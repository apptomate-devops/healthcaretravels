@extends('layout.master')
@section('title')
    {{APP_BASE_NAME}} | Owner Account | My Bookings page
@endsection
@section('main_content')
    @php
        $payment_error_message = 'Please add a new account or contact support';
    @endphp
    <link rel="stylesheet" href="{{ URL::asset('css/bookings.css') }}">

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
                @if($data->status == 1)
                    <div style="font-weight: bold; color: #e08716; margin-bottom: 15px;">Your request has been sent to the property owner. We'll let you know when your request is approved. In the mean time, feel free to start a chat with the property owner to say hello!</div>
                @endif
                <div class="booking-details">
                    <form action="{{url('/')}}/owner/chat-with-traveler" method="post" >
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="check_in" value="{{$data->start_date}}">
                        <input type="hidden" name="check_out" value="{{$data->end_date}}">
                        <input type="hidden" name="traveller_id" value="{{$data->traveller_id}}">
                        <input type="hidden" name="property_id" value="{{$data->property_id}}">
                        <button type="submit" class="btn bg-orange" id="chat_now">Chat now with {{$data->owner_name}}</button>
                    </form>
                    <h3>Details</h3>
                    <div>Booking Reservation: <span>{{$data->booking_id}}</span></div>
                    <div>Property Name: <a href="/property/{{$data->property_id}}">{{$property->title}}</a></div>
                    <div>Owner:
                        <a href="/owner-profile/{{$data->owner_id}}">
                            <img class="user-icon" src="{{$data->owner_profile_image}}"/>
                            {{$data->owner_name}}
                        </a>
                    </div>
                    <div>Check-in: <span>{{date('m-d-Y',strtotime($data->start_date))}}</span></div>
                    <div>Check-out: <span>{{date('m-d-Y',strtotime($data->end_date))}}</span></div>
                    <div>Guests: <span>{{$data->guest_count}}</span></div>
                    <div>Total Due: <span>{{\App\Http\Controllers\PropertyController::format_amount($total_payment)}} (*incl. $ {{$data->security_deposit}} security deposit)</span></div>
                </div>
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
                            <td>{{$payment['due_date_override'] ?? date('m/d/Y',strtotime($payment['due_date']))}}</td>
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
                    <tr>
                        <td>{{\Carbon\Carbon::parse($data->end_date)->addHours(72)->format('m/d/Y')}}</td>
                        <td>Security Deposit</td>
                        <td>{{\App\Http\Controllers\PropertyController::format_amount($data->traveler_cut)}}</td>
                        <td>
                            <b>{{Helper::get_security_payment_status($data)}}</b>
                        </td>
                        <td>Automatic deposit refund 72 hours after check-out</td>
                    </tr>
                </table>
                <div>The selected account will be used to process any future payments for this booking.</div>
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
                @if($data->status == 1)
                    <div style="text-align: center;margin-top: 30px;">
                        <button class="button" onclick="cancel_booking()" >Cancel Booking</button>
                    </div>
                    <br>
                @elseif($data->status == 2)
                    @if($data->cancellation_requested == 1)
                            <div style="text-align: center">Cancellation Pending</div>
                    @else
                        <div style="text-align: center;margin-top: 30px;">
                            <button class="button" onclick="location.href='{{BASE_URL}}request_cancellation/{{$data->booking_id}}';">Request Cancellation</button>
                        </div>
                        <br>
                    @endif
                @elseif($data->status == 4)
                    <div style="text-align: center;margin-top: 30px;">
                        <div>Request Denied by Owner</div>>
                        <br>
                        <span style="font-weight: bold; color: #e78016">{{$data->deny_reason ?? ''}}</span>
                    </div>
                    <br>
                @elseif($data->status == 8)
                    <div style="text-align: center;margin-top: 30px;">
                        Your booking has been canceled
                    </div>
                    <br>
                @endif
{{--                <div>--}}
{{--                    <center>--}}
{{--                        @if($data->payment_done == 1)--}}
{{--                            <span class="txt-green">Payment Done</span><br>--}}
{{--                        @else--}}
{{--                            <span class="txt-red">Not Paid</span><br>--}}
{{--                        @endif--}}
{{--                    </center>--}}

{{--                    @if(isset($_GET['id']))--}}
{{--                        <button class="button" onclick="document.location.href='{{BASE_URL}}owner/payment-success?id={{$data->booking_id}}';" style="margin-bottom: 80px;">Pay Now</button>--}}
{{--                    @endif--}}
{{--                </div>--}}

            </div>

        </div>
        <div class="modal fade in" id="confirmationModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b><span style="color:red">Warning</span></b></h4>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to Cancel booking?
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="cancelBooking">Yes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function cancel_booking() {
            $('#confirmationModal').modal('show');
        }
        $('#cancelBooking').click(function () {
            $('#confirmationModal').modal('hide');
            var id = '{{$data->booking_id}}';
            var url = '{{BASE_URL}}cancel-booking/'+id;
            $.ajax({
                "type": "get",
                "url" : url,
                success: function(data) {
                    if(data.status=="SUCCESS"){
                        window.location.reload();
                    } else {
                        console.log('Error Updating cancel status for booking');
                    }
                },
                error: function (e) {
                    console.log('Error Updating cancel status for booking');
                }
            });
        });
    </script>
@endsection

