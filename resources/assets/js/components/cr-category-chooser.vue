<template>
    <div class="panel panel-default" id="postCategories">
        <div class="panel-heading">
            Categories
        </div>


        <div class="panel-body">
            <div id="category-checkboxes">
                <div class="checkbox" v-for="category in categories">
                    <label>
                        <input type="checkbox" name="terms[]" value="{{ category.id }}" v-model="category.checked"> {{ category.term }}
                    </label>
                </div>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" v-model="newCategory" @keydown.enter="addCategory" placeholder="New Category">
                <span class="input-group-btn">
                    <button class="btn btn-default" @click="addCategory"><i class="fa fa-fw {{ addCatButtonClass }}"></i></button>
                </span>
            </div>
            <div class="alert alert-danger top-buffer" v-show="addCategoryErrors.length"><p v-for="error in addCategoryErrors" v-text="error"></p></div>
        </div>
    </div>
</template>

<script>
    var $ = require('jquery');

    module.exports = {
        props: ['checkedcategories'],

        data: function() {
            return {
                //checkedCategories: [],
                categories: [],
                newCategory: '',
                addCatButtonClass: 'fa-plus',
                addCategoryErrors: [],
            };
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
                console.log(this.checkedcategories);
                //this.checkedCategories = JSON.parse(this.checkedCategories);
                //this.checkedCategories = [];
                this.$http.get('/api/categories', function(categories)
                {
                    this.categories = categories.map(function(category)
                    {
                        category.checked = $.inArray(parseInt(category.id), this.checkedcategories) >= 0
                        return category;
                       
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
    }
</script>