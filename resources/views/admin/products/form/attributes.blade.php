    <div class="box box-primary">
        <div class="box-header">
            Attributes          
        </div>
        <div class="box-body">
            <div class="box-group" id="attributes">
                @foreach ($product_attributes as $attribute => $properties)
                <div class="panel box box-default">
                    <div class="box-header">
                    <a data-toggle="collapse" data-parent="#attributes" href="#attribute-{{ str_slug($attribute) }}" aria-expanded="true">
                        {{ $attribute }}
                      </a>
                    
                    </div>
                    <div class="panel-collapse collapse" id="attribute-{{ str_slug($attribute) }}">
                    @foreach ($properties as $property)
                        <div class="checkbox">
                            <label>
                            <input type="checkbox" 
                                   name="attributes[]" 
                                   value="{{ $property->id }}" 
                                   {{ $product->product_attributes->pluck('id')->contains($property->id) ? 'checked' : '' }}
                                   > {{ $property->property }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>