<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use Session;
use DB;
use Auth;
use App\Models\BecomeScout;
use App\Models\RequestRoommate;
use App\Models\PropertyRating;
use App\Models\PropertyBookingPrice;
use App\Models\EmailConfig;
use App\Models\HomeListing;
use App\Services\Logger;

class HomeController extends BaseController
{
    public function load_route($route, Request $request)
    {
        $url = 'Admin.' . $route;
        return view($url);
    }

    public function index(Request $request)
    {
        $email = $request->session()->get('admin_email');
        if (strpos(url()->previous(), "/admin/") !== false) {
            $request->session()->put('admin.url.intended', url()->previous());
        }
        if ($email) {
            return redirect()->route('admin.home');
        }
        return view('Admin.login');
    }

    public function make_login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|exists:ad_users,email',
            'password' =>
                'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#^_+=:;><~$!%*?&])[A-Za-z\d@#^_+=:;><~$!%*?&]{8,}$/i',
        ]);
        $check = DB::table('ad_users')
            ->where('email', '=', $request->email)
            ->first();
        if ($check) {
            if (!Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return back()->with('error_message', 'You have entered the wrong email or password. Please Try again.');
            }
        }
        $request->session()->put('admin_email', $request->email);
        $request->session()->put('admin_id', $check->id);
        $redirectUrl = $request->session()->get('admin.url.intended');
        if (!empty($redirectUrl)) {
            return redirect($redirectUrl);
        }
        return redirect('/admin/index');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }
        $request->session()->flush();
        return redirect('/admin');
    }

    public function dashboard()
    {
        $traveller_count = DB::table('users')
            ->where('role_id', ZERO)
            ->count();
        $owner_count = DB::table('users')
            ->where('role_id', ONE)
            ->count();
        $agency_count = DB::table('users')
            ->where('role_id', TWO)
            ->count();

        $property_count = $this->propertyList->where('is_complete', ONE)->count();
        $booking_count = DB::table('property_booking')->count();
        $earnings = DB::select("SELECT SUM(`service_fare`) as total FROM `property_booking_price` WHERE `status` = 2");
        if ($earnings[0]->total != null) {
            $earnings_count = $earnings[0]->total;
        } else {
            $earnings_count = ZERO;
        }
        $canceled = DB::table('property_booking')
            ->where('status', FOUR)
            ->count();
        $today = DB::table('users')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $counts = [
            'traveller' => $traveller_count,
            'owner' => $owner_count,
            'agency' => $agency_count,
            'property' => $property_count,
            'booking' => $booking_count,
            'earnings' => $earnings_count,
            'canceled' => $canceled,
            'today' => $today,
        ];
        // print_r(  $counts);exit;
        $bookings = DB::table('property_booking')
            ->join('users as traveller', 'traveller.id', '=', 'property_booking.traveller_id')
            ->join('users as owner', 'owner.id', '=', 'property_booking.owner_id')
            ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->join('property_booking_price', 'property_booking_price.property_booking_id', '=', 'property_booking.id')
            ->orderBy('property_booking.id', 'DESC')
            ->limit(5)
            ->select(
                'property_booking.booking_id',
                'traveller.first_name as traveller_name',
                'owner.first_name as owner_name',
                'property_list.title as property_name',
                'property_booking_price.total_amount as total',
            )
            ->get();
        return view('Admin.dashboard', compact('counts', 'bookings'));
    }

    public function approve_user_profiles(Request $request)
    {
        $data = $request->all();
        if (isset($data['userIds'])) {
            DB::table('users')
                ->whereIn('id', $data['userIds'])
                ->update(['is_verified' => 1]);
        }
        return response()->json([
            'status' => 'SUCCESS',
        ]);
    }

    public function become_scout()
    {
        $data = BecomeScout::get();

        return view('Admin.become_scout', compact('data'));
    }

    public function request_roommate()
    {
        $data = RequestRoommate::get();
        return view('Admin.request_roommate', compact('data'));
    }
    public function host_payout(Request $request)
    {
        $data = DB::table('property_booking')
            ->join('property_booking_price', 'property_booking_price.property_booking_id', '=', 'property_booking.id')
            ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->join('users as traveller', 'traveller.id', '=', 'property_booking.traveller_id')
            ->join('users as owner', 'owner.id', '=', 'property_booking.owner_id')
            ->join('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->where('property_booking.status', '=', THREE)
            ->select(
                'property_booking.*',
                'property_list.*',
                'property_booking_price.*',
                'traveller.profile_image as traveller_image',
                'owner.profile_image as owner_image',
                'owner.first_name as owner_fname',
                'owner.phone as phone',
                'traveller.first_name as traveller_fname',
                'owner.last_name as owner_lname',
                'traveller.last_name as traveller_lname',
                'property_booking.id as p_id',
                'property_booking.status as booking_status',
            )
            ->get();

        // print_r($data);exit;

        return view('Admin.host-payouts', ['data' => $data]);
    }
    public function traveller_ratings(Request $request)
    {
        $data = DB::table('property_rating')
            ->join('users', 'users.id', 'property_rating.user_id')
            ->groupBy('property_rating.user_id')
            ->where('users.role_id', 0)
            ->get();
        $array = [];
        if (count($data) != 0) {
            foreach ($data as $value) {
                $user = $this->user
                    ::where('id', $value->user_id)
                    ->where('role_id', 0)
                    ->first();
                $rating = PropertyRating::where('user_id', $value->user_id)->avg('rating');
                $arr = [];
                // $arr['username'] = $user->username;
                $arr['rating'] = $rating;
                array_push($array, $arr);
            }
        }

        return view('Admin.traveller-ratings', ['data' => $array]);
    }
    public function host_ratings(Request $request)
    {
        $data = DB::table('property_rating')
            ->join('users', 'users.id', 'property_rating.user_id')
            ->groupBy('property_rating.user_id')
            ->where('users.role_id', 1)
            ->get();
        $array = [];
        if (count($data) != 0) {
            foreach ($data as $value) {
                $user = $this->user
                    ::where('id', $value->user_id)
                    ->where('role_id', 1)
                    ->first();
                $rating = PropertyRating::where('user_id', $user->id)->avg('rating');
                $arr = [];
                //  $arr['username'] = $user->username;
                $arr['rating'] = $rating;
                array_push($array, $arr);
            }
        }
        return view('Admin.host-ratings', ['data' => $array]);
    }
    public function reservations_details($booking_id, Request $request)
    {
        $data = DB::table('property_booking')
            ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->join('property_booking_price', 'property_booking_price.property_booking_id', '=', 'property_booking.id')
            ->where('property_booking.client_id', CLIENT_ID)
            ->where('property_booking.booking_id', $booking_id)
            ->select(
                'property_list.title',
                'property_list.monthly_rate',
                'property_booking_price.*',
                'property_booking.*',
                'property_booking.status as booking_status',
            )
            ->first();
        $traveller = DB::select(
            "SELECT concat(first_name,last_name) as name FROM users WHERE id = $data->traveller_id",
        );
        $owner = DB::select("SELECT concat(first_name,last_name) as name FROM users WHERE id = $data->owner_id");
        $data->owner_name = $owner[0]->name;
        $data->traveller_name = $traveller[0]->name;
        // print_r($data);exit;
        return view('Admin.reservations-details', ['data' => $data]);
    }

    public function manage_cities(Request $request)
    {
        $data = HomeListing::get();
        return view('Admin.manage_cities', ['data' => $data]);
    }
    public function block_property(Request $request)
    {
        $property = DB::table('property_list')
            ->where('is_complete', 1)
            ->select('title', 'id')
            ->get();
        $data = DB::table('property_blocking')
            ->join('property_list', 'property_list.id', '=', 'property_blocking.property_id')
            ->join('users', 'users.id', '=', 'property_blocking.owner_id')
            ->select('property_blocking.*', 'property_list.title', 'users.first_name', 'users.last_name')
            ->get();
        //print_r($data);exit;
        return view('Admin.property_blocking', ['data' => $data, 'property' => $property]);
    }

    public function get_blocked_dates($id)
    {
        $booked_dates = DB::table('property_booking')
            ->where('property_booking.client_id', '=', CLIENT_ID)
            ->where('property_booking.property_id', '=', $id)
            ->get();
        // print_r($booked_dates);exit;
        $b_dates = [];
        foreach ($booked_dates as $booked_date) {
            $strDateFrom = date("Y-m-d", strtotime($booked_date->start_date));
            $strDateTo = date("Y-m-d", strtotime($booked_date->end_date));
            $dates_list = $this->createDateRangeArray($strDateFrom, $strDateTo);
            $BdDates = [];
            foreach ($dates_list as $item) {
                $item = date("m/d/Y", strtotime($item));
                array_push($BdDates, $item);
            }
            // $b_dates[] =$BdDates;
        }

        $blocked_dates = DB::table('property_blocking')
            ->where('property_blocking.client_id', '=', CLIENT_ID)
            ->where('property_blocking.property_id', '=', $id)
            ->get();
        foreach ($blocked_dates as $item) {
            $item = date("m/d/Y", strtotime($item->start_date));
            $b_dates[] = [$item];
        }
        return response()->json(['status' => 'SUCCESS', 'data' => $BdDates]);
    }

    public function add_city_process(Request $request)
    {
        $cities = HomeListing::find($request->id);

        if (!$cities) {
            $cities = new HomeListing();
        }
        $cities->client_id = CLIENT_ID;
        if ($request->location) {
            $cities->location = $request->location;
        }
        if ($request->title) {
            $cities->title = $request->title;
        }
        if ($request->category_id) {
            $cities->category_id = $request->category_id;
        }

        if ($request->file) {
            $cities->image_url = $this->base_image_upload_with_key($request, 'file', 'public/HomePage');
        } else {
            $cities->image_url = $request->image_url;
        }
        $cities->save();

        return back()->with('success', 'Cities updated successfully');
    }

    public function delete_city($id)
    {
        DB::table('home_listings')
            ->where('id', $id)
            ->delete();
        return back()->with('success', 'City Deleted successfully');
    }

    public function add_property_block(Request $request)
    {
        //print_r($request->all());exit;
        $owner = DB::table('property_list')
            ->where('id', $request->property)
            ->select('user_id')
            ->first();
        //print_r($owner_id);exit;
        DB::table('property_blocking')->insert([
            'owner_id' => $owner->user_id,
            'client_id' => CLIENT_ID,
            'start_date' => $request->block_date,
            'end_date' => $request->block_date,
            'booked_on' => $request->comment,
            'is_admin' => 1,
            'property_id' => $request->property,
        ]);

        return back()->with('success', 'Property Blocked successfully');
    }

    public function add_agency(Request $request)
    {
        $data = DB::table('agency')
            ->orderBy('name', 'ASC')
            ->get();
        return view('Admin.add-agency', ['agencies' => $data]);
    }

    public function add_occupation(Request $request)
    {
        $data = DB::table('occupation')->get();
        return view('Admin.add-occupation', ['occupation' => $data]);
    }

    public function add_property_type(Request $request)
    {
        $data = DB::table('property_types')->get();
        return view('Admin.add-property_type', ['property_types' => $data]);
    }
    public function add_room_type(Request $request)
    {
        $data = DB::table('property_room_types')->get();
        return view('Admin.add-room_type', ['room_types' => $data]);
    }

    public function add_agency_process(Request $request)
    {
        if ($request->id) {
            DB::table('agency')
                ->where('id', $request->id)
                ->update(['name' => $request->name]);
        } else {
            DB::table('agency')->insert(['name' => $request->name]);
        }
        return back()->with('success', 'Agency updated successfully');
    }
    public function add_occupation_process(Request $request)
    {
        if ($request->id) {
            DB::table('occupation')
                ->where('id', $request->id)
                ->update(['name' => $request->name]);
        } else {
            DB::table('occupation')->insert(['name' => $request->name]);
        }
        return back()->with('success', 'occupation updated successfully');
    }
    public function add_property_type_process(Request $request)
    {
        if ($request->id) {
            DB::table('property_types')
                ->where('id', $request->id)
                ->update(['name' => $request->name]);
        } else {
            DB::table('property_types')->insert(['name' => $request->name]);
        }
        return back()->with('success', 'Property Type updated successfully');
    }
    public function add_room_type_process(Request $request)
    {
        if ($request->id) {
            DB::table('property_room_types')
                ->where('id', $request->id)
                ->update(['name' => $request->name]);
        } else {
            DB::table('property_room_types')->insert(['name' => $request->name]);
        }
        return back()->with('success', 'Room Type updated successfully');
    }

    public function delete_agency($id)
    {
        DB::table('agency')
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'Agency Deleted successfully');
    }
    public function delete_occupation($id)
    {
        DB::table('occupation')
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'occupation Deleted successfully');
    }
    public function delete_property_type($id)
    {
        DB::table('property_types')
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'Property Type Deleted successfully');
    }
    public function delete_room_type($id)
    {
        DB::table('property_room_types')
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'Room Type Deleted successfully');
    }

    public function add_faq(Request $request)
    {
        $data = DB::table('faq')
            ->orderBy('question', 'ASC')
            ->get();
        return view('Admin.faq', ['faq' => $data]);
    }

    public function add_faq_process(Request $request)
    {
        if ($request->id) {
            DB::table('faq')
                ->where('id', $request->id)
                ->update(['question' => $request->question, 'answer' => $request->answer]);
        } else {
            DB::table('faq')->insert(['question' => $request->question, 'answer' => $request->answer]);
        }
        return back()->with('success', 'faq updated successfully');
    }
    public function delete_faq($id)
    {
        DB::table('faq')
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'faq Deleted successfully');
    }

    public function property_details($id)
    {
        $property_id = $id;
        $property = DB::table('property_list')
            ->select(
                'property_list.*',
                "users.client_id",
                "users.email",
                "users.first_name",
                "users.last_name",
                "users.phone",
                // "users.username",
                "users.gender",
                "users.date_of_birth",
                "users.is_verified",
                "users.social_id",
                "users.password",
                "users.auth_token",
                "users.device_token",
                "users.role_id",
                "users.status",
                "users.otp_verified",
                "users.otp",
                "users.email_verified",
                "users.created_at",
                "users.updated_at",
                "users.address",
                "users.country",
                "users.state",
                "users.city",
                "users.pin_code",
                "users.about_me",
                "users.current_city",
                "users.languages_known",
                "users.paypal_email",
                "users.facebook_url",
                "users.twitter_url",
                "users.skype_id",
                "users.profile_image",
                "users.user_type",
                "users.login_type",
                "users.occupation",
                "users.occupation_desc",
                "users.reset_password_token",
                "users.reset_date",
                "users.recruiter_name",
                "users.recruiter_phone",
                "users.work",
                "users.school",
                "users.name_of_agency",
                "users.website",
                "users.rep_code",
                "users.linkedin_url",
                "users.airbnb_link",
                "users.other_listing_link",
                "users.home_away_link",
                "users.tax_home",
                "users.listing_address",
                "users.work_title",
                "users.instagram_url",
                "users.traveler_license",
                "users.vrbo_link",
                "users.agency_hr_phone",
                "users.agency_hr_email",
                "users.is_submitted_documents",
                "users.ethnicity",
                "users.agency_office_number",
                "users.agency_website",
                "users.denied_count",
                "users.address_line_2",
                "users.other_agency",
                "users.property_tax_url",
                "users.homeowner_first_name",
                "users.homeowner_last_name",
                "users.homeowner_email",
                "users.homeowner_phone_number",
                "users.property_address",
                "users.is_encrypted",
                "users.enable_two_factor_auth",
                "users.email_opt",
                "users.is_pet_travelling",
                "users.pet_name",
                "users.pet_breed",
                "users.pet_weight",
                "users.pet_image",
                "users.other_occupation",
                "users.dwolla_customer",
                "users.default_funding_source",
                "users.dwolla_first_name",
                "users.dwolla_last_name",
                "users.dwolla_email",
                "users.approved_by",
                "users.approved_on",
            )
            ->leftjoin('users', 'users.id', '=', 'property_list.user_id')
            ->where('property_list.id', '=', $property_id)
            ->where('property_list.status', '=', 1)
            ->first();

        if (!$property) {
            return view('general_error', ['message' => 'We can???t find the property you???re looking for.']);
        }
        $property->images = DB::table('property_images')
            ->where('property_images.property_id', '=', $property_id)
            ->select('image_url')
            ->orderBy('property_images.sort', 'asc')
            ->orderBy('property_images.is_cover', 'desc')
            ->get();

        $property->aminities = DB::table('property_amenties')
            ->where('property_amenties.property_id', '=', $property_id)
            ->get();

        // return response()->json(['data'=>$p]);
        error_log(json_encode($property));
        return view('Admin.property-details')->with('property', $property);
    }

    public function register_mail(Request $request)
    {
        $register = EmailConfig::where('type', TEMPLATE_REGISTER)->first();
        return view('Admin.mail-register', ['register' => $register]);
    }
    public function verification_mail(Request $request)
    {
        $verification = EmailConfig::where('type', TEMPLATE_VERIFICATION)->first();
        $reminder = EmailConfig::where('type', TEMPLATE_VERIFICATION_REMINDER)->first();
        return view('Admin.mail-verification', [
            'verification' => $verification,
            'reminder' => $reminder,
        ]);
    }
    public function approval_mail(Request $request)
    {
        $approval = EmailConfig::where('type', TEMPLATE_APPROVAL)->first();
        $denial = EmailConfig::where('type', TEMPLATE_DENIAL)->first();
        $data = ['approval' => $approval, 'denial' => $denial];
        return view('Admin.mail-approval', $data);
    }
    public function booking_confirm_mail(Request $request)
    {
        $confirm = EmailConfig::where('type', TEMPLATE_BOOKING)->first();
        return view('Admin.mail-confirm-booking', ['confirm' => $confirm]);
    }
    public function booking_cancel_mail(Request $request)
    {
        $cancel = EmailConfig::where('type', TEMPLATE_CANCEL_BOOKING)->first();
        return view('Admin.mail-cancel-booking', ['cancel' => $cancel]);
    }
    public function password_reset(Request $request)
    {
        $password = EmailConfig::where('type', TEMPLATE_PASSWORD_RESET)->first();
        return view('Admin.mail-password-reset', ['password' => $password]);
    }

    public function get_document($file_name, Request $request)
    {
        $encryptedFileName = $file_name . '.dat';
        $qualifiedFilePath = storage_path('app/' . $encryptedFileName);
        if (!\Storage::disk('local')->exists($encryptedFileName)) {
            return abort('404');
        }
        $encryptedContents = \Storage::get($file_name . '.dat');
        $decryptedContents = \Crypt::decrypt($encryptedContents);
        $data = $this->get_encrypted_file($file_name);
        return response()->make($data['content'], 200, [
            'Content-Type' => $data['type'],
            'Content-Disposition' => 'attachment; filename="' . pathinfo($file_name, PATHINFO_BASENAME) . '"',
        ]);
    }

    public function save_config(Request $request)
    {
        if ($request->id) {
            $mail = EmailConfig::find($request->id);
        } else {
            $mail = new EmailConfig();
        }

        $mail->title = $request->title;
        $mail->role_id = $request->role_id;
        $mail->subject = $request->subject;
        $mail->message = $request->message;
        $mail->type = $request->type;

        $mail->save();

        return back()->with('success', 'Mail config has been Saved');
    }

    public function verify_all_documents($id, Request $request)
    {
        // This only handles the denied documents flow
        $data = $request->responses;
        $deniedCount = 0;
        foreach ($data as $value) {
            $updateData = ['status' => $value["status"], 'reason' => $value["reason"]];
            if ($value["status"] == -1) {
                $deniedCount++;
            } else {
                $updateData['approved_by'] = $request->session()->get('admin_id');
                $updateData['approved_on'] = now();
            }
            DB::table('documents')
                ->where('id', $value["id"])
                ->update($updateData);
        }
        $isDenied = $deniedCount > 0;
        $updateStatus = $isDenied ? -1 : ONE;
        $updateData = ['is_verified' => $updateStatus];
        if ($isDenied) {
            $updateData['denied_count'] = DB::raw('denied_count+1');
            $updateData['is_submitted_documents'] = 0;
        } else {
            $updateData['approved_by'] = $request->session()->get('admin_id');
            $updateData['approved_on'] = now();
        }
        $this->user->where('id', $id)->update($updateData);
        $user = $this->user->where('id', $id)->first();
        if ($user) {
            // Accept/Denied Email flow
            $emailType = $isDenied ? TEMPLATE_DENIAL : TEMPLATE_APPROVAL;
            $emailTemplate = $isDenied ? 'mail.account-denied' : 'mail.account-approved';
            $reg = $this->emailConfig->where('type', $emailType)->first();
            $mail_data = [
                'name' => Helper::get_user_display_name($user),
                'email' => $user->email,
                'text' => isset($reg->message) ? $reg->message : '',
            ];
            $title = isset($reg->title) ? $reg->title : 'Message from ' . APP_BASE_NAME;
            $subject = isset($reg->subject) ? $reg->subject : "Email verification from " . APP_BASE_NAME;
            $this->send_custom_email($user->email, $subject, $emailTemplate, $mail_data, $title, VERIFY_MAIL);
        }
        return response()->json([
            'success' => true,
        ]);
    }
    public function verify_property($id)
    {
        $this->propertyList->where('id', $id)->update(['verified' => ONE]);

        $file_name = 'data/' . $id . '.json';

        if (file_exists($file_name)) {
            unlink($file_name);
        }
        return back()->with('success', 'Property has been verified');
    }
    public function verify_profile($id, $deny = false)
    {
        $isDenied = $deny == "true";
        $updateStatus = $isDenied ? -1 : ONE;
        $user = $this->user
            ->where('id', $id)
            ->where('is_verified', '<>', $updateStatus)
            ->first();
        $updateData = ['is_verified' => $updateStatus];
        if ($isDenied) {
            $updateData['denied_count'] = DB::raw('denied_count+1');
            $updateData['is_submitted_documents'] = 0;
        }
        $this->user->where('id', $id)->update($updateData);
        if ($user) {
            // Accept/Denied Email flow
            $emailType = $isDenied ? TEMPLATE_DENIAL : TEMPLATE_APPROVAL;
            $emailTemplate = $isDenied ? 'mail.account-denied' : 'mail.account-approved';
            $reg = $this->emailConfig->where('type', $emailType)->first();
            $mail_data = [
                'name' => Helper::get_user_display_name($user),
                'email' => $user->email,
                'text' => isset($reg->message) ? $reg->message : '',
            ];
            $title = isset($reg->title) ? $reg->title : 'Message from ' . APP_BASE_NAME;
            $subject = isset($reg->subject) ? $reg->subject : "Email verification from " . APP_BASE_NAME;
            $this->send_custom_email($user->email, $subject, $emailTemplate, $mail_data, $title, VERIFY_MAIL);
        }
        return back()->with('success', 'User has been verified');
    }

    public function remove_profile_image($id)
    {
        $user = $this->user->where('id', $id)->first();
        if ($user) {
            DB::table('users')
                ->where('id', $id)
                ->update(['profile_image' => 0]);
            $reg = $this->emailConfig->where('type', TEMPLATE_REMOVE_PROFILE_IMAGE)->first();
            $mail_data = [
                'name' => Helper::get_user_display_name($user),
                'email' => $user->email,
                'text' => isset($reg->message) ? $reg->message : '',
            ];
            $title = isset($reg->title) ? $reg->title : 'Message from ' . APP_BASE_NAME;
            $subject = isset($reg->subject) ? $reg->subject : APP_BASE_NAME . "Remove Your Profile Image";
            $this->send_custom_email(
                $user->email,
                $subject,
                'mail.remove-profile-image',
                $mail_data,
                $title,
                VERIFY_MAIL,
            );
            return back()->with('success', 'Profile Image Removed');
        }
        return back()->with('error', 'Error while removing Profile Image');
    }

    public function verify_document($id, $status)
    {
        DB::table('documents')
            ->where('id', $id)
            ->update(['status' => $status]);
        if ($status == 1) {
            return back()->with('success', 'Document has been verified');
        } else {
            return back()->with('success', 'Document has been Unverified');
        }
    }

    public function verify_mobile($id, $status)
    {
        DB::table('users')
            ->where('id', $id)
            ->update(['otp_verified' => $status]);
        return back()->with('success', 'User Mobile number has been verified');
    }

    public function reports(Request $request)
    {
        $total = DB::select("SELECT SUM(`service_tax`) as total FROM `property_booking_price` WHERE `status` = 1");
        $host = DB::select("SELECT SUM(`total_amount`) as host FROM `property_booking_price` WHERE `status` = 1");
        $revenue = DB::select("SELECT SUM(`total_amount`) as revenue FROM `property_booking_price` WHERE `status` = 1");
        $data = DB::table('property_booking')
            ->join('property_booking_price', 'property_booking_price.property_booking_id', '=', 'property_booking.id')
            ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->join('users as traveller', 'traveller.id', '=', 'property_booking.traveller_id')
            ->join('users as owner', 'owner.id', '=', 'property_booking.owner_id')
            ->join('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->where('property_booking.status', '=', THREE)
            ->select(
                'property_booking.*',
                'property_list.*',
                'property_booking_price.*',
                'traveller.profile_image as traveller_image',
                'owner.profile_image as owner_image',
                'owner.first_name as owner_fname',
                'owner.phone as phone',
                'traveller.first_name as traveller_fname',
                'owner.last_name as owner_lname',
                'traveller.last_name as traveller_lname',
                'property_booking.id as p_id',
                'property_booking.status as booking_status',
            )
            ->get();

        $admin = $total[0]->total + $total[0]->total;
        $host = $host[0]->host - $admin;
        $revenue = $revenue[0]->revenue;

        return view('Admin.reports', ['total' => $admin, 'host' => $host, 'data' => $data, 'revenue' => $revenue]);
        // $total_earning = DB::select("SELECT SUM(`service_tax`) as total FROM `property_booking_price` WHERE `status` = 2");
    }

    public function update_notes($id, Request $request)
    {
        $data = $request->responses;

        switch ($data['type']) {
            case 'users':
                DB::table('users')
                    ->where('id', '=', $id)
                    ->update(['admin_notes' => $data['note']]);
                break;
            case 'property_list':
                DB::table('property_list')
                    ->where('id', '=', $id)
                    ->update(['admin_notes' => $data['note']]);
                break;
            case 'bookings':
                DB::table('property_booking')
                    ->where('id', '=', $id)
                    ->update(['admin_notes' => $data['note']]);
            default:
                error_log('default');
                break;
        }
        return;
    }
}
