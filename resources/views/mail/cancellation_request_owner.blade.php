@extends('layout.mail')
@section('content')
    <div>
        Hi Admin,
    </div>
    <div style="padding-top: 5px;">
        Cancellation is requested by <b>{{$name}} ({{$user_type}})</b> for property <b>{{$property_title}}</b>. Here are the details for the request:
        <br>
        <br>
        <b>Booking ID:</b> {{$booking_id}}
        <br>
        <b>Owner Name:</b> {{$owner->first_name . ' ' . $owner->last_name}}
        <br>
        <b>Owner Email:</b> {{$owner->email}}
        <br>
        <b>Traveller Name:</b> {{$traveler->first_name . ' ' . $traveler->last_name}}
        <br>
        <b>Traveller Email:</b> {{$traveler->email}}
        <br>
        <b>Reason:</b> {{$reason}}
        <br>
        <b>Explanation:</b> {{$explanation}}
        <br>
        <b>Has the traveler checked in to this property?:</b> {{$checked_in}}
    </div>
@endsection
