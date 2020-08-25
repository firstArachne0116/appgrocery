@extends('layouts.app')
@section('content')
<?php
$cities=App\City::orderBy('name','asc')->get();
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
        <form class="kt-form" method="POST" enctype="multipart/form-data" action="{{ route('supermarket.store') }}">
                @csrf
            <div class="kt-portlet__body"> 
            <div class="col-md-12">                       
                <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Name</label>
                <input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="Enter Name">
                </div>
                <div class="form-group col-md-3">
                    <label> Arabic Name for Supermarket</label>
                    <input type="text" name="name_arabic" value="{{old('name_arabic')}}" class="form-control" placeholder="Enter Arabic Name">
                </div>
                <div class="form-group col-md-3">
                    <label for="exampleInputPassword1">Lattitude</label>
                    <input type="text" name="latitude" value="{{old('latitude')}}" class="form-control" placeholder="Lattitude">
                </div>
                <div class="form-group col-md-3">
                    <label for="exampleInputPassword1">Longitude</label>
                    <input type="text" name="longitude" value="{{old('longitude')}}" class="form-control" placeholder="Longitude">
                </div>
                
                
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-3">
                            <label>Delivery Time</label>
                            <input type="time" name="deliverytime" value="{{old('deliverytime')}}" class="form-control" placeholder="Delivery Time">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="exampleInputPassword1">Min. Delivery Amount</label>
                        <input type="text" name="freedeliveryamount" value="{{old('freedeliveryamount')}}" class="form-control" placeholder="Min. Delivery Amount">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="exampleInputPassword1">Fixed Delivery Charge</label>
                        <input type="text" name="fixeddeliveryamount" value="{{old('fixeddeliveryamount')}}" class="form-control" placeholder="Fixed Delivery Amount">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="exampleInputPassword1">Fixed Service Charge</label>
                        <input type="text" name="fixedserviceamount" value="{{old('fixedserviceamount')}}" class="form-control" placeholder="Fixed Service Charge">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="exampleInputPassword1">Commission (In %)</label>
                        <input type="text" name="commission_percentage" value="{{old('commission_percentage')}}" class="form-control" placeholder="Commission Charge">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                            <label for="exampleInputPassword1">Cash Money reward Amount</label>
                            <input type="number" name="cash_money" value="{{old('cash_money')}}"  min="0" id="cash_money" value="" />
                    </div>
                    <div class="form-group col-md-3">
                        <label for="exampleInputPassword1">Country</label>
                        <select class="form-control" id="country_id"  name="country_id">
                                <option>Select Country</option>
                                <option value="229">United Arab Emirates</option>
                        </select>
                    </div>
                    <!--<div class="form-group col-md-3">
                        <label for="exampleInputPassword1">State</label>
                        <select class="form-control" id="state_id" name="state_id">
                                <option>Select State</option>
                        </select>
                    </div>-->
                    <div class="form-group col-md-3">
                            <label for="exampleInputPassword1">City</label>
                            <select class="form-control" id="city_id" name="city_id">
							<option="">Choose City </option>
							@if(count($cities)>0)
							@foreach($cities as $city)
							<option value="{{$city->id}}">{{$city->name}}</option>
							@endforeach
							@endif
                            </select>
                    </div>
					 <div class="form-group col-md-3">
                            <label for="exampleInputPassword1">Area</label>
                            <select class="form-control" id="area_id" name="area_id">
							<option="">Choose Area </option>
							
                            </select>
                    </div>
                </div>
                <div class="form-row">
               
                <div class="form-group col-md-4">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Supermarket Images</label>
                            <input type="file" required  id="file" value="{{old('filename')}}"  name="filename" class="form-control" >
                        </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Address</label>
                    <textarea name="address" value="{{old('address')}}" class="form-control" cols="10"></textarea>
                </div>
                <div class="form-group col-md-4">
                        <label>Status</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" value="1" {{ old('status' )== "1" ? 'checked' : ''}} name="status">Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" value="0" {{ old('status' )== "0" ? 'checked' : ''}} name="status">Disabled
                                <span></span>
                            </label>
                            
                        </div>
                        
                    </div>
                </div>
                <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="pull-right"><button type="submit" class="btn btn-primary">Submit</button></div>
                </div>
            </div>
            </div>
            </div>
        </form>               
        <!--end::Form-->			
    </div>
    <!--end::Portlet-->    
</div>
<script src="{{asset('js/common.js')}}"></script>
{{-- <script src="{{asset('js/bootstrap/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('js/bootstrap/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('js/bootstrap/bootstrap-timepicker.min.js')}}"></script> --}}

@endsection