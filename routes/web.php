<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WishListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AppController::class, 'index'])->name('app.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [ShopController::class, 'productDetails'])->name('shop.product.details');
Route::get('/cart-wishlist-count',[ShopController::class,'getCartAndWishlistCount'])->name('shop.cart.wishlist.count');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/store', [CartController::class, 'addToCart'])->name('cart.store');

Route::put('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::delete('/cart/remove', [CartController::class, 'removeItem'])->name('cart.remove');

Route::post('/wishlist/store', [WishlistController::class, 'store'])->name('wishlist.store');


Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/my-account', [UserController::class, 'index'])->name('user.index');
});

Route::middleware(['auth', 'auth.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});


Route::get('/products', [ShopController::class, 'index'])->name('products.index');

Route::get('/products/create', [ShopController::class, 'create'])->name('products.create');
Route::post('/products', [ShopController::class, 'store'])->name('products.store');

Route::get('/products/{product}', [ShopController::class, 'show'])->name('products.show');

Route::get('/products/{product}/edit', [ShopController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ShopController::class, 'update'])->name('products.update');

Route::delete('/products/{product}', [ShopController::class, 'destroy'])->name('products.destroy');

Route::get('/admin/product', function () {
    return view ('admin.nav_admin');
});