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

# Redirect routes for facebook login
Route::controller('/facebook', 'SocialController');


# Routes require user to be authenticated
Route::group(['middleware' => 'auth'], function () {

	Route::controller('/home', 'HomeController');

	Route::controller('/user', 'UserController');
	Route::controller('/project', 'ProjectController');
	Route::controller('/organization', 'OrganizationController');
	Route::controller('/subject', 'SubjectController');

	Route::group(['middleware' => 'admin'], function () {
		Route::controller('/admin', 'AdminController');
	});
});

# Register and login routes
Route::auth();

# GUEST PAGES
Route::controller('/', 'PagesController');
