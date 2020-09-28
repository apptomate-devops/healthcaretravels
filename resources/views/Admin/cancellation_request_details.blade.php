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
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Cancellation Request</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a>
                        </li>
                    </ol>
                </div>
            </div>
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
                                    <div class="details"><b>Submitted By: </b><span>{{$cancelled_by->first_name . ' ' . $cancelled_by->last_name}}</span></div>
                                    <div class="details"><b>Cancellation Status: </b><span>{{$booking->cancellation_requested == 3 ? 'In Progress' : ($booking->cancellation_requested == 2 ? 'Completed' : 'Pending') }}</span></div>
                                    <div class="details"><b>Cancellation Reason: </b><span>{{$booking->cancellation_reason}}</span></div>
                                    <div class="details"><b>Explanation: </b><span>{{$booking->cancellation_explanation}}</span></div>
                                    <div class="details"><b>Has the traveler checked in to this property?: </b><span>{{$booking->already_checked_in ? 'Yes' : 'No'}}</span></div>
                                    @if($booking->cancellation_requested == 1 || $booking->cancellation_requested == 3)
                                        <div style="margin-top: 20px;">
                                            <a class="btn btn-default btn-primary btn-block" href="{{BASE_URL}}admin/update_cancellation_request_status/{{$booking->booking_id}}/3">
                                                <span style="height:29px">In Progress</span>
                                            </a>
                                            <a class="btn btn-default btn-primary btn-block" href="{{BASE_URL}}admin/update_cancellation_request_status/{{$booking->booking_id}}/2">
                                                <span style="height:29px">Resolved</span>
                                            </a>
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
