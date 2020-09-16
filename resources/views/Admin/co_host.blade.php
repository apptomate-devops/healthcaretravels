@extends('Admin.Layout.master')

@section('title')  Rentals Slew Admin @endsection

@section('content')

    <style type="text/css">
        #map_wrapper {
            height: 400px;
        }

        #map_canvas {
            width: 100%;
            height: 100%;
        }

    </style>
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Co-Host <small>Management</small>
                @if(Session::has('error'))
                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="float:right;font-size: 15px"><span
                            class="alert alert-{{Session::get('status')}} alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{Session::get('error')}}
  </span></span>
                @endif</h3>
            <div class="row breadcrumbs-top d-inline-block" style="float: right;margin-right: -105%;">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{URL('/')}}/admin">Dashboard</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <input type="hidden" name="current" id="current" value="1">

    <div style="margin-bottom: 20px;">

    </div>

    <div class="content-body">
        <!-- Basic form layout section start -->


        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    @component('components.approve-all-by-user-role', ['user' => count($travellers) > 0 ? $travellers[0] : null])
                                    @endcomponent
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Registered At</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Gender</th>
                                            <th>Date of Birth</th>
                                            <th>Status</th>
                                            <th>View Documents</th>
                                            <th>Action &nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($travellers as $key => $traveller)
                                            <tr>
                                                <td>
                                                    {{$traveller->id}}
                                                </td>
                                                <td>{{date("m/d/Y",strtotime($traveller->created_at))}}</td>
                                                <td>
                                                    <center>@if($traveller->first_name!='0'){{$traveller->first_name}} @else  @endif
                                                        @if($traveller->last_name!='0'){{$traveller->last_name}}@else
                                                        @endif
                                                    </center>
                                                </td>
                                                <td>
                                                    @if($traveller->email!='0'){{$traveller->email}}@else
                                                        <center>-</center>@endif
                                                </td>
                                                <td>
                                                    @if($traveller->phone!='0'){{$traveller->phone}}@else
                                                        <center>-</center>@endif
                                                </td>
                                                <td>
                                                     <center>
                                                        @if($traveller->gender=!'0')
                                                            @if ($traveller->gender == '1')
                                                                Male
                                                            @elseif($traveller->gender == '2')
                                                                Female
                                                            @else
                                                                {{$traveller->gender}}
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        @if($traveller->date_of_birth!='0')
                                                            {{date('m-d-Y',strtotime($traveller->date_of_birth))}}
                                                        @else
                                                            -
                                                        @endif
                                                    </center>
                                                </td>
                                                <td>
                                                    @if($traveller->status == 0)
                                                        <span class="btn btn-danger btn-default">Disabled</span>
                                                    @elseif($traveller->is_verified==0 && $traveller->is_submitted_documents == 1)
                                                        <span class="btn btn-default btn-danger btn-block">Pending Verification </span></a>
                                                    @elseif($traveller->is_verified==0)
                                                        <span class="btn btn-default btn-danger btn-block">Not Verified </span></a>
                                                    @elseif($traveller->is_verified==-1)
                                                        <span class="btn btn-default btn-danger btn-block">Denied</span></a>
                                                    @else
                                                        <span class="btn btn-default btn-success btn-block">Verified</span>
                                                    @endif
                                                </td>
                                                <td>
                                                <a href="{{BASE_URL}}admin/single_user?id={{$traveller->id}}"><span
                                                        class="btn btn-success btn-default btn-block">View </span> </a>
                                            </td>
                                                <td>
                                                    <fieldset class="form-group">
                                                        <select class="form-control"
                                                                onchange="status_update(this.value,{{$traveller->id}},this)"
                                                                id="basicSelect" style="cursor: pointer;">
                                                            <option selected="selected" disabled>Select</option>
                                                            <option value="approve" data-approve="1">Approve</option>
                                                            <option value="deny" data-approve="0">Deny</option>
                                                            <option value="1">Enable</option>
                                                            <option value="0">Disable</option>
                                                            <option value="2">Delete</option>
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
            </div>
        </section>

        <!-- // Basic form layout section end -->
    </div>

@endsection


@section('scripts')

    <script type="text/javascript">

        function status_update(status, id, node) {
            if (node.selectedOptions[0].dataset.approve) {
                var url = "{{BASE_URL}}" + "admin/verify_profile/" + id;
                if (node.selectedOptions[0].dataset.approve == "0") {
                    url += "/true";
                }
            } else if (status != 5) {
                var url = "{{BASE_URL}}" + "admin/user-status-update?id=" + id + "&status=" + status;
            } else {
                var url = "{{BASE_URL}}" + "admin/single_user?id=" + id;
            }
            window.location = url;
        }


        function status_update1(status, id) {
            var url = "{{BASE_URL}}" + "admin/change_status/" + id + "/" + status;
            console.log(url);

            $.ajax({
                type: 'GET',
                url: url,
                // dataType: 'json',
                success: function (data) {
                    // ajax success
                    console.log("data", data);
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

        // $("#map_wrapper").hide();

        $("#btnMap").click(function () {
            var current = $("#current").val();

            if (current == 1) {
                $("#current").val(2);
                $("#map_wrapper").show();
                $(".content-body").hide();
                $("#btnMap").html("Show on table");
            } else {
                $("#current").val(1);
                $("#map_wrapper").hide();
                $(".content-body").show();
                $("#btnMap").html("Show on map");
            }
        });
    </script>

@endsection
