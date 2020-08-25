@extends('layouts.gh')

@section('content')
<div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">
<!--begin::Body-->
<div class="kt-login__body">

<!--begin::Signin-->
<div class="kt-login__form">
<div class="kt-login__title">{{ __('Reset Password') }}</div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                        <input id="email" type="email" placeholder="Email Id" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
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
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary btn-elevate kt-login__btn-primary">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>
            </form>
    </div>
</div>
</div>
@endsection
