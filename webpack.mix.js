const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([
    'node_modules/lightbox2/dist/css/lightbox.css',
    'node_modules/dropzone/dist/dropzone.css',
], 'public/css/libs.css');

// mix.scripts([
//     'node_modules/lightbox2/dist/js/lightbox.js'
// ], 'public/js/libs.js');

mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/', 'public/fonts/bootstrap');
mix.copy('node_modules/lightbox2/dist/images/', 'public/images');