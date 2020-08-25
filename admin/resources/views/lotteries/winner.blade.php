@extends('layouts.app')
@section('content')
<div class="row" style="padding: 0px 25px;">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2></h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('lottery.index') }}"> Back</a>
        </div>
    </div>
</div>
<div class="clearfix"><br/></div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
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

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"> 
    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="jumbotron">
                    <h3>Upload Lottery Winners</h3>
                </div>
                <!--begin::Form-->
                <form class="kt-form" method="POST"  action="{{ route('lottery.winnerupload') }}">
                        @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group" id="lottery_selector">
                            <label for="exampleInputPassword1">Select Lottery</label>
                            <select class="form-control" id="lottery_id" name="lottery_id">
                                    <option>Select Lottery</option> 
                                    @foreach ($lotteries as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                
                            </select>
                        </div>
                         <div class="form-group" id="winner_selector">
                            <label for="exampleInputPassword1">Select Winner Name</label>
                             <select class="form-control" name="winner_id" id="winner_id">

                             </select>
                        </div>
                        <div class="form-group" id="message_control">
                            <label for="exampleInputPassword1" id="message_label">Message</label>
                            <input type="text" name="message" class="form-control" placeholder="Message for Winner">
                        </div>
                    
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                               
                            </div>
                        </div>
                      
                    </div>
                </form>    			
            </div>
            <!--end::Portlet-->
    
        </div>
    </div>	
</div>
<script src="{{asset('js/common.js')}}"></script>
@endsection