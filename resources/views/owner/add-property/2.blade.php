@section('title')
    Property | {{APP_BASE_NAME}}
@endsection
@extends('layout.master')
@section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/property.css') }}">
    <div class="container add-property">
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

                        <div class="tab-content" id="tab4" style="display: none;">
                            <h3>Property Details</h3>
                            <div class="submit-section">
                            </div>

                            <form action="{{BASE_URL}}owner/add-new-property/2" method="post" name="form-add-new">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="client_id" value="{{CLIENT_ID}}">
                                <input type="hidden" name="property_id" value="{{$property_details->id}}">

                                <div class="row with-forms">

                                    <div class="col-md-6">
                                        <h5>Property Type<span class="required">*</span></h5>
                                        <select class="chosen-select-no-single validate" name="property_type" required>
                                            <option label=""></option>
                                            @foreach($property_types as $pro)
                                                <option value="{{$pro->name}}" @if($property_details->property_category == $pro->name) selected @endif>{{$pro->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <h5>Number of allowed guests<span class="required">*</span></h5>
                                        <p class="caption-text">Enter how many guests a tenant is permitted to have on the premises</p>
                                        <select class="chosen-select-no-single validate" name="guest_count" id="guest_count" data-placeholder="How many guests can stay on your property?">
                                            <option label=""></option>
                                            @for($i=1;$i<=$guest_count;$i++)
                                                <option value="{{$i}}">{{$i}} Guest{{$i > 1 ? 's' : ''}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                </div>

                                <div class="row with-forms">

                                    <div class="col-md-6">
                                        <h5>Home Type<span class="required">*</span></h5>
                                        <select class="chosen-select-no-single validate" name="room_type" id="room_type">
                                            <option label=""></option>
                                            @foreach($room_types as $room)
                                                <option value="{{$room->name}}" @if($property_details->room_type == $room->name) selected @endif>{{$room->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <h5>How Many Bathrooms<span class="required">*</span></h5>

                                        <select class="chosen-select-no-single validate" id="bathrooms" name="bathroom_count" data-placeholder="Select Bathrooms">
                                            <option></option>
                                            <option value="1">1 Bathroom</option>
                                            <option value="1.5">1.5 Bathrooms</option>
                                            <option value="2">2 Bathrooms</option>
                                            <option value="2.5">2.5 Bathrooms</option>
                                            <option value="3">3 Bathrooms</option>
                                            <option value="3.5">3.5 Bathrooms</option>
                                            <option value="4">4 Bathrooms</option>
                                            <option value="4.5">4.5 Bathrooms</option>
                                            <option value="5">5 Bathrooms</option>
                                            <option value="5.5">5.5 Bathrooms</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="row with-forms">
                                    <div class="col-md-6">
                                        <h5>Property sq ft<span class="required">*</span></h5>
                                        <input class="search-field validate" type="text" value="{{isset($property_data->property_size)?$property_data->property_size:''}}" id="property_size" name="property_size"/>
                                    </div>

                                    <div class="col-md-6">

                                        <h5>How Many Bedrooms<span class="required">*</span></h5>
                                        <select onchange="dynamic_rooms();" class="chosen-select-no-single validate"
                                                id="bedrooms" name="no_of_bedrooms">
                                            <option value=0>Select Bedrooms</option>
                                            @for($i=1;$i<=$guest_count;$i++)
                                                @if($i == 1)
                                                    <option value="{{$i}}">{{$i}} Bedroom</option>
                                                @else
                                                    <option value="{{$i}}">{{$i}} Bedrooms</option>
                                                @endif
                                            @endfor
                                        </select>

                                        <h5></h5>
                                        <input class="search-field validate" type="hidden" value="1" id="value" name="common_spaces"/>
                                    </div>

                                </div>



                                <div class="row with-forms">



                                    <div class="col-md-6">

                                    </div>


                                </div>
                                <input type="hidden" value="@if(count($property_bedrooms) > 0) {{$property_room->bed_count}} @else 0 @endif" id="bed_count" name="bed_count"/>
                                <div class="incremental-counter">
                                    <div class="row with-forms">
                                        <h4>Bed Types</h4>
                                    </div>
                                    <div class="row with-forms">
                                        <div class="counter-inputs">
                                            <input type="hidden" name="c_double_bed[]" id="double_input25" value="@if(isset($common_spc['double_bed'])) {{$common_spc['double_bed']}} @else 0 @endif"/>
                                            <div class="col-xs-6">
                                                <p>Double</p>
                                            </div>
                                            <div class="col-xs-6">
                                                <a onclick="minus(25);"><img src="{{BASE_URL}}minus.png"></a>
                                                <span id="doubles25">@if(isset($common_spc['double_bed'])){{$common_spc['double_bed']}} @else 0 @endif</span>
                                                <a onclick="plus(25);"><img src="{{BASE_URL}}plus.png"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row with-forms">
                                        <div class="counter-inputs">
                                            <input type="hidden" name="c_queen_bed[]" id="queen_input25" value="@if(isset($common_spc['queen_bed'])){{$common_spc['queen_bed']}} @else 0 @endif"/>
                                            <div class="col-xs-6">
                                                <p>Queen</p>
                                            </div>
                                            <div class="col-xs-6">
                                                <a onclick="queen_minus(25);"><img src="{{BASE_URL}}minus.png"></a>
                                                <span id="queen25">@if(isset($common_spc['queen_bed'])){{$common_spc['queen_bed']}} @else 0 @endif</span>
                                                <a onclick="queen_plus(25);"><img src="{{BASE_URL}}plus.png"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row with-forms">
                                        <div class="counter-inputs">
                                            <input type="hidden" name="c_single_bed[]" id="single_input25" value="@if(isset($common_spc['single_bed'])){{$common_spc['single_bed']}} @else 0 @endif"/>
                                            <div class="col-xs-6">
                                                <p>Single</p>
                                            </div>
                                            <div class="col-xs-6">
                                                <a onclick="single_minus(25);"><img src="{{BASE_URL}}minus.png"></a>
                                                <span id="single25">@if(isset($common_spc['single_bed'])){{$common_spc['single_bed']}} @else 0 @endif</span>
                                                <a onclick="single_plus(25);"><img src="{{BASE_URL}}plus.png"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row with-forms">
                                        <div class="counter-inputs">
                                            <input type="hidden" name="c_sofa_bed[]" id="sofa_input25" value="@if(isset($common_spc['sofa_bed'])){{$common_spc['sofa_bed']}} @else 0 @endif"/>
                                            <div class="col-xs-6">
                                                <p>Sofa bed</p>
                                            </div>
                                            <div class="col-xs-6">
                                                <a onclick="sofa_minus(25);"><img src="{{BASE_URL}}minus.png"></a>
                                                <span id="sofa25">@if(isset($common_spc['sofa_bed'])){{$common_spc['sofa_bed']}} @else 0 @endif</span>
                                                <a onclick="sofa_plus(25);"><img src="{{BASE_URL}}plus.png"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row with-forms">
                                        <div class="counter-inputs">
                                            <input type="hidden" name="c_bunk_bed[]" id="bunk_input25" value="@if(isset($common_spc['bunk_bed'])){{$common_spc['bunk_bed']}} @else 0 @endif"/>
                                            <div class="col-xs-6">
                                                <p>Bunk Bed</p>
                                            </div>
                                            <div class="col-xs-6">
                                                <a onclick="bunk_minus(25);"><img src="{{BASE_URL}}minus.png"></a>
                                                <span id="bunk25">@if(isset($common_spc['bunk_bed'])){{$common_spc['bunk_bed']}} @else 0 @endif</span>
                                                <a onclick="bunk_plus(25);"><img src="{{BASE_URL}}plus.png"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row with-forms">
                                        <h4>Total Beds :<span id="total_beds25">@if(isset($common_spc['total'])){{$common_spc['total']}} @else 0 @endif</span></h4>
                                    </div>
                                </div>

                                @if(count($property_bedrooms) > 0)
                                    @for($i=1;$i<count($property_bedrooms)+1;$i++)
                                        <div class="incremental-counter">
                                            <div class="row with-forms">
                                                <h4>Room {{$i}} Beds</h4>
                                            </div>
                                            <div class="row with-forms">
                                                <div class="counter-inputs">
                                                    <input type="hidden" name="double_bed[]" id="double_input{{$i}}" value="@if(isset($property_bedrooms[$i]['double_bed'])) {{$property_bedrooms[$i]['double_bed']}} @else 0 @endif"/>
                                                    <div class="col-xs-6">
                                                        <p>Double</p>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <a onclick="minus({{$i}});"><img src="{{BASE_URL}}minus.png"></a>
                                                        <span id="doubles{{$i}}">@if(isset($property_bedrooms[$i]['double_bed'])){{$property_bedrooms[$i]['double_bed']}} @else 0 @endif</span>
                                                        <a onclick="plus({{$i}});"><img src="{{BASE_URL}}plus.png"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row with-forms">
                                                <div class="counter-inputs">
                                                    <input type="hidden" name="queen_bed[]" id="queen_input{{$i}}" value="@if(isset($property_bedrooms[$i]['queen_bed'])){{$property_bedrooms[$i]['queen_bed']}} @else 0 @endif"/>
                                                    <div class="col-xs-6">
                                                        <p>Queen</p>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <a onclick="queen_minus({{$i}});"><img src="{{BASE_URL}}minus.png"></a>
                                                        <span id="queen{{$i}}">@if(isset($property_bedrooms[$i]['queen_bed'])){{$property_bedrooms[$i]['queen_bed']}} @else 0 @endif</span>
                                                        <a onclick="queen_plus({{$i}});"><img src="{{BASE_URL}}plus.png"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row with-forms">
                                                <div class="counter-inputs">
                                                    <input type="hidden" name="single_bed[]" id="single_input{{$i}}" value="@if(isset($property_bedrooms[$i]['single_bed'])){{$property_bedrooms[$i]['single_bed']}} @else 0 @endif"/>
                                                    <div class="col-xs-6">
                                                        <p>Single</p>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <a onclick="single_minus({{$i}});"><img src="{{BASE_URL}}minus.png"></a>
                                                        <span id="single{{$i}}">@if(isset($property_bedrooms[$i]['single_bed'])){{$property_bedrooms[$i]['single_bed']}} @else 0 @endif</span>
                                                        <a onclick="single_plus({{$i}});"><img src="{{BASE_URL}}plus.png"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row with-forms">
                                                <div class="counter-inputs">
                                                    <input type="hidden" name="sofa_bed[]" id="sofa_input{{$i}}" value="@if(isset($property_bedrooms[$i]['sofa_bed'])){{$property_bedrooms[$i]['sofa_bed']}} @else 0 @endif"/>
                                                    <div class="col-xs-6">
                                                        <p>Sofa bed</p>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <a onclick="sofa_minus({{$i}});"><img src="{{BASE_URL}}minus.png"></a>
                                                        <span id="sofa{{$i}}">@if(isset($property_bedrooms[$i]['sofa_bed'])){{$property_bedrooms[$i]['sofa_bed']}} @else 0 @endif</span>
                                                        <a onclick="sofa_plus({{$i}});"><img src="{{BASE_URL}}plus.png"></a>                                            </div>
                                                </div>
                                            </div>
                                            <div class="row with-forms">
                                                <div class="counter-inputs">
                                                    <input type="hidden" name="bunk_bed[]" id="bunk_input{{$i}}" value="@if(isset($property_bedrooms[$i]['bunk_bed'])){{$property_bedrooms[$i]['bunk_bed']}} @else 0 @endif"/>
                                                    <div class="col-xs-6">
                                                        <p>Bunk Bed</p>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <a onclick="bunk_minus({{$i}});"><img src="{{BASE_URL}}minus.png"></a>
                                                        <span id="bunk{{$i}}">@if(isset($property_bedrooms[$i]['bunk_bed'])){{$property_bedrooms[$i]['bunk_bed']}} @else 0 @endif</span>
                                                        <a onclick="bunk_plus({{$i}});"><img src="{{BASE_URL}}plus.png"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row with-forms">
                                                <h4>Total Beds :<span id="total_beds{{$i}}">@if(isset($property_bedrooms[$i]['total'])){{$property_bedrooms[$i]['total']}}@else 0 @endif</span></h4>
                                            </div>
                                            <br><hr><br>
                                        </div>

                                    @endfor
                                    <div id="dynamic_bedrooms"></div>


                                @else
                                    <div id="dynamic_bedrooms"></div>
                                @endif
                                <br><hr> <br>
                                <div id="cur_occupancy" @if($property_data->room_type === 'Entire Place') style="display: none;" @endif">
                                <div class="incremental-counter">
                                    <div class="row with-forms">
                                        <h4>Current Occupancy </h4>
                                    </div>
                                    <div class="row with-forms">
                                        <p>How many others will be sharing the property with the booker?</p>
                                    </div>
                                    <div class="row with-forms">
                                        <div class="counter-inputs">
                                            <input type="hidden" name="cur_adults" id="input_cur_adults" value="@if(isset($property_data->cur_adults)) {{$property_data->cur_adults}} @else 0 @endif"/>
                                            <div class="col-xs-6"><p> Adults </p> </div>
                                            <div class="col-xs-6">
                                                <a onclick="cur_minus('adults');"><img src="{{BASE_URL}}minus.png"></a>
                                                <span id="cur_adults">@if(isset($property_data->cur_adults)){{$property_data->cur_adults}} @else 0 @endif</span>
                                                <a onclick="cur_plus('adults');"><img src="{{BASE_URL}}plus.png"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row with-forms">
                                        <div class="counter-inputs">
                                            <input type="hidden" name="cur_child" id="input_cur_child" value="@if(isset($property_data->cur_child)) {{$property_data->cur_child}} @else 0 @endif"/>
                                            <div class="col-xs-6"><p> Child </p> </div>
                                            <div class="col-xs-6">
                                                <a onclick="cur_minus('child');"><img src="{{BASE_URL}}minus.png"></a>
                                                <span id="cur_child">@if(isset($property_data->cur_child)){{$property_data->cur_child}} @else 0 @endif</span>
                                                <a onclick="cur_plus('child');"><img src="{{BASE_URL}}plus.png"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row with-forms">
                                        <div class="counter-inputs">
                                            <input type="hidden" name="cur_pets" id="input_cur_pets" value="@if(isset($property_data->cur_pets)) {{$property_data->cur_pets}} @else 0 @endif"/>
                                            <div class="col-xs-6"><p> Pets </p> </div>
                                            <div class="col-xs-6">
                                                <a onclick="cur_minus('pets');"><img src="{{BASE_URL}}minus.png"></a>
                                                <span id="cur_pets">@if(isset($property_data->cur_pets)){{$property_data->cur_pets}} @else 0 @endif</span>
                                                <a onclick="cur_plus('pets');"><img src="{{BASE_URL}}plus.png"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br><hr> <br>
                        </div>
                        <div class="row with-forms text-center">
                            <button type="submit" id="button" class="button preview margin-top-5" value="NEXT">Save <i class="fa fa-arrow-circle-right"></i></button>
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

        function cover_image(id){
            var prop_id={{$property_details->id}};
            var url = window.location.protocol + "//" + window.location.host + "/delete_room/"+id+"/"+prop_id;
            $.ajax({
                "type": "get",
                "url" : url,
                success: function(data) {
                    location.reload();
                }
            });
        }
        $(function(){
            @if(isset($property_room->bathroom_count))
            $("#bathrooms").val("{{$property_room->bathroom_count}}");
            $("#bedrooms").val("{{$property_room->bedroom_count}}");
            $("#guest_count").val("{{$property_data->total_guests}}");
            dynamic_rooms();
                @endif
                @if(isset($property_room->bedroom_count))
            var beds={{$property_room->bedroom_count}};
            for(var j=1;j<beds;j++){
                $("#bedrooms option[value='"+ j + "']").attr('disabled', true);
            }
            @endif
        });



        function dynamic_rooms() {
            var count = $("#bedrooms").val();
            var bed_count = '{{isset($property_room->bedroom_count)?$property_room->bedroom_count:'+0+'}}';

            var l=parseInt(count)+parseInt(bed_count);
            // console.log('count',parseInt(count));
            // console.log('bed_count',parseInt(bed_count));
            // document.getElementById('no_of_bedrooms').value = count;
            var html = '';


            var cnt = parseInt(bed_count)+1;
            var limit= parseInt(l-count);
            console.log('count',count);
            console.log('cnt',cnt);
            console.log('limit',limit);
            console.log('bed_count',bed_count);

            for (var i=limit; i < count ; i++) {

                var j=parseInt(i+1);

                html += `<br><hr>
            <div class="incremental-counter">
                <div class="row with-forms">
                    <h4>Room ${j} Beds</h4>
                </div>
                <div class="row with-forms">
                    <div class="counter-inputs">
                    <input type="hidden" name="double_bed[]" id="double_input${j}"/>
                    <div class="col-xs-6">
                    <p>Double</p>
                    </div>
                    <div class="col-xs-6">
                    <a onclick="minus(${j});"><img src="{{BASE_URL}}minus.png"></a>
                    <span id="doubles${j}">0</span>
                    <a onclick="plus(${j});"><img src="{{BASE_URL}}plus.png"></a>
                    </div>
                    </div>
                    </div>
                    <div class="row with-forms">
                    <div class="counter-inputs">
                    <input type="hidden" name="queen_bed[]" id="queen_input${j}" />
                    <div class="col-xs-6">
                    <p>Queen</p>
                    </div>
                    <div class="col-xs-6">
                    <a onclick="queen_minus(${j});"><img src="{{BASE_URL}}minus.png"></a>
                    <span id="queen${j}">0</span>
                    <a onclick="queen_plus(${j});"><img src="{{BASE_URL}}plus.png"></a>
                    </div>
                    </div>
                    </div>
                    <div class="row with-forms">
                    <div class="counter-inputs">
                    <input type="hidden" name="single_bed[]" id="single_input${j}"/>
                    <div class="col-xs-6">
                    <p>Single</p>
                    </div>
                    <div class="col-xs-6">
                    <a onclick="single_minus(${j});"><img src="{{BASE_URL}}minus.png"></a>
                    <span id="single${j}">0</span>
                    <a onclick="single_plus(${j});"><img src="{{BASE_URL}}plus.png"></a>
                    </div>
                    </div>
                    </div>
                    <div class="row with-forms">
                    <div class="counter-inputs">
                    <input type="hidden" name="sofa_bed[]" id="sofa_input${j}"/>
                    <div class="col-xs-6">
                    <p>Sofa bed</p>
                </div>
                <div class="col-xs-6">
                    <a onclick="sofa_minus(${j});"><img src="{{BASE_URL}}minus.png"></a>
                    <span id="sofa${j}">0</span>
                    <a onclick="sofa_plus(${j});"><img src="{{BASE_URL}}plus.png"></a>
                    </div>
                    </div>
                    </div>
                    <div class="row with-forms">
                    <div class="counter-inputs">
                    <input type="hidden" name="bunk_bed[]" id="bunk_input${j}"/>
                    <div class="col-xs-6">
                    <p>Bunk Bed</p>
                </div>
                <div class="col-xs-6">
                    <a onclick="bunk_minus(${j});"><img src="{{BASE_URL}}minus.png"></a>
                    <span id="bunk${j}">0</span>
                    <a onclick="bunk_plus(${j});"><img src="{{BASE_URL}}plus.png"></a>
                    </div>
                    </div>
                    </div>
                    <div class="row with-forms">
                    <h4>Total Beds : <span id="total_beds${j}">0</span></h4>
                </div>
                </div>`;



                if (i == l) {
                    var j = parseInt(l) + 1;
                    // html += '<div class="row with-forms"><div class="col-md-3"></div><div class="col-md-3"><h4> Common Spaces</h4></div></div><div class="row with-forms"><div class="col-md-3"></div><div class="col-md-3"> <input type="hidden" name="c_double_bed[]" id="double_input' + j + '" /><p> Double <a onclick="minus(' + j + ');" style="margin-left: 100px;margin-right: 10px;"><img src="{{BASE_URL}}minus.png"></a> <span id="doubles' + j + '">0</span> <a onclick="plus(' + j + ');" style="margin-left: 10px;"><img src="{{BASE_URL}}plus.png"></a></p></div></div><div class="row with-forms"><div class="col-md-3"></div><div class="col-md-3"> <input type="hidden" name="c_queen_bed[]" id="queen_input' + j + '" /><p> Queen <a onclick="queen_minus(' + j + ');" style="margin-left: 122px;margin-right: 8px;"><img src="{{BASE_URL}}minus.png"></a> <span id="queen' + j + '">0</span> <a onclick="queen_plus(' + j + ');" style="margin-left: 10px;"><img src="{{BASE_URL}}plus.png"></a></p></div></div><div class="row with-forms"><div class="col-md-3"></div><div class="col-md-3"> <input type="hidden" name="c_single_bed[]" id="single_input' + j + '" /><p> Single <a onclick="single_minus(' + j + ');" style="margin-left: 125px;margin-right: 8px;"><img src="{{BASE_URL}}minus.png"></a> <span id="single' + j + '">0</span> <a onclick="single_plus(' + j + ');" style="margin-left: 10px;"><img src="{{BASE_URL}}plus.png"></a></p></div></div><div class="row with-forms"><div class="col-md-3"></div><div class="col-md-3"> <input type="hidden" name="c_sofa_bed[]" id="sofa_input' + j + '" /><p> Sofa bed <a onclick="sofa_minus(' + j + ');" style="margin-left: 108px;margin-right: 8px;"><img src="{{BASE_URL}}minus.png"></a> <span id="sofa' + j + '">0</span> <a onclick="sofa_plus(' + j + ');" style="margin-left: 10px;"><img src="{{BASE_URL}}plus.png"></a></p></div></div><div class="row with-forms"><div class="col-md-3"></div><div class="col-md-3"> <input type="hidden" name="c_bunk_bed[]" id="bunk_input' + j + '" /><p> Bunk Bed <a onclick="bunk_minus(' + j + ');" style="margin-left: 104px;margin-right: 8px;"><img src="{{BASE_URL}}minus.png"></a> <span id="bunk' + j + '">0</span> <a onclick="bunk_plus(' + j + ');" style="margin-left: 10px;"><img src="{{BASE_URL}}plus.png"></a></p><h4>Total Beds :<span id="total_beds' + j + '">0</span></h4></div></div> <br><hr> <br>';
                    // $("#dynamic_bedrooms").empty();

                }
                $("#dynamic_bedrooms").empty();
                $("#dynamic_bedrooms").append(html);

            }


        }



        function queen_minus(value) {
            var h = $("#queen" + value).html();

            var t = $("#total_beds" + value).html();
            if (parseInt(t) >= 0) {
                var r = parseInt(t) - 1;
                if ($("#queen_input" + value).val() > 0) {
                    $("#total_beds" + value).empty();
                    $("#total_beds" + value).html(r);
                    var bed_count = $("#bed_count").val();
                    bed_count = parseInt(bed_count) - 1;
                    $("#bed_count").val(bed_count);
                }
            }
            //////alert(value);
            if (parseInt(h) > 0) {
                var f = parseInt(h) - 1;
                $("#queen" + value).empty();
                $("#queen" + value).html(f);
                $("#queen_input" + value).empty();
                $("#queen_input" + value).val(f);
                var bed_count = $("#bed_count").val();
                bed_count = parseInt(bed_count) - 1;
                //$("#bed_count").val(bed_count);
            }

        }

        function queen_plus(value) {
            var h = $("#queen" + value).html();
            //////alert(value);

            var t = $("#total_beds" + value).html();
            if (parseInt(t) >= 0) {
                var r = parseInt(t) + 1;
                $("#total_beds" + value).empty();
                $("#total_beds" + value).html(r);
                var bed_count = $("#bed_count").val();
                bed_count = parseInt(bed_count) + 1;
                $("#bed_count").val(bed_count);
            } else {
                $("#total_beds" + value).html(1);
                var bed_count = $("#bed_count").val();
                bed_count = parseInt(bed_count) + 1;
                $("#bed_count").val(bed_count);
            }

            var f = parseInt(h) + 1;
            $("#queen" + value).empty();
            $("#queen" + value).html(f);
            $("#queen_input" + value).empty();
            $("#queen_input" + value).val(f);

        }

        function single_minus(value) {
            var h = $("#single" + value).html();
            var t = $("#total_beds" + value).html();
            if (parseInt(t) >= 0) {
                var r = parseInt(t) - 1;
                if ($("#single_input" + value).val() > 0) {
                    $("#total_beds" + value).empty();
                    $("#total_beds" + value).html(r);
                    var bed_count = $("#bed_count").val();
                    bed_count = parseInt(bed_count) - 1;
                    $("#bed_count").val(bed_count);
                }
            }
            if (parseInt(h) > 0) {
                //////alert(value);
                var f = parseInt(h) - 1;
                $("#single" + value).empty();
                $("#single" + value).html(f);
                $("#single_input" + value).empty();
                $("#single_input" + value).val(f);
                var bed_count = $("#bed_count").val();
                bed_count = parseInt(bed_count) - 1;
                //$("#bed_count").val(bed_count);
            }

        }

        function sofa_minus(value) {
            var h = $("#sofa" + value).html();
            var t = $("#total_beds" + value).html();
            if (parseInt(t) >= 0) {
                var r = parseInt(t) - 1;
                if ($("#sofa_input" + value).val() > 0) {
                    $("#total_beds" + value).empty();
                    $("#total_beds" + value).html(r);
                    var bed_count = $("#bed_count").val();
                    bed_count = parseInt(bed_count) - 1;
                    $("#bed_count").val(bed_count);
                }
            }
            //////alert(value);
            if (parseInt(h) > 0) {
                var f = parseInt(h) - 1;
                $("#sofa" + value).empty();
                $("#sofa" + value).html(f);
                $("#sofa_input" + value).empty();
                $("#sofa_input" + value).val(f);
                var bed_count = $("#bed_count").val();
                bed_count = parseInt(bed_count) - 1;
                //$("#bed_count").val(bed_count);
            }

        }

        function sofa_plus(value) {
            var h = $("#sofa" + value).html();
            var t = $("#total_beds" + value).html();
            if (parseInt(t) >= 0) {
                var r = parseInt(t) + 1;
                $("#total_beds" + value).empty();
                $("#total_beds" + value).html(r);
                var bed_count = $("#bed_count").val();
                bed_count = parseInt(bed_count) + 1;
                $("#bed_count").val(bed_count);
            }
            //////alert(value);
            var f = parseInt(h) + 1;
            $("#sofa" + value).empty();
            $("#sofa" + value).html(f);
            $("#sofa_input" + value).empty();
            $("#sofa_input" + value).val(f);

        }

        function bunk_minus(value) {
            var h = $("#bunk" + value).html();
            var t = $("#total_beds" + value).html();
            if (parseInt(t) >= 0) {
                var r = parseInt(t) - 1;
                if ($("#bunk_input" + value).val() > 0) {
                    $("#total_beds" + value).empty();
                    $("#total_beds" + value).html(r);
                    var bed_count = $("#bed_count").val();
                    bed_count = parseInt(bed_count) - 1;
                    $("#bed_count").val(bed_count);
                }
            }
            if (parseInt(h) > 0) {
                //////alert(value);
                var f = parseInt(h) - 1;
                $("#bunk" + value).empty();
                $("#bunk" + value).html(f);
                $("#bunk_input" + value).empty();
                $("#bunk_input" + value).val(f);
                var bed_count = $("#bed_count").val();
                bed_count = parseInt(bed_count) - 1;
                //$("#bed_count").val(bed_count);
            }

        }

        function bunk_plus(value) {
            var h = $("#bunk" + value).html();
            var t = $("#total_beds" + value).html();
            if (parseInt(t) >= 0) {
                var r = parseInt(t) + 1;
                $("#total_beds" + value).empty();
                $("#total_beds" + value).html(r);
                var bed_count = $("#bed_count").val();
                bed_count = parseInt(bed_count) + 1;
                $("#bed_count").val(bed_count);
            }
            //////alert(value);
            var f = parseInt(h) + 1;
            $("#bunk" + value).empty();
            $("#bunk" + value).html(f);
            $("#bunk_input" + value).empty();
            $("#bunk_input" + value).val(f);

        }

        function single_plus(value) {
            var h = $("#single" + value).html();
            //////alert(value);
            var t = $("#total_beds" + value).html();
            if (parseInt(t) >= 0) {
                var r = parseInt(t) + 1;
                $("#total_beds" + value).empty();
                $("#total_beds" + value).html(r);
                var bed_count = $("#bed_count").val();
                bed_count = parseInt(bed_count) + 1;
                $("#bed_count").val(bed_count);
            }
            var f = parseInt(h) + 1;
            $("#single" + value).empty();
            $("#single" + value).html(f);
            $("#single_input" + value).empty();
            $("#single_input" + value).val(f);

        }

        function minus(value) {
            var h = $("#doubles" + value).html();
            //////alert(value);
            var t = $("#total_beds" + value).html();
            if (parseInt(t) >= 0) {
                var r = parseInt(t) - 1;
                if ($("#double_input" + value).val() > 0) {
                    $("#total_beds" + value).empty();
                    $("#total_beds" + value).html(r);
                    var bed_count = $("#bed_count").val();
                    bed_count = parseInt(bed_count) - 1;
                    $("#bed_count").val(bed_count);
                }
            }
            if (parseInt(h) > 0) {
                var f = parseInt(h) - 1;
                $("#doubles" + value).empty();
                $("#doubles" + value).html(f);
                $("#double_bed" + value).empty();
                $("#double_input" + value).val(f);
            }

        }

        function plus(value) {
            var h = $("#doubles" + value).html();
            ////////alert(h+1);
            var t = $("#total_beds" + value).html();
            if (parseInt(t) >= 0) {
                var r = parseInt(t) + 1;
                $("#total_beds" + value).empty();
                $("#total_beds" + value).html(r);
                var bed_count = $("#bed_count").val();
                bed_count = parseInt(bed_count) + 1;
                $("#bed_count").val(bed_count);
            } else {
                $("#total_beds" + value).html(1);
                var bed_count = $("#bed_count").val();
                bed_count = parseInt(bed_count) + 1;
                $("#bed_count").val(bed_count);
            }
            var f = parseInt(h) + 1;
            $("#doubles" + value).empty();
            $("#doubles" + value).html(f);
            $("#double_input" + value).empty();
            $("#double_input" + value).val(f);

        }

        $('#room_type').on('change',function(){
            var cur_val = $("#room_type").val();
            //alert(cur_val);
            if(cur_val != "Entire Place"){
                $('#cur_occupancy').show();
            }else{
                $('#cur_occupancy').hide();
                $('#input_cur_adults').val(0);
                $('#input_cur_child').val(0);
                $('#input_cur_pets').val(0);

            }
        });

        function cur_plus(value){

            var cur_val = $("#input_cur_" + value).val();
            var new_val = parseInt(cur_val) + 1;

            $("#cur_" + value).html(new_val);
            $("#input_cur_" + value).val(new_val);

        }

        function cur_minus(value){

            var cur_val = $("#input_cur_" + value).val();
            if(cur_val != 0){
                var new_val = parseInt(cur_val) - 1;
                $("#cur_" + value).html(new_val);
                $("#input_cur_" + value).val(new_val);
            }


        }

    </script>
    <script type="text/javascript">
        $('#property_size').on('keypress', function(event) {
            var regex = new RegExp("^[0-9+]$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });

    </script>


    </body>{{-- https://maps.googleapis.com/maps/api/js?libraries=places&#038;language=en&#038;key=AIzaSyBWoWfqptSqcHj_tAT3khy2jjj7fuANNaM&#038;ver=1.0 --}}
    </html>

@endsection
