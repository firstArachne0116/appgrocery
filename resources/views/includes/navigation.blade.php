<nav class="navbar navbar-expand-lg navbar-dark bg-white">
  <div class="container"> <a class="navbar-brand" href="{{ route('home') }}"> <img src="{{ asset('/images/logo.png') }}" alt="" title="" class="img-fluid"> </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" 
    aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> 
    <span class="navbar-toggler-icon"></span> <span class="navbar-toggler-icon"></span> </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav">
        <li class="nav-item nav-item11"> <a class="" href="{{ route('home') }}"> Home </a></li>
        <li class="nav-item nav-item11"> <a class="nav-link11 dropdown-toggle" href="/#featured-products"> Nearby Supermarkets</a> </li>
        <!--<li class="nav-item dropdown megamenu-li"> <a class="nav-link dropdown-toggle" href="#" id="Dropdown2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Category </a>
          <div class="dropdown-menu megamenu animate slideIn" aria-labelledby="navbarDropdownBlog">
            <div class="row">
              <?php $catdata = array(); //$catdata = App\category::where(['status' => '1', 'parentid' => '0'])->get()->toArray();  ?>
              @if($catdata)
              @foreach($catdata as $cat)  
               <?php $subcatdata = App\category::where(['status' => '1', 'parentid' => $cat['id']])->get()->toArray(); ?>
              <div class="col-sm-6 col-lg-3">
                @if (session('name'))
                  <h5>{{ $cat[session('name')] }}</h5>
                @else
                <h5>{{ $cat['name'] }}</h5>
                @endif
                    @if($subcatdata)
                    @foreach($subcatdata as $subct)
                    @if (session('name'))
                    <a class="dropdown-item" href="{{route('subcategories',['sid' => session('supermarket_id'),
                        'cid' => $cat['id'] ])}}">{{ $subct[session('name')] }}</a> 
                    @else
                    <a class="dropdown-item" href="{{route('subcategories',['sid' => session('supermarket_id'),
                        'cid' => $cat['id'] ])}}">{{ $subct['name'] }}</a> 
                    @endif
                    @endforeach
                    @endif
              </div>
              @endforeach
              @endif
              <div class="clearfix"></div>
            </div>
          </div>
        </li>       -->
      </ul>
      <div class="rate-price nav-1">
        <ul>
          <li><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo session('location_addressname'); ?></a></li>
          <li class="dropdown"> <a class="dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
            <div class="dropdown-menu dropdown-menu-right animate slideIn"> 
                @if (Auth::user())
                <a class="dropdown-item" href="{{route('user.index')}}">My Account</a> 
                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>                   
                @else
                <a class="dropdown-item" href="{{ route('login') }}">Login</a> 
                <a class="dropdown-item" href="{{route('register')}}">Register</a>
                <a class="dropdown-item" href="{{route('password.request')}}">Forgot Password</a>    
                @endif
              </div> 
          </li>
          @if (Auth::user())
          <li> 
              <a href="{{route('wishlist.index')}}"><i class="fa fa-heart-o" aria-hidden="true"></i>
                @if(session('wishcount')) <span class="circle-2"> {{ session('wishcount') }} </span>@endif</a>
          </li>
          
          <li class="dropdown"> <a class="dropdown-toggle link" href="#" data-toggle="dropdown">
          <i class="fa fa-shopping-cart" aria-hidden="true"></i>
          @if(session('cartcount')) <span class="circle-2">
           {{ session('cartcount') }}</span> @endif</a>
            <div class="dropdown-menu dropdown-menu2 dropdown-menu-right animate slideIn">
              <div class="container">
                <div class="row">
                  <?php $cart_info = session('cartinfo'); ?>
                  @if ($cart_info)
                  @foreach($cart_info as $item)
                  <?php $link = session('constant_url') . session('product_image_path'). '/'.$item->image_path; ?>
                <div class="col-md-3"><img src="{{$link}}" alt="" title="" class="img-fluid"></div>
                  <div class="col-md-9">
                  <p>{{ $item->quantity. 'x '. $item->name }} <span class="price">
                  <?php echo html_entity_decode(session('currency_symbol'))?>{{$item->discount_price}}</span></p>
                    </div>
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
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</nav>  