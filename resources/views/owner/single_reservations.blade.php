@extends('layout.master')
@section('title')
    {{APP_BASE_NAME}} | Owner Account | My Bookings page
@endsection
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
                    <a class="btn bg-orange" id="chat_now" href="/owner-profile/{{$data->owner_id}}">Chat now with {{$data->owner_name}}</a>
                    <h3>Details</h3>
                    <div>Booking Reservation: <span>{{$data->booking_id}}</span></div>
                    <div>Property Name: <a href="/property/{{$data->property_id}}">{{$data->title}}</a></div>
                    <div>Owner:
                        <a href="/owner-profile/{{$data->owner_id}}">
                            <img src="{{($data->owner_profile_image != " " && $data->owner_profile_image != 0) ? $data->owner_profile_image : '/user_profile_default.png'}}"/>
                            {{$data->owner_name}}
                        </a>
                    </div>
                    <div>Check-in: <span>{{date('m-d-Y',strtotime($data->start_date))}}</span></div>
                    <div>Check-out: <span>{{date('m-d-Y',strtotime($data->end_date))}}</span></div>
                    <div>Guests: <span>{{$data->guest_count}}</span></div>
                    <div>Total Payment: <span>$ {{$total_payment}}</span></div>
                </div>
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
                        <td>Security Deposite</td>
                        <td>-${{$data->security_deposit}}</td>
                        <td>Pending</td>
                        <td>Refunded 72 hours after check-out</td>
                    </tr>
                    <tr>
                        <td>{{date('m/d/Y',strtotime($data->start_date))}}</td>
                        <td>Cleaning Fee</td>
                        <td>-${{$data->cleaning_fee}}</td>
                        <td>Pending</td>
                        <td>One-time charge</td>
                    </tr>
                    <tr>
                        <td>{{date('m/d/Y',strtotime($data->start_date))}}</td>
                        <td>Service Tax</td>
                        <td>-${{$data->cleaning_fee}}</td>
                        <td>Pending</td>
                        <td>One-time charge</td>
                    </tr>
                    @foreach($scheduled_payments as $payment)
                        <tr>
                            <td>{{date('m/d/Y',strtotime($payment['due_date']))}}</td>
                            <td>Stay payment</td>
                            <td>-${{$payment['amount']}}</td>
                            <td>Pending</td>
                            <td>{{$payment['covering_range']}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>{{date('m/d/Y',strtotime($data->start_date))}}</td>
                        <td>Security Deposite</td>
                        <td>+${{$data->security_deposit}}</td>
                        <td>Pending</td>
                        <td>Automatic deposit refund 72 hours after check-out</td>
                    </tr>
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
                <div >

                    <?php $single_pay = $data->total_amount / $data->payment_splitup; ?>
                    <center>
                        @if($data->payment_done == 1)
                            <span class="txt-green">Payment Done</span><br>
                        @else
                            <span class="txt-red">Not Paid</span><br>
                        @endif
                        {{-- TODO: need to add pay now button here --}}
                    </center>

                    @if(isset($_GET['id']))
                        <button class="button" onclick="document.location.href='{{BASE_URL}}owner/payment-success?id={{$data->booking_id}}';" style="margin-bottom: 80px;">Pay Now</button>
                    @endif

                    <a style="float: right;margin-bottom: 40px;" target="_blank" href="{{BASE_URL}}invoice/{{$data->booking_id}}" class="margin-top-40 button border">Print Invoice</a>
                    {{-- <a style="float: right;margin-bottom: 40px;" target="_blank" href="{{BASE_URL}}invoice/{{$data->booking_id}}" class="margin-top-40 button border">Cancel Booking</a> --}}
                </div>

            </div>

        </div>
    </div>

@endsection

