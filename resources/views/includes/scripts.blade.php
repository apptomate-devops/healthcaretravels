<script type="text/javascript" src="{{URL::asset('scripts/chosen.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/magnific-popup.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/owl.carousel.min.js') }}"></script>
{{--<script type="text/javascript" src="{{URL::asset('scripts/rangeSlider.js') }}"></script>--}}
<script type="text/javascript" src="{{URL::asset('scripts/sticky-kit.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/slick.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/mmenu.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/tooltips.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/masonry.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('scripts/custom.js') }}"></script>
{{--<script type="text/javascript" src="{{URL::asset('js/bootstrap-datepicker.min.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{URL::asset('js/caleran.min.js') }}"></script>--}}
<script type="text/javascript" src="{{URL::asset('scripts/my-library.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>
{{--Masked Inputs--}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.60/inputmask/jquery.inputmask.js"></script>

{{-- Date Range Picker--}}
<script type="text/javascript" src="{{URL::asset('js/date-range-picker.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/date-range-picker.css')}}" />

<!-- DropZone | Documentation: http://dropzonejs.com -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

{{--<script type="text/javascript" src="{{URL::asset('scripts/dropzone.js') }}"></script>--}}
<script type="text/javascript" src="{{URL::asset('scripts/common.js') }}"></script>

<script>
    Dropzone.autoDiscover = false;
    $(".dropzone:not(.property-calender)").dropzone({
        dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here to upload",
        uploadMultiple: true,
        autoProcessQueue: false,
        // maxFiles: 20,
        maxFilesize: 10,
        dictFileTooBig: 'File is too big. Please select image with minimum size of 10MB.',
        parallelUploads: 20,
        acceptedFiles: ".jpg, .jpeg, .png",
        addRemoveLinks: true,
        dictInvalidFileType: "Invalid File Type",
        dictMaxFilesExceeded: "Only 20 files are allowed",
        init: function () {
            var fileDropzone = this;

            var maximumImages = 20 - $('.dz-default.dz-message').attr("data-property-images-count");
            if(maximumImages <= 0) {
                $(".dz-hidden-input").prop("disabled",true);
                $(".dz-default.dz-message").html('You have already uploaded the maximum number of images');
            }
            function continue_upload() {
                fileDropzone.options.autoProcessQueue = true;
                fileDropzone.processQueue();
            };

            this.on("addedfiles", function (files) {
                $('#propertyImageSubmit').prop("disabled",true);
                setTimeout(function (e) {
                    var invalidImages = fileDropzone.getFilesWithStatus('error');
                    if(invalidImages.length) {
                        console.log('invalid images', invalidImages.length);
                    }
                    // Remove extra images
                    if(files.length > maximumImages) {
                        for (var x = 0; x < files.length; x++) {
                            if(x >= maximumImages) {
                                fileDropzone.removeFile(files[x])
                            }
                        }
                    }
                    continue_upload();
                }, 300);
            });

            this.on("successmultiple", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                   window.location.reload();
                }
            });

            this.on("thumbnail", function(file) {
                if (file.width < 1024 || file.height < 524) {
                    file.rejectDimensions();
                } else {
                    file.acceptDimensions();
                }
            });
        },
        accept: function(file, done) {
            file.acceptDimensions = done;
            file.rejectDimensions = function() { done("File is too small. Please select image with minimum resolution of 1024 x 524"); };
        },
    });
    $(".property-calender.dropzone").dropzone({
        dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here to upload",
        autoProcessQueue: false,
        acceptedFiles: ".ics",
        addRemoveLinks: true,
        dictInvalidFileType: "Invalid File Type",
        init: function () {
            var fileDropzone = this;

            $("#upload_ical").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (fileDropzone.files.length) {
                    $('#calenderLoadingProgress').show();
                    $('.calender-upload-alerts .alert').hide();
                    var form = $('#upload_ical_form')[0]; // You need to use standard javascript object here
                    var formData = new FormData(form);
                    for (var x = 0; x < fileDropzone.files.length; x++) {
                        formData.append("calender_files[]", fileDropzone.files[x]);
                    }
                    $.ajax({
                        url: '/owner/upload-calender',
                        data: formData,
                        type: 'POST',
                        contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                        processData: false, // NEEDED, DON'T OMIT THIS
                        success: function(response, textStatus, jqXHR) {
                            if(response && response.success) {
                                // Show success Message
                                $('.calender-upload-alerts .alert-success').show();
                                window.location.reload();
                            } else {
                                // Show error Message
                                $('.calender-upload-alerts .alert-danger').show();
                                $('.calender-upload-alerts .alert-danger').text(response.message);
                                console.log('Error while uploading calender details');
                            }
                            $('#calenderLoadingProgress').hide();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Show error Message
                            $('#calenderLoadingProgress').hide();
                            $('.calender-upload-alerts .alert-danger').show();
                            $('.calender-upload-alerts .alert-danger').text(textStatus);
                            console.log('Error while uploading calender details');
                        }
                    });
                } else {
                    alert('Please select a valid file');
                }
            });
            this.on("addedfiles", function(file) {
                $('#upload_ical').attr('disabled',false);
            });
            this.on("success", function(file) {
                // submit form
                $('#calenderLoadingProgress').hide();
                $("#upload_ical_form").submit();
            });
            this.on("error", function (file, response) {
                $('#calenderLoadingProgress').hide();
                console.log('error uploading calender file', response);
            });
        },
        accept: function(file, done) {
            file.acceptDimensions = done;
            file.rejectDimensions = function() { done("Please select a calender file"); };
        }
    });
</script>

<script>
    $('input[id="dob"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        maxDate: new Date(),
        opens: 'center',
        autoUpdateInput: false,
        autoApply: true,
    }, function(start) {
        $('input[id="dob"]').val(moment(start).format('MM/DD/YYYY'));
        let today = new Date();
        let birthDate = new Date(start);
        let age = today.getFullYear() - birthDate.getFullYear();
        let m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        if (age < 18 || age > 100) {
            $('#dob_validation_error').html('You must be 18 or older to register online. Contact <br>???<a href="mailto:info@healthcaretravels.com">info@healthcaretravels.com</a> to create a minor account.')
        } else {
            $('#dob_validation_error').html('');
        }
    });
</script>

@include('includes.mask')
<style type="text/css">
    .uploading {
        color: #ffffff;
        background-color: #e78016;
        border-color: #ffffff;
    }
</style>


{{--facebook login scripts--}}


<script>
    // function lsTest() {
    //     var test = 'test';
    //     try {
    //         localStorage.setItem(test, test);
    //         localStorage.removeItem(test);
    //         return true;
    //     } catch (e) {
    //         return false;
    //     }
    // }
    //
    // // listen to storage event
    // window.addEventListener('storage', function (event) {
    //     // do what you want on logout-event
    //     if (event.key == 'logout-event') {
    //         //alert('Received logout event! Insert logout script here.');
    //         window.location = window.location.protocol + "//" + window.location.host;
    //     }
    // }, false);
    //
    // $(document).ready(function () {
    //     if (lsTest()) {
    //         $('#logout').on('click', function () {
    //             // change logout-event and therefore send an event
    //             localStorage.setItem('logout-event', 'logout' + Math.random());
    //             return true;
    //         });
    //     } else {
    //         // setInterval or setTimeout
    //     }
    //
    //     var searchSelect = $('.search-container select, .search_container select');
    //     searchSelect.each(function (e) {
    //         if(!$(this).val()) {
    //             searchSelect.addClass('has-placeholder');
    //         }
    //     })
    //     searchSelect.change(function() {
    //         $(this).removeClass('has-placeholder');
    //     });
    // });

    // function signOut() {
    //     //alert("logout");
    //     window.localStorage.setItem('logged_in', false)
    //     // FB.logout(function(response) {
    //     //     // Person is now logged out
    //     //     console.log('User signed out.'+response);
    //
    //     // });
    //     // var auth2 = gapi.auth2.getAuthInstance();
    //     // auth2.signOut().then(function () {
    //     //     console.log('User signed out.');
    //
    //     // });
    //
    //     // FB.logout(function(response) {
    //     //     // Person is now logged out
    //     //     console.log('User signed out.'+response);
    //
    //
    //     // });
    //
    // }


    function initMap() {
        @if(Request::path()=='owner/add-property')
        dragMap();
            @endif

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
            content: '<div class="contact_map" style="top: 55px;margin-bottom: 8px;"><center><h2 style="color:orange">Health Care Travels</h2><h4> 7075 FM 1960 Rd West STE 1010,</h4><h4>Houston, Texas 77069, </h4><h4> United States</h4><center></div>'
        });

        var uluru = {lat: latitude, lng: longitude};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map,
            icon: '/storage/public/marker-blue.png',
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
        @if(Request::path()=='properties' && !empty($properties))
    var markers = [
                @foreach($properties as $propmap)
            {
                property_details: '<div style="background: white;width: 405px;padding-left: 2px;padding-bottom: 5px;    border-radius: 10px;"><div>@if(isset($propmap->image_url) != "")<img src="{{$propmap->image_url}}" style="width: 400px;">@endif<p style="font-size: 30px;font-weight: 600;margin-top: -45px;background-color: rgba(74,74,76,0.7);position: absolute;width: 400px;color: white;height: 45px;padding-left: 20px;width: 400px;">$ {{$propmap->monthly_rate}}</p></div><div><h4 style="font-size: 22px;font-weight: bold;padding-left: 5px;">{{$propmap->title}}</h4></div><div><p style="font-size: 15px;font-weight: 600;width: 400px;padding-left: 5px;"><i class="fa fa-map-marker"></i><?php
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
    var mapMarkers = [];
    var mapMarkers1 = [];
        @if(Request::path()=='properties')
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
                icon: '/storage/public/marker-blue.png',
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
        apiKey: "AIzaSyAp8NYnsYWc_E_78Ou4yXHDH4PasZuYs58",
        authDomain: "health-care-travels.firebaseapp.com",
        databaseURL: "https://health-care-travels.firebaseio.com",
        projectId: "health-care-travels",
        storageBucket: "health-care-travels.appspot.com",
        messagingSenderId: "420688223951",
        appId: "1:420688223951:web:5518320dc1d350fe1fe1ba"
    };
    firebase.initializeApp(config);

    // Create a Firebase reference where GeoFire will store its information
    var db = firebase.database();
    var firebaseRef = db.ref();
    var hasUnreadMessage = {{Session::get('has_unread_message')}};
    if(hasUnreadMessage) {
        $('#unread_chat_badge').show();
        $('#unread_chat_badge_inbox').show();
    }

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
        // gapi.load('auth2', function () {
        //     gapi.auth2.init({client_id: "420688223951-frk2eoqelgts1eqetnopugscuqsgkui7.apps.googleusercontent.com" });
        // });
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
    function getLastSagmentOfURL(url) {
        return url.substring(url.lastIndexOf('/') + 1);
    }
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
            case 'rental_analysis':
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
            case 'properties':
                initMaps();
                initSearchPropertySearchInput();
                break;
            case 'otp-verify-register':
            case 'otp-verify-login':
                setTimeout(() => {
                    window.location.href = "/login";
                    // Redirecting user to login screen after 5 mins
                }, 5 * 1000 * 60);
                break;
            default:
                break;
        }
    }
    $('.panel-collapse').on('show.bs.collapse', function () {
        $(this).siblings('.panel-heading').addClass('active');
    });
    $('.panel-collapse').on('hide.bs.collapse', function () {
        $(this).siblings('.panel-heading').removeClass('active');
    });
    $('img.user-icon').error(function (event) {
        event.target.src = '/user_profile_default.png';
    });
    $(document).ready(function() {
        $('img.user-icon').each(function(img) {
            var src = $(this).attr('src');
            if (!src || src == ' ' || src == '0') {
                $(this).attr('src', '/user_profile_default.png');
            }
        });

        $.getIconNode = function (classname, value, name) {
            var element = document.createElement('i');
            var classReaplce = classname.replace('.', '');
            element.className = classReaplce + ' chosen-icon-item';
            element.dataset.value = value;
            element.dataset.name = name;
            return element;
        }

        $.fn.chosenIcon = function (options) {
            return this.each(function () {
                var $select = $(this);
                var iconMap = {};
                var valueMap = {};
                var nameMap = {};

                // Retrieve icon class from data attribute and build object for each list item
                $select.find('option').filter(function () {
                    return $(this).text();
                }).each(function (i) {
                    var node = $(this);
                    var iconSrc = node.attr('data-icon');
                    iconMap[i] = $.trim(iconSrc);
                    valueMap[i] = node.val();
                    nameMap[i] = node.text();
                });
                // Execute chosen plugin and add our custom class
                $select.chosen(options);
                $chosen = $select.next().addClass('chosenIcon-container');

                // Add icon node in list item with source value
                $select.on('chosen:showing_dropdown chosen:activate', function () {
                    setTimeout(function () {
                        $chosen.find('.chosen-results li').each(function (i) {
                            var iconClassName = iconMap[i];
                            if (iconClassName) {
                                var iconNode = $.getIconNode(iconClassName, valueMap[i], nameMap[i]);
                                $(this).append(iconNode);
                            }
                        });
                    }, 0);
                });
                $select.trigger('change');
            });
        }
        $('.chosen-icon-no-single').chosenIcon({
            disable_search_threshold: 10,
            parser_config: { copy_data_attributes: true }
        });;
    }) ;
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{GOOGLE_MAPS_API_KEY}}&libraries=places&callback=onGoogleLoad" async defer></script>

<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>

<script src="https://unpkg.com/select-pure@latest/dist/bundle.min.js"></script>

