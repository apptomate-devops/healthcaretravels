@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        You have a message waiting from {{$traveler_name}}
        <br>
        <a href="{{$owner_link}}" style="margin-top: 10px;">Click here to view</a>
    </div>
@endsection
