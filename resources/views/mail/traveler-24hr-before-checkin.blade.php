@extends('layout.mail')
@section('content')
<div>
    Hi {{$name}},
</div>
<div style="padding-top: 5px;">
    Your stay at {{$propertyName}} is starting in 24 hours. Please be sure to contact the property owner to discuss how to enter the property and begin your stay.
</div>
<div style="padding-top: 5px;">
    Property Address: {{$propertyAddress}} {{$propertyZip}}
</div>
<div style="padding-top: 5px;">
    <b>Host Name:</b> {{$ownerName}}
</div>
<div style="padding-top: 5px;">
    <b>Host Phone:</b> +1 ({{substr($ownerNumber,0,3)}}) {{substr($ownerNumber,3,3)}}-{{substr($ownerNumber,6,4)}}
</div>





@endsection