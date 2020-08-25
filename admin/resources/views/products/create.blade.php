@extends('layouts.app')
@section('content')
<div class="row" style="padding:0px 25px 0px 0px;">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2></h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('product.list') }}"> Back</a>
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
                <h3>Product Details</h3>
            </div>
            <!--begin::Form-->
            <form class="kt-form" method="POST" enctype="multipart/form-data" action="{{ route('product.store') }}">
                    @csrf
                <div class="kt-portlet__body">
                        @role('admin')
                        <div class="form-group">
                            <label>Super Market</label>
                            <select class="form-control" id="supermarket_id" name="supermarket_id" required>
                                    <option value="">Select SuperMarket</option>
                                    @foreach ($sm as $item)
                                        <option value="{{$item->id}}" {{ $item->id == old('supermarket_id') ? "selected" : "" }}>{{$item->name}}</option>
                                    @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group" id="product_selector">
                            <label for="exampleInputPassword1">Choose Existing Product</label>
                            <select class="form-control" id="product_id" name="product_id">
                                    <option value="-1" selected >Add a new Product</option>
                            </select>
                        </div>
                        @endrole
                        @role('vendor')
                        <div class="form-group" id="product_selector">
                            <label for="exampleInputPassword1">Choose Existing Product</label>
                            <select class="form-control" id="product_id" name="product_id">
                                    <option value="-1" selected >Add a new Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{$product->product_id}}" {{ $product->product_id == old('product_id') ? "selected" : "" }}>{{$product->product_name}}</option>
                                    @endforeach
                            </select>
                        </div>
                        @endrole
                        <div class="form-group" id="name_selector">
                            <label> Product Name</label>
                        <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="form-group" id="name_arabic_selector">
                            <label> Arabic Product Name</label>
                            <input type="text" id="name" name="name_arabic" value="{{old('name_arabic')}}" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="form-group" id="description_selector">
                            <label for="exampleTextarea">Product Description</label>
                            <textarea class="form-control"  name="description"   id="description" rows="2">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group" id="description_arabic_selector">
                            <label for="exampleTextarea">Product Description  in Arabic </label>
                            <textarea class="form-control"  name="description_arabic" id="description" rows="2">{{old('description_arabic')}}</textarea>
                        </div>
                            {{-- <div class="form-group" id="category_selector">
                                <label for="exampleInputPassword1">Choose Category</label>
                                <select class="form-control" id="category_id" name="category_id">
                                        <option value="-1" selected >Select Sub Category</option>
                                            @foreach ($categories as $category)
                                                    <optgroup label="{{$category['name']}} "></optgroup>
                                                    @if (isset($category['sub_categories']) ))
                                                        @foreach ($category['sub_categories'] as $sbcat)
                                                            <option value="{{$sbcat['parent_id']}}">{{$sbcat['name']}}</option>
                                                        @endforeach
                                                    @endif
                                            @endforeach
                                </select>
                            </div>    --}}
                            <div class="form-group" id="main_category_selector">
                                <label for="exampleInputPassword1">Select Main Category</label>
                                <select class="form-control" id="main_category_type" name="main_category_id">
                                        <option>Select a Main Category</option>
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
                        <div class="form-group">
                            <label for="exampleInputPassword1">Product Images</label>
                            <input type="file"  id="file" name="filename[]" required  multiple="multiple"  class="form-control" >
                        </div>
                        <div class="form-group">
                            <label>Reward Points</label>
                        <input type="text" name="credits" id="credits" value="{{old('credits')}}"  class="form-control" placeholder="Reward Points">
                        </div>
                        <div class="form-group">
                            <label>Price (MRP)</label>
                            <input type="text" name="price" id="price" value="{{old('price')}}" class="form-control" placeholder="Price (MRP)">
                        </div>
                        <div class="form-group">
                            <label>Discount</label>
                        <input type="text" name="discount" id="discount" value="{{old('discount')}}" class="form-control" placeholder="Discount Percentage">
                        </div>
                        <div class="form-group">
                            <label>Discounted Price</label>
                            <input type="text" disabled name="discountedprice" value="{{old('discountedprice')}}" id="discountedprice" class="form-control" placeholder="" >
                        </div>
                        <div class="form-group">
                            <label>Capacity</label>
                            <input type="text" name="capacity" value="{{old('capacity')}}" class="form-control" placeholder="Capacity" >
                        </div>
                        <div class="form-group">
                            <label>Select Unit</label>
                            <select class="form-control" id="unit_select" name="unit" required>
                                <option>Select Unit</option>
                                @foreach ($units as $unit) 
                                    <option value="{{$unit->id}}" {{ $unit->id == old('unit') ? "selected" : "" }}>{{$unit->name}}</option>
                                @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                            <label>Quanity</label>
                            <input type="text" name="quantity" value="{{old('quantity')}}" class="form-control" placeholder="Quantity" >
                        </div>
                        <div class="form-group">
                            <label>Stock keeping unit</label>
                            <input type="text" name="sku" value="{{old('sku')}}" class="form-control" placeholder="Stock keeping unit" >
                        </div>
                        @role('admin')
                        <div class="form-group">
                            <label>Lottery Product</label>
                            <div class="kt-radio-inline">
                                <label class="kt-radio">
                                    <input type="radio" value="1" {{ old('lottery_product' )== "1" ? 'checked' : ''}}  name="lottery_product">Yes 
                                    <span></span>
                                </label>
                                <label class="kt-radio">
                                    <input type="radio" value="0" {{ old('lottery_product' )== "0" ? 'checked' : ''}} checked name="lottery_product">No
                                    <span></span>
                                </label>                                
                            </div>                        
                        </div>
                      <!--  <div class="form-group">
                            <label>Lottery Winner Product</label>
                            <div class="kt-radio-inline">
                                <label class="kt-radio">
                                    <input type="radio" value="1" {{ old('lottery_winner' )== "1" ? 'checked' : ''}} name="lottery_winner">Yes
                                    <span></span>
                                </label>
                                <label class="kt-radio">
                                    <input type="radio" value="0" {{ old('lottery_winner' )== "0" ? 'checked' : ''}} name="lottery_winner">No
                                    <span></span>
                                </label>                                
                            </div>                        
                        </div>  -->                      
                        <div class="form-group" id="lottery_selector_div" style="display: none;" >
                            <label>Select Lottery for this product</label>
                            <select class="form-control" id="lottery_id" name="lottery_id" required>
                                <option>Select Lottery Reward</option>                              
                                @foreach ($lotteries as $lottery) 
                                    <option value="{{$lottery->id}}" {{ old('lottery_id' )== $lottery->id ? 'selected' : ''}}>{{$lottery->name}}</option>
                                @endforeach
                        </select>
                        </div>
                        @endrole
                        @role('vendor')
                        <div class="form-group" style="display: none;">
                            <label>Super Market</label>
                        <input type="number" name="supermarket_id"  value="{{$vendor[0]['supermarket_id']}}" class="form-control"  placeholder="Supermarket" >
                        </div>
                        @endrole
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
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="{{asset('js/common.js')}}"></script>
<script src="{{asset('js/category.js')}}"></script>

<script>
    $(document).ready(function () {
        $(document).on("change keyup blur", "#discount", function() {
            var main = $('#price').val();
            var disc = $('#discount').val();
            var dec = (disc / 100).toFixed(2); 
            var mult = main * dec; // gives the value for subtract from main value
            var discont = main - mult;
            console.log(discont);
            $('#discountedprice').val(discont);
        });

        $("#product_id").change(function (e) {
            var selectedProduct = $("#product_id option:selected").val();
            if (selectedProduct != -1){
                $('#name_selector').hide();
                $('#name_arabic_selector').hide();
                $('#description_selector').hide();
                $('#description_arabic_selector').hide();
                $('#main_category_selector').hide();
            }
            else 
            {
                $('#name_selector').show();
                $('#description_selector').show();
                $('#main_category_selector').show();

            }
        });
		
		$(document).on("change keyup blur", "#discount", function() {
            var main = $('#price').val();
            var disc = $('#discount').val();
            var dec = (disc / 100).toFixed(2); 
            var mult = main * dec; // gives the value for subtract from main value
            var discont = main - mult;
            console.log(discont);
            $('#discountedprice').val(discont);
        });
		@if(old('lottery_product' )=='1')
			$('#lottery_selector_div').show();
		@endif
    });
</script>
@endsection