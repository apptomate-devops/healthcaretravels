@extends('layout.mail')
@section('content')
    <div>
        Hi {{$user_name}},
    </div>
    <div style="padding-top: 5px;">
        {{$text}}
    </div>
@endsection
