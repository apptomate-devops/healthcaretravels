@extends('layout.mail')
@section('content')
    <div>
        Hi {{$name}},
    </div>
    <div style="padding-top: 5px;">
        A user requested to booking <strong>{{$property->title}}</strong> for <strong>{{date('m-d-Y', strtotime($data->start_date))}}</strong> to <strong>{{date('m-d-Y', strtotime($data->end_date))}}</strong>. Please visit the
        <a href="{{URL('/')}}/owner/my-bookings">Your Bookings</a> page on Health Care Travels to view more details.
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
                                <tr class="expandable" id="neat_amount" style="font-weight: bold;">
                                    <td class="name pos-rel" >
                                           <span class="lang-chang-label">
                                               {{$booking_price->count_label}} (incl. service fees)
                                           </span>
                                    </td>
                                    <td class="val text-right">
{{--                                        deducted cleaning fees form grand total to display neat price for owner --}}
                                        $ {{$payment_summary_owner['grand_total'] - $booking_price->cleaning_fee}}
                                    </td>
                                </tr>
                                <tr class="expandable" id="neat_amount" style="font-weight: bold;">
                                    <td class="name pos-rel" >
                                           <span class="lang-chang-label">
                                               Cleaning Fee
                                           </span>
                                    </td>
                                    <td class="val text-right">
                                        $ {{$booking_price->cleaning_fee}}
                                    </td>
                                </tr>

                                <tr class="expandable" id="neat_amount" style="font-weight: bold;">
                                    <td class="name pos-rel" >
                                        <b><span class="lang-chang-label">Total Payout</span></b>
                                    </td>
                                    <td class="val text-right">
                                        <b>$ {{$payment_summary_owner['grand_total']}}</b>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </section>
                        <div>HCT will hold a security deposit from this traveler of $ {{$booking_price->security_deposit}}</div>
                        <hr>
                        <div>
                            Cancellation Policy: <a href="{{URL('/')}}/cancellationpolicy" class="cancel-policy-link" target="_blank">{{$property->cancellation_policy}} </a>
                        </div>
                        <hr>
                        <div class="total_amount" style="flex: 1; display: inline-block; width: 100%; max-width: 400px; margin: 10px;color: white; background-color: #e78016; font-weight: bold; padding: 10px; text-align: center;">
                            <a href="{{URL('/')}}/owner/single-booking/{{$data->booking_id}}" style="color: white" target="_blank">
                                View Request
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
