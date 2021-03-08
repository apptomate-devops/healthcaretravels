@section('title') {{APP_BASE_NAME}} - Admin @endsection
@extends('Admin.Layout.master')
@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Payment settings</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Site settings</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Payment settings</a>
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
                                            <label class="col-md-3 label-control" for="projectinput1">Paypal
                                                type</label>
                                            <div class="col-md-9">
                                                <div class="">

                                                    <div class="show"
                                                         style="display: block; position: static; width: 100%; margin-top: 0;">
                                                        <div class="">
                                                            <div class="input-group">
                                                                <div>
                                                                    <fieldset>
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio"
                                                                                   class="custom-control-input"
                                                                                   name="tab" id="live" value="igotnone"
                                                                                   onclick="show1();">
                                                                            <label class="custom-control-label"
                                                                                   for="live">Live</label>
                                                                        </div>
                                                                    </fieldset>
                                                                </div> &nbsp;&nbsp;&nbsp;
                                                                <div>
                                                                    <fieldset>
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio"
                                                                                   class="custom-control-input"
                                                                                   name="tab" id="sandbox"
                                                                                   value="igottwo" onclick="show2();">
                                                                            <label class="custom-control-label"
                                                                                   for="sandbox">Sandbox</label>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput1">Paypal Email
                                                ID</label>
                                            <div class="col-md-9">
                                                <input type="text" id="eventRegInput1" class="form-control"
                                                       placeholder="Paypal Email ID" name="paypalemail"
                                                       value="paypal@example.com">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput2">Paypal API User
                                                ID</label>
                                            <div class="col-md-9">
                                                <input type="text" id="eventRegInput2" class="form-control"
                                                       placeholder="Paypal API User ID" name="paypalapi"
                                                       value="paypal_api2.example.com">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput4">Paypal API
                                                Password</label>
                                            <div class="col-md-9">
                                                <input type="email" id="eventRegInput4" class="form-control"
                                                       placeholder="Paypal API Password"
                                                       name="paypalpassword" value="***********">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput5">Paypal API
                                                Signature</label>
                                            <div class="col-md-9">
                                                <input type="tel" id="eventRegInput5" class="form-control"
                                                       name="Paypalsgnature" placeholder="Paypal API Signature"
                                                       value="AFcWxV21C7fd0v3bYYYRCpSSRl31AzMvUtELLgU7Lds4p89CBwS7CL2I">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput5">Paypal App
                                                ID</label>
                                            <div class="col-md-9">
                                                <input type="tel" id="eventRegInput5" class="form-control"
                                                       name="paypalid" placeholder="Paypal App ID"
                                                       value="APP-80W284485P519544R">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions center" style="border-top: 0px">
                                        <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">
                                            <i class="la la-check-square-o"></i> Update
                                        </button>
                                    </div>
                                    <div class="form-actions"></div>
                                </form>

                                <form class="form form-horizontal">
                                    <div class="form-body">

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput1">Braintree Paypal
                                                Type</label>
                                            <div class="col-md-9">
                                                <div class="show"
                                                     style="display: block; position: static; width: 100%; margin-top: 0;">
                                                    <div class="">
                                                        <div class="input-group">
                                                            <div>
                                                                <fieldset>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input"
                                                                               name="tab" id="live2" value="igotnone"
                                                                               onclick="show1();">
                                                                        <label class="custom-control-label" for="live2">Live</label>
                                                                    </div>
                                                                </fieldset>
                                                            </div> &nbsp;&nbsp;&nbsp;
                                                            <div>
                                                                <fieldset>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input"
                                                                               name="tab" id="sandbox2" value="igottwo"
                                                                               onclick="show2();">
                                                                        <label class="custom-control-label"
                                                                               for="sandbox2">Sandbox</label>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput5">Braintree
                                                Merchant ID</label>
                                            <div class="col-md-9">
                                                <input type="tel" id="eventRegInput5" class="form-control"
                                                       name="BraintreeMerchantID" placeholder="Braintree Merchant ID"
                                                       value="8xzz2dztkdjpf79hu">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput5">Braintree Public
                                                Key</label>
                                            <div class="col-md-9">
                                                <input type="tel" id="eventRegInput5" class="form-control"
                                                       name="BraintreePublicKey" placeholder="Braintree Public Key"
                                                       value="9j7ss27dytftp5ly">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="eventRegInput5">Braintree Private
                                                Key</label>
                                            <div class="col-md-9">
                                                <input type="tel" id="eventRegInput5" class="form-control"
                                                       name="BraintreePrivateKey" placeholder="Braintree Private Key"
                                                       value="6482a53faa340b06b5b47ab678b2f8hj6">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions center" style="border-top: 0px">
                                        <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">
                                            <i class="la la-check-square-o"></i> Update
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
