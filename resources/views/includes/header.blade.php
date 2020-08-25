<div class="top-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-md-12 top-div top1">
        <ul>
          <li><a href="mailto:hello@appgrocery.com"><i class="fa fa-envelope"></i> &nbsp;hello@appgrocery.com</a></li>
          <li>|</li>
          <li><i class="fa fa-phone" aria-hidden="true"></i> +971 600562622</li>
        </ul>
      </div>
      <div class="col-lg-7 col-md-6 col-md-12 position-relative">
        <div class="right-div">
          <ul>            
            <li>
              <ul class="top-ul">
                <li>
                  <div class="dropdown"> <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                    <img src="{{ asset('/images/flag.jpg') }}" alt="" title=""> Choose Language <i class="fa fa-angle-down"></i></a>
                    <div class="dropdown-menu flag-css dropdown-menu-right"> <a href="{{route('common.changelanguage',['id'=> 1])}}">EN/USA</a>
                       <a href="{{route('common.changelanguage',['id' => 2])}}"><span class="flag-icon flag-icon-fr"> 
                    </span>AR/UAE</a> </div>
                  </div>
                </li>
                <li>
                  <div class="dropdown"> <a href="#" class="btn"   data-src="#popup-select-country"  data-fancybox="gallery">
                    <?php
                    $countrydata = App\Country::where(['id' => '229'])->get()->toArray();                    
                      if($countrydata[0]) {
                          echo $countrydata[0]['sortname'];                          
                      }
                      $supermarkets = App\Supermarket::where(['status' => '1', 'country_id' => '229'])->get()->toArray();                      
                      if($supermarkets) { session(['supermarket_id' => $supermarkets[0]['id']]); }

                      if(Auth::check()) {
                            $cartcount = $wishcount = 0;
                            $user_id = Auth::user()->id;         
                            $wishcount = App\Wishlist::wishcount($user_id);
                            session(['wishcount' => $wishcount]);
                            $cartcount = App\Persistantcart::where('user_id',$user_id)->count();
                            $cart_info = App\Persistantcart::where('user_id',$user_id)->orderBy('created_at')->get();
                            //echo json_encode($cartcount); exit();
                            session(['cartcount' => $cartcount]);
                            session(['cartinfo' => $cart_info]);
                        }
						$cities=App\City::orderBy('name','asc')->get();
                    ?>
                  </a>
                  </div>
                </li>
              </ul>
            </li>
            <li>
              <div class="rate-price rate-price2">
                <ul>
                  <li class="dropdown"> <a class="dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
                    <div class="dropdown-menu dropdown-menu-right animate slideIn"> 
                      @if (Auth::user())
                      <a class="dropdown-item" href="my-account.html">My Account</a> 
                      @else
                      <a class="dropdown-item" href="{{ route('login') }}">Login</a> 
                      <a class="dropdown-item" href="register.html">Register</a>
                      <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>    
                      @endif
                    </div> 
                  </li>
                  @if (Auth::user())
                  <li> 
                      <a href="{{route('wishlist.index')}}"><i class="fa fa-heart-o" aria-hidden="true"></i>                        
                        @if(session('wishcount') > '0')  <span class="circle-2"> {{ session('wishcount') }} </span> @endif </a>
                  </li>
                 
                  <li class="dropdown"> <a class="dropdown-toggle link" href="#" data-toggle="dropdown">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    @if(session('cartcount'))<span class="circle-2">
                     {{ session('cartcount') }}</span>  @endif</a>
                    <div class="dropdown-menu dropdown-menu2 dropdown-menu-right animate slideIn">
                      <div class="container">
                        <div class="row">
                          <?php $cart_info = session('cartinfo'); ?>
                          @if ($cart_info)
                          @foreach($cart_info as $item)
                          <?php $link = session('constant_url') . session('product_image_path'). '/'.$item->image_path; ?>
                        <div class="col-md-3"><img src="{{$link}}" alt="" title="" class="img-fluid"></div>
                          <div class="col-md-9">
                          <p>{{$item->quantity. 'x '. $item->name }} <span class="price">
                          <?php echo html_entity_decode(session('currency_symbol'))?>{{$item->discount_price}}</span></p>
                            <a href="#" class="close">x</a> </div>
                          <div class="col-md-12">
                            <hr>
                          </div>
                          @endforeach 
                          @endif                                                     
                        </div>
                        <div class="col-md-12 text-center">
                        <a type="button" href="{{route('cart')}}" class="btn check-out w-100">Check Out</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  </li>
                  @endif
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="popup-select-country" class="popup-fcy" style="padding:35px!important;">
  <div class="row">
  <form method="POST" action="{{route('common.change')}}">
    @csrf
        <div class="col-md-12"> 
            <h4>Please Select </h4>
          <div class="form-check cart-list">
                <label>Country</label><br />
                  <select id="country_id" name="country_id">                    
                    <option value="229">United Arab Emirates</option>
                  </select>
          </div>
          <div class="form-check cart-list">
                <label>City</label><br />
                  <select id="city_id" name="city_id">
                    <option>Choose City </option>
					 @if(count($cities)>0)
						 @foreach($cities as $city)
                       <option value="{{$city->id}}">{{$city->name}}</option>
				    	@endforeach
				   @endif
                  </select>
          </div>   
          <div class="form-check cart-list">
                <label>Area</label><br />
                  <select id="area_id" name="area_id">
                    <option>Choose Area </option>
                  </select>
          </div>         
      <div class="col-md-12"> <button class="btn btn-block cart mb-1 mt-1" value="Submit">Submit </button> </div>
    </form>
    
    </div>
  </div>
</div>