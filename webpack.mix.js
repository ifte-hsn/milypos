const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.scripts([
    'node_modules/jquery/dist/jquery.min.js',
    'resources/js/jquery-ui.min.js',
    'node_modules/bootstrap/dist/js/bootstrap.min.js',
    'resources/js/select2.full.min.js',
    'resources/js/ekko-lightbox.min.js',
    'resources/js/icheck.min.js',
    'node_modules/jquery-slimscroll/jquery.slimscroll.js',
    'resources/js/adminlte.js',
    'resources/js/script.js',
], 'public/js/all.js')
   .sass('resources/sass/app.scss', 'public/css/all.css');