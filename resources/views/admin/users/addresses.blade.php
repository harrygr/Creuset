@extends('admin.layouts.admin')

@section('title')
Addresses
@stop

@section('heading')
Addresses
@stop

@section('admin.content')

<p>
    <a href="#" class="btn btn-success pull-right">New Address</a>
</p>
<p class="clearfix"></p>
@include('partials.errors')


<div class="box box-primary">
    <div class="box-body">

        <div class="row">
            @foreach($user->addresses as $address)
            <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-body">
                    @include('partials.address', compact('address'))
                </div>
            </div>
            </div>
            @endforeach
        </div>

    </div>
</div>




@stop