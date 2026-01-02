<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class ProductReviews extends Component
{
    use WithPagination;
    
    public $productId;
    public $rating = 5;
    public $title = '';
    public $comment = '';
    public $showForm = false;
    
    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'title' => 'nullable|string|max:200',
        'comment' => 'required|string|min:10|max:1000',
    ];
    
    protected $messages = [
        'comment.min' => 'Review must be at least 10 characters.',
        'comment.max' => 'Review cannot exceed 1000 characters.',
    ];
    
    public function mount($productId)
    {
        $this->productId = $productId;
    }
    
    public function toggleForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $this->showForm = !$this->showForm;
    }
    
    public function submitReview()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $this->validate();
        
        $user = Auth::user();
        
        // Rate limiting: max 5 reviews per hour
        $recentReviewsCount = Review::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subHour())
            ->count();
            
        if ($recentReviewsCount >= 5) {
            session()->flash('error', 'You can only submit 5 reviews per hour. Please try again later.');
            return;
        }
        
        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', $user->id)
            ->where('product_id', $this->productId)
            ->first();
            
        if ($existingReview) {
            session()->flash('error', 'You have already reviewed this product.');
            return;
        }
        
        // Check if user purchased this product
        $hasPurchased = OrderItem::whereHas('order', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->whereIn('status', ['delivered', 'processing', 'shipped']);
        })->where('product_id', $this->productId)->exists();
        
        try {
            Review::create([
                'user_id' => $user->id,
                'product_id' => $this->productId,
                'rating' => $this->rating,
                'title' => $this->title,
                'comment' => $this->comment,
                'verified_purchase' => $hasPurchased,
            ]);
            
            session()->flash('success', 'Thank you for your review!');
            
            // Reset form
            $this->reset(['rating', 'title', 'comment', 'showForm']);
            $this->rating = 5;
            
        } catch (\Exception $e) {
            \Log::error('Review submission failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to submit review. Please try again.');
        }
    }
    
    public function render()
    {
        $product = Product::findOrFail($this->productId);
        
        $reviews = Review::where('product_id', $this->productId)
            ->with('user')
            ->latest()
            ->paginate(10);
            
        $averageRating = $product->reviews()->avg('rating') ?? 0;
        $totalReviews = $product->reviews()->count();
        
        // Rating distribution
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $product->reviews()->where('rating', $i)->count();
            $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
            $ratingDistribution[$i] = [
                'count' => $count,
                'percentage' => round($percentage, 1)
            ];
        }
        
        $userHasReviewed = Auth::check() 
            ? Review::where('user_id', Auth::id())
                ->where('product_id', $this->productId)
                ->exists()
            : false;
        
        return view('livewire.product-reviews', [
            'product' => $product,
            'reviews' => $reviews,
            'averageRating' => round($averageRating, 1),
            'totalReviews' => $totalReviews,
            'ratingDistribution' => $ratingDistribution,
            'userHasReviewed' => $userHasReviewed,
        ]);
    }
}
