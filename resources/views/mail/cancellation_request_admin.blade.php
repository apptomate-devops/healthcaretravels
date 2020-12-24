@extends('layout.mail')
@section('content')
    <div>
        Hi Admin,
    </div>
    <div style="padding-top: 5px;">
        Cancellation is requested by <b>{{$name}} ({{$user_type}})</b> for property <b>{{$property_title}}</b>. Here are the details for the request:
        <br>
        <br>
        <b>Booking ID:</b>
        <a href="{{BASE_URL}}admin/bookings/{{$booking_row_id}}">
             {{$booking_id}}
        </a>
        <br>
        <b>Owner Name:</b> {{Helper::get_user_display_name($owner)}}
        <br>
        <b>Owner Email:</b> {{$owner->email}}
        <br>
        <b>Traveler Name:</b> {{Helper::get_user_display_name($traveler)}}
        <br>
        <b>Traveler Email:</b> {{$traveler->email}}
        <br>
        <b>Reason:</b> {{$reason}}
        <br>
        <b>Explanation:</b> {{$explanation}}
        <br>
        <b>Has the traveler checked into this property?:</b> {{$checked_in}}
    </div>
@endsection
