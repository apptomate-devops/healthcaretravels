@extends('layout.master')
@section('title')
    {{APP_BASE_NAME}} | Owner Account | My Bookings page
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
                    <input type="text" name="from_date" id="date_range_picker" placeholder="Start Date" autocomplete="off"/>
                    <input type="text" name="to_date" id="date_range_picker" placeholder="End Date" autocomplete="off"/>
                    <div class="search-container">
                        <button class="button" id="search" style="width: 120px;" >Search</button>
                        <a href="/owner/bookings" disabled>Clear Dates</a>
                    </div>
                </div>
                <table class="manage-table responsive-table" style="border-spacing: 0 1em;" id="booking_table">
                    {{--                     <tr>--}}
                    {{--                        <td><input type="text"  name="from_date" placeholder="Start Date" value="" autocomplete="off" id="start_date" /></td>--}}
                    {{--                        <td colspan="2"><input name="to_date"  type="text"  placeholder="End Date" value="" autocomplete="off" id="end_date" /></td>--}}
                    {{--                        <td  ><button class="button" id="search" >Search</button></td>--}}
                    {{--                    </tr>--}}
                    <tr>
                        <th><i class="fa fa-file-text"></i> My Bookings</th>
                        <th class="expire-date"> Status </th>
                        <th colspan="2">Action</th>
                    </tr>

                    @foreach($bookings as $booking)
                    <!-- Item starts -->
                        <tr class="card" id="{{$booking->id}}">
                            <td class="title-container">
                                <img style="margin-left: 5%;" src="{{$booking->image_url}}" alt="">
                                <div class="title">
                                    <h4><a href="{{url('/')}}/property/{{$booking->property_id}}">{{$booking->title}}</a></h4>
                                    <div>Request by : <a href="{{BASE_URL}}owner-profile/{{$booking->traveller_id}}">{{$booking->traveller_name}}</a> </div>
                                    <div>From : {{date('m-d-Y',strtotime($booking->start_date))}}</div>
                                    <div>To : {{date('m-d-Y',strtotime($booking->end_date))}}</div>
                                    <div>Booking ID : <a href="{{BASE_URL}}owner/single-booking/{{$booking->booking_id}}">{{$booking->booking_id}}</a></div>
                                </div>
                            </td>
                            <td class="expire-date">
                                <p>
                                    <mark style="color: #FFFF;background-color: #0983b8;">
                                        {{Helper::get_stay_status($booking)}}
                                    </mark>
                                </p>
                            </td>
                            <td colspan="2" class="action" style="width: 1%">
                            <span>
                                @if($booking->status == 3)
                                    Invoice Sent
                                @endif
                                @if($booking->status == 4)
                                    Request Cancelled by you
                                @endif
                                @if($booking->status == 8)
                                    Booking Cancelled by you
                                @endif
                                @if($booking->status == 6)
                                    You rated traveller
                                @endif
                                @if($booking->status == 7)
                                    Traveller rated your property
                                @endif
                            </span>
                                <button type="button" class="button" style="min-width: 170px;" onclick="document.location.href='{{BASE_URL}}owner/single-booking/{{$booking->booking_id}}';">
                                    View Details
                                </button><br><br><br>
                                @if($booking->status == 5 || $booking->status == 6)
                                    <button class="button" onclick="document.location.href='{{BASE_URL}}property_ratings/{{$booking->booking_id}}';" style="min-width: 170px;">
                                        Rate Traveller
                                    </button><br><br><br>
                                @endif
                                @if(date('m-d-Y',strtotime($booking->end_date)) == date('m-d-Y') && $booking->status == 3 && $booking->payment_done == "1")
                                    <button class="button" id="reservation_completed" onclick="reservation_completed('{{$booking->booking_id}}')" style="min-width: 170px;">
                                        Reservation Completed
                                    </button><br>
                                @endif
                            </td>
                        </tr>
                        <!-- Item ends -->

                    @endforeach


                </table>

                @if(count($bookings) == 0)
                    <center>No Bookings found</center>
                @endif
                {{-- <button style="float: right;margin-bottom: 40px;" onclick="location.href='{{BASE_URL}}owner/create-booking';" class="margin-top-40 button border">Create Own Booking</button> --}}
            </div>

        </div>
    </div>
    <script type="text/javascript">
        var start_date_elem =  $('#date_range_picker[name="from_date"]');
        var end_date_elem =  $('#date_range_picker[name="to_date"]');

        $(document).ready(function () {
            const urlParams = new URLSearchParams(window.location.search);
            const start_date = urlParams.get('start_date');
            const end_date = urlParams.get('end_date');
            start_date_elem.val(start_date);
            end_date_elem.val(end_date);
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
            var start_date =  start_date_elem.val();
            var end_date =  end_date_elem.val();

            if(!start_date || !end_date){
                start_date_elem.css({'border-width': '2px', 'border-color': start_date ? 'gray' : 'red'});
                end_date_elem.css({'border-width': '2px', 'border-color': end_date ? 'gray' : 'red'});
                return false;
            }else{
                start_date_elem.css('border','solid 2px grey');
                end_date_elem.css('border','solid 2px grey');
                var url = window.location.protocol + "//" + window.location.host +'/owner/bookings?start_date='+start_date+"&end_date="+end_date;
                window.location = url;
            }
        });
    </script>
@endsection
