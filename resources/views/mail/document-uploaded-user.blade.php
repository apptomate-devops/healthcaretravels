@extends('layout.mail')
@section('content')
    <div style="float: left;">
        Hi {{$username}},
    </div>
    <br>
    <br>
    <div style="float: left;">
        Thanks for submitting your verification information. Your profile will be reviewed within 24 hours. We will send you an email upon approval.
    </div>
    <br>
    <br>
    <div style="float: left;">
        In the meantime, you are welcome to continue browsing through our website and current listings.
    </div>
@endsection
