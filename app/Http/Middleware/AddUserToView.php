<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AddUserToView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = null;
        $isAdmin = false;
        if (Auth::check()) {
            $user = Auth::user();
            $isAdmin = Auth::user()->isAdmin();
        }

        view()->share(compact('isAdmin', 'user'));

        return $next($request);
    }
}
