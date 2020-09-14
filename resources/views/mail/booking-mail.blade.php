@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        {{$text}}
    </div>
    <div style="padding-top: 5px;">
        <div class="panel payments-listing payment_list_right">
            <div class="panel-body">
                <section id="your-trip" class="your-trip">
                    <div class="hosting-info">
                        <div class="payments-listing-name h4 row-space-1" style="word-wrap: break-word;">
                            <h4>{{$data->title}}</h4>
                            <p style="font-weight: normal; font-size: 14px; margin: 10px 0px !important;">{{$data->location}}</p>
                        </div>
                        <div class="">
                            <hr>
                            <div class="row-space-1">
                                <strong>{{$data->room_type}}</strong>
                            </div>
                            <div>
                                <strong>{{$data->start_date}}</strong> to <strong>{{$data->end_date}}</strong>
                            </div>
                        </div>
                        <hr>
                        <table class="reso-info-table">
                            <tbody>
                                <tr>
                                    <td>Cancellation Policy</td>
                                    <td>
                                    &nbsp;
                                    <a href="{{URL('/')}}/cancellationpolicy" class="cancel-policy-link" target="_blank">{{$data->cancellation_policy}} </a>
                                    </td>
                                </tr>
                                <tr>
                                </tr>
                                <tr>
                                    <td>
                                    Nights
                                    </td>
                                    <td>
                                    &nbsp;
                                    {{$data->total_days}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <section id="billing-summary" class="billing-summary">
                            <table id="billing-table" class="reso-info-table billing-table" style="width:95%">
                                <tbody>
                                    <h4>Property Pricing Details</h4>
                                    <tr style=" border-bottom: 1px solid lightgrey;">
                                    <td class="name pos-rel" >
                                        <span class="lang-chang-label">
                                        $
                                        </span>{{$data->single_day_fare}} x {{$data->total_days}} night
                                        <span class='tooltips'><i style="color:black"  class='fa fa-question-circle'></i><span style="color: white!important" class='tooltiptext'>Average Nightly rate is Rounded</span></span>
                                    </td>
                                    <td class="val text-left">
                                        <span class="lang-chang-label">  $
                                        </span><span>{{$data->single_day_fare*$data->total_days}}</span>
                                    </td>
                                    </tr>
                                    @if($data->extra_guest!=0)
                                    <tr style=" border-bottom: 1px solid lightgrey;">
                                    <td class="name">
                                        Extra Guest {{$data->extra_guest}} X {{$data->extra_guest_price/$data->extra_guest}}
                                        <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">Average Nightly rate is Rounded</span></span>
                                    </td>
                                    <td class="val text-left">
                                        <span class="lang-chang-label">
                                        $
                                        </span><span>{{$data->extra_guest_price}}</span>
                                    </td>
                                    </tr>
                                    @endif
                                    <tr style=" border-bottom: 1px solid lightgrey;">
                                    <td class="name pos-rel">
                                        Service Tax
                                        <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">Average Nightly rate is Rounded</span></span>
                                    </td>
                                    <td class="val text-left">
                                        <span class="lang-chang-label">         $
                                        </span><span>{{$data->service_tax}}</span>
                                    </td>
                                    </tr>

                                    <tr style=" border-bottom: 1px solid lightgrey;">
                                    <td class="name">
                                        Cleaning fee
                                        <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">Average Nightly rate is Rounded</span></span>
                                    </td>
                                    <td class="val text-left">
                                        <span class="lang-chang-label">
                                        $
                                        </span><span>{{$data->cleaning_fare}}</span>
                                    </td>
                                    </tr>

                                    <tr style=" border-bottom: 1px solid lightgrey;">
                                    <td class="name">
                                        Security Deposit <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i></span>
                                    </td>
                                    <td class="val text-left">
                                        <span class="lang-chang-label">
                                        $
                                        </span><span>{{$data->security_deposit}}</span>
                                    </td>
                                    </tr>


                                    <tr style=" border-bottom: 1px solid lightgrey;">
                                    <td class="name">
                                        <b>Total Amount </b>
                                    </td>
                                    <td class="val text-left">
                                        <span class="lang-chang-label">
                                        $
                                        </span><span><b>{{$data->total_amount+$data->coupon_value}}</b></span>
                                    </td>
                                    </tr>
                                    @if($data->coupon_value!="")
                                    <tr style=" border-bottom: 1px solid lightgrey;">
                                    <td class="name" style="color:green;font-weight: bold">
                                        Discount(Coupon)
                                    </td>
                                    <td class="val text-left">
                                        <span class="lang-chang-label" style="color:green;font-weight: bold">
                                        $
                                        </span><span style="color:green;font-weight: bold">{{$data->coupon_value}}</span>
                                    </td>
                                    </tr>
                                    @endif
                                    <tr class="editable-fields" id="total_amount">
                                    <td colspan="2">
                                        <div class="total_amount" style="margin: 10px 0;color: white; background-color: #e78016; font-weight: bold; padding: 10px; text-align: center;">
                                            <a href="{{BASE_URL}}owner/single-booking/{{$data->booking_id}}" style="color: white" target="_blank">
                                                Accept Request
                                            </a>
                                        </div>
                                    </td>
                                    </tr>
                                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                                    @if($data->coupon_value!="")
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
@endsection
