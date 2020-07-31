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
Route::GET('/check_email/{email}/{client_id}', 'UserController@check_email');
Route::GET('/check_phone/{phono_no}/{client_id}', 'UserController@check_phone');
Route::GET('/email-send', 'UserController@email_send');
Route::GET('/get_phone_number/{user_id}', 'UserController@get_phone_number');
Route::get('/login', 'UserController@login');
Route::POST('/login-user', 'UserController@login_user');
Route::GET('/otp-verify-register', 'UserController@view_otp_screen');
Route::POST('/verify_recaptcha', 'UserController@verify_recaptcha');
Route::GET('/add-another-agency/{agency_name}', 'UserController@add_another_agency');
Route::POST('/register-user', 'UserController@register_user');
Route::GET('/sent_otp/{phone_no}/{user_id}', 'UserController@sent_otp');
Route::POST('/verify_otp', 'UserController@verify_otp');
Route::GET('/verify/{id}/{token}', 'UserController@email_verify');

// Home Controller Routes
Route::get('/', 'HomeController@index');
Route::get('/about_us', 'HomeController@about_us');
Route::get('/become-a-ambassador', 'HomeController@become_a_ambassador');
Route::get('/become-a-scout', 'HomeController@become_a_scout');
Route::post('/become-a-scout-save', 'HomeController@save_become_a_scout');
Route::get('/cancellationpolicy', 'HomeController@cancellation_policy');
Route::get('/contact', 'HomeController@contact');
// TODO: confirm if only logged in user can use contact us form.
Route::POST('/contact_mail', 'HomeController@contact_mail');
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
Route::get('/partner', 'HomeController@partner');
Route::get('/payment-terms', 'HomeController@payment_terms');
Route::get('/policies', 'HomeController@policies');
Route::get('/privacy-policy', 'HomeController@privacy_policy');
Route::get('/privacy-policy', 'HomeController@privacy_policy');
Route::get('/request-roommate', 'HomeController@request_roommate');
Route::post('/request_roommate', 'HomeController@save_request_roommate');
Route::post('/request_roommate2', 'HomeController@save_request_roommate2');
Route::get('/rv_professional', 'HomeController@rv_professional');
Route::get('/short-term', 'HomeController@short_term');
Route::post('/short-term', 'HomeController@search_property');
Route::get('/standards', 'HomeController@standards');
Route::get('/terms-of-use', 'HomeController@terms_of_use');
Route::get('/travellers-refund-policy', 'HomeController@travellers_refund_policy');

//  Reset password flow :: Home Controller
Route::POST('/new-password', 'HomeController@update_password');
Route::GET('/new-password/{token}', 'HomeController@new_password');
Route::get('/reset-password', 'HomeController@reset_password');
Route::POST('/reset-password', 'HomeController@reset_email');

// Property routes :: Home Controller
Route::post('/search-property', 'HomeController@search_property');
Route::post('/search-property-filtering', 'HomeController@search_property');

// Owner controller routes
Route::get('/owner/profile', 'OwnerController@owner_profile');

// Account Verification routes
Route::POST('/upload-document', 'UserController@upload_document');

// Logged in routes
Route::middleware(['LoginCheck'])->group(function () {
    Route::GET('/traveler/profile', 'OwnerController@owner_profile');
    Route::GET('/traveler/favorites', 'PropertyController@favorites');
    Route::get('/owner/favorites', 'PropertyController@favorites');
    Route::GET('/cancel-booking/{id}', 'PropertyController@cancel_booking');
    Route::GET('/owner-update-booking', 'PropertyController@owner_update_booking');
    Route::GET('/verify-account', 'UserController@verify_account');
});
