<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home/{language}', 'HomeController@index')->name('home');
Route::get('client','ClientController@show')->name('search.client');
Route::post('client','ClientController@store')->name('store.client');
Route::get('countries','CountriesController@index')->name('show.countries');
Route::post('package','PackageController@store')->name('store.package');
Route::get('cities','PackageController@showCities')->name('showcities.package');
Route::get('show/translations','HomeController@getTranslations');
