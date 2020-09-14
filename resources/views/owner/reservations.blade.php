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
                            <th></th>
                        </tr>

                    @foreach($bookings as $booking)
                        <!-- Item starts -->
                            <tr class="card">

                                <td class="title-container">
                                    <img style="margin-left: 5%;" src="{{$booking->image_url}}" alt="">
                                    <div class="title">
                                        <h4><a href="/property/{{$booking->property_id}}" target="_blank">{{$booking->title}}</a></h4>
                                        <div>Booking ID : <a href="{{BASE_URL}}owner/reservations/{{$booking->booking_id}}"> {{$booking->booking_id}} </a></div>
                                        <div>Payment Status :
                                        <a href="#">
                                        @if($booking->payment_done == 0)
                                                Not paid
                                            @endif

                                            @if($booking->payment_done == 1)
                                                Paid
                                            @endif


                                        </a>
                                    </div>
                                    </div>
                                </td>
                                <td class="action text-center" style="width: 1%">
                                <span>
                                    @if($booking->bookStatus == 1 || $booking->bookStatus == 2)
                                        Waiting for confirmation
                                    @endif
                                    @if($booking->bookStatus == 3)
                                        Booking Confirmed
                                    @endif
                                    @if($booking->bookStatus == 4)
                                        Booking Cancelled by Owner
                                    @endif
                                </span>
                                    <button class="button" onclick="document.location.href='{{BASE_URL}}owner/reservations/{{$booking->booking_id}}';" style="min-width: 200px;">
                                        View Details
                                    </button>
                                    @if($booking->bookStatus == 5 || $booking->bookStatus == 6)
                                        <button class="button" onclick="document.location.href='{{BASE_URL}}traveller_ratings/{{$booking->booking_id}}';" style="min-width: 170px;">
                                            Rate your stay
                                        </button><br><br><br>
                                    @endif
                                    @if($booking->bookStatus == 6)
                                        <button class="button" style="min-width: 170px;">
                                            Owner rated your Stay
                                        </button><br><br><br>
                                    @endif

                                    @if($booking->bookStatus == 7)
                                        <button class="button" style="min-width: 170px;">
                                            You rated this booking
                                        </button><br><br><br>
                                    @endif


                                    {{-- @if($booking->bookStatus != 5)
                                    <button class="button" onclick="cancel_booking('{{$booking->booking_id}}')" style="min-width: 200px;background-color: #e78016;margin-top: 10%">
                                        Cancel booking
                                    </button>
                                    @endif --}}

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
                window.location = url;
            }
        }
    </script>
@endsection
