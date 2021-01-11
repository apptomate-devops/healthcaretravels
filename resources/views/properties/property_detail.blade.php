<?php
//echo json_encode($data);exit;
?>
@extends('layout.master') @section('title',$data->title) @section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/select-pure.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/bookings.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/pricing_details.css') }}">
    <div id="" class="property-titlebar margin-bottom-0">
        <div class="property_details container">
            <div class="row">
                <form name="request_booking" id="request_booking" action="{{URL('/')}}/save-guest-information" method="post" enctype="multipart/form-data" onsubmit="return validate_submit()" autocomplete="off" onkeydown="return event.key != 'Enter';" >
                    <div class="row">
                        <div class="col-md-5 col-md-push-7 col-lg-4 col-lg-push-8 row-space-2 lang-ar-left tempClass">
                            <div class="panel payments-listing payment_list_right border-0 shadow-none mb-0">
                                <div class="media-photo media-photo-block text-center payments-listing-image">
                                    <img src="{{$data->image_url}}" class="img-responsive-height" alt="Chambre accueillante chezl habitant">
                                </div>
                                <div class="px-15">
                                    <section id="your-trip" class="your-trip">
                                        <div class="hosting-info">
                                            <div class="payments-listing-name h2 row-space-1" style="word-wrap: break-word;">
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
                                                    <strong>{{$data->guest_count}} Guests, {{date('m/d/Y',strtotime($data->start_date))}}</strong> - <strong>{{date('m/d/Y',strtotime($data->end_date))}}</strong>
                                                </div>
                                                <div>
                                                    <strong>
                                                        Cancellation Policy:
                                                        <a href="{{URL('/')}}/cancellationpolicy" class="cancel-policy-link" target="_blank">{{$data->cancellation_policy}} </a>
                                                    </strong>
                                                </div>
                                                @if(in_array($data->bookingStatus, [0,1]))
                                                    {{--                                                    only allow to edit if not approved--}}
                                                    <div>
                                                        <strong>
                                                            <a href="{{BASE_URL}}property/{{$data->property_id}}/{{$data->booking_id}}">Go back to edit</a>
                                                        </strong>
                                                    </div>
                                                @endif
                                            </div>
                                            <hr>
                                            <table class="reso-info-table" style="width:95%">
                                                <tbody>
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
                                            <section id="billing-summary" class="billing-summary">
                                                <table id="billing-table" class="reso-info-table billing-table">
                                                    <tbody>
                                                    <h4>Payment Details</h4>
                                                    <tr class="expandable" id="neat_amount">
                                                        <td class="name pos-rel" >
                                                                <span class="lang-chang-label">
                                                                    {{$data->count_label}}
                                                                </span>
                                                            <span class='tooltips'><i style="color:black"  class='fa fa-question-circle'></i><span style="color: white!important" class='tooltiptext'>The cost of your stay including applicable fees</span></span>
                                                        </td>
                                                        <td class="val text-right">
                                                            $ {{$data->neat_amount}}
                                                        </td>
                                                    </tr>
                                                    @foreach($data->scheduled_payments as $i => $payment)
                                                        <tr class="expandable payment_sections" id="section_{{$i}}" onclick="toggle_sub_section({{$i}});">
                                                            <td class="name">
                                                                {{$payment['day']}}
                                                            </td>
                                                            <td class="val text-right">
                                                                $ {{$payment['price']}}
                                                            </td>
                                                        </tr>
                                                        @foreach($payment['section'] as $key => $value)
                                                            <tr class="payment_sub_sections sub_sections_{{$i}}">
                                                                <td class="name">
                                                                    {{$key}}
                                                                    @if(strpos($key, 'Fee'))<span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important; font-weight: bold;">This fee helps us run our platform and offer our services</span></span>@endif
                                                                </td>
                                                                <td class="val text-right">
                                                                    $ {{$value}}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach

                                                    <tr class="row_border_top row_border">
                                                        <td class="name">
                                                            Cleaning Fee
                                                            <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">Decided by the property owner to clean after your stay.</span></span>
                                                        </td>
                                                        <td class="val text-right" >
                                                            $ {{$data->cleaning_fee}}
                                                        </td>
                                                    </tr>

                                                    <tr class="row_border">
                                                        <td class="name">
                                                            Deposit
                                                            <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">If property owner reports no damage, your deposit will be returned 72 hours after your stay.</span></span>
                                                        </td>
                                                        <td class="val text-right" >
                                                            $ {{$data->security_deposit}}
                                                        </td>
                                                    </tr>

                                                    <tr style="font-weight: normal;">
                                                        <td class="name">
                                                            Total Cost
                                                        </td>
                                                        <td class="val text-right" >
                                                            $ {{$data->total_price}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="name" style="padding: 0 10px;">
                                                            <b>Due on Approval</b>
                                                        </td>
                                                        <td class="val text-right" >
                                                            <b>$ {{$data->pay_now}}</b>
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
                                                    @if(in_array($data->bookingStatus, [0, 1]))
                                                        @if(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($data->start_date), false) >= 7)
                                                            @if(Session::get('user_id'))
                                                                <tr class="editable-fields">
                                                                    <td colspan="2">
                                                                        <label class="checkbox-container">
                                                                            I agree to the <a href="{{BASE_URL}}/terms-of-use" target="_blank">Terms of Use</a>, <a href="{{BASE_URL}}/privacy-policy" target="_blank">Privacy Policy</a>, <a href="{{BASE_URL}}/policies" target="_blank">Policies</a>, <a href="{{BASE_URL}}/payment-terms" target="_blank">Payment Terms</a>, <a href="{{BASE_URL}}/non-discrimination-policy" target="_blank">Nondiscrimination Policy</a> and <a href="{{URL('/')}}/cancellationpolicy">Cancellation Policy</a>.
                                                                            <input type="checkbox" required name="terms" id="terms">
                                                                            <span class="checkmark"></span>
                                                                        </label>
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
                                                        @else
                                                            <tr class="editable-fields">
                                                                <td colspan="2">
                                                                    <div style="margin-top: 30px; color: #e08716; text-align: center;">This booking has been expired. Please try to book again with new dates.</div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @elseif($data->bookingStatus == 2)
                                                        <tr class="editable-fields">
                                                            <td colspan="2">
                                                                <div style="margin-top: 30px; color: #e08716;">This booking request has been accepted by owner.</div>
                                                            </td>
                                                        </tr>
                                                    @elseif($data->bookingStatus == 3)
                                                        <tr class="editable-fields">
                                                            <td colspan="2">
                                                                <div style="margin-top: 30px; color: #e08716;">This booking is completed.</div>
                                                            </td>
                                                        </tr>
                                                    @elseif($data->bookingStatus == 4)
                                                        <tr class="editable-fields">
                                                            <td colspan="2">
                                                                <div style="margin-top: 30px; color: #e08716;">This booking request is denied by Owner.</div>
                                                            </td>
                                                        </tr>
                                                    @elseif($data->bookingStatus == 8)
                                                        <tr class="editable-fields">
                                                            <td colspan="2">
                                                                <div style="margin-top: 30px; color: #e08716;">This booking has been canceled.</div>
                                                            </td>
                                                        </tr>
                                                    @endif
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
                                        To complete this booking, you will need your bank account login details and bank account number and routing number. Select the add account details button below and setup your account details by logging in and answer any questions that are required to verify your identify.  You will not be charged until the property owner confirms your request. Bookings are confirmed on a first come first serve basis. Please review this listing in its entirety and the selected cancellation policy prior to booking. To change or add new bank account visit "My Payment Options" tab in your account. To check the status of your booking visit "My Trips" tab in your account.<br><br>
                                        *Please Note: Make sure your account is Up-To-Date and Complete including the (About Me) in your profile. This allows property owners to approve your stay quicker. If you have any questions or concerns email <a href="mailto:support@healthcaretravels.com">support@healthcaretravels.com</a>
                                        <p></p>
                                    </div>
                                </div>

                                @component('components.funding-source', ['funding_sources' => $funding_sources, 'user' => $traveller])
                                @endcomponent
                                <hr>
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
                                                    <div class="panel-body" style="position: relative;">
                                                        <input name="guest_id[]" type="hidden" value="{{$guest_data->id ?? ''}}">
                                                        <div class="control-group cc-first-name col-md-6">
                                                            <label class="control-label" for="credit-card-first-name">
                                                                Guest Name
                                                            </label>
                                                            <input id="name_{{$i}}" name="guest_name[]" type="text" value="{{$guest_data->name ?? ''}}" required>
                                                        </div>
                                                        <div class="control-group cc-last-name col-md-6">
                                                            <label class="control-label" for="credit-card-first-name">
                                                                Occupation
                                                            </label>
                                                            <input id="occupation_{{$i}}" name="guest_occupation[]" type="text" value="{{$guest_data->occupation ?? ''}}" required>
                                                        </div>
                                                        <div class="control-group cc-last-name col-md-6">
                                                            <label class="control-label" for="credit-card-first-name">
                                                                Phone Number
                                                            </label>
                                                            <input class="masked_phone_us" id="phone_{{$i}}"  name="phone_number[]" type="text" value="{{$guest_data->phone_number?? ''}}" required>
                                                        </div>
                                                        <div class="control-group cc-last-name col-md-6">
                                                            <label class="control-label" for="credit-card-first-name">
                                                                Email
                                                            </label>
                                                            <input id="email_{{$i}}" name="email[]" type="email" value="{{$guest_data->email ?? ''}}" required>
                                                        </div>
                                                        <div class="control-group cc-last-name col-md-6">
                                                            <label class="control-label" for="credit-card-first-name">
                                                                Age
                                                            </label>
                                                            <select id="age_{{$i}}" name="age[]" data-placeholder="Select Age" required>
                                                                <option label="Select Age" value="" disabled selected>Select Age</option>
                                                                <option label="Adult" value="Adult" @if($guest_data && $guest_data->age == 'Adult') selected @endif></option>
                                                                <option label="Child (Ages 2-12)" value="Child" @if($guest_data && $guest_data->age == 'Child') selected @endif></option>
                                                                <option label="Infant (Under 2)" value="Infant" @if($guest_data && $guest_data->age == 'Infant') selected @endif></option>
                                                            </select>
                                                        </div>
                                                        @if($i == 0)
                                                            <div onclick="add_my_info();" class="btn bg-orange" style="position: absolute; bottom: 0; right: 10px; margin-bottom: 20px; width: auto;">Add my info</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <hr>
                                @if ($data->pets_allowed)
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
                                        <div id="remove_pet" class="add-another" style="cursor: pointer;">Don't want to add a pet?</div>
                                    </div>
                                    <hr>
                                @endif
                                <div class="form-row form-row-wide" id="agency_show">
                                    <label for="agency_name"><b>Agency you work for this assignment:</b></label>
                                    <p class="register-info">Select the agency you are traveling with for this assignment.</p>
                                    <span class="autocomplete-select"></span>
                                    <p id="agency_error" class="error-text" style="display: none;">Select at least 1 agency</p>
                                    <div id="add_another_agency" class="add-another" onclick="add_another_agency(true)" style="cursor: pointer;">Can't find it? Add it here.</div>
                                    <input type="hidden" name="name_of_agency" id="name_of_agency" value="">
                                    <label for="other_agency_name" id="other_agency_name" style="display: none;">Other Agency:</label>
                                    <input type="text" style="display: none;" class="input-text validate" name="other_agency" id="other_agency" value="{{$traveller->other_agency}}" placeholder="Other agency" autocomplete="off">
                                    <div style="display: none;" id="other_agency_cancel" class="add-another" onclick="add_another_agency()" style="cursor: pointer;">Cancel</div>
                                </div>
                                <hr>
                                <h2 style="margin-bottom: 20px;">Recruiter Details</h2>
                                <div class="wrapper center-block">
                                    <div class="row">
                                        <div class="control-group cc-first-name col-md-6">
                                            <label class="control-label" for="recruiter_name">
                                                Recruiter Name
                                            </label>
                                            <input id="recruiter_name" name="recruiter_name" type="text" value="{{$data->recruiter_name ?? ''}}" required>
                                        </div>
                                        <div class="control-group cc-first-name col-md-6">
                                            <label class="control-label" for="recruiter_email">
                                                Recruiter Email
                                            </label>
                                            <input id="recruiter_email" name="recruiter_email" type="email" value="{{$data->recruiter_email ?? ''}}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="control-group cc-first-name col-md-4">
                                            <label class="control-label" for="recruiter_phone_number">
                                                Recruiter Phone Number
                                            </label>
                                            <input class="masked_phone_us" id="recruiter_phone_number" name="recruiter_phone_number" type="text" value="{{$data->recruiter_phone_number ?? ''}}" required>
                                        </div>
                                        <div class="control-group cc-first-name col-md-4">
                                            <label class="control-label" for="contract_start_date">
                                                Contract Start Date
                                            </label>
                                            <input type="text" name="contract_start_date"
                                                   placeholder="mm/dd/yyyy"
                                                   id="contract_date_range_picker" autocomplete="off" required/>
                                        </div>
                                        <div class="control-group cc-first-name col-md-4">
                                            <label class="control-label" for="contract_end_date">
                                                Contract End Date
                                            </label>
                                            <input type="text" name="contract_end_date"
                                                   placeholder="mm/dd/yyyy"
                                                   id="contract_date_range_picker" autocomplete="off" required/>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button id="scrollToSubmit" class="btn btn-default btn-block bg-orange" style="width: auto; margin: 20px auto;">Scroll Up to Accept Terms, Review, and Submit</button>
                                </div>
                            </section>
                        </div>
                    </div>

                    <div style="height:200px"></div>

                </form>
            </div>
        </div>
        <div id="request_booking_loading" class="loading style-2" style="display: none;"><div class="loading-wheel"></div></div>
    </div>

    <script>
        var allAgencies = [];
        var agencyAutoComplete;

        $(document).ready(function(){
            var defaultFundingSource = "{{$traveller->default_funding_source}}";
            $('#fundingSource').val(defaultFundingSource);
            if($('#fundingSource').val() && $('#terms').is(":checked")) {
                $('#requestBooking').attr('disabled',false);
            }

            $('#fundingSource').change(function (e) {
                if($('#fundingSource').val() && $('#terms').is(":checked")) {
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
            var bookingData = <?php echo json_encode($data); ?>;
            if(bookingData.contract_start_date && bookingData.contract_start_date !='0000-00-00' && bookingData.contract_end_date != '0000-00-00') {
                var start = moment(bookingData.contract_start_date, "YYYY-MM-DD").format("MM/DD/YYYY")
                var end = moment(bookingData.contract_end_date, "YYYY-MM-DD").format("MM/DD/YYYY")
                $('input[id="contract_date_range_picker"][name="contract_start_date"]').val(start);
                $('input[id="contract_date_range_picker"][name="contract_end_date"]').val(end);
            }

            $('input[id="contract_date_range_picker"]').daterangepicker({
                opens: 'center',
                autoUpdateInput: false,
                autoApply: true,
            });
            $('input[id="contract_date_range_picker"]').keydown(function (e) {
                e.preventDefault();
                return false;
            });
            $('input[id="contract_date_range_picker"]').on('apply.daterangepicker', function (ev, picker) {
                $('input[id="contract_date_range_picker"][name="contract_start_date"]').val(picker.startDate.format('MM/DD/YYYY'));
                $('input[id="contract_date_range_picker"][name="contract_end_date"]').val(picker.endDate.format('MM/DD/YYYY'));
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

        function add_my_info(key) {
            var traveller = <?php echo json_encode($traveller); ?>;
            $('#name_0').val(`${traveller.first_name} ${traveller.last_name}`);
            $('#occupation_0').val(traveller.occupation);
            $('#phone_0').val(traveller.phone);
            $('#email_0').val(traveller.email);
            $('#age_0').val('Adult');
        }
        function load_agencies() {
            var agencies = <?php echo json_encode($agency); ?>;
            allAgencies = agencies;
            initPureSelect(agencies);
        }

        function initPureSelect(agencies, selected) {
            var selected_agencies = '';
            {{--selected_agencies = selected_agencies ? selected_agencies.split(',') : [];--}}
            {{--if (selected) {--}}
            {{--    selected_agencies = selected;--}}
            {{--}--}}
            var mappedData = agencies.map(a => ({
                label: a.name,
                value: a.name
            }));
            $('.autocomplete-select').empty();
            var autocomplete = new SelectPure(".autocomplete-select", {
                options: mappedData,
                value: selected_agencies,
                multiple: false,
                autocomplete: true,
                icon: "fa fa-times",
                placeholder: "Select Agencies",
                onChange: function (e) {
                    $('#agency_error').hide();
                }
            });
            agencyAutoComplete = autocomplete;
        }

        $('#requestBooking').click(function (event) {
            $(".panel-body input[required],select[required]").each(function() {
                if (!$(this).val()) {
                    $(".panel-collapse.in").removeClass("in");
                    $(this).closest(".panel-collapse").addClass("in").css("height","auto");
                    return false;
                }
            });
        });

        $('#scrollToSubmit').click(function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(window).scrollTop($('#requestBooking').offset().top-500);
            return false;
        });

        function validate_submit() {
            $('#name_of_agency').val(agencyAutoComplete.value());
            if ($('#other_agency').val() || (agencyAutoComplete.value().length && agencyAutoComplete.value().length)) {
                $('#request_booking_loading').show();
                return true;
            }
            $('#agency_error').show();
            $(window).scrollTop($('#agency_error').offset().top-500);
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
        $('#terms').change(function (e) {
            e.stopPropagation();
            e.preventDefault();
            if($('#fundingSource').val() && $(this).is(":checked")) {
                $('#requestBooking').attr('disabled',false);
            } else {
                $('#requestBooking').attr('disabled',true);
            }
            return !$(this).is(":checked");
        });

        $('#neat_amount').click(function (e) {
            e.stopPropagation();
            e.preventDefault();
            if($(this).hasClass('active')) {
                $('.payment_sub_sections').removeClass('active');
                $('.payment_sections').removeClass('expanded');
            } else {
            }
            $('.payment_sections').toggleClass('active');
            $(this).toggleClass('active');
        });
        function toggle_sub_section(index) {
            $(`#section_${index}`).toggleClass('expanded');
            $(`.sub_sections_${index}`).toggleClass('active');
        };
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
@endsection
