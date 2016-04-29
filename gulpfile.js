var elixir = require('laravel-elixir');

require('laravel-elixir-vueify');

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
    mix.browserify('main.js');


    mix.copy(adminltepath + 'js/app.min.js', 'public/js/admin-lte.js');

    // Combine admin styles
    mix.styles([
        cssAdminPath + 'admin.css',
        '../../../' + adminltepath + 'css/AdminLTE.css',
        '../../../' + adminltepath + 'css/skins/skin-blue.css',
        ], 'public/css/admin.css');

    mix.version([
        'css/admin.css', 'js/admin.js'
        ]);
});
