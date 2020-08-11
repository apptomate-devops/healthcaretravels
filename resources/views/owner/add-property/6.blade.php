@extends('layout.master') @section('title','Profile') @section('main_content')

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

                    <div class="tab-content" id="tab6" style="display: none;">

                        <form action="{{url('/')}}/owner/add-new-property/6" method="post" name="form-add-new">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="client_id" value="{{$client_id}}">
                            <input type="hidden" name="property_id" value="{{$property_details->id}}">

                            <h3>Amenities and Features</h3>
                            <div class="submit-section">

                                <!-- Checkboxes -->
                                <h5><b>Select the amenities and features that apply for your property</b></h5>
                                <div class="checkboxes in-row margin-bottom-20">

                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <input id="Kitchen" type="checkbox" name="Kitchen" value="Kitchen">
                                            <label for="Kitchen">Kitchen</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Cable" type="checkbox" name="Cable" value="Cable">
                                            <label for="Cable">Cable</label>
                                        </div><!--   <div class="col-md-3">
                                            <input id="Internet" type="checkbox" name="internet">
                                            <label for="Internet">Internet</label>
                                        </div> -->
                                        <div class="col-md-3">
                                            <input id="Smoking_Allowed" type="checkbox" name="smoking_allowed" value="Smoking Allowed">
                                            <label for="Smoking_Allowed">Smoking Allowed</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Tv" type="checkbox" name="tv" value="Tv">
                                            <label for="Tv">TV</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <input id="Wheelchair_Accessible" type="checkbox" name="wheelchair_accessible" value="Wheelchair Accessible">
                                            <label for="Wheelchair_Accessible">Wheelchair Accessible</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Elevator_in_Building" type="checkbox" name="elevator_in_building" value="Elevator in Building">
                                            <label for="Elevator_in_Building">Elevator in Building</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Indoor_Fireplace" type="checkbox" name="indoor_fireplace" value="Indoor Fireplace">
                                            <label for="Indoor_Fireplace">Indoor Fireplace</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Heating" type="checkbox" name="heating" value="Heating">
                                            <label for="Heating">Heating</label>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <input id="Essentials" type="checkbox" name="essentials" value="Essentials">
                                            <label for="Essentials">Essentials</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Doorman" type="checkbox" name="door_man" value="Doorman">
                                            <label for="Doorman">Doorman</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Pool" type="checkbox" name="pool" value="Pool">
                                            <label for="Pool">Pool</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Washer" type="checkbox" name="washer" value="Washer">
                                            <label for="Washer">Washer</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <input id="Hot_Tub" type="checkbox" name="hot_tub" value="Hot Tub">
                                            <label for="Hot_Tub">Hot Tub</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Dryer" type="checkbox" name="dryer" value="Dryer">
                                            <label for="Dryer">Dryer</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Gym" type="checkbox" name="gym" value="Gym">
                                            <label for="Gym">Gym</label>
                                        </div>
                                         <div class="col-md-3">
                                            <input id="Pots_Pans" type="checkbox" name="pots_and_pans" value="Pots and Pans">
                                            <label for="Pots_Pans">Pots/Pans</label>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <input id="Wireless_Internet" type="checkbox" name="wireless_internet" value="Wireless Internet">
                                            <label for="Wireless_Internet">Wireless Internet</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Pets_Allowed" type="checkbox" name="pets_allowed" value="Pets Allowed">
                                            <label for="Pets_Allowed">Pets Allowed</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Kid_Friendly" type="checkbox" name="kid_friendly" value="Kid Friendly">
                                            <label for="Kid_Friendly">Kid Friendly</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Computer" type="checkbox" name="computer" value="Computer">
                                            <label for="Computer">Computer</label>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <input id="Non_Smoking" type="checkbox" name="non_smoking" value="Non Smoking">
                                            <label for="Non_Smoking">Non Smoking</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Phone" type="checkbox" name="phone" value="Phone">
                                            <label for="Phone">Phone</label>
                                        </div>
                                        <!-- <div class="col-md-3">
                                            <input id="Projector" type="checkbox" name="projector">
                                            <label for="Projector">Projector</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Restaurant" type="checkbox" name="restaurant">
                                            <label for="Restaurant">Restaurant</label>
                                        </div> -->
                                        <div class="col-md-3">
                                            <input id="all_bils_included" type="checkbox" name="all_bils_included" value="All Bils Included">
                                            <label for="all_bils_included">All Bills Included</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="security_cameras" type="checkbox" name="security_cameras" value="Security Cameras">
                                            <label for="security_cameras"> Security Cameras</label>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <input id="Air_Conditioner" type="checkbox" name="air_conditioner" value="Air Conditioner">
                                            <label for="Air_Conditioner">Air Conditioner</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Scanner_Printer" type="checkbox" name="scanner_printer" value="Scanner Printer">
                                            <label for="Scanner_Printer">Scanner / Printer</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Fax" type="checkbox" name="fax" value="Fax">
                                            <label for="Fax">Fax</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Breakfast_Included" type="checkbox" name="breakfast_included" value="Breakfast Included">
                                            <label for="Breakfast_Included">Breakfast Included</label>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <input id="Smart_TV" type="checkbox" name="smart_tv" value="Smart Tv">
                                            <label for="Smart_TV">Smart TV</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Garage" type="checkbox" name="garage" value="Garage">
                                            <label for="Garage">Garage</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Towels" type="checkbox" name="towels" value="Towels">
                                            <label for="Towels">Towels</label>
                                        </div>
                                       
                                        <div class="col-md-3">
                                            <input id="Free_Parking_on_Premises" type="checkbox" name="free_parking_on_premises" value="Free Parking on Premises">
                                            <label for="Free_Parking_on_Premises">Free Parking on Premises</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <input id="Netflix" type="checkbox" name="netflix" value="Netflix">
                                            <label for="Netflix">Netflix</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="Coffee-pot" type="checkbox" name="coffee_pot" value="Coffee Pot">
                                            <label for="Coffee-pot">Coffee Pot</label>
                                        </div>
                                        
                                    </div>



                                </div>
                                <!-- Checkboxes / End -->

                            </div>



                            <div class="col-md-3">
                                <h5>&nbsp;</h5>
                            </div>
                            <div class="col-md-3">
                                <h5>&nbsp;</h5>
                            </div>
                            <div class="col-md-3">
                                <h5>&nbsp;</h5>
                            </div>
                            <div class="col-md-3" style="
                                 margin-top: 40px;
                                 margin-bottom: 50px;
                                 ">

                                <div class="divider"></div>
                               {{--  @if(isset($property_details->is_complete) && $property_details->is_complete == 1)
                                                <button id="button" class="button border margin-top-5" name="save" value="save" style="background-color: #e78016;">Save<i class="fa fa-save"></i></button>
                                            @endif --}}
                                <button type="submit" class="button preview margin-top-5" value="NEXT">Save  <i class="fa fa-arrow-circle-right"></i></button>
                            </div>



                        </form>
                    </div>





                </div>

            </div>

        </div>

    </div>

</div>
</div>
<script type="text/javascript">



    function show_table(id) {
        var name = document.getElementById('name').value;
        var value = document.getElementById('value').value;
        var single_fee = document.getElementById('single_fee').value;

        document.getElementById('rname').value = (name);
        document.getElementById('rvalue').value = (value);
        document.getElementById('rsingle_fee').value = (single_fee);
        var ix;

        for (ix = 1; ix <= 6; ++ix) {
            document.getElementById('table' + ix).style.display = 'none';
        }
        if (typeof id === "number") {
            document.getElementById('table' + id).style.display = 'block';
        } else if (id && id.length) {
            for (ix = 0; ix < id.length; ++ix) {
                document.getElementById('table' + ix).style.display = 'block';
            }
        }

    }

</script>
<script type="text/javascript">
    $('.date_picker').datepicker({});
    var date = new Date();
    //date.setDate(date.getDate()-1);
    $('#from_date').datepicker({
        startDate: date
    });

    function set_to_date() {
        // body...
        var from_date = $('#from_date').val();
        $('#to_date').datepicker({
            startDate: from_date
        });
    }

    <?php if (count($amenties) != 0) {
        // $value=$amenties->amenties_name;
        foreach ($amenties as $a) { ?>
        console.log('{{$a->amenties_name}}');
                $("input[type=checkbox][value='{{$a->amenties_name}}']").prop("checked",true);

        <?php }
    } ?>


</script>


</body>{{-- https://maps.googleapis.com/maps/api/js?libraries=places&#038;language=en&#038;key=AIzaSyBWoWfqptSqcHj_tAT3khy2jjj7fuANNaM&#038;ver=1.0 --}}
</html>

@endsection
