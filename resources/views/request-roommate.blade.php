
@extends('layout.master') 
@section('title') 
Request Roommate | {{APP_BASE_NAME}}
@endsection
@section('main_content')

<div class="container" style="margin-top: 35px;">
    <form action="{{url('/')}}/request_roommate" method="post" >
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="row">

            <div class="col-md-12">

                <div class="style-1">

                     <button class="btn" style="margin-top: 10px;background-color:#0983b8;color:white">Your Information</button>
                     <button class="btn" style="margin-left: 5px;margin-top: 10px;">Your Roommate Preference</button>
                    

                        <!-- Tabs Content -->
                        <div class="tabs-container">

                            <div class="tab-content" id="tab1" style="display: inline-block;">
                                <h3>Your Information</h3><br>
                                <p>Please fill in the following information below if you would like to request a roommate for your next travel assignment. We will try to connect you with other healthcare travelers who may also be interested in a roommate. Finding a roommate can make short-term housing more affordable for those interested in using this feature.</p>
                               
								<div class="submit-section">

                                    <div class="row with-forms">
										<div class="col-md-6">
                                            <h5>Email Address<span style="color: red;">*</span></h5>
                                           <input type="email" class="input-text validate" name="email" id="email" value="" required="required" />
                                        </div>


                                        <div class="col-md-6">
                                            <h5>Phone Number <span style="color: red;">*</span></h5>
                                            <input type="text" class="input-text validate" name="phone" id="phone" value="" required="required"/>
                                        </div>
                                    </div>
                                    <div class="row with-forms">
										<div class="col-md-6">
                                            <h5>Firstname <span style="color: red;">*</span></h5>
                                            <input type="text" class="input-text validate" name="firstname" id="firstname" value="" required="required"/>
                                        </div>


                                        <div class="col-md-6">
                                            <h5>Lastname <span style="color: red;">*</span></h5>
                                           	<input type="text" class="input-text validate" name="lastname" id="lastname" value="" required="required"/>
                                        </div>
                                    </div>
                                    <div class="row with-forms">
										<div class="col-md-6">
                                            <h5>Start Date of Travel Assignment <span style="color: red;">*</span></h5>
                                           <input type="text" class="input-text validate" name="startdate" id="property_from_date" value="" required="required"/>
                                        </div>


                                        <div class="col-md-6">
                                            <h5>End Date of Travel Assignment <span style="color: red;">*</span></h5>
                                            <input type="text" name="enddate" id="property_to_date" value="" class="input-text validate"  required="required"/>
                                        </div>
                                    </div>
                                    <div class="row with-forms">
										<div class="col-md-6">
                                            <h5>The City of your Travel Assignment <span style="color: red;">*</span></h5>
                                           <input type="text" class="input-text validate" name="city" id="city" value="" required="required"/>
                                        </div>


                                        <div class="col-md-6">
                                            <h5>The State of your Travel Assignment <span style="color: red;">*</span></h5>
                                            <input type="text" class="input-text validate" name="state" id="state" value="" required="required"/>
                                        </div>
                                    </div>
                                    <div class="row with-forms">
										<div class="col-md-6">
                                            <h5>Your Gender <span style="color: red;">*</span></h5>
                                           	<select name="gender" class="chosen-select-no-single">
						                        <option label="blank"></option>
						                        <option value="Female">Female</option>
						                        <option value="Male">Male</option>
						                    </select>
                                        </div>


                                        <div class="col-md-6">
                                            <h5>Your Age <span style="color: red;">*</span></h5>
                                           <input type="text" class="input-text validate" name="age" id="age" value=""  required="required"/>
                                        </div>
                                    </div>

                                    <div class="divider"></div>
                                </div>
                                 @if(!Session::has('user_id'))
							            <center>
							                <button id="button" onclick="location.href='https://docs.google.com/forms/d/e/1FAIpQLSfAqkiqDWb4SVrS9ySxpGTVRFDTqX2noe3ItyKiGFBYwFmqeg/viewform?fbclid=IwAR2t27UuX3zLHL3fAl3gAgL_qEdDgZv4vF3U_mzCvdHAs4dEOuZGunsVJHA';" class="button border margin-top-5">Login to Request Roommate  <i class="fa fa-arrow-circle-right"></i></button>
							            </center><br><br>
							        @else
							        	<center>
							                <button id="button"  class="button border margin-top-5" onclick="show_next();">Next<i class="fa fa-arrow-circle-right"></i></button>
							            </center><br><br>
							        @endif
                                <!-- Section / End -->
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </form>
        
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        	date=new Date();
            $("#property_from_date").datepicker({
                startDate: date,
                autoclose: true
            });


            $("#property_from_date").change(function(){

                var fDate = $("#property_from_date").val();
                // alert(fDate);


                // $("#property_to_date").foucs();
                $("#property_to_date").datepicker('remove');
                $("#property_to_date").datepicker({
                    startDate: fDate,
                    autoclose: true
                });

            });
        });
    </script>

{{-- <script type="text/javascript">
   
function show_next(){
	$("#tab2").show();
	$("#tab1").hide();

}

</script> --}}

   
   
    

</body>
</html>

@endsection 