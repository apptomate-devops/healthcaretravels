<!DOCTYPE html>
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>Register / Login | {{APP_BASE_NAME}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    @include('includes.styles')
<style>
    .my-account label input {
    margin-top: 8px;
    padding-left: 50px;
    height: 53px;
}
</style>
</head>

<body>
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Header Container
        ================================================== -->
        @include('includes.header')
        <div class="clearfix"></div>
        <!-- Header Container / End -->

        <!-- Container -->
        <div class="container" style="margin-top: 40px;">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    @if (count($errors) > 0)
                    <div class = "alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        <h4>{{ Session::get('success') }}</h4>
                    </div>
                    @endif

                    <!--Tab -->
                    <div class="my-account style-1 margin-top-5 margin-bottom-40">

                        <ul class="tabs-nav">
                            <li class=""><a href="#tab1">Reset Password</a></li>

                        </ul>

                        <div class="tabs-container alt">

                            <!-- Login -->
                            <div class="tab-content" id="tab1" style="display: none;">
                                <form method="post" class="login">

                                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                    <p class="form-row form-row-wide">
                                        <label for="email">Email :
                                            <i class="im im-icon-Email"></i>
                                            <input type="text" class="input-text validate1" name="email" id="email" value="" />
                                        </label>
                                    </p>

                                    <p class="form-row">
                                        <input type="submit" id="button" class="button border margin-top-10" name="login" value="Send Reset Email" />
                                        <a href="{{BASE_URL}}login" style="float: right;margin-top: 20px;">Back</a>
                                    </p>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container / End -->
        <!-- Footer
        ================================================== -->
        @include('includes.footer')
        <!-- Footer / End -->
        <!-- Back To Top Button -->
        <div id="backtotop"><a href="#"></a></div>
        <!-- Scripts
        ================================================== -->
        @include('includes.scripts')
    </div>
    <!-- Wrapper / End -->
</body>
</html>
