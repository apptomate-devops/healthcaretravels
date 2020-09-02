@extends('Admin.Layout.master')

@section('title')
    {{APP_BASE_NAME}} Admin
@endsection

@section('content')
    <style>
        tr {
            border-bottom: 1px solid lightgrey;
            padding-bottom: 50px;
        }

        .col-det {
            padding: 10px;
        }

        td {
            padding: 20px;
        }

    </style>
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Reservation Details</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <!-- <ol class="breadcrumb">
                       <li class="breadcrumb-item"><a href="index.html">Home</a>
                       </li>
                       <li class="breadcrumb-item"><a href="#">Invoice</a>
                       </li>
                       <li class="breadcrumb-item active">Invoice Template
                       </li>
                     </ol> -->
                </div>
            </div>
        </div>
        <div class="content-header-left col-md-6 col-12">
            <div class="dropdown float-md-left">
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
        <section class="card">
            <div id="invoice-template" class="card-body">
                <!-- Invoice Company Details -->
                <div id="invoice-company-details" class="row">
                    <!--   <div class="col-md-6 col-sm-12 text-center text-md-left">
                         <div class="media">
                           <img src="../../../app-assets/images/logo/logo-80x80.png" alt="company logo" class=""
                           />
                           <div class="media-body">
                             <ul class="ml-2 px-0 list-unstyled">
                               <li class="text-bold-800">Modern Creative Studio</li>
                               <li>4025 Oak Avenue,</li>
                               <li>Melbourne,</li>
                               <li>Florida 32940,</li>
                               <li>USA</li>
                             </ul>
                           </div>
                         </div>
                       </div> -->
                    <!--  <div class="col-md-6 col-sm-12 text-center text-md-left">
                        <h2>INVOICE</h2>
                        <p class="pb-3"># INV-001001</p>
                        <ul class="px-0 list-unstyled">
                          <li>Balance Due</li>
                          <li class="lead text-bold-800">$ 12,000.00</li>
                        </ul>
                      </div>
                    </div> -->
                    <!--/ Invoice Company Details -->
                    <!-- Invoice Customer Details -->
                    <!-- <div id="invoice-customer-details" class="row pt-2">
                       <div class="col-sm-12 text-center text-md-left">
                         <p class="text-muted">Bill To</p>
                       </div>
                       <div class="col-md-6 col-sm-12 text-center text-md-left">
                         <ul class="px-0 list-unstyled">
                           <li class="text-bold-800">Mr. Bret Lezama</li>
                           <li>4879 Westfall Avenue,</li>
                           <li>Albuquerque,</li>
                           <li>New Mexico-87102.</li>
                         </ul>
                       </div>
                       <div class="col-md-6 col-sm-12 text-center text-md-left">
                         <p>
                           <span class="text-muted">Invoice Date :</span> 06/05/2017</p>
                         <p>
                           <span class="text-muted">Terms :</span> Due on Receipt</p>
                         <p>
                           <span class="text-muted">Due Date :</span> 10/05/2017</p>
                       </div>
                     </div> -->
                    <!--/ Invoice Customer Details -->
                    <!-- Invoice Items Details -->
                    <!-- <div id="invoice-items-details" class="pt-2">
                       <div class="row">
                         <div class="table-responsive col-sm-12">
                           <table class="table">
                             <thead>
                               <tr>
                                 <th>#</th>
                                 <th>Item & Description</th>
                                 <th class="col-det">Rate</th>
                                 <th class="col-det">Hours</th>
                                 <th class="col-det">Amount</th>
                               </tr>
                             </thead>
                             <tbody>
                               <tr>
                                 <th scope="row">1</th>
                                 <td>
                                   <p>Create PSD for mobile APP</p>
                                   <p class="text-muted">Simply dummy text of the printing and typesetting industry.</p>
                                 </td>
                                 <td class="col-det">$ 20.00/hr</td>
                                 <td class="col-det">120</td>
                                 <td class="col-det">$ 2400.00</td>
                               </tr>
                               <tr>
                                 <th scope="row">2</th>
                                 <td>
                                   <p>iOS Application Development</p>
                                   <p class="text-muted">Pellentesque maximus feugiat lorem at cursus.</p>
                                 </td>
                                 <td class="col-det">$ 25.00/hr</td>
                                 <td class="col-det">260</td>
                                 <td class="col-det">$ 6500.00</td>
                               </tr>
                               <tr>
                                 <th scope="row">3</th>
                                 <td>
                                   <p>WordPress Template Development</p>
                                   <p class="text-muted">Vestibulum euismod est eu elit convallis.</p>
                                 </td>
                                 <td class="col-det">$ 20.00/hr</td>
                                 <td class="col-det">300</td>
                                 <td class="col-det">$ 6000.00</td>
                               </tr>
                             </tbody>
                           </table>
                         </div>
                       </div>
                       <div class="row"> -->
                    <div class="col-sm-12 text-center text-md-left">
                        <p class="lead">Reservation Details : &nbsp;<span
                                class="btn btn-default btn-info">{{$data->title}}</span></p>
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table " style="">
                                    <tbody>
                                    <tr>
                                        <td>Property Name:</td>
                                        <td class="col-det">{{$data->title}}</td>
                                    </tr>
                                    <tr>
                                        <td>Host Name:</td>
                                        <td class="col-det">{{$data->owner_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Travellers Name:</td>
                                        <td class="col-det">{{$data->traveller_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Check In:</td>
                                        <td class="col-det">{{$data->start_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>Check Out:</td>
                                        <td class="col-det">{{$data->end_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>Number of Guests:</td>
                                        <td class="col-det">{{$data->guest_count}}</td>
                                    </tr>

                                    <tr>
                                        <td>Total Nights:</td>
                                        <td class="col-det">{{$data->min_days}}</td>
                                    </tr>

                                    <td>Room Fee:</td>
                                    <td class="col-det">$ {{$data->price_per_night}}</td>
                                    </tr>
                                    <tr>
                                        <td>Cleaning fee:</td>
                                        <td class="col-det">$ {{$data->cleaning_fee}}</td>
                                    </tr>
                                    {{--  <tr>
                                       <td>Additional guest fee:</td>
                                       <td class="col-det">$ {{$data->price_per_extra_guest}}</td>
                                     </tr> --}}

                                    <tr>
                                        <td> Subtotal amount:</td>
                                        <td class="col-det">$ {{$data->min_days*$data->price_per_night}}</td>
                                    </tr>
                                    <tr>
                                        <td>Service fee:</td>
                                        <td class="col-det">$ {{$data->service_tax}}</td>
                                    </tr>
                                    {{-- <tr>
                                      <td>Tax:</td>
                                      <td class="col-det">$ {{$data->tax_amount}}</td>
                                    </tr> --}}
                                    <tr>
                                        <td>Total amount:</td>
                                        <td class="col-det">$ {{$data->total_amount}}</td>
                                    </tr>
                                    <tr>
                                        <td>Host Commision:</td>
                                        <td class="col-det">
                                            $ {{$data->total_amount - ($data->service_tax + $data->admin_commision)}}</td>
                                    </tr>
                                    <!--  <tr>
                                       <td>Payment Mode:</td>
                                       <td class="col-det">Card</td>
                                     </tr> -->
                                    <tr>
                                        <td>Payment Status</td>
                                        <td class="col-det">@if($data->payment_done==1)
                                                <span class="btn-default btn-success btn">Paid </span>
                                            @else
                                                <span class="btn-default btn-danger btn"> Not Paid</span>
                                            @endif</td>
                                    </tr>
                                    <!-- <tr>
                                      <td>Transaction ID:</td>
                                      <td class="col-det">BTNPP34</td>
                                    </tr> -->

                                    </tbody>
                                </table>
                                <center>
                                    @if($data->booking_status == 2)
                                        <div class="col-md-5 col-sm-12 text-center">
                                            <a href="{{url('admin/send-invoice/')}}/{{$data->booking_id}}/{{$data->property_id}}">
                                                <button type="button" class="btn btn-info btn-lg my-1"><i
                                                        class="la la-paper-plane-o"></i> Send Invoice
                                                </button>
                                            </a>
                                        </div>
                                    @endif
                                    @if($data->booking_status == 3)
                                        <div class="col-md-5 col-sm-12 text-center">
                                            <button type="button" class="btn btn-info btn-lg my-1"> Invoice Sent
                                            </button>
                                        </div>
                                    @endif
                                    @if($data->booking_status == 4)
                                        <div class="col-md-5 col-sm-12 text-center">
                                            <button type="button" class="btn btn-info btn-lg my-1"> Request Cancelled by
                                                owner
                                            </button>
                                        </div>
                                    @endif
                                </center>
                            </div>
                        </div>
                    </div>
                    <!--   <div class="col-md-5 col-sm-12">
                         <p class="lead">Total due</p>
                         <div class="table-responsive">
                           <table class="table table-borderless table-sm">
                               <tbody>

                               </tbody>
                             </table>
                         </div>
                        <div class="text-center">
                           <p>Authorized person</p>
                           <img src="../../../app-assets/images/pages/signature-scan.png" alt="signature" class="height-100"
                           />
                           <h6>Amanda Orton</h6>
                           <p class="text-muted">Managing Director</p>
                         </div>
                       </div> -->
                </div>
            </div>
            <!-- Invoice Footer -->
            <!--  <div id="invoice-footer">
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
