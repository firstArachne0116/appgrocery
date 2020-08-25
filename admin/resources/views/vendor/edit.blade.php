@extends('layouts.app')
@section('content')
<?php
$cities=App\City::orderBy('name','asc')->get();
$area=App\Area::where('city_id',$vendor[0]->city_id)->orderBy('name','asc')->get();

?>
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
            <h3>Vendor Details</h3>
        </div>  
        <!--begin::Form-->
        <form class="kt-form" method="POST" action="{{ route('seller.update',$vendor[0]->id) }}">
            @method('put')    
            @csrf
            <div class="kt-portlet__body">                
                <div class="form-group">
                    <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{$vendor[0]->name}}" placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                <input type="text" name="mobile" maxlength=10 class="form-control" value="{{$vendor[0]->mobile}}" placeholder="Enter Phone Number">
                </div>
                <div class="form-group">
                    <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{$vendor[0]->email}}" placeholder="Enter Email">
                </div>
            
                <div class="form-group">
                        <label>Address</label>
                    <input type="text" name="address" value="{{$vendor[0]->address}}" class="form-control" placeholder="Enter Name">
                </div>                
            
                <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="country_id" name="country_id">
                          <option value="229">United Arab Emirates</option>
                    </select>
                </div>
               
                <div class="form-group">
                    <label for="exampleInputPassword1">City</label>
                    <select class="form-control" id="city_id" name="city_id">                        
						@if(count($cities)>0)
						@foreach($cities as $city)
						<option value="{{$city->id}}" @if($vendor[0]->city_id==$city->id) selected @endif>{{$city->name}}</option>
						@endforeach
						@endif
                    </select>
                </div>
				<div class="form-group">
                        <label for="exampleInputPassword1">Area</label>
                        <select class="form-control" id="area_id" name="area_id">
                          @if(count($area)>0)
							   <option="">Choose Area </option>
						@foreach($area as $ar)
						<option value="{{$ar->id}}" @if($vendor[0]->area_id==$ar->id) selected @endif>{{$ar->name}}</option>
						@endforeach
						@endif
                        </select>
                    </div>
        
                <div class="form-group">
                    <label>Super Market</label>
                    <select class="form-control" id="supermarket_id" name="supermarket_id">
                            <option>Select SuperMarket</option>
                            @foreach ($sm as $item)
                            <option value="{{$item->id}}"  {{ $item->id == $vendor[0]->supermarket_id ? "selected" : "" }}>{{$item->name}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                        <label>Status</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" value='1' {{$vendor[0]->is_enabled == 1 ? "checked": " " }}  name="status">Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" value="0" {{$vendor[0]->is_enabled == 0 ? "checked": " " }} name="status">Disabled
                                <span></span>
                            </label>
                            
                        </div>
                    </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        {{-- <button type="reset" class="btn btn-secondary">Cancel</button> --}}
                    </div>
                </div>    
                            
            </div>
                        
        </form>
        <!--end::Form-->			
    </div>
    <!--end::Portlet-->        
</div>
{{-- <script src="{{asset('items/global/jquery.js')}}" type="text/javascript"></script> --}}
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script src="{{asset('js/common.js')}}"></script>
@endsection
