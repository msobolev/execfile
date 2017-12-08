<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('homepage','mainController@main');


Route::post('search','mainController@results');

Route::get('login','mainController@login');

Route::get('logout','mainController@logout');

Route::get('get_cities_data','mainController@get_cities');

Route::get('get_searchnow_data','mainController@get_searchnow');

Route::get('get_all_company_data','mainController@get_companynameurl');

Route::get('updateCount','mainController@updateCount');


Route::get('requestdemop','mainController@requestdemop');
Route::post('requestdemo','mainController@requestdemo');




Route::get('accounts','mainController@accounts');
Route::post('accounts','mainController@accounts');

// route for settings pages and making saved list default on undefault
Route::get('settings/{lid?}/{action?}','mainController@settings');

// route for setting saved list name in settings page
Route::post('settings','mainController@settings');


Route::get('alerts','mainController@alerts');
Route::post('alerts','mainController@alerts');

Route::get('alerts/{lid?}/{action?}','mainController@alerts');

Route::get('getuser','mainController@getuserlink');
//Route::post('getuser','mainController@getuserlink');

//Route::get('makedefault/{default_list_id}/action','mainController@settings');
//Route::get('unmakedefault/{undefault_list_id}/action','mainController@settings');

//Route::get('search/{type}/{industries?}/{from_date?}/{to_date?}/{revenue?}/{employee_size?}/{city?}/{state?}/{zip?}/{searchnow?}/{rem?}/{p?}/logout','mainController@logout');
//Route::get('search/{type}/{industries}/{from_date}/{to_date}/{revenue}/{employee_size}/{city}/{state}/{zip}/{searchnow}/{rem}/logout','mainController@logout');
//Route::get('search/{type}/{industries}/{from_date}/{to_date}/{revenue}/{employee_size}/{city}/{state}/{zip}/{searchnow}/logout','mainController@logout');


Route::get('search/{type?}/{industries?}/{from_date?}/{to_date?}/{revenue?}/{employee_size?}/{city?}/{state?}/{zip?}/{searchnow?}/{companyval?}/{rem?}/{org?}/{p?}','mainController@results')->name('execf_search');


