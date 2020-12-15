<!DOCTYPE html>
<html>
<head>
    <title>{{APP_BASE_NAME}} Invoice</title>
</head>
<style>
    table.invoice_details {
        width: 100%;
        text-align: center;
    }
</style>

{{-- <body > --}}
<body onload="window.print()">
<div id="logo" style="margin-top: 30px;">
    <center>
        <a href="{{url('/')}}"><img src="/storage/public/HomePage/healthcaretravel.png" alt="" width="100"></a>
        <br>
        <br>
        <b><span class="data">
                Health Care Travels
                <br>
                7075 FM 1960 Rd West STE 1010
                <br>
                Houston, Texas 77069
                <br>
                United States
            </span></b>
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
        <tr>
            <td>{{date('m/d/Y',strtotime($payment['due_date']))}}</td>
            <td>{{$payment['name'] ?? 'Housing Payment'}}</td>
            <td>{{$payment['amount']}}</td>
            <td>
                <p>
                    <b>{{Helper::get_payment_status($payment)}}</b>
                </p>
            </td>
            <td>{{$payment['covering_range']}}</td>
        </tr>
    @endforeach
    @if($data->is_owner == 0)
        <tr style="height: 54px;">
            <td>{{\Carbon\Carbon::parse($data->end_date)->addHours(72)->format('m/d/Y')}}</td>
            <td>Security Deposit</td>
            <td>{{\App\Http\Controllers\PropertyController::format_amount($data->traveler_cut)}}</td>
            <td>
                <b>{{Helper::get_security_payment_status($data)}}</b>
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
                <b>{{\App\Http\Controllers\PropertyController::format_amount($data->grand_total)}}</b>
            </p>
        </th>

    </tr>

</table>
<br><br>
<div class="col-md-12">
    <center>
        <div class="copyrights">© {{date('Y')}} Health Care Travels. All Rights Reserved.</div>
    </center>

</div>
</body>
</html>
