@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li><a href="/account">My Account</a></li>
  <li><a href="/account/addresses">Addresses</a></li>
  <li class="active">Edit Address</li>
</ol>

<h1>Edit Address</h1>

@include('partials.errors')

<div class="col-md-offset-3 col-md-6">
{!! Form::model($address, ['route' => ['addresses.update', $address->id], 'method' => 'PUT']) !!}
    @include('addresses.form')
    <input type="submit" class="btn btn-success" value="Update Address">
{!! Form::close() !!}
</div>

@stop