@extends('emails.main')

@section('content')
Product out of stock: {{ $product->sku }}

{{ $product->description }}
@stop