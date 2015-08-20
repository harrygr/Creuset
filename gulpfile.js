var elixir = require('laravel-elixir');

var jsPath = 'resources/assets/js/vendor/';
var lessPath = 'resources/assets/less/vendor/';

elixir(function(mix) {
    mix .copy(
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

    mix .less('admin.less', 'public/css/admin.css');

    mix.browserify('app.js');
});