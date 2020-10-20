@extends('layout.mail')
@section('content')
<div>
    Hi {{$name}},
</div>
<div style="padding-top: 5px;">
    Your stay at {{$propertyName}} is ending in 24 hours. Please be sure to <a href="{{$contact}}">contact the property owner</a> if any damages occupied before you leave. If the property owner finds no damage you will receive your full security deposit three days after check-out.
</div>
@endsection
