<?php

use Lunar\Models\Product;
use Lunar\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;


Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/productos', [CatalogController::class, 'index'])
    ->name('catalog.index');

Route::get('/carrito', [CartController::class, 'index'])
    ->name('cart.index');

Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');


Route::get('/test-slide', function () {
    $slide = App\Models\HeroSlide::first();

    dd([
        'image_db' => $slide->image,
        'asset' => asset($slide->image),
    ]);
});
