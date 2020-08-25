@extends('layouts.app')
@section('content')
<div class="login m-0">
    <div class="login-form-container">
    <div class="account-login-form">        
            @if (!Auth::check())
            <p>Already have an account ? <a  onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
        {{ __('Logout') }} Log out here
    </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        </form>
        </p>  
            @endif
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
            @if ($message = Session::get('failure'))
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
            @endif            
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </div>
            @endif
            @php 
            $user = Auth::user();            
            @endphp
    <form action="{{route('updatepassword',$user->id)}}" method="POST">
        @csrf        
        <div class="account-input-box">
            <div class="row">
            <div class="col-md-12">
                <label>Old Password</label>
                <input type="password" name="oldpassword" value="" class="form-control">
            </div>
            <div class="col-md-12">
                <label>New Password</label>
                <input type="password" name="password" value="" class="form-control" >
            </div>
            <div class="col-md-12">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" value="" class="form-control">
            </div>            
            </div>
        </div>
        <div class="button-box">
            <button class="btn default-btn" type="submit">Change</button>
        </div>
        </form>
    </div>
    </div>
</div>
@endsection