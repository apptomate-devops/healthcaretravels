@extends('Admin.Layout.master')

@section('title')
    {{APP_BASE_NAME}} Admin
@endsection

@section('content')
    <style>
        .details {
            margin: 5px 0;
        }
    </style>
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0 d-inline-block">Cancellation Request</h3>
        </div>
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                @if($booking->cancellation_requested == 0)
                                    <div>No cancellation requested for this booking.</div>
                                @else
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

{{--                                TODO: confirm if we need to make the request in progress fiorst or allow direct cancellation for request --}}
                                    @if($booking->cancellation_requested == 1 || $booking->cancellation_requested == 3)
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Cancellation Request Refund</h4>
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
                                                <div class="deposit-form-wrapper">
                                                    <form action="{{BASE_URL}}admin/update_cancellation_request_status/{{$booking->booking_id}}" id="booking_cancellation_refund">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="refund_amount">Enter amount to be refunded:</label>
                                                            <input type="number" class="form-control col-1" id="refund_amount" name="refund_amount" placeholder="0" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-block">Process Refund and Cancel Request</button>
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
                                    @endif
                                    @if($booking->cancellation_requested == 2)
                                        <br>
                                        <b style="font-size: 18px;">
                                            Cancellation is completed.
                                        </b>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- // Basic form layout section end -->
    </div>
    </div>
    </div>

@endsection
