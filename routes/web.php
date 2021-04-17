<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'WebController@index');
Route::get('/contact-us', 'WebController@contactUs');
Route::post('/products/check-product', 'ProductController@checkProduct');
Route::post('/read-notification', 'WebController@readNotification');

Route::resource('products', 'ProductController');
Route::post('signup', 'AuthController@signup');
Route::post('login', 'AuthController@login');

Route::resource('admin/orders', 'Admin\OrderController');
Route::post('admin/orders/delivery/{id}', 'Admin\OrderController@delivery');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('user', 'AuthController@user');
    Route::get('logout', 'AuthController@logout');
    Route::post('carts/checkout', 'CartController@checkout');
    Route::resource('carts', 'CartController');
    Route::resource('cart-items', 'CartItemController');
});
