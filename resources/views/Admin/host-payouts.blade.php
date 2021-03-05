@extends('Admin.Layout.master')

@section('title') {{APP_BASE_NAME}} - Admin @endsection

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Host <small>Payouts</small></h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{URL('/')}}/admin">Dashboard</a>
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
                                <div class=" table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                        <tr>
                                            <th>S.no</th>
                                            <th>Booking ID</th>
                                            <th>Host Name</th>
                                            <th>Total Amount</th>
                                            <th>Admin Commision</th>
                                            <th>Host Commision</th>
                                            <th>Date</th>
                                            <th>Payout Status</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $key=>$d)
                                            <tr>

                                                <td>{{$key+1}}</td>
                                                <td>{{$d->booking_id}}</td>
                                                <td>{{$d->owner_fname}}{{$d->owner_lname}}</td>
                                                <td>$ {{$d->total_amount}}</td>
                                                <td>$ {{$d->service_tax*2}}</td>
                                                <td>$ {{$d->total_amount-($d->service_tax*2)}}</td>
                                                <td>{{$d->created_at}}</td>
                                                <td>
                                                    <center>@if($d->payment_done==0)
                                                            <button class="btn bth-default btn-danger">Not Paid</button>
                                                        @else
                                                            <button class="btn bth-default btn-success">Paid</button>
                                                        @endif
                                                    </center>
                                                </td>


                                            </tr>
                                        @endforeach


                                        </tbody>
                                        <!--  <tfoot>
                                         <tr>
                                           <th>S. No.</th>
                                           <th>Coupon Code</th>
                                           <th>Amount</th>
                                           <th>Currency Code</th>
                                           <th>Expired At</th>
                                           <th>Status</th>
                                           <th>Action</th>

                                         </tr>
                                       </tfoot> -->
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
