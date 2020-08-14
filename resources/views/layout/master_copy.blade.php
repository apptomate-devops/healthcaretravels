<!DOCTYPE html>
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="{{BASE_URL}}public/favicon.ico" />
    <!-- CSS
    ================================================== -->
    @include('includes.styles')

</head>

<body class=" header_double_height">

<!-- Wrapper -->
<div id="wrapper">


    <!-- Header Container
    ================================================== -->
    @include('includes.header')
    <div class="clearfix"></div>
    <!-- Header Container / End -->



    @yield('main_content')


<!-- Contact
================================================== -->


    <!-- Footer
    ================================================== -->
<!-- Footer / End -->


    <!-- Back To Top Button -->
    <div id="backtotop"><a href="#"></a></div>


    <!-- Scripts
    ================================================== -->
    @include('includes.scripts_only')


    <script type="text/javascript">
        $('#button').click(function (e) {
            var isvalid = true;
            var checki=true;
            $(".validate").each(function () {
                if ($.trim($(this).val()) == '') {
                    isValid = false;
                    $(this).css({
                        "border-color": "1px solid red",
                        "background": ""
                    });
                    //alert("Please fill all required fields");
                    if (isValid == false)
                        e.preventDefault();
                }
                else {
                    $(this).css({
                        "border": "2px solid green",
                        "background": ""
                    });

                }
            });

        });
    </script>
</div>
<!-- Wrapper / End -->

</body>
</html>
