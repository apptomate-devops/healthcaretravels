<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <title>
        Health Care Travels Admin
    </title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="SIVABHARATHY">
    <link rel="shortcut icon" href="{{BASE_URL}}favicon.ico"/>

    @include('Admin.Includes.styles')

    <style type="text/css">
        body::-webkit-scrollbar {
            width: 12px;
        }

        body::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        body::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
        }
    </style>
    <link rel="stylesheet" type="text/css"
          href="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/vendors/css/forms/selects/select2.min.css">
</head>
<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<!-- fixed-top-->

@include('Admin.Includes.head')

<!-- ////////////////////////////////////////////////////////////////////////////-->
@include('Admin.Includes.nav')

<div class="app-content content">
    <div class="content-wrapper">


        @yield('content')

    </div>
</div>


<!-- ////////////////////////////////////////////////////////////////////////////-->
@include('Admin.Includes.footer')

@include('Admin.Includes.scripts')


@yield('scripts')

<script
    src="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/vendors/js/forms/select/select2.full.min.js"
    type="text/javascript"></script>
<script
    src="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/js/scripts/forms/select/form-select2.min.js"
    type="text/javascript"></script>
</body>
</html>
