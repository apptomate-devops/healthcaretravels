@extends('layout.master_copy')
@section('title')
    {{APP_BASE_NAME}} | Property Listing
@endsection
@section('main_content')

    <style type="text/css">
        .map-width {
            width: 100% !important;
            position: relative;
        }

        @media (max-width: 1239px) {
            .compact .listing-img-container:before {
                background: linear-gradient(to bottom, transparent 50%, #2f2f2f00) !important;
                transition: opacity .5s !important;
            }

            .listing-img-content:before {
                background: linear-gradient(to bottom, transparent 50%, #2f2f2fa1) !important;
            }

            .compact .listing-img-content {
                padding: 0;
                background: linear-gradient(to bottom, transparent 0%, #2f2f2f) !important;
                padding-top: 5px;
            }

        }

        @media only screen and (max-width: 991px) {
            /* For mobile: */
            #map {
                margin-left: 10px !important;
                width: 95% !important;
            }

            h4.search-title {
                margin-top: 50px;
            }
        }

        @media only screen and (min-width: 768px) {
            /* For desktop: */
            .myclass {
                margin-top: 20px;
                position: fixed;
            }
        }

        @media only screen and (max-width: 768px) {
            /* For mobile: */
            .myform {
                margin-top: 490px;
            }

            .mapclass {
                max-width: 400px;
            }
        }

        .shine {
            background: #f6f7f8;
            background-image: linear-gradient(to right, #f6f7f8 0%, #edeef1 20%, #f6f7f8 40%, #f6f7f8 100%);
            background-repeat: no-repeat;
            background-size: 360px 250px;
            display: inline-block;
            position: relative;
            -webkit-animation-duration: 1s;
            -webkit-animation-fill-mode: forwards;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-name: placeholderShimmer;
            -webkit-animation-timing-function: linear;
        }

        box {
            height: 279px;
            width: 317px;
        }

        .skimmer {
            display: inline-flex;
            flex-direction: column;
            margin-left: 25px;
            margin-top: 15px;
            vertical-align: top;
        }

        lines {
            height: 10px;
            margin-top: 10px;
            width: 330px;
        }

        photo {
            display: block !important;
            width: 315px;
            height: 100px;
            margin-top: 15px;
        }

        @-webkit-keyframes placeholderShimmer {
            0% {
                background-position: -468px 0;
            }
            100% {
                background-position: 468px 0;
            }
        }

        .show_skimmer {

        }

    </style>
    <!-- Content
================================================== -->
    <div class="fs-container myclass">

        <div class="fs-inner-container" style="position: sticky;">

            <!-- Map -->

        <!--  <iframe style="border:0;margin-top: 20px;margin-left: 10px;margin-right: 10px;" src="{{BASE_URL}}multiple-marker/{{$location_url}}" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe> -->
            <div class="map-width">
                <div id='map' class="mapclass"
                     style="position: absolute;width: 100%;margin-left: 20px;height: 555px"></div>
                <div class="col-md-12"></div>
            </div>
        </div>


        <div class="fs-inner-container">
            <div class="fs-content">

                <!-- Search -->
                <section class="search margin-bottom-30">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            <h4>{{ Session::get('success') }}</h4>
                        </div>
                    @endif

                    @if(Session::has('error'))
                        <div class="alert alert-success">
                            <h4>{{ Session::get('error') }}</h4>
                        </div>
                    @endif
                    <div class="row myform">
                        <div class="col-md-12">

                            <!-- Title -->
                            @if(count($properties) == 0)
                                <div class="alert alert-danger">No Properties found for your filter</div>
                            @endif

                            <h4 class="search-title">Find Your Home </h4>

                            <!-- Form -->
                            <div class="main-search-box no-shadow">

                                <form id="filter_form" method="post" action="{{BASE_URL}}search-property">
                                    {{csrf_field()}}

                                    <div id="dynamic_elements"></div>
                                    @if(isset($request_data['lat']))
                                        <input type="hidden" name="lat" value="{{$request_data['lat']}}">
                                        <input type="hidden" name="lng" value="{{$request_data['lng']}}">
                                @endif
                                <!-- Row With Forms -->
                                    <div class="row with-forms">

                                        <!-- Main Search Input -->
                                        <div class="col-fs-6">
                                            <div class="main-search-input">
                                                <input type="text" required id="pac-input"
                                                       placeholder="Enter address e.g. street, city or state"
                                                       value="@if(isset($request_data['formatted_address']))  {{$request_data['formatted_address']}} @endif"
                                                       name="formatted_address" autocomplete="off"/>
                                            </div>
                                        </div>


                                        <!-- Status -->
                                        <div class="col-fs-3">
                                            <div class="main-search-input">
                                                <input type="text" name="from_date"
                                                       placeholder="Check in"
                                                       value="@if(isset($request_data['from_date'])) {{$request_data['from_date']}} @endif"
                                                       id="from_date" autocomplete="off"/>
                                            </div>
                                        </div>

                                        <!-- Property Type -->
                                        <div class="col-fs-3">
                                            <div class="main-search-input">
                                                <input type="text" placeholder="Check out" onchange="check_to_date();"
                                                       value="@if(isset($request_data['to_date']))  {{$request_data['to_date']}} @endif"
                                                       name="to_date" value="" id="to_date" autocomplete="off"/>

                                            </div>
                                        </div>

                                    </div>
                                    <!-- Row With Forms / End -->


                                    <!-- Row With Forms -->
                                    <div class="row with-forms">

                                        <!-- Min Price -->
                                        <div class="col-fs-3">

                                            <!-- Select Input -->
                                            <div class="select-input disabled-first-option">

                                                <select class="chosen-select-no-single" name="guests">
                                                    <option label="blank" value="">Guests</option>
                                                    <option value="1"
                                                            @if(isset($request_data['guests']) && $request_data['guests'] == "1")  selected @endif>
                                                        1 Guest
                                                    </option>
                                                    <option value="2"
                                                            @if(isset($request_data['guests']) && $request_data['guests'] == "2")  selected @endif>
                                                        2 Guests
                                                    </option>
                                                    <option value="3"
                                                            @if(isset($request_data['guests']) && $request_data['guests'] == "3")  selected @endif>
                                                        3 Guests
                                                    </option>
                                                    <option value="4"
                                                            @if(isset($request_data['guests']) && $request_data['guests'] == "4")  selected @endif>
                                                        4 Guests
                                                    </option>
                                                    <option value="5"
                                                            @if(isset($request_data['guests']) && $request_data['guests'] == "5")  selected @endif>
                                                        5 Guests
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- Select Input / End -->

                                        </div>

                                        <div class="col-fs-3">
                                            <div class="select-input disabled-first-option">
                                                <input
                                                    type="number"
                                                    placeholder="Distance"
                                                    name="distance"
                                                    data-unit="Mi"
                                                    value="@if(isset($request_data['distance']))  {{intval($request_data['distance'])}} @endif">

                                            </div>
                                        </div>
                                        <div class="col-fs-3">

                                            <!-- Select Input -->
                                            <div class="select-input disabled-first-option">
                                                <input type="number" placeholder="Min Price" name="minprice"
                                                       data-unit="USD"
                                                       value="@if(isset($request_data['minprice']))  {{$request_data['minprice']}} @endif">

                                            </div>
                                        </div>
                                        <div class="col-fs-3">
                                            <div class="select-input disabled-first-option">
                                                <input type="number" placeholder="Max Price" name="maxprice"
                                                       data-unit="USD"
                                                       value="@if(isset($request_data['maxprice']))  {{$request_data['maxprice']}} @endif">

                                            </div>
                                        </div>

                                        <div class="col-fs-3">
                                            <div class="select-input disabled-first-option">
                                                <select class="chosen-select-no-single" name="roomtype">
                                                    <option value="" label="blank">Home Type</option>
                                                    @foreach($room_types as $pro)
                                                        <option value="{{$pro->name}}"
                                                                @if(isset($request_data['roomtype']) && $request_data['roomtype'] == $pro->name)  selected @endif>{{$pro->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                                                                <div class="col-fs-3">
                                            <div class="select-input disabled-first-option">
                                                <select name="property_type" required data-placeholder="Any Status"
                                                    class="chosen-select-no-single">
                                                    <option value="" selected disabled>Property Type</option>
                                                    <option value="1">Short Term Rental</option>
                                                    <option value="2">Long Term Rental</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-fs-3">
                                            <div class="select-input disabled-first-option">
                                                <select class="chosen-select-no-single" name="bookingmode">
                                                    <option value="" label="blank">Booking Type</option>
                                                    <option value="1"
                                                            @if(isset($request_data['bookingmode']) && $request_data['bookingmode'] == "1")  selected @endif>
                                                        Instant Book
                                                    </option>
                                                    <option value="0"
                                                            @if(isset($request_data['bookingmode']) && $request_data['bookingmode'] == "0")  selected @endif>
                                                        Request Book
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-fs-3">
                                            <div class="select-input disabled-first-option">
                                            <div class="checkboxes in-row">
                                                <input id="occupied-check" type="checkbox" name="filters-check" value="CURRENTLY_OCCUPIED">
                                                <label for="occupied-check">Currently occupied</label>
                                            </div>
                                            <div class="mt-5 occupied-extra" style="display: none">
                                                <div class="px-0 col-md-6 checkboxes in-row">
                                                    <input id="no-kids-check" type="checkbox" name="filters-check" value="CURRENTLY_NO_KIDS">
                                                    <label for="no-kids-check">No kids</label>
                                                </div>
                                                <div class="px-0 col-md-6 checkboxes in-row">
                                                    <input id="no-dogs-check" type="checkbox" name="filters-check" value="CURRENTLY_NO_DOGS">
                                                    <label for="no-dogs-check">No dogs</label>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="extra-filters-wrapper">
                                        <div class="col-fs-3">
                                            <div class="checkboxes in-row">
                                                <input id="covid-check" type="checkbox" name="filters-check" value="COVID_SAFETY">
                                                <label for="covid-check">COVID Safety Measures Certified</label>
                                            </div>
                                        </div>
                                        <div class="col-fs-3">
                                            <div class="checkboxes in-row">
                                                <input id="cancellation-check" type="checkbox" name="filters-check" value="CANCELATION">
                                                <label for="cancellation-check">Cancellation flexibility</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row With Forms / End -->


                                    <!-- Search Button -->
                                    <button class="button fs-map-btn" type="submit">Search</button>

                                    <!-- More Search Options
                                    <a href="#" class="more-search-options-trigger margin-top-20" data-open-title="More Options" data-close-title="Less Options"></a>-->

                                    <div class="more-search-options relative">
                                        <div class="more-search-options-container margin-top-30">

                                            <!-- Row With Forms -->
                                            <div class="row with-forms">


                                                <!-- Rooms Area -->
                                                <div class="col-fs-3">
                                                    <select data-placeholder="Rooms" class="chosen-select-no-single">
                                                        <option label="blank"></option>
                                                        <option>Rooms (Any)</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>

                                                <!-- Min Area -->
                                                <div class="col-fs-3">
                                                    <select data-placeholder="Beds" class="chosen-select-no-single">
                                                        <option label="blank"></option>
                                                        <option>Beds (Any)</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>

                                                <!-- Max Area -->
                                                <div class="col-fs-3">
                                                    <select data-placeholder="Baths" class="chosen-select-no-single">
                                                        <option label="blank"></option>
                                                        <option>Baths (Any)</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <!-- Row With Forms / End -->


                                            <!-- Checkboxes -->
                                            <!-- <div class="checkboxes in-row">

                                                <input id="check-2" type="checkbox" name="check">
                                                <label for="check-2">Air Conditioning</label>

                                                <input id="check-3" type="checkbox" name="check">
                                                <label for="check-3">Swimming Pool</label>

                                                <input id="check-4" type="checkbox" name="check" >
                                                <label for="check-4">Central Heating</label>

                                                <input id="check-5" type="checkbox" name="check">
                                                <label for="check-5">Laundry Room</label>


                                                <input id="check-6" type="checkbox" name="check">
                                                <label for="check-6">Gym</label>

                                                <input id="check-7" type="checkbox" name="check">
                                                <label for="check-7">Alarm</label>

                                                <input id="check-8" type="checkbox" name="check">
                                                <label for="check-8">Window Covering</label>

                                            </div> -->
                                            <!-- Checkboxes / End -->

                                        </div>

                                    </div>
                                    <!-- More Search Options / End -->

                                </form>
                            </div>
                            <!-- Box / End -->
                        </div>
                    </div>

                </section>
                <!-- Search / End -->


                <!-- Listings Container -->
                <div class="row fs-listings">

                    <!-- Displaying -->
                    @if(isset($request_data))
                        <div class="col-md-12">
                            <p class="showing-results">{{$total_count}} Properties Match your search </p>
                        </div>
                    @endif
                    <?php
// dd($properties);
// dd($request_data);
?>
                    @foreach($properties as $property)
                        <?php
//echo json_encode($property); exit;
?>
                    <!-- Listing Item -->

                        <div class="show_skimmer listing-item compact">
                            <box class="shine"></box>
                            <box class="shine"></box>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="listing-item compact">

                                <a href="{{url('/')}}/property/{{$property->property_id}}"
                                   class="listing-img-container">
                                    @if($property->verified==1)
                                        <div class="listing-badges">
                                            <span class="featured"
                                                  style="background-color: {{$property->verified==1?'#ff5468':''}}"> {{$property->verified==1?'Verified':''}}</span>

                                        </div>
                                    @endif
                                    <div class="listing-img-content">
                                        <span class="listing-compact-title">{{$property->title}}<i>${{$property->price_more_than_one_month * 30}}/Month</i></span>

                                        <!-- <ul class="listing-hidden-content1">
                                            <li>Area <span>530 sq ft</span></li>
                                            <li>Rooms <span>3</span></li>
                                            <li>Beds <span>1</span></li>
                                            <li>Baths <span>1</span></li>
                                        </ul> -->
                                    </div>
                                    <img style="height: 250px;" src="{{$property->image_url}}" alt="">
                                </a>

                            </div>
                        </div>
                        <!-- Listing Item / End -->
                    @endforeach

                </div>
                <!-- Listings Container / End -->


                <!-- Pagination Container -->
                <div class="row fs-listings" style="margin-bottom: 25%;">
                    <div class="col-md-12" style="margin-bottom: 25%;">

                        <!-- Pagination -->
                        <div class="clearfix"></div>
                        <div class="pagination-container margin-top-10 margin-bottom-45">


                            <nav class="pagination-next-prev">
                                <ul>
                                    <li>
                                        <button onclick="nextpage({{$next-1}})" value="PREVIOUS" class="button">
                                            PREVIOUS
                                        </button>
                                    </li>
                                    <li>
                                        <input type="hidden" id="page" name="next" value="{{$next+1}}">
                                        <button id="next" onclick="nextpage({{$next+1}})" value="NEXT" class="button"
                                                style="float: right;margin-top: -45px;min-width: 20%;">NEXT
                                        </button>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
                <!-- Pagination Container / End -->

            </div>
        </div>

    </div>
    @include('includes.scripts')
    <script type="text/javascript">
        function check_to_date() {
            var to_date = $('#to_date').val();
            from_date = $('#from_date').val();
            if (to_date && from_date > to_date) {
                alert("Please choose date after " + from_date);
                $('#to_date').val("");
                return false;
            }
        }

        function set_favourite(property_id) {
            alert(property_id);

        }

        $(".user-menu").click(function () {
            var class_n = $(this).attr('class');
            if (class_n == "user-menu") {
                $(this).addClass('active');
            }
            if (class_n == "user-menu active") {
                $(this).removeClass('active');
            }

        });
        $(function () {
            $('#occupied-check').change(function (event) {
                var isChecked = event.currentTarget.checked;
                if (isChecked) {
                    $('.occupied-extra').fadeIn();
                } else {
                    $('.occupied-extra').fadeOut();
                }
            });
            $(".show_skimmer").fadeOut(2000, function () {
                $(".content").fadeIn(1500);

            });
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
debugger;
            function getDate(element) {
                var date;
                try {
                    date = new Date(element.value);
                } catch (error) {
                    date = null;
                }
                return date;
            }
        });

        $("#next").click(function (event) {
            let page = $("#page").val();
            let dynamicHtml = '<input type="hidden" name="page" value="' + page + '">';
            $("#dynamic_elements").html(dynamicHtml);
            $("#filter_form").submit();
        });

        function nextpage(page) {
            let dynamicHtml = '<input type="hidden" name="page" value="' + page + '">';
            $("#dynamic_elements").html(dynamicHtml);
            $("#filter_form").submit();
        }

    </script>
    <!-- Maps -->
@endsection
