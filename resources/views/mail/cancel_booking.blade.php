@extends('layout.mail')
@section('content')

    <div>
        <span style="float:left; text-align:left;">
                    @if($mail_to == 'admin')
                Hi Admin,
            @elseif($mail_to == 'owner')
                Hi {{$owner_name}},
            @elseif($mail_to == 'traveller')
                Hi {{$traveler}},
            @else
                Hi,
            @endif
                    </span>

        <div style="clear:both;" ></div>
        <hr width="100%" />
    </div>
    <div class="mail-container">

        <!--'.$content.'-->
        <div style="margin: 0; padding: 0; margin-top: 1em">
            @if($mail_to == 'admin')
                <p>The Homeowner {{$owner_name}} for {{$property}} has  canceled the booking that was requested for  {{$start_date}} to {{$end_date}}. Check  to see if the traveler has  checked already, if not fully refund traveler or if traveler checked in review selected cancellation policy on listing by homeowner and refund or not refund.</p>
            @elseif($mail_to == 'owner')
                <p>we recevied your request to cancel {{$booking_id}} for {{$start_date}} to {{$end_date}}. At this time if any money was paid towards this booking by the traveler, the traveler will receive a full refund if they have not checked in.</p>
            @elseif($mail_to == 'traveller')
                <p>The Homeowner for  {{$property}}   has canceled the booking {{$booking_id}}  that was Requested for   {{$start_date}} to {{$end_date}}. if you have not checked in and money has been collected for this listing {{APP_BASE_NAME}}  will begin processing a refund.</p>
            @else
                <p>The Homeowner for  {{$property}}   has canceled the booking {{$booking_id}}  that was Requested for   {{$start_date}} to {{$end_date}}. if you have not checked in and money has been collected for this listing {{APP_BASE_NAME}}  will begin processing a refund.</p>
            @endif
        </div>
        <br />
    </div>
@endsection
