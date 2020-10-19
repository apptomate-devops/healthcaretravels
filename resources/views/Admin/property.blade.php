@extends('Admin.Layout.master')

@section('title')  Rentals Slew Admin @endsection

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Property <small>Management</small></h3>
            <div class="row breadcrumbs-top d-inline-block float-md-right">
                <div class="breadcrumb-wrapper  col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{URL('/')}}/admin">Dashboard</a>
                        </li>


                    </ol>
                </div>
            </div>
        </div>
    </div>




    <div class="content-detached content-right">

        <div id="map_wrapper" style="margin-bottom: 20px;">
            <div id="map_canvas" class="mapping"></div>
        </div>

        <section class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">
                            <!-- Task List table -->
                            <div class="table-responsive">
                                <table id="users-contacts"
                                       class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Posted At</th>
                                        <th>Property Name</th>
                                        <th>Host Name</th>
                                        <th>Property Type</th>
                                        <th>Created At</th>
                                        <th>Featured</th>
                                        <th>Status</th>
                                        <th>View Documents</th>
                                        <th style="min-width: 110px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($properties as $key => $property)
                                        <tr>
                                            <td>{{$property->id}}</td>
                                            <td>{{Helper::get_local_date_time($property->created_at, 'm/d/Y')}}</td>
                                            <td>{{$property->title}}</td>
                                            <td>{{$property->first_name}} {{$property->last_name}}</td>
                                            <td>{{$property->room_type}}</td>
                                            <td>{{Helper::get_local_date_time($property->created_at)}}</td>
{{--                                            <td>{{$property->view_count}}</td>--}}
                                            <td>
                                                Featured : <input type="checkbox" id="switchery1" class="switchery-sm" />

                                            </td>
                                            </td>
                                            <td>
                                                @if($property->property_status == 0)
                                                    Pending
                                                @endif
                                                @if($property->property_status == 1)
                                                    Published
                                                @endif
                                                @if($property->property_status == 2)
                                                    Blocked
                                                @endif
                                                @if($property->property_status == 3)
                                                    Un Published
                                                @endif
                                                @if($property->property_status == 4)
                                                    Disabled
                                                @endif
                                                <br>
                                                @if($property->verified==0)
                                                    <span
                                                        class="btn btn-default btn-danger btn-block">Not Verified </span></a>
                                                @else
                                                    <span class="btn btn-default btn-success btn-block">Verified</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{BASE_URL}}admin/property_details/{{$property->id}}"><span
                                                        class="btn btn-success btn-default btn-block">View </span> </a>
                                            </td>
                                            <td style="min-width: 110px;">
                                                <fieldset class="form-group">
                                                    <select class="form-control"
                                                            onchange="status_update({{$property->id}},this)"
                                                            id="basicSelect" style="cursor: pointer;">
                                                        <option selected="selected" disabled>Select</option>
                                                        <option value="1">Publish</option>
                                                        <option value="3">Unpublish</option>
                                                        <!-- <option value="0">Pending</option> -->
                                                        <!-- <option value="2">Block</option> -->
                                                        <!-- <option value="4">Disable</option> -->
                                                        <option value="5">Delete</option>
                                                    </select>
                                                </fieldset>
                                            </td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection

@section('scripts')

    <script type="text/javascript">

        function status_update(id, obj) {
            var status = obj.value;
            var url = "{{BASE_URL}}" + "admin/property-status-update?id=" + id + "&status=" + status;

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function (data) {
                    // ajax success
                    console.log(data);
                    if (data.status) {
                        alert("Status updated successfully!...");
                        location.reload();
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }


        jQuery(function ($) {
            // Asynchronously Load the map API
            var script = document.createElement('script');
            script.src = "https://maps.googleapis.com/maps/api/js?key={{GOOGLE_MAPS_API_KEY}}&sensor=false&callback=initialize";
            document.body.appendChild(script);
        });

        function initialize() {
            var map;
            var bounds = new google.maps.LatLngBounds();
            var mapOptions = {
                mapTypeId: 'roadmap'
            };

            // Display a map on the page
            map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
            map.setTilt(45);
            // alert("You sre un initialize");

            // Multiple Markers
            var markers = [
                ['London Eye, London', 51.503454, -0.119562],
                ['Palace of Westminster, London', 51.499633, -0.124755]
            ];

            // Info Window Content
            var infoWindowContent = [
                ['<div class="info_content">' +
                '<h3>London Eye</h3>' +
                '<p>The London Eye is a giant Ferris wheel situated on the banks of the River Thames. The entire structure is 135 metres (443 ft) tall and the wheel has a diameter of 120 metres (394 ft).</p>' + '</div>'],
                ['<div class="info_content">' +
                '<h3>Palace of Westminster</h3>' +
                '<p>The Palace of Westminster is the meeting place of the House of Commons and the House of Lords, the two houses of the Parliament of the United Kingdom. Commonly known as the Houses of Parliament after its tenants.</p>' +
                '</div>']
            ];

            // Display multiple markers on a map
            var infoWindow = new google.maps.InfoWindow(), marker, i;

            // Loop through our array of markers & place each one on the map
            for (i = 0; i < markers.length; i++) {
                var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                bounds.extend(position);
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: markers[i][0]
                });

                // Allow each marker to have an info window
                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infoWindow.setContent(infoWindowContent[i][0]);
                        infoWindow.open(map, marker);
                    }
                })(marker, i));

                // Automatically center the map fitting all markers on the screen
                map.fitBounds(bounds);
            }

            // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
            var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
                this.setZoom(14);
                google.maps.event.removeListener(boundsListener);
            });

        }


    </script>
@endsection
