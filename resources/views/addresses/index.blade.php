@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li><a href="/account">My Account</a></li>
  <li class="active">Addresses</li>
</ol>

<a href="{{ route('addresses.create') }}" class="btn btn-default">Add New Address</a>
<hr>
@foreach ($addresses as $address)
    @include('partials.address', compact('address'))
    <a href="{{ route('addresses.edit', $address) }}">Edit</a>
    {!! Form::open(['route' => ['addresses.update', $address], 'method' => 'DELETE']) !!}
    <input type="submit" class="btn btn-link text-danger" value="Delete">
    {!! Form::close() !!}
    <hr>
@endforeach

@stop