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
        $this->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        
        try {
            $oldStatus = $this->order->status;
            
            // If cancelling, restore stock
            if ($this->status === 'cancelled' && $oldStatus !== 'cancelled') {
                foreach ($this->order->items as $item) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            
            $this->order->update(['status' => $this->status]);
            $this->order->refresh();
            
            session()->flash('success', __('Order status updated successfully.'));
        } catch (\Exception $e) {
            \Log::error('Order status update failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to update order status.');
        }
    }

    public function render()
    {
        return view('livewire.admin.orders.detail')->layout('layouts.admin');
    }
}
