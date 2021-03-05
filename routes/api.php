<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;

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

Route::group([
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/shops', [ShopController::class, 'index']);

/*Route::group(['middleware' => 'jwt'], function () {
    Route::get('/shops', 'ShopController@index');
    Route::get('/shops/{id}', 'ShopController@show');
    Route::post('/shops', 'ShopController@store');
    Route::patch('/shops/{id}', 'ShopController@update');
    Route::delete('/shops/{id}', 'ShopController@destroy');

//Route::get('/products', 'ProductController@index');
    Route::get('/products/{id}', 'ProductController@show');
    Route::post('/products', 'ProductController@store');
    Route::patch('/products/{id}', 'ProductController@update');
    Route::delete('/products/{id}', 'ProductController@destroy');

//Route::get('/stocks', 'StockController@index');
    Route::get('/stocks/{id}', 'StockController@show');

//Route::get('/categories', 'ProductController@index');
    Route::post('api/categories', 'CategoryController@store');
    Route::patch('/categories/{id}', 'CategoryController@update');
    Route::delete('/categories/{id}', 'CategoryController@destroy');
});*/


