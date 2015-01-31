@extends('admin.layouts.admin')

@section('title')
    Create Post
@stop

@section('admin.content')
    <h1>Create Post</h1>

    @include('partials.errors')

    {!! Form::open(['route' => 'admin.posts.store', 'method' => 'POST']) !!}

    <div class="row">
        @include('admin.posts.form')
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    {!! Form::submit('Create Post', ['class' => 'btn btn-primary pull-right']) !!}
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@stop