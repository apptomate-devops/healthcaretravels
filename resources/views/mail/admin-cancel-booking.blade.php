@extends('layout.mail')
@section('content')
    <div style="padding-top: 5px;">
        You booking at <b>{{$property_title}}</b> for <b>{{$check_in}} to {{$check_out}} </b> has been canceled. The reason for Canceled Booking: {{$cancellation_reason}}. If you feel this is in error please reach out to <a href="mailto:support@healthcaretravels.com">support@healthcaretravels.com</a> for more information.
    </div>
    <div style="padding-top: 5px;">
        Traveler: <b>{{$traveler_name}}</b>
    </div>
    <div style="padding-top: 5px;">
        Property Owner: <b>{{$owner_name}}</b>
    </div>
@endsection
