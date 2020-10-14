<?php
//print_r($properties[0]); exit;
?>
@extends('layout.master')
@section('title','Transaction history ')
@section('main_content')

<!-- Content
================================================== -->
<div class="container">


    <h2>Transaction History</h2>

    <div class="row">

        <div class="col-md-12">

            <div class="style-1">

                <!-- Tabs Navigation -->
                <ul class="tabs-nav">
                    <li class="active"><a href="#tab1">Completed Transactions</a></li>
                    <li class=""><a href="#tab2">Future Transactions</a></li>
                    <li class=""><a href="#tab3">Gross Earnings</a></li>

                </ul>


                <!-- Tabs Content -->
                <div class="tabs-container" style="min-height: 800px;">


                    <!--  completed transcations starts-->
                    <div class="tab-content" id="tab1" style="display: inline-block;">

                        <h2 style="margin-left: 30px;">Paid out : $ 100.00</h2>

                        <div class="col-md-12">
                            <div class="col-md-3">
                                <select name="property_method" required class="chosen-select-no-single" >
                                    <option value="" selected disabled>Account</option>
                                    @foreach($payment_methods as $property)
                                    <option value="{{$property->id}}">{{$property->account_number}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="property_id" required class="chosen-select-no-single" >
                                    <option value="0" selected >All Listings</option>
                                    @foreach($users_property as $property)
                                    <option value="{{$property->id}}">{{$property->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <?php $months = unserialize(MONTHS); ?>
                            <div class="col-md-3">
                                <select name="from_month" required class="chosen-select-no-single" >
                                    <option value="" selected disabled>From Month</option>
                                    @foreach($months as $index => $month)
                                    <option value="{{$index}}">{{$month}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="to_month" required class="chosen-select-no-single" >
                                    <option value="" selected disabled>To Month</option>
                                    @foreach($months as $index => $month)
                                    <option value="{{$index}}">{{$month}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <button class="button" style="margin-top: 10px;float:right;">Update</button>
                            </div>
                        </div>

                        <h2></h2>

                        <div class="col-md-12" style="margin-top: 25px;">
                            <table class="basic-table">

                                <tbody>

                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Details</th>
                                        <th>Amount</th>
                                        <th>Paid out</th>
                                    </tr>

                                    @foreach($payment_dones as $payment_done)
                                    <tr>
                                        <td>Item</td>
                                        <td>Description</td>
                                        <td>Description</td>
                                        <td>Description</td>
                                        <td>Description</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            @if(count($payment_dones) == 0)
                            <center><h2>No Data found</h2></center>
                            @endif
                        </div>

                    </div>
                    <!--  completed transcations ends-->

                    <!--  Future transcations starts-->
                    <div class="tab-content" id="tab2" style="display: none;">

                        <h2 style="margin-left: 30px;">Pending Paid out : $ 100.00</h2>

                        <div class="col-md-12">
                            <div class="col-md-3">
                                <select name="property_method" required class="chosen-select-no-single" >
                                    <option value="" selected disabled>Account</option>
                                    @foreach($payment_methods as $property)
                                    <option value="{{$property->id}}">{{$property->account_number}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="property_id" required class="chosen-select-no-single" >
                                    <option value="0" selected >All Listings</option>
                                    @foreach($users_property as $property)
                                    <option value="{{$property->id}}">{{$property->title}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <button class="button" >Update</button>
                            </div>
                        </div>

                        <h2></h2>

                        <div class="col-md-12" style="margin-top: 25px;">
                            <table class="basic-table">

                                <tbody>

                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Details</th>
                                        <th>Amount</th>
                                        <th>Paid out</th>
                                    </tr>

                                    @foreach($payment_dones as $payment_done)
                                    <tr>
                                        <td>Item</td>
                                        <td>Description</td>
                                        <td>Description</td>
                                        <td>Description</td>
                                        <td>Description</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            @if(count($payment_dones) == 0)
                            <center><h2>No Data found</h2></center>
                            @endif
                        </div>

                    </div>
                    <!--  Future transcations starts-->


                    <!--  gross earnings transcations starts-->
                    <div class="tab-content" id="tab3" style="display: none;">

                        <h2 style="margin-left: 30px;">Earnings Summary</h2>

                        <div class="col-md-12">
                            <div class="col-md-3">
                                <select name="property_method" id="year" required class="chosen-select-no-single" >
                                    <option value="" selected disabled>Year</option>

                                </select>
                            </div>
                            <?php $months = unserialize(MONTHS); ?>
                            <div class="col-md-3">
                                <select name="from_month" required class="chosen-select-no-single" >
                                    <option value="" selected disabled>From Month</option>
                                    @foreach($months as $index => $month)
                                    <option value="{{$index}}">{{$month}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="to_month" required class="chosen-select-no-single" >
                                    <option value="" selected disabled>To Month</option>
                                    @foreach($months as $index => $month)
                                    <option value="{{$index}}">{{$month}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <button class="button" >Update</button>
                            </div>
                        </div>

                        <h2></h2>

                        <div class="col-md-12" style="margin-top: 25px;">
                            <table class="basic-table">

                                <tbody>

                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Details</th>
                                        <th>Amount</th>
                                        <th>Paid out</th>
                                    </tr>

                                    @foreach($payment_dones as $payment_done)
                                    <tr>
                                        <td>Item</td>
                                        <td>Description</td>
                                        <td>Description</td>
                                        <td>Description</td>
                                        <td>Description</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            @if(count($payment_dones) == 0)
                            <center><h2>No Data found</h2></center>
                            @endif
                        </div>

                    </div>
                    <!--  gross earnings transcations starts-->

                </div>

            </div>

        </div>

    </div>

</div>
<script>
    var StartYear='{{START_YEAR}}';
    var EndYear='{{END_YEAR}}';
    var temp="";
    for (var i = StartYear; i<=EndYear; i++) {
        temp +="<option value="+i+">"+i+"</option>";
    }
    $('#year').append(temp);
// console.log(StartYear+' - '+EndYear);
</script>
@endsection
