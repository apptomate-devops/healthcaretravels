@section('title')  {{APP_BASE_NAME}} - Admin @endsection
@extends('Admin.Layout.master')
@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Canceled <small>Payment</small></h3>
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
                                            <th>S.no</th>
                                            <th>Transaction ID</th>
                                            <th>Traveler Name</th>
                                            <th>Host Name</th>
                                            <th>Amount</th>
                                            <th>Payment Method</th>
                                            <th>Action</th>
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
                                                <td>{{$booking->traveller_fname}} {{$booking->traveller_lname}}</td>
                                                <td>{{$booking->owner_fname}} {{$booking->owner_lname}}</td>

                                                <td>$ {{$booking->total_amount}}</td>
                                                <td>Paypal</td>

                                                <td>
                                                    <a href="{{URL('/')}}/send_mail_cancel_payment?booking_id={{$booking->booking_id}}&&owner_id={{$booking->owner_id}}&&traveler_id={{$booking->traveler_id}}">
                                                        <button class="btn btn-primary btn-sm" style="float: right;"><i
                                                                class="ft-plus white"></i>Send Email
                                                        </button>
                                                    </a></td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>S.no</th>
                                            <th>Transaction ID</th>
                                            <th>Traveler Name</th>
                                            <th>Host Name</th>
                                            <th>Payment Method</th>
                                            <th>Action</th>
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

@endsection
