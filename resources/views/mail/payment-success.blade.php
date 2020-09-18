@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        A payment of ${{$amount}} has been @if(isset($deposit) && $deposit) deposited into @else withdrawn from @endif your account {{$accountName}}.
    </div>
    <div style="padding-top: 5px;">
        To view details of this payment, visit <a href="{{BASE_URL}}invoice/{{$booking_id}}" style="color: blue;text-decoration: underline;" target="_blank">
            this link
        </a>.
    </div>
@endsection
