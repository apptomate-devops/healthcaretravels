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
        //         print_r($request->terms_accept);exit;

        $name = $request->username;
        $fname = $request->first_name;
        $lname = $request->last_name;
        $mail = $request->email;
        $phone = $request->phone_no;
        $type = $request->user_type;

        $messages = [
            'required' => 'Please complete this field',
            'accepted' => 'Terms and Policy must be agreed',
            'same' => 'Password must match repeat password',
            'password1.regex' =>
                'Password should be at least 7 characters long and should contain at least 1 uppercase, 1 lowercase, 1 number, no special characters allowed',
            'email.regex' => 'This should be your business email',
            'website.regex' => 'Please enter valid URL',
        ];

        if ($request->user_type === "1") {
            // Owner
            $rules = [
                'username' => 'required|unique:users,username',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password1' => 'required|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{7,}$/i',
                'password2' => 'required|same:password1',
                'first_name' => 'required',
                'last_name' => 'required',
                'phone_no' => 'required',
                'dob' => 'required',
                'gender' => 'required',
                'occupation' => 'required',
                'address' => 'required',
                'listing_address' => 'required',
                'terms_accept' => 'accepted',
            ];
        } elseif ($request->user_type === "2") {
            // Travel Agency
            $rules = [
                'username' => 'required|unique:users,username',
                'email' =>
                    'required|email:rfc,dns|unique:users,email|regex:/^([\w\-.]+@(?!gmail.com)(?!yahoo.com)(?!hotmail.com)(?!yahoo.co.in)(?!aol.com)(?!abc.com)(?!xyz.com)(?!pqr.com)(?!rediffmail.com)(?!live.com)(?!outlook.com)(?!me.com)(?!msn.com)(?!ymail.com)([\w-]+\.)+[\w-]{2,4})?$/i',
                'password1' => 'required|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{7,}$/i',
                'password2' => 'required|same:password1',
                'first_name' => 'required',
                'last_name' => 'required',
                'phone_no' => 'required',
                'gender' => 'required',
                'occupation' => 'required',
                'work' => 'required',
                'work_title' => 'required',
                'website' => 'required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                'terms_accept' => 'accepted',
            ];
        } elseif ($request->user_type === "3") {
            // RV Traveler
            $rules = [
                'username' => 'required|unique:users,username',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password1' => 'required|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{7,}$/i',
                'password2' => 'required|same:password1',
                'first_name' => 'required',
                'last_name' => 'required',
                'phone_no' => 'required',
                'dob' => 'required',
                'gender' => 'required',
                'occupation' => 'required',
                'tax_home' => 'required',
                'address' => 'required',
                'terms_accept' => 'accepted',
            ];
        } else {
            // Traveler
            $rules = [
                'username' => 'required|unique:users,username',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password1' => 'required|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{7,}$/i',
                'password2' => 'required|same:password1',
                'first_name' => 'required',
                'last_name' => 'required',
                'phone_no' => 'required',
                'dob' => 'required',
                'gender' => 'required',
                'tax_home' => 'required',
                'address' => 'required',
                'terms_accept' => 'accepted',
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()
                ->with('username', $name)
                ->with('fname', $fname)
                ->with('lname', $lname)
                ->with('mail', $mail)
                ->with('phone', $phone)
                ->with('type', $type)
                ->with('selectedTab', 'tab2')
                ->with('terms_accept', $request->terms_accept)
                ->with('dob', $request->dob)
                ->with('gender', $request->gender)
                ->with('languages_known', $request->languages_known)
                ->with('tax_home', $request->tax_home)
                ->with('address', $request->address)
                ->with('listing_address', $request->listing_address)
                ->with('work', $request->work)
                ->with('work_title', $request->work_title)
                ->with('website', $request->website)
                ->withErrors($validator);
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
            'client_id' => $request->client_id,
            'role_id' => $role_id,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone_no,
            'date_of_birth' => $request->dob,
            'gender' => $request->gender,
            'languages_known' => $request->languages_known,
            'occupation' => $request->occupation,
            'occupation_desc' => $request->occupation_desc,
            'name_of_agency' => $request->name_of_agency,
            'tax_home' => $request->tax_home,
            'status' => 1,
            'address' => $request->address,
            'auth_token' => $token,
        ]);
        $d = DB::table('users')
            ->where('client_id', '=', $request->client_id)
            ->where('email', '=', $request->email)
            ->first();
        $request->session()->put('phone', $d->phone);
        $request->session()->put('user_id', $d->id);
        $request->session()->put('role_id', $d->role_id);
        $request->session()->put('username', $d->username);

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

        $isOTPSent = $this->sendOTPMessage($d->phone, $OTP);
        $update = DB::table('users')
            ->where('client_id', '=', CLIENT_ID)
            ->where('phone', '=', $d->phone)
            ->update(['otp' => $OTP]);

        $url = $this->get_base_url() . 'otp-verify-register';

        return redirect($url)
            ->with('mobile', $d->phone)
            ->with('OTP', $OTP);
    }

    public function view_otp_screen(Request $request)
    {
        return view('otp-verify-register');
    }
}
