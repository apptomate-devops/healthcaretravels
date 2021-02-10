@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        A @if(isset($deposit) && $deposit) deposit @else withdrawal @endif  of ${{$amount}} is being processed on your account {{$accountName}}.
    </div>
    <div style="padding-top: 5px;">
        To view details of this housing payment, visit <a href="{{BASE_URL}}invoice/{{$booking_id}}" style="color: blue;text-decoration: underline;" target="_blank">this link</a>.
    </div>
@endsection
