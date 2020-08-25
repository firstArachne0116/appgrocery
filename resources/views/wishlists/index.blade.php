@extends('layouts.app')
@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb2 breadcrumb">
        <li class="breadcrumb-item"><a href="home"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
        <li class="breadcrumb-item">Wishlist</li>
      </ol>
    </nav>
    <div class="row">
      <div class="col-lg-12 mt-4">
        <div class="table-responsive wishlist-table">
          <table class="table wishlist-table">
            <thead class="title-h">
              <tr>
                <th align="left" valign="top"></th>
                <th colspan="2"  class="product-price">Product Detail</th>
                <th class="product-subtotal text-center unit-price"><p>Unit Price</p></th>
                <th class="text-center product-add-date"><p>Date Added</p></th>
                <th class="text-center add-to-3-th"> <p>Stock Status</p> </th>
                <th class="add-to-cart-th"><p>Action</p></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($wishlists as $wishlist)
                <tr>  
                    <?php $imgs = json_decode($wishlist->product_image); $link1 = session('constant_url') . session('product_image_path'). '/'.$imgs[0];?>
                    <td align="left"></td>
                        <td class="product-thumbnail"><a href="#">
                          <img  width="100" src="{{$link1}}" class="" alt=""></a></td>
                        <td  class="product-name"><p><a href="#">{{$wishlist->product_name}}</a></p>
                          {{-- <span>Color: Black</span> <span>Size: 40</span></td> --}}
                        <td class="text-center unit-price"><p>{{$wishlist->product_price.' '. session('currency_symbol') }}</p></td>
                        <td class="text-center product-add-date"><p>{{$wishlist->added_on}}</p></td>
                        <td class="text-center"><a href="#" class="green">
                          @if ($wishlist->product_stock > 0)
                          <p> &nbsp;&nbsp;
                            <img src="{{ asset('images/available.png') }}" alt="" title="" > In Stock</p>
                          @else
                          <p> &nbsp;&nbsp;
                            <img src="{{ asset('images/out-of-stock.png') }}" alt="" title="" > Out of Stock</p>
                          @endif
                          
                        
                        </td>
                        <form id="wishlist-form" action="{{ route('wishlist.destroy',$wishlist->wishlist_id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <td class="text-center">

                            {{-- <a href="{{route('wishlist.destroy',$wishlist->wishlist_id)}}" 
                            onclick="event.preventDefault();
                                document.getElementById('wishlist-form').submit();">
                                <i class="fa fa-trash"></i></a> --}}
                                <a href="{{route('wishlist.destroy',$wishlist->wishlist_id)}}"
                                    onclick="event.preventDefault();
                                    document.getElementById('wishlist-form').submit();"  class="add-to-cart" style="color: black;">
                                    <i class="fa fa-trash"></i><span class="hidden-xs">&nbsp; Remove</span></a>  


                          <form name="cartform" id="wishcartform" action="{{ route('addtocart') }}" method="post">
                            @csrf
                          <input type="hidden" name="product_id" id="product_id" value="{{ $wishlist->product_id }}" />
                          <input type="hidden" name="productconfig_id" id="productconfig_id" value="{{ $wishlist->productconfig_id }}" />
                          <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
                          <input type="hidden" name="name" id="name" value="{{ $wishlist->product_name }}" />
                          <input type="hidden" name="description" id="description" value="{{ $wishlist->product_description }}" />
                          <input type="hidden" name="image_path" id="image_path" value="{{ $imgs[0] }}" />
                          <input type="hidden" name="price" id="price" value="{{ $wishlist->product_price }}" />
                          <input type="hidden" name="discountedprice" id="discountedprice" value="{{ $wishlist->product_discount_price }}" />
                          <input type="hidden" name="quantity" id="quantity" value="1" />
                          <input type="hidden" name="maxquantity" id="maxquantity" value="{{ $wishlist->product_stock }}" />
                          <input type="hidden" name="unit" id="unit" value="{{ $wishlist->unit }}" />
                          <input type="hidden" name="market" id="market" value="{{ $wishlist->supermarket_id }}" />                          
                        </form> 
                        
                        <a {{route('addtocart')}}" onclick="event.preventDefault();
                                  document.getElementById('wishcartform').submit();" class="add-to-cart"><i class="fa fa-shopping-cart"></i>
                                  <span class="hidden-xs">&nbsp; Add To Cart</span></a>
                        </td>
                            
                      </tr> 
                @endforeach
             
{{--               
              <tr>
                <td colspan="7" class="text-right"><input value="Add Selected to Cart" class="add-to-select" type="button">
                <input value="Add All to Cart" type="button" class="add-to-select">              </td>
              </tr> --}}
              <tr>
                <td colspan="7"><ul class="share-link">
                    <li><span>Share</span></li>
                    <li><a href="#" class="icoRss" title=""><i class="fa fa-rss"></i></a></li>
                    <li><a href="#" class="icoFacebook" title=""><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#" class="icoTwitter" title=""><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#" class="icoGoogle" title=""><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#" class="icoLinkedin" title=""><i class="fa fa-linkedin"></i></a></li>
                  </ul></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection