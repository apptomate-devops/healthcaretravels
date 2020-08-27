<?php
//echo json_encode($data);exit;
?>
@extends('layout.master') @section('title',$data->title) @section('main_content')
<style type="text/css">
   div::-webkit-scrollbar {
   width: 12px;
   }
   div::-webkit-scrollbar-track {
   -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
   border-radius: 10px;
   }
   div::-webkit-scrollbar-thumb {
   border-radius: 10px;
   -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
   }
   .property-title h2 {
   font-size: 26px !important;
   }
   @media only screen and (min-width: 990px) {
   .property-image p {
   text-align: right;
   }
   .property-pricing {
   margin-top: 40px;
   }
   .property-image .sub-price a {
   text-align: right;
   }
   .show-990{
   display: none;
   }
   }
   @media only screen and (max-width: 989px) {
   .show-990{
   display: show;
   }
   .-990{
   display: none;
   }
   .property-image p {
   text-align: center;
   }
   .property-pricing {
   margin-top: 40px;
   }
   .property-image .sub-price a {
   text-align: center;
   }
   }
   @media only screen and (max-width: 767px) {
   .show-990{
   display: none !important;
   }
   .-990{
   display: show !important;
   }
   }
   .property-image .sub-price a {
   display: block;
   font-size: 19px;
   font-weight: 600;
   }
   .property-image p img {
   border-radius: 50%;
   width: 100px;
   margin-bottom: 0px;
   }
   .property-pricing {
   margin-top: 40px;
   }
   .comments {
   margin: -10px 0 0 0;
   }
   .td {
   padding: 10px;
   }
   #map_container{
   position: relative;
   }
   #map{
   height: 0;
   overflow: hidden;
   padding-bottom: 22.25%;
   padding-top: 30px;
   position: relative;
   }
   #contact_host{
   color: #e78016;
   text-decoration: underline;
   cursor: pointer;
   }
   .tooltip {
   position: relative;
   display: inline-block;
   border-bottom: 1px dotted black;
   }
   .row_border{
      /*padding: 10px;*/
      /*margin-bottom: 5px;*/
      border-bottom: 1px solid lightgrey;


   }
   .name{
      padding: 10px;
   }
   .tempClass{
      border: 1px solid lightgrey;
      padding:5px;
   }
   .total_amount{
      color: white;
      background-color: #e78016;
      font-weight: bold;
      padding: 10px;
      text-align: center;
   }
</style>
<div id="" class="property-titlebar margin-bottom-0">

   <div class="container">
      <div class="row margin-bottom-50">
      </div>
   </div>
   <div class="container">
      <div class="row">
         <div class="row">
            <div class="col-md-5 col-md-push-7 col-lg-4 col-lg-push-8 row-space-2 lang-ar-left tempClass">
               <div class="panel payments-listing payment_list_right">
                  <div class="media-photo media-photo-block text-center payments-listing-image">
                     <img src="{{$data->image_url}}" class="img-responsive-height" alt="Chambre accueillante chezl habitant">
                  </div>
                  <div class="panel-body">
                     <section id="your-trip" class="your-trip">
                        <div class="hosting-info">
                           <div class="payments-listing-name h4 row-space-1" style="word-wrap: break-word;">
                              {{$data->title}}
                              {{-- <p style="font-weight: normal;
                                 font-size: 14px;
                                 margin: 10px 0px !important;"> {{$data->location}} </p> --}}
                           </div>
                           <div class="">
                              <hr>
                              <div class="row-space-1">
                                 <strong>
                                 {{$data->room_type}}
                                 </strong>
                              </div>
                              <div>
                                 <strong>{{date('m/d/Y',strtotime($data->start_date))}}</strong> to <strong>{{date('m/d/Y',strtotime($data->end_date))}}</strong>
                              </div>
                           </div>
                           <hr>
                           <table class="reso-info-table">
                              <tbody>
                                 <tr>
                                    <td>Cancellation Policy</td>
                                    <td>
                                       &nbsp;
                                       <a href="{{URL('/')}}/cancellationpolicy" class="cancel-policy-link" target="_blank">{{$data->cancellation_policy}} </a>
                                    </td>
                                 </tr>
                                 <tr>
                                 </tr>
                                 <tr>
                                    <td>
                                       Nights
                                    </td>
                                    <td>
                                       &nbsp;
                                       {{$data->total_days}}
                                    </td>
                                 </tr>
                                 @if($data->coupon_value=="")
                                 <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                                 <tr class="" style="margin-top:5px">
                                       <td class="name pos-rel">
                                          Coupon Code
                                         <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">Please input coupon code given by us</span></span>
                                       </td>
                                       <td class="val text-left">
                                          <span class="lang-chang-label">
                                             <input type="text" name="coupon_code" id="coupon_code" onchange="apply_coupon(
                                             '{{$data->property_booking_id}}')">

                                       </td>
                                    </tr>
                                    <tr>
                                       <td colspan="2" ><span id="message"></span></td>
                                    </tr>
                                    @endif
                              </tbody>
                           </table>
                           <hr>
                           <section id="billing-summary" class="billing-summary">


                              <table id="billing-table" class="reso-info-table billing-table" style="width:95%">
                                 <tbody>
                                    <h4>Property Details</h4>
                                    <tr class="row_border">
                                       <td class="name pos-rel" >
                                          <span class="lang-chang-label">
                                          $
                                          </span>{{$data->single_day_fare}} x {{$data->total_days}} night
                                          <span class='tooltips'><i style="color:black"  class='fa fa-question-circle'></i><span style="color: white!important" class='tooltiptext'>Price per night</span></span>
                                       </td>
                                       <td class="val text-right">
                                          <span class="lang-chang-label" >  $
                                          </span><span >{{$data->single_day_fare*$data->total_days}}.00</span>
                                       </td>
                                    </tr>
                                       @if($data->extra_guest!=0)
                                     <tr class="row_border">
                                       <td class="name">
                                          Extra Guest {{$data->extra_guest}} X {{$data->extra_guest_price/$data->extra_guest}}
                                          <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">price per extra guest </span></span>
                                       </td>
                                       <td class="val text-right" >
                                          <span class="lang-chang-label">
                                          $
                                          </span><span>{{$data->extra_guest_price}}.00</span>
                                       </td>
                                    </tr>
                                    @endif
                                    <tr class="row_border">
                                       <td class="name pos-rel">
                                          Service Fee
                                         <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">General Service Charges</span></span>
                                       </td>
                                       <td class="val text-right" >
                                          <span class="lang-chang-label">         $
                                          </span><span>{{$data->service_tax}}.00</span>
                                       </td>
                                    </tr>

                                    <tr class="row_border">
                                       <td class="name">
                                          Cleaning Fee
                                          <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">General Cleaning Charges</span></span>
                                       </td>
                                       <td class="val text-right" >
                                          <span class="lang-chang-label">
                                          $
                                          </span><span>{{$data->cleaning_fare}}.00</span>
                                       </td>
                                    </tr>

                                    <tr class="row_border">
                                       <td class="name">
                                          Security Deposit <span class='tooltips'><i style="color:black" class='fa fa-question-circle'></i><span class='tooltiptext' style="color: white!important">Average Nightly rate is Rounded</span></span>
                                       </td>
                                       <td class="val text-right" >
                                          <span class="lang-chang-label">
                                          $
                                          </span><span>{{$data->security_deposit}}.00</span>
                                       </td>
                                    </tr>


                                    <tr class="row_border">
                                       <td class="name">
                                          <b>Total Amount </b>
                                       </td>
                                       <td class="val text-right" >
                                          <span class="lang-chang-label">
                                          $
                                          </span><span><b>{{$data->total_amount+$data->coupon_value}}.00</b></span>
                                       </td>
                                    </tr>
                                     @if($data->coupon_value!="")
                                    <tr class="row_border">
                                       <td class="name" style="color:green;font-weight: bold">
                                          Discount(Coupon)
                                       </td>
                                       <td class="val text-right">
                                          <span class="lang-chang-label" style="color:green;font-weight: bold">
                                         $
                                          </span><span style="color:green;font-weight: bold">{{$data->coupon_value}}</span>
                                       </td>
                                    </tr>
                                    @endif
                                    <tr class="editable-fields" id="total_amount">
                                       <td colspan="2">
                                      <div class="total_amount">Payable Amount $ {{$data->total_amount}}.00</div>
                                       </td>
                                    </tr>
                                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                                      @if($data->coupon_value!="")
                                    <tr>
                                       <td colspan="2"style="color:green;font-weight: bold"><center> Coupon Code is Applied<b>({{$data->coupon_code}})</b></center></td>
                                    </tr>
                                    @endif
                                   <!--  <tr class="coupon">
                                       <td class="name">
                                          <span class="without-applied-coupon">
                                          <span class="coupon-section-link" id="after_apply_coupon" style="display:none;">
                                          Coupon
                                          </span>
                                          </span>
                                          <span class="without-applied-coupon" id="restric_apply">
                                          <a href="javascript:;" class="open-coupon-section-link" style="display:Block;">Coupon Code</a>
                                          </span>
                                       </td>
                                       <td class="val text-left">
                                          <div class="without-applied-coupon label label-success" id="after_apply_amount" style="display:none;">
                                             -$<span id="applied_coupen_amount">0</span>
                                          </div>
                                       </td>
                                    </tr> -->
                                   <!--  <tr id="after_apply_remove" style="display:none;">
                                       <td>
                                          <a data-prevent-default="true" href="javascript:void(0);" id="remove_coupon">
                                          <span>
                                          Remove coupon
                                          </span>
                                          </a>
                                       </td>
                                       <td>
                                       </td>
                                    </tr> -->
                                 </tbody>
                              </table>
                              <hr>

                           </section>
                        </div>
                     </section>
                  </div>
               </div>
            </div>
            <div id="content-container" class="col-md-7 col-md-pull-5 col-lg-pull-4 lang-ar-right">



               <section id="head_scroll" class="checkout-main__section payment">
                  <form name="payment" action="{{URL('/')}}/save-guest-information" method="post">
                     <input type="hidden" name="_token" value="{{csrf_token()}}">
                     <input type="hidden" name="booking_id" value="{{$data->booking_id}}">
                     <input type="hidden" name="guest_count" value="{{$data->guest_count}}">
                        <div class="row">
                              <div class="col-sm-12">
                                       <h2>Billing Information</h2>
                                          To complete this booking, you will need your bank account number and routing number an invoice will be sent to the verified email associated with your Health Care Travels account within 24 hours. Once the invoice has been sent you should pay the invoice as soon as possible. Bookings are confirmed on a first come first serve basis and the invoice will expire 24 hours after invoice is created. Please review this listing in its entirety and the selected cancellation policy.<br><br>
                                          *Please note to speed up this process make sure your account is Up-To-Date, Complete, Verified and all of the necessary documents are uploaded to your account. If you have any question or concerns email <a href="mailto:support@healthcaretravels.com">support@healthcaretravels.com</a><br><br>
                                       <p></p>
                                    </div>
                                 </div>
                                 @if(Session::get('role_id') == 2)
                                    <h2>Basic Details</h2>
                                    <div class="row">
                                       <div class="control-group cc-first-name col-md-6">
                                          <label class="control-label" for="credit-card-first-name">
                                          Recruiter Name
                                          </label>
                                          <input  name="recruiter_name" type="text" value="" required="required">
                                       </div>
                                       <div class="control-group cc-last-name col-md-6">
                                          <label class="control-label" for="credit-card-last-name">
                                          Recruiter Phone Number
                                          </label>
                                          <input  name="recruiter_phone_number" type="number" value="">
                                       </div>
                                       <div class="control-group cc-last-name col-md-6">
                                          <label class="control-label" for="credit-card-last-name">
                                          Recruiter Email
                                          </label>
                                          <input  name="recruiter_email" type="email" value="">
                                       </div>
                                       <div class="control-group cc-last-name col-md-6">
                                          <label class="control-label" for="credit-card-last-name" >
                                          Contract Start Date
                                             </label>
                                          <input  name="contract_start_date" type="text" value="" id="property_from_date" >
                                       </div>
                                       <div class="control-group cc-last-name col-md-6">
                                          <label class="control-label" for="credit-card-last-name">
                                          Contract End Date
                                             </label>
                                          <input  name="contract_end_date" type="text" value="" id="property_to_date">
                                       </div>
                                    </div>
                                    <hr>
                                 @endif
                                 <h2>Guest Details</h2>
                                 @for($i=0;$i< $data->guest_count;$i++)
                                 <h4>Enter Guest {{$i+1}} Details</h4>
                                 <div class="row">
                                    <div class="control-group cc-first-name col-md-6">
                                       <label class="control-label" for="credit-card-first-name">
                                        Guest Name
                                       </label>
                                       <input  name="guest_name[]" type="text" value="" required="required">
                                    </div>
                                    <div class="control-group cc-last-name col-md-6">
                                       <label class="control-label" for="credit-card-last-name">
                                       Occupation
                                       </label>
                                       <input  name="guest_occupation[]" type="text" value="">
                                    </div>
                                    <div class="control-group cc-last-name col-md-6">
                                       <label class="control-label" for="credit-card-last-name">
                                       Phone number
                                       </label>
                                       <input  name="phone_number[]" type="text" value="">
                                    </div>
                                    <div class="control-group cc-last-name col-md-6">
                                       <label class="control-label" for="credit-card-last-name">
                                       Email
                                       </label>
                                       <input  name="email[]" type="email" value="">
                                    </div>
                                 </div>
                                 @endfor

                           <hr>
                           <button class="btn btn-default" style="background-color: #e78016;height:30px;color:white">Save Details</button>
                        </div>
                              </div>


                           </div>


                        </div>

                     </div>
                  </div>
                  <hr>
                  </form>
               </section>
               <div style="height:200px"></div>
               <p>
               </p>
               </p>
            </div>
         </div>
         <!-- Property Description -->
         <!-- Property Description / End -->
         <!-- Sidebar -->
         <!-- Widget / End -->
         <!-- Widget -->

         <!-- Widget / End -->
         <!-- Widget -->

         <!-- Widget / End -->
      </div>
   </div>
   <!-- Sidebar / End -->
</div>
{{--
<div class="row" style="background-color:#75a627;color:white;">
   <div class="col-md-1">
   </div>
   <div class="col-md-11">
      <h2>{{$data->first_name}} {{$data->last_name}}</h2>
      <p>A Family Man. Father of a cute little angel. a host that always longs to say, “Be my guest”. An IT professional by career, a vacation host by choice! I live in New Jersey, have rental interests in a few places in East Cost of US.</p>
      <a href="#" style="color:white" class="button">See Owner Profile</a><br>
      <a href="{{url('/')}}/owner/chat" style="color:white" class="button">Contact Owner</a>
      <br><br>
   </div>
</div>
--}}
</div>

<script>
   $(document).ready(function(){
         date=new Date();
         $("#property_from_date").datepicker({

             autoclose: true
          });


         $("#property_from_date").change(function(){

             var fDate = $("#property_from_date").val();
             // alert(fDate);


             // $("#property_to_date").foucs();
             $("#property_to_date").datepicker('remove');
             $("#property_to_date").datepicker({
                 startDate: fDate,
                 autoclose: true
              });

         });
      });
   function apply_coupon(id){

      var coupon_code=document.getElementById('coupon_code').value;
      var url = "{{url('/')}}/apply_coupon?coupon_code="+coupon_code+"&&id="+id;


console.log(url);

            $.ajax({
                "type": "get",
                "url" : url,
                success: function(data) {
                  console.log(data);
                  if(data.status=="SUCCESS"){
                     $('#message').css('color','green');
                     $('#message').css('font-weight','bold');
                     $('#message').css('font-size',17);
                     $('#message').html('* '+ data.message);
                     $('#message').css('display','block');
                     // alert(data.message);
                      window.location.reload();
                  }else{
                        $('#message').css('color','red');
                     $('#message').css('font-weight','bold');
                     $('#message').css('font-size',17);
                     $('#message').html('* '+ data.message);
                     $('#message').css('display','block');
                  }
                }

             });
             }
   </script>
@endsection
