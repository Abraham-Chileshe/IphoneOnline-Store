<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product routes
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Temporary login route (until Breeze is installed)
Route::view('/login', 'auth.login')->name('login');
Route::post('/logout', function() { 
    auth()->logout(); 
    return redirect('/'); 
})->name('logout');

// Auth routes will be added here after installing Laravel Breeze
// require __DIR__.'/auth.php';
