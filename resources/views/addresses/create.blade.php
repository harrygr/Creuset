@extends('layouts.main')

@section('breadcrumb')

<ol class="breadcrumb">
  <li><a href="/account">My Account</a></li>
  <li><a href="/account/addresses">Addresses</a></li>
  <li class="active">Create Address</li>
</ol>

@endsection

@section('content')

<h1>Create New Address</h1>
@include('partials.errors')

<div class="col-md-offset-3 col-md-6">
{!! Form::model($address, ['route' => ['addresses.store'], 'method' => 'POST']) !!}
    @include('addresses.form')
    <input type="submit" class="btn btn-success" value="Save Address">
{!! Form::close() !!}
</div>

@stop