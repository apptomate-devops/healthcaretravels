@extends('Admin.Layout.master')

@section('title')
    {{APP_BASE_NAME}} Admin
@endsection

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Reservation <small>Management</small></h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a>
                        </li>


                    </ol>
                </div>
            </div>
        </div>
        <!-- <div class="content-header-right col-md-6 col-12">
          <div class="dropdown float-md-right">
            <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton"
            type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
            <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbButton"><a class="dropdown-item" href="#"><i class="la la-calendar-check-o"></i> Calender</a>
              <a class="dropdown-item" href="#"><i class="la la-cart-plus"></i> Cart</a>
              <a class="dropdown-item" href="#"><i class="la la-life-ring"></i> Support</a>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
            </div>
          </div>
        </div> -->
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
                                            <th>S.No</th>
                                            <th>Hosts Name</th>
                                            <th>Travelers Name</th>
                                            <th>Booking Id</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Request Date</th>
                                            <th>Payment Status</th>
                                            <th>Action</th>
                                            <th>Update</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($data as $key => $booking)
                                            <tr>
                                                <td>
                                                    {{$key + 1}}
                                                </td>
                                                <td>
                                                    {{$booking->owner_fname}} {{$booking->owner_lname}}
                                                </td>
                                                <td>
                                                    @if($booking->traveller_role == 2)
                                                        {{$booking->name_of_agency}}
                                                    @else
                                                        {{$booking->traveller_fname}} {{$booking->traveller_lname}}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$booking->booking_id}}
                                                </td>
                                                <td>$ {{$booking->total_amount}}</td>
                                                <td>


                                                    @if($booking->booking_status == 2)
                                                        Owner Accepted
                                                    @endif

                                                    @if($booking->booking_status == 3)
                                                        Invoice Issued
                                                    @endif

                                                    @if($booking->booking_status == 4)
                                                        Owner Cancelled Request
                                                    @endif

                                                    @if($booking->booking_status == 5)
                                                        Owner cancelled
                                                    @endif

                                                    @if($booking->booking_status == 6)
                                                        Traveller Cancelled
                                                    @endif

                                                    @if($booking->booking_status == 7)
                                                        Completed
                                                    @endif

                                                    @if($booking->booking_status == 8)
                                                        Refund security deposit
                                                    @endif

                                                </td>
                                                <td>
                                                    {{$booking->start_date}}
                                                </td>
                                                <td>
                                                    @if($booking->payment_done == 1)
                                                        Payment Completed
                                                    @else
                                                        Not paid
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{url('admin/reservations-details/')}}/{{$booking->booking_id}}"
                                                       class="button btn btn-icon btn-success mr-1"><i
                                                            class="ft-file"></i></a>
                                                    {{-- <button type="button" class="btn btn-icon btn-success mr-1"><i class="ft-message-square"></i></button> --}}
                                                </td>
                                                <td style="min-width: 110px;">
                                                    <fieldset class="form-group">
                                                        <select class="form-control"
                                                                onchange="status_update('{{$booking->booking_id}}',this.value)"
                                                                id="basicSelect" style="cursor: pointer;">
                                                            <option selected="selected">Make..</option>
                                                            <option value="1">Paid</option>
                                                            <option value="0">Unpaid</option>
                                                        </select>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>

                                        <tfoot>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Hosts Name</th>
                                            <th>Travellers Name</th>
                                            <th>Booking Id</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Request Date</th>
                                            <th>Payment Status</th>
                                            <th>Action</th>
                                            <th>Update</th>
                                        </tr>
                                        </tfoot>
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

    <script type="text/javascript">

        function status_update(id, status) {
            var url = "{{BASE_URL}}" + "admin/booking-status-update?id=" + id + "&status=" + status;

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function (data) {
                    // ajax success
                    console.log(data);
                    if (data.status) {
                        alert("Status updated successfully!...");
                        location.reload();
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }

    </script>

@endsection
