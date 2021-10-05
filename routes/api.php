<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AddressesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\NotificationsUserController;
use App\Http\Controllers\Controller;
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

Route::middleware('cors', 'json.response', 'auth:api')->get('/user/{id}', function (Request $request, $id) {
    return $request->user()::findOrFail($id);
});

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

Route::get('/products/{status?}', [ProductsController::class, 'index'])->name('products');
Route::get('/product/{id}', [ProductsController::class, 'show'])->name('product');
Route::post('/product', [ProductsController::class, 'store'])->name('product');
Route::put('/product', [ProductsController::class, 'store'])->name('product');
Route::delete('/product/{id}', [ProductsController::class, 'destroy'])->name('product');
Route::get('/product/search/{name}', [ProductsController::class, 'search'])->name('product');

Route::get('/addresses/{status?}', [AddressesController::class, 'index'])->name('addresses');
Route::get('/address/{id}', [AddressesController::class, 'show'])->name('address');
Route::post('/address', [AddressesController::class, 'store'])->name('address');
Route::put('/address', [AddressesController::class, 'store'])->name('address');
Route::delete('/address/{id}', [AddressesController::class, 'destroy'])->name('address');
Route::get('/address/search/{name}', [AddressesController::class, 'search'])->name('address');

Route::get('/orders/{status?}', [OrdersController::class, 'index'])->name('orders');
Route::get('/order/{id}', [OrdersController::class, 'show'])->name('order');
Route::post('/order', [OrdersController::class, 'store'])->name('order');
Route::put('/order', [OrdersController::class, 'store'])->name('order');
Route::delete('/order/{id}', [OrdersController::class, 'destroy'])->name('order');
Route::get('/order/search/{order_number}', [OrdersController::class, 'search'])->name('order');

Route::get('/notifications_user/{status?}', [NotificationsUserController::class, 'index'])->name('notifications_user');
Route::get('/notification_user/{id}', [NotificationsUserController::class, 'show'])->name('notification_user');
Route::post('/notification_user', [NotificationsUserController::class, 'store'])->name('notification_user');
Route::put('/notification_user', [NotificationsUserController::class, 'store'])->name('notification_user');
Route::delete('/notification_user/{id}', [NotificationsUserController::class, 'destroy'])->name('notification_user');
Route::get('/notification_user/search/{title}', [NotificationsUserController::class, 'search'])->name('notification_user');