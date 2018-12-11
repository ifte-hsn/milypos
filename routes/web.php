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




Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });

    // Users Resource
    Route::resource('users', 'UsersController');
    Route::get('export', ['as' => 'users.export', 'uses' => 'UsersController@getExportUserCsv']);

    /**
     * Settings routes
     */
    Route::group(['prefix'=>'settings'], function () {
        Route::get('/', [ 'as'=> 'settings.index', 'uses' => 'SettingsController@index']);
        Route::get('brand_settings', [ 'as'=> 'settings.general.index', 'uses' => 'SettingsController@getBranding']);
    });

});
Auth::routes();