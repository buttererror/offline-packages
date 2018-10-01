<?php

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/change_locale','HomeController@changeLocal');
Route::get('/set_locale/{lang}','HomeController@setLocal');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('client','ClientController@show')->name('search.client');
Route::post('client','ClientController@store')->name('store.client');
Route::get('countries','CountriesController@index')->name('show.countries');
Route::post('package','PackageController@store')->name('store.package');
Route::get('cities','PackageController@showCities')->name('showcities.package');
Route::get('show/translations','HomeController@getTranslations');
Route::group([
    'prefix' => 'auth'
], function () {

    Route::post('login', 'AuthenticateController@login');
    Route::post('logout', 'AuthenticateController@logout')->name('logout');
    Route::post('refresh', 'AuthenticateController@refresh');
    Route::post('me', 'AuthenticateController@me');

});

