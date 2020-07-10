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

// Logout Controller Routes
Route::GET('/logout', 'LogoutController@logout');
Route::GET('/is_user_active', 'LogoutController@is_user_active');

// User Controller Routes

// User Controller Auth Routes
Route::GET('check_email/{email}/{client_id}', 'UserController@check_email');
Route::GET('check_phone/{phono_no}/{client_id}', 'UserController@check_phone');
Route::get('/login', 'UserController@login');
Route::POST('/register-user', 'UserController@register_user');

// Home Controller Routes
Route::get('/', 'HomeController@index');
Route::get('/about_us', 'HomeController@about_us');
