<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\ProductsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () {

    // ...

    // public routes
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login');
    Route::post('/register',[ApiAuthController::class, 'register'])->name('register');

    // ...

});

Route::middleware('auth:api')->group(function () {
    // our routes to be protected will go in here
    Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');
});

Route::get('/products', [ProductsController::class, 'index'])->name('products');

Route::get('/product/{id}', [ProductsController::class, 'show'])->name('product');

Route::post('/product', [ProductsController::class, 'store'])->name('product');

Route::put('/product', [ProductsController::class, 'store'])->name('product');

Route::delete('/product/{id}', [ProductsController::class, 'destroy'])->name('product');