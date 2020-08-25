@extends('layouts.gh')

@section('content')
<div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">
<!--begin::Body-->
<div class="kt-login__body">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (Route::has('login'))
            <nav class="navbar navbar-default" style="float:right;">
            <div class="container-fluid">
                <ul class="nav navbar-nav">
                    @auth
                        <li><a href="{{ url('/home') }}">Home</a></li><br/>
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li><br/>
                    @if (Route::has('register'))            
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endif
                    @endauth
                </ul>
            </div>
            </nav>
            @endif
</div></div>
</div></div>
@endsection
