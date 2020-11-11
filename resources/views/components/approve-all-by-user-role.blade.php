@if (isset($user))
    <div class="mb-15">
        {{-- TODO: come with a better name --}}
        <button id="approve-checked-profiles" class="btn btn-primary" style="display: none;">Verify Checked Users</button>
        <button class="btn btn-default" onclick="approveAll()">Approve all who signed up today</button>
    </div>
    @if(Session::has('approved'))
        <div class="mb-15 alert alert-success">
            <h4>{{Session::get('approved')}} users approved</h4>
        </div>
    @endif
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        function approveAll() {
            window.location.href = '/admin/approve-all/{{$user->role_id}}';
        }
        function updateDataTableSelectAllCtrl(table){
            var $table             = table.table().node();
            var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
            var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
            var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

            if($chkbox_checked.length === 0){
                // If none of the checkboxes are checked
                chkbox_select_all.checked = false;
                if('indeterminate' in chkbox_select_all){
                    chkbox_select_all.indeterminate = false;
                }
                $('#approve-checked-profiles').hide();

            } else if ($chkbox_checked.length === $chkbox_all.length){
                // If all of the checkboxes are checked
                chkbox_select_all.checked = true;
                if('indeterminate' in chkbox_select_all){
                    chkbox_select_all.indeterminate = false;
                }
                $('#approve-checked-profiles').show();

            } else {
                // If some of the checkboxes are checked
                chkbox_select_all.checked = true;
                if('indeterminate' in chkbox_select_all){
                    chkbox_select_all.indeterminate = true;
                }
                $('#approve-checked-profiles').show();
            }
        }

        $(document).ready(function (){
            // Array holding selected row IDs
            var rows_selected = [];
            var table = $('#hct_users').DataTable({
                'rowCallback': function(row, data, dataIndex){
                    // Get row ID
                    var rowId = data[1];
                    // If row ID is in the list of selected row IDs
                    if($.inArray(rowId, rows_selected) !== -1){
                        $(row).find('input[type="checkbox"]').prop('checked', true);
                        $(row).addClass('selected');
                    }
                }
            });
            // Handle click on checkbox
            $('#hct_users tbody').on('click', 'input[type="checkbox"]', function(e){
                var $row = $(this).closest('tr');

                // Get row data
                var data = table.row($row).data();

                // Get row ID
                var rowId = data[1];

                // Determine whether row ID is in the list of selected row IDs
                var index = $.inArray(rowId, rows_selected);

                if(this.checked && index === -1){
                    // If checkbox is checked and row ID is not in list of selected row IDs
                    rows_selected.push(rowId);
                } else if (!this.checked && index !== -1){
                    // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
                    rows_selected.splice(index, 1);
                }

                if(this.checked){
                    $row.addClass('selected');
                } else {
                    $row.removeClass('selected');
                }

                // Update state of "Select all" control
                updateDataTableSelectAllCtrl(table);

                // Prevent click event from propagating to parent
                e.stopPropagation();
            });

            // Handle click on table cells with checkboxes
            $('#hct_users').on('click', 'tbody td, thead th:first-child', function(e){
                $(this).parent().find('input[type="checkbox"]').trigger('click');
            });

            // Handle click on "Select all" control
            $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
                if(this.checked){
                    $('#hct_users tbody input[type="checkbox"]:not(:checked)').trigger('click');
                } else {
                    $('#hct_users tbody input[type="checkbox"]:checked').trigger('click');
                }

                // Prevent click event from propagating to parent
                e.stopPropagation();
            });

            // Handle table draw event
            table.on('draw', function(){
                // Update state of "Select all" control
                updateDataTableSelectAllCtrl(table);
            });

            // Handle form submission event
            $('#approve-checked-profiles').click(function(e){
                e.stopPropagation();
                let userIds = rows_selected;
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

            });

        })
    </script>
@endif
