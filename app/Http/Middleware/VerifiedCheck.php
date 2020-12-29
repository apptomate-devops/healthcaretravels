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

        $role_id = $request->session()->get('role_id');

        $is_owner_route = strpos($request->path(), 'owner/');
        $is_traveler_route = strpos($request->path(), 'traveler/');
        if ($is_owner_route !== false) {
            if (!in_array($role_id, [1, 4])) {
                return response()->view('general_error', [
                    'message' => 'Sorry, you are not able to access this feature.',
                    'hideImage' => true,
                    'title' => 'Oops!',
                ]);
            }
        }
        if ($is_traveler_route !== false) {
            if (!in_array($role_id, [0, 2, 3])) {
                return response()->view('general_error', [
                    'message' => 'Sorry, you are not able to access this feature.',
                    'hideImage' => true,
                    'title' => 'Oops!',
                ]);
            }
        }
        return $next($request);
    }
}
