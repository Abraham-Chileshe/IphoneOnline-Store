<?php

namespace App\Livewire\Admin\Customers;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.customers.index', [
            'customers' => \App\Models\User::latest()->paginate(10)
        ])->layout('layouts.admin');
    }
}
