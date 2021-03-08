@extends('layout.mail')
@section('content')
<div>
    Hi {{$name}},
</div>
<div style="padding-top: 5px;">
    Your stay at {{$propertyName}} is starting in 72 hours. Please be sure to <a href="{{$contact}}">contact the property owner</a> to discuss how to enter the property and begin your stay.
</div>
<div style="padding-top: 5px;">
    <b>Property Address:</b> {{$propertyAddress}} {{$propertyZip}}
</div>
<div style="padding-top: 5px;">
    <b>Host Name:</b> {{$ownerName}}
</div>
<div style="padding-top: 5px;">
    <b>Host Phone:</b> +1 ({{substr($ownerNumber,0,3)}}) {{substr($ownerNumber,3,3)}}-{{substr($ownerNumber,6,4)}}
</div>





@endsection
