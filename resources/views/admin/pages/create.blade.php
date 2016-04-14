@extends('admin.layouts.admin')

@section('title')
Create Page
@stop

@section('heading')
Create Page
@stop

@section('admin.content')

@include('partials.errors')
    
<div class="post-form" id="postForm">
    {!! Form::model($page, ['route' => 'admin.pages.store', 'method' => 'POST']) !!}

        @include('admin.pages.form', ['submitText' => 'Create Page'])

    {!! Form::close() !!}
</div>
@stop