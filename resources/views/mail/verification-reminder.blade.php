@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        {{$text}}
    </div>
    <div style="padding-top: 5px;">
        Please verify your profile at the link below within 48 hours
    </div>
    <div style="padding-top: 10px;">
        <a href="{{$BASE_URL ?? BASE_URL}}verify-account" style="color: blue;text-decoration: underline;" target="_blank">
            Verify here
        </a>
    </div>
@endsection
