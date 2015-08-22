@extends('admin.layouts.admin')

@section('title')
Edit Post
@stop

@section('admin.content')
<h1>Edit Post</h1>

@include('partials.errors')

<script>
var postId = {{ $post->id }};
</script>
@stop