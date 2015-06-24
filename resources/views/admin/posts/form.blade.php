<div class="row post-form" id="postForm">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">

                <div class="form-group">
                    <label for="title" class="sr-only">Title</label>
                    {!! Form::text('title', null, [
                    'class' => 'form-control input-lg', 
                    'placeholder' => "Title", 
                    'v-model' => 'title',
                    'v-on' => 'blur: setNewSlug'
                    ]) !!}                    
                </div>

                <label for="slug" class="sr-only">Slug</label>
                <div class="input-group">
                     {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => "Slug" , 'v-model' => 'slug']) !!}   
                    
                    <span class="input-group-btn refresh-slug">
                        <button class="btn btn-default" type="button" v-on="click: resluggifyTitle"><i class="fa fa-fw fa-refresh"></i></button>
                    </span>
                </div>

                <div class="form-group top-buffer" id="postContent">
                    <label for="content" class="sr-only">Content</label>
                    {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Content (Markdown/HTML)', 'v-model' => 'content']) !!} 
                    
                    <div class="panel panel-default top-buffer">
                    
                      <div class="panel-body" v-html="content | marked">
                       
                      </div>
                    </div>                   

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">

            <div class="panel-body">
                <div class="form-group">

                    {!! Form::label('published_at', 'Publish At') !!}
                    <div class="date datetimepickerx">
                        {!! Form::input('datetime-local', 'published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i:s') : date('Y-m-d\TH:i:s'), ['class' => 'form-control']) !!}

{{--                          {!! Form::text('published_at', null, ['class' => 'form-control']) !!}   
                        <span class="input-group-addon">
                            <span class="fa-calendar fa"></span>
                        </span> --}}
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

@section('admin.scripts')

@stop