@extends('layout.master') @section('title','Health Care Travels') @section('main_content')


    <div class="container" style="margin-top: 35px;">
        <div class="content_wrapper  row ">

            <div id="post" class="row  post-2000 page type-page status-publish hentry">
                <div class="col-md-12 breadcrumb_container">
                    <ol class="breadcrumb">
                        <li><a href="http://healthcaretravels.com">Home</a></li>
                        <li class="active">Cancellation Policy</li>
                    </ol>
                </div>
                <div class=" col-md-12 ">


                    <div class="loader-inner ball-pulse" id="internal-loader">
                        <div class="double-bounce1"></div>
                        <div class="double-bounce2"></div>
                    </div>

                    <div id="listing_ajax_container">

                    </div>
                    <div class="single-content">
                        <h1 class="entry-title single-title">Cancellation Policy</h1>


                        <p><strong>Health Care Travels Cancellation Policy</strong></p>
                        <p>In an event the traveler or also the host desires to cancel a booking/reservation, we've
                            provided the Health Care Travels Cancellation policy below. When creating a listing, the
                            host can choose 1 out of 4 cancellation options. Keep in your mind it's in the host's
                            discretion to select the option that best accommodates their listing. Be sure to familiarize
                            yourself and direct your attention as a traveler to the cancellation policy that applies to
                            each listing in the cancelation section of the listing. Booking signifies that you have read
                            and agree with all the listing details.</p>
                        <p>Please be aware that we will monitor the number of cancellations made by a traveler or host
                            within a calendar year. We reserve the right to terminate, prohibit or ban your account for
                            excessive cancellations. This platform was established to ease the stress of securing
                            short-term housing for working healthcare professionals. To maintain our standard of
                            practice, it is important to enforce these policies to protect the host and the
                            traveler.</p>
                        <p><b>Scouting</b></p>
                        <p>If you have requested and paid for the services of a scout to verify a listing before
                            booking, you can only seek a refund if the scout is not already in route or has not visited
                            the listing.</p>
                        <p><b>Fully Refundable fees if booking/reservation was canceled before check-in</b></p>
                        <ul>
                            <li>Deposits made during the booking process.</li>
                            <li>Cleaning fees paid with the reservation where applicable.</li>
                            <li>Fees for extra Travelers included in the reservation.</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p style="text-align: center;"><b>Flexible</b></p>
                        <ul>
                            <li>Travelers using the Health Care Travels Platform can request a refund of the service fee
                                up to 4 times in a year but must do so within 48 hours of reservation. However, if a
                                Traveler cancels a booking that coincides with an existing booking, Health Care Travels
                                shall not refund the service fee.
                            </li>
                            <li>The accommodation fees, which is the total daily fees the Traveler paid to the host
                                can be refunded in specific situations including:
                            </li>
                            <li>If either party has a complaint, Health Care Travels must be notified within 24 hours of
                                check-in.
                            </li>
                            <li>Where necessary, Health Care Travels will serve as a mediator, and our resolution on
                                every dispute is final.
                            </li>
                            <li>To officially cancel a reservation, the Traveler or Host goes to my
                                Bookings/Reservations, locate the booking or reservation you want to cancel. Select
                                Cancel. A page will appear asking you to confirm cancellation.
                            </li>
                            <li>Cancellation Policies can be due to a request for refund by the Traveler, justifiable
                                circumstances, and cancellations by Health Care Travels for any other reasons according
                                to our Terms of Service. Kindly look at these exceptions.
                            </li>
                        </ul>
                        <ul>
                            <li>To receive a full refund of accommodation fees, the Traveler must cancel the booking 24
                                hours before the listing’s local check-in time, and where it is not specified, 3:00 PM
                                on check-in day. So, if you are to check in on Wednesday, cancellation must be made by
                                Tuesday of that week before the time of check-in.
                            </li>
                        </ul>
                        <p><span
                                style="display: inline !important; float: none; background-color: transparent; color: #333333; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif; font-size: 16px; font-style: normal; font-variant: normal; font-weight: 400; letter-spacing: normal; line-height: 24px; orphans: 2; text-align: left; text-decoration: none; text-indent: 0px; text-transform: none; -webkit-text-stroke-width: 0px; white-space: normal; word-spacing: 0px; word-wrap: break-word;">*In the circumstance where the assignment of the Traveler was terminated or cancelled before check-in or after check-in (Traveler must show proof to Health Care Travels within 24 hours), the full deposit paid to the host shall be refunded to the Traveler, if the host doesn’t report any damage. The Traveler will also receive a full refund of the remaining accommodation fees agreed between the host and Traveler based on the revised checkout date.</span><b></b><i></i><u></u>
                        </p>
                        <p>For example:</p>
                        <p>&nbsp;</p>
                        <table style="height: 179px;" width="1070">
                            <tbody>
                            <tr>
                                <td>
                                    <p style="text-align: center;">1-Day Prior</p>
                                </td>
                                <td style="text-align: center;">Check-in</td>
                                <td style="text-align: center;">Check out</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">Tues, March 13<p></p>
                                    <p>3:00 PM</p></td>
                                <td style="text-align: center;">Wednesday, March 14<p></p>
                                    <p>3:00 PM</p></td>
                                <td>
                                    <p style="text-align: center;">Saturday, March 17</p>
                                    <p style="text-align: center;">11:00 AM</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p>&nbsp;</p>
                        <table style="height: 70px;" width="293">
                            <tbody>
                            <tr>
                                <td>
                                    <p style="text-align: center;"><b>Full Refund</b></p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p>&nbsp;</p>
                        <p style="text-align: center;"><b>Moderate</b></p>
                        <ul>
                            <li>Travelers on the Health Care Travels Platform can request for a refund of the service
                                fee up to 4 times in a year but must do so within 48 hours of reservation and at least
                                five full days before the check-in day. However, if a Traveler cancels a booking that
                                coincides with an existing booking, Health Care Travels shall not refund the service
                                fee.
                            </li>
                            <li>The accommodation fees, i.e., the total daily fees the Traveler paid to the host can
                                be refunded in specific situations including:
                            </li>
                            <li>If either party has a complaint, Health Care Travels must be notified within 24 hours of
                                check-in.
                            </li>
                            <li>Where necessary, Health Care Travels will serve as a mediator, and our resolution on
                                every dispute is final.
                            </li>
                            <li>To officially cancel a reservation, the Traveler or Host goes to the my
                                Bookings/Reservations, locate the booking or reservation you want to cancel. Select
                                Cancel. A page will appear asking you to confirm cancellation.
                            </li>
                            <li>Cancellation Policies are due to a request for refund by the Traveler, justifiable
                                circumstances, and cancellations by Health Care Travels for any other reasons according
                                to our Terms of Service. Kindly take a look at these exceptions
                            </li>
                        </ul>
                        <ul>
                            <li>To receive a full refund of accommodation fees, the Traveler must cancel the booking 5
                                days before the listings local check in time, and where it is not specified, 3:00PM on
                                check-in day. So if you are to check in on Friday, cancellation must be made by the
                                previous Sunday before the time of check-in.
                            </li>
                            <li>If the cancellation was made less than 5 days before check-in, we would not refund the
                                first day, but we will refund 50 percent of the accommodation fees for the remaining
                                days.
                            </li>
                            <li>If the Traveler decides to leave before the end of their reservation, Health Care
                                Travels will refund 50 percent of the accommodation fees for the unspent days 24 hours
                                after the Traveler canceled.
                            </li>
                        </ul>
                        <p><span
                                style="display: inline !important; float: none; background-color: transparent; color: #333333; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif; font-size: 16px; font-style: normal; font-variant: normal; font-weight: 400; letter-spacing: normal; line-height: 24px; orphans: 2; text-align: left; text-decoration: none; text-indent: 0px; text-transform: none; -webkit-text-stroke-width: 0px; white-space: normal; word-spacing: 0px; word-wrap: break-word;">*In the circumstance where the assignment of the Traveler was terminated or cancelled before check-in or after check-in (Traveler must show proof to Health Care Travels within 24 hours), 50 percent of the deposit paid to the host shall be refunded to the Traveler, if the host doesn’t report any damage. The Traveler will receive a full refund of the remaining accommodation fees agreed between the host and Traveler based on the revised checkout date.</span><b></b><i></i><u></u>
                        </p>
                        <p>For example:</p>
                        <table style="height: 179px;" width="1070">
                            <tbody>
                            <tr>
                                <td>
                                    <p style="text-align: center;">5 days before check-in</p>
                                </td>
                                <td style="text-align: center;">Check-in</td>
                                <td>
                                    <p style="text-align: center;">Check out</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">Sunday, March 11<p></p>
                                    <p>3:00 PM</p></td>
                                <td style="text-align: center;">Friday, March 16<p></p>
                                    <p>3:00 PM</p></td>
                                <td>
                                    <p style="text-align: center;">Monday, March 19</p>
                                    <p style="text-align: center;">11:00 AM</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p>&nbsp;</p>
                        <table style="height: 48px;" width="406">
                            <tbody>
                            <tr>
                                <td>
                                    <p style="text-align: center;"><b>Full Refund</b></p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p style="text-align: center;"><b>Strict</b></p>
                        <ul>
                            <li>Travelers using the Health Care Travels Platform can request for a refund of the service
                                fee up to 4 times in a year but must do so within 48 hours of reservation and a minimum
                                of 14 full days before the listing’s local check-in time, and where it is not specified,
                                3:00 PM on check-in day. However, if a Traveler cancels a booking that overlaps with
                                another booking, Health Care Travels shall not refund the service fee.
                            </li>
                            <li>The accommodation fees, i.e., the total nightly fees the traveler paid to the host can
                                be refunded in specific situations given below:
                            </li>
                            <li>If either party has a complaint, Health Care Travels must be notified within 24 hours of
                                check-in.
                            </li>
                            <li>Where necessary, Health Care Travels will serve as a mediator, and our resolution on
                                every dispute is final.
                            </li>
                            <li>To officially cancel a reservation, the Traveler or Host goes to the my
                                Bookings/Reservations, locate the booking or reservation you want to cancel. Select
                                Cancel. A page will appear asking you to confirm cancellation.
                            </li>
                            <li>Cancellation Policies are due to a request for refund by the Traveler, justifiable
                                circumstances, and cancellations by Health Care Travels for any other reasons according
                                to our Terms of Service. Kindly take a look at these exceptions.
                            </li>
                        </ul>
                        <ul>
                            <li>To receive a full refund of accommodation fees, the Traveler must cancel within 48 hours
                                of making the reservation and a minimum of 14 days before the listings local check-in
                                time or where the check-in time is not specific, 3:00PM on check-in day.
                            </li>
                            <li>To receive a 50 percent refund of accommodation fees, the Traveler must cancel 7 full
                                days before the local check-in time of the listing or 3:00 pm on the day of check-in
                                where the time is not specified, otherwise we will not refund. For instance, if you are
                                to check-in on Thursday, make your cancellation by Thursday of the previous week before
                                check-in time. In the event where the traveler cancels less than 7 days in advance or
                                makes an early exit after check-in, Health Care Travels will not refund the unspent
                                nights.
                            </li>
                        </ul>
                        <p><span
                                style="background-color: transparent; color: #333333; display: inline; float: none; font-family: Georgia,&amp;quot; times new roman&amp;quot;,&amp;quot;bitstream charter&amp;quot;,times,serif; font-size: 16px; font-style: normal; font-variant: normal; font-weight: 400; letter-spacing: normal; line-height: 24px; orphans: 2; text-align: left; text-decoration: none; text-indent: 0px; text-transform: none; -webkit-text-stroke-width: 0px; white-space: normal; word-spacing: 0px; word-wrap: break-word;">** If the assignment of the Traveler is canceled before check-in or after check-in (Traveler must show proof to Health Care Travels within 24 hours), the deposit paid to the host shall not be refunded to the Traveler, and the Traveler is required to pay an extra $100 if the host reports any damage. However, the Traveler will receive a refund of the remaining accommodation fees agreed between the host and Traveler based on the revised checkout date.</span><b
                                style="background-color: transparent; color: #333333; font-family: Georgia,&amp;quot; times new roman&amp;quot;,&amp;quot;bitstream charter&amp;quot;,times,serif; font-size: 16px; font-style: normal; font-variant: normal; font-weight: bold; letter-spacing: normal; line-height: 24px; max-width: none; min-height: 0px; orphans: 2; overflow: visible; text-align: left; text-decoration: none; text-indent: 0px; text-transform: none; -webkit-text-stroke-width: 0px; white-space: normal; word-spacing: 0px; word-wrap: break-word; padding: 0px; margin: 0px;"></b><i
                                style="background-color: transparent; color: #333333; font-family: Georgia,&amp;quot; times new roman&amp;quot;,&amp;quot;bitstream charter&amp;quot;,times,serif; font-size: 16px; font-style: italic; font-variant: normal; font-weight: 400; letter-spacing: normal; line-height: 24px; max-width: none; min-height: 0px; orphans: 2; overflow: visible; text-align: left; text-decoration: none; text-indent: 0px; text-transform: none; -webkit-text-stroke-width: 0px; white-space: normal; word-spacing: 0px; word-wrap: break-word; padding: 0px; margin: 0px;"></i><u
                                style="background-color: transparent; color: #333333; font-family: Georgia,&amp;quot; times new roman&amp;quot;,&amp;quot;bitstream charter&amp;quot;,times,serif; font-size: 16px; font-style: normal; font-variant: normal; font-weight: 400; letter-spacing: normal; line-height: 24px; max-width: none; min-height: 0px; orphans: 2; overflow: visible; text-align: left; text-decoration: underline; text-indent: 0px; text-transform: none; -webkit-text-stroke-width: 0px; white-space: normal; word-spacing: 0px; word-wrap: break-word; padding: 0px; margin: 0px;"></u><b></b><i></i><u></u>
                        </p>
                        <p>For example:</p>
                        <p>&nbsp;</p>
                        <table style="height: 180px;" width="1070">
                            <tbody>
                            <tr>
                                <td>
                                    <p style="text-align: center;">14 Days Prior to Check-In</p>
                                    <p style="text-align: center;">or</p>
                                    <p style="text-align: center;">Cancel Reservation Within 48 Hours of Booking</p>
                                </td>
                                <td style="text-align: center;">Check-in</td>
                                <td style="text-align: center;">Check out</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">Thursday, 1 May<p></p>
                                    <p>3:00 PM</p></td>
                                <td style="text-align: center;">Thursday, 15 May<p></p>
                                    <p>3:00 PM</p></td>
                                <td>
                                    <p style="text-align: center;">Sunday, 6 May</p>
                                    <p style="text-align: center;">11:00 AM</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p>&nbsp;</p>
                        <table style="height: 78px;" width="634">
                            <tbody>
                            <tr>
                                <td>
                                    <p style="text-align: center;"><b>Full Refund</b></p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p>&nbsp;</p>
                        <p><b>-OR-</b></p>
                        <p>&nbsp;</p>
                        <table style="height: 173px;" width="1070">
                            <tbody>
                            <tr>
                                <td>
                                    <p style="text-align: center;">7 Days Prior to Check-In</p>
                                </td>
                                <td style="text-align: center;">Check-in</td>
                                <td style="text-align: center;">Check out</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">Thursday 8 May<p></p>
                                    <p>3:00PM</p></td>
                                <td style="text-align: center;">Thursday, 15 May<p></p>
                                    <p>3:00 PM</p></td>
                                <td>
                                    <p style="text-align: center;">Sunday, 6 May</p>
                                    <p style="text-align: center;">11:00 AM</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p>&nbsp;</p>
                        <table style="height: 60px;" width="449">
                            <tbody>
                            <tr>
                                <td>
                                    <p style="text-align: center;"><b>50% Refund</b></p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p style="text-align: center;"><b>Super Strict 30 Days</b></p>
                        <ul>
                            <li>Travelers using the Health Care Travels Platform can request for a refund of the service
                                fee up to 4 times in a year but must do so within 48 hours of reservation and a minimum
                                of 30 full days before the listing’s local check-in time and where it is not specified,
                                3:00 PM on check-in day. However, if a Traveler cancels a booking that overlaps with
                                another reservation, Health Care Travels shall not refund the service fee.
                            </li>
                            <li>The accommodation fees, i.e., the total nightly fees the traveler paid to the host can
                                be refunded in specific situations given below:
                            </li>
                            <li>If either party has a complaint, Health Care Travels must be notified within 24 hours of
                                check-in.
                            </li>
                            <li>Where necessary, Health Care Travels will serve as a mediator, and our resolution on
                                every dispute is final.
                            </li>
                            <li>To officially cancel a reservation, the Traveler or Host goes to the my
                                Bookings/Reservations, locate the booking or reservation you want to cancel. Select
                                Cancel. A page will appear asking you to confirm cancellation.
                            </li>
                            <li>Cancellation Policies are due to a request for refund by the Traveler, justifiable
                                circumstances, and cancellations by Health Care Travels for any other reasons according
                                to our Terms of Service. Kindly take a look at these exceptions.
                            </li>
                        </ul>
                        <ul>
                            <li>To receive 50 percent refund of accommodation fees, the Traveler must cancel 30 days in
                                advance of the listing’s local check-in time or 3:00 PM on check-in day where
                                unspecified.
                            </li>
                            <li>If a cancellation is made less than 30 days before check-in, the Traveler will not
                                receive refunds for nights not spent.
                            </li>
                            <li>However, the Traveler will not be refunded for nights not spent if they decide to leave
                                early.
                            </li>
                        </ul>
                        <p><span
                                style="display: inline !important; float: none; background-color: transparent; color: #333333; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif; font-size: 16px; font-style: normal; font-variant: normal; font-weight: 400; letter-spacing: normal; line-height: 24px; orphans: 2; text-align: left; text-decoration: none; text-indent: 0px; text-transform: none; -webkit-text-stroke-width: 0px; white-space: normal; word-spacing: 0px; word-wrap: break-word;">*** If the assignment of the Traveler is canceled before check-in or after check-in (Traveler must show proof to Health Care Travels within 24 hours) the deposit made to the host shall not be refunded to the Traveler. Also, the Traveler will not be refunded the remainder of the accommodation reservation fees.</span><b></b><i></i><u></u>
                        </p>
                        <p>For example:<b></b><i></i><u></u></p>
                        <p style="background-color: transparent; color: #333333; font-family: Georgia,&amp;quot; times new roman&amp;quot;,&amp;quot;bitstream charter&amp;quot;,times,serif; font-size: 16px; font-style: normal; font-variant: normal; font-weight: 400; letter-spacing: normal; line-height: 24px; max-width: none; min-height: 0px; orphans: 2; overflow: visible; text-align: left; text-decoration: none; text-indent: 0px; text-transform: none; -webkit-text-stroke-width: 0px; white-space: normal; word-spacing: 0px; word-wrap: break-word; padding: 0px; margin: 16px 0px 16px 0px;">
                        </p>
                        <table style="height: 178px;" width="1070">
                            <tbody>
                            <tr>
                                <td>
                                    <p style="text-align: center;">30 days before check-in</p>
                                </td>
                                <td style="text-align: center;">Check-in</td>
                                <td style="text-align: center;">Check out</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">Wednesday, 2 April<p></p>
                                    <p>3:00 PM</p></td>
                                <td style="text-align: center;">Thursday, 3 May<p></p>
                                    <p>3:00 PM</p></td>
                                <td>
                                    <p style="text-align: center;">Sunday, 6 May</p>
                                    <p style="text-align: center;">11:00 AM</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p>&nbsp;</p>
                        <table style="height: 47px;" width="454">
                            <tbody>
                            <tr>
                                <td>
                                    <p style="text-align: center;"><b>50% Refund</b></p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>

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
