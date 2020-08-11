@extends('layout.master') @section('title','Profile') @section('main_content')


<div class="container" style="margin-top: 35px;">
    <div class="row">
        <div class="col-md-12">
            <hr>
            <div>

                <div class="dashboard-header">

                    <div class=" user_dashboard_panel_guide">

                        @include('owner.add-property.menu')

                    </div>
                </div>
                <!-- Tabs Content -->
              

                 <div class="tabs-container">

                      <form action="{{url('/')}}/owner/add-new-property/4" method="post" name="form-add-new">

                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="client_id" value="{{$client_id}}">
                            <input type="hidden" name="property_id" value="{{$property_details->id}}">

                            <div class="tab-content" id="tab1" style="display: inline-block;">
                                <!-- Section -->
                                <h3>Pricing</h3>
                                <div class="submit-section">

                                    <!-- Title -->
                                    <div class="row with-forms">

                                        <div class="col-md-6">
                                            <h5>Currency Type<span style="color: red">*</span></h5>
                                           
                                             <select class="chosen-select-no-single validates" name="currency">
                                                <option label=""></option>
                                                
                                                <option value="USD" selected>USD</option> 
  
                                            </select>
                                        </div>


                                        <!-- Area -->
                                        <!-- <div class="col-md-6">
                                            <h5>Maximum Guests</h5>
                                            <select class="chosen-select-no-single validate" name="maximum_guest">
                                                <option label="blank"></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                            </select>
                                        </div> -->
                                        <div class="col-md-6">
                                            <h5>Nightly Pricing<span style="color: red">*</span></h5>
                                            <input class="search-field validate" type="text" name="price_per_night"  onchange="this.value=parseFloat(parseFloat(this.value)).toFixed(2);" value="{{isset($price->price_per_night)?$price->price_per_night:''}}" />
                                        </div>
                                    </div>

                                    <!-- Row -->
                                    

                                  

                                     <div class="row with-forms" style="margin-bottom:10px;">

                                        <div class="col-md-6">
                                            <h5>Nightly price for stays more than 1 month (30+ days)<span style="color: red">*</span></h5>
                                            <input class="search-field validate"onchange="this.value=parseFloat(parseFloat(this.value)).toFixed(2);"   name="price_more_than_one_month"  type="text" value="{{isset($price->price_more_than_one_month)?$price->price_more_than_one_month:''}}" />
                                            <div id="set_location"></div>
                                            
                                          
                                        </div>

                                        <div class="col-md-6"> 
                                            <h5>Minimum Nightly Stay<span style="color: red">*</span></h5> 
                                            {{-- <h5>Minimum Stay<span style="color: red">*</span></h5>  --}}
                                            <input class="search-field validate" name="minimumstay"  type="text" value="{{isset($price->minimum_days)?$price->minimum_days:'0'}}"  />
                                        </div>

                                       

                                        

                                    </div>
<!-- 
                                    <div class="row with-forms" style="margin-bottom:10px;">

                                        <div class="col-md-6">
                                            <h5>City Fee</h5>
                                            <input class="search-field validate" name="city_fee"  onchange="this.value=parseFloat(parseFloat(this.value)).toFixed(2);" type="text" value="" />
                                          
                                        </div>

                                        <div class="col-md-6">
                                            <h5>City fee type </h5>
                                            <select class="chosen-select-no-single validate" name="city_fee_type">
                                                <option label=""></option>
                                                <option value="1">Single Fee</option>
                                                <option value="2">Per Night</option>
                                                <option value="3">Per Guest</option>
                                                <option value="4">Per Guest Per Night</option>
                                                
                                            </select>
                                        </div>

                                        

                                    </div> -->


                                    <div class="row with-forms" style="margin-bottom:10px;">

                                        <div class="col-md-6">
                                            <div class="checkboxes" style="margin-top: 0px;"> 

                                            <input id="is_extra_guest" type="checkbox" value="1" name="is_extra_guest">
                                            <label for="is_extra_guest">Check here if additional guest are allowed </label>
                                            <div id="guest_price" style="display: none">
                                             <h5 >Additional Guests Price (per night)</h5>
                                            <input class="search-field"  name="price_per_extra_guest" type="text" onchange="this.value=parseFloat(parseFloat(this.value)).toFixed(2);"  value="{{isset($price->price_per_extra_guest)?$price->price_per_extra_guest:'0'}}"  />
                                        </div>
                                        </div>
                                            
                                        </div>

                                        <div class="col-md-6" >
                                            <!-- <div>
                                           <h5 >Additional Guests (per night)</h5>
                                            <input class="search-field validate"  name="price_per_extra_guest"  type="text" value="" />
                                        </div> -->
                                          
                                        </div>

                                        

                                    </div>

                                    {{-- <div class="row with-forms">

                                        <div class="col-md-6">
                                            
                                            <h5>Cleaning Fee</h5>
                                            <input class="search-field" name="cleaning_fee"  onchange="this.value=parseFloat(parseFloat(this.value)).toFixed(2);" type="text" value="{{isset($price->cleaning_fee)?$price->cleaning_fee:''}}" />
                                        </div>
                                         <div class="col-md-6">
                                            <h5>Cleaning Fee Type </h5>
                                            <select class="chosen-select-no-single" name="cleaning_fee_type" id="cleaning_fee_type">
                                                <option label=""></option>
                                                <option value="Flat Rate Fee">Flat Rate Fee</option>
                                                <option value="Per Day">Per Day</option>
                                                <option value="Per Month">Per Month</option>
                                                
                                            </select>
                                        </div>
                                        

                                    </div> --}}

                                    <div class="row with-forms">

                                        <div class="col-md-6">
                                            <h5>Check In<span style="color: red">*</span></h5>
                                            <input class="search-field validate" name="check_in" id="property_from_date"   type="text" value="" />
                                            <div id="set_location"></div>
                                        </div>

                                        <div class="col-md-6">
                                            <h5>Check Out<span style="color: red">*</span></h5>
                                            <input class="search-field validate" name="check_out" id="property_to_date"  type="text" value="" />
                                        </div>

                                    </div>

                                    <div class="row with-forms">

                                        <div class="col-md-6">
                                            <h5>Cancellation Policy<span style="color: red">*</span></h5>
                                            <select class="chosen-select-no-single validate" id="cancellation_policy" name="cancellation_policy" required>
                                                <option label=""></option>
                                                
                                                <option value="Flexible">Flexible</option> 
                                                <option value="Moderate">Moderate</option> 
                                                <option value="Strict">Strict</option> 
                                                <option value="Super Strict">Super Strict</option> 
  
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Security Deposit<span style="color: red">*</span></h5>
                                            <input class="search-field" name="security_deposit"  onchange="this.value=parseFloat(parseFloat(this.value)).toFixed(2);"  type="text" value="{{isset($price->security_deposit)?$price->security_deposit:'0'}}"   />
                                            <div id="set_location"></div>
                                            
                                        </div>

                                        <br><br><br>

                                       

                                    </div>
                                  <div class="row with-forms">

                                          {{--  <div class="col-md-6">
                                            <h5>Nightly price for stays more than 1 week (7+ days)</h5>
                                            <input class="search-field" type="text" onchange="this.value=parseFloat(parseFloat(this.value)).toFixed(2);"  name="price_more_than_one_week" value="{{isset($price->price_more_than_one_week)?$price->price_more_than_one_week:''}}" />
                                        </div> --}}

                                        <!-- <div class="col-md-6">
                                            <h5>Category</h5>
                                            <select class="chosen-select-no-single validate" name="category">
                                                <option label="blank"></option>
                                                <option value="Apartment">Apartment</option>
                                                <option value="Villa">villa</option>
                                            </select>
                                        </div> -->


                                        <div class="col-md-6">
                                            <h5>House Rules<span style="color: red">*</span></h5>
                                            <textarea  class="search-field validate"   id="house_rules" name="house_rules">{{isset($property_data->house_rules)?$property_data->house_rules:''}}</textarea>
                                            
                                        </div>

                                        <!-- Area -->
                                       <!--  <div class="col-md-6">
                                            <h5>Room Type</h5>
                                            <select class="chosen-select-no-single validate" name="room_type">
                                                <option label="blank"></option>
                                                <option value="Private">Private</option>
                                                <option value="Entire House">Entire House</option>
                                                <option value="Shared Room">Shared Room</option>
                                            </select>
                                        </div> -->

                                    </div>



                                    <!-- Row -->
                                    
                                    <!-- Row / End -->



<div style="height:150px"></div>

                                    <div class="divider"></div>
                                    @if(Session::has('user_id'))
                                        @if(Session::get('role_id') == 1)
                                            <input type="hidden" name="user_id" value="{{Session::get('user_id')}}">
                                            {{-- @if(isset($property_details->is_complete) && $property_details->is_complete == 1)
                                                <button id="button" class="button border margin-top-5" name="save" value="save" style="background-color: #e78016;">Save<i class="fa fa-save"></i></button>
                                            @endif --}}
                                            <button id="button" class="button border margin-top-5">Save <i class="fa fa-arrow-circle-right"></i></button>
                                        @else
                                            <p> </p>
                                            {{-- @if(isset($property_details->is_complete) && $property_details->is_complete == 1)
                                                <button id="button" class="button border margin-top-5" name="save" value="save" style="background-color: #e78016;">Save<i class="fa fa-save"></i></button>
                                            @endif --}}
                                            <button id="button" class="button border margin-top-5">Save <i class="fa fa-arrow-circle-right"></i></button>
                                        @endif
                                    @else
                                        <p>Login to add property </p>
                                        <button id="button" disabled class="button border margin-top-5">Save <i class="fa fa-arrow-circle-right"></i></button>
                                    @endif

                                </div>
                                <!-- Section / End -->
                            </div>
                        </form>




                        </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var is_extra_guest='{{isset($price->is_extra_guest)?$price->is_extra_guest:'0'}}';
    if(is_extra_guest==1){
        $('#is_extra_guest').attr('checked',true);
        $('#guest_price').show();
    }


    $('#is_extra_guest').change(function(){
       if($('#is_extra_guest').prop("checked") == true){
        $('#guest_price').show();
       }else{
          $('#guest_price').hide();
       }
    })

    function decimal(value) {
        console.log(value);
    $(this).val(150);
    console.log(parseFloat(parseFloat(value)).toFixed(2)) ;

}

$(document).ready(function(){

     $('#sunday,#friday').change(function(){
            var value=$(this).val();
            if(value=="sunday"){
                $('#friday').attr('checked',false);
            }else{
               $('#sunday').attr('checked',false);
            }
        })

        $('.price_float').change(function(){
            console.log("hai");

        // $(this).val(parseFloat(parseFloat($(this).val()).toFixed(2)));  
        // console.log($(this).val());      
        });
    
    


            $('#property_from_date').timepicker({ 'timeFormat': 'H:i:s' });
            $('#property_to_date').timepicker({ 'timeFormat': 'H:i:s' });
            
            // $("#property_from_date").datepicker({
            //     startDate: date,
               
            // });

            // $("#property_to_date").datepicker({
            //     startDate: date,
               
            // });

          
            moment.locale('tr');
//var ahmet = moment("25/04/2012","DD/MM/YYYY").year();
            var date = new Date();
            bugun = moment(date).format("DD/MM/YYYY");

            var date_input=$('input[name="date"]'); //our date input has the name "date"
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
            var options={
                //startDate: '+1d',
                //endDate: '+0d',
                container: container,
                todayHighlight: true,
                autoclose: true,
                format: 'dd/mm/yyyy',
                language: 'tr',
                //defaultDate: moment().subtract(15, 'days')
                //setStartDate : "<DATETIME STRING HERE>"
            };
            date_input.val(bugun);
            date_input.datepicker(options).on('focus', function(date_input){
                // $("h3").html("focus event");
            }); ;


            date_input.change(function () {
                var deger = $(this).val();
                // $("h3").html("<font color=green>" + deger + "</font>");
            });



            $('.input-group').find('.glyphicon-calendar').on('click', function(){
//date_input.trigger('focus');
//date_input.datepicker('show');
                //$("h3").html("event : click");


                if( !date_input.data('datepicker').picker.is(":visible"))
                {
                    date_input.trigger('focus');
                    // $("h3").html("Ok");

                    //$('.input-group').find('.glyphicon-calendar').blur();
                    //date_input.trigger('blur');
                    //$("h3").html("görünür");
                } else {
                }


            });


        });

    function show_table(id) {
        var name = document.getElementById('name').value;
        var value = document.getElementById('value').value;
        var single_fee = document.getElementById('single_fee').value;

        document.getElementById('rname').value = (name);
        document.getElementById('rvalue').value = (value);
        document.getElementById('rsingle_fee').value = (single_fee);
        var ix;

        for (ix = 1; ix <= 6; ++ix) {
            document.getElementById('table' + ix).style.display = 'none';
        }
        if (typeof id === "number") {
            document.getElementById('table' + id).style.display = 'block';
        } else if (id && id.length) {
            for (ix = 0; ix < id.length; ++ix) {
                document.getElementById('table' + ix).style.display = 'block';
            }
        }

    }


</script>
<script type="text/javascript">
    $('.date_picker').datepicker({});
    var date = new Date();
    //date.setDate(date.getDate()-1);
    $('#from_date').datepicker({
        startDate: date
    });

    function set_to_date() {
        // body...
        var from_date = $('#from_date').val();
        $('#to_date').datepicker({
            startDate: from_date
        });
    }

      <?php if (isset($price->weekend_days)) {
          $value = explode(',', $price->weekend_days);
          foreach ($value as $v) { ?>
                $("input[type=checkbox][value={{$v}}]").prop("checked",true);

        <?php }
      } ?>
 
 $("#cancellation_policy").val("{{isset($property_details->cancellation_policy)?$property_details->cancellation_policy:''}}");
 $("#booking_type").val("{{isset($property_details->is_instant)?$property_details->is_instant:''}}");
 $("#cleaning_fee_type").val("{{isset($price->cleaning_fee_type)?$price->cleaning_fee_type:''}}");


</script>
</body>{{-- https://maps.googleapis.com/maps/api/js?libraries=places&#038;language=en&#038;key=AIzaSyBWoWfqptSqcHj_tAT3khy2jjj7fuANNaM&#038;ver=1.0 --}}

</html>

@endsection
