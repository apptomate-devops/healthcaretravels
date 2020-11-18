@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        You requested a booking at <strong>{{$property->title}}</strong> for <strong>{{date('m-d-Y', strtotime($data->start_date))}}</strong> to <strong>{{date('m-d-Y', strtotime($data->end_date))}}</strong>. The property owner has received your request. Please allow time for your request to be approved. If you have any questions or want to check on the booking status, please don't hesitate to reach out to the property owner. You can also log into your account and go to the <a href="{{URL('/')}}/traveler/my-reservations">My Trips</a> Tab or click the View Request button below.
    </div>
    <div style="padding-top: 5px;">
        <div class="panel payments-listing payment_list_right">
            <div class="panel-body">
                <section id="your-trip" class="your-trip">
                    <div class="hosting-info">
                        <div>
                            <hr>
                            <h2><b>{{$property->title}}</b></h2>
                            <div class="row-space-1">
                                <strong>{{$property->room_type}}</strong>
                            </div>
                            <div>
                                <img src="{{$cover_img}}" style="width: 300px; height: 200px; margin-top: 20px;" alt="">
                            </div>
                        </div>
                        <hr>
                        <section id="billing-summary" class="billing-summary">
                            <table id="billing-table" class="reso-info-table billing-table">
                                <tbody>
                                <h4>Payment Details</h4>
                                <tr class="expandable" id="neat_amount">
                                    <td class="name pos-rel" >
                                                                <span class="lang-chang-label">
                                                                    {{$booking_price->count_label}}
                                                                </span>
                                        <span class='tooltips'><i style="color:black"  class='fa fa-question-circle'></i><span style="color: white!important" class='tooltiptext'>The cost of your stay including applicable fees</span></span>
                                    </td>
                                    <td class="val text-right">
                                        $ {{$booking_price->neat_amount}}
                                    </td>
                                </tr>
{{--                                @foreach($booking_price->scheduled_payments as $i => $payment)--}}
{{--                                    <tr class="expandable payment_sections" id="section_{{$i}}" onclick="toggle_sub_section({{$i}});">--}}
{{--                                        <td class="name">--}}
{{--                                            {{$payment['day']}}--}}
{{--                                        </td>--}}
{{--                                        <td class="val text-right">--}}
{{--                                            $ {{$payment['price']}}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    @foreach($payment['section'] as $key => $value)--}}
{{--                                        <tr class="payment_sub_sections sub_sections_{{$i}}">--}}
{{--                                            <td class="name">--}}
{{--                                                {{$key}}--}}
{{--                                            </td>--}}
{{--                                            <td class="val text-right">--}}
{{--                                                $ {{$value}}--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                @endforeach--}}

                                <tr class="row_border_top row_border">
                                    <td class="name">
                                        Cleaning Fee
                                        <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">Decided by the property owner to clean before your stay</span></span>
                                    </td>
                                    <td class="val text-right" >
                                        $ {{$booking_price->cleaning_fee}}
                                    </td>
                                </tr>

                                <tr class="row_border">
                                    <td class="name">
                                        Deposit
                                        <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">If property owner reports no damage, your deposit will be returned 72 hours after your stay</span></span>
                                    </td>
                                    <td class="val text-right" >
                                        $ {{$booking_price->security_deposit}}
                                    </td>
                                </tr>

                                <tr style="font-weight: bold;">
                                    <td class="name">
                                        Total Cost
                                    </td>
                                    <td class="val text-right" >
                                        $ {{$booking_price->total_price}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </section>
                        <hr>
                        <div>
                            Cancellation Policy: <a href="{{URL('/')}}/cancellationpolicy" class="cancel-policy-link" target="_blank">{{$property->cancellation_policy}} </a>
                        </div>
                        <hr>
                        <div class="total_amount" style="flex: 1; display: inline-block; width: 100%; max-width: 400px; margin: 10px;color: white; background-color: #e78016; font-weight: bold; padding: 10px; text-align: center;">
                            <a href="{{URL('/')}}/owner/reservations/{{$data->booking_id}}" style="color: white" target="_blank">
                                View Request
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
