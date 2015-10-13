@extends('admin.layouts.admin')

@section('title')
Posts
@stop

@section('admin.content')

<a href="{{route('admin.posts.create')}}" class="btn btn-success pull-right">New Post</a>

	<h1>{{$title or 'Posts'}}</h1>

	<div class="panel panel-default">
		<div class="panel-body">

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Author</th>
					<th>Categories</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($posts as $post)
				<tr>
					<td>
						<strong>{{ $post->title }}</strong> {!! $post->present()->statusLabel() !!}
						<div class="row-actions">
							<a href="{{ route('admin.posts.edit', [$post->id]) }}">Edit</a> |
							<a href="{{ route('admin.posts.delete', [$post->id]) }}" data-method="delete" data-confirm="Are you sure?" class="text-danger" rel="nofollow">Trash</a>
						</div>
					</td>
					<td>{{ $post->author->name }}</td>
					<td>{!! $post->present()->categoryList() !!}</td>
					<td>{{ $post->created_at }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>

		<!-- Pagination -->
		{!! $posts->render() !!}
		</div>
	</div>


@stop