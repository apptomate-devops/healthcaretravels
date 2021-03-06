@section('title') {{APP_BASE_NAME}} - Admin @endsection
@extends('Admin.Layout.master')
@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Invoice</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Invoice Lists</a>
                        </li>
                        <li class="breadcrumb-item active">Invoice
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <!--         <div class="content-header-right col-md-6 col-12">
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
        <section class="card">
            <div id="invoice-template" class="card-body">
                <!-- Invoice Company Details -->
                <div id="invoice-company-details" class="row">
                    <div class="col-md-6 col-sm-12 text-center text-md-left">
                        <div class="media">
                            <img src="../../../app-assets/images/logo/logo-80x80.png" alt="company logo" class=""
                            />
                            <div class="media-body">
                                <ul class="ml-2 px-0 list-unstyled">
                                    <li class="text-bold-800">Property Details</li>
                                    <li>Address,</li>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 text-center text-md-right">
                        <h2>INVOICE</h2>
                        <p class="pb-3"># BFZPV41Z</p>
                        <!-- <ul class="px-0 list-unstyled">
                          <li>Balance Due</li>
                          <li class="lead text-bold-800">$ 12,000.00</li>
                        </ul> -->
                    </div>
                </div>
                <!--/ Invoice Company Details -->
                <!-- Invoice Customer Details -->
                <div id="invoice-customer-details" class="row pt-2">
                    <div class="col-sm-12 text-center text-md-left">
                        <p class="text-muted">Bill To</p>
                    </div>
                    <div class="col-md-6 col-sm-12 text-center text-md-left">
                        <ul class="px-0 list-unstyled">
                            <li class="text-bold-800">Traveler Details</li>
                            <li>Address,</li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-12 text-center text-md-right">
                        <p>
                            <span class="text-muted">Invoice Date :</span> 10/05/2018</p>
                        <p>
                            <!-- <span class="text-muted">Terms :</span> Due on Receipt</p>
                          <p>
                            <span class="text-muted">Due Date :</span> 10/05/2017</p> -->
                    </div>
                </div>
                <!--/ Invoice Customer Details -->
                <!-- Invoice Items Details -->
                <div id="invoice-items-details" class="pt-2">
                    <div class="row">
                        <div class="table-responsive col-sm-12">
                            <table class="table">
                                <thead>
                                <tr>

                                    <th>S. No.</th>
                                    <th>Property Name</th>
                                    <th class="text-center">Number Of Days</th>
                                    <th class="text-center">Rate Per Day</th>
                                    <th class="text-center">Total</th>
                                </tr>
                                </tr>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        <p>Property 1</p>
                                    </td>
                                    <td class="text-center">10</td>
                                    <td class="text-center">$ 200</td>
                                    <td class="text-center">$ 2,000</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 col-sm-12 text-center text-md-left">
                            <p class="lead">Payment Methods:</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                        <tr>
                                            <td>Payment :</td>
                                            <td class="text-right">PayPal</td>
                                        </tr>
                                        <!-- <tr>
                                          <td>Acc name:</td>
                                          <td class="text-right">Amanda Orton</td>
                                        </tr>
                                        <tr>
                                          <td>IBAN:</td>
                                          <td class="text-right">FGS165461646546AA</td>
                                        </tr>
                                        <tr>
                                          <td>SWIFT code:</td>
                                          <td class="text-right">BTNPP34</td> -->
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <p class="lead">Total due</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Sub Total</td>
                                        <td class="text-right">$ 2,000</td>
                                    </tr>

                                    <tr class="bg-grey bg-lighten-4">
                                        <td class="text-bold-800">Cleaning Fee</td>
                                        <td class="text-bold-800 text-right">$ 100</td>
                                    </tr>
                                    <tr>
                                        <td>TAX (10%)</td>
                                        <td class="text-right">$ 200.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-800">Total</td>
                                        <td class="text-bold-800 text-right"> $ 2,300.00</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="text-center">
                              <p>Authorized person</p>
                              <img src="../../../app-assets/images/pages/signature-scan.png" alt="signature" class="height-100"
                              />
                              <h6>Amanda Orton</h6>
                              <p class="text-muted">Managing Director</p>
                            </div> -->
                        </div>
                    </div>
                </div>
                <!-- Invoice Footer -->
                <!-- <div id="invoice-footer">
                  <div class="row">
                    <div class="col-md-7 col-sm-12">
                      <h6>Terms & Condition</h6>
                      <p>You know, being a test pilot isn't always the healthiest business
                        in the world. We predict too much for the next year and yet far
                        too little for the next 10.</p>
                    </div>
                    <div class="col-md-5 col-sm-12 text-center">
                      <button type="button" class="btn btn-info btn-lg my-1"><i class="la la-paper-plane-o"></i> Send Invoice</button>
                    </div>
                  </div>
                </div> -->
                <!--/ Invoice Footer -->
            </div>
        </section>
    </div>


    </div>
    </div>

@endsection
