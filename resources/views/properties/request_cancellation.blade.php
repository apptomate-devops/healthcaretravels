@extends('layout.master')
@section('title',$property->title . ' | ' . APP_BASE_NAME)
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
                    <h3>We have canceled your request for this booking</h3>
                    <div>Status: Cancellation In Progress</div>
                @elseif($booking->cancellation_requested == 2)
                    <h3>We have canceled your request for this booking</h3>
                    <div>Status: Cancellation Completed</div>
                @elseif ($booking->cancellation_requested == 1)
                    <h3>You have requested to cancel this booking</h3>
                    <div>We’ll keep you updated on the status of your request. If we need more information, we’ll reach out to you within 48 hours.</div>
                @else
                    <form action="{{url('/')}}/submit_cancellation_request" method="post" id="cancel_request_form" name="cancel_request_form" onsubmit="return validate_submit()" autocomplete="off" onkeydown="return event.key != 'Enter';">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="client_id" value="{{CLIENT_ID}}">
                        <input type="hidden" name="booking_id" value="{{$booking->booking_id}}">
                        <div class="row">
                            <h2>{{$title}}</h2>
                            <div>{{$subTitle}}</div>
                            @if(!$is_owner)
                                <div>Cancellation Policy: <a href="{{BASE_URL}}cancellationpolicy" class="cancel-policy-link" target="_blank">{{$booking->cancellation_policy ?? $property->cancellation_policy}}</a></div>
                            @endif
                        </div>
                        <div class="row margin-top-30">
                            <div class="col-md-6">
                                <div>
                                    <label for="cancellation_reason" style="margin-top: 10px;">Select a reason:</label>
                                    <select class="chosen-select validate" id="cancellation_reason" name="cancellation_reason">
                                        <option selected disabled>Select a reason</option>
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
                                <h3 class="margin-top-40">Has the traveler checked into this property?</h3>
                                <div class="checkboxes in-row">
                                    <input id="checked_in_yes" name="checked_in" type="checkbox" value="1">
                                    <label for="checked_in_yes">Yes</label>

                                    <input id="checked_in_no" name="checked_in" type="checkbox" value="0">
                                    <label for="checked_in_no">No</label>
                                </div>
                                <div class="error-text" id="checked_box_error" style="display: none;">This field is required</div>
                                <div class="margin-top-40">
                                    <label class="checkbox-container">
                                        I agree and understand that I may be charged a penalty fee for cancelling an existing booking that I have approved based on <a href="{{URL('/')}}/cancellationpolicy">HCT Cancellation Policy</a>.
                                        <input type="checkbox" required name="cancellation_policy" id="cancellation_policy">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <button class="button margin-top-10" type="submit" id="button" disabled>Submit Request</button>
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
        $('#cancellation_policy').change(function (e) {
            e.stopPropagation();
            e.preventDefault();
            if($(this).is(":checked")) {
                $('#button').attr('disabled',false);
            } else {
                $('#button').attr('disabled',true);
            }
            return !$(this).is(":checked");
        });
        function validate_submit() {
            var isCheckedIn = $('input[name="checked_in"]').is(':checked');
            if(!isCheckedIn) {
                $('#checked_box_error').show();
                return false;
            }
            $('#checked_box_error').hide();
            return true;
        }
    </script>
@endsection
