<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Auth;
use URL;

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
            Session::put('url.intended', URL::full());
            return redirect('login')->with([
                'error' => 'You need to be authenticated to access the page',
            ]);
        }
        return $next($request);
    }
}
