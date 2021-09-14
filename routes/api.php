<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', 'UserController@index');
Route::get('user/{id}', 'UserController@show');
Route::post('user', 'UserController@store');
Route::put('user', 'UserController@store');
Route::delete('user/{id}', 'UserController@destroy');

Route::get('products', 'ProductController@index');
Route::get('product/{id}', 'ProductController@show');
Route::post('product', 'ProductController@store');
Route::put('product', 'ProductController@store');
Route::delete('product/{id}', 'ProductController@destroy');
