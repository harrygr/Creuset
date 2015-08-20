@extends('admin.layouts.admin')

@section('title')
    User profile for {{ $user->name }}
@stop

@section('admin.content')
	<h1>Profile</h1>

	@include('partials.errors')

	<div class="panel panel-default">
		<div class="panel-body">
			{!! Form::model($user, ['route' => ['admin.users.update', $user->id], 'method' => 'PATCH']) !!}

				{!! Form::hidden('id') !!}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Name</label>
							{!! Form::text('name', null, ['class' => 'form-control']) !!}
						</div>
						
						<div class="form-group">
							<label for="username">Username</label>
							{!! Form::text('username', null, ['class' => 'form-control']) !!}
						</div>
						
						<div class="form-group">
							<label for="email">Email</label>
							{!! Form::email('email', null, ['class' => 'form-control']) !!}
						</div>
					</div>

					<div class="col-md-6">
						<legend>Update password. Leave blank if not updating</legend>
						
						<div class="form-group">
							<label for="password">Password</label>
							{!! Form::password('password', ['class' => 'form-control']) !!}
						</div>
						
						<div class="form-group">
							<label for="password_confirmation">Confirm Password</label>
							{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
						</div>
					</div>
				</div>

				<button class="btn btn-primary">Update Profile</button>
			{!! Form::close() !!}
		</div>
	</div>
@stop