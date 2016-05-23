@inject('queryFilter', 'App\Services\AttributeQueryBuilder')

<h3>Filter</h3>
<div class="row">
    @foreach ($product_attributes as $attribute => $properties)
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4>{{ $properties->first()->name }}</h4>
                <ul class="fa-ul">

                    @foreach ($properties as $property)
                        <?php $queryFilter->setFilters([$property->slug => $property->property_slug]); ?>
                        <li>
                            <i class="fa-li fa {{ $queryFilter->hasCurrentFilter($property->slug, $property->property_slug) ? 'fa-check-square-o' : 'fa-square-o' }}"></i>
                            <a href="/shop{{ $product_category->id ? "/{$product_category->slug}" : '' }}?{{ $queryFilter->getQueryString() }}">
                                {{ $property->property }}
                            </a> ({{ $property->products->count() }})
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div>
