<!DOCTYPE html>
<html>
<head>
    <title>Custom Markers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<div id="map"></div>
<script>
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            minZoom: 7,
            maxZoom: 12,
            center: new google.maps.LatLng({{$lat}},{{$lng}}),
            mapTypeId: 'roadmap'
        });

        var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
        var icons = {
            test: {
                icon: 'http://api.estatevue2.com/cdn/img/marker-green.png'
            }
        };

         var markerIcon = {
                path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
                fillColor: '#e25a00',
                fillOpacity: 0.95,
                scale: 3,
                strokeColor: '#fff',
                strokeWeight: 3,
                anchor: new google.maps.Point(12, 24)
            };

        
                var markers  = [  
                @if(count($hospitals)!=0)  
                    <?php $val = 0; ?>
                    @foreach($hospitals as $key=>$hospital)
                            <?php $val++; ?>
                        {property_details:'<div style="background: white;width: 405px;padding-left: 2px;padding-bottom: 5px;    border-radius: 10px;"><div>@if(isset($hospital['image_url']) != "")<img src="{{$hospital['image_url']}}" style="width: 400px;height:250px">@endif</div><div><h4 style="font-size: 22px;font-weight: bold;padding-left: 5px;">{{$hospital['name']}}</h4></div><div><p style="font-size: 15px;font-weight: 600;width: 400px;padding-left: 5px;"><i class="fa fa-map-marker"></i>{{$hospital['address']}} </p></div> <div style="font-size: 15px;font-weight: 600;width: 400px;padding-left: 5px;" >Phone :{{$hospital['display_phone']}} <br><br> {{$hospital['distance']}}  </div></div>', provider_id: "{{ 1 }}",name: '',type: 0, lat: {{$hospital['lat'] }}, lng: {{$hospital['lang']}} } @if($val <= count($hospitals)) , @endif
                                

                    @endforeach  
                @endif
                @if($pets_allowed == 1)
                    @if(count($pet_place)!=0)
                            <?php $value = 0; ?>
                         @foreach($pet_place as $pet)
                                 <?php $value++; ?>
                            {property_details:'<div style="background: white;width: 405px;padding-left: 2px;padding-bottom: 5px;    border-radius: 10px;"><div>@if(isset($pet['image_url']) != "")<img src="{{$pet['image_url']}}" style="width: 400px;height:250px">@endif</div><div><h4 style="font-size: 22px;font-weight: bold;padding-left: 5px;">{{$pet['name']}}</h4></div><div><p style="font-size: 15px;font-weight: 600;width: 400px;padding-left: 5px;"><i class="fa fa-map-marker"></i>{{$pet['address']}} </p></div> <div style="font-size: 15px;font-weight: 600;width: 400px;padding-left: 5px;" >Phone :{{$pet['display_phone']}} <br><br> {{$pet['distance']}}  </div></div>', provider_id: "{{ 1 }}",name: '',type: 1, lat: {{$pet['lat']?$pet['lat']:40.238856 }}, lng: {{$pet['lang']?$pet['lang']:-101.909323}} }@if($value < count($pet_place)) , @endif

                        @endforeach   
                    @endif
                @endif       
    ];
    

    console.log(markers);
    var mapIcons = [
         'https://cdn3.iconfinder.com/data/icons/medical-3-1/512/hospital_place-512.png',
     
    ];

    var latitude = 40.238856;
    var longitude = -101.909323;
    function initMaps() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng({{$lat}},{{$lng}}),
            zoom: 5,
            icon :  markerIcon
        });
    }

       marker = new google.maps.Marker({
                position: {lat: {{$lat}}, lng: {{$lng}}},
                map: map,
                icon: markerIcon,
            });


   console.log("latitude");
   console.log(latitude);
   console.log("longitude");
   console.log(longitude);

var yelp_icons =[
         'https://healthcaretravels.com/public/icons/map_hospital.png',
         'https://healthcaretravels.com/public/icons/map_pets.png',
     
    ];

    var infoWindow = new google.maps.InfoWindow(), marker, i;
var i=0;
        markers.forEach( function(element, index) {
             console.log(element);
            var url = "/admin/provider/details/"

            marker = new google.maps.Marker({
                property_details: element.property_details,
                position: {lat: element.lat, lng: element.lng},
                map: map,
                title: element.name,
                icon: yelp_icons[element.type],
            });

           
   google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(markers[i]['property_details']);
                infoWindow.open(map, marker);
            }
        })(marker, i));
  
  
    i++;
        });

      

console.log(infoWindow);

       
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{GOOGLE_MAPS_API_KEY}}&callback=initMap">
</script>
</body>
</html>
<!-- 
 var features = [
            {
                position: new google.maps.LatLng({{$lat}},{{$lng}}),
                type: 'test'
            }
        ];

        // Create markers.
        features.forEach(function(feature) {
            var marker = new google.maps.Marker({
                position: feature.position,
                icon: icons[feature.type].icon,
                map: map
            });
        }); -->