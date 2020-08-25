@extends('layouts.app')
@section('content')
<div class="row" style="padding:0px 25px 0px 0px;">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2></h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('commission.index') }}"> Back</a>
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
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="jumbotron">
                <h3>Commission</h3>
            </div>
            <!--begin::Form-->
            <form class="kt-form" method="POST" action="{{ route('commission.update',$commission->id) }}">
                @csrf
                @method('PUT')
            <div class="kt-portlet__body">
                <div class="form-group" id="status_selector">
                    
                </div>
                <div class="form-group" id="status_selector">
                        <label>Status Update</label>
                        <select class="form-control" id="commission_status" name="commission_status" required>
                            <option value="0" {{$commission->is_completed == 0 ? "selected" :"" }}>Not completed</option>
                            <option value="1" {{$commission->is_completed == 1 ? "selected" :"" }} >Completed</option>
                        </select>
                </div>
                <div class="form-group">
                        <label for="exampleTextarea">Status Message</label>
                        <textarea class="form-control"  name="status_message"  id="status_message" rows="2"></textarea>
                      </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <button type="submit" class="btn btn-primary">Submit</button>
                       
                    </div>
                </div>
              
            </div>
        </form>                
                <!--end::Form-->                	                        
            </div>
            <!--end::Portlet-->
            </div>
        <!--end::Portlet-->
    </div>
@endsection