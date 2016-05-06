@extends('layouts.outer')

@section('body')

<div class="bg space-deck">
    <div class="container">

        @yield('breadcrumb')

        @yield('content')
    </div>
</div>

@stop