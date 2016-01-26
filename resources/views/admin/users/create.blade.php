@extends('admin.layouts.admin')

@section('title')
New User
@stop

@section('heading')
New User
@stop

@section('admin.content')

@include('partials.errors')
<div class="box box-primary ">
<div class="box-body">
        {!! Form::model($user, ['route' => ['admin.users.store'], 'method' => 'POST']) !!}
        @include('admin.users.form', ['submit_text' => 'Create User'])
        {!! Form::close() !!}
    </div>
</div>
@stop