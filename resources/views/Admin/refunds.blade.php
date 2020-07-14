@extends('Admin.Layout.master')

@section('title') 
{{APP_BASE_NAME}} Admin 
@endsection

@section('content')

      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Refunds</h3>
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                </li>
              </ol>
            </div>
          </div>
        </div>
        
      </div>
      <div class="content-body">
        <!-- Basic form layout section start -->


        <section id="configuration">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                    <div class=" table-responsive">
                    <table class="table table-striped table-bordered zero-configuration">
                      <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Booking Id</th>
                            <th>Transaction Id</th>
                            <th>Travellers Name</th>
                            <th>Host Name</th>
                            <th>Security Deposit</th>
                            <th>Claim By</th>
                           
                            <th>Refund Status</th>
                            <th>Action</th>
                          
                        </tr>
                      </thead>
                       <tbody>
                        <tr>
                            
                        <td>1</td>
                        <td>BFZPV41Z</td>
                        <td>bhdgsdjai123278</td>
                        <td>Vishnu</td>
                        <td>krishna</td>
                        <td>$600</td>
                        <td>Vishnu (Traveller)</td>  
                        <td>In Process</td>
                        <td><fieldset class="form-group">
                        <select class="form-control" id="basicSelect" style="width: 200px;">
                        <option>Make..</option>
                        <option>Approve To Traveller</option>
                        <option>Approve To Host</option>
                        </select>
                       </fieldset>
                     </td>
                    </tr>
                        <tr>
                            <td>2</td>
                            <td>BFZPV41Z</td>
                            <td>bhdgsdjai123278</td>
                            <td>Vishnu</td>
                            <td>krishna</td>
                            <td>$600</td>
                            <td>Krishna (Host)</td>
                            <td>Refund Sent to Travellers</td>
                            <td><fieldset class="form-group">
                            <select class="form-control" id="basicSelect" style="width: 200px;">
                            <option>Make..</option>
                            <option>Approve To Traveller</option>
                            <option>Approve To Host</option>
                            </select>
                    </fieldset></td>

                             </tr>
                          
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>S.no</th>
                            <th>Booking Id</th>
                            <th>Transaction Id</th>
                            <th>Travellers Name</th>
                            <th>Host Name</th>
                            <th>Security Deposit</th>
                            <th>Claim By</th>
                            <th>Refund Status</th>
                            <th>Action</th>
                          
                        </tr>
                      </tfoot>
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

      
    </div>
  </div>

@endsection