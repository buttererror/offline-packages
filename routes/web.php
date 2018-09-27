<?php

Route::get('/', function () {
    return view('welcome');
});
Route::get('/change_locale',function (){
    if(app()->getLocale() == 'en'){
        app()->setLocale('ar');
        session()->put('current_locale','ar') ;
    }else{
        app()->setLocale('en');
        session()->put('current_locale','en');
    }
    if(! request()->ajax()){
        return redirect()->back();
    }
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('client','ClientController@show')->name('search.client');
Route::post('client','ClientController@store')->name('store.client');
Route::get('countries','CountriesController@index')->name('show.countries');
Route::post('package','PackageController@store')->name('store.package');
Route::get('cities','PackageController@showCities')->name('showcities.package');
Route::get('show/translations','HomeController@getTranslations');
