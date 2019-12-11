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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {

    Route::post('login', 'Api\AuthController@login');

    Route::post('register', 'Api\AuthController@register');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('getUser', 'Api\AuthController@getUser');
        Route::apiResource('tables', 'Api\TableController');
        Route::apiResource('foods', 'Api\FoodController');
        Route::apiResource('categories', 'Api\FoodCategoryController');
    });
});
