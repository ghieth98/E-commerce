<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SaveForLaterController;
use App\Http\Controllers\ShopController;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');

//Route::view('/cart', 'cart');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/cart/saveForLater/{product}', [CartController::class, 'saveForLater'])
    ->name('cart.saveForLater');

Route::post('/saveForLater/switchSaveForLater/{product}',
    [SaveForLaterController::class, 'switchToCart'])
    ->name('saveForLater.switchToCart');
Route::delete('/saveForLater/{product}', [SaveForLaterController::class, 'destroy'])
    ->name('saveForLater.destroy');

Route::get('empty', function (){
    Cart::instance('saveForLater')->destroy();
});

Route::view('/checkout', 'checkout');
Route::view('/thankyou', 'thankyou');
