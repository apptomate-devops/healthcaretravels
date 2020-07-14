<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use DB;

class CancellationController extends BaseController
{
    //

    public function index(Request $request)
    {
        $first = DB::table('cancellation_policy')
            ->where('id', 1)
            ->first();
        $second = DB::table('cancellation_policy')
            ->where('id', 2)
            ->first();
        $third = DB::table('cancellation_policy')
            ->where('id', 3)
            ->first();
        return view('Admin.cancellation-policy', compact('first', 'second', 'third'));
    }

    public function update(Request $request)
    {
        $res = [];
        $res['before_1_day'] = (int) $request->before_1_day;
        $res['before_15_day'] = (int) $request->before_15_day;
        $res['before_30_day'] = (int) $request->before_30_day;
        $update = DB::table('cancellation_policy')
            ->where('id', $request->id)
            ->update($res);
        return back()->with('success_message', 'Updated successfully');
    }
}
