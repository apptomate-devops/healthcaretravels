<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            <li {{{ (Request::is('admin/index') ? 'class=active' : '') }}}>
                <a href="{{url('admin/index')}}">
                    <i class="la la-dashboard"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                    Dashboard
                </span>
                </a>
            </li>

            <li {{{ (Request::is('admin/admin-users*') ? 'class=active' : '') }}}>
                <a href="{{url('admin/admin-users')}}">
                    <i class="la la-user"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                    Manage Admin Users
                </span>
                </a>
            </li>

            <li {{{ (Request::is('admin/travellers*') ? 'class=active' : '') }}}>
                <a href="{{url('admin/travellers')}}">
                    <i class="la la-user"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                    Manage Travelers
                </span>
                </a>
            </li>

            <li {{{ (Request::is('admin/owner*') ? 'class=active' : '') }}}>
                <a href="{{url('admin/owner')}}">
                    <i class="la la-user-plus"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                   Manage Owner
                </span>
                </a>
            </li>
            <li {{{ (Request::is('admin/agency*') ? 'class=active' : '') }}}>
                <a href="{{url('admin/agency')}}">
                    <i class="la la-user-plus"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                   Manage Agency
                </span>
                </a>
            </li>

            <li {{{ (Request::is('admin/property*') ? 'class=active' : '') }}}>
                <a href="{{url('admin/property')}}">
                    <i class="la la-home"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                    Manage Property
                </span>
                </a>
            </li>
            <li {{{ (Request::is('admin/block_property*') ? 'class=active' : '') }}}>
                <a href="{{url('admin/block_property')}}">
                    <i class="la la-home"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                    Block Property
                </span>
                </a>
            </li>

        <!--<li {{{ (Request::is('admin/inbox*') ? 'class=active' : '') }}}>
            <a href="{{url('admin/inbox')}}">
                <i class="la la-commenting-o"></i>
                <span class="menu-title" data-i18n="nav.dash.main">
                  My Inbox
                </span>
            </a>
        </li>

        <li {{{ (Request::is('admin/owner*') ? 'class=active' : '') }}}>
            <a href="{{url('admin/owner')}}">
                <i class="la la-envelope-o"></i>
                <span class="menu-title" data-i18n="nav.dash.main">
                   My Mail
                </span>
            </a>
        </li> -->


            <li {{{ (Request::is('admin/reservations*') ? 'class=active' : '') }}}>
                <a href="{{url('admin/reservations')}}">
                    <i class="la la-plane"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                   Reservations
                </span>
                </a>
            </li>
            <li {{{ (Request::is('admin/become_scout*') ? 'class=active' : '') }}}>
                <a href="{{url('admin/become_scout')}}">
                    <i class="la la-user"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                   Become Scout
                </span>
                </a>
            </li>

            <li {{{ (Request::is('admin/request_roommate*') ? 'class=active' : '') }}}>
                <a href="{{url('admin/request_roommate')}}">
                    <i class="la la-user"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                       Request Roomate
                    </span>
                </a>
            </li>

        <!--  <li {{{ (Request::is('admin/completedpayment*') ? 'class=active' : '') }}}>
            <a href="{{url('admin/completedpayment')}}">
                <i class="la la-dollar"></i>
                <span class="menu-title" data-i18n="nav.dash.main">
                   Completed Payments
                </span>
            </a>
        </li> -->

            <li {{{ (Request::is('admin/host-payouts') ? 'class=active' : '') }}}>
                <a href="{{url('admin/host-payouts')}}">
                    <i class="la la-money"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                    Host Payouts
                </span>
                </a>
            </li>

        <!--   <li {{{ (Request::is('admin/refunds*') ? 'class=active' : '') }}}>
            <a href="{{url('admin/refunds')}}">
                <i class="la la-dollar"></i>
                <span class="menu-title" data-i18n="nav.dash.main">
                   Refunds
                </span>
            </a>
        </li> -->

            <li {{{ (Request::is('admin/cancelledpayment*') ? 'class=active' : '') }}}>
                <a href="{{url('admin/cancelledpayment')}}">
                    <i class="la la-money"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                   Cancelled Payments
                </span>
                </a>
            </li>

        <!-- <li {{{ (Request::is('admin/invoice-lists') ? 'class=active' : '') }}}>
            <a href="{{url('admin/invoice-lists')}}">
                <i class="la la-file-text"></i>
                <span class="menu-title" data-i18n="nav.dash.main">
                    Invoice lists
                </span>
            </a>
        </li> -->


            <li {{{ (Request::is('admin/cancellation-policy*') ? 'class=active' : '') }}}>
                <a href="{{url('admin/cancellation-policy')}}">
                    <i class="la la-newspaper-o"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                    Cancellation Policy
                </span>
                </a>
            </li>
            <li class=" nav-item"><a href="#"><i class="la la-envelope"></i><span class="menu-title"
                                                                                  data-i18n="nav.starter_kit.main">Email Configuration</span></a>
                <ul class="menu-content">
                    <li {{{ (Request::is('admin/register_mail') ? 'class=active' : '') }}}>
                        <a href="{{url('admin/register_mail')}}">
                            <i class="la la-envelope"></i>
                            <span class="menu-title" data-i18n="nav.dash.main">
                    Register
                </span>
                        </a>
                    </li>

                    <li {{{ (Request::is('admin/verification_mail') ? 'class=active' : '') }}}>
                        <a href="{{url('admin/verification_mail')}}">
                            <i class="la la-envelope"></i>
                            <span class="menu-title" data-i18n="nav.dash.main">
                    Verification
                </span>
                        </a>
                    </li>
                    <li {{{ (Request::is('admin/approval_mail') ? 'class=active' : '') }}}>
                        <a href="{{url('admin/approval_mail')}}">
                            <i class="la la-envelope"></i>
                            <span class="menu-title" data-i18n="nav.dash.main">
                    Approval
                </span>
                        </a>
                    </li>
                    <li {{{ (Request::is('admin/password_reset') ? 'class=active' : '') }}}>
                        <a href="{{url('admin/password_reset')}}">
                            <i class="la la-envelope"></i>
                            <span class="menu-title" data-i18n="nav.dash.main">
                    Password Reset
                </span>
                        </a>
                    </li>
                    <li {{{ (Request::is('admin/booking_confirm_mail') ? 'class=active' : '') }}}>
                        <a href="{{url('admin/booking_confirm_mail')}}">
                            <i class="la la-envelope"></i>
                            <span class="menu-title" data-i18n="nav.dash.main">
                    Confirm Booking
                </span>
                        </a>
                    </li>
                    <li {{{ (Request::is('admin/booking_cancel_mail') ? 'class=active' : '') }}}>
                        <a href="{{url('admin/booking_cancel_mail')}}">
                            <i class="la la-envelope"></i>
                            <span class="menu-title" data-i18n="nav.dash.main">
                    Cancel Booking
                </span>
                        </a>
                    </li>

                </ul>
            </li>

        <!--  <li {{{ (Request::is('admin/emailsetting*') ? 'class=active' : '') }}}>
            <a href="{{url('admin/emailsetting')}}">
                <i class="la la-envelope"></i>
                <span class="menu-title" data-i18n="nav.dash.main">
                    Email Settings
                </span>
            </a>
        </li> -->

            <li {{{ (Request::is('admin/send-email*') ? 'class=active' : '') }}}>
                <a href="{{url('admin/send-email')}}">
                    <i class="la la-envelope"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                    Send Email
                </span>
                </a>
            </li>

        {{--  <li {{{ (Request::is('admin/payment-settings*') ? 'class=active' : '') }}}>
             <a href="{{url('admin/payment-settings')}}">
                 <i class="la la-paypal"></i>
                 <span class="menu-title" data-i18n="nav.dash.main">
                     Payment Settings
                 </span>
             </a>
         </li> --}}

        <!--   <li {{{ (Request::is('admin/commision*') ? 'class=active' : '') }}}>
            <a href="{{url('admin/commision')}}">
                <i class="la la-money"></i>
                <span class="menu-title" data-i18n="nav.dash.main">
                    Commission Settings
                </span>
            </a>
        </li> -->

        <!--  <li class=" nav-item"><a href="#"><i class="la la-group"></i><span class="menu-title" data-i18n="nav.starter_kit.main">Refferals</span></a>
             <ul class="menu-content">
                <li {{{ (Request::is('admin/referral-settings*') ? 'class=active' : '') }}}>
            <a href="{{url('admin/referral-settings')}}">
                <i class="la la-group"></i>
                <span class="menu-title" data-i18n="nav.dash.main">
                    Referral Settings
                </span>
            </a>
        </li> -->

        <!--  <li {{{ (Request::is('admin/referral-lists*') ? 'class=active' : '') }}}>
            <a href="{{url('admin/referral-lists')}}">
                <i class="la la-newspaper-o"></i>
                <span class="menu-title" data-i18n="nav.dash.main">
                    Refferals Lists
                </span>
            </a>
        </li>
                </ul>
            </li> -->


            <li class=" nav-item"><a href="#"><i class="la la-star"></i><span class="menu-title"
                                                                              data-i18n="nav.starter_kit.main">Ratings</span></a>
                <ul class="menu-content">
                    <li {{{ (Request::is('admin/host-ratings') ? 'class=active' : '') }}}>
                        <a href="{{url('admin/host-ratings')}}">
                            <i class="la la-star"></i>
                            <span class="menu-title" data-i18n="nav.dash.main">
                    Host Ratings
                </span>
                        </a>
                    </li>

                    <li {{{ (Request::is('admin/traveller-ratings') ? 'class=active' : '') }}}>
                        <a href="{{url('admin/traveller-ratings')}}">
                            <i class="la la-star"></i>
                            <span class="menu-title" data-i18n="nav.dash.main">
                    Traveler Ratings
                </span>
                        </a>
                    </li>
                </ul>
            </li>


        <!--   <li {{{ (Request::is('admin/reviews*') ? 'class=active' : '') }}}>
            <a href="{{url('admin/reviews')}}">
                <i class="la la-eye"></i>
                <span class="menu-title" data-i18n="nav.dash.main">
                    Reviews
                </span>
            </a>
        </li> -->


            <li {{{ (Request::is('admin/reports') ? 'class=active' : '') }}}>
                <a href="{{url('admin/reports')}}">
                    <i class="la la-file-text-o"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                    Manage reports
                </span>
                </a>
            </li>

            <li {{{ (Request::is('admin/faq*') ? 'class=active' : '') }}}>
                <a href="{{url('admin/faq')}}">
                    <i class="la la-envelope"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                   Faq
                </span>
                </a>
            </li>

            <li {{{ (Request::is('admin/add-agency') ? 'class=active' : '') }}}>
                <a href="{{url('admin/add-agency')}}">
                    <i class="la la-file-text-o"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                   Add Agency
                </span>
                </a>
            </li>
            <li {{{ (Request::is('admin/add-property_type') ? 'class=active' : '') }}}>
                <a href="{{url('admin/add-property_type')}}">
                    <i class="la la-file-text-o"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                   Add Property Type
                </span>
                </a>
            </li>
            <li {{{ (Request::is('admin/add-room_type') ? 'class=active' : '') }}}>
                <a href="{{url('admin/add-room_type')}}">
                    <i class="la la-file-text-o"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                   Add Room Type
                </span>
                </a>
            </li>
            <li {{{ (Request::is('admin/add-occupation') ? 'class=active' : '') }}}>
                <a href="{{url('admin/add-occupation')}}">
                    <i class="la la-file-text-o"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                   Add Occupation
                </span>
                </a>
            </li>
            <li {{{ (Request::is('admin/manage_cities') ? 'class=active' : '') }}}>
                <a href="{{url('admin/manage_cities')}}">
                    <i class="la la-file-text-o"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                    Manage cities
                </span>
                </a>
            </li>


            <li class=" nav-item"><a href="#"><i class="la la-ticket"></i><span class="menu-title"
                                                                                data-i18n="nav.starter_kit.main">Coupon Codes</span></a>
                <ul class="menu-content">

                    <li {{{ (Request::is('admin/create-coupon') ? 'class=active' : '') }}}>
                        <a href="{{url('admin/create-coupon')}}">
                            <i class="la la-newspaper-o"></i>
                            <span class="menu-title" data-i18n="nav.dash.main">
                  Create Coupon Code
                </span>
                        </a>
                    </li>

                    <li {{{ (Request::is('admin/manage-coupon') ? 'class=active' : '') }}}>
                        <a href="{{url('admin/manage-coupon')}}">
                            <i class="la la-newspaper-o"></i>
                            <span class="menu-title" data-i18n="nav.dash.main">
                   Manage Coupon Code
                </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li {{{ (Request::is('admin/site-management') ? 'class=active' : '') }}}>
                <a href="{{url('admin/site-management')}}">
                    <i class="la la-newspaper-o"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                    Site Management
                </span>
                </a>
            </li>


            <li {{{ (Request::is('admin/footer-settings') ? 'class=active' : '') }}}>
                <a href="{{url('admin/footer-settings')}}">
                    <i class="la la-newspaper-o"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">
                   Footer Settings
                </span>
                </a>
            </li>


        </ul>

    </div>
</div>
