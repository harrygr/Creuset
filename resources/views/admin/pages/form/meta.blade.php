<div class="box box-primary">

    <div class="box-body">
        <div class="form-group">
            {!! Form::label('published_at', 'Publish At') !!}
            <div class="date">
                {!! Form::input('datetime-local', 'published_at', isset($page->published_at) ? $page->published_at->format('Y-m-d\TH:i:s') : date('Y-m-d\TH:i:s'), ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
            {!! Form::label('status') !!}
            {!! Form::select('status', App\Post::$postStatuses, null, ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">

            {!! Form::label('user_id', 'Author') !!}
            {!! Form::select('user_id', App\User::lists('name', 'id'), null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
            {!! Form::label('parent_id', 'Parent') !!}
            {!! Form::select('parent_id', [null => 'none'] + App\Page::getNestedList('title', 'id', '- '), null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="box-footer">
        @if (isset($post))
        {!! HTML::linkRoute('admin.posts.delete', 'Trash', [$page->id],[
            'class' => 'btn text-danger pull-left',
            'data-method' => 'delete',
            'data-confirm' => 'Are you sure?'
        ]) !!}
        @endif

        {!! Form::submit(isset($submitText) ? $submitText : 'Submit', ['class' => 'btn btn-primary pull-right']) !!}
        <div class="clearfix"></div>
    </div>
</div>