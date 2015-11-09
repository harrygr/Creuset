{!! Form::label($name, 'Publish At') !!}
<div class="date">
<?php 
dd($thing->{$name}); ?>
    {!! Form::input('datetime-local', $name, old($name, isset($thing->published_at) ? $thing->published_at->format('Y-m-d\TH:i:s') : date('Y-m-d\TH:i:s')), ['class' => 'form-control']) !!}
</div>