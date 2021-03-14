@section('title')
    Rental Analysis | {{APP_BASE_NAME}}
@endsection
@extends('layout.master_copy')

<link rel="stylesheet" href="{{ URL::asset('css/listing_search.css') }}">

@section('main_content')

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
                <div class="container_wrapper search_container">
                    <form id="filter_form" method="post" action="{{BASE_URL}}rental_analysis" onsubmit="return validate_submit()" autocomplete="off" onkeydown="return event.key != 'Enter';">
                        {{csrf_field()}}
                        <div class="row with-forms position-relative">
                            <div class="col-md-12 title">Information About Your Rental</div>
                        </div>
                        <div class="row with-forms row-1">
                            <div class="col-sm-2">
                                <label>Address :</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="main-search-input">
                                    <input type="text" required id="search-address-input" @if(isset($request_data['formatted_address'])) data-is-valid="true" @endif
                                    placeholder="Hospital, City, or Address"/>
                                    <p id="search-address-input_error" style="display: none;">Please select a valid address from the suggestions.</p>
                                    <input class="field" type="hidden" id="formatted_address" name="address" value="{{Session::get('formatted_address')}}" />
                                    <input class="field" type="hidden" id="lat" name="lat" value="{{Session::get('lat')}}" />
                                    <input class="field" type="hidden" id="lng" name="lng" value="{{Session::get('lng')}}" />
                                </div>
                            </div>
                        </div> 

                        <div class="row with-forms row-1">
                            <div class="col-sm-2">
                                <label>Bedrooms :</label>
                            </div>
                            <div class="col-sm-10">
                            <select class="chosen-select-no-single" name="bedrooms" id="bedrooms" data-placeholder="Bedrooms">
                                    <option label="Bedrooms" value="" disabled selected>Bedrooms</option>
                                        <option value="1"> 1 </option>
                                        <option value="2"> 2 </option>
                                        <option value="3"> 3 </option>
                                        <option value="4"> 4 </option>
                                </select>
                            </div>
                        </div> 

                        <div class="row with-forms row-1">
                            <div class="col-sm-2">
                                <label>Baths :</label>
                            </div>
                            <div class="col-sm-10">
                            <select class="chosen-select-no-single" name="baths" id="baths" data-placeholder="Baths">
                                    <option label="Baths" value="" disabled selected>Baths</option>
                                        <option value="Any"> Any </option>
                                        <option value="1 Only"> 1 Only </option>
                                        <option value="1½ or more"> 1½ or more </option>
                                </select>
                            </div>
                        </div> 


                        <div class="row with-forms position-relative">
                            <div class="col-md-12 title">Contact Information</div>
                        </div>

                        <div class="row with-forms row-1">
                            <div class="col-sm-2">
                                <label>Email Address :</label>
                            </div>
                            <div class="col-sm-10">
                                    <input type="text" name="email"
                                           placeholder="Email Address"
                                           value=""
                                           id="email"/>
                           </div>
                        </div>

                        <div class="row with-forms row-1">
                            <div class="col-sm-2">
                                <label>Name :</label>
                            </div>
                            <div class="col-sm-10">
                                    <input type="text" name="name"
                                           placeholder="Name"
                                           value=""
                                           id="name"/>
                           </div>
                        </div>

                        <div class="row with-forms row-1">
                            <div class="col-sm-2">
                                <label>Phone Number :</label>
                            </div>
                            <div class="col-sm-10">
                                    <input type="text" name="phone_number"
                                           placeholder="Phone Number"
                                           value=""
                                           id="phone_number"/>
                           </div>
                        </div>

                        <div class="row with-forms row-1">
                            <div class="col-sm-2">
                                <label>I'm interested in :</label>
                            </div>
                            <div class="col-sm-10">
                                   <textarea name="i_am_interested_in" id="i_am_interested_in" placeholder="I'm interested in"></textarea>
                           </div>
                        </div>
                       
                        <div class="row with-forms text-center">
                            <button class="button" id="button" type="submit">
                                 Send My Rent Analysis
                            </button>
                        </div>
                      
                    </form>
        
        </div>
    </div>
<!-- Wrapper / End -->
@include('includes.scripts')

<script type="text/javascript">

        function get_current_location() {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(showPosition);
            } else {
                var HTML = "Geolocation is not supported by this browser.";
                alert(HTML);
            }

        }

        function showPosition(position) {
            var HTML = "Latitude: " + position.coords.latitude +
                "<br>Longitude: " + position.coords.longitude;
            alert(HTML);
        }
    </script>

    <script type="text/javascript">

        function initHomeSearchInput() {
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

    </script>
    <!-- Maps -->
@endsection
