<div class="row post-form">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">

                <div class="form-group">
                    <label for="title" class="sr-only">Title</label>
                    <input type="text" name="title" class="form-control input-lg" placeholder="Title" value="{{ $post->title }}">
                </div>

                <div class="input-group">
                    <label for="slug" class="sr-only">Slug</label>
                    <input type="text" name="slug" class="form-control" placeholder="Slug" value="{{ $post->slug }}">
                    <span class="input-group-btn refresh-slug">
                        <button class="btn btn-default disabled" type="button"><i class="fa fa-fw fa-refresh"></i></button>
                    </span>
                </div>

                <div class="form-group top-buffer">
                    <label for="content" class="sr-only">Content</label>
                    <textarea name="content" class="form-control" rows="15">{!! $post->content !!}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">

            <div class="panel-body">
                <div class="form-group">
                    <label for="published_at" class="sr-only">Publish At</label>

                    <div class="input-group date datetimepicker">
                        <input type="text" name="published_at" class="form-control" value="{{ $post->published_at->format('Y-m-d H:i') }}">
                        <span class="input-group-addon">
                            <span class="fa-calendar fa"></span>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
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
                        {!! Form::select('terms[]', $tagList, isset($post) ? $post->tags->lists('id') : null, ['multiple', 'class' => 'form-control tagSelect']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
