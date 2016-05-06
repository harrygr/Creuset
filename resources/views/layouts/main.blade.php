@extends('layouts.outer')

@section('body')

<div class="bg">
    <div class="container top-buffer">
        
        @yield('breadcrumb')

        @include('partials.alert')
        @yield('content')
    </div>
<div class="top-buffer"></div>
</div>
@stop