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

