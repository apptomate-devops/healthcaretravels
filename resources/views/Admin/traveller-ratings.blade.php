@extends('Admin.Layout.master')

@section('title')
    {{APP_BASE_NAME}} Admin
@endsection

@section('content')
    <style>
        .star-rating {
            line-height: 32px;
            font-size: 20px;
            pointer-events: none;


        }

        .star-rating .fa-star {
            color: #e78016;
        }
    </style>
    <link rel="stylesheet" href="{{URL::asset('/css/icons.css')}}">

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Traveler Ratings</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Ratings</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Traveler Ratings</a>
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


        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title">Traveler Ratings</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            </div>
                        </div>

                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Traveler Name</th>
                                        <th>Total Ratings</th>
                                        <!-- <th>Action</th> -->

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $key=>$d)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$d['username']}}</td>
                                            <td>
                                                <div class="star-rating">
                                                    <span class="fa fa-star-o" data-rating="1"></span>
                                                    <span class="fa fa-star-o" data-rating="2"></span>
                                                    <span class="fa fa-star-o" data-rating="3"></span>
                                                    <span class="fa fa-star-o" data-rating="4"></span>
                                                    <span class="fa fa-star-o" data-rating="5"></span>
                                                    <input type="hidden" name="rating" class="rating-value"
                                                           value="{{$d['rating']}}">
                                                </div>
                                            </td>
                                            <!--  <td>
                                                 <button type="button" class="btn btn-icon btn-success mr-1"><i class="ft-edit"></i></button>
                                                 <button type="button" class="btn btn-icon btn-success mr-1"><i class="ft-delete"></i></button>
                                               </td> -->

                                        </tr>
                                    @endforeach
                                    <!-- <tfoot>
                        <tr>

                          <th>S. No.</th>
                          <th>Traveler Name</th>
                          <th>Total Ratings</th>
                          <th>Action</th>

                        </tr>
                      </tfoot> -->
                                </table>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $('.star-rating').children().attr('disabled', 'disabled');
        var $star_rating = $('.star-rating .fa');

        var SetRatingStar = function () {
            return $star_rating.each(function () {
                if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                    return $(this).removeClass('fa-star-o').addClass('fa-star');
                } else {
                    return $(this).removeClass('fa-star').addClass('fa-star-o');
                }
            });
        };

        $star_rating.on('click', function () {
            $star_rating.siblings('input.rating-value').val($(this).data('rating'));
            return SetRatingStar();
        });

        SetRatingStar();
        $(document).ready(function () {
            SetRatingStar();
        });
    </script>

@endsection
