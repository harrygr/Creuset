@extends('admin.layouts.admin')

@section('title')
Edit Post
@stop

@section('heading')
Edit Post
@stop

@section('admin.content')

@include('partials.errors')

<div class="post-form" id="postForm">

  {!! Form::model($post, ['route' => ['admin.posts.update', $post->id], 'method' => 'PATCH']) !!}

  @include('admin.posts.form', ['submitText' => 'Update'])

  {!! Form::close() !!}

</div>

@stop
