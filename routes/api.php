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
    Route::post('psld', 'zReadingController@psld');

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

    Route::get('january', 'DashboardController@index');
    // Route::post('psld', 'PosController@create');
    Route::get('date/{date}', 'xReadingController@date');

    //List users
    Route::get('users', 'UserAccountController@index');
    //List single users
    Route::get('user/{id}', 'UserAccountController@show');
    //Create new users
    Route::post('user', 'UserAccountController@create');
    //Update users
    Route::put('user/{id}', 'UserAccountController@update');
    //Delete users
    Route::put('user/delete/{id}', 'UserAccountController@delete');
    // END users

    //List categories
    Route::get('categories', 'CategoriesController@index');
    //List single category
    Route::get('category/{id}', 'CategoriesController@show');
    //Create new category
    Route::post('category', 'CategoriesController@create');
    //Update category
    Route::put('category/{id}', 'CategoriesController@update');
    //Delete category
    Route::put('category/delete/{id}', 'CategoriesController@delete');
    // END categories

    Route::get('products', 'ProductsController@index');
    Route::post('products', 'ProductsController@create');
    Route::put('products/{id}', 'ProductsController@update');
    Route::put('product/delete/{id}', 'ProductsController@delete');

});
Route::get('print/betweenname/{from}/{to}/{user_id}', 'zReadingController@PrintBetweenName');
Route::get('print/betweendate/{from}/{to}/', 'zReadingController@PrintBetweenDate');
Route::get('print/date/{date}/', 'xReadingController@PrintDate');