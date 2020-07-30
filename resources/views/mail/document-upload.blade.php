@extends('layout.mail')
@section('content')
    <div>
        A new user just submitted their registration information. Please review their uploads and approve/deny their profile in the admin portal.
    </div>
    <div style="padding-top: 5px;">
        Name: {{$username}}
    </div>
    <div style="padding-top: 5px;">
        User Type: {{$type}}
    </div>
@endsection
