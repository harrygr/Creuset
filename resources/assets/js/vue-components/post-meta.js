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

			this.addCategoryErrors = [];

			if (!this.newCategory)
			{
				this.displayErrors(["Please provide a category"]);
				return false;
			}

			this.addCatButtonClass = 'fa-circle-o-notch fa-spin';

			var postData = {
				term: this.newCategory,
				taxonomy: 'category',
				_token: $("meta[name=csrf-token]").attr('content')
			};

			this.$http.post('/api/categories', postData)
				.success(function(newCategory)
				{
					// On success get the returned newly created term and append to the existing
					this.categories.unshift({
						id: newCategory.id,
						term: newCategory.term,
						slug: newCategory.slug,
						checked: true
					});

					this.addCatButtonClass = 'fa-plus';
				})
				.error(function(response)
				{
					this.displayErrors(response.term)
				});

			this.newCategory = '';
			
			return false;
		},

		displayErrors: function(messages)
		{
			var errorDisplayTime = 5000;

			// On failure catch the error response and display it
			this.addCategoryErrors = messages;
			this.addCatButtonClass = 'fa-plus';

			// Wait a bit and reset the errors
			setTimeout(function()
			{
				this.addCategoryErrors = [];
			}.bind(this), errorDisplayTime);
		}
	}
});