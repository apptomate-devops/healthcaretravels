@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        This is a reminder that you have an automatic payment scheduled for your stay at <a href="{{BASE_URL}}property/{{$propertyId}}" style="color: blue;text-decoration: underline;" target="_blank">
            {{$propertyName}}
        </a>. Please make sure that the funds are available in your account within 72 hours.
    </div>
    <div style="padding-top: 5px;">
        Date: {{$date}}
    </div>
    <div style="padding-top: 5px;">
        Sum: ${{$amount}}
    </div>
    <div style="padding-top: 5px;">
        Account: {{$accountName}}
    </div>
@endsection
