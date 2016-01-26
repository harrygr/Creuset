@extends('admin.layouts.admin')

@section('title')
Post Images
@stop

@section('heading')
Product Images
@stop

@section('admin.content')


<div class="top-buffer">
<cr-imageable-gallery imageable-url="{{ route('api.posts.images', $post->id) }}" v-ref:gallery></cr-imageable-gallery>
</div>

@include('partials.errors')

<div class="post-form" id="postForm">

    <div class="box box-primary">
      <div class="box-body">
        {!! Form::open(['route' => ['admin.posts.attach_image', $post], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'attachImagesForm']) !!}
        {{ csrf_field() }}
        {!! Form::close() !!}
      </div>
    </div>

</div>

@stop


@section('admin.scripts')
@parent
<script>
  Dropzone.options.attachImagesForm = {
    paramName: 'image',
    maxFilesize: 5, //5MB limit
    acceptedFiles: '.jpeg, .jpg, .png, .bmp, .gif, .svg',
    init: function()
    {
      this.on("complete", function(file) 
      { 
        this.removeFile(file);
        vm.$refs.gallery.fetchImages(); 

      });
    }
  }
</script>
@stop