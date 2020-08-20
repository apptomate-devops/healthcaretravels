@extends('layout.master') @section('title','Health Care Travels') @section('main_content')


    <div class="container" style="margin-top: 35px;">
        <div class="row">
            <div class="col-md-12">
                <div class="style-1">
                {{-- <button class="btn" disabled>Description</button>
                <button class="btn btn-success" style="margin-left: 5px;">Price</button>
                <button class="btn" style="margin-left: 5px;">Images</button>
                <button class="btn" style="margin-left: 5px;">Details</button>
                <button class="btn" style="margin-left: 5px;">Location</button>
                <button class="btn" style="margin-left: 5px;">Amenties</button>
                <button class="btn" style="margin-left: 5px;">Calender</button> --}}
                <!-- Tabs Content -->
                    <div class="tabs-container">
                        <div class="tab-content" id="tab2" style="display: none;">
                            <form action="{{url('/')}}/owner/add-new-property/2" method="post" name="form-add-new">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <!-- Section -->
                                <div class="single-content">
                                    <h1 class="entry-title single-title">How It Works</h1>


                                    <div class="vc_row wpb_row vc_row-fluid wpestate_row vc_row">
                                        <div class="wpb_column vc_column_container vc_col-sm-12 vc_column">
                                            <div class="vc_column-inner ">
                                                <div class="wpb_wrapper">
                                                    <div
                                                        class="wpb_video_widget wpb_content_element vc_clearfix   vc_video-aspect-ratio-169 vc_video-el-width-100 vc_video-align-left vc_video">
                                                        <div class="wpb_wrapper">

                                                            <div class="wpb_video_wrapper">
                                                                <div class="video-container">
                                                                    <iframe width="1178" height="700"
                                                                            src="https://www.youtube.com/embed/oEJSStC-S0Y?feature=oembed"
                                                                            frameborder="0"
                                                                            allow="autoplay; encrypted-media"
                                                                            allowfullscreen=""></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
