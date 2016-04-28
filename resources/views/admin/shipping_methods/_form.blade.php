{!! Form::model($shipping_method, ['method' => isset($method) ? $method : 'post', 'route' => $route]) !!}
<div class="row">
    <div class="form-group col-sm-6 {{ $errors->has('description') ? 'has-error' : '' }}">
        {!! Form::label('description', 'Description', ['class' => 'sr-only']) !!}
        {!! Form::text('description', null, ['class' => 'form-control']) !!}
        {!! $errors->has('description') ? '<span class="help-block">'.$errors->first('description').'</span>' : '' !!}
    </div>

    <div class="form-group col-sm-6 {{ $errors->has('base_rate') ? 'has-error' : '' }}">
        {!! Form::label('base_rate', 'Base Rate', ['class' => 'sr-only']) !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-{{ strtolower(config('shop.currency')) }}"></i></span>
            {!! Form::number('base_rate', null, ['class' => 'form-control', 'min' => 0, 'step' => '0.01', 'placeholder' => 'Base Rate']) !!}
        </div>
        {!! $errors->has('base_rate') ? '<span class="help-block">'.$errors->first('base_rate').'</span>' : '' !!}
    </div>
</div>

<div class="form-group">
    <?php $selected_countries = $shipping_method->shipping_countries->pluck('country_id')->toArray(); ?>
    {!! Form::label('shipping_countries[]', 'Allowed Countries') !!}
    {!! Form::select('shipping_countries[]', app(App\Countries\CountryRepository::class)->group()->toArray(), $selected_countries, ['multiple' => true, 'class' => 'form-control select2 shipping-country-select']) !!} 
</div>


<div class="form-group">
    <button type="submit" name="submit" class="btn btn-primary">Save Shipping Method</button>
    <a href="{{ route('admin.shipping_methods.index') }}" class="btn btn-default">Cancel</a>
</div>


{!! Form::close() !!}
