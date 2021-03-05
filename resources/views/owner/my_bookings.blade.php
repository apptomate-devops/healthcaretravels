@extends('layout.master')
@section('title')
     Owner Account | My Bookings page | {{APP_BASE_NAME}}
@endsection
@section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/reservations.css') }}">

    <div class="container my-reservations">
        <div class="row">


            <!-- Widget -->
            <div class="col-md-4">
                <div class="sidebar left">

                    <div class="my-account-nav-container">

                        @include('owner.menu')

                    </div>

                </div>
            </div>

            <div class="col-md-8">
                <div class="check-in-out-wrapper">
                    <input type="text" name="from_date" id="search_booking_range_picker" placeholder="Check in - Check out" autocomplete="off"/>
{{--                    <input type="text" name="to_date" id="search_booking_range_picker" placeholder="End Date" autocomplete="off"/>--}}
                    <div class="search-container">
                        <button class="button" id="search" style="width: 120px;" >Search</button>
                        <a href="/owner/my-bookings" disabled>Clear Dates</a>
                    </div>
                </div>
                <table class="manage-table responsive-table" style="border-spacing: 0 1em;" id="booking_table">
                    <tr>
                        <th><i class="fa fa-file-text"></i> Booking Requests</th>
                        <th class="expire-date"> Status </th>
                        <th colspan="2">Action</th>
                    </tr>
                @foreach($booking_requests as $booking)
                    <!-- Item starts -->
                        <tr class="card" id="{{$booking->id}}">
                            <td class="title-container">
                                <img style="margin-left: 5%;" src="{{$booking->image_url}}" alt="">
                                <div class="title">
                                    <h4><a href="/property/{{$booking->property_id}}" target="_blank">{{$booking->title}}</a></h4>
                                    <div><b>Traveler</b><a href="{{BASE_URL}}owner-profile/{{$booking->traveller_id}}"> {{$booking->traveller_name}} </a></div>
                                    <div><b>Check-in</b> {{$booking->start_date}}</div>
                                    <div><b>Check-out</b> {{$booking->end_date}}</div>
                                    <div><b>Booking ID</b><a href="{{BASE_URL}}owner/single-booking/{{$booking->booking_id}}"> {{$booking->booking_id}} </a></div>
                                </div>
                            </td>
                            <td class="expire-date">
                                <span>
                                    {{$booking->bookStatus}}
                                </span>
                            </td>
                            <td colspan="2" class="action" style="width: 1%">
                                <button type="button" class="button" style="min-width: 170px;" onclick="document.location.href='{{BASE_URL}}owner/single-booking/{{$booking->booking_id}}';">
                                    View Request
                                </button>
                                {{--                                @if($booking->status == 5 || $booking->status == 6)--}}
                                {{--                                    <button class="button" onclick="document.location.href='{{BASE_URL}}property_ratings/{{$booking->booking_id}}';" style="min-width: 170px;">--}}
                                {{--                                        Rate Traveller--}}
                                {{--                                    </button><br><br><br>--}}
                                {{--                                @endif--}}
                                {{--                                @if(date('m-d-Y',strtotime($booking->end_date)) == date('m-d-Y') && $booking->status == 3 && $booking->payment_done == "1")--}}
                                {{--                                    <button class="button" id="reservation_completed" onclick="reservation_completed('{{$booking->booking_id}}')" style="min-width: 170px;">--}}
                                {{--                                        Reservation Completed--}}
                                {{--                                    </button><br>--}}
                                {{--                                @endif--}}
                            </td>
                        </tr>
                        <!-- Item ends -->

                    @endforeach
                </table>

                @if(count($booking_requests) == 0)
                    <center>No Booking Requests found</center>
                @endif

                <table class="manage-table responsive-table" style="border-spacing: 0 1em;" id="booking_table">
                    <tr>
                        <th><i class="fa fa-file-text"></i> My Bookings</th>
                        <th class="expire-date"> Status </th>
                        <th colspan="2">Action</th>
                    </tr>
                @foreach($my_bookings as $booking)
                    <!-- Item starts -->
                        <tr class="card" id="{{$booking->id}}">
                            <td class="title-container">
                                <img style="margin-left: 5%;" src="{{$booking->image_url}}" alt="">
                                <div class="title">
                                    <h4><a href="/property/{{$booking->property_id}}" target="_blank">{{$booking->title}}</a></h4>
                                    <div><b>Traveler</b><a href="{{BASE_URL}}owner-profile/{{$booking->traveller_id}}"> {{$booking->traveller_name}} </a></div>
                                    <div><b>Check-in</b> {{$booking->start_date}}</div>
                                    <div><b>Check-out</b> {{$booking->end_date}}</div>
                                    <div><b>Booking ID</b><a href="{{BASE_URL}}owner/single-booking/{{$booking->booking_id}}"> {{$booking->booking_id}} </a></div>
                                </div>
                            </td>
                            <td class="expire-date">
                                <span>
                                    {{$booking->bookStatus}}
                                </span>
                                @if($booking->bookStatus == 'Declined') <span style="font-size: 12px; color: #e78016">{{$booking->deny_reason ?? ''}}</span> @endif
                            </td>
                            <td colspan="2" class="action" style="width: 1%">
                                <button type="button" class="button" style="min-width: 170px;" onclick="document.location.href='{{BASE_URL}}owner/single-booking/{{$booking->booking_id}}';">
                                    View Request
                                </button>
                                {{--                                @if($booking->status == 5 || $booking->status == 6)--}}
                                {{--                                    <button class="button" onclick="document.location.href='{{BASE_URL}}property_ratings/{{$booking->booking_id}}';" style="min-width: 170px;">--}}
                                {{--                                        Rate Traveller--}}
                                {{--                                    </button><br><br><br>--}}
                                {{--                                @endif--}}
                                {{--                                @if(date('m-d-Y',strtotime($booking->end_date)) == date('m-d-Y') && $booking->status == 3 && $booking->payment_done == "1")--}}
                                {{--                                    <button class="button" id="reservation_completed" onclick="reservation_completed('{{$booking->booking_id}}')" style="min-width: 170px;">--}}
                                {{--                                        Reservation Completed--}}
                                {{--                                    </button><br>--}}
                                {{--                                @endif--}}
                            </td>
                        </tr>
                        <!-- Item ends -->

                    @endforeach
                </table>
                @if(count($my_bookings) == 0)
                    <center>No Booking Requests found</center>
                @endif
                {{-- <button style="float: right;margin-bottom: 40px;" onclick="location.href='{{BASE_URL}}owner/create-booking';" class="margin-top-40 button border">Create Own Booking</button> --}}
            </div>

        </div>
    </div>
    @include('includes.scripts')
    <script type="text/javascript">
        // Date Range Picker
        $('input[id="search_booking_range_picker"]').daterangepicker({
            autoUpdateInput: false,
            autoApply: true,
        });

        $('input[id="search_booking_range_picker"]').keydown(function (e) {
            e.preventDefault();
            return false;
        });

        $('input[id="search_booking_range_picker"]').on('apply.daterangepicker', function(ev, picker) {
            $('input[name="from_date"]').val(`${picker.startDate.format('MM/DD/YYYY')} - ${picker.endDate.format('MM/DD/YYYY')}`);
            // $('input[name="to_date"]').val(picker.endDate.format('MM/DD/YYYY'));
        });
        var date_elem =  $('#search_booking_range_picker[name="from_date"]');

        $(document).ready(function () {
            const urlParams = new URLSearchParams(window.location.search);
            const start_date = urlParams.get('start_date');
            const end_date = urlParams.get('end_date');
            if(start_date && end_date) {
                date_elem.val(`${start_date} - ${end_date}`);
            }
        })
        function reservation_completed(id){
            var r = confirm("Are you sure this reservation is completed?");
            if (r == true) {
                var url = window.location.protocol + "//" + window.location.host + "/make-reservation-complete?booking_id="+id;
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        var url = '{{BASE_URL}}property_ratings/'+id;
                        window.location = url;
                    }
                });
            }
        }

        $("#search").click(function(){
            var date_range = date_elem.val();
            if(!date_range) {
                date_elem.css({'border-width': '2px', 'border-color': 'red'});
                return false;
            }else{
                date_range = date_range.split(' - ');
                date_elem.css('border','solid 2px grey');
                var url = window.location.protocol + "//" + window.location.host +'/owner/my-bookings?start_date='+date_range[0]+"&end_date="+date_range[1];
                window.location = url;
            }
        });
    </script>
@endsection
