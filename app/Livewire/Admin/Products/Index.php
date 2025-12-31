<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.products.index', [
            'products' => \App\Models\Product::latest()->paginate(10)
        ])->layout('layouts.admin');
    }
}
