@extends('admin.layouts.admin')

@section('title')
    Create Post
@stop

@section('heading')
Create Post
@stop

@section('admin.content')

@include('partials.errors')
    
<div class="post-form" id="postForm">
    {!! Form::model($post, ['route' => 'admin.posts.store', 'method' => 'POST']) !!}

        @include('admin.posts.form', ['submitText' => 'Create Post'])

    {!! Form::close() !!}
</div>
@stop