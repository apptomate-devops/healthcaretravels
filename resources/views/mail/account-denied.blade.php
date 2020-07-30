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
        Please try again or contact support at <a href="mailto:info@healthcaretravels.com" target="_blank">info@healthcaretravels.com</a> for more information
    </div>
@endsection
