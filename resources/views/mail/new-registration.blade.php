@extends('layout.mail')
@section('content')
    <div style="float: left;">
        A new user just signed up for Health Care Travels:
    </div>
    <br>
    <br>
    <div style="float: left;">
        {{$username}}
    </div>
    <br>
    <div style="float: left;">
        {{$email}}
    </div>
    <br>
    <div style="float: left;">
        {{$phone}}
    </div>
@endsection
