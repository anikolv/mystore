<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('register', 'UserController@register');
Route::get('login', 'UserController@login');
Route::post('registerUser', 'UserController@registerUser');
Route::post('loginUser', 'UserController@loginUser');


Route::group(array('before' => 'auth'), function() {
	
	Route::get('adminProducts', 'AdminController@adminProducts');
	Route::get('adminOrders', 'AdminController@adminOrders');
	Route::get('adminUsers', 'AdminController@adminUsers');
	Route::get('logout', 'UserController@logout');
	Route::get('admin/orders', 'CartController@orders');
	Route::get('admin/users', 'UserController@getUsers');
	Route::get('admin/products', 'ProductController@getProducts');
	Route::post('admin/addProduct', 'ProductController@addProduct');
	Route::post('admin/removeProduct', 'ProductController@removeProduct');
	Route::post('admin/addUser', 'UserController@addUser');
	
});