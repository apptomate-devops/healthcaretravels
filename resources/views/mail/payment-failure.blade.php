@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        An attempted @if(isset($deposit) && $deposit) deposited to @else withdraw from @endif your account {{$accountName}} failed.
    </div>
    <div style="padding-top: 5px;">
        Please <a href="{{BASE_URL}}login" style="color: blue;text-decoration: underline;" target="_blank">
            log in
        </a> to Health Care Travels to add a new payment method.
    </div>
@endsection
