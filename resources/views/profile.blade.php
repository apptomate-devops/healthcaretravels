@extends('layout.master')
@section('title')
    {{APP_BASE_NAME}} Owner Profile
@endsection

@section('main_content')

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{ URL::asset('css/profile.css') }}">

    <div class="container" style="margin-top: 35px;">
        <div class="row">

            <!-- Widget -->
            <div class="col-md-4">

                <div class="sidebar left">

                    <div class="my-account-nav-container">

                        @include('owner.menu')

                    </div>

                </div>
            </div>

            <div class="col-md-8">
                <div class="row">

                    <div class="col-md-8 my-profile">

                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                <h4>{{ Session::get('success') }}</h4>
                            </div>
                        @endif

                        @if(Session::has('error'))
                            <div class="alert alert-success">
                                <h4>{{ Session::get('error') }}</h4>
                            </div>
                        @endif
                        <form name="update_profile" action="update-profile" method="post" style="margin-top: -30px;" autocomplete="off">

                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <br>
                            @if($user_detail->is_verified==1)
                                <span style="border:2px solid #0983b8;color:#0983b8;padding: 15px;width: 100%"><b>Your account has been verified</b></span><br>
                            @endif

                            @if($user_detail->username)
                                <label>Username</label>
                                <input value="{{$user_detail->username}}" type="text" name="username" required="" disabled>
                            @endif

                            @if($user_detail->first_name)
                                <label>First Name</label>
                                <input value="{{$user_detail->first_name}}" type="text" name="first_name" required>
                            @endif

                            @if($user_detail->last_name)
                                <label>Last Name</label>
                                <input value="{{$user_detail->last_name}}" required placeholder="Please Enter Last Name" type="text" name="last_name">
                            @endif


                            @if($user_detail->name_of_agency)
                                @php $agency_array = json_decode(json_encode($agency), True); @endphp
                                <label>Name Of Agency</label>
                                <select class="input-text validate" autocomplete="off"  name="name_of_agency" id="agency_name">
                                    <option label="" value="" >Select Agency</option>
                                    @foreach($agency as $a)
                                        @if(in_array($user_detail->name_of_agency,$agency_array) && ($a->name == $user_detail->name_of_agency))
                                            <option value="{{$a->name}}"  selected >{{$a->name}}</option>
                                        @elseif(!in_array($user_detail->name_of_agency,$agency_array) && ($a->name != $user_detail->name_of_agency))
                                            <option value="{{$a->name}}">{{$a->name}}</option>
                                        @endif
                                    @endforeach
                                    @if(!in_array($user_detail->name_of_agency,$agency_array) )
                                        <option value="{{$user_detail->name_of_agency}}" selected="selected">{{$user_detail->name_of_agency}}</option>
                                    @endif
                                    <option value="Others" >Others</option>
                                </select>

                            @endif
                            <br>
                            <input autocomplete="off" id="others_show" type="text"  name="" id="" style="display: none;">


                            @if($user_detail->occupation)
                                @php $occupation_array = json_decode(json_encode($occupation), True); @endphp
                                <label>Occupation</label>
                                <select class="input-text validate" autocomplete="off"  name="occupation" id="occupation">
                                    <option label="" value="" >Select Occupation</option>
                                    @foreach($occupation as $a)
                                        @if(in_array($user_detail->occupation,$occupation_array) && ($a->name == $user_detail->occupation))
                                            <option value="{{$a->name}}"  selected >{{$a->name}}</option>
                                        @elseif(!in_array($user_detail->occupation,$occupation_array) && ($a->name != $user_detail->occupation))
                                            <option value="{{$a->name}}">{{$a->name}}</option>
                                        @endif
                                    @endforeach
                                    @if(!in_array($user_detail->occupation,$occupation_array) )
                                        <option value="{{$user_detail->occupation}}" selected="selected">{{$user_detail->occupation}}</option>
                                    @endif
                                    <option value="Others" >Others</option>
                                </select>
                            <!-- <input value="{{$user_detail->occupation}}"  placeholder="Occupation"  type="text" name="occupation"> -->
                            @endif
                            <input autocomplete="off" type="text"  name="" id="others_occupation" placeholder="Occupation" style="display: none;">

                            <label>Mobile Number</label>
                            @if($user_detail->phone==0)
                                <input placeholder="+1 (XXX) XXX XXXX" type="text" name="phone" required disabled>
                            @endif
                            @if($user_detail->phone!=0)
                                <input value="{{$user_detail->phone}}" style="border:{{$user_detail->otp_verified==1?'2px solid #0983b8':'2px solid #e78016'}}" placeholder="+1 (XXX) XXX XXXX" type="text" name="phone" required disabled>
                            @endif
                            <span style="color:{{$user_detail->otp_verified==1?'#0983b8':'#e78016'}}"><b>{{$user_detail->otp_verified==1?'Mobile Number is Verified':'Mobile Number is not Verified'}}</b></span>
                            <br>

                            <label>Email</label>
                            <input value="{{$user_detail->email}}" style="border:{{$user_detail->email_verified==1?'2px solid #0983b8':'2px solid #e78016'}}" type="text" name="email" required disabled>
                            <span style="color:{{$user_detail->email_verified==1?'#0983b8':'#e78016'}}"><b>{{$user_detail->email_verified==1?'Email is Verified':'Email not Verified'}}</b></span>
                            <br>

                            {{-- <!-- <label>Location</label>
                                                                    <input value="{{$user_detail->address}}" type="text" name="address"> --> --}}


                            <label>About Me</label>
                            <textarea name="about" id="about" cols="30" rows="10">@if($user_detail->about_me){{$user_detail->about_me}}@endif</textarea>
                            <p>*Please do not add any personal contact information for your privacy and safety</p>
                            @if($user_detail->role_id == 0)
                                <label>Tax Home</label>
                                <input value="@if($user_detail->tax_home) {{$user_detail->tax_home}} @endif" type="text" name="tax_home" >
                            @endif
                            <label>Languages Known</label>
                            <input value="{{$user_detail->languages_known!=""?$user_detail->languages_known:""}}" type="text" name="languages_known" placeholder="English, Spanish">

                            <input value="0" type="hidden" name="twitter_url">

                            @if($user_detail->gender)
                                <label> Gender</label>
                                <select name="gender" required>
                                    <option value=""></option>
                                    @if($user_detail->gender=='Male')
                                        <option value="Male" selected>Male</option>
                                    @else
                                        <option value="Male">Male</option>
                                    @endif
                                    @if($user_detail->gender=='Female')
                                        <option value="Female" selected>Female</option>
                                    @else
                                        <option value="Female">Female</option>
                                    @endif
                                    @if($user_detail->gender=='Others')
                                        <option value="Others" selected>Others</option>
                                    @else
                                        <option value="Others">Others</option>
                                    @endif
                                </select>
                            @endif


                            @if($user_detail->date_of_birth)

                                <label> Date of Birth</label>
                                <input  type="text"  required value="{{$user_detail->date_of_birth}}" id="date_birth" name="date_of_birth">
                            @endif


                            <div class="enable-auth-checkbox">
                                <input type="checkbox" name="enable_two_factor_auth" id="enable_two_factor_auth" @if("{$user_detail->enable_two_factor_auth}" == 1) checked @endif>
                                <span>Use two-factor authentication on every login</span>
                            </div>
                            <button type="submit" class="button margin-top-20 margin-bottom-20">Save Changes</button>
                        </form>
                    </div>

                    <div class="col-md-4">
                        <!-- Avatar -->
                        <div class="edit-profile-photo">
                            <div id="profileImage">
                                @if($user_detail->profile_image != " ")
                                    <img src="{{$user_detail->profile_image}}" alt="" style="border-radius: 100%;height: 150px;width: 150px;">
                                @else
                                    <img  src="/user_profile_default.png" style="border-radius: 100%;height: 150px;width: 150px;"/>
                                @endif

                            </div>
                            <div class="col-md-6">
                                <div class="change-photo-btn" id="upload_button">

                                    <div class="photoUpload">
                                        <span><i class="fa fa-upload"></i></span>
                                        <input type="file" id="profile_image" onchange="file_upload();" class="upload" name="profile_image" />
                                        <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                            </div>
                            <div id="uploading">

                            </div>
                            <div class="col-md-6">
                                <div class="change-photo-btn del" >
                                    <div class="photoUpload">
                                        <span id="delete_image" onclick="location.href='{{BASE_URL}}/owner/owner-delete-profile';"><i class="fa fa-trash"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#date_birth").datepicker({

            });
        });

        $('#agency_name').change(function(){
            var value=$(this).val();
            if(value=="Others"){
                $('#agency,#agency_show_single').hide();
                $('#others_show').show();
                $('#agency').attr('name','');
                $('#others_show').attr('name','name_of_agency');
                $('#agency_name').attr('name','');

            }else{
                $('#agency_name').attr('name','name_of_agency');
                $('#others_show').attr('name','');
                $('#others_show').hide();
            }
        });

        $('#occupation').change(function(){
            var value=$(this).val();
            //alert(value);
            if(value=="Others"){
                $('#others_occupation').show();
                $('#others_occupation').attr('name','occupation');
                $('#occupation').attr('name','');
                $('#occupation_desc').hide();

            }else{
                $('#others_show').hide();
                $('#occupation').attr('name','occupation');
                $('#others_occupation').attr('name','');
                $('#occupation_desc').show();
            }
        });

    </script>
@endsection
