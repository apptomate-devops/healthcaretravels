<<<<<<< HEAD


@extends('Admin.Layout.master')

@section('title')  Rentals Slew Admin @endsection

@section('content')


<div class="card">
              <div class="text-center">
                <div class="card-body">
                  <img src="@if($data->profile_image!=' ' &&  $data->profile_image!='0'){{$data->profile_image}}@else https://image.flaticon.com/icons/png/512/73/73199.png @endif" class="rounded-circle  height-150" alt="{{$data->username}} image">  
                </div>
                <div class="card-body">
                  <h4 class="card-title">{{$data->username}}</h4>
                  <h6 class="card-subtitle text-muted">@if($data->role_id==0) Traveler @elseif($data->role_id==1) Owner @else  Travel Agency @endif
                  	</h6>
                  	<br><h6 class="card-subtitle text-muted">@if($data->phone!='0'||$data->phone!=0){{$data->phone}}@endif
                  	</h6>
                  		<br><h6 class="card-subtitle text-muted">@if($data->email!='0'||$data->email!=0){{$data->email}}@endif
                    </h6><br>
                    <h6 class="card-subtitle text-muted">@if($data->name_of_agency!='0'||$data->name_of_agency!=0){{$data->name_of_agency}}@endif
                  	</h6><br>

                  	<div class="text-center">
                        @if($data->facebook_url!='0')
                  <a href="https://{{$data->facebook_url}}"  target="_blank" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook">
                    <span class="la la-facebook"></span>
                  </a>
                  @endif
                    @if($data->linkedin_url!='0')
                  <a href="https://{{$data->linkedin_url}}" target="_blank" class="btn btn-social-icon mb-1 btn-outline-linkedin">
                    <span class="la la-linkedin font-medium-4"></span>
                  </a>
                  @endif
                </div>
                 @if($data->is_verified==0)
              <a style="float:right"  class="btn btn-default btn-danger btn-block"  href="{{BASE_URL}}admin/verify_profile/{{$data->id}}"><span style="height:29px">Click here to Verify This @if($data->role_id==0) Traveler @elseif($data->role_id==1) Owner @else  Travel Agency @endif </span></a>
              @else
              <span  class="btn btn-default btn-success btn-block" style="background-color: green">Verified</span>
              @endif
              <br>
                </div>
              </div>
            </div>
           
            <div class="card">
              <div class="card-header">
                 {{-- <p>Tax Home : {{$data->tax_home}}</p> --}}
                <h4 class="card-title">Tax Home</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                </div>
              </div>
              <div class="card-content">
                <div class="card-body">
                    {{$data->tax_home}}
                  </div>
                </div>
              <div class="card-header">
                <h4 class="card-title">Address</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                </div>
              </div>
              <div class="card-content">
                <div class="card-body">
                    {{$data->address}}{{$data->country}}{{$data->state}}
                  </div>
                </div>
              <div class="card-header">
                <h4 class="card-title">About</h4>
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

                  @if($data->languages_known!='0')
                    <h4> {{$data->about_me}}</h4>
                    <br>
                    <br>
                  @else
                    <br>
                        -
                  @endif
               <h3 class="card-title">Languages Known</h3 >
                  @if($data->languages_known!='0')
              
                <br>
                <h4>{{$data->languages_known}}</h4>

                @else
                - 
                @endif
              </div>
                  
                </div>
              </div>
          

            <div class="card">
            	<div class="card-header">
            <h4 class="card-title">Property Details</h4>
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
              	<h3>Total Property Published : {{$total_posted}} </h3> <br><br>
              	<h3>Total Property Booked : {{$total_booking}} </h3><br>

               
              </div>
                  
                </div>
              </div>
            
            <div  class="card">
          <div class="card-header">
            <h4 class="card-title">Verification Documents</h4>
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
                @if($data->role_id==0)
              <h4 class="card-title"> Recuriter Name : {{$data->recruiter_name?$data->recruiter_name:' Not Added '}}</h4> <br>
            	<h4 class="card-title"> Recuriter Phone : {{ $data->recruiter_phone?$data->recruiter_phone:'Not Added'}} </h4><br>
            
            @endif
              <h4 class="card-title"> Verification Mobile Number : {{isset($mobile->mobile)?$mobile->mobile:' Not Added '}}</h4> <br>
              @if(isset($mobile->mobile))
                  @if($mobile->status == 0)
                      <a style="float:left"  class="btn btn-default btn-success"  href="{{BASE_URL}}admin/verify_mobile/{{$mobile->id}}/1"><span style="height:29px;width: 10px">Click here to Verify Mobile Number</span></a>
                      <a style="float:left"  class="btn btn-default btn-danger"  href="{{BASE_URL}}admin/verify_mobile/{{$mobile->id}}/2"><span style="height:29px">Click here to Unverify Mobile Number</span></a>
                  @elseif($mobile->status == 1)
                      <span  class="btn btn-default btn-success" style="background-color: green">Verified</span>
                  @else
                     <span  class="btn btn-default btn-danger" >Unverified</span>
                  @endif
              @endif
           </div>
            <div class="card-body  my-gallery" itemscope="" itemtype="http://schema.org/ImageGallery" data-pswp-uid="1">
              <div class="card-deck-wrapper">
                <div class="card-deck">
                	@if(count($document)==0)
                	  	<div class="col-md-12">  <center><h4>No Documents Uploaded yet.</h4></center></div>
                	 @else

                	@foreach($document as $d)
                	<div class="col-md-4">
                  <figure class="card card-img-top border-grey border-lighten-2" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
                  
                  	
                    <div class="card-body px-0">
                      <h4 class="card-title">   {{ucfirst(str_replace("_"," ",$d->document_type))}}</h4>
                    </div>
                    <a href="{{$d->document_url}}"  target="_blank"  itemprop="contentUrl" data-size="480x360">
                      <img class="gallery-thumbnail card-img-top" src="{{$d->document_url}}" itemprop="thumbnail" alt="Image description">
                    </a>
                
                    <div class="card-body px-0">
                      @if($d->status == 0)
                        <a style="float:right"  class="btn btn-default btn-success btn-block"  href="{{BASE_URL}}admin/verify_document/{{$d->id}}/1"><span style="height:29px">Click here to Verify This Document</span></a>
                        <a style="float:right"  class="btn btn-default btn-danger btn-block"  href="{{BASE_URL}}admin/verify_document/{{$d->id}}/2"><span style="height:29px">Unverify This Document</span></a>
                      @elseif($d->status == 1)
                       <span  class="btn btn-default btn-success btn-block" style="background-color: green">Verified</span>
                      @else
                        <span  class="btn btn-default btn-danger btn-block" >Unverified</span>
                      @endif
                    </div>
                  </figure>
              </div><br>
                  @endforeach

               

                  @endif

                  
                  
                 
                 
                </div>
              </div>
             
            </div>
            <!-- Root element of PhotoSwipe. Must have class pswp. -->
                      </div>
          <!--/ PhotoSwipe -->
        </div>
=======


@extends('Admin.Layout.master')

@section('title')  Rentals Slew Admin @endsection

@section('content')


<div class="card">
              <div class="text-center">
                <div class="card-body">
                  <img src="@if($data->profile_image!=' ' &&  $data->profile_image!='0'){{$data->profile_image}}@else https://image.flaticon.com/icons/png/512/73/73199.png @endif" class="rounded-circle  height-150" alt="{{$data->username}} image">  
                </div>
                <div class="card-body">
                  <h4 class="card-title">{{$data->username}}</h4>
                  <h6 class="card-subtitle text-muted">@if($data->role_id==0) Traveler @elseif($data->role_id==1) Owner @else  Travel Agency @endif
                  	</h6>
                  	<br><h6 class="card-subtitle text-muted">@if($data->phone!='0'||$data->phone!=0){{$data->phone}}@endif
                  	</h6>
                  		<br><h6 class="card-subtitle text-muted">@if($data->email!='0'||$data->email!=0){{$data->email}}@endif
                    </h6><br>
                    <h6 class="card-subtitle text-muted">@if($data->name_of_agency!='0'||$data->name_of_agency!=0){{$data->name_of_agency}}@endif
                  	</h6><br>

                  	<div class="text-center">
                        @if($data->facebook_url!='0')
                  <a href="https://{{$data->facebook_url}}"  target="_blank" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook">
                    <span class="la la-facebook"></span>
                  </a>
                  @endif
                    @if($data->linkedin_url!='0')
                  <a href="https://{{$data->linkedin_url}}" target="_blank" class="btn btn-social-icon mb-1 btn-outline-linkedin">
                    <span class="la la-linkedin font-medium-4"></span>
                  </a>
                  @endif
                </div>
                 @if($data->is_verified==0)
              <a style="float:right"  class="btn btn-default btn-danger btn-block"  href="{{BASE_URL}}admin/verify_profile/{{$data->id}}"><span style="height:29px">Click here to Verify This @if($data->role_id==0) Traveler @elseif($data->role_id==1) Owner @else  Travel Agency @endif </span></a>
              @else
              <span  class="btn btn-default btn-success btn-block" style="background-color: green">Verified</span>
              @endif
              <br>
                </div>
              </div>
            </div>
           
            <div class="card">
              <div class="card-header">
                 {{-- <p>Tax Home : {{$data->tax_home}}</p> --}}
                <h4 class="card-title">Tax Home</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                </div>
              </div>
              <div class="card-content">
                <div class="card-body">
                    {{$data->tax_home}}
                  </div>
                </div>
              <div class="card-header">
                <h4 class="card-title">Address</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                </div>
              </div>
              <div class="card-content">
                <div class="card-body">
                    {{$data->address}}{{$data->country}}{{$data->state}}
                  </div>
                </div>
              <div class="card-header">
                <h4 class="card-title">About</h4>
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

                  @if($data->languages_known!='0')
                    <h4> {{$data->about_me}}</h4>
                    <br>
                    <br>
                  @else
                    <br>
                        -
                  @endif
               <h3 class="card-title">Languages Known</h3 >
                  @if($data->languages_known!='0')
              
                <br>
                <h4>{{$data->languages_known}}</h4>

                @else
                - 
                @endif
              </div>
                  
                </div>
              </div>
          

            <div class="card">
            	<div class="card-header">
            <h4 class="card-title">Property Details</h4>
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
              	<h3>Total Property Published : {{$total_posted}} </h3> <br><br>
              	<h3>Total Property Booked : {{$total_booking}} </h3><br>

               
              </div>
                  
                </div>
              </div>
            
            <div  class="card">
          <div class="card-header">
            <h4 class="card-title">Verification Documents</h4>
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
                @if($data->role_id==0)
              <h4 class="card-title"> Recuriter Name : {{$data->recruiter_name?$data->recruiter_name:' Not Added '}}</h4> <br>
            	<h4 class="card-title"> Recuriter Phone : {{ $data->recruiter_phone?$data->recruiter_phone:'Not Added'}} </h4><br>
            
            @endif
              <h4 class="card-title"> Verification Mobile Number : {{isset($mobile->mobile)?$mobile->mobile:' Not Added '}}</h4> <br>
              @if(isset($mobile->mobile))
                  @if($mobile->status == 0)
                      <a style="float:left"  class="btn btn-default btn-success"  href="{{BASE_URL}}admin/verify_mobile/{{$mobile->id}}/1"><span style="height:29px;width: 10px">Click here to Verify Mobile Number</span></a>
                      <a style="float:left"  class="btn btn-default btn-danger"  href="{{BASE_URL}}admin/verify_mobile/{{$mobile->id}}/2"><span style="height:29px">Click here to Unverify Mobile Number</span></a>
                  @elseif($mobile->status == 1)
                      <span  class="btn btn-default btn-success" style="background-color: green">Verified</span>
                  @else
                     <span  class="btn btn-default btn-danger" >Unverified</span>
                  @endif
              @endif
           </div>
            <div class="card-body  my-gallery" itemscope="" itemtype="http://schema.org/ImageGallery" data-pswp-uid="1">
              <div class="card-deck-wrapper">
                <div class="card-deck">
                	@if(count($document)==0)
                	  	<div class="col-md-12">  <center><h4>No Documents Uploaded yet.</h4></center></div>
                	 @else

                	@foreach($document as $d)
                	<div class="col-md-4">
                  <figure class="card card-img-top border-grey border-lighten-2" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
                  
                  	
                    <div class="card-body px-0">
                      <h4 class="card-title">   {{ucfirst(str_replace("_"," ",$d->document_type))}}</h4>
                    </div>
                    <a href="{{$d->document_url}}"  target="_blank"  itemprop="contentUrl" data-size="480x360">
                      <img class="gallery-thumbnail card-img-top" src="{{$d->document_url}}" itemprop="thumbnail" alt="Image description">
                    </a>
                
                    <div class="card-body px-0">
                      @if($d->status == 0)
                        <a style="float:right"  class="btn btn-default btn-success btn-block"  href="{{BASE_URL}}admin/verify_document/{{$d->id}}/1"><span style="height:29px">Click here to Verify This Document</span></a>
                        <a style="float:right"  class="btn btn-default btn-danger btn-block"  href="{{BASE_URL}}admin/verify_document/{{$d->id}}/2"><span style="height:29px">Unverify This Document</span></a>
                      @elseif($d->status == 1)
                       <span  class="btn btn-default btn-success btn-block" style="background-color: green">Verified</span>
                      @else
                        <span  class="btn btn-default btn-danger btn-block" >Unverified</span>
                      @endif
                    </div>
                  </figure>
              </div><br>
                  @endforeach

               

                  @endif

                  
                  
                 
                 
                </div>
              </div>
             
            </div>
            <!-- Root element of PhotoSwipe. Must have class pswp. -->
                      </div>
          <!--/ PhotoSwipe -->
        </div>
>>>>>>> 9780f4d597805bbd719091658f0c562aa3f6ec95
@endsection