@extends('layout.master') @section('title','Health Care Travels') @section('main_content')


    <div class="container" style="margin-top: 35px;">
        <div class="content_wrapper  row ">

            <div id="post" class="row  post-2000 page type-page status-publish hentry">
                <div class="col-md-12 breadcrumb_container">
                    <ol class="breadcrumb">
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li class="active">Cancellation Policy</li>
                    </ol>
                </div>
                <div class="col-md-12">


                    <div class="loader-inner ball-pulse" id="internal-loader">
                        <div class="double-bounce1"></div>
                        <div class="double-bounce2"></div>
                    </div>

                    <div id="listing_ajax_container">
                    </div>
                    <div class="single-content col-sm-10" style="text-align: justify">
                        <h1 class="entry-title single-title">Cancellation Policy</h1>
                        <p><b>Care Travels Cancellation Policy</b></p>
                        <p>
                            In an event the traveler or also the Property Owner desires to cancel a booking/reservation, we've provided the Health Care Travels Cancellation policy below. When creating a listing, the Property Owner can choose 1 out of 3 cancellation options (Flexible, Moderate and Strict). Keep in mind it is in the Property Owner's discretion to select the option that best accommodates their listing. Be sure to familiarize yourself and direct your attention as a Traveler to the cancellation policy that applies to each listing in the cancelation section of the listing. Booking signifies that you have read and agree with all the listing details.
                        </p>
                        <p>
                            Please be aware that we will monitor the number of cancellations made by all users within a calendar year. We reserve the right to terminate, prohibit or ban your account for excessive cancellations. This platform was established to ease the stress of securing short-term housing for working healthcare professionals. To maintain our standard of practice, it is important to enforce these policies to protect all users.
                        </p>
                        <p>
                            Accommodation Fees is defined as:
                        </p>
                        <p><b>Fully Refundable fees if booking/reservation is canceled 48 hours BEFORE check-in</b></p>
                        <ul>
                            <li>Security Deposits made during the booking process</li>
                            <li>Fees for extra Travelers included in the reservation</li>
                            <li>Cleaning Fee</li>
                        </ul>
                        <p><b>Non-Refundable Fees</b></p>
                        <ul>
                            <li>Health Care Travels Service fee is non-refundable under any circumstances</li>
                        </ul>
                        <p><b>Security Deposits:</b></p>
                        <p>
                            Health Care Travels will hold all security deposits until 48 hours after the traveler has checked out. If no damages are reported by the property owner within 48 Hours of the Travelers check out time, the Security Deposit will be returned to the traveler within 3 days of check-out. If any damages are reported to Health Care Travels within 48 hours with proof, Health Care Travels will be the mediator and decide which party will receive the security deposit, decisions are final.
                        </p>
                        <p><b>Healthcare Traveler Canceled Work Assignment policy</b></p>
                        <p>
                            In the circumstance where the assignment of the Traveler was terminated or canceled before check-in or after check-in (Traveler <b>must</b> show proof to Health Care Travels within <b>24 hours</b> of being notified of any canceled contract). If the Travelers work assignment is canceled 48 hours before check-in the Traveler will receive a full refund of all fees except Health Care Travels Non-Refundable Service fee. If the Travelers assignment is canceled after Check-in the security deposit shall be refunded to the Traveler in 3 days, if the Property Owner doesn’t report any damages 48 hours after the revised check out date. If the Property Owner reports any damages the Traveler will be held responsible, if approved by Health Care Travels. The Traveler may or may not receive a refund of the remaining accommodation fees for the current month's rent. Refund determination shall be agreed between the Property Owner and Traveler based on the revised checkout date. If the traveler has any future auto payment(s) for the upcoming month(s) HCT will stop auto payments and the traveler will not be charged. In the event that sufficient proof is <b>not</b> sent to Health Care Travels within 24 hours. The homeowners selected policy will be enforced.
                        </p>
                        <p><b>Property Owner/Co-Host Cancels Booking</b></p>
                        <p>
                            Full refund to the traveler will be issued for the days unspent. If the property owner cancels after accepting the booking, the Property owner/Co-Host will be charged a penalty fee of $100 for canceling an already confirmed reservation if the cancellation reason does not fall under an Extenuating Circumstance policy with proof.
                        </p>
                        <p><b>Flexible</b></p>
                        <ul>
                            <li>
                                Reservations are fully refundable for 48 hours after the booking is confirmed, <b>as long as the cancellation occurs at least 7 days before check-in </b>(3:00 PM in the destination’s local time if not specified)
                            </li>
                            <li>
                                More than 48 hours after booking, Travelers can cancel before check-in and get a full refund, <b>minus the first 7 days</b> and the service fee
                            </li>
                        </ul>
                        <div class="policy-image-container mb-10 mt-10">
                            <img src="/assets/policies/flexible.png" alt="flexible" class="policy-image">
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                For a full refund, cancel within 48 hours of booking and at least 7 full days prior to listing’s local check-in time (3:00 PM if not specified) on the day of check-in.
                            </div>
                            <div class="col-md-4 col-sm-12">
                                If the Traveler cancels the reservation before the start date, the first 7 days of the reservation is paid to the Property Owner/Co-Host in full and not refunded to the Traveler.
                            </div>
                            <div class="col-md-4 col-sm-12">
                                If the Traveler cancels the reservation during their stay, the Traveler must submit a request to cancel within their account under in order to request and agree to a new checkout date. Regardless of the checkout date chosen, the Traveler is required to pay the Property Owner/Co-Host for the 7 days following the cancellation date, or up to the end date of the traveler’s original reservation if the remaining portion is less than 7 days.
                            </div>
                        </div>
                        <p><b>Moderate</b></p>
                        <ul>
                            <li>
                                Reservations are fully refundable for 48 hours after the booking is confirmed, <b>as long as the cancellation occurs at least 14 days before check-in </b>(3:00 PM in the destination’s local time if not specified)
                            </li>
                            <li>
                                More than 48 hours after booking, Travelers can cancel before check-in and get a full refund, <b>minus the first 14 days</b> and the service fee
                            </li>
                        </ul>
                        <div class="policy-image-container mb-10 mt-10">
                            <img src="/assets/policies/moderate.png" alt="moderate" class="policy-image">
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                For a full refund, cancel within 48 hours of booking and at least 14 full days prior to listing’s local check-in time (3:00 PM if not specified) on the day of check-in.
                            </div>
                            <div class="col-md-4 col-sm-12">
                                If the Traveler cancels the reservation before the start date, the first 14 days of the reservation is paid to the Property Owner/Co-Host in full and not refunded to the Traveler.
                            </div>
                            <div class="col-md-4 col-sm-12">
                                If the Traveler cancels the reservation during their stay, the Traveler must submit a request to cancel within their account under in order to request and agree to a new checkout date. Regardless of the checkout date chosen, the Traveler is required to pay the Property Owner/Co-Host for the 14 days following the cancellation date, or up to the end date of the traveler’s original reservation if the remaining portion is less than 14 days.
                            </div>
                        </div>
                        <p><b>Strict</b></p>
                        <ul>
                            <li>
                                Reservations are fully refundable for 48 hours after the booking is confirmed, <b>as long as the cancellation occurs at least 21 days before check-in </b>(3:00 PM in the destination’s local time if not specified)
                            </li>
                            <li>
                                More than 48 hours after booking, Travelers can cancel before check-in and get a full refund, <b>minus the first 21 days</b> and the service fee
                            </li>
                        </ul>
                        <div class="policy-image-container mb-10 mt-10">
                            <img src="/assets/policies/strict.png" alt="strict" class="policy-image">
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                For a full refund, cancel within 48 hours of booking and at least 21 full days prior to listing’s local check-in time (3:00 PM if not specified) on the day of check-in.
                            </div>
                            <div class="col-md-4 col-sm-12">
                                If the Traveler cancels the reservation before the start date, the first 21 days of the reservation is paid to the Property Owner/Co-Host in full and not refunded to the Traveler.
                            </div>
                            <div class="col-md-4 col-sm-12">
                                If the Traveler cancels the reservation during their stay, the Traveler must submit a request to cancel within their account under in order to request and agree to a new checkout date. Regardless of the checkout date chosen, the Traveler is required to pay the Property Owner/Co-Host for the 21 days following the cancellation date, or up to the end date of the traveler’s original reservation if the remaining portion is less than 21 day.
                            </div>
                        </div>
                    </div>

                    <!-- #comments start-->

                    <!-- end comments -->

                </div>

                <!-- begin sidebar -->
                <div class="clearfix visible-xs"></div>
                <!-- end sidebar --></div>

        </div>
    </div>

@endsection
