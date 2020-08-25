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

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.css"/>
 
	{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/b-1.5.6/sl-1.3.0/datatables.min.css"/> --}}
	<link href="{{asset('vendors/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Page Vendors Styles -->
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

    <div id="app">
        @include('includes.header')
    <main class="py-4">
        <div class="kt-container">
            @yield('content')
        </div>
		<div style ="display: none;" class="kt-footer  kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
			<div class="kt-container  kt-container--fluid ">
				<div class="kt-footer__copyright">
                2019&nbsp;&copy;&nbsp;<a href="#" target="_blank" class="kt-link">App</a>
				</div>
				
		</div>
		</div>
	</main>
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
                    <script src="{{asset('vendors/custom/gmaps/gmaps.js')}}" type="text/javascript"></script>
                <!--end::Page Vendors -->
  

            
    <!--begin::Page Scripts(used by this page) -->
                    <script src="{{asset('js/pages/dashboard.js')}}" type="text/javascript"></script>
				<!--end::Page Scripts -->
				
				<!--begin::Page Vendors(used by this page) -->
				{{-- <script src="{{asset('js/datatables.bundle.js')}}" type="text/javascript"></script> --}}
				<!--end::Page Vendors -->



				
{{-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/b-1.5.6/sl-1.3.0/datatables.min.js"></script> --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.js"></script>
				<!--begin::Page Scripts(used by this page) -->
					<script src="{{asset('js/pages/scrollable.js')}}" type="text/javascript"></script>
				<!--end::Page Scripts -->
				<!--begin::Page Scripts(used by this page) -->
				<script src="{{asset('js/pages/dashboard.js')}}" type="text/javascript"></script>
				{{-- <script src="{{asset('vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script> --}}
			<!--end::Page Scripts -->


</body>
</html>