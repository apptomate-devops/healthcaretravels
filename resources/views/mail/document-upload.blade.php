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
    <div style="padding-top: 10px;">
        <a href="{{BASE_URL}}admin/single_user?id={{$id}}" style="color: blue;text-decoration: underline;" target="_blank">
            Verify here
        </a>
    </div>
@endsection
