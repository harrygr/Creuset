@extends('admin.layouts.admin')

@section('title')
Posts
@stop

@section('admin.content')
		<h1>{{$title or 'Posts'}} <a href="{{ route('admin.posts.create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Add New</a></h1>
	<div class="panel panel-default">
		<div class="panel-body">

		<table class="table table-striped table-bordered">
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
						<strong>{{ $post->title }}</strong>
						<div class="row-actions">
							<a href="{{ route('admin.posts.edit', [$post->id]) }}">Edit</a> |
							<a href="{{ route('admin.posts.delete', [$post->id]) }}" data-method="delete" data-confirm="Are you sure?" class="text-danger" rel="nofollow">Trash</a>
						</div>
					</td>
					<td>{{ $post->author->name }}</td>
					<td>

						{{ $post->present()->categoryList() }}

					</td>
					<td>
						{{ $post->created_at }}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{!! $posts->render() !!}
	</div>
	</div>


@stop