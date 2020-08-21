<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['API']], function () {
    //routes on which you want the middleware
    Route::GET('/owner/get-my-properties', 'Api\OwnerController@get_my_properties');
    Route::GET('/get_property/{id}', 'Api\PropertyController@get_property');

    Route::GET('/get-property/1', 'Api\PropertyController@get_property1');
    Route::GET('/get-property/2', 'Api\PropertyController@get_property2');
    Route::GET('/get-property/3', 'Api\PropertyController@get_property3');
    Route::GET('/get-property/4', 'Api\PropertyController@get_property4');

    Route::POST('/add-property/1', 'Api\PropertyController@add_property1');
    Route::POST('/add-property/2', 'Api\PropertyController@add_property2');
    Route::POST('/add-property/3', 'Api\PropertyController@add_property3');
    Route::POST('/add-property/4', 'Api\PropertyController@add_property4');

    Route::GET('/disable_property/{id}', 'Api\PropertyController@disable_property');

    Route::POST('/property/upload-image', 'Api\PropertyController@upload_image')->name('Api\image_upload');
    Route::GET('/delete-property', 'Api\PropertyController@delete_property')->name('Api\delete_property');
    Route::GET('/delete-property_image/{id}', 'Api\PropertyController@delete_property_image');
    Route::POST('/cover_photo_change', 'Api\PropertyController@cover_photo_change');

    Route::GET('/properties/{location}', 'Api\PropertyController@search_property');

    Route::POST('/save-amenities', 'Api\PropertyController@save_amenities')->name('Api\save_amenities');
});
