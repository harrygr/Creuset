<div class="box box-primary">
    <div class="box-header">
        Tags
    </div>
    <div class="box-body">
        <div class="form-group">
            {!! Form::select('terms[]', $tagList, isset($post) ? $post->tags->lists('id')->toArray() : null, ['multiple', 'class' => 'form-control hidden select2']) !!}
        </div>
    </div>
</div>