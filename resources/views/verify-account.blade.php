@extends('layout.master')
@section('title')
    {{APP_BASE_NAME}} Owner Profile
@endsection

@section('main_content')


    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{ URL::asset('css/profile.css') }}">

    @php
        $filtypes = ".jpg, .jpeg, .heic, .png, .pdf"
    @endphp

    <div class="container verify-account" style="margin-top: 35px;">
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
                <b class="info-text" style="font-size: 18px;">
                    Your account has been submitted for verification. Please allow up to 1 to 3 business days for your information to be reviewed.
                </b>
                <p class="info-text" style="margin-top: 15px;">You'll receive an email once your account has been reviewed or if we need more information.</p>
            @elseif($user->denied_count >= 3)
                <b class="info-text" style="color: red; font-size: 18px;">We were unable to verify your account and cannot grant your access to our features. Please contact support for more information.</b>
            @else
                @if($user->is_verified == -1)
                    <div class="denied-details">
                        <b class="info-text" style="color: red; font-size: 18px;">One or more document(s) was denied:</b>
                        @foreach ($documents as $d)
                            <br><b class="info-text" style="color: red; font-size: 18px;">{{ucfirst(str_replace("_"," ",$d->document_type))}}: {{$d->reason}}</b>
                        @endforeach

                    </div>
                @endif
                <div class="col-md-8">
                    <div class="row">
                        <form name="doc" method="POST" action="{{url('/')}}/upload-document" enctype="multipart/form-data" autocomplete="off" onkeydown="return event.key != 'Enter';">
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            <div class="col-md-12 my-profile" style="padding-top: 15px;">
                                <div class="info-text" style="margin-bottom: 20px;">
                                    You must complete at least <b>three</b> verification methods in order to submit your profile for verification. Please submit within <b>seven</b> days to be granted full access to all of Health Care Travels' features.
                                </div>
                                @if($user->role_id == 1)

                                    {{-----  Owner Verification  ----- START ---------------}}

                                    @if ($user->is_verified == -1)
                                        <div class="info-text text-error padding-top-10">
                                            We were unable to verify your account. Please resubmit your information or contact support for more information. Attempts remaining: {{3 - $user->denied_count}}
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <label>Government ID/Driver's License/Passport<span class="required">*</span></label>
                                        <input type="file" name="government_id" id="government_id" class="form-control" required accept="{{$filtypes}}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Lease Agreement</label>
                                        <div class="caption-text">If approved by your state for subleasing</div>
                                        <input type="file" name="lease_agreement" id="lease_agreement" class="form-control" accept="{{$filtypes}}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Utility Bill</label>
                                        <div class="caption-text">With proof of name and listing address</div>
                                        <input type="file" name="utility_bill" id="utility_bill" class="form-control" accept="{{$filtypes}}" />
                                    </div>


                                    {{-----  Owner Verification  ----- END ---------------}}


                                @elseif($user->role_id==2)


                                    {{-----  Agency Verification -----  START ---------------}}

                                    @if ($user->is_verified == -1)
                                        <div class="info-text text-error padding-top-10">
                                            We were unable to verify your account. Please resubmit your information or contact support for more information. Attempts remaining: {{3 - $user->denied_count}}
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <label>Government ID/Driver's License/Passport<span class="required">*</span></label>
                                        <input type="file" name="government_id" id="government_id" class="form-control" required accept="{{$filtypes}}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>A Traveler's Contract</label>
                                        <div class="caption-text" style="margin-top: 5px;">This should have your name as a contact person in the contract.</div>
                                        <input type="file" name="traveler_contract_id" id="traveler_contract_id" class="form-control" accept="{{$filtypes}}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Work Badge </label>
                                        <input type="file" name="work_badge_id" id="work_badge_id" class="form-control" accept="{{$filtypes}}" />
                                    </div>
                                    <div class="col-md-12" style="margin-top: 40px;">
                                        <div class="card col-md-12" style="padding: 15px;">
                                            <h4>Agency Details</h4>

                                            <label>Proof of Employment on agency website </label>
                                            <div class="caption-text">If your agency has a page with your name on it, share it here.</div>
                                            <input value="@if($user->agency_website == '0' || $user->agency_website == null)@else{{$user->agency_website}}@endif" type="text" placeholder="Agency Website" name="agency_website" class="form-control" />

                                            <label>Agency HR Business Email</label>
                                            <input value="@if($user->agency_hr_email == '0' || $user->agency_hr_email == null)@else{{$user->agency_hr_email}}@endif" type="text" placeholder="Agency HR Email Address" name="agency_hr_email" class="form-control" />

                                            <label>Agency HR Direct Phone Number</label>
                                            <input value="@if($user->agency_hr_phone == '0' || $user->agency_hr_phone == null)@else{{$user->agency_hr_phone}}@endif" type="text" placeholder="Agency HR Phone Number" name="agency_hr_phone" class="form-control" />

                                            <label>Direct Office Number</label>
                                            <div class="caption-text">Provide your agency's main office phone number.</div>
                                            <input value="@if($user->agency_office_number == '0' || $user->agency_office_number == null)@else{{$user->agency_office_number}}@endif" type="text" placeholder="Agency Office Number" name="agency_office_number" class="form-control" />

                                        </div>
                                    </div>


                                    {{-----  Agency Verification ----- END ---------------}}


                                @elseif($user->role_id==4)

                                    {{----- Co-Host Verification ----- START ---------------}}

                                    @if ($user->is_verified == -1)
                                        <div class="info-text text-error padding-top-10">
                                            We were unable to verify your account. Please resubmit your information or contact support for more information. Attempts remaining: {{3 - $user->denied_count}}
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <label>Government ID/Driver's License/Passport<span class="required">*</span></label>
                                        <input type="file" name="government_id" id="government_id" class="form-control" required accept="{{$filtypes}}" />
                                        {{--                                        @if(isset($GOVERNMENT_ID->document_type))--}}
                                        {{--                                            <a href="{{$GOVERNMENT_ID->document_url}}" target="_blank" style="float: right;">view</a>--}}
                                        {{--                                        @endif--}}
                                    </div>
                                    {{------- Co-Host Traveler Verification ----- END ---------------}}

                                @else


                                    {{----- Traveler or RV Traveler Verification ----- START ---------------}}

                                    @if ($user->is_verified == -1)
                                        <div class="info-text text-error padding-top-10">
                                            We were unable to verify your account. Please resubmit your information or contact support for more information. Attempts remaining: {{3 - $user->denied_count}}
                                        </div>
                                    @endif
                                    <div class="row m-0">
                                        <div class="col-md-6">
                                            <label>Government ID/Driver's License/Passport<span class="required">*</span></label>
                                            <input type="file" name="government_id" id="government_id" class="form-control" accept="{{$filtypes}}" />
                                            {{--                                        @if(isset($GOVERNMENT_ID->document_type))--}}
                                            {{--                                            <a href="{{$GOVERNMENT_ID->document_url}}" target="_blank" style="float: right;">view</a>--}}
                                            {{--                                        @endif--}}
                                        </div>
                                        <div class="col-md-6">
                                            <label>Work Badge </label>
                                            <input type="file" name="work_badge_id" id="work_badge_id" class="form-control" accept="{{$filtypes}}" />
                                            @if(isset($WORK_BADGE_ID->document_type))
                                                <a href="{{$WORK_BADGE_ID->document_url}}" target="_blank" style="float: right;">view</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Travel Contract </label>
                                        <input type="file" name="travel_contract_id" id="travel_contract_id" class="form-control" accept="{{$filtypes}}" />
                                        @if(isset($TRAVEL_CONTRACT_ID->document_type))
                                            <a href="{{$TRAVEL_CONTRACT_ID->document_url}}" target="_blank" style="float: right;">view</a>
                                        @endif
                                    </div>

                                    {{------- Traveler or RV Traveler Verification ----- END ---------------}}



                                @endif


                                @if($user->role_id == 0 || $user->role_id == 3)
                                    <div class="col-md-12" style="margin-top: 20px;">
                                        <div class="card col-md-12" style="padding: 15px;">
                                            <h4>Certified Traveler License</h4>
                                            <div class="caption-text" style="margin-bottom: 25px;">Please provide your license number and your state's licensing or certification website URL</div>
                                            <div class="col-md-6">
                                                <input value="@if($user->traveler_license == '0' || $user->traveler_license == null)@else{{$user->traveler_license}}@endif" type="text" placeholder="License/Certification Number" name="traveler_license" id="traveler_license" class="form-control" />
                                            </div>
                                            <div class="col-md-6">
                                                <input value="@if($user->website == '0' || $user->website == null)@else{{$user->website}}@endif" type="text" placeholder="State Website URL" name="website" id="website" class="form-control" />
                                                <div style="margin-top: -10px; margin-left: 5px;">
                                                    <a href="https://www.bon.texas.gov/" target="_blank" class="info-text">Ex: https://www.bon.texas.gov/</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($user->role_id == 4)
                                    <div class="col-md-12">
                                        <div class="card col-md-12" style="padding: 15px;">
                                            <h4>Property Information</h4>
                                            <div class="caption-text" style="margin-bottom: 20px;">This information is required as one of your three verification items.</div>

                                            <h4 style="margin-bottom: 20px;">1. Co-Host Agreement Form<span class="required">*</span></h4>
{{--                                            <label>Signed HCT Co-Hosting Agreement<span class="required">*</span></label>--}}
                                            <div class="caption-text">Only the HCT Standard Agreement will be accepted.</div>
                                            <input type="file" name="co-hosting_agreement_id" id="co-hosting_agreement_id" class="form-control" required accept="{{$filtypes}}" />
                                            @if(isset($COHOSTING_AGREEMENT_ID->document_type))
                                                <a href="{{$COHOSTING_AGREEMENT_ID->document_url}}" target="_blank" style="float: right;">view</a>
                                            @endif
                                            <div style="margin-top: -20px; margin-bottom: 20px;">
                                                <a href="/co-host-agreement-form.pdf" download style="text-decoration-line: underline;">Download form here</a>
                                            </div>

                                            <h4 style="margin-bottom: 20px;">2. Homeowner's Contact Information</h4>

                                            <label>First Name<span class="required">*</span></label>
                                            <input value="@if($user->homeowner_first_name == '0' || $user->homeowner_first_name == null)@else{{$user->homeowner_first_name}}@endif" type="text" placeholder="First Name" name="homeowner_first_name" id="homeowner_first_name" class="form-control" />

                                            <label>Last Name<span class="required">*</span></label>
                                            <input value="@if($user->homeowner_last_name == '0' || $user->homeowner_last_name == null)@else{{$user->homeowner_last_name}}@endif" type="text" placeholder="Last Name" name="homeowner_last_name" id="homeowner_last_name" class="form-control" />

                                            <label>Email<span class="required">*</span></label>
                                            <input value="@if($user->homeowner_email == '0' || $user->homeowner_email == null)@else{{$user->homeowner_email}}@endif" type="text" placeholder="Email" name="homeowner_email" id="homeowner_email" class="form-control" />

                                            <label>Phone Number<span class="required">*</span></label>
                                            <input value="@if($user->homeowner_phone_number == '0' || $user->homeowner_phone_number == null)@else{{$user->homeowner_phone_number}}@endif" type="text" placeholder="Phone Number" name="homeowner_phone_number" id="homeowner_phone_number" class="form-control"/>

                                        </div>
                                        <div class="card col-md-12" style="padding: 15px; margin-top: 25px;">
                                            <h4>Property Address</h4>
                                            <input value="@if($user->property_address == '0' || $user->property_address == null)@else{{$user->property_address}}@endif" type="text" placeholder="Property Address" id="property_address" name="property_address" class="form-control" @if($user->property_address) data-is-valid="true" @endif />
                                            <div class="error-text" id="property_address_error" style="display: none;">Please select a valid address from the suggestions.</div>
                                            <div id="add_apt_number_field" style="display: none;">
                                                <label for="add_apt" style="width: 100%;">Add Apartment Number:
                                                    <input type="text" class="input-text validate {{ $errors->has('address_line_2') ? 'form-error' : ''}}" value="{{Session::get('address_line_2')}}" name="address_line_2" id="address_line_2" placeholder="Apt, Unit, Suite, or Floor #" style="padding-left: 20px;" />
                                                </label>
                                                <button id="remove_add_apt_number" class="button" style="float: right; margin-bottom: 25px;" >Don't Add</button>
                                            </div>
                                            <button id="btn_add_apt_number" class="button border fw" style="width: 100%; margin-bottom: 25px;">Add an Apt or Floor #</button>
                                        </div>
                                    </div>
                                @endif

                                @if($user->role_id == 1)
                                    <div class="col-md-12" style="margin-top: 40px;">
                                        <div class="card col-md-12" style="padding: 15px; margin-bottom: 25px;">
                                            <div>
                                                <h4>Property Tax Proof URL</h4>
                                                <input value="@if($user->property_tax_url == '0' || $user->property_tax_url == null)@else{{$user->property_tax_url}}@endif" type="text" placeholder="Property Tax Proof URL" name="property_tax_url" id="property_tax_url" class="form-control" />
                                            </div>
                                            <div>
                                                <label>Property Tax Document</label>
                                                <div class="caption-text">With proof of name and listing address</div>
                                                <input type="file" name="property_tax_document" id="property_tax_document" class="form-control" accept="{{$filtypes}}" />
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($user->role_id == 1 || $user->role_id == 4)
                                    <div class="col-md-12" style="margin-top: 40px;">
                                        <div class="card col-md-12" style="padding: 15px;">
                                            <h4>Existing Listing URL</h4>

                                            <label>Airbnb</label>
                                            <input value="@if($user->airbnb_link == '0' || $user->airbnb_link == null)@else{{$user->airbnb_link}}@endif" type="text" placeholder="Airbnb URL" name="airbnb_link" class="form-control" />

                                            <label>Homeaway</label>
                                            <input value="@if($user->home_away_link == '0' || $user->home_away_link == null)@else{{$user->home_away_link}}@endif" type="text" placeholder="Homeaway URL" name="home_away_link" class="form-control" />

                                            <label>VRBO</label>
                                            <input value="@if($user->vrbo_link == '0' || $user->vrbo_link == null)@else{{$user->vrbo_link}}@endif" type="text" placeholder="VRBO URL" name="vrbo_link" class="form-control" />

                                            <label>Other</label>
                                            <input value="@if($user->other_listing_link == '0' || $user->other_listing_link == null)@else{{$user->other_listing_link}}@endif" type="text" placeholder="OTHER LISTING URL" name="other_listing_link" class="form-control" />

                                        </div>
                                    </div>
                                @endif


                                <div class="col-md-12" style="margin-top: 40px;">
                                    <div class="card col-md-12" style="padding: 15px;">
                                        <h4>Your Social Media Account Links</h4>

                                        <label>Facebook</label>
                                        <input value="@if($user->facebook_url == '0' || $user->facebook_url == null)@else{{$user->facebook_url}}@endif" type="text" placeholder="Enter your facebook url (ex: https://www.facebook.com/healthcaretravels/)" name="facebook" class="form-control" />

                                        <label>Linkedin</label>
                                        <input value="@if($user->linkedin_url == '0' || $user->linkedin_url == null)@else{{$user->linkedin_url}}@endif" type="text" placeholder="Enter your LinkedIn url (ex: https://www.linkedin.com/company/health-care-travels/)" name="linkedin" class="form-control" />

                                        <label>Instagram</label>
                                        <input value="@if($user->instagram_url == '0' || $user->instagram_url == null)@else{{$user->instagram_url}}@endif" type="text" placeholder="Enter your Instagram url (ex: https://www.instagram.com/healthcaretravels/)" name="instagram" class="form-control" />

                                    </div>
                                </div>
                                <button id="submit_documents" style="margin-top:20px;margin-bottom:20px;float:right;" type="button" disabled class="btn btn-primary" onclick="validate_submit(this)">Submit</button>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade in" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Are you sure you are ready to submit?</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            You will not be able to edit or upload more documents once they have been submitted.                                </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button id="confirmation-popup-submit" type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="submitDocumentsProgress" class="loading style-2" style="display: none;"><div class="loading-wheel"></div></div>
                </div>
            @endif

            <script>
                var validation_regex = {
                    text: /.*/s,
                    email: /(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                    facebook: /(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/,
                    linkedin: /http(s)?:\/\/([\w]+\.)?linkedin\.com\/in\/[A-z0-9_-]+\/?/,
                    instagram: /(https?)?:?(www)?instagram\.com\/[a-z].{3}/,
                    phone_number: /(\+\d{1,3}[- ]?)?\d{10}$/,
                    url: /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/,
                }

                $(function() {
                    $(document).on('click', '#confirmation-popup-submit', function (event) {
                        $("#confirmationModal").modal('hide');
                        $('#submitDocumentsProgress').show();
                    });

                    $(':input').on('input', function() {
                        const ignore_fields = ['_token'];
                        let completed_inputs = $(':input').filter(function() {

                            if(!this.value || ignore_fields.includes(this.name)) { return false; }

                            let input_value = this.value;

                            let regex = validation_regex.text;

                            if(this.name === 'facebook') {
                                regex = validation_regex.facebook;
                            }
                            else if(this.name === 'linkedin') {
                                regex = validation_regex.linkedin;
                            }
                            else if(this.name === 'instagram') {
                                regex = validation_regex.instagram;
                            }
                            else if(['agency_hr_phone', 'agency_office_number', 'homeowner_phone_number'].includes(this.name)) {
                                regex = validation_regex.phone_number;
                            }
                            else if(['agency_hr_email', 'homeowner_email'].includes(this.name)) {
                                regex = validation_regex.email;
                            }
                            else if(['airbnb_link', 'home_away_link', 'vrbo_link', 'other_listing_link', 'agency_website', 'website', 'property_tax_url'].includes(this.name)) {
                                // URL validations
                                regex = validation_regex.url;
                            }
                            return regex.test(input_value);
                        });
                        $("#submit_documents").prop('disabled', completed_inputs.length < 3);
                    });

                    $("input:file").change(function (e) {
                        const target = e.target;
                        const maxAllowedSize = 25 * 1024 * 1024;
                        if (target.files && target.files[0] && target.files[0].size > maxAllowedSize) {
                            $(this).css('border-color', '#ff0000');
                            alert('File size is too large, maximum upload size is 25MB.')
                            target.value = ''
                        } else {
                            if(target.value) {
                                $(this).css('border-color', '#ccc');
                            }
                        }
                    })
                });

                function initializeAddress() {
                    var componentForm = {
                        street_number: 'short_name',
                        route: 'long_name',
                        locality: 'long_name',
                        administrative_area_level_1: 'long_name',
                        country: 'short_name',
                        postal_code: 'short_name'
                    };
                    let options = {
                        componentRestrictions: {country: 'us'}
                    };
                    try {
                        let property_address = document.getElementById('property_address');
                        if(property_address) {
                            google.maps.event.addDomListener(property_address, 'keypress', (event) => {
                                if (event.keyCode === 13) {
                                    event.preventDefault();
                                } else if(property_address.dataset.isValid) {
                                    delete property_address.dataset.isValid;
                                }
                            });
                            let autocomplete_address = new google.maps.places.Autocomplete(property_address, options);
                            autocomplete_address.addListener('place_changed', (e) => {
                                var place = autocomplete_address.getPlace();
                                property_address.style.borderColor = '#e0e0e0';
                                $(`#property_address_error`).hide();
                                property_address.dataset.isValid = JSON.stringify(place.address_components);
                            });
                        }
                    } catch (e) { console.log('address error: ', e); }
                };

                $('#btn_add_apt_number').click(function (e) {
                    if (e) { e.preventDefault(); }
                    $('#add_apt_number_field').show();
                    $('#btn_add_apt_number').hide();
                    $('#address_line_2').val('');
                });

                $('#remove_add_apt_number').click(function (e) {
                    e.preventDefault();
                    $('#add_apt_number_field').hide();
                    $('#btn_add_apt_number').show();
                    $('#address_line_2').val('');
                });

                function validate_submit() {
                    var user = <?php echo json_encode($user); ?>;

                    if (user.role_id == 4) {

                        var invalid = false;

                        $('#government_id, #co-hosting_agreement_id, #homeowner_first_name, #homeowner_last_name, #homeowner_email, #homeowner_phone_number').each(function () {
                            if(!$(this).val()) {
                                $(this).css('border-color', '#ff0000');
                                $(window).scrollTop($(this).offset().top-50);
                                invalid = true;
                            } else if(this.name === 'homeowner_email' && $(this).val() && !validation_regex.email.test($(this).val())) {
                                $(this).css('border-color', '#ff0000');
                                $(window).scrollTop($(this).offset().top-50);
                                invalid = true;
                            } else if(this.name === 'homeowner_phone_number' && $(this).val() && !validation_regex.phone_number.test($(this).val())) {
                                $(this).css('border-color', '#ff0000');
                                $(window).scrollTop($(this).offset().top-50);
                                invalid = true;
                            } else {
                                $(this).css('border-color', '#ccc');
                            }
                        });

                        if(invalid) {
                            return false;
                        }
                        let property_address = document.getElementById('property_address');
                        if(property_address.value && property_address.dataset.isValid) {

                            var address_components = JSON.parse(property_address.dataset.isValid);
                            var componentForm = {
                                street_number: { type: 'short_name' },
                                route: { type: 'long_name' },
                                apartment_number: { value: $('#address_line_2').val() || '' },
                                locality: { type: 'long_name' },
                                administrative_area_level_1: { type: 'short_name' },
                                country: { type: 'short_name' },
                                postal_code: { type: 'short_name' }
                            };

                            for (var i = 0; i < address_components.length; i++) {
                                var addressType = address_components[i].types[0];
                                if (componentForm[addressType]) {
                                    componentForm[addressType].value = address_components[i][componentForm[addressType].type];
                                }
                            }
                            var complete_address = Object.values(componentForm).map(a => a.value).filter(Boolean).join(', ');
                            $(`#property_address`).val(complete_address);
                            $("#confirmationModal").modal('show');
                            // return true;
                        } else {
                            $(`#property_address`).css('border-color', '#ff0000');
                            $(`#property_address_error`).show();
                            $(window).scrollTop($(`#property_address`).offset().top-200);
                            return false;
                        }
                    } else {
                        if(!$('#government_id').val()) {
                            $(`#government_id`).css('border-color', '#ff0000');
                            $(window).scrollTop($(`#government_id`).offset().top-50);
                            return false;
                        }
                        if(user.role_id == 1) {
                            let property_tax_url = $('#property_tax_url').val();
                            let property_tax_document = $('#property_tax_document').val();
                            if(property_tax_document || property_tax_url) {
                                if(!property_tax_url || !property_tax_document) {
                                    alert('Please submit both Property Tax Document and URL.');
                                    return false;
                                }
                            }
                        }
                    };

                    $("#confirmationModal").modal('show');
                }

                $('#agency_hr_phone, #agency_office_number, #homeowner_phone_number').on('keypress', function(event) {
                    var regex = new RegExp("^[0-9+]$");
                    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                    if (!regex.test(key)) {
                        event.preventDefault();
                        return false;
                    }
                });
            </script>
        </div>

@endsection
