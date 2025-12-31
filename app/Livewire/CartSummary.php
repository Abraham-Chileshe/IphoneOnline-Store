<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CartSummary extends Component
{
    public function removeItem($itemId)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if ($cart) {
            $cart->items()->where('id', $itemId)->delete();
            session()->flash('success', 'Item removed from cart!');
            $this->dispatch('item-removed');
        }
    }

    public function incrementQuantity($itemId)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if ($cart) {
            $item = $cart->items()->where('id', $itemId)->first();
            if ($item) {
                $item->increment('quantity');
                $this->dispatch('cart-updated');
            }
        }
    }

    public function decrementQuantity($itemId)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if ($cart) {
            $item = $cart->items()->where('id', $itemId)->first();
            if ($item && $item->quantity > 1) {
                $item->decrement('quantity');
                $this->dispatch('cart-updated');
            }
        }
    }

    public function placeOrder()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        
        if (!$cart || $cart->items()->count() === 0) {
            session()->flash('error', 'Your cart is empty!');
            return;
        }

        $items = $cart->items()->with('product')->get();
        $totalAmount = $items->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        \DB::transaction(function() use ($user, $cart, $items, $totalAmount) {
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'shipping_address' => $user->address,
                'city' => $user->city,
                'postal_code' => $user->postal_code,
                'phone' => $user->phone,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            $cart->items()->delete();
        });

        session()->flash('success', 'Order placed successfully!');
        $this->dispatch('order-placed'); 
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user) {
            return view('livewire.cart-summary', [
                'cartItems' => collect(),
                'total' => 0
            ]);
        }

        $cart = Cart::where('user_id', $user->id)->first();
        $cartItems = $cart ? $cart->items()->with('product')->get() : collect();
        
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('livewire.cart-summary', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }
}
