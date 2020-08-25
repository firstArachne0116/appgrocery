<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>App Grocery</title>
    <!-- main css -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <!-- main css -->
    
    <!--wow-->
    <link rel="stylesheet" type="text/css" href="{{asset('wow-slider/engine1/style.css')}}" />
    <link href="{{ asset('css/font-awesome.min.css')}}" />
    <script src="{{asset('wow-slider/engine1/jquery.js')}}"></script>
    <!--wow-->    
</head>
<body>

<!-- header -->
@include("includes.header")
<!-- header -->
<div class="clearfix"></div>
<!-- Navigation -->
@include("includes.navigation")
<!-- Navigation -->

@yield("content")

<!-- Footer -->
@include("includes.footer")
<!--easyzoom-->
<script src="{{ asset('vendors/detail-page/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('vendors/jquery/easyzoom.js') }}"></script>
<script src="{{ asset('vendors/jquery/easyzoom-script.js') }}"></script>
<!--easyzoom-->
<!--bootstrap-->
<script src="{{ asset('vendors/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!--bootstrap-->
<!--wow-->
<script src="{{ asset('vendors/wow/wow.js') }}"></script>
<script src="{{ asset('vendors/wow/page.js') }}"></script>
<!--wow-->
<!--owl.carousel-->
<script src="{{ asset('owlcarousel/owl.carousel.js') }}"></script>
<!--owl.carousel-->
<!--related-products-->
<script src="{{ asset('vendors/detail-page/related-products.js') }}"></script>
<script  src="{{ asset('vendors/detail-page/index.js') }}"></script>
<!--related-products-->
<script src="{{ asset('vendors/jquery/quality.js') }}"></script>
<script src="{{ asset('vendors/jquery/product.js') }}"></script>
<!--fancybox files -->
<link rel="stylesheet" href="{{ asset('css/product-hover.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/fancy-box/fancybox.min.css') }}" />
<script src="{{ asset('vendors/fancy-box/jquery.fancybox.min.js') }}"></script>
<!--scrolltop-->
<script src="{{ asset('vendors/jquery/scrolltopcontrol.js') }}"></script>
<!--scrolltop-->
<!--bootstrap-->
<script src="{{ asset('vendors/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
<!--bootstrap-->
{{-- Custom JS FILES --}}
<script src="{{asset('js/common.js')}}"></script>
{{-- CUSTOM FJS FILES --}}
</body>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function() {
  var startPos;
  var geoSuccess = function(position) {
    startPos = position;    
    var lats = startPos.coords.latitude;
    var longs = startPos.coords.longitude; 
    $.ajax({  
    url:    'setlocation',
    method:   'post',
    data: {lat:lats, long:longs},  
    success: function(response){
        console.log(response);
    },
  });       
  };
  navigator.geolocation.getCurrentPosition(geoSuccess);
});
</script>
</html>
