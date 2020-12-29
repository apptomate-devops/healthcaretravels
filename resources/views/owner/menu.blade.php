<style type="text/css">
    .fa-bell {
        color: #0983b8;
        display: none;
    }
</style>
@if(Session::get('role_id') == 1 || Session::get('role_id') == 3 || Session::get('role_id') == 4)
    <ul class="my-account-nav" id="my-account-nav">

        <li class="sub-nav-title">Manage Account</li>

        <li>
            <a href="{{url('/')}}/profile" {{{ (Request::is('profile') ? 'class=current' : '') }}}>
                <i class="sl sl-icon-user"></i> My Profile
            </a>
        </li>
        <li>
            <a href="{{url('/')}}/verify-account" {{{ (Request::is('verify-account') ? 'class=current' : '') }}}>
                <i class="sl sl-icon-user"></i>Verify Account
            </a>
        </li>

    </ul>

    <ul class="my-account-nav">

        <li class="sub-nav-title">Manage Listings</li>

        @if(Session::get('role_id') == 1 || Session::get('role_id') == 4)
            <li>
                <a href="{{url('/')}}/owner/my-properties" {{{ (Request::is('owner/my-properties') ? 'class=current' : '') }}}>
                    <i class="sl sl-icon-home"></i> My Properties
                </a>
            </li>

            <li>
                <a href="{{url('/')}}/owner/add-property" {{{ (Request::is('owner/add-property') ? 'class=current' : '') }}}>
                    <i class="sl sl-icon-plus"></i> Add New Property
                </a>
            </li>
            <li>
                <a href="{{url('/')}}/owner/calender" {{{ (Request::is('owner/calender') ? 'class=current' : '') }}}>
                    <i class="sl sl-icon-credit-card"></i> Calender
                </a>
            </li>
            <li>
                <a href="{{url('/')}}/owner/my-bookings" {{{ (Request::is('owner/my-bookings') ? 'class=current not-verified-block' : 'class=not-verified-block') }}}>
                    <i class="sl sl-icon-basket"></i> Bookings
                </a><i class="fa fa-bell" id="owner_booking" style="display: none;"></i>
            </li>
        @endif
        <li>
            <a href="{{url('/')}}/owner/favorites" {{{ (Request::is('owner/favorites') ? 'class=current' : '') }}}>
                <i class="sl sl-icon-star"></i> Favorites
            </a>
        </li>


        {{--  <li>
            <a href="{{url('/')}}/owner/reservations" {{{ (Request::is('owner/reservations') ? 'class=current' : '') }}}>
               <i class="sl sl-icon-credit-card"></i> My Trips
            </a>
        </li> --}}

        <li>
            <a href="{{url('/')}}/owner/inbox" {{{ (Request::is('owner/inbox') ? 'class=current not-verified-block' : 'class=not-verified-block') }}}>
                <i class="fa fa-inbox"></i> My Inbox
            </a>
        </li>

{{--        <li>--}}
{{--            <a href="{{url('/')}}/owner/transaction-history" {{{ (Request::is('owner/transaction-history') ? 'class=current' : '') }}}>--}}
{{--                <i class="sl sl-icon-note"></i> Transaction History--}}
{{--            </a>--}}
{{--        </li>--}}
        @if(Auth::user()->default_funding_source)
            <li>
                <a href="{{url('/')}}/payment-options" {{{ (Request::is('/payment-options') ? 'class=current' : '') }}}>
                    <i class="sl sl-icon-note"></i> Payment Options
                </a>
            </li>
        @endif

{{--        <li>--}}
{{--            <a href="{{url('/')}}/owner/special_price" {{{ (Request::is('/owner/special_price') ? 'class=current' : '') }}}>--}}
{{--                <i class="sl sl-icon-star"></i>  Special Pricing--}}
{{--            </a>--}}
{{--        </li>--}}

    </ul>



    <ul class="my-account-nav">

        {{-- <li>
            <a href="{{url('/')}}/owner/payment-method" {{{ (Request::is('owner/payment-method') ? 'class=current' : '') }}}>
               <i class="fa fa-plus"></i> Payment Method
            </a>
        </li> --}}
        <li>
            <a href="{{url('/')}}/delete_account" {{{ (Request::is('delete_account') ? 'class=current' : '') }}}>
                <i class="fa fa-trash"></i> Delete My Account
            </a>
        </li>

        <li>
            <a href="{{url('/')}}/change-password" {{{ (Request::is('change-password') ? 'class=current' : '') }}}>
                <i class="sl sl-icon-lock"></i> Change Password
            </a>
        </li>

        <li>
            <a href="{{url('/')}}/logout" {{{ (Request::is('home') ? 'class=current' : '') }}}>
                <i class="sl sl-icon-power"></i> Log Out
            </a>
        </li>

    </ul>
@endif

@if(Session::get('role_id') == 0 ) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency --}}
<ul class="my-account-nav" id="my-account-nav">
    <li class="sub-nav-title">Manage Account</li>

    <li><a href="{{url('/')}}/profile" {{{ (Request::is('profile') ? 'class=current' : '') }}}>
            <i class="sl sl-icon-user"></i> My Profile</a>
    </li>

    <li>
        <a href="{{url('/')}}/verify-account" {{{ (Request::is('verify-account') ? 'class=current' : '') }}}>
            <i class="sl sl-icon-user"></i>Verify Account
        </a>
    </li>

    <li><a href="{{url('/')}}/traveler/favorites" {{{ (Request::is('traveler/favorites') ? 'class=current' : '') }}}>
            <i class="sl sl-icon-star"></i> Favorites </a></li>

    <li><a href="{{url('/')}}/traveler/my-reservations" {{{ (Request::is('traveler/my-reservations') ? 'class=current' : '') }}}>
            <i class="sl sl-icon-credit-card"></i> My Trips</a><i class="fa fa-bell" id="traveler_trips" style="display: none;"></i></li>

    @if(Auth::user()->default_funding_source)
        <li>
            <a href="{{url('/')}}/payment-options" {{{ (Request::is('/payment-options') ? 'class=current' : '') }}}>
                <i class="sl sl-icon-note"></i> Payment Options
            </a>
        </li>
    @endif

    <li><a href="{{url('/')}}/traveler/inbox" {{{ (Request::is('traveler/inbox') ? 'class=current not-verified-block' : 'class=not-verified-block') }}}>
            <i class="fa fa-inbox"></i> Inbox</a></li>
    <li>
        <a href="{{url('/')}}/delete_account" {{{ (Request::is('delete_account') ? 'class=current' : '') }}}>
            <i class="fa fa-trash"></i> Delete My Account
        </a>
    </li>
    <li>
        <a href="{{url('/')}}/change-password" {{{ (Request::is('change-password') ? 'class=current' : '') }}}>
            <i class="sl sl-icon-lock"></i> Change Password
        </a>
    </li>
    <li><a href="{{url('/')}}/logout" {{{ (Request::is('logout') ? 'class=current' : '') }}}>
            <i class="sl sl-icon-power"></i> Log Out</a></li>
</ul>
@endif


@if(Session::get('role_id') == 2 ) {{-- 1- owner 0 - traveller-- 2 -- Travel Agency --}}
<ul class="my-account-nav" id="my-account-nav">
    <li class="sub-nav-title">Manage Account</li>

    <li><a href="{{url('/')}}/profile" {{{ (Request::is('profile') ? 'class=current' : '') }}}>
            <i class="sl sl-icon-user"></i> My Profile</a>
    </li>

    <li>
        <a href="{{url('/')}}/verify-account" {{{ (Request::is('verify-account') ? 'class=current' : '') }}}>
            <i class="sl sl-icon-user"></i>Verify Account
        </a>
    </li>

    <li><a href="{{url('/')}}/traveler/favorites" {{{ (Request::is('traveler/favorites') ? 'class=current' : '') }}}>
            <i class="sl sl-icon-star"></i> Favorites </a></li>

    <li><a href="{{url('/')}}/traveler/my-reservations" {{{ (Request::is('traveler/my-reservations') ? 'class=current' : '') }}}>
            <i class="sl sl-icon-credit-card"></i> My Trips</a><i class="fa fa-bell" id="agency_trips" style="display: none;"></i></li>

    @if(Auth::user()->default_funding_source)
        <li>
            <a href="{{url('/')}}/payment-options" {{{ (Request::is('/payment-options') ? 'class=current' : '') }}}>
                <i class="sl sl-icon-note"></i> Payment Options
            </a>
        </li>
    @endif
    <li><a href="{{url('/')}}/traveler/inbox" {{{ (Request::is('traveler/inbox') ? 'class=current not-verified-block' : 'class=not-verified-block') }}}>
            <i class="fa fa-inbox"></i> Inbox</a></li>
    <li>
        <a href="{{url('/')}}/delete_account" {{{ (Request::is('delete_account') ? 'class=current' : '') }}}>
            <i class="fa fa-trash"></i> Delete My Account
        </a>
    </li>
    <li>
        <a href="{{url('/')}}/change-password" {{{ (Request::is('change-password') ? 'class=current' : '') }}}>
            <i class="sl sl-icon-lock"></i> Change Password
        </a>
    </li>
    <li><a href="{{url('/')}}/logout" {{{ (Request::is('logout') ? 'class=current' : '') }}}>
            <i class="sl sl-icon-power"></i> Log Out</a></li>
</ul>
@endif
<script type="text/javascript">
    $(document).ready(function(){
        var user_id = {{Session::get('user_id')}};
        $("#owner_booking").hide();
        $("#traveler_trips").hide();
        $("#agency_trips").hide();
        var url = "{{url('/')}}/get-user-notifications?user_id="+user_id;
        console.log(url);
        $.ajax({
            "type": "get",
            "url" : url,
            success: function(data) {
                console.log(data.trip_count);
                if(data.status=="SUCCESS"){
                    if(data.booking_count > 0){
                        $("#owner_booking").show();
                    }
                    if(data.trip_count > 0){
                        $("#traveler_trips").show();
                        $("#agency_trips").show();
                    }
                }
            }
        });
    });
</script>
