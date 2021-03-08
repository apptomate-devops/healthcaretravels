@section('title') {{APP_BASE_NAME}} - Admin @endsection
@extends('Admin.Layout.master')
@section('content')

    <style type="text/css">
        .select2-selection .select2-selection--multiple {
            min-width: 250px;
        }
    </style>
    <script type="text/javascript"
            src="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.css">

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Send email</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Site settings</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Send email</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">
                <!-- <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton"
                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button> -->
                <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbButton"><a class="dropdown-item" href="#"><i
                            class="la la-calendar-check-o"></i> Calender</a>
                    <a class="dropdown-item" href="#"><i class="la la-cart-plus"></i> Cart</a>
                    <a class="dropdown-item" href="#"><i class="la la-life-ring"></i> Support</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
                </div>
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
                            <h4 class="card-title" id="horz-layout-basic"></i> Send Email Form</h4>

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
                                    <!-- <p>This is the basic horizontal form with labels on left and form
                                      controls on right in one line. Add <code>.form-horizontal</code>                        class to the form tag to have horizontal form styling. To
                                      define form sections use <code>form-section</code> class
                                      with any heading tags.</p> -->
                                </div>

                                <form class="form form-horizontal" method="post">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-body">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput1">E-mail to</label>
                                            <div class="col-md-9">

                                                <div class="show"
                                                     style="display: block; position: static; width: 100%; margin-top: 0;">
                                                    <div class="">
                                                        <div class="input-group">
                                                            <div>
                                                                <fieldset>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input"
                                                                               checked="" value="0" name="tab"
                                                                               id="customRadio1" value="igotnone">
                                                                        <label class="custom-control-label"
                                                                               for="customRadio1">All</label>
                                                                    </div>
                                                                </fieldset>
                                                            </div> &nbsp;&nbsp;&nbsp;
                                                            <div>
                                                                <fieldset>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input"
                                                                               name="tab" id="customRadio2" value="1">
                                                                        <label class="custom-control-label"
                                                                               for="customRadio2">Specified</label>
                                                                    </div>
                                                                </fieldset>
                                                            </div>&nbsp;&nbsp;&nbsp;
                                                            <div>
                                                                <fieldset>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input"
                                                                               name="tab" id="customRadio3" value="2">
                                                                        <label class="custom-control-label"
                                                                               for="customRadio3">All Owners</label>
                                                                    </div>
                                                                </fieldset>
                                                            </div>&nbsp;&nbsp;&nbsp;
                                                            <div>

                                                                <fieldset>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input"
                                                                               name="tab" id="customRadio4" value="3">
                                                                        <label class="custom-control-label"
                                                                               for="customRadio4">All Travelers</label>
                                                                    </div>&nbsp;&nbsp;&nbsp;
                                                                </fieldset>
                                                            </div>
                                                            <div>
                                                                <fieldset>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input"
                                                                               name="tab" id="customRadio5" value="4">
                                                                        <label class="custom-control-label"
                                                                               for="customRadio5">All Agencies</label>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="div1">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="projectinput6">Email
                                                address</label>
                                            <div class="col-md-9 col-lg-9" style="width:80%">
                                                <select class="select2 form-control" name="email[]" multiple="multiple"
                                                        style="width: 100%">
                                                    @foreach($users as $user)
                                                        @if($user->email!='0' && $user->email!='')
                                                            <option value="{{$user->id}}">{{$user->email}}</option>
                                                        @endif
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="projectinput4">Subject</label>
                                        <div class="col-md-9">
                                            <input type="text" id="projectinput4" required class="form-control"
                                                   placeholder="Subject" name="subject">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="projectinput4">Message</label>
                                        <div class="col-md-9">
                                            <textarea name="message" required="" id="txtEditor" rows="10"
                                                      cols="95"></textarea>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-actions center">
                                <button type="button" class="btn btn-warning mr-5" style="padding: 10px 15px;">
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

@section('scripts')

    <script type="text/javascript">

        $('input[type=radio][name=tab]').change(function () {
            var value = this.value;
            // $("#div"+value).show();
            if (value == '1') {
                $("#div1").show();
            }

        });

        $("#div1").hide();
        $("#div2").hide();
        $("#div3").hide();
        $("#div4").hide();
    </script>

@endsection
