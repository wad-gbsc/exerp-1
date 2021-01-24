<?php

use Illuminate\Http\Request;

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

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::get('select', 'zReadingController@Select');
    

});

 
    Route::middleware('auth:api')->group(function () {
    
    Route::get('poentry', 'RequestOrderEntryController@index');
    Route::post('poentry', 'RequestOrderEntryController@create');
    Route::get('getpoitems/{id}', 'RequestOrderEntryController@getReqeustitems');
    Route::put('poentry/{id}', 'RequestOrderEntryController@update');
    Route::put('poentry/delete/{id}', 'RequestOrderEntryController@delete');
    Route::get('betweendate/{from}/{to}', 'zReadingController@Between');
    Route::get('betweenname/{from}/{to}/{id}', 'zReadingController@BetweenName');
    Route::get('index', 'zReadingController@index');
    //List goodsreceipt
    Route::get('goodsreceipts', 'GoodsReceiptController@index');
    //Create new goodsreceipt
    Route::post('goodsreceipt', 'GoodsReceiptController@create');
    // // END goodsreceipt
    Route::get('getpoitems/{id}', 'GoodsReceiptController@getPoItems');
    // Route::get('getitems/{barcode}', 'GoodsReceiptController@getItems');
    Route::get('getRequest', 'RequestOrderEntryController@getRequest');

    //List pos
    Route::get('pos', 'PosController@index');
    //Create new pos
    Route::post('pos', 'PosController@create');
    //List single pos
    Route::get('pos/{id}', 'PosController@show');
    //Delete pos
    Route::put('pos/delete/{id}', 'PosController@delete');
    Route::get('getBarcode/{id}', 'PosController@getBarcode');

});
Route::get('print/betweenname/{from}/{to}/{user_id}', 'zReadingController@PrintBetweenName');
Route::get('print/betweendate/{from}/{to}/', 'zReadingController@PrintBetweenDate');