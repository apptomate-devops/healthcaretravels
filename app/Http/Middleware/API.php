<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Closure;
use DB;

class API
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
        $auth_id = $request->header('authId');
        $client_id = $request->header('clientId');
        $auth_token = $request->header('authToken');
        $check = self::auth_check($client_id, $auth_id, $auth_token);
        if ($check != 1) {
            return response()->json($check);
        } else {
            return $next($request);
        }
    }

    public function auth_check($client_id, $auth_id, $auth_token)
    {
        $errors = [];
        $errors['status'] = 'FAILED';

        if (!$client_id) {
            $errors['error_message'] = 'Client id should not be null';
            return $errors;
        }
        if (!$auth_id) {
            $errors['error_message'] = 'auth id should not be null';
            return $errors;
        }
        if (!$auth_token) {
            $errors['error_message'] = 'auth token should not be null';
            return $errors;
        }
        $auth_token = (int) $auth_token;
        LOG::info("client_id is : " . $client_id);
        LOG::info("Auth id : " . $auth_id);
        LOG::info("auth_token is : " . $auth_token);
        $check = DB::table('client_settings')
            ->where('client_id', '=', $client_id)
            ->first();
        if (!$check) {
            $errors['error_message'] = 'Wrong client id provided';
            return $errors;
        }
        $check_auth = DB::table('users')
            ->where('client_id', '=', $client_id)
            ->where('id', $auth_id)
            ->where('auth_token', $auth_token)
            ->first();
        if (isset($check_auth->id)) {
        } else {
            // $errors['error_message'] = 'Auth id , Auth token doesn`t match';
            // return $errors;
        }
        return 1;
    }
}
