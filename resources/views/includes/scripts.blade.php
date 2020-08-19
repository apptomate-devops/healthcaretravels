<script type="text/javascript" src="{{URL::asset('scripts/chosen.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/magnific-popup.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/rangeSlider.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/sticky-kit.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/slick.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/mmenu.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/tooltips.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/masonry.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/custom.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('js/caleran.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/my-library.js') }}"></script>


<!-- DropZone | Documentation: http://dropzonejs.com -->
<script type="text/javascript" src="{{URL::asset('scripts/dropzone.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/common.js') }}"></script>
<script>
    $(".dropzone").dropzone({
        dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
    });
</script>
<style type="text/css">
    .uploading {
        color: #ffffff;
        background-color: #e78016;
        border-color: #ffffff;
    }

</style>


{{--facebook login scripts--}}


<script>
    function lsTest() {
        var test = 'test';
        try {
            localStorage.setItem(test, test);
            localStorage.removeItem(test);
            return true;
        } catch (e) {
            return false;
        }
    }

    // listen to storage event
    window.addEventListener('storage', function (event) {
        // do what you want on logout-event
        if (event.key == 'logout-event') {
            //alert('Received logout event! Insert logout script here.');
            window.location = window.location.protocol + "//" + window.location.host;
        }
    }, false);

    $(document).ready(function () {
        if (lsTest()) {
            $('#logout').on('click', function () {
                // change logout-event and therefore send an event
                localStorage.setItem('logout-event', 'logout' + Math.random());
                return true;
            });
        } else {
            // setInterval or setTimeout
        }
    });

    function signOut() {
        //alert("logout");
        window.localStorage.setItem('logged_in', false)
        // FB.logout(function(response) {
        //     // Person is now logged out
        //     console.log('User signed out.'+response);

        // });
        // var auth2 = gapi.auth2.getAuthInstance();
        // auth2.signOut().then(function () {
        //     console.log('User signed out.');

        // });

        // FB.logout(function(response) {
        //     // Person is now logged out
        //     console.log('User signed out.'+response);


        // });

    }


    function initMap() {
        @if(Request::path()=='owner/add-property')
        dragMap();
        @endif
        var input = document.getElementById('pac-input');
        var autocomplete = new google.maps.places.Autocomplete(input);

        google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('pac-input'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
                var address = place.formatted_address;
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                var mesg = "Address: " + address;
                mesg += "\nLatitude: " + latitude;
                mesg += "\nLongitude: " + longitude;
                //alert(mesg);
                var html_data = '<input type="hidden" name="lat" value="' + latitude + '"/>';
                html_data += '<input type="hidden" name="lng" value="' + longitude + '"/>';
                html_data += '<input type="hidden" name="formatted_address" value="' + address + '"/>';
                $("#set_location").html(html_data);
                $("#search_location").html(html_data);
            });
        });
    }

    function dragMap() {
        var latitude = 40.238856;
        var longitude = -101.909323;

        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: latitude, lng: longitude},
            zoom: 14,
            minZoom: 1
        });
    }
    function contact_map() {
        var latitude = 30.0003267;
        var longitude = -95.2464395;

        var infowindow = new google.maps.InfoWindow({
            content: '<div class="contact_map" style="top: 55px;margin-bottom: 8px;"><center><h2 style="color:orange">Health Care Travels</h2><h4> 7075 Fm 1960 Rd W,</h4><h4>Houston, Texas 77069, </h4><h4> United States Suite 1010</h4><center></div>'
        });

        var uluru = {lat: latitude, lng: longitude};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map,
            icon: 'https://www.healthcaretravels.com/public/assets/icons/others/Map.png',
            title: 'Health Care Travels',
        });

        infowindow.open(map, marker);
        google.maps.event.addListener(marker, 'load', function () {
            infowindow.open(map, marker);
        });
    }

    function create_map(latitude, longitude) {


        var uluru = {lat: latitude, lng: longitude};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map,
        });
    }

    var map;
        @if(Request::path()=='short-term' || Request::path()=='search-property')
    var markers = [
                @foreach($properties as $propmap)
            {
                property_details: '<div style="background: white;width: 405px;padding-left: 2px;padding-bottom: 5px;    border-radius: 10px;"><div>@if(isset($propmap->image_url) != "")<img src="{{$propmap->image_url}}" style="width: 400px;">@endif<p style="font-size: 30px;font-weight: 600;margin-top: -45px;background-color: rgba(74,74,76,0.7);position: absolute;width: 400px;color: white;height: 45px;padding-left: 20px;width: 400px;">$ {{$propmap->price_per_night}}</p></div><div><h4 style="font-size: 22px;font-weight: bold;padding-left: 5px;">{{$propmap->title}}</h4></div><div><p style="font-size: 15px;font-weight: 600;width: 400px;padding-left: 5px;"><i class="fa fa-map-marker"></i><?php
                $location = explode(',', $propmap->location);
                $getLoc = end($location);
                echo $getLoc;
                ?> </p></div></div>',
                provider_id: "{{ $propmap->id }}",
                name: '',
                lat: {{ $propmap->lat }},
                lng: {{ $propmap->lng }}},
            @endforeach
        ];

    console.log(markers);
    var mapIcons = [
        'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
    ];
    var mapMarkers = [];
    var mapMarkers1 = [];
    @if(Request::path()=='short-term' || Request::path()=='search-property')
    var latitude = 40.238856;
    var longitude = -101.909323;
        @else
    var latitude = {{array_key_exists ('lat' , $request_data) ? $request_data['lat'] : 40.238856}};
    var longitude = {{array_key_exists ('lng' , $request_data) ? $request_data['lng'] : -101.909323}};

    @endif
    function initMaps() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: latitude, lng: longitude},
            zoom: 4,
            minZoom: 1
        });
        var infoWindow = new google.maps.InfoWindow(), marker, i;
        var i = 0;
        markers.forEach(function (element, index) {
            var url = "/admin/provider/details/"
            marker = new google.maps.Marker({
                property_details: element.property_details,
                position: {lat: element.lat, lng: element.lng},
                map: map,
                title: element.name,
                icon: mapIcons[element.available],
            });
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infoWindow.setContent(markers[i]['property_details']);
                    infoWindow.open(map, marker);
                }
            })(marker, i));
            i++;
        });
    }


    @endif

</script>


<!-- Firebase -->
<script src="https://www.gstatic.com/firebasejs/4.8.0/firebase.js"></script>

<!-- GeoFire -->
<script src="https://cdn.firebase.com/libs/geofire/4.1.2/geofire.min.js"></script>
<script>

    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyCBLDLZq27-DR9Wf0oNOTwNI4GKE7Vy-qI",
        authDomain: "keepers-firebase.firebaseapp.com",
        databaseURL: "https://keepers-firebase.firebaseio.com",
        projectId: "keepers-firebase",
        storageBucket: "",
        messagingSenderId: "813429405573"
    };
    firebase.initializeApp(config);

    // Create a Firebase reference where GeoFire will store its information
    var firebaseRef = firebase.database().ref();

    // Create a GeoFire index
    var geoFire = new GeoFire(firebaseRef);

    var ref = geoFire.ref();  // ref === firebaseRef
    geoFire.set("test", [10.48, 2.41]).then(function () {
        console.log("Provided key has been added to GeoFire");
    }, function (error) {
        console.log("Error: " + error);
    });

    var geoQuery = geoFire.query({
        center: [10.38, 2.41],
        radius: 100.5
    });

    var onKeyEnteredRegistration = geoQuery.on("key_entered", function (key, location, distance) {
        console.log(key + " entered query at " + location + " (" + distance + " km from center)");
    });

    var onKeyExitedRegistration = geoQuery.on("key_exited", function (key, location, distance) {
        console.log(key + " exited query to " + location + " (" + distance + " km from center)");

        // Cancel the "key_entered" callback
        onKeyEnteredRegistration.cancel();
    });

    function file_upload() {
        $("#upload_button").hide();
        var up = '<p  class="alert uploading" style="margin-top: 5px;text-align:  center;">Uploading...</p>';
        document.getElementById("uploading").innerHTML = up;
        var file_data = $('#profile_image').prop('files')[0];
        var form_data = new FormData();
        form_data.append('profile_image', file_data);
        form_data.append('_token', "{{csrf_token()}}");
        $.ajax({
            url: '/update-profile-picture',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (php_script_response) {
                //alert(php_script_response); // display response from the PHP script, if any
                var data = '<img src="' + php_script_response + '" alt="profile picture">'
                //$("#profileImage").html(data);
                document.getElementById("profileImage").innerHTML = data;
                document.getElementById("header_profile_image").innerHTML = data;
                document.getElementById("uploading").innerHTML = '';
                $("#upload_button").show();


            }
        });


    }

    function delete_file() {

        var tok = $("#token_1").val();
        var form_data = new FormData();
        form_data.append('_token', tok);

        $.ajax({
            url: 'owner_delete_profile', // point to server-side PHP script
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (php_script_response) {
                //alert(php_script_response); // display response from the PHP script, if any
                // var data = '<img src="'+php_script_response+'" alt="profile picture">'
                // //$("#profileImage").html(data);
                // document.getElementById("profileImage").innerHTML = data;
                // document.getElementById("header_profile_image").innerHTML = data;
                // document.getElementById("uploading").innerHTML = '';
                // $("#upload_button").show();

            }
        });


    }

</script>


<script>

    function onLoad() {
        gapi.load('auth2', function () {
            gapi.auth2.init();
        });
    }

    function show_snackbar(message) {
        // Get the snackbar DIV
        document.getElementById("snackbar").innerHTML = message;
        var x = document.getElementById("snackbar")
        // Add the "show" class to DIV
        x.className = "show";
    }

    function remove_snackbar() {
        var x = document.getElementById("snackbar")
        x.className = "";

    }

</script>

<script type="text/javascript">
    function limitNavigationUsingLinks() {
        $('.not-verified-block').toggleClass('not-verified-block');
        $('.notification-message').html('Verify otp to continue');
        $(document).on('click', 'a', function(event) {
            event.preventDefault();
            event.stopPropagation();
            openVerificationModal();
        });
    }
    function onGoogleLoad() {
        var path = "{{Request::path()}}";
        var property_path_regex = /^property\/(\d+)/;
        if(property_path_regex.test(path)) {
            initMap();
            return;
        }
        switch (path) {
            case '/':
                initHomeSearchInput();
                break;
            case 'contact':
                contact_map();
                break;
            case 'profile':
                initialize();
                break;
            case 'owner/add-property':
            case 'verify-account':
                initializeAddress();
                break;
            case 'short-term':
                initMaps();
                break;
            case 'search-property':
                initMaps();
                initSearchPropertySearchInput();
                break;
            case 'otp-verify-register':
            case 'otp-verify-login':
                limitNavigationUsingLinks();
                break;
            default:
                break;
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{GOOGLE_MAPS_API_KEY}}&libraries=places&callback=onGoogleLoad" async defer></script>

<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>

<script src="https://unpkg.com/select-pure@latest/dist/bundle.min.js"></script>

