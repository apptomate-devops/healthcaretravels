<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Auth;

class LoginCheck
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
        $user = $request->session()->get('user_id');
        if (!Auth::check()) {
            Session::flash('error_message', "Please Login to access application");
            return redirect()->intended('/');
        }
        return $next($request);
    }
}
