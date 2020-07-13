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
    .my-account label i {
    font-size: 21px;
    color: #868383;
    position: absolute;
    left: 15px;
    bottom: 27px;
    font-weight: bolder;
}
.my-account label input {
    margin-top: 8px;
    padding-left: 50px;
    height: 53px;
    width: 355px;
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

    <div class="row">
    <div class="col-md-4 col-md-offset-4">

        @if(Session::has('success'))
            <div class="alert alert-success">
                <h4>{{ Session::get('success') }}</h4>
            </div>
        @endif

        @if(Session::has('error'))
            <div class="alert alert-success">
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


                    
                
                    <center><label>Verify Mobile Number</label></center>
                    <br>
                    <form name="verify_otp" action="{{URL('/')}}/verify_otp" method="post">
                        

                <p class="form-row form-row-wide" id="mobile_chk">
                    <label for="phone_no">Mobile Number:
                        <input type="text" class="input-text validate" value="{{Session::get('phone')}}" placeholder="Mobile Number" style="width:320px" name="phone_no" id="phone_no" value="" /> <input type="button"  name="button border fw" value="Get Otp">
                    </label>
                </p>
                <p id="alert_phone"></p>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <p class="form-row form-row-wide" id="otp_sent" >
                    <label for="phone_no">One Time Password
                        <input type="text" class="input-text validate" placeholder="Otp" style="width:320px" name="otp" id="otp" value="{{Session::get('OTP')}}" required="" />
                        <input type="submit" name="button border fw" value="Verify Otp"><span  style="float:right;margin-top: 10px;background-color: #e78016;border-color: #e78016;" class="btn btn-danger btn-default" id="send_otp">Resend Otp</span>
                    </label>
                </p>
                
                </form>

                

              
                

                </form>
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

$('#mobile_chk').hide();
var otp;
$('#send_otp').click(function(){
        // alert('test');
        var phone_no=$('#phone_no').val();
        // var client_id = $('#client_id').val();
        
        $.ajax({
        type:'GET',
        url:'{{url("/")}}/sent_otp/'+phone_no,
        success:function(status) {  
        // console.log(status); 
           if(status.status == "Failure"){
            $('#alert_phone').css('color','red');
            $('#alert_phone').html("Otp Sent Failed");
           }else{
            otp=status.otp;
             $('#alert_phone').css('color','green');
            $('#alert_phone').html(status.message);
            $('#otp_sent').show();
            $('#mobile_chk').hide();

           }
        },
        error:function(err) {
           alert('Something went wrong. Please check.')
           }
     })

    });

// window.onsubmit = function(){

//     var current_otp=$('#otp').val();

// if(current_otp!=otp){
//     $('#alert_phone').css('color','red');
//      $('#alert_phone').html('Please Check your Otp');
//      return false;
// }    
// }


</script>
</body> 