<!-- Modal Notification -->
<div class="top-notification-overlay" id="verification-pending-modal">
    <div class="overlay-content">
        <div class="bg-orange padding-5">
            <div class="notification-message-wrapper">
                <span class="notification-message">You must verify your identity before using this feature. Upload documents <a class="white-link bold-link" href="/verify-account">here</a></span>
                <span id="notification-close">&times;</span>
            </div>
        </div>
    </div>
</div>
<header id="header-container" class="header-style-2">
    <!-- Header -->
    <div id="header">
        <div class="beta-banner">
            Health Care Travels is currently in the beta phase. Please <a href="mailto:support@healthcaretravels.com">contact us</a> if you encounter any issues.
        </div>
        <div class="container">
            <!-- Left Side Content -->
            <div class="left-side">
                <!-- Mobile Navigation -->
                <div class="mmenu-trigger">
                    <button class="hamburger hamburger--collapse" type="button">
                        <span class="hamburger-inner"></span>
                    </button>
                </div>
                <!-- Logo -->
                <div id="logo" class="margin-top-10">
                    <a href="{{url('/')}}"><img src="{{url('/')}}/healthcaretravel.png" alt=""></a>
                </div>
            </div>
            <!-- Left Side Content / End -->
            <!-- Right Side Content / End -->
            <div class="right-side visible-lg">
                <ul class="header-widget">
                    {{--  <li>
                       <i class="sl sl-icon-location"></i>
                       <div class="widget-content">
                         <span class="title">Our Office</span>
                         <span class="data"> 1202 E. 1st Street #14565
                           Humble, Tx 77347.</span>
                       </div>
                     </li> --}}

                    <li class="with-btn">
                        @if(Session::get('username'))
                            <a href="{{url('/')}}/owner/add-property" class="button border">Submit Property</a>
                        @endif
                    </li>

                </ul>
            </div>
            <!-- Right Side Content / End -->
        </div>
        <!-- Main Navigation -->
        <nav id="navigation" class="style-2">
            <div class="container">
                <ul id="responsive">

                    <li>
                    <!--  <a class="current" href="{{url('/')}}"> -->
                        {{-- @if(Session::get('role_id') == 3)
                            <a href="{{url('/')}}/rv-traveller">Home</a>
                        @else
                            <a href="{{url('/')}}">Home</a>
                        @endif --}}
                        <a
                            style="cursor: pointer"
                            {{-- href="{{url('/')}}" --}}
                        >
                            Home
                        </a>
                        <ul>
                            <li class="text-center">
                                <a href="{{url('/')}}/about_us">About Us</a>
                            </li>
                            <li class="text-center">
                                <a href="{{url('/')}}/how_it_works">How It Works</a>
                            </li>
                            <li class="text-center">
                                <a href="{{url('/')}}/standards">Standards</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a
                            style="cursor: pointer"
                            {{-- href="{{url('/')}}/travelers" --}}
                        >
                            Traveler
                        </a>
                        <ul>
                            <li class="text-center">
                                <a href="{{url('/')}}/travelers">
                                    Traveler
                                </a>
                            </li>
                            <li class="text-center">
                                <a class="not-verified-block" href="{{url('/')}}/roommate">
                                    Request a Roommate
                                </a>
                            </li>
                            <li class="text-center">
                                <a href="{{url('/')}}/rv_professional">
                                    RV Professionals
                                </a>
                            </li>
                            @if(Session::get('role_id') == 3) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency -- 3 -- RV Traveller --}}
                            <li class="text-center">
                                <a href="{{url('/')}}/rv-traveller">
                                    RV Traveller
                                </a>
                            </li>
                            @endif
                        </ul>

                    </li>

                    <li>
                        <a href="{{url('/')}}/host">Host
                        </a>

                    </li>

                    <li>
                        <a style="cursor: pointer">Opportunities
                        </a>
                        <ul>
                            <li class="text-center">
                                <a href="{{url('/')}}/ambassador">
                                    Become An Ambassador
                                </a>
                            </li>
                            <li class="text-center">
                                <a href="{{url('/')}}/scout">
                                    Become A Scout
                                </a>
                            </li>
                            <li class="text-center">
                                <a href="{{url('/')}}/partner">
                                    Partner
                                </a>
                            </li>
                            <li class="text-center">
                                <a href="#">
                                    Agency
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{url('/')}}/properties">
                            Properties
                        </a>
                    </li>
                    <li>
                        @if(Session::get('username'))
                            <a href="{{url('/')}}/owner/add-property">
                                Become a Host
                            </a>
                        @endif
                    </li>
                    <li>
                        <a style="cursor: pointer">
                            Help
                        </a>
                        <ul>
                            <li class="text-center">
                                <a href="{{url('/')}}/faq">

                                    FAQ
                                </a>
                            </li>
                            <li class="text-center">
                                <a href="{{url('/')}}/contact">
                                    Contact Us
                                </a>
                            </li>
                        </ul>

                    </li>



                    @if(Auth::check() && Auth::user()->id)

                    @else
                        <li class="right-side-menu-item">
                            {{--   <a href="https://docs.google.com/forms/d/e/1FAIpQLSfAqkiqDWb4SVrS9ySxpGTVRFDTqX2noe3ItyKiGFBYwFmqeg/viewform?fbclid=IwAR2t27UuX3zLHL3fAl3gAgL_qEdDgZv4vF3U_mzCvdHAs4dEOuZGunsVJHA" class="sign-in"> --}}
                            <a href="{{url('/')}}/login" class="sign-in visible-md visible-lg">
                                <i class="fa fa-user"></i>
                                Log In / Register
                            </a>
                            <a href="{{url('/')}}/login" class="sign-in btn btn-primary hidden-md hidden-lg">
                                <i class="fa fa-user"></i>
                                Log In / Register
                            </a>
                        </li>
                    @endif
                    {{--              @if(Session::has('user_id'))--}}

                    {{--              @else--}}
                    {{--               <li class="right-side-menu-item">--}}
                    {{--                <!-- <a href="{{url('/')}}/rv-register" class="sign-in"> -->--}}
                    {{--              --}}{{--   <a href="https://docs.google.com/forms/d/e/1FAIpQLSfAqkiqDWb4SVrS9ySxpGTVRFDTqX2noe3ItyKiGFBYwFmqeg/viewform?fbclid=IwAR2t27UuX3zLHL3fAl3gAgL_qEdDgZv4vF3U_mzCvdHAs4dEOuZGunsVJHA" class="sign-in"> --}}
                    {{--                  <a href="{{url('/')}}/login" target="_blank" class="sign-in">--}}
                    {{--                <i class="fa fa-user"></i>--}}
                    {{--                RV Register--}}
                    {{--                </a>--}}
                    {{--              </li>--}}
                    {{--              @endif--}}





                </ul>
            </div>
        </nav>

        <!-- User Menu -->

        @if(Auth::check() && Auth::user()->id)
            <div class="container hidden-xs">
                <div class="row">
                    <div class="user-menu-container">
                        <div class="user-menu">
                            <div class="user-name">
                                <span id="header_profile_image">
                                    @if(Session::has('profile_image') && Session::get('profile_image') != ' ')
                                        <img src="{{ Session::get('profile_image') }}">
                                    @else
                                        <img src="/user_profile_default.png" alt="">
                                    @endif
                                </span>
                                <span>{{ Session::get('username') }}</span>
                            </div>

                            @if(Session::get('role_id') == 1 || Session::get('role_id') == 4) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency --}}
                            <ul>
                                <li><a href="{{url('/')}}/profile"><i class="sl sl-icon-user"></i> My Profile</a></li>
                                <li><a href="{{url('/')}}/verify-account"><i class="sl sl-icon-user"></i> Verify Account</a></li>
                                <li><a href="{{url('/')}}/owner/favorites"><i class="sl sl-icon-star"></i> Favorites</a></li>
                                @if(Session::get('role_id') == 1)
                                    <li><a href="{{url('/')}}/owner/my-properties" class="not-verified-block"><i class="sl sl-icon-home"></i> My Properties</a></li>
                                    <li><a href="{{url('/')}}/owner/add-property" class="not-verified-block"><i class="sl sl-icon-plus"></i> Add Property</a></li>
                                    <li><a href="{{url('/')}}/owner/bookings"><i class="sl sl-icon-basket"></i> Bookings</a></li>
                                    {{-- <li><a href="{{url('/')}}/owner/reservations"><i class="sl sl-icon-credit-card"></i> My Trips</a></li> --}}
                                    <li><a href="{{url('/')}}/owner/calender"><i class="sl sl-icon-credit-card"></i> Calender</a></li>
                                @endif
                                <li><a href="{{url('/')}}/owner/inbox" class="not-verified-block"><i class="fa fa-inbox"></i> Inbox</a></li>
                                <li><a href="{{url('/')}}/owner/invoices"><i class="sl sl-icon-note"></i> Transaction History </a></li>
                                <li><a href="{{url('/')}}/owner/special_price"><i class="sl sl-icon-star"></i> Special Pricing </a></li>
                                {{-- <li><a href="{{url('/')}}/delete_account/"><i class="sl sl-icon-trash"></i> Delete Account </a></li> --}}
                                <li><a href="{{url('/')}}/logout" onclick="signOut();" id="logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
                            </ul>
                            @endif

                            @if(Session::get('role_id') == 0) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency --}}
                            <ul>
                                <li><a href="{{url('/')}}/profile"><i class="sl sl-icon-user"></i> My Profile</a></li>
                                <li><a href="{{url('/')}}/traveler/favorites"><i class="sl sl-icon-star"></i> Favorites</a></li>
                                <li><a href="{{url('/')}}/traveler/my-reservations" class="not-verified-block"><i class="sl sl-icon-credit-card"></i> My Trips</a></li>
                                <li><a href="{{url('/')}}/traveler/inbox" class="not-verified-block"><i class="fa fa-inbox"></i> Inbox</a></li>
                                {{--  <li><a href="{{url('/')}}/delete_account/"><i class="sl sl-icon-trash"></i> Delete Account </a></li> --}}
                                <li><a href="{{url('/')}}/logout" onclick="signOut();"  id="logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
                            </ul>
                            @endif

                            @if(Session::get('role_id') == 2) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency --}}
                            <ul>
                                <li><a href="{{url('/')}}/profile"><i class="sl sl-icon-user"></i> My Profile</a></li>
                                <li><a href="{{url('/')}}/traveler/favorites"><i class="sl sl-icon-star"></i> Favorites</a></li>
                                <li><a href="{{url('/')}}/traveler/my-reservations" class="not-verified-block"><i class="sl sl-icon-credit-card"></i> My Trips</a></li>
                                <li><a href="{{url('/')}}/traveler/inbox" class="not-verified-block"><i class="fa fa-inbox"></i> Inbox</a></li>
                                {{--  <li><a href="{{url('/')}}/delete_account/"><i class="sl sl-icon-trash"></i> Delete Account </a></li> --}}
                                <li><a href="{{url('/')}}/logout" onclick="signOut();"  id="logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
                            </ul>
                            @endif
                            @if(Session::get('role_id') == 3) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency -- 3 -- RV Traveller --}}
                            <ul>
                                <li><a href="{{url('/')}}/profile"><i class="sl sl-icon-user"></i> My Profile</a></li>

                                <li><a href="{{url('/')}}/logout" onclick="signOut();"  id="logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    @endif


    <!-- User Menu / End -->
        <div class="clearfix"></div>
        <!-- Main Navigation / End -->
    </div>
    <!-- Header / End -->
    <script type="text/javascript">
        var isUserVerified = false;
        var verifiedInterval = setInterval(function() {
            $.ajax({
                type: 'GET',
                url: '/check_verified',
                success: (response) => {
                    isUserVerified = response.isVerified;
                    if (isUserVerified) {
                        clearInterval(verifiedInterval);
                        verifiedInterval = undefined;
                    }
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }, 10000);
        $(document).on('click', '.not-verified-block', function(event) {
            var userId = "{{Session::get('user_id')}}";
            if (isVerified != 1) {
                event.preventDefault();
                event.stopPropagation();
                openVerificationModal();
            }
        });
        $(document).on('click', '#notification-close', function(evennt) {
            event.preventDefault();
            event.stopPropagation();
            closeVerificationModal();
        });
        function openVerificationModal() {
            document.getElementById("verification-pending-modal").style.height = "100%";
        }
        function closeVerificationModal() {
            document.getElementById("verification-pending-modal").style.height = "0%";
        }
        $( window ).on( "load", function() {
            $('.mm-next').click(function(){
                $('.mm-next').removeClass('active');
                $(this).addClass('active')
            });
            $('.mm-prev').click(function(){
                $('.mm-next').removeClass('active');
            });
        });

        $(document).ready(function() {
            $(".user-menu").hover(function () {
                var class_n = $(this).attr('class');
                if (class_n == "user-menu") {
                    $(this).addClass('active');
                }
                if (class_n == "user-menu active") {
                    $(this).removeClass('active');
                }
            });
        });

    </script>
</header>

<!-- The actual snackbar -->
<div id="snackbar">Some text some message..</div>
