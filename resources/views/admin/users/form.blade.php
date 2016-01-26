
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

				<div class="form-group">
					<label for="password">Password</label>
					@if($user->id)
					<span class="help-text small text-muted">(Leave blank to leave unchanged)</span>
					@endif
					{!! Form::password('password', ['class' => 'form-control']) !!}
				</div>
				
				<div class="form-group">
					<label for="password_confirmation">Confirm Password</label>
					{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
				</div>

				@if (true or Auth::user()->can('edit_user'))
				<div class="form-group ">
					<label for="roles">Role</label>
					{!! Form::select('role_id', $roles, $user->role_id, ['class' => 'form-control']) !!}
				</div>
				@endif

			</div>
		</div>

		<button class="btn btn-primary">{{ $submit_text or 'Submit' }}</button>
