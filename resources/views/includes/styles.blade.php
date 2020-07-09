<link rel="shortcut icon" href="{{URL::asset('favicon.ico')}}" type="image/x-icon">

  <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">

  <link rel="stylesheet" href="{{ URL::asset('css/colors/main.css') }}" id="colors">
  <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}">
  <script src="{{ URL::asset('lib/jquery.min.js') }}"></script>
  <script src="{{ URL::asset('lib/bootstrap.min.js') }}"></script>
  <script src="{{ URL::asset('lib/moment.min.js') }}"></script>
<script src="{{ URL::asset('lib/jquery-ui.custom.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('calendar/calendar1.css')}}" />
<script src="{{ URL::asset('calendar/calendar.js') }}"></script>
<script src="{{ URL::asset('lib/bootbox.min.js') }}"></script>

 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.tr.min.js"></script>
 <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-timepicker.min.css') }}">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>

  <link rel="stylesheet" href="{{URL::asset('css/caleran.min.css')}}">
  <!-- <script type="text/javascript" src="{{URL::asset('js/moment.min.js')}}"></script> -->

  <script type="text/javascript" src="{{URL::asset('js/caleran.min.js')}}"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
  <style type="text/css">
    #snackbar {
      visibility: hidden; /* Hidden by default. Visible on click */
      min-width: 250px; /* Set a default minimum width */
      margin-left: -125px; /* Divide value of min-width by 2 */
      background-color: #333; /* Black background color */
      color: #fff; /* White text color */
      text-align: center; /* Centered text */
      border-radius: 2px; /* Rounded borders */
      padding: 16px; /* Padding */
      position: fixed; /* Sit on top of the screen */
      z-index: 1; /* Add a z-index if needed */
      left: 50%; /* Center the snackbar */
      bottom: 30px; /* 30px from the bottom */
    }

    /* Show the snackbar when clicking on a button (class added with JavaScript) */
    #snackbar.show {
      visibility: visible; /* Show the snackbar */

      /* Add animation: Take 0.5 seconds to fade in and out the snackbar.
      However, delay the fade out process for 2.5 seconds */
      -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
      animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    /* Animations to fade the snackbar in and out */
    @-webkit-keyframes fadein {
      from {bottom: 0; opacity: 0;}
      to {bottom: 30px; opacity: 1;}
    }

    @keyframes fadein {
      from {bottom: 0; opacity: 0;}
      to {bottom: 30px; opacity: 1;}
    }

    @-webkit-keyframes fadeout {
      from {bottom: 30px; opacity: 1;}
      to {bottom: 0; opacity: 0;}
    }

    @keyframes fadeout {
      from {bottom: 30px; opacity: 1;}
      to {bottom: 0; opacity: 0;}
    }

    a:focus, a:hover {
      color: #e78016;
      text-decoration: underline;
    }

    .alert-success {
        color: #ffffff;
        background-color: #e78016 !important;
        border-color: #ffffff;
    }
  </style>
