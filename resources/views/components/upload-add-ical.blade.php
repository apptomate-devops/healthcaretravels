<div>
    <label style="margin-top: 20px;">Upload an iCalendar from another booking site</label>
    <div class="alert alert-info">
                            <span>
                                If your property is listed on another website like Airbnb, you can upload an iCalendar (.ics) file from that website to automatically block out dates that your property is not available.
                                Please be sure that the calendar you add only has events for stays at your property that were booked through alternate services. Any day with an event will be considered unavailable.
                            </span>
    </div>
    <form class="dropzone property-calender" id="upload_ical_form" method="post" action="{{url('/')}}/owner/upload-calender">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="property_id" name="property_id" value="{{$property_id}}">
        <input type="hidden" id="calender_file" type="file" name="calender_file">
        <div  class="dz-default dz-message">
                                <span>
                                    <i class="sl sl-icon-plus"></i> Click here to upload
                                </span>
        </div>
    </form>
    <div class="calender-upload-alerts">
        <div class="alert alert-danger" style="display: none">
                            <span>
                                Error in uploading calender events
                            </span>
        </div>
        <div class="alert alert-success" style="display: none">
                            <span>
                                Calender events are added successfully
                            </span>
        </div>
    </div>
    <div class="width-100 text-right">
        <button type="submit" disabled id="upload_ical" class="button preview margin-top-5" style="margin-bottom: 20px;">
            Upload
        </button>
    </div>
    <center><h3 style="margin: 0 0 20px 0;">OR</h3></center>
    <div>
        <label style="margin-left: 12px;">Enter Third party ICAL URL here</label>
        <div style="display: flex; justify-content: space-between;">
            <input style="margin-left: 10px;width: 80%;" type="text" placeholder="Enter Third party ICAL URL here" name="ical_url" value="https://calendar.google.com/calendar/ical/patelpooja300876%40gmail.com/public/basic.ics">
            <button type="button" id="add_ical" class="button preview margin-top-5" style="margin-bottom: 20px;float: right;">
                Add
            </button>
        </div>
    </div>
</div>
<div id="calenderLoadingProgress" class="loading style-2" style="display: none;"><div class="loading-wheel"></div>
</div>

<script>
    $(':input[name="ical_url"]').on('input', function() {
        var url_regex = /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/
        var is_valid_url = url_regex.test($(this).val());
        $('#add_ical').prop('disabled', !is_valid_url);
    });

    $('#add_ical').click(function (e) {
        var _token = "{{csrf_token()}}";
        var property_id = $('#property_id').val();
        var ical_url = $('input[name="ical_url"]').val();

        var data = {_token, property_id, ical_url};
        console.log(data)
        debugger
        $.ajax({
            type: "POST",
            data,
            json: true,
            url: '{{BASE_URL}}' + 'owner/upload-calender',
            success: function(data) {
                console.log(data);
                debugger
            },
            error: function (error) {
                console.log(error);
                debugger
            }
        });
    })

</script>
