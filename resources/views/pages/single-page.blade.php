@extends('layouts.main')

@section('content')

<h1>{{ $page->title }}</h1>

{!! $page->getContentHtml() !!}

@stop