@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li><a href="/account">My Account</a></li>
  <li class="active">Addresses</li>
</ol>

<a href="{{ route('addresses.create') }}" class="btn btn-default">Add New Address</a>
<hr>
<div class="row">
@foreach ($addresses as $address)
<div class="col-md-3">
<div class="panel panel-default"><div class="panel-body">
    @include('partials.address', compact('address'))

    {!! Form::open(['route' => ['addresses.update', $address], 'method' => 'DELETE']) !!}
    <button type="submit" class="btn btn-link"><span class="text-danger"><i class="fa fa-trash"></i> Delete</span></button>
    <a href="{{ route('addresses.edit', $address) }}" class="btn btn-link"><i class="fa fa-pencil"></i> Edit</a>
    {!! Form::close() !!}
</div></div>
</div>
@endforeach
</div>
@stop