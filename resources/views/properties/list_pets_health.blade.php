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
.yelp_img{
    max-width: 100%;
    width: 60%;
}


</style>

<div class="container">
        <div class="row">
            <!-- Property Description -->
            <div class="property-description">
              @if(count($hospitals->businesses) != 0)
                <div class="col-sm-12" id="scroll_stop">
                    <div class="wpb_wrapper">
                    <br><br>
                    <h3> What’s Nearby for Health and Medical</h3>
                        <table class="basic-table">
                            <tbody>
                            @for($j=0;$j<count($hospitals->businesses);$j++)
                                <tr>
                                    <td style="width: 21%;">
                                        @if($hospitals->businesses[$j]->image_url != '')
                                        <img src="{{$hospitals->businesses[$j]->image_url}}" class="yelp_img">
                                        @else
                                            <img src="{{url('/')}}/public/no-image-icon.png" class="yelp_img">
                                        @endif
                                    </td>
                                    <td><a href="{{$hospitals->businesses[$j]->url}}"><strong>{{$hospitals->businesses[$j]->name}}&nbsp;&nbsp;</strong></a>(<strong>{{round($hospitals->businesses[$j]->distance * 0.00062137)}}&nbsp;Miles</strong>)<br>
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;@for($k=0;$k<count($hospitals->businesses[$j]->location->display_address);$k++)
                                            {{$hospitals->businesses[$j]->location->display_address[$k]}}
                                        @endfor
                                        <br>
                                        <i class="fa fa-phone"></i>&nbsp;<strong>{{$hospitals->businesses[$j]->display_phone}}</strong>
                                        <br>
                                        @for($i=1;$i<=$hospitals->businesses[$j]->rating;$i++)
                                            <span class="fa fa-star checked"></span>
                                        @endfor
                                    </td>
                                </tr>
                                @endfor
                           </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @if(isset($pets->businesses) && count($pets->businesses) != 0)
                <div class="col-sm-12" id="scroll_stop">
                    <div class="wpb_wrapper">
                    <br><br>
                    <h3>What’s Nearby for Pets</h3>
                        <table class="basic-table">
                            <tbody>
                            @for($j=0;$j<count($pets->businesses);$j++)
                                    <tr>
                                        <td style="width: 21%;">
                                            @if($pets->businesses[$j]->image_url != '')
                                            <img src="{{$pets->businesses[$j]->image_url}}" class="yelp_img">
                                            @else
                                                <img src="{{url('/')}}/public/no-image-icon.png" class="yelp_img">
                                            @endif
                                        </td>
                                        <td><a href="{{$pets->businesses[$j]->url}}"><strong>{{$pets->businesses[$j]->name}}&nbsp;&nbsp;</strong></a>(<strong>{{round($pets->businesses[$j]->distance * 0.00062137)}}&nbsp;Miles</strong>)<br>
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;@for($k=0;$k<count($pets->businesses[$j]->location->display_address);$k++)
                                                {{$pets->businesses[$j]->location->display_address[$k]}}
                                            @endfor
                                            <br>
                                            <i class="fa fa-phone"></i>&nbsp;<strong>{{$pets->businesses[$j]->display_phone}}</strong>
                                            <br>
                                           @for($i=1;$i<=$pets->businesses[$j]->rating;$i++)
                                                <span class="fa fa-star checked"></span>
                                            @endfor
                                        </td>
                                    </tr>
                                @endfor
                           </tbody>
                        </table>
                    </div>
                </div>
            @endif
         </div>
    </div>
</div>

<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->

@endsection
