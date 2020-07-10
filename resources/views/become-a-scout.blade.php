
<!DOCTYPE html>
<head>
<!-- Basic Page Needs
================================================== -->
<title>Become a Scout | {{APP_BASE_NAME}}</title>
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
input[type="number"], {
	height: 20px;
	width: 5px;
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
		<center><p style="font-size: 25px;">Become a Scout</p></center>
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

	<!--Tab -->

	<div class="row">
		<center><div class="col-md-12">
			<img src="/image2.jpg">
		</div>
	</center>

	</div>

	<div class="my-account style-1 margin-top-5 margin-bottom-40" id="login_form">

		<!-- Register -->
				<h3>Your Information</h3>
				<p>This is a form to be filled out by those who desire to Scout. If you want to know what a Scout is refer to the FAQ section.</p>
				<form method="post" class="register" action="{{url('/')}}/become-a-scout-save">

				<input type="hidden" name="_token" value="{{csrf_token()}}">

				<!-- <div class="g-signin2" data-width="357" data-onsuccess="onSignIn"></div>
				<br>
					<div class="fb-login-button" data-width="357" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>

					<div style="margin-top: 8px;text-align: center;">OR</div> -->


				<p class="form-row form-row-wide">
					<label for="email2">Email Address:
						<i class="im im-icon-Mail"></i>
						<input type="email" class="input-text validate" name="email" required id="email2" value="" />
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="phone_no">Phone Number:
						<i class="im im-icon-Phone-2"></i>
						<input type="text" class="input-text validate" name="phone_no" required  id="phone_no" value="" />
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="Firstname">Firstname:
						<i class="im im-icon-Male"></i>
						<input type="text" class="input-text validate" name="firstname" required id="Firstname" value=""/>
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="username2">Lastname:
						<i class="im im-icon-Male"></i>
						<input type="text" class="input-text validate" name="lastname" required id="lastname" value=""/>
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="rent">What days are you able to Scout?
						  <div class="checkboxes in-row">
                            <input id="check-2" value="Sun" name="days[]" type="checkbox" checked name="check">
                            <label for="check-2" >Sunday</label>

                            <input id="check-3" name="days[]" value="Mon" type="checkbox" name="check">
                            <label for="check-3">Monday</label>

                            <input id="check-4" name="days[]" value="Tue" type="checkbox" name="check">
                            <label for="check-4"  >Tuesday</label>

                            <input id="check-5" value="Wed" name="days[]" type="checkbox" name="check">
                            <label for="check-5" >Wednesday</label>


                            <input id="check-6" value="Thu" name="days[]" type="checkbox" name="check">
                            <label for="check-6" >Thursday</label>

                            <input id="check-7" value="Fri" name="days[]" type="checkbox" name="check">
                            <label for="check-7" >Friday</label>

                            <input id="check-8" value="Sat" name="days[]" type="checkbox" name="check">
                            <label for="check-8" >Saturday</label>

                        </div>
					</label>
				</p>

				<p class="form">
					<label for="housing">Are you willing to take photos and/or videos?
					</label>
                    <select class="chosen-select-no-single" name="take_photo" required>
                        <option label="blank"></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
				</p>

				<p class="form-row form-row-wide">
					<label for="city">What City do you want to be a Scout?
						<input type="text" class="input-text validate" name="city" id="city"  required value=""/>
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="State">What State is the City in?
						<input type="text" class="input-text validate" name="state" id="State" required value=""/>
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="State">How many miles are you willing to travel? Ex: 40 miles or less
						<input type="text" class="input-text validate" name="miles" id="miles" required value=""/>
					</label>
				</p>

				<p class="form">
					<label for="travel">We may ask for a Photo Copy, License Plate and or car description, so we may know who is entering into host homes and who host should be expecting. Are you willing to provide this information if we ask? *
					</label>
                    <select class="chosen-select-no-single" name="information_check_allows" required>
                        <option label="blank"></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
				</p>

				<p class="form-row" style="margin-top: 10px;">
					<input type="submit" id="reg_button"  class="button border fw margin-top-10" name="register" value="Submit" />
				</p>

				</form>
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
</body>
