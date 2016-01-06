<?php

namespace Creuset\Http\Middleware;

use Closure;
use Validator;
use Creuset\Repositories\User\DbUserRepository;
use Creuset\User;
use Illuminate\Auth\Guard;
use Illuminate\Foundation\Validation\ValidatesRequests;

class DeriveUserForOrder
{
    use ValidatesRequests;

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
        $fields = $request->has('create_account') ? 
        ['email', 'password', 'password_confirmation'] : 
        ['email'];

        $billing_address = $request->get('billing_address');

        $data = $request->only($fields);
        $data['name'] = $billing_address['first_name'] . ' ' . $billing_address['last_name'];


        $this->validateInput($request);

        $user = $this->users->create(collect($data));
        $request->merge(['customer' => $user]);
        
        return $next($request);
    }

    protected function validateInput($request)
    {
        $rules = [
        'email'    => 'required|email|max:255|unique:users',
        ];

        if ($request->has('create_account')) {
            $rules['password'] = 'required|confirmed|min:6';
        }
        $this->validate($request, $rules);
    }
}
