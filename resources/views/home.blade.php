<!DOCTYPE html>
<head>
    <!-- Basic Page Needs
      ================================================== -->
    <title>{{APP_BASE_NAME}} | Home Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- CSS
      ================================================== -->
    @include('includes.styles')

    <style>

        .sec1 h3.headline-box {
            transform: translate3d(-50%, 6%, 0) !important;
        }

        .sec1 .container {
            margin-top: 20px;
        }

        section.fullwidth.sec2 {
            background-color: white;
        }

        .headline-box {
            color: #ff5573;
        }

        .im {
            color: #e78016;
        }

        .sec1 .icon-container {
            background-color: #f7f7f7;
            border: 2px solid #e78016;
        }

        .sec1 .icon-box-1 .icon-container .icon-links a {
            color: #ff556a;
        }

        .home-h3 {
            font-size: 29px;
            text-align: center;
            font-weight: bolder;
        }

        /* Testimonial Start  */

        .testimonials {
            overflow: hidden;
            position: relative;
            max-height: 300px;
        }

        .testimonials {
            background: #161d25;
        }

        .one-slide,
        .testimonial,
        .message {
            border: none !important;
            outline: none !important;
        }

        .icon-overlay {
            position: absolute;
            opacity: 0.3;
            right: 10%;
            top: 0;
            height: auto;
            width: 100%;
            max-width: 400px;
        }

        .carousel-controls .control {
            position: absolute;
            transform: translateY(-50%);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid #fff;
            z-index: 1;
        }

        .prev {
            left: -2.25rem;
        }

        .next {
            right: -2.25rem;
        }

        @media screen and (max-width: 768px) {
            .testimonials {
                max-height: 700px;
            }

            .icon-overlay {
                height: 300px;
                top: calc(50% - 150px);
            }

            .carousel-controls .control {
                width: 25px;
                height: 25px;
                top: inherit;
            }

            .prev {
                left: 0;
            }

            .next {
                right: 0;
            }

            .control i {
                font-size: .7rem;
            }

            .testimonials .message {
                font-size: 1rem;
            }

            .testimonials h2 {
                font-size: 1.5rem;
            }
        }

        /* Custome testimonial */
        .testimonials {
            background: #f7f7f7;
            padding-bottom: 450px;
        }

        .carousel-controls .control {
            margin-top: 170px;
            border-color: #ff556a;
        }

        .testimonials .next {
            right: 2.20rem;
        }

        .testimonials .prev {
            margin-left: 40px;
        }

        .testimonials i.fa.fa-chevron-left {
            margin-top: 10px;
            margin-left: 9px;
        }

        .testimonials i.fa.fa-chevron-right {
            margin-top: 10px;
            margin-left: 10px;
        }

        .carousel-controls .control {
            width: 35px;
            height: 35px;
        }

        .testimonials .message {
            line-height: 30px;
            font-size: 20px;
            color: #888;
        }

        .testimonials .blockquote-footer {
            line-height: 30px;
            font-size: 20px;
            color: #ff556a;
            font-weight: bolder;
        }

        .testimonials img {
            border-radius: 50%;
            width: 100px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 30px;
        }

        /* Testimonial End*/
        @media screen and (min-width: 1200px) {
            .home-slide {
                height: 595px;
            }
        }


        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 150; /* Sit on top */
            padding-top: 250px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            padding-left: 450px; /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            position: fixed;
            background-color: #fefefe;
            margin: auto;
            padding: 20px;

            width: 30%;
            -webkit-animation-name: slideIn;
            -webkit-animation-duration: 0.4s;
            animation-name: slideIn;
            animation-duration: 0.4s
        }

        /* The Close Button */
        .close {
            color: #000;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: red;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header {
            padding: 2px 16px;

            color: black;
            font-weight: bold;
        }

        .modal-body {
            padding: 2px 16px;
        }

        .modal-footer {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
        }

        /* Add Animation */
        @-webkit-keyframes slideIn {
            from {
                bottom: -300px;
                opacity: 0
            }
            to {
                bottom: 0;
                opacity: 1
            }
        }

        @keyframes slideIn {
            from {
                bottom: -300px;
                opacity: 0
            }
            to {
                bottom: 0;
                opacity: 1
            }
        }

        @-webkit-keyframes fadeIn {
            from {
                opacity: 0
            }
            to {
                opacity: 1
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0
            }
            to {
                opacity: 1
            }
        }

    </style>

</head>
<body>
<!-- Wrapper -->
<div id="wrapper">
    <!-- Header Container
      ================================================== -->
    @include('includes.header')


    <div class="clearfix"></div>
    <!-- Header Container / End -->
    <!-- Banner data-background="/home.jpg"
      ================================================== -->

    <div class="parallax home-slide" data-background="/background.jpg" data-color="#36383e" data-color-opacity="0.5"
         data-img-width="2500" data-img-height="1600">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-container">
                        <!-- Form -->
                        <h2 style="font-family: sans-serif;">Find New Home </h2>
                        <!-- Row With Forms -->
                        <div class="row with-forms">

                            <form name="test" action="{{url('/')}}/search-property" method="post">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="row">
                                    <!-- Main Search Input  -->
                                    <div class="col-md-4 col-sm-6 col-xs-12" style="margin-top: 10px;">
                                        <div class="main-search-input">
                                            <input type="text" required id="search-address-input" name="formatted_address"
                                                placeholder="Enter address e.g. street, city or state" value=""/>
                                            <input class="field" type="hidden" id="street_number" name="street_number" value="{{Session::get('street_number')}}" />
                                            <input class="field" type="hidden" id="route" name="route" value="{{Session::get('route')}}" />
                                            <input class="field" type="hidden" id="locality" name="city" value="{{Session::get('city')}}" />
                                            <input class="field" type="hidden" id="administrative_area_level_1" name="state" value="{{Session::get('state')}}" />
                                            <input class="field" type="hidden" id="postal_code" name="pin_code" value="{{Session::get('pin_code')}}" />
                                            <input class="field" type="hidden" id="country" name="country" value="{{Session::get('country')}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6 col-xs-6" style="margin-top: 10px;">
                                        <div class="main-search-input">
                                            <input type="number" name="distance"
                                                placeholder="Distance" data-unit="Mi" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6 col-xs-6" style="margin-top: 10px;">
                                        <div class="main-search-input">
                                            <input type="text" name="from_date" placeholder="Check in" value=""
                                                id="from_date" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6 col-xs-6" style="margin-top: 10px;">
                                        <div class="main-search-input">
                                            <input name="to_date" type="text" onchange="check_to_date();"
                                                placeholder="Check out" value="" id="to_date" autocomplete="off"/s>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="search_location"></div>
                                    <div class="col-md-2 col-sm-6 col-xs-6" style="margin-top: 10px;">
                                        <select name="property_type" required data-placeholder="Any Status"
                                                class="chosen-select-no-single">
                                            <option value="" selected disabled>Property Type</option>
                                            <option value="1">Short Term Rental</option>
                                            <option value="2">Long Term Rental</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-6 col-xs-6" style="margin-top: 10px;">
                                        <select name="home_type" required data-placeholder="Any Status"
                                                class="chosen-select-no-single">
                                            <option value="" selected disabled>Home Type</option>
                                            @foreach($room_types as $pro)
                                                <option
                                                    value="{{$pro->name}}"
                                                    @if(isset($request_data['roomtype']) && $request_data['roomtype'] == $pro->name)  selected @endif
                                                >
                                                        {{$pro->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-xs-12" style="margin-top: 10px;">
                                        <button class="button" id="button" style="height: 58px;width: 150px;" type="submit">
                                            <i class="fa fa-search">&nbsp;SEARCH</i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <!-- Row With Forms / End -->
                        <!-- Browse Jobs -->
                        <div class="adv-search-btn">
                            {{-- Need more search options? <a href="listings-list-full-width.html">Advanced Search</a> --}}
                        </div>
                        <!-- Announce -->
                        <div class="announce">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content
      ================================================== -->

    <!-- How it Work Start
    <section class="fullwidth margin-top-2 sec1" data-background-color="#f7f7f7" style="background: rgb(247, 247, 247);">

  <!-- Box Headline
  <h3 class="home-h3">What are you looking for?</h3>

  <!-- Content
  <div class="container">
    <div class="row">

      <div class="col-md-4 col-sm-4">
        <!-- Icon Box
        <div class="icon-box-1">

          <div class="icon-container">
            <i class="im im-icon-Office"></i>
            <div class="icon-links">
              <div style="color: #ff556a;">For Sale</div>
              <div style="color: #ff556a;">For Rent</div>
            </div>
          </div>

          <h3>Apartments</h3>
          <p>Without any further customization you can right away start your Boat rental business effectively. With all the features from Airbnb along with the customized features for car rental business, it’s the right script for you to start business.</p>
        </div>
      </div>

      <div class="col-md-4 col-sm-4">
        <!-- Icon Box
        <div class="icon-box-1">

          <div class="icon-container">
            <i class="im im-icon-Home-2"></i>
            <div class="icon-links">
              <div style="color: #ff556a;">For Sale</div>
              <div style="color: #ff556a;">For Rent</div>
            </div>
          </div>

          <h3>Houses</h3>
          <p>Without any further customization you can right away start your house rental business effectively. With all the features from Airbnb along with the customized features for car rental business, it’s the right script for you to start business.</p>
        </div>
      </div>

      <div class="col-md-4 col-sm-4">
        <!-- Icon Box --
        <div class="icon-box-1">

          <div class="icon-container">
            <i class="im im-icon-Car-3"></i>
            <div class="icon-links">
              <div style="color: #ff556a;">For Sale</div>
              <div style="color: #ff556a;">For Rent</div>
            </div>
          </div>

          <h3>Car Rental</h3>
          <p>Without any further customization you can right away start your car rental business effectively. With all the features from Airbnb along with the customized features for car rental business, it’s the right script for you to start business.</p>
        </div>
      </div>



    </div>
  </div>
</section>
    <!-- How it Work  / End -->

    <!-- Featured -->
    <section class="fullwidth sec2">
        <h3 class="home-h3" style="margin-top: -100px;">Latest Listings</h3>
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <!-- <h3 class="headline margin-bottom-25 margin-top-65" style="text-align:center">Latest Listings</h3> -->
                </div>
                <!-- Carousel -->
                <div class="col-md-12">
                    <div class="carousel">

                    @foreach($latest_properties as $property)

                        <!-- Listing Item -->
                            <div class="carousel-item">
                                <div class="listing-item compact">
                                    <a href="{{url('/')}}/property/{{$property->property_id}}"
                                       class="listing-img-container">
                                        <div class="listing-badges">
                                            <span class="featured">Latest</span>

                                        </div>
                                        <div class="listing-img-content">

                                            @if($property->is_favourite == 0)
                                                <span onclick="favourite({{$property->property_id}});"
                                                      class="like-icon with-tip"
                                                      data-tip-content="Add to Favorites"></span>
                                            @else
                                                <span onclick="favourite({{$property->property_id}});"
                                                      class="like-icon with-tip liked"
                                                      data-tip-content="Remove from Favorites"></span>
                                            @endif

                                            <span class="listing-compact-title">
                    {{$property->title}} <i>${{$property->price_more_than_one_month}}</i></span>
                                            <ul class="listing-hidden-content">
                                                <li>Area <span>{{$property->property_size}} sq ft</span></li>

                                        </div>

                                    </a>
                                </div>
                            </div>
                            <!-- Listing Item / End -->
                        @endforeach


                    </div>
                    <!-- Carousel / End -->
                </div>
                <!-- Carousel -->
                <div class="col-md-12">
                    <div class="carousel">

                    @foreach($latest_properties as $property)
                        {{-- @php print_r($property);exit; @endphp --}}
                        <!-- Listing Item -->
                            <div class="carousel-item">
                                <div class="listing-item">

                                    <a href="{{url('/')}}/property/{{$property->property_id}}"
                                       class="listing-img-container">

                                        @if($property->verified==1)
                                            <div class="listing-badges">
                                                <span class="featured"
                                                      style="background-color: {{$property->verified==1?'green':''}}"> {{$property->verified==1?'Verified':''}}</span>

                                            </div>
                                        @endif

                                        <div class="listing-img-content">
                                            <span
                                                class="listing-price">$ {{$property->price_more_than_one_month}}/Month</i></span>
                                            @if(Session::get('user_id'))
                                                <span @if($property->is_favourite == "0") class="like-icon with-tip"
                                                      @else class="like-icon with-tip liked"
                                                      @endif data-tip-content="Add to Favorites"
                                                      onclick="favourite({{$property->property_id}})"></span>
                                                {{-- <span class="like-icon with-tip" data-tip-content="Add to Favourites" onclick="favourite({{$property->property_id}})"></span> --}}
                                            @endif
                                            <span class="compare-button with-tip"
                                                  data-tip-content="Add to Compare"></span>
                                        </div>

                                        <!-- <div class="listing-carousel"> -->
                                        <div style="max-height: 240px;min-height: 240px;">
                                            <img style="max-height: 240px;min-height: 240px;"
                                                 src="{{$property->image_url}}" alt="">
                                        </div>

                                        <!-- </div> -->

                                    </a>

                                    <div class="listing-content">

                                        <div class="listing-title">
                                            <h4 style="max-height: 70px;min-height: 70px;">
                                                <a href="{{url('/')}}/property/{{$property->property_id}}">{{$property->title}}</a>
                                            </h4>
                                            <a href="{{url('/')}}/property/{{$property->property_id}}"
                                               class="listing-address popup-gmaps">
                                                <i class="fa fa-map-marker"></i>
                                                {{$property->city}},{{$property->state}}


                                            </a>
                                            @if($property->pets_allowed == 1)
                                                <div style="float: right;" title="Pets Allowed">
                                                    <img src="{{BASE_URL}}action_icons/Paw.png"/>
                                                </div>
                                            @endif
                                        </div>


                                        <ul class="listing-features">
                                            <li>Area <span>{{$property->property_size}} sq ft</span></li>
                                            <li>Bedrooms <span>{{$property->bedroom_count}}</span></li>
                                            <li>Bathrooms <span>{{$property->bathroom_count}}</span></li>
                                        </ul>

                                        <div class="listing-footer">
                                            <a href="{{url('/')}}/owner-profile/{{$property->owner_id}}"><i
                                                    class="fa fa-user"></i> {{$property->first_name}} {{$property->last_name}}
                                            </a>
                                            {{-- <span><i class="fa fa-calendar-o"></i> 1 day ago</span> --}}
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!-- Listing Item / End -->
                        @endforeach


                    </div>
                </div>
                <!-- Carousel / End -->
            </div>
        </div>
    </section>
    <!-- Featured / End -->

    <section>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="headline centered margin-bottom-35 home-h3" style="margin-top: -100px;">Featured Places
                        <span>Search for your next short-term housing by City and State</span></h3>
                </div>


                <?php $i = 0; ?>
                @foreach($categories as $category)
                    @if($i==0 || $i==7 || $i==8 || $i==12)
                        <div class="col-md-4"> @endif
                            @if($i==1 || $i==6 || $i==9 || $i==13)
                                <div class="col-md-4"> @endif
                                    @if($i==2 || $i==5 || $i==10 || $i==14)
                                        <div class="col-md-4"> @endif
                                            @if($i==3 || $i==4 || $i==11 || $i==15)
                                                <div class="col-md-8"> @endif
                                                @if($i < count($categories))
                                                    <!-- Image Box -->
                                                        <a href="{{url('/')}}/search-property?place={{$category->title}}"
                                                           class="img-box"
                                                           @if($i==0 || $i==4 || $i==11 || $i==15 || $i==5) style="height: 525px;"
                                                           @endif @if($i==3 || $i==7 || $i==8 ||$i==12) style="height: 250px;"
                                                           @endif data-background-image="{{$category->image_url}}">
                                                            <!-- Badge -->
                                                            <div class="listing-badges">
                                                                <span class="featured">Featured</span>
                                                            </div>
                                                            <div class="img-box-content visible">
                                                                <h4>{{$category->title}} </h4>
                                                                {{--<span>14 Properties</span>--}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                </div>
                                                <?php $i++; ?>
                                                @endforeach


                                        </div>
                                </div>
                        </div>
                        <!-- Container / End -->
    </section>

    <!-- Testimonial Start -->
{{-- <!-- <section class="testimonials py-5 text-white px-1 px-md-5 margin-top-xl">
<!-- <img src="https://raw.githubusercontent.com/solodev/testimonial-slider-fullwidth/master/solodev-logo-stacked.png" class="icon-overlay" /> -->
<div class="container">
<div class="row">
<div class="col-sm-12">
<h2 class="home-h3">Our Customers Are Seeing Big Results</h2>

<div class="carousel-controls testimonial-carousel-controls">
  <div class="control d-flex align-items-center justify-content-center prev mt-3"><i class="fa fa-chevron-left"></i></div>
  <div class="control d-flex align-items-center justify-content-center next mt-3"><i class="fa fa-chevron-right"></i></div>

  <div class="testimonial-carousel">
    <div class="h5 font-weight-normal one-slide mx-auto">
      <div class="testimonial w-100 px-3 text-center d-flex flex-direction-column justify-content-center flex-wrap align-items-center">
        <img src="{{url('/')}}/public/default-user-image.png">
        <div class="message text-center blockquote w-100">"They’ve been consistent throughout the years and grown together with us. Even as they’ve grown, they haven’t lost sight of what they do. Most of their key resources are still with them, which is also a testament to their organization."</div>
        <div class="blockquote-footer w-100 text-white">Ted, WebCorpCo</div>
      </div>
    </div>
    <div class="h5 font-weight-normal one-slide mx-auto">

      <div class="testimonial w-100 px-3 text-center  d-flex flex-direction-column justify-content-center flex-wrap align-items-center">
        <img src="{{url('/')}}/public/default-user-image.png">
        <div class="message text-center blockquote w-100">"Our website uses Solodev to craft a website capable of representing its diverse residents. The website features a newsroom with the latest events, an interactive calendar, and a mobile app that puts the resources at a user’s fingertips."</div>
        <div class="blockquote-footer w-100 text-white">Jim Joe, WebCorpCo</div>
      </div>
    </div>
    <div class="h5 font-weight-normal one-slide mx-auto">

      <div class="testimonial w-100 px-3 text-center  d-flex flex-direction-column justify-content-center flex-wrap align-items-center">
        <img src="{{url('/')}}/public/default-user-image.png">
        <div class="message text-center blockquote w-100">Our website uses Solodev to craft a website capable of representing its diverse residents. The website features a newsroom with the latest events, an interactive calendar, and a mobile app that puts the resources at a user’s fingertips.</div>
        <div class="blockquote-footer w-100 text-white">Jim Joe, WebCorpCo</div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
</section> --> --}}
<!-- Testimonial End -->
    <!-- Footer
      ================================================== -->
</div>
@include('includes.footer')
<!-- Footer / End -->
<!-- Back To Top Button -->


<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h4>Subscribe for New Updates</h4>


        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">

                    <form action="" method="" name="subscribe">
                        <div class="form-row">
                            <input type="text" placeholder="Email Address" class="form-control" name="email_subscribe"
                                   id="email_subscribe">
                            <button class="form-control btn-small btn-primary" name="subscribe" id="subscribe">
                                Subscribe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


</div>


<div id="backtotop"><a href="#"></a></div>
<!-- Scripts
  ================================================== -->
@include('includes.scripts')


</div>
<!-- Wrapper / End -->

<script type="text/javascript">
    $(function () {
        var dateFormat = "mm/dd/yy";
        var date_today = new Date();
        var date_today_next_month = new Date();
        date_today_next_month.setMonth(date_today_next_month.getMonth() + 1);
        var fromOptions = {
            startDate: date_today,
            changeMonth: true,
        };
        var toOptions = {
            startDate: date_today_next_month,
            changeMonth: true,
        };
        var from = $("#from_date")
                .datepicker(fromOptions)
                .on("change", function () {
                    var selectedDate = getDate(this);
                    if (selectedDate) {
                        selectedDate.setMonth(selectedDate.getMonth() + 1);
                        toOptions.startDate = selectedDate;
                        toOptions.minDate = selectedDate;
                        to.datepicker("destroy");
                        to.datepicker(toOptions);
                    }
                });
        var to = $("#to_date").datepicker(toOptions)
                .on("change", function () {
                    var selectedDate = getDate(this);
                });

        function getDate(element) {
            var date;
            try {
                date = new Date(element.value);
            } catch (error) {
                date = null;
            }
            return date;
        }
    });

    function check_to_date() {
        var to_date = $('#to_date').val();
        from_date = $('#from_date').val();
        if (to_date && from_date > to_date) {
            alert("Please choose date after " + from_date);
            $('#to_date').val("");
            return false;
        }
    }

    function set_favourite(property_id) {
        console.log("Set favourite clicked with id :-" + property_id);
        return false;
    }

    function get_current_location() {
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(showPosition);
        } else {
            var HTML = "Geolocation is not supported by this browser.";
            alert(HTML);
        }

    }

    function showPosition(position) {
        var HTML = "Latitude: " + position.coords.latitude +
            "<br>Longitude: " + position.coords.longitude;
        alert(HTML);
    }

    function favourite(id) {
        var url = 'property/set-favourite/' + id;
        $.ajax({
            "type": "get",
            "url": url,
            success: function (data) {
                console.log("Set favourite success ====:" + data);
                location.reload();
            }
        });
    }

</script>
<script>
    $(document).ready(function () {
        // $(".testimonial-carousel").slick({
        //   infinite: true,
        //   slidesToShow: 1,
        //   slidesToScroll: 1,
        //   autoplay: false,
        //   arrows: true,
        //   prevArrow: $(".testimonial-carousel-controls .prev"),
        //   nextArrow: $(".testimonial-carousel-controls .next")
        // });
        $(".owl-buttons:first").hide();
    });
    function initHomeSearchInput() {
        var componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'long_name',
            administrative_area_level_1: 'short_name',
            country: 'long_name',
            postal_code: 'short_name'
        };
        var addressOptions = {
            componentRestrictions: {country: 'us'}
        };
        try {
            var element_address = document.getElementById('search-address-input');
            if(element_address) {
                google.maps.event.addDomListener(element_address, 'keypress', (event) => {
                    if (event.keyCode === 13) {
                        event.preventDefault();
                    }
                });
                var autocomplete_address = new google.maps.places.Autocomplete(element_address, addressOptions);
                autocomplete_address.addListener('place_changed', (e) => {
                    if(element_address.name === 'formatted_address') {
                        var place = autocomplete_address.getPlace();
                        for (var i = 0; i < place.address_components.length; i++) {
                            var addressType = place.address_components[i].types[0];
                            if (componentForm[addressType]) {
                                var val = place.address_components[i][componentForm[addressType]];
                                document.getElementById(addressType).value = val;
                            }
                        }
                    }
                });
            }
        } catch (e) {
            console.error(e);
        }
    }
</script>


<script>
    // Get the modal
    var modal = document.getElementById('myModal');
    // modal.style.display = "block";


    // Get the button that opens the modal

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal


    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>
