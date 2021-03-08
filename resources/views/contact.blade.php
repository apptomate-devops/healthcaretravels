@section('title')
    Contact | {{APP_BASE_NAME}}
@endsection
@extends('layout.master')
@section('main_content')
    <!-- Header Container / End -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- <div class="g-recaptcha" data-sitekey="6LcxpKsUAAAAAHONGIDAR-CG_mGX1HJWVdO7rZzO"></div> -->
    <style type="text/css">

        @media only screen and (min-width: 768px) {
            /* For desktop: */
            .myclass {
                margin-top: 20px;
                position: fixed;
            }
        }

        @media only screen and (max-width: 768px) {
            /* For mobile: */
            .myform {
                margin-top: 490px;
            }

            .mapclass {
                max-width: 400px;
            }
        }

        #map {
            height: auto !important;
            flex: 1;
        }

        .contact_map {
            width: 100%;
            text-align: center;
            font-size: 14px !important;
            line-height: 1.6em !important;
            padding: 0px 30px;
        }
    </style>
    <!-- Content
    ================================================== -->

    <!-- Map Container -->
    <div class="contact-map margin-bottom-55">

        <!-- Google Maps -->
        <div id="map">

            <!-- <div class="col-md-12"></div> -->
            <!-- <a href="#" id="streetView">Street View</a> -->
        </div>
        <!-- Google Maps / End -->

        <!-- Office -->
        <div class="address-box-container">
            <div class="address-container" data-background-image="images/our-office.jpg"
                 style="background-image: url(&quot;images/our-office.jpg&quot;);">
                <div class="office-address">
                    <h3>Our Office</h3>
                    <ul>
                    <?php echo str_replace(',  ', ',<br />', CLIENT_ADDRESS); ?>

                    <!-- <li>Health Care Travels</li>
					<li>PO BOX 14565</li>
					<li>HUMBLE, TX 77347</li> -->
                    </ul>
                </div>
            </div>
        </div>
        <!-- Office / End -->

    </div>
    <div class="clearfix"></div>
    <!-- Map Container / End -->


    <!-- Container / Start -->
    <div class="container">

        <div class="row">

            <!-- Contact Details -->
            <div class="col-md-4">

                <h4 class="headline margin-bottom-30"><img class="footer-logo" src="/keepers_logo.png" alt=""></h4>

                <!-- Contact Details -->
                <div class="sidebar-textbox">
                    <p>
                    {{CONTACT_CONTENT}}<!-- Health Care Travels is committed to delivering a high level of expertise, customer service, and attention to detail to the market of accommodation booking . --></p>

                    <ul class="contact-details">
                        {{-- <li><i class="im im-icon-Phone-2"></i> <strong>Phone:</strong> <span>{{CLIENT_PHONE}}</span></li> --}}

                        <li><i class="im im-icon-Globe"></i> <strong>Web:</strong> <span><a target="_blank"
                                                                                            href="{{CLIENT_WEB}}">{{CLIENT_WEB}}</a></span>
                        </li>
                        <li><i class="im im-icon-Envelope"></i> <strong>E-Mail:</strong> <span><a target="_blank"
                                                                                                  href="mailto:{{CLIENT_MAIL}}">{{CLIENT_MAIL}}</a></span>
                        </li>
                    </ul>
                </div>
                <div class="">

                    <!-- Social Icons -->
                    <ul class="social-icons">
                        <li><a class="facebook" href="{{FACEBOOK}}" target="_blank"><i class="icon-facebook"></i></a>
                        </li>
                        <li><a class="twitter" href="{{TWITTER}}" target="_blank"><i class="icon-twitter"></i></a></li>
{{--                        <li><a class="gplus" href="{{GOOGLE}}" target="_blank"><i class="icon-gplus"></i></a></li>--}}
                        <li><a class="instagram" href="{{INSTAGRAM}}" target="_blank"><i class="icon-instagram"></i></a>
                        </li>
                    </ul>

                </div>

            </div>

            <!-- Contact Form -->
            <div class="col-md-8">

                <section id="contact">
                    <h4 class="headline margin-bottom-35">Contact Form</h4>

                    <div id="contact-message"></div>

                    <form method="post" action="{{URL('/')}}/contact_mail" autocomplete="off"
                          onsubmit="return form_validate();">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <div class="row">
                            <div class="col-md-6">
                                <div>
                                    <input name="name" type="text" id="" placeholder="Your Name" required="required">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div>
                                    <input name="email" type="email" id="" placeholder="Email Address"
                                           pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$"
                                           required="required">
                                </div>
                            </div>
                        </div>

                        <div>
                            <input name="subject" type="text" id="" placeholder="Subject" required="required">
                        </div>

                        <div>
                            <textarea name="message" cols="40" rows="3" id="" placeholder="Message" spellcheck="true"
                                      required="required"></textarea>
                        </div>

                        <div class="g-recaptcha" data-sitekey="6LcdUVMUAAAAAHf1NDwJ5VG7s3AemNQbXuMHZBsR"></div>
                        <br>

                        <button type="submit" class="submit btn btn-info btn-default">Submit Message</button>

                    </form>
                </section>
            </div>
            <!-- Contact Form / End -->

        </div>

    </div>
    <!-- Container / End -->

    <script type="text/javascript">
        var onloadCallback = function () {
            // alert("grecaptcha is ready!");
        };

        function form_validate() {
            var v = grecaptcha.getResponse();
            if (v.length == 0) {
                alert("Recaptcha Required.")
                return false;
            } else {
                return true;
            }
        }
    </script>

    <!-- Footer
    ================================================== -->
    <div style="margin-top:50px;height:150px;"></div>
    <!-- Back To Top Button -->


    </div>

    <!-- <script src="https://maps.googleapis.com/maps/api/js"></script> -->
@endsection
