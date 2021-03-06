@extends('layout.master')
@section('title')
    Owner Profile | {{APP_BASE_NAME}}
@endsection
@section('main_content')

<div id="titlebar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2><span style="color:#e78016;font-size:32px">Hey I'm</span> {{Helper::get_user_display_name($user)}}!</h2>
                <span id="report_user" style="margin-left: 2px;"><i class="sl sl-icon-flag"></i>&nbsp;Report this User</span>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs">
                    <ul>
                        <li><a href="{{BASE_URL}}">Home</a></li>
                        <li>
                            @if($user->role_id == 1)
                                Owner
                            @elseif ($user->role_id == 2)
                                Agency
                            @elseif ($user->role_id == 3)
                                RV Healthcare Traveler
                            @elseif ($user->role_id == 4)
                                Co-Host
                            @else
                                Traveler
                            @endif
                            Profile</li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</div>

<!-- Content
================================================== -->
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="agent agent-page">

                <div class="agent-avatar">

                    <img src="{{$user->profile_image}}" class="user-icon" alt="" height="100px" width="100px">
                    @if($user->is_verified==1)
                        <div class="listing-badges" style="float:left; right: -15px;">
                            <span class="featured verified"> {{$user->is_verified==1?'Verified':'Not Verified'}}</span>
                        </div>
                    @endif
                </div>

                <div class="agent-content">
                    <div class="agent-name">
                        <h4>Name: {{Helper::get_user_display_name($user)}}
                            {{-- <img src="{{url('/')}}/public/tick.png" height="40" width="40"> --}}
                        </h4>
                        {{-- <span>Account Verification:Verified</span> --}}
                        @if($avg_rating > 0) <span>Rating:{{round($avg_rating,2)}}</span> @endif
                        <span>Languages known:
                            {{$user->languages_known}}
                        </span>

                        @if(!empty($user->about_me) && $user->about_me != "0")
                            <h3>About me:</h3>
                            <p>
                                {{$user->about_me}}
                            </p>
                        @endif

                    </div>



                    {{-- <ul class="agent-contact-details">
                        <li><i class="sl sl-icon-call-in"></i>
                            @if($user->phone != 0) {{$user->phone}} <img src="{{url('/')}}/public/tick.png" height="30" width="30"> @else -- @endif
                        </li>
                        <li><i class="fa fa-envelope-o "></i><a href="#"><span class="__cf_email__" data-cfemail="412b242f2f2824012439202c312d246f222e2c">{{$user->email}} <img src="{{url('/')}}/public/tick.png" height="30" width="30"> </span></a></li>
                    </ul>

                    <ul class="social-icons">
                        <li style="margin-left: 7px;"><a class="facebook" href="{{$user->facebook_url}}"><i class="icon-facebook"></i></a></li>
                        <li><a class="twitter" href="{{$user->twitter_url}}"><i class="icon-twitter"></i></a></li>
                        <li><a class="gplus" href="{{$user->paypal_email}}"><i class="icon-gplus"></i></a></li>
                        <li><a class="skype" href="{{$user->skype_id}}"><i class="icon-skype"></i></a></li>
                    </ul>
                    <div class="clearfix"></div> --}}
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Content
================================================== -->
{{-- <div class="container">
    <div class="row">

        <div class="col-md-12">
            <h3 class="headline margin-bottom-25 margin-top-65">About Owner</h3>
            <p>
                {{$user->about_me}}
            </p>
        </div>

    </div>
</div> --}}


<!-- Content
================================================== -->
<div class="container">
    <div class="row">

        <div class="col-md-12" style="background-color: white; max-height: 660px; overflow-y: hidden;">
            <h3 class="headline margin-bottom-25 margin-top-65">{{ucfirst($user->first_name)}}'s Properties</h3>
        </div>

        <!-- Carousel -->
        <div class="col-md-12">
            <div class="carousel">

                <!-- Listing Item -->
                @foreach($properties as $property)
                <div class="carousel-item">
                    <div class="listing-item">

                        <a href="{{url('/')}}/property/{{$property->id}}" class="listing-img-container">

                            <div class="listing-img-content">
                                <span class="listing-price">${{$property->monthly_rate}} /Month</span>
                                <span class="like-icon with-tip" data-tip-content="Add to Favourites"></span>
                            </div>
                           @if($property->verified==1)
                                <div class="listing-badges">
                                    <span class="featured verified">Verified</span>
                                </div>
                            @endif

                            <div class="listing-carousel">
                                @if(count($property->images) != 0)
                                    @foreach($property->images as $image)
                                    <div style="min-height: 300px;max-height: 300px;">
                                        <img style="min-height: 300px;max-height: 300px;" src="{{$image->image_url}}" alt="">
                                    </div>
                                    @endforeach
                                @else
                                    <div style="min-height: 300px;max-height: 300px;">
                                        <img style="min-height: 300px;max-height: 300px;" src="{{STATIC_IMAGE}}" alt="">
                                    </div>
                                @endif
                            </div>

                        </a>

                        <div class="listing-content">

                            <div class="listing-title">
                                <h4>
                                    <a href="{{url('/')}}/property/{{$property->id}}">
                                        {{$property->title}}
                                    </a>
                                </h4>

                                <div>
                                    <i class="fa fa-map-marker" style="color: #e78016;"></i>
                                    {{$property->city}},{{$property->state}}
                                </div>
                            </div>

                            <ul class="listing-features">
                                <li>Guests <span>{{$property->total_guests ? $property->total_guests : 0}}</span></li>
                                <li>Bedrooms <span>{{$property->bed_count ? $property->bed_count : 0}}</span></li>
                                <li>Bathrooms <span>{{$property->bathroom_count ? $property->bathroom_count : 0}}</span></li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- Listing Item / End -->
                @endforeach

            </div>
        </div>
        <!-- Carousel / End -->

    </div>
</div>

<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="exampleModalLabel">Report User</h4>
          </div>
          <div class="modal-body">
            {{--  <a href="{{URL('/')}}/create_chat/{{$property_id}}" target="_blank"><h3 id="contact_host"><span class="property-badge" style="background-color: #0983b8" >Message Host</span></h3></a> --}}
            <form action="{{url('/')}}/report-user/{{$user->id}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div id="check_in_div">
                    <div class="form-group">
                        <label class="control-label" for="chat_from_date">Comments (optional)</label>
                        <input name="comments"  placeholder="Comments"  type="text" style="width: 273px;" >
                    </div>
                </div>

                <center>
                    <button class="button  margin-top-5"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                    Report
                            </font></font>
                    </button>
                </center>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script>

        $("#report_user").click(function(){
            $('#myModal').modal('show');
        });
    </script>


<!-- Content
================================================== -->
@endsection
