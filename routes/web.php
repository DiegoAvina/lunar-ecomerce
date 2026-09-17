<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SearchSuggestionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;



/*
|--------------------------------------------------------------------------
| TIENDA
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');


Route::get('/productos', [CatalogController::class, 'index'])
    ->name('catalog.index');


Route::get('/productos/{product}', ProductController::class)
    ->name('catalog.show');


/*
|--------------------------------------------------------------------------
| CARRITO
|--------------------------------------------------------------------------
*/

Route::get('/carrito', [CartController::class, 'index'])
    ->name('cart.index');


Route::get('/carrito/data', [CartController::class, 'data'])
    ->name('cart.data');


Route::post('/carrito/items', [CartController::class, 'store'])
    ->name('cart.items.store');


Route::patch('/carrito/items/{line}', [CartController::class, 'update'])
    ->name('cart.items.update');


Route::delete('/carrito/items/{line}', [CartController::class, 'destroy'])
    ->name('cart.items.destroy');


Route::delete('/carrito', [CartController::class, 'clear'])
    ->name('cart.clear');


/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
|
| El checkout requiere que el cliente haya iniciado sesión.
|
*/




/*
|--------------------------------------------------------------------------
| ENVÍO
|--------------------------------------------------------------------------
*/

Route::post(
    '/shipping/postal-code',
    [ShippingController::class, 'update']
)->name('shipping.postal-code');


Route::delete(
    '/shipping/postal-code',
    [ShippingController::class, 'destroy']
)->name('shipping.postal-code.destroy');


/*
|--------------------------------------------------------------------------
| BÚSQUEDA
|--------------------------------------------------------------------------
*/

Route::get(
    '/api/search/suggestions',
    SearchSuggestionController::class
)->name('search.suggestions');


/*
|--------------------------------------------------------------------------
| PERFIL DEL CLIENTE
|--------------------------------------------------------------------------
|
| Estas rutas requieren autenticación.
|
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');


    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN BREEZE
|--------------------------------------------------------------------------
|
| /login
| /register
| /logout
| recuperación de contraseña
| verificación de correo
|
*/
Route::middleware('auth')->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])
        ->name('checkout.address.store');

});

require __DIR__.'/auth.php';