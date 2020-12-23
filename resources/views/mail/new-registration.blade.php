@extends('layout.mail')
@section('content')
    <div>
        A new user just signed up for Health Care Travels:
    </div>
    <div style="padding-top: 5px;">
        {{$user_name}}
    </div>
    <div style="padding-top: 5px;">
        {{$email}}
    </div>
    <div style="padding-top: 5px;">
        {{$phone}}
    </div>
@endsection
