@extends('admin.layouts.admin')

@section('title')
{{ $title or 'Edit Attribute' }}
@stop

@section('heading')
{{ $title or 'Edit Attribute' }}
@stop

@section('admin.content')

<p>
    <a href="{{route('admin.attributes.create')}}" class="btn btn-success pull-right">New Attribute</a>
</p>
<p class="clearfix"></p>

<div class="box box-primary">
    <div class="box-body">
        <cr-attribute-form product_attribute="{{ $attribute }}">
    </div>
</div>

@stop
