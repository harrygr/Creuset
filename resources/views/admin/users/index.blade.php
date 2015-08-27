@extends('admin.layouts.admin')

@section('title')
Users
@stop

@section('admin.content')

<a href="{{route('admin.users.create')}}" class="btn btn-success pull-right">New User</a>
<h1>Users</h1>

@include('partials.errors')


<div class="panel panel-default">
	<div class="panel-body">


		<table class="table table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Username</th>
					<th>Name</th>
					<th>email</th>
					<th>Role</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $user)
				<tr>
					<td><img class="img-circle" src="{{ $user->present()->avatar() }}" alt="Avatar for {{ $user->name }}"></td>
					<td>
						<strong>{{ $user->username }}</strong>
						<br>
						<small class="text-muted">Last seen: {{ $user->last_seen_at ? $user->last_seen_at->diffForHumans() : "never" }}</small>

						<div class="row-actions">
							<a href="{{ route('admin.users.edit', $user->username) }}">Edit</a> | 
							<a href="" data-method="delete" data-confirm="Are you sure?" class="text-danger" rel="nofollow">Delete</a>
						</div>

					</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->role->display_name }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>
</div>




@stop