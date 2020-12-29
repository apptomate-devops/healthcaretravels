<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Auth;

class VerifiedCheck
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
        $is_verified = $request->session()->get('is_verified');
        if (!$is_verified) {
            return response()->view('general_error', [
                'message' => 'You must verify your identity before using this feature.',
                'url' => '/verify-account',
                'buttonText' => 'Verify Account',
                'hideImage' => true,
                'title' => 'Oops!',
            ]);
        }
        $is_owner_route = strpos($request->path(), 'owner/');
        if ($is_owner_route !== false) {
            $role_id = $request->session()->get('role_id');
            if (!in_array($role_id, [1, 4])) {
                return response()->view('general_error', [
                    'message' => 'You must be owner/co-host to access this feature.',
                    'hideImage' => true,
                    'title' => 'Oops!',
                ]);
            }
        }
        return $next($request);
    }
}
