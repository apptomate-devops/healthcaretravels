@extends('layout.mail')
@section('content')
<div>
    Hi {{$name}},
</div>
<div style="padding-top: 5px;">
    {{$travelerName}}'s stay at your property {{$propertyName}} is starting in less than 24 hours. Make sure you <a href="{{$contact}}">contact each other</a> beforehand to coordinate entry.
</div>
<div style="padding-top: 5px;">
    <b>Traveler Name: </b> {{$travelerName}}
</div>
<div style="padding-top: 5px;">
    <b>Traveler Phone: </b> {{$travelerPhone}}
</div>
@endsection