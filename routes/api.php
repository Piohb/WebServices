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

/*=== SHOP ROUTES ===*/
Route::get('/shops', 'ShopController@index');
Route::get('/shops/{id}', 'ShopController@show');
Route::post('/shops', 'ShopController@store');
Route::patch('/shops/{id}', 'ShopController@update');
Route::delete('/shops/{id}', 'ShopController@destroy');

/*=== PRODUCT ROUTES ===*/
//Route::get('/products', 'ProductController@index');
Route::get('/products/{id}', 'ProductController@show');
Route::post('/products', 'ProductController@store');
Route::patch('/products/{id}', 'ProductController@update');
Route::delete('/products/{id}', 'ProductController@destroy');

/*=== STOCK ROUTES ===*/
//Route::get('/stocks', 'StockController@index');
Route::get('/stocks/{id}', 'StockController@show');

/*=== CATEGORY ROUTES ===*/
//Route::get('/categories', 'ProductController@index');
Route::post('/categories', 'ProductController@store');
Route::patch('/categories/{id}', 'ProductController@update');
Route::delete('/categories/{id}', 'ProductController@destroy');