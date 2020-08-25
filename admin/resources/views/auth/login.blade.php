@extends('layouts.gh')

@section('content')
<div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">
<!--begin::Body-->
<div class="kt-login__body">
    <!--begin::Signin-->
    <div class="kt-login__form">
        <div class="kt-login__title">
            <h3>Sign In !</h3>
        </div>
        <!--begin::Form-->
        <form class="kt-form" action="{{ route('login') }}" method="POST"  novalidate="novalidate">
            @csrf
            <div class="form-group">
                <input id="email" type="email" placeholder="Email Id" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" placeholder="******" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
            </div>
            <!--begin::Action-->
            <div class="kt-login__actions">
                <a href="{{ route('password.request')}}" class="kt-link kt-login__link-forgot">
                    Forgot Password ?
                </a>
                {{-- <a href="{{ route('register')}}" class="kt-link kt-login__link-forgot">
                    New User? Sign up!
                </a> --}}
                <button id="kt_login_signin_submit" type="submit" class="btn btn-primary btn-elevate kt-login__btn-primary">Sign In</button>
            </div>
            <!--end::Action-->
        </form>
        <!--end::Form-->

        
    </div>
    <!--end::Signin-->
</div>
<!--end::Body-->
</div>
@endsection
