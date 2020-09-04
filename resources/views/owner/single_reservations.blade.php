@extends('layout.master')
@section('title')
{{APP_BASE_NAME}} | Owner Account | My Bookings page
@endsection
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

    .card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width: 40%;
    background-color: #f2f2f2;
}

.card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.container {
    padding: 2px 16px;
}

td {
    padding-top: .3em;
    padding-bottom: .3em;
}

ul.my-account-nav li a {
    font-size: 14px;
    line-height: 34px;
    color: black;
}
li.sub-nav-title {
    font-size: 16px;
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

                    <tr class="card">
                        <th style="width: 0;background-color: #e78016;">
                            Booking id :
                        </th>
                        <th style="width: 0;background-color: #747777;">
                            {{$data->booking_id}}
                        </th>
                        <th style="width: 0;background-color: #e78016;">
                            Property Name :
                        </th>
                        <th style="width: 0;background-color: #747777;">
                            {{$data->title}}
                        </th>
                    </tr>

                    <tr class="card">
                        <th style="width: 0;background-color: #e78016;">
                            Owner :
                        </th>
                        <th style="width: 0;background-color: #747777;">
                            {{ucfirst($data->traveller_name)}}
                        </th>
                        <th style="width: 0;background-color: #e78016;">
                            Date period :
                        </th>
                        <th style="width: 0;background-color: #747777;">
                            {{date('m-d-Y',strtotime($data->start_date))}} to {{date('m-d-Y',strtotime($data->end_date))}}
                        </th>
                    </tr>

                    {{-- NOTE: Commented the recruiter details as noboday understands what it is! 🤷🏻‍♂️ 😀 --}}
                    {{-- <tr class="card">
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
                    </tr> --}}
                    <tr class="card">
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
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                                Price per night <br> ( {{$data->min_days}} x $ {{$data->single_day_fare}} )
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                                $ {{$data->single_day_fare * $data->min_days}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                                {{$data->min_days}} Nights
                            </p>
                        </th>
                    </tr>

                    <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                                Cleaning Fee
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                                $ {{$data->cleaning_fare}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                               {{--  Cleaning fee type - {{$data->cleaning_fee_type}} , cost - $ {{$data->cleaning_fee}} --}}
                            </p>
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                                Security Deposit
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                                $ {{$data->security_deposit}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                                *refundable
                            </p>
                        </th>
                    </tr>
                    @if($data->extra_guest!=0)
                        <tr>
                            <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                                <p style="color: #000;">
                                    Extra guest ( {{$data->extra_guest}} X $ {{$data->extra_guest_price/$data->extra_guest}})
                                </p>
                            </th>
                            <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                                <p style="color: #000;">
                                    @if($data->extra_guest!=0)
                                    {{$data->extra_guest_price}}
                                    @else
                                    0
                                    @endif

                                </p>
                            </th>
                            <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                                <p style="color: #000;">

                                </p>
                            </th>
                        </tr>
                    @endif

                    <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                                <!-- Service Fee ( {{$data->service_fee_percentage}} % ) -->
                                Service Tax
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                                <!-- <?php $serv_fare = $data->service_fee_percentage * ($data->total_amount / 100); ?>
                                $ {{$serv_fare}} -->

                                $ {{$data->service_tax}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">

                            </p>
                        </th>
                    </tr>

                    {{-- <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                                Tax
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                                $ {{$data->tax_amount}}
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">

                            </p>
                        </th>
                    </tr> --}}

                    <tr>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                                <b>Total</b>
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
                            <p style="color: #000;">
                               <b> $ {{$data->total_amount}}</b>
                            </p>
                        </th>
                        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid lightgrey">
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
                <div >

                    <?php $single_pay = $data->total_amount / $data->payment_splitup; ?>
                    <center>
                        @if($data->payment_done == 1)
                            <span class="txt-green">Payment Done</span><br>
                        @else
                            <span class="txt-blue">Not Paid</span><br>
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

