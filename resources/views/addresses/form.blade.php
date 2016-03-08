@inject('countries', 'App\Countries\CountryRepository')

<div class="form-group">
    <label for="name">Name</label>
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="line_1">Address</label>
    {!! Form::text('line_1', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="line_2" class="sr-only">Address</label>
    {!! Form::text('line_2', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="city">Town/City</label>
    {!! Form::text('city', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="postcode">Postcode</label>
    {!! Form::text('postcode', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="country">Country</label>
    {!! Form::select('country', $countries->lists(), null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="phone">Phone Number</label>
    {!! Form::tel('phone', null, ['class' => 'form-control']) !!}
</div>
