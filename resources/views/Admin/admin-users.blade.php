@section('title') {{APP_BASE_NAME}} - Admin @endsection
@extends('Admin.Layout.master')
@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Admin Users <small>Control panel</small></h3>
            <div class="row breadcrumbs-top d-inline-block" style="float: right;margin-right: -105%;">
                <div class="breadcrumb-wrapper col-12">
                    <a class="btn btn-primary btn-sm" href="{{url('/')}}/admin/admin-user/add">Add new </a>
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
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>


                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($users as $key => $user)
                                            <tr>
                                                <td>
                                                    {{$key + 1}}
                                                </td>
                                                <td style="text-align: left;">
                                                    {{$user->email}}
                                                </td>
                                                <td>

                                                </td>
                                                <td>
                                                    @if($user->status == 1)
                                                        Active
                                                    @else
                                                        Blocked
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-icon btn-success mr-1" style="color: white;">
                                                        <i class="ft-edit"></i>
                                                    </a>
                                                    <a class="btn btn-icon btn-success mr-1" style="color: white;">
                                                        <i class="ft-delete"></i>
                                                    </a>
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
