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
     * Clients Routes
     */
    Route::prefix('clients')->group(function () {
        Route::get('/', 'ClientsController@index')->name('clients.index');
        Route::post('/','ClientsController@store')->name('clients.store');
        Route::post('bulkSave', 'ClientsController@postBulkSave')->name('clients.bulkSave');
        Route::post('bulkedit', 'ClientsController@postBulkEdit')->name('clients.bulkedit'); // need to check if we really need this
        Route::get('create', 'ClientsController@create')->name('clients.create');
        Route::get('export', 'ClientsController@exportAsCsv')->name('clients.csv.export');
        Route::get('getUsersList', 'ClientsController@getClientList')->name('clients.list');
        Route::get('{id}/restore', 'ClientsController@getRestore')->name('clients.restore');
        Route::delete('{id}', 'ClientsController@destroy')->name('clients.destroy');
        Route::match(['put', 'patch'], '{id}','ClientsController@update')->name('clients.update');
        Route::get('{id}/edit','ClientsController@edit')->name('clients.edit');
    });

    /**
     * Products
     */

    Route::prefix('products')->group(function () {
        Route::get('/', 'ProductsController@index')->name('products.index');
        Route::post('/','ProductsController@store')->name('products.store');
        Route::post('bulkSave', 'ProductsController@postBulkSave')->name('products.bulkSave');
        Route::post('bulkedit', 'ProductsController@postBulkEdit')->name('products.bulkedit'); // need to check if we really need this
        Route::get('create', 'ProductsController@create')->name('products.create');
        Route::get('export', 'ProductsController@exportAsCsv')->name('products.csv.export');
        Route::get('getProductsList', 'ProductsController@getProductList')->name('products.list');
        Route::get('{id}/restore', 'ProductsController@getRestore')->name('products.restore');
        Route::delete('{id}', 'ProductsController@destroy')->name('products.destroy');
        Route::match(['put', 'patch'], '{id}','ProductsController@update')->name('products.update');
        Route::get('{id}/edit','ProductsController@edit')->name('products.edit');
        Route::get('category/{id}','ProductsController@getProductsByCategory')->name('products.productByCategory');
        Route::get('{id}', 'ProductsController@show')->name('products.show');
    });

    /**
     * Roles Routes
     */
    Route::prefix('roles')->group(function () {
        Route::get('/', 'AclController@index')->name('roles.index');
        Route::post('/','AclController@store')->name('roles.store');
        Route::get('getRoleList', 'AclController@getRoleList')->name('roles.list');
        Route::get('create', 'AclController@create')->name('roles.create');
        Route::get('{id}/restore', 'AclController@getRoleRestore')->name('roles.restore');
        Route::delete('{id}', 'AclController@destroy')->name('roles.destroy');
        Route::match(['put', 'patch'], '{id}', 'AclController@update')->name('roles.update');
        Route::get('{id}/edit', 'AclController@edit')->name('roles.edit');
        Route::get('{id}', 'AclController@show')->name('roles.show');
    });

    Route::group(['prefix' => 'sales'], function () {
        Route::get('/', 'SalesController@manage')->name('sales.manage');
        Route::get('getSalesList', 'SalesController@getSalesList')->name('sales.list');
        Route::get('create', 'SalesController@create')->name('sales.create');
        Route::get('export', 'SalesController@exportAsCsv')->name('sales.csv.export');
        Route::post('bulkedit', 'SalesController@postBulkEdit')->name('sales.bulkedit');
        Route::match(['put', 'patch'], '{id}', 'SalesController@update')->name('sales.update');
        Route::post('product', 'SalesController@getProductById')->name('sales.product_by_id');
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

});
Auth::routes();