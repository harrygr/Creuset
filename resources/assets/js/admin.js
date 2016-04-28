// Browserify Entry Point
window.$ = window.jQuery = require('jquery');

global.Vue = require('vue');
global.Dropzone = require('dropzone');

global.AdminLTEOptions = {
  animationSpeed: 100,
  };

var bootstrap = require('bootstrap');

require('vue-resource');

Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').prop('content');

//var postContent = require('./vue-components/post-content.js');
//var postMeta = require('./vue-components/post-meta.js');

String.prototype.toProperCase = function () {
    return this.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
};


// Larail allows sending POST/PUT/DELETE requests using an a tag
var larail = require('./plugins/larail.js');

Vue.config.debug = true;
global.vm = new Vue({
	el: '#admin',

	components: {
		'cr-markarea':  require('./components/cr-markarea.vue'),
		'cr-title-slugger': require('./components/cr-title-slugger.vue'),
		'cr-category-chooser': require('./components/cr-category-chooser.vue'),
		'cr-imageable-gallery': require('./components/cr-imageable-gallery.vue'),
		'cr-image-chooser': require('./components/cr-image-chooser.vue'),
        'cr-attribute-form': require('./components/cr-attribute-form.vue'),
	}
})

// Activate select2 for multi-select
var select2 = require('select2');

jQuery(function(){
	$('.select2').select2({
        tags: true
    });
});
