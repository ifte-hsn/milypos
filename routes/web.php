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

    /**
     * Users Routes
     */
    Route::prefix('users')->group(function () {
        Route::get('/', 'UsersController@index')->name('users.index');
        Route::post('/','UsersController@store')->name('users.store');
        Route::post('bulkSave', 'UsersController@postBulkSave')->name('users.bulkSave');
        Route::post('bulkedit', 'UsersController@postBulkEdit')->name('users.bulkedit'); // need to check if we really need this
        Route::get('create', 'UsersController@create')->name('users.create');
        Route::get('export', 'UsersController@exportAsCsv')->name('users.csv.export');
        Route::get('getUsersList', 'UsersController@getUserList')->name('users.list');
        Route::get('{id}/restore', 'UsersController@getRestore')->name('users.restore');
        Route::delete('{id}', 'UsersController@destroy')->name('users.destroy');
        Route::match(['put', 'patch'], '{id}','UsersController@update')->name('users.update');
        Route::get('{id}/edit','UsersController@edit')->name('users.edit');
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', 'AclController@roleIndex')->name('roles.index');
        Route::get('getRoleList', 'AclController@getRoleList')->name('roles.list');
        Route::get('create', 'AclController@create')->name('roles.create');
        Route::get('{id}/restore', 'AclController@getRoleRestore')->name('roles.restore');
        Route::delete('{id}', 'AclController@destroyRole')->name('roles.destroy');
        Route::match(['put', 'patch'], '{id}', 'AclController@update')->name('roles.update');
        Route::get('{id}/edit', 'AclController@getRoleEdit')->name('roles.edit');
    });

    /**
     * Categories Routes
     */

    Route::prefix('categories')->group(function () {
        Route::get('/', 'CategoriesController@index')->name('category.index');
        Route::post('/', 'CategoriesController@store')->name('category.store');
        Route::post('bulkSave', 'CategoriesController@postBulkSave')->name('category.bulkSave');
        Route::post('bulkedit', 'CategoriesController@postBulkEdit')->name('category.bulkedit'); // need to check if we really need this
        Route::get('create', 'CategoriesController@create')->name('category.create');
        Route::get('export', 'CategoriesController@exportAsCsv')->name('category.csv.export');
        Route::get('getCategoriesList', 'CategoriesController@getCategoriesList')->name('categories.list');
        Route::get('{id}/restore', 'CategoriesController@restore')->name('category.restore');
        Route::delete('{id}', 'CategoriesController@destroy')->name('category.destroy');
        Route::match(['put', 'patch'], '{id}', 'CategoriesController@update')->name('category.update');
        Route::get('{id}/edit', 'CategoriesController@edit')->name('category.edit');
        Route::get('{id}', 'CategoriesController@show')->name('category.show');
    });

    /**
     * Settings Routes
     */
    Route::group(['prefix'=>'settings'], function () {
        Route::get('/', 'SettingsController@index')->name('settings.index');
        Route::get('brand_settings', 'SettingsController@getBranding')->name('settings.branding');
        Route::post('brand_settings', 'SettingsController@postBranding')->name('settings.branding');
        Route::get('localization', 'SettingsController@getLocalization')->name('settings.localization');
        Route::post('localization', 'SettingsController@postLocalization')->name('settings.localization');
    });

});
Auth::routes();