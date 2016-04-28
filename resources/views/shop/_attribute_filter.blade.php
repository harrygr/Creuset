<h4>Filter</h4>

<ul>
@foreach ($product_attributes as $attribute => $properties)
    <li>
        <h5>{{ $attribute }}</h5>
        <ul>

            @foreach ($properties as $property)
            <li>
                <a href="?filter[{{ $property->slug }}]={{ $property->property_slug }}">{{ $property->property }}</a> ({{ $property->products->count() }})                    
            </li>
            @endforeach
        </ul>
    </li>    
    @endforeach
</ul>