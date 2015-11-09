<div class="row">

<div class="col-md-8">
@include('admin.posts.form.content')
</div>
@if ($post->exists())
    {{-- @include('admin.posts.form.images') --}}
@endif

<div class="col-md-4"  id="postMeta">
    <div class="">@include('admin.posts.form.meta')</div>

    <div class="">
    	<cr-category-chooser :checkedcategories="{{ $post->categories->lists('id')->toJson(JSON_NUMERIC_CHECK) }}"></cr-category-chooser>
    </div>
    <div class="">@include('admin.posts.form.tags')</div>
</div>

</div>


   