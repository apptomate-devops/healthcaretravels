<div>
    <h2>Account Details</h2>
    @if(count($funding_sources) > 0)
        <div style="width: 70%">
            <select name="funding_source" id="fundingSource" class="chosen-select-no-single">
                <option selected disabled>Select Account</option>
                @foreach($funding_sources as $source)
                    <option label="{{$source->name}}" value="{{$source->_links->self->href}}">{{$source->name}}</option>
                @endforeach
            </select>
        </div>
    @else
        <div>You haven't added any account details yet.</div>
    @endif
    <span class="link" id="create-funding-source">Add Account Details</span>
</div>
