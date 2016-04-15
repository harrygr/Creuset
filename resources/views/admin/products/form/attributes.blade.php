    <div class="box box-primary">
        <div class="box-header">
            Attributes          
        </div>
        <div class="box-body">

            <div class="box-group" id="attributes">
                @foreach ($attributes as $attribute => $properties)
                <div class="panel box box-default">
                    <div class="box-header">
                    <a data-toggle="collapse" data-parent="#attributes" href="#attribute-{{ $attribute }}" aria-expanded="true">
                        {{ Present::labelText($attribute) }}
                      </a>
                    
                    </div>
                    <div class="panel-collapse collapse" id="attribute-{{ $attribute }}">
                    @foreach ($properties as $property)
                        <div class="checkbox">
                            <label>
                            <input type="checkbox" 
                                   name="terms[]" 
                                   value="{{ $property->id }}" 
                                   {{ $product->terms->pluck('id')->contains($property->id) ? 'checked' : '' }}
                                   > {{ $property->term }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>