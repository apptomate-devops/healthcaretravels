@extends('layout.master') @section('title','Health Care Travels')

@section('main_content')
<script src="https://cdn.dwolla.com/1/dwolla.js"></script>
<script>
    dwolla.configure('{{DWOLLA_ENV}}');
    function fundingSourcecallback(err, res) {
        var $div = $("<div />");
        var logValue = {
            error: err,
            response: res,
        };
        $div.text(JSON.stringify(logValue));
        console.log(logValue);
        $('#logs').append($div);
    }
    $('#create-funding-source').on('submit', function () {
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
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{$token}}
            <form id="create-funding-source">
                <p class="form-row form-row-wide">
                    <label for="password">Routing number:
                        <input class="input-text" type="text" id="routingNumber" placeholder="273222226" required />
                    </label>
                </p>
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
                    <input type="submit" value="Add Bank" />
                </div>
            </form>
            <div id="logs"></div>
        </div>
    </div>
</div>
@endsection

