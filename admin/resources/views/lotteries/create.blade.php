@extends('layouts.app')


@section('content')
<div class="row">

        <div class="col-lg-12 margin-tb">
    
            <div class="pull-left">
    
                <h2>Create  Lottery Reward</h2>
    
            </div>
    
            {{-- <div class="pull-right">
    
                <a class="btn btn-primary" href="{{ route('lotteries.index') }}"> Back</a>
    
            </div> --}}
    
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
                    <form class="kt-form" method="POST" action="{{ route('lottery.store') }}">
                            @csrf
                        <div class="kt-portlet__body">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Lottery Type</label>
                                <select class="form-control" id="lottery_type" name="lottery_type">
                                      <option>Choose lottery type</option>
                                      <option value="1">Supermarket</option>
                                      <option value="2">Grocery Hero</option>
                                </select>
                            </div>
                            <div class="form-group" id="supermarket_selector">
                                    <label>Select a supermarket for the Lottery</label>
                                    <select class="form-control" id="supermarket_id" name="supermarket_id" required>
                                            <option>Select SuperMarket</option>
                                            @foreach ($sm as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                            </div>
                            <div class="form-group" id="lottery_name">
                                <label for="exampleInputPassword1">Lottery Name</label>
                                <input type="text" name="lottery_name" class="form-control" placeholder="Lottery Name">
                            </div>
                            <div class="form-group" id="lottery_name_arabic">
                                <label for="exampleInputPassword1">Lottery Name in Arabic</label>
                                <input type="text" name="name_arabic" class="form-control" placeholder=" Arabic Lottery Name ">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea">Description</label>
                                <textarea class="form-control"  name="description"  id="description" rows="2"></textarea>
                              </div>
                            <div class="form-group">
                                <label for="exampleTextarea">Description in Arabic</label>
                                <textarea class="form-control"  name="description_arabic"  id="description_arabic" rows="2"></textarea>
                              </div>
                            <div class="form-group" id="sub_category_selector">
                                <label for="exampleInputPassword1">Choose Lottery Reward</label>
                                <input type="text" class="form-control" name="lottery_rule" id="lottery_rule">
                            </div>
                            <div class="form-group" id="valid_from_control">
                                <label for="exampleInputPassword1">Lottery valid from</label>
                                <input type="date" class="form-control" min="<?php echo date("Y-m-d"); ?>" name="valid_from" id="valid_from">
                            </div>
                            <div class="form-group" id="valid_till_control">
                                <label for="exampleInputPassword1">Lottery valid till</label>
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
<script>
        $(document).ready(function () {
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