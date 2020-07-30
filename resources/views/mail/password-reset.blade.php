<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html class="no-js" lang="en">
    <body>
        <div style="width: auto;border: 5px solid #d8750f;padding: 20px;margin: 10px;">
            <div class="container">
                <div class="navbar-header">
                    <div style="text-align: center;">
                        <a href="" title="" style="margin-top:0px">
                            <img src="{{BASE_URL}}public/uploads/keepers_logo.png" height="100px" width="100px" class="img-responsive logo-new" ></a>
                    </div>
                    <?php  ?>
                    <span style="float:right; text-align:right;">

                    </span>

                    <div style="clear:both;" ></div>
                    <hr width="100%" />
                </div>
                <div class="mail-container">
                    <br />
                    <!--                    <b>Hi '.$username.' </b>-->
                    <span style="float:left; text-align:left;"><b>Hi {{$username}} </b></span>
                    <br />
                    <br />
                    {{$text}}
                    <!-- <b> Thanks for riding with Us</b> -->
                    <br />
                    <!--'.$content.'-->
                    <div style="margin: 0; font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; padding: 0; margin-top: 1em">
                        <a href="{{BASE_URL}}new-password/{{$token}}" style="margin: 0; font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; display: block; padding: 10px 16px; text-decoration: none; border-radius: 2px; border: 1px solid; text-align: center; vertical-align: middle; font-weight: bold; white-space: nowrap; background: #007dc6; background-color: #007dc6; color: rgb(255, 255, 255); border-top-width: 1px" target="_blank">
                            Click here to reset your password
                        </a>
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
