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
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- CSS
    ================================================== -->

    @include('includes.styles')
    <link rel="stylesheet" href="{{ URL::asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/select-pure.css') }}">

    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<!-- Wrapper -->
<div id="wrapper" class="login-page">

    <!-- Header Container
    ================================================== -->

    @include('includes.header')
    <div class="clearfix"></div>
    <!-- Header Container / End -->

    <!-- Content Container
    ================================================== -->

    <div class="container">
        <div class="login-container">

            <!--Tab -->
            <div class="my-account style-1" id="login_form">

                @if(Session::has('success'))
                    <div class="alert alert-success">
                        <h4>{{Session::get('success')}}</h4>
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                        <h4>{!!Session::get('error')!!}</h4>
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <h4>Something went wrong. Please review the form and correct the required fields.</h4>
                    </div>
                @endif

                <ul class="tabs-nav">
                    <li id="login_tab"><a href="#tab1">Log In</a></li>
                    <li id="register_tab"><a href="#tab2">Register</a></li>
                </ul>

                <div class="tabs-container alt">

                    <!-- Login -->
                    <div class="tab-content" id="tab1" style="display: none;">
                        @component('components.social-buttons', ['type' => 'login'])
                        @endcomponent
                        <form method="post" class="login" action="{{url('/')}}/login-user">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="client_id" value="{{$constants['client_id']}}">
                            <p class="form-row form-row-wide">
                                <label for="username">Email Address:
                                    <input type="email" class="input-text" name="username" id="username" placeholder="Email Address" required />
                                </label>
                            </p>
                            <p class="form-row form-row-wide">
                                <label for="password">Password:
                                    <input class="input-text" type="password" name="password" id="password" placeholder="Password" required />
                                </label>
                            </p>
                            <div class="checkboxes in-row password-checkbox">
                                <input id="show_password" name="show_password" type="checkbox" onclick="togglePassword('password')">
                                <label for="show_password">Show Password</label>
                            </div>
                            <div class="checkboxes in-row password-checkbox">
                                <input type="checkbox" id="remember-email-check" name="remember-email-check" onclick="rememberEmail()">
                                <label for="remember-email-check">Remember my email</label>
                            </div>
                            <p class="form-row">
                                <input type="submit" onclick="checkRememberEmail()" class="btn btn-primary w-100 m-0" name="login" value="Login" />
                            </p>
                            <p class="lost_password text-center">
                                <a href="{{url('/')}}/reset-password">Lost Your Password?</a>
                            </p>
                        </form>
                    </div>

                    <!-- Register -->
                    <div class="tab-content" id="tab2" style="display: none;">
                        <div class="register-info" style="margin-bottom: 10px;">
                            After registering your account, you will be required to submit information to verify your account within seven days. Please have documents and identification available for upload.
                        </div>
                        <div class="register-info" style="margin-bottom: 30px;">
                            <span class="required">*</span>All fields are required.
                        </div>
                        @if (!Session::get('social_id'))
                            @component('components.social-buttons', ['type' => 'register'])
                            @endcomponent
                        @endif
                        <form method="post" class="register" action="{{url('/')}}/register-user" enctype="multipart/form-data" onsubmit="return validate_registration()" autocomplete="off" onkeydown="return event.key != 'Enter';">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="client_id" id="client_id" value="{{$constants['client_id']}}">
                            <input type="hidden" name="social_id" id="social_id" value="{{Session::get('social_id')}}">
                            <input type="hidden" name="login_type" id="login_type" value="{{Session::get('login_type')}}">

                            <p class="form-row form-row-wide">
                                <label for="user_type required">Account Type:
                                    <select type="text" class="input-text validate {{ $errors->has('user_type') ? 'form-error' : ''}}" onchange="get_form(this.value)" name="user_type" id="user_type" autocomplete="off">
                                        <option label="" selected>Select Account Type</option>

                                        <option value="2" @if(Session::get('type')=="2" ) selected @endif>Agency</option>
                                        <option value="4" @if(Session::get('type')=="4" ) selected @endif>Co-Host</option>
                                        <option value="0" @if(Session::get('type')=="0" ) selected @endif>Healthcare Traveler</option>
                                        <option value="1" @if(Session::get('type')=="1" ) selected @endif>Property Owner</option>
                                        <option value="3" @if(Session::get('type')=="3" ) selected @endif>RV Healthcare Traveler</option>

                                    </select>
                                </label>
                                {!! $errors->first('user_type', '<p class="error-text">:message</p>') !!}
                            </p>

                            <p class="form-row form-row-wide" id="username2_field" style="display: none;">
                                <label for="username2 required">Username:
                                    <input type="text" class="input-text validate {{ $errors->has('username') ? 'form-error' : ''}}" name="username" id="username2" value="{{Session::get('username')}}" placeholder="Username" autocomplete="off" required />
                                </label>
                                {!! $errors->first('username', '<p class="error-text">:message</p>') !!}
                            </p>

                            <p class="form-row form-row-wide" id="email_field" style="display: none;">
                                <label for="email2">
                                    <label id="email-label" class="m-0">Email Address:</label>
                                    <input type="email" class="input-text validate {{ $errors->has('email') ? 'form-error' : ''}}" value="{{Session::get('mail')}}" name="email" id="email2" autocomplete="off" placeholder="Email Address" required @if (Session::get('social_id') && Session::get('mail')) readonly @endif />
                                </label>
                                {!! $errors->first('email', '<p class="error-text">:message</p>') !!}
                            </p>

                            @if (!Session::get('social_id'))
                                <p class="form-row form-row-wide" id="password_field" style="display: none;">
                                    <label for="password1">Password:
                                        <input class="input-text validate {{ $errors->has('password1') ? 'form-error' : ''}}" type="password" data-strength autocomplete="off" name="password1" placeholder="Password" id="password1" required />
                                    </label>
                                <div class="checkboxes in-row password-checkbox">
                                    <input id="show_password_1" name="show_password_1" type="checkbox" onclick="togglePassword('password1')">
                                    <label for="show_password_1">Show Password</label>
                                </div>
                                {!! $errors->first('password1', '<p class="error-text">:message</p>') !!}
                                </p>

                                <div id="password-strength" class="strength" style="display: none;"><span class="strength-span"></span></div>
                                <div id="password-strength-text" class="strength-text" style="display: none;">Passsword is weak</div>

                                <div id="password_message" style="display: none;">
                                    <p><b>Your password must meet the below requirements:</b></p>
                                    <p id="letter" class="invalid-password">At least one lowercase letter</p>
                                    <p id="capital" class="invalid-password">At least one uppercase letter</p>
                                    <p id="number" class="invalid-password">At least one number</p>
                                    <p id="special_character" class="invalid-password">At least one special character (@#^_+=:;><~$!%*?&.)</p>
                                    <p id="length" class="invalid-password">At least 8 characters long</b></p>
                                </div>

                                <p class="form-row form-row-wide" id="password2_field" style="display: none;">
                                    <label for="password2">Repeat Password:
                                        <input class="input-text validate {{ $errors->has('password2') ? 'form-error' : ''}}" autocomplete="off" type="password" name="password2" placeholder="Repeat Password" id="password2" required />
                                    </label>
                                <div class="checkboxes in-row password-checkbox">
                                    <input id="show_password_2" name="show_password_2" type="checkbox" onclick="togglePassword('password2')">
                                    <label for="show_password_2">Show Password</label>
                                </div>
                                {!! $errors->first('password2', '<p class="error-text">:message</p>') !!}
                                </p>
                            @endif

                            <p class="form-row form-row-wide" id="first_name_field" style="display: none;">
                                <label for="username2">First Name:
                                    <label class="register-info" id="name-caption">Your name will not appear in your listing.</label>
                                    <input type="text" class="input-text validate {{ $errors->has('first_name') ? 'form-error' : ''}}" value="{{Session::get('fname')}}" name="first_name" id="first_name" autocomplete="off" placeholder="First Name" required />
                                </label>
                                {!! $errors->first('first_name', '<p class="error-text">:message</p>') !!}
                            </p>

                            <p class="form-row form-row-wide" id="last_name_field" style="display: none;">
                                <label for="username2">Last Name:
                                    <input type="text" class="input-text validate {{ $errors->has('last_name') ? 'form-error' : ''}}" value="{{Session::get('lname')}}" name="last_name" id="last_name" autocomplete="off" placeholder="Last Name" required />
                                </label>
                                {!! $errors->first('last_name', '<p class="error-text">:message</p>') !!}
                            </p>

                            <p class="form-row form-row-wide" id="ethnicity_filed" style="display: none;">
                                <label for="ethnicity">Ethnicity:
                                    <label class="register-info" id="ethnicity-caption">We use this information for identity verification. It will not appear on your public profile.</label>
                                    <select type="text" class="input-text validate {{ $errors->has('ethnicity') ? 'form-error' : ''}}" name="ethnicity" id="ethnicity" autocomplete="off" required>
                                        <option value="" selected>Select Ethnicity</option>
                                        @foreach(ETHNICITY as $ethnicity)
                                            <option value="{{$ethnicity}}" @if(Session::get('ethnicity')==$ethnicity) selected @endif>{{$ethnicity}}</option>
                                        @endforeach

                                    </select>
                                </label>
                                {!! $errors->first('ethnicity', '<p class="error-text">:message</p>') !!}
                            </p>

                            <p class="form-row form-row-wide" id="phone_number_field" style="display: none;">
                                <label for="phone">Mobile Number:
                                    <input type="text" class="masked_phone_us input-text validate {{ $errors->has('phone') ? 'form-error' : ''}}" value="{{Session::get('phone')}}" name="phone" id="phone" placeholder="Mobile Number" required />
                                </label>
                                {!! $errors->first('phone', '<p class="error-text">:message</p>') !!}
                            </p>

                            <p class="form-row form-row-wide" id="work_number_field" style="display: none;">
                                <label for="work">Office Number:
                                    <input type="text" class="masked_phone_us input-text validate {{ $errors->has('work') ? 'form-error' : ''}}" value="{{Session::get('work')}}" name="work" id="work" placeholder="Office Number" />
                                </label>
                                {!! $errors->first('work', '<p class="error-text">:message</p>') !!}
                            </p>

                            <p class="form-row form-row-wide" id="work_title_field" style="display: none;">
                                <label for="work_title">Work Title:
                                    <input type="text" class="input-text validate {{ $errors->has('work_title') ? 'form-error' : ''}}" value="{{Session::get('work_title')}}" name="work_title" placeholder="Work Title" id="work_title" />
                                </label>
                                {!! $errors->first('work_title', '<p class="error-text">:message</p>') !!}
                            </p>

                            <p class="form-row form-row-wide" id="website_field" style="display: none;">
                                <label for="website">Agency URL:
                                    <input type="text" class="input-text validate {{ $errors->has('website') ? 'form-error' : ''}}" value="{{Session::get('website')}}" name="website" placeholder="Agency URL" id="website" />
                                </label>
                                {!! $errors->first('website', '<p class="error-text">:message</p>') !!}
                            </p>

                            <p class="form-row form-row-wide label-margin" id="dob_field" style="display: none;">
                                <label for="dob">Date of Birth:
                                    <input type="date" onchange="on_dob_change(this.value)" class="input-text validate {{ $errors->has('dob') ? 'form-error' : ''}}" value="{{Session::get('dob')}}" name="dob" id="dob" autocomplete="off" required />
                                </label>
                            {!! $errors->first('dob', '<p class="error-text">:message</p>') !!}
                            <p id="dob_validation_error" style="margin-bottom: 20px;"></p>
                            </p>

                            <p class="form-row form-row-wide" id="gender_field" style="display: none;">
                                <label for="gender">Gender:
                                    <select type="text" class="input-text validate {{ $errors->has('gender') ? 'form-error' : ''}}" name="gender" id="gender" autocomplete="off" required>
                                        <option value="Female" @if(Session::get('gender')=='Female' ) selected @endif>Female</option>
                                        <option value="Male" @if(Session::get('gender')=='Male' ) selected @endif>Male</option>
                                        <option value="Neutral" @if(Session::get('gender')=='Neutral' ) selected @endif>Neutral</option>
                                    </select>
                                </label>
                                {!! $errors->first('gender', '<p class="error-text">:message</p>') !!}
                            </p>

                            <p class="form-row form-row-wide" id="languages_field" style="display: none;">
                                <label for="languages_known">Languages Known:
                                    <input type="text" class="input-text validate" value="{{Session::get('languages_known')}}" name="languages_known" id="languages_known" placeholder="English, Spanish" autocomplete="off" required />
                                </label>
                                {!! $errors->first('languages_known', '<p class="error-text">:message</p>') !!}
                            </p>

                            <p class="form-row form-row-wide" id="occupation_field" style="display: none;">
                                <label for="occupation">Occupation:
                                    <select class="input-text validate" autocomplete="off" name="occupation" id="occupation">
                                        <option label="" value="">Select Occupation</option>
                                        @foreach($occupation as $a)
                                            <option value="{{$a->name}}" @if(Session::get('occupation')===$a->name) selected @endif>{{$a->name}}</option>
                                        @endforeach
                                    </select>
                                </label>
                            <div id="add_another_occupation" class="add-another" onclick="add_another_occupation(true)" style="cursor: pointer;">Can't find it? Add it here.</div>
                            <input type="text" style="display: none;" class="input-text validate" name="other_occupation" id="other_occupation"  value="{{Session::get('other_occupation')}}" placeholder="Other Occupation" autocomplete="off">
                            <div style="display: none;" id="other_occupation_cancel" class="add-another" onclick="add_another_occupation()" style="cursor: pointer;">Cancel</div>
                            {!! $errors->first('occupation', '<p class="error-text">:message</p>') !!}
                            </p>

                            <p class="form-row form-row-wide" id="agency_show" style="display: none;">
                                <label for="agency_name" style="margin-bottom: 0;">Agency you work for:</label>
                                <label class="register-info" id="agency-caption">Select as many agencies that you have worked for in the last 12 months.</label>
                                <span class="autocomplete-select"></span>
                            <div id="add_another_agency" class="add-another" onclick="add_another_agency(true)" style="cursor: pointer;">Can't find it? Add it here.</div>
                            <input type="hidden" name="name_of_agency" id="name_of_agency" value="">
                            <input type="text" style="display: none;" class="input-text validate" name="other_agency" id="other_agency" value="{{Session::get('other_agency')}}" placeholder="Other agency" autocomplete="off">
                            <div style="display: none;" id="other_agency_cancel" class="add-another" onclick="add_another_agency()" style="cursor: pointer;">Cancel</div>
                            {!! $errors->first('name_of_agency', '<p class="error-text">:message</p>') !!}
                            </p>

                            <p class="form-row form-row-wide" id="tax_home_field" style="display: none;">
                                <label for="tax_home">Tax Home:
                                    <input type="text" class="input-text validate {{ $errors->has('tax_home') ? 'form-error' : ''}}" value="{{Session::get('tax_home')}}" name="tax_home" id="tax_home" placeholder="City, State" autocomplete="off" style="padding-left: 20px;" @if(Session::has('tax_home')) data-is-valid="true" @endif />
                                </label>
                                {!! $errors->first('tax_home', '<p class="error-text">:message</p>') !!}
                            </p>
                            <div class="error-text" id="tax_home_error" style="display: none;">Please select a valid address from the suggestions.</div>

                            <p class="form-row form-row-wide" id="address_field" style="display: none;">
                                <label for="address">
                                    <label id="address_label" class="m-0">Address:</label>
                                    <input type="text" class="input-text validate {{ $errors->has('address') ? 'form-error' : ''}}" value="{{Session::get('address')}}" name="address" id="address" placeholder="Full Street Address" autocomplete="off" style="padding-left: 20px;" @if(Session::has('address')) data-is-valid="true" @endif />
                                </label>
                                {!! $errors->first('address', '<p class="error-text">:message</p>') !!}
                            </p>
                            <div class="error-text" id="address_error" style="display: none;">Please select a valid address from the suggestions.</div>

                            <div>
                                <input class="field" type="hidden" id="street_number" name="street_number" value="{{Session::get('street_number')}}" />
                                <input class="field" type="hidden" id="route" name="route" value="{{Session::get('route')}}" />
                                <input class="field" type="hidden" id="locality" name="city" value="{{Session::get('city')}}" />
                                <input class="field" type="hidden" id="administrative_area_level_1" name="state" value="{{Session::get('state')}}" />
                                <input class="field" type="hidden" id="postal_code" name="pin_code" value="{{Session::get('pin_code')}}" />
                                <input class="field" type="hidden" id="country" name="country" value="{{Session::get('country')}}" />
                            </div>

                            <label for="add_apt" id="add_apt_number_field" style="display: none; margin-top: -10px;">
                                <input type="text" class="input-text validate {{ $errors->has('address_line_2') ? 'form-error' : ''}}" value="{{Session::get('address_line_2')}}" name="address_line_2" id="address_line_2" placeholder="Apt, Unit, Suite, or Floor #" style="padding-left: 20px;" />
                            </label>
                            <div style="width: 100%; display: inline-block;">
                                <button id="remove_add_apt_number" onclick="on_remove_address_line_2(event)" class="button" style="display: none;">Don't Add</button>
                            </div>
                            <button id="btn_add_apt_number" onclick="on_add_address_line_2(event)" class="btn btn-primary w-100" style="margin-bottom: 30px; margin-top: -40px; display: none;">Add an Apt or Floor #</button>

                            {{--                            <p class="form-row form-row-wide" id="listing_address_field" style="display: none;">--}}
                            {{--                                <label for="listing_address">Listing Address:--}}
                            {{--                                    <input type="text" class="input-text validate {{ $errors->has('listing_address') ? 'form-error' : ''}}" value="{{Session::get('listing_address')}}" name="listing_address" id="listing_address" placeholder="Full Street Address" autocomplete="off" style="padding-left: 20px;" @if(Session::has('listing_address')) data-is-valid="true" @endif />--}}
                            {{--                                </label>--}}
                            {{--                                {!! $errors->first('listing_address', '<p class="error-text">:message</p>') !!}--}}
                            {{--                            </p>--}}
                            {{--                            <div class="error-text" id="listing_address_error" style="display: none;">Please select a valid address from the suggestions.</div>--}}

                            <div id="is_pet" class="checkboxes in-row password-checkbox" style="margin-top: 0; display: none;">
                                <input id="is_pet_checked" name="is_pet_travelling" type="checkbox" @if(Session::get('is_pet_travelling')) checked @endif>
                                <label for="is_pet_checked">Do you travel with a pet?</label>
                            </div>

                            <div id="pet_details" style="display: none;">
                                <label for="pet_name">Name:
                                    <input type="text" class="input-text validate {{ $errors->has('pet_name') ? 'form-error' : ''}}" value="{{Session::get('pet_name')}}" name="pet_name" id="pet_name" placeholder="Name" autocomplete="off"/>
                                </label>
                                {!! $errors->first('pet_name', '<p class="error-text">:message</p>') !!}

                                <label for="pet_breed">Breed:
                                    <input type="text" class="input-text validate {{ $errors->has('pet_breed') ? 'form-error' : ''}}" value="{{Session::get('pet_breed')}}" name="pet_breed" id="pet_breed" placeholder="Breed" autocomplete="off"/>
                                </label>
                                {!! $errors->first('pet_breed', '<p class="error-text">:message</p>') !!}

                                <label for="pet_weight">Weight:
                                    <input type="text" class="price_float input-text validate {{ $errors->has('pet_weight') ? 'form-error' : ''}}" value="{{Session::get('pet_weight')}}" name="pet_weight" id="pet_weight" placeholder="Weight" autocomplete="off"/>
                                </label>
                                {!! $errors->first('pet_weight', '<p class="error-text">:message</p>') !!}

                                <label for="pet_image">Pet Image:
                                    <input type="file" name="pet_image" id="pet_image" class="form-control" accept="image/*" style="padding-top: 14px;"/>
                                </label>
                                {!! $errors->first('pet_image', '<p class="error-text">:message</p>') !!}
                            </div>

                    </div>
                    <div class="checkboxes" id="email_opt_field" style="display: none;">
                        <input id="email_opt" type="checkbox" name="email_opt" @if(Session::has('email_opt')) checked @endif">
                        <label for="email_opt">I don’t want to receive marketing messages and offers from Health Care Travels. I can also opt out of receiving these at any time by emailing
                            <a href="mailto:support@healthcaretravels.com">support@healthcaretravels.com.</a>
                            {{--                                {!! $errors->first('email_opt', '<p class="error-text-accept">:message</p>') !!}--}}
                        </label>
                    </div>

                    <div class="checkboxes" id="policy_accept_field" style="display: none;">
                        <input id="policy_accept" type="checkbox" name="policy_accept" @if(Session::has('policy_accept')) checked @endif">
                        <label for="policy_accept">
                            By checking and selecting Agree and Register below, I agree to Health Care Travels <a href="{{URL('/')}}/terms-of-use">Terms of Service</a>, <a href="{{URL('/')}}/payment-terms">Payments Terms of Service</a>, <a href="{{URL('/')}}/policies">Privacy Policy</a>, and <a href="{{URL('/')}}/non-discrimination-policy">Nondiscrimination Policy.</a>
                            {!! $errors->first('policy_accept', '<p class="error-text-accept">Policy must be agreed</p>') !!}
                        </label>

                    </div>
                    <div id="recaptcha-block" class="g-recaptcha" style="display: none" data-sitekey="{{RECAPTCHA_SITE_KEY}}" data-expired-callback="recaptcha_expired_callback" data-callback="recaptcha_callback">
                    </div>
                    <p class="form-row" id="register_button_field" style="display: none;">
                        <input type="submit" id="reg_button" class="btn btn-primary w-100" name="register" value="Agree and Register" disabled />
                    </p>

                    </form>
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

{{--<script src="https://maps.google.com/maps/api/js?key={{GOOGLE_MAPS_API_KEY}}=places" type="text/javascript"></script>--}}

<script type="text/javascript">
    var allAgencies = [];
    var agencyAutoComplete;
    var isLocalHost = window.location.origin.indexOf('localhost') !== -1;
    var isLocalIP = window.location.origin.indexOf('127.0.0.1') !== -1;
    var isLocal = isLocalHost || isLocalIP;

    function recaptcha_expired_callback(data) {
        $('#reg_button').prop("disabled", true);
    }

    function recaptcha_callback(data) {
        verifyServerSide(data, function(error, data) {
            if (!error) {
                $('#reg_button').prop("disabled", false);
            } else {
                alert('failed to verify recaptcha: ', error);
            }
        });
    }

    function verifyServerSide(token, cb) {
        var formData = {
            token: token,
            _token: '{{ csrf_token() }}'
        };
        $.ajax({
            url: "/verify_recaptcha",
            type: "POST",
            data: formData,
            json: true,
            success: function(data, textStatus, jqXHR) {
                if (data.success) {
                    cb(null, data);
                } else {
                    cb(data);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                cb(errorThrown);
            }
        });
    }
    $(document).ready(() => {
        load_agencies();
        set_max_date();
        checkRememberEmail(true);

        if ("{{ Session::get('selectedTab'), 'tab1' }}" === 'tab2') {
            $('#login_tab').removeClass('active');
            $('#register_tab').addClass('active');
            $('#tab1').hide();
            $('#tab2').show();
        }

        get_form("{{ Session::get('type') }}", true);

        let dob_value = "{{Session::get('dob')}}";
        if (dob_value) {
            on_dob_change(dob_value);
        }

        let address_line_2 = "{{Session::get('address_line_2')}}";
        if (address_line_2) {
            on_add_address_line_2(undefined, address_line_2);
        }

        let other_agency = "{{Session::get('other_agency')}}";
        if (other_agency) {
            add_another_agency(true);
        }

        let occupation = "{{Session::get('other_occupation')}}";
        if (occupation) {
            add_another_occupation(true);
        }
    })

    let addressFields = [];

    function get_form(data, isInitial = false) {
        if (!isInitial) {
            clear_errors();
        }
        switch (data) {
            case "0": // Healthcare Traveler
            case "3": // RV Healthcare Traveler
                $('#recaptcha-block').show();
                $('#username2_field').show();
                $('#email_field').show();
                $('#password_field').show();
                $('#password2_field').show();
                $('#tab2 .password-checkbox').show();
                $('#first_name_field').show();
                $('#last_name_field').show();
                $('#ethnicity_filed').show();
                $('#ethnicity-caption').show();
                $('#phone_number_field').show();
                $('#dob_field').show();
                $('#gender_field').show();
                $('#languages_field').show();
                $('#occupation_field').show();
                $('#add_another_occupation').show();
                $('#other_occupation').hide();
                $('#other_occupation_cancel').hide();
                $('#agency_show').show();
                $('#add_another_agency').show();
                $('#other_agency').hide();
                $('#other_agency_cancel').hide();
                $('#agency-caption').show();
                $('#tax_home_field').show();
                $('#address_field').show();
                $('#btn_add_apt_number').show();
                $('#add_apt_number_field').hide();
                $('#remove_add_apt_number').hide();
                $('#email_opt_field').show();
                $('#policy_accept_field').show();
                $('#register_button_field').show();
                $('#name-caption').hide();
                $('#work_title_field').hide();
                $('#work_number_field').hide();
                $('#website_field').hide();
                $('#is_pet').show();
                $('#pet_details').hide();

                $('#email-label').text('Email Address:');
                $('#address_label').text('Address:');
                $("#address").attr('placeholder', "Full Street Address");

                addressFields = ['tax_home', 'address']

                break;

            case "1": // Property Owner
            case "4": // Co-host
                $('#recaptcha-block').show();
                $('#username2_field').show();
                $('#email_field').show();
                $('#password_field').show();
                $('#password2_field').show();
                $('#tab2 .password-checkbox').show();
                $('#first_name_field').show();
                $('#last_name_field').show();
                $('#ethnicity_filed').show();
                $('#ethnicity-caption').show();
                $('#phone_number_field').show();
                $('#dob_field').show();
                $('#gender_field').show();
                $('#languages_field').show();
                $('#occupation_field').hide();
                $('#add_another_occupation').hide();
                $('#other_occupation').hide();
                $('#other_occupation_cancel').hide();
                $('#agency_show').hide();
                $('#add_another_agency').hide();
                $('#other_agency').hide();
                $('#other_agency_cancel').hide();
                $('#agency-caption').hide();
                $('#tax_home_field').hide();
                $('#address_field').show();
                $('#btn_add_apt_number').show();
                $('#add_apt_number_field').hide();
                $('#remove_add_apt_number').hide();
                $('#email_opt_field').show();
                $('#policy_accept_field').show();
                $('#register_button_field').show();
                $('#name-caption').show();
                $('#work_title_field').hide();
                $('#work_number_field').hide();
                $('#website_field').hide();
                $('#is_pet').hide();
                $('#is_pet_checked').attr('checked', false);
                $('#pet_details').hide();

                $('#email-label').text('Email Address:');
                $('#address_label').text('Mailing Address:');

                addressFields = ['address']

                break;

            case "2": // Agency
                $('#recaptcha-block').show();
                $('#username2_field').show();
                $('#email_field').show();
                $('#password_field').show();
                $('#password2_field').show();
                $('#tab2 .password-checkbox').show();
                $('#first_name_field').show();
                $('#last_name_field').show();
                $('#ethnicity_filed').show();
                $('#ethnicity-caption').show();
                $('#phone_number_field').show();
                $('#dob_field').show();
                $('#gender_field').show();
                $('#languages_field').show();
                $('#occupation_field').hide();
                $('#add_another_occupation').hide();
                $('#other_occupation').hide();
                $('#other_occupation_cancel').hide();
                $('#agency_show').show();
                $('#add_another_agency').show();
                $('#other_agency').hide();
                $('#other_agency_cancel').hide();
                $('#agency-caption').hide();
                $('#tax_home_field').hide();
                $('#address_field').hide();
                $('#btn_add_apt_number').hide();
                $('#add_apt_number_field').hide();
                $('#remove_add_apt_number').hide();
                $('#email_opt_field').show();
                $('#policy_accept_field').show();
                $('#register_button_field').show();
                $('#name-caption').hide();
                $('#work_title_field').show();
                $('#work_number_field').show();
                $('#website_field').show();
                $('#is_pet').hide();
                $('#is_pet_checked').attr('checked', false);
                $('#pet_details').hide();

                $('#email-label').text('Work Email Address:');
                $('#email2').val("{{Session::get('mail')}}");
                $('#address_label').text('Address:');

                addressFields = [];

                break;

            default:
                $('#recaptcha-block').hide();
                $('#username2_field').hide();
                $('#email_field').hide();
                $('#password_field').hide();
                $('#password2_field').hide();
                $("#password-strength, #password-strength-text, #password_message").hide();
                $('#tab2 .password-checkbox').hide();
                $('#first_name_field').hide();
                $('#last_name_field').hide();
                $('#ethnicity_filed').hide();
                $('#ethnicity-caption').hide();
                $('#phone_number_field').hide();
                $('#dob_field').hide();
                $('#gender_field').hide();
                $('#languages_field').hide();
                $('#occupation_field').hide();
                $('#add_another_occupation').hide();
                $('#other_occupation').hide();
                $('#other_occupation_cancel').hide();
                $('#agency_show').hide();
                $('#add_another_agency').hide();
                $('#other_agency').hide();
                $('#other_agency_cancel').hide();
                $('#agency-caption').hide();
                $('#tax_home_field').hide();
                $('#address_field').hide();
                $('#btn_add_apt_number').hide();
                $('#add_apt_number_field').hide();
                $('#remove_add_apt_number').hide();
                $('#email_opt_field').hide();
                $('#policy_accept_field').hide();
                $('#register_button_field').hide();
                $('#name-caption').hide();
                $('#work_title_field').hide();
                $('#work_number_field').hide();
                $('#website_field').hide();
                $('#is_pet').hide();
                $('#is_pet_checked').attr('checked', false);
                $('#pet_details').hide();

                $('#email-label').text('Email Address:');
                $('#address_label').text('Address:');

                addressFields = [];
                break;
        }
        initialize();
        $("#is_pet_checked").trigger('change');
    }

    function initialize() {
        var componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'long_name',
            administrative_area_level_1: 'long_name',
            country: 'short_name',
            postal_code: 'short_name'
        };


        let options = {
            componentRestrictions: {
                country: 'us'
            }
        };
        let options_tax_home = {
            types: ['(cities)'],
            componentRestrictions: {
                country: 'us'
            }
        };
        try {
            for (field in addressFields) {
                let element_address = document.getElementById(addressFields[field]);
                let element_address_error = document.getElementById(`${addressFields[field]}_error`);
                if (element_address) {
                    google.maps.event.addDomListener(element_address, 'keypress', (event) => {
                        if (event.keyCode === 13) {
                            event.preventDefault();
                        } else if (element_address.dataset.isValid) {
                            delete element_address.dataset.isValid;
                            if (element_address.name === 'address') {
                                for (var component in componentForm) {
                                    document.getElementById(component).value = '';
                                }
                            }
                        }
                    });
                    let autocomplete_address = new google.maps.places.Autocomplete(element_address, (addressFields[field] === 'tax_home') ? options_tax_home : options);
                    autocomplete_address.addListener('place_changed', (e) => {
                        if (element_address.name === 'address') {
                            var place = autocomplete_address.getPlace();

                            for (var i = 0; i < place.address_components.length; i++) {
                                var addressType = place.address_components[i].types[0];
                                if (componentForm[addressType]) {
                                    var val = place.address_components[i][componentForm[addressType]];
                                    document.getElementById(addressType).value = val;
                                }
                            }
                        }

                        element_address.style.borderColor = '#e0e0e0';
                        element_address_error.style.display = "none";
                        element_address.dataset.isValid = true;
                    });
                }
            }
        } catch (e) {}
    }

    function clear_errors() {
        $(".form-error").removeClass('form-error');
        $(".error-text").hide();
    }

    function set_max_date() {
        let dd = new Date().getDate();
        let mm = new Date().getMonth() + 1;
        let yyyy = new Date().getFullYear();
        document.getElementById("dob").max = `${yyyy}-${ mm<10 ? '0'+mm : mm }-${ dd<10 ? '0'+dd : dd }`;
    }

    function on_dob_change(value) {
        const dateString = value;
        let today = new Date();
        let birthDate = new Date(dateString);
        let age = today.getFullYear() - birthDate.getFullYear();
        let m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        if (age < 18 || age > 100) {
            $('#dob_validation_error').html('You must be 18 or older to register online. Contact <br>​<a href="mailto:{{VERIFY_MAIL}}">{{VERIFY_MAIL}}</a> to create a minor account.')
        } else {
            $('#dob_validation_error').html('');
        }
    }

    function on_add_address_line_2(e, value = '') {
        if (e) {
            e.preventDefault();
        }
        $('#add_apt_number_field').show();
        $('#remove_add_apt_number').show();
        $('#btn_add_apt_number').hide();
        $('#address_line_2').val(value);
    }

    function on_remove_address_line_2(e) {
        if (e) {
            e.preventDefault();
        }
        $('#add_apt_number_field').hide();
        $('#remove_add_apt_number').hide();
        $('#btn_add_apt_number').show();
        $('#address_line_2').val('');
    }

    $('#is_pet_checked').change(function () {
        var isChecked= $(this).is(':checked');
        if(isChecked) {
            $('#pet_details').show();
        } else {
            $('#pet_details').hide();
        }
    });

    $('.price_float').change(function(){
        var value = parseFloat(this.value);
        this.value = isNaN(value) ? 0 : value;
    });


    $('.price_float').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $('#phone, #work_number_field').on('keypress', function(event) {
        var regex = new RegExp("^[0-9+]$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    function add_another_agency(show = false) {
        if(show) {
            $('#add_another_agency').hide();
            $('#other_agency').show();
            $('#other_agency_cancel').show();
        } else {
            $('#add_another_agency').show();
            $('#other_agency').hide();
            $('#other_agency_cancel').hide();
            $('#other_agency').val('');
        }
    }

    function add_another_occupation(show = false) {
        if(show) {
            $('#add_another_occupation').hide();
            $('#other_occupation').show();
            $('#other_occupation_cancel').show();
        } else {
            $('#add_another_occupation').show();
            $('#other_occupation').hide();
            $('#other_occupation_cancel').hide();
            $('#other_occupation').val('');
        }
    }

    function load_agencies() {
        var agencies = <?php echo json_encode($agency); ?>;
        allAgencies = agencies;
        initPureSelect(agencies);
    }

    function initPureSelect(agencies, selected) {
        var selected_agencies = "{{Session::get('name_of_agency')}}";
        selected_agencies = selected_agencies ? selected_agencies.split(',') : [];
        if (selected) {
            selected_agencies = selected;
        }
        var mappedData = agencies.map(a => ({
            label: a.name,
            value: a.name
        }));
        $('.autocomplete-select').empty();
        var autocomplete = new SelectPure(".autocomplete-select", {
            options: mappedData,
            value: selected_agencies,
            multiple: true,
            autocomplete: true,
            icon: "fa fa-times",
            placeholder: "Select Agencies",
        });
        agencyAutoComplete = autocomplete;
    }

    function validate_registration() {
        if ("{{APP_ENV}}" === "local") {
            $('#name_of_agency').val(agencyAutoComplete.value());
            return true; // escape validation for local
        }
        let dob_error = $('#dob_validation_error').html();
        if(dob_error) {
            $(window).scrollTop($('#dob').offset().top-100);
            return false;
        }
        let allFields = addressFields.filter(e => {
            let element_address = document.getElementById(e);
            let invalidAddress = !element_address.value || (element_address.value && !element_address.dataset.isValid);
            if(invalidAddress) {
                $(`#${e}`).css('border-color', '#ff0000');
                $(`#${e}_error`).show();
            }
            return invalidAddress;
        })
        if(allFields.length && !isLocal) {
            $(window).scrollTop($(`#${allFields[0]}`).offset().top-100);
            return false;
        }
        $('#name_of_agency').val(agencyAutoComplete.value());
        return true;
    }

    let strength = 0;

    function passwordCheck(password) {
        if (password.match(/(?=.*[a-z])/)) {
            strength += 1;
            $('#letter').removeClass('invalid-password').addClass('valid-password');
        } else {
            $('#letter').removeClass('valid-password').addClass('invalid-password');
        }

        if (password.match(/(?=.*[A-Z])/)) {
            strength += 1;
            $('#capital').removeClass('invalid-password').addClass('valid-password');
        } else {
            $('#capital').removeClass('valid-password').addClass('invalid-password');
        }

        if (password.match(/(?=.*[0-9])/)) {
            strength += 1;
            $('#number').removeClass('invalid-password').addClass('valid-password');
        } else {
            $('#number').removeClass('valid-password').addClass('invalid-password');
        }

        if (password.length >= 8) {
            strength += 1;
            $('#length').removeClass('invalid-password').addClass('valid-password');
        } else {
            $('#length').removeClass('valid-password').addClass('invalid-password');
        }

        if (password.match(/(?=.*[!,%,&,@,#,$,^,*,?,_,~,<,>,.])/)) {
            strength += 1;
            $('#special_character').removeClass('invalid-password').addClass('valid-password');
        } else {
            $('#special_character').removeClass('valid-password').addClass('invalid-password');
        }

        displayBar(strength);
    }

    function displayBar(strength) {
        switch (strength) {
            case 1:
                $("#password-strength span").css({
                    "width": "20%",
                    "background": "#de1616"
                });
                $("#password-strength-text").text('Password is too weak').css({
                    "color": "#de1616"
                });
                break;

            case 2:
                $("#password-strength span").css({
                    "width": "40%",
                    "background": "#f86564"
                });
                $("#password-strength-text").text('Password is weak').css({
                    "color": "#f86564"
                });
                break;

            case 3:
                $("#password-strength span").css({
                    "width": "60%",
                    "background": "#ffca00"
                });
                $("#password-strength-text").text('Password is not so good').css({
                    "color": "#ffca00"
                });
                break;

            case 4:
                $("#password-strength span").css({
                    "width": "80%",
                    "background": "#FFA200"
                });
                $("#password-strength-text").text('Password is good').css({
                    "color": "#FFA200"
                });
                break;

            case 5:
                $("#password-strength span").css({
                    "width": "100%",
                    "background": "#68b300"
                });
                $("#password-strength-text").text('Password is great!').css({
                    "color": "#68b300"
                });
                break;

            default:
                $("#password-strength span").css({
                    "width": "0",
                    "background": "#de1616"
                });
                $("#password-strength-text").text('').css({
                    "color": "#de1616"
                });
        }
    }

    $("[data-strength]").focus(function() {
        $("#password-strength, #password-strength-text, #password_message").show();
    });

    $("[data-strength]").keyup(function() {
        strength = 0;
        var password = $(this).val();
        passwordCheck(password);
    });

</script>
<script>
    function togglePassword(id) {
        var x = document.getElementById(id);
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function rememberEmail() {
        var isRememberChecked = $('#remember-email-check').is(':checked');
        if (isRememberChecked) {
            var loginUserEmail = $('#username').val();
            setEmailInStorage(loginUserEmail);
        } else {
            setEmailInStorage('');
        }
    }
    function checkRememberEmail(isInitialLoad) {
        var storageEmail = getEmailFromStorage();
        if (storageEmail) {
            if (isInitialLoad) {
                $('#username').val(storageEmail);
                $('#password').val('');
            } else {
                var loginUserEmail = $('#username').val();
                if (loginUserEmail != storageEmail) {
                    setEmailInStorage('');
                }
            }
        }
    }
    function setEmailInStorage(value) {
        return window.localStorage.setItem('email', value);
    }
    function getEmailFromStorage() {
        return window.localStorage.getItem('email');
    }
</script>
</body>

</html>
