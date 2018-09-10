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

Route::post('accommodation_request', 'AccommodationRequestController@store')
    ->name('accommodation_request.store');

Route::post('client', 'ClientController@store')
    ->name('client.store');

Route::post('/save_file', 'ClientController@saveFile');

Route::post('transfer_request', 'TransferRequestController@store')
    ->name('transfer_request.store');

Route::post('package','PackageController@store')
    ->name('package.store');

Route::get('client/search', 'ClientController@search')
    ->name('client.search');

Route::get('countries','CountryController@index')
    ->name('country.index');
Route::post('countries','CountryController@searchCountry');


Route::get('client/mobile/is_unique','ClientController@isMobileUnique')
    ->name('client_mobile_is_unique.isMobileUnique');

Route::get('client/email/is_unique','ClientController@isEmailUnique')
    ->name('client_email_is_unique.isEmailُUnique');

Route::get('package/request','PackageController@index');
Route::get('cities/{country_id}','CountryController@cities');