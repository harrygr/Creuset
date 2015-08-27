@extends('admin.layouts.admin')

@section('title')
Edit Post
@stop

@section('admin.content')
<h1>Edit Post</h1>

@include('partials.errors')

<div class="post-form" id="postForm">
    {!! Form::model($post, ['route' => ['admin.posts.update', $post->id], 'method' => 'PATCH']) !!}

    @include('admin.posts.form', ['submitText' => 'Update'])

    {!! Form::close() !!}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css">
    <div class="">
        <div class="panel panel-default">
            <div class="panel-body">
            {!! Form::open(['route' => ['posts.image.store', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'attachImagesForm']) !!}
                {{ csrf_field() }}
            {!! Form::close() !!}
            </div>
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
          postImageVm.fetchImages(); 

      });
    }
  }
  </script>
  @stop