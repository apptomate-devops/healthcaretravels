<!DOCTYPE html>
<html class="no-js" lang="en">
<body>
<div style="width: auto;border: 5px solid #d8750f;padding: 20px;margin: 10px;">
    <div class="container">
        <div class="navbar-header">
            <div style="text-align: center;">
                <a href="" title="" style="margin-top:0px">
                    <img src="{{BASE_URL}}uploads/keepers_logo.png" class="img-responsive logo-new" width="100px"
                         height="100px"></a>
            </div>
            <?php  ?>
            <span style="float:right; text-align:right;">

                    </span>

            <div style="clear:both;"></div>
            <hr width="100%"/>
        </div>
        <div class="mail-container">
            <!--'.$content.'-->
            <div
                style="margin: 0; font-family: 'Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif'; padding: 0; margin-top: 1em">

                <div style="float: left;">Name : {{$name}},</div>
                <br>
                <br>
                <div style="float: left;">
                    Email : <a href="mailto:{{$email}}">{{$email}}</a>
                </div>
                <br>

                <br><br>
                Message : <br> <br>
                <div style="float: left;">
                    {{$text}}
                </div>
                <br>

                <br>


            </div>
            <br/>
        </div>
        <br/>


    </div>
</body>
</html>
