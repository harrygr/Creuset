<div class="box box-primary">

    <div class="box-body">
        <div class="form-group">
            {!! Form::label('published_at', 'Publish At') !!}
            <div class="date">
                {!! Form::input('datetime-local', 'published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i:s') : date('Y-m-d\TH:i:s'), ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('status') !!}
            {!! Form::select('status', App\Post::$postStatuses, null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">

            {!! Form::label('user_id', 'Author') !!}
            {!! Form::select('user_id', App\User::lists('name', 'id'), null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="box-footer">
        @if (isset($post))
        {!! HTML::linkRoute('admin.posts.delete', 'Trash', [$post->id],[
            'class' => 'btn text-danger pull-left',
            'data-method' => 'delete',
            'data-confirm' => 'Are you sure?'
        ]) !!}
        @endif

        {!! Form::submit(isset($submitText) ? $submitText : 'Submit', ['class' => 'btn btn-primary pull-right']) !!}
        <div class="clearfix"></div>
    </div>
</div>
