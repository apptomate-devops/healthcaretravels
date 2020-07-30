@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        Welcome to Health Care Travels. We are excited to have you!
    </div>
    <div style="padding-top: 5px;">
        {{$text}}
    </div>
    <div style="padding-top: 10px;">
        <a href="{{$url}}" style="color: blue;text-decoration: underline;">
            Verify Email
        </a>
    </div>
@endsection
