<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use App\Models\Users;
use App\Models\Propertyamenties;
use App\Models\PropertyList;
use App\Models\PropertyRating;
use App\Models\OwnerRating;
use App\Models\Couponecode;
use App\Models\PropertyBookingPrice;
use App\Models\EmailConfig;
use App\Models\GuestInformations;
use App\Models\Propertybooking;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Mail;

class PropertyController extends BaseController
{
    public function __construct(Users $users, PropertyList $property_list)
    {
        $this->users = $users;
        $this->property_list = $property_list;
    }
    public function cancel_booking(Request $request, $id)
    {
        $user_id = $request->session()->get('user_id');
        if (!$user_id) {
            return redirect()->intended('login');
        }
        if ($request->session()->get('role_id') == 1) {
            $user_id = $request->session()->get('user_id');
            $user = DB::table('users')
                ->where('client_id', CLIENT_ID)
                ->where('id', $user_id)
                ->first();
            $booking = DB::table('property_booking')
                ->where('booking_id', $id)
                ->leftjoin('property_list', 'property_list.id', '=', 'property_booking.property_id')
                ->leftjoin('users', 'users.id', '=', 'property_booking.traveller_id')
                ->select(
                    'users.first_name',
                    'users.last_name',
                    'property_list.title',
                    'property_booking.*',
                    'users.email',
                )
                ->first();
            // print_r($booking);exit;
            $mail_data = [
                'owner_name' => $user->first_name . " " . $user->last_name,
                'booking_id' => $booking->booking_id,
                'property' => $booking->title,
                'start_date' => date("m-d-Y", strtotime($booking->start_date)),
                'end_date' => date("m-d-Y", strtotime($booking->end_date)),
                'mail_to' => 'admin',
                'traveler' => $booking->first_name . " " . $booking->last_name,
            ];
            // $this->send_email('guru@sparkouttech.com', 'mail.cancel_booking', $mail_data);
            $this->send_email('info@healthcaretravels.com', 'mail.cancel_booking', $mail_data);
            if ($booking->email) {
                $mail_data1 = [
                    'owner_name' => $user->first_name . " " . $user->last_name,
                    'booking_id' => $booking->booking_id,
                    'property' => $booking->title,
                    'start_date' => date("m-d-Y", strtotime($booking->start_date)),
                    'end_date' => date("m-d-Y", strtotime($booking->end_date)),
                    'mail_to' => 'traveller',
                    'traveler' => $booking->first_name . " " . $booking->last_name,
                ];
                $this->send_email($booking->email, 'mail.cancel_booking', $mail_data1);
            }

            if ($user->email) {
                $mail_data2 = [
                    'owner_name' => $user->first_name . " " . $user->last_name,
                    'booking_id' => $booking->booking_id,
                    'property' => $booking->title,
                    'start_date' => date("m-d-Y", strtotime($booking->start_date)),
                    'end_date' => date("m-d-Y", strtotime($booking->end_date)),
                    'mail_to' => 'owner',
                    'traveler' => $user->first_name . " " . $booking->last_name,
                ];
                $this->send_email($user->email, 'mail.cancel_booking', $mail_data2);
            }

            $upd = DB::table('property_booking')
                ->where('booking_id', $id)
                ->update(['status' => 8]);
        } else {
            $upd = DB::table('property_booking')
                ->where('booking_id', $id)
                ->update(['status' => 8]);
        }

        return back()->with('success', 'Booking Cancelled successfully!');
    }

    public function create_chat($property_id, Request $request)
    {
        $property_detail = DB::table('property_list')
            ->where('client_id', CLIENT_ID)
            ->where('id', $property_id)
            ->first();
        $ins_data = [];
        $ins_data['client_id'] = CLIENT_ID;
        $ins_data['owner_id'] = $property_detail->user_id;
        $ins_data['property_id'] = $property_id;
        $ins_data['traveller_id'] = $request->session()->get('user_id');
        $ins_data['sent_by'] = $request->session()->get('user_id');
        $ins_data['message'] = "Hi";
        $chat_check = DB::table('personal_chat')
            ->where('client_id', CLIENT_ID)
            ->where('owner_id', $property_detail->user_id)
            ->where('traveller_id', $request->session()->get('user_id'))
            ->where('property_id', $property_id)
            ->first();
        if ($chat_check) {
            $chat_get = DB::table('personal_chat')
                ->where('client_id', CLIENT_ID)
                ->where('owner_id', $chat_check->owner_id)
                ->where('traveller_id', $chat_check->traveller_id)
                ->where('property_id', $property_id)
                ->where('owner_visible', 1)
                ->first();
            $chat_id = $chat_get->id;
        } else {
            $chat_id = DB::table('personal_chat')->insertGetId($ins_data);
        }

        $message = "Enquiry sent for ";
        $message .= $property_detail->title;
        $message .= ", Property ID :" . $property_id;
        $message .=
            " on " .
            date("m/d/Y", strtotime($request->check_in)) .
            " to " .
            date("m/d/Y", strtotime($request->check_out));

        // firebase write starts
        $date_fmt = date("m/d/Y H:i A");
        $values = [];
        $values['traveller_id'] = $request->session()->get('user_id');
        $values['owner_id'] = $property_detail->user_id;
        $values['sent_by'] = $request->session()->get('user_id');
        $values['property_id'] = $property_id;
        $values['date'] = $date_fmt;
        $values['message'] = "Hi, " . $message;
        $values['header'] = ONE;
        $postdata = json_encode($values);
        $header = [];
        $header[] = 'Content-Type: application/json';
        $url = $this->firebase_base_url() . PERSONAL_CHAT . '/' . $chat_id . '/start.json';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        $result = curl_exec($ch);
        curl_close($ch);

        $traveler = DB::table('users')
            ->where('id', $request->session()->get('user_id'))
            ->first();
        $owner = DB::table('users')
            ->where('id', $property_detail->user_id)
            ->first();

        if ($owner->email != "0") {
            $content = $message;

            $data = ['username' => $owner->username, 'content' => $content];

            $subject = "Enquiry for Your Property";
            $title = $traveler->username . " sends Enquiry for Your Property";
            $ownermail = $owner->email;
            $mail_data = ['username' => $owner->username, 'content' => $content];
            $this->send_custom_email($ownermail, $subject, 'mail.custom-email', $mail_data, $title);
        }

        return redirect()->intended('/traveler/chat/' . $chat_id . '?fb-key=personal_chat&fbkey=personal_chat');
    }

    public function delete_chat($id, Request $request)
    {
        $chat = DB::table('personal_chat')
            ->where('id', $id)
            ->first();
        $user_id = $request->session()->get('user_id');
        if ($chat->owner_id == $user_id) {
            DB::table('personal_chat')
                ->where('client_id', CLIENT_ID)
                ->where('id', $id)
                ->update(['owner_visible' => 0]);
        }
        if ($chat->traveller_id == $user_id) {
            DB::table('personal_chat')
                ->where('client_id', CLIENT_ID)
                ->where('id', $id)
                ->update(['traveler_visible' => 0]);
        }

        return redirect('owner/inbox');
    }

    public function delete_property_image($id)
    {
        $data = DB::table('property_images')
            ->where('id', $id)
            ->first();

        //$file_name = 'data/'.$property_id.'.json';
        //unlink($data->image_url);
        DB::table('property_images')
            ->where('id', $id)
            ->delete();
        return response()->json(['status' => 'SUCCESS']);
    }

    public function favorites(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $role_id = $request->session()->get('role_id');

        $properties = DB::table('user_favourites')
            ->join('property_list', 'property_list.id', '=', 'user_favourites.property_id')
            ->join(
                'property_short_term_pricing',
                'property_short_term_pricing.property_id',
                '=',
                'user_favourites.property_id',
            )
            ->join('property_room', 'property_room.property_id', '=', 'user_favourites.property_id')
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('user_favourites.user_id', '=', $user_id)
            ->get();

        $properties_near = [];
        foreach ($properties as $property) {
            $property->description = substr($property->description, 0, 170);
            $property->description .= '...';
            $pd = DB::table('property_images')
                ->where('property_images.client_id', '=', CLIENT_ID)
                ->where('property_images.property_id', '=', $property->property_id)
                ->orderBy('property_images.sort', 'asc')
                ->get();

            foreach ($pd as $images) {
                $img_url = $images->image_url;
                $property->image_url = $img_url;
            }

            $propertys = [];
            $propertysd = [];
            $propertys['image_url'] = STATIC_IMAGE;
            if (count($pd) == 0) {
                $propertysd[] = $propertys;
                $property->property_images = $propertysd;
                $property->image_url = STATIC_IMAGE;
            } else {
                $property->property_images = $pd;
            }

            $properties_near[] = $property;
        }

        return view('owner.favourites', ['properties' => $properties_near, 'role_id' => $role_id]);
    }

    public function fire_chat($id, Request $request)
    {
        if ($request->fbkey == "personal_chat") {
            $property = DB::table('personal_chat')
                ->where('id', $id)
                ->first();
            $traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->traveller_id)
                ->first();
            $owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->owner_id)
                ->first();
            return view('owner.fire_chat', ['owner' => $owner, 'traveller' => $traveller, 'id' => $id]);
        }
        $property = DB::table('property_booking')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $id)
            ->first();
        $traveller = DB::table('users')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $property->traveller_id)
            ->first();
        $owner = DB::table('users')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $property->owner_id)
            ->first();
        return view('owner.fire_chat', ['owner' => $owner, 'traveller' => $traveller, 'id' => $id]);
    }

    public function get_price(Request $request)
    {
        $guest_count = $request->guest_count == "Guests" ? 20 : $request->guest_count;
        $request->adults_count = $guest_count;
        $check_in = date('Y-m-d', strtotime($request->check_in));
        $check_out = date('Y-m-d', strtotime($request->check_out));

        $sql =
            "SELECT count(*) as is_available,B.total_guests FROM `property_booking` A, `property_list` B WHERE (A.start_date BETWEEN '" .
            $check_in .
            "' AND '" .
            $check_out .
            "') AND (A.end_date BETWEEN '" .
            $check_in .
            "' AND '" .
            $check_out .
            "')  AND B.minimum_guests < " .
            $guest_count .
            " AND A.payment_done = 1 AND A.is_instant = B.is_instant AND A.property_id = " .
            $request->property_id .
            "";

        $s_price =
            "SELECT count(*) as is_available,A.* FROM `property_special_pricing` A, `property_list` B WHERE (A.start_date  BETWEEN '" .
            $check_in .
            "' AND '" .
            $check_out .
            "') AND (A.end_date  BETWEEN '" .
            $check_in .
            "' AND '" .
            $check_out .
            "') AND A.property_id = " .
            $request->property_id .
            "";

        $pricing_config = DB::table('property_short_term_pricing')
            ->where('client_id', CLIENT_ID)
            ->where('property_id', $request->property_id)
            ->first();

        $special_price = DB::select($s_price);

        $is_available = DB::select($sql);

        $property_details = DB::table('property_list')
            ->where('client_id', CLIENT_ID)
            ->where('id', $request->property_id)
            ->first();

        $booking_count = DB::table('property_booking')
            ->where('client_id', CLIENT_ID)
            ->where('property_id', $request->property_id)
            ->count();

        $weeks = $this->get_weekend_count($check_in, $check_out);
        $weeks['total'] = $weeks['total'] - 1;

        if ($weeks['total'] < $property_details->min_days) {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'Please Select Minimum days ',
                'status_code' => ONE,
            ]);
        }

        if ($is_available[ZERO]->is_available == ZERO || $booking_count == ZERO) {
            $booking_price = [];
            $booking_price['client_id'] = CLIENT_ID;
            $booking_price['single_day_fare'] = $pricing_config->price_per_night;
            // $booking_price['single_day_fare'] = $pricing_config->price_per_night;
            $booking_price['total_days'] = $weeks['total'];
            //            $booking_price['price_per_extra_guest'] = $pricing_config->price_per_extra_guest;

            $total_days = $weeks['total'];

            // // edited By Karthik for Extra Guest systems.
            //     if($pricing_config->is_extra_guest!=0){
            //          $booking_price['no_extra_guest'] = 0;
            //         if($property_details->total_guests <$request->guest_count){
            //             $extra_guest=$request->guest_count-$property_details->total_guests;
            //             $extra_guest_price=$pricing_config->price_per_extra_guest*$extra_guest;
            //               $booking_price['is_extra_guest'] = 1;
            //         }else{
            //             $extra_guest=0;
            //             $extra_guest_price=0;
            //               $booking_price['is_extra_guest'] = 0;
            //         }
            //     }else{
            //         $extra_guest=0;
            //             $extra_guest_price=0;
            //         $booking_price['no_extra_guest'] = 1;
            //     }
            //     $booking_price['extra_guest'] = $extra_guest;

            // $booking_price['extra_guest_price'] = $extra_guest_price;

            // $week_end_pre = explode(",", $pricing_config->weekend_days);
            // $check_out_day = date('D', strtotime($request->check_out));
            // $check_in_day = date('D', strtotime($request->check_in));
            // $week_end_days = ZERO;
            // foreach ($week_end_pre as $week_day) {
            //     if(!in_array($check_out_day, $week_end_pre)){
            //         switch ($week_day) {
            //             case 'Fri';
            //                 $week_end_days = $week_end_days + $weeks['friday_count'];
            //                 break;

            //             case 'Sat';
            //                 $week_end_days = $week_end_days + $weeks['saturday_count'];
            //                 break;

            //             case 'Sun';
            //                 $week_end_days = $week_end_days + $weeks['sunday_count'];
            //                 break;
            //         }
            //     }
            // }

            $normal_days = $weeks['total'];

            // $normal_days = $normal_days - 1;
            if ($weeks['total'] > 30) {
                $pricing_config->price_per_night = $pricing_config->price_more_than_one_month;
                $booking_price['single_day_fare'] = $pricing_config->price_more_than_one_month;
                $pricing_config->price_per_weekend = 0;
                $week_end_days = 0;
                $price = $weeks['total'] * $pricing_config->price_per_night;
                $booking_price['normal_days'] = $weeks['total'];
            } else {
                $week_end_days = 0;
                $booking_price['normal_days'] = $weeks['total'];
                $booking_price['normal_days'] = $normal_days;
                $price = $normal_days * $pricing_config->price_per_night;
            }

            $booking_price['week_end_days'] = $week_end_days;
            $booking_price['price_per_weekend'] = $pricing_config->price_per_weekend;
            $booking_price['weekend_total'] = $pricing_config->price_per_weekend * $week_end_days;

            $cleaning_fee_amount = ZERO;
            $city_fee_amount = ZERO;
            if ($total_days <= 30) {
                $service_tax = DB::table('settings')
                    ->where('param', 'traveller_below_30_days')
                    ->first();
                $admin_commision = DB::table('settings')
                    ->where('param', 'traveller_below_30_days')
                    ->first();
            } else {
                $service_tax = DB::table('settings')
                    ->where('param', 'traveler_above_30_days')
                    ->first();
                $admin_commision = DB::table('settings')
                    ->where('param', 'traveler_above_30_days')
                    ->first();
            }

            $adminCommision = $admin_commision->value + $service_tax->value;
            // switch ($pricing_config->cleaning_fee_type) {
            //     case "Flat Rate Fee";
            //      $cleaning_fee_amount = $service_tax->value;
            //         break;

            //     case "Per Day";
            //         $cleaning_fee_amount = $weeks['total'] * $pricing_config->cleaning_fee;
            //         break;

            //     case "Per Month";
            //         $cleaning_fee_amount = $pricing_config->cleaning_fee;
            //         break;

            // }
            $cleaning_fee_amount = $service_tax->value;
            $booking_price['cleaning_fare'] = $service_tax->value;

            /*
             * Cleaning fee calculation ended
             */

            /*
             *
             * Total amount calculation
             */
            $total_price = $price + $cleaning_fee_amount + $pricing_config->security_deposit + $service_tax->value;
            //$tax_value = $this->get_percentage($pricing_config->tax, $total_price);
            $due_now = $this->get_percentage($pricing_config->first_payment_percentage, $total_price);
            $booking_price['service_tax'] = $service_tax->value;
            //$booking_price['tax_amount'] = $tax_value;
            $booking_price['initial_pay'] = $due_now;
            //$booking_price['total_amount'] = $total_price + $tax_value;
            $booking_price['total_amount'] = $total_price;
            $booking_price['check_in'] = $check_in;
            $booking_price['check_out'] = $check_out;
            $booking_price['city_fee_amount'] = $city_fee_amount;
            $booking_price['security_deposit'] = $pricing_config->security_deposit;
            $booking_price['sub_total'] = $total_price;
            $booking_price['price'] = $price;

            return response()->json(['status' => 'SUCCESS', 'data' => $booking_price, 'status_code' => ONE]);
        } else {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'This property not available',
                'status_code' => ZERO,
            ]);
        }
    }

    public function inbox(Request $request)
    {
        $user_id = $request->session()->get('user_id');

        $request_chats = DB::table('request_chat')
            ->where('client_id', '=', CLIENT_ID)
            ->where('request_chat.owner_id', '=', $user_id)
            ->get();

        foreach ($request_chats as $request_chat) {
            $request_chat->traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->traveller_id)
                ->first();
            $request_chat->owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->owner_id)
                ->first();
            $request_chat->chat_key = 'request_chat';
            $request_chat->last_message = $this->get_firebase_last_message('request_chat', $request_chat->id);
        }

        $instant_chats = DB::table('instant_chat')
            ->where('client_id', '=', CLIENT_ID)
            ->where('instant_chat.owner_id', '=', $user_id)
            ->get();
        foreach ($instant_chats as $request_chat) {
            $request_chat->traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->traveller_id)
                ->first();
            $request_chat->owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->owner_id)
                ->first();
            $request_chat->chat_key = 'instant_chat';
            $request_chat->last_message = $this->get_firebase_last_message('instant_chat', $request_chat->id);
        }
        // echo $user_id;
        $personal_chats = DB::table('personal_chat')
            ->where('client_id', '=', CLIENT_ID)
            ->where('personal_chat.owner_id', '=', $user_id)
            ->where('owner_visible', 1)
            ->get();

        foreach ($personal_chats as $request_chat) {
            $request_chat->traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->traveller_id)
                ->first();
            $request_chat->owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->owner_id)
                ->first();
            $request_chat->chat_key = 'personal_chat';
            $request_chat->last_message = $this->get_firebase_last_message('personal_chat', $request_chat->id);
        }

        $results = [];
        $results[] = $request_chats;
        $results[] = $instant_chats;
        $results[] = $personal_chats;

        $f_result = $results[0];

        // print_r($results);exit;
        return view('owner.my-inbox', ['properties' => $results]);
    }

    public function inbox_traveller(Request $request)
    {
        $user_id = $request->session()->get('user_id');

        $request_chats = DB::table('request_chat')
            ->where('client_id', '=', CLIENT_ID)
            ->where('request_chat.traveller_id', '=', $user_id)
            ->get();
        foreach ($request_chats as $request_chat) {
            $request_chat->traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->traveller_id)
                ->first();
            $request_chat->owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->owner_id)
                ->first();
            $request_chat->chat_key = 'request_chat';
            $request_chat->last_message = $this->get_firebase_last_message('request_chat', $request_chat->id);
        }

        $instant_chats = DB::table('instant_chat')
            ->where('client_id', '=', CLIENT_ID)
            ->where('instant_chat.traveller_id', '=', $user_id)
            ->get();
        foreach ($instant_chats as $request_chat) {
            $request_chat->traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->traveller_id)
                ->first();
            $request_chat->owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->owner_id)
                ->first();
            $request_chat->chat_key = 'instant_chat';
            $request_chat->last_message = $this->get_firebase_last_message('instant_chat', $request_chat->id);
        }

        $personal_chats = DB::table('personal_chat')
            ->where('client_id', '=', CLIENT_ID)
            ->where('personal_chat.traveller_id', '=', $user_id)
            ->where('traveler_visible', 1)
            ->get();
        foreach ($personal_chats as $request_chat) {
            $request_chat->traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->traveller_id)
                ->first();
            $request_chat->owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->owner_id)
                ->first();
            $request_chat->chat_key = 'personal_chat';
            $request_chat->last_message = $this->get_firebase_last_message('personal_chat', $request_chat->id);
        }

        $results = [];
        $results[] = $request_chats;
        $results[] = $instant_chats;
        $results[] = $personal_chats;

        $f_result = $results[0];

        return view('traveller.inbox-listing', ['properties' => $results]);
    }

    public function owner_update_booking(Request $request)
    {
        DB::table('property_booking')
            ->where('booking_id', $request->booking_id)
            ->update(['status' => $request->status]);
        if ($request->status == 4) {
            $booking = DB::table('property_booking')
                ->where('booking_id', $request->booking_id)
                ->leftjoin('property_list', 'property_list.id', '=', 'property_booking.property_id')
                ->leftjoin('users', 'users.id', '=', 'property_booking.traveller_id')
                ->select(
                    'users.first_name',
                    'users.last_name',
                    'property_list.title',
                    'property_booking.*',
                    'users.email',
                )
                ->first();
            $user = DB::table('users')
                ->where('client_id', CLIENT_ID)
                ->where('id', $booking->owner_id)
                ->first();
            $mail_data = [
                'owner_name' => $user->first_name . " " . $user->last_name,
                'booking_id' => $booking->booking_id,
                'property' => $booking->title,
                'mail_to' => 'traveller',
                'traveler' => $booking->first_name . " " . $booking->last_name,
            ];
            $this->send_email($booking->email, 'mail.cancel_booking', $mail_data);
        }
        return response()->json(['status' => 'SUCCESS']);
    }

    public function reservations(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $data = DB::select(
            "SELECT A.*,A.status as bookStatus,B.* FROM `property_booking` A,`property_list` B WHERE A.property_id = B.id AND A.traveller_id = $user_id",
        );
        DB::table('property_booking')
            ->where('property_booking.traveller_id', $request->session()->get('user_id'))
            ->update(['traveler_notify' => 0]);
        foreach ($data as $datum) {
            $traveller = DB::select(
                "SELECT concat(first_name,last_name) as name,id FROM users WHERE client_id = CLIENT_ID AND id = $datum->owner_id LIMIT 1",
            );

            $image = DB::table('property_images')
                ->where('client_id', CLIENT_ID)
                ->where('property_id', $datum->property_id)
                ->first();
            $datum->image_url = $image->image_url;
            $datum->owner_name = $traveller[0]->name;
            $datum->owner_id = $traveller[0]->id;
        }
        return view('owner.reservations', ['bookings' => $data]);
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
        if (Session::has('role_id')) {
            if (Session::get('role_id') == 3) {
                $where[] = 'property_list.property_type_rv_or_home = 1';
            } else {
                $where[] = 'property_list.property_type_rv_or_home = 2';
            }
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
        return view('search_property')
            ->with('properties', $nearby_properties)
            ->with('total_count', $total_count)
            ->with('location_url', $lat_lng_url)
            ->with('request_data', $request_data)
            ->with('total_properties', $total_properties)
            ->with('next', $page)
            ->with('room_types', $room_types);
    }

    public function set_favourite($property_id, Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $favourite = DB::table('user_favourites')
            ->where('user_favourites.client_id', '=', CLIENT_ID)
            ->where('user_favourites.user_id', '=', $user_id)
            ->where('user_favourites.property_id', '=', $property_id)
            ->get();
        if (count($favourite) != 0) {
            $favourite = DB::table('user_favourites')
                ->where('user_favourites.client_id', '=', CLIENT_ID)
                ->where('user_favourites.user_id', '=', $user_id)
                ->where('user_favourites.property_id', '=', $property_id)
                ->delete();
            return response()->json(['status' => 'SUCCESS', 'message' => 'Removed from favourites', 'code' => 0]);
        } else {
            $insert = DB::table('user_favourites')->insert([
                'client_id' => CLIENT_ID,
                'user_id' => $user_id,
                'property_id' => $property_id,
            ]);
            return response()->json(['status' => 'SUCCESS', 'message' => 'Added to favourites', 'code' => 1]);
        }
    }

    public function single_property($property_id, Request $request)
    {
        if ($request->reviews) {
            $properties = DB::table('property_list')
                ->leftjoin('users', 'users.id', '=', 'property_list.user_id')
                ->leftjoin('property_images', 'property_images.property_id', '=', 'property_list.id')
                ->leftjoin('property_room', 'property_room.property_id', '=', 'property_list.id')
                ->leftjoin(
                    'property_short_term_pricing',
                    'property_short_term_pricing.property_id',
                    '=',
                    'property_list.id',
                )
                ->leftjoin('property_video', 'property_video.property_id', '=', 'property_list.id')
                ->leftjoin('country', 'country.id', 'property_list.country')
                ->where('property_list.client_id', '=', CLIENT_ID)
                ->where('property_list.id', '=', $property_id)
                ->select(
                    'property_images.*',
                    'property_room.*',
                    'property_short_term_pricing.*',
                    'property_video.*',
                    'property_list.*',
                    'users.*',
                    'property_list.state as prop_state',
                    'property_list.city as prop_city',
                    'country.country_name',
                )
                ->first();
            //print_r($properties);exit;

            $reviews = DB::table('property_review')
                ->join('users', 'users.id', '=', 'property_review.reviewed_by')
                ->where('property_review.property_id', $property_id)
                ->get();
            $reviews_count = DB::table('property_review')
                ->join('users', 'users.id', '=', 'property_review.reviewed_by')
                ->where('property_review.property_id', $property_id)
                ->count();
            $properties->reviews_count = $reviews_count;

            $avg_rating = DB::select(
                "SELECT AVG(A.review_rating) as avg_rating FROM property_review A, property_list B, users C WHERE C.id = B.user_id AND A.property_id = B.id AND A.property_id = $property_id",
            );
            $ratng = $avg_rating[0]->avg_rating;

            $properties->avg_rating = $ratng;
            $properties->reviews_data = $reviews;
            return view('all-reviews', ['data' => $properties]);
        }

        $properties = DB::table('property_list')
            ->leftjoin('users', 'users.id', '=', 'property_list.user_id')
            ->leftjoin('property_images', 'property_images.property_id', '=', 'property_list.id')
            ->leftjoin('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->join('property_short_term_pricing', 'property_short_term_pricing.property_id', '=', 'property_list.id')
            ->leftjoin('property_video', 'property_video.property_id', '=', 'property_list.id')
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('property_list.id', '=', $property_id)
            ->select(
                'property_list.*',
                'users.first_name',
                'users.last_name',
                'users.profile_image',
                'users.device_token',
                'property_short_term_pricing.*',
                'property_images.image_url',
                'property_room.*',
                'property_video.url',
            )
            ->first();

        if ($properties) {
            // SELECT GROUP_CONCAT(bed_type) FROM `property_bedrooms` WHERE `property_id` = 1 AND `bedroom_number` = 1

            $property_bedrooms = DB::table('property_bedrooms')
                ->where('property_id', $property_id)
                ->get();
            $temp_bed_rooms = [];
            $temp_rooms = [];
            foreach ($property_bedrooms as $key => $value) {
                $sql = "SELECT GROUP_CONCAT(bed_type,' - ',count) as bed_types FROM `property_bedrooms` WHERE `property_id` = $property_id AND `bedroom_number` = $value->bedroom_number AND `count` != 0";
                $bed_rooms = DB::select($sql);

                if (in_array($bed_rooms, $temp_bed_rooms)) {
                } else {
                    $temp_bed_rooms[] = $bed_rooms;
                    $temp_rooms[] = [$bed_rooms[0]->bed_types];
                }
            }

            $bed_list = DB::table('property_bedrooms')
                ->where('property_bedrooms.client_id', '=', CLIENT_ID)
                ->where('property_bedrooms.property_id', '=', $property_id)
                ->where('property_bedrooms.count', '!=', 0)
                ->select('count', 'bed_type')
                ->get();

            foreach ($bed_list as $bed) {
                $bed->count = (string) $bed->count;
                switch ($bed->bed_type) {
                    case "double_bed":
                        $bed->bed_type = "Double Bed";
                        $bed->icon_url = DOUBLE_BED;
                        break;
                    case "queen_bed":
                        $bed->bed_type = "Queen Bed";
                        $bed->icon_url = QUEEN_BED;
                        break;
                    case "single_bed":
                        $bed->bed_type = "Single Bed";
                        $bed->icon_url = SINGLE_BED;
                        break;
                    case "sofa_bed":
                        $bed->bed_type = "Sofa Bed";
                        $bed->icon_url = SOFA_BED;
                        break;
                    case "bunk_bed":
                        $bed->bed_type = "Bunk Bed";
                        $bed->icon_url = BUNK_BED;
                        break;
                    default:
                        $bed->bed_type = "Common Space";
                        $bed->icon_url = COMMON_SPACE_BED;
                }
            }

            $properties->bed_rooms = $bed_list;

            $amenties = DB::table('property_amenties')
                ->where('property_amenties.client_id', '=', CLIENT_ID)
                ->where('property_amenties.property_id', '=', $property_id)
                ->join('amenities_list', 'property_amenties.amenties_name', '=', 'amenities_list.amenities_name')
                ->select('amenities_list.amenities_name as amenties_name', 'amenities_list.icon_url as amenties_icon')
                ->get();

            //print_r($amenties);exit;

            $properties->amenties = $amenties;

            $prop_full_rating = DB::table('property_rating')
                ->where('property_rating.client_id', '=', CLIENT_ID)
                ->join('users', 'users.id', '=', 'property_rating.user_id')
                ->where('property_rating.property_id', '=', $property_id)
                ->select('property_rating.*', 'users.first_name', 'users.last_name', 'users.profile_image')
                ->get();
            if (count($prop_full_rating) > 0) {
                $properties->prop_full_rating = $prop_full_rating;
            } else {
                $properties->prop_full_rating = [];
            }
            $favourite = DB::table('user_favourites')
                ->where('user_favourites.client_id', '=', CLIENT_ID)
                ->where('user_favourites.user_id', '=', $request->session()->get('user_id'))
                ->where('user_favourites.property_id', '=', $property_id)
                ->count();
            if ($favourite != 0) {
                $properties->is_favourite = 1;
            } else {
                $properties->is_favourite = 0;
            }
            $pd = DB::table('property_images')
                ->where('property_images.client_id', '=', CLIENT_ID)
                ->where('property_images.property_id', '=', $property_id)
                ->orderBy('property_images.sort', 'asc')
                ->select('property_images.image_url')
                ->get();
            $properties->property_images = $pd;
            $location = $properties->location;
        }
        $result = $properties;

        if ($request->price_high_to_low) {
            $properties = DB::table('property_list')
                ->where('property_list.client_id', '=', CLIENT_ID)
                ->orderBy('price_per_weekend', 'DESC')
                ->get();
        }
        if ($request->price_low_to_high) {
            $properties = DB::table('property_list')
                ->where('property_list.client_id', '=', CLIENT_ID)
                ->orderBy('price_per_weekend', 'ASC')
                ->get();
        }

        $latest_properties = DB::table('property_list')
            ->leftjoin('users', 'users.id', '=', 'property_list.user_id')
            ->leftjoin(
                'property_short_term_pricing',
                'property_short_term_pricing.property_id',
                '=',
                'property_list.id',
            )
            ->leftjoin('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('property_list.is_complete', '=', ACTIVE)
            ->where('property_list.property_status', '=', 1)
            ->where('property_list.status', '=', 1)
            ->where('property_list.id', '!=', $property_id)
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

            $property->image_url = isset($pd->image_url) ? $pd->image_url : '';
        }

        $properties = $latest_properties;

        //price_per_weekend
        $properties_near = [];

        foreach ($properties as $property) {
            $pd = DB::table('property_images')
                ->where('property_images.client_id', '=', CLIENT_ID)
                ->where('property_images.property_id', '=', $property->property_id)
                ->orderBy('property_images.sort', 'asc')
                ->select('property_images.image_url')
                ->get();
            $propertys = [];
            $propertysd = [];
            $propertys['image_url'] = STATIC_IMAGE;
            if (count($pd) == 0) {
                $propertysd[] = $propertys;
                $property->property_images = $propertysd;
            } else {
                $property->property_images = $pd;
            }

            $favourite = DB::table('user_favourites')
                ->where('user_favourites.client_id', '=', CLIENT_ID)
                ->where('user_favourites.user_id', '=', $request->session()->get('user_id'))
                ->where('user_favourites.property_id', '=', $property->property_id)
                ->count();
            if ($favourite != 0) {
                $property->is_favourite = 1;
            } else {
                $property->is_favourite = 0;
            }

            if ($properties) {
                $source_location = $properties[0]->location; //$location;
                $source_location = urlencode($source_location);
                $loc = $property->location;
                $location = explode(',', $property->location);
                $getLoc = end($location);
                $property->property_country = $getLoc;
                $property->location = urlencode($property->location);
                $url =
                    "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" .
                    $source_location .
                    "&destinations=" .
                    $property->location .
                    "&key=AIzaSyCD_0PVfhwHKvGcB4SUFq2ZBT0GOW900Bg"; //exit;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $response = json_decode($response); //dd($response); exit;
                if (isset($response->rows[0]->elements[0]->status) != 'ZERO_RESULTS') {
                    // echo $response->rows[0]->elements[0]->distance->text;exit;
                    // $distance = (float) $response->rows[0]->elements[0]->distance->text;
                    if (isset($response->rows[0]->elements[0]->distance->text) <= $this->get_radius()) {
                        $property->location = $loc;
                        $property->property_id = $property->property_id;
                        $properties_near[] = $property;
                    } else {
                        $properties_near[] = $property;
                    }
                } else {
                    if ($property->property_id != $property_id) {
                        $properties_near[] = $property;
                    }
                }
            }
        } //array_multisort(array_column($inventory, 'price'), SORT_DESC, $inventory);

        $booked_dates = DB::table('property_booking')
            ->where('property_booking.client_id', '=', CLIENT_ID)
            ->where('property_booking.payment_done', '=', 1)
            ->where('property_booking.property_id', '=', $property_id)
            ->select('start_date', 'end_date')
            ->get();

        $b_dates = [];
        foreach ($booked_dates as $booked_date) {
            $strDateFrom = date("Y-m-d", strtotime($booked_date->start_date));
            $strDateTo = date("Y-m-d", strtotime($booked_date->end_date));
            $dates_list = $this->createDateRangeArray($strDateFrom, $strDateTo);
            foreach ($dates_list as $item) {
                $item = date("m/d/Y", strtotime($item));
                $b_dates[] = ["dates" => $item];
            }
        }

        $blocked_dates = DB::table('property_blocking')
            ->where('property_blocking.client_id', '=', CLIENT_ID)
            ->where('property_blocking.property_id', '=', $property_id)
            ->select('start_date')
            ->get();

        foreach ($blocked_dates as $item) {
            $item = date("m/d/Y", strtotime($item->start_date));
            $b_dates[] = ["dates" => $item];
        }
        // print_r($b_dates);exit;
        $user_id = $request->session()->get('user_id');
        $current_user = DB::table('users')
            ->where('id', $user_id)
            ->first();
        $arr = [];
        if ($request->session()->get('propertyId')) {
            $arr = [
                'property_id' => $request->session()->get('propertyId'),
                'fromDate' => $request->session()->get('fromDate'),
                'toDate' => $request->session()->get('toDate'),
                'guest_count' => $request->session()->get('guest_count'),
            ];

            $request->session()->forget('propertyId');
            $request->session()->forget('fromDate');
            $request->session()->forget('toDate');
            $request->session()->forget('guest_count');
        }

        $user_id = $request->session()->get('role_id');
        if ($user_id) {
            $is_user = 1;
        } else {
            $is_user = 0;
        }
        //print_r($b_dates);exit;
        $f_result = [
            'status' => 'SUCCESS',
            'is_user' => $is_user,
            'current_user' => $current_user,
            'bed_rooms' => $temp_bed_rooms,
            'data' => $result,
            'booked_dates' => $b_dates,
            'properties_near' => $properties_near,
            'property_id' => $property_id,
            'session' => $arr,
            'properties' => $properties,
        ];

        //print_r($f_result);exit;

        if ($f_result['data']->pets_allowed == 1) {
            $pets = $this->yelp_pets($f_result['data']->lat, $f_result['data']->lng);
        } else {
            $pets = [];
        }
        $hospitals = $this->yelp_hospitals($f_result['data']->lat, $f_result['data']->lng);

        return view('property', $f_result)
            ->with('hospitals', $hospitals)
            ->with('pets', $pets);
    }

    public function traveller_fire_chat($id, Request $request)
    {
        if ($request->fbkey == "personal_chat") {
            $property = DB::table('personal_chat')
                ->where('id', $id)
                ->first();
            // echo json_encode($property);exit;
            $traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->traveller_id)
                ->first();
            $owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->owner_id)
                ->first();
            return view('traveller.fire_chat', [
                'owner' => $owner,
                'traveller' => $traveller,
                'id' => $id,
                'traveller_id' => $property->traveller_id,
            ]);
        }
        if ($request->fbkey == "request_chat") {
            $property = DB::table('request_chat')
                ->where('id', $id)
                ->first();
            $traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->traveller_id)
                ->first();

            $owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->owner_id)
                ->first();
            //dd($owner->id);
            return view('traveller.fire_chat', [
                'owner' => $owner,
                'traveller' => $traveller,
                'id' => $id,
                'traveller_id' => $traveller->id,
                'owner_id' => $owner->id,
            ]);
        }
        $property = DB::table('property_booking')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $id)
            ->first();
        $traveller = DB::table('users')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $property->traveller_id)
            ->first();
        $owner = DB::table('users')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $property->owner_id)
            ->first();
        //echo json_encode($traveller); exit;

        return view('traveller.fire_chat', ['owner' => $owner, 'traveller' => $traveller, 'id' => $id]);
    }

    public function update_cover_image($id, $property_id)
    {
        DB::table('property_images')
            ->where('property_id', $property_id)
            ->update(['is_cover' => 0]);
        DB::table('property_images')
            ->where('property_id', $property_id)
            ->where('id', $id)
            ->update(['is_cover' => 1]);

        return response()->json(['status' => 'SUCCESS']);
    }

    public function add_property(Request $request)
    {
        $client_id = CLIENT_ID;
        session()->forget('property_id');

        //        $property_id = $request->session()->get('property_id');
        //        if ($property_id) {
        //            $property_details = DB::table('property_list')
        //                ->where('client_id', '=', CLIENT_ID)
        //                ->where('id', '=', $property_id)
        //                ->first();
        //            return view('owner.add_property')
        //                ->with('client_id', $client_id)
        //                ->with('stage', 0)
        //                ->with('property_details', $property_details);
        //        } else {
        $property_details = new \stdClass();
        $property_details->stage = 0;
        $property_details->is_complete = 0;
        return view('owner.add_property')
            ->with('client_id', $client_id)
            ->with('stage', 0)
            ->with('property_details', $property_details);
        //        }
    }

    public function add_new_property(Request $request)
    {
        if (!$request->user_id) {
            $request->user_id = $request->session()->get('user_id');
        }

        $property_id = $request->session()->get('property_id');
        if ($property_id) {
            $new_property = PropertyList::find($property_id);
        } else {
            $new_property = new PropertyList();
        }
        $new_property->client_id = $request->client_id;
        $new_property->user_id = $request->user_id;

        $new_property->address = implode(", ", array_filter([$request->street_number, $request->route]));
        $new_property->building_number = $request->building_number;
        //        $new_property->location = urldecode($request->mlocation);
        $new_property->city = $request->city;
        $new_property->state = $request->state;
        $new_property->zip_code = $request->pin_code;
        $new_property->country = $request->country;
        $new_property->stage = 1;

        //        //Get LatLong From Address
        //        $address =
        //            $request->location .
        //            "," .
        //            $new_property->address .
        //            "," .
        //            $new_property->city .
        //            "," .
        //            $new_property->state .
        //            "," .
        //            $new_property->zip_code;
        //        $formattedAddr = str_replace(' ', '+', $address);

        if ($request->mlat != "") {
            $new_property->lat = $request->mlat;
        }

        if ($request->mlng != "") {
            $new_property->lng = $request->mlng;
        }

        $new_property->save();

        if (isset($request->save)) {
            session()->forget('property_id');
            $url = BASE_URL . "owner/calender?id=" . $new_property->id;
        } else {
            $url = BASE_URL . 'owner/add-new-property/2/' . $new_property->id;
        }

        return redirect($url);
    }

    public function property_next($stage, $property_id, Request $request)
    {
        //ical
        $property_details = DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', '=', $property_id)
            ->first();
        $request->session()->put('property_id', $property_id);
        if (!$property_details) {
            return back()->with('error', 'Wrong information try again');
        }
        switch ($stage) {
            case 2:
                $property_room = DB::table('property_room')
                    ->where('property_id', $property_id)
                    ->first();
                $property_data = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->first();
                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['on_stage' => 2]);

                $room_types = DB::table('property_room_types')->get();
                $property_types = DB::table('property_types')->get();
                $client_id = CLIENT_ID;
                //code to be executed if n=label1; ->with('stage',$stage)
                $property_bedrooms = DB::table('property_bedrooms')
                    ->where('property_id', $property_id)
                    ->where('is_common_space', 0)
                    ->select(
                        DB::raw('GROUP_CONCAT(bed_type) as bed_types'),
                        DB::raw('GROUP_CONCAT(count) as counts'),
                        'bedroom_number',
                        DB::raw('SUM(count) as total'),
                    )
                    ->groupBy('bedroom_number')
                    ->get();

                $common_space = DB::table('property_bedrooms')
                    ->where('property_id', $property_id)
                    ->where('is_common_space', '!=', 0)
                    ->select(
                        DB::raw('GROUP_CONCAT(bed_type) as bed_types'),
                        DB::raw('GROUP_CONCAT(count) as counts'),
                        'bedroom_number',
                        DB::raw('SUM(count) as total'),
                    )
                    ->groupBy('bedroom_number')
                    ->get();

                //print_r($common_space);
                // print_r($property_bedrooms); exit;
                $final = [];
                foreach ($property_bedrooms as $val) {
                    $final[$val->bedroom_number] = [];
                    $bed_type = explode(",", $val->bed_types);
                    $bed_count = explode(",", $val->counts);
                    for ($i = 0; $i < count($bed_type); $i++) {
                        if ($bed_type[$i] == "double_bed") {
                            $final[$val->bedroom_number]['double_bed'] = $bed_count[$i];
                        }
                        if ($bed_type[$i] == "queen_bed") {
                            $final[$val->bedroom_number]['queen_bed'] = $bed_count[$i];
                        }
                        if ($bed_type[$i] == "single_bed") {
                            $final[$val->bedroom_number]['single_bed'] = $bed_count[$i];
                        }
                        if ($bed_type[$i] == "sofa_bed") {
                            $final[$val->bedroom_number]['sofa_bed'] = $bed_count[$i];
                        }
                        if ($bed_type[$i] == "bunk_bed") {
                            $final[$val->bedroom_number]['bunk_bed'] = $bed_count[$i];
                        }
                    }
                    $final[$val->bedroom_number]["total"] = $val->total;
                    $bed_type = [];
                    $bed_count = [];
                }

                //$common_spc=array();
                if (count($common_space) > 0) {
                    $c_beds = explode(",", $common_space[0]->bed_types);
                    $c_count = explode(",", $common_space[0]->counts);
                    //print_r($c_count);
                    for ($i = 0; $i < count($c_beds); $i++) {
                        if ($c_beds[$i] == "queen_bed") {
                            $common_spc['queen_bed'] = $c_beds[$i];
                            $common_spc['queen_bed'] = $c_count[$i];
                        }
                        if ($c_beds[$i] == "double_bed") {
                            $common_spc['double_bed'] = $c_beds[$i];
                            $common_spc['double_bed'] = $c_count[$i];
                        }
                        if ($c_beds[$i] == "single_bed") {
                            $common_spc['single_bed'] = $c_beds[$i];
                            $common_spc['single_bed'] = $c_count[$i];
                        }
                        if ($c_beds[$i] == "sofa_bed") {
                            $common_spc['sofa_bed'] = $c_beds[$i];
                            $common_spc['sofa_bed'] = $c_count[$i];
                        }
                        if ($c_beds[$i] == "bunk_bed") {
                            $common_spc['bunk_bed'] = $c_beds[$i];
                            $common_spc['bunk_bed'] = $c_count[$i];
                        }
                        $common_spc['total'] = $common_space[0]->total;
                    }
                }

                //print_r($final);exit;

                // print_r($property_details);exit;
                //print_r($final);exit;
                $array = json_decode(json_encode($property_bedrooms), true);
                $guest_count = DB::table('settings')
                    ->where('param', 'guest_count')
                    ->select('value')
                    ->first();
                $bed_count = DB::table('settings')
                    ->where('param', 'bedroom_count')
                    ->select('value')
                    ->first();
                //print_r($common_spc);exit;

                // print_r($property_data);exit;
                return view('owner.add-property.2', [
                    'property_details' => $property_details,
                    'property_room' => $property_room,
                ])
                    ->with('stage', $stage)
                    ->with('property_data', $property_data)
                    ->with('client_id', $client_id)
                    ->with('room_types', $room_types)
                    ->with('property_types', $property_types)
                    ->with('property_bedrooms', $final)
                    ->with('common_spc', isset($common_spc) ? $common_spc : [])
                    ->with('guest_count', isset($guest_count->value) ? $guest_count->value : '')
                    ->with('bed_count', isset($bed_count->value) ? $bed_count->value : '');

                break;

            case 3:
                $property_data = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->first();

                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['on_stage' => 3]);
                $client_id = CLIENT_ID;
                //code to be executed if n=label2;
                return view('owner.add-property.3', ['property_details' => $property_details])
                    ->with('stage', $stage)
                    ->with('property_data', $property_data)
                    ->with('client_id', $client_id);
                break;

            case 4:
                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['on_stage' => 4]);
                $property_data = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->first();

                $price = DB::table('property_short_term_pricing')
                    ->where('property_id', $request->property_id)
                    ->first();
                // print_r($price);exit;
                $client_id = CLIENT_ID;
                //code to be executed if n=label3;
                return view('owner.add-property.4', [
                    'price' => $price,
                    'property_details' => $property_details,
                    'property_data' => $property_data,
                ])
                    ->with('stage', $stage)
                    ->with('client_id', $client_id);
                break;

            case 5:
                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['on_stage' => 5]);
                $client_id = CLIENT_ID;
                $property_images = DB::table('property_images')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('property_id', '=', $property_id)
                    ->get();
                //code to be executed if n=label3;
                $country = DB::table('country')
                    ->where('client_id', '=', CLIENT_ID)
                    ->get();
                $state = DB::table('state')
                    ->where('client_id', '=', CLIENT_ID)
                    ->get();
                //var_dump($property_details); exit;
                return view('owner.add-property.5', [
                    'property_details' => $property_details,
                    'country' => $country,
                    'state' => $state,
                ])
                    ->with('stage', $stage)
                    ->with('client_id', $client_id)
                    ->with('property_images', $property_images);
                break;

            case 6:
                $amenties = Propertyamenties::where('property_id', $property_id)->get();
                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['on_stage' => 6]);
                $client_id = CLIENT_ID;
                //code to be executed if n=label3;
                // print_r($amenties);exit;
                return view('owner.add-property.6', ['amenties' => $amenties, 'property_details' => $property_details])
                    ->with('stage', $stage)
                    ->with('client_id', $client_id);
                break;

            case 7:
                # code...

                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['on_stage' => 7]);

                if ($property_id) {
                    $property_rate = DB::table('property_short_term_pricing')
                        ->where('property_id', $property_id)
                        ->select('price_per_night')
                        ->first();

                    $list = [];

                    $month = date('m');
                    $year = date('Y');
                    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    for ($d = 1; $d <= $days; $d++) {
                        $time = mktime(12, 0, 0, $month, $d, $year);
                        if (date('m', $time) == $month) {
                            $list[$d]['date'] = date('Y-m-d', $time);
                        }
                        $list[$d]['price'] = $property_rate->price_per_night;
                    }
                    $icals = DB::table('third_party_calender')
                        ->where('property_id', '=', $property_id)
                        ->get();
                    $events = DB::table('property_booking')
                        ->where('client_id', '=', CLIENT_ID)
                        ->where('property_id', '=', $property_id)
                        ->get();
                    $block_events = DB::table('property_blocking')
                        ->where('client_id', '=', CLIENT_ID)
                        ->where('property_id', '=', $property_id)
                        ->get();
                    $special_price = DB::table('property_special_pricing')
                        ->where('client_id', '=', CLIENT_ID)
                        ->where('property_id', '=', $property_id)
                        ->get();

                    //print_r($special_price);
                    $dates = [];

                    for ($i = 0; $i < count($special_price); $i++) {
                        $dates[$i]['date'] = $special_price[$i]->start_date;
                        $dates[$i]['price'] = $special_price[$i]->price_per_night;
                    }

                    //print_r($dates);exit;

                    $finn = [];
                    $finn = array_merge($dates, $list);
                    // print_r($finn);exit;
                    $res = [];
                    $val = [];
                    foreach ($finn as $key => $index) {
                        if (!in_array($index['date'], $val)) {
                            if ($index['date']) {
                                $val[] = $index['date'];
                                $res[] = $index;
                            }
                        }
                    }

                    foreach ($events as $key => $value) {
                        if ($value->is_instant < 2) {
                            $value->booked_on = APP_BASE_NAME;
                        } else {
                            $value->booked_on = 'Airbnb';
                        }
                    }
                } else {
                    $events = [];
                    $icals = [];
                    $property_rate = new stdClass();
                    $property_rate->price_per_night = 0;
                    $res = [];
                    $block_events = [];
                }
                //                print_r($block_events);exit();
                return view(
                    'owner.add-property.7',
                    compact('property_details', 'events', 'icals', 'block_events', 'res'),
                )
                    ->with('stage', $stage)
                    ->with('client_id', CLIENT_ID);
                break;

            default:
                //code to be executed if n is different from all labels;
                return back()->with('error', 'Wrong information try again');
        }
    }

    public function property_next2(Request $request)
    {
        // print_r($request->all());exit;
        // print_r($request->all());exit;
        //$new_property = App\PropertyList::find($request->property_id); //new PropertyList($request->property_id);
        DB::table('property_bedrooms')
            ->where('client_id', CLIENT_ID)
            ->where('property_id', $request->property_id)
            ->delete();
        DB::table('property_room')
            ->where('client_id', CLIENT_ID)
            ->where('property_id', $request->property_id)
            ->delete();
        $request->check_in_time = date("H:i:s", strtotime($request->check_in_time));
        $request->check_out_time = date("H:i:s", strtotime($request->check_out_time));
        $countbed = $request->bed_count != "" ? $request->bed_count : 0;
        if (isset($request->room_type) && $request->room_type == "Entire Room") {
            $request->cur_adults = 0;
            $request->cur_child = 0;
            $request->cur_pets = 0;
        }

        DB::table('property_list')
            ->where('id', $request->property_id)
            ->update([
                'room_type' => $request->room_type,
                'property_category' => $request->property_type,
                'property_size' => $request->property_size,
                'total_guests' => $request->guest_count,
                'cur_adults' => $request->cur_adults,
                'cur_child' => $request->cur_child,
                'cur_pets' => $request->cur_pets,
                'stage' => 2,
            ]);
        //        print_r($request->double_bed);exit();

        $property_room = DB::table('property_room')->insert([
            'client_id' => CLIENT_ID,
            'property_id' => $request->property_id,
            'property_size' => $request->property_size ? $request->property_size : 0,
            'bathroom_count' => $request->bathroom_count ? $request->bathroom_count : 0,
            //            'check_in_time' => $request->check_in_time ? $request->check_in_time : 0,
            //            'check_out_time' => $request->check_out_time ? $request->check_out_time : 0,
            'bedroom_count' => $request->no_of_bedrooms,
            //            'bedroom_count' => count($request->double_bed),
            //            'bed_count' => $request->bed_count,
            'common_spaces' => $request->common_spaces ? $request->common_spaces : 0,
            'status' => ACTIVE,
        ]);

        for ($i = 0; $i < $request->no_of_bedrooms; $i++) {
            if (isset($request->double_bed[$i])) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "double_bed",
                    'count' => $request->double_bed[$i],
                    'status' => ACTIVE,
                ]);
            }
            if (isset($request->queen_bed[$i])) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "queen_bed",
                    'count' => $request->queen_bed[$i],
                    'status' => ACTIVE,
                ]);
            }
            if (isset($request->single_bed[$i])) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "single_bed",
                    'count' => $request->single_bed[$i],
                    'status' => ACTIVE,
                ]);
            }
            if (isset($request->sofa_bed[$i])) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "sofa_bed",
                    'count' => $request->sofa_bed[$i],
                    'status' => ACTIVE,
                ]);
            }
            if (isset($request->bunk_bed[$i])) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "bunk_bed",
                    'count' => $request->bunk_bed[$i],
                    'status' => ACTIVE,
                ]);
            }

            // common spaces start c_double_bed":["1"],"c_queen_bed":["1"],"c_single_bed":["1"],"c_sofa_bed":[null],"c_bunk_bed":
            if ($i == BLOCK) {
                if ($request->c_double_bed[$i]) {
                    $double_bed = DB::table('property_bedrooms')->insert([
                        'client_id' => CLIENT_ID,
                        'property_id' => $request->property_id,
                        'bedroom_number' => $i + 1,
                        'bed_type' => "double_bed",
                        'count' => $request->c_double_bed[$i],
                        'is_common_space' => ACTIVE,
                        'status' => ACTIVE,
                    ]);
                }
                if ($request->c_queen_bed[$i]) {
                    $double_bed = DB::table('property_bedrooms')->insert([
                        'client_id' => CLIENT_ID,
                        'property_id' => $request->property_id,
                        'bedroom_number' => $i + 1,
                        'bed_type' => "queen_bed",
                        'count' => $request->c_queen_bed[$i],
                        'is_common_space' => ACTIVE,
                        'status' => ACTIVE,
                    ]);
                }
                if ($request->c_single_bed[$i]) {
                    $double_bed = DB::table('property_bedrooms')->insert([
                        'client_id' => CLIENT_ID,
                        'property_id' => $request->property_id,
                        'bedroom_number' => $i + 1,
                        'bed_type' => "single_bed",
                        'count' => $request->c_single_bed[$i],
                        'is_common_space' => ACTIVE,
                        'status' => ACTIVE,
                    ]);
                }
                if ($request->c_sofa_bed[$i]) {
                    $double_bed = DB::table('property_bedrooms')->insert([
                        'client_id' => CLIENT_ID,
                        'property_id' => $request->property_id,
                        'bedroom_number' => $i + 1,
                        'bed_type' => "sofa_bed",
                        'count' => $request->c_sofa_bed[$i],
                        'is_common_space' => ACTIVE,
                        'status' => ACTIVE,
                    ]);
                }
                if ($request->c_bunk_bed[$i]) {
                    $double_bed = DB::table('property_bedrooms')->insert([
                        'client_id' => CLIENT_ID,
                        'property_id' => $request->property_id,
                        'bedroom_number' => $i + 1,
                        'bed_type' => "bunk_bed",
                        'count' => $request->c_bunk_bed[$i],
                        'is_common_space' => ACTIVE,
                        'status' => ACTIVE,
                    ]);
                }
            }

            // common spaces end
        }

        $file_name = 'data/' . $request->property_id . '.json';
        if (file_exists($file_name)) {
            unlink($file_name);
        }
        if (isset($request->save)) {
            session()->forget('property_id');
            $url = BASE_URL . "owner/calender?id=" . $request->property_id;
        } else {
            $url = BASE_URL . 'owner/add-new-property/3/' . $request->property_id;
        }
        return redirect($url);
    }

    public function property_next3(Request $request)
    {
        // print_r($request->all());exit;
        // $insert = DB::table('property_video')
        //         ->insert(['client_id' => CLIENT_ID, 'property_id' => $request->property_id, 'source' => $request->source, 'url' => $request->url, 'sort' => 1, 'status' => 1,]);
        $trash_pickup_days = "";
        if ($request->trash_pickup_days) {
            $trash_pickup_days = implode(',', $request->trash_pickup_days);
        }

        $update = DB::table('property_list')
            ->where('id', $request->property_id)
            ->update([
                'title' => $request->title,
                'description' => $request->description,
                'house_rules' => $request->house_rules,
                'trash_pickup_days' => $trash_pickup_days,
                'lawn_service' => $request->lawn_service,
                'pets_allowed' => $request->pets_allowed,
            ]);

        $prop = DB::table('property_list')
            ->where('id', $request->property_id)
            ->first();
        if ($prop->on_stage < 3) {
            $update_on_stage = $this->propertyList->where('id', $request->property_id)->update(['on_stage' => 3]);
        }

        $url = BASE_URL . 'owner/add-new-property/4/' . $request->property_id;
        return redirect($url);
    }

    public function property_next4(Request $request)
    {
        //print_r($request->all());exit;

        DB::table('property_list')
            ->where('id', $request->property_id)
            ->update(['cancellation_policy' => $request->cancellation_policy, 'min_days' => $request->minimumstay]);

        // echo $request->booking_type;exit;
        // if ($request->booking_type) {
        //  echo $request->booking_type;exit;

        // }
        $request->booking_type = (int) $request->booking_type;
        $update_on_stage = DB::table('property_list')
            ->where('id', $request->property_id)
            ->update(['is_instant' => $request->booking_type]);

        $ins = [];
        $ins['client_id'] = CLIENT_ID;
        $ins['property_id'] = $request->property_id;
        $ins['price_per_night'] = $request->price_per_night;
        // $ins['price_more_than_one_week'] = $request->price_more_than_one_week;
        $ins['price_more_than_one_month'] = $request->price_more_than_one_month;
        // $ins['price_per_weekend'] = $request->price_per_weekend;

        // $ins['weekend_days'] = implode(",",$request->weekendays);
        // $ins['tax'] = $request->tax;
        // $ins['cleaning_fee'] = $request->cleaning_fee;
        // $ins['cleaning_fee_type'] = (string) $request->cleaning_fee_type;
        $ins['city_fee'] = $request->city_fee;
        $ins['city_fee_type'] = $request->city_fee_type;
        //        $ins['is_extra_guest'] = $request->is_extra_guest ? $request->is_extra_guest : '0';
        //        $ins['price_per_extra_guest'] = $request->price_per_extra_guest;
        $ins['security_deposit'] = $request->security_deposit;
        $ins['check_in'] = $request->check_in;
        $ins['check_out'] = $request->check_out;
        $val_count = DB::table('property_short_term_pricing')
            ->where('property_id', $request->property_id)
            ->count();
        if ($val_count == ZERO) {
            $insert = DB::table('property_short_term_pricing')->insert($ins);
            DB::table('property_list')
                ->where('id', $request->property_id)
                ->update(['cleaning_type' => $request->cleaning_fee_type]);
            $msg = "Price added successfully";
            $update_on_stage = DB::table('property_list')
                ->where('id', $request->property_id)
                ->update(['on_stage' => 4]);
        } else {
            $update = DB::table('property_short_term_pricing')
                ->where('property_id', $request->property_id)
                ->update($ins);
            DB::table('property_list')
                ->where('id', $request->property_id)
                ->update(['cleaning_type' => $request->cleaning_fee_type]);
            $msg = "Price updated successfully";
        }

        $url = BASE_URL . 'owner/add-new-property/6/' . $request->property_id;
        return redirect($url);
    }

    public function property_next5(Request $request)
    {
        $property_id = $request->property_id;
        $insert = DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $property_id)
            ->update(['stage' => 5]);

        $property_details = DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $property_id)
            ->first();

        if ($property_id) {
            $property_rate = DB::table('property_short_term_pricing')
                ->where('property_id', $property_id)
                ->select('price_per_night')
                ->first();

            $list = [];

            $month = date('m');
            $year = date('Y');
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($d = 1; $d <= $days; $d++) {
                $time = mktime(12, 0, 0, $month, $d, $year);
                if (date('m', $time) == $month) {
                    $list[$d]['date'] = date('Y-m-d', $time);
                }
                $list[$d]['price'] = $property_rate->price_per_night;
            }
            $icals = DB::table('third_party_calender')
                ->where('property_id', '=', $property_id)
                ->get();
            $events = DB::table('property_booking')
                ->where('client_id', '=', CLIENT_ID)
                ->where('property_id', '=', $property_id)
                ->get();
            $block_events = DB::table('property_blocking')
                ->where('client_id', '=', CLIENT_ID)
                ->where('property_id', '=', $property_id)
                ->get();
            $special_price = DB::table('property_special_pricing')
                ->where('client_id', '=', CLIENT_ID)
                ->where('property_id', '=', $property_id)
                ->get();

            //print_r($special_price);
            $dates = [];

            for ($i = 0; $i < count($special_price); $i++) {
                $dates[$i]['date'] = $special_price[$i]->start_date;
                $dates[$i]['price'] = $special_price[$i]->price_per_night;
            }

            //print_r($dates);exit;

            $finn = [];
            $finn = array_merge($dates, $list);
            // print_r($finn);exit;
            $res = [];
            $val = [];
            foreach ($finn as $key => $index) {
                if (!in_array($index['date'], $val)) {
                    if ($index['date']) {
                        $val[] = $index['date'];
                        $res[] = $index;
                    }
                }
            }

            foreach ($events as $key => $value) {
                if ($value->is_instant < 2) {
                    $value->booked_on = APP_BASE_NAME;
                } else {
                    $value->booked_on = 'Airbnb';
                }
            }
        } else {
            $events = [];
            $icals = [];
            $property_rate = new stdClass();
            $property_rate->price_per_night = 0;
            $res = [];
            $block_events = [];
        }

        //        print_r($block_events);exit();
        if (isset($request->save)) {
            session()->forget('property_id');
            $url = BASE_URL . "owner/calender?id=" . $request->property_id;
        } else {
            $url = BASE_URL . 'owner/add-new-property/7/' . $request->property_id;
        }

        return redirect($url)->with(compact('property_details', 'events', 'icals', 'block_events', 'res'));
    }

    public function property_next6(Request $request)
    {
        //
        // print_r($request->all());exit;

        DB::table('property_amenties')
            ->where('client_id', CLIENT_ID)
            ->where('property_id', $request->property_id)
            ->delete();
        if ($request->Kitchen) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Kitchen';
            $property_aminities->amenties_icon = 'kitchen_icon';
            $property_aminities->save();
        }
        if ($request->internet) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Internet';
            $property_aminities->amenties_icon = 'Internet_icon';
            $property_aminities->save();
        }
        if ($request->smoking_allowed) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Smoking Allowed';
            $property_aminities->amenties_icon = 'Smoking_Allowed_icon';
            $property_aminities->save();
        }
        if ($request->tv) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Tv';
            $property_aminities->amenties_icon = 'Tv_icon';
            $property_aminities->save();
        }
        if ($request->wheelchair_accessible) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Wheelchair Accessible';
            $property_aminities->amenties_icon = 'Wheelchair_Accessible_icon';
            $property_aminities->save();
        }
        if ($request->elevator_in_building) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Elevator in Building';
            $property_aminities->amenties_icon = 'Elevator_in_building_icon';
            $property_aminities->save();
        }
        if ($request->indoor_fireplace) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Indoor Fireplace';
            $property_aminities->amenties_icon = 'Indoor_Fireplace_icon';
            $property_aminities->save();
        }
        if ($request->heating) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Heating';
            $property_aminities->amenties_icon = 'Heating_icon';
            $property_aminities->save();
        }
        if ($request->essentials) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Essentials';
            $property_aminities->amenties_icon = 'Essentials_icon';
            $property_aminities->save();
        }
        if ($request->door_man) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Doorman';
            $property_aminities->amenties_icon = 'Doorman_icon';
            $property_aminities->save();
        }
        if ($request->pool) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Pool';
            $property_aminities->amenties_icon = 'Pool_icon';
            $property_aminities->save();
        }
        if ($request->washer) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Washer';
            $property_aminities->amenties_icon = 'Washer_icon';
            $property_aminities->save();
        }
        if ($request->hot_tub) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Hot Tub';
            $property_aminities->amenties_icon = 'Hot_Tub_icon';
            $property_aminities->save();
        }
        if ($request->dryer) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Dryer';
            $property_aminities->amenties_icon = 'Dryer_icon';
            $property_aminities->save();
        }
        if ($request->gym) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Gym';
            $property_aminities->amenties_icon = 'Gym_icon';
            $property_aminities->save();
        }
        if ($request->free_parking_on_premises) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Free Parking on Premises';
            $property_aminities->amenties_icon = 'Free_Parking_on_Premises_icon';
            $property_aminities->save();
        }
        if ($request->wireless_internet) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Wireless Internet';
            $property_aminities->amenties_icon = 'Wireless_Internet_icon';
            $property_aminities->save();
        }
        if ($request->pets_allowed) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Pets Allowed';
            $property_aminities->amenties_icon = 'Pets_Allowed_icon';
            $property_aminities->save();
        }
        if ($request->kid_friendly) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Kid Friendly';
            $property_aminities->amenties_icon = 'Kid_Friendly_icon';
            $property_aminities->save();
        }
        if ($request->suitable_for_events) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Suitable for Events';
            $property_aminities->amenties_icon = 'Suitable_for_Events_icon';
            $property_aminities->save();
        }
        if ($request->non_smoking) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Non Smoking';
            $property_aminities->amenties_icon = 'Non_Smoking_icon';
            $property_aminities->save();
        }
        if ($request->phone) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Phone';
            $property_aminities->amenties_icon = 'Phone_icon';
            $property_aminities->save();
        }
        if ($request->projector) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Projector';
            $property_aminities->amenties_icon = 'Projector_icon';
            $property_aminities->save();
        }
        if ($request->restaurant) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Restaurant';
            $property_aminities->amenties_icon = 'Restaurant_icon';
            $property_aminities->save();
        }
        if ($request->air_conditioner) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Air Conditioner';
            $property_aminities->amenties_icon = 'Air_Conditioner_icon';
            $property_aminities->save();
        }
        if ($request->scanner_printer) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Scanner Printer';
            $property_aminities->amenties_icon = 'Scanner_Printer_icon';
            $property_aminities->save();
        }
        if ($request->fax) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Fax';
            $property_aminities->amenties_icon = 'Fax_icon';
            $property_aminities->save();
        }
        if ($request->breakfast_included) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Breakfast Included';
            $property_aminities->amenties_icon = 'Breakfast_Included_icon';
            $property_aminities->save();
        }

        if ($request->Cable) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Cable';
            $property_aminities->amenties_icon = 'cable_icon';
            $property_aminities->save();
        }

        if ($request->pots_and_pans) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Pots and Pans';
            $property_aminities->amenties_icon = 'pots_and_pans_icon';
            $property_aminities->save();
        }

        if ($request->towels) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Towels';
            $property_aminities->amenties_icon = 'Towels_icon';
            $property_aminities->save();
        }

        if ($request->garage) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Garage';
            $property_aminities->amenties_icon = 'Garage_icon';
            $property_aminities->save();
        }

        if ($request->smart_tv) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Smart Tv';
            $property_aminities->amenties_icon = 'Smart_Tv_icon';
            $property_aminities->save();
        }

        if ($request->all_bils_included) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'All Bils Included';
            $property_aminities->amenties_icon = 'All_Bils_Included_icon';
            $property_aminities->save();
        }

        if ($request->security_cameras) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Security Cameras';
            $property_aminities->amenties_icon = 'Security_Cameras_icon';
            $property_aminities->save();
        }

        if ($request->computer) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Computer';
            $property_aminities->amenties_icon = 'Computer_icon';
            $property_aminities->save();
        }

        if ($request->netflix) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Netflix';
            $property_aminities->amenties_icon = 'Netflix_icon';
            $property_aminities->save();
        }

        if ($request->coffee_pot) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Coffee Pot';
            $property_aminities->amenties_icon = 'Coffee_Pot_icon';
            $property_aminities->save();
        }

        //        $request_data = print_r($request->all());
        //        LOG::info("Aminities add hitted with data :".$request_data);
        $c_data = DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $request->property_id)
            ->first();
        DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $request->property_id)
            ->update(['stage' => 6]);
        //        if ($c_data->property_type == BLOCK) {
        //            $url = BASE_URL . 'owner/add-new-property/7/' . $request->property_id;
        //        } else {
        //            // DB::table('property_list')->where('client_id', '=', CLIENT_ID)->where('id', $request->property_id)->update(['is_complete' => 1]);
        //            $url = BASE_URL . "owner/my-properties";
        //        }

        if (isset($request->save)) {
            session()->forget('property_id');
            $url = BASE_URL . "owner/calender?id=" . $request->property_id;
        } else {
            $url = BASE_URL . 'owner/add-new-property/5/' . $request->property_id;
        }

        return redirect($url);
    }

    public function property_next7(Request $request)
    {
        //
        $property = DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $request->property_id)
            ->first();
        //        print_r($property);exit();

        $role_id = $request->session()->get('role_id');
        $user_id = $request->session()->get('user_id');
        if ($role_id == 2) {
            DB::table('users')
                ->where('id', $request->session()->get('user_id'))
                ->update(['role_id' => ONE]);
            $request->session()->put('role_id', ONE);
        }

        $file_name = 'data/' . $request->property_id . '.json';
        if (file_exists($file_name)) {
            unlink($file_name);
        }

        $mail_email = $this->get_email($property->user_id);
        $user = DB::table('users')
            ->where('id', $request->session()->get('user_id'))
            ->first();

        $mail_data = [
            'name' => $user->first_name . ' ' . $user->last_name,
            'property_link' => BASE_URL . 'property/' . $request->property_id,
            'availability_calendar' => BASE_URL . 'ical/' . $request->property_id,
        ];

        $address = implode(
            ", ",
            array_filter([
                $property->address,
                $property->city,
                $property->state,
                $property->zip_code,
                $property->country,
            ]),
        );

        if ($property->is_complete == 0) {
            DB::table('property_list')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request->property_id)
                ->update(['is_complete' => 1, 'stage' => 7]);

            $this->send_email_listing($mail_email, 'mail.listing', $mail_data, 'Listing Confirmation: ' . $address);
            session()->forget('property_id');
            $url = BASE_URL . "owner/calender?id=" . $request->property_id;
        } else {
            $this->send_email_listing(
                $mail_email,
                'mail.listing_update',
                $mail_data,
                'You edited your property listing: ' . $address,
            );
            $url = BASE_URL . 'owner/my-properties';
        }
        return redirect($url);
    }

    public function update_property($property_id)
    {
        $data = DB::table('property_list')
            ->where('id', '=', $property_id)
            ->first();
        $stage = $data->on_stage;
        $stage = 2;

        $url = BASE_URL . 'owner/add-new-property/' . $stage . '/' . $data->id;

        return redirect($url);
    }

    public function my_properties(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $properties = DB::table('property_list')
            ->leftjoin(
                'property_short_term_pricing',
                'property_short_term_pricing.property_id',
                '=',
                'property_list.id',
            )
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('property_list.user_id', '=', $user_id)
            ->where('property_list.is_complete', '=', 1)
            ->where('property_list.status', '=', 1)
            ->select(
                'property_list.*',
                'property_short_term_pricing.*',
                'property_list.id as propertyId',
                'property_list.status as propertyStatus',
            )
            ->get();
        $properties_near = [];
        foreach ($properties as $property) {
            $property->description = substr($property->description, 0, 170);
            $property->description .= '...';

            $pd = DB::table('property_images')
                ->where('property_images.client_id', '=', CLIENT_ID)
                ->where('property_images.property_id', '=', $property->propertyId)
                ->orderBy('property_images.sort', 'asc')
                ->get();

            $cover_img = DB::table('property_images')
                ->where('property_images.client_id', '=', CLIENT_ID)
                ->where('property_images.property_id', '=', $property->propertyId)
                ->where('property_images.is_cover', '=', 1)
                ->first();
            // print_r($cover_img);
            // echo count($cover_img)."----".$cover_img->image_url."<br>";
            foreach ($pd as $images) {
                $img_url = $images->image_url;
                $property->image_url = $img_url;
            }

            $propertys = [];
            $propertysd = [];
            if (count($pd) > 0) {
                if (isset($cover_img) && count($cover_img) == 1) {
                    $property->image_url = $cover_img->image_url;
                } else {
                    $property->image_url = $pd[ZERO]->image_url;
                }
            } else {
                $property->image_url = STATIC_IMAGE;
            }
            if (count($pd) == 0) {
                $propertysd[] = $propertys;
                $property->property_images = $propertysd;
                $property->image_url = STATIC_IMAGE;
            } else {
                $property->property_images = $pd;
            }

            $properties_near[] = $property;
        }

        return view('owner.my_properties', ['properties' => $properties_near]);
    }

    public function property_image_upload(Request $request)
    {
        //
        $file = $request->file('file');
        $image = $request->$key;
        $ext = $image->getClientOriginalExtension();
        $imageName = self::generate_random_string() . '.' . $ext;
        $destinationPath = 'public/uploads';
        $file->move($destinationPath, $imageName);
        $complete_url = BASE_URL . $destinationPath . '/' . $imageName;

        $property_id = $request->session()->get('property_id');
        $insert = DB::table('property_images')->insert([
            'client_id' => CLIENT_ID,
            'property_id' => $property_id,
            'image_url' => $complete_url,
            'sort' => ONE,
            'status' => ONE,
        ]);
        return $complete_url;
    }

    public function disable_property($id, Request $request)
    {
        //property_list
        $user_id = $request->session()->get('user_id');
        $user = DB::table('users')
            ->where('client_id', CLIENT_ID)
            ->where('id', $user_id)
            ->first();
        $username = $user->first_name . ' ' . $user->last_name;
        $check = DB::table('property_list')
            ->where('client_id', CLIENT_ID)
            ->where('id', $id)
            ->first();
        //print_r($check);exit;
        if ($check->is_disable == 0) {
            $disable = 1;
            $status = 0;
            $content = "Your Property : " . $check->title . "(Property ID : " . $check->id . ") Has been Disabled.";
        } else {
            $disable = 0;
            $status = 1;
            $content = "Your Property : " . $check->title . "(Property ID : " . $check->id . ") Has been Enabled.";
        }
        $update = DB::table('property_list')
            ->where('client_id', CLIENT_ID)
            ->where('id', $id)
            ->update(['is_disable' => $disable, 'status' => $status]);
        $mail_email = $this->get_email($check->user_id);
        $mail_data = [
            'username' => $username,
            'content' => $content,
        ];
        $this->send_email($mail_email, 'mail.custom-email', $mail_data);
        return back()->with('success', 'Property updated');
    }

    public function delete_property($property_id, Request $request)
    {
        $file_name = 'data/' . $property_id . '.json';
        if (file_exists($file_name)) {
            unlink($file_name);
        }
        DB::table('property_list')
            ->where('client_id', CLIENT_ID)
            ->where('id', $property_id)
            ->update(['status' => 0]);
        $data = DB::table('property_list')
            ->join('users', 'users.id', '=', 'property_list.user_id')
            ->where('property_list.client_id', CLIENT_ID)
            ->where('property_list.id', $property_id)
            ->first();
        $mail_data = [
            'name' => $data->first_name . " " . $data->last_name,
            'data' => $data,
            'text' => 'Trying to delete his/her property',
        ];
        $title = 'Alert from - ' . APP_BASE_NAME;
        $subject = "Property Deletion request from - " . APP_BASE_NAME;
        $email = "guru@sparkouttech.com";
        // $email = "info@healthcaretravels.com";
        $this->send_custom_email($email, $subject, 'mail.property-delete-mail', $mail_data, $title);

        // DB::table('property_amenties')->where('client_id', CLIENT_ID)->where('property_id', $property_id)->delete();
        // DB::table('property_bedrooms')->where('client_id', CLIENT_ID)->where('property_id', $property_id)->delete();
        // DB::table('property_room')->where('client_id', CLIENT_ID)->where('property_id', $property_id)->delete();
        // DB::table('property_short_term_pricing')->where('client_id', CLIENT_ID)->where('property_id', $property_id)->delete();
        // DB::table('property_images')->where('client_id', CLIENT_ID)->where('property_id', $property_id)->delete();
        return back()->with('success', 'Property removed successfully');
    }
}
