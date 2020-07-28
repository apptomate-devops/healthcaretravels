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

</head>

<body>

    <!-- Wrapper -->
    <div id="wrapper">


        <!-- Header Container
        ================================================== -->
        @include('includes.header')
        <div class="clearfix"></div>
        <!-- Header Container / End -->






        <!-- Contact
        ================================================== -->

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

                    @if(Session::has('error'))
                    <div class="alert alert-danger">
                        <h4>{{ Session::get('error') }}</h4>
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
                                <form method="post" action="{{BASE_URL}}new-password" class="login">

                                    @if($error == 1)
                                    <div class="alert alert-danger">
                                        <h4>Your link has been expired</h4>
                                    </div>
                                    @else

                                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                    <input type="hidden" name="email" value="{{$email}}" />
                                    <p class="form-row form-row-wide">
                                        <label for="email">New Password :
                                            <i class="im im-icon-Email"></i>
                                            <input type="password" class="input-text validate1" name="password" id="email" value="" />
                                        </label>
                                    </p>

                                    <p class="form-row form-row-wide">
                                        <label for="email">Confirm Password :
                                            <i class="im im-icon-Email"></i>
                                            <input type="password" class="input-text validate1" name="confirm_password" id="email" value="" />
                                        </label>
                                    </p>

                                    <p class="form-row">
                                        <input type="submit" id="button" class="button border margin-top-10" name="login" value="Reset Password" />
                                        <a href="http://13.127.130.227/keepers/login" style="float: right;margin-top: 20px;">Back</a>
                                    </p>
                                    @endif



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