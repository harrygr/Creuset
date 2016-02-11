@extends('admin.layouts.admin')

@section('title')
{{ $title or 'Edit Attribute' }}
@stop

@section('heading')
{{ $title or 'Edit Attribute' }}
@stop

@section('admin.content')

<div class="box box-primary">
    <div class="box-body">
        <cr-attribute-form taxonomy="{{ Present::labelText($taxonomy) }}">

    </div>
</div>

@stop
