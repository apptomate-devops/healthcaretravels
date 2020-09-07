@if (isset($user) && $user->role_id)
    <div class="mb-15">
        {{-- TODO: come with a better name --}}
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
    </script>
@endif

