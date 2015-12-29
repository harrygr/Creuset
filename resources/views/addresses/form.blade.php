<div class="form-group">
    <label for="first_name">First Name</label>
        {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="last_name">Last Name</label>
    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
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
    {!! Form::text('country', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="phone">Phone Number</label>
    {!! Form::tel('phone', null, ['class' => 'form-control']) !!}
</div>