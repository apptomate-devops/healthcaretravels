@section('title') {{APP_BASE_NAME}} - Admin @endsection
@extends('Admin.Layout.master')
@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Registeration Mail Configuration</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a>
                        </li>


                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">

            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Basic form layout section start -->
        <section id="horizontal-form-layouts">
            <div class="row">
                <div class="col-md-10 col-md-offset-2">
                    <div class="card">
                        <div class="card-header">

                            <h4 class="card-title" id="horz-layout-basic">Register</h4>
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
                                <form class="form form-horizontal" method="post" action="save_config">
                                    <input type="hidden" name="role_id" value="1">
                                    <input type="hidden" name="type" value="1">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="id" value="{{isset($register->id)?$register->id:''}}">
                                    <div class="form-body">

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="tilte1">
                                                Title
                                            </label>
                                            <div class="col-md-6">
                                                <input required type="text" id="title1"
                                                       value="{{isset($register->title)?$register->title:''}}"
                                                       class="form-control" placeholder="Title"
                                                       name="title">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="subject1">Subject</label>
                                            <div class="col-md-6">
                                                <input required type="text" id="subject1"
                                                       value="{{isset($register->subject)?$register->subject:''}}"
                                                       class="form-control" placeholder="Subject"
                                                       name="subject">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="message1">
                                                Message
                                            </label>
                                            <div class="col-md-6">
                                                <textarea name="message" class="form-control"
                                                          id="message1">{{isset($register->message)?$register->message:''}}</textarea>
                                            </div>
                                        </div>


                                        <div class="form-actions center">

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
            <br>

        </section>
        <!-- // Basic form layout section end -->
    </div>
    </div>
    </div>
@endsection
