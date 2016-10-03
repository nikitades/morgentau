<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class DenyAccessIfIsNotAdmin
{
    /**
     * Create a new filter instance.
     *
     * @param Guard|\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        $user = \Auth::user();
        if (!$user->admin) {
            if ($this->auth->check()) {
                return redirect('/');
            } else {
                return redirect('/login');
            }
        }
        return $next($request);

    }
}