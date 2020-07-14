@extends('Admin.Layout.master')

@section('title')
    {{APP_BASE_NAME}} Admin
@endsection

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Referral List</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Referral</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Referral List</a>
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
                        <div class="card-header">
                            <h4 class="card-title">Referral List</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Traveller</th>
                                        <th>Host</th>
                                        <th>Referred By</th>
                                        <th>Referral Amount</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>01.</td>
                                        <td>Krishna</td>
                                        <td>-</td>
                                        <td>Muniraja</td>
                                        <td>$10</td>

                                    </tr>
                                    <tr>
                                        <td>02.</td>
                                        <td>-</td>
                                        <td>Vishnu</td>
                                        <td>Sundaresh</td>
                                        <td>$20</td>

                                    </tr>
                                    <tr>
                                        <td>03.</td>
                                        <td>Vijay</td>
                                        <td>-</td>
                                        <td>Ajith</td>
                                        <td>$10</td>

                                    </tr>
                                    <tfoot>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Traveller</th>
                                        <th>Host</th>
                                        <th>Referred By</th>
                                        <th>Referral Amount</th>

                                    </tr>
                                    </tfoot>
                                </table>
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
