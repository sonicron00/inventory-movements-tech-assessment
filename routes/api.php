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
        Route::get('products/monthly/{months}/{id}', 'ProductController@getProductValueByMonth');
        Route::get('/products/preapply/{id}/{qty}', 'ProductController@calculateQuantity');
        Route::put('/products/edit/{descr}/{id}', 'ProductController@createOrUpdate');
        Route::get('/questions', 'QuestionController@getQuestions');
        Route::get('/purchases', 'TransactionController@getPurchases');
        Route::get('/applications', 'TransactionController@getApplications');
        Route::get('/transactions', 'TransactionController@getAllTransactions');
        Route::put('/products/apply/{id}/{qty}', 'TransactionController@applyQuantity');
        Route::put('/purchases/create/{id}/{qty}/{price}', 'TransactionController@createPurchase');
    }
);