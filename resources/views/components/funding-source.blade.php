@php
$buttonText = $button_label ?? 'Add Account Details';
$hasDwollaAccount = isset($user->dwolla_customer);
@endphp
<div>
    <h2>{{$label ?? 'Select an Account'}}</h2>
    <div style="width: 70%">
        <select name="funding_source" id="fundingSource" class="chosen-icon-no-single trash-icon">
            <option selected disabled>Select Account</option>
            @foreach($funding_sources as $source)
                <option data-icon="fa fa-trash" label="{{$source->name}}" value="{{$source->_links->self->href}}">{{$source->name}}</option>
            @endforeach
        </select>
    </div>
    <div id="noFundingSource" style="display: none;">You haven't added any account details yet.</div>
    @if (!$hasDwollaAccount)
        <div class="checkboxes mt-10" id="policy_accept_field">
            <input id="dwolla_policy_accept" type="checkbox" name="dwolla_policy_accept">
            <label for="dwolla_policy_accept">
                By entering your bank details below you understand and agree this is your bank account and matches with the HCT user profile on this account and the verification documents submitted to use the platform.
{{--                By checking and selecting {{$buttonText}} below, I agree to the <a href="{{BASE_URL}}/terms-of-use" target="_blank">Terms of Use</a>, <a href="{{BASE_URL}}/privacy-policy" target="_blank">Privacy Policy</a>, <a href="{{BASE_URL}}/policies" target="_blank">Policies</a>, <a href="{{BASE_URL}}/payment-terms" target="_blank">Payment Terms</a>, <a href="{{BASE_URL}}/non-discrimination-policy" target="_blank">Nondiscrimination Policy</a> and <a href="{{URL('/')}}/cancellationpolicy">Cancellation Policy</a>.--}}
                <p class="error-text-accept" style="display: none">Policy must be agreed</p>
            </label>
        </div>
    @endif
    <div class="btn bg-orange" style="width: auto; margin-top: 10px;" id="create-funding-source">{{$buttonText}}</div>
    <div id="bank_verification_modal" data-backdrop="static" data-keyboard="false" class="modal fade in" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bank Verification</h4>
                </div>
                <div class="modal-body">
                    <div id="iavContainer"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="delete_funding_source_modal" data-backdrop="static" data-keyboard="false" class="modal fade in" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content" style="text-align: left;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b><span style="color:red">Warning</span></b></h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove the account <span id="delete-account-name"></span>?
                    <br>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default w-mc" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger w-mc ml-10" id="confirm-delete-fs">Remove now</button>
                </div>
            </div>
        </div>
    </div>
    <div id="addDetailsProgress" class="loading style-2" style="display: none;"><div class="loading-wheel"></div></div>
</div>

<script src="https://cdn.dwolla.com/1/dwolla.js"></script>
<script>
    $('#fundingSource').on('chosen:ready', function(){
            var fundingSources = <?php echo json_encode($funding_sources); ?>;
            if(fundingSources.length) {
                $('#fundingSource_chosen').show();
                $('#noFundingSource').hide();
            } else {
                $('#fundingSource_chosen').hide();
                $('#noFundingSource').show();
            }
        });
    // Dwolla: Account details
    dwolla.configure('{{DWOLLA_ENV}}');

    function getFundingSourceFromIAV(iavToken) {
        $("#bank_verification_modal").modal('show');
        var config = {
            container: 'iavContainer',
            stylesheets: [
                'https://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext'
            ],
            microDeposits: false,
            fallbackToMicroDeposits: true,
            subscriber: ({ currentPage, error }) => {
                $('#addDetailsProgress').hide();
                console.log("currentPage:", currentPage, "error:", JSON.stringify(error));
            },
        };
        dwolla.iav.start(iavToken, config, function(err, res) {
            if(err) {
                $('#addDetailsProgress').hide();
                console.log('Error creating IAV funding source', err.message, 'with code', err.code);
                return false
            }
            var fundingSource = res._links['funding-source'].href;
            addDefaultFundingSourceToUser(fundingSource, function (err, data) {
                $('#addDetailsProgress').hide();
                $("#bank_verification_modal").modal('hide');
                if(data.success) {
                    reintChosen(data, fundingSource);
                }
            });
        });
    };

    function addDefaultFundingSourceToUser(fundingSource, cb) {
        var formData = {
            id: {{$user->id}},
            fundingSource: fundingSource,
            _token: '{{ csrf_token() }}',
            fromProfile: '{{ $from_profile ?? ''}}'
        };
        $.ajax({
            url: "/dwolla/add_funding_source",
            type: "POST",
            data: formData,
            json: true,
            success: function(response, textStatus, jqXHR) {
                cb(null, response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                cb(errorThrown);
            }
        });
    };

    function objectValues(obj) {
        var res = [];
        for (var i in obj) {
            if (obj.hasOwnProperty(i)) {
                res.push(obj[i]);
            }
        }
        return res;
    }
    function reintChosen(data, fundingSource) {
        $('#fundingSource').empty();
        var fs = data.funding_sources;
        if (!Array.isArray(fs)) {
            fs = objectValues(fs);
        }
        if(fs.length) {
            $('#fundingSource_chosen').show();
            $('#noFundingSource').hide();
            fs.forEach(source => {
                $('#fundingSource').append(`<option data-icon="fa fa-trash" label="${source.name}" value="${source._links.self.href}">${source.name}</option>`);
            });
            if(fundingSource) {
                $('#fundingSource').val(fundingSource);
            }
        } else {
            $('#fundingSource_chosen').hide();
            $('#noFundingSource').show();
        }
        $('#fundingSource').chosenIcon().trigger("chosen:updated");

        // Reloads side menu and user menu after to update payment Options
        $('#my-account-nav').load(document.URL +  ' #my-account-nav');
        $('#user-dropdown-nav').load(document.URL +  ' #user-dropdown-nav');
    }
    function deleteFundingSourceFromUser(fundingSource, cb) {
        var formData = {
            id: {{$user->id}},
            fundingSource: fundingSource,
            _token: '{{ csrf_token() }}',
        };
        $.ajax({
            url: "/dwolla/delete_funding_source",
            type: "POST",
            data: formData,
            json: true,
            success: function(response, textStatus, jqXHR) {
                cb(null, response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                cb(errorThrown);
            }
        });
    };

    $(document).on('click', '.chosen-icon-item', function(event) {
        window.fsToDelete = event.target.dataset.value;
        window.fsToDeleteName = event.target.dataset.name;
        $('#delete-account-name').text(window.fsToDeleteName);
        $('#delete_funding_source_modal').modal('show');
    });

    $(document).on('click', '#confirm-delete-fs', function(event) {
        $("#delete_funding_source_modal").modal('hide');
        $('#addDetailsProgress').show();
        deleteFundingSourceFromUser(window.fsToDelete, function (err, data) {
                if(data.success) {
                    reintChosen(data);
                }
                $('#addDetailsProgress').hide();
            });
    });
    $('#create-funding-source').on('click', function (e) {
        var dwollaAccept = $('#dwolla_policy_accept');
        if (dwollaAccept.length && !dwollaAccept.is(':checked')) {
            $('.error-text-accept').fadeIn();
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
        $('#addDetailsProgress').show();
        var userInfo = {
            id: {{$user->id}},
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: "/dwolla/create_customer_and_funding_source_token_with_validations",
            type: "POST",
            data: userInfo,
            json: true,
            success: function(response, textStatus, jqXHR) {
                if(response && response.success) {
                    getFundingSourceFromIAV(response.token);
                } else {
                    $('#addDetailsProgress').hide();
                    console.log('Error while generating IAV token');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#addDetailsProgress').hide();
                console.log('Error while generating IAV token');
            }
        });
    });
</script>
