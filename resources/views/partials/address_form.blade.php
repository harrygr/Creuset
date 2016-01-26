<div class="form-group {{ $errors->has("{$type}_address.name") ? 'has-error' : '' }}">
    <label for="{{ $type }}_address[name]">Name</label>
    {!! Form::text("{$type}_address[name]", old("{$type}_address[name]", $order->getAddress($type)->name), [
    'class' => 'form-control',
    'placeholder' => $type == 'billing' ? 'As it appears on card' : null,
    ]) !!}
</div>

<div class="form-group {{ $errors->has("{$type}_address.line_1") ? 'has-error' : '' }}">
    <label class="control-label" for="{{ $type }}_address[line_1]">Address</label>
    {!! Form::text("{$type}_address[line_1]", old("{$type}_address[line_1]", $order->getAddress($type)->line_1), [
    'class' => 'form-control',
    'placeholder' => 'Street address, house name',
    ]) !!}
</div>

<div class="form-group">
    <label class="sr-only" for="{{ $type }}_address[line_2]">Address</label>
    {!! Form::text("{$type}_address[line_2]", old("{$type}_address[line_2]", $order->getAddress($type)->line_2), [
    'class' => 'form-control',
    'placeholder' => 'Apartment, suite, unit etc. (optional)',
    ]) !!}
</div>

<div class="form-group {{ $errors->has("{$type}_address.city") ? 'has-error' : '' }}">
    <label class="control-label" for="{{ $type }}_address[city]">Town/City</label>
        {!! Form::text("{$type}_address[city]", old("{$type}_address[city]", $order->getAddress($type)->city), [
        'class' => 'form-control',
        ]) !!}
</div>

<div class="form-group {{ $errors->has("{$type}_address.postcode") ? 'has-error' : '' }}">
    <label class="control-label" for="{{ $type }}_address[postcode]">Postcode</label>
    {!! Form::text("{$type}_address[postcode]", old("{$type}_address[postcode]", $order->getAddress($type)->postcode), [
    'class' => 'form-control',
    'placeholder' => 'Postcode, zip',
    ]) !!}
</div>

<div class="form-group {{ $errors->has("{$type}_address.country") ? 'has-error' : '' }}">
    <label class="control-label" for="{{ $type }}_address[country]">Country</label>
            {!! Form::select("{$type}_address[country]", $countries->lists(), old("{$type}_address[country]", $order->getAddress($type)->country), [
        'class' => 'form-control',
        ]) !!}
</div>

<div class="form-group {{ $errors->has("{$type}_address.phone") ? 'has-error' : '' }}">
    <label class="control-label" for="{{ $type }}_address[phone]">Phone Number</label>
            {!! Form::text("{$type}_address[phone]", old("{$type}_address[phone]", $order->getAddress($type)->phone), [
        'class' => 'form-control',
        ]) !!}
</div>