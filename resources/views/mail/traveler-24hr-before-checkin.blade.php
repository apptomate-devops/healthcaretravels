@extends('layout.mail')
@section('content')
<div>
    Hi {{$name}},
</div>
<div style="padding-top: 5px;">
    Your stay at {{$propertyName}} is starting in 24 hours. Please be sure to contact the property owner to discuss how to enter the property and begin your stay.
</div>
@endsection