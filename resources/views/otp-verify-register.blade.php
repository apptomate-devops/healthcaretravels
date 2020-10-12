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

        <div class="row otp-verification">
            <div class="col-md-4 col-md-offset-4">

                @if(Session::has('success'))
                    <div class="alert alert-success">
                        <h4>{{ Session::get('success') }}</h4>
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                        @if(Session::get('error') == "Please Login again to Continue")
                            <h4>Please <a href="{{url('/')}}/login" style="color: white;">Login</a> again to Continue</h4>
                        @else
                            <h4>{{ Session::get('error') }}</h4>
                        @endif
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
                                <input type="text" class="masked_phone_us input-text validate" readonly value="" placeholder="Mobile Number" name="phone_no" id="phone_no" />
                                <input type="button" name="button border fw" value="Submit" id="get_otp">
                            </label>
                        </p>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="user_id" value="{{Session::get('user_id_v')}}">
                        <input type="hidden" name="attempts" value="{{Session::get('attempts')}}">
                        <p class="form-row form-row-wide" id="otp_sent" >
                            <label for="phone_no">
                                <input type="text" class="input-text validate" placeholder="Enter your code here" name="otp" id="otp" value="" required="" />
                            </label>
                        </p>
                        <div id="otp_buttons">
                            <span style="margin-top: 5px;background-color: #e78016;border-color: #e78016;" class="btn btn-danger btn-default" id="send_otp">Send me another code</span>
                            <input type="submit" name="button border fw" value="Submit" style="float:right; margin: 0;">
                            <div style="width: 100%; text-align: right; margin-top: 10px;">
                                <a id="change-phone" class="change-phone-link">Change number</a>
                            </div>
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
        let user_id = "{{Session::get('user_id_v')}}";
        let phone = "{{Session::get('phone_v')}}";
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

    $('#change-phone').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('#mobile_chk').show();
        $('#phone_no').val($('#phone_number').text());
        $('#otp_sent').hide();
        $('#otp_buttons').hide();
        $('#phone_no').removeAttr('readonly');
    });

    $('#get_help').click((e) => {
        e.preventDefault();
        e.stopPropagation();
        alert('Please contact support: {{SUPPORT_MAIL}}');
    });

    $('#send_otp').click(function() {
        $('#mobile_chk').show();
        $('#phone_no').val($('#phone_number').text());
        $('#otp_sent').hide();
        $('#otp_buttons').hide();
        $('#phone_no').attr('readonly', true);
    });

    $('#get_otp').click(() => {

        var phone_no = $('#phone_no').val();
        var user_id = "{{Session::get('user_id_v')}}";
        if(!phone_no || !user_id) {
            alert('Please Login to continue.');
            return;
        }
        var phone = $('.masked_phone_us').inputmask('unmaskedvalue');
        var url = '/sent_otp/' + phone + '/' + user_id;
        $.ajax({
            type:'GET',
            url,
            success: function (response) {
                if(response.status === "Failure") {
                    alert(response.message || 'Something went wrong. Please check.');
                } else {
                    $('#phone_number').text(phone_no);
                    $('#alert_phone').css('color','green');
                    $('#alert_phone').html(response.message);
                    $('#mobile_chk').hide();
                    $('#otp').val('');
                    $('#otp_sent').show();
                    $('#otp_buttons').show();
                }
            },
            error: function (err) {
                alert('Something went wrong. Please check.')
            }
        })
    });
</script>
</body>
