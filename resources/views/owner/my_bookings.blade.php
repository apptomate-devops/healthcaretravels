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
.close {
    float: right;
    font-size: 21px;
    font-weight: 700;
    line-height: 1;
    color: #f70606 !important;
    text-shadow: 0 1px 0 #fff;
    filter: alpha(opacity=20);
    opacity: 2 !important;
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
                <table class="manage-table responsive-table" style="border-spacing: 0 1em;" id="booking_table">
                     <tr>
                        <td><input type="text"  name="from_date" placeholder="Start Date" value="" autocomplete="off" id="start_date" /></td>
                        <td colspan="2"><input name="to_date"  type="text"  placeholder="End Date" value="" autocomplete="off" id="end_date" /></td>
                        <td  ><button class="button" id="search" >Search</button></td>
                    </tr>
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
                                <span>Request by : <a href="{{BASE_URL}}owner-profile/{{$booking->traveller_id}}">{{$booking->traveller_name}}</a> </span>
                                <span>From : {{date('m-d-Y',strtotime($booking->start_date))}}</span>
                                <span>To : {{date('m-d-Y',strtotime($booking->end_date))}}</span>
                                <span>Booking ID : <a href="{{BASE_URL}}owner/single-booking/{{$booking->booking_id}}">{{$booking->booking_id}}</a></span>
                            </div>
                        </td>
                        <td class="expire-date" style="width: 150px;">
                            @if($booking->payment_done == "1")
                                <p><mark style="color: #FFFF;background-color: #e78016;" >Payment Done</mark></p>@else<p><mark style="color: #FFFF;background-color: #0983b8;" >Not Paid</mark></p>
                            @endif
                        </td>
                        <td colspan="2" class="action" style="">
                            <span>
                                @if($booking->status == 3 )
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
                                View Request
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
        $("#start_date").datepicker({
            autoclose: true
        });
        $("#start_date").change(function(){
            var fDate = $("#start_date").val();
            $("#end_date").datepicker('remove');
            $("#end_date").datepicker({
                startDate: fDate,
                autoclose: true
            });
        });
        $("#search").click(function(){
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            if(!start_date){
                $('#start_date').css('border','solid 2px red');
                return false;
            }else if(!end_date){
                $('#end_date').css('border','solid 2px red');
                $('#start_date').css('border','solid 2px grey');
                return false;
            }else{
                $('#start_date').css('border','solid 2px grey');
                $('#end_date').css('border','solid 2px grey');
                var url = window.location.protocol + "//" + window.location.host +'/owner/bookings?start_date='+start_date+"&end_date="+end_date;
                 window.location = url;
            }
        });
    </script>
@endsection
