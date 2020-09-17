Health Care Travels Team
@extends('layout.mail')
@section('content')
    <div>
    Hi {{name}},
    </div>
    <div style="padding-top: 5px;">
    {{travelerName}}'s stay at your property {{propertyName}}  ending in 24 hours. Please be sure to <a>contact the traveler</a> to do a walk-through of the home before you leave. If you find any damage, be sure to contact us immediately.
    </div>
    <div style="padding-top: 5px;">
    Thank you,
    </div>
    <div style="padding-top: 5px;">
    Health Care Travels Team
    </div>
@endsection
