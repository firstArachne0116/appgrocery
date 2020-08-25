@extends('layouts.app')
@section('content')

<style>
.item11{

  min-width:300px;
  height: auto;
}
.item11 img{

  width: 100%;
  height: auto;
}
.item111{
min-width: 460px;
}
.wish-list{
  right:30px !important;
}
.wish-list .fa{
  color:#fff;
}
</style>

<?php //echo '<pre/>'; print_r($productdata); exit; ?>
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb2 breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class="breadcrumb-item"><a href="{{route('categories',['sid' => $productdata['marketid']])}}" >Categories</a></li>
    <li class="breadcrumb-item"><a href="{{route('subcategories',['sid' => $productdata['marketid'],
      'cid' => $productdata['cid']])}}">
        {{App\Category::find($productdata['cid'])->{session('name')} }}</a></li> 
     
    <li class="breadcrumb-item"><a href="{{route('products',['sid' => $productdata['marketid'],
      'cid' => $productdata['cid'],'scid' => $productdata['scid'] ])}}"></a>{{App\Category::find($productdata['scid'])->{session('name')} }}</li> 
      <li class="breadcrumb-item">{{App\Category::find($productdata['product']['category_id'])->{session('name')} }}</li> 
 
    </ol>
  </nav>
  <div class="clearfix"></div>
</div>
<div class="inner-header2">
  <h3>{{ $productdata['product']['name'] }}</h3>
</div>
<div class="inner-page">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-lg-5"> 
          @if(Auth::check())
      <?php if($productdata['variant'][0]['wishlist_item'] == 0) { $whcss = 'style="display:none;"'; } else { $whcss = ''; }
            if($productdata['variant'][0]['wishlist_item'] == 1) { $whacss = 'style="display:none;"'; } else { $whacss = ''; }  ?>
          
            <a class="wishtoadd wish-list" <?=$whacss;?> onclick="addtowishlist('<?php echo $productdata['product']['id']; ?>')"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
            <a class="addedwish wish-list" <?=$whcss;?>><i class="fa fa-heart" aria-hidden="true"></i></a>
          @endif
        <div id="sync1" class="owl-carousel owl-theme">
            
            <?php $imgs = json_decode($productdata['variant'][0]['image_path']); $link1 = session('constant_url') . session('product_image_path'). '/'.$imgs[0];  ?>
             
            @foreach($imgs as $img)
            <?php $link = session('constant_url') . session('product_image_path'). '/'.$img; ?>   
            <div class="item">
              <div class="item"> <a href="{{ $link }}"> <img src="{{ $link }}" alt="" title="" /> </a> </div>
            </div>
            @endforeach
          
        </div>
        <div id="sync2" class="owl-carousel owl-theme">
          
          @foreach($imgs as $img)
          <?php $link = session('constant_url') . session('product_image_path'). '/'.$img; ?> 
            <div class="item"><img src="{{ $link }}" alt="" title=""></div>
          @endforeach

        </div>
      </div>
      <div class="col-lg-7  product-text">
        <div class="row">
          <div class="col-md-6 col-sm-6 col-6">
              <h3>{{ $productdata['product'][session('name')] }}</h3>
          </div>
          <div class="col-md-6 col-sm-6 text-right col-6">
            <div class="price-css">
              @if ($productdata['variant'][0]['price'] != $productdata['variant'][0]['discountedprice'])
                <strike><?php echo session('currency_symbol'); ?>{{ $productdata['variant'][0]['price'] }}</strike>
              @endif
              <div class="clearfix"></div><?php echo session('currency_symbol'); ?>
              {{ $productdata['variant'][0]['discountedprice'] }}
            </div>
          </div>
          <div class="col-md-12">
            <div class="mt-3">
              <p>{{ $productdata['product'][session('description')] }}</p>
              <div class="mt-3 text-2">
              <?php if($productdata['variant'][0]['quantity'] > 0) { ?>
                <p><span>Availability</span>: &nbsp;&nbsp;<img src="{{ asset('images/available.png') }}" alt="" title="" > In Stock</p>
              <?php }  else { ?>
                <p><span>Availability</span>: &nbsp;&nbsp;<img src="{{ asset('images/out-of-stock.png') }}" alt="" title="" > Out of Stock</p>
              <?php } ?>
                <p><span>Vendor</span>: &nbsp;&nbsp;{{ $productdata['supermarket'][0][session('name')] }} </p>
                <!-- <p><span>Product Type</span>: &nbsp;&nbsp;Malesuada nunc vel risus </p> -->
              </div>
              <div class="quality">
                <div class="row">
                  <div class="col-md-5 col-sm-5">
                
                    <div class="input-group">
                      <h4>Quantity :</h4>
                      <span class="input-group-btn">
                      <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quantity"> <i class="fa fa-minus"></i> </button>
                      </span>
                      <input type="text" name="quantity" class="input-number" value="0" min="1" max="{{ $productdata['variant'][0]['quantity'] }}">
                      <span class="input-group-btn">
                      <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quantity"><i class="fa fa-plus"></i> </button>
                      </span> </div>
                  </div>
                  <div class="col-md-5 col-sm-5">
                        <div class="input-group">
                    <h4>Unit: &nbsp;</h4>
                    <div class="form-group">
                    <form name="unitform" id="unitform" method="get" action="{{ route('product', ['sid' => $productdata['marketid'], 'cid' => $productdata['cid'], 'scid' => $productdata['scid'], 'pid' => $productdata['pid']]) }}">            
                        <select name="units" class="form-control" id="variantselect">
                          @foreach($productdata['productconfig'] as $pck => $pcv)
                            <?php if($pcv['id'] == $productdata['variant'][0]['id']) {  $sel = 'selected'; } else { $sel = ''; } ?>
                            <?php $unit = App\Constant::Where(['id' => $pcv['unit_id']])->value('data'); ?>
                            <option value="{{ $pcv['id'] }}" <?php echo $sel; ?>>{{ $pcv['capacity']. ' '. $unit }}</option>                            
                          @endforeach
                        </select>
                    </form>
                       </div>
                     </div>
                  </div>

                 
                </div><br />
                @if(Auth::check())
                <div class="row">
                  <div class="col-md-3 col-sm-3"> 
                    <form name="cartform" id="cartform" action="{{ route('addtocart') }}" method="post">
                        @csrf
                      <input type="hidden" name="product_id" id="product_id" value="{{ $productdata['product']['id'] }}" />
                      <input type="hidden" name="productconfig_id" id="productconfig_id" value="{{ $productdata['variant'][0]['id'] }}" />
                      <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
                      <input type="hidden" name="name" id="name" value="{{ $productdata['product']['name'] }}" />
                      <input type="hidden" name="description" id="description" value="{{ $productdata['variant'][0]['description'] }}" />
                      <input type="hidden" name="image_path" id="image_path" value="{{ $imgs[0] }}" />
                      <input type="hidden" name="price" id="price" value="{{ $productdata['variant'][0]['price'] }}" />
                      <input type="hidden" name="discountedprice" id="discountedprice" value="{{ $productdata['variant'][0]['discountedprice'] }}" />
                      <input type="hidden" name="quantity" id="quantity" value="0" />
                      <input type="hidden" name="maxquantity" id="maxquantity" value="{{ $productdata['variant'][0]['quantity'] }}" />
                      <input type="hidden" name="unit" id="unit" value="{{ $productdata['variant'][0]['capacity'] }}" />
                      <input type="hidden" name="market" id="market" value="{{ $productdata['product']['supermarket_id'] }}" />
                      <input type="submit" class="btn add-to-cart2" id="pageaddtocart" value="Add To Cart">
                    </form>  
                   </div>
                   <?php if($productdata['variant'][0]['weeklylist_item'] == 0) { $wcss = 'style="display:none;"'; } else { $wcss = ''; }
                        if($productdata['variant'][0]['weeklylist_item'] == 1) { $wacss = 'style="display:none;"'; } else { $wacss = ''; }  ?>
                      <div class="col-md-4 col-sm-4"> <a class="btn add-to-cart2 addtoweekly weeklytoadd" <?=$wacss;?>>Add to Weekly List</a> </div>                   
                      <div class="col-md-4 col-sm-4"> <a class="btn add-to-cart2 addedweekly" <?=$wcss;?>>Added to Weekly List</a> </div>                
                 </div>
                 @endif
                 @if(!Auth::check())
                    Please Login
                 @endif
              </div>
              <div class="clearfix"></div>
             
              <div class="clearfix"></div>
              <div class="row categories">
                <div class="col-md-7">
                  <h3 class="pull-left"> Categories : <span>&nbsp;{{ App\Category::find($productdata['cid'])->{session('name')} }}</span></h3>
                </div>
               
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"> </div>
      <div class="col-md-12">
        <div id="tabs" class="description">
          <div>
            <nav>
              <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist"> <a class="active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Highlights</a>&nbsp;|&nbsp;<!--<a class="" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"> info</a>&nbsp;|&nbsp; --> </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active text-1" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <p class="p1"><strong>{{ $productdata['variant'][0][session('description')] }}<br>
                  </strong>{{ $productdata['variant'][0][session('description')] }}</p>               
              </div>
              <!-- <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <p class="p1"><strong>How to write product descriptions that sell <br>
                  </strong>One of the best things you can do to make your store successful is invest some time in writing great product descriptions. You want to provide detailed yet concise information that will entice potential to buy.</p>               
              </div> -->
              
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="related">
          <div class="col-md-12">
              <h2 class="icon-css">Recommended Products</h2>
              <div class="owl-carousel latest-products owl-theme wow fadeIn">
                
              <!-- recommended products -->
                
                  @foreach ($productdata['recommendedProducts'] as $rp)
                  <?php $imgs = json_decode($rp->product_image); $link1 = url('../admin/').'/public'. session('product_image_path'). '/'.$imgs[0];  ?>
                  <div class="item">
                  <div class="product bg-fff"><a class="product-img" href="/products/{{$rp->supermarket_id}}/{{$productdata['cid']}}/{{$rp->category_id}}/{{$rp->product_id}}"><img src="{{ $link1 }}" alt=""></a>
                      <h5 class="product-type">{{App\Category::find($rp->category_id)->{session('name')} }}</h5>
                      <h3 class="product-name">{{ $rp->{session('name')} }}</h3>
                      <h3 class="product-price"><?php echo session('currency_symbol'); ?>{{ $rp->product_price }}</h3>
                      <div>
                          <input type="hidden" name="product_id" id="product_idpr<?php echo $rp->productconfig_id; ?>" value="{{ $rp->product_id }}" />
                          <input type="hidden" name="productconfig_id" id="productconfig_idpr<?php echo $rp->productconfig_id; ?>" value="{{ $rp->productconfig_id }}" />
                          <input type="hidden" name="user_id" id="user_id" @if (Auth::check()) value="{{  Auth::user()->id }}" @endif  />                          
                          <input type="hidden" name="name" id="namepr<?php echo $rp->productconfig_id; ?>" value="{{ $rp->name }}" />
                          <input type="hidden" name="description" id="descriptionpr<?php echo $rp->productconfig_id; ?>" value="{{ $rp->description }}" />
                          <input type="hidden" name="image_path" id="image_pathpr<?php echo $rp->productconfig_id; ?>" value="{{ $link1 }}" />
                          <input type="hidden" name="price" id="pricepr<?php echo $rp->productconfig_id; ?>" value="{{ $rp->product_price }}" />
                          <input type="hidden" name="discountedprice" id="discountedpricepr<?php echo $rp->productconfig_id; ?>" value="{{ $rp->product_discounted_price }}" />
                          <input type="hidden" name="maxquantity" id="maxquantitypr<?php echo $rp->productconfig_id; ?>" value="{{ $rp->product_quanity }}" />
                          <input type="hidden" name="unit" id="unitpr<?php echo $rp->productconfig_id; ?>" value="{{ $rp->product_weight }}" />
                          <input type="hidden" name="market" id="marketpr<?php echo $rp->productconfig_id; ?>" value="{{ $rp->supermarket_id }}" />
                        </div>  
                        <div class="stepper-widget">
                            <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="pr<?php echo $rp->productconfig_id; ?>"> <i class="fa fa-minus"></i> </button>
                            <input type="text" name="pr<?php echo $rp->productconfig_id; ?>" id="quantitypr<?php echo $rp->productconfig_id; ?>" class="input-number" value="0" min="1" max="{{ $rp->product_quanity }}">
                            <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="pr<?php echo $rp->productconfig_id; ?>"><i class="fa fa-plus"></i> </button>                         
                            <?php $unit = App\Constant::Where(['id' => $rp->unit_id])->value('data'); ?>  
                            <h3 class="product-price">{{ $rp->product_weight .' '. $unit }} </h3>                   
                        </div><br/>
                        <div id="popproductdiv<?php echo $rp->productconfig_id; ?>" style="display:none;"><img src="{{ asset('images/available.png') }}" /><span class="popproductmsg"> </span></div>
                        <div class="product-select">@if(Auth::check())              
                          <?php if($rp->wishlist_item == '0') { $whcss = 'style="display:none;"'; } else { $whcss = ''; }
                                if($rp->wishlist_item == '1') { $whacss = 'style="display:none;"'; } else { $whacss = ''; } ?>
                                
                                <button data-toggle="tooltip" data-placement="top" title="Wishlist" class="add-to-wishlist round-icon-btn" id="wishtoadd<?php echo $rp->productconfig_id; ?>" onclick="addtowishlist('<?php echo $rp->productconfig_id; ?>','pr')" <?=$whacss;?>><i class="fa fa-heart-o" aria-hidden="true"></i></button>
                                <button data-toggle="tooltip" data-placement="top" title="Wishlist" class="add-to-wishlist round-icon-btn" id="addedwish<?php echo $rp->productconfig_id; ?>" <?=$whcss;?>><i class="fa fa-heart" aria-hidden="true"></i></button>
                                <button data-toggle="tooltip" data-placement="top" title="Add To Cart"  onClick="addtocart('<?php echo $rp->productconfig_id; ?>','pr')" class="add-to-cart round-icon-btn"><i class="fa fa-shopping-bag" aria-hidden="true"></i></button>
                                @endif
                                @if(!Auth::check())
                                  Please Login
                                @endif                                
                        </div>
                      </div>
                    </div> 
                  @endforeach
              
              <!-- recommended products -->
                
              </div>
            </div>
      </div>
    </div>
  </div>
</div>
@endsection