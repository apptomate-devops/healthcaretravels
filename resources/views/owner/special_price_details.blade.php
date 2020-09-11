<?php
//echo json_encode($data);exit;
?>
@extends('layout.master') @section('title','Healthcare Travels') @section('main_content')
<style type="text/css">
  div::-webkit-scrollbar {
    width: 12px;
}

div::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    border-radius: 10px;
}

div::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
}

    .property-title h2 {
    font-size: 26px !important;
}
@media only screen and (min-width: 990px) {
.property-image p {
    text-align: right;
}
.property-pricing {
    margin-top: 40px;
}
.property-image .sub-price a {
    text-align: right;
}
.show-990{
    display: none;
}
}
@media only screen and (max-width: 989px) {

.show-990{
    display: show;
}
.hide-990{
    display: none;
}
.property-image p {
    text-align: center;
}
.property-pricing {
    margin-top: 40px;
}
.property-image .sub-price a {
    text-align: center;
}
}
@media only screen and (max-width: 767px) {
.show-990{
    display: none !important;
}
.hide-990{
    display: show !important;
}
}
.property-image .sub-price a {
    display: block;
    font-size: 19px;
    font-weight: 600;
}
.property-image p img {
    border-radius: 50%;
    width: 100px;
    margin-bottom: 0px;
}

.property-pricing {
    margin-top: 40px;
}
.comments {
    margin: -10px 0 0 0;
}
.td {
    padding: 10px;
}

#map_container{
  position: relative;
}
#map{
    height: 0;
    overflow: hidden;
    padding-bottom: 22.25%;
    padding-top: 30px;
    position: relative;
}

#contact_host{
        color: #e78016;
    text-decoration: underline;
    cursor: pointer;
}
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}
.fa {
    color: #e78016 !important;
}



</style>

<div class="container">
    <div class="row">
        <br><br>
        <div class="col-md-12">
            <table class="manage-table responsive-table">

                <tr>
                    <th><i class="fa fa-file-text"></i>Special Pricing</th>
                    {{-- <th class="expire-date"><i class="fa fa-calendar"></i> Status</th> --}}
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>

                <tr>
                    <td><strong>Date</strong></td>
                    <td><strong>Property</strong></td>
                    <td><strong>Amount</strong></td>
                    <td><strong>Action</strong></td>
                </tr>
{{--                @foreach($special_price as $property)--}}
{{--                <tr>--}}
{{--                    <td >{{$property->start_date}} </td>--}}
{{--                    <td >{{$property->title}} </td>--}}
{{--                    <td >{{$property->price_per_night}}</td>--}}
{{--                    <td >--}}
{{--                        <a href="{{url('/')}}/owner/delete_special_price/{{$property->id}}" class="delete"><i class="fa fa-remove"></i> Delete</a>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--                @endforeach--}}
            </table>
        </div>
        <div class="col-md-12">
            <table class="manage-table responsive-table">
                <tr>
                    <th><i class="fa fa-file-text"></i>Property Blocking</th>
                    {{-- <th class="expire-date"><i class="fa fa-calendar"></i> Status</th> --}}
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>

                <tr>
                    <td><strong>Date</strong></td>
                    <td><strong>Property</strong></td>
                    <td><strong>Description</strong></td>
                    <td><strong>Action</strong></td>
                </tr>
                @foreach($blocking as $property)
                <tr>
                    <td >{{$property->start_date}} </td>
                    <td >{{$property->title}} </td>
                    <td >{{$property->booked_on}}</td>
                    <td >
                        <a href="{{url('/')}}/owner/delete_blocked_date/{{$property->id}}" class="delete"><i class="fa fa-remove"></i> Delete</a>
                    </td>
                </tr>
                @endforeach
            </table>

            {{-- <a href="{{url('/')}}/owner/add-property" class="margin-top-40 button">Submit New Property</a> --}}
        </div>
    </div>
</div>

<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->

@endsection
