@extends('layouts.single_product')

@section('breadcrumb')
<div class="sections">
    <ol class="breadcrumb">
        <li><a href="/shop">Shop</a></li>
        <li><a href="/shop/{{ $product->product_category->slug }}">{{ $product->product_category->term }}</a></li>
        <li class="active">{{ $product->name }}</li>
    </ol>

</div>
@endsection

@section('content')

@include('partials.alerts._errors_block')
@include('partials.alerts._alert_block')

<div itemscope itemtype="http://schema.org/Product">
    <div class="" itemprop="image">
        @include('products._product_image')
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="sections">

                <header>
                    <h1 itemprop="name">{{ $product->name }}</h1>
                </header>

                <hr>
                <header><h5>Description</h5></header>
                <section class="description" itemprop="description">
                    {!! $product->getDescriptionHtml() !!}
                </section>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="sections pricing-bar">
                <section class="row">
                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="col-xs-6">
                        <span class="price" itemprop="price">
                            {{ $product->present()->price() }}
                        </span>
                    </div>

                    <div class="col-sm-6 text-right">
                        <span class="stock {{ $product->stock_qty > 0 ? 'in-stock' : '' }}">
                            {{ $product->present()->stock() }}
                        </span>
                    </div>
                </section>
            </div>
            <div class="sections">

                @if ($product->inStock())
                <section>
                    <form action="/cart" method="POST" class="form-">
                        {{ csrf_field() }}
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
           <div class="row">
                            <div class="form-group col-sm-6">
                   <label for="quantity" class="col-xs-f6 control-label">Quantity</label>

                       <input type="number" name="quantity" value="1" min="1" step="1" max="{{ $product->stock_qty }}" class="form-control">

               </div>
           </div>
                        <input type="submit" class="btn btn-success btn-block" value="Add To Cart">
                    </form>
                </section>
                @endif

                <hr>

                <section>
                    <p class="text-center">
                        Share this product
                        <a href="#"><i class="fa fa-fw fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-fw fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-fw fa-pinterest"></i></a>
                    </p>
                </section>
            </div>


        </div>
    </div>
    <meta itemprop="url" content="{{ Request::url() }}">
</div>

@stop
