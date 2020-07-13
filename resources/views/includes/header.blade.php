<style type="text/css">
  .center{
    text-align: center;
  }
  .btn-header {
    float: right;
  }
  @media only screen and (max-width: 992px){
    .right-side {
      text-align: center;
    }
    .btn-header {
      float: none;
    }
  }
</style>
<header id="header-container" class="header-style-2">
      <!-- Header -->
      <div id="header">
        <div class="container">
          <!-- Left Side Content -->
          <div class="left-side">
            <!-- Logo -->
            <div id="logo" class="margin-top-10">
              <a href="{{url('/')}}"><img src="{{url('/')}}/healthcaretravel.png" alt=""></a>
            </div>
            <!-- Mobile Navigation -->
            <div class="mmenu-trigger">
              <button class="hamburger hamburger--collapse" type="button">
              <span class="hamburger-box">
              <span class="hamburger-inner"></span>
              </span>
              </button>
            </div>
          </div>
          <!-- Left Side Content / End -->
          <!-- Right Side Content / End -->
          <div class="right-side">
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
         {{--    <a href="https://docs.google.com/forms/d/e/1FAIpQLSfWnft5cRSmWcyZ23q63C6onr1W0HifZqULU4fej3y9qc2hWw/viewform?usp=sf_link" target="_blank" class="sign-in">
              <button class="btn btn-primary btn-header"> --}}
                     <a href="{{url('/')}}/login" target="_blank" class="sign-in">
              <button class="btn btn-primary btn-header">
                RV Covid-19 Assistance
              </button>
            </a>
          </div>
          <!-- Right Side Content / End -->
        </div>
        <!-- Main Navigation -->
        <nav id="navigation" class="style-2">
          <div class="container">
            <ul id="responsive">

              <li>
			<!--  <a class="current" href="{{url('/')}}"> -->
              @if(Session::get('role_id') == 3)
                <a href="{{url('/')}}/rv-traveller">Home</a>
              @else
               <a href="{{url('/')}}">Home</a>
              @endif
                <ul>
                	<li class="center">
                		<a href="{{url('/')}}/about_us">About Us</a>
                	</li>
                	<li class="center">
                		<a href="{{url('/')}}/how_its_works">How It Works</a>
                	</li>
                	 <li class="center">
                		<a href="{{url('/')}}/standards">Standards</a>
                	</li>
                </ul>
              </li>

              <li>
                <a href="#">
                Traveler
                </a>
                	<ul>
                		<li class="center">
                			<a href="{{url('/')}}/dear_travelers">
			                Traveler
			                </a>
                		</li>
                    <li class="center">
                      <a href="{{url('/')}}/request-roommate">
                      Request a Roommate
                      </a>
                    </li>
                    <li class="center">
                      <a href="{{url('/')}}/rv_professional">
                      RV Professionals
                      </a>
                    </li>
                     @if(Session::get('role_id') == 3) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency -- 3 -- RV Traveller --}}
                      <li class="center">
                        <a href="{{url('/')}}/rv-traveller">
                        RV Traveller
                        </a>
                      </li>
                      <li class="center">
                        {{-- <a href="https://docs.google.com/forms/d/e/1FAIpQLSfWnft5cRSmWcyZ23q63C6onr1W0HifZqULU4fej3y9qc2hWw/viewform?usp=sf_link" target="_blank" class="sign-in">Click here for Covid-19 Assistance</a> --}}
                          <a href="{{url('/')}}/login" target="_blank" class="sign-in">
                      </li>
                     @endif
                	</ul>

              </li>

               <li>
                <a href="{{url('/')}}/dear_host">Host
                </a>

              </li>

               <li>
                <a href="{{url('/')}}/">Opportunities
                </a>
                <ul>
                <li class="center">
                  <a href="{{url('/')}}/become-a-ambassador">
                    Become An Ambassador
                    </a>
                </li>
                <li class="center">
                  <a href="{{url('/')}}/become-a-scout">
                    Become A Scout
                    </a>
                </li>
                 <li class="center">
                  <a href="{{url('/')}}/partner">
                    Partner
                  </a>
                </li>
                <li class="center">
                  <a href="#">
                    Agency
                  </a>
                </li>
                </ul>
              </li>
              <li>
                <a href="{{url('/')}}/short-term">
                Properties
                </a>
              </li>

              {{-- <li>
                <a href="{{url('/')}}/short-term">
                </a>
                <ul>
                  <li><a href="{{url('/')}}/short-term">Vacation Homes</a></li>
                  <li><a href="{{url('/')}}/long-term">For Rent</a></li>
                </ul>
              </li> --}}

              <li>
                 @if(Session::get('username'))
                <a href="{{url('/')}}/owner/add-property">
                Become a Host

                </a>
                @endif
              </li>
                <li>
                <a href="#">
                Help
                </a>
                  <ul>
                    <li class="center">
                      <a href="{{url('/')}}/faq">

                      FAQ
                      </a>
                    </li>
                    <li class="center">
                      <a href="{{url('/')}}/contact">
                      Contact Us
                      </a>
                    </li>
                  </ul>

              </li>



              @if(Session::has('user_id'))

              @else
               <li class="right-side-menu-item">
              {{--   <a href="https://docs.google.com/forms/d/e/1FAIpQLSfAqkiqDWb4SVrS9ySxpGTVRFDTqX2noe3ItyKiGFBYwFmqeg/viewform?fbclid=IwAR2t27UuX3zLHL3fAl3gAgL_qEdDgZv4vF3U_mzCvdHAs4dEOuZGunsVJHA" class="sign-in"> --}}
                   <a href="{{url('/')}}/login" class="sign-in">
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

        @if(Session::has('user_id'))
            <div class="container">
          <div class="row">
              <div class="user-menu-container">
                  <div class="user-menu">
                      <div class="user-name">
                          <span id="header_profile_image">
                             @if(Session::has('profile_image'))
                                  <img src="{{ Session::get('profile_image') }}" style="max-width: 38px;max-height: 34px;" alt="">
                             @else
                                  <img src="{{url('/')}}/user_profile_default.png" alt="">
                             @endif
                          </span>
                          @if(Session::get('role_id') == 2)
                          &nbsp;{{ Session::get('name_of_agency') }}
                          @else
                           &nbsp;{{ Session::get('username') }}
                           @endif
                        </div>

                      @if(Session::get('role_id') == 1) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency --}}
                      <ul>
                          <li><a href="{{url('/')}}/owner/profile"><i class="sl sl-icon-user"></i> My Profile</a></li>
                          <li><a href="{{url('/')}}/owner/verify-account"><i class="sl sl-icon-user"></i> Verify Account</a></li>
                          <li><a href="{{url('/')}}/owner/favorites"><i class="sl sl-icon-star"></i> Favorites</a></li>
                          <li><a href="{{url('/')}}/owner/my-properties"><i class="sl sl-icon-home"></i> My Properties</a></li>
                          <li><a href="{{url('/')}}/owner/add-property"><i class="sl sl-icon-plus"></i> Add Property</a></li>
                          <li><a href="{{url('/')}}/owner/bookings"><i class="sl sl-icon-basket"></i> Bookings</a></li>
                          {{-- <li><a href="{{url('/')}}/owner/reservations"><i class="sl sl-icon-credit-card"></i> My Trips</a></li> --}}
                          <li><a href="{{url('/')}}/owner/calender"><i class="sl sl-icon-credit-card"></i> Calender</a></li>
                          <li><a href="{{url('/')}}/owner/inbox"><i class="fa fa-inbox"></i> Inbox</a></li>
                          <li><a href="{{url('/')}}/owner/invoices"><i class="sl sl-icon-note"></i> Transaction History </a></li>
                          <li><a href="{{url('/')}}/owner/special_price"><i class="sl sl-icon-star"></i> Special Pricing </a></li>
                          {{-- <li><a href="{{url('/')}}/delete_account/"><i class="sl sl-icon-trash"></i> Delete Account </a></li> --}}
                          <li><a href="{{url('/')}}/logout" onclick="signOut();" id="logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
                      </ul>
                      @endif

                      @if(Session::get('role_id') == 0) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency --}}
                      <ul>
                          <li><a href="{{url('/')}}/traveler/profile"><i class="sl sl-icon-user"></i> My Profile</a></li>
                          <li><a href="{{url('/')}}/traveler/favorites"><i class="sl sl-icon-star"></i> Favorites</a></li>
                          <li><a href="{{url('/')}}/traveler/my-reservations"><i class="sl sl-icon-credit-card"></i> My Trips</a></li>
                          <li><a href="{{url('/')}}/traveler/inbox"><i class="fa fa-inbox"></i> Inbox</a></li>
                         {{--  <li><a href="{{url('/')}}/delete_account/"><i class="sl sl-icon-trash"></i> Delete Account </a></li> --}}
                          <li><a href="{{url('/')}}/logout" onclick="signOut();"  id="logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
                      </ul>
                      @endif

                      @if(Session::get('role_id') == 2) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency --}}
                      <ul>
                          <li><a href="{{url('/')}}/traveler/profile"><i class="sl sl-icon-user"></i> My Profile</a></li>
                          <li><a href="{{url('/')}}/traveler/favorites"><i class="sl sl-icon-star"></i> Favorites</a></li>
                          <li><a href="{{url('/')}}/traveler/my-reservations"><i class="sl sl-icon-credit-card"></i> My Trips</a></li>
                          <li><a href="{{url('/')}}/traveler/inbox"><i class="fa fa-inbox"></i> Inbox</a></li>
                         {{--  <li><a href="{{url('/')}}/delete_account/"><i class="sl sl-icon-trash"></i> Delete Account </a></li> --}}
                          <li><a href="{{url('/')}}/logout" onclick="signOut();"  id="logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
                      </ul>
                      @endif
                      @if(Session::get('role_id') == 3) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency -- 3 -- RV Traveller --}}
                      <ul>
                          <li><a href="{{url('/')}}/traveler/profile"><i class="sl sl-icon-user"></i> My Profile</a></li>

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
    </header>

<!-- The actual snackbar -->
<div id="snackbar">Some text some message..</div>
