@extends('layouts.gh')

@section('content')
<div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">
    <div class="kt-login__body">
            <div class="kt-login__form">
                <div class="kt-login__title"><h3>{{ __('Sing Up!') }}</h3></div>
                    <form method="POST" action="{{ route('register') }}" class="kt-form">
                        @csrf
                        <div class="form-group">                            
                                <input id="name" type="text" placeholder="Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                            
                        </div>
                        <div class="form-group">                            
                                <input id="email" type="email" placeholder="Email Id" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                            
                        </div>
                        <div class="form-group">                            
                                <input id="password" type="password" placeholder="******" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                            
                        </div>
                        <div class="form-group">
                            <input id="password-confirm" type="password" placeholder="******" class="form-control" name="password_confirmation" required autocomplete="new-password">                            
                        </div>
                        <div class="kt-login__actions">
                        <a href="{{ route('password.request')}}" class="kt-link kt-login__link-forgot">
                            Forgot Password ?
                        </a>
                        <a href="{{ route('login')}}" class="kt-link kt-login__link-forgot">
                            Already a user? Sign In!
                        </a>
                        <button type="submit" class="btn btn-primary btn-elevate kt-login__btn-primary">
                            {{ __('Register') }}
                        </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
@endsection
