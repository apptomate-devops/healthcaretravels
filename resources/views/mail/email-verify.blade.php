<!DOCTYPE html>
<html class="no-js" lang="en">
    <body>
        <div style="width: auto;border: 10px solid #d8750f;padding: 20px;margin: 10px;">
            <div class="container">
                <div class="navbar-header">
                    <div style="text-align: center;">
                        <a href="" title="" style="margin-top:0px">
                            <img src="{{BASE_URL}}uploads/keepers_logo.png"  height="100px" width="100px" class="img-responsive logo-new" ></a>
                    </div>
                    <?php  ?>
                    <span style="float:right; text-align:right;">

                    </span>

                    <div style="clear:both;" ></div>
                    <hr width="100%" />
                </div>
                <div class="mail-container">
                    <!--'.$content.'-->
                    <div style="margin: 0; font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; padding: 0; margin-top: 1em">

                        <div style="float: left;">Hi {{$name}},</div><br>
                        <br>
                        <div style="float: left;">
                            {{$email}}
                        </div><br>

                        <br><br>
                        <div style="float: left;">
                            {{$text}}
                        </div><br>

                        <div style="float: left;">
                            <a href="{{$url}}" style="color: blue;text-decoration: underline;">
                                Continue Login
                            </a>
                        </div><br>


                    </div>
                    <br />
                </div>
                <br />
                <hr width="100%" />
                <footer class="navbar-inverse">
                    <div class="row">
                        <!--'.$sign.'-->
                        Thank you<br>{{APP_BASE_NAME}} Team<br><br>
                        � 2018 {{APP_BASE_NAME}}. All Rights Reserved.
                        <br>
                        @include('mail.footer')
                        <div class="collapse navbar-collapse"></div>
                    </div>
                </footer>
            </div>
    </body>
</html>
