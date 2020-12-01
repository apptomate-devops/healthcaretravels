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
                                    <div id="all_amenties" class="checkboxes in-row margin-bottom-20">
                                        @foreach($all_amenties->chunk(4) as $chunk)
                                            <div class='col-md-12'>
                                                @foreach($chunk as $amenty)
                                                    <div class="col-md-3">
                                                        <input id="{{$amenty->amenities_name}}" type="checkbox" name="{{str_replace(' ', '_', strtolower($amenty->amenities_name))}}" value="{{$amenty->amenities_name}}">
                                                        <label for="{{$amenty->amenities_name}}">{{$amenty->amenities_name}}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Checkboxes / End -->

                                </div>

                                <div class="text-center">
                                    {{--  @if(isset($property_details->is_complete) && $property_details->is_complete == 1)
                                                    <button id="button" class="button border margin-top-5" name="save" value="save" style="background-color: #e78016;">Save<i class="fa fa-save"></i></button>
                                                @endif --}}
                                    <button type="submit" class="button preview margin-top-50" value="NEXT">Save  <i class="fa fa-arrow-circle-right"></i></button>
                                </div>



                            </form>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script type="text/javascript">
        // var amenities = [{name: "Air Conditioner", id: 'Air_Conditioner', input_name: 'air_conditioner'}, {name: "All Bills Included", id: 'all_bils_included', input_name: 'all_bils_included'}, {name: "All Utilities Included", id: 'utilities', input_name: 'utilities'}, {name: "Breakfast Included", id: 'Breakfast_Included', input_name: 'breakfast_included'}, {name: "Cable", id: 'Cable', input_name: 'Cable'}, {name: "Coffee Pot", id: 'coffee_pot', input_name: 'coffee_pot'}, {name: "Computer", id: '', input_name: ''}, {name: "Doorman", id: '', input_name: ''}, {name: "Dryer", id: '', input_name: ''}, {name: "Elevator in Building", id: '', input_name: ''}, {name: "Fax", id: '', input_name: ''}, {name: "Free Parking on Premises", id: '', input_name: ''}, {name: "Garage", id: '', input_name: ''}, {name: "Gym", id: '', input_name: ''}, {name: "Heating", id: '', input_name: ''}, {name: "Hot Tub", id: '', input_name: ''}, {name: "Indoor Fireplace", id: '', input_name: ''}, {name: "Iron/Ironing Board", id: '', input_name: ''}, {name: "Kid Friendly", id: '', input_name: ''}, {name: "Kitchen", id: '', input_name: ''}, {name: "Netflix", id: '', input_name: ''}, {name: "Non Smoking", id: '', input_name: ''}, {name: "Pets Allowed", id: '', input_name: ''}, {name: "Phone", id: '', input_name: ''}, {name: "Pool", id: '', input_name: ''}, {name: "Pots/Pans", id: '', input_name: ''}, {name: "Roku", id: '', input_name: ''}, {name: "Scanner / Printer", id: '', input_name: ''}, {name: "Security Cameras (Exterior)", id: '', input_name: ''}, {name: "Smart TV", id: '', input_name: ''}, {name: "Smoking Allowed", id: '', input_name: ''}, {name: "TV", id: '', input_name: ''}, {name: "Towels", id: '', input_name: ''}, {name: "Washer", id: '', input_name: ''}, {name: "Wheelchair Accessible", id: '', input_name: ''}, {name: "Wireless Internet", id: '', input_name: ''}]

        var allAmenities = "";

    <?php if (count($amenties) != 0) {
        // $value=$amenties->amenties_name;
        foreach ($amenties as $a) { ?>
        console.log('{{$a->amenties_name}}');
                $("input[type=checkbox][value='{{$a->amenties_name}}']").prop("checked",true);
        <?php }
    } ?>

    </script>
@endsection
