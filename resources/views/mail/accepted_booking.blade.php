@extends('layout.mail')
@section('content')

    <div>
        <span style="float:left; text-align:left;">
                    @if($mail_to == 'admin')
                Hi Admin,
            @elseif($mail_to == 'owner')
                Hi {{$owner->first_name . ' ' . $owner->last_name}},
            @elseif($mail_to == 'traveller')
                Hi {{$traveler->first_name . ' ' . $traveler->last_name}},
            @else
                Hi,
            @endif
                    </span>

        <div style="clear:both;" ></div>
    </div>
    <div class="mail-container">

        <!--'.$content.'-->
        <div style="margin: 0; padding: 0; margin-top: 1em">
            @if($mail_to == 'admin')
                <p>The Homeowner {{$owner_name}} for {{$property}} has  Accepted the booking that was requested for  {{$start_date}} to {{$end_date}}.</p>

            @elseif($mail_to == 'owner')
                <div style="padding-top: 5px;">
                    Your booking with {{Helper::get_user_display_name($traveler)}} at {{$property_title}} for {{$start_date}} to {{$end_date}} is confirmed. Please visit the <a href="{{URL('/')}}/owner/my-bookings">Your Bookings</a> page on Health Care Travels to view more details.
                </div>
                <div>
                    @if($traveler->profile_image && $traveler->profile_image != ' ')
                        <img src="{{BASE_URL . ltrim($traveler->profile_image, '/')}}" style="width: 30px; height: 30px; border-radius: 15px; border: 1px solid #e08716" alt="">
                    @endif
                    <span> {{Helper::get_user_display_name($traveler)}} </span>
                </div>
                <div>
                    <h2><b>{{$property_title}}</b></h2>
                    <div class="row-space-1">
                        <strong>{{$property_room_type}}</strong>
                    </div>
                    <div>
                        <img src="{{$cover_img}}" style="width: 300px; height: 200px; margin-top: 20px;" alt="">
                    </div>
                </div>
                <div class="total_amount" style="flex: 1; display: inline-block; width: 100%; max-width: 400px; margin: 10px;color: white; background-color: #e78016; font-weight: bold; padding: 10px; text-align: center;">
                    <a href="{{URL('/')}}/owner/single-booking/{{$booking_id}}" style="color: white" target="_blank">
                        View Stay
                    </a>
                </div>


            @elseif($mail_to == 'traveller')
                <div style="padding-top: 5px;">
                    {{Helper::get_user_display_name($owner)}} confirmed your booking at {{$property_title}} for {{$start_date}} to {{$end_date}}. Please visit the <a href="{{URL('/')}}/traveler/my-reservations">My Trips</a> page on Health Care Travels to view more details. Note that the address and check-in details will be available to you 72 hours before your stay.
                    <br>
                    <br>
                    Please check your inbox for another email regarding your first housing payment.
                </div>
                <div>
                    @if($owner->profile_image && $owner->profile_image != ' ')
                        <img src="{{BASE_URL . ltrim($owner->profile_image, '/')}}" style="width: 30px; height: 30px; border-radius: 15px; border: 1px solid #e08716" alt="">
                    @endif
                    <span> {{Helper::get_user_display_name($owner)}} </span>
                </div>
                <div>
                    <h2><b>{{$property_title}}</b></h2>
                    <div class="row-space-1">
                        <strong>{{$property_room_type}}</strong>
                    </div>
                    <div>
                        <img src="{{$cover_img}}" style="width: 300px; height: 200px; margin-top: 20px;" alt="">
                    </div>
                </div>
                <div class="total_amount" style="flex: 1; display: inline-block; width: 100%; max-width: 400px; margin: 10px;color: white; background-color: #e78016; font-weight: bold; padding: 10px; text-align: center;">
                    <a href="{{URL('/')}}/owner/reservations/{{$booking_id}}" style="color: white" target="_blank">
                        View Stay
                    </a>
                </div>
            @else
                <p>The Homeowner for  {{$property}}   has accepted the booking {{$booking_id}}  that was Requested for   {{$start_date}} to {{$end_date}}.</p>
            @endif
        </div>
        <br />
    </div>
@endsection
