<?php

namespace Creuset\Http\Middleware;

use Closure;
use Validator;
use Creuset\Repositories\User\DbUserRepository;
use Creuset\User;
use Illuminate\Auth\Guard;

class DeriveUserForOrder
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;
    
    private $users;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     *
     * @return void
     */
    public function __construct(Guard $auth, DbUserRepository $users)
    {
        $this->auth = $auth;
        $this->users = $users;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // The user is already logged in, use them in the request
        if ($this->auth->check())
        {
            $request->merge(['customer' => $this->auth->user()]);
            return $next($request);
        }

        // The email address has an account
        if ($user = User::where('email', $request->email)->first()) {
            // They were auto-created so we can't ask them to login. Just use their account for the order
            if ($user->auto_created) {
                $request->merge(['customer' => $user]);
                return $next($request);
            }

            // Ask them to login for the order
            \Session::put('url.intended', 'checkout');
            return redirect()
            ->route('auth.login', ['email' => $request->email])
            ->with([
                   'alert' => 'This email has an account here. Please login. If you do not know your password please reset it.',
                   'alert-class' => 'warning',
                   ]);
        }

        // They haven't made an account yet
        $fields = $request->has('create_account') ? ['email', 'name', 'password', 'password_confirmation'] : ['email', 'name'];
        $data = $request->only($fields);
        $validator = $this->validator($data, $request->has('create_account'));

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        }

        $user = $this->users->create(collect($data));
        $request->merge(['customer' => $user]);
        return $next($request);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data, $password_required = true)
    {
        $rules = [
        'name'     => 'required|max:255',
        'email'    => 'required|email|max:255|unique:users',
        ];

        if ($password_required) {
            $rules['password'] = 'required|confirmed|min:6';
        }

        return Validator::make($data, $rules);
    }
}
