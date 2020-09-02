@extends('layout.master')
@section('title',APP_BASE_NAME.' | Owner Account | My Bookings page')
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>
@section('main_content')


    <div class="container" style="margin-top: 35px;">
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
                <table id="print_table" class="manage-table responsive-table" style="border-spacing: 0px 8px;">

                    <tr>
                        <th style="width: 0;background-color: #e78016;">
                            Booking ID :
                        </th>
                        <th style="width: 0;background-color: #747777;" >
                            {{$data->booking_id}}
                        </th>
                        <th style="width: 0;background-color: #e78016;">
                            Property Name :
                        </th>
                        <th style="width: 0;background-color: #747777;">
                            {{$data->title}}
                        </th>
                    </tr>

                    <tr>
                        <th style="width: 0;background-color: #e78016;">
                            Requested By :
                        </th>
                        <th style="width: 0;background-color: #747777;">
                            {{$data->traveller_name}}
                        </th>
                        <th style="width: 0;background-color: #e78016;">
                            Date period :
                        </th>
                        <th style="width: 0;background-color: #747777;">
                            {{date('m-d-Y',strtotime($data->start_date))}} to {{date('m-d-Y',strtotime($data->end_date))}}
                        </th>
                    </tr>
                    @if($data->role_id == 2)
                        <tr class="card">
                            <th style="width: 0;background-color: #e78016;">
                                Recruiter name :
                            </th>
                            <th style="width: 0;background-color: #747777;">
                                {{$data->recruiter_name}}
                            </th>
                            <th style="width: 0;background-color: #e78016;">
                                Recruiter Phone number :
                            </th>
                            <th style="width: 0;background-color: #747777;">
                                {{$data->recruiter_phone_number}}
                            </th>
                        </tr>
                        <tr class="card">
                            <th style="width: 0;background-color: #e78016;">
                               Recruiter Email :
                            </th>
                            <th style="width: 0;background-color: #747777;">
                                {{$data->recruiter_email}}
                            </th>
                            <th style="width: 0;background-color: #e78016;">
                                Contract Period :
                            </th>
                            <th style="width: 0;background-color: #747777;">
                                {{date('m-d-Y',strtotime($data->contract_start_date))}} to {{date('m-d-Y',strtotime($data->contract_end_date))}}
                            </th>
                        </tr>
                    @endif

                    <tr>
                        <th style="width: 0;background-color: #e78016;">
                            Total Payment :
                        </th>
                        <th style="width: 0;background-color: #747777;">
                            $ {{$data->total_amount}}
                        </th>
                        <th style="width: 0;background-color: #e78016;">
                            Total Guests :
                        </th>
                        <th style="width: 0;background-color: #747777;">
                            {{$data->guest_count}}
                        </th>
                    </tr>

                </table>
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
                                Price per night <br> ( {{$data->min_days}} x $ {{$data->price_per_night}} )
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                $ {{$data->price_per_night * $data->min_days}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                {{$data->min_days}} Nights
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
                                $ {{$data->cleaning_fare}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                               {{--  Cleaning fee type - {{$data->cleaning_fee_type}} , cost - $ {{$data->cleaning_fee}} --}}
                            </p>
                        </th>
                    </tr>

                    <!-- <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                City Fee
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                $ {{$data->city_fare}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                City fee type - {{$data->city_fee_type}} , cost - $ {{$data->city_fee}}
                            </p>
                        </th>
                    </tr>
 -->
                    <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                Security Deposit
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                $ {{$data->security_deposit}}
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
                                $ {{$data->service_tax}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">

                            </p>
                        </th>
                    </tr>

                    <!-- <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                Tax
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                $ {{$data->tax_amount}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">

                            </p>
                        </th>
                    </tr>
 -->
                   {{--  <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                Traveler Pays
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                {{$data->total_amount}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">

                            </p>
                        </th>
                    </tr> --}}

                    <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                Homeowner Earns
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                $ {{$data->total_amount - ($data->service_tax + $data->admin_commision)}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">

                            </p>
                        </th>
                    </tr>

                   {{--  <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">
                                Discount :
                            </p>
                            <input type="text" name="discount" id="disount">
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <button class="button" style="margin-top: 33px;">Add</button>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                            <p style="color: #000;">

                            </p>
                        </th>
                    </tr> --}}

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

