@extends('layout.master')
@section('title','Profile')
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

                <!-- Item #1 -->
                @if($properties != NULL && count($properties) != 0)
                    <table class="manage-table responsive-table">
                        <tr>
                            <th><i class="fa fa-file-text"></i> Property</th>
                            <th class="expire-date"><i class="fa fa-calendar"></i> Status</th>
                            <th></th>
                        </tr>
                        @foreach($properties as $property)
                            <tr>
                                <td class="title-container">

                                    <img src="{{$property->image_url}}" alt="">
                                    <div class="title">
                                        <h4><a href="{{BASE_URL}}property/{{$property->propertyId}}">{{$property->title}}</a></h4>
                                        <span>{{$property->description}} </span>
                                        @if($property->price_per_night == ZERO)
                                            <span class="table-property-price">Price not set</span>
                                        @else
                                            <span class="table-property-price">${{$property->price_per_night}} / per night</span>
                                        @endif

                                    </div>
                                </td>
                                @if($property->is_complete == ZERO) {{--// incomplete--}}
                                <td class="expire-date">Pending</td>
                                @endif
                                @if($property->is_complete == ONE && $property->propertyStatus == ZERO) {{--// incomplete--}}
                                <td class="expire-date">Disabled</td>
                                @endif

                                @if($property->is_complete == ONE && $property->propertyStatus == ONE) {{--// incomplete--}}
                                <td class="expire-date">Working</td>
                                @endif


                                <td class="action">
                                    <a href="{{url('/')}}/owner/update-property/{{$property->propertyId}}" >
                                        <img src="{{BASE_URL}}action_icons/edit24.png" title="Edit" />
                                    </a>
                                    {{-- <a href="{{BASE_URL}}delete-property/{{$property->propertyId}}" class="delete"  id="delete" title="Delete"> --}}
                                    <a class="delete"  onclick="delete_property();" id="delete" title="Delete">
                                        <img src="{{BASE_URL}}action_icons/24d.png" />
                                    </a>

                                    @if($property->propertyStatus == 0)
                                        <a href="{{BASE_URL}}disable-property/{{$property->propertyId}}" class="delete" title="Enable Property">
                                            <img src="{{BASE_URL}}action_icons/enable24.png" />
                                        </a>
                                    @else
                                        <a href="{{BASE_URL}}disable-property/{{$property->propertyId}}" class="delete" title="Disable Property">
                                            <img src="{{BASE_URL}}action_icons/disable24.png" />
                                        </a>
                                    @endif


                                </td>
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="exampleModalLabel"><b><span style="color:red">Warning</span></b></h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this property
                                                <br> <br>
                                                <span style="float: right;">
            	<a href="{{BASE_URL}}delete-property/{{$property->propertyId}}"><button type="button" class="btn btn-primary" >Yes</button></a>
            	{{-- <a href="{{BASE_URL}}delete-property/"><button type="button" class="btn btn-primary" >Yes</button></a>  --}}
            	<a href=""><button type="button" class="btn btn-danger">No</button></a>
            </span>
                                                <br> <br>
                                            </div>
                                            {{-- <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div> --}}
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

        </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript">

        function delete_property(){

            $('#myModal').modal();
        }


    </script>

@endsection
