@extends('Admin.Layout.master')

@section('title') 
{{APP_BASE_NAME}} Admin 
@endsection

@section('content')


<div class="content-body">
       
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-12">
              <div class="card pull-up">
              <div class="card bg-gradient-directional-info">
                <div class="card-content">
                  <div class="card-body">
                    <div class="media d-flex">
                      <div class="align-self-center">
                        <i class="icon-user text-white font-large-2 float-left"></i>
                      </div>
                      <div class="media-body text-white text-right">
                        <h3 class="text-white">{{$counts['traveller']}}</h3>
                        <span>Total Travelers</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
            <div class="col-xl-3 col-lg-6 col-12">
              <div class="card pull-up">
              <div class="card bg-gradient-directional-danger">
                <div class="card-content">
                  <div class="card-body">
                    <div class="media d-flex">
                      <div class="align-self-center">
                        <i class="icon-user text-white font-large-2 float-left"></i>
                      </div>
                      <div class="media-body text-white text-right">
                        <h3 class="text-white">{{$counts['owner']}}</h3>
                        <span>Total Owners</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
              <div class="card pull-up">
              <div class="card bg-gradient-directional-success">
                <div class="card-content">
                  <div class="card-body">
                    <div class="media d-flex">
                      <div class="media-body text-white text-left">
                        <h3 class="text-white">{{$counts['agency']}}</h3>
                        <span>Total Agencies</span>
                      </div>
                      <div class="align-self-center">
                        <i class="icon-user text-white font-large-2 float-right"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
            <div class="col-xl-3 col-lg-6 col-12">
              <div class="card pull-up">
              <div class="card bg-gradient-directional-warning">
                <div class="card-content">
                  <div class="card-body">
                    <div class="media d-flex">
                      <div class="align-self-center">
                        <i class="icon-graph text-white font-large-2 float-left"></i>
                      </div>
                      <div class="media-body text-white text-right">
                        <h3 class="text-white">{{$counts['booking']}}</h3>
                        <span>Total Bookings</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>

            
      </div>
          <div class="row">
            <div class="col-xl-3 col-lg-6 col-12">
              <div class="card pull-up">
              <div class="card bg-gradient-directional-warning">
                <div class="card-content">
                  <div class="card-body">
                    <div class="media d-flex">
                      <div class="align-self-center">
                        <i class="icon-pointer text-white font-large-2 float-left"></i>
                      </div>
                      <div class="media-body text-white text-right">
                        <h3 class="text-white">$ {{$counts['earnings']}}</h3>
                        <span>Total Earnings</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
            <div class="col-xl-3 col-lg-6 col-12">
              <div class="card pull-up">
              <div class="card bg-gradient-directional-success ">
                <div class="card-content">
                  <div class="card-body">
                    <div class="media d-flex">
                      <div class="media-body text-white text-left">
                        <h3 class="text-white">{{$counts['property']}}</h3>
                        <span>Total Properties</span>
                      </div>
                      <div class="align-self-center">
                        <i class="icon-rocket text-white font-large-2 float-right"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
            
            <div class="col-xl-3 col-lg-6 col-12">
              <div class="card pull-up">
              <div class="card bg-gradient-directional-danger">
                <div class="card-content">
                  <div class="card-body">
                    <div class="media d-flex">
                      <div class="media-body text-white text-left">
                        <h3 class="text-white">{{$counts['today']}}</h3>
                        <span>Today Registers</span>
                      </div>
                      <div class="align-self-center">
                        <i class="icon-pie-chart text-white font-large-2 float-right"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
            <div class="col-xl-3 col-lg-6 col-12">
              <div class="card pull-up">
              <div class="card bg-gradient-directional-info">
                <div class="card-content">
                  <div class="card-body">
                    <div class="media d-flex">
                      <div class="media-body text-white text-left">
                        <h3 class="text-white">423</h3>
                        <span>Website Counts</span>
                      </div>
                      <div class="align-self-center">
                        <i class="icon-support text-white font-large-2 float-right"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
        <!--/ eCommerce statistic -->

        <!--Recent Orders & Monthly Sales -->
        <div class="row match-height">
                    <div id="recent-sales" class="col-12 col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Reports</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right"
                      href="{{URL('/')}}/admin/reservations">View all</a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content mt-1">
                <div class="table-responsive">
                  <table id="recent-orders" class="table table-hover table-xl mb-0">
                    <thead>
                      <tr>
                        <th class="border-top-0">Booking ID</th>
                        <th class="border-top-0">Traveler Name</th>
                        <th class="border-top-0">Host Name</th>
                        <th class="border-top-0">Property Name </th>
                        <th class="border-top-0">Amount</th>
                       
                      </tr>
                    </thead>
                    <tbody>

                    @foreach($bookings as $key => $booking)
                      <tr>
                        <td class="text-truncate">
                        	{{$booking->booking_id}}
                        </td>
                        <td class="text-truncateRecent Sales">
                         	{{$booking->traveller_name}}
                        </td>
                        <td>
                          	{{$booking->owner_name}}
                        </td>
                        <td>
                          	{{$booking->property_name}}
                        </td>
                        <td class="text-truncate">
                        	{{CURRENCY}} {{$booking->total}}
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
        <!--/Recent Orders & Monthly Sales -->
                <div class="row">
          <div class="col-xl-6 col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Sales Graph</h4>
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
                <div class="col-xl-6 col-lg-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Calender</h4>
                </div>
                <div class="card-body">
                  <p class="card-text"></p>
                  <div id="clndr-default" class="overflow-hidden bg-grey bg-lighten-3"></div>
                </div>
              </div>
            </div>
          </div>

      </div>


@endsection