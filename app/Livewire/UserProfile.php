<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Wishlist;

class UserProfile extends Component
{
    public $activeTab = 'personal-info';
    public $name, $email, $phone, $address, $city, $postal_code;

    protected $listeners = [
        'cart-updated' => '$refresh',
        'order-placed' => '$refresh',
        'item-removed' => '$refresh',
        'wishlist-updated' => '$refresh'
    ];


    public function mount($tab = null)
    {
        if ($tab) {
            $this->activeTab = $tab;
        }
        
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->city = $user->city;
        $this->postal_code = $user->postal_code;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
        ]);

        session()->flash('success', 'Profile updated successfully!');
    }

    public function render()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with(['items.product'])
            ->latest()
            ->get();

        $cart = Cart::where('user_id', $user->id)->first();
        $cartCount = $cart ? $cart->items()->count() : 0;

        $wishlistItems = Wishlist::where('user_id', $user->id)
            ->with('product')
            ->latest()
            ->get();

        return view('livewire.user-profile', [
            'user' => $user,
            'orders' => $orders,
            'cartCount' => $cartCount,
            'wishlistItems' => $wishlistItems,
        ]);
    }
}

