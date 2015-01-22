@extends('layouts.admin')

@section('title')
Edit Post
@stop

@section('content')
<h1>Edit Post</h1>

@include('partials.errors')

{!! Form::model($post, ['route' => ['admin.posts.update', $post->id], 'method' => 'PATCH']) !!}

{!! Form::hidden('id', $post->id) !!}
<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			{!! Form::text('title', null, ['class' => 'form-control input-lg']) !!}
		</div>
		<div class="form-group">
			{!! Form::text('slug', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::textarea('content', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="col-md-4">
			{!! HTML::linkRoute('admin.posts.delete', 'Delete Post', [$post->id],['class' => 'btn btn-link text-danger pull-left']) !!}
			{!! Form::submit('Update', ['class' => 'btn btn-primary pull-right']) !!}
	</div>
</div>
{!! Form::close() !!}
@stop