<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\BecomeScout;
use App\Models\RequestRoommate;
use App\Models\PropertyList;
use App\Models\EmailConfig;
use DB;
use Mail;
use Session;

class HomeController extends BaseController
{
    public function about_us()
    {
        return view('statics.about_us');
    }
    public function become_a_ambassador()
    {
        return view('statics.become-a-ambassador');
    }

    public function become_a_scout()
    {
        return view('become-a-scout');
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
    public function cookies_policy()
    {
        return view('policies.cookies-policy');
    }

    public function copyright_policy()
    {
        return view('policies.copyright-policy');
    }

    public function dear_host()
    {
        return view('statics.dear_host');
    }

    public function dear_travelers()
    {
        return view('statics.dear_travelers');
    }

    public function Extenuating_Circ_policy()
    {
        return view('policies.Extenuating-Circ-policy');
    }

    public function exortion_policy()
    {
        return view('policies.exortion-policy');
    }

    public function eye_catching_photo()
    {
        return view('statics.eye-catching-photo');
    }

    public function faq()
    {
        $data = DB::table('faq')->get();
        return view('faq', ['data' => $data]);
    }

    public function fees_explained()
    {
        return view('statics.fees-explained');
    }

    public function how_its_works()
    {
        return view('statics.how_its_works');
    }

    public function index(Request $request)
    {
        $latest_properties = DB::table('property_list')
            ->leftjoin(
                'property_short_term_pricing',
                'property_short_term_pricing.property_id',
                '=',
                'property_list.id',
            )
            ->leftjoin('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->leftjoin('users', 'users.id', '=', 'property_list.user_id')
            ->leftjoin('country', 'country.id', 'property_list.country')
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('property_list.property_status', '=', 1)
            ->where('property_list.status', '=', 1)
            ->where('property_list.is_complete', '=', ACTIVE)
            ->where('property_list.property_type_rv_or_home', '=', 2)
            ->select(
                'property_short_term_pricing.price_per_night',
                'property_short_term_pricing.price_more_than_one_month',
                'property_list.title',
                'property_list.location',
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
            "SELECT A.image_url,A.location,A.title FROM `home_listings` A, `home_category` B WHERE A.category_id = B.id",
        );
        $room_types = DB::table('property_room_types')->get();
        return view('home', [
            'latest_properties' => $latest_properties,
            'categories' => $categories,
            'room_types' => $room_types,
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
            return view('set-new-password')
                ->with('error', 1)
                ->with('email', $check->email);
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
        $mail_data = EmailConfig::where('type', 5)->first();
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

        Mail::send('mail.password-reset', $data, function ($message) use ($email, $subject, $title) {
            $message->from('gotocva@gmail.com', $title);
            $message->to($email);
            $message->subject($subject);
        });

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

    public function search_property(Request $request)
    {
        $request_data = $request->all();
        $room_types = DB::table('property_room_types')->get();
        $lat_lng = [];
        $lat_lng_url = urlencode(serialize($lat_lng));

        if ($request->formatted_address) {
            $request->place = $request->formatted_address;
        }
        // if ($request->place) {
        //     $prepAddr = str_replace(' ','+',$request->place);
        //     $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?key=AIzaSyB-rD5XU_5kd1vcx_EiOg4syU_honD2XIg&address='.$prepAddr.'&sensor=false');
        //     $output= json_decode($geocode);
        //     // print_r($output);exit;
        //     $request->lat = $output->results[0]->geometry->location->lat;
        //     $request->lng = $output->results[0]->geometry->location->lng;
        //     $request_data['lat'] = $output->results[0]->geometry->location->lat;
        //     $request_data['lng'] = $output->results[0]->geometry->location->lng;
        // }
        $source_lat = $request->lat;
        $source_lng = $request->lng;
        $page = $request->page ?: 1;
        $items_per_page = 100;
        $offset = ($page - 1) * $items_per_page;
        $property_list_obj = new PropertyList();
        $query = $property_list_obj
            ->join('users', 'users.id', '=', 'property_list.user_id')
            ->join('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->join('property_short_term_pricing', 'property_short_term_pricing.property_id', '=', 'property_list.id')
            ->select('property_list.*', 'property_room.*', 'property_short_term_pricing.*')
            ->where('property_list.is_complete', '=', ACTIVE)
            ->where('property_list.status', '=', 1)
            ->where('property_list.property_status', '=', 1);
        if (!empty($source_lng) && !empty($source_lat)) {
            $query
                ->selectRaw(
                    "(6371 * acos(cos(radians(" .
                        $source_lat .
                        "))* cos(radians(`lat`))
                            * cos(radians(`lng`) - radians(" .
                        $source_lng .
                        ")) + sin(radians(" .
                        $source_lat .
                        "))
                            * sin(radians(`lat`)))) as distance",
                )
                ->having('distance', '<=', RADIUS)
                ->orderBy('distance');
        }
        $where = [];
        if (Session::has('role_id') && Session::get('role_id') == 3) {
            $where[] = 'property_list.property_type_rv_or_home = 1';
        } else {
            $where[] = 'property_list.property_type_rv_or_home = 2';
        }
        if ($request->guests != "") {
            $where[] = 'property_list.total_guests >= "' . $request->guests . '" ';
        }
        if ($request->roomtype != "") {
            $where[] = 'property_list.room_type = "' . $request->roomtype . '" ';
        }
        if ($request->bookingmode != "") {
            $where[] = 'property_list.is_instant = "' . $request->bookingmode . '" ';
        }
        if ($request->minprice != "" && $request->maxprice != "") {
            $where[] =
                'property_short_term_pricing.price_per_night BETWEEN "' .
                $request->minprice .
                '" and "' .
                $request->maxprice .
                '" ';
        }

        if ($request->minprice != "" && $request->maxprice == "") {
            $where[] = 'property_short_term_pricing.price_per_night <= "' . $request->minprice . '" ';
        }
        if ($request->minprice == "" && $request->maxprice != "") {
            $where[] = 'property_short_term_pricing.price_per_night <= "' . $request->maxprice . '" ';
        }

        $dataWhere = implode(" and ", $where);
        if ($dataWhere != "") {
            $query->whereRaw($dataWhere);
        }
        $total_count = count($query->get());
        $query = $query->skip($offset)->take($items_per_page);
        $nearby_properties = $query->get();
        $total_properties = count($nearby_properties);
        foreach ($nearby_properties as $key => $value) {
            $image = DB::table('property_images')
                ->where('property_id', $value->property_id)
                ->first();
            $value->image_url = isset($image->image_url) ? $image->image_url : '';
        }
        return view('short_term')
            ->with('properties', $nearby_properties)
            ->with('total_count', $total_count)
            ->with('location_url', $lat_lng_url)
            ->with('request_data', $request_data)
            ->with('request_data1', $request_data)
            ->with('total_properties', $total_properties)
            ->with('next', $page)
            ->with('room_types', $room_types);
    }

    public function short_term(Request $request)
    {
        $request_data = $request->all();
        $room_types = DB::table('property_room_types')->get();
        $lat_lng = [];
        $lat_lng_url = urlencode(serialize($lat_lng));
        $page = $request->page ?: 1;
        $items_per_page = 100;
        $offset = ($page - 1) * $items_per_page;

        $property_list_obj = new PropertyList();
        $query = $property_list_obj
            ->join('users', 'users.id', '=', 'property_list.user_id')
            ->join('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->join('property_short_term_pricing', 'property_short_term_pricing.property_id', '=', 'property_list.id')
            ->where('property_list.is_complete', '=', ACTIVE)
            ->where('property_list.status', '=', 1)
            ->where('property_list.property_status', '=', 1)
            ->select('property_list.*', 'property_room.*', 'property_short_term_pricing.*');

        $where = [];

        $dataWhere = implode(" and ", $where);
        // dd($dataWhere);

        $total_count = count($query->get());

        $query = $query->skip($offset)->take($items_per_page);

        $nearby_properties = $query->get();

        $total_properties = count($nearby_properties);

        foreach ($nearby_properties as $key => $value) {
            $image = DB::table('property_images')
                ->where('property_id', $value->property_id)
                ->first();
            $value->image_url = isset($image->image_url) ? $image->image_url : '';
        }

        // print_r($request_data); exit;
        return view('short_term')
            ->with('properties', $nearby_properties)
            ->with('total_count', $total_count)
            ->with('location_url', $lat_lng_url)
            ->with('request_data', $request_data)
            ->with('request_data1', $request_data)
            ->with('total_properties', $total_properties)
            ->with('next', $page)
            ->with('room_types', $room_types);
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
        $this->validate($request, [
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password',
        ]);

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
            $username = $user->first_name . " " . $user->last_name;
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
        $email = $request->email;
        Mail::send('mail.custom-email', $data, function ($message) use ($email, $subject, $title) {
            $message->from('gotocva@gmail.com', $title);
            $message->to($email);
            $message->subject($subject);
        });

        $url = BASE_URL . 'login';
        return redirect($url);
    }
}
