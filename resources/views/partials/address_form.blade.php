<div class="form-group">
    <label for="first_name">First Name</label>
    <input type="text" name="{{ $type }}_address[first_name]" class="form-control">
</div>

<div class="form-group">
    <label for="last_name">Last Name</label>
    <input type="text" name="{{ $type }}_address[last_name]"  class="form-control">
</div>

<div class="form-group">
    <label for="{{ $type }}_address[line_1]">Address</label>
    {!! Form::text("{$type}_address[line_1]", null, ['class' => 'form-control']) !!}
{{--     <input type="text" name="{{ $type }}_address[line_1]" class="form-control">
 --}}</div>

<div class="form-group">
    <label for="{{ $type }}_address[line_2]" class="sr-only">Address</label>
    <input type="text" name="{{ $type }}_address[line_2]" class="form-control">
</div>

<div class="form-group">
    <label for="{{ $type }}_address[city]">Town/City</label>
    <input type="text" name="{{ $type }}_address[city]" class="form-control">
</div>

<div class="form-group">
    <label for="{{ $type }}_address[postcode]">Postcode</label>
    <input type="text" name="{{ $type }}_address[postcode]" class="form-control">
</div>

<div class="form-group">
    <label for="{{ $type }}_address[country]">Country</label>
    <input type="text" name="{{ $type }}_address[country]" class="form-control">
</div>

<div class="form-group">
    <label for="{{ $type }}_address[phone]">Phone Number</label>
    <input type="tel" name="{{ $type }}_address[phone]" class="form-control">
</div>