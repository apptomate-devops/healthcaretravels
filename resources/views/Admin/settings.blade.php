@section('title') {{APP_BASE_NAME}} - Admin @endsection
@extends('Admin.Layout.master')
{{--Keepers Admin--}}
@section('content')


    <!-- <div class="content-body">

        <div class="row">
            <form class="form-horizontal form-simple" action="" method="post">
              <input type="hidden" name="_token" value="{{csrf_token()}}">



                <button type="submit" class="btn btn-info btn-lg btn-block">
                  <i class="ft-unlock"></i> Submit
                </button>
              </form>
          </div>

      </div> -->

    <div class="content-body">
        <!-- Basic form layout section start -->
        <section id="horizontal-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="horz-layout-basic"></i>Settings</h4>

                            <!-- <h4 class="card-title" id="horz-layout-basic">Project Info</h4> -->
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <div class="card-text">

                                </div>
                                <form class="form form-horizontal" action="" method="post"
                                      enctype="multipart/form-data">

                                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                                    @foreach($settings as $key => $setting)
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput2">
                                                {{ucfirst(str_replace("_"," ",$setting->param))}}
                                            </label>
                                            <div class="col-md-6">
                                                @if($setting->is_image == 1)
                                                    <input type="file" id="projectinput2" class="form-control"
                                                           placeholder="Name"
                                                           name="{{$setting->param}}">
                                                @else
                                                    <input type="text" id="projectinput2" class="form-control"
                                                           placeholder="Name"
                                                           name="{{$setting->param}}" value="{{$setting->value}}">
                                                @endif
                                            </div>
                                            @if($setting->is_image == 1)
                                                <div class="col-md-3">
                                                    <img src="{{$setting->value}}" style="width: 100px;">
                                                </div>
                                            @endif

                                        </div>
                                    @endforeach

                                    <h4>Email Settings</h4>
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="email">
                                            Gmail ID
                                        </label>
                                        <div class="col-md-6">
                                            <input type="email" id="email" class="form-control" placeholder="Email"
                                                   name="email">
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="app_password">
                                            Gmail App password
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" id="app_password" class="form-control"
                                                   placeholder="Gmail App Password"
                                                   name="app_password">
                                        </div>
                                    </div>


                                    <div class="form-actions center">
                                        <a href="{{url('/admin/admin-users')}}" class="button btn btn-warning mr-5"
                                           style="padding: 10px 15px;">
                                            <i class="ft-x"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">
                                            <i class="la la-check-square-o"></i> Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic form layout section end -->
    </div>
@endsection
