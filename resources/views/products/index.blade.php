@extends('layouts.app')
@section('content')
<?php // echo '<pre/>'; print_r($productdata); exit; ?>
<style>
  .product-selection{
    /*width: 100%; */
    height:30px;
			border-radius: :none !important;
			padding: 0px 8px 0px 20px;
    font-size: 15px;
    font-weight: 500;
    font-family: 'Roboto', sans-serif;
    letter-spacing: .5px;
    background: #f4ef55;
    color: #0D2764;
		}
    option{
      padding: 14px 16px 14px 37px;
height: 56px !important;

    }

    .product-selection select{
      padding: 14px 16px 14px 37px;
height: 56px !important;

    }
    button, input, optgroup, select, textarea{

      line-height: 30px !important;
    }
    .select-items div,.select-selected {
  color: #000000;
  padding: 8px 6px;
  border: 1px solid transparent;
  border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
  cursor: pointer;
  user-select: none;
}

.custom-select {
  position: relative;
  font-family: Arial;
}

.custom-select select {
  display: none; /*hide original SELECT element:*/
}

.select-selected {
  background-color: red;
}

/*style the arrow inside the select element:*/
.select-selected:after {
  position: absolute;
  content: "";
  top: 14px;
  right: 10px;
  width: 0;
  height: 0;
  border: 6px solid transparent;
  border-color: #fff transparent transparent transparent;
}

/*point the arrow upwards when the select box is open (active):*/
.select-selected.select-arrow-active:after {
  border-color: transparent transparent #fff transparent;
  top: 7px;
}

/*style the items (options), including the selected item:*/
.select-items div,.select-selected {
  color: #000000;
  padding: 8px 6px;
  border: 1px solid transparent;
  border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
  cursor: pointer;
  user-select: none;
}

/*style items (options):*/
.select-items {
  position: absolute;
  background-color: DodgerBlue;
  top: 100%;
  left: 0;
  right: 0;
  z-index: 99;
}

/*hide the items when the select box is closed:*/
.select-hide {
  display: none;
}

.select-items div:hover, .same-as-selected {
  background-color: rgba(0, 0, 0, 0.1);
}
.filter-by .form-control{
  width:90%;
  float: left;
}

</style>
<div class="container search-div ">
  <div class="row">
    <div class="col-lg-4 col-md-4 top-dropdown">    
        <div class="">  
        <form name="categoryform" id="categoryform" method="get" 
        action="{{ route('products', ['sid' => $productdata['marketid'], 
        'cid' => $productdata['cid'], 'scid' => $productdata['scid']]) }}">            
            <select name="childnode" id="childnode" class="product-selection">
            <option value="0">Browse other Categories</option>
            <?php //echo '<pre/>'; print_r($productdata['childcategories']['categories']); exit; ?>
              @if($productdata['childcategories']['categories'])
              @foreach($productdata['childcategories']['categories'] as $catk => $catv)
                <option value="{{ $catv['id'] }}" {{ $catv['id'] == Request::get('childnode') ? "selected" : "" }} >{{ $catv[session('name')] }} </option>
              @endforeach
              @endif
            </select>
          </form>

    </div>
    
    </div>
    <div class="col-lg-8 col-md-8">
      <div class="input-group filter-by" >
      <form action="{{route('products',['sid' => $productdata['marketid'], 'cid' => $productdata['cid'], 'scid' =>$productdata['scid']])}}" method="GET" style="width: 100%;margin-bottom:0px !important;">
        {{csrf_field()}}  
        {{-- <input type="hidden" name="search_param" value="all" id="search_param"> --}}
        <input type="text" class="form-control" name="search_text" placeholder="What do you need?" >
        <span class="input-group-btn">
          <input type="submit" value="Search" class="btn btn-default search-bt">
        </span> 
      </form>
      </div>
    </div>
  </div>
</div>
<!-- Navigation -->
<div class="container container">
  <nav aria-label="breadcrumb" class="bread-boder">
    <div class="row">
      <div class="col-lg-6 col-md-4">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
          <li class="breadcrumb-item"><a href="{{route('categories',['sid' => $productdata['marketid']])}}" >Categories</a></li>
        <li class="breadcrumb-item"><a href="{{route('subcategories',['sid' => $productdata['marketid'],
          'cid' => $productdata['cid']])}}">
            {{App\category::find($productdata['cid'])->{session('name')} }}</a></li> 
        <li class="breadcrumb-item">{{App\category::find($productdata['scid'])->{session('name')} }}</li> 
        </ol>
      </div>      
      <div class="col-lg-6 col-md-4">
        <div class="row">
          <div class="col-md-6">
            <form  name="sortform" id="sortform" method="get" action="{{ route('products', ['sid' => $productdata['marketid'], 'cid' => $productdata['cid'], 'scid' => $productdata['scid']]) }}">
                <div class="">
                    <div class="">
                      <input type="hidden" name="childnode"  
                      value="{{ (Request::get('childnode') ? Request::get('childnode') : 0) }}" />
                      <select class="product-selection" name="sortcategory" id="sort-category">
                        <option>Default Sorting</option>
                        <option value="1">A to Z</option>
                        <option value="2">Z to A</option>
                        {{-- <option value="3">High to low price</option>
                        <option value="4">Low to high</option> --}}
                      </select>
                    </div>
                  </div>
              </form>
          </div>
          <div class="col-md-6">
            <div class="row">
              <form name="productlimitform" id="product-limit-form" method="get" action="{{ route('products', 
              ['sid' => $productdata['marketid'], 'cid' => $productdata['cid'], 'scid' => $productdata['scid']]) }}">
              <input type="hidden" name="childnode"  
              value="{{ (Request::get('childnode') ? Request::get('childnode') : 0) }}" />
                  <select class="product-selection" name="productlimit" id="product-limit">
                      <option>Showing 10 products</option>
                      <option value="20">Show 20</option>
                      <option value="30">Show 30</option>
                    </select>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
  </nav>
  <div class="container">
  <div class="row">    
    <div class="col-lg-12 col-md-12">
      <div class="columns-5">
        <div>
          <div class="right-heading">
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <h3>Products </h3>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">          
          @if($productdata['productlist'])
          @foreach($productdata['productlist'] as $productk => $productv)  
           {{! $pid = $productv['id'] }}
           @if($productv['productconfig'][0])
          <?php $imgs = json_decode($productv['productconfig'][0]['image_path']); $link = session('constant_url') . session('product_image_path'). '/'.$imgs[0]; ?>  
            <div class="col-lg-3 col-md-5 col-sm-6 mb-4">
              <div class="product bg-fff"><a class="product-img" href="{{ route('product', ['sid' => $productdata['marketid'], 'cid' => $productdata['cid'], 'scid' => $productdata['scid'], 'pid' => $pid])}}"><img src="<?php echo $link; ?>" alt=""></a>
                <h5 class="product-type">{{ App\Category::find($productv['category_id'])->{session('name')} }}</h5>
                <h3 class="product-name">{{ $productv[session('name')] }}</h3>
                <div class="row m-0 list-n">                                                                  
                  <div class="col-lg-12 p-0">
                    <h3 class="product-price">
                        @if ($productv['productconfig'][0]['price'] != $productv['productconfig'][0]['discountedprice'])
                            <strike><small><?php echo session('currency_symbol').' '; ?>{{ $productv['productconfig'][0]['price'] }}</small></strike>
                        @endif
                        <br/>
                        <?php echo session('currency_symbol').' '; ?>
                        {{$productv['productconfig'][0]['discountedprice']}}
                    </h3><br/>                    
                  </div>                                 
                  <div class="col-lg-12 p-0">
                    <div class="product-price">
                      <form class="form-inline">
                        <div>
                          <input type="hidden" name="product_id" id="product_idpr<?php echo $productv['id']; ?>" value="{{ $productv['id'] }}" />
                          <input type="hidden" name="productconfig_id" id="productconfig_idpr<?php echo $productv['id']; ?>" value="{{ $productv['productconfig'][0]['id'] }}" />
                          <input type="hidden" name="user_id" id="user_id" @if (Auth::check()) value="{{  Auth::user()->id }}" @endif  />                          
                          <input type="hidden" name="name" id="namepr<?php echo $productv['id']; ?>" value="{{ $productv['name'] }}" />
                          <input type="hidden" name="description" id="descriptionpr<?php echo $productv['id']; ?>" value="{{ $productv['productconfig'][0]['description'] }}" />
                          <input type="hidden" name="image_path" id="image_pathpr<?php echo $productv['id']; ?>" value="{{ $imgs[0] }}" />
                          <input type="hidden" name="price" id="pricepr<?php echo $productv['id']; ?>" value="{{ $productv['productconfig'][0]['price'] }}" />
                          <input type="hidden" name="discountedprice" id="discountedpricepr<?php echo $productv['id']; ?>" value="{{ $productv['productconfig'][0]['discountedprice'] }}" />
                          <input type="hidden" name="maxquantity" id="maxquantitypr<?php echo $productv['id']; ?>" value="{{ $productv['productconfig'][0]['quantity'] }}" />
                          <input type="hidden" name="unit" id="unitpr<?php echo $productv['id']; ?>" value="{{ $productv['productconfig'][0]['capacity'] }}" />
                          <input type="hidden" name="market" id="marketpr<?php echo $productv['id']; ?>" value="{{ $productv['supermarket_id'] }}" />
                        </div>                        
                        <div class="stepper-widget">
                        <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="pr<?php echo $productv['id']; ?>"> <i class="fa fa-minus"></i> </button>
                        <input type="text" name="pr<?php echo $productv['id']; ?>" id="quantitypr<?php echo $productv['id']; ?>" class="input-number" value="0" min="1" max="{{ $productv['productconfig'][0]['quantity'] }}">
                        <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="pr<?php echo $productv['id']; ?>"><i class="fa fa-plus"></i> </button>
                          <select name="units" data-fancybox="gallery"  data-src="#popup-<?php echo $pid; ?>" href="javascript:;">
                            @foreach($productv['productconfig'] as $productconfk => $productconfv)  
                              <?php $unit = App\Constant::Where(['id' => $productconfv['unit_id']])->value('data'); ?>         
                              <option value="{{ $productconfv['capacity'] }}">{{ $productconfv['capacity']. ' '. $unit }}</option>      
                            @endforeach            
                           </select>
                         </div>                                               
                      </form>
                    </div>
                    <p><div id="popproductdiv<?php echo $productv['id']; ?>" style="display:none;"><img src="{{ asset('images/available.png') }}" /><span class="popproductmsg"> </span></div></p>
                  </div>          

                </div>
                <div class="product-select">
                  <?php if($productv['productconfig'][0]['wishlist_item'] == 0) { $whcss = 'style="display:none;"'; } else { $whcss = ''; }
                        if($productv['productconfig'][0]['wishlist_item'] == 1) { $whacss = 'style="display:none;"'; } else { $whacss = ''; }?>
                  @if(Auth::check()) 
                  <button data-toggle="tooltip" data-placement="top" title="Wishlist" class="add-to-wishlist round-icon-btn" id="wishtoadd<?php echo $productv['id']; ?>" onclick="addtowishlist('<?php echo $productv['id']; ?>','pr')" <?=$whacss;?>><i class="fa fa-heart-o" aria-hidden="true"></i></button>
                  <button data-toggle="tooltip" data-placement="top" title="Wishlist" class="add-to-wishlist round-icon-btn" id="addedwish<?php echo $productv['id']; ?>" <?=$whcss;?>><i class="fa fa-heart" aria-hidden="true"></i></button>
                  <button data-toggle="tooltip" data-placement="top" title="Add To Cart"  onClick="addtocart('<?php echo $productv['id']; ?>','pr')" class="add-to-cart round-icon-btn"><i class="fa fa-shopping-bag" aria-hidden="true"></i></button>
                  @endif
                  @if(!Auth::check())
                    <p> Please Login</p>
                  @endif
                </div>
              </div>
            </div> 
            @endif
            @endforeach      
            @endif     




            </div>         
            <div class="clearfix"></div>
            {{-- <div class="col text-center">
              <nav aria-label="Page navigation example">
                <ul class="pagination pagination-template d-flex justify-content-center float-none">
                  <li class="page-item"><a href="#" class="page-link"> <i class="fa fa-angle-left"></i></a></li>
                  <li class="page-item"><a href="#" class="page-link active">1</a></li>
                  <li class="page-item"><a href="#" class="page-link">2</a></li>
                  <li class="page-item"><a href="#" class="page-link">3</a></li>
                  <li class="page-item"><a href="#" class="page-link"> <i class="fa fa-angle-right"></i></a></li>
                </ul>
              </nav>
            </div>           --}}
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="clearfix"></div>

@if($productdata['productlist'])
  @foreach($productdata['productlist'] as $productk => $productv) 
  {{! $pid = $productv['id'] }}
  @if($productv['productconfig'][0])
  <?php $imgs = json_decode($productv['productconfig'][0]['image_path']); $link = session('constant_url') . session('product_image_path'). '/'.$imgs[0]; ?>  
    <div id="popup-<?php echo $pid; ?>" class="popup-fcy">
      <div class="row">
        <div class="col-md-6"> <img src="{{ $link }}" alt="" title="" class="img-fluid"> </div>
        <div class="col-md-6">          
          <div class="product-dis">
            <h3>{{ $productv[session('name')] }}</h3>
            <hr>
            <p>{{ $productv[session('description')] }}</p>
            <div class="row">
              <table class="table table hover">
                <thead><th>Price</th><th>Unit</th><th>Quantity</th><th>Action</th><th></th></thead>
                <tbody>
                  @foreach($productv['productconfig'] as $pck => $pcv)
                    <tr>
                        <td>
                        <div>
                          <input type="hidden" name="product_id" id="product_id<?php echo $pcv['id']; ?>" value="{{ $productv['id'] }}" />
                          <input type="hidden" name="productconfig_id" id="productconfig_id<?php echo $pcv['id']; ?>" value="{{ $pcv['id'] }}" />
                          <input type="hidden" name="user_id" id="user_id" @if (Auth::check()) value="{{  Auth::user()->id }}" @endif  />                          
                          <input type="hidden" name="name" id="name<?php echo $pcv['id']; ?>" value="{{ $productv['name'] }}" />
                          <input type="hidden" name="description" id="description<?php echo $pcv['id']; ?>" value="{{ $pcv['description'] }}" />
                          <input type="hidden" name="image_path" id="image_path<?php echo $pcv['id']; ?>" value="{{ $imgs[0] }}" />
                          <input type="hidden" name="price" id="price<?php echo $pcv['id']; ?>" value="{{ $pcv['price'] }}" />
                          <input type="hidden" name="discountedprice" id="discountedprice<?php echo $pcv['id']; ?>" value="{{ $pcv['discountedprice'] }}" />                      
                          <input type="hidden" name="maxquantity" id="maxquantity<?php echo $pcv['id']; ?>" value="{{ $pcv['quantity'] }}" />                      
                          <input type="hidden" name="unit" id="unit<?php echo $pcv['id']; ?>" value="{{ $pcv['capacity'] }}" />
                          <input type="hidden" name="market" id="market<?php echo $pcv['id']; ?>" value="{{ $pcv['supermarket_id'] }}" />
                        </div>
                    {{ session('currency_symbol') .' '. $pcv['price'] }}</td>
                        <td>
                            <?php $unit = App\Constant::Where(['id' => $pcv['unit_id']])->value('data'); ?>
                            {{ $pcv['capacity']. ' ' .$unit }}
                        </td>
                        <td>
                          <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="var<?php echo $pcv['id']; ?>"> <i class="fa fa-minus"></i> </button>
                          <input type="text" name="var<?php echo $pcv['id']; ?>" id="quantity<?php echo $pcv['id']; ?>" class="input-number" value="0" min="1" max="{{ $pcv['quantity'] }}">
                          <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="var<?php echo $pcv['id']; ?>"><i class="fa fa-plus"></i> </button>
                        </td>
                        @if(Auth::check())
                        <td>
                          <input type="button" class="btn add-to-cart2" onclick="addtocart('<?php echo $pcv['id']; ?>')" value="Add To Cart">
                        </td>
                        @endif
                        @if(!Auth::check())
                        <td>Please Login</td>
                        @endif
                        <td>
                           <div id="popvariantdiv<?php echo $pcv['id']; ?>" style="display:none;"><img src="{{ asset('images/available.png') }}" /><span class="popvariantmsg"> </span></div>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  @endforeach
@endif
<script src="{{asset('js/sort.js')}}"></script>
@endsection
<style>
.selection_productlist{
    border-radius: :none !important;
		padding: 14px 16px 14px 37px;
    font-size: 15px;
    font-weight: 500;
    font-family: 'Roboto', sans-serif;
    letter-spacing: .5px;
    background: #f4ef55;
    color: #0D2764;
    }
</style>
