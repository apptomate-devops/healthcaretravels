<!DOCTYPE html>
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>Otp Verify | {{APP_BASE_NAME}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- CSS
    ================================================== -->
    @include('includes.styles')



    <style>
        .otp-verification label {
            width: 100%;
        }
        .otp-verification label input {
            margin-top: 10px;
            height: 53px;
        }
        .btn_get_help {
            width: 150px;
            margin-top: 30px;
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

    <!-- Contact
    ================================================== -->

    <!-- Container -->
    <div class="container" style="margin-top: 40px;">

        <div class="row otp-verification">
            <div class="col-md-4 col-md-offset-4">

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
                    <form name="continue_registration" action="{{URL('/')}}/email-send" method="get">
                        <input type="submit" name="continue_registration" value="Continue Registration" style="width: 100%; margin-top: 10px;">
                    </form>
                @else
                    <form name="verify_otp" action="{{URL('/')}}/verify_otp" method="post">
                        <center><label style="font-weight: 100;"><b>Verification Code: </b> Enter the code we sent to {{COUNTRY_CODE}}<b id="phone_number"></b>.</label></center>
                        <br>
                        <p class="form-row form-row-wide" id="mobile_chk" style="display: none;">
                            <label for="phone_no">Mobile Number:
                                <input type="text" class="input-text validate" readonly value="" placeholder="Mobile Number" name="phone_no" id="phone_no"/>
                                <input type="button" name="button border fw" value="Get Otp" id="get_otp">
                            </label>
                        </p>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="user_id" value="{{Session::get('user_id')}}">
                        <input type="hidden" name="attempts" value="{{Session::get('attempts')}}">
                        <p class="form-row form-row-wide" id="otp_sent" >
                            <label for="phone_no">One Time Password
                                <input type="text" class="input-text validate" placeholder="Otp" name="otp" id="otp" value="" required="" />
                            </label>
                        </p>
                        <div id="otp_buttons">
                            <input type="submit" name="button border fw" value="Submit">
                            <span style="float:right;margin-top: 10px;background-color: #e78016;border-color: #e78016;" class="btn btn-danger btn-default" id="send_otp">Send me another code</span>
                        </div>
                        @if(Session::has('attempts') && Session::get('attempts') > 1)
                            <center><input type="button" class="btn_get_help" onclick="get_help()" id="get_help" value="Get Help"></center>
                        @endif
                    </form>
                @endif
                <div style="height:250px"></div>
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

</div>
<!-- Wrapper / End -->

<script src='https://www.google.com/recaptcha/api.js'></script>

<script type="text/javascript">

    $(document).ready(() => {
        let user_id = "{{Session::get('user_id')}}";
        let phone = "{{Session::get('phone')}}";
        if(phone) {
            $('#phone_number').text(phone);
            $('#phone_no').val(phone);
        } else {
            // Get user's phone number by id
            let url = '{{url("/")}}/get_phone_number/'+user_id;
            $.ajax({
                type: 'GET',
                url,
                success: (response) => {
                    if(response.phone_number) {
                        $('#phone_number').text(response.phone_number);
                        $('#phone_no').val(response.phone_number);
                    }
                },
                error: (error) => {
                    console.log(error);
                }
            })
        }
    });

    $('#get_help').click((e) => {
        e.preventDefault();
        e.stopPropagation();
        alert('Please contact support: {{SUPPORT_MAIL}}');
    });

    $('#send_otp').click(() => {
        $('#mobile_chk').show();
        $('#phone_no').val($('#phone_number').text());
        $('#otp_sent').hide();
        $('#otp_buttons').hide();
    });

    $('#get_otp').click(() => {

        let phone_no=$('#phone_no').val();
        let user_id="{{Session::get('user_id')}}";

        if(!phone_no || !user_id) {
            alert('Please Login to continue.');
            return;
        }

        let url = '{{url("/")}}/sent_otp/'+phone_no+'/'+user_id;

        $.ajax({
            type:'GET',
            url,
            success:(status) => {
                if(status.status === "Failure"){

                    // $('#alert_phone').css('color','red');
                    // $('#alert_phone').html("Otp Sent Failed");
                    alert('Something went wrong. Please check.');

                }else{

                    console.log("OTP == ", status.otp);

                    $('#alert_phone').css('color','green');
                    $('#alert_phone').html(status.message);
                    $('#mobile_chk').hide();
                    $('#otp').val('');
                    $('#otp_sent').show();
                    $('#otp_buttons').show();
                }
            },
            error:(err) => {
                alert('Something went wrong. Please check.')
            }
        })
    });
</script>
</body>
