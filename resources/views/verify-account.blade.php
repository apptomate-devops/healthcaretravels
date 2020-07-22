@extends('layout.master')
@section('title')
    {{APP_BASE_NAME}} Owner Profile
@endsection

@section('main_content')

    <style>

        .verify-traveler .info-text {
            color: #e78016;
        }
        .info-text.text-error {
            color: red;
        }

        ul.my-account-nav li a {
            font-size: 14px;
            line-height: 34px;
            color: black;
        }
        li.sub-nav-title {
            font-size: 16px;
        }
        .approved{
            background-color: #119E67;
            color: white;
        }
        .unapproved{
            background-color: red;
            color: white;
        }
        .info-text {
            color: red;
            font-size: 14px;
            margin: 0;
        }
    </style>
    <div class="container verify-traveler" style="margin-top: 35px;">
        @if(Session::has('success'))
            <div class="alert alert-success">
                <h4>{{ Session::get('success') }}</h4>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">
                <h4>{{ Session::get('error') }}</h4>
            </div>
        @endif
        @if (count($errors) > 0)
            <div class = "alert alert-danger">
                <h4>Something went wrong. Please review the form and correct the required fields.</h4>
            </div>
        @endif
        <div class="row">

            <!-- Widget -->
            <div class="col-md-4">
                <div class="sidebar left">

                    <div class="my-account-nav-container">

                        @include('owner.menu')

                    </div>

                </div>
            </div>

            @if($user->is_verified == 1)
                <b class="info-text" style="color: forestgreen; font-size: 18px;">Your account has been verified.</b>
            @elseif($user->is_submitted_documents == 1)
                <b class="info-text" style="font-size: 18px;">Your verification information has been submitted. Please allow up to 24 hours for approval.</b>
            @elseif($user->denied_count >= 3)
                <b class="info-text" style="color: red; font-size: 18px;">We were unable to verify your account and cannot grant your access to our features. Please contact support for more information.</b>
            @else
                <div class="col-md-8">
                    <div class="row">
                        <form name="doc" method="POST" action="{{url('/')}}/upload-document" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            <div class="col-md-12 my-profile" style="padding-top: 15px;">
                                @if($user->role_id == 1)


                                    {{-----  Owner Verification  ----- START ---------------}}


                                    <div class="info-text">
                                        You must complete 3 of 5 verification methods in order to submit your profile for verification.
                                        Please submit within seven days to be granted full access to all of Health Care Travels' features.
                                    </div>
                                    @if ($user->is_verified == -1)
                                        <div class="info-text text-error padding-top-10">
                                            We were unable to verify your account. Please resubmit your information or contact support for more information. Attempts remaining: {{3 - $user->denied_count}}
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <label>Government ID </label>
                                        <input type="file" name="government_id" id="government_id" class="form-control"  />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Driver's license </label>
                                        <input type="file" name="driver_license_id" id="driver_license_id" class="form-control" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Property Tax Document</label>
                                        <input type="file" name="property_tax_document" id="property_tax_document" class="form-control"  />
                                        <div class="info-text">With proof of name and listing address</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Utility Bill</label>
                                        <input type="file" name="utility_bill" id="utility_bill" class="form-control"  />
                                        <div class="info-text">With proof of name and listing address</div>
                                    </div>


                                    {{-----  Owner Verification  ----- END ---------------}}


                                @elseif($user->role_id==2)


                                    {{-----  Agency Verification -----  START ---------------}}


                                    <div class="info-text">
                                        You must complete 3 of 7 verification methods in order to submit your profile for verification.
                                        Please submit within seven days to be granted full access to all of Health Care Travels' features.
                                    </div>
                                    @if ($user->is_verified == -1)
                                        <div class="info-text text-error padding-top-10">
                                            We were unable to verify your account. Please resubmit your information or contact support for more information. Attempts remaining: {{3 - $user->denied_count}}
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <label>Traveler's Contract</label>
                                        <input type="file" name="traveler_contract_id" id="traveler_contract_id" class="form-control"  />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Work Badge Picture </label>
                                        <input type="file" name="work_badge_id" id="work_badge_id" class="form-control"  />
                                    </div>
                                    <div class="col-md-12" style="margin-top: 40px;">
                                        <div class="card col-md-12" style="padding: 15px;">
                                            <h4>Agency Details</h4>

                                            <label>Proof of Employment on agency website </label>
                                            <input value="@if($user->agency_website == '0' || $user->agency_website == null)@else{{$user->agency_website}}@endif" type="text" placeholder="Agency Website" name="agency_website" class="form-control" />
                                            <p class="info-text">If your agency has a page with your name on it, share it here.</p>

                                            <label>Agency HR Business Email</label>
                                            <input value="@if($user->agency_hr_email == '0' || $user->agency_hr_email == null)@else{{$user->agency_hr_email}}@endif" type="text" placeholder="Agency HR Email Address" name="agency_hr_email" class="form-control" />

                                            <label>Agency HR Direct Phone Number</label>
                                            <input value="@if($user->agency_hr_phone == '0' || $user->agency_hr_phone == null)@else{{$user->agency_hr_phone}}@endif" type="text" placeholder="Agency HR Phone Number" name="agency_hr_phone" class="form-control" />

                                            <label>Agency Office Phone Number</label>
                                            <input value="@if($user->agency_office_number == '0' || $user->agency_office_number == null)@else{{$user->agency_office_number}}@endif" type="text" placeholder="Agency Office Number" name="agency_office_number" class="form-control" />
                                            <p class="info-text">Provide your agency's main office phone number.</p>

                                        </div>
                                    </div>


                                    {{-----  Agency Verification ----- END ---------------}}


                                @else


                                    {{----- Traveler or RV Traveler Verification ----- START ---------------}}


                                    <div class="info-text">
                                        You must complete 3 of 6 verification methods in order to submit your profile for verification.
                                        Please submit within seven days to be granted full access to all of Health Care Travels' features.
                                    </div>
                                    @if ($user->is_verified == -1)
                                        <div class="info-text text-error padding-top-10">
                                            We were unable to verify your account. Please resubmit your information or contact support for more information. Attempts remaining: {{3 - $user->denied_count}}
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <label>Work Badge Picture </label>
                                        <input type="file" name="work_badge_id" id="work_badge_id" class="form-control"  />
                                        @if(isset($WORK_BADGE_ID->document_type))
                                            <a href="{{$WORK_BADGE_ID->document_url}}" target="_blank" style="float: right;">view</a>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label>Travel Contract </label>
                                        <input type="file" name="travel_contract_id" id="travel_contract_id" class="form-control"  />
                                        @if(isset($TRAVEL_CONTRACT_ID->document_type))
                                            <a href="{{$TRAVEL_CONTRACT_ID->document_url}}" target="_blank" style="float: right;">view</a>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label>Government ID </label>
                                        <input type="file" name="government_id" id="government_id" class="form-control"  />
                                        @if(isset($GOVERNMENT_ID->document_type))
                                            <a href="{{$GOVERNMENT_ID->document_url}}" target="_blank" style="float: right;">view</a>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label>Driver's license </label>
                                        <input type="file" name="driver_license_id" id="driver_license_id" class="form-control" />
                                        @if(isset($DRIVER_LICENSE_ID->document_type))
                                            <a href="{{$DRIVER_LICENSE_ID->document_url}}" target="_blank" style="float: right;">view</a>
                                        @endif
                                    </div>


                                    {{------- Traveler or RV Traveler Verification ----- END ---------------}}



                                @endif


                                <div class="col-md-12" style="margin-top: 40px;">
                                    <div class="card col-md-12" style="padding: 15px;">
                                        <h4>Social Media Account link</h4>

                                        <label>Facebook</label>
                                        <input value="@if($user->facebook_url == '0' || $user->facebook_url == null)@else{{$user->facebook_url}}@endif" type="text" placeholder="Enter you facebook url" name="facebook" class="form-control" />

                                        <label>LinkedIn</label>
                                        <input value="@if($user->linkedin_url == '0' || $user->linkedin_url == null)@else{{$user->linkedin_url}}@endif" type="text" placeholder="Enter you LinkedIn url" name="linkedin" class="form-control" />

                                        <label>Instagram</label>
                                        <input value="@if($user->instagram_url == '0' || $user->instagram_url == null)@else{{$user->instagram_url}}@endif" type="text" placeholder="Enter you Instagram url" name="instagram" class="form-control" />

                                    </div>
                                </div>


                                @if($user->role_id == 0 || $user->role_id == 3)
                                    <div class="col-md-12" style="margin-top: 20px;">
                                        <div class="card col-md-12" style="padding: 15px;">
                                            <h4>Certified Traveler License</h4>
                                            <input value="@if($user->traveler_license == '0' || $user->traveler_license == null)@else{{$user->traveler_license}}@endif" type="text" placeholder="State/Website of Licensure" name="traveler_license" id="traveler_license" class="form-control" />
                                        </div>
                                    </div>
                                @endif



                                @if($user->role_id == 1)
                                    <div class="col-md-12" style="margin-top: 40px;">
                                        <div class="card col-md-12" style="padding: 15px;">
                                            <h4>Existing Listing URL</h4>

                                            <label>Airbnb</label>
                                            <input value="@if($user->airbnb_link == '0' || $user->airbnb_link == null)@else{{$user->airbnb_link}}@endif" type="text" placeholder="Airbnb URL" name="airbnb_link" class="form-control" />

                                            <label>Homeaway</label>
                                            <input value="@if($user->home_away_link == '0' || $user->home_away_link == null)@else{{$user->home_away_link}}@endif" type="text" placeholder="Homeaway URL" name="home_away_link" class="form-control" />

                                            <label>VRBO</label>
                                            <input value="@if($user->vrbo_link == '0' || $user->vrbo_link == null)@else{{$user->vrbo_link}}@endif" type="text" placeholder="VRBO URL" name="vrbo_link" class="form-control" />

                                        </div>
                                    </div>
                                @endif



                                <button style="margin-top:20px;margin-bottom:20px;float:right;" type="submit" disabled class="button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            <script>
                $(function() {
                    $(':input').on('input', function() {
                        const ignore_fields = ['_token'];
                        let completed_inputs = $(':input').filter(function() {

                            if(!this.value || ignore_fields.includes(this.name)) { return false; }
                            let input_value = this.value;
                            let regex = /.*/s;
                            if(this.name === 'facebook') {
                                regex = /(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/;
                            }
                            if(this.name === 'linkedin') {
                                regex = /http(s)?:\/\/([\w]+\.)?linkedin\.com\/in\/[A-z0-9_-]+\/?/;
                            }
                            if(this.name === 'instagram') {
                                regex = /(https?)?:?(www)?instagram\.com\/[a-z].{3}/;
                            }
                            if(['agency_hr_phone', 'agency_office_number'].includes(this.name)) {
                                regex = /(\+\d{1,3}[- ]?)?\d{10}$/;
                            }
                            if(this.name === 'agency_hr_email') {
                                regex = /(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                            }
                            if(['airbnb_link', 'home_away_link', 'vrbo_link', 'agency_website'].includes(this.name)) {
                                regex = /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/
                            }
                            return regex.test(input_value);
                        });
                        $(":submit").prop('disabled', completed_inputs.length < 3);
                    });
                });

            </script>
        </div>

@endsection
