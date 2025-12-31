<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class ProductList extends Component
{
    public $search = '';

    protected $listeners = ['search-updated' => 'updateSearch'];

    public function mount()
    {
        // Handle search query from URL redirection
        $this->search = request()->query('search', '');
    }

    public function updateSearch($query)
    {
        $this->search = $query;
    }

    public function render()
    {
        $query = Product::where('is_active', true);

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $products = $query->get();

        return view('livewire.product-list', [
            'products' => $products
        ]);
    }
}

