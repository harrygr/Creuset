<div class="row post-form" id="postForm">

    <div class="col-md-8" id="postContent">
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
                        <button class="btn btn-default" type="button" v-on="click: sluggifyTitle"><i class="fa fa-fw fa-refresh"></i></button>
                    </span>
                </div>

                <div class="form-group top-buffer" id="postContent">
                    <label for="content" class="sr-only">Content</label>
                    {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Content (Markdown/HTML)', 'v-model' => 'content']) !!} 
                    
                    <div class="panel panel-default top-buffer">                    
                      <div class="panel-body" v-html="content | marked"></div>
                  </div>                   

              </div>
          </div>
      </div>
  </div>

  <div class="col-md-4" id="postMeta">
    <div class="panel panel-default">

        <div class="panel-body">
            <div class="form-group">

                {!! Form::label('published_at', 'Publish At') !!}
                <div class="date datetimepickerx">
                    {!! Form::input('datetime-local', 'published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i:s') : date('Y-m-d\TH:i:s'), ['class' => 'form-control']) !!}
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


        <div class="panel panel-default" id="postCategories">
            <div class="panel-heading">
                Categories
            </div>
            <input type="hidden" v-model="checkedCategories" value="{{ $post->categories->lists('id')->toJson() }}">

            <div class="panel-body">
                <div class="checkbox" v-repeat="category: categories">
                    <label>
                        <input type="checkbox" name="terms[]" value="@{{ category.id }}" v-model="category.checked"> @{{ category.term }}
                        <code>@{{ category.checked }}</code>
                    </label>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" v-model="newCategory" v-on="keyup:addCategory | key 'enter'" placeholder="New Category">
                    <span class="input-group-btn">
                        <button class="btn btn-default" v-on="click: addCategory">Add Category</button>
                    </span>
                </div>
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