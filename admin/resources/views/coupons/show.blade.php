@extends('layouts.app')
@section('content')
<style>
.card-header {
    background-color:#3b2f5c !important;
    color:#FFF;
}
</style>
<div class="kt-container  kt-container--fluid kt-margin-b-100">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" id="headingOne">
                <div class="row">
                    <div class="col-lg-12 margin-tb">                
                        <div class="pull-left">                
                            <h2> Show Coupon</h2>                
                        </div>                
                        <div class="pull-right">                
                            <a class="btn btn-primary" href="{{ route('coupon.index') }}"> Back</a>                
                        </div>                
                    </div>                
                </div>
            </div>
                <div class="card-body">
                    <div class="kt-container">
                        <div class="col-md-6"></div>
                    </div>
                    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                        <div class="row">
                            <div class="col-md-3">
                                <label> Coupon ID </label>
                                <br />
                                <p>{{$coupon->id}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Coupon Name </label>
                                <br />
                                <p>{{$coupon->name}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Coupon Code </label>
                                <br />
                                <p>{{$coupon->coupon_code}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Coupon Rule </label>
                                <br />
                                <p>{{$coupon->coupon_rule}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Coupon Type </label>
                                <br />
                                <p>{{$coupon->supermarket_id == 0 ? "Grocery Hero Coupon" :   "Supermarket Coupon"}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Valid From</label>
                                <br />
                                <p>{{date('d-M-Y', strtotime($coupon->valid_from))}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Valid Till </label>
                                <br />
                                <p>{{date('d-M-Y', strtotime($coupon->valid_till))}}</p>
                            </div>                 
                        </div>
                    </div>
                </div>            
        </div>
    </div>
</div>

@endsection