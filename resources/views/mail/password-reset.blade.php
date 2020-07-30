@extends('layout.mail')
@section('content')
    <div style="float: left;">
        Hi {{$username}},
    </div>
    <br>
    <br>
    <div style="float: left;">
        {{$text}}
    </div>
    <br>
    <br>
    <div style="float: left;">
        <a href="{{BASE_URL}}new-password/{{$token}}" style="margin: 0; font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; display: block; padding: 10px 16px; text-decoration: none; border-radius: 2px; border: 1px solid; text-align: center; vertical-align: middle; font-weight: bold; white-space: nowrap; background: #007dc6; background-color: #007dc6; color: rgb(255, 255, 255); border-top-width: 1px" target="_blank">
            Click here to reset your password
        </a>
    </div>
@endsection
