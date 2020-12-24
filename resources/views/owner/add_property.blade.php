@extends('layout.master')
@section('title')
    Add new property | {{APP_BASE_NAME}}
@endsection
@section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/profile.css') }}">

    <div class="container" style="margin-top: 35px;">
        <form method="post" name="form-add-new" action="add-property" onsubmit="return validate_submit()" autocomplete="off" onkeydown="return event.key != 'Enter';">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="client_id" value="{{$client_id}}">

            <div class="row">

                <div class="col-md-12">

                    <div class="style-1">

                    {{--                        <button class="btn" style="margin-top: 10px;background-color:#0983b8;color:white">Listing Location</button>--}}
                    {{--                        <button class="btn" style="margin-left: 5px;margin-top: 10px;" @if(isset($property_details)) @if($property_details->stage >= 2) href="{{url('/')}}/owner/add-new-property/2/{{$property_details->id}}" @else disabled="" @endif @endif>Property Details</button>--}}
                    {{--                        <button class="btn" style="margin-left: 5px;margin-top: 10px;" @if(isset($property_details)) @if($property_details->stage >= 3) href="{{url('/')}}/owner/add-new-property/3/{{$property_details->id}}" @else disabled="" @endif @endif>Listing</button>--}}
                    {{--                        <button class="btn" style="margin-left: 5px;margin-top: 10px;" @if(isset($property_details)) @if($property_details->stage >= 4) href="{{url('/')}}/owner/add-new-property/4/{{$property_details->id}}" @else disabled="" @endif @endif>Pricing</button>--}}
                    {{--                        <button class="btn" style="margin-left: 5px;margin-top: 10px;" @if(isset($property_details)) @if($property_details->stage >= 5) href="{{url('/')}}/owner/add-new-property/5/{{$property_details->id}}" @else disabled="" @endif @endif>Add Photo</button>--}}
                    <!--  <button class="btn" style="margin-left: 5px;margin-top: 10px;" disabled="">Amenties</button>
                         <button class="btn" style="margin-left: 5px;margin-top: 10px;" disabled="">Calender</button> -->
                        <div class="dashboard-header">

                            <div class=" user_dashboard_panel_guide">

                                @include('owner.add-property.menu')

                            </div>
                        </div>
                        <!-- Tabs Content -->
                        <div class="tabs-container">

                            <div class="tab-content" id="tab1" style="display: inline-block;">
                                <!-- Section -->
                                <h3>Listing Location</h3><br>
                                @if(!Session::has('user_id'))
                                    <span style="border:2px solid red;color:red;padding: 15px;width: 100%"><b>Login to add property</b></span><br>
                                @endif

                                <div class="submit-section">

                                    <!-- Title -->
                                    <div class="row with-forms">
                                        <div class="col-md-12">
                                            <div class="warning-text">Be sure to add your complete and correct address, including your apartment or unit number if relevant. You will not be able to edit the address after listing your property.</div>
                                            <h5>Address <span class="required">*</span></h5>
                                            <input type="text" value="{{Session::get('address')}}" name="address" id="address" placeholder="Full Street Address" autocomplete="off" style="padding-left: 20px;" @if(Session::has('address')) data-is-valid="true" @endif />
                                            <div class="error-text" id="address_error" style="display: none;">Please select a valid address from the suggestions.</div>
                                        </div>
                                        <div class="col-md-12">
                                            <button id="btn_add_apt_number" onclick="on_add_address_line_2(event)" class="btn btn-primary">Add an Apt or Floor #</button>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="add_apt" id="add_apt_number_field" style="display: none;">
                                                <input type="text" class="input-text validate" value="{{Session::get('building_number') ?? $property_details->building_number ?? ''}}" name="building_number" id="building_number" placeholder="Apt, Unit, Suite, or Floor #" style="padding-left: 20px;" />
                                            </label>
                                            <div style="width: 100%; display: inline-block; text-align: right; margin-bottom: 20px;">
                                                <button id="remove_add_apt_number" onclick="on_remove_address_line_2(event)" class="button" style="display: none;">Don't Add</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <input class="field" type="hidden" id="street_number" placeholder="street_number" name="street_number" value="{{Session::get('street_number')}}" />
                                        <input class="field" type="hidden" id="route" placeholder="route" name="route" value="{{Session::get('route')}}" />
                                        <input class="field" type="hidden" id="locality" placeholder="locality" name="city" value="{{Session::get('city')}}" />
                                        <input class="field" type="hidden" id="administrative_area_level_1" placeholder="administrative_area_level_1" name="state" value="{{Session::get('state')}}" />
                                        <input class="field" type="hidden" id="postal_code" placeholder="postal_code" name="pin_code" value="{{Session::get('pin_code')}}" />
                                        <input class="field" type="hidden" id="country" placeholder="country" name="country" value="{{Session::get('country')}}" />
                                    </div>

                                    <div class="row with-forms">
                                        <div style="text-align: center; text-align: -webkit-center;">
                                            <div id="dvMap" style="width: 825px; height: 300px" />
                                        </div>
                                    </div>

                                    <input type="hidden" id="mlat" value="" name="mlat" >
                                    <input type="hidden" id="mlng" value="" name="mlng" >

                                    <div class="w-100 text-center mt-3">
                                        @if(Session::has('user_id') && Session::get('role_id') == 1)
                                            <input type="hidden" name="user_id" value="{{Session::get('user_id')}}">
                                            <button type="submit" class="button" style="margin-top: 25px;margin-bottom: 25px;">Next <i class="fa fa-arrow-circle-right"></i></button>
                                        @else
                                            {{-- <p>Login to add property </p> --}}
                                            @if(!Session::has('user_id'))
                                                <center>
                                                    <button id="button" onclick="location.href='{{BASE_URL}}/login';" class="button border margin-top-5">Login to add property <i class="fa fa-arrow-circle-right"></i></button>
                                                </center><br><br>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <!-- Section / End -->
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </form>
    </div>


    <script type="text/javascript">
        $(window).ready(function () {
            let building_number = "{{Session::get('building_number')}}";
            if (building_number) {
                on_add_address_line_2(undefined, building_number);
            }
        });

        function on_add_address_line_2(e, value = '') {
            if (e) {
                e.preventDefault();
            }
            $('#add_apt_number_field').show();
            $('#remove_add_apt_number').show();
            $('#btn_add_apt_number').hide();
            $('#building_number').val(value);
        }

        function on_remove_address_line_2(e) {
            if (e) {
                e.preventDefault();
            }
            $('#add_apt_number_field').hide();
            $('#remove_add_apt_number').hide();
            $('#btn_add_apt_number').show();
            $('#building_number').val('');
        }

        function load_address() {
            var markerData = {
                "lat": 40.049749,
                "lng": -101.5360453,
                "description": '10052 County Rd 2, Yuma, CO 80759, USA'
            }
                @if(isset($property_details) && isset($property_details->id))
            var propertyDetails = <?php echo json_encode($property_details); ?>;
            var fullAddress = [propertyDetails.address, propertyDetails.city, propertyDetails.state, propertyDetails.pin_code, propertyDetails.country].filter(Boolean).join(', ');

            var addressParts = propertyDetails.address.split(", ");
            var streetNumber = addressParts[0] || '';
            var route = addressParts[1] || '';

            $('#address').val(fullAddress);
            $('#street_number').val(streetNumber);
            $('#route').val(route);
            $('#locality').val(propertyDetails.city);
            $('#administrative_area_level_1').val(propertyDetails.state);
            $('#postal_code').val(propertyDetails.pin_code);
            $('#country').val(propertyDetails.country);

            document.getElementById('address').dataset.isValid = true;

            // var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?mlat='+propertyDetails.lat+'&mlng='+propertyDetails.lng+'&mlocation='+fullAddress+'';
            // window.history.pushState({ path: newurl }, '', newurl);

            markerData = {
                "lat": propertyDetails.lat,
                "lng": propertyDetails.lng,
                "description": fullAddress,
            }

            @endif

            show_marker(markerData.lat, markerData.lng, markerData.description);
        }

        function initializeAddress() {

            load_address();

            var componentForm = {
                street_number: 'short_name',
                route: 'long_name',
                locality: 'long_name',
                administrative_area_level_1: 'long_name',
                country: 'short_name',
                postal_code: 'short_name'
            };

            let options = {
                componentRestrictions: {
                    country: 'us'
                }
            };

            try {
                let element_address = document.getElementById('address');
                let element_address_error = document.getElementById(`address_error`);
                if (element_address) {
                    google.maps.event.addDomListener(element_address, 'keypress', (event) => {
                        if (event.keyCode === 13) {
                            event.preventDefault();
                        } else if (element_address.dataset.isValid) {
                            delete element_address.dataset.isValid;
                            for (var component in componentForm) {
                                document.getElementById(component).value = '';
                            }
                        }
                    });

                    // initialize address component
                    let autocomplete_address = new google.maps.places.Autocomplete(element_address, options);
                    autocomplete_address.addListener('place_changed', (e) => {
                        var place = autocomplete_address.getPlace();

                        for (var i = 0; i < place.address_components.length; i++) {
                            var addressType = place.address_components[i].types[0];
                            if (componentForm[addressType]) {
                                var val = place.address_components[i][componentForm[addressType]];
                                document.getElementById(addressType).value = val;
                            }
                        }

                        element_address.style.borderColor = '#e0e0e0';
                        element_address_error.style.display = "none";
                        element_address.dataset.isValid = true;

                        // Set Markers

                        var latitude = place.geometry.location.lat();
                        var longitude = place.geometry.location.lng();
                        var address = place.formatted_address;

                        // var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?mlat='+latitude+'&mlng='+longitude+'&mlocation='+address+'';
                        // window.history.pushState({ path: newurl }, '', newurl);

                        show_marker(latitude, longitude, address);
                    });
                }
            } catch (e) {}
        }

        function show_marker(latitude, longitude, address) {
            var myLatlng = new google.maps.LatLng(latitude, longitude);
            var mapOptions = {
                zoom: 15,
                center: myLatlng,
                draggable: false,
                gestureHandling: "none",
                keyboardShortcuts: false
            }
            var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
            var marker = new google.maps.Marker({
                position: myLatlng,
                title: address,
                icon: '/storage/public/marker-blue.png',
            });
            marker.setMap(map);

            $('#mlat').val(latitude);
            $('#mlng').val(longitude);
        }

        function validate_submit() {
            let element_address = document.getElementById('address');
            let invalidAddress = !element_address.value || (element_address.value && !element_address.dataset.isValid);
            if(invalidAddress) {
                $(`#address`).css('border-color', '#ff0000');
                $(`#address_error`).show();
                $(window).scrollTop($(`#address`).offset().top-100);
                return false;
            }
            return true;
        }
    </script>

    </body>
    </html>

@endsection


{{--    <script type="text/javascript">--}}
{{--        try {--}}
{{--            if(google) {--}}
{{--                google.maps.event.addDomListener(window, 'load', function () {--}}
{{--                    var places = new google.maps.places.Autocomplete(document.getElementById('txtPlaces'));--}}
{{--                    google.maps.event.addListener(places, 'place_changed', function () {--}}
{{--                        var myarray = [];--}}
{{--                        var place = places.getPlace();--}}
{{--                        var address = place.formatted_address;--}}
{{--                        var locality = place.address_components;--}}
{{--                        console.log(place);--}}
{{--                        locality.forEach(function(element) {--}}
{{--                            myarray.push(element.long_name);--}}

{{--                        });--}}
{{--                        var len = place.address_components.length;--}}
{{--                        var pincode = place.address_components[len-1]['long_name'];--}}
{{--                        if(!isNaN(pincode)){--}}
{{--                            $('#zip_code').val(pincode);--}}
{{--                        }else{--}}
{{--                            $('#zip_code').val(" ");--}}
{{--                        }--}}
{{--                        var state = place.address_components[len-2]['long_name'];--}}
{{--                        var city = place.address_components[len-3]['long_name'];--}}
{{--                        $('#state').val(state);--}}
{{--                        $('#city').val(city);--}}
{{--                        var latitude = place.geometry.location.lat();--}}
{{--                        var longitude = place.geometry.location.lng();--}}
{{--                        var mesg = "Address: " + address;--}}
{{--                        mesg += "\nLatitude: " + latitude;--}}
{{--                        mesg += "\nLongitude: " + longitude;--}}
{{--                        markers = [--}}
{{--                            {--}}
{{--                                "title": 'County Rd',--}}
{{--                                "lat": latitude,--}}
{{--                                "lng": longitude,--}}
{{--                                "description": address--}}
{{--                            }--}}
{{--                        ];--}}

{{--                        // Mapped location -> Default location in USA.--}}
{{--                        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?mlat='+markers[0].lat+'&mlng='+markers[0].lng+'&mlocation='+markers[0].description+'';--}}
{{--                        window.history.pushState({ path: newurl }, '', newurl); // its show url in When the window is loaded. Tag: Karthik.--}}

{{--                        var mapOptions = {--}}
{{--                            center: new google.maps.LatLng(markers[0].lat,markers[0].lng ),--}}
{{--                            zoom:10--}}
{{--                        };--}}
{{--                        console.log(mapOptions);--}}
{{--                        var infoWindow = new google.maps.InfoWindow();--}}
{{--                        var latlngbounds = new google.maps.LatLngBounds();--}}
{{--                        var geocoder = geocoder = new google.maps.Geocoder();--}}
{{--                        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);--}}
{{--                        map.setOptions({ minZoom: 1, maxZoom:15 });--}}




{{--                        for (var i = 0; i < markers.length; i++) {--}}
{{--                            var data = markers[i]--}}
{{--                            var myLatlng = new google.maps.LatLng(markers[0].lat, markers[0].lng);--}}
{{--                            var marker = new google.maps.Marker({--}}
{{--                                position: myLatlng,--}}
{{--                                map: map,--}}
{{--                                title: data.title,--}}
{{--                                draggable: true,--}}
{{--                                animation: google.maps.Animation.DROP--}}
{{--                            });--}}
{{--                            (function (marker, data) {--}}
{{--                                google.maps.event.addListener(marker, "click", function (e) {--}}
{{--                                    infoWindow.setContent(data.description);--}}
{{--                                    infoWindow.open(map, marker);--}}
{{--                                });--}}
{{--                                google.maps.event.addListener(marker, "dragend", function (e) {--}}
{{--                                    var lat, lng, address;--}}
{{--                                    geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {--}}
{{--                                        if (status == google.maps.GeocoderStatus.OK) {--}}
{{--                                            lat = marker.getPosition().lat();--}}
{{--                                            lng = marker.getPosition().lng();--}}



{{--                                            address = results[0].formatted_address;--}}
{{--                                            infoWindow.setContent(address);--}}
{{--                                            infoWindow.open(map, marker);--}}
{{--                                            var len = address.length;--}}
{{--                                            var pincode = address[len-1]['long_name'];--}}
{{--                                            if(!isNaN(pincode)){--}}
{{--                                                $('#zip_code').val(pincode);--}}
{{--                                            }else{--}}
{{--                                                $('#zip_code').val(" ");--}}
{{--                                            }--}}

{{--                                            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?mlat='+lat+'&mlng='+lng+'&mlocation='+address;--}}
{{--                                            window.history.pushState({ path: newurl }, '', newurl);--}}
{{--                                            // document.getElementById("lat").value=lat;--}}
{{--                                            //  document.getElementById("lng").value=lng;--}}
{{--                                            // alert("Latitude: " + lat + "\nLongitude: " + lng + "\nAddress: " + zip_code);--}}

{{--                                            $('#txtPlaces').val(address);--}}
{{--                                            $('#my_lat').val(lat);--}}
{{--                                            $('#my_lng').val(lng);--}}
{{--                                        }--}}
{{--                                    });--}}
{{--                                });--}}
{{--                            })(marker, data);--}}
{{--                            latlngbounds.extend(marker.position);--}}
{{--                        }--}}
{{--                        var bounds = new google.maps.LatLngBounds();--}}
{{--                        map.setCenter(latlngbounds.getCenter());--}}
{{--                        map.fitBounds(latlngbounds);--}}
{{--                        // alert(mesg);--}}

{{--                    });--}}
{{--                });--}}
{{--            }--}}
{{--        } catch (e) {}--}}
{{--    </script>--}}
