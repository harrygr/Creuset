@extends('admin.layouts.admin')

@section('title')
Edit Page
@stop

@section('heading')
Edit Page
@stop

@section('admin.content')

@include('partials.errors')

<div class="post-form" id="postForm">

  {!! Form::model($page, ['route' => ['admin.pages.update', $page], 'method' => 'PATCH']) !!}

  @include('admin.pages.form', ['submitText' => 'Update'])

  {!! Form::close() !!}

</div>

@stop
