
@extends('Admin.Layout.master')

@section('title')  Rentals Slew Admin @endsection

@section('content')
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/css/plugins/animate/animate.min.css">

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
          <h3 class="content-header-title mb-0 d-inline-block">Faq Management</h3> <span style="float:right"><button type="button" class="btn btn-outline-blue blue block btn-lg" data-toggle="modal" data-target="#rollIn">
                            Add Faq
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

      <div class="modal animated rollIn text-left" id="rollIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel41" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <form name="edit_agency" action="add_faq_process" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">  
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel41">Add Faq</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <fieldset class="form-group floating-label-form-group">
                                      <label for="email">Question</label>
                                      <input type="text" required name="question" value="" class="form-control" id="question" placeholder="Question">
                                    </fieldset>

                                     <fieldset class="form-group floating-label-form-group">
                                      <label for="email">Answer</label>
                                      <textarea  name="answer" required value="" class="form-control" id="answer" placeholder="Answer"></textarea>
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


 @foreach($faq as $key=> $f)
      <div class="modal animated rollIn text-left" id="rollIn{{$key+1}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel41" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <form name="add_agency" action="add_faq_process" method="post">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">  
                                <input type="hidden" name="id" value="{{$f->id}}">  
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel41">{{$f->question}}</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <fieldset class="form-group floating-label-form-group">
                                      <label for="email">Question</label>
                                      <input type="text" name="question" required value="{{$f->question}}" class="form-control" id="question" placeholder=" question">
                                    </fieldset>

                                    <fieldset class="form-group floating-label-form-group">
                                      <label for="email">Answer</label>
                                      <textarea  name="answer" required value="{{$f->question}}" class="form-control" id="answer" placeholder="Answer">{{$f->answer}}</textarea>
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
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Action</th>
                           
                          </tr>
                        </thead>
                        <tbody>

                          @foreach($faq as $key=> $f)
                         
                            <tr>
                              <td>
                                {{$key+1}}

                              </td>
                              <td>
                              {{$f->question}}
                              </td>

                              <td>
                              {{$f->answer}}
                              </td>
                              
                              <td>
                                <a class="btn btn-default btn-info" data-toggle="modal" data-target="#rollIn{{$key+1}}" style="color:white"><i class="fa fa-edit"></i>Edit</a>
                             
                                <a class="btn btn-default btn-danger " href="delete-faq/{{$f->id}}" style="color:white"><i class="fa fa-edit"></i>Delete</a>
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

