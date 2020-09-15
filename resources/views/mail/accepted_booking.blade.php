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
                <p>The Homeowner {{$owner_name}} for {{$property}} has  Accepted the booking that was requested for  {{$start_date}} to {{$end_date}}.</p>
            @elseif($mail_to == 'owner')
                <p>we recevied your request to accept {{$booking_id}} for {{$start_date}} to {{$end_date}}.</p>
            @elseif($mail_to == 'traveller')
                <p>The Homeowner for  {{$property}}   has accepted the booking {{$booking_id}}  that was Requested for   {{$start_date}} to {{$end_date}}.</p>
            @else
                <p>The Homeowner for  {{$property}}   has accepted the booking {{$booking_id}}  that was Requested for   {{$start_date}} to {{$end_date}}.</p>
            @endif
        </div>
        <br />
    </div>
@endsection
