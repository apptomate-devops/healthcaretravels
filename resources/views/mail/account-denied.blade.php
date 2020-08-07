@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        {{$text}}
    </div>
    <div style="padding-top: 5px;">
        Check your verification page to see which information was denied. Please correct the errors and resubmit documents for approval.
    </div>
@endsection
