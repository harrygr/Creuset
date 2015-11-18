<?php

namespace Creuset\Http\Controllers\Auth;

use Creuset\Http\Controllers\Controller;
use Creuset\User;
use Illuminate\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends Controller {

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    private $auth;

	protected $redirectTo = '/';

	/**
	 * Create a new authentication controller instance.
	 *
	 */
	public function __construct(Guard $auth)
	{
		$this->middleware('guest', ['except' => 'getLogout']);
		$this->auth = $auth;
	}



	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	// public function postLogin(Request $request)
	// {
	// 	$this->validate($request, [
	// 		'username' => 'required', 'password' => 'required',
	// 	]);

	// 	// Attempt logging in with username first, or email if that fails
	// 	if ( \Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->has('remember')) or
	// 		 \Auth::attempt(['email' => $request->username, 'password' => $request->password], $request->has('remember')))
	// 	{
	// 		return redirect()->intended(route('admin.posts.index'));
	// 	}

	// 	return \Redirect::route('auth.login')
	// 				->withInput($request->only('email'))
	// 				->withErrors([
	// 					'username' => 'These credentials do not match our records.',
	// 				]);
	// }

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
			'username' => $data['username'],
			'password' => bcrypt($data['password']),
		]);
	}


    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return route('auth.login');
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route('admin.posts.index');
    }

}
