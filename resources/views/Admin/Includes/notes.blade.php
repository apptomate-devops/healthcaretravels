<div class="card">
    <div class="card-header">
        <h4 class="card-title">Notes</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                <li><a data-action="close"><i class="ft-x"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form onsubmit="submit_notes();return false;">
                <textarea class="form-control" id="admin_notes" name="admin_notes" rows="8" style="width:100%">{{$admin_notes}}</textarea>
                <div class="text-center" style="padding-top:10px;">
                    <button class="btn btn-default btn-primary btn-block">Submit Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function submit_notes() {
        var note = $('#admin_notes').val();
        $.ajax({
            url: "{{BASE_URL}}admin/update_notes/{{$id}}",
            type: "POST",
            data: {
                responses: {
                    note: note,
                    type: '{{$type}}',
                },
                _token: '{{ csrf_token() }}'
            },
            json: true,
            success: function(data, textStatus, jqXHR) {},
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                setError('An error occured');
            }
        });
        return false;
    }
</script>