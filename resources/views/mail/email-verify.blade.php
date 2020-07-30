@extends('layout.mail')
@section('content')
    <div style="float: left;">Hi {{$name}},</div>
    <br>
    <br>
    <div style="float: left;">
        Welcome to Health Care Travels. We are excited to have you!
    </div>
    <br>
    <br>
    <div style="float: left;">
        {{$text}}
    </div>
    <br>
    <br>
    <div style="float: left;">
        <a href="{{$url}}" style="color: blue;text-decoration: underline;">
            Verify Email
        </a>
    </div>
@endsection
