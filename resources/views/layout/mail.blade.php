<!DOCTYPE html>
<html class="no-js" lang="en">
<body>
<div style="width: auto;border: 10px solid #d8750f;padding: 20px;margin: 10px;">
    <div class="container">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center">
                    <a href="{{BASE_URL}}" style="margin-top:0px">
                        <img title="Logo" alt="Logo" src="{{BASE_URL}}uploads/keepers_logo.png" height="70px" width="100px" class="img-responsive logo-new">
                    </a>
                </td>
            </tr>
        </table>
        <hr width="100%"/>
        <div class="mail-container"style="margin: 1em 0; display: inline-block; font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; padding: 0; display: inline-block;">
            @yield('content')
        </div>
        <hr width="100%"/>
        @include('includes.mail-footer')
    </div>
</body>
</html>
