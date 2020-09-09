@extends('layout.master') @section('title','Health Care Travels')

@section('main_content')
<script src="https://cdn.dwolla.com/1/dwolla.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form id="create-funding-source">
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
        alert(fundingSource);
        $div.text(JSON.stringify(logValue));
        console.log(logValue);
        $('#logs').append($div);
    }
    $('#create-funding-source').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(".form-error").removeClass('form-error');
        $(".form-error-message").hide();
        var token = '{{$token}}';
        var bankInfo = {
            routingNumber: $('#routingNumber').val(),
            accountNumber: $('#accountNumber').val(),
            type: $('#type').val(),
            name: $('#name').val(),
        };
        dwolla.fundingSources.create(token, bankInfo, fundingSourcecallback);
        return false;
    });
</script>
@endsection

