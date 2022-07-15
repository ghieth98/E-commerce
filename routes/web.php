<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SaveForLaterController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UsersController;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
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

//ShopController
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/search', [ShopController::class, 'search'])->name('search');

//Cart Controller
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/cart/saveForLater/{product}', [CartController::class, 'saveForLater'])
    ->name('cart.saveForLater');

//Save for later Controller
Route::post('/saveForLater/switchSaveForLater/{product}',
    [SaveForLaterController::class, 'switchToCart'])
    ->name('saveForLater.switchToCart');
Route::delete('/saveForLater/{product}', [SaveForLaterController::class, 'destroy'])
    ->name('saveForLater.destroy');

//CouponsControllers
Route::post('/coupon', [CouponsController::class, 'store'])->name('coupon.store');
Route::delete('/coupon', [CouponsController::class, 'destroy'])->name('coupon.destroy');

//CheckoutController
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')
    ->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

//Route::get('empty', function (){
//    Cart::instance('saveForLater')->destroy();
//});


Route::get('/thankyou', [ConfirmationController::class, 'index'])->name('confirmation.index');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();
Route::middleware('auth')->group(function (){
    Route::get('/my-profile', [UsersController::class, 'edit'])->name('users.edit');
    Route::patch('/my-profile', [UsersController::class, 'update'])->name('users.update');

    Route::get('/my-orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
