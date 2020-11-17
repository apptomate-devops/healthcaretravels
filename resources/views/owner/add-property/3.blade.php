@extends('layout.master') @section('title','Profile') @section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/property.css') }}">

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
                    <div class="tab-content" id="tab5" style="display: none;">
                        <form action="{{url('/')}}/owner/add-new-property/3" method="post" name="form-add-new">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="client_id" value="{{$client_id}}">
                            <input type="hidden" name="property_id" value="{{$property_details->id}}">
                            <h3>Listing :</h3>

                            <div class="row with-forms container">
                                <div class="col-md-6">
                                    <h5>Property Title <span class="required">*</span></h5>
                                    <input class="search-field validate" type="text" value="{{isset($property_data->title)?$property_data->title:''}}"  id="value" name="title" />
                                </div>
                            </div>


                            <div class="row with-forms container">
                                <div class="col-md-6">
                                    <h5>Description <span class="required">*</span></h5>
                                    <p class="caption-text">Please do not add any personal contact information for your privacy and safety.</p>
                                    <textarea id="button" class="search-field validate" id="value" name="description">{{isset($property_data->description)?$property_data->description:''}}</textarea>
                                </div>
                            </div>

                            <div class="row with-forms container">
                                <div class="col-md-6">
                                    <h5>House Rules</h5>
                                    <textarea  class="search-field" id="house_rules" name="house_rules">{{isset($property_data->house_rules)?$property_data->house_rules:''}}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12 form-row">
                                <h3>Trash Pickup Days: </h3>
                                <div class="checkboxes in-row" id="trash_days">

                                    <input id="check-2"  value="Sun" name="trash_pickup_days[]" type="checkbox" name="check">
                                    <label for="check-2" >Sunday</label>

                                    <input id="check-3" name="trash_pickup_days[]" value="Mon" type="checkbox" name="check">
                                    <label for="check-3">Monday</label>

                                    <input id="check-4" name="trash_pickup_days[]" value="Tue" type="checkbox" name="check">
                                    <label for="check-4"  >Tuesday</label>

                                    <input id="check-5" value="Wed" name="trash_pickup_days[]" type="checkbox" name="check">
                                    <label for="check-5" >Wednesday</label>


                                    <input id="check-6" value="Thu" name="trash_pickup_days[]" type="checkbox" name="check">
                                    <label for="check-6" >Thursday</label>
                                    <br><br>

                                    <input id="check-7" value="Fri" name="trash_pickup_days[]" type="checkbox" name="check">
                                    <label for="check-7" >Friday</label>

                                    <input id="check-8" value="Sat" name="trash_pickup_days[]" type="checkbox" name="check">
                                    <label for="check-8" >Saturday</label>

                                </div>
                            </div>

                            <div class="col-md-12"><br><br>
                                <h3>Lawn Services<span class="required">*</span> :</h3>
                                <div class="checkboxes in-row">

                                    <input id="lawn_yes" name="lawn_service" type="checkbox" value="1" name="check">
                                    <label for="lawn_yes" >Yes</label>

                                    <input id="lawn_no" name="lawn_service" type="checkbox" value="0" name="check">
                                    <label for="lawn_no" value="1">No</label>
                                </div>
                            </div>

                            <div class="col-md-12"><br><br>
                                <h3>Pets Allowed<span class="required">*</span> :</h3>
                                <div class="checkboxes in-row">

                                    <input id="pet_yes" name="pets_allowed" type="checkbox" value="1" >
                                    <label for="pet_yes" >Yes</label>

                                    <input id="pet_no" name="pets_allowed" type="checkbox" value="0" >
                                    <label for="pet_no" value="1">No</label>
                                </div>
                            </div>



                            <div class="text-center">

                                <input type="hidden" id="lat" name="lat" value="{{$property_details->lat}}">
                                <input type="hidden" id="lng" name="lng" value="{{$property_details->lng}}">

                                <!--   <div class="col-md-10">
                                      <input  type="button" class="button preview" value="PREVIOUS">
                              </div> -->
                                {{-- @if(isset($property_details->is_complete) && $property_details->is_complete == 1)
                                    <button id="button" class="button border margin-top-5" name="save" value="save" style="background-color: #e78016;">Save<i class="fa fa-save"></i></button>
                                @endif --}}
                                <button type="submit" id="button" class="button preview margin-top-5" value="NEXT">Save  <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </form>

                    </div>

                    <input type="hidden" id="before_lat" value="{{$property_details->lat}}">
                    <input type="hidden" id="before_lng" value="{{$property_details->lng}}">
                </div>

            </div>

        </div>
    </div>
    <script type="text/javascript">
        var propertyData = <?php echo json_encode($property_data); ?>;
        debugger
        if(propertyData.trash_pickup_days) {
            var pickupDays = propertyData.trash_pickup_days.split(',');
            console.log(pickupDays);
            pickupDays.forEach(function (day) {
                $(`input[type=checkbox][value=${day}]`).prop("checked",true);
            })
        }

        if(propertyData.is_complete == 1) {
            var isLawnServiceAvailable = propertyData.lawn_service;
            $('#lawn_no').attr('checked', !isLawnServiceAvailable);
            $('#lawn_yes').attr('checked', !!isLawnServiceAvailable);

            var isPetsAllowed = propertyData.pets_allowed;
            $('#pet_no').attr('checked', !isPetsAllowed);
            $('#pet_yes').attr('checked', !!isPetsAllowed);
        }

        $('#lawn_no,#lawn_yes').change(function(){
            var value=$(this).val();
            if(value==1){
                $('#lawn_no').attr('checked',false);
            }else{
                $('#lawn_yes').attr('checked',false);
            }
        })
        $('#pet_no,#pet_yes').change(function(){
            var value=$(this).val();
            if(value==1){
                $('#pet_no').attr('checked',false);
            }else{
                $('#pet_yes').attr('checked',false);
            }
        })


    </script>


@endsection
