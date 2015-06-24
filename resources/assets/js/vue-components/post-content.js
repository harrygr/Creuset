var sluggify = require('../filters/sluggify.js');

module.exports = new Vue({
	el: '#postForm',
	data: {
		title: '',
		oldTitle: '',
		slug: '',
		content: '',
	},
	filters: {
		marked: require('marked'),
	},
	methods: {
		resluggifyTitle: function(e)
		{
			if (e) e.preventDefault();
			this.slug = sluggify(this.title);
		},
		setNewSlug: function(e)
		{
			if (this.oldTitle == '')
			{
				this.resluggifyTitle(e);
			}
			this.oldTitle = this.title;
		}
	}
});