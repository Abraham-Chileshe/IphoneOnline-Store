<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product routes
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart routes with rate limiting
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->middleware('throttle:30,1')->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->middleware('throttle:60,1')->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->middleware('throttle:60,1')->name('cart.remove');

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// Auth routes with rate limiting
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});


// Language and Currency switching (POST to prevent CSRF)
Route::post('/lang/{locale}', function (Illuminate\Http\Request $request, $locale) {
    if (in_array($locale, ['en', 'ru'])) {
        session()->put('locale', $locale);
        // Sync currency with locale
        session()->put('currency', $locale == 'ru' ? 'RUB' : 'USD');
    }
    return redirect()->back();
})->name('lang.switch');

Route::post('/currency/{currency}', function (Illuminate\Http\Request $request, $currency) {
    if (in_array($currency, ['USD', 'RUB', 'AED'])) {
        session()->put('currency', $currency);
    }
    return redirect()->back();
})->name('currency.switch');

Route::post('/city/{city}', function (Illuminate\Http\Request $request, $city) {
    if ($city === 'all' || \App\Models\City::where('slug', $city)->exists()) {
        session()->put('selected_city', $city === 'all' ? '' : $city);
    }
    return redirect()->back();
})->name('city.switch');


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

    // Cities
    Route::get('/cities', App\Livewire\Admin\Cities\Index::class)->name('cities.index');
    Route::get('/cities/create', App\Livewire\Admin\Cities\Create::class)->name('cities.create');
    Route::get('/cities/{id}/edit', App\Livewire\Admin\Cities\Edit::class)->name('cities.edit');

    // Settings
    Route::get('/settings', App\Livewire\Admin\Settings::class)->name('settings');

    // Customers
    Route::get('/customers', App\Livewire\Admin\Customers\Index::class)->name('customers.index');
});

// Auth routes will be added here after installing Laravel Breeze
// require __DIR__.'/auth.php';
