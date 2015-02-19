@extends('admin.layouts.admin')

@section('title')
    Create Post
@stop

@section('admin.content')
    <h1>Create Post</h1>

    @include('partials.errors')

    {!! Form::model($post = new \Creuset\Post, ['route' => 'admin.posts.store', 'method' => 'POST']) !!}


        @include('admin.posts.form', ['submitText' => 'Create Post'])


    {!! Form::close() !!}
@stop