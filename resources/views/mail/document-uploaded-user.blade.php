@extends('layout.mail')
@section('content')
    <div>
        Hi {{$username}},
    </div>
    <div style="padding-top: 5px;">
        Thanks for submitting your verification information. Your profile will be reviewed within 24 hours. We will send you an email upon approval.
    </div>
    <div style="padding-top: 5px;">
        In the meantime, you are welcome to continue browsing through our website and current listings.
    </div>
@endsection
