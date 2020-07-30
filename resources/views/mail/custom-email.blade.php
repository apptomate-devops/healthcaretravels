@extends('layout.mail')
@section('content')
    <div style="float: left;">Hi {{$username}},</div>
    <br>
    <br>
    <div style="float: left;">
        {{$content}}
    </div>
@endsection
