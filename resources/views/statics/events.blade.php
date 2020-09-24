@extends('layout.master') @section('title','Events') @section('main_content')
    <style type="text/css">
        li {
            display: list-item;
            line-height: 30px;
        }

        ul {
            padding-left: 30px;
        }


    </style>


    <div class="container" style="margin-top: 35px;">
        <div class="row">
            <div class="col-md-12">
                <center><p style="font-size: 20px;">Events</p></center>
                <div class="row">


                </div>
                {{-- <p>Interested in learning how to partner with Health Care Travels? Email us at <a
                        href="maillto:info@healthcaretravels.com"> info@healthcaretravels.com</a>. Please send your
                    contact information and why you're interested in partnering with us along with a description of the
                    products and services you or your company can provide. Please also include why you think Health Care
                    Travels should consider partnering with your brand. A team member will review your inquiry and
                    contact you via email. We are open to different partnerships that will scale traveling healthcare
                    professionals and homeowners experience on our platform. Below you can find our current partners.
                </p> --}}
                <div class="image">
                    <center>
                        <div class="col-md-12 pb-20">
                            <img src="{{URL::asset('/assets/events/exhibitor2021.jpeg')}}"
                                 style="vertical-align: middle;height: 331px;">
                        </div>
                    </center>
                </div>


                <br>
                <br>
                <br>
            </div>
        </div>
    </div>

@endsection
