@extends('admin.layouts.admin')

@section('title')
User profile for {{ $user->name }}
@stop

@section('heading')
Profile for {{ $user->name }}
@stop

@section('admin.content')

@include('partials.errors')


<div class="row">

    <div class="col-sm-3">
        @include('admin.users._widget')
    </div>

    <div class="col-sm-9">
        <div class="box box-primary">
            <div class="box-header">Update Profile</div>
            <div class="box-body">
                {!! Form::model($user, ['route' => ['admin.users.update', $user->id], 'method' => 'PATCH']) !!}
                @include('admin.users.form', ['submit_text' => 'Update Profile'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@stop