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
mix.js([
    'resources/js/app.js',
    'resources/js/home.js',
], 'public/js')
    .styles([
        'resources/css/header.css',
        'resources/css/footer.css',
        'resources/css/home.css',
    ], 'public/css/style.css');
mix.styles('resources/css/authentication.css', 'public/css/authentication.css')
mix.styles('resources/css/user-profile.css', 'public/css/user-profile.css')
mix.styles('resources/css/list-docs.css', 'public/css/list-docs.css')
mix.styles('resources/css/upload.css', 'public/css/upload.css')
mix.js('resources/js/upload.js', 'public/js/upload.js')
mix.js('resources/js/documents.js', 'public/js/documents.js')