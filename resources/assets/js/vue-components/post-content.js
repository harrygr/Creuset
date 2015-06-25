var sluggify = require('../filters/sluggify.js');

module.exports = new Vue({
	el: '#postContent',
	data: {
		title: '',
		slug: '',
		content: '',
	},
	filters: {
		marked: require('marked'),
	},
	ready: function()
	{
		if (this.slug != '') this.hasSlug = true;
	},
	methods: {
		sluggifyTitle: function(e)
		{
			if (e) e.preventDefault();
			this.slug = sluggify(this.title);
		},
		setNewSlug: function(e)
		{
			if (this.slug == '')
			{
				this.sluggifyTitle(e);
			}
		}
	}
});