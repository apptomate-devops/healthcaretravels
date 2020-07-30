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
        </div>
        <hr width="100%"/>
        <div class="mail-container"style="margin: 1em 0; display: inline-block; font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; padding: 0; display: inline-block;">
            @yield('content')
        </div>
        <hr width="100%"/>
        @include('includes.mail-footer')
    </div>
</body>
</html>
