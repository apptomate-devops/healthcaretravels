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
.my-account label input {
    margin-top: 8px;
    padding-left: 50px;
    height: 53px;
    width: 355px;
}
ul, li {
    margin:0;
    padding:0;
    list-style-type:none;
}
#pswd_info {
    position:absolute;
    bottom:138px;
    bottom: -115px\9; /* IE Specific */
    right:-10px;
    width:255px;
    padding:15px;
    background:#fefefe;
    font-size:.875em;
    border-radius:5px;
    z-index: 250;
    box-shadow:0 1px 3px #ccc;
    border:1px solid #ddd;
     display:none;
}
#pswd_info h4 {
    margin:0 0 10px 0;
    padding:0;
    font-weight:normal;
}
#pswd_info::before {
    content: "\25B2";
    position:absolute;
    top:-12px;
    left:45%;
    font-size:14px;
    line-height:14px;
    color:#ddd;
    text-shadow:none;
    display:block;
}

.invalid {
    background:url(https://www.healthcaretravels.com/public/icons/cross.png) no-repeat 0 50%;
    padding-left:22px;
    line-height:24px;
    color:#ec3f41;
}
.valid {
    background:url('https://www.healthcaretravels.com/public/icons/tick.png') no-repeat 0 50%;
    padding-left:22px;
    line-height:24px;
    color:#3a7d34;
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

			<div id="gmail_signup">
			<form method="post" class="login" action="{{url('/')}}/gmail-signup">

				<div id="temp_elements"></div>
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<input type="hidden" name="client_id" value="{{$constants['client_id']}}">
			Welcome to {{APP_BASE_NAME}} your account has been created. <br> Please choose your account type.
			<p class="form-row form-row-wide">
					<label for="user_type">Account Type:
						
						<select type="text" class="input-text validate" onchange="get_form(this.value)" name="user_type" id="user_type" style="width:350px" requiredautocomplete="off" >
						<option label="" selected>Select Account Type</option>

						@if(Session::get('type')==0)
						<option value="0" >Healthcare Traveler</option>
						@else
						<option value="0">Healthcare Traveler</option>
						@endif
						@if(Session::get('type')==1)
						<option value="1" selected>Property Owner</option>
						@else
						<option value="1">Property Owner</option>
						@endif
						@if(Session::get('type')==2)
						<option value="2" selected>Travel Agency</option>
						@else
						<option value="2">Travel Agency</option>
						@endif
					</select>

					</label>
				</p>
			<p class="form-row form-row-wide">
					<label for="email2">Email Address:
						<i class="im im-icon-Mail"></i>
						<input type="email" class="input-text" value="{{Session::get('mail')}}" name="email" id="email3" style="width:350px"autocomplete="off"  />
					</label>
				</p>
				
				<p class="form-row form-row-wide" >
					<label for="password1">Password:
						<i class="im im-icon-Lock-2" ></i>
						<input class="input-text" type="password" autocomplete="off" style="width:350px" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{7,}" title="Password must be at least 7 characters long, 1 upper case, 1 lower case, 1 number and no special characters (ex:$&@.!)" name="password1" id="spassword1"/>
					</label>
					<div id="pswd_info">
				    <h4>Password must meet the following requirements:</h4>
				    <ul>
				        <li id="letter" class="invalid">At least <strong>one letter</strong></li>
				        <li id="capital" class="invalid">At least <strong>one Capital letter</strong></li>
				        <li id="sml_letter" class="invalid">At least <strong>one Small letter</strong></li>
				        <li id="number" class="invalid">At least <strong>one Number</strong></li>
				        <li id="length" class="invalid">Be at least <strong>7 Characters</strong></li>
				    </ul>
				</div>
				</p>				
				
				
				<input id="" type="submit" class="button border margin-top-10" name="login" value="Complete Signup" />
				<br><br>
			</form>
			</div>

	<!--Tab -->
	<div class="my-account style-1 margin-top-5 margin-bottom-40" id="login_form">

		<ul class="tabs-nav">
			<li class=""><a href="#tab1">Log In</a></li>
			<li><a href="#tab2">Register</a></li>
		</ul>

		<div class="tabs-container alt">

			<!-- Login -->
			<div class="tab-content" id="tab1" style="display: none;">
				<form method="post" class="login" action="{{url('/')}}/login-user"  >

					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<input type="hidden" name="client_id" value="{{$constants['client_id']}}">

					<a href="{{url('/')}}/google_auth_login"></a><div class="g-signin2" data-width="357" data-onsuccess="onSignIn"></div></a>
					<br>


					<div class="fb-login-button" data-width="357" onlogin="checkLoginState();" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>

					<div style="margin-top: 8px;text-align: center;">OR</div>
					<p class="form-row form-row-wide">
						<label for="username">Email Address:
							<i class="im im-icon-Male"></i>
							<input type="text" class="input-text" name="username" id="username" placeholder="Email Address">
						</label>
					</p>

					<p class="form-row form-row-wide">
						<label for="password">Password:
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

			<!-- forgot password -->
			<div class="my-accounts tab-content" id="tab3" style="display: none;">

			</div>

			<!-- Register -->
			<div class="tab-content" id="tab2" style="display: none;">

				<form method="post" class="register" action="{{url('/')}}/register-user" autocomplete="off">
					
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				

					<input type="hidden" name="client_id" id="client_id" value="{{$constants['client_id']}}">

				<div class="g-signin2" data-width="357" data-onsuccess="onSignIn"></div>
				<br>
					<div class="fb-login-button" data-width="357" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>
					

					<div style="margin-top: 8px;text-align: center;">OR</div>

					<p class="form-row form-row-wide">
					<label for="user_type">Account Type:
						
						<select type="text" class="input-text validate" onchange="get_form(this.value)" name="user_type" id="user_type" style="width:350px" requiredautocomplete="off" >
						<option label="" selected>Select Account Type</option>

						@if(Session::get('type')==0)
						<option value="0" >Healthcare Traveler</option>
						@else
						<option value="0">Healthcare Traveler</option>
						@endif
						@if(Session::get('type')==1)
						<option value="1" selected>Property Owner</option>
						@else
						<option value="1">Property Owner</option>
						@endif
						@if(Session::get('type')==2)
						<option value="2" selected>Travel Agency</option>
						@else
						<option value="2">Travel Agency</option>
						@endif
					</select>

					</label>
				</p>

				<p class="form-row form-row-wide" id="agency_show" style="display: none;">
					<label for="agency_name">Name of the Agency:
						<select class="input-text validate" autocomplete="off" style="width:350px" name="" id="agency_name">
							<option label="" value="" >Select Agency</option>
							@foreach($agency as $a)
							<option value="{{$a->name}}">{{$a->name}}</option>
							@endforeach
							<option value="Others">Others</option>
						</select>
					</label>
				</p>
				<p class="form-row form-row-wide" >
						<input class="input-text validate" autocomplete="off" id="others_show" type="text" style="width:350px" name="" id=""/>
				</p>

				


				

				<p class="form-row form-row-wide" id="authorised_field" style="display: none;">
					<label for="authorised">Authorised Person Name:
						<input type="text" class="input-text validate" name="authorised" id="authorised" value="{{Session::get('authorised')}}" style="width:350px" requiredautocomplete="off" />
					</label>
				</p>

				<p class="form-row form-row-wide" id="username2_field" style="display: none;">
					<label for="username2">Username:
						<i class="im im-icon-Male"></i>
						<input type="text" class="input-text validate" name="username" id="username2" value="{{Session::get('name')}}" style="width:350px" requiredautocomplete="off" />
					</label>
				</p>
				<p class="form-row form-row-wide" id="first_name_field" style="display: none;">
					<label for="username2">First Name:
						<i class="im im-icon-Male"></i>
						<input type="text" class="input-text validate" value="{{Session::get('fname')}}" name="first_name" id="first_name"  style="width:350px" requiredautocomplete="off" />
					</label>
				</p>
				<p class="form-row form-row-wide" id="last_name_field" style="display: none;">
					<label for="username2">Last Name:
						<i class="im im-icon-Male"></i>
						<input type="text" class="input-text validate" value="{{Session::get('lname')}}" name="last_name" id="last_name"  style="width:350px" requiredautocomplete="off" />
					</label>
				</p>
				<p id="alert_name" style="color: red;"></p>
					
				<p class="form-row form-row-wide">
					<label for="email2">Email Address:
						<i class="im im-icon-Mail"></i>
						<input type="email" class="input-text validate" value="{{Session::get('mail')}}" name="email" id="email2" style="width:350px"autocomplete="off"  />
					</label>
				</p>
				<p id="alert_email" style="color: red;"></p>

				<p class="form-row form-row-wide" >
					<label for="phone_no">Phone Number:
						<i class="im im-icon-Phone-2"></i>
						<input type="text" class="input-text validate" value="{{Session::get('phone')}}" name="phone_no" id="phone_no"  />
					</label>
				</p>
				<p class="form-row form-row-wide" id="occupation_field" style="display: none;">
					<label for="occupation">Occupation:
						<select class="input-text validate" autocomplete="off" style="width:350px" name="occupation" id="occupation">
							<option label="" value="" >Select Occupation</option>
							@foreach($occupation as $a)
							<option value="{{$a->name}}">{{$a->name}}</option>
							@endforeach
							<option value="Others">Others</option>
						</select>
					</label>
				</p>
				<p class="form-row form-row-wide" >
						<input class="input-text validate" autocomplete="off" style="display: none;" id="occupation_desc" placeholder="Occupation Description" type="text" style="width:350px" name="occupation_desc" />
				</p>
				<p class="form-row form-row-wide" >
						<input class="input-text validate" autocomplete="off" style="display: none;" id="others_occupation" placeholder="Occupation" type="text" style="width:350px" name="" />
				</p>
				<p class="form-row form-row-wide" id="dob_field" style="display: none;">
					<label for="dob">Date of Birth:
						<i class="im im-icon-Calendar" style="bottom: 10px;"></i>
						<input type="date" class="input-text validate" value="{{Session::get('dob')}}" name="dob" id="dob" autocomplete="off"  />
					</label>
				</p>

				<p id="alert_phone" style="color: red;"></p>

				{{-- <p class="form-row form-row-wide" id="occupation_field" style="display: none;">
						<label for="occupation">Occupation:
							<i class="im im-icon-Job" style="bottom: 10px;"></i>
							<input type="text" class="input-text validate" value="{{Session::get('occupation')}}" name="occupation"  autocomplete="off"  />
						</label>
				</p> --}}
				<p id="alert_occupation" style="color: red;"></p>
				<p class="form-row form-row-wide" id="address_field" style="display: none;">
						<label for="address">Address:
							
							<input type="text" class="input-text validate" value="{{Session::get('address')}}" name="address" id="address"  autocomplete="off"  />
						</label>
				</p>

				<p id="alert_occupation" style="color: red;"></p>

				

				<p class="form-row form-row-wide" >
					<label for="password1">Password:
						<i class="im im-icon-Lock-2" ></i>
						<input class="input-text validate" type="password" autocomplete="off" style="width:350px" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{7,}" title="Password must be at least 7 characters long, 1 upper case, 1 lower case, 1 number and no special characters (ex:$&@.!)" name="password1" id="password1"/>
					</label>
					<div id="pswd_info">
    <h4>Password must meet the following requirements:</h4>
    <ul>
        <li id="letter" class="invalid">At least <strong>one letter</strong></li>
        <li id="capital" class="invalid">At least <strong>one Capital letter</strong></li>
        <li id="sml_letter" class="invalid">At least <strong>one Small letter</strong></li>
        <li id="number" class="invalid">At least <strong>one Number</strong></li>
        <li id="length" class="invalid">Be at least <strong>7 Characters</strong></li>
    </ul>
</div>
				</p>				
				<p id="alert_pass1" style="color: red;"></p>

				<p class="form-row form-row-wide" >
					<label for="password2">Repeat Password:
						<i class="im im-icon-Lock-2" ></i>
						<input class="input-text validate" autocomplete="off" type="password" style="width:350px" name="password2" id="password2"/>
					</label>
				</p>
				<p id="alert_pass" style="color: red;"></p>

				
				

				<div class="checkboxes">
					<input id="terms_accept" type="checkbox" name="terms_accept" required>
					<label for="terms_accept"> I agree to the <a href="{{URL('/')}}/terms-of-use">Terms of Use</a> and <a href="{{URL('/')}}/policies">Policies</a> </label>
					
				</div>
				{{-- <p class="form-row form-row-wide">
				<div class="g-recaptcha" id="rcaptcha"  data-sitekey="6LcdUVMUAAAAAHf1NDwJ5VG7s3AemNQbXuMHZBsR"></div>
			</p> --}}
			<h4 id="error_Capt"></h4>

				<p class="form-row" style="margin-top: 10px;">
					<input type="submit" id="reg_button"  class="button border fw margin-top-10" name="register" value="Register" />
				</p>

				</form>

			</div>

		</div>
	</div>

	</div>
	</div>

</div>
<!-- Container / End -->
<input type="hidden" name="isGmailButtonClicked" value="0" id="isGmailButtonClicked">

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

function get_form(data){

	//alert(data);
	if(data == 0){
		//alert("0"+data);.attr('disabled','disabled');
		$('#username2_field').hide();
		$('#first_name_field').show();
		$('#last_name_field').show();
		$('#dob_field').show();
		$('#occupation_field').show();
		$('#authorised').attr('disabled','disabled');
		$('#address').attr('disabled','disabled');
		$('#agency_show').show();
		$('#agency_name').attr('name','name_of_agency');
		$('#authorised_field').hide();
		$('#address_field').hide();
	}
	if(data == 1){
		//alert("1"+data);
		$('#username2_field').hide();
		$('#first_name_field').show();
		$('#last_name_field').show();
		$('#address_field').show();
		$('#dob_field').show();
		$('#occupation_field').attr('disabled','disabled');
		$('#agency_show').attr('disabled','disabled');
		$('#authorised').attr('disabled','disabled');
		$('#authorised_field').hide();
		$('#occupation_field').hide();
		$('#agency_show').hide();
	}
	if(data == 2){
		//alert("2"+data);
		$('#username2_field').attr('disabled','disabled');
		$('#first_name_field').attr('disabled','disabled');
		$('#last_name_field').attr('disabled','disabled');
		$('#dob_field').attr('disabled','disabled');
		$('#occupation_field').attr('disabled','disabled');
		$('#agency_name').attr('name','name_of_agency');
		$('#username2_field').hide();
		$('#first_name_field').hide();
		$('#last_name_field').hide();
		$('#dob_field').hide();
		$('#occupation_field').hide();
		$('#agency_show').show();

		

	}
}

$('#others_show').hide();
// $('#agency_show').hide();
$('#agency').hide();
	$('#username2').change(function(){		
        var name=$(this).val();
		if(name == ""){         		
            	$('#alert_name').html("User name should not be empty");
         	}        
	});
	$('#password2').change(function(){	
	
        	var pass2=$(this).val();		
            var pass1 = $('#password1').val();
            if(pass1 != pass2){
               	$('#alert_pass').html("The Password and Repeat doesn't match");
            }        
	});

	$('#phone_no').change(function(){
   		//alert('test');
        var phone_no=$(this).val();
	    var client_id = $('#client_id').val();
		
		$.ajax({
	    type:'GET',
	    url:'{{url("/")}}/check_phone/'+phone_no+'/'+client_id,
	    success:function(status) {  
	    console.log(status);  
	       if(status.status == "Failure"){
          	$('#alert_phone').html("Mobile number is already");
	       }else{

         	$('#alert_phone').html("");

	       }
	    },
	    error:function(err) {
	       alert('Something went wrong. Please check.')
 		   }
	 })

 	})

	$('#email2').change(function(){
   		//alert('test');
        var email=$(this).val();
	    var client_id = $('#client_id').val();
		$.ajax({
	    type:'GET',
	    url:'{{url("/")}}/check_email/'+email+'/'+client_id,
	    success:function(status) {  
	    console.log(status);  
	       if(status.status == "Failure"){
          	$('#alert_email').html("Your Email id is already exist");
	       }else{

         	$('#alert_email').html("");

	       }
	    },
	    error:function(err) {
	       alert('Something went wrong. Please check.')
 		   }
	 })

 })
$('#password1').change(function(){ 
    var value=$(this).val(); 
    
	filter = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{7,}$/;
	if(filter.test(value.value)) {
	  
	  $('#alert_pass1').html("Password atleast 7 characters and 1 upper 1 lower and 1 number");
	 
	}
	else
	  {
	  		$('#alert_pass1').html("");
	   } 
	})

</script>
<script>
$('#agency,#agency_show_single').hide();
	// $('#user_type').change(function(){
	// 	var value=$(this).val();
	// 	if(value==0){
	// 		$('#agency_show').hide();
	// 		$('#agency,#agency_show_single').hide();
	// 		//$('#agency').attr('name','');
	// 		//$('#agency_name').attr('name','name_of_agency');
	// 	}else if(value==2){
	// 		$('#agency_show').show();
	// 		//$('#agency,#agency_show_single').show();
	// 		$('#agency_name').attr('name','name_of_agency');
			
	// 		$('#others_show').hide();
	// 		$('#others_show').attr('name','');
	// 	}else{
	// 		$('#agency_show').hide();
	// 	}
	// });

	$('#agency_name').change(function(){
		var value=$(this).val();
		if(value=="Others"){
			$('#agency,#agency_show_single').hide();
			$('#others_show').show();
			$('#agency').attr('name','');
			$('#others_show').attr('name','name_of_agency');
			$('#agency_name').attr('name','');

		}else{
			$('#agency_name').attr('name','name_of_agency');
			$('#others_show').hide();
		}
	});

	$('#occupation').change(function(){
		var value=$(this).val();
		//alert(value);
		if(value=="Others"){
			$('#others_occupation').show();
			$('#others_occupation').attr('name','occupation');
			$('#occupation').attr('name','');
			$('#occupation_desc').hide();

		}else{
			$('#others_show').hide();
			$('#occupation').attr('name','occupation');
			$('#others_occupation').attr('name','');
			$('#occupation_desc').show();
		}
	});




	$('#owner,#traveller,#agency').change(function(){
            var value=$(this).val();
            if(value==1){
                $('#traveller').attr('checked',false);
                $('#agency').attr('checked',false);
            }else if(value==0){
               $('#owner').attr('checked',false);
               $('#agency').attr('checked',false);
            }else if(value==2){
            	 $('#owner').attr('checked',false);
            	  $('#traveller').attr('checked',false);

            }
        })
	$('#phone_number').on('keypress', function (event) {
		// alert();
   var regex = new RegExp("^[0-9+]$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
}); 
var is_login=0;
$("#button1").click(function () {
// alert("yes")
is_login=1;
var isvalid = true;
        var checki=true;
        $(".validate").each(function () {
            if ($.trim($(this).val()) == '') {
                isValid = false;
                $(this).css({
                    "border-color": "1px solid red",
                    "background": ""
                });
                //alert("Please fill all required fields");
                if (isValid == false){
                   	 // e.preventDefault();
                }
                
            }
            else {
                $(this).css({
                    "border": "2px solid green",
                    "background": ""
                });

            }
        });

if ($("input[type=password]").filter(function () {
	return this.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{7,}$/);
})) {
	$("#alert").text("pass");
	// alert("pass");
	return true;
} else {
	$("#alert").text("fail");
	// alert("fail");
	return false;
}

});


// window.onsubmit = function(){
	
//     var v = grecaptcha.getResponse();

//     if(is_login !=1){
//     if(v.length == 0)
//     {
//         document.getElementById('error_Capt').innerHTML="You can't leave Captcha Code empty";
//         return false;
//     }
//     else
//     {
//          document.getElementById('error_Capt').innerHTML="Captcha completed";
//         return true; 
//     }
// }

    
// }
	//$("#gmail_signup").hide();

	$(document).ready(function() {

    $('#password1').keyup(function() {
    	var pswd = $(this).val();
   	
// console.log("password",pswd);
// var pswd = $(this).val();

if ( pswd.length < 8 ) {
    $('#length').removeClass('valid').addClass('invalid');
} else {
    $('#length').removeClass('invalid').addClass('valid');
}
if ( pswd.match(/[A-z]/) ) {
    $('#letter').removeClass('invalid').addClass('valid');
} else {
    $('#letter').removeClass('valid').addClass('invalid');
}

if ( pswd.match(/[a-z]/) ) {
    $('#sml_letter').removeClass('invalid').addClass('valid');
} else {
    $('#sml_letter').removeClass('valid').addClass('invalid');
}

//validate capital letter
if ( pswd.match(/[A-Z]/) ) {
    $('#capital').removeClass('invalid').addClass('valid');
} else {
    $('#capital').removeClass('valid').addClass('invalid');
}

//validate number
if ( pswd.match(/\d/) ) {
    $('#number').removeClass('invalid').addClass('valid');
} else {
    $('#number').removeClass('valid').addClass('invalid');
}
}).focus(function() {
	
    $('#pswd_info').show();
}).blur(function() {
    $('#pswd_info').hide();
});

});

</script>
<script>

    function make_fb_login(data) {
        if(!data.id){
            return false;
        }
        var URL = 'gmail-login/'+data.id+'?fb=1&image_url='+data.picture.data.url;
        $.ajax({
            type: 'GET',
            url: URL,
            success: function (res_data) {
                console.log(data.status);
                if(res_data.status == 0){
                    $("#gmail_signup").show();
                    $("#login_form").hide();
                    var htm = '<input type="hidden" name="username" value="'+data.name+'" /><input type="hidden" name="fb_id" value="'+data.id+'" /><input type="hidden" name="profile_image" value="'+data.picture.data.url+'" />';
                    $("#temp_elements").html(htm);
                }else{
                    var role = res_data.data.role_id;
                    if(role == 1){
                        window.location.href = window.location.protocol + "//" + window.location.host;
                    }else{
                        window.location.href = window.location.protocol + "//" + window.location.host;
                    }
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }

    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
        FB.api('/me', function(response) {
        var URL = "https://graph.facebook.com/"+response.id+"/?fields=id,name,first_name,last_name,email,picture&access_token=EAAHP0luOxmkBAKQ9j03CEpx7m10rsa8JqWZCO6VVLu6LVF6zZAZCEp90ZBJVWcNa7HIKO2fq1rRt6ZBmzoO6tqxkk9fB08u4d7EK1DYtmbBxcxsUxGZAlnGhcnfsaxtQcLSVFx79ipOQx9raDuZCZBUDcu37G9yIh2fEue6AZBHEraOT5qn5Gd80fvu4CQ5KgZA9AxkR2hSciZC1rep9zlBtqHd";
        	$.ajax({
	            type: 'GET',
	            url: URL,
	            success: function (data) {
	            	console.log(data);
	            	make_fb_login(data);
            	}
            });	
        });
    }

    // This function is called when someone finishes with the Login
    // Button.  See the onlogin handler attached to it in the sample
    // code below.
    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
            console.log(response);
        });
    }



    window.fbAsyncInit = function() {
        FB.init({
            appId      : '509977362876009',
            cookie     : true,  // enable cookies to allow the server to access
            xfbml      : true,  // parse social plugins on this page
            version    : 'v3.3' // use graph api version 2.8
        });


        FB.getLoginStatus(function(response) {
            // statusChangeCallback(response);
        });

    };

    // Load the SDK asynchronously
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


</script>
<input type="hidden" id="u_email" >
<input type="hidden" id="u_image" >
<input type="hidden" id="u_name" >

<script type="text/javascript">


    $("#gmail_signup").hide();

    function makeRedirection(u_email,u_image,u_name){
    	var URL = 'gmail-login/'+u_email+'?image_url='+u_image;
    	console.log('u_email: ' + u_email); // Do not send to your backend! Use an ID token instead.
        console.log('u_image: ' + u_image);
        $.ajax({
            type: 'GET',
            url: URL,
            success: function (data) {
                //Bootstrap  success message
                
                console.log(data.status);
                if(data.status == 0){
                	
                    // new user registration
                    $("#gmail_signup").show();
                    $("#login_form").hide();
                    var htm = '<input type="hidden" name="username" value="'+u_name+'" /><input type="hidden" name="profile_image" value="'+u_image+'" />';
                    $("#email3").val(u_email);
                    $("#temp_elements").html(htm);
                }else{
                    // var role = data.data.role_id;
                    window.location.href = window.location.protocol + "//" + window.location.host;
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
    
    $(".g-signin2").click(function(){

		let u_email = $("#u_email").val();
		let u_image = $("#u_image").val();
		let u_name = $("#u_name").val();
    	makeRedirection(u_email,u_image,u_name);
    });

    function onSignIn(googleUser) {

        var profile = googleUser.getBasicProfile();
        console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
        console.log('Name: ' + profile.getName());
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

		$("#u_email").val(profile.getEmail());
		$("#u_image").val(profile.getImageUrl());
		$("#u_name").val(profile.getName());

        let isGmailButtonClicked = $("#isGmailButtonClicked").val();

        var URL = 'check-gmail-login/'+profile.getEmail();
        $.ajax({
            type: 'GET',
            url: URL,
            success: function (data) 
            {

            	if(data.status == 0){
            		return;
            	}else{
            		makeRedirection();
            	}

            	isGmailButtonClicked = parseInt(isGmailButtonClicked);
            	if (isGmailButtonClicked == 2) {
            		makeRedirection();
            	}
            }
        });
		$("#isGmailButtonClicked").val(2);
    }

    

$("#gmail_signup").hide();
</script>

</body>
</html>