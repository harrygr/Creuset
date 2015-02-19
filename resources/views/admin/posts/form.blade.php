<div class="row post-form">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::label('title', 'Title', ['class' => 'sr-only']) !!}
                    {!! Form::text('title', null, ['class' => 'form-control input-lg', 'placeholder' => 'Title']) !!}
                </div>
                <div class="input-group">
                    {!! Form::label('slug', 'Slug', ['class' => 'sr-only']) !!}
                    {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Slug']) !!}
                    <span class="input-group-btn refresh-slug">
                        <button class="btn btn-default disabled" type="button"><i class="fa fa-fw fa-refresh"></i></button>
                    </span>
                </div>

                <div class="form-group top-buffer">
                    {!! Form::label('content', 'Content', ['class' => 'sr-only']) !!}
                    {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">

            <div class="panel-body">
                <div class="form-group">
                    {!! Form::label('published_at', 'Publish at') !!}
                    <div class="input-group date datetimepicker">
                    {!! Form::text('published_at', $post->published_at->format('Y-m-d H:i'), ['class' => 'form-control']) !!}
                    <span class="input-group-addon"><span class="fa-calendar fa"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('status') !!}
                    {!! Form::select('status', Creuset\Post::$postStatuses, null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">

                    {!! Form::label('user_id', 'Author') !!}
                    {!! Form::select('user_id', Creuset\User::lists('name', 'id'), null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="panel-footer">
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


        <div class="panel panel-default">
            <div class="panel-heading">
                Categories
            </div>
            <div class="panel-body">

                @foreach ($categoryList as $categoryId => $category)
                    <div class="checkbox">
                    <label>
                    {!! Form::checkbox('terms[]', $categoryId, in_array($categoryId, $selectedCategories)) !!} {{ $category }}
                    </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Tags
            </div>
            <div class="panel-body">
                <div class="form-group">

                {!! Form::select('terms[]', $tagList, isset($post) ? $post->tags->lists('id') : null, ['multiple', 'class' => 'form-control select2']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
