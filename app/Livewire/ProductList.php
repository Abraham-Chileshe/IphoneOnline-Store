<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

use Livewire\Attributes\Url;

class ProductList extends Component
{
    #[Url]
    public $search = '';

    public function render()
    {
        try {
            $query = Product::where('is_active', true)
                ->where('stock', '>', 0);

            if (!empty($this->search)) {
                $searchTerm = '%' . $this->search . '%';
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm)
                      ->orWhere('brand', 'like', $searchTerm)
                      ->orWhere('description', 'like', $searchTerm);
                });
            }

            $products = $query->orderBy('created_at', 'desc')->get();

            return view('livewire.product-list', [
                'products' => $products
            ]);
        } catch (\Exception $e) {
            \Log::error('Product list rendering failed: ' . $e->getMessage());
            return view('livewire.product-list', [
                'products' => collect()
            ]);
        }
    }
}

