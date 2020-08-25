@extends('layouts.app')
@section('content')
<div class="row" style="padding:0px 25px 0px 0px;">
    <div class="col-lg-12 margin-tb">                      
        @role('admin')
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('product.list') }}"> Back</a>
        </div>
        @endrole
        @role('vendor')
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('product.index') }}"> Back</a>
        </div>
        @endrole
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
            <form class="kt-form" method="POST" enctype="multipart/form-data" action="{{ route('product.update',$product[0]->productconfig_id) }}">
                    @csrf
                    @method('PUT')
                <div class="kt-portlet__body">
                        @role('admin')
                        <div class="form-group">
                                <label>Super Market</label>
                                <select class="form-control" id="supermarket_id" name="supermarket_id" required>
                                        <option>Select SuperMarket</option>
                                        @foreach ($sm as $item)
                                            <option value="{{$item->id}}" {{ $item->id == $product[0]->supermarket_id ? "selected" : "" }}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                            </div>
                        @endrole
                        <div class="form-group">
                            <label> Product Name</label>
                        <input type="text" id="name" name="name" value="{{$product[0]->product_name}}" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label> Arabic Product Name</label>
                        <input type="text" id="name" name="name_arabic" value="{{$product[0]->product_name_arabic}}" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea">Product Description</label>
                        <textarea class="form-control"  name="description"   id="description" rows="2">{{ htmlspecialchars($product[0]->description) }}</textarea>
                            </div>
                        <div class="form-group">
                            <label for="exampleTextarea">Product Description in Arabic</label>
                        <textarea class="form-control"  name="description_arabic"   id="description_arabic" rows="2">{{ htmlspecialchars($product[0]->description_arabic) }}</textarea>
                            </div>
                            <div class="form-group" id="category_selector">
                            <label for="exampleInputPassword1">Product Category: {{$product[0]->category_name}}</label>
                                {{-- <select class="form-control" id="category_id" name="category_id">
                                        <option value="-1" selected >Select Sub Category</option>
                                        @if (isset($categories))
                                            @foreach ($categories as $category)
                                                    <optgroup label="{{$category['name']}} "></optgroup>
                                                    @if (isset($category['sub_categories']) ))
                                                        @foreach ($category['sub_categories'] as $sbcat)
                                                            <option value="{{$sbcat['parent_id']}}" {{ $sbcat['parent_id'] == $product[0]->category_id ? "selected" : "" }} >{{$sbcat['name']}}</option>
                                                        @endforeach
                                                    @endif
                                            @endforeach
                                        @endif
                                </select> --}}
                            </div>   
                            @if(json_decode($product[0]->image_path))
                            <div class="form-group">
                            <label for="exampleInputPassword1">Uploaded Images</label>
                                
                                @foreach (json_decode($product[0]->image_path) as $item)
                                    <img src = "{{asset(App\Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data').'/'.$item)}}"  width="50" height="50">
                                    {{-- <a href="{{route('image.delete',$loop->index)}}"><img class="close-image" width="10" height="10" src="http://aux3.iconspalace.com/uploads/567330038556056137.png" > </a> --}}
                                @endforeach   
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="exampleInputPassword1">Product Images</label>
                                <input type="file"  id="file" name="filename[]" multiple="multiple"  class="form-control" >
                            </div>
                    
                        <div class="form-group">
                            <label>Status</label>
                            <div class="kt-radio-inline">
                                <label class="kt-radio">
                                    <input type="radio" value="1" {{$product[0]->is_enabled == 1 ? "checked" : ""}}  name="status">Enabled
                                    <span></span>
                                </label>
                                <label class="kt-radio">
                                    <input type="radio" value="0" {{$product[0]->is_enabled == 0 ? "checked" : ""}} name="status">Disabled
                                    <span></span>
                                </label>
                                
                            </div>                        
                        </div>
                        <div class="form-group">
                            <label>Credits</label>
                        <input type="number" name="credits" id="credits" value="{{$product[0]->credits}}" class="form-control" placeholder="Price (MRP)">
                        </div>
                        <div class="form-group">
                            <label>Price (MRP)</label>
                        <input type="number" name="price" id="price" value="{{$product[0]->price}}" class="form-control" placeholder="Price (MRP)" step="0.01">
                        </div>
                        <div class="form-group">
                            <label>Discount</label>
                        <input type="number" name="discount" value="{{$product[0]->discount}}" id="discount" class="form-control" placeholder="Discount Percentage">
                        </div>
                        <div class="form-group">
                            <label>Discounted Price</label>
                        <input type="number"  name="discountedprice" value="{{$product[0]->discountedprice}}" id="discountedprice" class="form-control" placeholder="" >
                        </div>
                        <div class="form-group">
                            <label>Capacity</label>
                        <input type="text" name="capacity" value="{{$product[0]->capacity}}" class="form-control" placeholder="Weight" >
                        </div>
                        <div class="form-group">
                            <label>Select Unit</label>
                            <select class="form-control" id="unit_select" name="unit" required>
                                <option>Select Unit</option>
                                @foreach ($units as $unit) 
                                    <option value="{{$unit->id}}" {{ $unit->id == $product[0]->unit_id ? "selected" : "" }}>{{$unit->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quanity</label>
                        <input type="number" name="quantity" value="{{$product[0]->quantity}}" class="form-control" placeholder="Quantity" >
                        </div>  
                        <div class="form-group">
                            <label>Stock Keeping Unit</label>
                            <input type="text" name="sku" value="{{$product[0]->sku}}" class="form-control" placeholder="Stock Keeping Unit" >
                        </div>  
                        @role('admin')
                        <div class="form-group">
                            <label>Lottery Product</label>
                            <div class="kt-radio-inline">
                                <label class="kt-radio">
                                    <input type="radio" value="1" {{$product[0]->lotteryproduct == 1 ? "checked" : ""}} name="lottery_product">Yes 
                                    <span></span>
                                </label>
                                <label class="kt-radio">
                                    <input type="radio" value="0" {{$product[0]->lotteryproduct == 0 ? "checked" : ""}} name="lottery_product">No
                                    <span></span>
                                </label>                                
                            </div>                        
                        </div>
                        @if($selectedlottery)
                        @if ($product[0]->lotteryproduct == 1)
                            <div class="form-group">
                                <label>Lottery Choosen</label>
                                <span>{{'Name: '.$selectedlottery->name.' Lottery Reward: '.$selectedlottery->lottery_rule.
                                '  Valid Till: '.date('d-M-Y', strtotime($selectedlottery->valid_till))}}</span>                      
                            </div>
                        @endif
                        @endif                                           
                       <div class="form-group" id="lottery_selector_div" style="display: none;"> 
                            <label>Available Lotteries </label>
                            <select class="form-control" id="lottery_id" name="lottery_id">
                                <option value="">Select Different Lottery</option>                               
                                @foreach ($lotteries as $lottery) 
                                    <option value="{{$lottery->id}}" 
                                        {{$lottery->id == $product[0]->lottery_id ? "selected" : ""}}>{{$lottery->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endrole
                        @role('vendor')
                        <div class="form-group" style="display: none;">
                            <label>Super Market</label>
                        <input type="number" name="supermarket_id" value="{{$vendor[0]['supermarket_id']}}" class="form-control"  placeholder="Supermarket" >
                        </div>
                        @endrole

                        
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
<script
src="https://code.jquery.com/jquery-3.4.1.min.js"
integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous"></script>
<script src="{{asset('js/common.js')}}"></script>

<script>
        $(document).ready(function () {
        $('input[name=discountedprice]'). prop("disabled", true);
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
                $('#file').hide();
                $('#name').hide();
                $('#description').hide();
                $('#category_id').hide();
            }
            else 
            {
                $('#file').show();
                $('#name').show();
                $('#description').show();
                $('#category_id').show();

            }
        });	
		
		@if($product[0]->lotteryproduct=='1')
			$('#lottery_selector_div').show();
		@endif
		
    });

</script>
@endsection