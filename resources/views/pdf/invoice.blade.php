<!DOCTYPE html>
<html>
<head>
    <title>{{APP_BASE_NAME}}| Invoice</title>
</head>

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
        <td>{{$data->traveller_name}}</td>
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
<table  border="1" align="center" style="width: 100%">

    <tr>
        <th style="width: 0;background-color: #e78016;font-size: 25px;">
            Cost
        </th>
        <th style="width: 0;background-color: #e78016;font-size: 25px;">
            Price
        </th>
        <th style="width: 0;background-color: #e78016;font-size: 25px;">
            Detail
        </th>
    </tr>

    <tr>
        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
            <p style="color: #000;">
                Price per night ( {{$data->total_days}} x $ {{$data->price_per_night}} )
            </p>
        </th>
        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
            <p style="color: #000;">
                $ {{$data->price_per_night * $data->total_days}}.00
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
                $ {{$data->cleaning_fare}}.00
            </p>
        </th>
        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
            <p style="color: #000;">
                {{-- Cleaning fee type - {{$data->cleaning_fee_type}} , cost - $ {{$data->cleaning_fee}} --}}
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
                $ {{$data->security_deposit}}.00
            </p>
        </th>
        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
            <p style="color: #000;">
                *Refundable based on selected Cancellation Policy
            </p>
        </th>
    </tr>

    @if($data->minimum_guests < $data->guest_count)
        <tr>
            <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                <p style="color: #000;">
                    Extra guest ( {{$data->guest_count - $data->minimum_guests}} x $ {{$data->price_per_extra_guest}} )
                </p>
            </th>
            <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                <p style="color: #000;">
                    <?php $extra_guests = $data->guest_count - $data->minimum_guests; ?>
                    $ {{$extra_guests * $data->price_per_extra_guest}}.00
                </p>
            </th>
            <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
                <p style="color: #000;">

                </p>
            </th>
        </tr>
    @endif

    <tr>
        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
            <p style="color: #000;">
                Service Fee 
            </p>
        </th>
        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
            <p style="color: #000;">
                $ {{$data->service_tax}}.00
            </p>
        </th>
        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
            <p style="color: #000;">

            </p>
        </th>
    </tr>

    

    <tr>
        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
            <p style="color: #000;font-size: 35px;">
                You Earn
            </p>
        </th>
        <th colspan="2" style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
            <p style="color: #000;font-size: 35px;">
                <b>$  {{$data->total_amount}}.00</b>
            </p>
        </th>
        
    </tr>

    {{-- <tr>
        <th style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
            <p style="color: #000;">
                You earn
            </p>
        </th>
        <th colspan="2" style="width: 0;background-color: #FFF;border-bottom: 1px solid #000;">
            <p style="color: #000;">
                {{$data->total_amount - $serv_fare}}
            </p>
        </th>
        
    </tr> --}}

</table>
<br><br>
<div class="col-md-12">
    <center>
        <div class="copyrights">© 2019 Health Care Travels. All Rights Reserved.</div>
    </center>
    
</div>
</body>
</html>