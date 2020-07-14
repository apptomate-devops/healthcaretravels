<!DOCTYPE html>
<head>
<!-- Basic Page Needs
================================================== -->
<title>Register / Login | {{APP_BASE_NAME}}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="google-signin-client_id" content="386426447902-4r69c89sditkvcfqikt0led8fe4g4q7v.apps.googleusercontent.com">
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

		<div class="card" style="margin-bottom: 300px;">
			Thank you for registering with Health Care Travels, to complete your registration process please check your <br> email and click on the link that we have provided.” If you did not receive a email please email  us at  <br>​<a href="mailto:support@heatlhcaretravels.com​">{{SUPPORT_MAIL}}</a> for further assistance.”
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


</div>
<!-- Wrapper / End -->
</body>
</html>
