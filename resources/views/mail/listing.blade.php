@extends('layout.mail')
@section('content')
    <b>Hi {{$name}} </b>
    <br />
    <!--'.$content.'-->
    <div style="margin: 0; font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; padding: 0; margin-top: 1em">
        You successfully shared your property on Health Care Travels!
        <br>
        <br>
        Please remember to keep your property's <a href="{{$availability_calendar}}">availability calendar</a> updated. Don't forget to share your listing by email or social Media with Friends and Family.
        <br>
        <br>
        Quick Steps to sharing:
        <br>
        You can now view your public listing by clicking <a href="{{$property_link}}">here</a> and share by clicking this share bottom found on your listing.
        <br>
        Paste the copied code on Facebook, Twitter or send by email.
        <img src="/storage/public/copy-code.png">
        <br>
        <br>
        Congratulations!"
    </div>
@endsection
