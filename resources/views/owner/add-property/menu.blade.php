@if($stage == 1)
    <a @if($property_details->is_complete == 1) href="{{url('/')}}/owner/add-property" @else href="#" @endif
    class="btn"
       style="background-color: #e78016;color:white;">Address </a>
@else
    <a  href="{{url('/')}}/owner/add-property"
    class="btn"
       style="background-color: #9a9595;color:white;">Address </a>
@endif

@if($stage == 2)
    <a @if($property_details->is_complete == 1) href="{{url('/')}}/owner/add-new-property/2x/{{$property_details->id}}" @else href="#" @endif
    class="btn"
       style="background-color: #e78016;color:white;">Property Details </a>
@else
    <a @if($property_details->stage >= 2 ||$property_details->is_complete == 1) href="{{url('/')}}/owner/add-new-property/2/{{$property_details->id}}" @else href="#" @endif
    class="btn"
       style="background-color: #9a9595;color:white;">Property Details </a>
@endif

@if($stage == 3)
    <a @if($property_details->is_complete == 1) href="{{url('/')}}/owner/add-new-property/3/{{$property_details->id}}" @else href="#" @endif
    class="btn"
       style="background-color: #e78016;color:white;">Listing </a>
@else
    <a @if($property_details->stage >= 3 ||$property_details->is_complete == 1) href="{{url('/')}}/owner/add-new-property/3/{{$property_details->id}}" @else href="#" @endif
    class="btn"
       style="background-color: #9a9595;color:white;">Listing </a>
@endif

@if($stage == 4)
    <a @if($property_details->is_complete == 1) href="{{url('/')}}/owner/add-new-property/4/{{$property_details->id}}" @else href="#" @endif
    class="btn"
       style="background-color: #e78016;color:white;">Booking </a>
@else
    <a @if($property_details->stage >= 4  ||$property_details->is_complete == 1) href="{{url('/')}}/owner/add-new-property/4/{{$property_details->id}}" @else href="#" @endif
    class="btn"
       style="background-color: #9a9595;color:white;">Booking </a>
@endif

@if($stage == 6)
    <a @if($property_details->is_complete == 1) href="{{url('/')}}/owner/add-new-property/6/{{$property_details->id}}" @else href="#" @endif
    class="btn"
       style="background-color: #e78016;color:white;">Amenities </a>
@else
    <a @if($property_details->stage >=    5 ||$property_details->is_complete == 1) href="{{url('/')}}/owner/add-new-property/6/{{$property_details->id}}" @else href="#" @endif
    class="btn"
       style="background-color: #9a9595;color:white;">Amenities </a>
@endif

@if($stage == 5)
    <a @if($property_details->is_complete == 1) href="{{url('/')}}/owner/add-new-property/5/{{$property_details->id}}" @else href="#" @endif
    class="btn"
       style="background-color: #e78016;color:white;">Add Photos </a>
@else
    <a @if($property_details->stage == 6 ||$property_details->is_complete == 1) href="{{url('/')}}/owner/add-new-property/5/{{$property_details->id}}" @else href="#" @endif
    class="btn"
       style="background-color: #9a9595;color:white;">Add Photos </a>
@endif


<!--
@if($stage == 7)
    <a @if($property_details->is_complete == 1) href="{{url('/')}}/owner/add-new-property/7/{{$property_details->id}}" @else href="#" @endif
    class="btn"
       style="background-color: #ff556a;color:white;">Calendar </a>
@else
    <a @if($property_details->is_complete == 1) href="{{url('/')}}/owner/add-new-property/7/{{$property_details->id}}" @else href="#" @endif
    class="btn"
       style="background-color: #9a9595;color:white;">Calendar </a>
@endif -->
