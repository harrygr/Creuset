<div class="form-group {{ $errors->has("{$type}_address.name") ? 'has-error' : '' }}">
    <label for="{{ $type }}_address[name]">Name</label>
    {!! Form::text("{$type}_address[name]", null, [
    'class' => 'form-control',
    'placeholder' => $type == 'billing' ? 'As it appears on card' : null,
    ]) !!}
</div>

<div class="form-group {{ $errors->has("{$type}_address.line_1") ? 'has-error' : '' }}">
    <label class="control-label" for="{{ $type }}_address[line_1]">Address</label>
    {!! Form::text("{$type}_address[line_1]", null, [
    'class' => 'form-control',
    'placeholder' => 'Street address, house name',
    ]) !!}
</div>

<div class="form-group">
    <label class="sr-only" for="{{ $type }}_address[line_2]">Address</label>
    {!! Form::text("{$type}_address[line_2]", null, [
    'class' => 'form-control',
    'placeholder' => 'Apartment, suite, unit etc. (optional)',
    ]) !!}
</div>

<div class="form-group {{ $errors->has("{$type}_address.city") ? 'has-error' : '' }}">
    <label class="control-label" for="{{ $type }}_address[city]">Town/City</label>
        {!! Form::text("{$type}_address[city]", null, [
        'class' => 'form-control',
        ]) !!}
</div>

<div class="form-group {{ $errors->has("{$type}_address.postcode") ? 'has-error' : '' }}">
    <label class="control-label" for="{{ $type }}_address[postcode]">Postcode</label>
    {!! Form::text("{$type}_address[postcode]", null, [
    'class' => 'form-control',
    'placeholder' => 'Postcode, zip',
    ]) !!}
</div>

<div class="form-group {{ $errors->has("{$type}_address.country") ? 'has-error' : '' }}">
    <label class="control-label" for="{{ $type }}_address[country]">Country</label>
            {!! Form::text("{$type}_address[country]", null, [
        'class' => 'form-control',
        ]) !!}
</div>

<div class="form-group {{ $errors->has("{$type}_address.phone") ? 'has-error' : '' }}">
    <label class="control-label" for="{{ $type }}_address[phone]">Phone Number</label>
            {!! Form::text("{$type}_address[phone]", null, [
        'class' => 'form-control',
        ]) !!}
</div>