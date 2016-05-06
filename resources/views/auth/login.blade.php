@extends('layouts.main')

@section('content')

	@include('partials.alert')
	@include('partials.errors')
	<h1 class="text-center">Login</h1>

	<form class="form-horizontal" role="form" method="POST" action="{{ route('auth.login') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<div class="form-group">
			<label class="col-md-4 control-label">E-Mail Address</label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="email" value="{{ old('email', Request::get('email')) }}">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Password</label>
			<div class="col-md-6">
				<input type="password" class="form-control" name="password">
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="remember"> Remember Me
					</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
					Login
				</button>

				<a href="/password/email">Forgot Your Password?</a>
			</div>
		</div>
	</form>


@endsection
