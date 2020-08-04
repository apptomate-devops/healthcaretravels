@extends('layout.mail')
@section('content')
    <div>
        Name : {{$name}},
    </div>
    <div style="padding-top: 5px;">
        Email : <a href="mailto:{{$email}}">{{$email}}</a>
    </div>
    <br>
    <br>
    Message :
    <div style="padding-top: 10px;">
        {{$text}}
    </div>
@endsection
