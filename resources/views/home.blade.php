@extends("layouts.app")
@section("content")
<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @if($data['offers']) 
        <?php 
          $combinedoffers = array();
          foreach($data['offers'] as $offersmk => $offersmv) {
            foreach($offersmv as $offersk => $offersv) {
              $combinedoffers[] = $offersv;
            }
          }      
        ?> 
        @foreach($combinedoffers as $offersk => $offersv)             
        <?php $link = $imgs = ''; $imgs = json_decode($offersv['image_path']); 
            $link = session('constant_url') . session('offer_slider_image_eng'). '/'.$imgs[0];             
            if($offersk == '0') { $css = 'active'; } else { $css = ''; }           
        ?>
        @if ($offersv['productconfig_id'] && $offersv['product_id']>0)    
        <div class="carousel-item <?=$css;?>">
            <a href="{{ route('product',['sid' =>$offersv['supermarket_id'],'cid' =>$offersv['main_category_id'],
                'scid' => $offersv['sub_category_id'], 'pid' => $offersv['product_id'] ]) }}">
                <img class="d-block w-100" src="{{ $link }}" alt="First slide" style="width:100%">
            </a>
          </div>
        @else
          <div class="carousel-item <?=$css;?>">
              <a href="{{ route('products',['sid' =>$offersv['supermarket_id'],'cid' =>$offersv['main_category_id'],
                  'scid' => $offersv['sub_category_id']]) }}">
                <img class="d-block w-100" src="{{ $link }}" alt="First slide" style="width:100%;">
              </a>
          </div>
        @endif
        @endforeach
      @endif
    </div>
</div>
<div class="clearfix"></div>
<div id="featured-products">  
  <div class="container">
    <h2 class="wow fadeInDown">Nearby Supermarkets</h2>
    <div class="owl-carousel latest-products owl-theme wow fadeIn">
     @if($data['list'])
     @foreach($data['list'] as $supermarketk => $supermarketv) 
     <?php $imgs = json_decode($supermarketv['image_path']); $link = session('constant_url') . session('supermarket_image_path'). '/'.$imgs[0]; ?>    
      <div class="item">        
        <div class="product1"><a class="product-img" href="{{ route('categories', ['sid' => $supermarketv['id']]) }}"><img src="{{ $link }}" alt=""></a>
          <h5 class="product-type"><a href="{{ route('supermarkets') }}" data-distance="{{ $supermarketv['distance']}}">{{ $supermarketv[session('name')] }}</a></h5>
          <h3 class="product-name">{{ $supermarketv['address'] }}</h3>
        </div>
      </div>
      @endforeach
      @endif
    </div>
  </div>
</div>



<!-- Page Content -->
<div class="products-section">
  <div class="container">
    <h2 class="wow fadeInDown">Tickets Products</h2>
    <div class="owl-carousel latest-products owl-theme wow fadeIn">
      @if($data['lotteryproducts'])
      <?php //echo '<pre/>'; print_r($data['lotteryproducts']); exit; ?>
      @foreach($data['lotteryproducts'] as $productsk => $productsv)
      <?php //echo '<pre/>'; print_r($productsv); exit; ?>
        
        <?php $imgs = json_decode($productsv['image_path']); $link = session('constant_url') . session('product_image_path'). '/'.$imgs[0]; ?>  
      <div class="item">
        <div class="sale-flag-side"> <span class="sale-text">{{ $productsv['discount']}} %</span> </div>
      <div class="product bg-fff"><a class="product-img" href="{{ route('product', ['sid' => $productsv['supermarket_id'], 'cid' => $productsv['cid'], 'scid' => $productsv['category_id'], 'pid' => $productsv['product_id']]) }}"><img src="<?php echo $link; ?>" alt=""></a>
          <h5 class="product-type">{{ App\Product::find($productsv['product_id'])->{session('name')} }}</h5>
          <h3 class="product-price"><?php echo session('currency_symbol'); ?> {{ $productsv['discountedprice'] }} <del>{{ $productsv['price'] }}</del> </h3>          
          <br/>          
            <div>
              <input type="hidden" name="product_id" id="product_idpr<?php echo $productsv['id']; ?>" value="{{ $productsv['product_id'] }}" />
              <input type="hidden" name="productconfig_id" id="productconfig_idpr<?php echo $productsv['id']; ?>" value="{{ $productsv['id'] }}" />
              <input type="hidden" name="user_id" id="user_id" @if (Auth::check()) value="{{  Auth::user()->id }}" @endif  />                          
              <input type="hidden" name="name" id="namepr<?php echo $productsv['id']; ?>" value="{{ App\Product::find($productsv['product_id'])->name }}" />
              <input type="hidden" name="description" id="descriptionpr<?php echo $productsv['id']; ?>" value="{{ $productsv['description'] }}" />
              <input type="hidden" name="image_path" id="image_pathpr<?php echo $productsv['id']; ?>" value="{{ $imgs[0] }}" />
              <input type="hidden" name="price" id="pricepr<?php echo $productsv['id']; ?>" value="{{ $productsv['price'] }}" />
              <input type="hidden" name="discountedprice" id="discountedpricepr<?php echo $productsv['id']; ?>" value="{{ $productsv['discountedprice'] }}" />
              <input type="hidden" name="maxquantity" id="maxquantitypr<?php echo $productsv['id']; ?>" value="{{ $productsv['quantity'] }}" />
              <input type="hidden" name="unit" id="unitpr<?php echo $productsv['id']; ?>" value="{{ $productsv['capacity'] }}" />
              <input type="hidden" name="market" id="marketpr<?php echo $productsv['id']; ?>" value="{{ $productsv['supermarket_id'] }}" />
            </div>
            <div class="stepper-widget">
              <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="pr<?php echo $productsv['id']; ?>"> <i class="fa fa-minus"></i> </button>
              <input type="text" name="pr<?php echo $productsv['id']; ?>" id="quantitypr<?php echo $productsv['id']; ?>" class="input-number" value="0" min="1" max="{{ $productsv['quantity'] }}">
              <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="pr<?php echo $productsv['id']; ?>"><i class="fa fa-plus"></i> </button>                         
              <?php $unit = App\Constant::Where(['id' => $productsv['unit_id']])->value('data'); ?>  
              <h3 class="product-price">{{ $productsv['capacity']. ' '.$unit }} </h3>                   
            </div>
            <div id="popproductdiv<?php echo $productsv['id']; ?>" style="display:none;"><img src="{{ asset('images/available.png') }}" /><span class="popproductmsg"> </span></div>
          <div class="product-select">
              @if(Auth::check()) 
            <?php if($productsv['wishlist_item'] == 0) { $whcss = 'style="display:none;"'; } else { $whcss = ''; }
            if($productsv['wishlist_item'] == 1) { $whacss = 'style="display:none;"'; } else { $whacss = ''; } ?>
            
            <button data-toggle="tooltip" data-placement="top" title="Wishlist" class="add-to-wishlist round-icon-btn" id="wishtoadd<?php echo $productsv['id']; ?>" onclick="addtowishlist('<?php echo $productsv['id']; ?>','pr')" <?=$whacss;?>><i class="fa fa-heart-o" aria-hidden="true"></i></button>
            <button data-toggle="tooltip" data-placement="top" title="Wishlist" class="add-to-wishlist round-icon-btn" id="addedwish<?php echo $productsv['id']; ?>" <?=$whcss;?>><i class="fa fa-heart" aria-hidden="true"></i></button>
            <button data-toggle="tooltip" data-placement="top" title="Add To Cart"  onClick="addtocart('<?php echo $productsv['id']; ?>','pr')" class="add-to-cart round-icon-btn"><i class="fa fa-shopping-bag" aria-hidden="true"></i></button>
            @endif
            @if(!Auth::check())
              Please Login
            @endif            
          </div>          
        </div>
      </div>
      @endforeach
      @endif
    </div>
  </div>
</div>

<!-- download section -->

<div class="inner-bg">
    <div class="container">
        <div class="row">
            <div class="col-sm-5 phone wow fadeInLeft animated text-center" style="visibility: visible; animation-name: fadeInLeft;">
                <img style="display: inline;" class="img-responsive iamgurdeeposahan" alt="iamgurdeeposahan" title="iamgurdeeposahan" src="{{asset('images/gurdeeposa1856.png')}}">
            </div>
            <div class="col-sm-7 text wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                <h1>Get it now!</h1>
                <div class="description">
                  Download our application now and earn reward points on registration!<br/>
You can use your reward points for paying your everyday grocery.
                </div>                    
            <div class="vendors">
                <a href="https://apps.apple.com/us/app/app-grocery/id1493253318?ls=1"><span class="fa fa-apple"></span></a>
                <a href="https://play.google.com/store/apps/details?id=com.grocery.hero"><span class="fa fa-android"></span></a>        
            </div>
            </div>
        </div>
    </div>
</div>

<!-- end of download section -->

<div class="clearfix"></div>
<div class="container text-center  hover-effect m-20">
    <div class="section-md bg-image bg-image-9">
        <div class="row">
            <div class="col-sm-12 col-md-7">
                <div class="inset-1">
                  <h1 class="heading-decorative"> Earn reward points when you referral your friend to the app.</h1>
                  <p class="big">Earn extra cash money when your friend complete a successful bill transaction.</p>
                  <h1 class="heading-decorative"> Your friend can earn reward points on downloading the app</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection