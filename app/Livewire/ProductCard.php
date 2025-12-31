<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ProductCard extends Component
{
    public $product;
    public $isAdded = false;
    public $isInWishlist = false;

    protected $listeners = [
        'item-removed' => 'checkIfAdded',
        'wishlist-updated' => 'checkWishlistStatus'
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->checkIfAdded();
        $this->checkWishlistStatus();
    }

    public function checkWishlistStatus()
    {
        $user = Auth::user();
        if ($user) {
            $this->isInWishlist = Wishlist::where('user_id', $user->id)
                ->where('product_id', $this->product->id)
                ->exists();
        } else {
            $this->isInWishlist = false;
        }
    }

    public function toggleWishlist()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $this->product->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $this->isInWishlist = false;
            session()->flash('info', 'Removed from wishlist');
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $this->product->id
            ]);
            $this->isInWishlist = true;
            session()->flash('success', 'Added to wishlist');
        }

        $this->dispatch('wishlist-updated');
    }


    public function checkIfAdded()
    {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        } else {
            $cart = Cart::where('session_id', session()->getId())->first();
        }

        if ($cart) {
            $this->isAdded = $cart->items()->where('product_id', $this->product->id)->exists();
        } else {
            $this->isAdded = false;
        }
    }

    public function addToCart()
    {
        // 1. Fresh database check to prevent hacking or race conditions
        $this->product->refresh(); // Get latest stock from DB
        
        $this->checkIfAdded(); // Re-verify if it's already in cart

        if ($this->product->stock <= 0) {
            session()->flash('error', 'Sorry, this product is now out of stock.');
            return;
        }

        if ($this->isAdded) {
            session()->flash('info', 'Product is already in your cart.');
            return;
        }

        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        } else {
            $cart = Cart::firstOrCreate(['session_id' => session()->getId()]);
        }

        $cart->items()->create([
            'product_id' => $this->product->id,
            'quantity' => 1
        ]);

        $this->isAdded = true;
        
        // Notify other components (like sidebar markers or cart summary)
        $this->dispatch('cart-updated');
        session()->flash('success', 'Product added to cart!');
    }

    public function render()
    {
        return view('livewire.product-card');
    }
}
