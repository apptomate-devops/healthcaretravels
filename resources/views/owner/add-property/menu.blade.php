@if($property_details->is_disable == 1)
    <h4 style="position: absolute; top: -25px;">This property is disabled.</h4>
@endif

<a class="btn" style="background-color: @if($stage == 0) #e78016 @else #9a9595 @endif;color:white;">
    Address
</a>

<a @if($property_details->is_complete == 1 || $property_details->stage >= 2) href="{{url('/')}}/owner/add-new-property/2/{{$property_details->id}}" @else href="#" @endif
class="btn" style="background-color: @if($stage == 2) #e78016 @else #9a9595 @endif;color:white;">
    Property Details
</a>

<a @if($property_details->is_complete == 1 || $property_details->stage >= 3) href="{{url('/')}}/owner/add-new-property/3/{{$property_details->id}}" @else href="#" @endif
class="btn" style="background-color: @if($stage == 3) #e78016 @else #9a9595 @endif;color:white;">
    Listing
</a>

<a @if($property_details->is_complete == 1 || $property_details->stage >= 4) href="{{url('/')}}/owner/add-new-property/4/{{$property_details->id}}" @else href="#" @endif
class="btn" style="background-color: @if($stage == 4) #e78016 @else #9a9595 @endif;color:white;">
    Booking
</a>

<a @if($property_details->is_complete == 1 || $property_details->stage >= 6) href="{{url('/')}}/owner/add-new-property/6/{{$property_details->id}}" @else href="#" @endif
class="btn" style="background-color: @if($stage == 6) #e78016 @else #9a9595 @endif;color:white;">
    Amenities
</a>

<a @if($property_details->is_complete == 1 || $property_details->stage >= 5) href="{{url('/')}}/owner/add-new-property/5/{{$property_details->id}}" @else href="#" @endif
class="btn" style="background-color: @if($stage == 5) #e78016 @else #9a9595 @endif;color:white;">
    Add Photos
</a>

<a @if($property_details->is_complete == 1 || $property_details->stage >= 7) href="{{url('/')}}/owner/add-new-property/7/{{$property_details->id}}" @else href="#" @endif
class="btn" style="background-color: @if($stage == 7) #e78016 @else #9a9595 @endif;color:white;">
    Calendar
</a>
