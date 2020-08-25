@extends('layouts.app')


@section('content')
<div class="row">

        <div class="col-lg-12 margin-tb">
    
            <div class="pull-left">
    
                <h2>Edit Lottery</h2>
    
            </div>
    
            <div class="pull-right">
    
                <a class="btn btn-primary" href="{{ route('lottery.index') }}"> Back</a>
    
            </div>
    
        </div>
    
    </div>
    
    
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
                <!--begin::Form-->
                <form class="kt-form" method="POST" action="{{ route('lottery.update',$lottery->id) }}">
                        @csrf
                        @method('PUT')
                    <div class="kt-portlet__body">
                        <div class="form-group">
                                <div class="form-group" id="lottery_name">
                                        <label for="exampleInputPassword1">Lottery Name</label>
                                     <input type="text" class="form-control" value="{{$lottery->name}}" name="lottery_name" id="lottery_reward">
                                    </div>
                                    <div class="form-group" id="lottery_name_arabic">
                                            <label for="exampleInputPassword1">Lottery Name in Arabic</label>
                                         <input type="text" class="form-control" value="{{$lottery->name_arabic}}" name="name_arabic" id="lottery_reward">
                                    </div>
                                    <div class="form-group">
                                            <label for="exampleTextarea">Description</label>
                                    <textarea class="form-control"  name="description"   id="description" 
                                    rows="2">{{ htmlspecialchars($lottery->description) }}</textarea>
                                          </div>
                                        <div class="form-group">
                                            <label for="exampleTextarea">Description in Arabic</label>
                                        <textarea class="form-control"  name="description_arabic"  id="description_arabic" 
                                        rows="2">{{htmlspecialchars($lottery->description_arabic)}}</textarea>
                                          </div>
                            <label for="exampleInputPassword1">Lottery Type</label>
                            <select class="form-control" id="lottery_type" name="lottery_type">
                                  <option value="1" {{$lottery->lottery_type == 1 ? "selected" :"" }} >Supermarket</option>
                                  <option value="2" {{$lottery->lottery_type == 2 ? "selected" :"" }}>Grocery Hero</option>
                            </select>
                        </div>
                        <div class="form-group" id="supermarket_selector">
                                <label>Select a supermarket for the lottery</label>
                                <select class="form-control" id="supermarket_id" name="supermarket_id" required>
                                        <option value="-1" >Select SuperMarket</option>
                                        @foreach ($sm as $item)
                                            <option value="{{$item->id}}" {{ $item->id == $lottery->supermarket_id ? "selected" : "" }}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                        </div>

                         <div class="form-group" id="sub_category_selector">
                            <label for="exampleInputPassword1">Choose lottery Reward</label>
                         <input type="text" class="form-control" value="{{$lottery->lottery_rule}}" name="lottery_rule" id="lottery_reward">
                        </div>
                        <div class="form-group" id="valid_from_control">
                            <label for="exampleInputPassword1">Valid from</label>
                            <input type="date" class="form-control" value="{{date('Y-m-d', strtotime($lottery->valid_from))}}" min="<?php echo date("Y-m-d"); ?>" name="valid_from" id="valid_from">
                        </div>
                        <div class="form-group" id="valid_from_control">
                            <label for="exampleInputPassword1">Valid till</label>
                        <input type="date" class="form-control" value="{{$lottery->valid_till}}"  min="<?php echo date("Y-m-d"); ?>" name="valid_till" id="valid_till">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <div class="kt-radio-inline">
                                <label class="kt-radio">
                                    <input type="radio" value="1" {{$lottery->is_enabled == 1 ? "checked" : ""}}  name="status">Enabled
                                    <span></span>
                                </label>
                                <label class="kt-radio">
                                    <input type="radio" value="0" {{$lottery->is_enabled == 0 ? "checked" : ""}} name="status">Disabled
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
        var selectedLT = $("#lottery_type option:selected").val();
        if (selectedLT == 2) {
            $("#supermarket_selector").hide();
        }
        $("#lottery_type").change(function (e) { 
        var lotteryType = $("#lottery_type option:selected").val();
        
        if (lotteryType == 1 ){
            $("#supermarket_selector").show();
        }
        else if (lotteryType != 1) {
            $("#supermarket_selector").hide();
        }
       
   });
    });
</script>
@endsection