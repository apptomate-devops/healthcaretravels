@section('title') {{APP_BASE_NAME}} - Admin @endsection
@extends('Admin.Layout.master')
@section('content')
    <link rel="stylesheet" type="text/css"
          href="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/css/plugins/animate/animate.min.css">

    <style type="text/css">
        #map_wrapper {
            height: 400px;
        }

        #map_canvas {
            width: 100%;
            height: 100%;
        }

    </style>
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Property Blocking</h3> <span style="float:right"><button
                    type="button" class="btn btn-outline-blue blue block btn-lg" data-toggle="modal"
                    data-target="#rollIn">
                            Block Property
                          </button></span>
            <div class="row breadcrumbs-top d-inline-block" style="float: right;margin-right: -105%;">
                <div class="breadcrumb-wrapper col-12">
                    <div id="dynButton">
                        <!-- <button class="btn btn-primary btn-sm" type="button" id="btnMap">
                          Show on Map
                        </button> -->
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal animated rollIn text-left" id="rollIn" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel41" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form name="edit_cities" action="add_property_block" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel41">Block Property</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <fieldset class="form-group floating-label-form-group">
                            <label class="label-control" for="coupon_type">Select Property</label>
                            <select id="property" name="property" class="form-control"
                                    onchange="get_blocked_date(this.value)">
                                @foreach($property as $p)
                                    <option value="{{$p->id}}">{{$p->title}}</option>
                                @endforeach
                            </select>

                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label for="email">Date</label>
                            <input type="date" required name="block_date" value="" class="form-control pickadate"
                                   id="block_date" placeholder="Date">
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label for="email">Comments</label>
                            <input type="text" required name="comment" class="form-control" id="comment"
                                   placeholder="Comments">
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{--  @foreach($data as $key=> $d)
          <div class="modal animated rollIn text-left" id="rollIn{{$key+1}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel41" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <form name="edit_cities" action="add_cities_process" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title" id="myModalLabel41">{{$d->location}}</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <fieldset class="form-group floating-label-form-group">
                                          <label for="email">Title</label>
                                          <input type="text" name="title" required value="{{$d->title}}" class="form-control" id="title" placeholder="Title">
                                        </fieldset>
                                        <fieldset class="form-group floating-label-form-group">
                                          <label for="email">Location</label>
                                          <input type="text" name="location" required value="{{$d->location}}" class="form-control" id="location" placeholder="Location">
                                        </fieldset>
                                        <fieldset class="form-group floating-label-form-group">
                                          <label for="email">Category ID</label>
                                          <input type="text" name="category_id" value="{{$d->category_id}}" class="form-control" id="category_id" placeholder="Category ID" required>
                                        </fieldset>
                                        <fieldset class="form-group floating-label-form-group">
                                          <label for="email">Image</label>
                                          <input type="file" class="form-control" id="file" required name="file" placeholder="Image">
                                          <br>
                                          <img src="{{$d->image_url}}" width="75px" width="75px">
                                          <input type="hidden" name="image_url" value="{{$d->image_url}}">
                                          <input type="hidden" name="id" value="{{$d->id}}">
                                        </fieldset>

                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-outline-primary">Save changes</button>
                                    </div>
                                  </div>
                                  </form>
                                </div>
                              </div>

                              @endforeach

     --}}

    <div class="content-body">
        <!-- Basic form layout section start -->


        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>


                                        <tr>
                                            <th>S.No</th>
                                            <th>Property</th>
                                            <th>Owner</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $key=> $d)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$d->title}}</td>
                                                <td>{{$d->first_name}}&nbsp;{{$d->last_name}}</td>
                                                <td>{{date('m-d-Y',strtotime($d->start_date))}}</td>
                                                <td>
                                                    <a class="btn btn-default btn-danger "
                                                       href="delete-blocked-date/{{$d->id}}" style="color:white"><i
                                                            class="fa fa-edit"></i>Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- // Basic form layout section end -->
    </div>

@endsection


@section('scripts')
    {{-- <script type="text/javascript" src="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/js/scripts/modal/components-modal.min.js"></script> --}}

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}

    <script type="text/javascript">
        function get_blocked_date(id) {
            //alert(id);
            var url = 'get_blocked_dates/' + id;
            $.ajax({
                "type": "get",
                "url": url,
                success: function (data) {
                    console.log(data);

                }
            });

        }


    </script>


