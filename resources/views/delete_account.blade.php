@section('title')
    Delete Account | {{APP_BASE_NAME}}
@endsection
@extends('layout.master')
@section('main_content')

    <div class="container" style="margin-top: 35px;">
        <div class="content_wrapper  row ">

            <div id="post" class="row  post-2328 page type-page status-publish hentry">
                <div class="col-md-12 breadcrumb_container"><ol class="breadcrumb">
                        <li><a href="{{url('/')}}">Home</a></li><li class="active">Delete My Account</li></ol></div>    <div class=" col-md-12 ">



                    <div class="loader-inner ball-pulse" id="internal-loader">
                        <div class="double-bounce1"></div>
                        <div class="double-bounce2"></div>
                    </div>

                    <div id="listing_ajax_container">

                    </div>
                    <div class="single-content">
                        <h1 class="entry-title single-title">Delete My Account</h1>


                        <ul>
                            <li>Your Account Information will be deleted permanently.</li>
                            <li>Your property and booking details will be deleted permanently.
                            <li>We will verify your identity for security purposes before accepting the deletion request.</li>
                            <li>You can’t reactivate, recover any data, or regain access to your account once it’s deleted.</li>
                            <li>Any reservations/bookings you currently have as a Property Owner, Co-Host or a Traveler will automatically be canceled.</li>
                            <li>Instead of deleting certain data, we may de-identify or disassociate it, such that it no longer appears associated with you. Some information, such as your reviews and messages you sent to other users, may still be visible to others.</li>
                            <li>We’ll start working on your deletion request after we receive it, but some of your data may remain in our systems if we are legally required, or while we are legally permitted, to retain it.</li>
                        </ul>


                    </div>

                    <!-- #comments start-->

                    <!-- end comments -->

                </div>

                <!-- begin sidebar -->
                <div class="clearfix visible-xs"></div>
                <!-- end sidebar --></div>

        </div><br>
        <form method="post" action="{{url('/')}}/account_delete_process">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="user_id" value="{{Session::get('user_id')}}">
            <input type="hidden" name="role_id" value="{{Session::get('role_id')}}">

            @if(Session::get('user_id'))
                <div class="checkboxes">
                    <input id="terms_accept" type="checkbox" name="terms_accept" required>
                    <label for="terms_accept"> I agree to the above Terms & Conditions </label>

                </div> <br><br>

                <p class="form-row" style="margin-top: 10px;">
                    <input type="submit" id="reg_button" class="button border fw margin-top-10" style="line-height: inherit;" name="register" value="Delete My Account" />
                </p>
            @endif
        </form>

    </div>

@endsection
