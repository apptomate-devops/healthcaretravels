@extends('Admin.Layout.master')

@section('title')
{{APP_BASE_NAME}} Admin
@endsection

@section('content')
<style>
    .star-rating {
        line-height: 32px;
        font-size: 20px;
        pointer-events: none;

    }

    .star-rating .fa-star {
        color: #e78016;
    }
</style>
<link rel="stylesheet" href="{{URL::asset('/css/icons.css')}}">

<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Manage Property</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">

            </div>
        </div>
    </div>
    <!-- <div class="content-header-right col-md-6 col-12">
          <div class="dropdown float-md-right">
            <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton"
            type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
            <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbButton"><a class="dropdown-item" href="#"><i class="la la-calendar-check-o"></i> Calender</a>
              <a class="dropdown-item" href="#"><i class="la la-cart-plus"></i> Cart</a>
              <a class="dropdown-item" href="#"><i class="la la-life-ring"></i> Support</a>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
            </div>
          </div>
        </div> -->

    @if($property[0]->verified==0)
    <a style="float:right" class="btn btn-default btn-danger btn-block" href="{{BASE_URL}}admin/verify_property/{{$property[0]->id}}"><span>Click here to Verify This Property </span></a>
    @else
    <span class="btn btn-default btn-success btn-block">Verified</span>
    @endif

    </center>
</div>
<div class="content-body">

    <br>
    <!-- Basic form layout section start -->


    <!-- Form wizard with vertical tabs section start -->
    <!-- Tabs -->
    <section id="tabs">
        <div class="container">
            {{-- <h6 class="section-title h1">Tabs</h6> --}}
            <div class="row">
                <div class="col-md-12 ">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Property Details</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Amenties</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Pricing Details</a>
                            <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">Property Images</a>
                            <a class="nav-item nav-link" id="nav-about-owner" data-toggle="tab" href="#nav-owner" role="tab" aria-controls="nav-owner" aria-selected="false">Owner Details</a>
                        </div>
                    </nav>
                    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <table class="table table-xl mb-0">
                                <tr>
                                    <td>Property Name</td>
                                    <td><b>{{$property[0]->title}}</b></td>
                                    <td>Category</td>
                                    <td><b>{{$property[0]->property_category}}</b></td>
                                </tr>
                                <tr>
                                    <td>Location</td>
                                    <td><b>{{$property[0]->address}},{{$property[0]->city}},{{$property[0]->state}}
                                            ,{{$property[0]->state}}-{{$property[0]->zip_code}}</b></td>
                                    <td>Property Type</td>
                                    <td><b>{{$property[0]->room_type}}</b></td>
                                </tr>
                                <tr>
                                    <td>Booking Type</td>
                                    <td><b>{{$property[0]->is_instant==1?'Instant Booking' :'Request Booking'}}</b>
                                    </td>
                                    <td>Property Status</td>
                                    <td>
                                        @if($property[0]->is_disable == 0)
                                        <span class="btn btn-default btn-success">Enabled</span>
                                        @else
                                        <span class="btn btn-default btn-danger">Disabled</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>Guests</td>
                                    <td><b>{{$property[0]->total_guests}} /Day</b></td>
                                    <td>Property Length</td>
                                    <td><b>{{$property[0]->property_size}} ft</b></td>
                                </tr>

                                <tr>
                                    <td colspan="1">Description</td>
                                    <td colspan="3"><b>{{$property[0]->description}}</b></td>
                                </tr>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                            <table class="table table-xl mb-0">
                                <tr>
                                    <td>Price per day</td>
                                    <td><b>{{CURRENCY}} {{($property[0]->monthly_rate) / 30}}</b></td>

                                </tr>
                                {{-- <tr>--}}
                                {{-- <td>Price per Week</td>--}}
                                {{-- <td><b>{{CURRENCY}} {{$property[0]->price_more_than_one_week}}</b></td>--}}

                                {{-- </tr>--}}
                                <tr>
                                    <td>Price per Month</td>
                                    <td><b>{{CURRENCY}} {{$property[0]->monthly_rate}}</b></td>
                                </tr>
                                <tr>
                                    <td>Cleaning fee</td>
                                    <td><b>{{CURRENCY}} {{$property[0]->cleaning_fee}} /Day</b></td>

                                </tr>
                                <tr>
                                    <td>Minimum no of days</td>
                                    <td><b> {{$property[0]->min_days}} </b></td>

                                </tr>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <ul class="property-features margin-top-0">
                                @foreach($property->aminities as $am)
                                <li>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">{{$am->amenties_name}}</font>
                                    </font>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                            @if(!empty($property->images))
                            @foreach($property->images as $img)
                            <a href="{{$img->image_url}}" target="_blank" itemprop="contentUrl" data-size="480x360"><img class="img-thumbnail img-fluid" src="{{$img->image_url}}" itemprop="thumbnail" alt="Image description" height="25%" width="25%"></a>
                            @endforeach
                            @endif
                        </div>
                        <div class="tab-pane fade" id="nav-owner" role="tabpanel" aria-labelledby="nav-owner-tab">
                            <table class="table table-xl mb-0">
                                <tr>
                                    <td>Owner ID</td>
                                    <td><b>{{$property[0]->user_id}}</b></td>

                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td><b>{{$property[0]->first_name}} {{$property[0]->last_name}}</b></td>

                                </tr>
                                <tr>
                                    <td>User Name</td>
                                    <td><b>{{$property[0]->username}}</b></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><b>{{$property[0]->email}}</b></td>

                                </tr>
                                <tr>
                                    <td>Contact Number</td>
                                    <td><b>{{$property[0]->phone}} </b></td>

                                </tr>
                                <tr>
                                    <td>About</td>
                                    <td><b>{{$property[0]->about_me}} </b></td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('Admin.Includes.notes',['id'=>$property[0]->id,'admin_notes'=>$property[0]->admin_notes,'type'=>'property_list'])
    </section>
    <!-- Form wizard with vertical tabs section end -->
    <!-- // Basic form layout section end -->
</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

@endsection