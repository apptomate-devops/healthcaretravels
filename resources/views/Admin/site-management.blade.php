@extends('Admin.Layout.master')

@section('title') {{APP_BASE_NAME}} - Admin @endsection

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Site management</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Site settings</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Site management</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">
                <!-- <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton"
                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button> -->
                <!-- <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbButton"><a class="dropdown-item" href="#"><i class="la la-calendar-check-o"></i> Calender</a>
                  <a class="dropdown-item" href="#"><i class="la la-cart-plus"></i> Cart</a>
                  <a class="dropdown-item" href="#"><i class="la la-life-ring"></i> Support</a>
                  <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
                </div> -->
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Basic form layout section start -->
        <section id="horizontal-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="horz-layout-basic"></i>Basic Form Elements</h4>

                            <!-- <h4 class="card-title" id="horz-layout-basic">Project Info</h4> -->
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collpase show">
                            <div class="card-body">
                                <div class="card-text">
                                    <!-- <p>This is the basic horizontal form with labels on left and form
                                      controls on right in one line. Add <code>.form-horizontal</code>                        class to the form tag to have horizontal form styling. To
                                      define form sections use <code>form-section</code> class
                                      with any heading tags.</p> -->
                                </div>
                                <form class="form form-horizontal">

                                    <div class="form-body">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput2">Site Name</label>
                                            <div class="col-md-9">
                                                <input type="text" id="projectinput2" class="form-control"
                                                       placeholder="Site Name"
                                                       name="SiteName">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Site Title</label>
                                            <div class="col-md-9">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Site Title" name="sitetitle">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Google Map Api
                                                Key</label>
                                            <div class="col-md-9">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Google Map Api Key" name="apiKey">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Meta
                                                Keyword</label>
                                            <div class="col-md-9">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Meta Keyword" name="MetaKeyword">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Meta
                                                Description</label>
                                            <div class="col-md-9">
                                                <input type="text" id="projectinput4" class="form-control"
                                                       placeholder="Meta Description" name="MetaDescription">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Welcome
                                                Email</label>
                                            <div class="col-md-9">
                                                <fieldset class="radio">
                                                    <label>
                                                        <input type="radio" name="radio" value="" checked> Yes
                                                    </label> &nbsp;

                                                    <label>
                                                        <input type="radio" name="radio" value=""> No
                                                    </label>
                                                </fieldset>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Logo Image
                                                (Black)</label>
                                            <div class="col-md-9">


                                                <img id="blah" src="http://placehold.it/180" alt="your image" /
                                                style="max-width:180px;"><br>
                                                <input type='file' onchange="readURL(this);" /
                                                style="padding:10px;background:000;">

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Logo Image
                                                (White)</label>
                                            <div class="col-md-9">


                                                <img id="blah1" src="http://placehold.it/180" alt="your image" /
                                                style="max-width:180px;"><br>
                                                <input type='file' onchange="readURL1(this);" /
                                                style="padding:10px;background:000;">

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput4">Default User
                                                Image</label>
                                            <div class="col-md-9">


                                                <img id="blah2" src="http://placehold.it/180" alt="your image" /
                                                style="max-width:180px;"><br>
                                                <input type='file' onchange="readURL2(this);" /
                                                style="padding:10px;background:000;">

                                            </div>
                                        </div>


                                        <div class="form-actions center">
                                            <button type="button" class="btn btn-warning mr-5"
                                                    style="padding: 10px 15px;">
                                                <i class="ft-x"></i> Cancel
                                            </button>
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


    </div>
    </div>

@endsection
