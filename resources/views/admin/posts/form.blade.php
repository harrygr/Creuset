    <div class="col-md-8">
        <div class="panel panel-default" id="postContent">
            <div class="panel-body">

                <div class="form-group">
                    <label for="title" class="sr-only">Title</label>
                    {!! Form::text('title', null, [
                        'class' => 'post-title-input', 
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

      <!-- Post images -->  
      <div class="panel panel-default" id="post-images">
          <div class="panel-heading">
              Attached Images
          </div>

        <div class="panel-heading" v-if="selectedImage.id">
            <div class="row">
                <div class="col-md-4">
                    <img class="media-object img-thumbnail" src="/@{{ selectedImage.thumbnail_path}}" alt=""> 
                </div>
                <div  class="col-md-8">
                        <p>
                        <strong>URL: </strong>
                        <input type="text" class="form-control input-sm" readonly value="{{ url() }}/@{{ selectedImage.path }}">
                        </p>    

                        {{-- </strong><code>{{ url() }}/@{{ selectedImage.path }}</code> --}}
                        <p>
                        <strong>Thumbnail: </strong>
                        <input type="text" class="form-control input-sm" readonly value="{{ url() }}/@{{ selectedImage.thumbnail_path }}">
                        </p>
                </div>
            </div>
        </div>
    <div class="panel-body">

      @if ($post->id)


      <span v-if="imagesLoading"><i class="fa fa-circle-o-notch fa-spin"></i> Loading images...</span>

      <div class="row" v-if="hasImages">
        <div class="col-md-3 col-sm-4 col-xs-6 top-buffer" v-repeat="image: images">
          <img src="@{{ '/' + image.thumbnail_path }}" alt="" class="img-responsive img-thumbnail selectable" v-class="selected: isSelected(image.id)" v-on="click: selectedImage = image">
      </div>
  </div>

  <span v-if="!hasImages">No Images yet</span>
  {{-- <pre>@{{ $data | json }}</pre> --}}
  @else
  Save the {{ $post->type }} to attach images
  @endif
</div>
</div>
</div>

<div class="col-md-4" id="postMeta">
    <div class="panel panel-default">

        <div class="panel-body">
            <div class="form-group">
                {!! Form::label('published_at', 'Publish At') !!}
                <div class="date">
                    {!! Form::input('datetime-local', 'published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i:s') : date('Y-m-d\TH:i:s'), ['class' => 'form-control']) !!}
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


        <div class="panel panel-default" id="postCategories">
            <div class="panel-heading">
                Categories
            </div>
            <input type="hidden" v-model="checkedCategories" value="{{ $post->categories->lists('id')->toJson() }}">

            <div class="panel-body">
                <div id="category-checkboxes">
                    <div class="checkbox" v-repeat="categories | orderBy 'checked' -1">
                        <label>
                            <input type="checkbox" name="terms[]" value="@{{ id }}" v-model="checked"> @{{ term }}
                        </label>
                    </div>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" v-model="newCategory" v-on="keydown:addCategory | key 'enter'" placeholder="New Category" v-attr="disabled: isLoadingCategories">
                    <span class="input-group-btn">
                        <button class="btn btn-default" v-on="click: addCategory" v-attr="disabled: isLoadingCategories"><i class="fa fa-fw @{{ addCatButtonClass }}"></i></button>
                    </span>
                </div>
                <div class="alert alert-danger top-buffer" v-show="addCategoryErrors.length"><p v-repeat="error: addCategoryErrors" v-text="error"></p></div>
            </div>
        </div>

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
    </div>


    @section('admin.scripts')
    @parent

    @if ($post->id)
    <script>
        postImageVm = new Vue({
            el: "#post-images",

            data: {
                images: [],
                selectedImage: {},
                imagesLoading: false
            },

            computed: {
                hasImages: function()
                {
                    return this.images.length > 0;
                }
            },

            ready: function()
            {
                this.fetchImages();
            },

            methods: {
                fetchImages: function()
                {
                    this.imagesLoading = true;

                    this.$http.get('{{ route('api.posts.images', $post->id) }}').success(function(response)
                    {
                        this.images = response;
                        this.imagesLoading = false;

                    });

                },
                isSelected: function(id)
                {
                    return this.selectedImage.id == id;
                }
            }
        });
    </script>
    @endif
    @stop