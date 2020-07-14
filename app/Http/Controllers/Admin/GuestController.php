<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\Users;
use App\admin\Propertylist;
use App\admin\Becomeowner;
use App\admin\Propertybooking;
use DB;
use Log;
class GuestController extends Controller
{
    protected $users;

    public function __construct(
        Users $users,
        Propertylist $propertylist,
        Becomeowner $become_owner,
        Propertybooking $property_booking
    ) {
        $this->users = $users;
        $this->propertylist = $propertylist;
        $this->become_owner = $become_owner;
        $this->property_booking = $property_booking;
    }

    public function guestdashboard()
    {
        return view('admin.guest.guestdashboard');
    }

    public function guestlist()
    {
        $guest = $this->users->where('user_type', 0)->get();
        return view('admin.guest.guestlist', compact('guest'));
    }
    public function addguest()
    {
        return view('admin.guest.addguest');
    }
    public function guestview($id)
    {
        $guest = $this->users->where('id', $id)->get();
        return view('admin.guest.viewguest', compact('guest'));
    }
    public function guestedit($id)
    {
        $guest = $this->users->where('id', $id)->get();
        return view('admin.guest.editguest', compact('guest'));
    }
    public function guesteditstore(Request $request)
    {
        $input = $request->all();
        // dd($input);exit;
        $this->users->find($input['id'])->update($input);
        return redirect('/keeperadmin/guest/list');
    }
    public function guestdelete($id)
    {
        //$guest = $this->users->where('id', $id)->get();
        $this->users->find($id)->delete($id);
        return redirect('/keeperadmin/guest/list');
    }
    public function gueststore(Request $request)
    {
        $input = $request->all();

        if ($input['status'] == 'on') {
            $input['status'] = '1';
        } else {
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
        // dd($input);exit;
        $this->users->create($input);

        return redirect('/keeperadmin/guest/list');
    }
    public function dashboard()
    {
        $guest_value = 0;
        $guest = $this->users->where('user_type', 0)->count();
        $hoast = $this->become_owner->where('status', 1)->count();
        $property_hoast = $this->propertylist->where('is_complete', 1)->count();
        $propertybooking = $this->property_booking->whereDate('created_at', '=', date('2018-03-16'))->count();

        return view('admin.addguest', compact('guest', 'hoast', 'property_hoast', 'propertybooking'));
    }
}
