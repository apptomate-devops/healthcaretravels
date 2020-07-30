@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        {{$text}}
    </div>
    <div style="padding-top: 5px;">
        Please try again or contact support at <a href="mailto:info@healthcaretravels.com" target="_blank">info@healthcaretravels.com</a> for more information
    </div>
@endsection
