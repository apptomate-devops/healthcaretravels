@extends('layout.mail')
@section('content')
    <div style="float: left;">
        A new user just submitted their registration information. Please review their uploads and approve/deny their profile in the admin portal.
    </div>
    <br>
    <br>
    <div style="float: left;">
        Name: {{$username}}
    </div>
    <br>
    <br>
    <div style="float: left;">
        User Type: {{$type}}
    </div>
@endsection
