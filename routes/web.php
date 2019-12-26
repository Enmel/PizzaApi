<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tables','Web\TableController');
Route::resource('foodcategories','Web\FoodCategoryController');
Route::resource('foods','Web\FoodController');
Route::get('/orders/{order}/paidout', 'Web\OrderController@paidout')->name('orders.paidout');
Route::get('/orders/{order}/status', 'Web\OrderController@status')->name('orders.status');
Route::resource('orders','Web\OrderController');
