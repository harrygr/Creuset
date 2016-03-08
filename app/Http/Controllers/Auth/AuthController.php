<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    private $auth;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->auth = $auth;
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin(Request $request)
    {
        if ($request->session()->has('url.intended')) {
            $request->session()->flash('url.intended', $request->session()->get('url.intended'));
        }

        return view('auth.login');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Foundation\Http\FormRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
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
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    public function create(array $data)
    {
        return User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'username'     => $data['username'],
            'password'     => $data['password'],
            'last_seen_at' => new \DateTime(),
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
        return '/';
    }
}
