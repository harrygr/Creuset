// Browserify Entry Point
window.$ = window.jQuery = require('jquery');

global.Vue = require('vue');
global.Dropzone = require('dropzone');

var bootstrap = require('bootstrap');

require('vue-resource');

var postContent = require('./vue-components/post-content.js');
var postMeta = require('./vue-components/post-meta.js');

// Larail allows sending POST/PUT/DELETE requests using an a tag
var larail = require('./plugins/larail.js');


// Activate select2 for multi-select
var select2 = require('select2');

jQuery(function(){
	$('.select2').select2({
        tags: true
    });
});


 
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#admin-content").toggleClass("toggled");
    $("#wrapper").toggleClass("toggled");
});
