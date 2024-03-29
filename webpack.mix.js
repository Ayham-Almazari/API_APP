const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/auth/LoginAdmin.js', 'public/js')
    .js('resources/js/global.js', 'public/js')
    .js('resources/js/shared pages.js', 'public/js')
    .js('resources/js/HomeAdmin.js', 'public/js')
    .js('resources/js/components/nav-bar.js', 'public/js')
    .js('resources/js/components/aside-nav-bar.js', 'public/js')
    .js('resources/js/pages/under_verification_factories.js', 'public/js')
    .js('resources/js/pages/under_verification_deleted_factories.js', 'public/js')
    .js('resources/js/pages/under_verification_owner.js', 'public/js')
    .js('resources/js/pages/users.js', 'public/js')
    .js('resources/js/pages/manage_factories.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass("resources/sass/admin-login.scss",'public/css')
    .sass("resources/sass/under_verification_factories.scss",'public/css')
    .sass("resources/sass/under_verification_deleted_factories.scss",'public/css')
    .sass("resources/sass/users.scss",'public/css')
    .sass("resources/sass/home.scss",'public/css')
    .sass("resources/sass/manage_factories.scss",'public/css')
    .sass("resources/sass/under_verification_owners.scss",'public/css');

mix.browserSync({
    proxy: 'localhost:8000',
    browser:'chrome',
});
/*.postCss('resources/css/app.css', 'public/css', [
      //
  ])*/
