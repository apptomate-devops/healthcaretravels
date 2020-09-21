@extends('layout.master')
@section('title',APP_BASE_NAME.' | Owner Account | My Bookings page')
@section('main_content')
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
                    <tr>
                        <td>{{date('m/d/Y',strtotime($data->start_date))}}</td>
                        <td>Cleaning Fee</td>
                        <td>+${{$data->cleaning_fee}}</td>
                        <td>Pending</td>
                        <td></td>
                    </tr>
                    @foreach($scheduled_payments as $payment)
                        <tr>
                            <td>{{date('m/d/Y',strtotime($payment['due_date']))}}</td>
                            <td>Stay payment</td>
                            <td>+${{$payment['amount']}}</td>
                            <td>Pending</td>
                            <td>Covering {{$payment['covering_range']}}, Minus ${{$payment['service_tax']}} fee</td>
                        </tr>
                    @endforeach
                </table>
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
                        <br><br>
                    @if($data->status == 1)


                        <button class="button" onclick="owner_status_update(2)">Accept Request</button>
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
                    <a style="float: right;margin-bottom: 40px;" target="_blank" href="{{BASE_URL}}invoice/{{$data->booking_id}}" class="margin-top-40 button border">Print Invoice</a>
                </div>

            </div>

        </div>
    </div>
    <script type="text/javascript">
    function owner_status_update(status){
            var id = $('#booking_id').val();
            if(status == 4){
                var r = confirm("Do you want to cancel this Booking Request?");
            }else{
                var r = true;
            }

            if (r == true) {
                var url = window.location.protocol + "//" + window.location.host + "/owner-update-booking?booking_id="+id+"&status="+status;
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        if(data.status === 'SUCCESS') {
                            location.reload();
                        }
                    }
                });

            }
        }
    </script>
@endsection

