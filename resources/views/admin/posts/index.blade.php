@extends('layouts.admin')

@section('title')
Posts
@stop

@section('content')
<h1>Posts</h1>

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
					<a href="#">Delete</a>
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

@stop