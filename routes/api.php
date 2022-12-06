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

Route::middleware('auth:api')->get(
    '/user',
    function (Request $request) {
        return $request->user();
    }
);
Route::group(
    [],
    function () {
        Route::get('/products', 'ProductController@getProducts');
        Route::get('/products/apply/{id}', 'ProductController@applyQuantity');
        Route::get('/purchases', 'PurchaseController@getPurchases');
        Route::get('/applications', 'ApplicationController@getApplications');
    }
);