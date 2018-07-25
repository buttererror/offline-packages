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

Route::post('transfer_request', 'TransferRequestController@store')
    ->name('transfer_request.store');

Route::get('client/search', 'ClientController@search')
    ->name('client.search');