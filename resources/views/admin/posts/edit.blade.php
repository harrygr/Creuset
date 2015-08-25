@extends('admin.layouts.admin')

@section('title')
Edit Post
@stop

@section('admin.content')
<h1>Edit Post</h1>

@include('partials.errors')

<div class="row post-form" id="postForm">
    {!! Form::model($post, ['route' => ['admin.posts.update', $post->id], 'method' => 'PATCH']) !!}

    @include('admin.posts.form', ['submitText' => 'Update'])

    {!! Form::close() !!}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
            {!! Form::open(['route' => ['posts.image.store', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'attachImagesForm']) !!}
                {{ csrf_field() }}
            {!! Form::close() !!}
            </div>
      </div>
  </div>


</div>

<div>
    @foreach ($post->images as $image)
        <img src="/{{ $image->thumbnail_path }}" alt="">

    @endforeach
</div>
@stop

@section('admin.scripts')
  <script>
  Dropzone.options.attachImagesForm = {
    paramName: 'image',
    maxFilesize: 5, //5MB limit
    acceptedFiles: '.jpeg, .jpg, .png, .bmp, .gif, .svg'
  }
  </script>
  @stop