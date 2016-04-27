<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


# Register and login routes
Route::auth();


# Landing page
Route::get('/', function () {
	return view('welcome');
});


# Redirect routes for facebook login
Route::controller('/facebook', 'SocialController');


# Routes require user to be authenticated
Route::group(['middleware' => 'auth'], function () {

	Route::controller('/home', 'HomeController');

	Route::controller('/admin', 'AdminController');

	Route::controller('/user', 'UserController');

	Route::get('images/profile/{userID}', 'ResourceController@picture');

});

# CATCH-ALL ROUTE
Route::group(['prefix' => ''], function () {
	Route::options('{path?}', 'Controller@actionOk')->where('path', '.+');
});

