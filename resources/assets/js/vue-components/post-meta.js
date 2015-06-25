module.exports = new Vue({
	el: '#postMeta',

	data: {
		categories: [],
		checkedCategories: [],
		newCategory: ''
	},

	ready: function()
	{
		this.fetchCategories();

	},

	methods: {
		fetchCategories: function()
		{
			this.checkedCategories = JSON.parse(this.checkedCategories);

			this.$http.get('/api/categories', function(categories)
				{
					categories.map(function(category)
					{
						this.categories.push({
							id: category.id,
							term: category.term,
							slug: category.slug,
							checked: $.inArray(category.id, this.checkedCategories) >= 0
						});
					}.bind(this));					
				});
		},
		addCategory: function(e)
		{
			if (e) e.preventDefault();

			var postData = {
				term: this.newCategory,
				taxonomy: 'category',
				_token: $("meta[name=csrf-token]").attr('content')
			};

			this.$http.post('/api/terms', postData, function(newCategory)
				{
					this.categories.push({
						id: newCategory.id,
						term: newCategory.term,
						slug: newCategory.slug,
						checked: true
					});
				});


			this.newCategory = '';
		}
	}

});