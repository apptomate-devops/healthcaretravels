<!DOCTYPE html>
<head>

    <!-- Basic Page Needs
    ================================================== -->

    <title>Register / Login | {{APP_BASE_NAME}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="33727337346-hv0qqjv7ivi3osmkutnnv9hae0n6g82i.apps.googleusercontent.com">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- CSS
    ================================================== -->

    @include('includes.styles')
    <style>
        .my-account label i {
            font-size: 21px;
            color: #868383;
            position: absolute;
            left: 15px;
            bottom: 27px;
            font-weight: bolder;
        }
        .required {
            content:"*";
            color: #e78016;
        }
        .my-account label input {
            margin-top: 8px;
            padding-left: 50px;
            height: 53px;
            width: 350px;
        }
        .my-account label select {
            margin-top: 8px;
            margin-bottom: 16px;
            height: 53px;
            width: 350px;
        }
        ul, li {
            margin:0;
            padding:0;
            list-style-type:none;
        }
        #pswd_info h4 {
            margin:0 0 10px 0;
            padding:0;
            font-weight:normal;
        }
        .info-text {
            color: red;
            font-size: 14px;
            margin-bottom: 20px;
            margin-top: -10px;
        }
        .form-error {
            border-color: #e78016 !important;
        }
        .error-text {
            margin-top: -25px;
            margin-bottom: 25px;
            color: #e78016;
        }
        .label-margin {
            margin-bottom: 25px !important;
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

    <!-- Content Container
    ================================================== -->
    <div class="container" style="margin-top: 40px;">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                @if(Session::has('success'))
                    <div class = "alert alert-success">
                        <h4>{{Session::get('success')}}</h4>
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                        <h4>{{ Session::get('error') }}</h4>
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class = "alert alert-danger">
                        <h4>Something went wrong. Please review the form and correct the required fields.</h4>
                    </div>
                @endif

	<!--Tab -->
	<div class="my-account style-1 margin-top-5 margin-bottom-40" id="login_form">

		<ul class="tabs-nav">
			<li id="login_tab"><a href="#tab1">Log In</a></li>
			<li id="register_tab"><a href="#tab2">Register</a></li>
		</ul>

		<div class="tabs-container alt">

                        <!-- Login -->
                        <div class="tab-content" id="tab1" style="display: none;">
                            <form method="post" class="login" action="{{url('/')}}/login-user"  >
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="client_id" value="{{$constants['client_id']}}">
                                <p class="form-row form-row-wide">
                                    <label for="username">Email Address:<span class="required">*</span>
                                        <i class="im im-icon-Male"></i>
                                        <input type="text" class="input-text" name="username" id="username" placeholder="Email Address">
                                    </label>
                                </p>
                                <p class="form-row form-row-wide">
                                    <label for="password">Password:<span class="required">*</span>
                                        <i class="im im-icon-Lock-2"></i>
                                        <input class="input-text" type="password" name="password" id="password" placeholder="Password" />
                                    </label>
                                </p>
                                <p class="form-row">
                                    <input id="button1" type="submit" class="button border margin-top-10" name="login" value="Login" />
                                </p>
                                <p class="lost_password" style="margin-top: 10px;">
                                    <a href="{{url('/')}}/reset-password" >Lost Your Password?</a>
                                </p>
                            </form>
                        </div>

                        <!-- Register -->
                        <div class="tab-content" id="tab2" style="display: none;">
                            <div style="margin-bottom: 30px;">After registering your account, you will be required to submit information to verify your account within seven days. Please have documents and identification available for upload.</div>
                            <form method="post" class="register" action="{{url('/')}}/register-user" autocomplete="off">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="client_id" id="client_id" value="{{$constants['client_id']}}">

                                <p class="form-row form-row-wide">
                                    <label for="user_type required">Account Type:<span class="required">*</span>
                                        <select type="text" class="input-text validate {{ $errors->has('user_type') ? 'form-error' : ''}}" onchange="get_form(this.value)" name="user_type" id="user_type" autocomplete="off" >
                                            <option label="" selected>Select Account Type</option>
                                            @if(Session::get('type')==="0")
                                                <option value="0" selected>Traveler</option>
                                            @else
                                                <option value="0">Traveler</option>
                                            @endif
                                            @if(Session::get('type')==="1")
                                                <option value="1" selected>Property Owner</option>
                                            @else
                                                <option value="1">Property Owner</option>
                                            @endif
                                            @if(Session::get('type')==="2")
                                                <option value="2" selected>Travel Agent</option>
                                            @else
                                                <option value="2">Travel Agent</option>
                                            @endif
                                            @if(Session::get('type')==="3")
                                                <option value="3" selected>RV Traveler</option>
                                            @else
                                                <option value="3">RV Traveler</option>
                                            @endif
                                        </select>
                                    </label>
                                    {!! $errors->first('user_type', '<p class="error-text">:message</p>') !!}
                                </p>


                                <p class="form-row form-row-wide" id="username2_field" style="display: none;">
                                    <label for="username2 required">Username:<span class="required">*</span>
                                        <i class="im im-icon-Male"></i>
                                        <input type="text" class="input-text validate {{ $errors->has('username') ? 'form-error' : ''}}" name="username" id="username2" value="{{Session::get('username')}}" autocomplete="off" />
                                    </label>
                                    {!! $errors->first('username', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" id="email_field" style="display: none;">
                                    <label for="email2"><label id="email-label">Email Address:</label><span class="required">*</span>
                                        <i class="im im-icon-Mail"></i>
                                        <input type="text" class="input-text validate {{ $errors->has('email') ? 'form-error' : ''}}" value="{{Session::get('mail')}}" name="email" id="email2" autocomplete="off"  />
                                    </label>
                                    {!! $errors->first('email', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" id="password_field" style="display: none;">
                                    <label for="password1">Password:<span class="required">*</span>
                                        <i class="im im-icon-Lock-2" ></i>
                                        <input class="input-text validate {{ $errors->has('password1') ? 'form-error' : ''}}" type="password" autocomplete="off" name="password1" id="password1"/>
                                    </label>
                                    {!! $errors->first('password1', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" id="password2_field" style="display: none;" >
                                    <label for="password2">Repeat Password:<span class="required">*</span>
                                        <i class="im im-icon-Lock-2" ></i>
                                        <input class="input-text validate {{ $errors->has('password2') ? 'form-error' : ''}}" autocomplete="off" type="password" name="password2" id="password2"/>
                                    </label>
                                    {!! $errors->first('password2', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" id="first_name_field" style="display: none;">
                                    <label for="username2">First Name:<span class="required">*</span>
                                        <i class="im im-icon-Male"></i>
                                        <input type="text" class="input-text validate {{ $errors->has('first_name') ? 'form-error' : ''}}" value="{{Session::get('fname')}}" name="first_name" id="first_name" autocomplete="off" />
                                    </label>
                                    {!! $errors->first('first_name', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" id="last_name_field" style="display: none;">
                                    <label for="username2">Last Name:<span class="required">*</span>
                                        <i class="im im-icon-Male"></i>
                                        <input type="text" class="input-text validate {{ $errors->has('last_name') ? 'form-error' : ''}}" value="{{Session::get('lname')}}" name="last_name" id="last_name" autocomplete="off" />
                                    </label>
                                    {!! $errors->first('last_name', '<p class="error-text">:message</p>') !!}
                                </p>

                                <div class="info-text" id="name-caption">Your name will not appear in your listing.</div>

                                <p class="form-row form-row-wide" id="phone_number_field" style="display: none;">
                                    <label for="phone_no">Mobile Number:<span class="required">*</span>
                                        <i class="im im-icon-Phone-2"></i>
                                        <input type="text" class="input-text validate {{ $errors->has('phone_no') ? 'form-error' : ''}}" value="{{Session::get('phone')}}" name="phone_no" id="phone_no" maxlength="10" />
                                    </label>
                                    {!! $errors->first('phone_no', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" id="work_number_field" style="display: none;">
                                    <label for="work">Office Number:<span class="required">*</span>
                                        <i class="im im-icon-Phone"></i>
                                        <input type="text" class="input-text validate {{ $errors->has('work') ? 'form-error' : ''}}" value="{{Session::get('work')}}" name="work" id="work" maxlength="10" />
                                    </label>
                                    {!! $errors->first('work', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" id="work_title_field" style="display: none;">
                                    <label for="work_title">Work Title:<span class="required">*</span>
                                        <i class="im im-icon-Consulting"></i>
                                        <input type="text" class="input-text validate {{ $errors->has('work_title') ? 'form-error' : ''}}" value="{{Session::get('work_title')}}" name="work_title" id="work_title"/>
                                    </label>
                                    {!! $errors->first('work_title', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" id="website_field" style="display: none;">
                                    <label for="website">Agency URL:<span class="required">*</span>
                                        <i class="im im-icon-Ustream"></i>
                                        <input type="text" class="input-text validate {{ $errors->has('website') ? 'form-error' : ''}}" value="{{Session::get('website')}}" name="website" id="website" />
                                    </label>
                                    {!! $errors->first('website', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide label-margin" id="dob_field" style="display: none;">
                                    <label for="dob">Date of Birth:<span class="required">*</span>
                                        <i class="im im-icon-Calendar" style="bottom: 10px;"></i>
                                        <input type="date" class="input-text validate {{ $errors->has('dob') ? 'form-error' : ''}}" value="{{Session::get('dob')}}" name="dob" id="dob" autocomplete="off"  />
                                    </label>
                                    {!! $errors->first('dob', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" id="gender_field" style="display: none;">
                                    <label for="gender">Gender:<span class="required">*</span>
                                        <select type="text" class="input-text validate {{ $errors->has('gender') ? 'form-error' : ''}}" name="gender" id="gender" autocomplete="off" >
                                            <option value="Male" @if(Session::get('gender')=='Male') selected @endif>Male</option>
                                            <option value="Female" @if(Session::get('gender')=='Female') selected @endif>Female</option>
                                            <option value="Neutral" @if(Session::get('gender')=='Neutral') selected @endif>Neutral</option>
                                        </select>
                                    </label>
                                    {!! $errors->first('gender', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" id="languages_field" style="display: none;">
                                    <label for="languages_known">Languages Known:
                                        <i class="im im-icon-Globe"></i>
                                        <input type="text" class="input-text validate" value="{{Session::get('languages_known')}}" name="languages_known" id="languages_known" autocomplete="off" />
                                    </label>
                                    {!! $errors->first('languages_known', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" id="occupation_field" style="display: none;">
                                    <label for="occupation">Occupation:<span class="required">*</span>
                                        <select class="input-text validate" onchange="on_occupation_change(this.value)" autocomplete="off" name="occupation" id="occupation">
                                            <option label="" value="" >Select Occupation</option>
                                            @foreach($occupation as $a)
                                                <option value="{{$a->name}}" @if(Session::get('occupation')===$a->name) selected @endif>{{$a->name}}</option>
                                            @endforeach
                                            <option value="Others" @if(Session::get('occupation')==="Others") selected @endif>Others</option>
                                        </select>
                                    </label>
                                    {!! $errors->first('occupation', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" >
                                    <input class="input-text validate label-margin" autocomplete="off" style="@if(Session::get('occupation')!=="Others") display: none; @endif width: 350px;" id="others_occupation" placeholder="Occupation" type="text" name="" />
                                </p>

                                <p class="form-row form-row-wide" id="agency_show" style="display: none;">
                                    <label for="agency_name">Name of the Agency:
                                        <select class="input-text validate" onchange="on_agency_change(this.value)" autocomplete="off" name="name_of_agency" id="agency_name">
                                            <option label="" value="" >Select Agency</option>
                                            @foreach($agency as $a)
                                                <option value="{{$a->name}}" @if(Session::get('name_of_agency')===$a->name) selected @endif>{{$a->name}}</option>
                                            @endforeach
                                            <option value="Others" @if(Session::get('name_of_agency')==="Others") selected @endif>Others</option>
                                        </select>
                                    </label>
                                    {!! $errors->first('name_of_agency', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide">
                                    <input class="input-text validate label-margin" autocomplete="off" id="others_show" type="text" style="@if(Session::get('name_of_agency')!=="Others") display: none; @endif width: 350px;" name="others_show" placeholder="Agency" />
                                </p>

                                <p class="form-row form-row-wide" id="tax_home_field" style="display: none;">
                                    <label for="tax_home">Tax Home:<span class="required">*</span>
                                        <input type="text" class="input-text validate {{ $errors->has('tax_home') ? 'form-error' : ''}}" value="{{Session::get('tax_home')}}" name="tax_home" id="tax_home" placeholder="State, Country" autocomplete="off" style="padding-left: 20px;" />
                                    </label>
                                    {!! $errors->first('tax_home', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" id="address_field" style="display: none;">
                                    <label for="address"><label id="address_label">Address:</label><span class="required">*</span>
                                        <input type="text" class="input-text validate {{ $errors->has('address') ? 'form-error' : ''}}" value="{{Session::get('address')}}" name="address" id="address" placeholder="Full Street Address" autocomplete="off" style="padding-left: 20px;" />
                                    </label>
                                    {!! $errors->first('address', '<p class="error-text">:message</p>') !!}
                                </p>

                                <p class="form-row form-row-wide" id="listing_address_field" style="display: none;">
                                    <label for="listing_address">Listing Address:<span class="required">*</span>
                                        <input type="text" class="input-text validate {{ $errors->has('listing_address') ? 'form-error' : ''}}" value="{{Session::get('listing_address')}}" name="listing_address" id="listing_address" placeholder="Full Street Address" autocomplete="off" style="padding-left: 20px;" />
                                    </label>
                                    {!! $errors->first('listing_address', '<p class="error-text">:message</p>') !!}
                                </p>

                                <div class="checkboxes" id="terms_accept_field" style="display: none;">
                                    @if(Session::has('terms_accept'))
                                        <input id="terms_accept" type="checkbox" name="terms_accept" checked>
                                    @else
                                        <input id="terms_accept" type="checkbox" name="terms_accept" >
                                    @endif

                                    <label for="terms_accept"> I agree to the <a href="{{URL('/')}}/terms-of-use">Terms of Use</a> and <a href="{{URL('/')}}/policies">Policies</a></label>
                                        {!! $errors->first('terms_accept', '<p class="error-text" style="margin-top: 15px;">:message</p>') !!}
                                </div>

                                <p class="form-row"  id="register_button_field" style="display: none; margin-top: 10px;">
                                    <input type="submit" id="reg_button"  class="button border fw margin-top-10" name="register" value="Register" />
                                </p>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Container / End -->

    <!-- Footer Container
    ================================================== -->
@include('includes.footer')
<!-- Footer Container / End -->

    <!-- Scripts
    ================================================== -->
@include('includes.scripts')
<!-- Scripts / End -->

</div>
<!-- Wrapper / End -->

<script src="https://maps.google.com/maps/api/js?key={{GOOGLE_MAPS_API_KEY}}=places&callback=initAutocomplete" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(() => {

        get_form("{{ Session::get('type') }}", true);
        set_max_date();
        if("{{ Session::get('selectedTab'), 'tab1' }}" === 'tab2') {
            $('#login_tab').removeClass('active');
            $('#register_tab').addClass('active');
            $('#tab1').hide();
            $('#tab2').show();
        }
    })

    function get_form(data, isInitial = false){
        if(!isInitial) { clear_errors(); }
        switch (data) {
            case "0": // Traveler
            case "3": // RV Traveler
                $('#username2_field').show();
                $('#email_field').show();
                $('#password_field').show();
                $('#password2_field').show();
                $('#first_name_field').show();
                $('#last_name_field').show();
                $('#phone_number_field').show();
                $('#dob_field').show();
                $('#gender_field').show();
                $('#languages_field').show();
                $('#occupation_field').show();
                $('#occupation_desc').show();
                $('#agency_show').show();
                $('#tax_home_field').show();
                $('#address_field').show();
                $('#listing_address_field').hide();
                $('#terms_accept_field').show();
                $('#register_button_field').show();
                $('#name-caption').hide();
                $('#work_title_field').hide();
                $('#work_number_field').hide();
                $('#website_field').hide();

                $('#email-label').text('Email Address:');
                $('#address_label').text('Address:');
                $("#address").attr('placeholder', "Full Street Address");

                break;
            case "1": // Property Owner
                $('#username2_field').show();
                $('#email_field').show();
                $('#password_field').show();
                $('#password2_field').show();
                $('#first_name_field').show();
                $('#last_name_field').show();
                $('#phone_number_field').show();
                $('#dob_field').show();
                $('#gender_field').show();
                $('#languages_field').show();
                $('#occupation_field').show();
                $('#occupation_desc').show();
                $('#agency_show').hide();
                $('#others_show').hide();
                $('#tax_home_field').hide();
                $('#address_field').show();
                $('#listing_address_field').show();
                $('#terms_accept_field').show();
                $('#register_button_field').show();
                $('#name-caption').show();
                $('#work_title_field').hide();
                $('#work_number_field').hide();
                $('#website_field').hide();

                $('#email-label').text('Email Address:');
                $('#address_label').text('Mailing Address:');

                break;
            case "2": // Travel Agent

                $('#username2_field').show();
                $('#email_field').show();
                $('#password_field').show();
                $('#password2_field').show();
                $('#first_name_field').show();
                $('#last_name_field').show();
                $('#phone_number_field').show();
                $('#dob_field').hide();
                $('#gender_field').show();
                $('#languages_field').hide();
                $('#occupation_field').show();
                $('#occupation_desc').show();
                $('#others_occupation').hide();
                $('#agency_show').hide();
                $('#others_show').hide();
                $('#tax_home_field').hide();
                $('#address_field').hide();
                $('#listing_address_field').hide();
                $('#terms_accept_field').show();
                $('#register_button_field').show();
                $('#name-caption').hide();
                $('#work_title_field').show();
                $('#work_number_field').show();
                $('#website_field').show();

                $('#email-label').text('Business Email Address:');
                $('#email2').val('');
                $('#address_label').text('Address:');

                break;

            default:
                $('#username2_field').hide();
                $('#email_field').hide();
                $('#password_field').hide();
                $('#password2_field').hide();
                $('#first_name_field').hide();
                $('#last_name_field').hide();
                $('#phone_number_field').hide();
                $('#dob_field').hide();
                $('#gender_field').hide();
                $('#languages_field').hide();
                $('#occupation_field').hide();
                $('#occupation_desc').hide();
                $('#others_occupation').hide();
                $('#agency_show').hide();
                $('#others_show').hide();
                $('#tax_home_field').hide();
                $('#address_field').hide();
                $('#listing_address_field').hide();
                $('#terms_accept_field').hide();
                $('#register_button_field').hide();
                $('#name-caption').hide();
                $('#work_title_field').hide();
                $('#work_number_field').hide();
                $('#website_field').hide();

                $('#email-label').text('Email Address:');
                $('#address_label').text('Address:');

                break;
        }
        if(!isInitial) { initialize(); }
        hide_required(data);
    }

    function hide_required(type) {
        let occupation_span = $('#occupation_field > label > span');
        if(type === "0") {
            occupation_span.hide();
        } else {
            occupation_span.show();
        }
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    function initialize() {
        let options = {
            componentRestrictions: {country: 'us'}
        };
        let options_tax_home = {
            types: ['(cities)'],
            componentRestrictions: {country: 'us'}
        };
            // let addressFields = ['address', 'tax_home', 'listing_address'];
           try {
               let element_address = document.getElementById("address");
               if(element_address) {
                   let autocomplete_address = new google.maps.places.Autocomplete(element_address, options);
                   autocomplete_address.addListener('place_changed_address', (e) => console.log('place ====', e));
               }

               let element_tax_home = document.getElementById("tax_home");
               if(element_tax_home) {
                   let autocomplete_tax_home = new google.maps.places.Autocomplete(element_tax_home, options_tax_home);
                   autocomplete_tax_home.addListener('place_changed_tax_home', (e) => console.log('place ====', e));
               }

               let element_listing_address = document.getElementById("listing_address");
               if(element_listing_address) {
                   let autocomplete_listing_address = new google.maps.places.Autocomplete(element_listing_address, options);
                   autocomplete_listing_address.addListener('place_changed_listing_address', (e) => console.log('place ====', e));
               }
           } catch (e) {
           }
    }
    function clear_errors () {
        $(".form-error").removeClass('form-error');
        $(".error-text").hide();
    }
    function set_max_date() {
        let dd = new Date().getDate();
        let mm = new Date().getMonth()+1;
        let yyyy = new Date().getFullYear();
        document.getElementById("dob").max = `${yyyy}-${ mm<10 ? '0'+mm : mm }-${ dd<10 ? '0'+dd : dd }`;
    }

    function on_agency_change(value) {
        if(value === "Others"){
            $('#others_show').show();
            $('#others_show').attr('name','name_of_agency');
            $('#agency_name').attr('name','');
        }else{
            $('#agency_name').attr('name','name_of_agency');
            $('#others_show').hide();
        }
    }
    function on_occupation_change(value) {
        if(value === "Others"){
            $('#others_occupation').show();
            $('#others_occupation').attr('name','occupation');
            $('#occupation').attr('name','');
            $('#occupation_desc').hide();
        }else{
            $('#others_occupation').hide();
            $('#others_occupation').attr('name','');
            $('#occupation').attr('name','occupation');
            $('#occupation_desc').show();
        }
    }

    $('#phone_no, #work_number_field').on('keypress', function (event) {
        var regex = new RegExp("^[0-9+]$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
</script>

</body>
</html>
