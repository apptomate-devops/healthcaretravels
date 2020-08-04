<!DOCTYPE html>
<head>
<!-- Basic Page Needs
================================================== -->
<title>@yield('title')</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="google-site-verification" content="FLL3mad9UxnF2ohZAQRFW0w8TM5AyfRjoD4r31Pygq0" />


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-123742839-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-123742839-1');
</script>
<!-- CSS
================================================== -->
    <style type="text/css">
        /*html **/
        /*{*/
            /*font-family: sans-serif !important;*/
        /*}*/
        .tooltips {
    position: relative;
}

.tooltips .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: #e78016!important;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    top: -52px!important;


    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.tooltips:hover .tooltiptext {
    visibility: visible;
}
        .card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width: 40%;
    background-color: #f2f2f2;
}

.card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}
    </style>
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
@include('includes.footer')
<!-- Footer / End -->


<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>


<!-- Scripts
================================================== -->

@include('includes.scripts')


<script type="text/javascript">
    try {
        $("#caleran-ex-1").caleran();

        $( function() {
            $( "#datepicker" ).datepicker();
            $( "#datepicker1" ).datepicker();
            var date = new Date();
            $('#from_dates').datepicker({
                startDate: date
            });
            $("#from_date").datepicker({
                startDate: date,
                datesDisabled:["03/13/2018","11/28/2016","12/02/2016","12/23/2016"]
            });
            $('#to_date').datepicker({
                startDate: date
            });
        } );

        $('.date_picker').datepicker({});

        $('#timepicker').timepicker();
        $('#timepicker1').timepicker();
        $('#timepicker2').timepicker();

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
                        alert("Please fill all required fields");
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
    } catch (e) {};
</script>
    @yield('custom_script')
</div>
<!-- Wrapper / End -->

</body>
</html>
