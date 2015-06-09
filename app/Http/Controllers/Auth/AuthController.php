<?php

namespace Creuset\Http\Controllers\Auth;

use Creuset\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Validator;
use Creuset\User;

class AuthController extends Controller {

	use AuthenticatesAndRegistersUsers;

	protected $redirectTo = '/';

	/**
	 * Create a new authentication controller instance.
	 *
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}



	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		if (\Auth::attempt($credentials, $request->has('remember')))
		{
			return redirect()->intended(route('admin.posts.index'));
		}

		return \Redirect::route('auth.login')
					->withInput($request->only('email'))
					->withErrors([
						'email' => 'These credentials do not match our records.',
					]);
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param \Illuminate\Foundation\Http\FormRequest|Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$validator = $this->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$this->auth->login($this->create($request->all()));

		return redirect($this->redirectPath());
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);
	}

}
