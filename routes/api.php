<?php

use Illuminate\Http\Request;
use App\Http\Resources\Api\PaymentTypeResource;
use App\Http\Resources\Api\DeliveryPriceResource;
use App\DeliveryPrice;
use App\PaymentType;

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

//Route::get('users', 'Api\UserController@show');

//Route::post('login', 'Api\UserController@login');
//R


Route::group(['prefix' => 'guest'], function(){

    Route::post('users', 'Api\UserController@store');

    Route::post('users/login', 'Api\UserController@login');

    Route::get('categories/{_category_id}/subcategories', 'Api\SubCategoryController@index');
    Route::get('categories/{_category_id}/subcategories/{_subcategory_id}', 'Api\SubCategoryController@show');

    Route::get('categories', 'Api\CategoryController@index');
    Route::get('categories/{_id}', 'Api\CategoryController@show');

    Route::get('brands', 'Api\BrandController@index');
    Route::get('brands/{_id}', 'Api\BrandController@show');

    Route::get('products', 'Api\ProductController@index');
    Route::get('products/{_id}', 'Api\ProductController@show');


    Route::get('payment_types', function() {
        return buildApiResponse([
            'payment_types' => PaymentTypeResource::collection(PaymentType::active()->get())
        ]);
    });


    Route::get('delivery_prices', function() {
        return buildApiResponse([
            'delivery_prices' => DeliveryPriceResource::collection(DeliveryPrice::active()->where('published', 1)->orderBy('name')->get())
        ]);
    });

    Route::get('orders', 'Api\OrderController@show');
    Route::get('orders/{_id}', 'Api\OrderController@show');

    Route::post('orders/{_id}/close', 'Api\OrderController@close');

    Route::post('orders/{_order_hash}/products', 'Api\OrderController@storeDetail');
    Route::put('orders/{_order_hash}/products/{_product_detail_id}', 'Api\OrderController@updateDetail');
    Route::delete('orders/{_order_hash}/products/{_product_detail_id}', 'Api\OrderController@deleteDetail');
});

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('users', 'Api\UserController@index');

    Route::get('categories/{_category_id}/subcategories', 'Api\SubCategoryController@index');
    Route::get('categories/{_category_id}/subcategories/{_subcategory_id}', 'Api\SubCategoryController@show');
    Route::post('categories/{_category_id}/subcategories', 'Api\SubCategoryController@store');
    Route::put('categories/{_category_id}/subcategories/{_subcategory_id}', 'Api\SubCategoryController@update');
    Route::delete('categories/{_category_id}/subcategories/{_subcategory_id}', 'Api\SubCategoryController@delete');


    Route::get('categories', 'Api\CategoryController@index');
    Route::get('categories/{_id}', 'Api\CategoryController@show');
    Route::post('categories', 'Api\CategoryController@store');
    Route::put('categories/{_id}', 'Api\CategoryController@update');
    Route::delete('categories/{_id}', 'Api\CategoryController@delete');


    Route::get('brands', 'Api\BrandController@index');
    Route::get('brands/{_id}', 'Api\BrandController@show');
    Route::post('brands', 'Api\BrandController@store');
    Route::put('brands/{_id}', 'Api\BrandController@update');
    Route::delete('brands/{_id}', 'Api\BrandController@delete');


    Route::get('products', 'Api\ProductController@index');
    Route::get('products/{_id}', 'Api\ProductController@show');
    Route::post('products', 'Api\ProductController@store');
    Route::put('products/{_id}', 'Api\ProductController@update');
    Route::delete('products/{_id}', 'Api\ProductController@delete');

    Route::get('orders/{_id}', 'Api\OrderController@show');
    Route::post('orders', 'Api\OrderController@store');
    Route::put('orders/{_id}', 'Api\OrderController@update');
    Route::delete('orders/{_id}', 'Api\OrderController@delete');

});
