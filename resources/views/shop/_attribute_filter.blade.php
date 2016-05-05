<h3>Filter</h3>

<div class="row">
    @foreach ($product_attributes as $attribute => $properties)
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4>{{ $properties->first()->name }}</h4>
                <ul>

                    @foreach ($properties as $property)
                    <li>
                        <a href="?filter[{{ $property->slug }}]={{ $property->property_slug }}">{{ $property->property }}</a> ({{ $property->products->count() }})                    
                    </li>
                    @endforeach

                </ul>
            </div>
        </div>    
    </div>
    @endforeach
</div>