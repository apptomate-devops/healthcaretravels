@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        {{$text}}
    </div>
    <div style="padding-top: 5px;">
        Again, welcome!
    </div>
    <div style="padding-top: 10px;">
        <a href="{{BASE_URL}}login" style="color: blue;text-decoration: underline;">
            Login here
        </a>
    </div>
@endsection
