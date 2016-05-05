
@if ($product->media->count() < 2)

<img src="{{ $product->image ? $product->image->getUrl('wide') : 'http://placehold.it/1300x866' }}" alt="%s" style="width:100%;" class="img-responsive">

@else

<div id="product-image-carousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    @foreach($product->media as $key => $media)
    <li data-target="#product-image-carousel" data-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}"></li>
    @endforeach
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">

    @foreach($product->media as $key => $media)
    <div class="item {{ $key === 0 ? 'active' : '' }}">
      <img src="{{ $media->getUrl('wide') }}" alt="...">
    </div>    
    @endforeach
    
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#product-image-carousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#product-image-carousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
@endif