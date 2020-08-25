<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="description" content="Updates and statistics">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'App Grocery') }}</title>
    <!--begin::Fonts -->
    <script src="//ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Fonts -->
    <!--begin::Page Vendors Styles(used by this page) -->
    <link href="{{asset('vendors/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles -->
    
    <link href="{{asset('/css/login-1.css')}}" rel="stylesheet" type="text/css" />
    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{asset('vendors/global/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles -->
    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{asset('css/skins/header/base/light.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/skins/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/skins/brand/dark.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/skins/aside/dark.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{asset('media/logos/favicon.png')}}" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    <div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
    <!--begin::Aside-->
    <div class="kt-grid__item kt-grid__item--order-tablet-and-mobile-2 kt-grid kt-grid--hor kt-login__aside" style="background-image: url({{asset('/media/bg/bg-4.jpg')}});">
        <div class="kt-grid__item">
            <a href="#" class="kt-login__logo">
                <img src="{{asset('/media/logos/logo-4.png')}}">
            </a>
        </div>
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver">
            <div class="kt-grid__item kt-grid__item--middle">
                <h3 class="kt-login__title">Welcome to App Grocery!</h3>
                <h4 class="kt-login__subtitle">The ultimate Grocery app.</h4>
            </div>
        </div>
        <div class="kt-grid__item">
            <div class="kt-login__info">
                <div class="kt-login__copyright">
                    &copy 2019 App Grocery
                </div>
                <div class="kt-login__menu">
                    <a href="#" class="kt-link">Privacy</a>
                    <a href="#" class="kt-link">Legal</a>
                    <a href="#" class="kt-link">Contact</a>
                </div>
            </div>
        </div>
    </div>
    <!--begin::Aside-->

    <!--begin::Content-->
            @yield('content')
    <!--end::Content-->
</div>
</div>
</div>

<script>
    var KTAppOptions = {"colors":{"state":{"brand":"#5d78ff","dark":"#282a3c","light":"#ffffff","primary":"#5867dd","success":"#34bfa3","info":"#36a3f7","warning":"#ffb822","danger":"#fd3995"},"base":{"label":["#c5cbe3","#a1a8c3","#3d4465","#3e4466"],"shape":["#f0f3ff","#d9dffa","#afb4d4","#646c9a"]}}};
</script>
<!-- end::Global Config -->


<!--begin::Global Theme Bundle(used by all pages) -->
        <script src="{{asset('vendors/global/vendors.bundle.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/scripts.bundle.js')}}" type="text/javascript"></script>
        
        <!--end::Global Theme Bundle -->


<!--begin::Page Vendors(used by this page) -->
                <script src="{{asset('vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
                <script src="http://maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
                <script src="{{asset('vendors/custom/gmaps/gmaps.js')}}" type="text/javascript'></script>
<!--end::Page Vendors -->


        
<!--begin::Page Scripts(used by this page) -->
                <script src="{{asset('js/pages/dashboard.js')}}" type="text/javascript"></script>
            <!--end::Page Scripts -->
            
            <!--begin::Page Vendors(used by this page) -->
            <script src="{{asset('js/datatables.bundle.js')}}" type="text/javascript"></script>
            <!--end::Page Vendors -->
            
            <!--begin::Page Scripts(used by this page) -->
                <script src="{{asset('js/pages/scrollable.js')}}" type="text/javascript"></script>
            <!--end::Page Scripts -->
            <!--begin::Page Scripts(used by this page) -->
            <script src="{{asset('js/pages/dashboard.js')}}" type="text/javascript"></script>
            {{-- <script src="{{asset('vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script> --}}
        <!--end::Page Scripts -->
</body>
</html>