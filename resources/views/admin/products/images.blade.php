@extends('admin.layouts.admin')

@section('title')
Product Images
@stop

@section('heading')
Product Images
@stop

@section('admin.content')

@include('partials.nav')

<div class="top-buffer">
<cr-imageable-gallery imageable-url="{{ route('api.products.images', $product->id) }}" v-ref:gallery></cr-imageable-gallery> 
</div>

@include('partials.errors')

<div class="post-form" id="postForm">

    <div class="box box-primary">
      <div class="box-body">
        {!! Form::open(['route' => ['admin.products.attach_image', $product], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'attachImagesForm']) !!}
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