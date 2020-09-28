@extends('layout.master')
@section('title',$property->title)
@section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/select-pure.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/bookings.css') }}">
    <div class="property-titlebar margin-bottom-0">
        <div class="property_details container">
            @if($errors->any())
                <div class="row alert alert-danger">
                    <h4>{{$errors->first()}}</h4>
                </div>
            @endif
            <div class="row">
                @if($booking->cancellation_requested == 3)
                    <h3>We have cancelled your request for this booking!</h3>
                    <div>Status: Cancellation In Progress</div>
                @elseif($booking->cancellation_requested == 2)
                    <h3>We have cancelled your request for this booking!</h3>
                    <div>Status: Cancellation Completed</div>
                @elseif ($booking->cancellation_requested == 1)
                    <h3>We have request for cancellation for this booking!</h3>
                    <div>Status: Cancellation Pending</div>
                @else
                    <form id="cancel_request_form" name="cancel_request_form" action="{{url('/')}}/submit_cancellation_request" method="post" autocomplete="off" >
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="client_id" value="{{CLIENT_ID}}">
                        <input type="hidden" name="booking_id" value="{{$booking->booking_id}}">
                        <div class="row">
                            <h2>{{$title}}</h2>
                            <div>{{$subTitle}}</div>
                            @if(!$is_owner)
                                <div>Cancellation Policy: <a href="{{BASE_URL}}cancellationpolicy" class="cancel-policy-link" target="_blank">{{$property->cancellation_policy}}</a></div>
                            @endif
                        </div>
                        <div class="row margin-top-30">
                            <div class="col-md-6">
                                <div>
                                    <label for="cancellation_reason" style="margin-top: 10px;">Select a reason:</label>
                                    <select class="chosen-select" id="cancellation_reason" name="cancellation_reason">
                                        {{--                                    <option value="" selected disabled>Select a reason</option>--}}
                                        @foreach($reasons as $reason)
                                            <option value="{{$reason}}" label="{{$reason}}">{{$reason}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="cancellation_explanation" style="margin-top: 10px;">Add an explanation</label>
                                    <textarea id="cancellation_explanation" name="cancellation_explanation" required></textarea>
                                </div>
                                <h3 class="margin-top-40">Has the traveler checked in to this property?</h3>
                                <div class="checkboxes in-row">
                                    <input id="checked_in_yes" name="checked_in" type="checkbox" value="1">
                                    <label for="checked_in_yes">Yes</label>

                                    <input id="checked_in_no" name="checked_in" type="checkbox" value="0" checked>
                                    <label for="checked_in_no">No</label>
                                </div>
                                <button class="button margin-top-40" type="submit">Submit Request</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <script>
        $('#checked_in_yes,#checked_in_no').change(function(){
            $("input[type=checkbox][name='checked_in']").prop('checked',false);
            $(this).prop('checked',true);
        });
    </script>
@endsection
