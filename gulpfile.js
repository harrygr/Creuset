var elixir = require('laravel-elixir');

var jsPath = 'resources/assets/js/vendor/';
var lessPath = 'resources/assets/less/vendor/';



elixir(function(mix) {

    mix.sass('admin.scss', 'public/css/admin.css', {
    	includePaths: [
        'node_modules'
        ]
    	});

    mix.browserify('admin.js');
});