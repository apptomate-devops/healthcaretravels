<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use DB;

class CouponController extends BaseController
{
    public function index(Request $request)
    {
        # code...
        $coupon_codes = DB::table('coupon_code')->get();
        // dd($coupon_codes);
        return view('Admin.manage-coupon', compact('coupon_codes'));
    }

    public function store_coupon(Request $request)
    {
        $type = 1;
        if ($request->coupon_type == 1) {
            $type = 0;
        }
        $coupon = [];
        $coupon['coupon_name'] = $request->coupon_name;
        $coupon['coupon_code'] = $request->coupon_code;
        $coupon['max_no_users'] = $request->max_no_users;
        $coupon['coupon_valid_from'] = $request->coupon_valid_from;
        $coupon['coupon_valid_to'] = $request->coupon_valid_to;
        $coupon['coupon_type'] = $request->coupon_type;
        $coupon['is_percent'] = $type;
        $coupon['price_value'] = $request->price_value;
        $coupon['description'] = $request->description;
        $coupon['status'] = $request->status;
        DB::table('coupon_code')->insert($coupon);
        return back()->with('success_message', 'New coupon added successfully');
    }

    public function send_email_get(Request $request)
    {
        # code...
        $users = DB::table('users')->get();
        return view('Admin.send-email', compact('users'));
    }

    public function send_email_post(Request $request)
    {
        // print_r($request->all());exit;
        # code...
        $subject = $request->subject;
        $message = $request->message;
        $view = 'mail.email-admin-custom';
        $data = ['content' => $message];
        if ($request->tab == 1) {
            # code...
            foreach ($request->email as $key => $value) {
                $user = DB::table('users')
                    ->where('id', $value)
                    ->first();
                if (isset($user->email) && $user->email != '0' && $user->email != '') {
                    $email = $user->email;
                    $this->send_custom_email_admin($email, $subject, $view, $data);
                }
            }
        } elseif ($request->tab == 2) {
            $users = DB::table('users')
                ->where('role_id', 1)
                ->where('email', 'karthik.bca1111@gmail.com')
                ->get();
            foreach ($users as $key => $user) {
                if (isset($user->email) && $user->email != '0' && $user->email != '') {
                    $email = $user->email;
                    $this->send_custom_email_admin($email, $subject, $view, $data);
                }
            }
            // exit;
        } elseif ($request->tab == 3) {
            $users = DB::table('users')
                ->where('role_id', 0)
                ->get();
            foreach ($users as $key => $user) {
                if (isset($user->email) && $user->email != '0' && $user->email != '') {
                    $email = $user->email;
                    $this->send_custom_email_admin($email, $subject, $view, $data);
                }
            }
        } elseif ($request->tab == 4) {
            $users = DB::table('users')
                ->where('role_id', 2)
                ->get();
            foreach ($users as $key => $user) {
                if (isset($user->email) && $user->email != '0' && $user->email != '') {
                    $email = $user->email;
                    $this->send_custom_email_admin($email, $subject, $view, $data);
                }
            }
        } else {
            # code...
            $users = DB::table('users')->get();
            foreach ($users as $key => $user) {
                if (isset($user->email) && $user->email != '0' && $user->email != '') {
                    $email = $user->email;
                    $this->send_custom_email_admin($email, $subject, $view, $data);
                }
            }
        }

        return back()->with('success', 'Email sent successfully');
    }
}
