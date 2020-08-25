@extends('layouts.app')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb2">
        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
        <li class="breadcrumb-item">My Account</li>
      </ol>
    </nav>
</div>
<div class="container">
    <div class="account-dashboard">
      <div class="dashboard-upper-info">
        <div class="row align-items-center justify-content-center">
          <div class="col-lg-3 col-md-6">
            <div class="d-single-info">
              <div class="row">
                <div class="col-md-3"><img src="{{asset('images/logout.png')}}" alt="" title="" class="img-fluid"></div>
                <div class="col-md-9">
                <p class="user-name"><span class="text-danger">{{$user->email}}</span></p>
                  <p>not your Account? <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="d-single-info">
              <div class="row">
                <div class="col-md-3"><img src="{{asset('images/support.png')}}" alt="" title="" class="img-fluid"></div>
                <div class="col-md-9">
                  <p>Need Assistance? <br>
                    Customer service at</p>
                  <p><a href="mailto:hello@appgrocery.com">hello@appgrocery.com</a></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="d-single-info">
              <div class="row">
                <div class="col-md-3"><img src="{{asset('images/email.png')}}" alt="" title="" class="img-fluid"></div>
                <div class="col-md-9">
                  <p>Reach us at </p>
                  <p><a href="mailto:hello@appgrocery.com">hello@appgrocery.com</a></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="d-single-info border-0">
              <div class="row">
              <div class="col-md-12"><a href="{{route('cart')}}" class="view-cart"><i class="fa fa-cart-plus"></i>view cart </a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 col-lg-2">
          <!-- Nav tabs -->
          <ul role="tablist" class="nav flex-column dashboard-list">
            <li><a href="#account-details" data-toggle="tab" class="active" >Account details</a></li>
          <li><a href="{{route('changepassword')}}">Password Management</a></li>
            <li> <a href="#orders" data-toggle="tab">Orders</a></li>
            <li><a href="#address" data-toggle="tab">Addresses</a></li>
            <li><a href="#credits" data-toggle="tab">Reward Points</a></li>
            <li><a href="#cashcredits" data-toggle="tab">Cash Credits</a></li>
            <li><a href="{{route('weeklylist.index')}}">Weekly List</a></li>
          <li><a href="{{route('lottery.index')}}">Tickets</a></li>
          </ul>
        </div>
        <div class="col-md-12 col-lg-10">
          <!-- Tab panes -->
          <div class="tab-content dashboard-content">
                <div class="tab-pane active" id="account-details">
                        <h3>Account details </h3>
                        <div class="login m-0">
                          <div class="login-form-container">
                            <div class="account-login-form">
                             
                                    @if (!Auth::check())
                                    <p>Already have an account ? <a  onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                               {{ __('Logout') }} Log out here
                           </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                              </form>
                              </p>  
                                    @endif
                                    @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                      <p>{{ $message }}</p>
                                    </div>
                                    @endif
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
                            <form action="{{route('user.update',$user->id)}}" method="POST">
                              @csrf
                              @method('PUT')
                                <div class="account-input-box">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <label>Name</label>
                                        <input type="text" name="name" value="{{$user->name}}" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                      <label>Email</label>
                                      <input type="text" name="email" value={{$user->email}} class="form-control" readonly>
                                    </div>
                                    <div class="col-md-12">
                                      <label>Mobile</label>
                                      <input type="text" name="mobile" value={{$user->mobile}} class="form-control">
                                    </div>
                                    {{-- <div class="col-md-6">
                                      <label>Credits</label>
                                      <input type="number" name="credits" class="form-control">
                                    </div> --}}
                                  </div>
                                </div>
                                <div class="button-box">
                                  <button class="btn default-btn" type="submit">Save</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
            <div class="tab-pane fade" id="orders">
              <h3>Orders</h3>
              <div class="table-responsive">
                <table class="table boder-b">
                  <thead>
                    <tr>
                      <th>Order</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Total</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($orders as $order)
                          <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>{{App\Constant::find($order->order_status)->data}}</td>
                            <td>{{$order->subtotal}} <?php echo session('currency_symbol'); ?></td>
                          <td><a href="{{route('order.show',['id' => $order->id])}}" class="view">View</a></td>
                          </tr> 
                      @endforeach
                   
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="credits">
              <h3>Reward Points</h3>
              <div class="container text-center  hover-effect m-20">
                    <div class="section-md bg-image bg-image-9">
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                <div class="inset-1">
                                  <h1 class="heading-decorative">Your present reward points is {{Auth::user()->credits .' '. session('currency_symbol') }} </h1>
                                  <h1 class="heading-decorative"> You can earn reward points when you referral your friend to the App</h1>
                                  <p class="big">Earn extra cash money when your friend complete a successful bill transaction</p>
                                  <h1 class="heading-decorative"> Your friend can earn reward points on downloading the App</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="cashcredits">
                <h3>Cash Credits</h3>
                <div class="container text-center  hover-effect m-20">
                      <div class="section-md bg-image bg-image-9">
                          <div class="row">
                              <div class="col-sm-12 col-md-7">
                                  <div class="inset-1">
                                    <h1 class="heading-decorative">Your present Cash Money is {{ Auth::user()->cash_credits ? Auth::user()->cash_credits : 0  }} {{ session('currency_symbol') }} </h1>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
            </div>
            <div class="tab-pane" id="address">
              {{-- <p>The following addresses will be used on the checkout page by default.</p> --}}
              <h4 class="billing-address">Billing address</h4>
              <div class="row">
                  @foreach ($addresses as $address)
                  <div class="col-md-4">
                        <div class="address-1">
                        <p class="biller-name"><strong>{{ $address->honorific.' '.$address->  name}}</strong></p>
                          <address>
                          <small>{{$address->addressname}}
                          {{$address->city?$address->city->name:''}}<br>
                          {{'Phone: '.$address->mobile}}</small>
                          </address>
                          <form id="address-form" action="{{ route('address.destroy',$address->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                    </form> 
                          <a href={{route('address.destroy',$address->id)}}  onclick="event.preventDefault();
                          document.getElementById('address-form').submit();"><i class="fa fa-trash"></i></a>  
                        </div>
                  </div> 
                  @endforeach
           
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
    
@endsection