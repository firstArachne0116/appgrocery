@extends('layouts.app')
@section('content')
<div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb2">
          <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li class="breadcrumb-item">Weekly Product List</li>
          </ol>
      </nav>
        <div class="row">
          <div class="col-12 col-xl-12 mb-4">
            <div class="table-responsive wishlist-table">
              <table class="table wishlist-table">
                <thead>
                  <tr>
                    <th class="text-center">Image</th>
                    <th class="text-center">Product Name</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Action</th>
                   
                  </tr>
                </thead>
                <tbody>
                    @foreach ($weeklylists as $weeklylist)
                    <tr>
                        <?php $imgs = json_decode($weeklylist->product_image); $link1 = session('constant_url') . session('product_image_path'). '/'.$imgs[0];?>
                    <td  class="product-thumbnail text-center"><a href="#"><img  src="{{$link1}}" class="" alt=""></a></td>
                            <td><div class="cart-detail text-center">{{$weeklylist->product_name}}</div></td>
                                 <td class="text-center"><div style="width:80px;margin: auto;">{{$weeklylist->product_price.' '. session('currency_symbol')}} </div></td>
                          
                            <td class="text-center">

                                <form name="cartform" id="weeklycartform" action="{{ route('addtocart') }}" method="post">
                                    @csrf
                                  <input type="hidden" name="product_id" id="product_id" value="{{ $weeklylist->product_id }}" />
                                  <input type="hidden" name="productconfig_id" id="productconfig_id" value="{{ $weeklylist->productconfig_id }}" />
                                  <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
                                  <input type="hidden" name="name" id="name" value="{{ $weeklylist->product_name }}" />
                                  <input type="hidden" name="description" id="description" value="{{ $weeklylist->product_description }}" />
                                  <input type="hidden" name="image_path" id="image_path" value="{{ $imgs[0] }}" />
                                  <input type="hidden" name="price" id="price" value="{{ $weeklylist->product_price }}" />
                                  <input type="hidden" name="discountedprice" id="discountedprice" value="{{ $weeklylist->product_discount_price }}" />
                                  <input type="hidden" name="quantity" id="quantity" value="1" />
                                  <input type="hidden" name="maxquantity" id="maxquantity" value="{{ $weeklylist->product_stock }}" />
                                  <input type="hidden" name="unit" id="unit" value="{{ $weeklylist->unit }}" />
                                  <input type="hidden" name="market" id="market" value="{{ $weeklylist->supermarket_id }}" />                                  
                                </form>

                                <a {{route('addtocart')}}" onclick="event.preventDefault();
                                  document.getElementById('weeklycartform').submit();" 
                                  class="add-to-cart"><i class="fa fa-shopping-cart"></i><span class="hidden-xs">&nbsp; Add To Cart</span></a>
                                <form id="weeklylist-form" action="{{ route('weeklylist.destroy',$weeklylist->list_id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                </form> 
                                <a href="{{route('weeklylist.destroy',$weeklylist->list_id)}}"
                                onclick="event.preventDefault();
                                document.getElementById('weeklylist-form').submit();" class="add-to-cart">
                                <i class="fa fa-trash"></i><span class="hidden-xs">&nbsp; Remove</span></a>                                                                                                                         
                              </td>
                          </tr> 
                    @endforeach
             
                  <tr>
                    <td colspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="coupon">
                        <tbody>
                        
      
                        </tbody>
                      </table></td>
                  </tr>
      
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
@endsection