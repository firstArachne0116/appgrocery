@extends('layouts.app')
@section('content')
<div class="row" style="padding:0px 25px 0px 0px;">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2></h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('coupon.index') }}"> Back</a>
        </div>
    </div>
</div>
<div class="clearfix"><br/></div>    
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
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"> 
    <div class="row">
    <div class="col-md-12">
    <!--begin::Portlet-->
    <div class="kt-portlet">
            <div class="jumbotron">
                <h3>Coupon Details</h3>
            </div>
        <!--begin::Form-->
        <form class="kt-form" method="POST" action="{{ route('coupon.update',$coupon->id) }}">
                @csrf
                @method('PUT')
            <div class="kt-portlet__body">
                <div class="form-group">
                    <label for="exampleInputPassword1">Coupon Type</label>
                    <select class="form-control" id="coupon_type" name="coupon_type">
                            <option value="1" {{$coupon->id == 1 ? "selected" :"" }} >Supermarket</option>
                            <option value="2" {{$coupon->id == 2 ? "selected" :"" }}>Grocery Hero</option>
                    </select>
                </div>
                <div class="form-group" id="supermarket_selector">
                    <label>Select a supermarket for the coupon</label>
                    <select class="form-control" id="supermarket_id" name="supermarket_id" required>
                            <option value="0" >Select SuperMarket</option>
                            @foreach ($sm as $item)
                                <option value="{{$item->id}}" {{ $item->id == $coupon->supermarket_id ? "selected" : "" }}>{{$item->name}}</option>
                            @endforeach
                    </select>
                </div>

                <div class="form-group" id="sub_category_selector">
                    <label for="exampleInputPassword1">Choose Coupon Reward  ( Discount Percentage)</label>
                    <input type="text" class="form-control" value="{{$coupon->coupon_rule}}" name="coupon_reward" id="coupon_reward">
                </div>
                <div class="form-group" id="valid_from_control">
                    <label for="exampleInputPassword1">Coupon valid from</label>
                    <input type="date" class="form-control" value="{{date('Y-m-d', strtotime($coupon->valid_from))}}" min="<?php echo date("Y-m-d"); ?>" name="valid_from" id="valid_from">
                </div>
                <div class="form-group" id="valid_from_control">
                    <label for="exampleInputPassword1">Coupon valid till</label>
                <input type="date" class="form-control" value="{{$coupon->valid_till}}"  min="<?php echo date("Y-m-d"); ?>" name="valid_till" id="valid_from">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <div class="kt-radio-inline">
                        <label class="kt-radio">
                            <input type="radio" value="1" {{$coupon->is_enabled == 1 ? "checked" : ""}}  name="status">Enabled
                            <span></span>
                        </label>
                        <label class="kt-radio">
                            <input type="radio" value="0" {{$coupon->is_enabled == 0 ? "checked" : ""}} name="status">Disabled
                            <span></span>
                        </label>
                        
                    </div>                        
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        
                    </div>
                </div>                
            </div>
        </form>    			
    </div>
    <!--end::Portlet-->
    </div>
    </div>	
</div>

{{-- <script src="{{asset('js/bootstrap/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('js/bootstrap/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('js/bootstrap/bootstrap-timepicker.min.js')}}"></script> --}}
<script>
$(document).ready(function () {
    $("#coupon_type").change(function (e) { 
    var couponType = $("#coupon_type option:selected").val();
    
    if (couponType == 1 ){
        $("#supermarket_selector").show();
    }
    else if (couponType != 1) {
        $("#supermarket_selector").hide();
    }  
   });
});
</script>
@endsection