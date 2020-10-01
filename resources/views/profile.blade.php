@extends('layout.master')
@section('title')
    {{APP_BASE_NAME}} Owner Profile
@endsection

@section('main_content')

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{ URL::asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/select-pure.css') }}">

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
                <div class="row">

                    <div class="col-md-8 my-profile">

                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                <h4>{{Session::get('success')}}</h4>
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-danger">
                                <h4>{{ Session::get('error') }}</h4>
                            </div>
                        @endif
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <h4>Something went wrong. Please review the form and correct the required fields.</h4>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="post" name="update_profile" action="update-profile" enctype="multipart/form-data" onsubmit="return validate_submit()" autocomplete="off" onkeydown="return event.key != 'Enter';">

                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            @if($user_detail->is_verified==1)
                                <div style="border:2px solid #0983b8;color:#0983b8;padding: 15px;width: 100%"><b>Your account has been verified</b></div><br>
                            @endif

                            <label>Username</label>
                            <input value="{{$user_detail->username}}" type="text" name="username" required="" disabled>

                            <label>First Name</label>
                            <input value="{{Session::get('first_name') ?? $user_detail->first_name}}" type="text" name="first_name" placeholder="First Name" required>

                            <label>Last Name</label>
                            <input value="{{Session::get('last_name') ?? $user_detail->last_name}}" required placeholder="Last Name" type="text" name="last_name">

                            <label>Mobile Number</label>
                            @if($user_detail->phone==0)
                                <input class="masked_phone_us" placeholder="+1 (XXX) XXX XXXX" type="text" name="phone" required disabled>
                            @endif
                            @if($user_detail->phone!=0)
                                <input class="masked_phone_us" value="{{$user_detail->phone}}" style="border:{{$user_detail->otp_verified==1?'2px solid #0983b8':'2px solid #e78016'}}" placeholder="+1 (XXX) XXX XXXX" type="text" name="phone" required disabled>
                            @endif
                            <div class="caption">{{$user_detail->otp_verified==1?'Mobile Number is Verified':'Mobile Number is not Verified'}}</div>

                            <label>Email</label>
                            <input value="{{$user_detail->email}}" style="border:{{$user_detail->email_verified==1?'2px solid #0983b8':'2px solid #e78016'}}" type="text" name="email" required disabled>
                            <div class="caption">{{$user_detail->email_verified==1?'Email is Verified':'Email not Verified'}}</div>

                            <label> Date of Birth</label>
                            <input type="date" onchange="on_dob_change(this.value)" class="input-text validate" value="{{Session::get('date_of_birth') ?? $user_detail->date_of_birth}}" name="dob" id="dob" autocomplete="off" required />
                            <p id="dob_validation_error" style="margin-bottom: 20px;"></p>

                            <label> Gender</label>
                            <select name="gender" id="gender" required>
                                <option value="Female" @if(Session::get('gender')=='Female' || $user_detail->gender =='Female' ) selected @endif>Female</option>
                                <option value="Male" @if(Session::get('gender')=='Male' || $user_detail->gender =='Male' ) selected @endif>Male</option>
                                <option value="Neutral" @if(Session::get('gender')=='Neutral' || $user_detail->gender =='Neutral' ) selected @endif>Neutral</option>
                            </select>

                            <label for="ethnicity">Ethnicity:</label>
                            <p class="register-info">We use this information for identity verification. It will not appear on your public profile.</p>
                            <select type="text" class="input-text validat" name="ethnicity" id="ethnicity" autocomplete="off" required>
                                <option value="" selected>Select Ethnicity</option>
                                @foreach(ETHNICITY as $ethnicity)
                                    <option value="{{$ethnicity}}" @if(Session::get('ethnicity')==$ethnicity || $user_detail->ethnicity ==$ethnicity) selected @endif>{{$ethnicity}}</option>
                                @endforeach
                            </select>

                            <label>Languages Known</label>
                            <input value="{{Session::get('languages_known') ?? $user_detail->languages_known}}" type="text" name="languages_known" placeholder="English, Spanish">

                            @if($user_detail->role_id == 0 || $user_detail->role_id == 2 || $user_detail->role_id == 3)
                                <div class="form-row form-row-wide" id="agency_show">
                                    <label for="agency_name">Agency you work for:</label>
                                    <p class="register-info">Select as many agencies that you have worked for in the last 12 months.</p>
                                    <span class="autocomplete-select"></span>
                                    <div id="add_another_agency" class="add-another" onclick="add_another_agency(true)" style="cursor: pointer;">Can't find it? Add it here.</div>
                                    <input type="hidden" name="name_of_agency" id="name_of_agency" value="">
                                    <label for="other_agency_name" id="other_agency_name" style="display: none;">Other Angency:</label>
                                    <input type="text" style="display: none;" class="input-text validate" name="other_agency" id="other_agency" onclick="add_another_agency()" value="{{Session::get('other_agency') ?? $user_detail->other_agency}}" placeholder="Other agency" autocomplete="off">
                                </div>
                            @endif
                            @if($user_detail->role_id == 0 || $user_detail->role_id == 3)
                                <label>Occupation</label>
                                <select class="input-text validate" autocomplete="off" name="occupation" id="occupation" required style=" margin: 0 0 20px;" onchange="on_occupation_change(this);">
                                    <option label="" value="">Select Occupation</option>
                                    @foreach($occupation as $a)
                                        <option value="{{$a->name}}" @if(Session::get('occupation')===$a->name || $user_detail->occupation === $a->name) selected @endif>{{$a->name}}</option>
                                    @endforeach
                                </select>
                                <div id="add_another_occupation" class="add-another" onclick="add_another_occupation(true)" style="cursor: pointer;">Can't find it? Add it here.</div>
                                <input type="text" style="display: none; margin: 0 0 20px;" class="input-text validate" name="other_occupation" id="other_occupation"  value="{{Session::get('other_occupation') ?? $user_detail->other_occupation}}" placeholder="Other Occupation" autocomplete="off">
                                <div style="display: none;" id="other_occupation_cancel" class="add-another" onclick="add_another_occupation(false, true)" style="cursor: pointer;">Cancel</div>


                                <div class="form-row form-row-wide" id="tax_home_field">
                                    <label for="tax_home">Tax Home:</label>
                                    <input type="text" class="input-text validate" value="{{Session::get('tax_home') ?? $user_detail->tax_home}}" name="tax_home" id="tax_home" placeholder="City, State" autocomplete="off" style="padding-left: 20px;" @if($user_detail->tax_home) data-is-valid="true" @endif />
                                </div>
                                <p class="error-text" id="tax_home_error" style="display: none;">Please select a valid address from the suggestions.</p>
                            @endif

                            @if($user_detail->role_id == 0 || $user_detail->role_id == 1 || $user_detail->role_id == 3 || $user_detail->role_id == 4)
                                <?php
                                $fullAddress = implode(
                                    ", ",
                                    array_filter([
                                        $user_detail->address,
                                        $user_detail->city,
                                        $user_detail->state,
                                        $user_detail->pin_code,
                                        $user_detail->country,
                                    ]),
                                );
                                $address_parts = explode(", ", $user_detail->address);
                                $street_number = $address_parts[0] ?? '';
                                $route = $address_parts[1] ?? '';
                                ?>
                                <div class="form-row form-row-wide" id="address_field">
                                    <label id="address_label">Address:</label>
                                    <input type="text" class="input-text validate" value="{{$fullAddress}}" name="address" id="address" placeholder="Full Street Address" autocomplete="off" style="padding-left: 20px;" @if($fullAddress || $user_detail->address) data-is-valid="true" @endif />
                                </div>
                                <p class="error-text" id="address_error" style="display: none;">Please select a valid address from the suggestions.</p>

                                <div>
                                    <input class="field" type="hidden" id="street_number" name="street_number" value="{{$street_number ?? ''}}" />
                                    <input class="field" type="hidden" id="route" name="route" value="{{$route ?? ''}}" />
                                    <input class="field" type="hidden" id="locality" name="city" value="{{$user_detail->city ?? ''}}" />
                                    <input class="field" type="hidden" id="administrative_area_level_1" name="state" value="{{$user_detail->state ?? ''}}" />
                                    <input class="field" type="hidden" id="postal_code" name="pin_code" value="{{$user_detail->pin_code ?? ''}}" />
                                    <input class="field" type="hidden" id="country" name="country" value="{{$user_detail->country ?? ''}}" />
                                </div>

                                <label for="add_apt" id="add_apt_number_field" style="display: none; margin-top: -10px;">
                                    <input type="text" class="input-text validate" value="{{Session::get('address_line_2') ?? $user_detail->address_line_2 }}" name="address_line_2" id="address_line_2" placeholder="Apt, Unit, Suite, or Floor #" style="padding-left: 20px;" />
                                </label>
                                <div style="width: 100%; display: inline-block; text-align: right; margin-top: -10px;">
                                    <button id="remove_add_apt_number" onclick="on_remove_address_line_2(event)" class="button" style="display: none;">Don't Add</button>
                                </div>
                                <button id="btn_add_apt_number" onclick="on_add_address_line_2(event)" class="btn btn-primary w-100" style="margin-bottom: 30px; margin-top: -40px;">Add an Apt or Floor #</button>

                            @endif

                            {{--                            @if($user_detail->role_id == 1 || $user_detail->role_id == 4)--}}
                            {{--                                <div class="form-row form-row-wide" id="listing_address_field">--}}
                            {{--                                    <label for="listing_address">Listing Address:</label>--}}
                            {{--                                    <input type="text" class="input-text validate" value="{{Session::get('listing_address') ?? $user_detail->listing_address}}" name="listing_address" id="listing_address" placeholder="Full Street Address" autocomplete="off" style="padding-left: 20px;" @if($user_detail->listing_address) data-is-valid="true" @endif />--}}
                            {{--                                </div>--}}
                            {{--                                <p class="error-text" id="listing_address_error" style="display: none;">Please select a valid address from the suggestions.</p>--}}
                            {{--                            @endif--}}

                            @if($user_detail->role_id == 2)
                                <label for="work">Office Number:</label>
                                <input type="text" class="masked_phone_us input-text validate" value="{{Session::get('work') ?? $user_detail->work}}" name="work" id="work" placeholder="Office Number" />

                                <label for="work_title">Work Title:</label>
                                <input type="text" class="input-text validate" value="{{Session::get('work_title') ?? $user_detail->work_title}}" name="work_title" id="work_title" placeholder="Work Title" />

                                <label for="website">Agency URL:</label>
                                <input type="text" class="input-text validate" value="{{Session::get('website') ?? $user_detail->website}}" name="website" id="website" placeholder="Agency URL" />
                            @endif

                            <label>About Me</label>
                            <p class="register-info">Please do not add any personal contact information for your privacy and safety</p>
                            <textarea name="about" id="about" cols="30" rows="10">{{Session::get('about_me') ?? $user_detail->about_me}}</textarea>

                            <div class="enable-auth-checkbox">
                                <input type="checkbox" name="enable_two_factor_auth" id="enable_two_factor_auth" @if("{$user_detail->enable_two_factor_auth}" == 1) checked @endif>
                                <span>Use two-factor authentication on every login</span>
                            </div>
                            <button type="submit" class="button" style="margin-bottom: 25px;">Save Changes</button>
                        </form>
                    </div>

                    <div class="col-md-4">
                        <!-- Avatar -->
                        <div class="edit-profile-photo">
                            <div id="profileImage">
                                <img src="{{($user_detail->profile_image != " " && $user_detail->profile_image != "" && $user_detail->profile_image != 0) ? $user_detail->profile_image : '/user_profile_default.png'}}"/>
                            </div>
                            <div class="col-md-6">
                                <div class="change-photo-btn" id="upload_button">

                                    <div class="photoUpload">
                                        <span><i class="fa fa-upload"></i></span>
                                        <input type="file" id="profile_image" onchange="file_upload();" class="upload" name="profile_image" accept="image/*" />
                                        <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                            </div>
                            <div id="uploading">

                            </div>
                            <div class="col-md-6">
                                <div class="change-photo-btn del" >
                                    <div class="photoUpload">
                                        <span id="delete_image" onclick="location.href='{{BASE_URL}}delete-profile-picture';"><i class="fa fa-trash"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>

        </div>
    </div>

    <script>
        var allAgencies = [];
        var agencyAutoComplete;
        var addressFields = [];
        $(document).ready(function(){
            set_max_date();
            load_agencies();

            let occupation = "{{Session::get('other_occupation') ?? $user_detail->other_occupation}}";
            if (occupation) {
                add_another_occupation(true);
            }

            var otherAgencies = "{{Session::get('other_agency') ?? $user_detail->other_agency}}";
            if(otherAgencies) {
                add_another_agency(true, otherAgencies);
            }
            var address_line_2 = "{{Session::get('address_line_2') ?? $user_detail->address_line_2}}";
            if (address_line_2) {
                on_add_address_line_2(undefined, address_line_2);
            }
        });

        function set_max_date() {
            let dd = new Date().getDate();
            let mm = new Date().getMonth() + 1;
            let yyyy = new Date().getFullYear();
            document.getElementById("dob").max = `${yyyy}-${ mm<10 ? '0'+mm : mm }-${ dd<10 ? '0'+dd : dd }`;
        }

        function on_dob_change(value) {
            const dateString = value;
            let today = new Date();
            let birthDate = new Date(dateString);
            let age = today.getFullYear() - birthDate.getFullYear();
            let m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            if (age < 18 || age > 100) {
                $('#dob_validation_error').html('You must be 18 or older to register online. Contact <br>​<a href="mailto:{{VERIFY_MAIL}}">{{VERIFY_MAIL}}</a> to create a minor account.')
            } else {
                $('#dob_validation_error').html('');
            }
        }

        function add_another_occupation(show = false, isCancel = false) {
            if(show) {
                $('#add_another_occupation').hide();
                $('#other_occupation').show();
                $('#other_occupation_cancel').show();
                $('#occupation').val('Other');
            } else {
                $('#add_another_occupation').show();
                $('#other_occupation').hide();
                $('#other_occupation_cancel').hide();
                $('#other_occupation').val('');
                if(isCancel) {
                    $('#occupation').val('');
                }
            }
        }
        function on_occupation_change(element) {
            var isOther = $(element).val() == 'Other';
            add_another_occupation(isOther);
        }

        function initialize() {
            var componentForm = {
                street_number: 'short_name',
                route: 'long_name',
                locality: 'long_name',
                administrative_area_level_1: 'long_name',
                country: 'short_name',
                postal_code: 'short_name'
            };

            var roleId = "{{$user_detail->role_id}}";

            if(roleId == 0 || roleId == 3) {
                addressFields = ['tax_home', 'address'];
            } else if(roleId == 1 || roleId == 4) {
                addressFields = ['address'];
            };

            let options = {
                componentRestrictions: {
                    country: 'us'
                }
            };
            let options_tax_home = {
                types: ['(cities)'],
                componentRestrictions: {
                    country: 'us'
                }
            };
            try {
                for (field in addressFields) {
                    let element_address = document.getElementById(addressFields[field]);
                    let element_address_error = document.getElementById(`${addressFields[field]}_error`);
                    if (element_address) {
                        google.maps.event.addDomListener(element_address, 'keypress', (event) => {
                            if (event.keyCode === 13) {
                                event.preventDefault();
                            } else if (element_address.dataset.isValid) {
                                delete element_address.dataset.isValid;
                                if (element_address.name === 'address') {
                                    for (var component in componentForm) {
                                        document.getElementById(component).value = '';
                                    }
                                }
                            }
                        });
                        let autocomplete_address = new google.maps.places.Autocomplete(element_address, (addressFields[field] === 'tax_home') ? options_tax_home : options);
                        autocomplete_address.addListener('place_changed', (e) => {
                            if (element_address.name === 'address') {
                                var place = autocomplete_address.getPlace();

                                for (var i = 0; i < place.address_components.length; i++) {
                                    var addressType = place.address_components[i].types[0];
                                    if (componentForm[addressType]) {
                                        var val = place.address_components[i][componentForm[addressType]];
                                        document.getElementById(addressType).value = val;
                                    }
                                }
                            }

                            element_address.style.borderColor = '#e0e0e0';
                            element_address_error.style.display = "none";
                            element_address.dataset.isValid = true;
                        });
                    }
                }
            } catch (e) {}
        }

        function on_add_address_line_2(e, value = '') {
            if (e) {
                e.preventDefault();
            }
            $('#add_apt_number_field').show();
            $('#remove_add_apt_number').show();
            $('#btn_add_apt_number').hide();
            $('#address_line_2').val(value);
        }

        function on_remove_address_line_2(e) {
            if (e) {
                e.preventDefault();
            }
            $('#add_apt_number_field').hide();
            $('#remove_add_apt_number').hide();
            $('#btn_add_apt_number').show();
            $('#address_line_2').val('');
        }
        function add_another_agency(show = false, value = '') {
            if(show) {
                $('#add_another_agency').hide();
                $('#other_agency').show();
                $('#other_agency_cancel').show();
                $('#other_agency_name').show();
                $('#other_agency').val(value);
            } else {
                $('#add_another_agency').show();
                $('#other_agency').hide();
                $('#other_agency_cancel').hide();
                $('#other_agency_name').hide();
                $('#other_agency').val('');
            }
        }

        function load_agencies() {
            var agencies = <?php echo json_encode($agency); ?>;
            allAgencies = agencies;
            initPureSelect(agencies);
        }

        function initPureSelect(agencies, selected) {
            var selected_agencies = "{{Session::get('name_of_agency') ?? $user_detail->name_of_agency}}";
            selected_agencies = selected_agencies ? selected_agencies.split(',') : [];
            if (selected) {
                selected_agencies = selected;
            }
            var mappedData = agencies.map(a => ({
                label: a.name,
                value: a.name
            }));
            $('.autocomplete-select').empty();
            var autocomplete = new SelectPure(".autocomplete-select", {
                options: mappedData,
                value: selected_agencies,
                multiple: true,
                autocomplete: true,
                icon: "fa fa-times",
                placeholder: "Select Agencies",
            });
            agencyAutoComplete = autocomplete;
        }

        function validate_submit() {
                {{--if ("{{APP_ENV}}" === "local") {--}}
                {{--    $('#name_of_agency').val(agencyAutoComplete.value());--}}
                {{--    return true; // escape validation for local--}}
                {{--}--}}
            let dob_error = $('#dob_validation_error').html();
            if(dob_error) {
                $(window).scrollTop($('#dob').offset().top-100);
                return false;
            }
            let allFields = addressFields.filter(e => {
                let element_address = document.getElementById(e);
                let invalidAddress = !element_address.value || (element_address.value && !element_address.dataset.isValid);
                if(invalidAddress) {
                    $(`#${e}`).css('border-color', '#ff0000');
                    $(`#${e}_error`).show();
                }
                return invalidAddress;
            })
            if(allFields.length) {
                $(window).scrollTop($(`#${allFields[0]}`).offset().top-100);
                return false;
            }
            $('#name_of_agency').val(agencyAutoComplete.value());
            return true;
        }
    </script>
@endsection
