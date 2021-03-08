@section('title') {{APP_BASE_NAME}} - Admin @endsection
@extends('Admin.Layout.master')
@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Create Coupon</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Manage Coupon Codes</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Create Coupon</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">

            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Basic form layout section start -->
        <section id="horizontal-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="horz-layout-basic"></i>Ceate Coupon</h4>

                            <!-- <h4 class="card-title" id="horz-layout-basic">Project Info</h4> -->
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <div class="card-text">

                                </div>
                                <form class="form form-horizontal" method="post">

                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-body">

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="coupon_name">
                                                Coupon Name
                                            </label>
                                            <div class="col-md-6">
                                                <input required type="text" id="coupon_name" class="form-control"
                                                       placeholder="Coupon Name"
                                                       name="coupon_name">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="coupon_code">Coupon Code</label>
                                            <div class="col-md-6">
                                                <input required type="text" id="coupon_code" class="form-control"
                                                       placeholder="Coupon Code"
                                                       name="coupon_code">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="coupon_type">Coupon Type</label>
                                            <div class="col-md-6">
                                                <select id="coupon_type" name="coupon_type" class="form-control">
                                                    <option value="1" selected="">Amount</option>
                                                    <option value="2">Percentage</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="max_no_users">
                                                Maximum Number of Users
                                            </label>
                                            <div class="col-md-6">
                                                <input required type="text" id="max_no_users" class="form-control"
                                                       placeholder="Enter Max users count" name="max_no_users">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Value</label>
                                            <div class="col-md-6">
                                                <input required type="text" id="projectinput4" class="form-control"
                                                       placeholder="Enter Amount or Percentge" name="price_value">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="coupon_valid_from">
                                                From date
                                            </label>
                                            <div class="col-md-6">
                                                <input required type="date" id="coupon_valid_from" class="form-control"
                                                       placeholder="Coupon valid from" name="coupon_valid_from">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="coupon_valid_to">
                                                To date
                                            </label>
                                            <div class="col-md-6">
                                                <input required type="date" id="coupon_valid_to" class="form-control"
                                                       placeholder="Coupon valid to" name="coupon_valid_to">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="description">
                                                Description
                                            </label>
                                            <div class="col-md-6">
                                                <textarea name="description" class="form-control"
                                                          id="description"></textarea>
                                            </div>
                                        </div>


                                        <!-- <div class="form-group row">
                                          <label class="col-md-3 label-control" for="projectinput4">Coupon Currency</label>
                                          <div class="col-md-6">
                                            <select id="projectinput6" name="interested" class="form-control">
                                              <option value="1" selected="" disabled="">USD</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="form-group row">
                                          <label class="col-md-3 label-control" for="projectinput4">Expire Date</label>
                                          <div class="col-md-6">
                                      <fieldset class="form-group">
                                        <input required type="date" class="form-control" id="date" value="2011-08-19">
                                      </fieldset>
                                      </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Status</label>
                                            <div class="col-md-6">
                                                <select id="projectinput6" name="status" class="form-control">
                                                    <option value="0" selected="" disabled="">Select</option>
                                                    <option value="1">Active</option>
                                                    <option value="2">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-actions center">
                                            <a href="manage-couponcodes.html" class="button btn btn-warning mr-5"
                                               style="padding: 10px 15px;">
                                                <i class="ft-x"></i> Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">
                                                <i class="la la-check-square-o"></i> Submit
                                            </button>
                                        </div>
                                </form>
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
