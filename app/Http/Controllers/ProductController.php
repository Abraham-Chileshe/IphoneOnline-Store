<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        // Check if product is in cart
        $isInCart = false;
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $isInCart = $cart->items()->where('product_id', $id)->exists();
            }
        } else {
            $cart = Cart::where('session_id', session()->getId())->first();
            if ($cart) {
                $isInCart = $cart->items()->where('product_id', $id)->exists();
            }
        }
        
        return view('products.show', compact('product', 'isInCart'));
    }
}
