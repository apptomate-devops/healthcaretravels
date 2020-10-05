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
        <div class="card-content card-body-padding">
            <h4 style="font-weight: bold;">Property: <span>{{$property->title}}</span></h4>
            <div class="details">Booking ID: <span>{{$booking->booking_id}}</span></div>
            <div class="details">Cancellation Policy: <a href="{{BASE_URL}}cancellationpolicy" class="cancel-policy-link" target="_blank">{{$property->cancellation_policy}}</a></div>
            <br>
            <div class="details"><b>Owner</b></div>
            <div class="details">Name: <span>{{$owner->first_name . ' ' . $owner->last_name}}</span></div>
            <div class="details">Username: <span>{{$owner->username}}</span></div>
            <div class="details">Email: <span>{{$owner->email}}</span></div>
            <div class="details"><b>Traveler</b></div>
            <div class="details">Name: <span>{{$traveler->first_name . ' ' . $traveler->last_name}}</span></div>
            <div class="details">Username: <span>{{$traveler->username}}</span></div>
            <div class="details">Email: <span>{{$traveler->email}}</span></div>
            <br>
            <div class="details"><b>Submitted By: </b><span>{{$cancelled_by}}</span></div>
            <div class="details"><b>Cancellation Status: </b><span>{{$booking->cancellation_requested == 3 ? 'In Progress' : ($booking->cancellation_requested == 2 ? 'Completed' : 'Pending') }}</span></div>
            <div class="details"><b>Cancellation Reason: </b><span>{{$booking->cancellation_reason}}</span></div>
            <div class="details"><b>Explanation: </b><span>{{$booking->cancellation_explanation}}</span></div>
            <div class="details"><b>Has the traveler checked in to this property?: </b><span>{{$booking->already_checked_in ? 'Yes' : 'No'}}</span></div>
            Start Date: {{date('m-d-Y',strtotime($booking->start_date))}}<br />
            End Date: {{date('m-d-Y',strtotime($booking->end_date))}}<br />
            Status: @if($booking->status == 1)
                Created
            @elseif($booking->status == 2)
                Approved
            @elseif($booking->status == 3)
                Completed
            @elseif($booking->status == 4)
                Denied
            @else
                Canceled
            @endif<br />
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Cancel Booking</h4>
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
        <div class="card-content card-body-padding">
            @if($booking->cancellation_requested == 2)
                <h5><b>Cancellation is completed for this booking</b></h5>
            @elseif($booking->cancellation_requested == 3)
                <h5><b>Cancellation is in Process for this booking</b></h5>
            @else
                <div class="deposit-form-wrapper">
                <form action="{{url('/')}}/admin/booking_cancellation_admin" method="post" id="booking_cancellation_admin">
                    @csrf
                    <input type="hidden" value="{{$booking->id}}" name="id">
                    <input type="hidden" value="{{$booking->booking_id}}" name="booking_id">
                    <div class="form-group">
                        <label for="cancellation_reason">Cancellation Reason</label>
                        <input type="text" class="form-control" id="cancellation_reason" name="cancellation_reason" required>
                    </div>
                    <div class="form-group">
                        <label for="cancellation_explanation">Cancellation Explanation</label>
                        <textarea class="form-control" id="cancellation_explanation" name="cancellation_explanation" required></textarea>
                    </div>
                    <div class="form-group">
                        <h5 class="margin-top-40">Has the traveler checked in to this property?</h5>
                        <div class="checkboxes in-row">
                            <input id="checked_in_yes" name="checked_in" type="checkbox" value="1">
                            <label for="checked_in_yes">Yes</label>

                            <input id="checked_in_no" name="checked_in" type="checkbox" value="0" checked>
                            <label for="checked_in_no">No</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="refund_amount">Enter amount to be refunded:</label>
                        <input type="number" class="form-control col-1" id="refund_amount" name="refund_amount" placeholder="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Process refund and cancel Booking</button>
                    @if(Session::has('success_cancel_booking'))
                        @if (Session::has('successMessage'))
                            <div class="mt-10 alert alert-success" role="alert" autofocus>
                                {{ Session::get('successMessage') }}
                            </div>
                        @endif
                        @if (Session::has('errorMessage'))
                            <div class="mt-10 alert alert-danger" role="alert">
                                {{ Session::get('errorMessage') }}
                            </div>
                        @endif
                    @endif
                </form>
            </div>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Booking Security Deposit</h4>
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
        <div class="card-content px-25" style="padding-bottom:10px;">
            <h6 for="">Deposit Amount: {{$booking->security_deposit}}<br /></h6>
            <div class="mt-10 alert alert-primary" role="alert">
                Auto handling of Security deposit is turned @if ($booking->should_auto_deposit) <b>on</b> @else <b>off</b> @endif for this booking
            </div>
            @if ($booking->is_deposit_handled)
                <div class="mt-10 alert alert-success" role="alert">
                    Security deposit was settled as follows:
                </div>
            @endif
            <div class="deposit-form-wrapper">
                <form action="{{url('/')}}/admin/settle-deposit" method="post" id="settle-deposit">
                    @csrf
                    <input type="hidden" value="{{$booking->id}}"  name="id">
                    <div class="form-group">
                        <label for="traveler_cut">Traveler Cut</label>
                        <input type="number" class="form-control col-1" min="0" max="{{$booking->security_deposit}}" value="{{$booking->traveler_cut}}" id="traveler_cut" name="traveler_cut" placeholder="0" required>
                    </div>
                    <div class="form-group">
                        <label for="owner_cut">Owner Cut</label>
                        <input type="number" class="form-control col-1" id="owner_cut" name="owner_cut" min="0" max="{{$booking->security_deposit}}" value="{{$booking->owner_cut}}" placeholder="0" required>
                    </div>
                    <div class="form-group">
                        <label for="admin_remarks">Admin Remarks</label>
                        <input type="text" class="form-control col-4" id="admin_remarks" name="admin_remarks" value="{{$booking->admin_remarks}}" placeholder="Admin Remarks" required>
                    </div>
                    <div class="form-group">
                        <label for="traveler_remarks">Traveler Remarks</label>
                        <input type="text" class="form-control col-4" id="traveler_remarks" name="traveler_remarks" value="{{$booking->traveler_remarks}}" placeholder="Traveler Remarks" required>
                    </div>
                    <div class="form-group">
                        <label for="owner_remarks">Owner Remarks</label>
                        <input type="text" class="form-control col-4" id="owner_remarks" name="owner_remarks" value="{{$booking->owner_remarks}}" placeholder="Owner Remarks" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Process Deposit</button>
                    <br />
                    <button id="pause-auto-deposit" type="button" class="mt-10 btn btn-primary" @if($booking->should_auto_deposit == 0) disabled @endif>Pause Auto Deposit</button>
                    @if(Session::has('success'))
                        @if (Session::has('successMessage'))
                            <div class="mt-10 alert alert-success" role="alert" autofocus>
                                {{ Session::get('successMessage') }}
                            </div>
                        @endif
                        @if (Session::has('errorMessage'))
                            <div class="mt-10 alert alert-danger" role="alert">
                                {{ Session::get('errorMessage') }}
                            </div>
                        @endif
                    @endif
                </form>
            </div>
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
                            <td>Account</td>
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
                                <td>
                                    @if($booking_transaction->is_owner == 0)
                                        Traveler
                                    @else
                                        Owner
                                    @endif
                                </td>
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

    @include('Admin.Includes.notes',['id'=>$booking->id,'admin_notes'=>$booking->admin_notes,'type'=>'bookings'])
@endsection

@section('scripts')
    <script>
        $(function ready() {
            var deposit = '{{$booking->security_deposit}}';
            deposit = parseInt(deposit);
            var tc = $('#traveler_cut');
            var oc = $('#owner_cut');
            tc.change(function (event) {
                var travelerValue = event.currentTarget.value;
                travelerValue = parseInt(travelerValue);
                oc.val(deposit - travelerValue);
            });
            oc.change(function (event) {
                var ownerValue = event.currentTarget.value;
                ownerValue = parseInt(ownerValue);
                tc.val(deposit - ownerValue);
            });
            var isHandled = '{{$booking->is_deposit_handled}}';
            if (isHandled == 1) {
                $('#settle-deposit :input').prop("disabled", true);;
            }
            var hasMessage = '{{Session::has("success")}}';
            if (hasMessage) {
                var hasSuccessMessage = '{{Session::has("successMessage")}}';
                var hasErrorMessage = '{{Session::has("errorMessage")}}';
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#traveler_remarks").offset().top
                }, 400);
            }
        });
        $('#checked_in_yes,#checked_in_no').change(function(){
            $("input[type=checkbox][name='checked_in']").prop('checked',false);
            $(this).prop('checked',true);
        });
        $('#pause-auto-deposit').click(function (event) {
            event.preventDefault();
            event.stopPropagation();
            window.location.href = '/admin/pause-auto-deposit/{{$booking->id}}';
        });
    </script>
@endsection
