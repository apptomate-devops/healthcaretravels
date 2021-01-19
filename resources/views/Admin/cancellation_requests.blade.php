@extends('Admin.Layout.master')

@section('title')
    {{APP_BASE_NAME}} Admin
@endsection

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Cancellation requests</h3>
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
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                        <tr>
                                            <th>S.no</th>
                                            <th>Booking ID</th>
                                            <th>Owner</th>
                                            <th>Traveler</th>
                                            <th>Submitted by</th>
                                            <th>status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $key => $booking)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{$booking->booking_id}}</td>
                                                <td>{{Helper::get_user_display_name($booking, 'owner_')}}</td>
                                                <td>{{Helper::get_user_display_name($booking, 'traveller_')}}</td>
                                                <td>{{$booking->cancelled_by == 'Admin' ? 'Admin' : Helper::get_user_display_name($booking, 'requester_')}}</td>
                                                <td>{{$booking->cancellation_requested == 3 ? 'In Progress' : ($booking->cancellation_requested == 2 ? 'Resolved' : 'Pending')}}</td>
                                                <td>
                                                    <a href="{{url('admin/bookings/')}}/{{$booking->id}}">
                                                        <button class="btn btn-primary btn-sm" style="float: right;">
                                                            View Details
                                                        </button>
                                                    </a></td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
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
