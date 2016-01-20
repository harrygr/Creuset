@extends('admin.layouts.admin')

@section('title')
User profile for {{ $user->name }}
@stop

@section('heading')
Profile
@stop

@section('admin.content')

@include('partials.errors')

{!! Form::model($user, ['route' => ['admin.users.update', $user->id], 'method' => 'PATCH']) !!}
	@include('admin.users.form', ['submit_text' => 'Update Profile'])
{!! Form::close() !!}


@stop