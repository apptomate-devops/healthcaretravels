<!DOCTYPE html>
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PBXWJ52');</script>
<!-- End Google Tag Manager -->

<!-- Basic Page Needs
================================================== -->
<title>@yield('title')</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="google-site-verification" content="FLL3mad9UxnF2ohZAQRFW0w8TM5AyfRjoD4r31Pygq0" />

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
        @media (max-width: 992px) {
            .card {
                width: 100%;
            }
        }
    </style>
@include('includes.styles')

</head>

<body class=" header_double_height">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PBXWJ52"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

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
@include('includes.mask')
    @yield('custom_script')
</div>
<!-- Wrapper / End -->

</body>
</html>
