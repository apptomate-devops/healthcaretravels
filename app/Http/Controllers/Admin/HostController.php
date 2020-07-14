<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\Users;
use App\admin\Propertylist;
use App\admin\Becomeowner;
use App\admin\Propertybooking;
use App\admin\Country;
use App\admin\State;
use App\admin\Propertyamenties;
use App\admin\Propertyroom;
use App\admin\Propertyimage;
use App\admin\Propertylocation;
use DB;
use Log;
class HostController extends Controller
{
    protected $users;
    protected $propertylist;
    protected $become_owner;
    protected $property_booking;
    protected $country;
    protected $state;
    protected $property_amenties;
    protected $property_room;
    protected $property_image;
    protected $property_location;
    protected $property;

    public function __construct(
        Users $users,
        Propertylist $propertylist,
        Becomeowner $become_owner,
        Propertybooking $property_booking,
        Country $country,
        State $state,
        Propertyamenties $property_amenties,
        Propertyroom $property_room,
        Propertylocation $property_location,
        Propertyimage $property_image
    ) {
        $this->users = $users;
        $this->propertylist = $propertylist;
        $this->become_owner = $become_owner;
        $this->property_booking = $property_booking;
        $this->country = $country;
        $this->state = $state;
        $this->property_amenties = $property_amenties;
        $this->property_room = $property_room;
        $this->property_image = $property_image;
        $this->property_location = $property_location;
    }

    public function guestdashboard()
    {
        return view('admin.guest.guestdashboard');
    }

    public function hostlist()
    {
        $host = $this->users->where('user_type', 1)->get();
        return view('admin.host.hostlist', compact('host'));
    }
    public function addhost()
    {
        return view('admin.host.addhost');
    }
    public function hostview($id)
    {
        $host_user = $this->users->where('id', $id)->get();
        $host_owner = $this->become_owner->where('user_id', $id)->get();
        return view('admin.host.viewhost', compact('host_user', 'host_owner'));
    }
    public function hostedit($id)
    {
        $host_user = $this->users->where('id', $id)->get();
        $host_owner = $this->become_owner->where('user_id', $id)->get();
        return view('admin.host.edithost', compact('host_user', 'host_owner'));
    }
    public function hosteditstore(Request $request)
    {
        $input = $request->all();
        if ($input['step'] == '1') {
            # code...

            $this->users->find($input['id'])->update($input);
        } else {
            $this->become_owner->find($input['id'])->update($input);
        }

        return redirect('/keeperadmin/host/list');
    }
    public function hostdelete($id)
    {
        $owner = $this->become_owner->where('user_id', $id)->pluck('id');
        $this->users->find($id)->delete($id);
        $this->become_owner->find($owner[0])->delete($owner[0]);
        return redirect('/keeperadmin/host/list');
    }
    public function hoststore(Request $request)
    {
        $input = $request->all();

        //echo $input['account_name'];exit;
        // dd($input);exit;
        //$country = $input['country'];
        if ($input['status'] == 'on') {
            $input['status'] = '1';
        } else {
            $input['status'] = '0';
        }
        if ($input['status'] == ' ') {
            $input['status'] = '0';
        }
        if ($input['status'] == 'null' || $input['status'] == 'Null') {
            $input['status'] = '0';
        }
        // Image uploads
        if ($request->hasfile('profile_image')) {
            $image = $request->file('profile_image');
            $name = $image->getClientOriginalName();
            $image->move(public_path() . '/admin/uploads', $name);
            $input['profile_image'] = $name;
        }
        $input['password'] = bcrypt($input['password']);

        $input['client_id'] = 15465793;
        $input['role_id'] = 1;
        $input['user_type'] = 1;
        // dd($input);exit;

        $user_id = $this->users->create($input);
        $status = $input['status'];
        $owner_value = [];
        $owner_value['user_id'] = $user_id->id;
        $owner_value['client_id'] = $input['client_id'];
        $owner_value['location'] = $input['client_id'];
        $owner_value['type'] = 1;
        $owner_value['guests'] = $status;
        $owner_value['account_name'] = $input['account_name'];
        $owner_value['account_number'] = $input['account_number'];
        $owner_value['bank_name'] = $input['bank_name'];
        $this->become_owner->create($owner_value);

        // echo $propertylist_id->id;exit;

        return redirect('/keeperadmin/host/list');
    }
}
