@section('title') {{APP_BASE_NAME}} - Admin @endsection
@extends('Admin.Layout.master')
@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Commission Settings</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Site settings</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Commission Settings</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

    </div>
    <div class="content-body">
        <!-- Basic form layout section start -->
        <section id="basic-form-layouts">
            <div class="row match-height">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-form-center">Commission Settings</h4>
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
                            <div class="card-body">
                                <form class="form" name="form" action="" method="post">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-9">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="eventInput1">Admin Commission</label>
                                                    <input type="text" id="eventInput1" class="form-control"
                                                           placeholder="Admin Commission in %" name="admin_commision"
                                                           value="{{$commision->admin_commision}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="eventInput2">Host Commission</label>
                                                    <input type="text" id="eventInput2" class="form-control"
                                                           placeholder="Host Commission in %" name="host_commision"
                                                           value="{{$commision->host_commision}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-header">
                                        <h4 class="card-title" id="basic-layout-form-center">Security Deposit</h4>
                                    </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-9">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="eventInput5">Amount</label>
                                                    <input type="tel" id="eventInput5" class="form-control"
                                                           name="deposit" placeholder="Enter Amount"
                                                           value="{{$commision->deposit}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-actions center">

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
