<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\BecomeScout;
use App\Models\RequestRoommate;
use App\Models\PropertyList;
use App\Models\EmailConfig;
use DB;
use Mail;
use Session;
use finfo;

class HomeController extends BaseController
{
    public function about_us()
    {
        return view('statics.about_us');
    }
    public function ambassador()
    {
        return view('statics.ambassador');
    }

    public function scout()
    {
        return view('scout');
    }
    public function cancellation_policy()
    {
        return view('policies.cancellationpolicy');
    }
    public function contact()
    {
        return view('contact');
    }
    public function contact_mail(Request $request)
    {
        $name = $request->name;
        $mail_data = [
            'name' => $request->name,
            'email' => $request->email,
            'text' => $request->message,
        ];
        $subject = $request->subject;
        $this->send_email_contact($request->email, $subject, 'mail.contact', $mail_data, $name);

        return back();
    }
    public function content()
    {
        return view('policies.content-policy');
    }
    public function cookie_policy()
    {
        return view('policies.cookie-policy');
    }

    public function copyright_policy()
    {
        return view('policies.copyright-policy');
    }

    public function host()
    {
        return view('statics.host');
    }

    public function travelers()
    {
        return view('statics.travelers');
    }

    public function extenuating_circ_policy()
    {
        return view('policies.Extenuating-Circ-policy');
    }

    public function extortion_policy()
    {
        return view('policies.extortion-policy');
    }

    public function eye_catching_photo()
    {
        return view('statics.eye-catching-photo');
    }

    public function faq()
    {
        $data = DB::table('faq')
            ->orderBy('question', 'ASC')
            ->get();
        return view('faq', ['data' => $data]);
    }

    public function fees_explained()
    {
        return view('statics.fees-explained');
    }

    public function get_user_notifications(Request $request)
    {
        $user_id = $request->user_id;
        $booking_count = DB::table('property_booking')
            ->where('owner_id', $user_id)
            ->where('owner_notify', 1)
            ->count();
        $trip_count = DB::table('property_booking')
            ->where('traveller_id', $user_id)
            ->where('traveler_notify', 1)
            ->count();
        return response()->json([
            'status' => 'SUCCESS',
            'booking_count' => $booking_count,
            'trip_count' => $trip_count,
        ]);
    }

    public function how_it_works()
    {
        return view('statics.how_it_works');
    }

    public function index(Request $request)
    {
        $latest_properties = DB::table('property_list')
            ->leftjoin('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->leftjoin('users', 'users.id', '=', 'property_list.user_id')
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('property_list.property_status', '=', 1)
            ->where('property_list.status', '=', 1)
            ->where('property_list.is_complete', '=', ACTIVE)
            ->where('property_list.is_disable', '=', ZERO)
            ->select(
                'property_list.title',
                'property_list.monthly_rate',
                'property_list.min_days',
                'property_room.bedroom_count',
                'property_room.bathroom_count',
                'property_list.property_size',
                'users.first_name',
                'users.last_name',
                'property_list.id as property_id',
                'property_list.verified',
                'users.id as owner_id',
                'property_list.state',
                'property_list.city',
                'property_list.pets_allowed',
            )
            ->orderBy('property_list.created_at', 'DESC')
            ->get();
        foreach ($latest_properties as $property) {
            $favourite = DB::table('user_favourites')
                ->where('user_favourites.client_id', '=', CLIENT_ID)
                ->where('user_favourites.user_id', '=', $request->session()->get('user_id'))
                ->where('user_favourites.property_id', '=', $property->property_id)
                ->count();
            if ($favourite != ZERO) {
                $property->is_favourite = ONE;
            } else {
                $property->is_favourite = ZERO;
            }
            $pd = DB::table('property_images')
                ->where('property_images.client_id', '=', CLIENT_ID)
                ->where('property_images.property_id', '=', $property->property_id)
                ->orderBy('property_images.sort', 'asc')
                ->orderBy('property_images.is_cover', 'desc')
                ->first();
            $cover_img = DB::table('property_images')
                ->where('property_images.client_id', '=', CLIENT_ID)
                ->where('property_images.property_id', '=', $property->property_id)
                ->where('property_images.is_cover', '=', 1)
                ->first();
            if (isset($pd->image_url)) {
                if ($cover_img != null) {
                    $property->image_url = $cover_img->image_url;
                } else {
                    $property->image_url = $pd->image_url;
                }
            } else {
                $property->image_url = STATIC_IMAGE;
            }
        }
        $categories = DB::select(
            "SELECT A.image_url,A.title,A.lat,A.lng FROM `home_listings` A, `home_category` B WHERE A.category_id = B.id",
        );
        $room_types = DB::table('property_room_types')
            ->orderBy('name', 'ASC')
            ->get();

        $user_id = $request->session()->get('user_id');
        $users_bookings = DB::table('property_booking')
            ->where('property_booking.client_id', '=', CLIENT_ID)
            ->where('property_booking.status', '=', 2)
            ->where('property_booking.traveller_id', '=', $user_id)
            ->select('start_date', 'end_date')
            ->get();

        $users_booked_dates = [];
        foreach ($users_bookings as $booking_date) {
            $dates = $this->getDatesBetweenRange($booking_date->start_date, $booking_date->end_date);
            $users_booked_dates = array_merge($users_booked_dates, $dates);
        }

        return view('home', [
            'latest_properties' => $latest_properties,
            'categories' => $categories,
            'room_types' => $room_types,
            'users_booked_dates' => $users_booked_dates,
        ]);
    }

    public function new_password($token, Request $request)
    {
        $cur_date = date('Y-m-d');
        $check = DB::table('users')
            ->where('client_id', CLIENT_ID)
            ->where('reset_password_token', $token)
            ->where('reset_date', $cur_date)
            ->first();
        if (!$check) {
            return view('set-new-password')->with('error', 1);
        } else {
            return view('set-new-password')
                ->with('error', 0)
                ->with('email', $check->email);
        }
    }

    public function non_discrimination_policy()
    {
        return view('policies.non-discrimination-policy');
    }
    public function partner()
    {
        return view('statics.partner');
    }
    public function events()
    {
        return view('statics.events');
    }
    public function payment_terms()
    {
        return view('policies.payment-terms');
    }
    public function policies()
    {
        return view('policies.policies');
    }

    public function privacy_policy()
    {
        return view('policies.privacy-policy');
    }

    public function request_roommate()
    {
        // TODO: remove me when functionality is implemented
        return view('request-roommate-iframe');
        return view('request-roommate');
    }

    public function reset_email(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|exists:users,email',
        ]);

        $token = $this->generate_hash($request->email);
        $date = date('Y-m-d');
        DB::table('users')
            ->where('email', $request->email)
            ->update(['reset_password_token' => $token, 'reset_date' => $date]);
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();
        $mail_data = EmailConfig::where('type', TEMPLATE_PASSWORD_RESET)->first();
        $email = $request->email;
        if ($user->role_id == 2) {
            $username = $user->name_of_agency;
        } else {
            $username = $user->first_name . " " . $user->last_name;
        }
        $data = [
            'token' => $token,
            'text' => isset($mail_data->message) ? $mail_data->message : '',
            'username' => $username,
        ];
        $title = isset($mail_data->title) ? $mail_data->title : 'Mail from - ' . APP_BASE_NAME;
        $subject = isset($mail_data->subject) ? $mail_data->subject : "Mail from - " . APP_BASE_NAME;
        $this->send_custom_email($email, $subject, 'mail.password-reset', $data, $title);
        return back()->with('success', 'Password reset link sent to your email');
    }

    public function reset_password()
    {
        return view('reset_password');
    }

    public function rv_professional()
    {
        return view('statics.rv_professional');
    }

    public function save_become_a_scout(Request $request)
    {
        $new = new BecomeScout();
        $new->email = $request->email;
        $new->phone = $request->phone_no;
        $new->firstname = $request->firstname;
        $new->lastname = $request->lastname;
        $new->days = implode(',', $request->days);
        $new->is_take_photo = $request->take_photo;
        $new->city = $request->city;
        $new->state = $request->state;
        $new->miles = $request->miles;
        $new->information_check_allows = $request->information_check_allows;
        $new->save();

        return back()->with('success', 'Your information has been saved.');
    }

    public function save_request_roommate(Request $request)
    {
        $new = new RequestRoommate();
        $new->email = $request->email;
        $new->phone = $request->phone;
        $new->firstname = $request->firstname;
        $new->lastname = $request->lastname;
        $new->startdate = $request->startdate;
        $new->enddate = $request->enddate;
        $new->city = $request->city;
        $new->state = $request->state;

        $new->gender = $request->gender;
        $new->age = $request->age;

        $new->save();
        return view('request_roommate2')->with('id', $new->id);
    }

    public function save_request_roommate2(Request $request)
    {
        // print_r($request->all());exit;
        $new = RequestRoommate::find($request->id);
        $new->rent = $request->rent;
        $new->occupation = $request->occupation;
        $new->is_house_on_healthcare = $request->is_house_on_healthcare;
        $new->prefer_gender = $request->prefer_gender;
        $new->prefer_age = $request->prefer_age;
        $new->request_details = $request->request_details;
        $new->save();
        return redirect('/');
    }

    public function standards()
    {
        return view('statics.standards');
    }

    public function terms_of_use()
    {
        return view('statics.terms-of-use');
    }

    public function travellers_refund_policy()
    {
        return view('policies.travellers-refund-policy');
    }

    public function update_password(Request $request)
    {
        $messages = [
            'password.regex' => PASSWORD_REGEX_MESSAGE,
        ];
        $rules = [
            'password' => PASSWORD_REGEX,
            'confirm_password' => 'required|same:password',
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $password = $this->encrypt_password($request->password);
        DB::table('users')
            ->where('email', $request->email)
            ->update(['password' => $password]);
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();
        if ($user->role_id == 2) {
            $username = $user->name_of_agency;
        } else {
            $username = Helper::get_user_display_name($user);
        }
        $data = [
            'content' =>
                'You have successfully changed your password. If you feel this message is in error and you did not request a password change email ​' .
                SUPPORT_MAIL .
                ' or call us at ' .
                CLIENT_PHONE,
            'username' => $username,
        ];
        $title = 'Your Password Changed Successfully';
        $subject = 'Your Password Changed Successfully';
        $this->send_custom_email($request->email, $subject, 'mail.custom-email', $data, $title);

        $url = BASE_URL . 'login';
        return redirect($url);
    }
}
