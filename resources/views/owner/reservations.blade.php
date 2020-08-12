@extends('layout.master')
@section('title')
{{APP_BASE_NAME}} | Owner Account | My Bookings page
@endsection
@section('main_content')


<style>
.card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width: 40%;
    background-color: #f2f2f2;
}

.card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.container {
    padding: 2px 16px;
}

td {
    padding-top: .5em;
    padding-bottom: .5em;
}

ul.my-account-nav li a {
    font-size: 14px;
    line-height: 34px;
    color: black;
}
li.sub-nav-title {
    font-size: 16px;
}

</style>


    <div class="container" style="margin-top: 35px;">
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
                <table class="manage-table responsive-table" style="border-spacing: 0 1em;">

                    <tr>
                        <th><i class="fa fa-file-text"></i> Your Trips</th>
                        <th class="expire-date">{{-- <i class="fa fa-calendar"></i> Status --}} </th>
                        <th></th>
                    </tr> 

                @foreach($bookings as $booking)
                    <!-- Item starts -->
                        <tr class="card">

                            <td class="title-container">
                                <img style="margin-left: 5%;" src="{{$booking->image_url}}" alt="">
                                <div class="title">
                                    <h4><a href="#">{{$booking->title}}</a></h4>
                                    <span>Owner : <a href="{{url('/')}}/owner-profile/{{$booking->owner_id}}">{{$booking->owner_name}}</a> </span>
                                    <span>From : {{$booking->start_date}}</span>
                                    <span>To : {{$booking->end_date}}</span>
                                    <span>Booking ID : <a href="{{BASE_URL}}owner/reservations/{{$booking->booking_id}}"> {{$booking->booking_id}} </a></span>
                                    <span>Payment Status : 
                                        <a href="#">
                                        @if($booking->payment_done == 0)
                                        Not paid
                                        @endif

                                        @if($booking->payment_done == 1)
                                        Paid
                                        @endif

                                        
                                        </a>
                                    </span>
                                </div>
                            </td>

                            <td class="expire-date" style="width: 150px;">
                                {{-- @if($booking->bookStatus == 1)
                                <p><mark style="color: #FFFF;" >Waiting for Owner</mark></p>
                                @elseif($booking->bookStatus == 2)
                                 <p><mark style="color: #FFFF;" >Approved</mark></p>
                                @elseif($booking->bookStatus == 3)
                                <p><mark style="color: #FFFF;" >Completed</mark></p>
                                @elseif($booking->bookStatus == 4)
                                 <p><mark style="color: #FFFF;" >Cancelled</mark></p>
                               
                                @endif

                                @if($booking->payment_done == 0)
                                    <p><mark style="color: #FFFF;background-color: red;" >Not fully paid</mark></p>
                                @else
                                    <p><mark style="color: #FFFF;" >Payment Complete</mark></p>
                                @endif --}}
                            </td>
                            <td class="action" style="">
                                
                                @if($booking->bookStatus == 1 || $booking->bookStatus == 2)
                                    <button class="button" href="#" style="min-width: 200px;">
                                        Waiting for confirmation 
                                    </button>
                                @endif

                                @if($booking->bookStatus == 3)
                                    <button class="button" onclick="document.location.href='{{BASE_URL}}owner/reservations/{{$booking->booking_id}}';" style="min-width: 200px;">
                                        View Invoice
                                    </button>
                                @endif

                                @if($booking->bookStatus == 4)
                                    <button class="button" onclick="document.location.href='{{BASE_URL}}owner/reservations/{{$booking->booking_id}}';" style="min-width: 200px;">
                                        Booking Cancelled by Owner
                                    </button>
                                @endif

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
                <!-- <button style="float: right;margin-bottom: 40px;" onclick="location.href='{{BASE_URL}}';" class="margin-top-40 button border">Find Homes</button> -->
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
                //alert(window.location.hostname);
            }

        }
    </script>
@endsection