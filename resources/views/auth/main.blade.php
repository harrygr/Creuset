@extends('app')

@section('content')
    @include('partials.logo')
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @yield('auth.content')
            </div>
        </div>
    </div>
</div>
@stop