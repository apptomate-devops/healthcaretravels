<?php
//echo json_encode($data);exit;
?>
@extends('layout.master') @section('title',$data->title) @section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/select-pure.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/bookings.css') }}">
    <div id="" class="property-titlebar margin-bottom-0">
        <div class="property_details container">
            <div class="row">
                <form name="payment" action="{{URL('/')}}/save-guest-information" method="post" enctype="multipart/form-data" onsubmit="return validate_submit()" autocomplete="off" onkeydown="return event.key != 'Enter';" >
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
                                                @if($data->status == 1)
{{--                                                    only allow to edit if not approved--}}
                                                    <tr>
                                                        <td>
                                                            <a href="{{BASE_URL}}property/{{$data->property_id}}/{{$data->booking_id}}">Go back to edit</a>
                                                        </td>
                                                    </tr>
                                                @endif
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
                                                    <tr>
                                                        <td class="name pos-rel" >
                                                                <span class="lang-chang-label">
                                                                    {{$data->count_label}}
                                                                </span>
                                                            <span class='tooltips'><i style="color:black"  class='fa fa-question-circle'></i><span style="color: white!important" class='tooltiptext'>Total price</span></span>
                                                        </td>
                                                        <td class="val text-right" id="neat_amount">
                                                            $ {{$data->neat_amount}}
                                                        </td>
                                                    </tr>
                                                    @foreach($data->scheduled_payments as $payment)
                                                        <tr class="payment_sections">
                                                            <td class="name">
                                                                {{$payment['day']}}
                                                            </td>
                                                            <td class="val text-right">
                                                                $ {{$payment['price']}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr class="row_border row_border_top">
                                                        <td class="name pos-rel">
                                                            Service Fee
                                                            <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">General Service Charges</span></span>
                                                        </td>
                                                        <td class="val text-right" >
                                                            $ {{$data->service_tax}}
                                                        </td>
                                                    </tr>

                                                    <tr class="row_border">
                                                        <td class="name">
                                                            Cleaning Fee
                                                            <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">General Cleaning Charges</span></span>
                                                        </td>
                                                        <td class="val text-right" >
                                                            $ {{$data->cleaning_fee}}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="name">
                                                            Total Amount
                                                        </td>
                                                        <td class="val text-right" >
                                                            $ {{$data->total_price}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="name">
                                                            <b>Due on Approval</b>
                                                        </td>
                                                        <td class="val text-right" >
                                                            <b>$ {{$data->due_on_approve}}</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="name">
                                                            + $ {{$data->security_deposit}} refundable security deposit <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">Refunded after completion</span></span>
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
                                                    <tr class="editable-fields">
                                                        <td colspan="2">
                                                            <button id="requestBooking" class="btn btn-default btn-block bg-orange" disabled>Request Booking</button>
                                                        </td>
                                                    </tr>
                                                    <tr class="editable-fields" id="total_amount">
                                                        <td colspan="2">
                                                            <div class="total_amount total_amount_gray">You won't be charged until the property owner confirms your request</div>
                                                        </td>
                                                    </tr>
                                                    @if(false && $data->coupon_value!="")
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

                                @component('components.funding-source', ['funding_sources' => $funding_sources])
                                @endcomponent

                                <h2>Guest Details</h2>
                                <div class="wrapper center-block">
                                    <div class="panel-group" id="guest-accordian" role="tablist" aria-multiselectable="true">
                                        @for($i=0;$i< $data->guest_count;$i++)
                                            <?php $guest_data = $guests[$i] ?? []; ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="guest-heading-{{$i+1}}">
                                                    <h4 class="panel-title">
                                                        <a id="guest-collapse-{{$i}}" role="button" data-toggle="collapse" data-parent="#guest-accordian" href="#guest-collapse{{$i+1}}" @if($i == 0) aria-expanded="true" @endif aria-controls="guest-collapse{{$i+1}}">
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
                                                            <select name="age[]" data-placeholder="Select Age" required>
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

                                <hr>
                                <button id="add_pet" class="btn bg-orange" style="margin-bottom: 20px; width: auto;">
                                    Add a Pet
                                </button>
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
                                    <div id="remove_pet" class="add-another">Don't want to add a pet?</div>
                                </div>
                                <hr>

                                <div class="form-row form-row-wide" id="agency_show">
                                    <label for="agency_name">Agency you work for:</label>
                                    <p class="register-info">Select as many agencies that you have worked for in the last 12 months.</p>
                                    <span class="autocomplete-select"></span>
                                    <p id="agency_error" class="error-text" style="display: none;">Select at least 1 agency</p>
                                    <div id="add_another_agency" class="add-another" onclick="add_another_agency(true)" style="cursor: pointer;">Can't find it? Add it here.</div>
                                    <input type="hidden" name="name_of_agency" id="name_of_agency" value="">
                                    <label for="other_agency_name" id="other_agency_name" style="display: none;">Other Angency:</label>
                                    <input type="text" style="display: none;" class="input-text validate" name="other_agency" id="other_agency" value="{{$traveller->other_agency}}" placeholder="Other agency" autocomplete="off">
                                    <div style="display: none;" id="other_agency_cancel" class="add-another" onclick="add_another_agency()" style="cursor: pointer;">Cancel</div>
                                </div>
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
            <div id="addDetailsProgress" class="loading style-2" style="display: none;"><div class="loading-wheel"></div></div>
        </div>
    </div>

    <script>
        var allAgencies = [];
        var agencyAutoComplete;

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

            load_agencies();
            var otherAgencies = "{{$traveller->other_agency}}";
            if(otherAgencies) {
                add_another_agency(true, otherAgencies);
            }

            var pet_details = "{{isset($pet_details)}}" ? 1 : 0;
            change_pet_travelling(pet_details);

            $('#add_pet').click(function (e) {
                e.stopPropagation();
                e.preventDefault();
                change_pet_travelling(1);
            });
            $('#remove_pet').click(function (e) {
                e.stopPropagation();
                e.preventDefault();
                change_pet_travelling(0);
            });
        });

        function change_pet_travelling(value) {
            if(value) {
                $('#pet_details').show();
                $('#pet_name, #pet_weight, #pet_breed, #pet_image').attr('required', true);
            } else {
                $('#pet_name, #pet_weight, #pet_breed, #pet_image').attr('required', false);
                $('#pet_details').hide();
            }
        }

        function add_another_agency(show = false, value = '') {
            if(show) {
                $('#add_another_agency').hide();
                $('#other_agency').show();
                $('#other_agency').attr('required', true);
                $('#other_agency_cancel').show();
                $('#other_agency_name').show();
                $('#other_agency').val(value);
            } else {
                $('#add_another_agency').show();
                $('#other_agency').hide();
                $('#other_agency').attr('required', false);
                $('#other_agency_cancel').hide();
                $('#other_agency_name').hide();
                $('#other_agency').val('');
            }
        }

        function load_agencies() {
            var agencies = <?php echo json_encode($agency); ?>;
            allAgencies = agencies;
            initPureSelect(agencies);
        }

        function initPureSelect(agencies, selected) {
            var selected_agencies = "{{$traveller->name_of_agency}}";
            selected_agencies = selected_agencies ? selected_agencies.split(',') : [];
            if (selected) {
                selected_agencies = selected;
            }
            var mappedData = agencies.map(a => ({
                label: a.name,
                value: a.name
            }));
            $('.autocomplete-select').empty();
            var autocomplete = new SelectPure(".autocomplete-select", {
                options: mappedData,
                value: selected_agencies,
                multiple: true,
                autocomplete: true,
                icon: "fa fa-times",
                placeholder: "Select Agencies",
                onChange: function (e) {
                    $('#agency_error').hide();
                }
            });
            agencyAutoComplete = autocomplete;
        }

        function validate_submit() {
            $('#name_of_agency').val(agencyAutoComplete.value());
            if($('#other_agency').val() || (agencyAutoComplete.value().length && agencyAutoComplete.value().length)) {
                return true;
            }
            $('#agency_error').show();
            return false
        }

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
        $('#neat_amount').click(function (e) {
            e.stopPropagation();
            e.preventDefault();
            $('.payment_sections').toggleClass('active');
            $(this).toggleClass('active');
        })
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
                subscriber: ({ currentPage, error }) => {
                    $('#addDetailsProgress').hide();
                    console.log("currentPage:", currentPage, "error:", JSON.stringify(error));
                },
            };
            dwolla.iav.start(iavToken, config, function(err, res) {
                if(err) {
                    $('#addDetailsProgress').hide();
                    console.log('Error creating IAV funding source', err.message, 'with code', err.code);
                    return false
                }
                var fundingSource = res._links['funding-source'].href;
                addDefaultFundingSourceToUser(fundingSource, function (err, data) {
                    $('#addDetailsProgress').hide();
                    $("#bank_verification_modal").modal('hide');
                    if(data.success) {
                        window.location.reload();
                    }
                });
            });
        };

        function addDefaultFundingSourceToUser(fundingSource, cb) {
            var formData = {
                id: {{$traveller->id}},
                fundingSource: fundingSource,
                _token: '{{ csrf_token() }}'
            };
            $.ajax({
                url: "/dwolla/add_funding_source",
                type: "POST",
                data: formData,
                json: true,
                success: function(response, textStatus, jqXHR) {
                    cb(null, response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    cb(errorThrown);
                }
            });
        };

        $('#create-funding-source').on('click', function (e) {
            $('#addDetailsProgress').show();
            var userInfo = {
                id: {{$traveller->id}},
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: "/dwolla/create_customer_and_funding_source_token_with_validations",
                type: "POST",
                data: userInfo,
                json: true,
                success: function(response, textStatus, jqXHR) {
                    if(response && response.success) {
                        getFundingSourceFromIAV(response.token);
                    } else {
                        $('#addDetailsProgress').hide();
                        console.log('Error while generating IAV token');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#addDetailsProgress').hide();
                    console.log('Error while generating IAV token');
                }
            });
        });
    </script>
@endsection
