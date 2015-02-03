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
    mix .less('admin.less')
        .scripts(['js/larail.js', 'js/jquery.pagedown-bootstrap.combined.js', 'js/admin.js'], 'resources/assets/', 'public/js/admin.js');

});