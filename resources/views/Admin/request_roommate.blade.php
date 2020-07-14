<<<<<<< HEAD
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
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Roommate Management</h3>
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

<input type="hidden" name="current" id="current" value="1">

<!-- <div id="map_wrapper" style="margin-bottom: 20px;">
    <div id="map_canvas" class="mapping"></div>
</div> -->

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
                            <th>SNo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date Between</th>
                            <th>gender</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Age</th>
                            <th>Found House</th>
                            <th>Rent</th>
                            <th>House on <br>Healthcare</th>
                            <th>Occupation</th>
                            <th>Prefer<br> Gender/Age</th>
                            <th>Request <br>Details</th>
                            
                            
                          </tr>
                        </thead>
                        <tbody>

                          @foreach($data as $key => $roommate)
                            <tr>
                              <td>
                                {{$key+1}}
                              </td>
                              <td>
                                <center>
                                {{$roommate->lastname}}
                                {{$roommate->firstname}}
                               
                              </td>
                              <td>
                                {{$roommate->email}}
                              </td>
                              <td>
                                {{$roommate->phone}}
                              </td>
                              <td>
                              {{$roommate->startdate}} <br> to<br>
                              {{$roommate->enddate}}
                              </td>
                              <td>
                              {{$roommate->gender}}
                              </td>
                              <td>
                                {{$roommate->city}}
                               </td>
                                <td>
                                {{$roommate->state}}
                               </td>
                               <td>
                                {{$roommate->age}}
                               </td>
                                <td>
                                {{$roommate->found_housing}}
                               </td>
                               <td>
                                {{$roommate->rent}}
                               </td>
                               <td>
                                {{$roommate->is_house_on_healthcare}}
                               </td>
                               <td>
                                {{$roommate->occupation  }}
                               </td>
                               <td>
                                {{$roommate->prefer_gender}}/
                                {{$roommate->prefer_age}}
                               </td>
                               <td>
                                {{$roommate->request_details}}
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
  
  function status_update(status,id) {
    var url = "{{BASE_URL}}"+"admin/user-status-update?id="+id+"&status="+status;

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
        ['London Eye, London', 51.503454,-0.119562],
        ['Palace of Westminster, London', 51.499633,-0.124755]
    ];
                        
    // Info Window Content
    var infoWindowContent = [
        ['<div class="info_content">' +
        '<h3>London Eye</h3>' +
        '<p>The London Eye is a giant Ferris wheel situated on the banks of the River Thames. The entire structure is 135 metres (443 ft) tall and the wheel has a diameter of 120 metres (394 ft).</p>' +        '</div>'],
        ['<div class="info_content">' +
        '<h3>Palace of Westminster</h3>' +
        '<p>The Palace of Westminster is the meeting place of the House of Commons and the House of Lords, the two houses of the Parliament of the United Kingdom. Commonly known as the Houses of Parliament after its tenants.</p>' +
        '</div>']
    ];
        
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
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

$("#btnMap").click(function(){
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

=======
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
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Roommate Management</h3>
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

<input type="hidden" name="current" id="current" value="1">

<!-- <div id="map_wrapper" style="margin-bottom: 20px;">
    <div id="map_canvas" class="mapping"></div>
</div> -->

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
                            <th>SNo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date Between</th>
                            <th>gender</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Age</th>
                            <th>Found House</th>
                            <th>Rent</th>
                            <th>House on <br>Healthcare</th>
                            <th>Occupation</th>
                            <th>Prefer<br> Gender/Age</th>
                            <th>Request <br>Details</th>
                            
                            
                          </tr>
                        </thead>
                        <tbody>

                          @foreach($data as $key => $roommate)
                            <tr>
                              <td>
                                {{$key+1}}
                              </td>
                              <td>
                                <center>
                                {{$roommate->lastname}}
                                {{$roommate->firstname}}
                               
                              </td>
                              <td>
                                {{$roommate->email}}
                              </td>
                              <td>
                                {{$roommate->phone}}
                              </td>
                              <td>
                              {{$roommate->startdate}} <br> to<br>
                              {{$roommate->enddate}}
                              </td>
                              <td>
                              {{$roommate->gender}}
                              </td>
                              <td>
                                {{$roommate->city}}
                               </td>
                                <td>
                                {{$roommate->state}}
                               </td>
                               <td>
                                {{$roommate->age}}
                               </td>
                                <td>
                                {{$roommate->found_housing}}
                               </td>
                               <td>
                                {{$roommate->rent}}
                               </td>
                               <td>
                                {{$roommate->is_house_on_healthcare}}
                               </td>
                               <td>
                                {{$roommate->occupation  }}
                               </td>
                               <td>
                                {{$roommate->prefer_gender}}/
                                {{$roommate->prefer_age}}
                               </td>
                               <td>
                                {{$roommate->request_details}}
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
  
  function status_update(status,id) {
    var url = "{{BASE_URL}}"+"admin/user-status-update?id="+id+"&status="+status;

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
        ['London Eye, London', 51.503454,-0.119562],
        ['Palace of Westminster, London', 51.499633,-0.124755]
    ];
                        
    // Info Window Content
    var infoWindowContent = [
        ['<div class="info_content">' +
        '<h3>London Eye</h3>' +
        '<p>The London Eye is a giant Ferris wheel situated on the banks of the River Thames. The entire structure is 135 metres (443 ft) tall and the wheel has a diameter of 120 metres (394 ft).</p>' +        '</div>'],
        ['<div class="info_content">' +
        '<h3>Palace of Westminster</h3>' +
        '<p>The Palace of Westminster is the meeting place of the House of Commons and the House of Lords, the two houses of the Parliament of the United Kingdom. Commonly known as the Houses of Parliament after its tenants.</p>' +
        '</div>']
    ];
        
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
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

$("#btnMap").click(function(){
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

>>>>>>> 9780f4d597805bbd719091658f0c562aa3f6ec95
@endsection