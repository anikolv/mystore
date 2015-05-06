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
Route::post('/notify', 'CartController@notify');
Route::post('/return', 'HomeController@index');
Route::get('/register', 'UserController@register');
Route::get('/login', 'UserController@login');
Route::post('registerUser', 'UserController@registerUser');
Route::post('loginUser', 'UserController@loginUser');
Route::get('store/getPhones', 'ProductController@getPhones');
Route::get('/store/tablets', 'ProductController@tablets');
Route::get('/store/getTablets', 'ProductController@getTablets');
Route::get('/store/notebooks', 'ProductController@notebooks');
Route::get('/store/getNotebooks', 'ProductController@getNotebooks');
Route::get('/store/tvs', 'ProductController@tvs');
Route::get('/store/getTvs', 'ProductController@getTvs');
Route::post('/store/addToCart/{id}', 'CartProductController@addToCart');
Route::get('/store/mycart', 'CartProductController@myCart');
Route::get('/store/getMyCart', 'CartProductController@getMyCart');
Route::post('/store/removeFromCart/{id}', 'CartProductController@removeFromCart');
Route::get('/store/choose_details/', 'HomeController@chooseDetails');
Route::get('/user/getDetails/', 'UserController@getDetails');
Route::get('/contact', 'HomeController@contact');
Route::post('/sendMessage', 'HomeController@sendMessage');
Route::get('/account', 'UserController@account');
Route::get('/getAccount', 'UserController@getAccount');
Route::post('/changeAccount', 'UserController@changeAccount');
Route::post('/search', 'ProductController@search');
Route::get('/getSearchResults', 'ProductController@getSearchResults');
Route::get('/flushSession/', 'HomeController@flushSession');
Route::get('/language/{lang}', 'HomeController@selectLang');
Route::get('/currency/{id}', 'HomeController@selectCurr');

Route::group(array('before' => 'auth'), function() {
	
	Route::get('adminProducts', 'AdminController@adminProducts');
	Route::get('adminOrders', 'AdminController@adminOrders');
	Route::get('adminUsers', 'AdminController@adminUsers');
	Route::get('/logout', 'UserController@logout');
	Route::get('admin/orders', 'CartController@orders');
	Route::get('admin/users', 'UserController@getUsers');
	Route::get('admin/products', 'ProductController@getProducts');
	Route::post('admin/addProduct', 'ProductController@addProduct');
	Route::post('admin/removeProduct', 'ProductController@removeProduct');
	Route::post('admin/addUser', 'UserController@addUser');
	Route::post('admin/removeUser', 'UserController@removeUser');
	Route::post('admin/getCartProducts', 'CartProductController@getCartProducts');
	
});