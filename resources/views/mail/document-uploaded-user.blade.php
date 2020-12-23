@extends('layout.mail')
@section('content')
    <div>
        Hi {{$user_name}},
    </div>
    <div style="padding-top: 5px;">
        Thanks for submitting your verification information. Your profile will be reviewed within 1 to 3 business days. We will send you an email upon approval.
    </div>
    <div style="padding-top: 5px;">
        In the meantime, you are welcome to continue browsing through our website and current listings.
    </div>
    <div style="padding-top: 10px;">
        <a href="{{BASE_URL}}" style="color: blue;text-decoration: underline;" target="_blank">
            Click here to visit Health Care Travels
        </a>
    </div>
@endsection
