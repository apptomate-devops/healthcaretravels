@extends('layout.master') @section('title','Profile') @section('main_content')
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


                            <div class="tab-content" id="tab3" style="display: none;">
                                <h3>Add Photo</h3>
                                <div class="submit-section">
                                    <div class="row with-forms">

                                        <div class="col-md-6">
                                            <form action="{{url('/')}}/owner/property/file-upload" class="dropzone dz-clickable">
                                                <div  class="dz-default dz-message">
                                                    <span>
                                                         <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        <i class="sl sl-icon-plus"></i> Click here or drop files to upload
                                                    </span>
                                                </div>
                                            </form>
                                            <h5 style="color: #e78016">*You Can Upload Multiple Images</h5>
                                            {{-- <h5>**Change images order with Drag & Drop.</h5> --}}
                                        </div>

                                        <form action="{{url('/')}}/owner/add-new-property/7" method="post" name="form-add-new">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <input type="hidden" name="client_id" value="{{$client_id}}">
                                            <input type="hidden" name="property_id" value="{{$property_details->id}}">

                                            

                                            <div class="divider"></div>
                                            <button type="submit" class="button preview margin-top-5" style="margin-top: 130px !important;float: right;">
                                                SAVE
                                                <i class="fa fa-arrow-circle-right"></i>
                                            </button>
                                        </form>

                                    </div>
                                </div>

                                <div class="divider"></div>
                                {{--<button type="submit" class="button preview margin-top-5">SAVE
                                    <i class="fa fa-arrow-circle-right"></i>
                                </button>--}}
                            </div>

                         @if(isset($property_images))
                         <div class="tab-content" id="tab4" >
                            <h3>Photos</h3>
                            <div class="submit-section">
                                <div class="row with-forms">
                                    @foreach($property_images as $img)
                                    <div class="col-md-2">
                                        <img src="{{$img->image_url}}" height="150px" width="200px">
                                        <button class="img_btn" onclick="delete_image({{$img->id}})"><i class="fa fa-trash"></i>
                                        </button>
                                        @if($img->is_cover == 0)
                                            <button  class="new_button" onclick="cover_image({{$img->id}})">Make Cover Photo</button>
                                        @else
                                            <button  class="new_button cover_image" disabled="disabled">Cover Photo</button>
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

                </div>

            </div>

        </div>

    </div>
    </div>
    <script type="text/javascript">

        function delete_image(id){
            var url = window.location.protocol + "//" + window.location.host + "/delete_property_image/"+id;

            $.ajax({
                "type": "get",
                "url" : url,
                success: function(data) {
                    location.reload();
                }
            });
        }
        function cover_image(id){
            var prop_id={{$property_details->id}};
            var url = window.location.protocol + "//" + window.location.host + "/update_cover_image/"+id+"/"+prop_id;
            $.ajax({
                "type": "get",
                "url" : url,
                success: function(data) {
                    location.reload();
                }
            });
        }

        function show_table(id) {
            var name=document.getElementById('name').value;
            var value=document.getElementById('value').value;
            var single_fee=document.getElementById('single_fee').value;

            document.getElementById('rname').value =(name);
            document.getElementById('rvalue').value =(value);
            document.getElementById('rsingle_fee').value =(single_fee);
            var ix;

            for (ix = 1;  ix <= 6;  ++ix) {
                document.getElementById('table' + ix).style.display='none';
            }
            if (typeof id === "number") {
                document.getElementById('table'+id).style.display='block';
            } else if (id && id.length) {
                for (ix = 0;  ix < id.length;  ++ix) {
                    document.getElementById('table'+ix).style.display='block';
                }
            }

        }

    </script>



    </body>{{-- https://maps.googleapis.com/maps/api/js?libraries=places&#038;language=en&#038;key=AIzaSyBWoWfqptSqcHj_tAT3khy2jjj7fuANNaM&#038;ver=1.0 --}}
    </html>

@endsection
