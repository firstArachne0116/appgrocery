@extends('layouts.app')
@section('content')

<?php
$cities=App\City::orderBy('name','asc')->get();
$area=App\Area::where('city_id',$sm->city_id)->orderBy('name','asc')->get();
?>
<div class="row" style="padding:0px 25px 0px 0px;">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2></h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('supermarket.index') }}"> Back</a>
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
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="jumbotron">
            <h3>Supermarket Details</h3>
        </div>
        <!--begin::Form-->
        <form class="kt-form" method="POST" enctype="multipart/form-data" action="{{ route('supermarket.update',$sm->id) }}">
            @method('PUT')    
            @csrf                        
            <div class="kt-portlet__body"> 
                <div class="col-md-12">                        
                <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Name</label>
                    <input type="text" name="name" value="{{$sm->name}}" class="form-control" placeholder="Enter Name">
                </div>
                <div class="form-group col-md-3">
                    <label>Arabic Name</label>
                    <input type="text" name="name_arabic" value="{{$sm->name_arabic}}" class="form-control" placeholder="Enter Name">
                </div>
                <div class="form-group col-md-3">
                    <label for="exampleInputPassword1">Lattitude</label>
                    <input type="text" name="latitude" class="form-control" value="{{$sm->latitude}}" placeholder="Lattitude">
                </div>
                <div class="form-group col-md-3">
                    <label for="exampleInputPassword1">Longitude</label>
                <input type="text" name="longitude" class="form-control" value="{{$sm->longitude}}" placeholder="Longitude">
                </div>
                	
                </div>
                <div class="form-row">
                <div class="form-group col-md-3">
                        <label>Delivery Time</label>
                    <input type="time" name="deliverytime" class="form-control" value="{{$sm->deliverytime}}" placeholder="Delivery Time">
                    </div>
                <div class="form-group col-md-3">
                    <label for="exampleInputPassword1">Min. Delivery Amount</label>
                <input type="number" name="freedeliveryamount" value="{{$sm->freedeliveryamount}}" class="form-control" placeholder="Min. Delivery Amount">
                </div>
                <div class="form-group col-md-2">
                    <label for="exampleInputPassword1">Fixed Delivery Amount</label>
                <input type="number" name="fixeddeliveryamount" value="{{$sm->fixeddeliveryamount}}" class="form-control" placeholder="Min. Delivery Amount">
                </div>
                <div class="form-group col-md-2">
                    <label for="exampleInputPassword1">Fixed Service Amount</label>
                <input type="number" name="fixedserviceamount" value="{{$sm->fixedserviceamount}}" class="form-control" placeholder="Min. Delivery Amount">
                </div>
                <div class="form-group col-md-2">
                        <label for="exampleInputPassword1">Commission (In %)</label>
                        <input type="text" name="commission_percentage" value="{{$sm->commission_percentage}}" class="form-control" placeholder="Commission Charge">
                </div>
                </div>
                <div class="form-row">
                        <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Cash Money reward Amount</label>
                                <input type="number" name="cash_money" id="cash_money" value="{{$sm->cash_money}}" />
                        </div>
                    <div class="form-group col-md-3">
                        <label for="exampleInputPassword1">Country</label>
                        <select class="form-control" id="country_id" name="country_id">
                                 <option value="229">United Arab Emirates</option>
                        </select>
                    </div>
                   
                    <div class="form-group col-md-3">
                        <label for="exampleInputPassword1">City</label>
                        <select class="form-control" id="city_id" name="city_id">
                         <option="">Choose City </option>
						@if(count($cities)>0)
						@foreach($cities as $city)
						<option value="{{$city->id}}" @if($sm->city_id==$city->id) selected @endif>{{$city->name}}</option>
						@endforeach
						@endif
                        </select>
                    </div>
					<div class="form-group col-md-3">
                        <label for="exampleInputPassword1">Area</label>
                        <select class="form-control" id="area_id" name="area_id">
                          @if(count($area)>0)
							   <option="">Choose Area </option>
						@foreach($area as $ar)
						<option value="{{$ar->id}}" @if($sm->area_id==$ar->id) selected @endif>{{$ar->name}}</option>
						@endforeach
						@endif
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label>Address</label>
                        <input type="text" name="address" value="{{$sm->address}}" class="form-control" placeholder="Enter Adress">
                    </div>
                    
                    <div class="form-group col-md-7">
                        <label>Status</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" value="1" {{$sm->is_enabled == 1 ? "checked": " " }}  name="status">Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" value="0" {{$sm->is_enabled == 0 ? "checked": " "}} name="status">Disabled
                                <span></span>
                            </label>                        
                        </div>                
                    </div> 
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                            <div class="form-group">
                                    <label for="exampleInputPassword1">Supermarket Images</label>
                                    <input type="file"  id="file" name="filename" class="form-control" >
                            </div>
                    </div>
                    <div class="form-group col-md-4">
                            <div class="form-group">
                                    <label for="exampleInputPassword1">Uploaded Images</label>
                                    <?php $item = json_decode($sm->image_path); ?>
                            <img src={{asset(App\Constant::where('constant_type','SUPERMARKET_IMAGE_PATH')->value('data').'/'.$item[0])}} alt="No Image Uploaded for this Supermarket" height="300" width="300" >
                            </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="pull-right"><button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                
        </div></div>
        </form>        
        <!--end::Form-->	
</div>
</div>
<script src="{{asset('js/common.js')}}"></script>
{{-- <script src="{{asset('js/bootstrap/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('js/bootstrap/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('js/bootstrap/bootstrap-timepicker.min.js')}}"></script> --}}

@endsection