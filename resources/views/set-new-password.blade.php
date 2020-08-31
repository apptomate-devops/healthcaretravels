<!DOCTYPE html>
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>Register / Login | {{APP_BASE_NAME}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    @include('includes.styles')
    <link rel="stylesheet" href="{{ URL::asset('css/login.css') }}">

</head>

<body>

    <!-- Wrapper -->
    <div id="wrapper">


        <!-- Header Container
        ================================================== -->
        @include('includes.header')
        <div class="clearfix"></div>
        <!-- Header Container / End -->






        <!-- Contact
        ================================================== -->

        <!-- Container -->
        <div class="container" style="margin-top: 40px;">

            <div class="row">
                <div class="col-md-4 col-md-offset-4">


                    @if (count($errors) > 0)
                    <div class = "alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        <h4>{{ Session::get('success') }}</h4>
                    </div>
                    @endif

                    @if(Session::has('error'))
                    <div class="alert alert-danger">
                        <h4>{{ Session::get('error') }}</h4>
                    </div>
                    @endif

                    <!--Tab -->
                    <div class="my-account style-1 margin-top-5 margin-bottom-40">

                        <ul class="tabs-nav">
                            <li class=""><a href="#tab1">Reset Password</a></li>

                        </ul>

                        <div class="tabs-container alt">

                            <!-- Login -->
                            <div class="tab-content" id="tab1" style="display: none;">
                                <form method="post" action="{{BASE_URL}}new-password" class="login">

                                    @if($error == 1)
                                    <div class="alert alert-danger">
                                        <h4>Your link has been expired</h4>
                                    </div>
                                    @else

                                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                    <input type="hidden" name="email" value="{{$email}}" />
                                    <p class="form-row form-row-wide">
                                        <label for="email">New Password :
                                            <input type="password" class="input-text validate1" name="password" id="email" data-strength value="" />
                                        </label>
                                    </p>

                                        <div id="password-strength" class="strength" style="display: none;"><span class="strength-span"></span></div>
                                        <div id="password-strength-text" class="strength-text" style="display: none;">Passsword is weak</div>

                                        <div id="password_message" style="display: none;">
                                            <div><b>Your password must meet the below requirements:</b></div>
                                            <p id="letter" class="invalid-password">At least one lowercase letter</p>
                                            <p id="capital" class="invalid-password">At least one uppercase letter</p>
                                            <p id="number" class="invalid-password">At least one number</p>
                                            <p id="special_character" class="invalid-password">At least one special character (@#^_+=:;><~$!%*?&.)</p>
                                            <p id="length" class="invalid-password">At least 8 characters long</b></p>
                                        </div>

                                    <p class="form-row form-row-wide">
                                        <label for="email">Confirm Password :
                                            <input type="password" class="input-text validate1" name="confirm_password" id="email" value="" />
                                        </label>
                                    </p>

                                    <p class="form-row">
                                        <input type="submit" id="button" class="button border margin-top-10" name="login" value="Reset Password" />
                                        <a href="http://13.127.130.227/keepers/login" style="float: right;margin-top: 20px;">Back</a>
                                    </p>
                                    @endif



                                </form>
                            </div>

                        </div>
                    </div>





                </div>
            </div>

        </div>
        <!-- Container / End -->



        <!-- Footer
        ================================================== -->
        @include('includes.footer')
        <!-- Footer / End -->


        <!-- Back To Top Button -->
        <div id="backtotop"><a href="#"></a></div>


        <!-- Scripts
        ================================================== -->
        @include('includes.scripts')

        <script>
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

    </div>
    <!-- Wrapper / End -->
</body>
</html>
