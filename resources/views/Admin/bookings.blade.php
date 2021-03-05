@extends('Admin.Layout.master')

@section('title')
    Property Booking | {{APP_BASE_NAME}}
@endsection

@section('content')

<style type="text/css">
</style>
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Bookings <small>Management</small>
            @if(Session::has('alert'))
            &nbsp;&nbsp;&nbsp;&nbsp;<span style="float:right;font-size: 15px"><span class="alert alert-{{Session::get('status')}} alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{Session::get('alert')}}
                </span></span>
            @endif</h3>
        <div class="row breadcrumbs-top d-inline-block" style="float: right;margin-right: -105%;">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{URL('/')}}/admin">Dashboard</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>

</div>

<input type="hidden" name="current" id="current" value="1">

<div style="margin-bottom: 20px;">
</div>

<div class="content-body">
    <!-- Basic form layout section start -->


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
                                            <th>ID</th>
                                            <th>Booking ID</th>
                                            <th>Property Title</th>
                                            <th>Owner</th>
                                            <th>Traveler</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($bookings as $key => $booking)
                                        <tr>
                                            <td>
                                                {{$booking->id}}
                                            </td>
                                            <td>
                                                {{$booking->booking_id}}
                                            </td>
                                            <td>
                                                {{$booking->property_title}}
                                            </td>
                                            <td>
                                                {{Helper::get_user_display_name($booking, 'owner_')}}
                                            </td>
                                            <td>
                                                {{Helper::get_user_display_name($booking, 'traveller_')}}
                                            </td>
                                            <td>
                                                {{date('m-d-Y',strtotime($booking->start_date))}}
                                            </td>
                                            <td>
                                                {{date('m-d-Y',strtotime($booking->end_date))}}
                                            </td>
                                            <td>
                                                @if($booking->status == 1)
                                                Created
                                                @elseif($booking->status == 2)
                                                Approved
                                                @elseif($booking->status == 3)
                                                Completed
                                                @elseif($booking->status == 4)
                                                    Declined
                                                @else
                                                Canceled
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{BASE_URL}}admin/bookings/{{$booking->id}}">
                                                    <span class="btn btn-success btn-default btn-block">
                                                        View
                                                    </span>
                                                </a>
                                            </td>
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

@endsection


@section('scripts')
<script>

</script>
@endsection
