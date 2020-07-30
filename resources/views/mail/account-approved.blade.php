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
        Again, welcome!
    </div>
    <br>
    <br>
    <div style="float: left;">
        <a href="{{BASE_URL}}login" style="color: blue;text-decoration: underline;">
            Login here
        </a>
    </div>
@endsection
