<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DateTime;

class SessionTimeOut
{
    public function __construct()
    {
        $this->redirectUrl = 'login';
        $this->sessionLabel = 'error';
        $this->lifetime = (config('session.lifetime') ?: 60) - 1;
        $this->ignoreURLs = ['check_verified'];
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
        $isIgnored = in_array($request->path(), $this->ignoreURLs);
        if (!$isIgnored && Auth::check()) {
            if (!$request->session()->has('lastActivityTime')) {
                $request->session()->put('lastActivityTime', new DateTime());
            }
            $diff = (new DateTime())->diff($request->session()->get('lastActivityTime'));
            if ($diff->i >= $this->lifetime) {
                $request->session()->flush();
                Auth::logout();
                return redirect($this->redirectUrl)->with([
                    $this->sessionLabel =>
                        'You have been inactive for ' . $this->lifetime . ' minutes. Please log back in to continue.',
                ]);
            }
            $request->session()->put('lastActivityTime', new DateTime());
            $request->session()->save();
        }
        return $next($request);
    }
}
