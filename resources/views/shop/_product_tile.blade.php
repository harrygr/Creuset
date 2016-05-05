<a href="{{ $product->url }}" class="product-grid-element">
  <img src="{{ $product->present()->thumbnail_url(500) }}" alt="" class="product-grid-image img-responsive">  
  <div class="product-flex">
      <div class="product-description">
      
            <!-- <p>{{ $product->product_category->term }}</p> -->
                <h3>{{ $product->name }}</h3>
        </div>
      <p class="product-grid-price">
        <span class="price">{{ $product->present()->price() }}</span>
      </p>
  </div>
</a>