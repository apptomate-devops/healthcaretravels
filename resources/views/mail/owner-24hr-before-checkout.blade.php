@extends('layout.mail')
@section('content')
<div>
    Hi {{$name}},
</div>
<div style="padding-top: 5px;">
    {{$travelerName}}'s stay at your property {{$propertyName}} ending in 24 hours. Please be sure to <a href="{{$contact}}">contact the traveler</a> to do a walk-through of the home before you leave. If you find any damage, be sure to contact us immediately.
</div>
@endsection