@extends('admin.layouts.admin')

@section('title')
{{ $title or 'New Attribute' }}
@stop

@section('heading')
{{ $title or 'New Attribute' }}
@stop

@section('admin.content')

<div class="box box-primary">
    <div class="box-body">
        <cr-attribute-form>

    </div>
</div>

@stop
