@section('title') {{APP_BASE_NAME}} - Admin @endsection
@extends('Admin.Layout.master')
@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Reviews Management</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Reviews</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Reviews Management</a>
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
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title">Reviews Management</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            </div>
                        </div>

                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Reservation ID</th>
                                        <th>Room Name</th>
                                        <th>Review By</th>
                                        <th>Comments</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>01</td>
                                        <td>21</td>
                                        <td>Elegant</td>
                                        <td>Host</td>
                                        <td>This experience was wonderful</td>
                                        <td>23/02/2018 15:01:35</td>
                                        <td>23/02/2018 15:01:35</td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-success mr-1"><i
                                                    class="ft-edit"></i></button>
                                            <button type="button" class="btn btn-icon btn-success mr-1"><i
                                                    class="ft-delete"></i></button>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td>02</td>
                                        <td>26</td>
                                        <td>Elegant</td>
                                        <td>Guest</td>
                                        <td>This experience was wonderful</td>
                                        <td>22/02/2018 11:01:35</td>
                                        <td>22/02/2018 11:01:35</td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-success mr-1"><i
                                                    class="ft-edit"></i></button>
                                            <button type="button" class="btn btn-icon btn-success mr-1"><i
                                                    class="ft-delete"></i></button>
                                        </td>

                                    </tr>

                                    </tbody>


                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Reservation ID</th>
                                        <th>Room Name</th>
                                        <th>Review By</th>
                                        <th>Comments</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>

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
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Reviews Management</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Reviews</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Reviews Management</a>
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


    </div>
    </div>

@endsection
