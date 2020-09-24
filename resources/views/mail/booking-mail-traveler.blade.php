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
                            <h2>{{$property->title}}</h2>
                            <p style="font-weight: normal; font-size: 14px; margin: 10px 0px !important;">{{$property->city}} ,{{$property->state}}</p>
                        </div>
                        <div class="">
                            <hr>
                            <div class="row-space-1">
                                <strong>{{$property->room_type}}</strong>
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
                                    <a href="{{URL('/')}}/cancellationpolicy" class="cancel-policy-link" target="_blank">{{$property->cancellation_policy}} </a>
                                    </td>
                                </tr>
                                <tr>
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
                                        </span>{{$property->monthly_rate}}
                                            <span class='tooltips'><i style="color:black"  class='fa fa-question-circle'></i><span style="color: white!important" class='tooltiptext'>Monthly rate</span></span>
                                        </td>
                                        <td class="val text-left">
                                        <span class="lang-chang-label">  $
                                        </span><span>{{$property->monthly_rate}}</span>
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
                                        </span><span>{{SERVICE_TAX}}</span>
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
                                        </span><span>{{$data->cleaning_fee}}</span>
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
