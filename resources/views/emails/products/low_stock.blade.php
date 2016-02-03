@extends('emails.main')

@section('content')
Product stock low: {{ $product->sku }}

{{ $product->description }}
@stop