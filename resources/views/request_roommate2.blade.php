@extends('layout.master')
@section('title')
Request Roommate | {{APP_BASE_NAME}}
@endsection
@section('main_content')

<div class="container" style="margin-top: 35px;">
    <form action="{{url('/')}}/request_roommate2" method="post" >
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="row">

            <div class="col-md-12">

                <div class="style-1">

                     <button class="btn" style="margin-top: 10px;">Your Information</button>
                     <button class="btn" style="background-color:#0983b8;color:white;margin-top: 10px;">Your Roommate Preference</button>


                        <!-- Tabs Content -->
                        <div class="tabs-container">

                            <div class="tab-content" id="tab2" style="display: inline-block;">
                                <div class="submit-section">
                                    <h3>Your Roommate Preference</h3>
                                    <div class="row with-forms">
                                        <div class="col-md-6">
                                            <h5>Have you found housing? <span style="color: red;">*</span></h5>
                                           <input type="text" class="input-text validate" name="rent" id="rent" value=""/>
                                           <input type="hidden" class="input-text validate" name="id"  value="{{$id}}"/>
                                        </div>


                                        <div class="col-md-6">
                                            <h5>Is your Housing on Health Care Travels? <span style="color: red;">*</span></h5>
                                            <select class="validate chosen-select-no-single" name="is_house_on_healthcare" required>
                                                <option label="blank"></option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                                <option value="Haven't Found Housing">Haven't Found Housing</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row with-forms">
                                        <div class="col-md-6">
                                            <h5>Your Occupation <span style="color: red;">*</span></h5>
                                           <input type="text" class="input-text validate" name="occupation" id="occupation" value="" required/>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Additional request or details? </h5>
                                           <input type="text" class="input-text validate" name="request_details" id="request_details" value=""/>
                                        </div>
                                    </div>
                                    <div class="row with-forms">
                                        <div class="col-md-6">
                                            <h5>Prefer what gender? <span style="color: red;">*</span></h5>
                                           <select class="validate chosen-select-no-single" name="prefer_gender" required>
                                                <option label="blank"></option>
                                                <option value="Female">Female</option>
                                                <option value="Male">Male</option>
                                                <option value="Not">It doesn't matter</option>
                                            </select>
                                        </div>


                                        <div class="col-md-6">
                                            <h5>Prefer what age? <span style="color: red;">*</span></h5>
                                           <select class="validate chosen-select-no-single" name="prefer_age" required>
                                                <option label="blank"></option>
                                                <option value="18-25">18-25</option>
                                                <option value="26-35">26-35</option>
                                                <option value="36-45">36-45</option>
                                                <option value="46 and up">46 and up</option>
                                                <option value="not">It doesn't matter</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="divider"></div>
                                    @if(!Session::has('user_id'))
                                        <center>
                                            <button onclick="location.href='/login';" class="button border margin-top-5">Login to Request Roommate  <i class="fa fa-arrow-circle-right"></i></button>
                                        </center><br><br>
                                    @else
                                        <center>
                                            <button id="button" class="button border margin-top-5">Submit <i class="fa fa-arrow-circle-right"></i></button>
                                        </center><br><br>
                                    @endif

                                </div>
                                <!-- Section / End -->
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>
</div>

<script type="text/javascript">



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
<script type="text/javascript">

function show_next(){
    $("#tab2").show();
    $("#tab1").hide();

}

</script>





</body>
</html>

@endsection
