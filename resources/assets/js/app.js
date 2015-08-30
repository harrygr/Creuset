// Browserify Entry Point

global.Vue = require('vue');
global.$ = require('jquery');
global.Dropzone = require('dropzone');

require('vue-resource');
//global.Vue.use(require('vue-resource'));


var postContent = require('./vue-components/post-content.js');
var postMeta = require('./vue-components/post-meta.js');

// Larail allows sending POST/PUT/DELETE requests using an a tag
var larail = require('./plugins/larail.js');


// Activate select2 for multi-select
var select2 = require('select2');



$(function(){
	$('.select2').select2({
        tags: true
    });
});


 
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#admin-content").toggleClass("toggled");
    $("#wrapper").toggleClass("toggled");
});
