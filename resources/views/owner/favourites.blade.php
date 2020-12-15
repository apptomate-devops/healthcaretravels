@extends('layout.master')
@section('title','Favourite properties')
@section('main_content')
    <style>
        .show {
            opacity: 1;
            padding-top: 60px;
        }
    </style>
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
                <input type="hidden" id="favourite_property_id" />

                <table class="manage-table responsive-table">

                    <tr>
                        <th><i class="fa fa-file-text"></i> Favorite Properties</th>
                        <th></th>
                        <th class="expire-date"><i class="fa fa-calendar"></i> Action</th>

                    </tr>

                    <!-- Item #1 -->
                    @foreach($properties as $property)
                        <tr>
                            <td class="title-container">

                                @if($property->image_url != null)
                                    <img src="{{$property->image_url}}" alt="">
                                @else
                                    <img src="{{STATIC_IMAGE}}" alt="">
                                @endif
                                <div class="title">
                                    <h4><a href="{{BASE_URL}}property/{{$property->property_id}}">{{$property->title}}</a></h4>
                                    <span>{{$property->description}} </span>
                                </div>
                            </td>

                            <td></td>

                            <td class="action">
                                <button onclick="remove_property_from_favourite({{$property->property_id}})" class="button" style="background-color: #0983b8;">
                                    <mark style="color: white;background-color: #0983b8;font-size: 16px;"> &nbsp;Remove&nbsp;</mark>
                                </button>
                            </td>
                        </tr>
                    @endforeach


                </table>
            </div>

        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b><span style="color:red">Warning</span></b></h4>
                    </div>
                    <div class="modal-body">
                        You are about to remove this listing from your favorites
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="remove_favourite();" >Yes</button>
                        <button type="button" class="btn btn-danger" style="width: 60px; border-radius: 9px;" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="addDetailsProgress" class="loading style-2" style="display: none;"><div class="loading-wheel"></div></div>
    </div>

    <script type="text/javascript">
        function remove_property_from_favourite(property_id){
            $('#myModal').modal('show');
            $("#favourite_property_id").val(property_id);
        }

        function remove_favourite() {
            $('#myModal').modal('hide');
            $('#addDetailsProgress').show();
            var val = $("#favourite_property_id").val();
            var url = '{{BASE_URL}}add_property_to_favourite/'+val;
            $.ajax({
                "type": "get",
                "url" : url,
                success: function (data) {
                    $('#addDetailsProgress').hide();
                    if(data.status == 'SUCCESS') {
                        location.reload();
                    }
                },
                error: function (error) {
                    $('#addDetailsProgress').hide();
                    console.log("error adding data to success", error);
                }
            });
        }
    </script>
@endsection
