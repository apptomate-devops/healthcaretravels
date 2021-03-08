@section('title')
    Property | {{APP_BASE_NAME}}
@endsection
@extends('layout.master')
@section('main_content')
    <style>
        .img_btn {
            position: absolute;
            top: 11%;
            left: 88%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            background-color: transparent;
            color: white;
            font-size: 16px;
            padding: 12px 24px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .img_btn:hover {
            background-color: red;
        }

        .cover_image {
            background-color: #e78016 !important;
        }

        .new_button{
            background-color: #0983b8;
            top: 7px;
            /* padding: 10px 20px; */
            color: #fff;
            position: relative;
            font-size: 16px;
            /* font-weight: 500; */
            /* display: inline-block; */
            /* transition: all 0.2s ease-in-out; */
            /* cursor: pointer; */
            /* margin-right: 6px; */
            /* overflow: hidden; */
            border: none;
            border-radius: 9px;
            width: 100%;
            height: -68%;
            max-height: 24%;
        }
    </style>
    <div class="container" style="margin-top: 35px;">
        <div class="row">

            <div class="col-md-12">
                <hr>
                <div>


                    <div class="dashboard-header">

                        <div class=" user_dashboard_panel_guide">

                            @include('owner.add-property.menu')

                        </div>
                    </div>

                    <!-- Tabs Content -->
                    <div class="tabs-container">


                        <div class="tab-content" id="tab3" style="display: none; padding-bottom: 0;">
                            <h3>Add Photos</h3>
                            <div class="submit-section">
                                <div class="row with-forms" style="padding: 0 15px;">
                                    <form action="{{BASE_URL}}owner/property/file-upload" method="post" enctype="multipart/form-data" class="dropzone" id="property-image">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <div  class="dz-default dz-message" data-property-images-count="{{count($property_images)}}">
                                            <span><i class="sl sl-icon-plus"></i> Click here to upload</span>
                                        </div>
                                    </form>
                                    <p>Add up to 20 images of your property. Check out our <a href="{{BASE_URL}}eye-catching-photos" target="_blank">article</a> on how to take great photos.</p>
                                    <p><span style="color: #e78016">* </span>You Can Upload Multiple Images</p>
                                    <p><span style="color: #e78016">* </span>Each image must be below 10 MB.</p>
                                    {{-- <h5>**Change images order with Drag & Drop.</h5> --}}
                                </div>
                            </div>

                            <div class="divider"></div>
                            {{--<button type="submit" class="button preview margin-top-5">SAVE
                                <i class="fa fa-arrow-circle-right"></i>
                            </button>--}}
                        </div>

                        @if(isset($property_images))
                            <div class="tab-content" id="tab4" style="padding-top: 0;">
                                <h3>Photos</h3>
                                <div class="submit-section">
                                    <div class="row with-forms">
                                        @foreach($property_images as $img)
                                            <div class="col-md-2" style="margin-top: 15px;" id="cover-img-{{$img->id}}">
                                                <img src="{{$img->image_url}}" height="150px" width="200px">
                                                <button class="img_btn" onclick="delete_image({{$img->id}})"><i class="fa fa-trash"></i>
                                                </button>
                                                @if($img->is_cover == 0)
                                                    <button id="cover-{{$img->id}}"  class="new_button" onclick="cover_image({{$img->id}})">Make Cover Photo</button>
                                                @else
                                                    <button id="cover-{{$img->id}}"  class="new_button cover_image" disabled="disabled">Cover Photo</button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="divider"></div>
                                {{--<button type="submit" class="button preview margin-top-5">SAVE
                                    <i class="fa fa-arrow-circle-right"></i>
                                </button>--}}
                            </div>
                    </div>
                    @endif

                    <form action="{{BASE_URL}}owner/add-new-property/5" method="post" name="form-add-new" id="property_submit_5">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="client_id" value="{{$client_id}}">
                        <input type="hidden" name="property_id" value="{{$property_details->id}}">
                        <div class="text-center">
                            <button type="submit" id="propertyImageSubmit" class="button preview" @if(count($property_images) == 0) disabled @endif>
                                SAVE
                                <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="propertyImagesProgress" class="loading style-2" style="display: none;"><div class="loading-wheel"></div></div>
        </div>

    </div>

    </div>
    </div>
    <script type="text/javascript">

        function delete_image(id){
            var url = window.location.protocol + "//" + window.location.host + "/delete_property_image/"+id;
            $('#propertyImagesProgress').show();
            $.ajax({
                "type": "get",
                "url" : url,
                success: function(data) {
                    // $(`div#cover-img-${id}`).remove();
                    // if(data.new_cover_image && data.new_cover_image.id) {
                    //     $(`button#cover-${data.new_cover_image.id}`).prop('disabled', true);
                    //     $(`button#cover-${data.new_cover_image.id}`).addClass('cover_image');
                    //     $(`button#cover-${data.new_cover_image.id}`).text('Cover Photo');
                    // }
                    $('#propertyImagesProgress').hide();
                    window.location.reload()
                },
                error: function (error) {
                    $('#propertyImagesProgress').hide();
                }
            });
        }
        function cover_image(id){
            $('#propertyImagesProgress').show();
            var prop_id={{$property_details->id}};
            var url = window.location.protocol + "//" + window.location.host + "/update_cover_image/"+id+"/"+prop_id;
            $.ajax({
                "type": "get",
                "url" : url,
                success: function(data) {
                    $('button.cover_image').prop('disabled', false);
                    $('button.cover_image').removeClass('cover_image');
                    $('button.cover_image').text('Make Cover Photo');
                    $(`button#cover-${id}`).prop('disabled', true);
                    $(`button#cover-${id}`).addClass('cover_image');
                    $(`button#cover-${id}`).text('Cover Photo');
                    $('#propertyImagesProgress').hide();
                },
                error: function (error) {
                    $('#propertyImagesProgress').hide();
                }
            });
        }
    </script>
    </body>{{-- https://maps.googleapis.com/maps/api/js?libraries=places&#038;language=en&#038;key=AIzaSyBWoWfqptSqcHj_tAT3khy2jjj7fuANNaM&#038;ver=1.0 --}}
    </html>

@endsection
