<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class CommisionController extends BaseController
{
    //

    public function index(Request $request)
    {
        # code...
        $commision = $this->db::table('ad_commision')->first();
        return view('Admin.commision', compact('commision'));
    }

    public function update(Request $request)
    {
        # code...
        $res = [];
        $res['admin_commision'] = $request->admin_commision;
        $res['host_commision'] = $request->host_commision;
        $res['deposit'] = $request->deposit;
        $update = $this->db
            ::table('ad_commision')
            ->where('id', 1)
            ->update($res);
        return back()->with('success_message', 'Commision updated successfully');
    }
}
