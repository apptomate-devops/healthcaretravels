@extends('layout.master') @section('title','Profile') @section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/property.css') }}">


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
                                <h3>Booking</h3>
                                <div class="submit-section">

                                    <!-- Title -->
                                    <div class="row with-forms">


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
                                    </div>

                                    <!-- Row -->




                                    <div class="row with-forms" style="margin-bottom:10px;">

{{--                                        <div class="col-md-6">--}}
{{--                                            <h5>Nightly price for stays more than 1 month (30+ days)<span class="required">*</span></h5>--}}
{{--                                            <input class="search-field validate price_int" id="price_more_than_one_month" name="price_more_than_one_month" type="text" value="{{isset($price->price_more_than_one_month)?$price->price_more_than_one_month:''}}" />--}}
{{--                                            <div id="set_location"></div>--}}


{{--                                        </div>--}}

                                        <div class="col-md-6">
                                            <h5>Monthly Rate (USD)<span class="required">*</span></h5>
                                            {{--                                            <p class="caption-text">Booking prices will be calculated based on this rate, starting at a minimum of 30 days.</p>--}}
                                            <p class="caption-text">Pay outs will reflect: <br>(1) a service fee of $50 for the 1st month of a traveler's stay <br>(2) a processing fee of $10 for the remaining months of the stay.</p>
                                            <input class="search-field validate price_int" type="text" name="monthly_rate" id="monthly_rate" value="{{isset($property_details->monthly_rate)?$property_details->monthly_rate:''}}" autocomplete="off"/>
                                            <i class="price">$</i>
                                        </div>

                                        <div class="col-md-6">
                                            <h5>Minimum Daily Stay<span class="required">*</span></h5>
                                            <p class="caption-text">Minimum 30 days</p>
                                            {{-- <h5>Minimum Stay<span class="required">*</span></h5>  --}}
                                            <input class="search-field validate" id="minimumstay" name="minimumstay" type="text" value="{{isset($property_details->min_days)?$property_details->min_days:'30'}}" autocomplete="off" />
                                        </div>
                                    </div>
                                    <!--
                                                                        <div class="row with-forms" style="margin-bottom:10px;">

                                                                            <div class="col-md-6">
                                                                                <h5>City Fee</h5>
                                                                                <input class="search-field validate price_int" name="city_fee" type="text" value="" />

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


                                    {{-- <div class="row with-forms">

                                        <div class="col-md-6">

                                            <h5>Cleaning Fee</h5>
                                            <input class="search-field price_int" name="cleaning_fee" type="text" value="{{isset($price->cleaning_fee)?$price->cleaning_fee:''}}" />
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



                                        <div class="col-md-6" style="padding: 0;">
                                            <div class="col-md-6">
                                                <h5>Check In<span class="required">*</span></h5>
                                                <input class="search-field validate" name="check_in" id="property_from_date" type="text" value="{{isset($property_details->check_in)?$property_details->check_in:''}}" />
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Check Out<span class="required">*</span></h5>
                                                <input class="search-field validate" name="check_out" id="property_to_date" type="text" value="{{isset($property_details->check_out)?$property_details->check_out:''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <h5>Cleaning Fee (USD)<span class="required">*</span></h5>
                                            <p class="caption-text">This fee will be charged once per stay</p>
                                            <input class="search-field price_int validate" id="cleaning_fee" name="cleaning_fee" type="text" value="{{isset($property_details->cleaning_fee)?$property_details->cleaning_fee:'0'}}" autocomplete="off"  />
                                            <i class="price">$</i>
                                        </div>
                                    </div>

                                    <div class="row with-forms">

                                        <div class="col-md-6">
                                            <h5>Cancellation Policy<span class="required">*</span></h5>
                                            <select class="chosen-select-no-single validate" id="cancellation_policy" name="cancellation_policy" required>
                                                <option label=""></option>
                                                <option value="Flexible">Flexible</option>
                                                <option value="Moderate">Moderate</option>
                                                <option value="Strict">Strict</option>
                                            </select>
                                            <p class="caption-text" style="margin-bottom: 12px;">View more on cancellation policies <a href="https://healthcaretravels.com/cancellationpolicy" target="_blank">here</a>.</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Security Deposit (USD)<span class="required">*</span></h5>
                                            <input class="search-field price_int validate" id="security_deposit" name="security_deposit" type="text" value="{{isset($property_details->security_deposit)?$property_details->security_deposit:'0'}}" autocomplete="off"  />
                                            <i class="price">$</i>
                                        </div>
                                        <br><br>
                                    </div>
{{--                                    <div class="row with-forms">--}}

{{--                                        <div class="col-md-12">--}}
{{--                                            <h3>Allow Instant Booking :</h3>--}}
{{--                                            <div class="checkboxes in-row">--}}

{{--                                                <input id="booking_type_yes" name="booking_type" type="checkbox" value="1" >--}}
{{--                                                <label for="booking_type_yes">Yes</label>--}}

{{--                                                <input id="booking_type_no" name="booking_type" type="checkbox" value="0" checked >--}}
{{--                                                <label for="booking_type_no">No</label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <br><br><br>--}}
{{--                                    </div>--}}

                                    <!-- Row -->

                                    <!-- Row / End -->
                                    <div class="text-center">
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

            $('#minimumstay').change(function(){
                var value = parseInt(this.value);
                this.value = isNaN(value) ? 30 : value;
                this.value = isNaN(value) ? 30 : value;
            });

            $('#minimumstay').blur(function(){
                var value = parseInt(this.value);
                this.value = (value < 30) ? 30 : value;
            });

            $('#minimumstay, .price_int').keypress(function(event) {
                var regex = new RegExp("^[0-9+]$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
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

        var is_instant = "{{$property_details->is_instant}}";
        var min_days = "{{$property_details->min_days}}";
        if(is_instant === '1') {
            $('#booking_type_yes').attr('checked',true);
            $('#booking_type_no').attr('checked',false);
        } else {
            $('#booking_type_yes').attr('checked',false);
            $('#booking_type_no').attr('checked',true);
        };

        $('#booking_type_yes,#booking_type_no').change(function(){
            if($(this).val()==1){
                $('#booking_type_no').attr('checked',false);
            }else{
                $('#booking_type_yes').attr('checked',false);
            }
        });

        $("#cancellation_policy").val("{{isset($property_details->cancellation_policy)?$property_details->cancellation_policy:''}}");
{{--        $("#booking_type").val("{{isset($property_details->is_instant)?$property_details->is_instant:''}}");--}}
<!--        $("#cleaning_fee_type").val("{{isset($price->cleaning_fee_type)?$price->cleaning_fee_type:''}}");-->

    </script>
    </body>{{-- https://maps.googleapis.com/maps/api/js?libraries=places&#038;language=en&#038;key=AIzaSyBWoWfqptSqcHj_tAT3khy2jjj7fuANNaM&#038;ver=1.0 --}}

    </html>

@endsection
