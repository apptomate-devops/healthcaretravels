@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        {{$text}}
@endsection
