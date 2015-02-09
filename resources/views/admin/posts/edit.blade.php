@extends('admin.layouts.admin')

@section('title')
Edit Post
@stop

@section('admin.content')
<h1>Edit Post</h1>

@include('partials.errors')

{!! Form::model($post, ['route' => ['admin.posts.update', $post->id], 'method' => 'PATCH']) !!}


	@include('admin.posts.form', ['submitText' => 'Update'])


{!! Form::close() !!}
@stop