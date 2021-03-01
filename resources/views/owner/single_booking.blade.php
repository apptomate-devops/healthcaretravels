@extends('layout.master')
@section('title',APP_BASE_NAME.' | Owner Account | My Bookings page')
@section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/bookings.css') }}">
    <style>
        .show {
            opacity: 1;
            padding-top: 60px;
        }
    </style>

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
                    <form action="{{url('/')}}/chat-with-traveler" method="post" >
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="check_in" value="{{$data->start_date}}">
                        <input type="hidden" name="check_out" value="{{$data->end_date}}">
                        <input type="hidden" name="traveller_id" value="{{$data->traveller_id}}">
                        <input type="hidden" name="property_id" value="{{$data->property_id}}">
                        <button type="submit" class="btn bg-orange" id="chat_now">Chat now with {{$data->traveller_name}}</button>
                    </form>
                    <h3>Details</h3>
                    <div>Booking Reservation: <span>{{$data->booking_id}}</span></div>
                    <div>Property Name: <a href="/property/{{$data->property_id}}">{{$data->title}}</a></div>
                    <div>Traveler:
                        <a href="/owner-profile/{{$data->traveller_id}}">
                            <img class="user-icon" src="{{$data->traveller_profile_image}}"/>
                            {{$data->traveller_name}}
                        </a>
                    </div>
                    <div>Check-in: <span>{{date('m-d-Y',strtotime($data->start_date))}}</span></div>
                    <div>Check-out: <span>{{date('m-d-Y',strtotime($data->end_date))}}</span></div>
                    <div>Guests: <span>{{$data->guest_count}}</span></div>
                    <div>Cancellation Policy: <span><a href="{{URL('/')}}/cancellationpolicy" class="cancel-policy-link" target="_blank">{{$data->cancellation_policy}} </a></span></div>
                    <div>Total Earnings: <span>{{\App\Http\Controllers\PropertyController::format_amount($total_earning)}}</span></div>
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
                        <tr>
                            <td>{{date('m/d/Y',strtotime($payment['due_date']))}}</td>
                            <td>{{$payment['name'] ?? 'Housing Payment'}}</td>
                            <td>{{$payment['amount']}}</td>
                            <td>
                                <p>
                                    <b>{{Helper::get_payment_status($payment)}}</b>
                                </p>
                                <p>{{($payment['is_cleared'] == -1) ? $payment_error_message : ''}}</p>
                            </td>
                            <td>{{$payment['covering_range']}}</td>
                        </tr>
                    @endforeach
                </table>
                <div>The selected account will be used to process any future deposits for this booking.</div>
                @if(in_array($data->status, [2, 3]))
                    <div class="text-right">
                        <a target="_blank" href="{{BASE_URL}}invoice/{{$data->booking_id}}" class="margin-top-40 button border">Print Invoice</a>
                    </div>
                @endif

                @if(count($guest_info) > 0)
                    <h2>Guest Information</h2>
                    <table class="table table-striped">
                        <tr>
                            <th>S.no</th>
                            <th>Name</th>
                            <th>Occupation</th>
                            <th>Age</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                        </tr>
                        @foreach($guest_info as $key => $g)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$g->name}}</td>
                                <td>{{$g->occupation ?? '-'}}</td>
                                <td>{{$g->age ?? '-'}}</td>
                                <td>{{$g->email ?? '-'}}</td>
                                <td>{{$g->phone_number ?? '-'}}</td>
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
                                    <img src="{{$pet_details->pet_image}}" alt="" style="height: 70px; width: 70px;">
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
                            <br>
                            <div style="text-align: left;">
                                To accept this booking request, please add/select the bank account that you wish for Health Care Travels to send your Payout(s) and/or Collect Payment(s) for this booking. You will need your bank account login details and bank account number, and routing number. To add banking details, select the add account details button below and set up your account details by logging in and answer any questions that are required to verify your identity. To change or add a new bank account visit the "Payment Options" tab in your account. To check the status of your booking please visit the "Bookings" tab in your account. Payouts are issued once the traveler has safely checked in.
                                <br>
                                <br>
                                <b>Please Note</b>
                                <br>
                                Make sure your account is Up-To-Date and Complete including the (About Me) in your profile. If you have any questions or concerns email <a href="mailto:support@healthcaretravels.com">support@healthcaretravels.com</a>.
                                <p></p>
                            </div>
                            @component('components.funding-source', ['funding_sources' => $funding_sources, 'user' => $owner])
                            @endcomponent

                            <button class="button" id="acceptRequest" onclick="owner_status_update(2)" style="margin-top: 40px;" disabled>Accept Request</button>
                            <button class="button" onclick="owner_cancel_booking();" style="background-color: #e78016;">Decline Request</button>
                            <br><br>

                        @elseif($data->status == 2)
                            @if($data->cancellation_requested == 1)
                                <div style="text-align: center">Cancellation Pending</div>
                            @else
                                <b>Request Accepted</b>
                                <br><br>
                                <button class="button" onclick="location.href='{{BASE_URL}}request_cancellation/{{$data->booking_id}}';">Request Cancellation</button>
                                <br>
                                <br>
                            @endif
                        @elseif($data->status == 3)
                            <div class="button" >Invoice sent</div><br><br>

                        @elseif($data->status == 4)
                            <div>Request Declined by you</div>
                            <br>
                            <span style="font-weight: bold; color: #e78016">{{$data->deny_reason ?? ''}}</span>
                            <br><br>
                        @elseif($data->status == 8)
                            <button class="button" style="text-align: center;margin-top: 30px; pointer-events: none;">
                                Your booking has been canceled
                            </button>
                            <br><br>
                        @endif
                    </center>
                </div>
            </div>
        </div>
        <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b><span style="color:red">Warning</span></b></h4>
                    </div>
                    <div class="modal-body">
                        Do you want to decline this Booking Request?
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="owner_status_update(4);" >Yes</button>
                        <button type="button" class="btn btn-danger" style="width: 60px;" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="update_status_loading" class="loading style-2" style="display: none;"><div class="loading-wheel"></div></div>

    </div>

    <script type="text/javascript">
        $(document).ready(function (e) {
            var defaultFundingSource = "{{$owner->default_funding_source}}";
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
    <script type="text/javascript">
        function owner_cancel_booking() {
            $('#myModal').modal('show');
        }
        function owner_status_update(status){
            $('#myModal').modal('hide');
            var id = $('#booking_id').val();
            var owner_funding_source = $('#fundingSource').val();

            $('#update_status_loading').show();
            var formData = {
                booking_id: id,
                status: status,
                owner_funding_source: owner_funding_source,
                _token: '{{ csrf_token() }}'
            };
            $.ajax({
                url: "/owner-update-booking",
                type: "POST",
                data: formData,
                json: true,
                success: function(response, textStatus, jqXHR) {
                    $('#update_status_loading').hide();
                    if(response.success) {
                        window.location.reload();
                    } else {
                        console.log('Error updating status');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#update_status_loading').hide();
                    console.log('Error updating status');
                }
            });
        }
    </script>
@endsection

