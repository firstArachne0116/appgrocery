@extends('layouts.app')


@section('content')
<div class="row">

        <div class="col-lg-12 margin-tb">
    
            <div class="pull-left">
    
                <h2>Edit Consumers</h2>
    
            </div>
    
            <div class="pull-right">
    
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
    
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
                <form class="kt-form" method="POST" action="{{ route('users.update',$user->id) }}">
                        @csrf
                        @method('PUT')
                    <div class="kt-portlet__body">
                            <div class="form-group">
                                    <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}">
                            </div>
                            <div class="form-group">
                                    <label>Mobile</label>
                            <input type="text" maxlength="10" name="mobile" id="mobile" class="form-control" value="{{$user->mobile}}">
                            </div>
                            <div class="form-group">
                                    <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}">
                            </div>
                            <div class="form-group">
                                    <label>Cash Money Reward Points</label>
                            <input type="number" name="cash_credits" id="cash_credits" class="form-control" value="{{$user->cash_credits}}">
                            </div>
                        <div class="form-group">
                            <label>Status</label>
                            <div class="kt-radio-inline">
                                <label class="kt-radio">
                                    <input type="radio" value="1" {{$user->is_enabled == 1 ? "checked" : ""}}  name="status">Enabled
                                    <span></span>
                                </label>
                                <label class="kt-radio">
                                    <input type="radio" value="0" {{$user->is_enabled == 0 ? "checked" : ""}} name="status">Disabled
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

@endsection