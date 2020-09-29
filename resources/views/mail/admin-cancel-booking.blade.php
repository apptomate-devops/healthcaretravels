@extends('layout.mail')
@section('content')
    <div style="padding-top: 5px;">
        Your booking at <b>{{$property_title}}</b> for {{$check_in}} to {{$check_out}} has been cancelled. Please reach out to support for more information.
    </div>
    <div style="padding-top: 5px;">
        Traveler: <b>{{$traveler_name}}</b>
    </div>
    <div style="padding-top: 5px;">
        Property Owner: <b>{{$owner_name}}</b>
    </div>
@endsection
