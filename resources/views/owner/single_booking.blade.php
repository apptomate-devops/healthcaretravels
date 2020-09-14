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
                    <h3>Details:</h3>
                    <div>Booking ID : <span>{{$data->booking_id}}</span></div>
                    <div>Property Name : <span>{{$data->title}}</span></div>
                    <div>Requested By :
                        <img src="{{($data->traveller_profile_image != " " && $data->traveller_profile_image != 0) ? $data->traveller_profile_image : '/user_profile_default.png'}}"/>
                        <span>{{$data->traveller_name}}</span>
                    </div>
                    <div>Owner :
                        <img src="{{($data->owner_profile_image != " " && $data->owner_profile_image != 0) ? $data->owner_profile_image : '/user_profile_default.png'}}"/>
                        <span>{{$data->owner_name}}</span>
                    </div>
                    <div>Date period : <span>{{date('m-d-Y',strtotime($data->start_date))}} to {{date('m-d-Y',strtotime($data->end_date))}}</span></div>
                    <div>Total Payment : <span>$ {{number_format($data->total_amount, 2)}}</span></div>
                    <div>Total Guests : <span>{{$data->guest_count}}</span></div>
                </div>

                <input type="hidden" id="booking_id" value="{{$data->booking_id}}">
                <table class="manage-table responsive-table" style="border-spacing: 0px 8px;">

                    <tr>
                        <th style="width: 0;background-color: #0983b8;">
                            Cost
                        </th>
                        <th style="width: 0;background-color: #0983b8;">
                            Price
                        </th>
                        <th style="width: 0;background-color: #0983b8;">
                            Detail
                        </th>
                    </tr>

                    <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                Price per night <br> $ {{Helper::get_daily_price($data->monthly_rate)}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                $ {{number_format(Helper::get_daily_price($data->monthly_rate) * $data->total_days, 2)}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                {{$data->total_days}} Nights
                            </p>
                        </th>
                    </tr>

                    <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                Cleaning Fee
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                $ {{number_format($data->cleaning_fee, 2)}}
                            </p>
                        </th>

                    </tr>

                    <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                Security Deposit
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                $ {{number_format($data->security_deposit, 2)}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                *Refundable based on selected Cancellation Policy
                            </p>
                        </th>
                    </tr>



                    <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                Service Fee
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                $ {{number_format($data->service_tax, 2)}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">

                            </p>
                        </th>
                    </tr>



                    <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                Homeowner Earns
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                $ {{number_format($data->total_amount - ($data->service_tax + $data->admin_commision), 2)}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">

                            </p>
                        </th>
                    </tr>


                </table>
                @if(count($guest_info) > 0)
                        <h2>Guest Information</h2>
                        <table class="table table-striped">
                            <tr>
                                <th>S.no</th>
                                <th>Name</th>
                                <th>Occupation</th>
                            </tr>
                            @foreach($guest_info as $key => $g)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$g->name}}</td>
                                    <td>{{$g->occupation}}</td>
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
                        location.reload();
                    }
                });

            }
        }
    </script>
@endsection

