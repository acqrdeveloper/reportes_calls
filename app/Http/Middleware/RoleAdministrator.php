<?php

namespace Cosapi\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class RoleAdministrator
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
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
        if(Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }
        return redirect('/errorRole');
    }
}
