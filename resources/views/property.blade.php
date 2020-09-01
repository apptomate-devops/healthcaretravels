<?php
//echo json_encode($data);exit;
?>
@extends('layout.master') @section('title',$data->title) @section('main_content')
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

        .yelp_img{
            max-width: 100%;
            width: 60%;
        }




    </style>
    <div id="titlebar" class="property-titlebar margin-bottom-0">
        <div class="container">

            <div class="row" style="padding-top: 2%;background-color: #f2f2f2;margin-bottom: 20px;">
                <form name="test" action="{{url('/')}}/properties" method="post" utocomplete="off">
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="search" id="pac-input" style="height: 57px;" />
                    </div>
                    <div class="col-md-3">
                        <div class="check-in-out-wrapper">
                            <input type="text" name="from_date"
                                   placeholder="Check in"
                                   id="date_range_picker" autocomplete="off"/>
                            <input type="text" name="to_date"
                                   placeholder="Check out"
                                   id="date_range_picker" autocomplete="off"/>
                            <!-- <input type="text"  name="from_date" onchange="set_to_date();" placeholder="Check in" value="" id="from_date" /> -->
{{--                            <input type="text"  name="from_date" placeholder="Check in" value="" autocomplete="off" id="from_date" />--}}
                        </div>
                    </div>

{{--                    <div class="col-md-2 col-sm-6 col-xs-6">--}}
{{--                        <div class="main-search-input">--}}
{{--                            <input name="to_date"  type="text"  placeholder="Check out" value="" autocomplete="off" id="to_date" />--}}
{{--                            <!-- <input name="to_date"  type="text" onchange="check_to_date();" placeholder="Check out" value="" id="to_date" /> -->--}}

{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="col-md-2 text-center">
                        <button class="button" type="submit" style="width: 100%; margin: 5px 0 20px;" >Search</button>
                    </div>
                    <div id="search_location"></div>

                </form>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <!-- <a href="listings-list-with-sidebar.html" class="back-to-listings"></a> -->
                    <div class="col-md-3 col-sm-12 col-xs-6 property-image show-990">
                        <p>
                            <img style="max-height: 85px;max-width: 85px;" src="{{$data->profile_image}}" alt="">
                        </p>
                        <div class="sub-price">
                            <a href="{{url('/')}}/owner-profile/{{$data->user_id}}">{{$data->first_name}} {{$data->last_name}}</a><br>

                        </div>

                    </div>
                    <div class="property-title col-md-6 col-sm-6 col-xs-12" style="margin-left: 0px;">
                        <h2>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">{{$data->title}} </font>
                            </font>
                            <span class="property-badge">
                                <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                        {{$data->room_type}}
                                </font></font>
                            </span>
                            @if($data->verified==1)
                                <span class="property-badge" style="background-color: green">
                                    <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                        Verified
                                    </font></font>
                                </span>
                            @endif
                            @if($data->pets_allowed == 1)
                                <span>
                                    <img src="{{BASE_URL}}action_icons/Paw.png" />
                                </span>
                            @endif
                        </h2>

                        <span>
                              <a href="#location" class="listing-address">
                              <i class="fa fa-map-marker"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">

                              {{$data->city}},{{$data->state}}
                              </font></font></a>
                        </span>
                        <div class="property-price" style="font-size: 24px;color: #e78016;">
                            <font style="vertical-align: inherit;">
                                $ {{$data->price_per_night * $data->min_days}}/Month
                            </font>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <center>
                        <div style="margin-left: 18%;" class="col-md-3 col-sm-6 col-xs-6 property-image hide-990">
                            <p>
                                <img style="max-height: 85px;max-width: 85px;" src="{{$data->profile_image}}" alt="">
                            </p>
                            <div class="sub-price">
                                <a href="{{url('/')}}/owner-profile/{{$data->user_id}}">{{ucfirst($data->first_name)}} {{ucfirst($data->last_name)}}</a>
                            </div>
                            <div class="sub-price">
                                @if(Session::get('user_id'))
                                    {{--  <a href="{{URL('/')}}/create_chat/{{$property_id}}" target="_blank"><h3 id="contact_host"><span class="property-badge" style="background-color: #0983b8" >Message Host</span></h3></a> --}}

                                    <a><h3 id="contact_host"><span class="property-badge"  id="chat_host">Message Host</span></h3></a>
                                @else
                                    <a href="{{URL('/')}}/login" target="_blank"><h3 id="contact_host"><span class="property-badge" style="background-color: #0983b8">Login to Chat</span></h3></a>
                                @endif
                            </div>

                        </div>
                    </center>
                    {{-- <div class="property-pricing col-md-3 col-sm-3 col-xs-5"> ucfirst("hello world!");
                        <div class="property-price">
                                <font style="vertical-align: inherit;">$ {{$data->price_per_night}}</font><br>Per Night</font>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row margin-bottom-50">
            <div class="col-md-12">

                <!-- Slider -->
                <div class="property-slider default" style="max-height: 400px;">

                    @foreach($data->property_images as $property_image)
                        <a  href="{{$property_image->image_url}}" data-background-image="{{$property_image->image_url}}" class="item mfp-gallery"></a>
                    @endforeach
                </div>

                <!-- Slider Thumbs -->

                <div class="property-slider-nav">
                    @foreach($data->property_images as $property_image)


                        <div class="item"><img src="{{$property_image->image_url}}" alt="" style="height: 136px"></div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <!-- Property Description -->
            <div class="col-lg-8 col-md-7">
                <div class="property-description">
                    <!-- Main Features -->
                    <ul class="property-main-features">
                        <li>
                            <img src="{{BASE_URL}}bedicons/profile24.png">
                            {{$data->total_guests}} Guests
                            <input type="hidden" id="total_guest_count" value="{{$data->total_guests}}">
                        </li>
                        <li>
                            <img src="{{BASE_URL}}bedicons/keepersbed24.png">
                            {{$data->bed_count}} Beds
                        </li>
                        <li>
                            <img src="{{BASE_URL}}bedicons/bathtab2.png">   {{$data->bathroom_count}} Bathrooms
                        </li>
                        <li>
                            <img src="{{BASE_URL}}bedicons/Bedrooms.png">  {{$data->bedroom_count}} Bedrooms
                        </li>
                    </ul>


                {{-- <div id="contact_host_form">
                    <!-- <textarea id="cont_message"></textarea> -->
                    <!-- <div id="hide" style="padding: 10px;">Your message sent successfully.</div> -->
                    @if(!Session::get('role_id'))
                     <a href="{{URL('/')}}/login"><button id="" class="button" style="float :right;margin-top: 15px;">Login to Chat</button></a>
                    @else
                    <a href="{{URL('/')}}/create_chat/{{$property_id}}" target="_blank"><button id="" class="button" style="float :right;margin-top: 15px;">Send Message</button></a>
                    @endif
                </div> --}}

                <!-- Description -->
                    <h3 class="desc-headline">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">About Home</font>
                        </font>
                    </h3>
                    <div class="show-more" id="head_scroll">

                        <p>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">
                                    {{$data->description}}
                                </font>

                                <br>
                                <span id="show_less" style="cursor: pointer;color: #e78016;margin-left: 340px;">Show less</span>


                            </font>
                        </p>

                        <script type="text/javascript">
                            $("#show_less").click(function(){
                                $(".show-more").removeClass("visible");
                            });
                        </script>
                        <a href="#" class="show-more-button">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">show more </font>
                            </font><i class="fa fa-angle-down"></i></a>
                    </div>
                    <!-- <a href="#"><h3>Contact host</h3></a> -->
                    <!-- Details -->
                    <h3 class="desc-headline">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Property Details</font>
                        </font>
                    </h3>
                    <ul class="property-features margin-top-0">
                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Property ID: </font>
                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$property_id}}</font></font></span>
                        </li>

                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Property Type: </font>
                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$data->property_category}}</font></font></span>
                        </li>

                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Bathrooms: </font>
                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$data->bathroom_count}}</font></font></span>
                        </li>

                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Property Size: </font>
                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$data->property_size}}ft</font></font></span>
                        </li>

                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Beds: </font>
                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$data->bed_count}}</font></font></span>
                        </li>

                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Bedrooms : </font>
                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$data->bedroom_count}}</font></font></span>
                        </li>

                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Trash Pickup Days : </font>
                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$data->trash_pickup_days ?? 'No'}}</font></font></span>
                        </li>

                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Lawn Service :</font>
                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$data->lawn_service ? 'Yes' : 'No'}}</font></font></span>
                        </li>

                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Pets Allowed :</font>
                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$data->pets_allowed ? 'Yes' : 'No'}}</font></font></span>
                        </li>

                    </ul>

                    @if($data->room_type != "Entire Place")
                        <br><h4>Current Occupancy</h4>
                        <div class="col-sm-12" id="scroll_stop">
                            <ul class="property-features margin-top-0">
                                <li>
                                    <img src="{{BASE_URL}}icons/people.png" style="width: 30%;">
                                    <span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Total :  {{$data->cur_adults}}</font></font></span>
                                </li>
                                <li>
                                    <img src="{{BASE_URL}}icons/child.png" style="width: 30%;">
                                    <span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Total :  {{$data->cur_child}}</font></font></span>
                                </li>
                                <li>
                                    <img src="{{BASE_URL}}icons/pets.png" style="width: 30%;">
                                    <span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Total :  {{$data->cur_pets}}</font></font></span>
                                </li>
                            </ul>


                        </div><br><br>
                    @endif

                <!-- Features -->
                    @if(count($data->amenties))
                        <br>
                        <h3 class="desc-headline  amenities">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Amenities</font>
                            </font>
                        </h3>


                        <ul class="property-features margin-top-0">

                            @foreach($data->amenties as $aminity)
                                <li>
                                    <img src="{{BASE_URL}}{{$aminity->amenties_icon}}" style="width: 20px;" />
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">{{$aminity->amenties_name}}</font>
                                    </font>
                                </li>
                            @endforeach

                        </ul>
                        <br>
                    @endif

                    {{-- <h4>

                    Surveillance camera inside and outside :
                    @if(isset($data->is_camera) == 0)
                        No
                    @else
                        Yes
                    @endif
                    </h4> --}}
                    <br>
                    <h3 class="desc-headline">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">House Rules</font>
                        </font>
                    </h3>
                    <ul>
                        @if(isset($data->house_rules))
                            <li>
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">{{$data->house_rules}}</font>
                                </font>
                            </li>
                        @endif
                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Check-in Time: {{$data->check_in}}</font>
                            </font>
                        </li>
                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Check out Time: {{$data->check_out}}</font>
                            </font>
                        </li>
                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Cancellation Policy: {{$data->cancellation_policy}}<a href="{{URL('/')}}/cancellationpolicy">&nbsp;&nbsp;Read more</a></font>
                            </font>
                        </li>
                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Minimum Stay : {{$data->min_days}}</font>
                            </font>
                        </li>
                    </ul>

                    <!-- Floorplans -->
                    {{--
                    <h3 class="desc-headline no-border">Floorplans</h3>
                    <!-- Accordion -->
                    <div class="style-1 fp-accordion">
                        <div class="accordion">

                            <h3>First Floor <span>460 sq ft</span> <i class="fa fa-angle-down"></i> </h3>
                            <div>
                                <a class="floor-pic mfp-image" href="../../../i.imgur.com/kChy7IU.jpg">
                              <img src="../../../i.imgur.com/kChy7IU.jpg" alt="">
                            </a>
                                <p>Mauris mauris ante, blandit et, ultrices a, susceros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate aliquam egestas litora torquent conubia.</p>
                            </div>

                            <h3>Second Floor <span>440 sq ft</span> <i class="fa fa-angle-down"></i></h3>
                            <div>
                                <a class="floor-pic mfp-image" href="../../../i.imgur.com/l2VNlwu.jpg">
                                <img src="../../../i.imgur.com/l2VNlwu.jpg" alt="">
                              </a>
                                <p>Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit, faucibus interdum tellus libero ac justo. Vivamus non quam. Nullam laoreet,
                                    velit ut taciti sociosqu condimentum feugiat.</p>
                            </div>

                            <h3>Garage <span>140 sq ft</span> <i class="fa fa-angle-down"></i></h3>
                            <div>
                                <a class="floor-pic mfp-image" href="../../../i.imgur.com/0zJYERy.jpg">
                                <img src="../../../i.imgur.com/0zJYERy.jpg" alt="">
                              </a>
                            </div>

                        </div>
                    </div> --}}
                    <h3 class="desc-headline no-border">Sleeping Arrangements</h3>


                <!--    <div class="col-md-12" style="margin-bottom: 20px;">
                        @foreach($bed_rooms as $key => $bedroom)
                    <div class="col-md-4" style="/*background-color: #f7f7f7;*/border:1px solid #DBDBDB !important;border-color: white;">
                        <div>
                            <div> -->
                        <?php
//$rooms = explode(",",$bedroom[0]->bed_types);

// foreach($rooms as $room)
// {
//  $room = substr($room, 0, strpos($room, "-"));
//  $room = str_replace(" ","",$room);

//  switch ($room) {
//      case "double_bed";
//          echo '<img src="'.DOUBLE_BED.'" style="margin-left: 10px;margin-top: 10px;
//                                                    height: 24px;width: 24px;fill: currentcolor;" />';

//          break;
//      case "queen_bed";
//          echo '<img src="'.QUEEN_BED.'" style="margin-left: 10px;margin-top: 10px;
//                                                    height: 24px;width: 24px;fill: currentcolor;" />';

//          break;
//      case "single_bed";
//          echo '<img src="'.SINGLE_BED.'" style="margin-left: 10px;margin-top: 10px;
//                                                    height: 24px;width: 24px;fill: currentcolor;" />';

//          break;
//      case "sofa_bed";
//          echo '<img src="'.SOFA_BED.'" style="margin-left: 10px;margin-top: 10px;
//                                                    height: 24px;width: 24px;fill: currentcolor;" />';

//          break;
//      case "bunk_bed";
//          echo '<img src="'.BUNK_BED.'" style="margin-left: 10px;margin-top: 10px;
//                                                    height: 24px;width: 24px;fill: currentcolor;" />';
//          break;
//      default:
//          echo '<img src="'.COMMON_SPACE_BED.'" style="margin-left: 10px;margin-top: 10px;
//                                                    height: 24px;width: 24px;fill: currentcolor;" />';
//  }
// }
?>
                    <!-- </div>

                        <h4>Bedroom {{$key+1}}</h4> -->

                        <?php
// $rooms = explode(",",$bedroom[0]->bed_types);
// foreach($rooms as $room){
//  $room = str_replace("_"," ",$room);
//  echo $room = ucfirst($room).',';
// }
// $room_string = implode(",",$rooms);
// $bd = str_replace("_"," ",$room_string);
//$bd = ucfirst($bd);
?>
                    <!--  </div>
                        </div> -->
                        <!-- <div class="display">&nbsp;&nbsp;</div> -->
                    <!--    @endforeach

                    </div> -->

                    <!-- Carousel -->
                    <div class="col-md-12" id="">
                        <div class="carousel">



                        @foreach($bed_rooms as $key => $bedroom)
                            <!-- Listing Item -->
                                <div class="carousel-item">
                                    <div class="listing-item" style="text-align: center;">
                                        <!-- <div class="col-md-4" style="/*background-color: #f7f7f7;*/border:1px solid #DBDBDB !important;border-color: white;"> -->
                                        <div style="/*background-color: #f7f7f7;*/border:1px solid #DBDBDB !important;border-color: white;height: 250px;">
                                            <div style="padding: 20px;">
                                                <?php
                                                $rooms = explode(",", $bedroom[0]->bed_types);

                                                foreach ($rooms as $room) {
                                                    $room = substr($room, 0, strpos($room, "-"));
                                                    $room = str_replace(" ", "", $room);

                                                    switch ($room) {
                                                        case "double_bed":
                                                            echo '<img src="' .
                                                                DOUBLE_BED .
                                                                '" style="margin-left: 10px;margin-top: 10px;
                                                                height: 24px;width: 24px;fill: currentcolor;" />';

                                                            break;
                                                        case "queen_bed":
                                                            echo '<img src="' .
                                                                QUEEN_BED .
                                                                '" style="margin-left: 10px;margin-top: 10px;
                                                                height: 24px;width: 24px;fill: currentcolor;" />';

                                                            break;
                                                        case "single_bed":
                                                            echo '<img src="' .
                                                                SINGLE_BED .
                                                                '" style="margin-left: 10px;margin-top: 10px;
                                                                height: 24px;width: 24px;fill: currentcolor;" />';

                                                            break;
                                                        case "sofa_bed":
                                                            echo '<img src="' .
                                                                SOFA_BED .
                                                                '" style="margin-left: 10px;margin-top: 10px;
                                                                height: 24px;width: 24px;fill: currentcolor;" />';

                                                            break;
                                                        case "bunk_bed":
                                                            echo '<img src="' .
                                                                BUNK_BED .
                                                                '" style="margin-left: 10px;margin-top: 10px;
                                                                height: 24px;width: 24px;fill: currentcolor;" />';
                                                            break;
                                                        default:
                                                            echo '<img src="' .
                                                                COMMON_SPACE_BED .
                                                                '" style="margin-left: 10px;margin-top: 10px;
                                                                height: 24px;width: 24px;fill: currentcolor;" />';
                                                    }
                                                }
                                                ?>
                                            </div>
                                            {{--  <div style="padding-bottom: 20px;padding-left: 20px;padding-right: 20px;"> --}}
                                            <div >
                                                <h4>Bedroom {{$key+1}}</h4>

                                                <?php
                                                $rooms = explode(",", $bedroom[0]->bed_types);
                                                foreach ($rooms as $room) {
                                                    $room = str_replace("_", " ", $room);
                                                    echo $room = ucfirst($room) . ', ';
                                                }
                                                $room_string = implode(",", $rooms);
                                                $bd = str_replace("_", " ", $room_string);

//$bd = ucfirst($bd);
?>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                        <!-- <div class="display">&nbsp;&nbsp;</div> -->
                                    </div>
                                </div>
                                <!-- Listing Item / End -->
                            @endforeach


                        </div>
                    </div>
                    <br>
                    <h3>Property Price :</h3>
                    <div class="col-sm-12" id="scroll_stop">
                        <table cellpadding="1" cellspacing="1" border="1" style="width: 100%;margin-top: 10px;">
                            <tbody id="table_bodys">

                            <tr>
                                <td style="text-align: center;">Price per day</td>
                                <td style="text-align: center; width: 50%">$ {{$data->price_per_night}}</td>
                            </tr>

                            {{-- <tr>
                                <td style="text-align: center;">Price per night (7day+)</td>
                                <td style="text-align: center; width: 50%">$ {{$data->price_more_than_one_week}}</td>
                            </tr> --}}

{{--                            <tr>--}}
{{--                                <td style="text-align: center;">Price per night (30day+)</td>--}}
{{--                                <td style="text-align: center; width: 50%">$ {{$data->price_more_than_one_month}}</td>--}}
{{--                            </tr>--}}

                            <tr>
                                <td style="text-align: center;">Security Deposit</td>
                                <td style="text-align: center; width: 50%">$ {{$data->security_deposit}}</td>
                            </tr>

                            <tr>
                                <td style="text-align: center;">Cleaning fee</td>
                                <td style="text-align: center; width: 50%">$ {{$data->cleaning_fee}}</td>
                            </tr>

                            {{--

                            <tr>
                                <td style="text-align: center;">Security Deposit</td>
                                <td style="text-align: center;">$ {{$data->security_deposit}}</td>
                            </tr>

                            <tr>
                                <td style="text-align: center;">Price per weekend</td>
                                <td style="text-align: center;">$ {{$data->price_per_weekend}}&nbsp;(&nbsp;{{$data->weekend_days}}&nbsp;)</td>
                            </tr>

                            <tr>
                                <td style="text-align: center;">Minimum no of days</td>
                                <td style="text-align: center;">{{$data->min_days}}</td>
                            </tr> --}}
                            </tbody>
                        </table>
                    </div>
                    @if(isset($hospitals->businesses) && count($hospitals->businesses) != 0)
                        <div class="col-sm-12" id="scroll_stop">
                            <div class="wpb_wrapper">
                                <br><br>
                                <h3> What’s Nearby for Health and Medical</h3>
                                <table class="basic-table">
                                    <tbody>
                                    @if(count($hospitals->businesses) > 4)
                                        @for($j=0;$j<=4;$j++)
                                            <tr>
                                                <td style="width: 21%;">
                                                    @if($hospitals->businesses[$j]->image_url != '')
                                                        <img src="{{$hospitals->businesses[$j]->image_url}}" class="yelp_img">
                                                    @else
                                                        <img src="{{url('/')}}/no-image-icon.png" class="yelp_img">
                                                    @endif
                                                </td>
                                                <td><a href="{{$hospitals->businesses[$j]->url}}"><strong>{{$hospitals->businesses[$j]->name}}&nbsp;&nbsp;</strong></a>(<strong>{{round($hospitals->businesses[$j]->distance * 0.00062137)}}&nbsp;Miles</strong>)<br>
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;@for($k=0;$k<count($hospitals->businesses[$j]->location->display_address);$k++)
                                                        {{$hospitals->businesses[$j]->location->display_address[$k]}}
                                                    @endfor
                                                    <br>
                                                    @for($i=1;$i<=$hospitals->businesses[$j]->rating;$i++)
                                                        <span class="fa fa-star checked"></span>
                                                    @endfor
                                                </td>
                                            </tr>
                                        @endfor
                                    @endif
                                    @if(count($hospitals->businesses)<=4)
                                        @for($j=0;$j<count($hospitals->businesses);$j++)
                                            <tr>
                                                <td style="width: 21%;">
                                                    @if($hospitals->businesses[$j]->image_url != '')
                                                        <img src="{{$hospitals->businesses[$j]->image_url}}" class="yelp_img">
                                                    @else
                                                        <img src="{{url('/')}}/no-image-icon.png" class="yelp_img">
                                                    @endif
                                                </td>
                                                <td><a href="{{$hospitals->businesses[$j]->url}}"><strong>{{$hospitals->businesses[$j]->name}}&nbsp;&nbsp;</strong></a>(<strong>{{round($hospitals->businesses[$j]->distance * 0.00062137)}}&nbsp;Miles</strong>)<br>
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;@for($k=0;$k<count($hospitals->businesses[$j]->location->display_address);$k++)
                                                        {{$hospitals->businesses[$j]->location->display_address[$k]}}
                                                    @endfor
                                                    <br>
                                                    @for($i=1;$i<=$hospitals->businesses[$j]->rating;$i++)
                                                        <span class="fa fa-star checked"></span>
                                                    @endfor
                                                </td>
                                            </tr>
                                        @endfor
                                    @endif

                                    </tbody>
                                </table>
                                @if(count($hospitals->businesses) > 4)
                                    <center>
                                        <a href="{{URL('/')}}/list_pets_health/{{$data->lat}}/{{$data->lng}}/{{$property_id}}" class="button  margin-top-5" target="_blank">
                                            show more
                                        </a>
                                    </center>
                                @endif
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
                                    @if(count($pets->businesses) > 4)
                                        @for($j=0;$j<=4;$j++)
                                            <tr>
                                                <td style="width: 21%;">
                                                    @if($pets->businesses[$j]->image_url != '')
                                                        <img src="{{$pets->businesses[$j]->image_url}}" class="yelp_img">
                                                    @else
                                                        <img src="{{url('/')}}/no-image-icon.png" class="yelp_img">
                                                    @endif
                                                </td>
                                                <td><a href="{{$pets->businesses[$j]->url}}"><strong>{{$pets->businesses[$j]->name}}&nbsp;&nbsp;</strong></a>(<strong>{{round($pets->businesses[$j]->distance * 0.00062137)}}&nbsp;Miles</strong>)<br>
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;@for($k=0;$k<count($pets->businesses[$j]->location->display_address);$k++)
                                                        {{$pets->businesses[$j]->location->display_address[$k]}}
                                                    @endfor
                                                    <br>
                                                    @for($i=1;$i<=$pets->businesses[$j]->rating;$i++)
                                                        <span class="fa fa-star checked"></span>
                                                    @endfor
                                                </td>
                                            </tr>
                                        @endfor
                                    @endif
                                    @if(count($pets->businesses)<=4)
                                        @for($j=0;$j<count($pets->businesses);$j++)
                                            <tr>
                                                <td style="width: 21%;">
                                                    @if($pets->businesses[$j]->image_url != '')
                                                        <img src="{{$pets->businesses[$j]->image_url}}" class="yelp_img">
                                                    @else
                                                        <img src="{{url('/')}}/no-image-icon.png" class="yelp_img">
                                                    @endif
                                                </td>
                                                <td><a href="{{$pets->businesses[$j]->url}}"><strong>{{$pets->businesses[$j]->name}}&nbsp;&nbsp;</strong></a>(<strong>{{round($pets->businesses[$j]->distance * 0.00062137)}}&nbsp;Miles</strong>)<br>
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;@for($k=0;$k<count($pets->businesses[$j]->location->display_address);$k++)
                                                        {{$pets->businesses[$j]->location->display_address[$k]}}
                                                    @endfor
                                                    <br>
                                                    @for($i=1;$i<=$pets->businesses[$j]->rating;$i++)
                                                        <span class="fa fa-star checked"></span>
                                                    @endfor
                                                </td>
                                            </tr>
                                        @endfor
                                    @endif

                                    </tbody>
                                </table>
                                @if(count($pets->businesses) > 4)
                                    <center>
                                        <a href="{{URL('/')}}/list_pets_health/{{$data->lat}}/{{$data->lng}}/{{$property_id}}" class="button  margin-top-5" target="_blank">
                                            show more
                                        </a>
                                    </center>
                                @endif
                            </div>
                        </div>
                    @endif




                    <br><br><br>
                    <!-- Location -->
                    <h3 class="desc-headline no-border" id="location" style="margin-top: 21%;">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Location</font>
                        </font>
                    </h3>

                    <div class="col-sm-12" style="min-height: 300px;">
                        <iframe src="{{BASE_URL}}single-marker/{{$data->lat}}/{{$data->lng}}/{{$data->pets_allowed}}" style="width: 100%; height: 600px;" ></iframe>
                    </div>
                    <div class="clearfix"></div>
                    <b><h5>72 hours after confirmed booking exact location will be provided</h5></b>

                <!--   <img src="http://maps.googleapis.com/maps/api/staticmap?key=AIzaSyCR6Vgb6Tg6dvb0_dL9WUtAeNut6clrg9c&zoom=17&size=512x512&markers=icon:http://api.estatevue2.com/cdn/img/marker-green.png|{{$data->lat}},{{$data->lng}}" > -->

                <!-- <img src="http://maps.googleapis.com/maps/api/staticmap?key=AIzaSyByI8gik-nps54DdqY81oqS1GCFJK8mko4&zoom=17&size=512x512&markers=icon:http://api.estatevue2.com/cdn/img/marker-green.png|{{$data->lat}},{{$data->lng}}" > -->

                    <br>
                    @if(count($data->prop_full_rating) != 0)
                        <div class="col-sm-12" id="prop_full_rating">
                            <div class="wpb_wrapper">
                                <br><br>
                                <h3>Reviews</h3>
                                <table class="basic-table">
                                    <tbody>
                                    @if(count($data->prop_full_rating) > 4)
                                        @for($j=0;$j<=4;$j++)
                                            <tr>
                                                <td style="width: 21%;"><img src="{{$data->prop_full_rating[$j]->profile_image}}" style="border-radius: 85px;width: 58%;"></td>
                                                <td><strong>{{$data->prop_full_rating[$j]->first_name}}&nbsp;{{$data->prop_full_rating[$j]->last_name}}</strong></a><br>
                                                    {{$data->prop_full_rating[$j]->comments}}
                                                    <br>
                                                    @for($i=1;$i<=$data->prop_full_rating[$j]->rating;$i++)
                                                        <span class="fa fa-star checked"></span>
                                                    @endfor
                                                </td>
                                            </tr>
                                        @endfor
                                    @endif
                                    @if(count($data->prop_full_rating)<=4)
                                        @for($j=0;$j<count($data->prop_full_rating);$j++)
                                            <tr>
                                                <td style="width: 21%;"><img src="{{$data->prop_full_rating[$j]->profile_image}}" style="border-radius: 85px;width: 58%;"></td>
                                                <td><strong>{{$data->prop_full_rating[$j]->first_name}}&nbsp;{{$data->prop_full_rating[$j]->last_name}}</strong></a><br>
                                                    {{$data->prop_full_rating[$j]->comments}}
                                                    <br>
                                                    @for($i=1;$i<=$data->prop_full_rating[$j]->rating;$i++)
                                                        <span class="fa fa-star checked"></span>
                                                    @endfor
                                                </td>
                                            </tr>
                                        @endfor
                                    @endif

                                    </tbody>
                                </table>
                                @if(count($data->prop_full_rating) > 4)
                                    <center>
                                        <a href="" class="button  margin-top-5">
                                            show more
                                        </a>
                                    </center>
                                @endif
                            </div>
                        </div>
                    @endif




                    <br><br><br>
                    <section id="book-widget-stop"></section>

                    <section class="comments">



                    </section>
                <!-- Video
                    <h3 class="desc-headline no-border">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Property Video</font>
                        </font>
                    </h3>
                    <div class="responsive-iframe">
                        {{--<iframe width="560" height="315" src="{{$data->url}}" frameborder="0" allowfullscreen=""></iframe>--}}
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$data->url}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div> -->


                </div><br><br><br><br>
            </div>
            <!-- Property Description / End -->
            <!-- Sidebar -->
            <div class="col-lg-4 col-md-5 tempClass">
                <div class="sidebar sticky right">
                    <!-- Widget -->
                    <div class="widget margin-bottom-30">
                        <input type="hidden" value="{{BASE_URL}}property/{{$property_id}}" id="share_link">
                        <button class="widget-button with-tip" data-tip-content="Share" id="share">
                            <i class="sl sl-icon-cloud-upload"></i>
                            <div class="tip-content"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Share</font></font></div>
                        </button>

                        <button id="not_favourite" onclick="favourite({{$property_id}})" class="widget-button with-tip" data-tip-content="Favorites">
                            <i class="fa fa-star-o"></i>
                            <div class="tip-content"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Favorites</font></font></div>
                        </button>

                        <button id="yes_favourite" onclick="favourite({{$data->property_id}})" class="widget-button with-tip liked" data-tip-content="Favorites">
                            <i class="fa fa-star-o"></i>
                            <div class="tip-content"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Remove</font></font></div>
                        </button>
                        <!-- <button class="widget-button with-tip compare-widget-button" data-tip-content="Add to Compare">
                                <i class="icon-compare"></i>
                                <div class="tip-content"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Add to compare</font></font></div>
                            </button> -->
                        <div class="clearfix"></div>
                    </div>
                    <!-- Widget / End -->
                    <!-- Widget -->
                    <div class="widget booking-form-widget" >
                        <!-- Agent Widget -->
                        <form name="booking_form" action="{{BASE_URL}}book-now" method="post" id="booking_form">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="agent-widget" ><!-- style="overflow-y: auto;max-height: 400px;" -->
                                <div class="agent-title">
                                    {{--
                                    <div class="agent-photo"><img src="{{url('/')}}/public/images/agent-avatar.jpg" alt=""></div> --}}
                                    <div class="agent-details">
                                        <h4>
                                            <a href="#">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">
                                                        $ {{$data->price_per_night * $data->min_days}}/Month
                                                    </font>
                                                </font>
                                            </a>
                                        </h4>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <!--  <label>Check In</label>
                                    <input type="date" placeholder="Your Phone"> -->
                                <div id="check_in_div">
                                    <div class="form-group">
                                        <!-- Date input -->
                                        <label class="control-label" for="property_from_date">Check In</label>
                                        <input name="check_in" required value="@if(count($session)!=0) {{$session['fromDate']}} @endif" id="property_from_date" placeholder="Check In date" onchange="get_price({{$property_id}})" type="text" style="width: 273px;" >
                                    </div>
                                </div>
                                <!-- <label>Check Out</label>
                                    <input type="date" placeholder="Your Phone"> -->
                                <div id="check_out_div">
                                    <div class="form-group">
                                        <!-- Date input -->
                                        <label class="control-label" for="date">Check Out</label>
                                        <input name="check_out" value="@if(count($session)!=0) {{$session['toDate']}} @endif"  required id="property_to_date" onchange="get_price({{$property_id}})" placeholder="Check Out date" type="text" style="width: 273px;" >

                                        <input name="property_id" type="hidden" value="{{$property_id}}" >
                                    </div>
                                </div>
                                <!-- <div class="form-group">

                                    <label class="control-label" for="messages">Message</label>
                                    <textarea name="message" required id="messages" type="text" style="width: 273px;"></textarea>

                                </div> -->
                            <!-- onchange="get_price({{$property_id}})" -->
                                <input type="hidden" id="guest" name="guest_count">
                                <select required onchange="get_price({{$property_id}});" class="chosen-select-no-single validate" id="current_guest_count" >
                                    <option selected disabled>Guests</option>
                                    @for($i=1;$i<=$data->total_guests;$i++)
                                <option value="{{$i}}">{{$i}} Guest{{$i > 1 ? 's' : ''}}</option>
                                    @endfor

                                </select>

                                <div id="guest_details"></div>


                                <div id="pricing_details" style="margin-bottom: 10px;">

                                    <table cellpadding="1" cellspacing="1" border="1" style="width: 100%;margin-top: 10px; border-top: 1px solid lightgrey; border-bottom:  1px solid lightgrey;
                                 border-left: 1px solid white;
                                 border-right: 1px solid white" id="pricing">
                                        <thead>
                                        <tr>
                                            <th style="text-align: left;padding: 5px">Detail</th>
                                            <th style="text-align: left;padding: 5px">Price</th>
                                        </tr>
                                        </thead>
                                        <tbody id="table_body">

                                        </tbody>
                                        <br>
                                        <tr><td colspan="5" id="guest_alert" style="text-align: center; color: red;font-weight:bold"></td></tr>

                                    </table>

                                    @if(Session::get('user_id'))
                                        <input type="checkbox" required name="terms" id="terms" value="cmg" style="width: 19px;margin-bottom: 52px;">
                                        <p style="margin-bottom: 43px;margin-left: 22px;margin-top: -90px;">
                                            I agree with the <a href="{{BASE_URL}}/terms-of-use" target="_blank"> Term of Use </a> and
                                        </p>

                                        <p style="margin-bottom: 10px;margin-left: 22px;margin-top: -50px;">
                                            <a href="{{BASE_URL}}/cancellationpolicy" target="_blank"> Cancellation Policy </a>
                                        </p>
                                    @endif

                                </div>
                                @if(Session::get('user_id') !=  $data->user_id)
                                    @if(!Session::get('user_id'))
                                        <button onclick="location.href='{{BASE_URL}}login';" class="button fullwidth margin-top-5">
                                            Login to Book
                                        </button>
                                    @else
                                        <button class="button fullwidth margin-top-5 booking_button"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                                    Book Now </font></font>
                                        </button>
                                    @endif
                                @endif

                                <div class="alert" style="background-color: red;color: white;text-align: center;margin-top: 5%;">
                                    Property is not available
                                </div>




                                <!--   <h6 style="text-align: center;">OR</h6>
                                  <div class="form-group">  -->
                                <!-- Date input -->
                                <!--      <label class="control-label" for="date">Message</label>
                                   <textarea name="message"></textarea>
                               </div> -->
                                <!--  <button class="button fullwidth margin-top-5"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                             Contact HOST
                                         </font></font></button> -->
                            </div>
                            <!-- Agent Widget / End -->
                        </form>
                    </div>
                    <!-- Widget / End -->
                    <!-- Widget -->
                {{--
                <div class="widget">
                    <h3 class="margin-bottom-30 margin-top-30">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Mortgage Calculator</font>
                        </font>
                    </h3>
                    <!-- Mortgage Calculator -->
                    <form action="javascript:void(0);" autocomplete="off" class="mortgageCalc" data-calc-currency="USD">
                        <div class="calc-input">
                            <div class="pick-price tip" data-tip-content="Set This Property Price">
                                <div class="tip-content">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">This set Property Price</font>
                                    </font>
                                </div>
                            </div>
                            <input type="text" id="amount" name="amount" placeholder="Sale Price" required="">
                            <label for="amount" class="fa fa-usd"></label>
                        </div>
                        <div class="calc-input">
                            <input type="text" id="downpayment" placeholder="Down Payment">
                            <label for="downpayment" class="fa fa-usd"></label>
                        </div>
                        <div class="calc-input">
                            <input type="text" id="years" placeholder="Loan Term (Years)" required="">
                            <label for="years" class="fa fa-calendar-o"></label>
                        </div>
                        <div class="calc-input">
                            <input type="text" id="interest" placeholder="Interest Rate" required="">
                            <label for="interest" class="fa fa-percent"></label>
                        </div>
                        <button class="button calc-button" formvalidate=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Calculate</font></font></button>
                        <div class="calc-output-container">
                            <div class="notification success">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Monthly payment: </font>
                                </font><strong class="calc-output"></strong></div>
                        </div>
                    </form>
                    <!-- Mortgage Calculator / End -->
                </div> --}}
                <!-- Widget / End -->
                    <!-- Widget -->
                {{--
                <div class="widget">
                    <h3 class="margin-bottom-35">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Find Properties</font>
                        </font>
                    </h3>
                    <div class="listing-carousel outer owl-carousel owl-theme" style="opacity: 1; display: block;">
                        <!-- Item -->
                        <div class="owl-wrapper-outer">
                            <div class="owl-wrapper" style="width: 1878px; left: 0px; display: block; transition: all 0ms ease; transform: translate3d(0px, 0px, 0px);">
                                <div class="owl-item" style="width: 313px;">
                                    <div class="item">
                                        <div class="listing-item compact">
                                            <a href="#" class="listing-img-container">
                                                <div class="listing-badges">
                                                    <span class="featured"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Featured </font></font></span>
                                                    <span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">for sale</font></font></span>
                                                </div>
                                                <div class="listing-img-content">
                                                    <span class="listing-compact-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Eagle Apartments, </font></font><i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">$ 275,000</font></font></i></span>
                                                    <ul class="listing-hidden-content">
                                                        <li>
                                                            <font style="vertical-align: inherit;">
                                                                <font style="vertical-align: inherit;">Area of </font>
                                                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">530 sq ft</font></font></span></li>
                                                        <li>
                                                            <font style="vertical-align: inherit;">
                                                                <font style="vertical-align: inherit;">rooms </font>
                                                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">3</font></font></span></li>
                                                        <li>
                                                            <font style="vertical-align: inherit;">
                                                                <font style="vertical-align: inherit;">Beds </font>
                                                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">1</font></font></span></li>
                                                        <li>
                                                            <font style="vertical-align: inherit;">
                                                                <font style="vertical-align: inherit;">Temple </font>
                                                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">1</font></font></span></li>
                                                    </ul>
                                                </div>
                                                <img src="{{url('/')}}/public/images/listing-01.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="owl-item" style="width: 313px;">
                                    <div class="item">
                                        <div class="listing-item compact">
                                            <a href="#" class="listing-img-container">
                                                <div class="listing-badges">
                                                    <span class="featured"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Featured </font></font></span>
                                                    <span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">for sale</font></font></span>
                                                </div>
                                                <div class="listing-img-content">
                                                    <span class="listing-compact-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Selway Apartments, </font></font><i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">$ 245,000</font></font></i></span>
                                                    <ul class="listing-hidden-content">
                                                        <li>
                                                            <font style="vertical-align: inherit;">
                                                                <font style="vertical-align: inherit;">Area of </font>
                                                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">530 sq ft</font></font></span></li>
                                                        <li>
                                                            <font style="vertical-align: inherit;">
                                                                <font style="vertical-align: inherit;">rooms </font>
                                                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">3</font></font></span></li>
                                                        <li>
                                                            <font style="vertical-align: inherit;">
                                                                <font style="vertical-align: inherit;">Beds </font>
                                                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">1</font></font></span></li>
                                                        <li>
                                                            <font style="vertical-align: inherit;">
                                                                <font style="vertical-align: inherit;">Temple </font>
                                                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">1</font></font></span></li>
                                                    </ul>
                                                </div>
                                                <img src="{{url('/')}}/public/images/listing-02.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="owl-item" style="width: 313px;">
                                    <div class="item">
                                        <div class="listing-item compact">
                                            <a href="#" class="listing-img-container">
                                                <div class="listing-badges">
                                                    <span class="featured"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Featured </font></font></span>
                                                    <span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">for sale</font></font></span>
                                                </div>
                                                <div class="listing-img-content">
                                                    <span class="listing-compact-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Oak Tree Houses </font></font><i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">$ 325,000</font></font></i></span>
                                                    <ul class="listing-hidden-content">
                                                        <li>
                                                            <font style="vertical-align: inherit;">
                                                                <font style="vertical-align: inherit;">Area of </font>
                                                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">530 sq ft</font></font></span></li>
                                                        <li>
                                                            <font style="vertical-align: inherit;">
                                                                <font style="vertical-align: inherit;">rooms </font>
                                                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">3</font></font></span></li>
                                                        <li>
                                                            <font style="vertical-align: inherit;">
                                                                <font style="vertical-align: inherit;">Beds </font>
                                                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">1</font></font></span></li>
                                                        <li>
                                                            <font style="vertical-align: inherit;">
                                                                <font style="vertical-align: inherit;">Temple </font>
                                                            </font><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">1</font></font></span></li>
                                                    </ul>
                                                </div>
                                                <img src="{{url('/')}}/public/images/listing-03.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Item / End -->
                        <!-- Item -->
                        <!-- Item / End -->
                        <!-- Item -->
                        <!-- Item / End -->
                        <div class="owl-controls clickable">
                            <div class="owl-pagination">
                                <div class="owl-page active"><span class=""></span></div>
                                <div class="owl-page"><span class=""></span></div>
                                <div class="owl-page"><span class=""></span></div>
                            </div>
                            <div class="owl-buttons">
                                <div class="owl-prev"></div>
                                <div class="owl-next"></div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- Widget / End -->
                </div>
            </div>
            <!-- Sidebar / End -->
        </div>
        {{--
        <div class="row" style="background-color:#75a627;color:white;">
            <div class="col-md-1">
            </div>
            <div class="col-md-11">

                <h2>{{$data->first_name}} {{$data->last_name}}</h2>
                <p>A Family Man. Father of a cute little angel. a host that always longs to say, “Be my guest”. An IT professional by career, a vacation host by choice! I live in New Jersey, have rental interests in a few places in East Cost of US.</p>
                <a href="#" style="color:white" class="button">See Owner Profile</a><br>
                <a href="{{url('/')}}/owner/chat" style="color:white" class="button">Contact Owner</a>
                <br><br>
            </div>
        </div> --}}

    </div>

    <!-- Content
    ================================================== -->
    <div class="container workfrom" id="stop_scroll">
        <div class="row">

            <div class="col-md-12">
                <h3 class="headline margin-bottom-25 margin-top-65" style="text-align:center" id="silmilar-property">Similar Properties</h3>
            </div>

            <!-- Carousel -->
            <div class="col-md-12">
                <div class="carousel">

                @foreach($properties_near as $key => $property)
                    <!-- Listing Item -->
                        <div class="carousel-item">
                            <div class="listing-item">

                                <a href="{{url('/')}}/property/{{$property->property_id}}" class="listing-img-container">

                                    @if($property->verified==1)
                                        <div class="listing-badges">
                                            <span class="featured" style="background-color: {{$property->verified==1?'green':''}}"> {{$property->verified==1?'Verified':''}}</span>

                                        </div>
                                    @endif

                                    <div class="listing-img-content">
                                        <span class="listing-price">$ {{$data->price_per_night * $data->min_days}}/Month</i></span>
                                        {{-- <span class="like-icon with-tip" data-tip-content="Add to Bookmarks"></span>
                                        <span class="compare-button with-tip" data-tip-content="Add to Compare"></span> --}}
                                    </div>

                                    <!-- <div class="listing-carousel"> -->
                                    <div style="max-height: 240px;min-height: 240px;">
                                        <img style="max-height: 240px;min-height: 240px;" src="{{$property->image_url}}" alt="">
                                    </div>

                                    <!-- </div> -->

                                </a>

                                <div class="listing-content">

                                    <div class="listing-title">
                                        <h4 style="max-height: 70px;min-height: 70px;">
                                            <a href="{{url('/')}}/property/{{$property->property_id}}">{{$property->title}}</a>
                                        </h4>
                                        <a style="min-height: 70px;max-height: 70px;" href="{{url('/')}}/property/{{$property->property_id}}" class="listing-address popup-gmaps">
                                            <i class="fa fa-map-marker"></i>

                                            {{$property->city}},{{$property->state}}
                                        </a>
                                        @if($property->pets_allowed == 1)
                                            <div style="float: right;" title="Pets Allowed">
                                                <img src="{{BASE_URL}}action_icons/Paw.png" />
                                            </div>
                                        @endif
                                    </div>

                                    <ul class="listing-features">
                                        <li>Area <span>{{$property->property_size}} sq ft</span></li>
                                        <li>Bedrooms <span>{{$property->bedroom_count}}</span></li>
                                        <li>Bathrooms <span>{{$property->bathroom_count}}</span></li>
                                    </ul>

                                    <div class="listing-footer">
                                        <a href="{{url('/')}}/owner-profile/{{$property->owner_id}}">
                                            <i class="fa fa-user"></i> {{$property->first_name}} {{$property->last_name}}
                                        </a>
                                        {{-- <span><i class="fa fa-calendar-o"></i> 1 day ago</span> --}}
                                    </div>

                                </div>

                            </div>
                        </div>
                        <!-- Listing Item / End -->
                    @endforeach
                </div>
            </div>
            <!-- Carousel / End -->

        </div>
    </div>

    <div class="modal fade" id="copy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel"><b><span style="color:green">Success</span></b></h4>
                </div>
                <div class="modal-body">
                    Link Copied, you are now able to share.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Chat to Host</h4>
                </div>
                <div class="modal-body">
                    {{--  <a href="{{URL('/')}}/create_chat/{{$property_id}}" target="_blank"><h3 id="contact_host"><span class="property-badge" style="background-color: #0983b8" >Message Host</span></h3></a> --}}
                    <form action="{{URL('/')}}/create_chat/{{$property_id}}" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div id="check_in_div">
                            <div class="form-group">
                                <label class="control-label" for="chat_from_date">Check In</label>
                                <input name="check_in" required id="chat_from_date" placeholder="Check In date"  type="text" style="width: 273px;" >
                            </div>
                        </div>
                        <div id="check_out_div">
                            <div class="form-group">
                                <label class="control-label" for="date">Check Out</label>
                                <input name="check_out"  required id="chat_to_date"  placeholder="Check Out date" type="text" style="width: 273px;" >
                                <input name="property_id" type="hidden" value="{{$property_id}}" >
                            </div>
                        </div>
                        <center>
                            <button class="button  margin-top-5"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                        Request Chat
                                    </font></font>
                            </button>
                        </center>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->
    <script>


        $('input').attr('autocomplete', 'off');

        $("#contact_host").click(function(){
            $("#contact_host_form").toggle();
        });
        $("#contact_host_form").hide();
        // Starrr plugin (https://github.com/dobtco/starrr)
        var __slice = [].slice;

        (function($, window) {
            var Starrr;

            Starrr = (function() {
                Starrr.prototype.defaults = {
                    rating: void 0,
                    numStars: 5,
                    change: function(e, value) {}
                };

                function Starrr($el, options) {
                    var i, _, _ref,
                        _this = this;

                    this.options = $.extend({}, this.defaults, options);
                    this.$el = $el;
                    _ref = this.defaults;
                    for (i in _ref) {
                        _ = _ref[i];
                        if (this.$el.data(i) != null) {
                            this.options[i] = this.$el.data(i);
                        }
                    }
                    this.createStars();
                    this.syncRating();
                    this.$el.on('mouseover.starrr', 'span', function(e) {
                        return _this.syncRating(_this.$el.find('span').index(e.currentTarget) + 1);
                    });
                    this.$el.on('mouseout.starrr', function() {
                        return _this.syncRating();
                    });
                    this.$el.on('click.starrr', 'span', function(e) {
                        return _this.setRating(_this.$el.find('span').index(e.currentTarget) + 1);
                    });
                    this.$el.on('starrr:change', this.options.change);
                }

                Starrr.prototype.createStars = function() {
                    var _i, _ref, _results;

                    _results = [];
                    for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
                        _results.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"));
                    }
                    return _results;
                };

                Starrr.prototype.setRating = function(rating) {
                    if (this.options.rating === rating) {
                        rating = void 0;
                    }
                    this.options.rating = rating;
                    this.syncRating();
                    return this.$el.trigger('starrr:change', rating);
                };

                Starrr.prototype.syncRating = function(rating) {
                    var i, _i, _j, _ref;

                    rating || (rating = this.options.rating);
                    if (rating) {
                        for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
                            this.$el.find('span').eq(i).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
                        }
                    }
                    if (rating && rating < 5) {
                        for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
                            this.$el.find('span').eq(i).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
                        }
                    }
                    if (!rating) {
                        return this.$el.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
                    }
                };

                return Starrr;

            })();
            return $.fn.extend({
                starrr: function() {
                    var args, option;

                    option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
                    return this.each(function() {
                        var data;

                        data = $(this).data('star-rating');
                        if (!data) {
                            $(this).data('star-rating', (data = new Starrr($(this), option)));
                        }
                        if (typeof option === 'string') {
                            return data[option].apply(data, args);
                        }
                    });
                }
            });
        })(window.jQuery, window);

        $(function() {
            return $(".starrr").starrr();
        });

        $("#hide").hide();
        $("#send_message").click(function(){
            var message = $("#cont_message").val();
            $("#hide").show();
            //$("#contact_host_form").hide();
        });

        $( document ).ready(function() {

            var dateFormat = "mm/dd/yy";
            var date_today = new Date();
            var date_today_next_month = new Date();
            date_today_next_month.setMonth(date_today_next_month.getMonth() + 1);
            var fromOptions = {
                startDate: date_today,
                changeMonth: true,
            };
            var toOptions = {
                startDate: date_today_next_month,
                changeMonth: true,
            };
            var from = $("#from_date")
                .datepicker(fromOptions)
                .on("change", function () {
                    var selectedDate = getDate(this);
                    if (selectedDate) {
                        selectedDate.setMonth(selectedDate.getMonth() + 1);
                        toOptions.startDate = selectedDate;
                        toOptions.minDate = selectedDate;
                        to.datepicker("destroy");
                        to.datepicker(toOptions);
                    }
                });
            var to = $("#to_date").datepicker(toOptions)
                .on("change", function () {
                    var selectedDate = getDate(this);
                });
            function getDate(element) {
                var date;
                try {
                    date = new Date(element.value);
                } catch (error) {
                    date = null;
                }
                return date;
            }

            console.log(<?php echo json_encode($data); ?>);
            $('#stars').on('starrr:change', function(e, value){
                $('#count').html(value);
            });

            $('#stars-existing').on('starrr:change', function(e, value){
                $('#count-existing').val(value);
            });

            console.log(<?php echo json_encode($booked_dates); ?>	);
            $(".alert").hide();
            console.log('{{url('/')}}/loader.gif');
            var loader = '<img src="{{url('/')}}/loader.gif" height="30" width="30">';
            date=new Date();
            $("#property_from_date").datepicker({
                startDate: date,
                autoclose: true,
                datesDisabled:[ @foreach($booked_dates as $d) "{{$d['dates']}}" ,@endforeach ]
            });


            $("#property_from_date").change(function(){

                var fDate = $("#property_from_date").val();
                // alert(fDate);


                // $("#property_to_date").foucs();
                $("#property_to_date").datepicker('remove');
                $("#property_to_date").datepicker({
                    startDate: fDate,
                    autoclose: true,
                    datesDisabled: [ @foreach($booked_dates as $d) "{{$d['dates']}}",@endforeach ]
                });

            });




            var fav_id = '{{$data->is_favourite}}';
            if(fav_id == 1)
            {
                $("#yes_favourite").show();
                $("#not_favourite").hide();
            }
            if(fav_id == 0)
            {
                $("#yes_favourite").hide();
                $("#not_favourite").show();
            }
            moment.locale('tr');
//var ahmet = moment("25/04/2012","DD/MM/YYYY").year();
            var date = new Date();
            bugun = moment(date).format("DD/MM/YYYY");

            var date_input=$('input[name="date"]'); //our date input has the name "date"
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
            var options={
                //startDate: '+1d',
                //endDate: '+0d',
                container: container,
                todayHighlight: true,
                autoclose: true,
                format: 'dd/mm/yyyy',
                language: 'tr',
                //defaultDate: moment().subtract(15, 'days')
                //setStartDate : "<DATETIME STRING HERE>"
            };
            date_input.val(bugun);
            date_input.datepicker(options).on('focus', function(date_input){
                // $("h3").html("focus event");
            }); ;


            date_input.change(function () {
                var deger = $(this).val();
                // $("h3").html("<font color=green>" + deger + "</font>");
            });



            $('.input-group').find('.glyphicon-calendar').on('click', function(){
//date_input.trigger('focus');
//date_input.datepicker('show');
                //$("h3").html("event : click");


                if( !date_input.data('datepicker').picker.is(":visible"))
                {
                    date_input.trigger('focus');
                    // $("h3").html("Ok");

                    //$('.input-group').find('.glyphicon-calendar').blur();
                    //date_input.trigger('blur');
                    //$("h3").html("görünür");
                } else {
                }


            });


        });

        function favourite(id) {
            var url = 'set-favourite/'+id;
            $.ajax({
                "type": "get",
                "url" : url,
                success: function(data) {
                    console.log("Set favourite success ====:"+data);
                    location.reload();
                }
            });
        }

        function get_price(id) {

            var from_date = $("#property_from_date").val();
            var to_date = $("#property_to_date").val();
            var guest_count = $("#current_guest_count").val();
            var totalguestcount=parseInt($('#total_guest_count').val());
            totalguestcount = isNaN(totalguestcount) ? 0 : totalguestcount;

            $("#pricing_details").show();
            $('.guest').show();

            if(!id || !from_date || !to_date) {
                return;
            }
            var url = 'get-price?property_id='+id+"&check_in="+from_date+"&check_out="+to_date+"&guest_count="+guest_count;


            $.ajax({
                "type": "get",
                "url" : url,
                success: function(data) {
                    // console.log("room ",data);
                    if (data.status == 'FAILED' && data.status_code == 0) {
                        $(".alert").html("Property not available");
                        $(".alert").show();
                        $("#table_body").html("");
                        $('.booking_button').attr('disabled',true);
                        $('.booking_button').css('background','lightgrey');

                    }
                    if (data.status == 'FAILED' && data.status_code == 1) {
                        $(".alert").html("Please review the house rules for Minimum night stay.");
                        $(".alert").show();
                        $("#table_body").html("");
                        $('.booking_button').attr('disabled',true);
                        $('.booking_button').css('background','lightgrey');

                    }

                    if(data.status == 'SUCCESS'){
                        $(".alert").html("");
                        $(".alert").hide();
                        $('.booking_button').attr('disabled',false);
                        $('.booking_button').css('background','#0983b8');
                    }


                    console.log("Set favourite success ====:"+JSON.stringify(data));
                    //location.reload();{"client_id":"15465793","single_day_fare":5000,"total_days":2,"city_fare":0,
                    // "cleaning_fare":0,"tax_amount":1100,"initial_pay":2200,"total_amount":11000
                    // <div class="tooltips">Hover over me
                    //                 <span class="tooltiptext">Tooltip text</span>
                    //               </div>

                    if(data.data) {
                        var tr;
                        var tr_data="";
                        tr_data +="<tr><td style='text-align: left;color:black;padding:5px'> $ "+data.data.single_day_fare+" X "+data.data.normal_days+" Night &nbsp;</td><td style='text-align: right;color:black;padding:5px'> $ "+data.data.single_day_fare*data.data.normal_days+".00</td></tr>";
                        // if(data.data.extra_guest>0){
                        //     //edited By Karthik for Extra Guest systems.
                        //     tr_data +="<tr><td style='text-align: left;color:black;padding:5px'>Extra guest "+data.data.extra_guest+" X "+data.data.price_per_extra_guest+"  &nbsp;<span class='tooltips'><i class='fa fa-question-circle'></i><span class='tooltiptext'>Average Nightly rate is Rounded</span></span></td><td style='text-align: right;color:black;padding:5px'> $ "+data.data.extra_guest_price+".00</td></tr>";
                        //    }
                        // if(data.data.week_end_days > 0){

                        //  tr_data +="<tr><td style='text-align: left;color:black;padding:5px'>"+data.data.price_per_weekend+" X "+data.data.week_end_days+"Night &nbsp;<span class='tooltips'><i class='fa fa-question-circle'></i><span class='tooltiptext'>Weekend Price</span></span></td><td style='text-align: right;color:black;padding:5px'> $ "+data.data.weekend_total+".00</td></tr>";
                        // }
                        tr_data +="<tr><td style='text-align: left;color:black;padding:5px'>Service Fee &nbsp;<span class='tooltips'><i class='fa fa-question-circle'></i><span class='tooltiptext'>This fee helps us run our platform and offer our services </span></span></td><td style='text-align: right;color:black;padding:5px'>$ "+data.data.service_tax+".00</td></tr>";

                        tr_data +="<tr><td style='text-align: left;color:black;padding:5px'>Cleaning Fee&nbsp;<span class='tooltips'><i class='fa fa-question-circle'></i><span class='tooltiptext'> fee charged by host to cover the cost of cleaning their space.</span></span></td><td style='text-align: right;color:black;padding:5px'>$ "+data.data.cleaning_fare+".00</td></tr>";
                        // tr_data +="<tr><td style='text-align: left;color:black;padding:5px'>Tax&nbsp;<span class='tooltips'><i class='fa fa-question-circle'></i><span class='tooltiptext'>Average Nightly rate is Rounded</span></span></td><td style='text-align: left;color:black;padding:5px'>$ "+data.data.tax_amount+".00</td></tr>";

                        tr_data +="<tr><td style='text-align: left;color:black;padding:5px'>Security Deposit &nbsp;<span class='tooltips'><i class='fa fa-question-circle'></i><span class='tooltiptext'>Deposit collected by host in case of damages. Refundable based on Cancellation Policy</span></span></td><td style='text-align: right;color:black;padding:5px'>$ "+data.data.security_deposit+"</td></tr>";


                        tr_data +="<tr><td style='text-align: left;color:black;padding:5px'>Total &nbsp;</td><td style='text-align: right;color:black;padding:5px'><b  id='total_booking_price'>$ "+data.data.total_amount+".00</b></td></tr>";
                        if(data.data.no_extra_guest==1){
                            if(totalguestcount < guest_count){
                                $('.booking_button').attr('disabled',true);
                                $('.booking_button').css('background','lightgrey');
                            }else{
                                $('.booking_button').attr('disabled',false);
                                $('.booking_button').css('background','#{{BASE_COLOR}}');
                            }
                            // document.getElementById('guest_count').value=totalguestcount;
                            $('#guest').val(totalguestcount);
                            $("#guest_alert").html(" * Only "+totalguestcount+ " Guests Allowed");
                            $("#guest_alert").show();
                        }else{
                            $("#guest_alert").hide();
                            $('#guest').val(guest_count);
                        }

                        // tr_data +="<tr></tr>"
                        // tr_data +="<tr></tr>"

                        tr += "<tr><td style='text-align: center;' class='tooltips'>Price Per night<span class='tooltiptext'>Price for single night base fare</span></td><td style='text-align: center;'>$ "+data.data.single_day_fare+".00</td></tr>";
                        tr += "<tr><td style='text-align: center;'>City Fee</td><td style='text-align: center;'>$ "+data.data.city_fare+".00</td></tr>";
                        tr += "<tr><td style='text-align: center;'>Cleaning Fee</td><td style='text-align: center;'>$ "+data.data.city_fee_amount+".00</td></tr>";
                        // tr += "<tr><td style='text-align: center;'>Tax Amount</td><td style='text-align: center;'>$ "+data.data.tax_amount+".00</td></tr>";
                        tr += "<tr><td style='text-align: center;'>Initial Pay</td><td style='text-align: center;'>$ "+data.data.initial_pay+".00</td></tr>";
                        tr += "<tr><td style='text-align: center;' >Total Amount</td><td style='text-align: center;' >$ "+data.data.total_amount+".00</td></tr>";

                        $("#table_body").html(tr_data);

                    }
                },
                error: function (e) {
                    console.log('Error in Get_price', e);
                }
            });
        }

        $("#pricing_details").hide();
    </script>
    <script>

        //            var fixmeTop = $('#booking_form').offset().top;
        //            var fixmeTop1 = $('#location').offset().top;
        // $(window).scroll(function() {
        //     var currentScroll = $(window).scrollTop();

        //     if (currentScroll >= fixmeTop) {
        //         $('#booking_form').css({
        //             position: 'fixed',
        //             top: '0'
        //         });
        //     } else {
        //         $('#booking_form').css({
        //             position: 'static'
        //         });
        //     }
        // });
        // boxPosition = $(".booking-form-widget").offset().top;
        // boxPosition1 = $("#location").offset();
        // boxPosition11 = $(".workfrom").offset().top;
        // var a = $("#location").scrollTop;
        // $(window).scroll(function(){
        // boxPosition1 = $("#location").offset().top;
        // console.log(boxPosition1);
        //    var isFixed = $(".booking-form-widget").css("position") === "fixed";
        //    if($(window).scrollTop() > boxPosition && !isFixed){
        //             $(".booking-form-widget").css({position:"fixed", top: "180px"});
        //    }else if($(window).scrollTop() < boxPosition11){
        //         $(".booking-form-widget").css({position:"static"});
        //    }
        //    if($(window).scrollTop() > boxPosition1){
        //     $(".booking-form-widget").css({position:"absolute", top: "0px"});
        //     }
        // });

    </script>
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script> --}}
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script>
        $("#share").click(function(){
            var aux = document.createElement("input");
            aux.setAttribute("value",window.location.protocol + "//" + window.location.host + "/property/{{$data->property_id}}");
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);
            $('#copy').modal();
            // alert('Link Copied, you are now able to share.');
        });

        $("#chat_host").click(function(){
            $('#myModal').modal();
            var date=new Date();
            $("#chat_from_date").datepicker({
                startDate: date,
                autoclose: true,
                datesDisabled:[ @foreach($booked_dates as $d) "{{$d['dates']}}" ,@endforeach ]
            });

            $("#chat_from_date").change(function(){

                var fDate = $("#chat_from_date").val();
                // alert(fDate);


                // $("#property_to_date").foucs();
                $("#chat_to_date").datepicker('remove');
                $("#chat_to_date").datepicker({
                    startDate: fDate,
                    autoclose: true,
                    datesDisabled: [ @foreach($booked_dates as $d) "{{$d['dates']}}",@endforeach ]
                });

            });
        });

        $("#post_comment").click(function(){
            var star_rating = $("#count-existing").val();
            var review = $("#review").val();
            // var property_id = {{$data->property_id}};
            console.log("Star rating : "+star_rating);
            console.log("review : "+review);
            console.log("property_id : "+property_id);
            var url = window.location.protocol + "//" + window.location.host + "/keepers/add-review?property_id="+property_id+"&star_rating="+star_rating+"&review="+review;
            $.ajax({
                "type": "get",
                "url" : url,
                success: function(data) {
                    location.reload();
                }
            });
        });


    </script>

    <script>

        function onlyNumbers(e) {
            var keynum;
            var keychar;
            var numcheck;

            if(window.event) {
                keynum = e.keyCode;
            }
            else if(e.which) {
                keynum = e.which;
            }
            keychar = String.fromCharCode(keynum);
            numcheck = /\d/;
            return numcheck.test(keychar);
        }

        if ($(window).width() > 700){

            $(window).scroll(function(){

                boxPosition = $("#head_scroll").offset().top;

                boxPosition1 = $("#scroll_stop").offset().top;

                // console.log("simi "+boxPosition1);

                // console.log("post -> "+ $(window).width() );
                var isFixed = $(".tempClass").css("position") === "fixed";
                if($(window).scrollTop() > boxPosition && !isFixed){
                    $(".tempClass").css({position:"fixed", top: "5px" ,bottom:'55px', left:"840px"});
                    $("#check_in_div").addClass('col-md-6');
                    $("#check_out_div").addClass('col-md-6');
                }else if($(window).scrollTop() < boxPosition){
                    $(".tempClass").css({position:"static"});
                    $("#check_in_div").removeClass('col-md-6');
                    $("#check_out_div").removeClass('col-md-6');
                }

                if(boxPosition1 < $(window).scrollTop())
                {
                    $(".tempClass").css({position:"static"});
                    $("#check_in_div").removeClass('col-md-6');
                    $("#check_out_div").removeClass('col-md-6');
                }

                // //$('.tempClass').addClass('fixed-top');
            });
        }

    </script>
@endsection
