@extends('layout.master')
@section('title')

{{APP_BASE_NAME}} | Owner Account | My Bookings page

@endsection
@section('main_content')


<style>
.card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width: 40%;
    background-color: #f2f2f2;
}

.card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.container {
    padding: 2px 16px;
}

td {
    padding-top: .5em;
    padding-bottom: .5em;
}

ul.my-account-nav li a {
    font-size: 14px;
    line-height: 34px;
    color: black;
}
li.sub-nav-title {
    font-size: 16px;
}

</style>

    <div class="container" style="margin-top: 35px;">
        <div class="row">


            <!-- Widget -->
            <div class="col-md-4" style="height: 1000px;">
                <div class="sidebar left">

                    <div class="my-account-nav-container">

                        @include('owner.menu')

                    </div>

                </div>
            </div>

        <div class="col-md-8">
            <div class="row">

                <div class="col-md-8 my-profile">

                @if(Session::has('success'))
                <div class="alert alert-success">
                    <h4>{{ Session::get('success') }}</h4>
                </div>
                @endif

                @if(Session::has('error'))
                    <div class="alert alert-success">
                        <h4>{{ Session::get('error') }}</h4>
                    </div>
                @endif
                    <form  action="{{url('special-pricing-process')}}" method="post" style="margin-top: -30px;" autocomplete="off">

                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <label>Category</label>
                        <select class="input-text validate" autocomplete="off"  name="category" id="category" required="required">
                            <option label="" value="" >Select Category</option>
                            <option value="rb" >Room Blocking</option>
                            <option value="sp" >Special Pricing</option>
                        </select>
                        <label>Property</label>
                        <select class="input-text validate" autocomplete="off"  name="property" id="property" required="required">
                            <option label="" value="" >Select Property</option>
                            @foreach($properties as $p)
                                <option value="{{$p->id}}" >{{$p->title}}</option>
                            @endforeach
                        </select>
                        <div id="date" >
                            <label>Date</label>
                            <input value="" type="text" name="from_date" id="from_date" required="required">
                        </div>

                        <div id="per_night" style="display: none;">
                            <label>Price Per Night</label>
                            <input value=""  type="text" name="per_night" name="per_night1" placeholder="Price Per Night" onchange="this.value=parseFloat(parseFloat(this.value)).toFixed(2);">
                        </div>
                        <div id="description" style="display: none;">
                            <label>Description</label>
                            <input value=""  type="text" name="description" id="description1" placeholder="Description" >
                        </div>
                        <button type="submit" style="display: none;" id="block_room" class="button margin-top-20 margin-bottom-20">Block Room</button>
                        <button type="submit" style="display: none;" id="add_price" class="button margin-top-20 margin-bottom-20">Save Price</button>
                    </form>
                </div>
            </div>
        </div><br><br>
        <div class="col-md-8">
            <table class="manage-table responsive-table">

                <tr>
                    <th><i class="fa fa-file-text"></i>Special Pricing</th>
                    {{-- <th class="expire-date"><i class="fa fa-calendar"></i> Status</th> --}}
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>

                <tr>
                    <td><strong>Date</strong></td>
                    <td><strong>Property </strong></td>
                    <td><strong>Amount</strong></td>
                    <td><strong>Action</strong></td>
                </tr>
                @foreach($special_price as $property)
                <tr>
                    <td >{{$property->start_date}} </td>
                    <td >{{$property->title}} </td>
                    <td >{{$property->price_per_night}}</td>
                    <td >
                        <a href="{{url('/')}}/owner/delete_special_price/{{$property->id}}" class="delete"><i class="fa fa-remove"></i> Delete</a>
                    </td>
                </tr>
                @endforeach


            </table>
            @if(count($special_price) >= 5)
                <a href="{{url('/')}}/owner/special_price_details" class="margin-top-40 button" style="float:right;">Show more</a>
            @endif
            <br>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-8">
            <table class="manage-table responsive-table">

                <tr>
                    <th><i class="fa fa-file-text"></i>Property Blocking</th>
                    {{-- <th class="expire-date"><i class="fa fa-calendar"></i> Status</th> --}}
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>

                <tr>
                    <td><strong>Date</strong></td>
                    <td><strong>Property</strong></td>
                    <td><strong>Description</strong></td>
                    <td><strong>Action</strong></td>
                </tr>
                @foreach($blocking as $property)
                <tr>
                    <td >{{$property->start_date}} </td>
                    <td >{{$property->title}} </td>
                    <td >{{$property->booked_on}}</td>
                    <td >
                        <a href="{{url('/')}}/owner/delete_blocked_date/{{$property->id}}" class="delete"><i class="fa fa-remove"></i> Delete</a>
                    </td>
                </tr>
                @endforeach


            </table>
            @if(count($blocking) >= 5)
                <a href="{{url('/')}}/owner/special_price_details" class="margin-top-40 button" style="float:right;">Show more</a>
            @endif
            {{-- <a href="{{url('/')}}/owner/add-property" class="margin-top-40 button">Submit New Property</a> --}}
        </div>

        </div>
    </div>
    <script>
        var date = new Date();
        $('#from_date').datepicker({
            startDate: date,
            selectMultiple:true,
            multidate: true
        });

        $('#category').change(function(){
            var value=$(this).val();
            if(value=="sp"){
               $('#per_night').show();
               $('#block_date').hide();
               $('#add_price').show();
               $('#description').hide();
               $('#block_room').hide();

            }
            if(value=="rb"){
               $('#block_date').show();
               $('#per_night').hide();
               $('#description').show();
               $('#block_room').show();
               $('#add_price').hide();


            }

        });
    </script>

@endsection
