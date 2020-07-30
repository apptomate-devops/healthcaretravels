<!DOCTYPE html>
<html class="no-js" lang="en">
<body>
<div style="width: auto;border: 10px solid #d8750f;padding: 20px;margin: 10px;">
    <div class="container">
        <div class="navbar-header">
            <div style="text-align: center;">
                <a href="" title="" style="margin-top:0px">
                    <img src="{{BASE_URL}}uploads/keepers_logo.png" height="100px" width="100px" class="img-responsive logo-new">
                </a>
            </div>
            <span style="float:right; text-align:right;"></span>
            <div style="clear:both;"></div>
            <hr width="100%"/>
        </div>
        <div class="mail-container">
            <div style="margin: 0; font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; padding: 0; margin-top: 1em">
                @yield('content')
                <br>
            </div>
            <br/>
        </div>
        @include('includes.mail-footer')
    </div>
</body>
</html>
