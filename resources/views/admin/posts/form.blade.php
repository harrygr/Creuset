<div class="row">

<div class="col-md-8">
@include('admin.posts.form.content')
</div>

<div class="col-md-4"  id="postMeta">
    <div>@include('admin.posts.form.meta')</div>

    <div>
    	<cr-category-chooser :checkedcategories="{{ $post->categories->lists('id')->toJson(JSON_NUMERIC_CHECK) }}"></cr-category-chooser>
    </div>
    <div>@include('admin.posts.form.tags')</div>
</div>

</div>


   