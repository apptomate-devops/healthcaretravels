@extends('layout.mail')
@section('content')
    <b>Hi {{$name}} </b>
    <br />
    <!--'.$content.'-->
    <div style="margin: 0; font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; padding: 0; margin-top: 1em">
        You successfully edited your property listing. You can view your public listing <a href="{{$property_link}}">here</a>.
        <br>
        <br>
        Thank you.
    </div>
@endsection
