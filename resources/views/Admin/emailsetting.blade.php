@extends('Admin.Layout.master')

@section('title')
    {{APP_BASE_NAME}} Admin
@endsection

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Email settings</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Site settings</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Email settings</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">
                <!-- <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton"
                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button> -->
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
                            <h4 class="card-title" id="horz-layout-basic">Email Settings Form</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <div class="card-text">

                                </div>

                                <form class="form form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput1">Driver</label>
                                            <div class="col-md-9">
                                                <input type="text" id="eventRegInput1" class="form-control"
                                                       placeholder="Driver" name="driver" value="smtp">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput2">Host</label>
                                            <div class="col-md-9">
                                                <input type="text" id="eventRegInput2" class="form-control"
                                                       placeholder="host" name="host" value="smtp.gmail.com">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput3">Port</label>
                                            <div class="col-md-9">
                                                <input type="text" id="eventRegInput3" class="form-control"
                                                       placeholder="Port"
                                                       name="port" value="25">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput4">From
                                                Address</label>
                                            <div class="col-md-9">
                                                <input type="email" id="eventRegInput4" class="form-control"
                                                       placeholder="From Address"
                                                       name="form_address" value="example@gmail.com">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput5">From Name</label>
                                            <div class="col-md-9">
                                                <input type="tel" id="eventRegInput5" class="form-control"
                                                       name="form_name" placeholder="From Name" value="sample form">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control"
                                                   for="eventRegInput5">Encryption</label>
                                            <div class="col-md-9">
                                                <input type="tel" id="eventRegInput5" class="form-control"
                                                       name="Encryption" placeholder="Encryption" value="tls">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput5">Username</label>
                                            <div class="col-md-9">
                                                <input type="tel" id="eventRegInput5" class="form-control"
                                                       name="Username" placeholder="Username"
                                                       value="username@gmail.com">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput5">Password</label>
                                            <div class="col-md-9">
                                                <input type="tel" id="eventRegInput5" class="form-control"
                                                       name="contact" placeholder="Password" value="**********">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-actions center">
                                        <button type="button" class="btn btn-warning mr-5" style="padding: 10px 15px;">
                                            <i class="ft-x"></i> Cancel
                                        </button>
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
