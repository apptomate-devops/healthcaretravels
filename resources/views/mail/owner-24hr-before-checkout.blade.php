@extends('layout.mail')
@section('content')
<div>
    Hi {{$name}},
</div>
<div style="padding-top: 5px;">
    Your guest {{$travelerName}} at {{$propertyName}} has a check out in 24 hours. Please be sure to visit the property within 48 hours after your guest has checked out. If you find any damage(s), be sure to contact us immediately at <a href="mailto:support@healthcaretravels.com">support@healthcaretravels.com</a>.
</div>
@endsection
