<!DOCTYPE html>
<html>
<head>
    <title>{{APP_BASE_NAME}}| Invoice</title>
</head>
<style>
    table.invoice_details {
        width: 100%;
        text-align: center;
    }
</style>

{{-- <body > --}}
    <body onload="window.print()">
<div id="logo" class="margin-top-10">
    <center>
        <a href="{{url('/')}}"><img src="{{url('/')}}/public/keepers_logo.png" alt="" style="width:30%;"></a></br></br>
        <b><span class="data"> PO BOX 14565,<br>
        Humble TX 77347 </span></b>
    </center>
</div>
<br><br>
<table>
    <tr>
        <td>Name</td>
        <td>:</td>
        <td>{{$data->name}}</td>
    </tr>
    <tr>
        <td>Property</td>
        <td>:</td>
        <td>{{$data->title}}</td>
    </tr>
    <tr>
        <td>Booking ID</td>
        <td>:</td>
        <td>{{$data->booking_id}}</td>
    </tr>
    <tr>
        <td>Booked Dates</td>
        <td>:</td>
        <td>{{date('m/d/Y',strtotime($data->start_date))}}&nbsp;to &nbsp;{{date('m/d/Y',strtotime($data->end_date))}}</td>
    </tr>
</table>

<br><br>
<table border="1" class="invoice_details">

    <tr>
        <th style="width: 0;background-color: #e78016;font-size: 25px;">
            Date
        </th>
        <th style="width: 0;background-color: #e78016;font-size: 25px;">
            Name
        </th>
        <th style="width: 0;background-color: #e78016;font-size: 25px;">
            Price
        </th>
        <th style="width: 0;background-color: #e78016;font-size: 25px;">
            Status
        </th>
        <th style="width: 0;background-color: #e78016;font-size: 25px;">
            Detail
        </th>
    </tr>
    @foreach($data->scheduled_payments as $payment)
        @if($payment['payment_cycle'] == 1)
            @if($data->is_owner == 0)
                <tr>
                    <td>{{date('m/d/Y',strtotime($payment['due_date']))}}</td>
                    <td>Security Deposit</td>
                    <td>${{$payment['security_deposit']}}</td>
                    <td>
                        <p>
                            <b>{{Helper::get_payment_status($payment['is_cleared'], $payment['is_owner'])}}</b>
                        </p>
                        <p>{{($payment['is_cleared'] == -1) ? $payment_error_message : ''}}</p>
                    </td>
                    <td>Refunded 72 hours after check-out</td>
                </tr>
                <tr>
                    <td>{{date('m/d/Y',strtotime($payment['due_date']))}}</td>
                    <td>Service Tax</td>
                    <td>${{$payment['service_tax']}}</td>
                    <td>
                        <p>
                            <b>{{Helper::get_payment_status($payment['is_cleared'], $payment['is_owner'])}}</b>
                        </p>
                        <p>{{($payment['is_cleared'] == -1) ? $payment_error_message : ''}}</p>
                    </td>
                    <td>One-time charge</td>
                </tr>
            @endif
                <tr>
                    <td>{{date('m/d/Y',strtotime($payment['due_date']))}}</td>
                    <td>Cleaning Fee</td>
                    <td>${{$payment['cleaning_fee']}}</td>
                    <td>
                        <p>
                            <b>{{Helper::get_payment_status($payment['is_cleared'], $payment['is_owner'])}}</b>
                        </p>
                    </td>
                    <td></td>
                </tr>
        @endif
        <tr>
            <td>{{date('m/d/Y',strtotime($payment['due_date']))}}</td>
            <td>Stay payment</td>
            <td>${{$payment['amount']}}</td>
            <td>
                <p>
                    <b>{{Helper::get_payment_status($payment['is_cleared'], $payment['is_owner'])}}</b>
                </p>
            </td>
            <td>Covering {{$payment['covering_range']}}, Minus ${{$payment['service_tax']}} fee</td>
        </tr>
    @endforeach
    @if($data->is_owner == 0)
        {{--                    TODO: Add security deposit details here when handled--}}
        <tr style="height: 54px;">
            <td>{{date('m/d/Y',strtotime($data->start_date))}}</td>
            <td>Security Deposit</td>
            <td>${{$data->security_deposit}}</td>
            <td>
                <b>Pending</b>
            </td>
            <td>Automatic deposit refund 72 hours after check-out</td>
        </tr>
    @endif
    <tr>
        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
            <p style="color: #000;font-size: 35px;">
                {{$data->is_owner ? 'You Earn' : 'You Pay'}}
            </p>
        </th>
        <th colspan="4" style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
            <p style="color: #000;font-size: 35px;">
                <b>$  {{$data->grand_total}}</b>
            </p>
        </th>

    </tr>

</table>
<br><br>
<div class="col-md-12">
    <center>
        <div class="copyrights">© 2019 Health Care Travels. All Rights Reserved.</div>
    </center>

</div>
</body>
</html>
