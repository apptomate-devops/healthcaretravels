<!DOCTYPE html>
<head>
    <!-- Basic Page Needs
      ================================================== -->
    <title>Home Page | {{APP_BASE_NAME}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{ URL::asset('css/listing_search.css') }}">
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
            max-height: 530px;
            overflow-y: hidden;
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

        .featured-places img {
            transition: all 0.55s;
            transition: transform 0.35s ease-out;
        }
        .featured-places:hover img {
            transform: scale(1.06);
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


                    *,
            *::before,
            *::after {
            box-sizing: border-box;
            }

            body {
            margin: 0;
            padding: 0;
            background-color: #1C2325;
            color: #eee;
            }

            .outer-wrapper {
            width: 100%;
            margin: 0px auto;
            height: 240px;
            }

            .s-wrap {
            margin-bottom: 50px;
            padding-bottom: 55%;
            position: relative;
            border: 10px solid #fff;
            background-color: #efefe8;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            height: 240px;
            width: auto;
            }
            .s-wrap > input {
            display: none;
            }
            .s-wrap .s-content {
            margin: 0;
            padding: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 500%;
            height: 100%;
            font-size: 0;
            list-style: none;
            transition: transform 1s;
            height: auto;
            margin-top: -8px;
            }
            .s-wrap .s-item {
            display: inline-block;
            width: 20%;
            height: 100%;
            background-repeat: no-repeat;
            background-size: cover;
            }

            .s-type-1 .s-control {
            z-index:100;
            position: absolute;
            bottom: 18px;
            left: 50%;
            text-align: center;
            transform: translateX(-50%);
            transition-timing-function: ease-out;
            }

            .s-type-1 .s-control > label[class^="s-c-"] {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 10px;
            border-radius: 50%;
            border: 1px solid #999;
            background-color: #efefe8;
            cursor: pointer;
            }
            .s-type-1 .s-nav label {
            display: none;
            position: absolute;
            top: 50%;
            padding: 5px 10px;
            transform: translateY(-50%);
            cursor: pointer;
            }
            .s-type-1 .s-nav label::before, .s-type-1 .s-nav label::after {
            content: "";
            display: block;
            width: 8px;
            height: 24px;
            background-color: #fff;
            }
            .s-type-1 .s-nav label::before {
            margin-bottom: -12px;
            }
            .s-type-1 .s-nav label.left {
            left: 20px;
            }
            .s-type-1 .s-nav label.left::before {
            transform: rotate(45deg);
            }
            .s-type-1 .s-nav label.left::after {
            transform: rotate(-45deg);
            }
            .s-type-1 .s-nav label.right {
            right: 20px;
            }
            .s-type-1 .s-nav label.right::before {
            transform: rotate(-45deg);
            }
            .s-type-1 .s-nav label.right::after {
            transform: rotate(45deg);
            }
            .s-type-1 #s-1:checked ~ .s-content {
            transform: translateX(0%);
            }
            .s-type-1 #s-1:checked ~ .s-control .s-c-1 {
            background-color: #333;
            }
            .s-type-1 #s-1:checked ~ .s-nav .s-nav-1 {
            display: block;
            }
            .s-type-1 #s-2:checked ~ .s-content {
            transform: translateX(-20%);
            }
            .s-type-1 #s-2:checked ~ .s-control .s-c-2 {
            background-color: #333;
            }
            .s-type-1 #s-2:checked ~ .s-nav .s-nav-2 {
            display: block;
            }
            .s-type-1 #s-3:checked ~ .s-content {
            transform: translateX(-40%);
            }
            .s-type-1 #s-3:checked ~ .s-control .s-c-3 {
            background-color: #333;
            }
            .s-type-1 #s-3:checked ~ .s-nav .s-nav-3 {
            display: block;
            }
            .s-type-1 #s-4:checked ~ .s-content {
            transform: translateX(-60%);
            }
            .s-type-1 #s-4:checked ~ .s-control .s-c-4 {
            background-color: #333;
            }
            .s-type-1 #s-4:checked ~ .s-nav .s-nav-4 {
            display: block;
            }
            .s-type-1 #s-5:checked ~ .s-content {
            transform: translateX(-80%);
            }
            .s-type-1 #s-5:checked ~ .s-control .s-c-5 {
            background-color: #333;
            }
            .s-type-1 #s-5:checked ~ .s-nav .s-nav-5 {
            display: block;
            }

            @keyframes slider-animation {
            0%,
            7% {
            transform: translateX(0%);
            }
            12.5%,
            19.5% {
            transform: translateX(-20%);
            }
            25%,
            32% {
            transform: translateX(-40%);
            }
            37.5%,
            44.5% {
            transform: translateX(-60%);
            }
            50%,
            57% {
            transform: translateX(-80%);
            }
            62.5%,
            69.5% {
            transform: translateX(-60%);
            }
            75%,
            82% {
            transform: translateX(-40%);
            }
            87.5%,
            94.5% {
            transform: translateX(-20%);
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

    <div class="parallax home-slide" data-background="/storage/public/HomePage/background_blur_crop.webp" data-color="#36383e" data-color-opacity="0.5"
         data-img-width="1200" data-img-height="1000">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-container">
                        <!-- Form -->
                        <h2 style="font-family: sans-serif;">Find Your New Home</h2>
                        <!-- Row With Forms -->
                        <div class="row with-forms">
                            <form name="test" method="post" action="{{BASE_URL}}properties" onsubmit="return validate_submit()" autocomplete="off" onkeydown="return event.key != 'Enter';">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="col-md-12">
                                    <!-- Main Search Input  -->
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="main-search-input">
                                            <input type="text" required id="search-address-input" @if(isset($request_data['formatted_address'])) data-is-valid="true" @endif
                                            placeholder="Hospital, City, or Address"/>
                                            <p id="search-address-input_error" style="display: none;">Please select a valid address from the suggestions.</p>
                                            {{--                                            <input class="field" type="hidden" id="street_number" name="street_number" value="{{Session::get('street_number')}}" />--}}
                                            {{--                                            <input class="field" type="hidden" id="route" name="route" value="{{Session::get('route')}}" />--}}
                                            {{--                                            <input class="field" type="hidden" id="locality" name="city" value="{{Session::get('city')}}" />--}}
                                            {{--                                            <input class="field" type="hidden" id="administrative_area_level_1" name="state" value="{{Session::get('state')}}" />--}}
                                            {{--                                            <input class="field" type="hidden" id="postal_code" name="pin_code" value="{{Session::get('pin_code')}}" />--}}
                                            {{--                                            <input class="field" type="hidden" id="country" name="country" value="{{Session::get('country')}}" />--}}
                                            <input class="field" type="hidden" id="formatted_address" name="formatted_address" value="{{Session::get('formatted_address')}}" />
                                            <input class="field" type="hidden" id="lat" name="lat" value="{{Session::get('lat')}}" />
                                            <input class="field" type="hidden" id="lng" name="lng" value="{{Session::get('lng')}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 p-0">
                                        <div class="col-sm-7 col-xs-6" style="margin-bottom: 0;">
                                            <select class="chosen-select-no-single" name="room_type" id="room_type" data-placeholder="Home Type" style="margin-bottom: 0; height: 57px;">
                                                <option label="Home Type" value="" disabled selected></option>
                                                @foreach($room_types as $room)
                                                    <option value="{{$room->name}}" @if(isset($request_data['room_type']) && $request_data['room_type'] == $room->name) selected @endif>{{$room->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-5 col-xs-6" style="margin-bottom: 0;">
                                            <select class="chosen-select-no-single" name="guests" id="guests" data-placeholder="Guests" style="margin-bottom: 0; height: 57px;">
                                                <option label="Guest" value="" disabled selected></option>
                                                @for($i=1;$i<=10;$i++)
                                                    <option value="{{$i}}">{{$i}} Guest</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <div class="check-in-out-wrapper">
                                            <input type="text" name="from_date"
                                                   placeholder="Check in - Check out"
                                                   id="home_date_range_picker" autocomplete="off"  style="text-align: left;"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12 text-center">
                                        <button class="button" id="button" style="height: 58px;width: 150px;" type="submit">
                                            <i class="fa fa-search"></i> SEARCH
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="search_location"></div>
                                    {{--                                    <div class="col-md-2 col-sm-6 col-xs-6" style="margin-top: 10px;">--}}
                                    {{--                                        <select name="property_type" required data-placeholder="Any Status"--}}
                                    {{--                                                class="chosen-select-no-single">--}}
                                    {{--                                            <option value="" selected disabled>Property Type</option>--}}
                                    {{--                                            <option value="1">Short Term Rental</option>--}}
                                    {{--                                            <option value="2">Long Term Rental</option>--}}
                                    {{--                                        </select>--}}
                                    {{--                                    </div>--}}
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

    <!-- Featured -->
    <section class="fullwidth sec2">
        <h3 class="home-h3 text-center">Latest Listings</h3>
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <!-- <h3 class="headline margin-bottom-25 margin-top-65" style="text-align:center">Latest Listings</h3> -->
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
                                                <span class="featured verified"> {{$property->verified==1?'Verified':''}}</span>
                                            </div>
                                        @endif

                                        <div class="listing-img-content">
                                            <span
                                                class="listing-price">$ {{$property->monthly_rate}}/Month</span>
                                            @if(Session::get('user_id'))
                                                <span @if($property->is_favourite == "0") class="like-icon with-tip"
                                                      @else class="like-icon with-tip liked"
                                                      @endif data-tip-content="Add to Favorites"
                                                      onclick="favourite({{$property->property_id}});"></span>
                                                {{-- <span class="like-icon with-tip" data-tip-content="Add to Favourites" onclick="favourite({{$property->property_id}})"></span> --}}
                                            @endif
                                            <span class="compare-button with-tip"
                                                  data-tip-content="Add to Compare"></span>
                                        </div>

                                        <!-- <div class="listing-carousel"> -->
                                        <!-- <div style="max-height: 240px;min-height: 240px;">
                                            <img style="max-height: 240px;min-height: 240px;"
                                                 src="{{$property->image_url}}" alt="">
                                        </div> -->

                                        @if(count($property->property_images) > 1)

                                            <div class="outer-wrapper">
                                            <div class="s-wrap s-type-1" role="slider">
                                            @foreach($property->property_images as $prop_image)
                                            <input type="radio" id="s-{{ $loop->index + 1 }}" name="slider-control"
                                            {!! ($loop->index + 1 === 1) ? "checked='checked'" : "" !!} >
                                            @endforeach
                                            <ul class="s-content">
                                            @foreach($property->property_images as $prop_image)
                                            <li class="s-item s-item-{{ $loop->index + 1 }}">
                                            <img src="{{$prop_image->image_url}}" alt="No Data" style="height: 220px;" />
                                            </li>
                                            @endforeach
                                            </ul>
                                            <div class="s-control">
                                            @foreach($property->property_images as $prop_image)
                                            <label class="s-c-{{ $loop->index + 1 }}" for="s-{{ $loop->index + 1 }}"></label>
                                            @endforeach
                                            </div>
                                            </div>
                                            </div>

                                            @else
                                            <div style="max-height: 240px;min-height: 240px;">
                                            <img style="max-height: 240px;min-height: 240px;"
                                            src="{{$property->image_url}}" alt="">
                                            </div>
                                            @endif

                                        <!-- </div> -->

                                    </a>

                                    <div class="listing-content">

                                        <div class="listing-title">
                                            <h4>
                                                <a href="{{url('/')}}/property/{{$property->property_id}}">{{$property->title}}</a>
                                            </h4>
                                            <a href="{{url('/')}}/property/{{$property->property_id}}">
                                                <i class="fa fa-map-marker"></i>
                                                {{$property->city}},{{$property->state}}
                                            </a>
                                            @if($property->pets_allowed == 1)
                                                <div style="float: right;" title="Pets Allowed">
                                                    <img src="/storage/public/HomePage/Paw.webp"/>
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
                                                    class="fa fa-user"></i> {{Helper::get_user_display_name($property)}}
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
                    <h3 class="headline centered margin-bottom-35 home-h3">Featured Places
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
                                                        <a href="{{url('/')}}/properties?place={{$category->title}}&lat={{$category->lat}}&lng={{$category->lng}}"
                                                           class="featured-places img-box"
                                                           @if($i==0 || $i==4 || $i==11 || $i==15 || $i==5) style="height: 525px;"
                                                           @endif @if($i==3 || $i==7 || $i==8 ||$i==12) style="height: 250px;"
                                                            @endif data-background-image="{{$category->image_url}}">
{{--                                                            <img src="{{$category->image_url}}" height="100%" width="100%" style="object-fit: cover">--}}
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
</div>
<!-- Wrapper / End -->
<script type="text/javascript">

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
        // $(".owl-buttons:first").hide();
    });
    function initHomeSearchInput() {
        var componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'long_name',
            administrative_area_level_1: 'long_name',
            country: 'short_name',
            postal_code: 'short_name'
        };
        var addressOptions = {
            componentRestrictions: {country: 'us'}
        };
        try {
            var element_address = document.getElementById('search-address-input');
            var element_address_error = document.getElementById('search-address-input_error');
            if(element_address) {
                google.maps.event.addDomListener(element_address, 'keypress', (event) => {
                    if (event.keyCode === 13) {
                        event.preventDefault();
                    } else if (element_address.dataset.isValid) {
                        delete element_address.dataset.isValid;
                    }
                });
                var autocomplete_address = new google.maps.places.Autocomplete(element_address, addressOptions);
                autocomplete_address.addListener('place_changed', (e) => {
                    var place = autocomplete_address.getPlace();
                    var lat = place.geometry.location.lat();
                    var lng = place.geometry.location.lng()

                    var selectedLocation = {lat, lng};

                    $('#formatted_address').val(place.formatted_address);
                    $('#lat').val(lat);
                    $('#lng').val(lng);
                    element_address.style.borderColor = '#e0e0e0';
                    element_address_error.style.display = "none";
                    element_address.dataset.isValid = true;
                    repaintCircle(selectedLocation);
                });
            }
        } catch (e) {
            console.error(e);
        }
    }
    function validate_submit() {
        let search_address_input = document.getElementById('search-address-input');
        if(search_address_input.value && search_address_input.dataset.isValid) {
            return true;
        }
        $(`#search-address-input`).css('border-color', '#ff0000');
        $(`#search-address-input_error`).show();
        $(window).scrollTop($(`#search-address-input`).offset().top-200);
        return false;
    }
    function favourite(id) {
        var url = '{{BASE_URL}}add_property_to_favourite/' + id;
        $.ajax({
            "type": "get",
            "url": url,
            error: function (error) {
                console.log("error adding data to success", error);
            }
        });
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
@include('includes.scripts')
<script>
    // Book Now: Date Range Picker
    var disableDates = <?php echo json_encode($users_booked_dates); ?>;
    $('input[id="home_date_range_picker"]').daterangepicker({
        minDate: new Date(),
        opens: 'center',
        minSpan: {
            "days": ({{$data->min_days ?? 30}} + 1)
        },
        autoUpdateInput: false,
        autoApply: true,
        isInvalidDate: function(date){
            var dc = moment();
            dc.add(7, 'days');
            // Blocking next 7 days for payment security on owner side
            if (dc > date) {
                return true;
            }
            return disableDates.includes(date.format('YYYY-MM-DD'));
        }
    });
    $('input[id="home_date_range_picker"]').keydown(function (e) {
        e.preventDefault();
        return false;
    });
    $('input[id="home_date_range_picker"]').on('apply.daterangepicker', function (ev, picker) {
        var is_valid = check_valid_date_range(picker.startDate, picker.endDate)
        if(is_valid) {
            $('input[id="home_date_range_picker"][name="from_date"]').val(`${picker.startDate.format('MM/DD/YYYY')} - ${picker.endDate.format('MM/DD/YYYY')}`);
        }
    });

    function check_valid_date_range(startDate, endDate) {
        var getDaysArray = function (s, e) {
            for (var a = [], d = new Date(s); d <= e; d.setDate(d.getDate() + 1)) {
                a.push(d.toISOString().split('T')[0]);
            }
            return a;
        };
        var dates = getDaysArray(startDate, endDate);
        let collideDates = dates.filter(x => disableDates.includes(x));
        return !collideDates.length
    }
</script>
</body>
</html>
