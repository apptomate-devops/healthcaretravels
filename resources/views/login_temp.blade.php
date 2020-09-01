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
    <style>
        .google-form {
            display: none;
        }
        .my-account {
            width: 500px !important;
        }
    </style>
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
                        {{-- @if (!Session::get('social_id'))
                            @component('components.social-buttons', ['type' => 'register'])
                            @endcomponent
                        @endif --}}
                        <form method="post" class="register" action="{{url('/')}}/register-user" enctype="multipart/form-data" onsubmit="return validate_registration()" autocomplete="off" onkeydown="return event.key != 'Enter';">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="client_id" id="client_id" value="{{$constants['client_id']}}">
                            <input type="hidden" name="social_id" id="social_id" value="{{Session::get('social_id')}}">
                            <input type="hidden" name="login_type" id="login_type" value="{{Session::get('login_type')}}">

                            <p class="form-row form-row-wide">
                                <label for="user_type required">Account Type:
                                    <select type="text" class="input-text validate {{ $errors->has('user_type') ? 'form-error' : ''}}" onchange="get_form(this.value)" name="user_type" id="user_type" autocomplete="off">
                                        <option label="" selected>Select Account Type</option>

                                        <option value="0" @if(Session::get('type')=="0" ) selected @endif>Healthcare Traveler</option>

                                        <option value="1" @if(Session::get('type')=="1" ) selected @endif>Property Owner</option>

                                        <option value="2" @if(Session::get('type')=="2" ) selected @endif>Agency</option>

                                        <option value="3" @if(Session::get('type')=="3" ) selected @endif>RV Healthcare Traveler</option>

                                        <option value="4" @if(Session::get('type')=="4" ) selected @endif>Co-host</option>
                                    </select>
                                </label>
                                {!! $errors->first('user_type', '<p class="error-text">:message</p>') !!}
                            </p>
                            <div class="google-form register-form-wrapper">
                                <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSfAqkiqDWb4SVrS9ySxpGTVRFDTqX2noe3ItyKiGFBYwFmqeg/viewform?embedded=true" width="100%" height="500" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>
                            </div>
                            <div class="google-form rv-form-wrapper">
                                <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSfWnft5cRSmWcyZ23q63C6onr1W0HifZqULU4fej3y9qc2hWw/viewform?embedded=true" width="100%" height="500" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>
                            </div>
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

        var allOccupations = <?php echo json_encode($occupation); ?>;
        let occupation = "{{Session::get('occupation')}}";
        if (occupation && !allOccupations.some(e => e.name === occupation)) {
            add_another_occupation(true);
        }


    })

    let addressFields = [];

    function get_form(data, isInitial = false) {
        if (data == 3) {
            $('.register-form-wrapper').hide();
            $('.rv-form-wrapper').fadeIn();
        } else {
            $('.rv-form-wrapper').hide();
            $('.register-form-wrapper').fadeIn();
        }
        return false;
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
            $('#occupation').hide();
            $('#other_occupation_cancel').show();
            $('#other_occupation').attr('name','occupation');
            $('#occupation').attr('name','other_occupation');
        } else {
            $('#add_another_occupation').show();
            $('#other_occupation').hide();
            $('#occupation').show();
            $('#other_occupation_cancel').hide();
            $('#other_occupation').val('');
            $('#occupation').attr('name','occupation');
            $('#other_occupation').attr('name','other_occupation');
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

        if (password.match(/(?=.*[!,%,&,@,#,$,^,*,?,_,~,<,>,])/)) {
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
