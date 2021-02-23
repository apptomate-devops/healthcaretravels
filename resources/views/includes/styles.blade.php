<!-- START - Facebook Open Graph, Google+ and Twitter Card Tags 99.99.99 -->
<meta name="description"
    content="Health Care Travels is committed to delivering a high level of expertise, customer service, and attention to detail to the market of accommodation booking." />
<meta property="og:locale" content="en_US" />
<meta property="og:image" content="https://healthcaretravels.com/hct-logo-square.jpeg">
<meta property="og:site_name" content="The best place to rent/book properties to/for healthcare workers | Health Care Travels" />
<meta property="og:title" content="The best place to rent/book properties to/for healthcare workers | Health Care Travels" />
<meta itemprop="name" content="The best place to rent/book properties to/for healthcare workers | Health Care Travels" />
<meta name="twitter:title" content="The best place to rent/book properties to/for healthcare workers | Health Care Travels" />
<meta property="og:url" content="https://healthcaretravels.com/" />
<meta property="og:type" content="website" />
<meta property="og:description"
    content="Health Care Travels is committed to delivering a high level of expertise, customer service, and attention to detail to the market of accommodation booking." />
<meta itemprop="description"
    content="Health Care Travels is committed to delivering a high level of expertise, customer service, and attention to detail to the market of accommodation booking." />
<meta name="twitter:card" content="summary_large_image" />
<!-- END - Facebook Open Graph, Google+ and Twitter Card Tags -->

<link rel="shortcut icon" href="{{URL::asset('favicon.ico')}}" type="image/x-icon">

<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/style-override.css') }}">

<link rel="stylesheet" href="{{ URL::asset('css/colors/main.css') }}" id="colors">
<link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}">
<script src="{{ URL::asset('lib/jquery.min.js') }}"></script>
<script src="{{ URL::asset('lib/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('lib/moment.min.js') }}"></script>
{{--<script src="{{ URL::asset('lib/jquery-ui.custom.min.js') }}"></script>--}}
<link rel="stylesheet" type="text/css" href="{{ URL::asset('calendar/calendar1.css')}}" />
<script src="{{ URL::asset('calendar/calendar.js') }}"></script>
<script src="{{ URL::asset('lib/bootbox.min.js') }}"></script>

{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>--}}
{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>--}}
{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.tr.min.js"></script>--}}
<link rel="stylesheet" href="{{ URL::asset('css/bootstrap-timepicker.min.css') }}">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>

<link rel="stylesheet" href="{{URL::asset('css/caleran.min.css')}}">
{{--<!-- <script type="text/javascript" src="{{URL::asset('js/moment.min.js')}}"></script> -->--}}

<script type="text/javascript" src="{{URL::asset('js/caleran.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}

{{-- Analytics code here --}}

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-117530617-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-117530617-1');
</script>
<!-- Hotjar Tracking Code for https://healthcaretravels.com/ -->
<script>
    if(window.location.origin === 'https://healthcaretravels.com') {
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:1973030,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    }
</script>

{{-- End Analytics codes --}}

{{-- Intercom integration --}}
<script>
    if("{{APP_ENV}}" !== 'local') {
        window.intercomSettings = {
            app_id: "rq7sg7kx"
        };
    }
</script>

<script>
// We pre-filled your app ID in the widget URL: 'https://widget.intercom.io/widget/rq7sg7kx'
(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/rq7sg7kx';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>

{{-- End Intercom integration --}}
