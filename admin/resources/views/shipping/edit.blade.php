@extends('layouts.app')


@section('content')
<div class="row">

        <div class="col-lg-12 margin-tb">
    
            <div class="pull-left">
    
                <h2>Update Shipping Status</h2>
    
            </div>
    
            <div class="pull-right">
    
                <a class="btn btn-primary" href="{{ route('shipping.list') }}"> Back</a>
    
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
                <form class="kt-form" method="POST" action="{{ route('shipping.update',$shipping->id) }}">
                        @csrf
                        @method('PUT')
                    <div class="kt-portlet__body">
                        <div class="form-group" id="status_selector">
                                <label>Current Status</label>
                                <select class="form-control" id="shipping_status" name="shipping_status" required>
                                    @foreach ($statuses as $status)
                                        <option value="{{$status->id}}"
                                            {{($shipping->shipping_status == $status->id ? "selected": "" )}}>
                                            {{$status->data}}</option>
                                    @endforeach
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
            </div>
            <!--end::Portlet-->
    
        </div>
    </div>	
</div>
@endsection