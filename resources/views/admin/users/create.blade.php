@extends('admin.layouts.admin')

@section('title')
New User
@stop

@section('admin.content')
<h1>New User</h1>

@include('partials.errors')

{!! Form::model($user, ['route' => ['admin.users.store'], 'method' => 'POST']) !!}
	@include('admin.users.form', ['submit_text' => 'Create User'])
{!! Form::close() !!}
@stop