<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EmailConfig;
use App\Models\Users;
use DB;
use Log;
use Mail;

class UserController extends BaseController
{
    public function check_email($email, $client_id)
    {
        $check = DB::table('users')
            ->where('client_id', '=', $client_id)
            ->where('email', '=', $email)
            ->count();
        if ($check != 0) {
            return response()->json(['status' => 'Failure']);
        } else {
            return response()->json(['status' => 'Success']);
        }
    }

    public function check_phone($phone_no, $client_id)
    {
        $check = DB::table('users')
            ->where('client_id', '=', $client_id)
            ->where('phone', '=', $phone_no)
            ->count();
        if ($check != 0) {
            return response()->json(['status' => 'Failure']);
        } else {
            return response()->json(['status' => 'Success']);
        }
    }

    public function login(Request $request)
    {
        $constants = $this->constants();

        $agency = DB::table('agency')->get();
        $occupation = DB::table('occupation')->get();
        $data = [];
        return view('login', [
            'constants' => $constants,
            'agency' => $agency,
            'data' => $data,
            'occupation' => $occupation,
        ]);
    }

    public function register_user(Request $request)
    {
        // print_r($request->all());exit;

        $name = $request->username;
        $fname = $request->first_name;
        $lname = $request->last_name;
        $dob = $request->dob;
        $mail = $request->email;
        $phone = $request->phone_no;
        $type = $request->user_type;

        $check = DB::table('users')
            ->where('client_id', '=', $request->client_id)
            ->where('email', '=', $request->email)
            ->get();
        if (!$check) {
            return back()
                ->with('error', 'Email already exists try login')
                ->with('name', $name)
                ->with('fname', $fname)
                ->with('lname', $lname)
                ->with('mail', $mail)
                ->with('phone', $phone)
                ->with('type', $type);
        }
        if ($request->user_type == 0) {
            $validator = Validator::make($request->all(), [
                //'username' => 'required|unique:users,username',
                'first_name' => 'required',
                'last_name' => 'required',
                'dob' => 'required',
                // 'occupation' => 'required',
                'password1' => 'required|min:4',
                'password2' => 'required|same:password1',
                'email' => 'required|unique:users,email',
            ]);
        }
        if ($request->user_type == 1) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'dob' => 'required',
                // 'address' => 'required',
                // 'username' => 'required|unique:users,username',
                'password1' => 'required|min:4',
                'password2' => 'required|same:password1',
                'email' => 'required|unique:users,email',
            ]);
        }
        if ($request->user_type == 2) {
            $validator = Validator::make($request->all(), [
                //'username' => 'required|unique:users,username',
                'password1' => 'required|min:4',
                'name_of_agency' => 'required',
                // 'address' => 'required',
                'password2' => 'required|same:password1',
                'email' => 'required|unique:users,email',
            ]);
        }

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            return back()
                ->with('error', $error_messages)
                ->with('name', $name)
                ->with('fname', $fname)
                ->with('lname', $lname)
                ->with('mail', $mail)
                ->with('phone', $phone)
                ->with('name', $type);
        }

        if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{7,}$/', $request->password1)) {
            return back()
                ->with('error', 'Password atleast 7 characters and 1 upper 1 lower and 1 number')
                ->with('name', $name)
                ->with('fname', $fname)
                ->with('lname', $lname)
                ->with('mail', $mail)
                ->with('phone', $phone)
                ->with('type', $type);
        }

        $password = $this->encrypt_password($request->password1);

        $role_id = $request->user_type;
        if ($request->name_of_agency != "") {
            $chk = DB::table('agency')
                ->where('name', $request->name_of_agency)
                ->count();
            if ($chk == 0) {
                DB::table('agency')->insert(['name' => $request->name_of_agency]);
            }
        }
        $token = $this->generate_random_string();
        $mobile = $request->phone_no;
        $insert = DB::table('users')->insert([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'client_id' => $request->client_id,
            'email' => $request->email,
            'phone' => $request->phone_no,
            'date_of_birth' => $request->dob,
            'occupation_desc' => $request->occupation_desc,
            'password' => $password,
            'role_id' => $role_id,
            'status' => 1,
            'address' => $request->address,
            'occupation' => $request->occupation,
            'name_of_agency' => $request->name_of_agency,
            'auth_token' => $token,
        ]);
        $d = DB::table('users')
            ->where('client_id', '=', $request->client_id)
            ->where('email', '=', $request->email)
            ->first();
        $request->session()->put('phone', $d->phone);
        $request->session()->put('user_id', $d->id);
        $request->session()->put('role_id', $d->role_id);
        $request->session()->put('username', $d->first_name . " " . $d->last_name);

        $verify_url = BASE_URL . 'verify/' . $d->id . '/' . $token;

        $reg = EmailConfig::where('type', 2)->first();

        $mail_data = [
            'token' => $token,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'url' => $verify_url,
            'text' => isset($reg->message) ? $reg->message : '',
        ];

        $title = isset($reg->title) ? $reg->title : 'Message from ' . APP_BASE_NAME;
        $subject = isset($reg->subject) ? $reg->subject : "Email verification from " . APP_BASE_NAME;
        $this->send_custom_email($request->email, $subject, 'mail.email-verify', $mail_data, $title);

        //  Send Welcome mail

        $welcome = EmailConfig::where('type', 1)
            ->where('role_id', $d->role_id)
            ->first();

        $mail_data = [
            'username' => $request->first_name . ' ' . $request->last_name,
            'text' => isset($welcome->message) ? $welcome->message : '',
        ];

        $title = isset($welcome->title) ? $welcome->title : 'Welcome to ' . APP_BASE_NAME;
        $subject = isset($welcome->subject) ? $welcome->subject : "Welcome to " . APP_BASE_NAME;

        $this->send_custom_email($request->email, $subject, 'mail.welcome-mail', $mail_data, $title);

        $OTP = rand(1111, 9999);

        $this->sendSms($d->phone, $OTP);
        $update = DB::table('users')
            ->where('client_id', '=', CLIENT_ID)
            ->where('phone', '=', $d->phone)
            ->update(['otp' => $OTP]);

        $url = $this->get_base_url() . 'otp-verify-register';

        return redirect($url)
            ->with('mobile', $d->phone)
            ->with('OTP', $OTP);
    }
}
