@if (isset($user))
<div class="mb-15">
    {{-- TODO: come with a better name --}}
    <button id="approve-checked-profiles" onclick="approveCheckedProfiles()" class="btn btn-primary d-none">Approve Checked Profiles</button>
    <button class="btn btn-default" onclick="approveAll()">Approve all who signed up today</button>
</div>
@if(Session::has('approved'))
<div class="mb-15 alert alert-success">
    <h4>{{Session::get('approved')}} users approved</h4>
</div>
@endif
<script>
    function approveAll() {
        window.location.href = '/admin/approve-all/{{$user->role_id}}';
    }

    function checkIsAnyCheckboxChecked() {
        var isChecked = false;
        var inputs = document.getElementsByTagName("input");
        for (var i = 0; i < inputs.length; i++) {
            var input = inputs[i];
            if (input.type === 'checkbox' && input.id != 'check-all' && input.checked) {
                isChecked = true;
                break;
            }
        }
        return isChecked;
    }

    function getAllCheckedUserIds() {
        var inputs = document.getElementsByTagName("input"),
            userIds = [];

        for (var i = 0; i < inputs.length; i++) {
            var input = inputs[i];
            if (input.type === 'checkbox' && input.id != 'check-all' && input.checked) {
                userIds.push(input.value);
            }
        }
        return userIds;
    }

    function approveCheckedProfiles() {
        var userIds = getAllCheckedUserIds();
        if (userIds.length == 0) return;

        $.ajax({
            url: "/admin/verify_checked_profiles",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                userIds: userIds
            },
            json: true,
            success: function(data, textStatus, jqXHR) {
                if (data.status === 'SUCCESS') {
                    window.location.reload();
                } else {
                    console.log(data);
                    setError('An error occured');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                setError('An error occured');
            }
        });
    }

    document.addEventListener('change', (e) => {
        if (e.target && e.target.type == 'checkbox') {
            if (e.target.id === 'check-all') {
                if (e.target.checked) {
                    $(':checkbox').prop("checked", true);
                } else {
                    $(':checkbox').prop("checked", false);
                }
            }
            var isChecked = checkIsAnyCheckboxChecked();
            if (isChecked) {
                $('#approve-checked-profiles').removeClass('d-none');
            } else {
                if (!$('#approve-checked-profiles').hasClass('d-none')) {
                    $('#approve-checked-profiles').addClass('d-none');
                }
            }
        }
    });
</script>
@endif