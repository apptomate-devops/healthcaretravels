@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        The {{$requested_by}} has requested to cancel your booking at <b>{{$title}}</b> for dates <b>{{$check_in}}</b> to <b>{{$check_out}}</b>.
        Health Care Travels is currently reviewing the request and will confirm shortly.
        <br>
        <br>
        Cancellation Reason: {{$cancellation_reason}}
        <br>
        Description: {{$cancellation_explanation}}
        <br>
        <br>
        Please contact the {{$requested_by}} for more information.
    </div>
@endsection
