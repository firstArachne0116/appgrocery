@extends('layouts.app')
@section('content')
<div class="row" style="padding:0px 25px 0px 0px;">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2></h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.listvendor') }}"> Back</a>
        </div>
    </div>
</div>
<div class="clearfix"><br/></div>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"> 
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="jumbotron">
            <h3>Vendor Details</h3>
        </div>
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-md-3">
                    <label> Name </label>
                    <br /><p>{{ $user->name }}</p>                
                </div>
                <div class="col-md-3">
                    <label> Email </label>
                    <br /><p>{{ $user->email }}</p>                
                </div>
                <div class="col-md-3">
                    <label> Mobile </label>
                    <br /><p>{{ $user->mobile }}</p>                
                </div>
                <div class="col-md-3">
                    <label> Credits </label>
                    <br /><p>{{ $user->credits }}</p>                
                </div>
                <div class="col-md-3">
                        <label> cash Credits </label>
                        <br /><p>{{ $user->cash_credits }}</p>                
                    </div>
                <div class="col-md-3">
                    <label> Referral Code </label>
                    <br /><p>{{ $user->user_refer_code }}</p>                
                </div>
                <div class="col-md-3">
                    <label> Role </label>
                    <br />
                    <p>
                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                            <label class="badge badge-success">{{ $v }}</label>
                        @endforeach
                    @endif
                    </p>              
                </div>
            </div>
        </div>
    </div>
</div>
@endsection