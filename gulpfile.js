var elixir = require('laravel-elixir');

var jsPath = 'resources/assets/js/vendor/';
var lessPath = 'resources/assets/less/vendor/';
var cssAdminPath = 'resources/assets/css/admin/';

var adminltepath = 'vendor/almasaeed2010/adminlte/dist/';


elixir(function(mix) {

    mix.sass('admin.scss', cssAdminPath + 'admin.css', {
    	includePaths: [
        'node_modules'
        ]
    	});

    mix.browserify('admin.js');

    mix.copy(adminltepath + 'css/AdminLTE.css', cssAdminPath + 'AdminLTE.css')
       .copy(adminltepath + 'css/skins/skin-blue.css', cssAdminPath + 'skin-blue.css')
       .copy(adminltepath + 'js/app.min.js', 'public/js/admin-lte.js');

    // Combine admin styles
    mix.styles([
        cssAdminPath + 'admin.css',
        cssAdminPath + 'AdminLTE.css',
        cssAdminPath + 'skin-blue.css',
        ], 'public/css/admin.all.css');

    mix.version([
        'css/admin.all.css',
        'js/admin.js'
        ]);
});