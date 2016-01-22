@extends('admin.layouts.admin')

@section('title')
Shipping Methods
@stop

@section('heading')
{{ $title or 'Shipping Methods' }}
@stop


@section('admin.content')



<div class="box box-primary">
	<div class="box-body">


		<table class="table">
			<thead>
				<th>Description</th>
				<th>Base Rate</th>
				<th>Countries Allowed</th>
				<th></th>
			</thead>
			<tbody>
				@foreach($shipping_methods as $method)
				<tr>
					<td>{{ $method->description }}</td>
					<td>{{ Present::money($method->getPrice()) }}</td>
					<td><span title="{{ $method->shipping_countries->implode('country_id', PHP_EOL) }}">{{ $method->shipping_countries->count() }}</span></td>
					<td>@include('partials._delete_link', ['url' => route('admin.shipping_methods.delete', $method)])</td>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>
</div>

<div class="box box-primary">
	<div class="box-header">
		New Shipping Rate
	</div>
	<div class="box-body">

		{!! Form::model(new Creuset\ShippingMethod, ['method' => 'post']) !!}
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
			{!! Form::label('shipping_countries[]', 'Allowed Countries') !!}
			{!! Form::select('shipping_countries[]', app(Creuset\Countries\CountryRepository::class)->lists(), null, ['multiple' => true, 'class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			<button type="submit" name="submit" class="btn btn-primary">Save Shipping Method</button>
		</div>


		{!! Form::close() !!}


	</div>
</div>


@stop
