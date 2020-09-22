@extends('layout.mail')
@section('content')
<div>
    Hi {{$name}},
</div>
<div style="padding-top: 5px;">
    This is a reminder that you have an automatic payment scheduled for your stay at <a href="{{property_link}}">{{property_name}}</a>. Please make sure that the funds are available in your account within 72 hours.
</div>
<div style="padding-top: 5px;">
Date: {{payment_date}}<br/>
Sum: {{payment_amount}}<br/>
Account: {{account_name}}<br/>
</div>
<div style="padding-top: 5px;">
    Thank you,
</div>
<div style="padding-top: 5px;">
    Health Care Travels Team
</div>
@endsection