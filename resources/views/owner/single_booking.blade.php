@extends('layout.master')
@section('title',APP_BASE_NAME.' | Owner Account | My Bookings page')
@section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/bookings.css') }}">

    @php
        $payment_error_message = 'Please add a new account or contact support';
    @endphp

    <div class="container single_bookings">
        <div class="row">


            <!-- Widget -->
            <div class="col-md-4">
                <div class="sidebar left">

                    <div class="my-account-nav-container">

                        @include('owner.menu')

                    </div>

                </div>
            </div>

            <div class="col-md-8">
                <div class="booking-details">
                    <a class="btn bg-orange" id="chat_now" href="/owner-profile/{{$data->traveller_id}}">Chat now with {{$data->traveller_name}}</a>
                    <h3>Details</h3>
                    <div>Booking Reservation: <span>{{$data->booking_id}}</span></div>
                    <div>Property Name: <a href="/property/{{$data->property_id}}">{{$data->title}}</a></div>
                    <div>Traveler:
                        <a href="/owner-profile/{{$data->traveller_id}}">
                            <img src="{{($data->traveller_profile_image != " " && $data->traveller_profile_image != 0) ? $data->traveller_profile_image : '/user_profile_default.png'}}"/>
                            {{$data->traveller_name}}
                        </a>
                    </div>
                    <div>Check-in: <span>{{date('m-d-Y',strtotime($data->start_date))}}</span></div>
                    <div>Check-out: <span>{{date('m-d-Y',strtotime($data->end_date))}}</span></div>
                    <div>Guests: <span>{{$data->guest_count}}</span></div>
                    <div>Total Earnings: <span>$ {{$total_earning}}</span></div>
                </div>

                <input type="hidden" id="booking_id" value="{{$data->booking_id}}">
                <table class="pricing-table responsive-table">
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                    @foreach($scheduled_payments as $payment)
                        @if($payment['payment_cycle'] == 1)
                            <tr>
                                <td>{{date('m/d/Y',strtotime($payment['due_date']))}}</td>
                                <td>Cleaning Fee</td>
                                <td>+${{$payment['cleaning_fee']}}</td>
                                <td>
                                    <p>
                                        <b>{{Helper::get_payment_status($payment['is_cleared'], $payment['is_owner'])}}</b>
                                    </p>
                                    <p>{{($payment['is_cleared'] == -1) ? $payment_error_message : ''}}</p>
                                </td>
                                <td></td>
                            </tr>
                        @endif
                        <tr>
                            <td>{{date('m/d/Y',strtotime($payment['due_date']))}}</td>
                            <td>Stay payment</td>
                            <td>+${{$payment['amount']}}</td>
                            <td>
                                <p>
                                    <b>{{Helper::get_payment_status($payment['is_cleared'], $payment['is_owner'])}}</b>
                                </p>
                                <p>{{($payment['is_cleared'] == -1) ? $payment_error_message : ''}}</p>
                            </td>
                            <td>Covering {{$payment['covering_range']}}, Minus ${{$payment['service_tax']}} fee</td>
                        </tr>
                    @endforeach
                </table>
                <div class="text-right">
                    <a target="_blank" href="{{BASE_URL}}invoice/{{$data->booking_id}}/1" class="margin-top-40 button border">Print Invoice</a>
                </div>

                @if(count($guest_info) > 0)
                    <h2>Guest Information</h2>
                    <table class="table table-striped">
                        <tr>
                            <th>S.no</th>
                            <th>Name</th>
                            <th>Occupation</th>
                            <th>Age</th>
                        </tr>
                        @foreach($guest_info as $key => $g)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$g->name}}</td>
                                <td>{{$g->occupation}}</td>
                                <td>{{$g->age}}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
                @if(isset($pet_details) > 0)
                    <h2>Pet Details</h2>
                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Breed</th>
                            <th>Weight (lb)</th>
                            <th>Image</th>
                        </tr>
                        <tr>
                            <td>{{$pet_details->pet_name}}</td>
                            <td>{{$pet_details->pet_breed}}</td>
                            <td>{{$pet_details->pet_weight}}</td>
                            <td>
                                <a href="{{$pet_details->pet_image}}" target="_blank">
                                    <img src="{{$pet_details->pet_image}}" alt="">
                                </a>
                            </td>
                        </tr>
                    </table>
                @endif
                @if($data->agency)
                    <h2>Agency Details</h2>
                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                        </tr>
                        <tr>
                            <td>{{$data->agency}}</td>
                        </tr>
                    </table>
                @endif
                <div>
                    <center>
                        @if($data->status == 1)
                            @component('components.funding-source', ['funding_sources' => $funding_sources])
                            @endcomponent

                            <button class="button" id="acceptRequest" onclick="owner_status_update(2)" style="margin-top: 40px;" disabled>Accept Request</button>
                            <button class="button" onclick="owner_status_update(4)" style="background-color: #e78016;">Decline Request</button>
                            <br><br>

                        @elseif($data->status == 2)
                            <button class="button" >Request Accepted</button><br><br>
                        @elseif($data->status == 3)
                            <button class="button" >Invoice sent</button><br><br>
                        @elseif($data->status == 4)
                            <button class="button" >Request Declined by you</button><br><br>
                        @else

                        @endif
                    </center>
                </div>

            </div>
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
            <div id="addDetailsProgress" class="loading style-2" style="display: none;"><div class="loading-wheel"></div></div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function (e) {
            var defaultFundingSource = "{{$data->owner_default_funding_source}}";
            $('#fundingSource').val(defaultFundingSource);
            if($('#fundingSource').val()) {
                $('#acceptRequest').attr('disabled',false);
            }

            $('#fundingSource').change(function (e) {
                if($('#fundingSource').val()) {
                    $('#acceptRequest').attr('disabled',false);
                }
            });
        });
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
                id: {{$data->owner_id}},
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
                id: {{$data->owner_id}},
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
    <script type="text/javascript">
        function owner_status_update(status){
            var id = $('#booking_id').val();
            var owner_funding_source = $('#fundingSource').val();

            if(status == 4){
                var r = confirm("Do you want to cancel this Booking Request?");
            }else{
                var r = true;
            }
            if (r == true) {
                var formData = {
                    booking_id: id,
                    status,
                    owner_funding_source
                };
                $.ajax({
                    url: "/owner-update-booking",
                    type: "POST",
                    data: formData,
                    json: true,
                    success: function(response, textStatus, jqXHR) {
                        if(response.success) {
                            window.location.reload();
                        } else {
                            console.log('Error updating status');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error updating status');
                    }
                });
            }
        }
    </script>
@endsection

