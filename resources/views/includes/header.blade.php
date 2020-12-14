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
            Health Care Travels is currently in the beta phase. Please <a href="/contact">contact us</a> if you encounter any issues.
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
                <div id="logo">
                    <a href="/"><img src="/storage/public/HomePage/healthcaretravel.png" alt=""></a>
                </div>
                <nav id="navigation" class="style-2">
                    <ul id="responsive">

                        <li>
                            <a href="/">Home</a>
                        </li>
                        <li>
                            <a href="/properties">Places to Stay</a>
                        </li>
                        <li>
                            <a href="/about_us">About Us</a>
                        </li>
                        <li>
                            <a>Work With Us</a>
                            <ul>
                                <li class="text-center">
                                    <a href="/ambassador">
                                        Become An Ambassador
                                    </a>
                                </li>
                                <li class="text-center">
                                    <a href="/scout">
                                        Become A Scout
                                    </a>
                                </li>
                                <li class="text-center">
                                    <a href="/partner">
                                        Partner
                                    </a>
                                </li>
                                <li class="text-center">
                                    <a href="/events">
                                        Events
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
                            <a style="cursor: pointer">
                                Help
                            </a>
                            <ul>
                                <li class="text-center">
                                    <a href="/travelers">
                                        For Travelers
                                    </a>
                                </li>
                                <li class="text-center">
                                    <a href="/rv_professional">
                                        For RV Travelers
                                    </a>
                                </li>
                                <li class="text-center">
                                    <a href="/host">
                                        For Hosts
                                    </a>
                                </li>
                                <li class="text-center">
                                    <a href="/request-roommate">
                                        Request a Roommate
                                    </a>
                                </li>
                                <li class="text-center">
                                    <a href="/how_it_works">
                                        How It Works
                                    </a>
                                </li>
                                <li class="text-center">
                                    <a href="/faq">
                                        FAQ
                                    </a>
                                </li>
                                <li class="text-center">
                                    <a href="/contact">
                                        Contact Us
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- Left Side Content / End -->
            <!-- Right Side Content / End -->
            <div id="right-side" class="right-side">
                <!-- User Menu -->
                <div class="right-side-menu-item" id="right-side-menu-item">
                    <a class="button" href="/properties">
                        <i class="fa fa-search"></i> Find a New Home
                    </a>
                    @if(Auth::check() && Auth::user()->id)
                    <div class="hidden-xs hidden-sm">
                        <div class="user-menu-container">
                            <div class="user-menu">
                                <div class="user-name">
                                    <span id="header_profile_image">
                                        <img class="user-icon" src="{{Auth::user()->profile_image}}">
                                        <span id="unread_chat_badge"><span class="unread_chat_badge"></span></span>
                                    </span>
                                    <span>{{Helper::get_user_display_name(Auth::user())}}</span>
                                </div>

                                @if(Session::get('role_id') == 1 || Session::get('role_id') == 4) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency --}}
                                <ul id="user-dropdown-nav">
                                    <li><a href="{{url('/')}}/profile"><i class="sl sl-icon-user"></i> My Profile</a></li>
                                    <li><a href="{{url('/')}}/verify-account"><i class="sl sl-icon-user"></i> Verify Account</a></li>
                                    <li><a href="{{url('/')}}/owner/favorites"><i class="sl sl-icon-star"></i> Favorites</a></li>
                                    <li><a href="{{url('/')}}/owner/my-properties" class="not-verified-block"><i class="sl sl-icon-home"></i> My Properties</a></li>
                                    <li><a href="{{url('/')}}/owner/add-property" class="not-verified-block"><i class="sl sl-icon-plus"></i> Add Property</a></li>
{{--                                    @if(Session::get('role_id') == 1)--}}
                                    <li><a href="{{url('/')}}/owner/bookings"><i class="sl sl-icon-basket"></i> Bookings</a></li>
                                    {{-- <li><a href="{{url('/')}}/owner/reservations"><i class="sl sl-icon-credit-card"></i> My Trips</a></li> --}}
                                    <li><a href="{{url('/')}}/owner/calender"><i class="sl sl-icon-credit-card"></i> Calender</a></li>
{{--                                    @endif--}}
                                    <li><a href="{{url('/')}}/owner/inbox" class="not-verified-block" style="position:relative"><i class="fa fa-inbox"></i> <span id="unread_chat_badge_inbox"><span class="unread_chat_badge_inbox"></span></span> Inbox</a></li>
                                    <li><a href="{{url('/')}}/owner/invoices"><i class="sl sl-icon-note"></i> Transaction History </a></li>
                                    @if(Auth::user()->default_funding_source)
                                        <li>
                                            <a href="{{url('/')}}/payment-options" class="not-verified-block">
                                                <i class="sl sl-icon-note"></i> Payment Options
                                            </a>
                                        </li>
                                    @endif
                                    {{-- <li><a href="{{url('/')}}/owner/special_price"><i class="sl sl-icon-star"></i> Special Pricing </a></li>--}}
                                    {{-- <li><a href="{{url('/')}}/delete_account/"><i class="sl sl-icon-trash"></i> Delete Account </a></li> --}}
                                    <li><a href="{{url('/')}}/logout" onclick="signOut();" id="logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
                                </ul>
                                @endif

                                @if(Session::get('role_id') == 0) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency --}}
                                <ul id="user-dropdown-nav">
                                    <li><a href="{{url('/')}}/profile"><i class="sl sl-icon-user"></i> My Profile</a></li>
                                    <li><a href="{{url('/')}}/traveler/favorites"><i class="sl sl-icon-star"></i> Favorites</a></li>
                                    <li><a href="{{url('/')}}/traveler/my-reservations" class="not-verified-block"><i class="sl sl-icon-credit-card"></i> My Trips</a></li>
                                    <li><a href="{{url('/')}}/traveler/inbox" class="not-verified-block" style="position:relative"><i class="fa fa-inbox"></i> <span id="unread_chat_badge_inbox"><span class="unread_chat_badge_inbox"></span></span> Inbox</a></li>
                                    @if(Auth::user()->default_funding_source)
                                        <li>
                                            <a href="{{url('/')}}/payment-options" class="not-verified-block">
                                                <i class="sl sl-icon-note"></i> Payment Options
                                            </a>
                                        </li>
                                    @endif
                                    {{-- <li><a href="{{url('/')}}/delete_account/"><i class="sl sl-icon-trash"></i> Delete Account </a></li> --}}
                                    <li><a href="{{url('/')}}/logout" onclick="signOut();" id="logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
                                </ul>
                                @endif

                                @if(Session::get('role_id') == 2) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency --}}
                                <ul id="user-dropdown-nav">
                                    <li><a href="{{url('/')}}/profile"><i class="sl sl-icon-user"></i> My Profile</a></li>
                                    <li><a href="{{url('/')}}/traveler/favorites"><i class="sl sl-icon-star"></i> Favorites</a></li>
                                    <li><a href="{{url('/')}}/traveler/my-reservations" class="not-verified-block"><i class="sl sl-icon-credit-card"></i> My Trips</a></li>
                                    <li><a href="{{url('/')}}/traveler/inbox" class="not-verified-block"><i class="fa fa-inbox"></i> Inbox</a></li>
                                    @if(Auth::user()->default_funding_source)
                                        <li>
                                            <a href="{{url('/')}}/payment-options" class="not-verified-block">
                                                <i class="sl sl-icon-note"></i> Payment Options
                                            </a>
                                        </li>
                                    @endif
                                    {{-- <li><a href="{{url('/')}}/delete_account/"><i class="sl sl-icon-trash"></i> Delete Account </a></li> --}}
                                    <li><a href="{{url('/')}}/logout" onclick="signOut();" id="logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
                                </ul>
                                @endif
                                @if(Session::get('role_id') == 3) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency -- 3 -- RV Traveller --}}
                                <ul id="user-dropdown-nav">
                                    <li><a href="{{url('/')}}/profile"><i class="sl sl-icon-user"></i> My Profile</a></li>

                                    <li><a href="{{url('/')}}/logout" onclick="signOut();" id="logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                    <a href="/login" class="sign-in">
                        <img src="/icons/login.png" alt="Login" class="sign-in-icon" style="height: 20px; width: 20px; margin-right: 10px;">
                        <span>Log In / Register</span>
                    </a>
                    @endif
                </div>
                {{-- <ul class="header-widget">--}}
                {{-- <li class="with-btn">--}}
                {{-- @if(Session::get('username'))--}}
                {{-- <a href="{{url('/')}}/owner/add-property" class="button border">Submit Property</a>--}}
                {{-- @endif--}}
                {{-- </li>--}}
                {{-- </ul>--}}
            </div>
            <!-- Right Side Content / End -->
        </div>


        <!-- User Menu / End -->
        <div class="clearfix"></div>
        <!-- Main Navigation / End -->
    </div>
    <!-- Header / End -->
    <script type="text/javascript">
        var isUserVerified = false;
        function interval_check_vefiried() {
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
        }
        interval_check_vefiried();
        var verifiedInterval = setInterval(interval_check_vefiried, 1000 * 60);
        // $(document).on('click', '.not-verified-block', function(event) {
        //     var sessionVerified = "{{Session::has('is_verified') && Session::get('is_verified')}}";
        //     if (isUserVerified != 1 && sessionVerified != "1") {
        //         event.preventDefault();
        //         event.stopPropagation();
        //         openVerificationModal();
        //     }
        // });
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


        function responsiveRightSide() {
            var rightSideMenu = $('.right-side').html(),
                mmMenu = $('.mm-menu > .mm-panels > .mm-panel:first-child');

            mmMenu.addClass('mm-right-side-menu');

            if ($(window).width() < 992) {
                $('.mm-right-side-menu').append(rightSideMenu);
                $('.sign-in').addClass('button');
            }
        }

        $(window).on("load", function() {
            $('.mm-next').click(function() {
                $('.mm-next').removeClass('active');
                $(this).addClass('active')
            });
            $('.mm-prev').click(function() {
                $('.mm-next').removeClass('active');
            });
            responsiveRightSide();
        });

        // $(window).resize(function () {
        //     responsiveRightSide();
        // });

        $(document).ready(function() {
            $(".user-menu").hover(function() {
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
    <style>
        #unread_chat_badge {
            display: none;
        }

        #unread_chat_badge_inbox {
            display: none;
        }

        .unread_chat_badge {
            position: absolute;
            bottom: 0;
            left: 26px;
            height: 10px;
            width: 10px;
            background-color: red;
            border-radius: 50%;
            display: inline;
        }

        .unread_chat_badge_inbox {
            position: absolute;
            bottom: 4px;
            left: 26px;
            height: 10px;
            width: 10px;
            background-color: red;
            border-radius: 50%;
            display: inline;
        }
    </style>
</header>

<!-- The actual snackbar -->
<div id="snackbar">Some text some message..</div>
