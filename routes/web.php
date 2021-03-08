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

Route::GET('/not_found', 'BaseController@general_error');
Route::get('/storage/{filePath}', 'BaseController@get_storage_file')->where(['filePath' => '.*']);

// Logout Controller Routes
Route::GET('/logout', 'LogoutController@logout');
Route::GET('/is_user_active', 'LogoutController@is_user_active');

// Public route for iCal
Route::GET('/ical/{id}', 'IcalController@ical');

// User Controller Routes
// User Controller Auth Routes
Route::GET('/check_email/{email}/{client_id}', 'UserController@check_email');
Route::GET('/check_phone/{phono_no}/{client_id}', 'UserController@check_phone');
Route::GET('/check_verified', 'UserController@check_verified');
Route::GET('/email-send', 'UserController@email_send');
Route::GET('/get_phone_number/{user_id}', 'UserController@get_phone_number');
Route::get('/login', 'UserController@login');
Route::POST('/login-user', 'UserController@login_user');
Route::GET('/otp-verify-register', 'UserController@view_otp_screen_register');
Route::GET('/otp-verify-login', 'UserController@view_otp_screen_login');
Route::POST('/verify_recaptcha', 'UserController@verify_recaptcha');
Route::GET('/add-another-agency/{agency_name}', 'UserController@add_another_agency');
Route::POST('/register-user', 'UserController@register_user');
Route::GET('/sent_otp/{phone_no}/{user_id}', 'UserController@sent_otp');
Route::POST('/verify_otp', 'UserController@verify_otp');
Route::POST('/verify_otp_login', 'UserController@verify_otp_login');
Route::GET('/verify/{id}/{token}', 'UserController@email_verify');
Route::get('/social/redirect/{provider}/{type}', 'UserController@handleProviderRedirect');
Route::get('/social/callback', 'UserController@handleProviderCallback');

// Home Controller Routes
Route::get('/', 'HomeController@index');
Route::get('/about_us', 'HomeController@about_us');
Route::get('/ambassador', 'HomeController@ambassador');
// Route::get('/scout', 'HomeController@scout');
// Route::post('/become-a-scout-save', 'HomeController@save_become_a_scout');
Route::get('/cancellationpolicy', 'HomeController@cancellation_policy');
Route::get('/contact', 'HomeController@contact');
Route::POST('/contact_mail', 'HomeController@contact_mail');
Route::get('/content-policy', 'HomeController@content');
Route::get('/cookie-policy', 'HomeController@cookie_policy');
Route::get('/copyright-policy', 'HomeController@copyright_policy');
Route::get('/host', 'HomeController@host');
Route::get('/travelers', 'HomeController@travelers');
Route::get('/extortion-policy', 'HomeController@extortion_policy');
Route::get('/extenuating-circ-policy', 'HomeController@extenuating_circ_policy');
Route::get('/eye-catching-photos', 'HomeController@eye_catching_photo');
Route::get('/faq', 'HomeController@faq');
Route::get('/fees', 'HomeController@fees_explained');
Route::GET('/get-user-notifications', 'HomeController@get_user_notifications');
Route::get('/how_it_works', 'HomeController@how_it_works');
Route::get('/non-discrimination-policy', 'HomeController@non_discrimination_policy');
Route::get('/partner', 'HomeController@partner');
Route::get('/events', 'HomeController@events');
Route::get('/payment-terms', 'HomeController@payment_terms');
Route::get('/policies', 'HomeController@policies');
Route::get('/privacy-policy', 'HomeController@privacy_policy');
Route::get('/privacy-policy', 'HomeController@privacy_policy');
Route::get('/request-roommate', 'HomeController@request_roommate');
Route::post('/request_roommate', 'HomeController@save_request_roommate');
Route::post('/request_roommate2', 'HomeController@save_request_roommate2');
Route::get('/rv_professional', 'HomeController@rv_professional');
//Route::get('/standards', 'HomeController@standards');
Route::get('/terms-of-use', 'HomeController@terms_of_use');
Route::get('/travelers-refund-policy', 'HomeController@travellers_refund_policy');

//  Reset password flow :: Home Controller
Route::POST('/new-password', 'HomeController@update_password');
Route::GET('/new-password/{token}', 'HomeController@new_password');
Route::get('/reset-password', 'HomeController@reset_password');
Route::POST('/reset-password', 'HomeController@reset_email');

// Property Controller
Route::get('/delete_property_image/{id}', 'PropertyController@delete_property_image');
Route::get('/update_cover_image/{id}/{property_id}', 'PropertyController@update_cover_image');
Route::match(['get', 'post'], '/properties', 'PropertyController@search_property');
Route::post('/search-property-filtering', 'PropertyController@search_property');
Route::GET('/get-property-price', 'PropertyController@get_price');
Route::GET('/property/{id}/{booking_id?}', 'PropertyController@single_property');
Route::GET('/add-calender/{property_id}', 'CalenderController@add_calender');
Route::GET('/update-calender/{id}', 'CalenderController@update_calender');
Route::GET('/delete-calender/{id}', 'CalenderController@delete_calender');
Route::GET('/block_booking', 'CalenderController@block_booking');
Route::GET('/delete_block_booking', 'CalenderController@delete_block_booking');
Route::GET('/list_pets/{lat}/{lng}/{id}', 'PropertyController@list_pets');
Route::GET('/list_health/{lat}/{lng}/{id}', 'PropertyController@list_health');

// Property related :: Maps Controller
Route::GET('/single-marker/{lat}/{lng}/{pets}', 'MapController@single_marker');
Route::get('/owner-profile/{id}', 'OwnerController@property_owner_profile');

// login to chat button
Route::POST('/create_chat/{id}', 'PropertyController@create_chat');

// Logged in routes
Route::middleware(['LoginCheck'])->group(function () {
    // All Users
    Route::GET('/profile', 'UserController@profile');
    Route::GET('/verify-account', 'UserController@verify_account');
    Route::POST('/account_delete_process', 'UserController@account_delete_process');
    Route::get('/delete_account', 'UserController@delete_account');
    Route::POST('/update-profile', 'UserController@update_profile');
    Route::POST('/update-profile-picture', 'UserController@update_profile_picture');
    Route::get('/delete-profile-picture', 'UserController@delete_profile_picture');
    Route::POST('/upload-document', 'UserController@upload_document');
    Route::GET('/change-password', 'UserController@change_password');
    Route::POST('/change-password', 'UserController@update_password');

    // Dwolla Payment Routes
    Route::post(
        '/dwolla/create_customer_and_funding_source_token_with_validations',
        'PaymentController@create_customer_and_funding_source_token_with_validations',
    );
    Route::post('/dwolla/get_funding_source_details', 'PaymentController@get_funding_source_details');
    Route::post('/dwolla/add_funding_source', 'PaymentController@add_funding_source');
    Route::post('/dwolla/delete_funding_source', 'PaymentController@delete_funding_source');

    // Verified users only
    Route::middleware(['VerifiedCheck'])->group(function () {
        // Chat
        Route::get('/delete_chat/{id}', 'PropertyController@delete_chat');

        // Traveller
        Route::get('/traveler/my-reservations', 'PropertyController@reservations');
        Route::get('/traveler/single-reservation/{id}', 'PropertyController@single_reservations');
        Route::GET('/traveler/inbox', 'PropertyController@inbox_traveller');
        Route::GET('/traveler/favorites', 'PropertyController@favorites');
        Route::get('/traveler/chat/{id}', 'PropertyController@traveller_fire_chat');
        Route::GET('/cancel-booking/{id}', 'PropertyController@cancel_booking');
        Route::GET('/delete-booking/{id}', 'PropertyController@delete_booking');

        // Property
        Route::post('/book-now', 'PropertyController@book_now');
        Route::GET('/booking_detail/{id}', 'PropertyController@booking_detail');
        Route::GET('/request_cancellation/{id}', 'PropertyController@request_cancellation');
        Route::get('/add_property_to_favourite/{id}', 'PropertyController@add_property_to_favourite');
        Route::POST('/save-guest-information', 'PropertyController@save_guest_information');
        Route::POST('/submit_cancellation_request', 'PropertyController@submit_cancellation_request');

        // Owner
        Route::get('/owner/inbox', 'PropertyController@inbox_owner');
        Route::get('/owner/favorites', 'PropertyController@favorites');
        // Route::GET('/owner/transaction-history', 'TransactionController@transaction_history');
        Route::GET('/owner/special_price', 'OwnerController@special_price');
        Route::GET('/owner/special_price_details', 'OwnerController@special_price_details');
        Route::get('/owner/my-properties', 'PropertyController@my_properties');
        Route::get('/owner/add-property', 'PropertyController@add_property');
        Route::POST('/owner/add-property', 'PropertyController@add_new_property');
        Route::GET('/owner/add-new-property/{stage}/{property_id}', 'PropertyController@property_next');
        Route::POST('/owner/add-new-property/2', 'PropertyController@property_next2');
        Route::POST('/owner/add-new-property/3', 'PropertyController@property_next3');
        Route::POST('/owner/add-new-property/4', 'PropertyController@property_next4');
        Route::POST('/owner/add-new-property/5', 'PropertyController@property_next5');
        Route::POST('/owner/add-new-property/6', 'PropertyController@property_next6');
        Route::POST('/owner/add-new-property/7', 'PropertyController@property_next7');
        Route::get('/owner/payment-method', 'OwnerController@payment_method_index');
        Route::GET('/owner/my-bookings', 'OwnerController@my_bookings');
        Route::GET('/owner/single-booking/{id}', 'PropertyController@single_booking');
        //        Route::get('/owner/reservations', 'PropertyController@reservations');
        //        Route::get('/owner/reservations/{id}', 'PropertyController@single_reservations');
        Route::POST('/owner/property/file-upload/{cover_id?}', 'PropertyController@property_image_upload');
        Route::POST('/owner-update-booking', 'PropertyController@owner_update_booking');
        Route::get('/owner/update-property/{id}', 'PropertyController@update_property');
        Route::GET('/owner/disable-property/{id}', 'PropertyController@disable_property');
        Route::GET('/owner/delete-property/{id}', 'PropertyController@delete_property');
        Route::GET('/payment-default/{id}', 'OwnerController@payment_default');
        Route::GET('/owner/calender', 'OwnerController@calender');
        Route::POST('/owner/upload-calender', 'OwnerController@upload_calender');
        Route::get('/owner/chat/{id}', 'PropertyController@owner_fire_chat');

        // Payment and Invoices
        Route::GET('/payment-options', 'PaymentController@get_payment_options');
        Route::GET('/invoice/{id}', 'PDF_Controller@invoice');

        // general routes

        Route::POST('/chat-with-traveler', 'PropertyController@chat_with_traveler');
    });
});

Route::post('/dwolla-webhooks', 'PaymentController@dwolla_webhook');
Route::post('/webhooks/dwolla', 'PaymentController@dwolla_webhook');
Route::post(
    '/twilio-webhooks/check-in-traveler-based-on-message',
    'PropertyController@check_in_traveler_based_on_message',
);

// TODO: remove when implemented
// Payment testing APIS
Route::get('/dwolla/create_customer/{id}', 'PaymentController@create_customer');
Route::get('/dwolla/create/{id}', 'PaymentController@create');
Route::get('/dwolla/get_funding_source_token/{id}', 'PaymentController@get_funding_source_token');
Route::post(
    '/dwolla/create_customer_and_funding_source_token',
    'PaymentController@create_customer_and_funding_source_token',
);

Route::get('/dwolla/create_funding_source/{id}', 'PaymentController@create_funding_source_token');
Route::get('/dwolla/test_transfer', 'PaymentController@transfer');
Route::get('/dwolla/get_funding_source/{id}', 'PaymentController@get_funding_source')->where(['id' => '.*']);
ROute::get('/queue-email/test', 'SendEmailController@createJobForEmail');

Route::fallback('BaseController@general_error');
