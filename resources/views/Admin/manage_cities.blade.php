@extends('Admin.Layout.master')

@section('title')  Rentals Slew Admin @endsection

@section('content')
    <link rel="stylesheet" type="text/css"
          href="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/css/plugins/animate/animate.min.css">

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
            <h3 class="content-header-title mb-0 d-inline-block">Cities Management</h3> <span style="float:right"><button
                    type="button" class="btn btn-outline-blue blue block btn-lg" data-toggle="modal"
                    data-target="#rollIn">
                            Add Cities
                          </button></span>
            <div class="row breadcrumbs-top d-inline-block" style="float: right;margin-right: -105%;">
                <div class="breadcrumb-wrapper col-12">
                    <div id="dynButton">
                        <!-- <button class="btn btn-primary btn-sm" type="button" id="btnMap">
                          Show on Map
                        </button> -->
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal animated rollIn text-left" id="rollIn" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel41" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form name="edit_cities" action="add_cities_process" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel41">Add Cities</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <fieldset class="form-group floating-label-form-group">
                            <label for="email">Title</label>
                            <input type="text" required name="title" value="" class="form-control" id="title"
                                   placeholder="Title">
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label for="email">Location</label>
                            <input type="text" required name="location" value="" class="form-control" id="location"
                                   placeholder="Location">
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label for="email">Category Id</label>
                            <input type="text" required name="category_id" value="1" class="form-control"
                                   id="category_id" placeholder="Category Id">
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label for="email">Image</label>
                            <input type="file" required class="form-control" id="file" name="file" placeholder="">
                            <br>

                        </fieldset>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @foreach($data as $key=> $d)
        <div class="modal animated rollIn text-left" id="rollIn{{$key+1}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel41" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form name="edit_cities" action="add_cities_process" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel41">{{$d->location}}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <fieldset class="form-group floating-label-form-group">
                                <label for="email">Title</label>
                                <input type="text" name="title" required value="{{$d->title}}" class="form-control"
                                       id="title" placeholder="Title">
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label for="email">Location</label>
                                <input type="text" name="location" required value="{{$d->location}}"
                                       class="form-control" id="location" placeholder="Location">
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label for="email">Category Id</label>
                                <input type="text" name="category_id" value="{{$d->category_id}}" class="form-control"
                                       id="category_id" placeholder="Category Id" required>
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label for="email">Image</label>
                                <input type="file" class="form-control" id="file" required name="file"
                                       placeholder="Image">
                                <br>
                                <img src="{{$d->image_url}}" width="75px" width="75px">
                                <input type="hidden" name="image_url" value="{{$d->image_url}}">
                                <input type="hidden" name="id" value="{{$d->id}}">
                            </fieldset>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-outline-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    @endforeach



    <div class="content-body">
        <!-- Basic form layout section start -->


        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>


                                        <tr>
                                            <th>S.No</th>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Location</th>
                                            <th>Category</th>

                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($data as $key=> $d)

                                            <tr>
                                                <td>
                                                    {{$key+1}}

                                                </td>
                                                <td>
                                                    {{$d->title}}
                                                </td>
                                                <td>
                                                    <img src="{{$d->image_url}}" width="75px" height="75px">

                                                </td>
                                                <td>
                                                    {{$d->location}}
                                                </td>
                                                <td>
                                                    {{$d->category_id}}
                                                </td>


                                                <td>
                                                    <a class="btn btn-default btn-info btn-block" data-toggle="modal"
                                                       data-target="#rollIn{{$key+1}}" style="color:white"><i
                                                            class="fa fa-edit"></i>Edit</a>
                                                    <a class="btn btn-default btn-danger btn-block"
                                                       href="delete-city/{{$d->id}}" style="color:white"><i
                                                            class="fa fa-edit"></i>Delete</a>
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
    <script type="text/javascript"
            src="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/js/scripts/modal/components-modal.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">

        function status_update(status, id) {
            var url = "{{BASE_URL}}" + "admin/user-status-update?id=" + id + "&status=" + status;

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

