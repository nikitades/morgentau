var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    /*
        Admin styles & scripts:
     */

    mix.sass('admin.scss', 'resources/assets/css/admin.css');

    mix.styles([
        'libs/bootstrap.min.css',
        'libs/bootstrap-theme.min.css',
        'libs/select2.min.css',
        'admin.css'
    ], 'public/css/admin.css', 'resources/assets/css');

    mix.scripts([
        'libs/jquery.min.js',
        'libs/bootstrap.min.js',
        'libs/select2.full.min.js',
        'admin.js'
    ], 'public/js/admin.js', 'resources/assets/js');

    /*
        Global app styles & scripts:
     */

    mix.sass('app.scss', 'resources/assets/css/app.css');
    mix.sass('homePage.scss', 'public/css/homePage.css');
    mix.sass('regularPage.scss', 'public/css/regularPage.css');
    mix.sass('faq.scss', 'public/css/faq.css');
    mix.sass('contacts.scss', 'public/css/contacts.css');
    mix.sass('newsItem.scss', 'public/css/newsItem.css');
    mix.sass('newsList.scss', 'public/css/newsList.css');
    mix.sass('login.scss', 'public/css/login.css');
    mix.sass('admin-pages-list.scss', 'public/css/admin-pages-list.css');
    mix.sass('services.scss', 'public/css/services.css');

    mix.styles([
        'libs/bootstrap.min.css',
        'libs/bootstrap-theme.min.css',
        'libs/jquery-ui.structure.min.css',
        'libs/jquery-ui.min.css',
        'libs/jquery-ui.theme.min.css',
        'app.css'
    ], 'public/css/app.css', 'resources/assets/css');

    mix.scripts([
        'libs/jquery.min.js',
        'libs/jquery-ui.min.js',
        'libs/bootstrap.min.js',
        'app.js'
    ], 'public/js/app.js', 'resources/assets/js');

    /*
     *  Version all the files:
     */

    mix.version([
        'public/css/admin.css',
        'public/js/admin.js',
        'public/css/app.css',
        'public/css/homePage.css',
        'public/css/regularPage.css',
        'public/css/faq.css',
        'public/css/contacts.css',
        'public/css/newsItem.css',
        'public/css/newsList.css',
        'public/css/login.css',
        'public/css/admin-pages-list.css',
        'public/css/services.css',
        'public/js/app.js'
    ]);

});
