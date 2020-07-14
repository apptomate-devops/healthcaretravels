<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

use Validator;

use Log;

use DB;

class headerValidate
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
        //        getallheaders()['clientId'] = $request->header('clientId');
        //        getallheaders()['authId'] = $request->header('authId');
        //        getallheaders()['authToken'] = $request->header('authToken');$_SERVER['HTTP_X_HARDIK']

        //        getallheaders()['clientId'] = getallheaders()['clientId'];
        //        getallheaders()['authId'] = getallheaders()['authId'];
        //        getallheaders()['authToken'] = getallheaders()['authToken'];

        $errors = [];
        $errors['status'] = 'FAILED';

        $temp = 1;

        if (!isset(getallheaders()['clientId'])) {
            $errors['error_message'] = 'Client id should not be null';
            //return $errors;
            $temp = 0;
        }
        if (!isset(getallheaders()['authId'])) {
            $errors['error_message'] = 'auth id should not be null';
            //return $errors;
            $temp = 0;
        }
        if (!isset(getallheaders()['authToken'])) {
            $errors['error_message'] = 'auth token should not be null';
            //return $errors;
            $temp = 0;
        }
        $check = DB::table('client_settings')
            ->where('client_id', '=', getallheaders()['clientId'])
            ->first();
        if (count($check) == 0) {
            $errors['error_message'] = 'Wrong client id provided';
            //return $errors;
            $temp = 0;
        }
        $check_auth = DB::table('users')
            ->where('client_id', '=', getallheaders()['clientId'])
            ->where('id', getallheaders()['authId'])
            ->where('auth_token', getallheaders()['authToken'])
            ->first();
        if (count($check_auth) == 0) {
            $errors['error_message'] = 'Auth id , Auth token doesn`t match';
            //return $errors;
            $temp = 0;
        }
        if ($temp == 0) {
            return $errors;
        } else {
            return $next($request);
        }
    }
}
