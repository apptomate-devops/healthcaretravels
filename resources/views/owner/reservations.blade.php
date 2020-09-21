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
                <div style="overflow-x:auto;">
                    <table class="manage-table responsive-table">
                        <tr>
                            <th><i class="fa fa-file-text"></i> Your Trips</th>
                            <th class="expire-date"> Status </th>
                            <th colspan="2">Action</th>
                        </tr>

                    @foreach($bookings as $booking)
                        <!-- Item starts -->
                            <tr class="card">

                                <td class="title-container">
                                    <img style="margin-left: 5%;" src="{{$booking->image_url}}" alt="">
                                    <div class="title">
                                        <h4><a href="/property/{{$booking->property_id}}" target="_blank">{{$booking->title}}</a></h4>
                                        <div><b>Owner</b><a href="owner-profile/{{$booking->owner_id}}"> {{$booking->owner_name}} </a></div>
                                        <div><b>Check-in</b> {{$booking->start_date}}</div>
                                        <div><b>Check-out</b> {{$booking->end_date}}</div>
                                        <div><b>Booking ID</b><a href="owner/reservations/{{$booking->booking_id}}"> {{$booking->booking_id}} </a></div>
                                    </div>
                                </td>
                                <td class="expire-date">
                                <span>
                                    {{Helper::get_traveller_status($booking->bookStatus, $booking->start_date, $booking->end_date)}}
                                </span>
                                </td>
                                <td colspan="2" class="action" style="width: 1%">
                                    <button class="button" onclick="document.location.href='{{BASE_URL}}owner/reservations/{{$booking->booking_id}}';" style="min-width: 200px;">
                                        View Details
                                    </button>
                                    {{--                                    @if($booking->bookStatus == 5 || $booking->bookStatus == 6)--}}
                                    {{--                                        <button class="button" onclick="document.location.href='{{BASE_URL}}traveller_ratings/{{$booking->booking_id}}';" style="min-width: 170px;">--}}
                                    {{--                                            Rate your stay--}}
                                    {{--                                        </button><br><br><br>--}}
                                    {{--                                    @endif--}}
                                    {{--                                    @if($booking->bookStatus == 6)--}}
                                    {{--                                        <button class="button" style="min-width: 170px;">--}}
                                    {{--                                            Owner rated your Stay--}}
                                    {{--                                        </button><br><br><br>--}}
                                    {{--                                    @endif--}}

                                    {{--                                    @if($booking->bookStatus == 7)--}}
                                    {{--                                        <button class="button" style="min-width: 170px;">--}}
                                    {{--                                            You rated this booking--}}
                                    {{--                                        </button><br><br><br>--}}
                                    {{--                                    @endif--}}


                                    @if($booking->bookStatus < 2)
                                        <div class="link" onclick="cancel_booking('{{$booking->booking_id}}')" style="margin-top: 10px; text-align: center">
                                            Cancel booking
                                        </div>
                                    @endif

                                </td>
                            </tr>
                            <!-- Item ends -->
                        @endforeach


                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('custom_script')
    <script type="text/javascript">
        function cancel_booking(id)
        {
            var r = confirm("Are you sure to cancel Booking..");
            if (r == true) {
                var url = '{{BASE_URL}}cancel-booking/'+id;
                $.ajax({
                    "type": "get",
                    "url" : url,
                    success: function(data) {
                        if(data.status=="SUCCESS"){
                            window.location.reload();
                        } else {
                            console.log('Error Updating cancel status for booking');
                        }
                    },
                    error: function (e) {
                        console.log('Error Updating cancel status for booking');
                    }
                });
            }
        }
    </script>
@endsection
