<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AddressesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\NotificationsUserController;
use App\Http\Controllers\LikeProductsController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/users/{user_id}', [UserController::class, 'index'])->name('user');
Route::middleware('cors', 'json.response', 'auth:api')->get('/user/{id}', [UserController:: class, 'show'])->name('user');
Route::middleware('cors', 'json.response', 'auth:api')->put('/user', [UserController:: class, 'update'])->name('user');

Route::group(['middleware' => ['cors', 'json.response']], function () {

    // ...

    // public routes
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login');
    Route::post('/register',[ApiAuthController::class, 'register'])->name('register');

    // ...

});

Route::post('route',[Controller:: class, 'method'])->middleware('api.admin');

Route::middleware('auth:api')->group(function () {
    // our routes to be protected will go in here
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout.api');
    Route::get('/articles', [ArticleController::class, 'index'])->middleware('api.admin')->name('articles');
});

Route::get('/products/{user_id}/{status?}', [ProductsController::class, 'index'])->name('products');
Route::get('/product/{id}', [ProductsController::class, 'show'])->name('product');
Route::post('/product', [ProductsController::class, 'store'])->name('product');
Route::put('/product', [ProductsController::class, 'update'])->name('product');
Route::patch('/product', [ProductsController::class, 'archive'])->name('product');
Route::delete('/product/{id}', [ProductsController::class, 'destroy'])->name('product');
Route::get('/product/search/{name}', [ProductsController::class, 'search'])->name('product');
Route::get('/products', [ProductsController::class, 'all'])->name('products');

Route::post('/upload', [ProductsController::class, 'upload'])->name('upload');

Route::get('/addresses/{user_id}/{status?}', [AddressesController::class, 'index'])->name('addresses');
Route::get('/address/{id}', [AddressesController::class, 'show'])->name('address');
Route::post('/address', [AddressesController::class, 'store'])->name('address');
Route::put('/address', [AddressesController::class, 'update'])->name('address');
Route::patch('/address', [AddressesController::class, 'archive'])->name('address');
Route::delete('/address/{id}', [AddressesController::class, 'destroy'])->name('address');
Route::get('/address/search/{name}', [AddressesController::class, 'search'])->name('address');

Route::get('/orders/{user_id}/{status?}', [OrdersController::class, 'index'])->name('orders');
Route::get('/order/{id}', [OrdersController::class, 'show'])->name('order');
Route::post('/order', [OrdersController::class, 'store'])->name('order');
Route::put('/order', [OrdersController::class, 'store'])->name('order');
Route::patch('/order', [OrdersController::class, 'archive'])->name('order');
Route::delete('/order/{id}', [OrdersController::class, 'destroy'])->name('order');
Route::get('/order/search/{order_number}/{seller_id}', [OrdersController::class, 'search'])->name('order');
Route::patch('/order/update_status', [OrdersController::class, 'updateStatus'])->name('order');

Route::get('/notifications_user/{status?}', [NotificationsUserController::class, 'index'])->name('notifications_user');
Route::get('/notification_user/{id}', [NotificationsUserController::class, 'show'])->name('notification_user');
Route::post('/notification_user', [NotificationsUserController::class, 'store'])->name('notification_user');
Route::put('/notification_user', [NotificationsUserController::class, 'store'])->name('notification_user');
Route::delete('/notification_user/{id}', [NotificationsUserController::class, 'destroy'])->name('notification_user');
Route::get('/notification_user/search/{title}', [NotificationsUserController::class, 'search'])->name('notification_user');

Route::get('/like_products/{product_id}/{user_id?}', [LikeProductsController::class, 'all'])->name('like_products');
Route::post('/like_products', [LikeProductsController::class, 'store'])->name('like_products');
Route::patch('/like_products', [LikeProductsController::class, 'archive'])->name('like_products');

Route::get('/dashboards/{user_id}', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/{id}', [DashboardController::class, 'show'])->name('dashboard');
Route::post('/dashboard', [DashboardController::class, 'store'])->name('dashboard');
