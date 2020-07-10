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
Route::get('/cancellationpolicy', 'HomeController@cancellation_policy');
Route::get('/content', 'HomeController@content');
Route::get('/cookies-policy', 'HomeController@cookies_policy');
Route::get('/copyright-policy', 'HomeController@copyright_policy');
Route::get('/dear_host', 'HomeController@dear_host');
Route::get('/dear_travelers', 'HomeController@dear_travelers');
Route::get('/exortion-policy', 'HomeController@exortion_policy');
Route::get('/Extenuating-Circ-policy', 'HomeController@Extenuating_Circ_policy');
Route::get('/eye-catching-photo', 'HomeController@eye_catching_photo');
Route::get('/faq', 'HomeController@faq');
Route::get('/fees-explained', 'HomeController@fees_explained');
Route::get('/how_its_works', 'HomeController@how_its_works');
Route::get('/non-discrimination-policy', 'HomeController@non_discrimination_policy');
Route::get('/payment-terms', 'HomeController@payment_terms');
Route::get('/policies', 'HomeController@policies');
Route::get('/privacy-policy', 'HomeController@privacy_policy');
Route::get('/privacy-policy', 'HomeController@privacy_policy');
Route::get('/rv_professional', 'HomeController@rv_professional');
Route::get('/standards', 'HomeController@standards');
Route::get('/terms-of-use', 'HomeController@terms_of_use');
Route::get('/travellers-refund-policy', 'HomeController@travellers_refund_policy');
