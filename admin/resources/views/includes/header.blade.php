<?php
$notificationCnt=0;
 if (Auth::check() )
 {
	 $user=Auth::user();
	 $notify=$user->unreadNotifications;
	 if(!empty($notify))
	 {
		 $notificationCnt=$notify->count();
		 
	 }
 }
// dd($notificationCnt);
?>

<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        <a href="{{route('home')}}">
            <img alt="Logo" src="{{asset('/media/logos/logo-4.png')}}" />
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span>
        </button>
        <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i>
        </button> 
    </div>
</div>
<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <!-- begin:: Aside -->
        <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i>
        </button>
        <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
            <!-- begin:: Aside -->
            <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
                <div class="kt-aside__brand-logo">
                    <a href="{{route('home')}}">
                        <img alt="Logo" src="{{asset('media/logos/logo-4.png')}}" />
                    </a>
                </div>
                <div class="kt-aside__brand-tools">
                    <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler"> <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
    <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" id="Path-94" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
    <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
</g>
</svg></span>
                        <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
    <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" id="Path-94" fill="#000000" fill-rule="nonzero"/>
    <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
</g>
</svg></span>
                    </button>
                    <!--
        <button class="kt-aside__brand-aside-toggler kt-aside__brand-aside-toggler--left" id="kt_aside_toggler"><span></span></button>
        -->
                </div>
            </div>
            <!-- end:: Aside -->
            <!-- begin:: Aside Menu -->
            <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
                <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
                    <ul class="kt-menu__nav ">
                        {{-- Admin Roles --}} @role('admin') @include('includes.admin') @endrole {{-- Vendor Roles --}} @role('vendor') @include('includes.vendor') @endrole
                        <!-- end:: Aside Menu -->

                        <!-- end:: Aside -->
                        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                            <!-- begin:: Header -->
                            <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">
                                <!-- begin:: Header Menu -->
                                <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i>
                                </button>
                                <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
                                    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">

                                    </div>
                                </div>
                                <!-- end:: Header Menu -->

                                <!-- begin:: Header Topbar -->
                                <div class="kt-header__topbar">
                                    <!--begin: Search -->
                                    <!--begin: Search -->
                                    {{-- <div class="kt-header__topbar-item kt-header__topbar-item--search dropdown" id="kt_quick_search_toggle">
                                        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                            <span class="kt-header__topbar-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    <rect id="bound" x="0" y="0" width="24" height="24"/>
    <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" id="Path-2" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
    <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" id="Path" fill="#000000" fill-rule="nonzero"/>
</g>
</svg>							</span>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
                                            <div class="kt-quick-search kt-quick-search--inline" id="kt_quick_search_inline">
                                                <form method="get" class="kt-quick-search__form">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span></div>
                                                        <input type="text" class="form-control kt-quick-search__input" placeholder="Search...">
                                                        <div class="input-group-append"><span class="input-group-text"><i class="la la-close kt-quick-search__close"></i></span></div>
                                                    </div>
                                                </form>
                                                <div class="kt-quick-search__wrapper kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <!--end: Search -->
                                    <!--end: Search -->
                                    <!--begin: Notifications -->

                                    <div class="kt-header__topbar-item dropdown">
                                        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="30px,0px" aria-expanded="true">
                                            <span class="kt-header__topbar-icon kt-pulse kt-pulse--brand">
                                                    <?php $product_approve_count = App\Productconfig::where('is_approved',0)->count() ?>
                                                   
                                                    @if($notificationCnt>0)
                                                    <span class="badge badge-light">{{$notificationCnt + $product_approve_count }}</span>
                                                   @endif  
                                                  
                                                   
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    <rect id="bound" x="0" y="0" width="24" height="24"/>
    <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" id="Combined-Shape" fill="#000000" opacity="0.3"/>
    <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" id="Combined-Shape" fill="#000000"/>
</g>
</svg>                                <span class="kt-pulse__ring"></span>
                                            </span>
                                            <!--
            Use dot badge instead of animated pulse effect: 
            <span class="kt-badge kt-badge--dot kt-badge--notify kt-badge--sm kt-badge--brand"></span>
        -->
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-lg">
                                            <form>
                                                <!--begin: Head -->
                                                <div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b" style="background-image: url({{asset('media/misc/bg-1.jpg')}})">
                                                    <h3 class="kt-head__title">
        User Notifications 
        &nbsp;
        {{-- <span class="btn btn-success btn-sm btn-bold btn-font-md">23 new</span> --}}
    </h3>

                                                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active show" data-toggle="tab" 
                                                        href="#topbar_notifications_notifications" role="tab" aria-selected="true">Events 
                                                        @if($notificationCnt>0)
                                                        <span class="badge badge-light">{{$notificationCnt}}</span>
                                                        @endif   
                                                       
                                                        </a>
                                                        </li>
                                                        @role('admin')
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-toggle="tab" href="#topbar_notifications_events" role="tab" aria-selected="false">Pending Actions @if($product_approve_count)
                                                                    <span class="badge badge-light">{{$product_approve_count}}</span>
                                                                   @endif</a>
                                                        </li>
                                                        @endrole
                                                        {{-- <li class="nav-item">
                                                            <a class="nav-link" data-toggle="tab" href="#topbar_notifications_logs" role="tab" aria-selected="false">Logs</a>
                                                        </li> --}}
                                                    </ul>
                                                </div>
                                                @if($notificationCnt>0)
                                                    <div class="row" style="position:absolute;bottom:25px;left:30px;">
                                                            <a href="{{route('markAllAsRead')}}" class="button" style="z-index:9999999;">Clear all </a>
                                                        </div>
                                                    @endif
                                                
                                                
                                                <!--end: Head -->

                                                <div class="tab-content">
                                                    <div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
                                                        <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
														     @if($notificationCnt>0)
                                                            @foreach (Auth::user()->unreadNotifications as $notification)
                                                                
                                                            <a  class="kt-notification__item">
                                                                    <div class="kt-notification__item-icon">
                                                                        <i class="flaticon2-line-chart kt-font-success"></i>
                                                                    </div>
                                                                    <div class="kt-notification__item-details">
                                                                        <div class="kt-notification__item-title">
                                                                             {{ $notification->data['message'] }}
                                                                            
                                                                        </div>
                                                                        <div class="kt-notification__item-time">
                                                                                {{ $notification->created_at->diffForHumans()}} 
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <a href="{{route('markAsRead',['id' => $notification->id  ])}}" class="button" style="padding:1.1rem 1.5rem;">Mark as Read</a>

                                                            
                                                            @endforeach
															@endif
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
                                                        <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                                            
                                                        <a href="{{route('product.list')}}" class="kt-notification__item">
                                    
                                                                <div class="kt-notification__item-details">
                                                                    <div class="kt-notification__item-title">
                                                                       @role('admin')
                                                                       @if ($product_approve_count)
                                                                            {{$product_approve_count.' products are pending approval'}}  
                                                                       @endif
                                                                       @endrole
                                                                    </div>
                                                                </div>
                                                            </a>
               
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                                                        {{--
                                                        <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                                                            <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                                                <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                                                    All caught up!
                                                                    <br>No new notifications.
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!--end: Notifications -->
                                    <!--begin: My Cart -->
                                    <!-- <div class="kt-header__topbar-item dropdown">
<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="30px,0px" aria-expanded="true">
    <span class="kt-header__topbar-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    <rect id="bound" x="0" y="0" width="24" height="24"/>
    <path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" id="Path-30" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
    <path d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z" id="Combined-Shape" fill="#000000"/>
</g>
</svg>                    </span>
</div>
<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
    <form>

<div class="kt-mycart">
        <div class="kt-mycart__head kt-head" style="background-image: url(assets/media/misc/bg-1.jpg);">
        <div class="kt-mycart__info">
            <span class="kt-mycart__icon"><i class="flaticon2-shopping-cart-1 kt-font-success"></i></span>
            <h3 class="kt-mycart__title">My Cart</h3>
        </div> 
        <div class="kt-mycart__button">
            <button type="button" class="btn btn-success btn-sm" style=" ">2 Items</button>
        </div>                
    </div>        

<div class="kt-mycart__body kt-scroll" data-scroll="true" data-height="245" data-mobile-height="200">
    <div class="kt-mycart__item">
        <div class="kt-mycart__container">
            <div class="kt-mycart__info">
                <a href="#" class="kt-mycart__title">
                    Samsung                      
                </a>
                <span class="kt-mycart__desc">
                    Profile info, Timeline etc
                </span>

                <div class="kt-mycart__action">
                    <span class="kt-mycart__price">$ 450</span>
                    <span class="kt-mycart__text">for</span>
                    <span class="kt-mycart__quantity">7</span>
                    <a href="#" class="btn btn-label-success btn-icon">&minus;</a>
                    <a href="#" class="btn btn-label-success btn-icon">&plus;</a>
                </div>    
            </div>

            <a href="#" class="kt-mycart__pic">
                <img src="assets/media/products/product9.jpg" title="">
            </a>    
        </div>     			 
    </div>

    <div class="kt-mycart__item">
        <div class="kt-mycart__container">
            <div class="kt-mycart__info">
                <a href="#" class="kt-mycart__title">
                    Panasonic                       
                </a>

                <span class="kt-mycart__desc">
                    For PHoto & Others
                </span>

                <div class="kt-mycart__action">
                    <span class="kt-mycart__price">$ 329</span>
                    <span class="kt-mycart__text">for</span>
                    <span class="kt-mycart__quantity">1</span>
                    <a href="#" class="btn btn-label-success btn-icon">&minus;</a>
                    <a href="#" class="btn btn-label-success btn-icon">&plus;</a>                          
                </div>    
            </div>

            <a href="#" class="kt-mycart__pic">
                <img src="assets/media/products/product13.jpg" title="">
            </a>     
        </div>     			 
    </div>    

    <div class="kt-mycart__item">
        <div class="kt-mycart__container">
            <div class="kt-mycart__info">
                <a href="#" class="kt-mycart__title">
                    Fujifilm                       
                </a>
                <span class="kt-mycart__desc">
                    Profile info, Timeline etc
                </span>

                <div class="kt-mycart__action">
                    <span class="kt-mycart__price">$ 520</span>
                    <span class="kt-mycart__text">for</span>
                    <span class="kt-mycart__quantity">6</span>
                    <a href="#" class="btn btn-label-success btn-icon">&minus;</a>
                    <a href="#" class="btn btn-label-success btn-icon">&plus;</a>
                </div>    
            </div>

            <a href="#" class="kt-mycart__pic">
                <img src="assets/media/products/product16.jpg" title="">
            </a>    
        </div>     			 
    </div>

    <div class="kt-mycart__item">
        <div class="kt-mycart__container">
            <div class="kt-mycart__info">
                <a href="#" class="kt-mycart__title">
                    Candy Machine                      
                </a>

                <span class="kt-mycart__desc">
                    For PHoto & Others
                </span>

                <div class="kt-mycart__action">
                    <span class="kt-mycart__price">$ 784</span>
                    <span class="kt-mycart__text">for</span>
                    <span class="kt-mycart__quantity">4</span>
                    <a href="#" class="btn btn-label-success btn-icon">&minus;</a>
                    <a href="#" class="btn btn-label-success btn-icon">&plus;</a>                       
                </div>    
            </div>

            <a href="#" class="kt-mycart__pic">
                <img src="assets/media/products/product15.jpg" title="" alt="">
            </a>     
        </div>     			 
    </div>          
</div>

<div class="kt-mycart__footer">
    <div class="kt-mycart__section">
        <div class="kt-mycart__subtitel">
            <span>Sub Total</span>
            <span>Taxes</span>
            <span>Total</span>                    
        </div>  

        <div class="kt-mycart__prices">
            <span>$ 840.00</span> 
            <span>$ 72.00</span> 
            <span class="kt-font-brand">$ 912.00</span>
        </div>  
    </div>
    <div class="kt-mycart__button kt-align-right">
        <button type="button" class="btn btn-primary btn-sm">Place Order</button>
    </div>
</div>
</div>        </form>
</div>
</div> -->
                                    <!--end: My Cart -->

                                    <!--begin: Language bar -->

                                    <!-- <div class="kt-header__topbar-item kt-header__topbar-item--langs">
<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
    <span class="kt-header__topbar-icon">
        <img class="" src="assets/media/flags/020-flag.svg" alt="" />
    </span>
</div>
<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround">
    <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
<li class="kt-nav__item kt-nav__item--active">
    <a href="#" class="kt-nav__link">
        <span class="kt-nav__link-icon"><img src="assets/media/flags/020-flag.svg" alt="" /></span>
        <span class="kt-nav__link-text">English</span>
    </a>
</li>
<li class="kt-nav__item">
    <a href="#" class="kt-nav__link">
        <span class="kt-nav__link-icon"><img src="assets/media/flags/016-spain.svg" alt="" /></span>
        <span class="kt-nav__link-text">Arabian</span>
    </a>
</li>

</ul>    </div>
</div> -->

                                    <!--end: Language bar -->

                                    <!--begin: User Bar -->

                                    <div class="kt-header__topbar-item kt-header__topbar-item--user">
                                        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
                                            <div class="kt-header__topbar-user">
                                                <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
                                                <span class="kt-header__topbar-username kt-hidden-mobile">{{ Auth::user()->name }}</span> {{-- <img class="kt-hidden" alt="Pic" src="assets/media/users/300_25.jpg" /> --}}
                                                <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                                <span class="kt-badge kt-badge--username kt-badge--unified-success 
        kt-badge--lg kt-badge--rounded kt-badge--bold">{{strtoupper(substr(Auth::user()->name, 0, 1))}}</span>
                                            </div>
                                        </div>

                                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
                                            <!--begin: Head -->
                                            <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(assets/media/misc/bg-1.jpg)">
                                                <div class="kt-user-card__avatar">
                                                    <img class="kt-hidden" alt="Pic" src="{{asset('media/users/300_25.jpg')}}" />
                                                    <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                                    <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{strtoupper(substr(Auth::user()->name, 0, 1))}}</span>
                                                </div>
                                                <div class="kt-user-card__name">
                                                    Sean Stone
                                                </div>
                                                <div class="kt-user-card__badge">
                                                    {{-- <span class="btn btn-success btn-sm btn-bold btn-font-md">23 messages</span> --}}
                                                </div>
                                            </div>
                                            <!--end: Head -->

                                            <!--begin: Navigation -->
                                            <div class="kt-notification">
                                                {{-- <a href="#" class="kt-notification__item">
                                                    <div class="kt-notification__item-icon">
                                                        <i class="flaticon2-calendar-3 kt-font-success"></i>
                                                    </div>
                                                    <div class="kt-notification__item-details">
                                                        <div class="kt-notification__item-title kt-font-bold">
                                                            My Profile
                                                        </div>
                                                        <div class="kt-notification__item-time">
                                                            Account settings and more
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="kt-notification__item">
                                                    <div class="kt-notification__item-icon">
                                                        <i class="flaticon2-mail kt-font-warning"></i>
                                                    </div>
                                                    <div class="kt-notification__item-details">
                                                        <div class="kt-notification__item-title kt-font-bold">
                                                            My Messages
                                                        </div>
                                                        <div class="kt-notification__item-time">
                                                            Inbox and tasks
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="kt-notification__item">
                                                    <div class="kt-notification__item-icon">
                                                        <i class="flaticon2-rocket-1 kt-font-danger"></i>
                                                    </div>
                                                    <div class="kt-notification__item-details">
                                                        <div class="kt-notification__item-title kt-font-bold">
                                                            My Activities
                                                        </div>
                                                        <div class="kt-notification__item-time">
                                                            Logs and notifications
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="kt-notification__item">
                                                    <div class="kt-notification__item-icon">
                                                        <i class="flaticon2-hourglass kt-font-brand"></i>
                                                    </div>
                                                    <div class="kt-notification__item-details">
                                                        <div class="kt-notification__item-title kt-font-bold">
                                                            My Tasks
                                                        </div>
                                                        <div class="kt-notification__item-time">
                                                            latest tasks and projects
                                                        </div>
                                                    </div>
                                                </a>

                                                <a href="#" class="kt-notification__item">
                                                    <div class="kt-notification__item-icon">
                                                        <i class="flaticon2-cardiogram kt-font-warning"></i>
                                                    </div>
                                                    <div class="kt-notification__item-details">
                                                        <div class="kt-notification__item-title kt-font-bold">
                                                            Billing
                                                        </div>
                                                        <div class="kt-notification__item-time">
                                                            billing & statements <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">2 pending</span>
                                                        </div>
                                                    </div>
                                                </a> --}}
                                                <div class="kt-notification__custom kt-space-between">
                                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
    document.getElementById('logout-form').submit();" target="_blank" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>

                                                </div>
                                            </div>
                                            <!--end: Navigation -->
                                        </div>
                                    </div>
                                    <!--end: User Bar -->
                                </div>
                            
                                <!-- end:: Header Topbar -->
                            </div>
                            <style>
                                .jumbotron {
                                    background-color: #3b2f5c!important;
                                    color: #FFF;
                                }
                                
                                .card-title {
                                    background-color: #3b2f5c!important;
                                    color: #FFF!important;
                                }
                                
                                .subject-icon {
                                    flex: 0 0 50px;
                                    height: 50px;
                                    border-radius: 50%;
                                    display: flex !important;
                                    align-items: center;
                                    justify-content: center;
                                    margin-right: 20px;
                                }
                                
                                .subject-link {
                                    padding: 10px 20px;
                                    margin-bottom: 0;
                                    width: 100%;
                                    height: 90px;
                                    display: inline-flex;
                                    align-items: center;
                                    color: #000 !important;
                                    background: #fff;
                                    border: 1px solid #e1e1e1;
                                    border-radius: 5px;
                                    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.09) !important;
                                    font-size: 15px;
                                    font-weight: normal;
                                }
                                
                                .subject-li {
                                    display: inline-block !important;
                                    width: 300px;
                                    padding-top: 20px;
                                    padding-right: 12px;
                                    left: 40px;
                                }
                                
                                .popular-subjects {
                                    width: 100%;
                                    margin: auto;
                                }
                                
                                ul {
                                    padding: 0px 0px 0px 0px !important;
                                }
                                
                                .shadow {
                                    -webkit-box-shadow: 0 10px 6px -6px #c3c3c3;
                                    -moz-box-shadow: 0 10px 6px -6px #c3c3c3;
                                    box-shadow: 0 10px 6px -6px #c3c3c3;
                                }
                                
                                .popular-subjects {
                                    margin-top: 30px;
                                }
                                
                                .list-unstyled {
                                    line-height: 30px;
                                }
                                
                                .subject-icon {
                                    flex: 0 0 50px;
                                    height: 50px;
                                    border-radius: 50%;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    margin-right: 20px;
                                }
                                
                                .subject-li a:hover {
                                    list-style: none;
                                    text-decoration: none !important;
                                    background: #f2f8fb !important;
                                }
                                
                                .pd_18 {
                                    padding-top: 18px;
                                }
                                
                                .kt-badge a {
                                    color: #fff !important;
                                }
                                
                                label {
                                    display: inline-block;
                                    margin-bottom: .5rem;
                                    font-size: 15px;
                                    font-weight: 500;
                                }
                                
                                .col-md-3 {
                                    margin-bottom: 10px;
                                    border-bottom: 2px solid #f2f3f8;
                                    flex: 0 0 33.33333%;
                                }
                                
                                .subjects-list li {
                                    float: left;
                                    padding: 0px 0px 0px 20px;
                                    list-style-type: none;
                                    margin: 0px 0px 10px 0px;
                                }
                            </style>