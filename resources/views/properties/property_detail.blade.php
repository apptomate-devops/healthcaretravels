<?php
//echo json_encode($data);exit;
?>
@extends('layout.master') @section('title',$data->title) @section('main_content')
    <style type="text/css">
        .property_details.container {
            margin-top: 50px;
            margin-bottom: 50px;
        }
        div::-webkit-scrollbar {
            width: 12px;
        }
        div::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            border-radius: 10px;
        }
        div::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
        }
        .property-title h2 {
            font-size: 26px !important;
        }
        @media only screen and (min-width: 990px) {
            .property-image p {
                text-align: right;
            }
            .property-pricing {
                margin-top: 40px;
            }
            .property-image .sub-price a {
                text-align: right;
            }
            .show-990{
                display: none;
            }
        }
        @media only screen and (max-width: 989px) {
            .show-990{
                display: show;
            }
            .-990{
            display: none;
        }
            .property-image p {
                text-align: center;
            }
            .property-pricing {
                margin-top: 40px;
            }
            .property-image .sub-price a {
                text-align: center;
            }
        }
        @media only screen and (max-width: 767px) {
            .show-990{
                display: none !important;
            }
            .-990{
            display: show !important;
        }
        }
        .property-image .sub-price a {
            display: block;
            font-size: 19px;
            font-weight: 600;
        }
        .property-image p img {
            border-radius: 50%;
            width: 100px;
            margin-bottom: 0px;
        }
        .property-pricing {
            margin-top: 40px;
        }
        .comments {
            margin: -10px 0 0 0;
        }
        .td {
            padding: 10px;
        }
        #map_container{
            position: relative;
        }
        #map{
            height: 0;
            overflow: hidden;
            padding-bottom: 22.25%;
            padding-top: 30px;
            position: relative;
        }
        #contact_host{
            color: #e78016;
            text-decoration: underline;
            cursor: pointer;
        }
        .tooltip {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black;
        }
        .row_border{
            /*padding: 10px;*/
            /*margin-bottom: 5px;*/
            border-bottom: 1px solid lightgrey;


        }
        .name{
            padding: 10px;
        }
        .tempClass{
            border: 1px solid lightgrey;
            padding:5px;
        }
        .total_amount{
            color: #e78016;
            font-weight: bold;
            padding: 10px;
            text-align: center;
        }
        .total_amount.total_amount_gray {
            color: #adadad;
            font-weight: normal;
        }
        #general_errors {
            text-align: center;
            color: red;
            font-weight: 500;
        }
    </style>
    <div id="" class="property-titlebar margin-bottom-0">
        <div class="property_details container">
            <div class="row">
                <form name="payment" action="{{URL('/')}}/save-guest-information" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-5 col-md-push-7 col-lg-4 col-lg-push-8 row-space-2 lang-ar-left tempClass">
                            <div class="panel payments-listing payment_list_right border-0 shadow-none mb-0">
                                <div class="media-photo media-photo-block text-center payments-listing-image">
                                    <img src="{{$data->image_url}}" class="img-responsive-height" alt="Chambre accueillante chezl habitant">
                                </div>
                                <div class="px-15">
                                    <section id="your-trip" class="your-trip">
                                        <div class="hosting-info">
                                            <div class="payments-listing-name h4 row-space-1" style="word-wrap: break-word;">
                                                {{$data->title}}
                                                {{-- <p style="font-weight: normal;
                                                   font-size: 14px;
                                                   margin: 10px 0px !important;"> {{$data->location}} </p> --}}
                                            </div>
                                            <div class="">
                                                <hr>
                                                <div class="row-space-1">
                                                    <strong>
                                                        {{$data->room_type}}
                                                    </strong>
                                                </div>
                                                <div>
                                                    <strong>{{date('m/d/Y',strtotime($data->start_date))}}</strong> to <strong>{{date('m/d/Y',strtotime($data->end_date))}}</strong>
                                                </div>
                                            </div>
                                            <hr>
                                            <table class="reso-info-table" style="width:95%">
                                                <tbody>
                                                <tr>
                                                    <td>Cancellation Policy</td>
                                                    <td>
                                                        &nbsp;
                                                        <a href="{{URL('/')}}/cancellationpolicy" class="cancel-policy-link" target="_blank">{{$data->cancellation_policy}} </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Days
                                                    </td>
                                                    <td>
                                                        &nbsp;
                                                        {{$data->total_days}}
                                                    </td>
                                                </tr>
                                                {{-- Hiding coupon details as of now --}}
                                                @if(false && $data->coupon_value=="")
                                                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                                                    <tr class="" style="margin-top:5px">
                                                        <td class="name pos-rel">
                                                            Coupon Code
                                                            <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">Please input coupon code given by us</span></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" >
                                                            <input type="text" name="coupon_code" id="coupon_code" onchange="apply_coupon('{{$data->property_booking_id}}')">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" ><span id="message"></span></td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                            <hr>
                                            <section id="billing-summary" class="billing-summary">


                                                <table id="billing-table" class="reso-info-table billing-table" style="width:95%">
                                                    <tbody>
                                                    <h4>Payment Details</h4>
                                                    <tr class="row_border">
                                                        <td class="name pos-rel" >
                                          <span class="lang-chang-label">
                                          $
                                          </span>{{$data->single_day_fare}} x {{$data->total_days}} days
                                                            <span class='tooltips'><i style="color:black"  class='fa fa-question-circle'></i><span style="color: white!important" class='tooltiptext'>Price per day</span></span>
                                                        </td>
                                                        <td class="val text-right">
                                          <span class="lang-chang-label" >  $
                                          </span><span >{{$data->single_day_fare*$data->total_days}}</span>
                                                        </td>
                                                    </tr>
                                                    @if($data->extra_guest!=0)
                                                        <tr class="row_border">
                                                            <td class="name">
                                                                Extra Guest {{$data->extra_guest}} X {{$data->extra_guest_price/$data->extra_guest}}
                                                                <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">price per extra guest </span></span>
                                                            </td>
                                                            <td class="val text-right" >
                                          <span class="lang-chang-label">
                                          $
                                          </span><span>{{$data->extra_guest_price}}</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr class="row_border">
                                                        <td class="name pos-rel">
                                                            Service Fee
                                                            <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">General Service Charges</span></span>
                                                        </td>
                                                        <td class="val text-right" >
                                          <span class="lang-chang-label">         $
                                          </span><span>{{$data->service_tax}}</span>
                                                        </td>
                                                    </tr>

                                                    <tr class="row_border">
                                                        <td class="name">
                                                            Cleaning Fee
                                                            <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">General Cleaning Charges</span></span>
                                                        </td>
                                                        <td class="val text-right" >
                                          <span class="lang-chang-label">
                                          $
                                          </span><span>{{$data->cleaning_fee}}</span>
                                                        </td>
                                                    </tr>

                                                    <tr class="row_border">
                                                        <td class="name">
                                                            Security Deposit <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">Average Daily rate is Rounded</span></span>
                                                        </td>
                                                        <td class="val text-right" >
                                          <span class="lang-chang-label">
                                          $
                                          </span><span>{{$data->security_deposit}}</span>
                                                        </td>
                                                    </tr>


                                                    <tr class="row_border">
                                                        <td class="name">
                                                            <b>Total Amount </b>
                                                        </td>
                                                        <td class="val text-right" >
                                          <span class="lang-chang-label">
                                          $
                                          </span><span><b>{{$data->total_amount}}</b></span>
                                                        </td>
                                                    </tr>
                                                    @if(false && $data->coupon_value!="")
                                                        <tr class="row_border">
                                                            <td class="name" style="color:green;font-weight: bold">
                                                                Discount(Coupon)
                                                            </td>
                                                            <td class="val text-right">
                                                                <span class="lang-chang-label" style="color:green;font-weight: bold">$</span>
                                                                <span style="color:green;font-weight: bold">{{$data->coupon_value}}</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr class="editable-fields" id="total_amount">
                                                        <td colspan="2">
                                                            <div class="total_amount">Payable Amount ${{$data->total_amount}}</div>
                                                        </td>
                                                    </tr>
                                                    <tr class="editable-fields">
                                                        <td colspan="2">
                                                            <button id="requestBooking" class="btn btn-default btn-block bg-orange" disabled>Request Booking</button>
                                                        </td>
                                                    </tr>
                                                    <tr class="editable-fields" id="total_amount">
                                                        <td colspan="2">
                                                            <div class="total_amount total_amount_gray">User will not be charged until booking request is accepted</div>
                                                        </td>
                                                    </tr>
                                                    @if($data->coupon_value!="")
                                                        <tr>
                                                            <td colspan="2"style="color:green;font-weight: bold"><center> Coupon Code is Applied<b>({{$data->coupon_code}})</b></center></td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </section>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                        <div id="content-container" class="col-md-7 col-md-pull-5 col-lg-pull-4 lang-ar-right">



                            <section id="head_scroll" class="checkout-main__section payment">

                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="booking_id" value="{{$data->booking_id}}">
                                <input type="hidden" name="guest_count" value="{{$data->guest_count}}">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2>Billing Information</h2>
                                        To complete this booking, you will need your bank account number and routing number an invoice will be sent to the verified email associated with your Health Care Travels account within 24 hours. Once the invoice has been sent you should pay the invoice as soon as possible. Bookings are confirmed on a first come first serve basis and the invoice will expire 24 hours after invoice is created. Please review this listing in its entirety and the selected cancellation policy.<br><br>
                                        *Please note to speed up this process make sure your account is Up-To-Date, Complete, Verified and all of the necessary documents are uploaded to your account. If you have any question or concerns email <a href="mailto:support@healthcaretravels.com">support@healthcaretravels.com</a><br><br>
                                        <p></p>
                                    </div>
                                </div>

                                <h2>Payment Details</h2>
                                @if(count($funding_sources) > 0)
                                    <select name="funding_source" id="fundingSource" class="chosen-select-no-single">
                                        <option selected disabled>Select Account</option>
                                        @foreach($funding_sources as $source)
                                            <option label="{{$source->name}}" value="{{$source->_links->self->href}}">{{$source->name}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <div>You haven't added any account details yet.</div>
                                @endif
                                <span class="link" id="create-funding-source">Add Account Details</span>

                                <h2>Guest Details</h2>
                                <div class="wrapper center-block">
                                    <div class="panel-group" id="guest-accordian" role="tablist" aria-multiselectable="true">
                                        @for($i=0;$i< $data->guest_count;$i++)
                                            <?php $guest_data = $guests[$i] ?? []; ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="guest-heading-{{$i+1}}">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#guest-accordian" href="#guest-collapse{{$i+1}}" aria-expanded="true" aria-controls="guest-collapse{{$i+1}}">
                                                            Enter Guest {{$i+1}} Details
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="guest-collapse{{$i+1}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="guest-heading-{{$i+1}}">
                                                    <div class="panel-body">
                                                        <input  name="guest_id[]" type="hidden" value="{{$guest_data->id ?? ''}}" required>
                                                        <div class="control-group cc-first-name col-md-6">
                                                            <label class="control-label" for="credit-card-first-name">
                                                                Guest Name
                                                            </label>
                                                            <input  name="guest_name[]" type="text" value="{{$guest_data->name ?? ''}}" required>
                                                        </div>
                                                        <div class="control-group cc-last-name col-md-6">
                                                            <label class="control-label" for="credit-card-last-name">
                                                                Occupation
                                                            </label>
                                                            <input  name="guest_occupation[]" type="text" value="{{$guest_data->occupation ?? ''}}">
                                                        </div>
                                                        <div class="control-group cc-last-name col-md-6">
                                                            <label class="control-label" for="credit-card-last-name">
                                                                Phone number
                                                            </label>
                                                            <input  name="phone_number[]" type="text" value="{{$guest_data->phone_number?? ''}}">
                                                        </div>
                                                        <div class="control-group cc-last-name col-md-6">
                                                            <label class="control-label" for="credit-card-last-name">
                                                                Email
                                                            </label>
                                                            <input  name="email[]" type="email" value="{{$guest_data->email ?? ''}}">
                                                        </div>
                                                        <div class="control-group cc-last-name col-md-6">
                                                            <label class="control-label" for="credit-card-last-name">
                                                                Age
                                                            </label>
                                                            <select class="chosen-select-no-single" name="age[]" data-placeholder="Select Age" required>
                                                                <option label="Select Age" value="" disabled selected>Select Age</option>
                                                                <option label="Adult" value="Adult" @if($guest_data && $guest_data->age == 'Adult') selected @endif></option>
                                                                <option label="Child (Ages 2-12)" value="Child" @if($guest_data && $guest_data->age == 'Child') selected @endif></option>
                                                                <option label="Infant (Under 2)" value="Infant" @if($guest_data && $guest_data->age == 'Infant') selected @endif></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <div id="is_pet" class="checkboxes in-row" style="margin-bottom: 20px;">
                                    <h3>Do you travel with a pet?</h3>
                                    <div class="checkboxes in-row">
                                        <input id="is_pet_travelling_yes" name="is_pet_travelling" type="checkbox" value="1" >
                                        <label for="is_pet_travelling_yes">Yes</label>

                                        <input id="is_pet_travelling_no" name="is_pet_travelling" type="checkbox" value="0" >
                                        <label for="is_pet_travelling_no">No</label>
                                    </div>

                                </div>

                                <div class="row" id="pet_details" style="display: none;">
                                    <div class="control-group cc-last-name col-md-6">
                                        <label for="pet_name">Name:
                                            <input type="text" class="input-text validate" value="{{$pet_details->pet_name ?? ''}}" name="pet_name" id="pet_name" placeholder="Name" autocomplete="off"/>
                                        </label>
                                    </div>

                                    <div class="control-group cc-last-name col-md-6">
                                        <label for="pet_breed">Breed:
                                            <input type="text" class="input-text validate" value="{{$pet_details->pet_breed ?? ''}}" name="pet_breed" id="pet_breed" placeholder="Breed" autocomplete="off"/>
                                        </label>
                                    </div>

                                    <div class="control-group cc-last-name col-md-6">
                                        <label for="pet_weight" class="weight-lb">Weight:
                                            <input type="text" class="price_float input-text validate" value="{{$pet_details->pet_weight ?? ''}}" name="pet_weight" id="pet_weight" placeholder="Weight" autocomplete="off"/>
                                        </label>
                                    </div>

                                    <div class="control-group cc-last-name col-md-6">
                                        <label for="pet_image">
                                            <div style="margin-bottom: 10px;">Pet Image:</div>
                                            <input type="file" name="pet_image" id="pet_image" class="form-control" accept="image/*"/>
                                        </label>
                                    </div>
                                </div>
                                <hr>
                            </section>
                        </div>
                    </div>

                    <div style="height:200px"></div>


                </form>
                <div id="bank_verification_modal" data-backdrop="static" data-keyboard="false" class="modal fade in" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Bank Verification</h4>
                            </div>
                            <div class="modal-body">
                                <div id="iavContainer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            var defaultFundingSource = "{{$traveller->default_funding_source}}";
            $('#fundingSource').val(defaultFundingSource);
            if($('#fundingSource').val()) {
                $('#requestBooking').attr('disabled',false);
            }

            $('#fundingSource').change(function (e) {
                if($('#fundingSource').val()) {
                    $('#requestBooking').attr('disabled',false);
                }
            });

            var pet_details = "{{isset($pet_details)}}" ? 1 : 0;
            change_pet_travelling(pet_details);

            $('#is_pet_travelling_yes,#is_pet_travelling_no').change(function(){
                change_pet_travelling($(this).val());
            });

            function change_pet_travelling(value) {
                if(value == 1) {
                    $('#is_pet_travelling_yes').attr('checked',true);
                    $('#is_pet_travelling_no').attr('checked',false);
                    $('#pet_details').show();
                    $('#pet_name, #pet_weight, #pet_breed, #pet_image').attr('required', true);
                } else {
                    $('#is_pet_travelling_yes').attr('checked',false);
                    $('#is_pet_travelling_no').attr('checked',true);
                    $('#pet_name, #pet_weight, #pet_breed, #pet_image').attr('required', false);
                    $('#pet_details').hide();
                }
            }
        });
        $('.price_float').change(function(){
            var value = parseFloat(this.value);
            this.value = isNaN(value) ? 0 : value;
        });

        $('.price_float').keypress(function(event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        $('.numbers_only').keypress(function(event) {
            var regex = new RegExp("^[0-9+]$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });

        function apply_coupon(id){

            var coupon_code=document.getElementById('coupon_code').value;
            var url = "{{url('/')}}/apply_coupon?coupon_code="+coupon_code+"&&id="+id;


            console.log(url);

            $.ajax({
                "type": "get",
                "url" : url,
                success: function(data) {
                    console.log(data);
                    if(data.status=="SUCCESS"){
                        $('#message').css('color','green');
                        $('#message').css('font-weight','bold');
                        $('#message').css('font-size',17);
                        $('#message').html('* '+ data.message);
                        $('#message').css('display','block');
                        window.location.reload();
                    }else{
                        $('#message').css('color','red');
                        $('#message').css('font-weight','bold');
                        $('#message').css('font-size',17);
                        $('#message').html('* '+ data.message);
                        $('#message').css('display','block');
                    }
                }

            });
        }
    </script>
    <script src="https://cdn.dwolla.com/1/dwolla.js"></script>
    <script>
        // Dwolla: Account details
        dwolla.configure('{{DWOLLA_ENV}}');

        function getFundingSourceFromIAV(iavToken) {
            $("#bank_verification_modal").modal('show');
            var config = {
                container: 'iavContainer',
                stylesheets: [
                    'https://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext'
                ],
                microDeposits: false,
                fallbackToMicroDeposits: true,
            };
            dwolla.iav.start(iavToken, config, function(err, res) {
                if(err) {
                    // TODO: simulate error flow
                    return false
                }
                setTimeout(function (e) {
                    $("#bank_verification_modal").modal('hide');
                    window.location.reload();
                }, 3000);
                var fundingSource = res._links['funding-source'].href;
                addDefaultFundingSourceToUser(fundingSource);
            });

        };

        function addDefaultFundingSourceToUser(fundingSource) {
            var formData = {
                id: $('#travellerId').val(),
                fundingSource: fundingSource,
                _token: '{{ csrf_token() }}'
            };
            $.ajax({
                url: "/dwolla/add_funding_source",
                type: "POST",
                data: formData,
                json: true,
                success: function(data, textStatus, jqXHR) {
                    if (data.success) {
                        console.log('Default funding source stored');
                    } else {
                        console.log('Error saving Default funding source', data);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error saving Default funding source', data);
                }
            });
        };

        $('#create-funding-source').on('click', function (e) {
            var userInfo = {
                id: $('#travellerId').val(),
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: "/dwolla/create_customer_and_funding_source_token_with_validations",
                type: "POST",
                data: userInfo,
                json: true,
                success: function(data, textStatus, jqXHR) {
                    if(data && data.success) {
                        getFundingSourceFromIAV(data.token);
                    } else {
                        console.log('Error while generating IAV token', data);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error while generating IAV token');
                }
            });
        });
    </script>
@endsection
