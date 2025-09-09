<?php

use App\Livewire\Cart;
use App\Models\Product;
use App\Livewire\ProductCatalog;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    $products = Product::take(6)->get(); // Fetch 6 products for homepage sections
    return view('pages.homepage', compact('products'));
})->name('home');
Route::get('/products', ProductCatalog::class)->name('product-catalog');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product');
Route::get('/cart', Cart::class)->name('cart');
Route::view('/checkout', 'pages.checkout')->name('checkout');
Route::view('/order-confirmed', 'pages.order-confirmed')->name('order-confirmed');
Route::view('/page', 'pages.page')->name('page');
