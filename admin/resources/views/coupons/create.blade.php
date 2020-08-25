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
                <form class="kt-form" method="POST" action="{{ route('coupon.store') }}">
                        @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Coupon Type</label>
                            <select class="form-control" id="coupon_type" name="coupon_type" required>
                                  <option>Select Coupon Type</option>
                                  <option value="1">Supermarket</option>
                                  <option value="2">Grocery Hero</option>
                            </select>
                        </div>
                        <div class="form-group" id="supermarket_selector">
                                <label>Select a supermarket for the coupon</label>
                                <select class="form-control" id="supermarket_id" name="supermarket_id" required>
                                        <option>Select SuperMarket</option>
                                        @foreach ($sm as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                        </div>
                        <div class="form-group" id="coupon_name">
                                <label for="exampleInputPassword1">New Coupon Name</label>
                                <input type="text" name="coupon_name" class="form-control" placeholder="Coupon Name">
                            </div>
                        <div class="form-group" id="coupon_name">
                                <label for="exampleInputPassword1">New Coupon Name in Arabic</label>
                                <input type="text" name="name_arabic" class="form-control" placeholder="Coupon Name in Arabic">
                            </div>
                            <div class="form-group">
                                    <label for="exampleTextarea">Description</label>
                                    <textarea class="form-control"  name="description"  id="description" rows="2"></textarea>
                                  </div>
                                <div class="form-group">
                                    <label for="exampleTextarea">Description in Arabic</label>
                                    <textarea class="form-control"  name="description_arabic"  id="description_arabic" rows="2"></textarea>
                                  </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Coupon Reward Type</label>
                            <select class="form-control" id="coupon_reward_type" name="coupon_reward_type">
                                <option>Select a coupon reward type</option>
                                  @foreach ($couponrewards as $couponreward)
                                    <option value="{{$couponreward->id}}">{{$couponreward->data}}</option>
                                  @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="coupon_reward_details_selector" style="display: none;">
                            <label id="coupon_reward_details_label"></label>
                            <input type="text" class="form-control" name="coupon_reward" id="coupon_reward">
                        </div>
                        <div class="form-group" id="valid_from_control">
                            <label for="exampleInputPassword1">Coupon valid from</label>
                            <input type="date" class="form-control" min="<?php echo date("Y-m-d"); ?>" name="valid_from" id="valid_from">
                        </div>
                        <div class="form-group" id="valid_till_control">
                            <label for="exampleInputPassword1">Coupon valid till</label>
                            <input type="date" class="form-control" min="<?php echo date("Y-m-d"); ?>" name="valid_till" id="valid_till">
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
        $("#coupon_reward_type").change(function (e) { 
            var couponRewardType = $("#coupon_reward_type option:selected").val();
            switch(couponRewardType) {
            case "7":
                $("#coupon_reward_details_selector").hide();
                break;
            case "8":
                $("#coupon_reward_details_selector").hide();
                break;
            case "9":
                $("#coupon_reward_details_selector").show();
                $("#coupon_reward_details_label").text("Please enter a valid Discount Percentage for this Coupon");
                break;
            case "10":
                $("#coupon_reward_details_selector").show();
                $("#coupon_reward_details_label").text("Please enter total amount to be deducted");

                break;
            default:
                // code block
            }
            
        });

    });
</script>
@endsection