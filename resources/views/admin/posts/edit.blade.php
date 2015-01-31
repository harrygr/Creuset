@extends('admin.layouts.admin')

@section('title')
Edit Post
@stop

@section('admin.content')
<h1>Edit Post</h1>

@include('partials.errors')

{!! Form::model($post, ['route' => ['admin.posts.update', $post->id], 'method' => 'PATCH']) !!}

<div class="row">
	@include('admin.posts.form')
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-body">
			{!! HTML::linkRoute('admin.posts.delete', 'Trash', [$post->id],[
				'class' => 'btn text-danger pull-left',
				'data-method' => 'delete',
				'data-confirm' => 'Are you sure?'
				]) !!}
			{!! Form::submit('Update', ['class' => 'btn btn-primary pull-right']) !!}
			</div>
			</div>
		</div>
	</div>
</div>

{!! Form::close() !!}
@stop