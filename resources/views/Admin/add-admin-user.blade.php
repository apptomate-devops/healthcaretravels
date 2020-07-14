@extends('Admin.Layout.master')

@section('title')  Rentals Slew Admin @endsection

@section('content')

    <div class="content-body">
        <!-- Basic form layout section start -->
        <section id="horizontal-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="horz-layout-basic"></i>Add Admin User</h4>

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
                                <form class="form form-horizontal">

                                    <div class="form-body">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput2">Name</label>
                                            <div class="col-md-6">
                                                <input type="text" id="projectinput2" class="form-control"
                                                       placeholder="Name"
                                                       name="name">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Email</label>
                                            <div class="col-md-6">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Email id" name="email">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Password</label>
                                            <div class="col-md-6">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Password" name="password">
                                            </div>
                                        </div>


                                        <div class="form-group row" class="col-md-6">
                                            <label class="col-md-3 label-control"
                                                   for="projectinput4">Description</label>
                                            <div class="col-md-3" style="text-align: right;">
                                                @foreach($pages as $key => $page)

                                                    <label for="switcherySize10"
                                                           class="font-medium-2 mr-1">{{$page->page_name}}</label>
                                                    <input type="checkbox" id="switcheryColor" data-size="xs"
                                                           class="switchery" data-color="primary"
                                                           checked value="{{$page->id}}"/><br>

                                                @endforeach
                                            </div>

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
