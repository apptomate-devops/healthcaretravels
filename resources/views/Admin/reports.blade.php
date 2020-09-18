@extends('Admin.Layout.master')

@section('title')
    {{APP_BASE_NAME}} Admin
@endsection

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Reports Summary</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Reports</a>
                        </li>
                        <li class="breadcrumb-item active">Reports Summary
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Revenue, Hit Rate & Deals -->
        <div class="row" style="display: none">
            <div class="col-xl-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Revenue</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body pt-0">
                            <div class="row mb-1">
                                <div class="col-6 col-md-4">
                                    <h5>Current week</h5>
                                    <h2 class="danger">$82,124</h2>
                                </div>
                                <div class="col-6 col-md-4">
                                    <h5>Previous week</h5>
                                    <h2 class="text-muted">$52,502</h2>
                                </div>
                            </div>
                            <div class="chartjs">
                                <canvas id="thisYearRevenue" width="400" style="position: absolute;"></canvas>
                                <canvas id="lastYearRevenue" width="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-12">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-header bg-hexagons">
                                <h4 class="card-title">Hit Rate
                                    <span class="danger">-12%</span>
                                </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show bg-hexagons">
                                <div class="card-body pt-0">
                                    <div class="chartjs">
                                        <canvas id="hit-rate-doughnut" height="275"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content collapse show bg-gradient-directional-danger ">
                                <div class="card-body bg-hexagons-danger">
                                    <h4 class="card-title white">Deals
                                        <span class="white">-55%</span>
                                        <span class="float-right">
                          <span class="white">152</span>
                          <span class="red lighten-4">/200</span>
                        </span>
                                    </h4>
                                    <div class="chartjs">
                                        <canvas id="deals-doughnut" height="275"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h6 class="text-muted">Order Value </h6>
                                            <h3>$ 88,568</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-trophy success font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h6 class="text-muted">Calls</h6>
                                            <h3>3,568</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-call-in danger font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Revenue, Hit Rate & Deals -->
        <!-- Emails Products & Avg Deals -->
        <div class="row" style="display: none;">
            <div class="col-12 col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Emails</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body pt-0">
                            <p>Open rate
                                <span class="float-right text-bold-600">89%</span>
                            </p>
                            <div class="progress progress-sm mt-1 mb-0 box-shadow-1">
                                <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 80%"
                                     aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="pt-1">Sent
                                <span class="float-right">
                      <span class="text-bold-600">310</span>/500</span>
                            </p>
                            <div class="progress progress-sm mt-1 mb-0 box-shadow-1">
                                <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 48%"
                                     aria-valuenow="48" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Top Products</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a href="#">Show all</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <tbody>
                                    <tr>
                                        <th scope="row" class="border-top-0">iPone X</th>
                                        <td class="border-top-0">2245</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">One Plus</th>
                                        <td>1850</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Samsung S7</th>
                                        <td>1550</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Average Deal Size</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-md-6 col-12 border-right-blue-grey border-right-lighten-5 text-center">
                                    <h6 class="danger text-bold-600">-30%</h6>
                                    <h4 class="font-large-2 text-bold-400">$12,536</h4>
                                    <p class="blue-grey lighten-2 mb-0">Per rep</p>
                                </div>
                                <div class="col-md-6 col-12 text-center">
                                    <h6 class="success text-bold-600">12%</h6>
                                    <h4 class="font-large-2 text-bold-400">$18,548</h4>
                                    <p class="blue-grey lighten-2 mb-0">Per team</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Emails Products & Avg Deals -->

        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-content">
                        <div class="earning-chart position-relative">
                            <div class="chart-title position-absolute mt-2 ml-2">
                                <h1 class="display-5" id="total"> {{$total==''?'0':$total}}</h1>
                                <span class="text-muted">Admin Earnings</span>
                            </div>
                            <canvas id="earning-chart" class="height-450"></canvas>
                            <div class="chart-stats position-absolute position-bottom-0 position-right-0 mb-2 mr-3">
                                <a href="#" class="btn round btn-danger mr-1 btn-glow">Statistics <i
                                        class="ft-bar-chart"></i></a>
                                <span class="text-muted">for the <a href="#"
                                                                    class="danger darken-2">Admin Earnings .</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-content">
                        <div class="earning-chart position-relative">
                            <div class="chart-title position-absolute mt-2 ml-2">
                                <h1 class="display-5" id="host"> {{$host==''?'0':$host}}</h1>
                                <span class="text-muted">Host Earnings</span>
                            </div>
                            <canvas id="earning-chart1" class="height-450"></canvas>
                            <div class="chart-stats position-absolute position-bottom-0 position-right-0 mb-2 mr-3">
                                <a href="#" class="btn round btn-danger mr-1 btn-glow">Statistics <i
                                        class="ft-bar-chart"></i></a>
                                <span class="text-muted">for the <a href="#" class="danger darken-2">Host Earnings.</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-content">
                        <div class="earning-chart position-relative">
                            <div class="chart-title position-absolute mt-2 ml-2">
                                <h1 class="display-5" id="revenue"> {{$revenue==''?'0':$revenue}}</h1>
                                <span class="text-muted">Total Revenue</span>
                            </div>
                            <canvas id="earning-chart2" class="height-450"></canvas>
                            <div class="chart-stats position-absolute position-bottom-0 position-right-0 mb-2 mr-3">
                                <a href="#" class="btn round btn-danger mr-1 btn-glow">Statistics <i
                                        class="ft-bar-chart"></i></a>
                                <span class="text-muted">for the <a href="#" class="danger darken-2">Total Earings.</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total earning & Reports  -->
        <div class="row">
            <!--  <div class="col-12 col-md-4">
               <div class="card">
                 <div class="card-content">
                   <div class="earning-chart position-relative">
                     <div class="chart-title position-absolute mt-2 ml-2">
                       <h1 class="display-4">$234</h1>
                       <span class="text-muted">Total Commissions</span>
                     </div>
                     <canvas id="earning-chart3" class="height-450"></canvas>
                     <div class="chart-stats position-absolute position-bottom-0 position-right-0 mb-2 mr-3">
                       <a href="#" class="btn round btn-danger mr-1 btn-glow">Statistics <i class="ft-bar-chart"></i></a>
                       <span class="text-muted">for the <a href="#" class="danger darken-2">last year.</a></span>
                     </div>
                   </div>
                 </div>
               </div>
             </div> -->
            <div id="recent-sales" class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Reports</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right"
                                       href="{{BASE_URL}}admin/host-payouts" target="_blank">View all</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content mt-1">
                        <div class="table-responsive">
                            <table id="recent-orders" class="table table-hover table-xl mb-0">
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
        <!--/ Total earning & Reports  -->
        <!-- Analytics map based session -->

        <!-- Analytics map based session -->
    </div>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
        value = $('#host').html();
        value2 = $('#total').html();
        value3 = $('#revenue').html();
        $('#host').html("{{CURRENCY}} " + parseFloat(value).toFixed(2));
        $('#total').html("{{CURRENCY}} " + parseFloat(value2).toFixed(2));
        $('#revenue').html("{{CURRENCY}} " + parseFloat(value3).toFixed(2));

    </script>
@endsection
