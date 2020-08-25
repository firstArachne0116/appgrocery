@extends('layouts.gh')

@section('content')
<div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">
<!--begin::Body-->
<div class="kt-login__body">

    <!--begin::Signin-->
    <div class="kt-login__form">
        <div class="kt-login__title">
            <h3>{{ __('Reset Password') }}</h3>
        </div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" class="kt-form">
                @csrf
                <div class="form-group">
                        <input id="email" type="email" placeholder="Email Id" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="kt-login__actions">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary btn-elevate kt-login__btn-primary">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </div>
            </form>
    </div>
</div>
</div>
</div>
@endsection
