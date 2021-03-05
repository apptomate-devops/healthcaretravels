@extends('Admin.Layout.master')

@section('title') {{APP_BASE_NAME}} - Admin @endsection

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
        <h3 class="content-header-title mb-0 d-inline-block">Traveler Agency <small>Management</small></h3>
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
<div style="margin-bottom: 20px;"></div>
<input type="hidden" name="current" id="current" value="1">

<div class="content-body">
    <!-- Basic form layout section start -->


    <section id="configuration">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                @component('components.approve-all-by-user-role', ['user' => count($agencyes) > 0 ? $agencyes[0] : null])
                                @endcomponent
                                <table class="table table-striped table-bordered zero-configuration select" id="hct_users">
                                    <thead>
                                        <tr>
                                            <th><input name="select_all" value="1" type="checkbox"> Select</th>
                                            <th>ID</th>
                                            <th>Registered On</th>
                                            <th>Agency Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>View Documents</th>
                                            <th>Action &nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($agencyes as $key => $agency)
                                        <tr>
                                            <td>
                                                <center>
                                                    <input type="checkbox" name="" value="{{$agency->id}}" />
                                                </center>
                                            </td>
                                            <td>
                                                {{$agency->id}}
                                            </td>
                                            <td>{{Helper::get_local_date_time($agency->created_at, 'm/d/Y')}}</td>
                                            <td>
                                                <center>@if($agency->name_of_agency!='0'){{$agency->name_of_agency}} @else
                                                    - @endif </center>


                                            </td>
                                            <td>
                                                @if($agency->email!='0'){{$agency->email}}@else
                                                <center>-</center>@endif
                                            </td>
                                            <td>
                                                @if($agency->phone!='0')<span class="masked_phone_us_text">{{$agency->phone}}</span>@else
                                                <center>-</center>@endif
                                            </td>


                                            <td>
                                                @if($agency->status == 0)
                                                <span class="btn btn-danger btn-default">Disabled</span>
                                                @elseif($agency->is_verified==0 && $agency->is_submitted_documents == 1)
                                                <span class="btn btn-default btn-danger btn-block">Pending Verification </span></a>
                                                @elseif($agency->is_verified==0)
                                                <span class="btn btn-default btn-danger btn-block">Not Verified </span></a>
                                                @elseif($agency->is_verified==-1)
                                                <span class="btn btn-default btn-danger btn-block">Denied</span></a>
                                                @else
                                                <span class="btn btn-default btn-success btn-block">Verified</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($agency->approved_by))
                                                <a href="{{BASE_URL}}admin/single_user?id={{$agency->id}}"><span class="btn btn-outline-success btn-default btn-block">Documents Approved </span> </a>
                                                @else
                                                <a href="{{BASE_URL}}admin/single_user?id={{$agency->id}}"><span class="btn btn-success btn-default btn-block">View </span> </a>
                                                @endif
                                            </td>
                                            <td>
                                                <fieldset class="form-group">
                                                    <select class="form-control" onchange="status_update(this.value,{{$agency->id}},this)" id="basicSelect" style="cursor: pointer;">
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
        var url = "{{BASE_URL}}" + "admin/user-status-update?id=" + id + "&status=" + status;
        console.log(url);
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(data) {
                // ajax success
                console.log("data", data);
                if (data.status) {
                    alert("Status updated successfully!...");
                    location.reload();
                }
            },
            error: function(data) {
                console.log('Error:', data);
            }
        });
    }

    jQuery(function($) {
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
                '<p>The London Eye is a giant Ferris wheel situated on the banks of the River Thames. The entire structure is 135 metres (443 ft) tall and the wheel has a diameter of 120 metres (394 ft).</p>' + '</div>'
            ],
            ['<div class="info_content">' +
                '<h3>Palace of Westminster</h3>' +
                '<p>The Palace of Westminster is the meeting place of the House of Commons and the House of Lords, the two houses of the Parliament of the United Kingdom. Commonly known as the Houses of Parliament after its tenants.</p>' +
                '</div>'
            ]
        ];

        // Display multiple markers on a map
        var infoWindow = new google.maps.InfoWindow(),
            marker, i;

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
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));

            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }

        // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
            this.setZoom(14);
            google.maps.event.removeListener(boundsListener);
        });

    }

    // $("#map_wrapper").hide();

    $("#btnMap").click(function() {
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
