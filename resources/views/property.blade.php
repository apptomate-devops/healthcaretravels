@extends('layout.master') @section('title',$data->title) @section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/property.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/pricing_details.css') }}">
    <div id="titlebar" class="property-titlebar margin-bottom-0">
        <div class="container">

            <div class="row" style="padding-top: 2%;background-color: #f2f2f2;margin-bottom: 20px;">
                <form name="test" action="{{BASE_URL}}properties" method="post" utocomplete="off">
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
                        </div>
                    </div>

                    <div class="col-md-2 text-center">
                        <button class="button" type="submit" style="width: 100%; margin: 5px 0 20px;" >Search</button>
                    </div>
                    <div id="search_location"></div>
                </form>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3 col-sm-12 col-xs-6 property-image show-990">
                        <p>
                            <img style="max-height: 85px;max-width: 85px;"
                                 src="{{isset($data->profile_image) ? $data->profile_image : '/user_profile_default.png'}}"
                                 alt="">
                        </p>
                        <div class="sub-price">
                            <a href="{{BASE_URL}}owner-profile/{{$data->user_id}}">{{Helper::get_user_display_name($data)}}</a><br>
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
                                $ {{$data->monthly_rate}}/Month
                            </font>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <center>
                        <div style="margin-left: 18%;" class="col-md-3 col-sm-6 col-xs-6 property-image hide-990">
                            <p>
                                <img class="user-icon" src="{{$data->profile_image}}">
                            </p>
                            <div class="sub-price">
                                <a href="{{BASE_URL}}owner-profile/{{$data->user_id}}">{{Helper::get_user_display_name($data)}}</a>
                            </div>
                            <div class="sub-price">
                                @if(Session::get('user_id'))
                                    @if($data->user_id != Session::get('user_id'))
                                    <a><h3 id="contact_host"><span class="property-badge"  id="chat_host">Message Host</span></h3></a>
                                    @endif
                                @else
                                    <button style="background: transparent;border: 0;float: right;" onclick="$('#request-chat').click()"><h3 id="contact_host"><span class="property-badge" style="background-color: #0983b8">Login to Chat</span></h3></button>
                                @endif
                            </div>

                        </div>
                    </center>
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

                    <h3 class="desc-headline">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">About Home</font>
                        </font>
                    </h3>
                    <div class="show-more visible" id="head_scroll">

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
                        <p id="show_more" class="show-more-button">
                            <span id="show_more" style="cursor: pointer;color: #e78016;">Show More</span>
                            <i class="fa fa-angle-down"></i>
                        </p>
                    </div>
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
                                <font style="vertical-align: inherit;">Cancellation Policy: {{$data->cancellation_policy}}<a href="{{BASE_URL}}cancellationpolicy">&nbsp;&nbsp;Read more</a></font>
                            </font>
                        </li>
                        <li>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Minimum Stay : {{$data->min_days}}</font>
                            </font>
                        </li>
                    </ul>


                    <h3 class="desc-headline no-border">Sleeping Arrangements</h3>

                    <!-- Carousel -->
                    <div class="col-md-12" id="">
                        <div class="carousel">



                        @foreach($bed_rooms as $key => $bedroom)
                            <!-- Listing Item -->
                                <div class="carousel-item">
                                    <div class="listing-item" style="text-align: center;">
                                        <div style="/*background-color: #f7f7f7;*/border:1px solid #DBDBDB !important;border-color: white;min-height: 250px;">
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
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Listing Item / End -->
                            @endforeach


                        </div>
                    </div>
                    <br>
{{--                    <h3>Property Price :</h3>--}}
{{--                    <div class="col-sm-12" id="scroll_stop">--}}
{{--                        <table cellpadding="1" cellspacing="1" border="1" style="width: 100%;margin-top: 10px;">--}}
{{--                            <tbody id="table_bodys">--}}

{{--                            <tr>--}}
{{--                                <td style="text-align: center;">Price per day</td>--}}
{{--                                <td style="text-align: center; width: 50%">$ {{Helper::get_daily_price($data->monthly_rate)}}</td>--}}
{{--                            </tr>--}}

{{--                            <tr>--}}
{{--                                <td style="text-align: center;">Security Deposit</td>--}}
{{--                                <td style="text-align: center; width: 50%">$ {{$data->security_deposit}}</td>--}}
{{--                            </tr>--}}

{{--                            <tr>--}}
{{--                                <td style="text-align: center;">Cleaning fee</td>--}}
{{--                                <td style="text-align: center; width: 50%">$ {{$data->cleaning_fee}}</td>--}}
{{--                            </tr>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
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
                                                        <img src="{{BASE_URL}}no-image-icon.png" class="yelp_img">
                                                    @endif
                                                </td>
                                                <?php $distance_in_miles = round(
                                                    $hospitals->businesses[$j]->distance * 0.00062137,
                                                ); ?>
                                                <td><a href="{{$hospitals->businesses[$j]->url}}"><strong>{{$hospitals->businesses[$j]->name}}&nbsp;&nbsp;</strong></a>(<strong>@if($distance_in_miles == 0) Less than a Mile @else {{$distance_in_miles}} Miles @endif</strong>)<br>
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
                                                        <img src="{{BASE_URL}}no-image-icon.png" class="yelp_img">
                                                    @endif
                                                </td>
                                                <?php $distance_in_miles = round(
                                                    $hospitals->businesses[$j]->distance * 0.00062137,
                                                ); ?>
                                                <td><a href="{{$hospitals->businesses[$j]->url}}"><strong>{{$hospitals->businesses[$j]->name}}&nbsp;&nbsp;</strong></a>(<strong>@if($distance_in_miles == 0) Less than a Mile @else {{$distance_in_miles}} Miles @endif</strong>)<br>
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
                                        <a href="{{BASE_URL}}list_health/{{$data->lat}}/{{$data->lng}}/{{$property_id}}" class="button  margin-top-5" target="_blank">
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
                                                        <img src="{{BASE_URL}}no-image-icon.png" class="yelp_img">
                                                    @endif
                                                </td>
                                                <?php $distance_in_miles = round(
                                                    $pets->businesses[$j]->distance * 0.00062137,
                                                ); ?>
                                                <td><a href="{{$pets->businesses[$j]->url}}"><strong>{{$pets->businesses[$j]->name}}&nbsp;&nbsp;</strong></a>(<strong>@if($distance_in_miles == 0) Less than a Mile @else {{$distance_in_miles}} Miles @endif</strong>)<br>
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
                                                        <img src="{{BASE_URL}}no-image-icon.png" class="yelp_img">
                                                    @endif
                                                </td>
                                                <?php $distance_in_miles = round(
                                                    $pets->businesses[$j]->distance * 0.00062137,
                                                ); ?>
                                                <td><a href="{{$pets->businesses[$j]->url}}"><strong>{{$pets->businesses[$j]->name}}&nbsp;&nbsp;</strong></a>(<strong>@if($distance_in_miles == 0) Less than a Mile @else {{$distance_in_miles}} Miles @endif</strong>)<br>
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
                                        <a href="{{BASE_URL}}list_pets/{{$data->lat}}/{{$data->lng}}/{{$property_id}}" class="button  margin-top-5" target="_blank">
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
                    <b><h5> Exact location will be provided 72 hours before Check-In</h5></b>

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
                                                <td><strong>{{$data->prop_full_rating[$j]-username}}</strong><br>
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
                                                <td><strong>{{$data->prop_full_rating[$j]->username}}</strong><br>
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
                                    <div class="agent-details">
                                        <h4>
                                            <a href="#">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">
                                                        $ {{$data->monthly_rate}}/Month
                                                    </font>
                                                </font>
                                            </a>
                                        </h4>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div id="check_in_div" class="p-0">
                                    <div class="form-group">
                                        <!-- Date input -->
                                        <label class="control-label" for="check_in_date">Check In</label>
                                        <input name="check_in" required value="@if(count($session)!=0) {{$session['fromDate']}} @endif" id="booking_date_range_picker" placeholder="Check In date" type="text" autocomplete="off">
                                    </div>
                                </div>
                                <div id="check_out_div" class="p-0">
                                    <div class="form-group">
                                        <!-- Date input -->
                                        <label class="control-label" for="check_out_date">Check Out</label>
                                        <input name="check_out" value="@if(count($session)!=0) {{$session['toDate']}} @endif"  required id="booking_date_range_picker" placeholder="Check Out date" type="text" autocomplete="off" >

                                        <input name="property_id" type="hidden" value="{{$property_id}}" >
                                        <input id="booking_id" name="booking_id" type="hidden">
                                    </div>
                                </div>
                                <input type="hidden" id="guest" name="guest_count">
                                <select required onchange="get_price();" class="chosen-select-no-single validate" id="current_guest_count" >
                                    <option selected disabled>Guests</option>
                                    @for($i=1;$i<=$data->total_guests;$i++)
                                        <option value="{{$i}}">{{$i}} Guest{{$i > 1 ? 's' : ''}}</option>
                                    @endfor

                                </select>

                                <div id="guest_details"></div>


                                <div id="pricing_details" style="margin-bottom: 10px;">

                                    <table id="billing-table">
                                        <thead>
                                        <tr class="row_border">
                                            <th style="text-align: left;padding: 5px">Detail</th>
                                            <th style="text-align: left;padding: 5px">Price</th>
                                        </tr>
                                        </thead>
                                        <tbody id="table_body">

                                        </tbody>
                                        <br>
                                        <tr><td colspan="5" id="guest_alert" style="text-align: center; color: red;font-weight:bold"></td></tr>

                                    </table>
                                    <p class="pay-caption"></p>

                                </div>
                                @if(Session::get('user_id') !=  $data->user_id)
                                    @if(!Session::get('user_id'))
                                        <button onclick="location.href='{{BASE_URL}}login';" class="button fullwidth margin-top-5">
                                            Login to Book
                                        </button>
                                    @else
                                        <button disabled id="btn_book_now" class="button fullwidth mt-10 booking_button">
                                            Book Now
                                        </button>
                                    @endif
                                @endif

                                <div class="alert" style="display: none;background-color: red;color: white;text-align: center;margin-top: 5%;">
                                    Property is not available
                                </div>
                            </div>
                            <!-- Agent Widget / End -->
                        </form>
                    </div>
                    <!-- Widget / End -->
                </div>
            </div>
            <!-- Sidebar / End -->
        </div>

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

                                <a href="{{BASE_URL}}property/{{$property->property_id}}" class="listing-img-container">

                                    @if($property->verified==1)
                                        <div class="listing-badges">
                                            <span class="featured" style="background-color: {{$property->verified==1?'green':''}}"> {{$property->verified==1?'Verified':''}}</span>

                                        </div>
                                    @endif

                                    <div class="listing-img-content">
                                        <span class="listing-price">$ {{$data->monthly_rate}}/Month</span>
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
                                            <a href="{{BASE_URL}}property/{{$property->property_id}}">{{$property->title}}</a>
                                        </h4>
                                        <a style="min-height: 70px;max-height: 70px;" href="{{BASE_URL}}property/{{$property->property_id}}" class="listing-address popup-gmaps">
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
                                        <a href="{{BASE_URL}}owner-profile/{{$property->owner_id}}">
                                            <i class="fa fa-user"></i> {{Helper::get_user_display_name($property)}}
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
                    <h4 class="modal-title" id="exampleModalLabel">Chat with Host</h4>
                </div>
                <form action="{{BASE_URL}}create_chat/{{$property_id}}" method="post">
                <div class="modal-body">
                    {{--  <a href="{{BASE_URL}}create_chat/{{$property_id}}" target="_blank"><h3 id="contact_host"><span class="property-badge" style="background-color: #0983b8" >Message Host</span></h3></a> --}}
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label" for="chat_from_date">Check In</label>
                                        <input name="check_in" id="chat_from_date" placeholder="Check In date"  type="text" style="width: 273px;" >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label" for="date">Check Out</label>
                                        <input name="check_out"  id="chat_to_date"  placeholder="Check Out date" type="text" style="width: 273px;" >
                                        <input name="property_id" type="hidden" value="{{$property_id}}" >
                                    </div>
                                </div>
                            </div>
                            <div class="text-center" style="font-size:1.2rem;">
                                Optional: Add check-in/check-out dates to give the property owner more information about your inquiry.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" style="float:left;" data-dismiss="modal">Close</button>
                            <button id="request-chat" class="button margin-top-5"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                        Request Chat
                                    </font></font>
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
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
            // Edit Property Booking
            var booking_details = <?php echo json_encode($booking_details); ?>;
            if(booking_details) {
                $('#booking_id').val(booking_details.booking_id);
                var start = moment(booking_details.start_date, "YYYY-MM-DD").format("MM/DD/YYYY")
                var end = moment(booking_details.end_date, "YYYY-MM-DD").format("MM/DD/YYYY")
                $('input[id="booking_date_range_picker"][name="check_in"]').val(start);
                $('input[id="booking_date_range_picker"][name="check_out"]').val(end);
                $('#current_guest_count').val(booking_details.guest_count);
                get_price();
            }
            var fav_id = '{{$data->is_favourite}}';
            if (fav_id == 1) {
                $("#yes_favourite").show();
                $("#not_favourite").hide();
            }
            if (fav_id == 0) {
                $("#yes_favourite").hide();
                $("#not_favourite").show();
            }

            function favourite(id) {
                var url = 'set-favourite/' + id;
                $.ajax({
                    "type": "get",
                    "url": url,
                    success: function (data) {
                        console.log("Set favourite success ====:" + data);
                        location.reload();
                    }
                });
            }

            // Book Now: Date Range Picker
            $('input[id="booking_date_range_picker"]').daterangepicker({
                minDate: new Date(),
                opens: 'center',
                minSpan: {
                    "days": ({{$data->min_days ?? 30}} + 1)
                },
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                },
                isInvalidDate: function(date){
                    var dc = moment();
                    dc.add(7, 'days');
                    // Blocking next 7 days for payment security on owner side
                    if (dc > date) {
                        return true;
                    }
                    var disableDates = <?php echo json_encode($booked_dates); ?>;
                    return disableDates.includes(date.format('YYYY-MM-DD'));
                }
            });
            $('input[id="booking_date_range_picker"]').keydown(function (e) {
                e.preventDefault();
                return false;
            })
            $('input[id="booking_date_range_picker"]').on('apply.daterangepicker', function (ev, picker) {
                $('input[id="booking_date_range_picker"][name="check_in"]').val(picker.startDate.format('MM/DD/YYYY'));
                $('input[id="booking_date_range_picker"][name="check_out"]').val(picker.endDate.format('MM/DD/YYYY'));
                get_price();
            });

            $('input[id="booking_date_range_picker"]').on('cancel.daterangepicker', function (ev, picker) {
                $('input[id="booking_date_range_picker"][name="check_in"]').val();
                $('input[id="booking_date_range_picker"][name="check_out"]').val();
            });

            var aboutHeight = $('#head_scroll').height();
            if(aboutHeight > 240) {
                $(".show-more").removeClass("visible");
            } else {
                $('#show_less').hide();
            }
        });
        function get_price() {
            var id = "{{$property_id}}";
            var booking_id = $('#booking_id').val();
            var from_date =$('input[id="booking_date_range_picker"][name="check_in"]').val();
            var to_date = $('input[id="booking_date_range_picker"][name="check_out"]').val();
            var guestCount = parseInt($("#current_guest_count").val());
            var guest_count =isNaN(guestCount) ? 0 : guestCount;
            var totalguestcount=parseInt($('#total_guest_count').val());
            totalguestcount = isNaN(totalguestcount) ? 0 : totalguestcount;
            guest_count = isNaN(guest_count) ? 0 : guest_count;

            $('.guest').show();
            if(!id || !from_date || !to_date || !guest_count) {
                return;
            }
            var url = '/get-property-price?property_id='+id+"&check_in="+from_date+"&check_out="+to_date+"&guest_count="+guest_count+"&booking_id="+booking_id;
            $.ajax({
                "type": "get",
                "url" : url,
                success: function(data) {
                    // console.log("room ",data);
                    if (data.status == 'FAILED' && data.status_code == 0) {
                        $(".alert").html(data.message || "Sorry! This property is not available during all of your selected dates. Try changing your dates or finding another property.");
                        $(".alert").show();
                        $("#table_body").html("");
                        $("#pricing_details").hide();
                        $('.booking_button').attr('disabled',true);
                        $('.booking_button').css('background','lightgrey');

                    }
                    if (data.status == 'FAILED' && data.status_code == 1) {
                        $(".alert").html(data.message || "Please review the house rules for Minimum days stay.");
                        $(".alert").show();
                        $("#table_body").html("");
                        $("#pricing_details").hide();
                        $('.booking_button').attr('disabled',true);
                        $('.booking_button').css('background','lightgrey');

                    }

                    if(data.status == 'SUCCESS'){
                        $(".alert").html("");
                        $(".alert").hide();
                        $("#pricing_details").show();

                        $('.booking_button').attr('disabled',false);
                        $('.booking_button').css('background','#0983b8');
                        $("#pricing_details").show();
                    }

                    console.log("Set favourite success ====:"+JSON.stringify(data));

                    if(data.data) {
                        var scheduled_payments = data.data.scheduled_payments;

                        var tr_data="";

                        tr_data +="<tr class='expandable' id='neat_amount'><td> "+data.data.count_label+" &nbsp;&nbsp;<span class='tooltips'><i class='fa fa-question-circle'></i><span class='tooltiptext'>The cost of your stay including applicable fees.</span></span></td><td class='val'> $ "+ data.data.neat_amount +"</td></tr>";

                        scheduled_payments.forEach((e, i) => {
                            tr_data +="<tr class='expandable payment_sections' id='section_"+i+"' onclick='toggle_sub_section("+i+");'><td> "+e.day+" &nbsp;</td><td class='val'> $ "+ e.price +"</td></tr>";
                            Object.keys(e.section).forEach((key, index) => {
                                tr_data +="<tr class='payment_sub_sections sub_sections_"+i+"'><td> "+key+" "+(index === 1 ? "<span class='tooltips'><i class='fa fa-question-circle'></i><span class='tooltiptext' style='font-weight: bold;'>This fee helps us run our platform and offer our services.</span></span>" : "")+" </td><td class='val'> $ "+ e.section[key] +"</td></tr>";
                            })
                        });

                        tr_data +="<tr class='row_border row_border_top'><td>Cleaning Fee&nbsp;<span class='tooltips'><i class='fa fa-question-circle'></i><span class='tooltiptext'>Decided by the property owner to clean after your stay.</span></span></td><td>$ "+data.data.cleaning_fee+"</td></tr>";
                        tr_data +="<tr class='row_border'><td>Deposit&nbsp;<span class='tooltips'><i class='fa fa-question-circle'></i><span class='tooltiptext'>If property owner reports no damage, your deposit will be returned 72 hours after your stay.</span></span></td><td>$ "+data.data.security_deposit+"</td></tr>";
                        tr_data +="<tr class='row_border'><td>Total Cost&nbsp;</td><td><b  id='total_booking_price'>$ "+data.data.total_price+"</b></td></tr>";

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
                        $("#table_body").html(tr_data);

                        $('.pay-caption').text(`Pay on approval: $${data.data.pay_now}, Total: $${data.data.total_price}`);

                        $('#neat_amount').click(function (e) {
                            e.stopPropagation();
                            e.preventDefault();
                            if($(this).hasClass('active')) {
                                $('.payment_sub_sections').removeClass('active');
                                $('.payment_sections').removeClass('expanded');
                            } else {
                            }
                            $('.payment_sections').toggleClass('active');
                            $(this).toggleClass('active');
                        });
                    }
                },
                error: function (e) {
                    console.log('Error in Get_price', e);
                }
            });
        }
        function toggle_sub_section(index) {
            $(`#section_${index}`).toggleClass('expanded');
            $(`.sub_sections_${index}`).toggleClass('active');
        };
        $("#pricing_details").hide();
    </script>
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
                {{--datesDisabled:[ @foreach($booked_dates as $d) "{{$d['dates']}}" ,@endforeach ]--}}
            });

            $("#chat_from_date").change(function(){

                var fDate = $("#chat_from_date").val();
                $("#chat_to_date").datepicker('remove');
                $("#chat_to_date").datepicker({
                    startDate: fDate,
                    autoclose: true,
                    {{--datesDisabled: [ @foreach($booked_dates as $d) "{{$d['dates']}}",@endforeach ]--}}
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

                var isFixed = $(".tempClass").css("position") === "fixed";
                if($(window).scrollTop() > boxPosition && !isFixed){
                    $(".tempClass").css({position:"fixed", top: "70px" ,bottom:'55px', left:"900px"});
                    $(".agent-widget").addClass('is-fixed');
                    $("#check_in_div").addClass('col-md-6');
                    $("#check_out_div").addClass('col-md-6');
                }else if($(window).scrollTop() < boxPosition){
                    $(".tempClass").css({position:"static"});
                    $(".agent-widget").removeClass('is-fixed');
                    $("#check_in_div").removeClass('col-md-6');
                    $("#check_out_div").removeClass('col-md-6');
                }

                if(boxPosition1 < $(window).scrollTop())
                {
                    $(".tempClass").css({position:"static"});
                    $(".agent-widget").removeClass('is-fixed');
                    $("#check_in_div").removeClass('col-md-6');
                    $("#check_out_div").removeClass('col-md-6');
                }
            });
        }

    </script>
@endsection
