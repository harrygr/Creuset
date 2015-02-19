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

var jsPath = 'resources/assets/js/vendor/';
var lessPath = 'resources/assets/less/vendor/';

elixir(function(mix) {
    mix .copy('bower_components/moment/moment.js', jsPath + 'moment.js')
        .copy(
            'bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js',
            jsPath + 'bootstrap-datetimepicker.js'
    )
        .copy(
        'bower_components/eonasdan-bootstrap-datetimepicker/src/less/bootstrap-datetimepicker.less',
        lessPath + 'bootstrap-datetimepicker.less'
    )
        .copy(
        'bower_components/select2/dist/js/select2.js',
        jsPath + 'select2.js'
    )
        .copy(
        'bower_components/select2/dist/css/select2.css',
        lessPath + 'select2.less'
    );

    mix .less('admin.less')
        .scripts([
            'js/vendor/moment.js',
            'js/vendor/*',
            'js/post.js',
            'js/admin.js'
        ], 'resources/assets/', 'public/js/admin.js');
});