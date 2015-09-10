
@include('admin.posts.form.content')

@if ($post->exists())
    @include('admin.posts.form.images')
@endif

<div class="row"  id="postMeta">
    <div class="col-md-4"> @include('admin.posts.form.categories')</div>
    <div class="col-md-4">@include('admin.posts.form.tags')</div>
    <div class="col-md-4">@include('admin.posts.form.meta')</div>
</div>




   