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
                $product = $item->product;
                if ($item->quantity >= $product->stock) {
                    session()->flash('error', 'Cannot add more. Only ' . $product->stock . ' items in stock.');
                    return;
                }
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
        
        if (!$user->address || !$user->city || !$user->postal_code || !$user->phone) {
            session()->flash('error', 'Please complete your profile before placing an order.');
            return redirect()->route('profile.index');
        }
        
        $cart = Cart::where('user_id', $user->id)->first();
        
        if (!$cart || $cart->items()->count() === 0) {
            session()->flash('error', 'Your cart is empty!');
            return;
        }

        $items = $cart->items()->with('product')->get();
        
        // Validate stock availability
        foreach ($items as $item) {
            if ($item->product->stock < $item->quantity) {
                session()->flash('error', "Insufficient stock for {$item->product->name}. Only {$item->product->stock} available.");
                return;
            }
        }
        
        $totalAmount = $items->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        try {
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
                    
                    // Decrement stock
                    $item->product->decrement('stock', $item->quantity);
                }

                $cart->items()->delete();
            });

            session()->flash('success', 'Order placed successfully! Order will be processed soon.');
            $this->dispatch('order-placed');
        } catch (\Exception $e) {
            \Log::error('Order placement failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to place order. Please try again.');
        }
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
        $cartItems = $cart ? $cart->items()->whereHas('product')->with('product')->get() : collect();

        
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('livewire.cart-summary', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }
}
