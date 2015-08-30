<div class="panel panel-default" id="postCategories">
    <div class="panel-heading">
        Categories
    </div>
    <input type="hidden" v-model="checkedCategories" value="{{ $post->categories->lists('id')->toJson() }}">

    <div class="panel-body">
        <div id="category-checkboxes">
            <div class="checkbox" v-repeat="categories | orderBy 'checked' -1">
                <label>
                    <input type="checkbox" name="terms[]" value="@{{ id }}" v-model="checked"> @{{ term }}
                </label>
            </div>
        </div>
        <div class="input-group">
            <input type="text" class="form-control" v-model="newCategory" v-on="keydown:addCategory | key 'enter'" placeholder="New Category" v-attr="disabled: isLoadingCategories">
            <span class="input-group-btn">
                <button class="btn btn-default" v-on="click: addCategory" v-attr="disabled: isLoadingCategories"><i class="fa fa-fw @{{ addCatButtonClass }}"></i></button>
            </span>
        </div>
        <div class="alert alert-danger top-buffer" v-show="addCategoryErrors.length"><p v-repeat="error: addCategoryErrors" v-text="error"></p></div>
    </div>
</div>