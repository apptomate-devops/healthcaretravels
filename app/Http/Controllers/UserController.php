<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
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

    public function email_send()
    {
        return view('email-send');
    }

    public function email_verify($id, $token, Request $request)
    {
        $count = DB::table('users')
            ->where('id', $id)
            ->count();
        if ($count != 0) {
            $d = DB::table('users')
                ->where('id', $id)
                ->where('auth_token', $token)
                ->first();
            DB::table('users')
                ->where('id', $id)
                ->where('auth_token', $token)
                ->update(['email_verified' => ONE]);
            $url = $this->get_base_url() . 'login';
            return redirect($url)->with('success', 'Your email is verified, please login to continue');
        } else {
            $url = $this->get_base_url() . 'login';
            return redirect($url);
        }
    }

    public function get_phone_number($user_id)
    {
        $check = DB::table('users')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', '=', $user_id)
            ->first();
        if ($check && isset($check->phone)) {
            return response()->json(['status' => 'Success', 'phone_number' => $check->phone]);
        } else {
            return response()->json(['status' => 'Failure']);
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
    public function login_user(Request $request)
    {
        if ($request->phone_no) {
            $request->username = $request->username;

            $check = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('email', '=', $request->username)
                ->first();

            if ($check) {
                if ($check->otp_verified != 1) {
                    $OTP = rand(1111, 9999);
                    // send otp
                    $this->sendOTPMessage($request->phone, $OTP);
                    $update = DB::table('users')
                        ->where('client_id', '=', CLIENT_ID)
                        ->where('phone', '=', $check->phone)
                        ->update(['otp' => $OTP]);

                    $check = DB::table('users')
                        ->where('client_id', '=', CLIENT_ID)
                        ->where('phone', '=', $check->phone)
                        ->first();

                    $url = $this->get_base_url() . 'otp-verify-register';

                    return redirect($url)->with('phone', $check->phone);
                }
            } else {
                return back()->with('error', 'This Email is not registered');
            }
        }
        Log::info("Login with user hitted at :" . date('d-m-Y H:i:s'));
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:4',
        ]);

        $check = DB::table('users')
            ->where('client_id', '=', $request->client_id)
            ->where('email', '=', $request->username)
            ->first();
        if ($check) {
            $password = $this->encrypt_password($request->password);
            if ($check->password !== $password) {
                return back()->with('error', 'You have entered the wrong email or password. Please Try again.');
            }
            if ($check->profile_image) {
                $request->session()->put('profile_image', $check->profile_image);
            }
            $request->session()->put('user_id', $check->id);
            $request->session()->put('is_verified', $check->is_verified);
            $request->session()->put('role_id', $check->role_id);
            $request->session()->put('username', $check->username);
            $request->session()->put('name_of_agency', $check->name_of_agency);
            $request->session()->put('phone', $check->phone);
            $request->session()->put('profile_image', BASE_URL . 'user_profile_default.png');

            if ($check->otp_verified != 1) {
                $OTP = rand(1111, 9999);
                // send otp
                $this->sendOTPMessage($check->phone, $OTP);

                $update = DB::table('users')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('phone', '=', $check->phone)
                    ->update(['otp' => $OTP]);

                $check = DB::table('users')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('phone', '=', $check->phone)
                    ->first();

                $url = $this->get_base_url() . 'otp-verify-register';
                return redirect($url)
                    ->with('phone', $check->phone)
                    ->with('user_id', $check->id);
            }
            // return redirect($url)->with('mobile',$check->phone);
            // }else{
            //     $url = $this->get_base_url() . 'owner/profile';
            // }

            if ($check->email_verified != 1) {
                $d = DB::table('users')
                    ->where('client_id', '=', $request->client_id)
                    ->where('email', '=', $check->email)
                    ->first();
                $token = $check->auth_token;

                $verify_url = BASE_URL . 'verify/' . $d->id . '/' . $token;

                $reg = EmailConfig::where('type', 2)->first();

                $mail_data = [
                    'token' => $token,
                    'name' => $check->first_name . ' ' . $check->last_name,
                    'email' => $check->email,
                    'url' => $verify_url,
                    'text' => isset($reg->message) ? $reg->message : '',
                ];

                $title = isset($reg->title) ? $reg->title : 'Message from ' . APP_BASE_NAME;
                $subject = isset($reg->subject) ? $reg->subject : "Email verification from " . APP_BASE_NAME;
                $this->send_custom_email($check->email, $subject, 'mail.email-verify', $mail_data, $title);
                $request->session()->flush();
                $url = $this->get_base_url() . 'email-send';
                return redirect($url)->with('phone', $check->phone);
            }

            $request->session()->put('profile_image', $check->profile_image);

            if ($check->is_submitted_documents == 0) {
                $url = $this->get_base_url() . 'verify-account';
            } else {
                $url = $this->get_base_url() . 'owner/profile';
            }
            if ($request->session()->get('propertyId')) {
                $property_id = $request->session()->get('propertyId');
                $url = $this->get_base_url() . 'property/' . $property_id;
            }

            return redirect($url)->with('phone', $check->phone);
        } else {
            return back()->with('error', 'This email is not registered.');
        }
    }

    public function verify_recaptcha(Request $request)
    {
        $client = new Client();
        $res = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => RECAPTCHA_SECRET_KEY,
                'response' => $request->token,
            ],
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $response = json_decode($res->getBody()->getContents());
        return response()->json($response);
    }

    public function add_another_agency($agency_name)
    {
        $added = DB::table('agency')->updateOrInsert(
            [
                'name' => $agency_name,
            ],
            [
                'name' => $agency_name,
                'status' => 0,
            ],
        );

        if ($added) {
            return response()->json([
                'success' => true,
                'message' => 'Agency listed successfully!!!',
                'agency_name' => $agency_name,
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Error while listing agency!!!']);
        }
    }

    public function register_user(Request $request)
    {
        //                 print_r($request->all());exit;

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
                'Password should be at least 8 characters long and should contain at least 1 uppercase, 1 lowercase, 1 number and 1 special character',
            'email.regex' => 'This should be your business email',
            'website.regex' => 'Please enter valid URL',
            'numeric' => 'Please enter valid phone number',
            'digits' => 'Please enter valid phone number',
        ];

        if ($request->user_type === "1") {
            // Owner
            $rules = [
                'username' => 'required|unique:users,username',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password1' =>
                    'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#^_+=:;><~$!%*?&])[A-Za-z\d@#^_+=:;><~$!%*?&]{8,}$/i',
                'password2' => 'required|same:password1',
                'first_name' => 'required',
                'last_name' => 'required',
                'ethnicity' => 'required',
                'phone_no' => 'required|numeric|digits:10',
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
                'password1' =>
                    'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#^_+=:><~$!%*?&])[A-Za-z\d@#^_+=:><~$!%*?&]{8,}$/i',
                'password2' => 'required|same:password1',
                'first_name' => 'required',
                'last_name' => 'required',
                'ethnicity' => 'required',
                'phone_no' => 'required|numeric|digits:10',
                'gender' => 'required',
                'dob' => 'required',
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
                'password1' =>
                    'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#^_+=:><~$!%*?&])[A-Za-z\d@#^_+=:><~$!%*?&]{8,}$/i',
                'password2' => 'required|same:password1',
                'first_name' => 'required',
                'last_name' => 'required',
                'ethnicity' => 'required',
                'phone_no' => 'required|numeric|digits:10',
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
                'password1' =>
                    'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#^_+=:><~$!%*?&])[A-Za-z\d@#^_+=:><~$!%*?&]{8,}$/i',
                'password2' => 'required|same:password1',
                'first_name' => 'required',
                'last_name' => 'required',
                'ethnicity' => 'required',
                'phone_no' => 'required|numeric|digits:10',
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
                ->with('ethnicity', $request->ethnicity)
                ->with('mail', $mail)
                ->with('phone', $phone)
                ->with('type', $type)
                ->with('selectedTab', 'tab2')
                ->with('terms_accept', $request->terms_accept)
                ->with('dob', $request->dob)
                ->with('gender', $request->gender)
                ->with('occupation', $request->occupation)
                ->with('name_of_agency', $request->name_of_agency)
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
            'ethnicity' => $request->ethnicity,
            'phone' => $request->phone_no,
            'date_of_birth' => $request->dob,
            'gender' => $request->gender,
            'languages_known' => $request->languages_known,
            'occupation' => $request->occupation,
            'name_of_agency' => $request->name_of_agency,
            'tax_home' => $request->tax_home,
            'address' => $request->address,
            'listing_address' => $request->listing_address,
            'status' => 1,
            'work' => $request->work,
            'work_title' => $request->work_title,
            'website' => $request->website,
            'auth_token' => $token,
        ]);
        $d = DB::table('users')
            ->where('client_id', '=', $request->client_id)
            ->where('email', '=', $request->email)
            ->first();

        //        $request->session()->put('phone', $d->phone);
        //        $request->session()->put('role_id', $d->role_id);
        $request->session()->put('username', $d->username);
        $request->session()->put('user_id', $d->id);
        $request->session()->put('is_verified', $d->is_verified);

        //  Send Welcome mail

        $welcome = EmailConfig::where('type', 1)->first();

        $mail_data = [
            'username' => $request->first_name . ' ' . $request->last_name,
            'text' => isset($welcome->message) ? $welcome->message : '',
            'email' => $request->email,
            'phone' => $d->phone,
        ];

        $title = isset($welcome->title) ? $welcome->title : 'Welcome to ' . APP_BASE_NAME;
        $subject = isset($welcome->subject) ? $welcome->subject : "Welcome to " . APP_BASE_NAME;

        $this->send_custom_email($request->email, $subject, 'mail.welcome-mail', $mail_data, $title);

        // Sending new registration email to admin
        $this->send_custom_email(CLIENT_MAIL, 'New user registered', 'mail.new-registration', $mail_data, $title);

        $OTP = rand(1111, 9999);

        $isOTPSent = $this->sendOTPMessage($d->phone, $OTP);
        $update = DB::table('users')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', '=', $d->id)
            ->where('phone', '=', $d->phone)
            ->update(['otp' => $OTP]);

        $url = $this->get_base_url() . 'otp-verify-register';

        return redirect($url)->with('phone', $d->phone);
        //            ->with('user_id', $d->id)
        //            ->with('OTP', $OTP);
    }

    public function view_otp_screen(Request $request)
    {
        return view('otp-verify-register');
    }

    public function verify_otp(Request $request)
    {
        if (!$request->phone_no || !$request->user_id) {
            return back()->with('error', 'Please Login to Continue');
        }
        $attempts = isset($request->attempts) ? $request->attempts : 0;
        if ($attempts) {
            $attempts = $attempts + 1;
        } else {
            $attempts = 1;
        }

        $check = DB::table('users')
            ->where('client_id', CLIENT_ID)
            ->where('id', $request->user_id)
            ->where('phone', $request->phone_no)
            ->first();
        if (!$check || $check->otp != $request->otp) {
            return back()
                ->with('phone_number', $request->phone_no)
                ->with('phone', $request->phone_no)
                ->with('user_id', $check->id)
                ->with('error', 'Wrong code. Please try again.')
                ->with('attempts', $attempts);
        } else {
            $update_status = DB::table('users')
                ->where('client_id', CLIENT_ID)
                ->where('id', $request->user_id)
                ->where('phone', $request->phone_no)
                ->update(['otp_verified' => 1]);

            if ($check->email_verified == 1) {
                if ($check->role_id == 1 || $check->role_id == 2) {
                    // 1: Property Owner || 2: Agency
                    $url = $this->get_base_url() . 'owner/profile';
                }
                //                else if($check->role_id==3) {
                //                    $url = $this->get_base_url() . '/rv-traveller';
                //                }
                else {
                    // 0: Healthcare Traveler || 3: RV Healthcare Traveler
                    $url = $this->get_base_url() . 'traveler/profile';
                }
                $request->session()->put('user_id', $check->id);
                $request->session()->put('is_verified', $check->is_verified);
                $request->session()->put('role_id', $check->role_id);
                $request->session()->put('username', $check->username);
                $request->session()->put('name_of_agency', $check->name_of_agency);
                $request->session()->put('phone', $check->phone);
                $userProfileImage = $check->profile_image
                    ? $check->profile_image
                    : BASE_URL . 'user_profile_default.png';
                $request->session()->put('profile_image', $userProfileImage);
                return redirect($url)->with('phone', $check->phone);
            } else {
                // Send Verification mail
                $verify_url = BASE_URL . 'verify/' . $check->id . '/' . $check->auth_token;

                $reg = EmailConfig::where('type', 2)->first();

                $mail_data = [
                    'token' => $check->auth_token,
                    'name' => $check->first_name . ' ' . $check->last_name,
                    'email' => $check->email,
                    'url' => $verify_url,
                    'text' => isset($reg->message) ? $reg->message : '',
                ];

                $title = isset($reg->title) ? $reg->title : 'Message from ' . APP_BASE_NAME;
                $subject = isset($reg->subject) ? $reg->subject : "Email verification from " . APP_BASE_NAME;
                $this->send_custom_email($check->email, $subject, 'mail.email-verify', $mail_data, $title);

                // Redirect to email verification screen

                $request->session()->flush();
                //                $url = $this->get_base_url() . 'email-send';
            }
            return redirect()
                ->back()
                ->with('success', 'Verified Successfully!');
        }
    }

    public function sent_otp($phone_no, $user_id)
    {
        $messages = [
            'required' => 'Please complete this field',
            'numeric' => 'Please enter valid phone number',
            'digits' => 'Please enter valid phone number',
        ];
        $rules = ['phone_no' => 'required|numeric|digits:10'];
        $reqData = ['phone_no' => $phone_no];
        $validator = Validator::make($reqData, $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => 'Failure',
                'message' => $errors->get('phone_no'),
            ]);
        }
        $check = DB::table('users')
            ->where('id', $user_id)
            ->where('client_id', '=', CLIENT_ID)
            ->first();
        if ($check) {
            $isPhoneUpdate = $phone_no != $check->phone;
            if ($isPhoneUpdate) {
                $checkPhoneNumber = DB::table('users')
                    ->where('phone', $phone_no)
                    ->where('client_id', '=', CLIENT_ID)
                    ->first();
                if ($checkPhoneNumber) {
                    return response()->json([
                        'status' => 'Failure',
                        'message' => 'Phone number is linked to another account. Try another phone number',
                    ]);
                }
            }
            $OTP = rand(1111, 9999);
            $this->sendOTPMessage($phone_no, $OTP);

            $update = DB::table('users')
                ->where('id', $user_id)
                ->where('client_id', '=', CLIENT_ID)
                ->update(['otp' => $OTP, 'phone' => $phone_no]);

            return response()->json(['status' => 'Success', 'message' => 'Otp Sent successfully', 'otp' => $OTP]);
        }
        return response()->json(['status' => 'Failure']);
    }

    // Account Verification

    public function verify_account(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $user = DB::table('users')
            ->where('id', $user_id)
            ->first();
        return view('verify-account', compact('user'));
    }

    public function map_documents(Request $request)
    {
        $keys = [
            "work_badge_id",
            "travel_contract_id",
            "government_id",
            "driver_license_id",
            "property_tax_document",
            "utility_bill",
            "traveler_contract_id",
        ];
        $all_documents = [];
        foreach ($keys as $key) {
            if ($request->$key) {
                array_push(
                    $all_documents,
                    (object) [
                        'image' => $this->base_document_upload_with_key($request, $key),
                        'type' => strtoupper($key),
                    ],
                );
            }
        }
        return $all_documents;
    }

    public function upload_document(Request $request)
    {
        // upload_documents
        $user_id = $request->session()->get('user_id');
        $all_documents = $this->map_documents($request);
        foreach ($all_documents as $doc) {
            DB::table('documents')->updateOrInsert(
                [
                    'user_id' => $user_id,
                    'document_type' => $doc->type,
                ],
                [
                    'user_id' => $user_id,
                    'document_type' => $doc->type,
                    'document_url' => $doc->image,
                    'status' => 0,
                ],
            );
        }

        $user = DB::table('users')
            ->where('id', $user_id)
            ->first();

        $user_role = DB::table('user_role')
            ->where('id', $user->role_id)
            ->first();

        DB::table('users')
            ->where('id', $user_id)
            ->update([
                'is_verified' => 0,
                'is_submitted_documents' => 1,
                'facebook_url' => isset($request->facebook) ? $request->facebook : null,
                'linkedin_url' => isset($request->linkedin) ? $request->linkedin : null,
                'instagram_url' => isset($request->instagram) ? $request->instagram : null,
                'traveler_license' => isset($request->traveler_license) ? $request->traveler_license : null,
                'airbnb_link' => isset($request->airbnb_link) ? $request->airbnb_link : null,
                'home_away_link' => isset($request->home_away_link) ? $request->home_away_link : null,
                'vrbo_link' => isset($request->vrbo_link) ? $request->vrbo_link : null,
                'agency_hr_email' => isset($request->agency_hr_email) ? $request->agency_hr_email : null,
                'agency_hr_phone' => isset($request->agency_hr_phone) ? $request->agency_hr_phone : null,
                'agency_website' => isset($request->agency_website) ? $request->agency_website : null,
                'agency_office_number' => isset($request->agency_office_number) ? $request->agency_office_number : null,
            ]);

        $doc_name = 'Document name';
        //        $doc_name = ucfirst(str_replace("_", " ", $type));

        $data = ['username' => $user->first_name . ' ' . $user->last_name, 'type' => $user_role->role];

        $subject = "Verification documents Uploads";
        $title = $user->username . " uploaded his Verification documents";
        $usermail = $user->email;

        Mail::send('mail.document-upload', $data, function ($message) use ($usermail, $title, $subject) {
            $message->from($usermail, $title);
            $message->to(VERIFY_MAIL);
            $message->replyTo($usermail);
            $message->subject($subject);
        });
        return back()->with('success', 'Documents uploaded successfully');
    }
}
