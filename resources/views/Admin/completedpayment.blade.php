@section('title') {{APP_BASE_NAME}} - Admin @endsection
@extends('Admin.Layout.master')
@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Completed <small>Payments</small></h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
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
                                                <th>S.no</th>
                                                <th>Booking ID</th>
                                                <th>Host Name</th>
                                                <th>Travellers Name</th>
                                                <th>Amount</th>
                                                <th style="min-width: 170px;">Date</th>
                                                <th>Approve Payout</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data as $key => $booking)
                                                <tr>

                                                    <td>
                                                        {{$key + 1}}
                                                    </td>
                                                    <td>
                                                        {{$booking->booking_id}}
                                                    </td>
                                                    <td>{{$booking->owner_fname}} {{$booking->owner_lname}}</td>
                                                    <td>{{$booking->traveller_fname}} {{$booking->traveller_lname}}</td>
                                                    <td>$ {{$booking->total_amount}}</td>
                                                    <td>
                                                        {{$booking->start_date}} - {{$booking->end_date}}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm">
                                                            <i class="ft-plus white"></i>
                                                            Approve
                                                        </button>

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


    </div>
    </div>



@endsection

@section('scripts')

    <script type="text/javascript">

        $('button').click(function () {
            $(this).toggleClass('pressed');
            $(this).css('background-color', 'green');
            $(this).text("Approved");
        });
    </script>

@endsection
