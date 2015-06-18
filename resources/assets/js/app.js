// Browserify Entry Point

var Vue = require('vue');

new Vue({

	el: '#admin-content',

	components: {
		postContent: require('./components/post-content')
	}
});