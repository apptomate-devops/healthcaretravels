<?php
/*
  |--------------------------------------------------------------------------
  | Admin panel Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register Admin panel routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
use Illuminate\Http\Request;

Route::group(['prefix' => 'admin'], function () {
    Route::GET('/', 'Admin\HomeController@index')->name('admin.login');
    Route::POST('/', 'Admin\HomeController@make_login')->name('admin.make_login');

    Route::group(['middleware' => 'AdminCheck'], function () {
        Route::GET('/logout', 'Admin\HomeController@logout');
        Route::GET('/index', 'Admin\HomeController@dashboard')->name('admin.home');
        Route::GET('/settings', 'Admin\SettingsController@index');
        Route::POST('/settings', 'Admin\SettingsController@update');
        //
        Route::GET('/admin-users', 'Admin\UsersController@index');
        Route::GET('/admin-user/add', 'Admin\UsersController@add');

        // property
        Route::GET('/property', 'Admin\PropertyController@index');
        Route::GET('/property-status-update', 'Admin\PropertyController@status_update');

        //
        Route::GET('/cancellation-policy', 'Admin\CancellationController@index');
        Route::POST('/cancellation-policy', 'Admin\CancellationController@update');

        Route::GET('/travellers', 'Admin\TravellerController@index');
        Route::GET('/owner', 'Admin\OwnerController@index');
        Route::GET('/user-status-update', 'Admin\OwnerController@status_update');
        Route::GET('/single_user', 'Admin\OwnerController@single_user');

        Route::GET('/commision', 'Admin\CommisionController@index');
        Route::POST('/commision', 'Admin\CommisionController@update');

        Route::GET('/reservations', 'Admin\ReservationController@index');
        Route::GET('/booking-status-update', 'Admin\ReservationController@booking_status_update');
        Route::GET('/send-invoice/{booking_id}/{property_id}', 'Admin\ReservationController@send_invoice');

        Route::GET('/completedpayment', 'Admin\PaymentController@completed_payment');
        Route::GET('/cancelledpayment', 'Admin\PaymentController@cancelledpayment');

        Route::GET('/manage-coupon', 'Admin\CouponController@index');

        Route::POST('/create-coupon', 'Admin\CouponController@store_coupon');

        Route::GET('/send-email', 'Admin\CouponController@send_email_get');
        Route::POST('/send-email', 'Admin\CouponController@send_email_post');

        Route::GET('/become_scout', 'Admin\HomeController@become_scout');
        Route::GET('/request_roommate', 'Admin\HomeController@request_roommate');

        Route::GET('/host-payouts', 'Admin\HomeController@host_payout');
        Route::GET('/agency', 'Admin\TravellerController@agency');
        Route::GET('/traveller-ratings', 'Admin\HomeController@traveller_ratings');
        Route::GET('/host-ratings', 'Admin\HomeController@host_ratings');
        Route::GET('/reservations-details/{id}', 'Admin\HomeController@reservations_details');
        Route::GET('/manage_cities/', 'Admin\HomeController@manage_cities');
        Route::GET('/delete-city/{id}', 'Admin\HomeController@delete_city');

        Route::GET('/block_property/', 'Admin\HomeController@block_property');
        Route::GET('/get_blocked_dates/{id}', 'Admin\HomeController@get_blocked_dates');
        Route::POST('/add_property_block', 'Admin\HomeController@add_property_block');

        Route::POST('/add_cities_process', 'Admin\HomeController@add_city_process');
        Route::POST('/add_agency_process', 'Admin\HomeController@add_agency_process');
        Route::GET('/add-agency', 'Admin\HomeController@add_agency');
        Route::GET('/delete-agency/{id}', 'Admin\HomeController@delete_agency');

        Route::POST('/add_property_type_process', 'Admin\HomeController@add_property_type_process');
        Route::GET('/add-property_type', 'Admin\HomeController@add_property_type');
        Route::GET('/delete-property_type/{id}', 'Admin\HomeController@delete_property_type');

        Route::POST('/add_room_type_process', 'Admin\HomeController@add_room_type_process');
        Route::GET('/add-room_type', 'Admin\HomeController@add_room_type');
        Route::GET('/delete-room_type/{id}', 'Admin\HomeController@delete_room_type');

        Route::POST('/add_occupation_process', 'Admin\HomeController@add_occupation_process');
        Route::GET('/add-occupation', 'Admin\HomeController@add_occupation');
        Route::GET('/delete-occupation/{id}', 'Admin\HomeController@delete_occupation');

        Route::GET('/property_details/{id}', 'Admin\HomeController@property_details');

        //email Config
        Route::GET('/register_mail', 'Admin\HomeController@register_mail');
        Route::GET('/verification_mail', 'Admin\HomeController@verification_mail');
        Route::GET('/booking_confirm_mail', 'Admin\HomeController@booking_confirm_mail');
        Route::GET('/booking_cancel_mail', 'Admin\HomeController@booking_cancel_mail');
        Route::GET('/password_reset', 'Admin\HomeController@password_reset');

        Route::POST('/save_config', 'Admin\HomeController@save_config');

        // Route::POST('/save_verification_mail','Admin\HomeController@save_verification_mail');
        // Route::POST('/save_booking_confirm_mail','Admin\HomeController@save_booking_confirm_mail');
        // Route::POST('/save_booking_cancel_mail','Admin\HomeController@save_booking_cancel_mail');
        //verify process
        Route::GET('/verify_property/{id}', 'Admin\HomeController@verify_property');
        Route::GET('/verify_profile/{id}', 'Admin\HomeController@verify_profile');
        Route::GET('/verify_document/{id}/{status}', 'Admin\HomeController@verify_document');
        Route::GET('/verify_mobile/{id}/{status}', 'Admin\HomeController@verify_mobile');
        // faq
        Route::POST('/add_faq_process', 'Admin\HomeController@add_faq_process');
        Route::GET('/faq', 'Admin\HomeController@add_faq');
        Route::GET('/delete-faq/{id}', 'Admin\HomeController@delete_faq');

        Route::GET('/reports', 'Admin\HomeController@reports');

        Route::GET('/{route}', 'Admin\HomeController@load_route');
    });
});