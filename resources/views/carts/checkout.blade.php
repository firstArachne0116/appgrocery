@extends('layouts.app')
@section('content')
<style>
  .box{
    border:1px solid #bfbfbf;
    padding: 15px;
    border-radius:2px;
    margin-bottom:10px;
  }
.box label {
  margin-bottom: 0px;
}
.box p{
  color: #807e7e;
  font-size: 15px;
  font-weight:500;
}
</style>
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb2">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class="breadcrumb-item">Checkout</li>
    </ol>
  </nav>
  <div class="row mb-5">
    <div class="col-12 col-xl-8">
      <h5 class="font-weight-bold">Billing details</h5>
      <div class="row">
      <div class="col-md-12">
          <div class="form-group">
            <label for="honorific">Honorific</label><br/>
            <div class="form-check-inline">
              <label class="form-check-label" for="check1">
                <input type="radio" class="form-check-input" id="honorific" name="honorific" value="Mr." checked>Mr.
              </label>
            </div>
            <div class="form-check-inline">
              <label class="form-check-label" for="check2">
                <input type="radio" class="form-check-input" id="honorific" name="honorific" value="Mrs.">Mrs.
              </label>
            </div>
            <div class="form-check-inline">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" id="honorific" name="honorific" value="Miss">Miss
              </label>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="email">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="" />
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="email">Flat/House No./Office No.</label>
            <input type="text" name="house_address" id="house_address" class="form-control" value="" />
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="email">Street / Society / Office Name</label>
            <input type="text" name="area_address" id="area_address" class="form-control" value="" />
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="email">Locality</label>
            <input type="text" name="locality_address" id="locality_address" class="form-control" value="">
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="email">Nickname </label>
            <input type="text" name="nickname" id="nickname" class="form-control" value="">
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <input type="submit" name="address_add" class="btn btn-primary" value="Add" onclick="add_address()" style="width:200px;float:right;">
          </div>
        </div>
            
        <div class="col-md-12">
          <div class="clearfix"></div>
          <hr>
          <div class="clearfix"></div>
        </div>
      <form name="checkoutform" id="checkoutform" method="post" action="{{ route('placeorder') }}" style="width:100%;">
        @csrf
        <!-- address list -->
        <div class="container" >
          <div class="row">            
          @if($addressdata)
          @foreach($addressdata as $addressk => $addressv)
          <div class="col-md-5">
            <div class="box mb_50">
                <input type="radio" required name="order_address_id" id="order_address_id<?php echo $addressv['id']; ?>" value="{{ $addressv['id'] }}" />
              <h6 class="text-uppercase font-weight-bold">{{ $addressv['addressname'] }}</h6>              
              <label>{{ $addressv['name'] }}</label>
              <p>{{ $addressv['houseno'] }}</p>
              <p>{{ $addressv['society'] }}</p>
              <p>{{ $addressv['locality'] }}</p>
              <div class="text-center ">
                <!--<button name="order_address_select" class="btn btn-primary" onclick="select_address('<?php echo $addressv['id']; ?>')" required>Delivery Here</button> -->
              </div>
            </div>
          </div>
          @endforeach
          @endif          
          </div>
        </div>
      <!-- address list -->      
        <div class="col-md-12">
          <textarea  class="input-text form-control input-lg" name="order_comments" id="order_comments" placeholder="Notes about your order, eg. special instructions for delivery." rows="3" cols="4"></textarea>
        </div>
      </div>      
    </div>
    <div class="col-12 col-xl-4">
      <div class="cart_totals">
        <div class="table-responsive">
          <table cellspacing="0" class="table table-borderless mb-0">
            <tbody>
              <tr>
                <th>Amount Payable</th>
              <th class="text-right">{{ $payable_amount.' '. session('currency_symbol') }}</th>
              </tr>              
            </tbody>
          </table>
          <div class="ul-css m-0">
            <ul class="m-0 ml-3">              
              
              <li>
                <input  type="radio" class="input-radio" value="cod" name="payment_method" required data-order_button_text="">
                <label for="payment_method_cheque">Cash on delivery</label>
              </li>
              <li>
                <p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="#" target="_blank">privacy policy</a>.</p>
              </li>
              
              @if($addressdata)
                <li> <input type="submit" value="Place Order" class="btn cart w-100" /></li>
              @else
                <li> <input type="button" value="Place Order" class="btn cart w-100" onclick="alert('Please add an address');"/></li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>
  </form>
  </div>
</div>
</div>
</div>
<div class="clearfix"></div>
</div>
@endsection
