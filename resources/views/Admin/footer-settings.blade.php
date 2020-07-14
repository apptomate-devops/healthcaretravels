@extends('Admin.Layout.master')

@section('title') 
{{APP_BASE_NAME}} Admin 
@endsection

@section('content')

      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Footer Settings</h3>
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#">Site settings</a>
                </li>
                <li class="breadcrumb-item active"><a href="#">Footer Settings</a>
                </li>
              </ol>
            </div>
          </div>
        </div>
        <!-- <div class="content-header-right col-md-6 col-12">
          <div class="dropdown float-md-right">
            <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton"
            type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
            <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbButton"><a class="dropdown-item" href="#"><i class="la la-calendar-check-o"></i> Calender</a>
              <a class="dropdown-item" href="#"><i class="la la-cart-plus"></i> Cart</a>
              <a class="dropdown-item" href="#"><i class="la la-life-ring"></i> Support</a>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
            </div>
          </div>
        </div> -->
      </div>
      <div class="content-body">
        <!-- Basic form layout section start -->
        <section id="basic-form-layouts">
          <div class="row match-height">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title" id="basic-layout-form-center">Footer Settings</h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body">
                    <form class="form">
                      <div class="row justify-content-md-center">
                        <div class="col-md-9">
                          <div class="form-body">
                            <div class="form-group">
                              <label for="eventInput1">Address</label>
                              <input type="text" id="eventInput1" class="form-control" placeholder="name" name="fullname" value="123 Street, City State/Country">
                            </div>
                            <div class="form-group">
                              <label for="eventInput2">Phone</label>
                              <input type="text" id="eventInput2" class="form-control" placeholder="title" name="title" value="1235456">
                            </div>
                            <div class="form-group">
                              <label for="eventInput4">Email</label>
                              <input type="email" id="eventInput4" class="form-control" placeholder="email" name="email" value="example@mail.com">
                            </div>
                            <div class="form-group">
                              <label for="eventInput3">Facebook Link</label>
                              <input type="text" id="eventInput3" class="form-control" placeholder="company" name="company" value="https://www.facebook.com/">
                            </div>
                            
                            <div class="form-group">
                              <label for="eventInput5">Google Link</label>
                              <input type="tel" id="eventInput5" class="form-control" name="GoogleLink" placeholder="Google Link" value="https://plus.google.com/">
                            </div>
                            
                            <div class="form-group">
                              <label for="eventInput5">Twitter Link</label>
                              <input type="tel" id="eventInput5" class="form-control" name="TwitterLink" placeholder="Twitter Link" value="https://twitter.com/">
                            </div>
                            
                            <div class="form-group">
                              <label for="eventInput5">Linkedin Link</label>
                              <input type="tel" id="eventInput5" class="form-control" name="LinkedinLink" placeholder="Linkedin Link" value="http://www.linkedin.com/">
                            </div>
                            
                            <div class="form-group">
                              <label for="eventInput5">Youtube Link</label>
                              <input type="tel" id="eventInput5" class="form-control" name="YoutubeLink" placeholder="Youtube Link" value="https://www.youtube.com/">
                            </div>
                            
                            <div class="form-group">
                              <label for="eventInput5">Pinterest Link</label>
                              <input type="tel" id="eventInput5" class="form-control" name="PinterestLink" placeholder="Pinterest Link" value="http://www.pinterest.com/">
                            </div>
                            
                            <div class="form-group">
                              <label for="eventInput5">Instagram Link</label>
                              <input type="tel" id="eventInput5" class="form-control" name="InstagramLink" placeholder="Instagram Link" value="https://www.instagram.com/">
                            </div>

                          </div>
                        </div>
                      </div>
                      <div class="form-actions center">
                        
                        <button type="submit" class="btn btn-primary"  style="padding: 8px 15px;">
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