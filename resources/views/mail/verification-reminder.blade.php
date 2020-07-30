@extends('layout.mail')
@section('content')
    <div style="float: left;">
        Hi {{$name}},
    </div>
    <br>
    <br>
    <div style="float: left;">
        {{$text}}
    </div>
    <br>
    <div style="float: left;">
        Please verify your profile at the link below within 48 hours
    </div>
    <br>
    <br>
    <div style="float: left;">
        <a href="{{BASE_URL}}verify-account" style="color: blue;text-decoration: underline;">
            Verify here
        </a>
    </div>
@endsection
