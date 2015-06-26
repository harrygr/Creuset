module.exports = new Vue({
	el: '#postMeta',

	data: {
		categories: [],
		checkedCategories: [],
		newCategory: '',
		addCatButtonClass: 'fa-plus',
		addCategoryErrors: []
	},

	computed: {
		isLoadingCategories: function()
		{
			return this.addCatButtonClass !== 'fa-plus';
		}
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

			this.addCatButtonClass = 'fa-circle-o-notch fa-spin';

			var postData = {
				term: this.newCategory,
				taxonomy: 'category',
				_token: $("meta[name=csrf-token]").attr('content')
			};

			this.$http.post('/api/categories', postData, function(newCategory)
				{
					// On success get the returned newly created term and append to the existing
					this.categories.push({
						id: newCategory.id,
						term: newCategory.term,
						slug: newCategory.slug,
						checked: true
					});

					this.addCatButtonClass = 'fa-plus';
				}).error(function(response)
				{
					// On failure catch the error response and display it
					this.addCategoryErrors = response.term;
					this.addCatButtonClass = 'fa-plus';

					// Wait a bit and reset the errors
					setTimeout(function()
					{
						this.addCategoryErrors = [];
					}.bind(this), 5000);
				});

			this.newCategory = '';
			
			return false;
		}
	}
});