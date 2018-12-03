<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


/**
 * This service provider handles sharing the milyPosSettings variable,
 * and sets some common upload path and image urls
 *
 * @package App\Providers
 */
class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Share common settings variable with all views
        view()->composer('*', function ($view) {
            $view->with('milyPosSettings', \App\Setting::getSettings());
        });

        /**
         * Set some common variable so that they are globally available.
         * The paths should always be public (versus private uploads)
         */
        // Users paths and urls
        \App::singleton('users_upload_path', function () {
            return public_path('upload/models');
        });

        \App::singleton('users_upload_url', function () {
            return url('/') . '/uploads/users/';
        });

        // Company paths and URLs
        \App::singleton('companies_upload_path', function () {
            return public_path('/uploads/companies/');
        });

        \App::singleton('companies_upload_url', function () {
            return url('/') . '/uploads/companies/';
        });

        // Set the monetary locale to the configured locale to make helper::parseFloat work.
        setlocale(LC_MONETARY, config('app.locale'));
        setlocale(LC_NUMERIC, config('app.locale'));


    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
