@extends('layouts.app')
@section('content')
<?php //echo '<pre/>'; print_r($cartdata); exit; ?>
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb2">
      <li class="breadcrumb-item"><a href="/"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class="breadcrumb-item">Cart</li>
    </ol>
  </nav>
  <div class="row">     
    <div class="col-12 col-xl-8 mb-4">   
        @if(Session::has('message'))
        <p class="alert alert-info">{{ Session::get('message') }}</p>
        @endif 
      <div class="table-responsive cart-table table-borderless">
        <table class="table">
          <thead>
            <tr>
              <th class="text-center">Product</th>
              <th class="text-center">&nbsp;</th>
              <th class="text-center">Price</th>
              <th class="text-center">Quantity</th>
              <th>Total</th>
              <th> </th>
            </tr>
          </thead>
          <tbody>          
          <?php $total = 0; $allquantity = 0; $discountamount = 0; static $discounttotal = 0; static $subtotal = 0; ?>
          <form name="cartform" id="cartform" method="post" action="{{ route('updatecart') }}">
          @csrf
        @if($cartdata)
        @foreach($cartdata as $cartk => $cartv)          
         <?php 
        $productids[]       =  $cartv->product_id;
        $productconfigids[] =  $cartv->productconfig_id;
        $total = round(($cartv->discount_price * $cartv->quantity) * 10000) / 10000;
         $mrptotal = ($cartv->price * $cartv->quantity); 
         $subtotal = $subtotal+$mrptotal;
         $discountamount =  ($cartv->price - $cartv->discount_price)* ($cartv->quantity);  
         $discounttotal  = $discounttotal+$discountamount;
          
         $allquantity = $allquantity+ ($cartv->quantity);  ?>
        <?php $link = session('constant_url') . session('product_image_path'). '/'.$cartv->image_path; ?>
          <tr>
              <td class="product-thumbnail text-center"><a href="#"><img  src="{{ $link }}" class="" alt=""></a></td>
              <td><div class="cart-detail">{{ $cartv->name }}</div></td>
              <td class="text-center"><div style="width:80px"><strike>{{ $cartv->price }}</strike>&nbsp&nbsp {{ $cartv->discount_price .' '. session('currency_symbol') }}</div></td>
              <td class="product-quantity" data-title="Quantity">
                <center>                    
                    <div class="stepper-widget">
                        <button type="button" class="btn btn-default btn-number" {{$cartv->quantity == 1 ? "disabled" : ""}} data-type="minus" data-field="cartquant<?php echo $cartv->id; ?>"> <i class="fa fa-minus"></i> </button>
                        <input type="text" name="cartquant<?php echo $cartv->id; ?>" class="input-number" value="{{ $cartv->quantity }}" min="1" max="{{ $cartv->maxquantity }}">
                        <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="cartquant<?php echo $cartv->id; ?>"><i class="fa fa-plus"></i> </button>                      
                      </div> 
                </center>
              </td>
              <td><div style="width:100px">{{ $total .' '. session('currency_symbol') }}</td>                
              <td>                
                <a href="{{route('cartdelete', ['cartid' => $cartv->id])}}"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
          </tr>
          @endforeach
          @endif
           </form>                     
          <tr>
            <td colspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="coupon">
                <tbody>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col-md-6 pr-0">
                            <a href="#" class="btn cart mb-1 mt-1" value="Apply coupon"  data-src="#popup-3"  data-fancybox="gallery">Apply coupon</a>
                        </div>
                        <div class="col-md-6"> 
                          <a href="#" class="btn cart mb-1 mt-1" value="Apply earn points"  data-src="#popup-4"  data-fancybox="gallery">Apply Earn Points</a> 
                        </div>
                      </div>
                    </td>
                    <td>&nbsp;</td>
                    <td valign="top" class="text-right"><a id="updatecartbtn" class="btn cart" value="Update cart">Update cart</a></td>
                  </tr>
                </tbody>
              </table></td>
          </tr>
          <tr>
              <td colspan="2"><p class="alert alert-info" id="couponerror" style="display:none;">This coupon is not valid.</p></td>  
           </tr> 
          </tbody>
        </table>
      </div>
    </div>
<!--apply coupon popup -->
<?php if($subtotal > $market_delivery_amount) { $deliverycharge = 0; } else { $deliverycharge = $market_delivery_charge; } ?>
    <div class="col-12 col-xl-4 mb-5" id="cart_total_sum">
      <div class="cart_totals">
        <div class="table-responsive">
          <table cellspacing="0" class="table table-borderless mb-0">
            <tbody>
              <tr class="cart-subtotal">
                <td>Sub Total</td>
                <td class="text-right" id="cart_subtotal">{{ $subtotal }}                  
                </td><td><input type="hidden" name="input_cart_subtotal" id="input_cart_subtotal" value="{{ $subtotal }}" />{{session('currency_symbol')}}</td>
              </tr>
              <tr class="shipping">
                <td colspan="2" align="left" class="mb-0 pb-0"><h5 class="m-0 p-0">Amount Breakup:</h5></td>
              </tr>
              <tr>
                <td class="flat-rate"><h5>Total Quantity:</h5></td>
                <td class="text-right amount" id="cart_quantity">{{ $allquantity }}
                  <input type="hidden" name="input_cart_quantity" id="input_cart_quantity" value="{{ $allquantity }}" />
                </td>
              </tr>
              <tr>
                <td class="flat-rate"><h5>Product Discount:</h5></td>
                <td class="text-right amount" id="cart_discount">{{ $discounttotal }}                  
                </td><td><input type="hidden" name="input_cart_discount" id="input_cart_discount" value="{{ $discounttotal }}" />{{session('currency_symbol')}}</td>
              </tr>
              <tr>
                <td class="flat-rate"><h5>Coupon Discount:</h5></td>
              <td class="text-right amount" id="cart_coupon_discount">0                  
                </td><td><input type="hidden" name="input_cart_coupon_discount" id="input_cart_coupon_discount" value="0" /> {{session('currency_symbol')}}</td>               
              </tr>
              <tr>
                <td class="flat-rate"><h5>Reward Points Discount:</h5></td>
              <td class="text-right amount" id="cart_reward_discount">0                  
                </td><td><input type="hidden" name="input_cart_reward_discount" id="input_cart_reward_discount" value="0" />{{session('currency_symbol')}}</td>
              </tr>
              <tr>
                <td class="flat-rate"><h5>Delivery Charge:</h5></td>
                <td class="text-right amount" id="cart_delivery_charge">{{ $deliverycharge }}                  
                </td><td><input type="hidden" name="input_cart_delivery_charge" id="input_cart_delivery_charge" value="{{ $deliverycharge }}" />{{session('currency_symbol')}}</td>
              </tr>
              <tr>
                <td class="flat-rate"><h5>Service Charge:</h5></td>
                <td class="text-right amount" id="cart_service_charge">{{ $market_service_charge }}                  
                </td><td><input type="hidden" name="input_cart_service_charge" id="input_cart_service_charge" value="{{ $market_service_charge }}" />{{session('currency_symbol')}}</td>
              </tr>
              <tr class="order-total">
                <td><h5>Total</h5></td>
              <td align="right" id="final_cart_total"></td><td>{{ session('currency_symbol') }}</td>
                <input type="hidden" name="input_final_cart_total" id="input_final_cart_total" value="" />
              </tr>
            </tbody>
          </table>
          <form name="proceedcheckoutform" id="proceedcheckoutform" method="post" action="{{ route('proceedtocheckout') }}" >  
            @csrf        
            <input type="hidden" name="applied_coupon_id" id="applied_coupon_id" value="" />
            <input type="hidden" name="applied_earned_points" id="applied_earned_points" value="" />
            <input type="submit" value="Proceed to Checkout" class="btn cart w-100" id="proceedcheckout" /> </div>
          </form>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<?php //echo '<pre/>'; print_r($coupons); exit; ?>

 <!-- coupons --> 
<div id="popup-3" class="popup-fcy">
  <div class="row">
    <div class="col-md-12"> 
      <h4>Your Offers </h4>      
        <div class="form-check cart-list">
              <input type="text" name="couponcode" id="couponcode"  value=""> <span class="label-text">               
        </div>
        <div class="col-md-12"> <a href="#" class="btn btn-block cart mb-1 mt-1" onclick="applycoupon()" value="Apply coupon">Apply </a> </div>
    </div>
  </div>
</div>

<!-- reward points -->
<div id="popup-4"  class="popup-fcy">
  <div class="row">
    <div class="col-md-10"> 
      <h4>You have earned </h4>
      <h2><?php echo $userrewards; ?> Points</h2>
    </div>   
  </div>
  <div class="row">
      <div class="col-md-12 pr-0">
        <input type="hidden" name="maxrewards" id="maxrewards" value="<?php echo $userrewards; ?>" />
        <input type="number" name="reward_points" class="input-text form-control coupon_code mb-1 mt-1" id="reward_points" value="" placeholder="Coupon code" max="<?php echo $userrewards; ?>" min= "0">
      </div>
      <div class="col-md-12"> <a href="#" id="applyreward" onclick="applyrewards()" class="btn btn-block cart mb-1 mt-1" value="Apply Rewards">Apply </a> </div>
  </div>
</div>

@endsection


