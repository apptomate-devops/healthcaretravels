@extends('layout.mail')
@section('content')
    <div>
        Hi {{$user_name}},
    </div>
    <div style="padding-top: 5px;">
        {{$text}}
    </div>
    <div style="padding-top: 10px;">
        <a href="{{BASE_URL}}new-password/{{$token}}" style="color: blue;text-decoration: underline;" target="_blank">
            Click here to reset your password
        </a>
    </div>
@endsection
