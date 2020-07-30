@extends('layout.mail')
@section('content')
    <div style="float: left;">
        Name : {{$name}},
    </div>
    <br>
    <br>
    <div style="float: left;">
        Email : <a href="mailto:{{$email}}">{{$email}}</a>
    </div>
    <br>
    <br>
    <br>
    Message : <br><br>
    <div style="float: left;">
        {{$text}}
    </div>
@endsection
