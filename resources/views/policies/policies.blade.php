@section('title')
    Policy | {{APP_BASE_NAME}}
@endsection
@extends('layout.master')
@section('main_content')

    <div class="container" style="margin-top: 35px;">
        <div class="content_wrapper  row ">

            <div id="post" class="row  post-2328 page type-page status-publish hentry">
                <div class="col-md-12 breadcrumb_container">
                    <ol class="breadcrumb">
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li class="active">Policies</li>
                    </ol>
                </div>
                <div class=" col-md-12 ">


                    <div class="loader-inner ball-pulse" id="internal-loader">
                        <div class="double-bounce1"></div>
                        <div class="double-bounce2"></div>
                    </div>

                    <div id="listing_ajax_container">

                    </div>
                    <div class="single-content">
                        <h1 class="entry-title single-title">Policies</h1>


                        <table class="shop_attributes" style="height: 10px;" width="50%">
                            <tbody>
                            <tr>
                                <th style="text-align: left;">
                                    <ul>
                                        <li><a class="menu-item-link" href="{{url('/')}}/cancellationpolicy">Cancellation
                                                Policy</a></li>
                                    </ul>
                                </th>
                                <th style="text-align: left;">
                                    <ul>
                                        <li><a class="menu-item-link" href="{{url('/')}}/extortion-policy">Extortion
                                                Policy</a></li>
                                    </ul>
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align: left;">
                                    <ul>
                                        <li><a class="menu-item-link" href="{{url('/')}}/cookie-policy">Cookie
                                                Policy</a></li>
                                    </ul>
                                </th>
                                <th style="text-align: left;">
                                    <ul>
                                        <li><a class="menu-item-link" href="{{url('/')}}/non-discrimination-policy">Non-Discrimination
                                                Policy</a></li>
                                    </ul>
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align: left;">
                                    <ul>
                                        <li><a class="menu-item-link" href="{{url('/')}}/copyright-policy">Copyright
                                                Policy</a></li>
                                    </ul>
                                </th>
                                <th style="text-align: left;">
                                    <ul>
                                        <li><a class="menu-item-link" href="{{url('/')}}/privacy-policy">Privacy
                                                Policy</a></li>
                                    </ul>
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align: left;">
                                    <ul>
                                        <li><a class="menu-item-link" href="{{url('/')}}/content-policy">Content Policy</a>
                                        </li>
                                    </ul>
                                </th>
                                <th style="text-align: left;">
                                    <ul>
                                        <li><a class="menu-item-link" href="{{url('/')}}/payment-terms">Payment
                                                Terms</a></li>
                                    </ul>
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align: left;">
                                    <ul>
                                        <li><a class="menu-item-link" href="{{url('/')}}/extenuating-circ-policy">Extenuating
                                                Circ. Policy</a></li>
                                    </ul>
                                </th>
                                <th style="text-align: left;">
                                    <ul>
                                        <li><a class="menu-item-link" href="{{url('/')}}/travelers-refund-policy">Traveler
                                                Refund Policy</a></li>
                                    </ul>
                                </th>
                            </tr>
                            </tbody>
                        </table>

                    </div>

                    <!-- #comments start-->

                    <!-- end comments -->

                </div>

                <!-- begin sidebar -->
                <div class="clearfix visible-xs"></div>
                <!-- end sidebar --></div>

        </div>
    </div>

@endsection
