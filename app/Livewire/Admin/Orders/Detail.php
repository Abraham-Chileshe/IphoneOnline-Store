<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;

class Detail extends Component
{
    public $order;
    public $status;

    public function mount($id)
    {
        $this->order = \App\Models\Order::with(['items.product', 'user'])->findOrFail($id);
        $this->status = $this->order->status;
    }

    public function updateStatus()
    {
        $this->order->update(['status' => $this->status]);
        session()->flash('message', 'Order status updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.orders.detail')->layout('layouts.admin');
    }
}
