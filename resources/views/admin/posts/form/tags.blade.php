<div class="panel panel-default">
    <div class="panel-heading">
        Tags
    </div>
    <div class="panel-body">
        <div class="form-group">
            {!! Form::select('terms[]', $tagList, isset($post) ? $post->tags->lists('id')->toArray() : null, ['multiple', 'class' => 'form-control hidden select2']) !!}
        </div>
    </div>
</div>