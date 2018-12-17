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

    // Users route
    Route::prefix('users')->group(function () {
        Route::get('/', 'UsersController@index')->name('users.index');
        Route::post('/','UsersController@store')->name('users.store');
        Route::post('bulkSave', 'UsersController@postBulkSave')->name('users.bulkSave');
        Route::post('bulkedit', 'UsersController@postBulkEdit')->name('users.bulkedit');
        Route::get('create', 'UsersController@create')->name('users.create');
        Route::get('export', 'UsersController@getExportUserCsv')->name('users.export');
        Route::get('getUsersList', 'UsersController@getUserList')->name('users.list');
        Route::get('{id}/clone', 'UsersController@getClone')->name('users.clone');
        Route::post('{id}/clone', 'UsersController@store');
        Route::get('{id}/restore', 'UsersController@getRestore')->name('users.restore');
        Route::delete('{user}', 'UsersController@destroy')->name('users.destroy');
        Route::match(['put', 'patch'], '{user}','UsersController@update')->name('users.update');
        Route::get('{user}/edit','UsersController@edit')->name('users.edit');
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