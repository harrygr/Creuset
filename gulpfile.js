var elixir = require('laravel-elixir');

var jsPath = 'resources/assets/js/vendor/';
var lessPath = 'resources/assets/less/vendor/';

elixir(function(mix) {
  mix.copy(
  'bower_components/select2/dist/css/select2.css',
  lessPath + 'select2.less'
  ).copy(
'bower_components/bootstrap/less',
  lessPath + 'bootstrap'
  );

  mix.less('admin.less', 'public/css/admin.css');

  mix.browserify('app.js');
});