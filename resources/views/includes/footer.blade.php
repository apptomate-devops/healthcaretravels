<div id="footer" class="sticky-footer">
    <!-- Main -->
    <div class="container">

        <div class="row">
            <div class="col-md-5 col-sm-6">
                <div>
                    <img class="footer-logo" src="{{url('/')}}/healthcaretravel.png" alt="">
                    <div class="hidden-md hidden-sm hidden-lg" style="float: right;">
                        <script type="text/javascript" src="https://sealserver.trustwave.com/seal.js?style=invert&code=396d793c4b3e43848064dce5b52f8e79"></script>
                    </div>
                </div>

                <br><br>
                <!-- <p>Health Care Travels is committed to delivering a high level of expertise, customer service, and attention to detail to the market of accommodation booking .</p> -->
                <p>
                    {{CONTACT_CONTENT}}

                </p>

                <br>
                <div class="hidden-xs">
                    <script type="text/javascript" src="https://sealserver.trustwave.com/seal.js?style=invert&code=396d793c4b3e43848064dce5b52f8e79"></script>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 ">
                <h4>Helpful Links</h4>
                <ul class="footer-links">
                    <!-- https://docs.google.com/forms/d/e/1FAIpQLSfAqkiqDWb4SVrS9ySxpGTVRFDTqX2noe3ItyKiGFBYwFmqeg/viewform?fbclid=IwAR2t27UuX3zLHL3fAl3gAgL_qEdDgZv4vF3U_mzCvdHAs4dEOuZGunsVJHA -->
                    <li><a href="{{url('/')}}/login" target="_blank">Login</a></li>
                    {{-- <li><a href="{{url('/')}}/rv-register" target="_blank" class="sign-in">RV Login</a></li> --}}
                    {{-- <li><a href="#" target="_blank" class="sign-in">RV Login</a></li> --}}
                    <li><a href="{{url('/')}}/terms-of-use">Terms Of Use</a></li>
                    <li><a href="{{url('/')}}/privacy-policy">Privacy Policy</a></li>
                    <li><a href="{{url('/')}}/policies">Policies</a></li>

                </ul>
                <ul class="footer-links">
                    <!-- <li><a href="#">How to be a Great Host</a></li> -->
                <!--<li><a href="{{url('/')}}/understanding-tax">Understanding Tax</a></li> -->
                    <li><a href="{{url('/')}}/fees">Fees Explained</a></li>
                <!-- <li><a href="{{url('/')}}/cancellationpolicy">Cancellation Policy</a></li> -->
                <!-- <li><a href="{{url('/')}}/payment-terms">Payment Terms</a></li> -->
                    <li><a href="{{url('/')}}/eye-catching-photos">Eye Catching Photos</a></li>
                <!-- <li><a href="{{url('/')}}/how-to-be-great-host">How to be a Great Host</a></li>
               <li><a href="{{url('/')}}/policies">Policies</a></li> -->
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-3  col-sm-12">
                <h4>Contact Us</h4>
                <div class="text-widget">
                    <span> <?php echo str_replace(',', ',<br />', CLIENT_ADDRESS); ?></span> <br>
                    E-Mail:<span> <a href="mailto:{{CLIENT_MAIL}}" target="_blank"><span class="__cf_email__" data-cfemail="b0dfd6d6d9d3d5f0d5c8d1ddc0dcd59ed3dfdd">
  {{CLIENT_MAIL}}
</span>
                </a></span> <br>
                    {{-- Mobile: <span><a href="tel:{{CLIENT_PHONE}}" class="__cf_email__" target="_blank"> {{CLIENT_PHONE}}</a></span> --}}
                </div>
                <ul class="social-icons margin-top-20">
                    <li><a class="facebook" href="{{FACEBOOK}}" target="_blank"><i class="icon-facebook"></i></a></li>
                    <li><a class="twitter" href="{{TWITTER}}" target="_blank"><i class="icon-twitter"></i></a></li>
                    <li><a class="gplus" href="{{GOOGLE}}" target="_blank"><i class="icon-gplus"></i></a></li>
                    <li><a class="instagram" href="{{INSTAGRAM}}" target="_blank"><i class="icon-instagram"></i></a></li>
                </ul>
            </div>
        </div>
        <!-- Copyright -->
        <div class="row">
            <div class="col-md-12">
                <div class="copyrights">© 2020 {{APP_BASE_NAME}}. All Rights Reserved.</div>
            </div>
        </div>
    </div>

</div>
<!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '193582665302375');
    fbq('track', 'PageView');
</script>
<noscript>
    <img height="1" width="1"
         src="https://www.facebook.com/tr?id=193582665302375&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->
