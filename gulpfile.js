var elixir = require('laravel-elixir');

var jsPath = 'resources/assets/js/vendor/';
var lessPath = 'resources/assets/less/vendor/';

elixir(function(mix) {
    mix 
   //  .copy('bower_components/moment/moment.js', jsPath + 'moment.js')
   //     .copy(
   //         'bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js',
   //         jsPath + 'bootstrap-datetimepicker.js'
   // )
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

    mix .less('admin.less', 'public/css/admin.css');

    mix .scripts([
            'vendor/*',
            'post.js',
            'admin.js'
        ], 'public/js/admin.js');

    mix.browserify('app.js');
});