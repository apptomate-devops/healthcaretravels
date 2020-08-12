<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Snazzy Info Window</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet">
    <link rel="stylesheet" href="https://rawgit.com/atmist/snazzy-info-window/master/examples/complex-styles/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWoWfqptSqcHj_tAT3khy2jjj7fuANNaM&v=3"></script>
    <script src="https://rawgit.com/atmist/snazzy-info-window/master/dist/snazzy-info-window.min.js"></script>
    <script type="text/javascript">
        $(function() {
            // Snazzy Map Style - https://snazzymaps.com/style/8097/wy
            var mapStyle = [{'featureType': 'all', 'elementType': 'geometry.fill', 'stylers': [{'weight': '2.00'}]}, {'featureType': 'all', 'elementType': 'geometry.stroke', 'stylers': [{'color': '#9c9c9c'}]}, {'featureType': 'all', 'elementType': 'labels.text', 'stylers': [{'visibility': 'on'}]}, {'featureType': 'landscape', 'elementType': 'all', 'stylers': [{'color': '#f2f2f2'}]}, {'featureType': 'landscape', 'elementType': 'geometry.fill', 'stylers': [{'color': '#ffffff'}]}, {'featureType': 'landscape.man_made', 'elementType': 'geometry.fill', 'stylers': [{'color': '#ffffff'}]}, {'featureType': 'poi', 'elementType': 'all', 'stylers': [{'visibility': 'off'}]}, {'featureType': 'road', 'elementType': 'all', 'stylers': [{'saturation': -100}, {'lightness': 45}]}, {'featureType': 'road', 'elementType': 'geometry.fill', 'stylers': [{'color': '#eeeeee'}]}, {'featureType': 'road', 'elementType': 'labels.text.fill', 'stylers': [{'color': '#7b7b7b'}]}, {'featureType': 'road', 'elementType': 'labels.text.stroke', 'stylers': [{'color': '#ffffff'}]}, {'featureType': 'road.highway', 'elementType': 'all', 'stylers': [{'visibility': 'simplified'}]}, {'featureType': 'road.arterial', 'elementType': 'labels.icon', 'stylers': [{'visibility': 'off'}]}, {'featureType': 'transit', 'elementType': 'all', 'stylers': [{'visibility': 'off'}]}, {'featureType': 'water', 'elementType': 'all', 'stylers': [{'color': '#46bcec'}, {'visibility': 'on'}]}, {'featureType': 'water', 'elementType': 'geometry.fill', 'stylers': [{'color': '#c8d7d4'}]}, {'featureType': 'water', 'elementType': 'labels.text.fill', 'stylers': [{'color': '#070707'}]}, {'featureType': 'water', 'elementType': 'labels.text.stroke', 'stylers': [{'color': '#ffffff'}]}];

            // Create the map
            var map = new google.maps.Map($('.map-canvas')[0], {
                zoom: 14,
                styles: mapStyle,
                center: new google.maps.LatLng({{$results[0]['lat']}},{{$results[0]['lng']}})
            });

            // Add a custom marker
            var markerIcon = {
                path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
                fillColor: '#e25a00',
                fillOpacity: 0.95,
                scale: 3,
                strokeColor: '#fff',
                strokeWeight: 3,
                anchor: new google.maps.Point(12, 24)
            };

            var features = [
                    @foreach($results as $result)
                {
                    position: new google.maps.LatLng({{$result['lat']}},{{$result['lng']}}),
                    type: 'test',
                    html_content: '<img src="{{$result['image_url']}}" height="150" width="150" /><p>$ {{$result['price']}} <a href="{{BASE_URL}}property/{{$result['id']}}" style="float: right;"><i class="fa fa-arrow-right"></i></a></p><p>Property_title</p><p>Property_title</p>',
                    html_contents: '',
                },
                @endforeach
            ];

            // Create markers.
            features.forEach(function(feature) {
                var marker = new google.maps.Marker({
                    map: map,
                    icon: markerIcon,
                    position: feature.position
                });

                // Set up handle bars
                var template = Handlebars.compile($('#marker-content-template').html());

                // Set up a close delay for CSS animations
                var info = null;
                var closeDelayed = false;
                var closeDelayHandler = function() {
                    $(info.getWrapper()).removeClass('active');
                    setTimeout(function() {
                        closeDelayed = true;
                        info.close();
                    }, 300);
                };
                // Add a Snazzy Info Window to the marker
                info = new SnazzyInfoWindow({
                    marker: marker,
                    wrapperClass: 'custom-window',
                    offset: {
                        top: '-72px'
                    },
                    edgeOffset: {
                        top: 50,
                        right: 60,
                        bottom: 50
                    },
                    border: false,
                    closeButtonMarkup: '<button type="button" class="custom-close">&#215;</button>',
                    content: template({
                        title: 'Complex Styles',
                        subtitle: 'For Snazzy Info Windows',
                        bgImg: 'https://images.unsplash.com/42/U7Fc1sy5SCUDIu4tlJY3_NY_by_PhilippHenzler_philmotion.de.jpg?dpr=1&auto=format&fit=crop&w=800&h=350&q=80&cs=tinysrgb&crop='
                    }),
                    callbacks: {
                        open: function() {
                            $(this.getWrapper()).addClass('open');
                        },
                        afterOpen: function() {
                            var wrapper = $(this.getWrapper());
                            wrapper.addClass('active');
                            wrapper.find('.custom-close').on('click', closeDelayHandler);
                        },
                        beforeClose: function() {
                            if (!closeDelayed) {
                                closeDelayHandler();
                                return false;
                            }
                            return true;
                        },
                        afterClose: function() {
                            var wrapper = $(this.getWrapper());
                            wrapper.find('.custom-close').off();
                            wrapper.removeClass('open');
                            closeDelayed = false;
                        }
                    }
                });
            });
        });



    </script>
    <script id="marker-content-template" type="text/x-handlebars-template">
        <div class="custom-img" style="background-image: tst.jpg"></div>

        <section class="custom-content">
            <h1 class="custom-header">
                title
                <small>subtitle</small>
            </h1>
            <div class="custom-body">body</div>
        </section>

    </script>
</head>
<body>
<div class="map-canvas">
</div>
</body>
</html>