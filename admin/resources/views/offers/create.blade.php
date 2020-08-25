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
            <form class="kt-form" method="POST" enctype="multipart/form-data" action="{{ route('offer.store') }}">
                    @csrf
                <div class="kt-portlet__body">
                        <div class="form-group">
                                <label for="exampleInputPassword1">Offer Type</label>
                                <select class="form-control" id="offer_type" name="offer_type">
                                      <option value="-1">Select an offer</option>
                                      <option value="1">Home Page Slider</option>
                                      <option value="2">Sub Category</option>
                                </select>
                            </div>  <div class="form-group" id="supermarket_selector">
                                    <label>Select a Supermarket for this Offer</label>
                                    <select class="form-control" id="supermarket_id" name="supermarket_id" required>
                                            <option value="0" >Select SuperMarket</option>
                                            @foreach ($sm as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                        <div class="form-group">
                            <label> Offer Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label> Offer Name in Arabic</label>
                            <input type="text" id="name" name="name_arabic" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea">Offer Description</label>
                            <textarea class="form-control"  name="description"  id="description" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea">Offer Description in Arabic</label>
                            <textarea class="form-control"  name="description_arabic"  id="description" rows="2"></textarea>
                        </div>
                        <div class="form-group" id="main_category_selector" style="display: none;" >
                                <label for="exampleInputPassword1">Select Main Category</label>
                                <select class="form-control" id="main_category_type" name="main_category_id">
                                     <option>Select a main Category</option>
                                        @foreach ($categories as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="product_sub_category_selector" style="display: none;">
                                <label for="exampleInputPassword1">Choose sub-category</label>
                                <select class="form-control" id="product_sub_category_id" name="sub_category_id">
                                </select>
                            </div>
                            <div class="form-group" id="sub_sub_category_selector" style="display: none;">
                                <label for="exampleInputPassword1">Product Category</label>
                                <select class="form-control" id="sub_sub_category_id" name="category_id">
                                </select>
                            </div>
                            <div class="form-group" id="product_selector" style="display: none;">
                                <label for="exampleInputPassword1">Choose Product</label>
                                <select class="form-control" id="productconfig_id" name="productconfig_id">
                                </select>
                            </div>
                        <div class="form-group" id="multiple-offer-selector" style="display: none;">
                            <label for="exampleInputPassword1">Offer Images</label>
                            <input type="file"  id="image_slider" name="image_slider" class="form-control" >
                        </div>
                        <div class="form-group" id="multiple-offer-selector-arabic" style="display: none;">
                            <label for="exampleInputPassword1">Offer Images In Arabic</label>
                            <input type="file"  id="image_slider_arabic" name="image_slider_arabic" class="form-control" >
                        </div>
                        <div class="form-group" id="single-offer-selector" style="display: none;">
                            <label for="exampleInputPassword1">Static Offer Images </label>
                            <input type="file"  id="image" name="image" class="form-control">
                        </div>
                        <div class="form-group" id="single-offer-selector-arabic" style="display: none;">
                            <label for="exampleInputPassword1">Static Offer Images in Arabic</label>
                            <input type="file"  id="image_arabic" name="image_arabic" class="form-control">
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
    <script src="{{asset('js/category.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#offer_type").change(function (e) { 
        var selectedSubCategory = $("#offer_type option:selected").val();
       if (selectedSubCategory == 1){
            $("#multiple-offer-selector").show();
            $("#multiple-offer-selector-arabic").show();
            $("#single-offer-selector").hide();
            $("#single-offer-selector-arabic").hide();
       }
       else if (selectedSubCategory == 2){
            $("#multiple-offer-selector").hide();
            $("#multiple-offer-selector-arabic").hide();
            $("#single-offer-selector").show();
            $("#single-offer-selector-arabic").show();
       }
    }); 
            $("#supermarket_id").change(function (e) { 
                $("#main_category_selector").show();

    }); 

  
        


        });
    </script>

@endsection