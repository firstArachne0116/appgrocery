@extends('layouts.app')
@section('content')
<div class="row" style="padding:0px 25px 0px 0px;">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2></h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('offer.index') }}"> Back</a>
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
                <h3>Offers</h3>
            </div>
            <!--begin::Form-->
            <form class="kt-form" method="POST" enctype="multipart/form-data" action="{{ route('offer.update',$offer->id) }}">
                    @csrf
                    @method('PUT')
                <div class="kt-portlet__body">
                        <div class="form-group">
                            <label> Offer Name</label>
                        <input type="text" id="name" name="name" value="{{$offer->name}}" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label> Arabic Offer Name</label>
                        <input type="text" id="name" name="name_arabic" value="{{$offer->name_arabic}}" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea">Offer Description</label>
                            <textarea class="form-control"  name="description"  id="description" rows="2">{{ htmlspecialchars($offer->description) }}</textarea>
                        </div>
                      
                        <div class="form-group">
                            <label for="exampleTextarea">Offer Description in Arabic</label>
                            <textarea class="form-control"  name="description_arabic"  id="description" rows="2">{{ htmlspecialchars($offer->description_arabic) }}</textarea>
                        </div>
                        <div class="form-group" id="product_selector">
                            <label for="exampleInputPassword1">Choose Product</label>
                            <select class="form-control" id="productconfig_id" name="productconfig_id">
                                <option value="0">Add to all products in this Category</option>
                                @foreach ($products as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option> 
                                @endforeach
                            </select>
                        </div>
                        @if ($offer->offer_type == 1)
                        <div class="form-group">
                        <label for="exampleInputPassword1">Slider Images</label>
                            
                            @foreach (json_decode($offer->image_path) as $item)
                                <img src = "{{asset(App\Constant::where('constant_type','OFFER_SLIDER_IMAGE_ENGLISH')->value('data').'/'.$item)}}"  width="50" height="50">
                                {{-- <a href="{{route('image.delete',$loop->index)}}"><img class="close-image" width="10" height="10" src="http://aux3.iconspalace.com/uploads/567330038556056137.png" > </a> --}}
                            @endforeach   
                        </div>
                        <div class="form-group" id="multiple-offer-selector">
                            <label for="exampleInputPassword1">Offer Images</label>
                            <input type="file"  id="image_slider" name="image_slider"   class="form-control" multiple >
                        </div>
                        <div class="form-group">
                        <label for="exampleInputPassword1">Slider Images in Arabic</label>
                            
                            @foreach (json_decode($offer->image_path_arabic) as $item)
                                <img src = "{{asset(App\Constant::where('constant_type','OFFER_SLIDER_IMAGE_ARABIC')->value('data').'/'.$item)}}"  width="50" height="50">
                                {{-- <a href="{{route('image.delete',$loop->index)}}"><img class="close-image" width="10" height="10" src="http://aux3.iconspalace.com/uploads/567330038556056137.png" > </a> --}}
                            @endforeach   
                        </div>
                        <div class="form-group" id="multiple-offer-selector-arabic">
                            <label for="exampleInputPassword1">Offer Images In Arabic</label>
                            <input type="file"  id="image_slider_arabic" name="image_slider_arabic"   class="form-control" multiple >
                        </div>

                        @endif
                        @if ($offer->offer_type == 2)
                        <div class="form-group">
                            <label for="exampleInputPassword1">Static Offer Images</label>
                                <?php $item = json_decode($offer->image_path) ?>
                                    <img src = "{{asset(App\Constant::where('constant_type','OFFER_STATIC_IMAGE_ENGLISH')->value('data').'/'.$item[0])}}"  width="50" height="50">
                                    {{-- <a href="{{route('image.delete',$loop->index)}}"><img class="close-image" width="10" height="10" src="http://aux3.iconspalace.com/uploads/567330038556056137.png" > </a> --}}
                                            
                        </div>
                        <div class="form-group" id="single-offer-selector">
                            <label for="exampleInputPassword1">Static Offer Images </label>
                            <input type="file"  id="image" name="image"   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Static Offer Images in Arabic</label>
                                <?php $item = json_decode($offer->image_path_arabic) ?>
                                    <img src = "{{asset(App\Constant::where('constant_type','OFFER_STATIC_IMAGE_ARABIC')->value('data').'/'.$item[0])}}"  width="50" height="50">
                                    {{-- <a href="{{route('image.delete',$loop->index)}}"><img class="close-image" width="10" height="10" src="http://aux3.iconspalace.com/uploads/567330038556056137.png" > </a> --}}
                                            
                        </div>
                        <div class="form-group" id="single-offer-selector">
                            <label for="exampleInputPassword1">Static Offer Images </label>
                            <input type="file"  id="image_arabic" name="image_arabic"   class="form-control">
                        </div>
                        @endif
                     
                        <div class="form-group">
                                <label>Status</label>
                                <div class="kt-radio-inline">
                                    <label class="kt-radio">
                                        <input type="radio" value="1" {{$offer->is_enabled == 1 ? "checked" : ""}}  name="status">Enabled
                                        <span></span>
                                    </label>
                                    <label class="kt-radio">
                                        <input type="radio" value="0" {{$offer->is_enabled == 0 ? "checked" : ""}} name="status">Disabled
                                        <span></span>
                                    </label>
                                    
                                </div>                        
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>                        
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