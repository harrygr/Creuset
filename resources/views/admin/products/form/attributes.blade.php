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
                    {{ Present::labelText($attribute) }}
                  </a>
                
                </div>
                <div class="panel-collapse collapse" id="attribute-{{ str_slug($attribute) }}">
                @foreach ($properties as $property)
                    <div class="checkbox">
                        <label>
                               {{ Form::checkbox('attributes[]', $property->id, $product->product_attributes->pluck('id')->contains($property->id)) }}
                               {{ $property->property }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>