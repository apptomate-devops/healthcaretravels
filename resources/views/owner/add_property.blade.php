@extends('layout.master')
@section('title')
    Add new property | {{APP_BASE_NAME}}
@endsection
@section('main_content')

    <div class="container" style="margin-top: 35px;">
        <form action="" method="post" name="form-add-new">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="client_id" value="{{$client_id}}">

            <div class="row">

                <div class="col-md-12">

                    <div class="style-1">

                        <button class="btn" style="margin-top: 10px;background-color:#0983b8;color:white">Listing Location</button>
                        <button class="btn" style="margin-left: 5px;margin-top: 10px;" @if(isset($property_details)) @if($property_details->stage >= 2) href="{{url('/')}}/owner/add-new-property/2/{{$property_details->id}}" @else disabled="" @endif @endif>Property Details</button>
                        <button class="btn" style="margin-left: 5px;margin-top: 10px;" @if(isset($property_details)) @if($property_details->stage >= 3) href="{{url('/')}}/owner/add-new-property/3/{{$property_details->id}}" @else disabled="" @endif @endif>Listing</button>
                        <button class="btn" style="margin-left: 5px;margin-top: 10px;" @if(isset($property_details)) @if($property_details->stage >= 4) href="{{url('/')}}/owner/add-new-property/4/{{$property_details->id}}" @else disabled="" @endif @endif>Pricing</button>
                        <button class="btn" style="margin-left: 5px;margin-top: 10px;" @if(isset($property_details)) @if($property_details->stage >= 5) href="{{url('/')}}/owner/add-new-property/5/{{$property_details->id}}" @else disabled="" @endif @endif>Add Photo</button>
                        <!--  <button class="btn" style="margin-left: 5px;margin-top: 10px;" disabled="">Amenties</button>
                         <button class="btn" style="margin-left: 5px;margin-top: 10px;" disabled="">Calender</button> -->

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

                                        <div class="col-md-6">
                                            <h5>Country</h5>

                                            <select class="chosen-select-no-single validate" name="country">
                                                <option label="blank"></option>

                                                <option value="United States" selected>United States</option>

                                            </select>
                                        </div>


                                        <!-- Area -->
                                        <!-- <div class="col-md-6">
                                            <h5>Maximum Guests</h5>
                                            <select class="chosen-select-no-single validate" name="maximum_guest">
                                                <option label="blank"></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                            </select>
                                        </div> -->
                                        <div class="col-md-6">
                                            <h5>Address <span style="color: red">*</span></h5>
                                            <input class="search-field validate" type="text" name="streetname" @if(isset($property_details->address)) value="{{$property_details->address}}" @else value="" @endif required  id="txtPlaces"/>
                                        </div>
                                    </div>

                                    <!-- Row -->
                                    <div class="row with-forms">

                                        <div class="col-md-6">
                                            <h5>Building Number</h5>
                                            <input class="search-field " type="text" name="building_number" @if(isset($property_details->building_number)) value="{{$property_details->building_number}}" @else value="" @endif   />
                                        </div>

                                        <!-- <div class="col-md-6">
                                            <h5>Category</h5>
                                            <select class="chosen-select-no-single validate" name="category">
                                                <option label="blank"></option>
                                                <option value="Apartment">Apartment</option>
                                                <option value="Villa">villa</option>
                                            </select>
                                        </div> -->

                                        {{-- <div class="col-md-6">
                                            <h5>City <span style="color: red">*</span></h5> --}}
                                        <input class="search-field" name="city"  type="hidden" @if(isset($property_details->city)) value="{{$property_details->city}}" @else value="" @endif required id="city"/>
                                        <input class="search-field" name="state"  type="hidden" @if(isset($property_details->state)) value="{{$property_details->state}}" @else value="" @endif required id="state"/>
                                    {{--   <div id="set_location"></div>
                                  </div> --}}
                                    <!-- Area -->
                                        <!--  <div class="col-md-6">
                                             <h5>Room Type</h5>
                                             <select class="chosen-select-no-single validate" name="room_type">
                                                 <option label="blank"></option>
                                                 <option value="Private">Private</option>
                                                 <option value="Entire House">Entire House</option>
                                                 <option value="Shared Room">Shared Room</option>
                                             </select>
                                         </div> -->
                                        <div class="col-md-6">
                                            <h5>Zip/Postal code  <span style="color: red">*</span></h5>
                                            <input class="search-field validate" name="zip_code"  type="text" @if(isset($property_details->zip_code)) value="{{$property_details->zip_code}}" @else value="" @endif required maxlength="5" id="zip_code"/>
                                        </div>


                                    </div>

                                    <!-- Row -->
                                    {{--  <div class="row with-forms">

                                         <div class="col-md-6">
                                             <h5>State <span style="color: red">*</span></h5>
                                             <input class="search-field validate" name="state"  type="text" @if(isset($property_details->state)) value="{{$property_details->state}}" @else value="" @endif required id="state"/>
                                             <div id="set_location"></div>
                                         </div>

                                         <div class="col-md-6">
                                             <h5>Zip/Postal code  <span style="color: red">*</span></h5>
                                             <input class="search-field validate" name="zip_code"  type="text" @if(isset($property_details->zip_code)) value="{{$property_details->zip_code}}" @else value="" @endif required maxlength="6" id="zip_code"/>
                                         </div>

                                     </div> --}}

                                    <div class="row with-forms">

                                        <div class="col-md-2"></div>
                                        <div class="col-md-3">
                                            <div id="dvMap" style="width: 825px; height: 300px">
                                                <input type="text" id="my_lat" value="" name="lat" >
                                                <input type="text" id="my_lng" value="" name="lng" >

                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <h5>&nbsp;</h5>
                                    </div>
                                    <div class="col-md-3">



                                        <div class="divider"></div>

                                    </div>


                                    <!-- Row -->

                                    <!-- Row / End -->





                                    <div class="divider"></div>
                                    @if(Session::has('user_id'))
                                        @if(Session::get('role_id') == 1)
                                            <input type="hidden" name="user_id" value="{{Session::get('user_id')}}">
                                            <button id="button" class="button border margin-top-5">Next <i class="fa fa-arrow-circle-right"></i></button>
                                        @else
                                            <p> </p>
                                            <button id="button" class="button border margin-top-5">Next <i class="fa fa-arrow-circle-right"></i></button>
                                        @endif
                                    @else
                                        {{-- <p>Login to add property </p> --}}

                                    @endif

                                </div>
                                <!-- Section / End -->
                            </div>





                        </div>

                    </div>

                </div>

            </div>

        </form>
        @if(!Session::has('user_id'))
            <center>
                <button id="button" onclick="location.href='{{BASE_URL}}/login';" class="button border margin-top-5">Login to add property <i class="fa fa-arrow-circle-right"></i></button>
            </center><br><br>
        @endif
    </div>
    </div>

    <script type="text/javascript">



        function show_table(id) {
            var name=document.getElementById('name').value;
            var value=document.getElementById('value').value;
            var single_fee=document.getElementById('single_fee').value;

            document.getElementById('rname').value =(name);
            document.getElementById('rvalue').value =(value);
            document.getElementById('rsingle_fee').value =(single_fee);
            var ix;

            for (ix = 1;  ix <= 6;  ++ix) {
                document.getElementById('table' + ix).style.display='none';
            }
            if (typeof id === "number") {
                document.getElementById('table'+id).style.display='block';
            } else if (id && id.length) {
                for (ix = 0;  ix < id.length;  ++ix) {
                    document.getElementById('table'+ix).style.display='block';
                }
            }

        }

    </script>
    <script type="text/javascript">
        $('.date_picker').datepicker({});
        var date = new Date();
        //date.setDate(date.getDate()-1);
        $('#from_date').datepicker({
            startDate: date
        });

        function set_to_date() {
            // body...
            var from_date = $('#from_date').val();
            $('#to_date').datepicker({
                startDate: from_date
            });
        }

    </script>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByI8gik-nps54DdqY81oqS1GCFJK8mko4&libraries=places"></script>
    <script type="text/javascript">

        google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('txtPlaces'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var myarray = [];
                var place = places.getPlace();
                var address = place.formatted_address;
                var locality = place.address_components;
                console.log(place);
                locality.forEach(function(element) {
                    myarray.push(element.long_name);

                });
                var len = place.address_components.length;
                var pincode = place.address_components[len-1]['long_name'];
                if(!isNaN(pincode)){
                    $('#zip_code').val(pincode);
                }else{
                    $('#zip_code').val(" ");
                }
                var state = place.address_components[len-2]['long_name'];
                var city = place.address_components[len-3]['long_name'];
                $('#state').val(state);
                $('#city').val(city);
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                var mesg = "Address: " + address;
                mesg += "\nLatitude: " + latitude;
                mesg += "\nLongitude: " + longitude;
                mesg += "\nlocality: " + locality;
                markers = [
                    {
                        "title": 'County Rd',
                        "lat": latitude,
                        "lng": longitude,
                        "description": address
                    }
                ];

// Mapped location -> Default location in USA.
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?mlat='+markers[0].lat+'&mlng='+markers[0].lng+'&mlocation='+markers[0].description+'';
                window.history.pushState({ path: newurl }, '', newurl); // its show url in When the window is loaded. Tag: Karthik.

                var mapOptions = {
                    center: new google.maps.LatLng(markers[0].lat,markers[0].lng ),
                    zoom:10
                };
                console.log(mapOptions);
                var infoWindow = new google.maps.InfoWindow();
                var latlngbounds = new google.maps.LatLngBounds();
                var geocoder = geocoder = new google.maps.Geocoder();
                var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                map.setOptions({ minZoom: 1, maxZoom:15 });




                for (var i = 0; i < markers.length; i++) {
                    var data = markers[i]
                    var myLatlng = new google.maps.LatLng(markers[0].lat, markers[0].lng);
                    var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: data.title,
                        draggable: true,
                        animation: google.maps.Animation.DROP
                    });
                    (function (marker, data) {
                        google.maps.event.addListener(marker, "click", function (e) {
                            infoWindow.setContent(data.description);
                            infoWindow.open(map, marker);
                        });
                        google.maps.event.addListener(marker, "dragend", function (e) {
                            var lat, lng, address;
                            geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
                                if (status == google.maps.GeocoderStatus.OK) {
                                    lat = marker.getPosition().lat();
                                    lng = marker.getPosition().lng();



                                    address = results[0].formatted_address;
                                    infoWindow.setContent(address);
                                    infoWindow.open(map, marker);
                                    var len = address.length;
                                    var pincode = address[len-1]['long_name'];
                                    if(!isNaN(pincode)){
                                        $('#zip_code').val(pincode);
                                    }else{
                                        $('#zip_code').val(" ");
                                    }

                                    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?mlat='+lat+'&mlng='+lng+'&mlocation='+address;
                                    window.history.pushState({ path: newurl }, '', newurl);
                                    // document.getElementById("lat").value=lat;
                                    //  document.getElementById("lng").value=lng;
                                    // alert("Latitude: " + lat + "\nLongitude: " + lng + "\nAddress: " + zip_code);

                                    $('#txtPlaces').val(address);
                                    $('#my_lat').val(lat);
                                    $('#my_lng').val(lng);
                                }
                            });
                        });
                    })(marker, data);
                    latlngbounds.extend(marker.position);
                }
                var bounds = new google.maps.LatLngBounds();
                map.setCenter(latlngbounds.getCenter());
                map.fitBounds(latlngbounds);
                // alert(mesg);

            });
        });

    </script>

    <script type="text/javascript">
        $(function(){
            @if(isset($property_details->country))
            $("#country").val("{{$property_details->country}}");
            @endif
        });
        // var lat = document.getElementById("before_lat").value;
        // var lng = document.getElementById("before_lng").value;
        // console.log('Lat is '+lat);
        // console.log('Lng is '+lng);
            @if(isset($property_details->lat) && isset($property_details->lng))
        var markers = [
                {
                    "title": '{{$property_details->address}}',
                    "lat": {{$property_details->lat}},
                    "lng": {{$property_details->lng}},
                    "description": '{{$property_details->city}}'
                }
            ];
            @else
        var markers = [
                {
                    "title": 'County Rd',
                    "lat": 40.049749,
                    "lng": -101.5360453,
                    "description": '10052 County Rd 2, Yuma, CO 80759, USA'
                }
            ];
        @endif

        // $('#country').on('change',function(){

        //         var address = this.value;
        //         var url = 'get_lat_long/'+this.value;

        //         $.ajax({
        //             "type": "get",
        //             "url" : url,
        //             success: function(data) {
        //                 console.log(data.lat);


        //             }
        //         });

        //     });

        window.onload = function () {


            // Mapped location -> Default location in USA.
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?mlat='+markers[0].lat+'&mlng='+markers[0].lng+'&mlocation='+markers[0].description+'';
            window.history.pushState({ path: newurl }, '', newurl); // its show url in When the window is loaded. Tag: Karthik.

            var mapOptions = {
                center: new google.maps.LatLng(markers[0].lat,markers[0].lng ),
                zoom:10
            };
            console.log(mapOptions);
            var infoWindow = new google.maps.InfoWindow();
            var latlngbounds = new google.maps.LatLngBounds();
            var geocoder = geocoder = new google.maps.Geocoder();
            var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
            map.setOptions({ minZoom: 1, maxZoom:15 });




            for (var i = 0; i < markers.length; i++) {
                var data = markers[i]
                var myLatlng = new google.maps.LatLng(markers[0].lat, markers[0].lng);
                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: data.title,
                    draggable: true,
                    animation: google.maps.Animation.DROP
                });
                (function (marker, data) {
                    google.maps.event.addListener(marker, "click", function (e) {
                        infoWindow.setContent(data.description);
                        infoWindow.open(map, marker);
                    });
                    google.maps.event.addListener(marker, "dragend", function (e) {
                        var lat, lng, address;
                        geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                lat = marker.getPosition().lat();
                                lng = marker.getPosition().lng();


                                address = results[0].formatted_address;
                                infoWindow.setContent(address);
                                infoWindow.open(map, marker);

                                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?mlat='+lat+'&mlng='+lng+'&mlocation='+address;
                                window.history.pushState({ path: newurl }, '', newurl);
                                // document.getElementById("lat").value=lat;
                                //  document.getElementById("lng").value=lng;
                                // alert("Latitude: " + lat + "\nLongitude: " + lng + "\nAddress: " + address);
                                $('#txtPlaces').val(address);
                                $('#my_lat').val(lat);
                                $('#my_lng').val(lng);
                            }
                        });
                    });
                })(marker, data);
                latlngbounds.extend(marker.position);
            }
            var bounds = new google.maps.LatLngBounds();
            map.setCenter(latlngbounds.getCenter());
            map.fitBounds(latlngbounds);
        }
    </script>


    </body>
    </html>

@endsection
