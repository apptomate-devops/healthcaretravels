<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Helper\Helper;
use App\Models\EmailConfig;
use App\Models\Users;
use DB;
use App\Services\Logger;
use Mail;
use Auth;

class UserController extends BaseController
{
    // protected $maxAttempts = 2;
    protected $decayMinutes = 5;
    use AuthenticatesUsers;

    public function account_delete_process(Request $request)
    {
        // TODO: handle soft delete, handle logout from all sessions when account is deleted.
        DB::table('users')
            ->where('id', $request->user_id)
            ->delete();
        if ($request->role_id == 0) {
            DB::table('property_list')
                ->where('user_id', $request->user_id)
                ->update(['status' => 2]);
        }

        if ($request->role_id == 1) {
            DB::table('property_list')
                ->where('user_id', $request->user_id)
                ->update(['status' => 2]);
        }

        if ($request->role_id == 2) {
            DB::table('property_list')
                ->where('user_id', $request->user_id)
                ->update(['status' => 2]);
        }
        if (Auth::check()) {
            Auth::logout();
        }
        session()->flush();
        $url = BASE_URL . 'login';
        return redirect($url);
    }

    public function change_password(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        if (!$user_id) {
            return redirect('/login')->with('error', 'Session timeout login again');
        }
        $client_id = $this->get_client_id();
        $user_detail = DB::table('users')
            ->where('client_id', '=', $client_id)
            ->where('id', '=', $user_id)
            ->first();
        return view('owner.change_password', ['user_detail' => $user_detail]);
    }

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

    public function check_verified(Request $request)
    {
        $user_id = $request->session()->get("user_id");
        if (empty($user_id)) {
            return response()->json(['isVerified' => 0]);
        }
        $check = DB::table('users')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $user_id)
            ->where('is_verified', 1)
            ->count();
        $request->session()->put('is_verified', $check);
        return response()->json(['isVerified' => $check]);
    }

    public function delete_account()
    {
        return view('delete_account');
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

    public function handleProviderCallback(Request $request)
    {
        $provider = $request->session()->get('provider');
        $type = $request->session()->get('type');
        $isLogin = $type == "login";
        $selectedTab = $isLogin ? "tab1" : "tab2";
        $login_type = $provider == "google" ? 2 : 3;
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'There was error fetching your profile information');
        }
        $email = $user->getEmail();
        $fullname = trim($user->getName());
        $social_id = $user->getId();
        $social_avatar = $user->getAvatar();
        if ($email) {
            $existingUser = Users::where('email', $email)->first();
        } else {
            $existingUser = Users::where('social_id', $social_id)->first();
        }
        if ($existingUser) {
            if ($isLogin) {
                if ($existingUser->login_type == $login_type) {
                    Auth::login($existingUser);
                    return $this->login_user_success($existingUser, $request);
                } else {
                    return redirect()
                        ->to('/login')
                        ->with('selectedTab', $selectedTab)
                        ->with(
                            'error',
                            'You account is not linked with ' .
                                $provider .
                                '. Please log in with your email and password.',
                        );
                }
            } else {
                return redirect()
                    ->to('/login')
                    ->with('selectedTab', $selectedTab)
                    ->with('error', 'Your email is already registered. Please log in instead.');
            }
        } else {
            if ($isLogin) {
                return redirect('/login')
                    ->with('selectedTab', $selectedTab)
                    ->with('error', "We don't have an account on record associated with your profile.");
            }
            if (strpos($fullname, ' ') !== false) {
                $parts = explode(" ", $fullname);
                $lname = array_pop($parts);
                $fname = implode(" ", $parts);
            } else {
                $fname = $fullname;
                $lname = '';
            }
            return redirect()
                ->to('/login')
                ->with('selectedTab', $selectedTab)
                ->with('provider', $provider)
                ->with('login_type', $login_type)
                ->with('social_id', $social_id)
                ->with('mail', $email)
                ->with('fname', $fname)
                ->with('lname', $lname)
                ->with('social_avatar', $social_avatar)
                ->with(
                    'success',
                    'Data fetched successfully. Please fill out other required fields to continue registration.',
                );
        }
    }
    public function handleProviderRedirect($provider, $type, Request $request)
    {
        $request->session()->put('provider', $provider);
        $request->session()->put('type', $type);
        return Socialite::driver($provider)
            ->with(['provider' => $provider, 'type' => $type])
            ->redirect();
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->intended('/profile');
        }
        $constants = $this->constants();

        $agency = DB::table('agency')
            ->orderBy('name', 'ASC')
            ->get();

        $occupation = DB::table('occupation')
            ->orderBy('name', 'ASC')
            ->get();
        $data = [];
        // TODO: Re-enable registration forms by removing the temp route
        // login_temp :: => Toggle as per requirements
        $login_view = APP_ENV == 'beta' ? 'login_temp' : 'login';
        return view($login_view, [
            'constants' => $constants,
            'agency' => $agency,
            'data' => $data,
            'occupation' => $occupation,
        ]);
    }

    public function login_user(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $error_message = 'Your account is locked due to too many failed login attempts.';
            $error_message .= ' Please wait 5 minutes before reattempting.';
            $error_message .= ' If you can not access your account you can reset your password or contact';
            $error_message .= ' <a href="mailto:' . SUPPORT_MAIL . '" style="color: white">' . SUPPORT_MAIL . '</a>';
            return back()->with('error', $error_message);
        }
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
                        ->where('id', '=', $check->id)
                        ->update(['otp' => $OTP]);

                    $check = DB::table('users')
                        ->where('client_id', '=', CLIENT_ID)
                        ->where('phone', '=', $check->phone)
                        ->where('id', '=', $check->id)
                        ->first();

                    $url = $this->get_base_url() . 'otp-verify-register';

                    return redirect($url)->with('phone', $check->phone);
                }
            } else {
                return back()->with('error', 'This Email is not registered');
            }
        }
        Logger::info("Login with user hitted at :" . date('d-m-Y H:i:s'));
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:4',
        ]);

        $check = DB::table('users')
            ->where('client_id', '=', $request->client_id)
            ->where('email', '=', $request->username)
            ->first();
        if ($check) {
            if ($check->login_type != 1) {
                $login_provider = $check->login_type == 2 ? "google" : "facebook";
                return back()->with(
                    'error',
                    'This email is linked with ' . $login_provider . '. Please sign in with ' . $login_provider . '.',
                );
            }
            $credentials = [
                'email' => $request->username,
                'password' => $request->password,
                'client_id' => $request->client_id,
            ];
            if (!Auth::attempt($credentials)) {
                $this->incrementLoginAttempts($request);
                return back()->with([
                    'error' => '',
                    'password_error' => 'You have entered the wrong password. Please try again.',
                ]);
            }
            if (\Hash::needsRehash($check->password)) {
                $hashed = $this->encrypt_password($request->password);
                $update = DB::table('users')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $check->id)
                    ->update(['password' => $hashed]);
            }
            return $this->login_user_success($check, $request);
        } else {
            return back()->with([
                'error' => '',
                'email' => $request->username,
                'email_error' => 'This email is not registered.',
            ]);
        }
    }

    public function login_user_success($check, $request)
    {
        $request->session()->put('user_id', $check->id);
        $request->session()->put('phone', $check->phone);
        $request->session()->put('user_id_v', $check->id);
        $request->session()->put('phone_v', $check->phone);
        $request->session()->put('user_role_id', $check->role_id);
        $request->session()->put('user_funding_source', $check->default_funding_source);

        // store user timezone
        DB::table('users')
            ->where('client_id', '=', CLIENT_ID)
            ->where('phone', '=', $check->phone)
            ->where('id', '=', $check->id)
            ->update(['timezone' => $request->timezone]);

        if ($check->otp_verified != 1) {
            $OTP = rand(1111, 9999);
            // send otp
            $this->sendOTPMessage($check->phone, $OTP);
            $update = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('phone', '=', $check->phone)
                ->where('id', '=', $check->id)
                ->update(['otp' => $OTP]);

            $url = $this->get_base_url() . 'otp-verify-register';
            if (Auth::check()) {
                Auth::logout();
            }
            return redirect($url);
        }

        if ($check->email_verified != 1) {
            $d = DB::table('users')
                ->where('client_id', '=', $request->client_id)
                ->where('email', '=', $check->email)
                ->first();
            $token = $check->auth_token;
            $verify_url = BASE_URL . 'verify/' . $d->id . '/' . $token;
            $reg = EmailConfig::where('type', TEMPLATE_VERIFICATION)->first();
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
            if (Auth::check()) {
                Auth::logout();
            }
            $request->session()->flush();
            $url = $this->get_base_url() . 'email-send';
            return redirect($url)->with('phone', $check->phone);
        }

        if ($check->enable_two_factor_auth == 1) {
            // Verify identity if two factor auth is enabled, by default enabled
            $OTP = rand(1111, 9999);
            // send otp
            $this->sendOTPMessage($check->phone, $OTP);
            $update = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('phone', '=', $check->phone)
                ->where('id', '=', $check->id)
                ->update(['otp' => $OTP]);
            if (Auth::check()) {
                Auth::logout();
            }
            $url = $this->get_base_url() . 'otp-verify-login';
            return redirect($url);
        } else {
            $request->session()->put('user_id', $check->id);
            $request->session()->put('is_verified', $check->is_verified);
            $request->session()->put('user_id_v', $check->id);
            $request->session()->put('phone_v', $check->phone);
            $request->session()->put('role_id', $check->role_id);
            $request->session()->put('username', $check->username);
            $request->session()->put('name_of_agency', $check->name_of_agency);
            $request->session()->put('phone', $check->phone);
            $request->session()->put('user_funding_source', $check->default_funding_source);
            $userProfileImage = $check->profile_image ? $check->profile_image : BASE_URL . 'user_profile_default.png';
            $request->session()->put('profile_image', $userProfileImage);
            $url = $this->check_login_redirection($check);
            $request_chat_property_id = $request->session()->get('request_chat_property_id');
            $property_id = $request->session()->get('propertyId');
            if ($property_id) {
                $url = $this->get_base_url() . 'property/' . $property_id;
            } elseif ($request_chat_property_id) {
                $url = $this->get_base_url() . 'create_chat/' . $request_chat_property_id;
                $request->session()->forget('request_chat_property_id');
                return Helper::start_chat($request_chat_property_id, $request);
            }

            return redirect()
                ->intended($url)
                ->with('phone', $check->phone);
        }
    }

    public function profile(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        if (!$user_id) {
            return redirect('/login')->with('error', 'Session timeout login again');
        }
        $client_id = $this->get_client_id();
        $user_detail = DB::table('users')
            ->where('client_id', '=', $client_id)
            ->where('id', '=', $user_id)
            ->first();

        foreach ($user_detail as $key => $value) {
            if ($value == '0') {
                $user_detail->$key = "";
            }
        }

        $agency = DB::table('agency')
            ->orderBy('name', 'ASC')
            ->get();
        $occupation = DB::table('occupation')
            ->orderBy('name', 'ASC')
            ->get();

        return view('profile', [
            'user_detail' => $user_detail,
            'agency' => $agency,
            'occupation' => $occupation,
        ]);
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
        $name = $request->username;
        $fname = $request->first_name;
        $lname = $request->last_name;
        $mail = $request->email;
        $type = $request->user_type;
        $social_id = $request->social_id;
        $login_type = $request->login_type ?? 1;

        $messages = [
            'required' => 'Please complete this field',
            'required_without' => 'Please complete this field',
            'accepted' => 'Terms and Policy must be agreed',
            'same' => 'Password must match repeat password',
            'password1.regex' => PASSWORD_REGEX_MESSAGE,
            'email.regex' => 'This should be your business email',
            'website.regex' => 'Please enter valid URL',
            'numeric' => 'Please enter valid phone number',
            'digits' => 'Please enter valid phone number',
            'phone.unique' =>
                'This phone number is already in use an another account. If this is an error, please contact <a href="mailto:support@healthcaretravels.com">support@healthcaretravels.com</a>.',
        ];

        $rules = [
            'username' => 'required|unique:users,username',
            'first_name' => 'required',
            'last_name' => 'required',
            'ethnicity' => 'required',
            'phone' =>
                'required|numeric|digits:10' . (APP_ENV == 'test' || APP_ENV == 'local' ? '' : '|unique:users,phone'),
            'dob' => 'required',
            'gender' => 'required',
            'languages_known' => 'required',
            //            'email_opt' => 'accepted',
            'policy_accept' => 'accepted',
        ];
        if (empty($social_id)) {
            $rules["password1"] = PASSWORD_REGEX;
            $rules["password2"] = 'required|same:password1';
        }
        if ($request->user_type === "1" || $request->user_type === "4") {
            // Owner or Co-Host
            $rules["email"] = 'required|email:rfc,dns|unique:users,email';
            $rules["address"] = 'required';
            //            $rules["listing_address"] = 'required';
        } elseif ($request->user_type === "2") {
            // Travel Agency
            $rules["email"] =
                'required|email:rfc,dns|unique:users,email|regex:/^([\w\-.]+@(?!gmail.com)(?!yahoo.com)(?!hotmail.com)(?!yahoo.co.in)(?!aol.com)(?!abc.com)(?!xyz.com)(?!pqr.com)(?!rediffmail.com)(?!live.com)(?!outlook.com)(?!me.com)(?!msn.com)(?!ymail.com)([\w-]+\.)+[\w-]{2,4})?$/i';
            $rules["work"] = 'required';
            $rules["work_title"] = 'required';
            //            $rules["occupation"] = 'required_without:other_occupation';
            //            $rules["other_occupation"] = 'required_without:occupation';
            $rules["website"] = 'required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
            $rules["name_of_agency"] = 'required_without:other_agency';
            $rules["other_agency"] = 'required_without:name_of_agency';
        } else {
            // Traveler or RV traveler
            $rules["email"] = 'required|email:rfc,dns|unique:users,email';
            $rules["occupation"] = 'required_without:other_occupation';
            $rules["other_occupation"] = 'required_without:occupation';
            $rules["name_of_agency"] = 'required_without:other_agency';
            $rules["other_agency"] = 'required_without:name_of_agency';
            $rules["tax_home"] = 'required';
            $rules["address"] = 'required';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()
                ->with('username', $name)
                ->with('fname', $fname)
                ->with('lname', $lname)
                ->with('ethnicity', $request->ethnicity)
                ->with('mail', $mail)
                ->with('phone', $request->phone)
                ->with('type', $type)
                ->with('selectedTab', 'tab2')
                ->with('email_opt', $request->email_opt)
                ->with('policy_accept', $request->policy_accept)
                ->with('dob', $request->dob)
                ->with('gender', $request->gender)
                ->with('occupation', $request->occupation)
                ->with('other_occupation', $request->other_occupation)
                ->with('name_of_agency', $request->name_of_agency)
                ->with('other_agency', $request->other_agency)
                ->with('languages_known', $request->languages_known)
                ->with('tax_home', $request->tax_home)
                ->with('address', $request->address)
                ->with('address_line_2', $request->address_line_2)
                ->with('street_number', $request->street_number)
                ->with('route', $request->route)
                ->with('city', $request->city)
                ->with('state', $request->state)
                ->with('pin_code', $request->pin_code)
                ->with('country', $request->country)
                ->with('work', $request->work)
                ->with('work_title', $request->work_title)
                ->with('website', $request->website)
                ->withErrors($validator);
        }

        $password = $social_id ? null : $this->encrypt_password($request->password1);

        $role_id = $request->user_type;

        $token = $this->generate_random_string();

        // Considered as Address_line_1
        $address = implode(", ", array_filter([$request->street_number, $request->route]));

        $OTP = rand(1111, 9999);
        $isOTPSent = $this->sendOTPMessage($request->phone, $OTP);
        $profileImage = '';
        if (isset($request->profile_image)) {
            $profileImage = $this->base_image_upload($request, 'profile_image', 'users');
        }
        $email_opt = isset($request->email_opt) ? 1 : 0;
        $insert = DB::table('users')->insert([
            'client_id' => $request->client_id,
            'role_id' => $role_id,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'ethnicity' => $request->ethnicity,
            'phone' => $request->phone,
            'date_of_birth' => $request->dob,
            'gender' => $request->gender,
            'languages_known' => $request->languages_known,
            'occupation' => $request->occupation,
            'other_occupation' => $request->other_occupation,
            'name_of_agency' => $request->name_of_agency,
            'other_agency' => $request->other_agency,
            'tax_home' => $request->tax_home,
            'address' => $address,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'pin_code' => $request->pin_code,
            'country' => $request->country,
            'status' => 1,
            'work' => $request->work,
            'work_title' => $request->work_title,
            'website' => $request->website,
            'timezone' => $request->timezone || USER_DEFAULT_TIMEZONE,
            'auth_token' => $token,
            'is_encrypted' => 1,
            'login_type' => $login_type,
            'social_id' => $social_id,
            'otp' => $OTP,
            'email_opt' => $email_opt,
            'profile_image' => $profileImage,
        ]);

        $sendgridUserData = [
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'city' => $request->city,
            'postal_code' => $request->pin_code,
        ];
        // NOTE: Checking it as 0 as the value stored in database is inverted
        if ($email_opt == 0) {
            $this->sendgrid->addUserToMarketingList($sendgridUserData);
        } else {
            $this->sendgrid->addUserToNoContactList($sendgridUserData);
        }

        $d = DB::table('users')
            ->where('client_id', '=', $request->client_id)
            ->where('email', '=', $request->email)
            ->first();

        $request->session()->put('phone', $d->phone);
        $request->session()->put('role_id', $d->role_id);
        $request->session()->put('username', $d->username);
        $request->session()->put('user_id', $d->id);
        $request->session()->put('is_verified', $d->is_verified);
        $request->session()->put('user_id_v', $d->id);
        $request->session()->put('phone_v', $d->phone);

        //  Send Welcome mail
        $welcome = EmailConfig::where('type', TEMPLATE_REGISTER)->first();
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
        $url = $this->get_base_url() . 'otp-verify-register';
        return redirect($url);
    }

    public function view_otp_screen_register(Request $request)
    {
        return view('otp-verify-register');
    }

    public function view_otp_screen_login(Request $request)
    {
        return view('otp-verify-login');
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

        $check = Users::where('client_id', CLIENT_ID)
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
            Auth::login($check);
            $update_status = DB::table('users')
                ->where('client_id', CLIENT_ID)
                ->where('id', $request->user_id)
                ->where('phone', $request->phone_no)
                ->update(['otp_verified' => 1]);

            if ($check->email_verified == 1) {
                $url = $this->check_login_redirection($check);

                $request->session()->put('user_id', $check->id);
                $request->session()->put('is_verified', $check->is_verified);
                $request->session()->put('user_id_v', $check->id);
                $request->session()->put('phone_v', $check->phone);
                $request->session()->put('role_id', $check->role_id);
                $request->session()->put('username', $check->username);
                $request->session()->put('name_of_agency', $check->name_of_agency);
                $request->session()->put('phone', $check->phone);
                $request->session()->put('user_funding_source', $check->default_funding_source);
                $userProfileImage = $check->profile_image
                    ? $check->profile_image
                    : BASE_URL . 'user_profile_default.png';
                $request->session()->put('profile_image', $userProfileImage);
                return redirect($url)->with('phone', $check->phone);
            } else {
                // Send Verification mail
                $verify_url = BASE_URL . 'verify/' . $check->id . '/' . $check->auth_token;

                $reg = EmailConfig::where('type', TEMPLATE_VERIFICATION)->first();

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
                if (Auth::check()) {
                    Auth::logout();
                }
                $request->session()->flush();
                //                $url = $this->get_base_url() . 'email-send';
            }
            return redirect()
                ->back()
                ->with('success', 'Verified Successfully!');
        }
    }

    public function verify_otp_login(Request $request)
    {
        if (!$request->phone_no || !$request->user_id) {
            return back()->with('error', 'Please Login again to Continue');
        }
        $check = Users::where('client_id', CLIENT_ID)
            ->where('id', $request->user_id)
            ->where('phone', $request->phone_no)
            ->first();
        if (!$check || $check->otp != $request->otp) {
            return back()->with([
                'phone_number' => $request->phone_no,
                'phone' => $request->phone_no,
                'user_id' => $request->user_id,
                'error' => 'Wrong code. Please try again.',
            ]);
        } else {
            Auth::login($check);
            $update_status = DB::table('users')
                ->where('client_id', CLIENT_ID)
                ->where('id', $request->user_id)
                ->where('phone', $request->phone_no)
                ->update(['otp_verified' => 1]);

            $url = $this->check_login_redirection($check);

            $request->session()->put('user_id', $check->id);
            $request->session()->put('is_verified', $check->is_verified);
            $request->session()->put('role_id', $check->role_id);
            $request->session()->put('username', $check->username);
            $request->session()->put('name_of_agency', $check->name_of_agency);
            $request->session()->put('phone', $check->phone);
            $userProfileImage = $check->profile_image ? $check->profile_image : BASE_URL . 'user_profile_default.png';
            $request->session()->put('profile_image', $userProfileImage);
            $request->session()->put('user_id_v', $check->id);
            $request->session()->put('phone_v', $check->phone);
            $request->session()->put('user_funding_source', $check->default_funding_source);
            if ($check->is_verified) {
                return redirect()->intended($url);
            }
            return redirect($url);
        }
    }

    public function check_login_redirection($user)
    {
        if ($user->is_submitted_documents == 0) {
            return $this->get_base_url() . 'verify-account';
        } else {
            return $this->get_base_url() . 'profile';
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
                if (APP_ENV != 'test' || APP_ENV != 'local') {
                    if ($checkPhoneNumber) {
                        return response()->json([
                            'status' => 'Failure',
                            'message' => 'Phone number is linked to another account. Try another phone number',
                        ]);
                    }
                }
            }
            $OTP = rand(1111, 9999);
            $this->sendOTPMessage($phone_no, $OTP);

            $update = DB::table('users')
                ->where('id', $user_id)
                ->where('client_id', '=', CLIENT_ID)
                ->update(['otp' => $OTP, 'phone' => $phone_no]);

            return response()->json(['status' => 'Success', 'message' => 'Otp Sent successfully']);
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
        $documents = DB::table('documents')
            ->where('user_id', $user_id)
            ->where('status', -1)
            ->get();
        return view('verify-account', compact('user', 'documents'));
    }

    public function map_documents(Request $request)
    {
        $docKeys = [
            "work_badge_id",
            "travel_contract_id",
            "government_id",
            "property_tax_document",
            "utility_bill",
            "traveler_contract_id",
            "co-hosting_agreement_id",
            "lease_agreement",
        ];
        $all_documents = [];
        foreach ($docKeys as $key) {
            if ($request->$key) {
                array_push(
                    $all_documents,
                    (object) [
                        'image' => $this->base_document_upload_with_key($request, $key),
                        'type' => strtoupper($key),
                        'data_type' => 0,
                    ],
                );
            }
        }
        $linkKeys = [
            "website",
            "facebook",
            "linkedin",
            "instagram",
            "airbnb_link",
            "home_away_link",
            "vrbo_link",
            "other_listing_link",
            "agency_website",
            "property_tax_url",
        ];
        foreach ($linkKeys as $key) {
            Logger::info('Key: ' . $key);
            Logger::info('value: ' . $request->$key);
            if ($request->$key) {
                array_push(
                    $all_documents,
                    (object) [
                        'image' => $request->$key,
                        'type' => $key == 'website' ? 'LICENSE_CERTIFICATION_WEBSITE' : strtoupper($key),
                        'data_type' => 1,
                    ],
                );
            }
        }
        $textKeys = ["traveler_license"];
        foreach ($textKeys as $key) {
            if ($request->$key) {
                array_push(
                    $all_documents,
                    (object) [
                        'image' => $request->$key,
                        'type' => strtoupper($key),
                        'data_type' => 2,
                    ],
                );
            }
        }
        return $all_documents;
    }

    public function update_password(Request $request)
    {
        $messages = [
            'new_password.regex' => PASSWORD_REGEX_MESSAGE,
        ];
        $rules = [
            'new_password' => PASSWORD_REGEX,
            'confirm_password' => 'required|same:new_password',
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        if ($request->new_password != $request->confirm_password) {
            return back()->with('error', 'Passwords does not match');
        }
        $user_id = $request->session()->get('user_id');
        Logger::info("update_password with user_id " . $user_id);
        $client_id = $this->get_client_id();
        if ($request->old_password) {
            $check = DB::table('users')
                ->where('id', '=', $user_id)
                ->first();
            $credentials = [
                'email' => $check->email,
                'password' => $request->old_password,
                'client_id' => $client_id,
            ];
            if (!Auth::attempt($credentials)) {
                return back()->with('error', 'You have entered wrong old password');
            }
            $newEncryptedPassword = $this->encrypt_password($request->new_password);
            $update = DB::table('users')
                ->where('id', '=', $user_id)
                ->update(['password' => $newEncryptedPassword]);
            return back()->with('success', 'Password updated successfully');
        } else {
            $update = DB::table('users')
                ->where('client_id', '=', $client_id)
                ->where('id', '=', $user_id)
                ->update(['password' => $this->encrypt_password($request->new_password)]);
            return back()->with('success', 'Password updated successfully');
        }
    }

    public function upload_document(Request $request)
    {
        // upload_documents
        try {
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
                        'data_type' => $doc->data_type,
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
                    'website' => isset($request->website) ? $request->website : null,
                    'airbnb_link' => isset($request->airbnb_link) ? $request->airbnb_link : null,
                    'home_away_link' => isset($request->home_away_link) ? $request->home_away_link : null,
                    'vrbo_link' => isset($request->vrbo_link) ? $request->vrbo_link : null,
                    'other_listing_link' => isset($request->other_listing_link) ? $request->other_listing_link : null,
                    'property_tax_url' => isset($request->property_tax_url) ? $request->property_tax_url : null,
                    'property_address' => isset($request->property_address) ? $request->property_address : null,
                    'agency_hr_email' => isset($request->agency_hr_email) ? $request->agency_hr_email : null,
                    'agency_hr_phone' => isset($request->agency_hr_phone) ? $request->agency_hr_phone : null,
                    'agency_website' => isset($request->agency_website) ? $request->agency_website : null,
                    'agency_office_number' => isset($request->agency_office_number)
                        ? $request->agency_office_number
                        : null,
                    'homeowner_first_name' => isset($request->homeowner_first_name)
                        ? $request->homeowner_first_name
                        : null,
                    'homeowner_last_name' => isset($request->homeowner_last_name)
                        ? $request->homeowner_last_name
                        : null,
                    'homeowner_email' => isset($request->homeowner_email) ? $request->homeowner_email : null,
                    'homeowner_phone_number' => isset($request->homeowner_phone_number)
                        ? $request->homeowner_phone_number
                        : null,
                ]);

            $data = [
                'username' => $user->first_name . ' ' . $user->last_name,
                'type' => $user_role->role,
                'id' => $user->id,
            ];

            $subject = "Verification documents Uploads";
            $title = $user->username . " uploaded their Verification documents";
            $usermail = $user->email;

            Mail::send('mail.document-upload', $data, function ($message) use ($usermail, $title, $subject) {
                $message->from($usermail, $title);
                $message->to(VERIFY_MAIL);
                $message->replyTo($usermail);
                $message->subject($subject);
            });

            $title = "Profile Verification Pending";
            $subject = "Profile Verification Pending";
            $this->send_custom_email($user->email, $subject, 'mail.document-uploaded-user', $data, $title, VERIFY_MAIL);

            return redirect()
                ->back()
                ->with('success', 'Documents uploaded successfully!');
        } catch (\Exception $ex) {
            return redirect()
                ->back()
                ->with('error', 'Error submitting documents, Please try again later');
        }
    }

    public function update_profile(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $user = DB::table('users')
            ->where('id', $user_id)
            ->first();

        $messages = [
            'required' => 'Please complete :attribute field',
            'required_without' => 'Please complete this field',
            'accepted' => 'Terms and Policy must be agreed',
            'same' => 'Password must match repeat password',
            'password1.regex' => PASSWORD_REGEX_MESSAGE,
            'website.regex' => 'Please enter valid URL',
            'numeric' => 'Please enter valid phone number',
            'digits' => 'Please enter valid phone number',
        ];

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'ethnicity' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'languages_known' => 'required',
        ];
        if ($user->role_id == "1" || $user->role_id == "4") {
            // Owner or Co-Host
            $rules["address"] = 'required';
        } elseif ($user->role_id == "2") {
            // Travel Agency
            $rules["work_title"] = 'required';
            $rules["website"] = 'required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
            $rules["occupation"] = 'required_without:other_occupation';
            $rules["other_occupation"] = 'required_without:occupation';
        } else {
            // Traveler or RV traveler
            $rules["occupation"] = 'required_without:other_occupation';
            $rules["other_occupation"] = 'required_without:occupation';
            $rules["name_of_agency"] = 'required_without:other_agency';
            $rules["other_agency"] = 'required_without:name_of_agency';
            $rules["tax_home"] = 'required';
            $rules["address"] = 'required';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()
                ->with('first_name', $request->first_name)
                ->with('last_name', $request->last_name)
                ->with('date_of_birth', $request->dob)
                ->with('gender', $request->gender)
                ->with('languages_known', $request->languages_known)
                ->with('occupation', $request->occupation)
                ->with('other_occupation', $request->other_occupation)
                ->with('name_of_agency', $request->name_of_agency)
                ->with('other_agency', $request->other_agency)
                ->with('tax_home', $request->tax_home)
                ->with('address', $request->address)
                ->with('address_line_2', $request->address_line_2)
                ->with('street_number', $request->street_number)
                ->with('route', $request->route)
                ->with('city', $request->city)
                ->with('state', $request->state)
                ->with('pin_code', $request->pin_code)
                ->with('country', $request->country)
                ->with('work', $request->work)
                ->with('work_title', $request->work_title)
                ->with('website', $request->website)
                ->with('enable_two_factor_auth', $request->enable_two_factor_auth)
                ->withErrors($validator);
        }

        // Considered as Address_line_1
        $address = implode(", ", array_filter([$request->street_number, $request->route]));
        DB::table('users')
            ->where('id', $user_id)
            ->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'ethnicity' => $request->ethnicity,
                'date_of_birth' => $request->dob,
                'gender' => $request->gender,
                'languages_known' => $request->languages_known,
                'occupation' => $request->occupation,
                'other_occupation' => $request->other_occupation,
                'name_of_agency' => $request->name_of_agency,
                'other_agency' => $request->other_agency,
                'tax_home' => $request->tax_home,
                'address' => $address,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'state' => $request->state,
                'pin_code' => $request->pin_code,
                'country' => $request->country,
                'work' => $request->work,
                'work_title' => $request->work_title,
                'website' => $request->website,
                'enable_two_factor_auth' => isset($request->enable_two_factor_auth) ? 1 : 0,
                'about_me' => $request->about,
            ]);

        return back()->with('success', 'Profile updated successfully');
    }

    public function update_profile_picture(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        if (!$user_id) {
            return redirect('/login')->with('error', 'Session timeout login again');
        }
        $profile_image = '';
        if ($request->file('profile_image')) {
            $profile_image = $this->base_image_upload($request, 'profile_image', 'users');
        }
        $update = DB::table('users')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', '=', $user_id)
            ->update(['profile_image' => $profile_image]);
        $request->session()->put('profile_image', $profile_image);
        return $profile_image;
    }
    public function delete_profile_picture(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        if (!$user_id) {
            return redirect('/login')->with('error', 'Session timeout login again');
        }
        $client_id = $this->get_client_id();
        $complete_url = " ";
        $update = DB::table('users')
            ->where('client_id', '=', $client_id)
            ->where('id', '=', $user_id)
            ->update(['profile_image' => ' ']);
        $request->session()->put('profile_image', ' ');
        return redirect('profile');
    }
}
