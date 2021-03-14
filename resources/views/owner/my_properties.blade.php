@section('title')
    My Properties | {{APP_BASE_NAME}}
@endsection
    @extends('layout.master')
@section('main_content')

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
            
               <span id="errMsg"></span>

                <!-- <div class="row">
                
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                <h4 style="text-align:center;">{{ Session::get('success') }}</h4>
                            </div>
                        @endif

                        @if(Session::has('error'))
                            <div class="alert alert-danger">
                                <h4 style="text-align:center;">{{ Session::get('error') }}</h4>
                            </div>
                        @endif

                </div> -->
                <input type="hidden" id="delete_property_id" />
                <!-- Item #1 -->
                @if($properties != NULL && count($properties) != 0)
                    <table class="manage-table responsive-table">
                        <tr>
                            <th><i class="fa fa-file-text"></i> Property</th>
                            <th class="expire-date">
                                <div style="display: flex; align-items: center;"><i class="fa fa-calendar" style="margin-right: 7px;"></i><span> Status</span></div>
                            </th>
                            <th>Action</th>
                        </tr>
                        @foreach($properties as $property)
                            <tr>
                                <td class="title-container">

                                    <img src="{{$property->image_url}}" alt="">
                                    <div class="title">
                                        <h4><a href="{{BASE_URL}}property/{{$property->propertyId}}">{{$property->title}}</a></h4>
                                        <div class="description">
                                            <span>{{$property->description}} </span>
                                        </div>
                                        @if($property->monthly_rate == ZERO)
                                            <span class="table-property-price">Price not set</span>
                                        @else
                                            <span class="table-property-price">${{$property->monthly_rate}} / Month</span>
                                        @endif

                                    </div>
                                </td>
                                @if($property->is_complete == ZERO) {{--// incomplete--}}
                                <td class="expire-date">Pending</td>
                                @elseif($property->is_complete == ONE && $property->is_disable == ONE) {{--// incomplete--}}
                                <td class="expire-date">Disabled</td>
                                @elseif($property->is_complete == ONE && $property->propertyStatus == ONE) {{--// incomplete--}}
                                <td class="expire-date">Working</td>
                                @endif


                                <td class="action">
                                    <a class="icons" href="{{url('/')}}/owner/update-property/{{$property->propertyId}}" >
                                        <span class='tooltips'>
                                            <img src="{{BASE_URL}}action_icons/edit24.png" />
                                            <span class='tooltiptext'>Edit</span>
                                        </span>
                                    </a>
                                    {{-- <a href="{{BASE_URL}}delete-property/{{$property->propertyId}}" class="delete"  id="delete" title="Delete"> --}}
                                    <a class="icons delete" @if($property->delete_not_allowed) onclick="delete_property_not_allowed_alert();" @else onclick="delete_property({{$property->id}});" @endif id="delete">
                                        <span class='tooltips'>
                                        <img src="{{BASE_URL}}action_icons/24d.png" />
                                            <span class='tooltiptext'>Delete</span>
                                        </span>
                                    </a>

                                    <a href="{{BASE_URL}}owner/disable-property/{{$property->propertyId}}" class="icons delete">
                                        <span class='tooltips'>
                                            @if($property->is_disable == ONE)
                                                <img src="{{BASE_URL}}action_icons/enable24.png" />
                                                <span class='tooltiptext'>Enable Property</span>
                                            @else
                                                <img src="{{BASE_URL}}action_icons/disable24.png" />
                                                <span class='tooltiptext'>Disable Property</span>
                                            @endif
                                        </span>
                                    </a>



                                </td>
                                <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="exampleModalLabel"><b><span style="color:red">Warning</span></b></h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this property?
                                                <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" onclick="delete_property_with_id();" >Yes</button>
                                                <button type="button" class="btn btn-danger" style="width: 60px;" data-dismiss="modal">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade in" id="deleteNotAllowed" tabindex="-1" role="dialog" aria-labelledby="deleteNotAllowedLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="deleteNotAllowedLabel"><b><span style="color:red">Warning</span></b></h4>
                                            </div>
                                            <div class="modal-body">
                                                You have current or future bookings for this property. Please complete or cancel your bookings to delete your property.<br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <h4 class="info-text">No properties added</h4>
                @endif
                <a href="{{url('/')}}/owner/add-property" class="margin-top-40 button">Submit New Property</a>
            </div>
            <div id="addDetailsProgress" class="loading style-2" style="display: none;"><div class="loading-wheel"></div></div>
        </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript">

        function delete_property_not_allowed_alert(){
            $('#deleteNotAllowed').modal('show');
        }

        function delete_property(property_id){
            $('#myModal').modal('show');
            $("#delete_property_id").val(property_id);
        }

        function delete_property_with_id() {
            $('#myModal').modal('hide');
            $('#addDetailsProgress').show();
            var val = $("#delete_property_id").val();
            $.ajax({
                "type": "get",
                "url" : `{{BASE_URL}}owner/delete-property/${val}`,
                success: function(data) {
                    $('#addDetailsProgress').hide();
                    if(data.status=="SUCCESS"){
                        window.location.reload();
                    } else {
                        console.log('Error Deleting property');
                        $('#errMsg').css('color','red');
                        $('#errMsg').css('font-weight','bold');
                        $('#errMsg').css('font-size',17);
                        $('#errMsg').html('* '+ data.message);
                        $('#errMsg').css('display','block');
                    }
                },
                error: function (e) {
                    $('#addDetailsProgress').hide();
                    console.log('Error Deleting property');
                }
            });
        }
    </script>

@endsection
