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
        return view('home', [
            'latest_properties' => $latest_properties,
            'categories' => $categories,
        ]);
    }

    public function non_discrimination_policy()
    {
        return view('policies.non-discrimination-policy');
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
}
