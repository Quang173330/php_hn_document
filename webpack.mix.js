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
mix.styles('resources/css/buy-coin.css', 'public/css/buy-coin.css')
mix.styles('resources/css/chat.css', 'public/css/chat.css')
mix.js('resources/js/upload.js', 'public/js/upload.js')
mix.js('resources/js/delete_category.js', 'public/js/delete_category.js')
mix.js('resources/js/add_member.js', 'public/js/add_member.js')
mix.js('resources/js/validate_login.js', 'public/js/validate_login.js')
mix.js('resources/js/member_ban_upgrade.js', 'public/js/member_ban_upgrade.js')
mix.js('resources/js/chat.js', 'public/js/chat.js')