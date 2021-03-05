@extends('Admin.Layout.master')

@section('title') {{APP_BASE_NAME}} - Admin @endsection

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Manage Coupon Code</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Coupon Code</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Coupon Code Management</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

    </div>
    <div class="content-body">
        <!-- Basic form layout section start -->


        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title">Coupon Code Management</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                <div class="heading-elements">
                                    <a href="{{url('/')}}/admin/create-coupon" class="btn btn-primary btn-sm"><i
                                            class="ft-plus white"></i> Create Coupon</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class=" table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Coupon Code</th>
                                            <th>Coupon Type</th>
                                            <th>Coupon Value</th>
                                            <th>Maximum Users</th>
                                            <th style="min-width: 165px;">Date</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($coupon_codes as $key => $code)
                                            <tr>
                                                <td>
                                                    {{$key + 1}}
                                                </td>
                                                <td>
                                                    {{$code->coupon_code}}
                                                </td>
                                                <td>
                                                    @if($code->coupon_type == 1)
                                                        Cash discount
                                                    @endif

                                                    @if($code->coupon_type == 2)
                                                        % Discount
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($code->coupon_type == 1)
                                                        $
                                                    @endif

                                                    @if($code->coupon_type == 2)
                                                        %
                                                    @endif
                                                    {{$code->price_value}}
                                                </td>
                                                <td>{{$code->max_no_users}}</td>
                                                <td>
                                                    {{$code->coupon_valid_from}} - {{$code->coupon_valid_to}}
                                                </td>
                                                <td>
                                                    Active
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-icon btn-success mr-1"><i
                                                            class="ft-edit"></i></button>
                                                    <button type="button" class="btn btn-icon btn-success mr-1"><i
                                                            class="ft-delete"></i></button>
                                                </td>

                                            </tr>
                                        @endforeach

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
