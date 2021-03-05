@extends('Admin.Layout.master')

@section('title')  {{APP_BASE_NAME}} - Admin @endsection

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Cancellation Policy</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Payment</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Cancellation Policy</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">

                <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbButton"><a class="dropdown-item" href="#"><i
                            class="la la-calendar-check-o"></i> Calender</a>
                    <a class="dropdown-item" href="#"><i class="la la-cart-plus"></i> Cart</a>
                    <a class="dropdown-item" href="#"><i class="la la-life-ring"></i> Support</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
                </div>
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
                            <h4 class="card-title" id="horz-layout-basic"></i> Flexible </h4>

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
                                <form class="form form-horizontal" method="post" action="">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="id" value="1">
                                    <div class="form-body">

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Before 1
                                                Day</label>
                                            <div class="col-md-6">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Before 1 Day" name="before_1_day"
                                                       value="{{$first->before_1_day}}%">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Before 15
                                                Day</label>
                                            <div class="col-md-6">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Before 15 Day" name="before_15_day"
                                                       value="{{$first->before_15_day}}%">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Before 30
                                                Day</label>
                                            <div class="col-md-6">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Before 30 Day" name="before_30_day"
                                                       value="{{$first->before_30_day}}%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions center" style="border-width: 0px;">

                                        <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">
                                            <i class="la la-check-square-o"></i> Submit
                                        </button>
                                        <div class="form-actions center"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="horz-layout-basic"></i> Moderate </h4>

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
                                <form class="form form-horizontal" method="post" action="">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="id" value="2">
                                    <div class="form-body">

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Before 1
                                                Day</label>
                                            <div class="col-md-6">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Before 1 Day" name="before_1_day"
                                                       value="{{$second->before_1_day}}%">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Before 15
                                                Day</label>
                                            <div class="col-md-6">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Before 15 Day" name="before_15_day"
                                                       value="{{$second->before_15_day}}%">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Before 30
                                                Day</label>
                                            <div class="col-md-6">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Before 30 Day" name="before_30_day"
                                                       value="{{$second->before_30_day}}%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions center" style="border-width: 0px;">

                                        <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">
                                            <i class="la la-check-square-o"></i> Submit
                                        </button>
                                        <div class="form-actions center"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="horz-layout-basic"></i> Ultra Moderate </h4>

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
                                <form class="form form-horizontal" method="post" action="">
                                    <input type="hidden" name="id" value="3">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-body">

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Before 1
                                                Day</label>
                                            <div class="col-md-6">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Before 1 Day" name="before_1_day"
                                                       value="{{$third->before_1_day}}%">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Before 15
                                                Day</label>
                                            <div class="col-md-6">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Before 15 Day" name="before_15_day"
                                                       value="{{$third->before_15_day}}%">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Before 30
                                                Day</label>
                                            <div class="col-md-6">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Before 30 Day" name="before_30_day"
                                                       value="{{$third->before_30_day}}%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions center" style="border-width: 0px;">

                                        <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">
                                            <i class="la la-check-square-o"></i> Submit
                                        </button>
                                        <div class="form-actions center"></div>
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
