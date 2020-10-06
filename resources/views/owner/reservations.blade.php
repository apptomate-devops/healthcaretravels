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

                    @if(count($bookings) > 0)
                        @foreach($bookings as $booking)
                            <!-- Item starts -->
                                <tr class="card">

                                    <td class="title-container">
                                        <img style="margin-left: 5%;" src="{{$booking->image_url}}" alt="">
                                        <div class="title">
                                            <h4><a href="/property/{{$booking->property_id}}" target="_blank">{{$booking->title}}</a></h4>
                                            <div><b>Owner</b><a href="/owner-profile/{{$booking->owner_id}}"> {{$booking->owner_name}} </a></div>
                                            <div><b>Check-in</b> {{$booking->start_date}}</div>
                                            <div><b>Check-out</b> {{$booking->end_date}}</div>
                                            <div><b>Booking ID</b><a href="/owner/reservations/{{$booking->booking_id}}"> {{$booking->booking_id}} </a></div>
                                        </div>
                                    </td>
                                    <td class="expire-date">
                                <span>
                                    {{Helper::get_traveller_status($booking->bookStatus, $booking->start_date, $booking->end_date)}}
                                    @if($booking->bookStatus == 4) <span style="font-size: 12px; color: #e78016">{{$booking->deny_reason ?? ''}}</span> @endif
                                </span>
                                    </td>
                                    <td colspan="2" class="action" style="width: 1%">
                                        <button class="button" onclick="document.location.href='{{BASE_URL}}owner/reservations/{{$booking->booking_id}}';" style="min-width: 200px;">
                                            View Details
                                        </button>
                                        @if($booking->bookStatus == 1)
                                            <div class="link" onclick="cancel_booking('{{$booking->booking_id}}')" style="margin-top: 10px; text-align: center">
                                                Cancel booking
                                            </div>
                                        @endif

                                    </td>
                                </tr>
                                <!-- Item ends -->
                            @endforeach
                        @else
                            <td>No booking requested</td>
                        @endif


                    </table>
                </div>

                @if(count($incomplete_bookings) > 0)
                    <div style="overflow-x:auto;">
                        <table class="manage-table responsive-table">
                            <tr>
                                <th><i class="fa fa-file-text"></i>Incomplete Bookings</th>
                                <th colspan="2">Action</th>
                            </tr>

                        @foreach($incomplete_bookings as $booking)
                            <!-- Item starts -->
                                <tr class="card">

                                    <td class="title-container">
                                        <img style="margin-left: 5%;" src="{{$booking->image_url}}" alt="">
                                        <div class="title">
                                            <h4><a href="/property/{{$booking->property_id}}" target="_blank">{{$booking->title}}</a></h4>
                                            <div><b>Owner</b><a href="/owner-profile/{{$booking->owner_id}}"> {{$booking->owner_name}} </a></div>
                                            <div><b>Check-in</b> {{$booking->start_date}}</div>
                                            <div><b>Check-out</b> {{$booking->end_date}}</div>
                                            <div><b>Booking ID</b><a href="/owner/reservations/{{$booking->booking_id}}"> {{$booking->booking_id}} </a></div>
                                        </div>
                                    </td>
                                    <td colspan="2" class="action" style="width: 1%">
                                        <button class="button" onclick="document.location.href='{{BASE_URL}}booking_detail/{{$booking->booking_id}}';" style="min-width: 200px;">
                                            Complete Booking
                                        </button>
                                        <div class="link" onclick="delete_booking('{{$booking->booking_id}}')" style="margin-top: 10px; text-align: center">
                                            Delete booking
                                        </div>
                                    </td>
                                </tr>
                                <!-- Item ends -->
                            @endforeach


                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection

@section('custom_script')
    <script type="text/javascript">
        function cancel_booking(id) {
            var r = confirm("Are you sure you want to cancel?");
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
        function delete_booking(id) {
            var url = '{{BASE_URL}}delete-booking/'+id;
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
    </script>
@endsection
