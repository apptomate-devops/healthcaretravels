@extends('layout.master_copy')
@section('title')
    {{APP_BASE_NAME}} | Property Listing
@endsection

<link rel="stylesheet" href="{{ URL::asset('css/listing_search.css') }}">
<style>
    .mmenu-trigger {
        top: 18px;
    }
</style>
@section('main_content')

    <!-- Content
================================================== -->
    <div class="fs-container search_property">
        <section class="col-md-12">
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
                <div class="alert alert-danger no-properties" style="display: none;">There aren't any properties near this location yet. Try expanding your search.</div>
        </section>
        <div class="main-container">
            <div class="col-md-4">
                <div class="map-width">
                    <div id='map' class="mapclass">
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="container_wrapper search_container" style="display: none;">
                    <form id="filter_form" method="post" action="{{BASE_URL}}properties" onsubmit="return validate_submit()" autocomplete="off" onkeydown="return event.key != 'Enter';">
                        {{csrf_field()}}
                        <div class="row with-forms position-relative">
                            <div class="col-md-12 title">Search Properties</div>
                            <div id="hide_search_block" @if(count($properties)) style="display: block;" @endif></div>
                        </div>
                        <div class="row with-forms row-1">
                            <div class="col-sm-8">
                                <div class="main-search-input">
                                    <input type="text" required id="search-address-input"
                                           placeholder="Hospital, City, or Address"
                                           value="@if(isset($request_data['formatted_address']))  {{$request_data['formatted_address']}} @endif" autocomplete="off" @if(isset($request_data['formatted_address'])) data-is-valid="true" @endif/>
                                    <p id="search-address-input_error" style="display: none;">Please select a valid address from the suggestions.</p>
                                    {{--                                    <input class="field" type="hidden" id="street_number" name="street_number" value="{{$request_data['street_number'] ?? ''}}" />--}}
                                    {{--                                    <input class="field" type="hidden" id="route" name="route" value="{{$request_data['route'] ?? ''}}" />--}}
                                    {{--                                    <input class="field" type="hidden" id="locality" name="city" value="{{$request_data['city'] ?? ''}}" />--}}
                                    {{--                                    <input class="field" type="hidden" id="administrative_area_level_1" name="state" value="{{$request_data['state'] ?? ''}}" />--}}
                                    {{--                                    <input class="field" type="hidden" id="postal_code" name="pin_code" value="{{$request_data['pin_code'] ?? ''}}" />--}}
                                    {{--                                    <input class="field" type="hidden" id="country" name="country" value="{{$request_data['country'] ?? ''}}" />--}}
                                    <input class="field" type="hidden" id="formatted_address" name="formatted_address" value="{{$request_data['formatted_address'] ?? ''}}" />
                                    <input class="field" type="hidden" id="lat" name="lat" value="{{$request_data['lat'] ?? ''}}" />
                                    <input class="field" type="hidden" id="lng" name="lng" value="{{$request_data['lng'] ?? ''}}" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <select class="chosen-select-no-single" name="room_type" id="room_type" data-placeholder="Home Type">
                                    <option label="Home Type" value="" disabled selected>Home Type</option>
                                    @foreach($room_types as $room)
                                        <option value="{{$room->name}}" @if(isset($request_data['room_type']) && $request_data['room_type'] == $room->name) selected @endif>
                                            {{$room->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row with-forms row-2">
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <select class="chosen-select-no-single" name="guests" id="guests" data-placeholder="Guests">
                                    <option label="Guests" value="" disabled selected>Guests</option>
                                    @for($i=1;$i<=10;$i++)
                                        <option value="{{$i}}"@if(isset($request_data['guests']) && $request_data['guests'] == $i) selected @endif>
                                            {{$i}} Guest
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5">
                                <div class="check-in-out-wrapper">
                                    <input type="text" name="from_date"
                                           placeholder="Check in"
                                           value="@if(isset($request_data['from_date'])){{$request_data['from_date']}}@endif"
                                           id="date_range_picker" autocomplete="off"/>
                                    <input type="text" name="to_date"
                                           placeholder="Check out"
                                           value="@if(isset($request_data['to_date'])){{$request_data['to_date']}}@endif"
                                           id="date_range_picker" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-4 col-sm-4">
                                <div class="check-in-out-wrapper">
                                    <input type="text" class="price_float" placeholder="$ Min" name="minprice" id="minprice"
                                           value="@if(isset($request_data['minprice'])){{$request_data['minprice']}}@endif">
                                    <input type="text" class="price_float" placeholder="$ Max" name="maxprice" id="maxprice"
                                           value="@if(isset($request_data['maxprice'])){{$request_data['maxprice']}}@endif">
                                </div>
                            </div>
                        </div>

                        <div class="row with-forms">
                            <div class="checkboxes in-row">
                                <input id="instance_booking" name="instance_booking" type="checkbox" @if(isset($request_data['instance_booking'])) checked @endif>
                                <label for="instance_booking">Instant Booking</label>

                                <input id="flexible_cancellation" name="flexible_cancellation" type="checkbox" @if(isset($request_data['flexible_cancellation'])) checked @endif>
                                <label for="flexible_cancellation">Flexible Cancellation</label>

{{--                                <input id="enhanced_cleaning_protocol" name="enhanced_cleaning_protocol" type="checkbox" @if(isset($request_data['enhanced_cleaning_protocol'])) checked @endif>--}}
{{--                                <label for="enhanced_cleaning_protocol">Enhanced Cleaning Protocol</label>--}}

                            </div>
                            <div class="checkboxes in-row">
                                <input id="pets_allowed" name="pets_allowed" type="checkbox" @if(isset($request_data['pets_allowed'])) checked @endif>
                                <label for="pets_allowed">Pets Allowed</label>

                                <div id="currently_occupied" style="display: none;">
                                    <p class="caption-text">Currently Occupied By:</p>
                                    <input id="no_child" name="no_child" type="checkbox" @if(isset($request_data['no_child'])) checked @endif>
                                    <label for="no_child">No Kids</label>

                                    <input id="no_pets" name="no_pets" type="checkbox" @if(isset($request_data['no_pets'])) checked @endif>
                                    <label for="no_pets">No Pets</label>
                                </div>

                            </div>
                        </div>

                        <div class="row with-forms text-center">
                            <button class="button" id="button" type="submit">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>
                        <div id="dynamic_elements"></div>
                    </form>
                </div>
                <div class="properties_container" style="display: none;">
                    <div class="container_wrapper">
                        <div class="title">{{count($properties)}} Properties Available</div>
                        <p id="search_criteria"></p>
                        <div class="row with-forms">
                            <div class="col-md-12">
                                <button class="button" id="update_search">
                                    Update Search
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row with-forms">
                    @foreach($properties as $property)
                        <!-- Listing Property -->
                            <div class="col-sm-6">
                                <div class="show_skimmer listing-item compact">
                                    <box class="shine"></box>
                                    <box class="shine"></box>
                                </div>
                                <div class="listing-item compact">

                                    <a href="{{url('/')}}/property/{{$property->id}}"
                                       class="listing-img-container">
                                        @if($property->verified==1)
                                            <div class="listing-badges">
                                                                <span class="featured"
                                                                      style="background-color: {{$property->verified==1?'#ff5468':''}}"> {{$property->verified==1?'Verified':''}}</span>

                                            </div>
                                        @endif
                                        <div class="listing-img-content">
                                            <span class="listing-compact-title">{{$property->title}}<i>${{$property->monthly_rate}}/Month</i></span>

                                        </div>
                                        <img style="height: 100%; width: 100%;" src="{{$property->image_url}}" alt="">
                                    </a>
                                </div>
                            </div>
                            <!-- Listing Property / End -->
                        @endforeach
                    </div>
                    <div class="row with-forms button-container">
                        <div class="col-xs-6">
                            <button id="previous" onclick="nextpage({{$next-1}})" value="PREVIOUS" class="button" disabled>
                                PREVIOUS
                            </button>
                        </div>
                        <div class="col-xs-6 text-right">
                            <input type="hidden" id="page" name="next" value="{{$next+1}}">
                            <button id="next" onclick="nextpage({{$next+1}})" value="NEXT" class="button" disabled>
                                NEXT
                            </button>
                        </div>
                    </div>
                </div>


                {{--                    </div>--}}
                {{--                    <!-- Listings Container / End -->--}}


                {{--                    <!-- Pagination Container -->--}}
                {{--                    <div class="row fs-listings" style="margin-bottom: 25%;">--}}
                {{--                        <div class="col-md-12" style="margin-bottom: 25%;">--}}

                {{--                            <!-- Pagination -->--}}
                {{--                            <div class="clearfix"></div>--}}
                {{--                            <div class="pagination-container margin-top-10 margin-bottom-45">--}}


                {{--                                <nav class="pagination-next-prev">--}}
                {{--                                    <ul>--}}
                {{--                                        <li>--}}
                {{--                                            <button onclick="nextpage({{$next-1}})" value="PREVIOUS" class="button">--}}
                {{--                                                PREVIOUS--}}
                {{--                                            </button>--}}
                {{--                                        </li>--}}
                {{--                                        <li>--}}
                {{--                                            <input type="hidden" id="page" name="next" value="{{$next+1}}">--}}
                {{--                                            <button id="next" onclick="nextpage({{$next+1}})" value="NEXT" class="button"--}}
                {{--                                                    style="float: right;margin-top: -45px;min-width: 20%;">NEXT--}}
                {{--                                            </button>--}}
                {{--                                        </li>--}}
                {{--                                    </ul>--}}
                {{--                                </nav>--}}
                {{--                            </div>--}}

                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <!-- Pagination Container / End -->--}}

                {{--                </div>--}}
                {{--            </div>--}}
            </div>
        </div>
    </div>


    <script type="text/javascript">
        function initSearchPropertySearchInput() {
            var componentForm = {
                street_number: 'short_name',
                route: 'long_name',
                locality: 'long_name',
                administrative_area_level_1: 'long_name',
                country: 'short_name',
                postal_code: 'short_name'
            };
            var addressOptions = {
                componentRestrictions: {country: 'us'}
            };
            if ("{{$request_data['lat'] ?? ''}}" && "{{$request_data['lng'] ?? ''}}") {
                var selectedLocation = {
                    lat: parseFloat("{{$request_data['lat'] ?? ''}}"),
                    lng: parseFloat("{{$request_data['lng'] ?? ''}}")
                }
                repaintCircle(selectedLocation);
            }
            try {
                var element_address = document.getElementById('search-address-input');
                var element_address_error = document.getElementById('search-address-input_error');
                if(element_address) {
                    google.maps.event.addDomListener(element_address, 'keypress', (event) => {
                        if (event.keyCode === 13) {
                            event.preventDefault();
                        } else if (element_address.dataset.isValid) {
                            delete element_address.dataset.isValid;
                        }
                    });
                    var autocomplete_address = new google.maps.places.Autocomplete(element_address, addressOptions);
                    autocomplete_address.addListener('place_changed', (e) => {
                        var place = autocomplete_address.getPlace();
                        var lat = place.geometry.location.lat();
                        var lng = place.geometry.location.lng()

                        var selectedLocation = {lat, lng};

                        $('#formatted_address').val(place.formatted_address);
                        $('#lat').val(lat);
                        $('#lng').val(lng);
                        element_address.style.borderColor = '#e0e0e0';
                        element_address_error.style.display = "none";
                        element_address.dataset.isValid = true;
                        repaintCircle(selectedLocation);
                    });
                }
            } catch (e) {
                console.error(e);
            }
        }
        function repaintCircle(location) {
            if (location) {
                window.circleLocation = location;
            }
            var currentDistance = 25;
            if ($('#search-distance').val()) {
                try {
                    currentDistance = parseInt($('#search-distance').val());
                } catch (error) {

                }
            }
            var radius = currentDistance * 1609.34 // Converted Miles to Metres
            if (window.distanceCircle) {
                window.distanceCircle.setMap(null);
            }
            window.distanceCircle = new google.maps.Circle({
                strokeColor: "#e78016",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#e78016",
                fillOpacity: 0.35,
                map: map,
                center: location,
                radius: radius
            });
            map.setCenter(location);
            map.setZoom(getZoomLevel(radius));
        }
        function getZoomLevel(radius) {
            var zoomLevel = 11;
            var scale = radius / 450;
            zoomLevel = (16 - Math.log(scale) / Math.log(2));
            return zoomLevel - 0.5;
        }

        function validate_submit() {
            let search_address_input = document.getElementById('search-address-input');
            if(search_address_input.value && search_address_input.dataset.isValid) {
                return true;
            }
            $(`#search-address-input`).css('border-color', '#ff0000');
            $(`#search-address-input_error`).show();
            $(window).scrollTop($(`#search-address-input`).offset().top-200);
            return false;
        }

        $(function () {
            var properties = <?php echo json_encode($properties); ?>;
            var requestData = <?php echo json_encode($request_data); ?>;
            var pageNo = <?php echo json_encode($next); ?>;
            var totalCount = <?php echo json_encode($total_count); ?>;
            var offset = <?php echo json_encode($offset); ?>;

            if(properties.length) {
                $('.no-properties').hide();
                $('.search_container').hide();
                $('.properties_container').show();

                var criterias = [
                    $('#formatted_address').val(),
                    $('#room_type').val(),
                    $('#guests').val(),
                    get_date_range(),
                    get_price_range(),
                ].filter(Boolean).join(', ');

                $('input[type=checkbox]:checked+label').each(function () {
                    criterias = criterias + ', ' + $(this).text();
                });
                $('#search_criteria').text(criterias);
            } else {
                if(Object.keys(requestData).length) {
                    $('.no-properties').show();
                }
                $('.search_container').show();
                $('.properties_container').hide();
            }
            $('#update_search').click(function (e) {
                e.preventDefault();
                $('.search_container').show();
                $('.properties_container').hide();
            });
            $('#hide_search_block').click(function (e) {
                e.preventDefault();
                $('.search_container').hide();
                $('.properties_container').show();
            });

            if(pageNo > 1) {
                $('#previous').prop("disabled", false);
            }
            if(totalCount > (offset + properties.length)) {
                $('#next').prop("disabled", false);
            }

            function get_price_range() {
                var price_range = [
                    $('#minprice').val() ? `$${$('#minprice').val()}` : '',
                    $('#maxprice').val() ? `$${$('#maxprice').val()}` : ''
                ].filter(Boolean).join('-');
                return price_range ? price_range + '/day' : '';
            }
            function get_date_range() {
                var date_range = [$('#from_date').val(), $('#to_date').val()].filter(Boolean).join('-');
                return date_range || '';
            }

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
            function getDate(element) {
                var date;
                try {
                    date = new Date(element.value);
                } catch (error) {
                    date = null;
                }
                return date;
            }

            $('.price_float').change(function(){
                var value = parseFloat(parseFloat(this.value)).toFixed(2);
                this.value = isNaN(value) ? 0 : value;
            });


            $('.price_float').keypress(function(event) {
                if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });

            if(requestData.room_type) {
                show_current_occupacy(requestData.room_type);
            };

            $('#room_type').change(function () {
                show_current_occupacy($(this).val());
            });

            function show_current_occupacy(value) {
                if(value == 'Private Room' || value == 'Shared Room') {
                    $('#currently_occupied').show();
                } else {
                    $('#currently_occupied').hide();
                }
            }
        });

        $("#next").click(function (event) {
            let page = $("#page").val();
            let dynamicHtml = '<input type="hidden" name="page" value="' + page + '">';
            $("#dynamic_elements").html(dynamicHtml);
            $("#filter_form").submit();
        });

        $('#search-distance').change(function (event) {
            if (window.circleLocation) {
                repaintCircle(window.circleLocation);
            }
        });

        function check_to_date() {
            var to_date = $('#to_date').val();
            var from_date = $('#from_date').val();
            if (to_date && from_date) {
                var td = new Date(to_date);
                var fd = new Date(from_date);
                td.setHours(0,0,0,0);
                fd.setHours(0,0,0,0);
                if (td => fd) {
                    var diffTime = td.getTime() - fd.getTime();
                    var diffDays = diffTime / (1000 * 3600 * 24);
                    if (diffDays >= 30) {
                        return false;
                    }
                }
                var mintoDate = new Date(from_date);
                mintoDate.setMonth(mintoDate.getMonth() + 1);
                var minDateString = (mintoDate.getMonth() + 1) + "/" + mintoDate.getDate() + "/" + mintoDate.getFullYear();
                alert("Please choose date after " + minDateString);
                $('#to_date').val("");
                return false;
            }
        }

        function nextpage(page) {
            let dynamicHtml = '<input type="hidden" name="page" value="' + page + '">';
            $("#dynamic_elements").html(dynamicHtml);
            $("#filter_form").submit();
        }
    </script>
    @include('includes.scripts')

    <!-- Maps -->
@endsection
