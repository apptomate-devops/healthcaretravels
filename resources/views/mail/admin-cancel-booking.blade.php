@extends('layout.mail')
@section('content')
    <div>
        You booking at {{$propertyName}} for {{$check_in}} - {{$check_out}} has been cancelled. Please reach out to support for more information.
    </div>
    <div style="padding-top: 5px;">
        Traveler: {{$traveler_name}}
    </div>
    <div style="padding-top: 5px;">
        Property Owner: {{$owner_name}}
    </div>
@endsection
