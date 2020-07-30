@extends('layout.mail')
@section('content')
    <div>
        Hi {{$username}},
    </div>
    <div style="padding-top: 5px;">
        {{$text}}
    </div>
@endsection
