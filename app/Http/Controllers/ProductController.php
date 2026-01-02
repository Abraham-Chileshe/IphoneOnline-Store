<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show($identifier)
    {
        $product = Product::where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();
        // Check if product is in cart
        $isInCart = false;
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $isInCart = $cart->items()->where('product_id', $product->id)->exists();
            }
        } else {
            $cart = Cart::where('session_id', session()->getId())->first();
            if ($cart) {
                $isInCart = $cart->items()->where('product_id', $product->id)->exists();
            }
        }
        // Check if product is in wishlist
        $isInWishlist = false;
        if (Auth::check()) {
            $isInWishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();
        }
        
        return view('products.show', compact('product', 'isInCart', 'isInWishlist'));
    }
}
