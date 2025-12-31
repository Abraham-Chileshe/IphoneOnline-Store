<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.orders.index', [
            'orders' => \App\Models\Order::with(['user', 'items'])->latest()->paginate(10)
        ])->layout('layouts.admin');
    }
}
