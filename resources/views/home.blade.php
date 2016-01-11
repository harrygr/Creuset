@extends('layouts.main')

@section('content')
	@include('partials.logo')
    <div class="container">
        <p class="text-center">
        You are at Crueset! This is the front-end of the site, which currently doesn't exist. You can <a href="{{ route('auth.login') }}">login</a> or <a href="{{ route('auth.register') }}">register</a> to get started.
        </p>
    </div>
@endsection
