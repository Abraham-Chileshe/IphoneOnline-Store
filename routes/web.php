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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', App\Livewire\Admin\Dashboard::class)->name('dashboard');
    
    // Products
    Route::get('/products', App\Livewire\Admin\Products\Index::class)->name('products.index');
    Route::get('/products/create', App\Livewire\Admin\Products\Create::class)->name('products.create');
    Route::get('/products/{id}/edit', App\Livewire\Admin\Products\Edit::class)->name('products.edit');

    // Orders
    Route::get('/orders', App\Livewire\Admin\Orders\Index::class)->name('orders.index');
    Route::get('/orders/{id}', App\Livewire\Admin\Orders\Detail::class)->name('orders.detail');

    // Customers
    Route::get('/customers', App\Livewire\Admin\Customers\Index::class)->name('customers.index');
});

// Auth routes will be added here after installing Laravel Breeze
// require __DIR__.'/auth.php';
