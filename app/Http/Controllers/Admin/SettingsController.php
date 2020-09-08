<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Settings;

class SettingsController extends BaseController
{
    //

    public function index(Request $request)
    {
        $settings = Settings::all();
        return view('Admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        foreach ($data as $key => $value) {
            $check = Settings::where('param', $key)->first();
            $c = Settings::where('param', $key)->count();
            if ($c & ($value != null)) {
                if ($check->is_image == 1) {
                    $value = $this->base_image_upload_with_keys($request, 'logo');
                } else {
                    $value = $value;
                }

                Settings::where('param', $key)->update(['value' => $value]);
            }
            //echo $key;
        }
        return back()->with('success_message', 'Updated sucessfully');
    }
}
