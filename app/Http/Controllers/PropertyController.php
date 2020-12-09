<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessOwnerReminder;
use App\Jobs\ProcessPropertyUpdateEmail;
use App\Models\AmenitiesList;
use App\Models\PetInformation;
use App\Models\PropertyBlocking;
use App\Services\Logger;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Users;
use App\Models\Propertyamenties;
use App\Models\PropertyList;
use App\Models\EmailConfig;
use App\Models\GuestsInformation;
use App\Models\PropertyBooking;
use App\Models\BookingPayments;
use App\Jobs\ProcessAutoCancel;
use Twilio\TwiML\MessagingResponse;

use Mail;
use App\Helper\Helper;
use Carbon\Carbon;

class PropertyController extends BaseController
{
    //    public function __construct(Users $users, PropertyList $property_list)
    //    {
    //        $this->users = $users;
    //        $this->property_list = $property_list;
    //    }

    public function book_now(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        if (!$user_id) {
            $request->session()->put('propertyId', $request->property_id);
            $request->session()->put('fromDate', $request->check_in);
            $request->session()->put('toDate', $request->check_out);
            $request->session()->put('guest_count', $request->guest_count);
            return redirect()->intended('login');
        }
        $check_in = date('Y-m-d', strtotime($request->check_in));
        $check_out = date('Y-m-d', strtotime($request->check_out));

        // Padding 24 hours for property owner after check-out
        $c_out = Carbon::parse($check_out);
        $check_out_date = $c_out->addDay()->toDateString();

        $sql =
            "SELECT count(*) as is_available,B.total_guests FROM `property_booking` A, `property_list` B WHERE (A.start_date BETWEEN '" .
            $check_in .
            "' AND '" .
            $check_out_date .
            "') AND (A.end_date BETWEEN '" .
            $check_in .
            "' AND '" .
            $check_out_date .
            "')  AND B.total_guests < " .
            $request->guest_count .
            " AND A.status = 2 AND A.is_instant = B.is_instant AND A.property_id = " .
            $request->property_id .
            "";

        $is_available = DB::select($sql);

        $property_details = DB::table('property_list')
            ->where('client_id', CLIENT_ID)
            ->where('id', $request->property_id)
            ->first();

        $booking_count = DB::table('property_booking')
            ->where('client_id', CLIENT_ID)
            ->where('property_id', $request->property_id)
            ->count();
        if ($is_available[ZERO]->is_available == ZERO || $booking_count == ZERO) {
            $insert_booking = [];
            $insert_booking['start_date'] = $check_in;
            $insert_booking['client_id'] = CLIENT_ID;
            $insert_booking['property_id'] = $request->property_id;
            $insert_booking['end_date'] = $check_out;
            $insert_booking['guest_count'] = $request->guest_count;
            $insert_booking['traveller_id'] = $user_id;
            $insert_booking['owner_id'] = $property_details->user_id;
            $insert_booking['is_instant'] = $property_details->is_instant;
            // Add deposit amount and traveler cut
            $insert_booking['traveler_cut'] = $property_details->security_deposit;
            $insert_booking['security_deposit'] = $property_details->security_deposit;
            $insert_booking['cleaning_fee'] = $property_details->cleaning_fee;
            //            $insert_booking['status'] = ONE;
            $insert_booking['booking_id'] = $request->booking_id ?? $this->generate_random_string();

            $booking_id = $insert_booking['booking_id'];
            $property_booking = PropertyBooking::updateOrCreate(
                [
                    'booking_id' => $insert_booking['booking_id'],
                ],
                $insert_booking,
            );
            $property_booking_id = $property_booking->id;
            $weeks = $this->get_weekend_count($check_in, $check_out);
            $weeks['total'] = $weeks['total'] - 1;
            $single_day_fare = $property_details->monthly_rate / 30;

            $booking_price = [];
            $booking_price['client_id'] = CLIENT_ID;
            $booking_price['single_day_fare'] = $single_day_fare;
            $booking_price['property_booking_id'] = $property_booking_id;
            $booking_price['total_days'] = $weeks['total'];
            $week_end_days = ZERO;

            $price = $weeks['total'] * $single_day_fare;
            $service_tax = DB::table('settings')
                ->where('param', 'service_tax')
                ->first();
            $total_price =
                $price + $property_details->cleaning_fee + $property_details->security_deposit + $service_tax->value;

            $booking_price['service_tax'] = $service_tax->value;
            $booking_price['initial_pay'] = 0; // TODO: check with $due_now;
            $booking_price['total_amount'] = round($total_price, 2);
            $booking_price['temp_amount'] = 0; // TODO: $pricing_config->price_per_weekend;
            $booking_price['week_end_days'] = $week_end_days;
            $booking_price['security_deposit'] = $property_details->security_deposit;
            $booking_price['weekend_fare'] = 0; // TODO: $pricing_config->price_per_weekend;

            DB::table('property_booking_price')->insert($booking_price);

            $insert_data = DB::table('property_booking_price')
                ->orderBy('id', 'desc')
                ->first();
            $insert_data->calc_price = $price;

            return redirect()->intended('/booking_detail/' . $booking_id);
        } else {
            return response()->json([
                'status' => 'FAILED',
                'message' =>
                    'Sorry! This property is not available during all of your selected dates. Try changing your dates or finding another property.',
            ]);
        }
    }

    public function get_valid_date_range_for_booking_request($property_id, $check_in, $check_out, $user_id, $booking_id)
    {
        $isBlocked = PropertyBlocking::whereRaw(
            'property_id = "' .
                $property_id .
                '" AND ((start_date BETWEEN "' .
                $check_in .
                '" AND "' .
                $check_out .
                '") OR (end_date BETWEEN "' .
                $check_in .
                '" AND "' .
                $check_out .
                '") OR ("' .
                $check_in .
                '" BETWEEN start_date AND end_date))',
        )->get();
        if (count($isBlocked)) {
            return ['isBlocked' => $isBlocked];
        }

        $requestAlreadyExists = PropertyBooking::whereRaw(
            'traveller_id = "' .
                $user_id .
                ($booking_id ? '" AND booking_id != "' . $booking_id : '') .
                '" AND status NOT IN (0, 4, 8) AND ((start_date BETWEEN "' .
                $check_in .
                '" AND "' .
                $check_out .
                '") OR (end_date BETWEEN "' .
                $check_in .
                '" AND "' .
                $check_out .
                '") OR ("' .
                $check_in .
                '" BETWEEN start_date AND end_date))',
        )->get();
        if (count($requestAlreadyExists)) {
            return ['requestAlreadyExists' => $requestAlreadyExists];
        }
        return [];
    }
    public function get_price(Request $request)
    {
        $guest_count = $request->guest_count == 0 ? 20 : $request->guest_count;
        $request->adults_count = $guest_count;
        $check_in = date('Y-m-d', strtotime($request->check_in));
        $check_out = date('Y-m-d', strtotime($request->check_out));
        $user_id = $request->session()->get('user_id');
        $booking_id = $request->booking_id;

        $isValidRequest = $this->get_valid_date_range_for_booking_request(
            $request->property_id,
            $check_in,
            $check_out,
            $user_id,
            $booking_id,
        );

        if (isset($isValidRequest['isBlocked'])) {
            return response()->json([
                'status' => 'FAILED',
                'message' =>
                    'Sorry! This property is not available during all of your selected dates. Try changing your dates or finding another property.',
                'status_code' => ZERO,
                'is_blocked' => ONE,
                'blocked_data' => $isValidRequest['isBlocked'],
            ]);
        }

        if (isset($isValidRequest['requestAlreadyExists'])) {
            $my_trips_url = BASE_URL . 'traveler/my-reservations';
            return response()->json([
                'status' => 'FAILED',
                'message' =>
                    'You have already <a style="color: white;text-decoration-line: underline;" href=' .
                    $my_trips_url .
                    '>submitted a request</a> for these dates.<br>Try a different date range or visit <a style="color: white;text-decoration-line: underline;" href=' .
                    $my_trips_url .
                    '>My Trips</a> page to view your submitted request.',
                'status_code' => ZERO,
                'request_already_exists' => ONE,
                'request_data' => $isValidRequest['requestAlreadyExists'],
            ]);
        }
        // Padding 24 hours for property owner after check-out

        $c_out = Carbon::parse($check_out);
        $check_out_date = $c_out->addDay()->toDateString();

        $sql =
            "SELECT count(*) as is_available,B.total_guests FROM `property_booking` A, `property_list` B WHERE (A.start_date BETWEEN '" .
            $check_in .
            "' AND '" .
            $check_out_date .
            "') AND (A.end_date BETWEEN '" .
            $check_in .
            "' AND '" .
            $check_out_date .
            "')  AND B.total_guests < " .
            $guest_count .
            " AND A.status = 2 AND A.property_id = " .
            $request->property_id;

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

        if ($weeks['total'] < $property_details->min_days) {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'Please review the house rules for Minimum days stay.',
                'status_code' => ONE,
            ]);
        }

        if ($is_available[ZERO]->is_available == ZERO || $booking_count == ZERO) {
            try {
                $user_role_id = DB::table('users')
                    ->where('id', '=', $user_id)
                    ->select('role_id')
                    ->first();
                $property_details->role_id = isset($user_role_id) ? $user_role_id->role_id : 0;
                $booking_price = Helper::get_price_details($property_details, $check_in, $check_out);
                return response()->json(['status' => 'SUCCESS', 'data' => $booking_price, 'status_code' => ONE]);
            } catch (\Exception $ex) {
                return response()->json([
                    'status' => 'FAILED',
                    'message' => $ex->getMessage(),
                    'status_code' => ZERO,
                ]);
            }
        } else {
            return response()->json([
                'status' => 'FAILED',
                'message' =>
                    'Sorry! This property is not available during all of your selected dates. Try changing your dates or finding another property.',
                'status_code' => ZERO,
            ]);
        }
    }

    /**
     *Get booking details of that property
     *
     *@param booking_id int
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */

    public function booking_detail($booking_id, Request $request)
    {
        $data = DB::table('property_booking')
            ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->leftjoin('property_images', 'property_images.property_id', '=', 'property_booking.property_id')
            ->where('property_booking.client_id', CLIENT_ID)
            ->where('property_booking.booking_id', $booking_id)
            ->select(
                'property_booking.*',
                'property_booking.status as bookingStatus',
                'property_list.*',
                'property_images.*',
            )
            ->orderBy('property_images.is_cover', 'desc')
            ->first();
        if (empty($data)) {
            return view('general_error', ['message' => 'Booking you are looking for does not exists!']);
        }
        $user_id = $request->session()->get('user_id');

        if ($user_id != $data->traveller_id) {
            // Do not allow other user to access booking details
            return view('general_error', ['message' => 'Invalid Access']);
        }

        $isValidRequest = $this->get_valid_date_range_for_booking_request(
            $data->property_id,
            $data->start_date,
            $data->end_date,
            $user_id,
            $booking_id,
        );

        if (count($isValidRequest) > 0) {
            $error_title = "You can't complete this booking.";
            if (isset($isValidRequest['isBlocked'])) {
                $error_message = "Dates are blocked for this property.";
            } else {
                $error_message = 'You have already submitted request for these dates';
            }
            $my_trips_url = BASE_URL . 'traveler/my-reservations';
            return view('general_error', [
                'title' => $error_title,
                'message' => $error_message,
                'hideImage' => true,
                'url' => $my_trips_url,
            ]);
        }

        $agency = DB::table('agency')
            ->orderBy('name', 'ASC')
            ->get();
        $guests = DB::table('guest_informations')
            ->where('booking_id', $booking_id)
            ->get();
        $pet_details = DB::table('pet_information')
            ->where('booking_id', $booking_id)
            ->first();
        $traveller = DB::table('users')
            ->where('id', $data->traveller_id)
            ->first();

        $data->role_id = $traveller->role_id;
        $booking_price = Helper::get_price_details($data, $data->start_date, $data->end_date);
        $data = (object) array_merge((array) $data, (array) $booking_price);

        $funding_sources = $this->dwolla->getFundingSourcesForCustomer($traveller->dwolla_customer);

        return view('properties.property_detail', [
            'data' => $data,
            'guests' => $guests,
            'pet_details' => $pet_details,
            'traveller' => $traveller,
            'funding_sources' => $funding_sources,
            'agency' => $agency,
        ]);
    }

    public function cancel_booking(Request $request, $id)
    {
        try {
            $user_id = $request->session()->get('user_id');
            if (!$user_id) {
                return redirect()->intended('login');
            }
            $traveller = DB::table('property_booking')
                ->where('booking_id', $id)
                ->select('traveller_id')
                ->first();

            if ($user_id != $traveller->traveller_id) {
                // Do not allow other user to cancel booking
                return response()->json(['status' => 'FAILED', 'message' => 'Invalid Access']);
            }
            DB::table('property_booking')
                ->where('booking_id', $id)
                ->update(['status' => 8]);
            return response()->json(['status' => 'SUCCESS', 'message' => 'Booking Cancelled successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'FAILED', 'message' => $e->getMessage()]);
        }
    }

    public function delete_booking(Request $request, $id)
    {
        try {
            $user_id = $request->session()->get('user_id');
            if (!$user_id) {
                return redirect()->intended('login');
            }
            $traveller = DB::table('property_booking')
                ->where('booking_id', $id)
                ->select('traveller_id')
                ->first();

            if ($user_id != $traveller->traveller_id) {
                // Do not allow other user to cancel booking
                return response()->json(['status' => 'FAILED', 'message' => 'Invalid Access']);
            }
            DB::table('property_booking')
                ->where('booking_id', $id)
                ->delete();
            return response()->json(['status' => 'SUCCESS', 'message' => 'Booking Deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'FAILED', 'message' => $e->getMessage()]);
        }
    }

    public function create_chat($property_id, Request $request)
    {
        return Helper::start_chat($property_id, $request);
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
            return redirect('owner/inbox');
        }
        if ($chat->traveller_id == $user_id) {
            DB::table('personal_chat')
                ->where('client_id', CLIENT_ID)
                ->where('id', $id)
                ->update(['traveler_visible' => 0]);
            return redirect('traveler/inbox');
        }
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
            ->where('user_favourites.client_id', '=', CLIENT_ID)
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
                ->orderBy('property_images.is_cover', 'desc')
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

    public function owner_fire_chat($id, Request $request)
    {
        $user_id = $request->session()->get('user_id');
        if (!$user_id) {
            return redirect('/');
        }
        if ($request->fbkey == "personal_chat") {
            $property = DB::table('personal_chat')
                ->where('id', '=', $id)
                ->where(function ($query) use ($user_id) {
                    $query->where('owner_id', '=', $user_id)->orWhere('traveller_id', '=', $user_id);
                })
                ->first();

            if (!isset($property)) {
                return redirect('/');
            }

            $traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->traveller_id)
                ->first();
            $owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->owner_id)
                ->first();
            $property_description = DB::table('property_list')
                ->where('id', $property->property_id)
                ->first();

            if ($property->traveller_id == $user_id) {
                return view('traveller.fire_chat', [
                    'owner' => $owner,
                    'traveller' => $traveller,
                    'id' => $id,
                    'traveller_id' => $property->traveller_id,
                    'property' => $property_description,
                ]);
            }

            return view('owner.fire_chat', [
                'owner' => $owner,
                'traveller' => $traveller,
                'id' => $id,
                'property' => $property_description,
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
        $property_description = DB::table('property_list')
            ->where('id', $property->property_id)
            ->first();

        if ($property->traveller_id == $user_id) {
            return view('traveller.fire_chat', [
                'owner' => $owner,
                'traveller' => $traveller,
                'id' => $id,
                'traveller_id' => $property->traveller_id,
                'property' => $property_description,
            ]);
        }

        return view('owner.fire_chat', [
            'owner' => $owner,
            'traveller' => $traveller,
            'id' => $id,
            'property' => $property_description,
        ]);
    }

    public function inbox_owner(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $unread_message_data = $request->session()->get('unread_message_data');
        $has_unread_message = $request->session()->get('has_unread_message');

        $request_chats = DB::table('request_chat')
            ->where('client_id', '=', CLIENT_ID)
            ->where(function ($query) use ($user_id) {
                $query
                    ->where('request_chat.owner_id', '=', $user_id)
                    ->orWhere('request_chat.traveller_id', '=', $user_id);
            })
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
            if (
                $has_unread_message &&
                isset($unread_message_data['message_key']) &&
                $unread_message_data['message_key'] == $request_chat->chat_key &&
                $unread_message_data['message_id'] == $request_chat->id
            ) {
                $request_chat->has_unread_message = true;
            }
            $request_chat->last_message = $this->get_firebase_last_message('request_chat', $request_chat, $user_id);
        }

        $instant_chats = DB::table('instant_chat')
            ->where('client_id', '=', CLIENT_ID)
            ->where(function ($query) use ($user_id) {
                $query
                    ->where('instant_chat.owner_id', '=', $user_id)
                    ->orWhere('instant_chat.traveller_id', '=', $user_id);
            })
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
            if (
                $has_unread_message &&
                isset($unread_message_data['message_key']) &&
                $unread_message_data['message_key'] == $request_chat->chat_key &&
                $unread_message_data['message_id'] == $request_chat->id
            ) {
                $request_chat->has_unread_message = true;
            }
            $request_chat->last_message = $this->get_firebase_last_message('instant_chat', $request_chat, $user_id);
        }
        // echo $user_id;
        $personal_chats = DB::table('personal_chat')
            ->where('client_id', '=', CLIENT_ID)
            ->where(function ($query) use ($user_id) {
                $query
                    ->where('personal_chat.owner_id', '=', $user_id)
                    ->orWhere('personal_chat.traveller_id', '=', $user_id);
            })
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
            if (
                $has_unread_message &&
                isset($unread_message_data['message_key']) &&
                $unread_message_data['message_key'] == $request_chat->chat_key &&
                $unread_message_data['message_id'] == $request_chat->id
            ) {
                $request_chat->has_unread_message = true;
            }
            $last_message = $this->get_firebase_last_message('personal_chat', $request_chat, $user_id);
            $request_chat->last_message = $last_message;
        }

        $results = [];
        $results[] = $request_chats;
        $results[] = $instant_chats;
        $results[] = $personal_chats;

        return view('owner.my-inbox', ['properties' => $results]);
    }

    public function inbox_traveller(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $unread_message_data = $request->session()->get('unread_message_data');
        $has_unread_message = $request->session()->get('has_unread_message');

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
            if (
                $has_unread_message &&
                isset($unread_message_data['message_key']) &&
                $unread_message_data['message_key'] == $request_chat->chat_key &&
                $unread_message_data['message_id'] == $request_chat->id
            ) {
                $request_chat->has_unread_message = true;
            }
            $request_chat->last_message = $this->get_firebase_last_message('request_chat', $request_chat, $user_id);
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
            if (
                $has_unread_message &&
                isset($unread_message_data['message_key']) &&
                $unread_message_data['message_key'] == $request_chat->chat_key &&
                $unread_message_data['message_id'] == $request_chat->id
            ) {
                $request_chat->has_unread_message = true;
            }
            $request_chat->last_message = $this->get_firebase_last_message('instant_chat', $request_chat, $user_id);
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
            if (
                $has_unread_message &&
                isset($unread_message_data['message_key']) &&
                $unread_message_data['message_key'] == $request_chat->chat_key &&
                $unread_message_data['message_id'] == $request_chat->id
            ) {
                $request_chat->has_unread_message = true;
            }
            $last_message = $this->get_firebase_last_message('personal_chat', $request_chat, $user_id);
            $request_chat->last_message = $last_message;
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
        $booking = DB::table('property_booking')
            ->where('booking_id', $request->booking_id)
            ->leftjoin('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->leftjoin('users', 'users.id', '=', 'property_booking.traveller_id')
            ->select(
                'users.username',
                'users.first_name',
                'users.last_name',
                'property_list.title',
                'property_list.room_type',
                'property_list.monthly_rate',
                'property_list.check_in',
                'property_list.check_out',
                'property_booking.*',
                'users.email',
                'users.phone',
                'users.role_id',
            )
            ->first();

        $property_img = DB::table('property_images')
            ->where('property_images.client_id', '=', CLIENT_ID)
            ->where('property_images.property_id', '=', $booking->property_id)
            ->orderBy('is_cover', 'DESC')
            ->first();
        $cover_img = BASE_URL . ltrim($property_img->image_url, '/');

        $user_id = $request->session()->get('user_id');

        if ($user_id && $booking && $booking->owner_id == $user_id) {
            DB::table('property_booking')
                ->where('booking_id', $request->booking_id)
                ->update([
                    'owner_funding_source' => $request->owner_funding_source ?? '',
                    'status' => $request->status,
                ]);

            if ($request->status == 2) {
                $scheduled_payments_traveler = Helper::generate_booking_payments($booking);
                $scheduled_payments_owner = Helper::generate_booking_payments($booking, 1);
                $scheduled_payments = array_merge($scheduled_payments_traveler, $scheduled_payments_owner);
                foreach ($scheduled_payments as $payment) {
                    BookingPayments::updateOrCreate(
                        [
                            'booking_id' => $payment['booking_id'],
                            'payment_cycle' => $payment['payment_cycle'],
                            'is_owner' => $payment['is_owner'],
                        ],
                        $payment,
                    );
                }
                $paymentRes = $this->process_booking_payment($booking->booking_id, 1);
                $bookingModel = PropertyBooking::find($booking->id);

                // SEND MAIL TO TRAVELLER/OWNER AS SOON AS BOOKING ACCEPTED
                $owner = $bookingModel->owner;
                $traveler = $bookingModel->traveler;
                $mail_data = [
                    'traveler' => $traveler,
                    'owner' => $owner,
                    'mail_to' => 'traveler',
                    'booking_id' => $booking->booking_id,
                    'property_title' => $booking->title,
                    'property_room_type' => $booking->room_type,
                    'start_date' => date('m-d-Y', strtotime($booking->start_date)),
                    'end_date' => date('m-d-Y', strtotime($booking->end_date)),
                    'cover_img' => $cover_img,
                ];

                $title = $request->status == 2 ? 'Owner confirms booking' : 'Owner cancels booking';
                $subject = $request->status == 2 ? 'Booking Confirmed' : 'Booking Cancelled';

                // Traveler email
                $this->send_custom_email($traveler->email, $subject, 'mail.accepted_booking', $mail_data, $title);
                // Owner email
                $mail_data['mail_to'] = 'owner';
                $this->send_custom_email($owner->email, $subject, 'mail.accepted_booking', $mail_data, $title);

                $this->schedule_payments_and_emails_for_booking($bookingModel, $request);

                // Deny other booking requests for this property for overlapping dates
                $overlapping_bookings = PropertyBooking::whereRaw(
                    'booking_id != "' .
                        $booking->booking_id .
                        '" AND property_id = "' .
                        $booking->property_id .
                        '" AND status = 1 AND ((start_date BETWEEN "' .
                        $booking->start_date .
                        '" AND "' .
                        $booking->end_date .
                        '") OR (end_date BETWEEN "' .
                        $booking->start_date .
                        '" AND "' .
                        $booking->end_date .
                        '") OR ("' .
                        $booking->start_date .
                        '" BETWEEN start_date AND end_date))',
                )->pluck('booking_id');
                foreach ($overlapping_bookings as $bookingId) {
                    PropertyBooking::where('booking_id', $bookingId)->update([
                        'status' => 4, // Deny request
                        'deny_reason' => 'Dates Not Available',
                    ]);
                }
            }

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
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
        $bookings = [];
        $incomplete_bookings = [];
        foreach ($data as $datum) {
            $traveller = DB::select(
                "SELECT first_name, last_name, username, id FROM users WHERE client_id = CLIENT_ID AND id = $datum->owner_id LIMIT 1",
            );
            $image = DB::table('property_images')
                ->where('client_id', CLIENT_ID)
                ->where('property_id', $datum->property_id)
                ->orderBy('is_cover', 'desc')
                ->first();
            $datum->image_url = '';
            if ($image) {
                $datum->image_url = $image->image_url;
            }
            $datum->owner_name = Helper::get_user_display_name($traveller[0]);
            $datum->owner_id = $traveller[0]->id;
            $datum->start_date = Carbon::parse($datum->start_date)->format('m/d/Y');
            $datum->end_date = Carbon::parse($datum->end_date)->format('m/d/Y');
            if ($datum->bookStatus == 0) {
                array_push($incomplete_bookings, $datum);
            } else {
                array_push($bookings, $datum);
            }
        }
        return view('owner.reservations', ['bookings' => $bookings, 'incomplete_bookings' => $incomplete_bookings]);
    }

    public function search_property(Request $request)
    {
        $request_data = $request->all();
        $nearby_properties = [];
        $total_count = 0;
        $lat_lng_url = '';
        $page = $request->page ?: 1;
        $items_per_page = SEARCH_ITEM_COUNT;
        $offset = ($page - 1) * $items_per_page;

        $room_types = DB::table('property_room_types')
            ->orderBy('name', 'ASC')
            ->get();

        if (count(array_filter($request_data)) > 0) {
            $lat_lng = [];
            $lat_lng_url = urlencode(serialize($lat_lng));

            if ($request->formatted_address) {
                $request->place = $request->formatted_address;
            }
            $source_lat = $request->lat;
            $source_lng = $request->lng;
            $property_list_obj = new PropertyList();

            $query = $property_list_obj->select('property_list.*')->where([
                'is_complete' => ACTIVE,
                'status' => 1,
                'is_disable' => 0,
                'property_status' => 1,
            ]);

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

            if ($request->guests != "") {
                $where[] = 'property_list.total_guests >= "' . $request->guests . '" ';
            }

            if ($request->room_type != "") {
                $where[] = 'property_list.room_type = "' . $request->room_type . '" ';
            }

            //            if (isset($request->instance_booking)) {
            //                $where[] = 'property_list.is_instant = 1';
            //            }

            if (isset($request->flexible_cancellation)) {
                $where[] = "property_list.cancellation_policy = 'Flexible'";
            }

            if (isset($request->pets_allowed)) {
                $where[] = 'property_list.pets_allowed = 1';
            }

            if (isset($request->no_child)) {
                $where[] = 'property_list.cur_child = 0';
            }

            if (isset($request->no_pets)) {
                $where[] = 'property_list.cur_pets = 0';
            }

            // TODO: check in check out filter for block date

            // TODO: instant booking, flexible cancellation, enhanced cleaning pool, no kids, no pets filter

            if ($request->minprice != "" && $request->maxprice != "") {
                $where[] =
                    'property_list.monthly_rate BETWEEN "' . $request->minprice . '" and "' . $request->maxprice . '" ';
            } elseif ($request->minprice != "" && $request->maxprice == "") {
                $where[] = 'property_list.monthly_rate <= "' . $request->minprice . '" ';
            } elseif ($request->minprice == "" && $request->maxprice != "") {
                $where[] = 'property_list.monthly_rate <= "' . $request->maxprice . '" ';
            }
            $from = strtotime($request->from_date);
            $to = strtotime($request->to_date);
            $query_blocking = [];
            if ($from && $to) {
                $fromDate = date('Y-m-d', $from);
                $toDate = date('Y-m-d', $to);
                $property_blocking_obj = new PropertyBlocking();
                $property_booking_obj = new PropertyBooking();

                $query_blocking = $property_blocking_obj
                    ->select('property_id')
                    ->whereRaw(
                        'property_blocking.start_date between "' .
                            $fromDate .
                            '" and "' .
                            $toDate .
                            '" OR
                             property_blocking.end_date between "' .
                            $fromDate .
                            '" and "' .
                            $toDate .
                            '" OR
                             "' .
                            $fromDate .
                            '" between property_blocking.start_date and property_blocking.end_date',
                    )
                    ->pluck('property_id')
                    ->toArray();

                $query_booking = $property_booking_obj
                    ->select('property_id')
                    ->whereRaw(
                        '(property_booking.start_date between "' .
                            $fromDate .
                            '" and "' .
                            $toDate .
                            '" OR
                             property_booking.end_date between "' .
                            $fromDate .
                            '" and "' .
                            $toDate .
                            '" OR
                             "' .
                            $fromDate .
                            '" between property_booking.start_date and property_booking.end_date) and property_booking.status = 2',
                    )
                    ->pluck('property_id')
                    ->toArray();
                $query_blocking = array_unique(array_merge($query_blocking, $query_booking));
            }

            $dataWhere = implode(" and ", $where);
            if ($dataWhere != "") {
                $query->whereRaw($dataWhere);
            }

            if (count($query_blocking)) {
                $query->whereNotIn('property_list.id', $query_blocking);
            }

            $query->groupBy('property_list.id');

            $total_count = count($query->get());
            $query = $query->skip($offset)->take($items_per_page);
            $nearby_properties = $query->get();
            foreach ($nearby_properties as $key => $value) {
                $image = DB::table('property_images')
                    ->where('property_id', $value->id)
                    ->orderBy('is_cover', 'desc')
                    ->first();
                $value->image_url = isset($image->image_url) ? $image->image_url : '';
            }
        }
        $blocked_dates = [];
        $user_id = $request->session()->get('user_id');

        if ($user_id) {
            $booking_start_dates = DB::table('property_booking')
                ->where('traveller_id', '=', $user_id)
                ->whereNotIn('status', [0, 4, 8])
                ->whereDate('start_date', '>=', Carbon::now())
                ->pluck('start_date');
            foreach ($booking_start_dates as $key => $value) {
                $start_date = Carbon::parse($value);
                $dates_list = $this->getDatesBetweenRange($start_date->copy()->subDays(7), $start_date);
                $blocked_dates = array_merge($blocked_dates, $dates_list);
            }
        }
        return view('search_property')
            ->with('properties', $nearby_properties)
            ->with('total_count', $total_count)
            ->with('location_url', $lat_lng_url)
            ->with('request_data', $request_data)
            ->with('total_properties', count($nearby_properties))
            ->with('next', $page)
            ->with('room_types', $room_types)
            ->with('offset', $offset)
            ->with('blocked_dates', $blocked_dates);
    }

    public static function add_property_to_favourite($property_id, Request $request)
    {
        try {
            $user_id = $request->session()->get('user_id');
            $favourite = DB::table('user_favourites')
                ->where('user_favourites.client_id', '=', CLIENT_ID)
                ->where('user_favourites.user_id', '=', $user_id)
                ->where('user_favourites.property_id', '=', $property_id)
                ->get();

            if (count($favourite)) {
                DB::table('user_favourites')
                    ->where('user_favourites.client_id', '=', CLIENT_ID)
                    ->where('user_favourites.user_id', '=', $user_id)
                    ->where('user_favourites.property_id', '=', $property_id)
                    ->delete();
                return response()->json(['status' => 'SUCCESS', 'message' => 'Removed from favourites', 'code' => 0]);
            } else {
                DB::table('user_favourites')->insert([
                    'client_id' => CLIENT_ID,
                    'user_id' => $user_id,
                    'property_id' => $property_id,
                ]);
                return response()->json(['status' => 'SUCCESS', 'message' => 'Added to favourites', 'code' => 1]);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'ERROR', 'message' => 'Error adding to favourites', 'code' => -1]);
        }
    }

    public static function format_amount($amount, $sign = '+')
    {
        if ($amount < 0) {
            $sign = '-';
        }
        return $sign . '$' . abs($amount);
    }

    public static function get_payment_summary($booking, $is_owner = 0)
    {
        $grand_total = 0;
        $scheduled_payments = [];

        // Get all booking payments for traveler from DB

        $all_scheduled_payments = BookingPayments::where('booking_id', $booking->booking_id)
            ->where('is_owner', $is_owner)
            ->get();

        if (count($all_scheduled_payments) == 0) {
            // Display records for payment if no DB entry found
            $all_scheduled_payments = Helper::generate_booking_payments($booking, $is_owner);
        }

        foreach ($all_scheduled_payments as $payment) {
            if (is_object($payment)) {
                $payment = json_decode(json_encode($payment), true);
            }

            $payment['is_cleared'] = $payment['is_cleared'] ?? 0;
            $payment['status'] = $payment['status'] ?? 0;
            $cleaning_fee_entry = array_merge([], $payment);
            $security_deposit_entry = array_merge([], $payment);
            $service_tax_entry = array_merge([], $payment);
            $is_partial_days_payment = boolval($payment['is_partial_days'] ?? 0);
            $neat_rate = $payment['monthly_rate'];
            if ($is_partial_days_payment) {
                $neat_rate = round(($payment['monthly_rate'] * $payment['is_partial_days']) / 30);
            }
            if ($is_owner == 1) {
                $payment['amount'] = self::format_amount($neat_rate - $payment['service_tax']);
                $grand_total = $grand_total + $payment['total_amount'] - $payment['service_tax'];
                $payment['covering_range'] =
                    "Covering " . $payment['covering_range'] . ", Minus $" . $payment['service_tax'] . " fee";

                if ($payment['payment_cycle'] == 1) {
                    $cleaning_fee_entry['name'] = 'Cleaning Fee';
                    $cleaning_fee_entry['amount'] = self::format_amount($booking->cleaning_fee);
                    $cleaning_fee_entry['covering_range'] = '';
                    array_push($scheduled_payments, $cleaning_fee_entry);
                }
            } else {
                $payment['amount'] = self::format_amount($neat_rate, '-');
                $grand_total = $grand_total + $payment['total_amount'] + $payment['service_tax'];

                if ($payment['payment_cycle'] == 1) {
                    $grand_total = $grand_total - $booking->security_deposit;

                    $cleaning_fee_entry['name'] = 'Cleaning Fee';
                    $cleaning_fee_entry['amount'] = self::format_amount($booking->cleaning_fee, '-');
                    $cleaning_fee_entry['covering_range'] = 'One-time charge';

                    $security_deposit_entry['name'] = 'Security Deposit';
                    $security_deposit_entry['amount'] = self::format_amount($booking->security_deposit, '-');
                    $security_deposit_entry['covering_range'] = 'Refunded 72 hours after check-out';
                    // Showing pending if the booking is not yet approved
                    if ($booking->status < 2) {
                        $payment['due_date_override'] = 'Pending';
                        $cleaning_fee_entry['due_date_override'] = 'Pending';
                        $security_deposit_entry['due_date_override'] = 'Pending';
                        $service_tax_entry['due_date_override'] = 'Pending';
                    }

                    // Adding entries to scheduled payments.
                    array_push($scheduled_payments, $cleaning_fee_entry);
                    array_push($scheduled_payments, $security_deposit_entry);
                }

                $service_tax_entry['due_date'] = $payment['due_date'];
                $service_tax_entry['name'] = $payment['payment_cycle'] == 1 ? 'Service Fee' : 'Processing Fee';
                $service_tax_entry['amount'] = self::format_amount($payment['service_tax'], '-');
                $service_tax_entry['is_cleared'] = $payment['is_cleared'];
                $service_tax_entry['status'] = $payment['status'];
                $service_tax_entry['covering_range'] = 'One-time charge';
                array_push($scheduled_payments, $service_tax_entry);
            }
            array_push($scheduled_payments, $payment);
        }

        return ['scheduled_payments' => $scheduled_payments, 'grand_total' => $grand_total];
    }

    public function single_booking($booking_id, Request $request)
    {
        try {
            $data = DB::table('property_booking')
                ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
                ->join(
                    'property_booking_price',
                    'property_booking_price.property_booking_id',
                    '=',
                    'property_booking.id',
                )
                ->select(
                    'property_booking_price.*',
                    'property_booking.*',
                    'property_list.title',
                    'property_list.id as property_id',
                    'property_list.min_days',
                    'property_list.monthly_rate',
                    'property_list.security_deposit',
                    'property_list.cleaning_fee',
                    'property_list.check_in',
                    'property_list.check_out',
                )
                ->where('property_booking.client_id', CLIENT_ID)
                ->where('property_booking.booking_id', $booking_id)
                ->first();
            if (empty($data)) {
                return view('general_error', ['message' => 'We can’t find the booking you’re looking for.']);
            }
            $bookingModel = PropertyBooking::find($data->id);
            $owner = $bookingModel->owner;
            $traveller = $bookingModel->traveler;
            $property = $bookingModel->property;

            $guest_info = GuestsInformation::where('booking_id', $booking_id)->get();
            $pet_details = PetInformation::where('booking_id', $booking_id)->first();
            $data->traveller_profile_image = $traveller->profile_image;
            $data->traveller_name = Helper::get_user_display_name($traveller);
            $data->agency = implode(", ", array_filter([$data->name_of_agency, $data->other_agency])); // Booking agencies

            $payment_summary = $this->get_payment_summary($data, 1);

            $funding_sources = $this->dwolla->getFundingSourcesForCustomer($owner->dwolla_customer);

            return view('owner.single_booking', [
                'data' => $data,
                'owner' => $owner,
                'guest_info' => $guest_info,
                'pet_details' => $pet_details,
                'scheduled_payments' => $payment_summary['scheduled_payments'],
                'total_earning' => $payment_summary['grand_total'],
                'funding_sources' => $funding_sources,
            ]);
        } catch (Exception $e) {
            Logger::info($e->getMessage());
            return back()->with('error', 'Unable to handle');
        }
    }

    public function chat_with_traveler(Request $request)
    {
        $travellerId = $request->traveller_id;
        $propertyId = $request->property_id;
        $user_id = $request->session()->get('user_id');
        $chat_with = $user_id === $travellerId ? 'traveler' : 'owner';
        if ($travellerId && $propertyId) {
            $chat_data = Helper::start_chat_handler($travellerId, $propertyId, $request);
            $chat_url = "{$request->getSchemeAndHttpHost()}/{$chat_with}/chat/{$chat_data['chat_id']}?fb-key=personal_chat&fbkey=personal_chat";
            return redirect($chat_url);
        } else {
            return back()->with('error', 'Not able to initialize chat');
        }
    }
    public function single_property($property_id, $booking_id = null, Request $request)
    {
        $booking_details = null;
        if ($booking_id) {
            $booking_details = PropertyBooking::where('booking_id', $booking_id)->first();
            if (!$booking_details) {
                return view('general_error', ['message' => 'We can’t find the property you’re looking for.']);
            }
            if ($booking_details && !in_array($booking_details->status, [0, 1])) {
                return view('general_error', ['message' => 'You can not edit booking now.']);
            }
            $user_id = $request->session()->get('user_id');
            if ($user_id != $booking_details->traveller_id) {
                // Do not allow other user to access booking details
                return view('general_error', ['message' => 'Invalid Access']);
            }
        }

        $temp_bed_rooms = [];
        if ($request->reviews) {
            $properties = DB::table('property_list')
                ->leftjoin('users', 'users.id', '=', 'property_list.user_id')
                ->leftjoin('property_images', 'property_images.property_id', '=', 'property_list.id')
                ->leftjoin('property_room', 'property_room.property_id', '=', 'property_list.id')
                ->where('property_list.client_id', '=', CLIENT_ID)
                ->where('property_list.id', '=', $property_id)
                ->select(
                    'property_images.*',
                    'property_room.*',
                    'property_list.*',
                    'users.*',
                    'property_list.state as prop_state',
                    'property_list.city as prop_city',
                )
                ->orderBy('property_images.is_cover', 'desc')
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
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('property_list.id', '=', $property_id)
            ->select(
                'property_list.*',
                'users.first_name',
                'users.last_name',
                'users.username',
                'users.profile_image',
                'users.device_token',
                'property_images.image_url',
                'property_images.is_cover',
                'property_room.*',
            )
            ->orderBy('property_images.is_cover', 'DESC')
            ->first();

        if ($properties) {
            // SELECT GROUP_CONCAT(bed_type) FROM `property_bedrooms` WHERE `property_id` = 1 AND `bedroom_number` = 1

            $property_bedrooms = DB::table('property_bedrooms')
                ->where('property_id', $property_id)
                ->get();
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
            $properties->bed_count = $bed_list->sum('count');

            $amenties = DB::table('property_amenties')
                ->where('property_amenties.client_id', '=', CLIENT_ID)
                ->where('property_amenties.property_id', '=', $property_id)
                ->join('amenities_list', 'property_amenties.amenties_name', '=', 'amenities_list.amenities_name')
                ->select('amenities_list.amenities_name as amenties_name', 'amenities_list.icon_url as amenties_icon')
                ->orderBy('amenties_name', 'ASC')
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
                ->orderBy('property_images.is_cover', 'desc')
                ->select('property_images.image_url')
                ->get();
            $properties->property_images = $pd;
        } else {
            return view('general_error', ['message' => 'We can’t find the property you’re looking for.']);
        }
        $result = $properties;

        if ($request->price_high_to_low) {
            $properties = DB::table('property_list')
                ->where('property_list.client_id', '=', CLIENT_ID)
                ->orderBy('monthly_rate', 'DESC')
                ->get();
        }
        if ($request->price_low_to_high) {
            $properties = DB::table('property_list')
                ->where('property_list.client_id', '=', CLIENT_ID)
                ->orderBy('monthly_rate', 'ASC')
                ->get();
        }

        $latest_properties = DB::table('property_list')
            ->leftjoin('users', 'users.id', '=', 'property_list.user_id')
            ->leftjoin('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('property_list.is_complete', '=', ACTIVE)
            ->where('property_list.property_status', '=', 1)
            ->where('property_list.status', '=', 1)
            ->where('property_list.is_disable', '=', ZERO)
            ->where('property_list.id', '!=', $property_id)
            ->select(
                'property_list.title',
                'property_room.bedroom_count',
                'property_room.bathroom_count',
                'property_list.property_size',
                'users.first_name',
                'users.last_name',
                'users.username',
                'users.profile_image',
                'property_list.id as property_id',
                'property_list.verified',
                'users.id as owner_id',
                'property_list.state',
                'property_list.city',
                'property_list.pets_allowed',
                'property_list.monthly_rate',
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
                ->orderBy('property_images.is_cover', 'desc')
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
                ->orderBy('property_images.is_cover', 'desc')
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
                $location = $property->state;
                $url =
                    "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" .
                    "&destinations=" .
                    $location .
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
            ->where('property_booking.status', '=', 2)
            ->where('property_booking.property_id', '=', $property_id)
            ->select('start_date', 'end_date')
            ->get();

        $b_dates = [];
        foreach ($booked_dates as $booked_date) {
            // Padding 24 hours for property owner

            $booking_start = Carbon::parse($booked_date->start_date);
            $booking_end = Carbon::parse($booked_date->end_date);
            $booking_start_date = $booking_start->subDay()->toDateString();
            $booking_end_date = $booking_end->addDay()->toDateString();
            $dates_list = $this->getDatesBetweenRange($booking_start_date, $booking_end_date);
            $b_dates = array_merge($b_dates, $dates_list);
        }

        $blocked_dates = DB::table('property_blocking')
            ->where('property_blocking.client_id', '=', CLIENT_ID)
            ->where('property_blocking.property_id', '=', $property_id)
            ->select('start_date', 'end_date')
            ->get();

        foreach ($blocked_dates as $blocked_date) {
            $blocked_dates_list = $this->getDatesBetweenRange($blocked_date->start_date, $blocked_date->end_date);
            $b_dates = array_merge($b_dates, $blocked_dates_list);
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

        if ($f_result['data']->pets_allowed == 1) {
            $pets = $this->yelp_pets($f_result['data']->lat, $f_result['data']->lng);
        } else {
            $pets = [];
        }
        $hospitals = $this->yelp_hospitals($f_result['data']->lat, $f_result['data']->lng);

        return view('property', $f_result)
            ->with('hospitals', $hospitals)
            ->with('booking_details', $booking_details)
            ->with('pets', $pets);
    }

    public function single_reservations($booking_id, Request $request)
    {
        if (empty($booking_id)) {
            return view('general_error', ['message' => 'We can’t find the booking you’re looking for.']);
        }
        $data = DB::table('property_booking')
            ->leftJoin('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->where('property_booking.client_id', CLIENT_ID)
            ->where('property_booking.booking_id', $booking_id)
            ->select(
                'property_booking.*',
                'property_list.monthly_rate',
                'property_list.check_in',
                'property_list.check_out',
            )
            ->first();

        $bookingModel = PropertyBooking::find($data->id);
        $owner = $bookingModel->owner;
        $traveller = $bookingModel->traveler;
        $property = $bookingModel->property;

        $guest_info = GuestsInformation::where('booking_id', $booking_id)->get();
        $pet_details = PetInformation::where('booking_id', $booking_id)->first();
        $data->role_id = $traveller->role_id;
        $data->traveller_profile_image = $traveller->profile_image;
        $data->traveller_name = $traveller->username;
        $data->owner_role_id = $owner->role_id;
        $data->owner_profile_image = $owner->profile_image;
        $data->owner_name = Helper::get_user_display_name($owner);
        $data->agency = implode(", ", array_filter([$data->name_of_agency, $data->other_agency])); // Booking Agency

        $payment_summary = $this->get_payment_summary($data);

        return view('owner.single_reservations', [
            'data' => $data,
            'property' => $property,
            'guest_info' => $guest_info,
            'pet_details' => $pet_details,
            'scheduled_payments' => $payment_summary['scheduled_payments'],
            'total_payment' => $payment_summary['grand_total'],
        ]);
    }

    public function traveller_fire_chat($id, Request $request)
    {
        $user_id = $request->session()->get('user_id');

        if (!$user_id) {
            return redirect('/');
        }

        if ($request->fbkey == "personal_chat") {
            $property = DB::table('personal_chat')
                ->where([['id', '=', $id], ['traveller_id', '=', $user_id]])
                ->first();
            if (!isset($property)) {
                error_log('..');
                return redirect('/');
            }
            // echo json_encode($property);exit;
            $traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->traveller_id)
                ->first();
            $owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->owner_id)
                ->first();

            $property_description = DB::table('property_list')
                ->where('id', $property->property_id)
                ->first();

            return view('traveller.fire_chat', [
                'owner' => $owner,
                'traveller' => $traveller,
                'id' => $id,
                'traveller_id' => $property->traveller_id,
                'property' => $property_description,
            ]);
        }
        if ($request->fbkey == "request_chat") {
            $property = DB::table('request_chat')
                ->where([['id', '=', $id], ['traveller_id', '=', $user_id]])
                ->first();

            if (!isset($property)) {
                error_log('..');
                return redirect('/');
            }

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
                    ->update(['stage' => 2]);

                $room_types = DB::table('property_room_types')
                    ->orderBy('name', 'ASC')
                    ->get();
                $property_types = DB::table('property_types')
                    ->orderBy('name', 'ASC')
                    ->get();
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

                $guest_count = DB::table('settings')
                    ->where('param', 'guest_count')
                    ->select('value')
                    ->first();
                $bed_count = DB::table('settings')
                    ->where('param', 'bedroom_count')
                    ->select('value')
                    ->first();

                return view('owner.add-property.2', [
                    'property_details' => $property_details,
                    'property_room' => $property_room,
                    'property_bedrooms' => $final,
                ])
                    ->with('stage', $stage)
                    ->with('property_data', $property_data)
                    ->with('client_id', $client_id)
                    ->with('room_types', $room_types)
                    ->with('property_types', $property_types)
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
                    ->update(['stage' => 3]);
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
                    ->update(['stage' => 4]);
                $property_data = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->first();

                $client_id = CLIENT_ID;
                return view('owner.add-property.4', [
                    'price' => $property_data->monthly_rate,
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
                    ->update(['stage' => 5]);
                $client_id = CLIENT_ID;
                $property_images = DB::table('property_images')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('property_id', '=', $property_id)
                    ->orderBy('is_cover', 'desc')
                    ->get();
                //var_dump($property_details); exit;
                return view('owner.add-property.5', [
                    'property_details' => $property_details,
                ])
                    ->with('stage', $stage)
                    ->with('client_id', $client_id)
                    ->with('property_images', $property_images);
                break;

            case 6:
                $all_amenties = AmenitiesList::where('client_id', '=', CLIENT_ID)
                    ->where('status', "=", ONE)
                    ->orderBy('amenities_name', 'ASC')
                    ->get();
                $amenties = Propertyamenties::where('property_id', $property_id)->get();
                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['stage' => 6]);
                $client_id = CLIENT_ID;
                //code to be executed if n=label3;
                // print_r($amenties);exit;
                return view('owner.add-property.6', [
                    'amenties' => $amenties,
                    'all_amenties' => $all_amenties,
                    'property_details' => $property_details,
                ])
                    ->with('stage', $stage)
                    ->with('client_id', $client_id);
                break;

            case 7:
                # code...

                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['stage' => 7]);

                if ($property_id) {
                    $property_rate = DB::table('property_list')
                        ->where('id', $property_id)
                        ->select('title', 'monthly_rate')
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
                        $list[$d]['price'] = $property_rate;
                    }
                    $icals = DB::table('third_party_calender')
                        ->where('property_id', '=', $property_id)
                        ->get();
                    $booked_events = DB::table('property_booking')
                        ->leftjoin('users as traveller', 'traveller.id', '=', 'property_booking.traveller_id')
                        ->where('property_booking.client_id', '=', CLIENT_ID)
                        ->where('property_booking.property_id', '=', $property_id)
                        ->where('property_booking.status', '=', 2)
                        ->select(
                            'property_booking.is_instant',
                            'property_booking.start_date',
                            'property_booking.end_date',
                            //                            DB::raw('DATE_FORMAT(property_booking.start_date, "%M %d, %Y") as start_date'),
                            //                            DB::raw('DATE_FORMAT(property_booking.end_date, "%M %d, %Y") as end_date'),
                            'traveller.first_name',
                            'traveller.last_name',
                        )
                        ->get();
                    $block_events = DB::table('property_blocking')
                        ->where('client_id', '=', CLIENT_ID)
                        ->where('property_id', '=', $property_id)
                        ->get();

                    $res = [];
                    $val = [];
                    foreach ($list as $key => $index) {
                        if (!in_array($index['date'], $val)) {
                            if ($index['date']) {
                                $val[] = $index['date'];
                                $res[] = $index;
                            }
                        }
                    }

                    //                    foreach ($booked_events as $key => $value) {
                    //                        if ($value->is_instant < 2) {
                    //                            $value->booked_on = APP_BASE_NAME;
                    //                        } else {
                    //                            $value->booked_on = 'Airbnb';
                    //                        }
                    //                    }

                    $booked_events->booked_on = APP_BASE_NAME;
                } else {
                    $booked_events = [];
                    $icals = [];
                    $property_rate = 0;
                    $res = [];
                    $block_events = [];
                }
                //                print_r($block_events);exit();
                return view(
                    'owner.add-property.7',
                    compact('property_details', 'booked_events', 'icals', 'block_events', 'res'),
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
        $property = DB::table('property_list')
            ->where('id', $request->property_id)
            ->first();

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
            'bedroom_count' => $request->no_of_bedrooms,
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
        $this->schedule_property_update_email($property);
        return redirect($url);
    }

    public function property_next3(Request $request)
    {
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
                'stage' => 3,
            ]);

        $prop = DB::table('property_list')
            ->where('id', $request->property_id)
            ->first();
        if ($prop->stage < 3) {
            $update_on_stage = $this->propertyList->where('id', $request->property_id)->update(['stage' => 3]);
        }

        $url = BASE_URL . 'owner/add-new-property/4/' . $request->property_id;

        $this->schedule_property_update_email($prop);
        return redirect($url);
    }

    public function property_next4(Request $request)
    {
        $ins = [];
        $ins['client_id'] = CLIENT_ID;
        $ins['monthly_rate'] = empty($request->monthly_rate) ? 0 : ltrim($request->monthly_rate, "0");
        $ins['cleaning_fee'] = empty($request->cleaning_fee) ? 0 : ltrim($request->security_deposit, "0");
        $ins['security_deposit'] = empty($request->security_deposit) ? 0 : ltrim($request->security_deposit, "0");
        $ins['check_in'] = $request->check_in;
        $ins['check_out'] = $request->check_out;
        $ins['cancellation_policy'] = $request->cancellation_policy;
        $ins['min_days'] = $request->minimumstay;
        $ins['is_instant'] = (int) $request->booking_type;
        $ins['stage'] = 4;

        $property = DB::table('property_list')
            ->where('id', $request->property_id)
            ->first();

        $update_rate = DB::table('property_list')
            ->where('id', $request->property_id)
            ->update($ins);

        $url = BASE_URL . 'owner/add-new-property/6/' . $request->property_id;
        $this->schedule_property_update_email($property);
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
            $list = [];

            $month = date('m');
            $year = date('Y');
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($d = 1; $d <= $days; $d++) {
                $time = mktime(12, 0, 0, $month, $d, $year);
                if (date('m', $time) == $month) {
                    $list[$d]['date'] = date('Y-m-d', $time);
                }
                $list[$d]['price'] = $property_details->monthly_rate;
            }
            $icals = DB::table('third_party_calender')
                ->where('property_id', '=', $property_id)
                ->get();
            $booked_events = DB::table('property_booking')
                ->leftjoin('users as traveller', 'traveller.id', '=', 'property_booking.traveller_id')
                ->where('property_booking.client_id', '=', CLIENT_ID)
                ->where('property_booking.property_id', '=', $property_id)
                ->where('property_booking.status', '=', 2)
                ->select(
                    'property_booking.is_instant',
                    DB::raw('DATE_FORMAT(property_booking.start_date, "%M %d, %Y") as start_date'),
                    DB::raw('DATE_FORMAT(property_booking.end_date, "%M %d, %Y") as end_date'),
                    'traveller.first_name',
                    'traveller.last_name',
                )
                ->get();
            $block_events = DB::table('property_blocking')
                ->where('client_id', '=', CLIENT_ID)
                ->where('property_id', '=', $property_id)
                ->get();
            $dates = [];

            $res = [];
            $val = [];
            foreach ($list as $key => $index) {
                if (!in_array($index['date'], $val)) {
                    if ($index['date']) {
                        $val[] = $index['date'];
                        $res[] = $index;
                    }
                }
            }

            //            foreach ($booked_events as $key => $value) {
            //                if ($value->is_instant < 2) {
            //                    $value->booked_on = APP_BASE_NAME;
            //                } else {
            //                    $value->booked_on = 'Airbnb';
            //                }
            //            }
            $booked_events->booked_on = APP_BASE_NAME;
        } else {
            $booked_events = [];
            $icals = [];
            $property_rate = 0;
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

        $this->schedule_property_update_email($property_details);
        return redirect($url)->with(compact('property_details', 'booked_events', 'icals', 'block_events', 'res'));
    }

    public function property_next6(Request $request)
    {
        //
        // print_r($request->all());exit;

        DB::table('property_amenties')
            ->where('client_id', CLIENT_ID)
            ->where('property_id', $request->property_id)
            ->delete();
        foreach ($request->all() as $key => $value) {
            if (!in_array($key, ['_token', 'client_id', 'property_id'])) {
                $icon = DB::table('amenities_list')
                    ->select('icon_url')
                    ->where('amenities_name', '=', $value)
                    ->value('user_id');
                $icon = str_replace('amenities/', '', $icon);
                $property_aminities = new Propertyamenties();
                $property_aminities->client_id = CLIENT_ID;
                $property_aminities->property_id = $request->property_id;
                $property_aminities->amenties_name = $value;
                $property_aminities->amenties_icon = $icon;
                $property_aminities->save();
            }
        }

        //        $request_data = print_r($request->all());
        //        Logger::info("Aminities add hitted with data :".$request_data);
        $property = DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $request->property_id)
            ->first();
        DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $request->property_id)
            ->update(['stage' => 6]);

        if (isset($request->save)) {
            session()->forget('property_id');
            $url = BASE_URL . "owner/calender?id=" . $request->property_id;
        } else {
            $url = BASE_URL . 'owner/add-new-property/5/' . $request->property_id;
        }

        $this->schedule_property_update_email($property);
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
            $this->schedule_property_update_email($property);
            $url = BASE_URL . 'owner/my-properties';
        }
        Logger::info('After ADDING NEW PROPERTY ' . $property->is_complete);

        return redirect($url);
    }

    public function schedule_property_update_email($property)
    {
        if ($property->is_complete == 1) {
            DB::table('property_list')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->id)
                ->update(['last_edited_at' => Carbon::now('UTC')]);
            ProcessPropertyUpdateEmail::dispatch($property->id)
                ->delay(now()->addMinutes(5))
                ->onQueue(EMAIL_QUEUE);
        }
    }

    public function schedule_auto_cancel_job($booking)
    {
        // New Requirements:
        // Users are not able to request booking with 7 days of checkin
        // Property owner must accept booking 5 days (5x24 hours) before check in
        // Property owner must accept booking within y days of booking request. before check in

        // Getting check in time
        $check_in = $booking->property->check_in;
        $timeSplit = Helper::get_time_split($check_in);

        // Exact check in time with date
        $check_in_date_time = Carbon::parse($booking->start_date);
        $check_in_date_time->setTime($timeSplit[0], $timeSplit[1], 0);
        $check_in_date_time = Helper::get_utc_time_user($check_in_date_time);

        // Last time that owner can accept booking. 5 days before check in time
        $last_approval_time = $check_in_date_time->copy()->subDays(5);

        $week_after_request = now('UTC')->addDays(7);
        $scheduler_date = Carbon::parse($last_approval_time->min($week_after_request));
        $scheduler_date->setTime($timeSplit[0], $timeSplit[1], 0);
        $owner_reminder_email = $scheduler_date->copy()->subDays(1);

        Logger::info('Cancel date: ' . $scheduler_date);
        Logger::info('Current date now: ' . Carbon::now());
        Logger::info('check_in_date_time: ' . $check_in_date_time);
        ProcessAutoCancel::dispatch($booking->id)
            ->delay($scheduler_date)
            ->onQueue(GENERAL_QUEUE);
        ProcessOwnerReminder::dispatch($booking->id)
            ->delay($owner_reminder_email)
            ->onQueue(GENERAL_QUEUE);
    }

    /**
     *save guest details of booking
     *
     *@param Request data
     *
     *@return details of booking
     */
    public function save_guest_information(Request $request)
    {
        $booking = PropertyBooking::where('booking_id', $request->booking_id)->first();

        if ($request->recruiter_name) {
            $booking->recruiter_name = $request->recruiter_name;
        }
        if ($request->recruiter_phone_number) {
            $booking->recruiter_phone_number = $request->recruiter_phone_number;
        }
        if ($request->recruiter_email) {
            $booking->recruiter_email = $request->recruiter_email;
        }
        if ($request->contract_start_date) {
            $booking->contract_start_date = date('Y-m-d', strtotime($request->contract_start_date));
        }
        if ($request->contract_end_date) {
            $booking->contract_end_date = date('Y-m-d', strtotime($request->contract_end_date));
        }
        if ($request->name_of_agency) {
            $booking->name_of_agency = $request->name_of_agency;
        }
        if ($request->other_agency) {
            $booking->other_agency = $request->other_agency;
        }
        $owner = $booking->owner;
        $traveller = $booking->traveler;
        $property = $booking->property;

        $booking->funding_source = $request->funding_source;
        $booking->status = ONE;
        $booking->cancellation_policy = $property->cancellation_policy;
        $booking->save();
        // Scheduling auto cancel job if there was no response from owner
        $this->schedule_auto_cancel_job($booking);

        $property_img = DB::table('property_images')
            ->where('property_images.client_id', '=', CLIENT_ID)
            ->where('property_images.property_id', '=', $property->id)
            ->orderBy('is_cover', 'DESC')
            ->first();
        $cover_img = '';
        if ($property_img && $property_img->image_url) {
            $cover_img = BASE_URL . ltrim($property_img->image_url, '/');
        }

        // Owner Mail
        $property_details = DB::table('property_list')
            ->where('client_id', CLIENT_ID)
            ->where('id', $booking->property_id)
            ->select('monthly_rate', 'check_in', 'check_out', 'title', 'id')
            ->first();

        $booking->monthly_rate = $property_details->monthly_rate;
        $booking->check_in = $property_details->check_in;
        $booking->check_out = $property_details->check_out;
        $booking_price = (object) Helper::get_price_details($booking, $booking->start_date, $booking->end_date);

        $bookingEmailType = $booking->is_instant ?? 0;
        if ($bookingEmailType != 0 || $bookingEmailType != 1) {
            $bookingEmailType = 0;
        }
        $welcome = EmailConfig::where('type', 3)
            ->where('role_id', $bookingEmailType)
            ->first();

        $owner_name = $owner->first_name . " " . $owner->last_name;
        $traveler_name = $traveller->first_name . " " . $traveller->last_name;

        Helper::send_booking_message(
            $owner_name,
            $owner->phone,
            $booking->start_date,
            $booking->end_date,
            $property_details->title,
            $booking->id,
            OWNER_NEW_BOOKING,
        );

        Helper::send_booking_message(
            $owner_name,
            $owner->phone,
            $booking->start_date,
            $booking->end_date,
            $property_details->title,
            $booking->id,
            OWNER_BOOKING_REMINDER,
        );

        Helper::send_booking_message(
            $traveler_name,
            $traveller->phone,
            $booking->start_date,
            $booking->end_date,
            $property_details->title,
            $booking->id,
            TRAVELER_CHECK_IN_APPROVAL,
        );

        Helper::send_booking_message(
            $traveler_name,
            $traveller->phone,
            $booking->start_date,
            $booking->end_date,
            $property_details->title,
            $booking->id,
            TRAVELER_CHECK_IN_APPROVAL_REMINDER,
        );

        $mail_data = [
            'name' => $owner_name,
            'text' => isset($welcome->message) ? $welcome->message : '',
            'property' => $property,
            'cover_img' => $cover_img,
            'data' => $booking,
            'booking_price' => $booking_price,
        ];

        $title = isset($welcome->title) ? $welcome->title : 'New booking from - ' . APP_BASE_NAME;
        $subject = isset($welcome->subject) ? $welcome->subject : "New booking from  - " . APP_BASE_NAME;
        $this->send_custom_email($owner->email, $subject, 'mail.booking-mail', $mail_data, $title);

        // Traveller Mail
        $mail_traveler = EmailConfig::where('type', 4)
            ->where('role_id', 0)
            ->first();

        $mail_data_traveler = [
            'name' => $traveler_name,
            'text' => isset($mail_traveler->message) ? $mail_traveler->message : '',
            'property' => $property,
            'cover_img' => $cover_img,
            'data' => $booking,
            'booking_price' => $booking_price,
        ];

        $title_traveler = isset($mail_traveler->title) ? $mail_traveler->title : 'New booking from - ' . APP_BASE_NAME;
        $subject_traveler = isset($mail_traveler->subject)
            ? $mail_traveler->subject
            : "New booking from  - " . APP_BASE_NAME;

        $this->send_custom_email(
            $traveller->email,
            $subject_traveler,
            'mail.booking-mail-traveler',
            $mail_data_traveler,
            $title_traveler,
        );

        if ($request->guest_name) {
            for ($i = 0; $i < count($request->guest_name); $i++) {
                if ($request->guest_id[$i]) {
                    $data = GuestsInformation::find($request->guest_id[$i]);
                } else {
                    $data = new GuestsInformation();
                }
                $data->booking_id = $request->booking_id;
                $data->guest_count = $request->guest_count;
                $data->name = $request->guest_name[$i];
                $data->occupation = $request->guest_occupation[$i];
                $data->phone_number = $request->phone_number[$i];
                $data->email = $request->email[$i];
                $data->age = $request->age[$i];
                $data->save();
            }
        }
        $pet_detail = PetInformation::where('booking_id', $request->booking_id)->first();
        if (!$pet_detail) {
            $pet_detail = new PetInformation();
        }
        if ($request->is_pet_travelling) {
            $petImage = $this->base_image_upload($request, 'pet_image', 'pets');
            $pet_detail->booking_id = $request->booking_id;
            $pet_detail->pet_name = $request->pet_name;
            $pet_detail->pet_breed = $request->pet_breed;
            $pet_detail->pet_weight = $request->pet_weight;
            $pet_detail->pet_image = $petImage;
            $pet_detail->save();
        } else {
            $pet_detail->delete();
        }
        return redirect()->intended('/owner/reservations/' . $booking->booking_id);
    }

    public function update_property($property_id)
    {
        $data = DB::table('property_list')
            ->where('id', '=', $property_id)
            ->first();
        $stage = 2;

        $url = BASE_URL . 'owner/add-new-property/' . $stage . '/' . $data->id;

        return redirect($url);
    }

    public function check_in_traveler_based_on_message(Request $request)
    {
        $response = new MessagingResponse();
        $data = $request->all();
        error_log(json_encode($data));
        $message = $data['Body'];
        $phone_number = $data['From'];
        Logger::info("Twilio webhook executed.");
        if (!isset($phone_number) || !isset($message)) {
            Logger::info("FAILED: Message and Phone are required fields.");
            return $response;
        }
        if (strtolower(trim($message)) == 'y') {
            $phone_number = str_replace(COUNTRY_CODE, "", $phone_number);
            $traveler = DB::table('users')
                ->where('phone', '=', $phone_number)
                ->where('role_id', '=', ZERO)
                ->first();

            if (isset($traveler)) {
                $booking = PropertyBooking::getActiveBookingForUser($traveler->id)
                    ->where('status', 2)
                    ->first();

                if (isset($booking)) {
                    if ($booking->already_checked_in == 0) {
                        $booking->already_checked_in = 1;
                        $booking->save();
                    }
                    Logger::info("SUCCESS: Traveler successfully check-in.");
                    return $response;
                } else {
                    Logger::info("FAILED: No booking found.");
                    return $response;
                }
            } else {
                Logger::info("FAILED: No traveler found.");
                return $response;
            }
        }
        Logger::info("FAILED: Something went wrong with webhook.");

        return $response;
    }

    public function my_properties(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $properties = DB::table('property_list')
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('property_list.user_id', '=', $user_id)
            ->where('property_list.is_complete', '=', 1)
            ->where('property_list.status', '=', 1)
            ->select('property_list.*', 'property_list.id as propertyId', 'property_list.status as propertyStatus')
            ->get();
        $properties_near = [];
        foreach ($properties as $property) {
            $pd = DB::table('property_images')
                ->where('property_images.client_id', '=', CLIENT_ID)
                ->where('property_images.property_id', '=', $property->propertyId)
                ->orderBy('property_images.sort', 'asc')
                ->orderBy('property_images.is_cover', 'desc')
                ->get();

            $cover_img = DB::table('property_images')
                ->where('property_images.client_id', '=', CLIENT_ID)
                ->where('property_images.property_id', '=', $property->propertyId)
                ->where('property_images.is_cover', '=', 1)
                ->first();
            foreach ($pd as $images) {
                $img_url = $images->image_url;
                $property->image_url = $img_url;
            }

            $propertys = [];
            $propertysd = [];
            if (count($pd) > 0) {
                if (isset($cover_img) && is_array($cover_img) && count($cover_img) == 1) {
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

    public function property_image_upload($cover_id = null, Request $request)
    {
        //
        $property_id = $request->session()->get('property_id');
        $complete_url = '';
        $cover_image_id = null;
        if ($property_id) {
            if ($request->hasfile('file')) {
                foreach ($request->file('file') as $key => $file) {
                    $complete_url = $this->base_image_upload_array($file, 'properties');
                    $insert_id = DB::table('property_images')->insertGetId([
                        'client_id' => CLIENT_ID,
                        'property_id' => $property_id,
                        'image_url' => $complete_url,
                        'sort' => ONE,
                        'status' => ONE,
                    ]);
                    if (strval($key) == $cover_id) {
                        $cover_image_id = $insert_id;
                    }
                }
                if ($cover_image_id) {
                    DB::table('property_images')
                        ->where('property_id', $property_id)
                        ->update(['is_cover' => 0]);
                    DB::table('property_images')
                        ->where('property_id', $property_id)
                        ->where('id', $cover_image_id)
                        ->update(['is_cover' => 1]);
                } else {
                    $cover_image_available = DB::table('property_images')
                        ->where('property_id', $property_id)
                        ->where('is_cover', '=', 1)
                        ->first();
                    if (!$cover_image_available) {
                        DB::table('property_images')
                            ->where("property_id", '=', $property_id)
                            ->limit(1)
                            ->update(['is_cover' => 1]);
                    }
                }
            }
        }
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
        $username = Helper::get_user_display_name($user);
        $check = DB::table('property_list')
            ->where('client_id', CLIENT_ID)
            ->where('id', $id)
            ->first();
        //print_r($check);exit;
        if ($check->is_disable == 0) {
            $disable = 1;
            //            $status = 0;
            $content = "Your Property : " . $check->title . "(Property ID : " . $check->id . ") Has been Disabled.";
        } else {
            $disable = 0;
            //            $status = 1;
            $content = "Your Property : " . $check->title . "(Property ID : " . $check->id . ") Has been Enabled.";
        }
        $update = DB::table('property_list')
            ->where('client_id', CLIENT_ID)
            ->where('id', $id)
            ->update(['is_disable' => $disable]);
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
        try {
            $file_name = 'data/' . $property_id . '.json';
            if (file_exists($file_name)) {
                unlink($file_name);
            }
            Logger::info('delete proprty for id' . $property_id);
            DB::table('property_list')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', '=', $property_id)
                ->update(['status' => 0]);
            //        $data = DB::table('property_list')
            //            ->join('users', 'users.id', '=', 'property_list.user_id')
            //            ->where('property_list.client_id', CLIENT_ID)
            //            ->where('property_list.id', $property_id)
            //            ->first();
            //        $mail_data = [
            //            'name' => $data->first_name . " " . $data->last_name,
            //            'data' => $data,
            //            'text' => 'Trying to delete his/her property',
            //        ];
            //        $title = 'Alert from - ' . APP_BASE_NAME;
            //        $subject = "Property Deletion request from - " . APP_BASE_NAME;
            //        $email = "guru@sparkouttech.com";
            //        // $email = "info@healthcaretravels.com";
            //        $this->send_custom_email($email, $subject, 'mail.property-delete-mail', $mail_data, $title);

            DB::table('property_amenties')
                ->where('client_id', CLIENT_ID)
                ->where('property_id', $property_id)
                ->delete();
            DB::table('property_bedrooms')
                ->where('client_id', CLIENT_ID)
                ->where('property_id', $property_id)
                ->delete();
            DB::table('property_room')
                ->where('client_id', CLIENT_ID)
                ->where('property_id', $property_id)
                ->delete();
            // DB::table('property_short_term_pricing')->where('client_id', CLIENT_ID)->where('property_id', $property_id)->delete();
            //        DB::table('property_images')
            //            ->where('client_id', CLIENT_ID)
            //            ->where('property_id', $property_id)
            //            ->delete();
            //        DB::table('property_rating')
            //            ->where('client_id', CLIENT_ID)
            //            ->where('property_id', $property_id)
            //            ->delete();
            //        DB::table('property_review')
            //            ->where('client_id', CLIENT_ID)
            //            ->where('property_id', $property_id)
            //            ->delete();
            //        DB::table('property_room')
            //            ->where('client_id', CLIENT_ID)
            //            ->where('property_id', $property_id)
            //            ->delete();
            return response()->json(['status' => 'SUCCESS', 'message' => 'Property removed successfully']);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'FAILED',
                'message' => $ex->getMessage(),
                'status_code' => ZERO,
            ]);
        }
    }

    public function list_pets($lat, $lng, $id)
    {
        $data = DB::table('property_list')
            ->where('id', $id)
            ->select('pets_allowed')
            ->first();
        if ($data->pets_allowed == 1) {
            $pets = $this->yelp_pets($lat, $lng);
        } else {
            $pets = (object) [];
        }
        return view('properties.list_pets_health')->with('pets', $pets);
    }
    public function list_health($lat, $lng, $id)
    {
        $hospitals = $this->yelp_hospitals($lat, $lng);
        return view('properties.list_pets_health')->with('hospitals', $hospitals);
    }

    public function request_cancellation($booking_id, Request $request)
    {
        $data = DB::table('property_booking')
            ->where('property_booking.client_id', CLIENT_ID)
            ->where('property_booking.booking_id', $booking_id)
            ->first();
        if (empty($data)) {
            return view('general_error', ['message' => 'Booking you are looking for does not exists!']);
        }
        // allow only if booking request is accepted
        if ($data->status != 2) {
            return view('general_error', ['message' => 'Request is not accepted yet']);
        }
        $user_id = $request->session()->get('user_id');
        if ($user_id != $data->traveller_id && $user_id != $data->owner_id) {
            // Do not allow other user to access booking details
            return view('general_error', ['message' => 'Invalid Access']);
        }

        $bookingModel = PropertyBooking::find($data->id);
        $property = $bookingModel->property;

        $is_owner = $user_id == $data->owner_id;
        if ($is_owner) {
            $title = 'Request to Cancel This Trip';
            $subTitle =
                'Once you submit your cancellation request, Health Care Travels will email you for more information.';
            $reasons = OWNER_CANCELLATION_REASONS;
        } else {
            $title = 'Request to Cancel Your Trip';
            $subTitle =
                "Make sure to review this property's cancellation policy before requesting to cancel. Once you submit your cancellation request, Health Care Travels will email you if we need more information. Unless the property owner is at fault, you will only receive a refund based on the property owner's cancellation policy. We recommend submitting a request at least 72 hours before your next scheduled payment.";
            $reasons = TRAVELLER_CANCELLATION_REASONS;
        }
        return view('properties.request_cancellation', [
            'booking' => $data,
            'title' => $title,
            'subTitle' => $subTitle,
            'reasons' => $reasons,
            'property' => $property,
            'is_owner' => $is_owner,
        ]);
    }

    public function submit_cancellation_request(Request $request)
    {
        try {
            $booking = PropertyBooking::where('booking_id', $request->booking_id)->first();
            if (empty($booking)) {
                return back()->withErrors(['Booking you are looking for does not exists!']);
            }
            if ($booking->cancellation_requested == 3) {
                return back()->withErrors(['Cancellation is in progress for this booking!']);
            }
            if ($booking->cancellation_requested == 2) {
                return back()->withErrors(['Cancellation is completed for this booking!']);
            }
            if ($booking->cancellation_requested == 1) {
                return back()->withErrors(['You have already request cancellation for this booking!']);
            }
            $user_id = $request->session()->get('user_id');
            PropertyBooking::where('booking_id', $request->booking_id)->update([
                'cancellation_requested' => 1,
                'cancellation_reason' => $request->cancellation_reason,
                'cancellation_explanation' => $request->cancellation_explanation,
                'cancelled_by' => $user_id,
                'already_checked_in' => $request->checked_in,
            ]);

            $bookingModel = PropertyBooking::find($booking->id);
            $owner = $bookingModel->owner;
            $traveler = $bookingModel->traveler;
            $property = $bookingModel->property;
            $is_owner = $user_id == $booking->owner_id;
            $user = $is_owner ? $owner : $traveler;
            $other_user = $is_owner ? $traveler : $owner;

            $mail_traveler = EmailConfig::where('type', 15)
                ->where('role_id', 0)
                ->first();

            // TODO: send email to user

            $name = $user->first_name . " " . $user->last_name;

            $title = $mail_traveler->title ?? APP_BASE_NAME . "Cancellation Request";
            $subject = $mail_traveler->subject ?? "Your Cancellation Request";
            $content =
                $mail_traveler->message ??
                "Health Care Travels has received your cancellation request. We'll contact you or confirm your cancellation within 72 hours.";
            $mail_data = [
                'name' => $name,
                'text' => $content,
            ];
            $this->send_custom_email($user->email, $subject, 'mail.cancellation_request', $mail_data, $title);

            // TODO: send email to other user

            $other_user_mail_data = [
                'name' => $other_user->first_name . " " . $other_user->last_name,
                'title' => $property->title,
                'requested_by' => $is_owner ? 'host' : 'traveler',
                'check_in' => date('m-d-Y', strtotime($bookingModel->start_date)),
                'check_out' => date('m-d-Y', strtotime($bookingModel->end_date)),
                'cancellation_reason' => $request->cancellation_reason,
                'cancellation_explanation' => $request->cancellation_explanation,
            ];
            Logger::info('Sending email to ' . $other_user->email . ' with data ' . json_encode($other_user_mail_data));
            $this->send_custom_email(
                $other_user->email,
                "Booking Cancellation Requested for " . $property->title,
                'mail.cancellation_request_another_user',
                $other_user_mail_data,
                $title,
            );

            // TODO: send email to Admin: support@healthcaretravels.com
            $mail_data_admin = [
                'name' => $name,
                'user_type' => $is_owner ? 'Owner' : 'Traveler',
                'property_title' => $property->title,
                'booking_row_id' => $booking->id,
                'booking_id' => $booking->booking_id,
                'owner' => $owner,
                'traveler' => $traveler,
                'reason' => $request->cancellation_reason,
                'explanation' => $request->cancellation_explanation,
                'checked_in' => $request->checked_in ? 'Yes' : 'No',
            ];
            $this->send_email_contact(
                $user->email,
                'Cancellation Request',
                'mail.cancellation_request_admin',
                $mail_data_admin,
                $name,
            );

            return back()->with(
                'success',
                'You have successfully requested cancellation for this booking, we will contact you soon!',
            );
        } catch (\Exception $ex) {
            Logger::error('Error Submitting request for cancelllation: ' . $ex->getMessage());
            return back()->withErrors([$ex->getMessage()]);
        }
    }
}
