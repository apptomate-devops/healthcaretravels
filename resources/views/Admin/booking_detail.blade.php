@extends('Admin.Layout.master')

@section('title') Booking Detail @endsection

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Booking <small>Details</small></h3>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Booking Details</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                <li><a data-action="close"><i class="ft-x"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content text-center" style="padding-bottom:10px;">
        Property Title: {{$booking->property_title}}<br />
        Owner: {{$booking->owner_first_name}} {{$booking->owner_last_name}}<br />
        Traveller: {{$booking->traveller_first_name}} {{$booking->traveller_last_name}}<br />
        Start Date: {{date('m-d-Y',strtotime($booking->start_date))}}<br />
        End Date: {{date('m-d-Y',strtotime($booking->start_date))}}<br />
        Status: @if($booking->status == 1)
        Created
        @elseif($booking->status == 2)
        Approved
        @elseif($booking->status == 3)
        Completed
        @else
        Canceled
        @endif<br />
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Booking Transactions</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                <li><a data-action="close"><i class="ft-x"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body card-dashboard">
            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Payment Cycle</td>
                            <td>Service Tax</td>
                            <td>Partial Days</td>
                            <td>Booking Row ID</td>
                            <td>Booking ID</td>
                            <td>Cleaning Fee</td>
                            <td>Security Deposit</td>
                            <td>Monthly Rate</td>
                            <td>Total Amount</td>
                            <td>Due Date</td>
                            <td>Is Processed</td>
                            <td>Processed Time</td>
                            <td>Confirmed Time</td>
                            <td>Failed Time</td>
                            <td>Failed Reason</td>
                            <td>Transfer ID</td>
                            <td>Created At</td>
                            <td>Updated At</td>
                            <td>Is Owner</td>
                            <td>Job ID</td>
                            <td>Transfer URL</td>
                            <td>Is Cleared</td>
                            <td>Is Partial Days</td>
                            <td>Covering Range</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking_transactions as $booking_transaction)
                        <tr>
                            <td>{{$booking_transaction->id}}</td>
                            <td>{{$booking_transaction->payment_cycle}}</td>
                            <td>{{$booking_transaction->service_tax}}</td>
                            <td>{{$booking_transaction->partial_days}}</td>
                            <td>{{$booking_transaction->booking_row_id}}</td>
                            <td>{{$booking_transaction->booking_id}}</td>
                            <td>{{$booking_transaction->cleaning_fee}}</td>
                            <td>{{$booking_transaction->security_deposit}}</td>
                            <td>{{$booking_transaction->monthly_rate}}</td>
                            <td>{{$booking_transaction->total_amount}}</td>
                            <td>{{$booking_transaction->due_date}}</td>
                            <td>{{$booking_transaction->is_processed}}</td>
                            <td>{{$booking_transaction->processed_time}}</td>
                            <td>{{$booking_transaction->confirmed_time}}</td>
                            <td>{{$booking_transaction->failed_time}}</td>
                            <td>{{$booking_transaction->failed_reason}}</td>
                            <td>{{$booking_transaction->transfer_id}}</td>
                            <td>{{$booking_transaction->created_at}}</td>
                            <td>{{$booking_transaction->updated_at}}</td>
                            <td>{{$booking_transaction->is_owner}}</td>
                            <td>{{$booking_transaction->job_id}}</td>
                            <td>{{$booking_transaction->transfer_url}}</td>
                            <td>{{$booking_transaction->is_cleared}}</td>
                            <td>{{$booking_transaction->is_partial_days}}</td>
                            <td>{{$booking_transaction->covering_range}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
</script>
@endsection