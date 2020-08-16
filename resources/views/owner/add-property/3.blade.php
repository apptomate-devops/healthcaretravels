@extends('layout.master') @section('title','Profile') @section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/property.css') }}">

    <div class="container" style="margin-top: 35px;">
        <div class="row">

            <div class="col-md-12">
                <hr>
                <div>

                    <div class="dashboard-header">

                        <div class=" user_dashboard_panel_guide">

                            @include('owner.add-property.menu')

                        </div>
                    </div>

                    <!-- Tabs Content -->
                    <div class="tab-content" id="tab5" style="display: none;">
                        <form action="{{url('/')}}/owner/add-new-property/3" method="post" name="form-add-new">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="client_id" value="{{$client_id}}">
                            <input type="hidden" name="property_id" value="{{$property_details->id}}">
                            <h3>Listing :</h3>

                            <div class="row with-forms container">
                                <div class="col-md-6">
                                    <h5>Property Title <span class="required">*</span></h5>
                                    <input class="search-field validate" type="text" value="{{isset($property_data->title)?$property_data->title:''}}"  id="value" name="title" />
                                </div>
                            </div>


                            <div class="row with-forms container">
                                <div class="col-md-6">
                                    <h5>Description <span class="required">*</span></h5>
                                    <p class="caption-text">Please do not add any personal contact information for your privacy and safety.</p>
                                    <textarea id="button" class="search-field validate" id="value" name="description">{{isset($property_data->description)?$property_data->description:''}}</textarea>
                                </div>
                            </div>

                            <div class="row with-forms container">
                                <div class="col-md-6">
                                    <h5>House Rules</h5>
                                    <textarea  class="search-field" id="house_rules" name="house_rules">{{isset($property_data->house_rules)?$property_data->house_rules:''}}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12 form-row">
                                <h3>Trash Pickup Days: </h3>
                                <div class="checkboxes in-row" id="trash_days">

                                    <input id="check-2"  value="Sun" name="trash_pickup_days[]" type="checkbox" name="check">
                                    <label for="check-2" >Sunday</label>

                                    <input id="check-3" name="trash_pickup_days[]" value="Mon" type="checkbox" name="check">
                                    <label for="check-3">Monday</label>

                                    <input id="check-4" name="trash_pickup_days[]" value="Tue" type="checkbox" name="check">
                                    <label for="check-4"  >Tuesday</label>

                                    <input id="check-5" value="Wed" name="trash_pickup_days[]" type="checkbox" name="check">
                                    <label for="check-5" >Wednesday</label>


                                    <input id="check-6" value="Thu" name="trash_pickup_days[]" type="checkbox" name="check">
                                    <label for="check-6" >Thursday</label>
                                    <br><br>

                                    <input id="check-7" value="Fri" name="trash_pickup_days[]" type="checkbox" name="check">
                                    <label for="check-7" >Friday</label>

                                    <input id="check-8" value="Sat" name="trash_pickup_days[]" type="checkbox" name="check">
                                    <label for="check-8" >Saturday</label>

                                </div>
                            </div>

                            <div class="col-md-12"><br><br>
                                <h3>Lawn Services<span class="required">*</span> :</h3>
                                <div class="checkboxes in-row">

                                    <input id="lawn_yes" name="lawn_service" type="checkbox" value="1" name="check">
                                    <label for="lawn_yes" >Yes</label>

                                    <input id="lawn_no" name="lawn_service" type="checkbox" value="0" checked  name="check">
                                    <label for="lawn_no"  value="1">No</label>
                                </div>
                            </div>

                            <div class="col-md-12"><br><br>
                                <h3>Pets Allowed :</h3>
                                <div class="checkboxes in-row">

                                    <input id="pet_yes" name="pets_allowed" type="checkbox" value="1" >
                                    <label for="pet_yes" >Yes</label>

                                    <input id="pet_no" name="pets_allowed" type="checkbox" value="0" checked  >
                                    <label for="pet_no"  value="1">No</label>
                                </div>
                            </div>



                            <div class="text-center">

                                <input type="hidden" id="lat" name="lat" value="{{$property_details->lat}}">
                                <input type="hidden" id="lng" name="lng" value="{{$property_details->lng}}">

                                <!--   <div class="col-md-10">
                                      <input  type="button" class="button preview" value="PREVIOUS">
                              </div> -->
                                {{-- @if(isset($property_details->is_complete) && $property_details->is_complete == 1)
                                    <button id="button" class="button border margin-top-5" name="save" value="save" style="background-color: #e78016;">Save<i class="fa fa-save"></i></button>
                                @endif --}}
                                <button type="submit" id="button" class="button preview margin-top-5" value="NEXT">Save  <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </form>

                    </div>

                    <input type="hidden" id="before_lat" value="{{$property_details->lat}}">
                    <input type="hidden" id="before_lng" value="{{$property_details->lng}}">
                </div>

            </div>

        </div>

    </div>
    </div>
    <script type="text/javascript">

        <?php
        if (isset($property_data->trash_pickup_days)) {
            $value = explode(',', $property_data->trash_pickup_days);
            foreach ($value as $v) { ?>
        $("input[type=checkbox][value={{$v}}]").prop("checked",true);

        <?php }
        }
        if (isset($property_data->lawn_service)) {
            $temp = $property_data->lawn_service;

            if ($temp == 1) { ?>

        $('#lawn_no').attr('checked',false);
        $('#lawn_yes').attr('checked',true);
        <?php }
            if ($temp == 0) { ?>
        $('#lawn_no').attr('checked',true);
        $('#lawn_yes').attr('checked',false);
        <?php }
        }
        ?>



        $('#lawn_no,#lawn_yes').change(function(){
            var value=$(this).val();
            if(value==1){
                $('#lawn_no').attr('checked',false);
            }else{
                $('#lawn_yes').attr('checked',false);
            }
        })

        <?php if (isset($property_data->pets_allowed)) {
            $temp = $property_data->pets_allowed;

            if ($temp == 1) { ?>

        $('#pet_no').attr('checked',false);
        $('#pet_yes').attr('checked',true);
        <?php }
            if ($temp == 0) { ?>
        $('#pet_no').attr('checked',true);
        $('#pet_yes').attr('checked',false);
        <?php }
        } ?>



        $('#pet_no,#pet_yes').change(function(){
            var value=$(this).val();
            if(value==1){
                $('#pet_no').attr('checked',false);
            }else{
                $('#pet_yes').attr('checked',false);
            }
        })
    </script>
    {{--    <script type="text/javascript">
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

        </script>--}}

    <!--    <script type="text/javascript">
//        var markers = [
//            {
//                "title": 'Alibaug',
//                "lat": '18.641400',
//                "lng": '72.872200',
//                "description": 'Alibaug is a coastal town and a municipal council in Raigad District in the Konkan region of Maharashtra, India.'
//            },
//            {
//                "title": 'Lonavla',
//                "lat": '18.750000',
//                "lng": '73.416700',
//                "description": 'Lonavla'
//            },
//            {
//                "title": 'Mumbai',
//                "lat": '18.964700',
//                "lng": '72.825800',
//                "description": 'Mumbai formerly Bombay, is the capital city of the Indian state of Maharashtra.'
//            },
//            {
//                "title": 'Pune',
//                "lat": '18.523600',
//                "lng": '73.847800',
//                "description": 'Pune is the seventh largest metropolis in India, the second largest in the state of Maharashtra after Mumbai.'
//            },
//            {
//                "title": 'Thane',
//                "lat": '19.182800',
//                "lng": '72.961200',
//                "description": 'Thane'
//            },
//            {
//                "title": 'Vashi',
//                "lat": '18.750000',
//                "lng": '73.033300',
//                "description": 'Vashi'
//            }
//        ];

        var lat = document.getElementById("before_lat").value;
        var lng = document.getElementById("before_lng").value;
        console.log('Lat is '+lat);
        console.log('Lng is '+lng);
        var markers = [
            {
                "title": 'Alibaug',
                "lat": lat,
                "lng": lng,
                "description": 'Alibaug is a coastal town and a municipal council in Raigad District in the Konkan region of Maharashtra, India.'
            }
        ];

        window.onload = function () {
            var mapOptions = {
                center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
                zoom: 4,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var infoWindow = new google.maps.InfoWindow();
            var latlngbounds = new google.maps.LatLngBounds();
            var geocoder = geocoder = new google.maps.Geocoder();
            var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
            for (var i = 0; i < markers.length; i++) {
                var data = markers[i]
                var myLatlng = new google.maps.LatLng(data.lat, data.lng);
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
                                document.getElementById("lat").value = lat;
                                document.getElementById("lng").value = lng;
                                //alert("Latitude: " + lat + "\nLongitude: " + lng + "\nAddress: " + address);
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
    </script> -->

@endsection
