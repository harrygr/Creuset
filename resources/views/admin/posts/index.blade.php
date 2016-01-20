@extends('admin.layouts.admin')

@section('title')
Posts
@stop

@section('heading')
{{ $title or 'Posts' }}
@stop

@section('admin.content')

<p><a href="{{route('admin.posts.create')}}" class="btn btn-success pull-right">New Post</a></p>

	<p><a href="{{ route('admin.posts.index') }}">All</a> ({{ $postCount }}) | <a href="{{ route('admin.posts.trash') }}">Trash</a> ({{ $trashedCount }})</p>

	<div class="box box-primary">
		<div class="box-body">

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
						<strong>{{ $post->title }}</strong> {{ $post->present()->statusLabel() }}
						<div class="row-actions">
							{{ $post->present()->indexLinks() }}
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