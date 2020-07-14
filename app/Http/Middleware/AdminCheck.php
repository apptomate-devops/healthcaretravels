<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class AdminCheck
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
        $admin_email = $request->session()->get('admin_email');
        if (!$admin_email) {
            Session::flash('error_message', "Please Login to access application");
            return redirect()->intended('/admin');
        }
        return $next($request);
    }
}
