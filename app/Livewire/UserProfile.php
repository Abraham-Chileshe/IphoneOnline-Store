<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use Livewire\Attributes\Url;
use App\Models\Wishlist;

class UserProfile extends Component
{
    #[Url(as: 'tab')]
    public $activeTab = 'personal-info';

    public $name, $email, $phone, $address, $city, $postal_code;

    protected $listeners = [
        'cart-updated' => '$refresh',
        'order-placed' => '$refresh',
        'item-removed' => '$refresh',
        'wishlist-updated' => '$refresh'
    ];


    public function mount()
    {
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
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|regex:/^[0-9+\-\s()]+$/|min:10|max:20',
            'address' => 'required|string|min:5|max:500',
            'city' => 'required|string|min:2|max:100',
            'postal_code' => 'required|string|min:3|max:20',
        ], [
            'phone.regex' => 'Phone number format is invalid.',
            'phone.required' => 'Phone number is required for order delivery.',
            'address.required' => 'Address is required for order delivery.',
        ]);

        try {
            // Sanitize inputs before updating
            $user->update([
                'name' => strip_tags(trim($this->name)),
                'email' => filter_var(trim($this->email), FILTER_SANITIZE_EMAIL),
                'phone' => preg_replace('/[^0-9+\-\s()]/', '', $this->phone),
                'address' => strip_tags(trim($this->address)),
                'city' => strip_tags(trim($this->city)),
                'postal_code' => strip_tags(trim($this->postal_code)),
            ]);

            session()->flash('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Profile update failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to update profile. Please try again.');
        }
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
            ->whereHas('product')
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

