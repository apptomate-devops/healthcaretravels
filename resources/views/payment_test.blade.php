@extends('layout.master') @section('title','Health Care Travels')

@section('main_content')
<script src="https://cdn.dwolla.com/1/dwolla.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form id="create-funding-source">
                <div>
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" placeholder="First Name" required />
                </div>
                <div>
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" placeholder="Last Name" required />
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="email@example.com" required />
                </div>
                <div>
                    <label for="password">Routing number</label>
                    <input type="text" id="routingNumber" placeholder="273222226" required />
                </div>
                <div>
                    <label>Account number</label>
                    <input type="text" id="accountNumber" placeholder="Account number" />
                </div>
                <div>
                    <label>Bank account name</label>
                    <input type="text" id="name" placeholder="Name" />
                </div>
                <div>
                    <select name="type" id="type">
                        <option value="checking">Checking</option>
                        <option value="savings">Savings</option>
                    </select>
                </div>
                <div>
                    <input type="submit" value="Add Bank" class="btn btn-primary" />
                </div>
            </form>
            <div id="logs"></div>
        </div>
    </div>
</div>
<script>
    dwolla.configure('{{DWOLLA_ENV}}');
    function fundingSourcecallback(err, res) {
        var $div = $("<div />");
        var logValue = {
            error: err,
            response: res,
        };
        if (err) {
            var errors = err._embedded.errors;
            errors.forEach(function (errDetail) {
                var errorField = errDetail.path.substring(1);
                var fieldNode = $('#' + errorField);
                fieldNode.addClass('form-error');
                $('<p class="txt-red mb-5 form-error-message">' + errDetail.message + '</p>').insertAfter(fieldNode);
            });
            return false;
        }
        // TODO: send me to server to update me for user
        var fundingSource = res._links['funding-source'].href;
        addFundingSourceToUser(fundingSource);
        $div.text(JSON.stringify(logValue));
        console.log(logValue);
        $('#logs').append($div);
    }
    function addFundingSourceToUser(fundingSource) {
        var formData = {
            id: getLastSagmentOfURL(window.location.pathname),
            fundingSource: fundingSource,
            _token: '{{ csrf_token() }}'
        };
        $.ajax({
            url: "/dwolla/add_funding_source",
            type: "POST",
            data: formData,
            json: true,
            success: function(data, textStatus, jqXHR) {
                if (data.success) {
                    alert('User detail have been update successfully');
                } else {
                    alert('Error occured');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error occured');
            }
        });
    }
    function createCustomerForUserAndGetToken(userInfo, cb) {
        var formData = userInfo;
        formData.id = getLastSagmentOfURL(window.location.pathname);
        formData._token = '{{ csrf_token() }}';
        $.ajax({
            url: "/dwolla/create_customer_and_funding_source_token",
            type: "POST",
            data: formData,
            json: true,
            success: function(data, textStatus, jqXHR) {
                cb(null, data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                cb(errorThrown);
            }
        });
    }
    $('#create-funding-source').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(".form-error").removeClass('form-error');
        $(".form-error-message").hide();
        var token = '{{$token ?? ''}}';
        var bankInfo = {
            routingNumber: $('#routingNumber').val(),
            accountNumber: $('#accountNumber').val(),
            type: $('#type').val(),
            name: $('#name').val(),
        };
        var userInfo = {
            dwolla_first_name: $('#firstName').val(),
            dwolla_last_name: $('#lastName').val(),
            dwolla_email: $('#email').val(),
        }
        createCustomerForUserAndGetToken(userInfo, function(error, data) {
            if (data && data.success) {
                dwolla.fundingSources.create(data.token, bankInfo, fundingSourcecallback);
            } else {
                console.error(error || data);
                alert('Error occured:');
            }
        });
        return false;
    });
</script>
@endsection

