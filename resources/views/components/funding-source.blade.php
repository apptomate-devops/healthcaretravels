@php
$buttonText = $button_label ?? 'Add Account Details';
$hasDwollaAccount = isset($user->dwolla_customer);
if (!$hasDwollaAccount) {
    $buttonText = 'Agree and ' . $buttonText;
}
@endphp
<div>
    <h2>{{$label ?? 'Select an Account'}}</h2>
    @if(count($funding_sources) > 0)
        <div style="width: 70%">
            <select name="funding_source" id="fundingSource" class="chosen-icon-no-single trash-icon">
                <option selected disabled>Select Account</option>
                @foreach($funding_sources as $source)
                    <option data-icon="fa fa-trash" label="{{$source->name}}" value="{{$source->_links->self->href}}">{{$source->name}}</option>
                @endforeach
            </select>
        </div>
    @else
        <div>You haven't added any account details yet.</div>
    @endif
    @if (!$hasDwollaAccount)
        <div class="checkboxes mt-10" id="policy_accept_field">
            <input id="dwolla_policy_accept" type="checkbox" name="dwolla_policy_accept">
            <label for="dwolla_policy_accept">
                By checking and selecting {{$buttonText}} below, You agree to <a target="_blank" href="https://www.dwolla.com/legal/tos/">Dwolla Terms of Service</a> and <a target="_blank" href="https://www.dwolla.com/legal/privacy/">Dwolla Privacy Policy</a>
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
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Are you sure you want to remove the account <span id="delete-account-name"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="flex-row">
                        <div class="btn btn-default w-mc" data-dismiss="modal">Cancel</div>
                        <div class="btn btn-danger w-mc ml-10" id="confirm-delete-fs">Remove now</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="addDetailsProgress" class="loading style-2" style="display: none;"><div class="loading-wheel"></div></div>
</div>

<script src="https://cdn.dwolla.com/1/dwolla.js"></script>
<script>
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
                    $('#fundingSource').empty();
                    data.funding_sources.forEach(source => {
                        $('#fundingSource').append(`<option data-icon="fa fa-trash" label="${source.name}" value="${source._links.self.href}">${source.name}</option>`);
                    })
                    $('#fundingSource').val(fundingSource);
                    $('#fundingSource').chosen().trigger("chosen:updated");
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
                    $('#fundingSource').empty();
                    data.funding_sources.forEach(source => {
                        $('#fundingSource').append(`<option data-icon="fa fa-trash" label="${source.name}" value="${source._links.self.href}">${source.name}</option>`);
                    })
                    $('#fundingSource').val(fundingSource);
                    $('#fundingSource').chosen().trigger("chosen:updated");
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
