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
    })->name('home');


    Route::get('test', function (){ return '';})->name('users.bulkDelete');
    Route::resource('users', 'UsersController');

    Route::prefix('users')->group(function () {

        Route::post(
            'bulkedit',
            [
                'as'   => 'users.bulkedit',
                'uses' => 'UsersController@postBulkEdit',
            ]
        );

        Route::post('bulkSave',
            [
                'as' => 'users.bulkSave',
                'uses' => 'UsersController@postBulkSave'
            ]
        );

        Route::get(
            'export',
            [
                'as'=> 'users.export',
                'uses' => 'UsersController@getExportUserCsv'
            ]
        );

        Route::get(
            '{id}/restore',
            [
                'as'=> 'users.restore',
                'uses' => 'UsersController@getRestore'
            ]
        );
    });




    /**
     * Settings routes
     */
    Route::group(['prefix'=>'settings'], function () {
        Route::get('/', [ 'as'=> 'settings.index', 'uses' => 'SettingsController@index']);
        Route::get('brand_settings', [ 'as'=> 'settings.general.index', 'uses' => 'SettingsController@getBranding']);
    });

});
Auth::routes();