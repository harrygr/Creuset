@extends('admin.layouts.admin')

@section('title')
Pages
@stop

@section('heading')
{{ $title or 'Pages' }}
@stop

@section('admin.content')

<p><a href="{{route('admin.pages.create')}}" class="btn btn-success pull-right">New Page</a></p>

<p><a href="{{ route('admin.pages.index') }}">All</a> | <a href="{{ route('admin.pages.trash') }}">Trash</a></p>
	<div class="box box-primary clearfix">
		<div class="box-body">

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Author</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($pages as $page)
				<tr>
					<td>
					{{ str_repeat('- ', $page->getDepth()) }}
						<strong>{{ $page->title }}</strong> {{ $page->present()->statusLabel() }}
						<div class="row-actions">
							{{ $page->present()->indexLinks() }}
						</div>
					</td>
					<td>{{ $page->author->name }}</td>
					<td>{{ $page->created_at }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>

		<!-- Pagination -->
		{!! $pages->render() !!}
		</div>
	</div>


@stop