@extends('layouts.app')
@section('content')
<style type="text/css">
  
    .shop-tracking-status .order-status{margin-top:80px;position:relative;margin-bottom:150px}
    .shop-tracking-status .order-status-timeline{height:12px;border:1px solid #0d2765;border-radius:7px;background:#eee;box-shadow:0px 0px 5px 0px #C2C2C2 inset}.shop-tracking-status .order-status-timeline .order-status-timeline-completion{height:8px;margin:1px;border-radius:7px;background:#f4ef55;width:0px}
    .shop-tracking-status .order-status-timeline .order-status-timeline-completion.c1{width:22%}
    .shop-tracking-status .order-status-timeline .order-status-timeline-completion.c2{width:46%}
    .shop-tracking-status .order-status-timeline .order-status-timeline-completion.c3{width:70%}
    .shop-tracking-status .order-status-timeline .order-status-timeline-completion.c4{width:100%}
    .shop-tracking-status .image-order-status{border:1px solid #ddd;padding:7px;box-shadow:0px 0px 10px 0px #999;background-color:#fdfdfd;position:absolute;margin-top:-35px;border-radius: 50px;}
    .shop-tracking-status .image-order-status.disabled{filter:url("data:image/svg+xml;utf8,<svg%20xmlns='http://www.w3.org/2000/svg'><filter%20id='grayscale'><feColorMatrix%20type='matrix'%20values='0.3333%200.3333%200.3333%200%200%200.3333%200.3333%200.3333%200%200%200.3333%200.3333%200.3333%200%200%200%200%200%201%200'/></filter></svg>#grayscale");filter:grayscale(100%);-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);filter:gray;}
    .shop-tracking-status .image-order-status.active{}.shop-tracking-status .image-order-status.active .status{}
    .shop-tracking-status .image-order-status .icon{height:40px;width:40px;background-size:contain;background-position:no-repeat}
    .shop-tracking-status .image-order-status .status{position:absolute;text-shadow:1px 1px #eee;color:#0d2765;transform:rotate(-30deg);-webkit-transform:rotate(-30deg);width:180px;top:-50px;left:50px}.shop-tracking-status .image-order-status .status:before{font-family:FontAwesome;content:"\f053";padding-right:5px}
    .shop-tracking-status .image-order-status-new{left:0}.shop-tracking-status .image-order-status-new .icon{background-image: url({{asset('images/o1.png')}});}
    .shop-tracking-status .image-order-status-active{left:22%}.shop-tracking-status .image-order-status-active .icon{background-image: url({{asset('images/o2.png')}});}
    .shop-tracking-status .image-order-status-intransit{left:45%}.shop-tracking-status .image-order-status-intransit .icon{background-image: url({{asset('images/o3.png')}});}
    .shop-tracking-status .image-order-status-delivered{left:70%}.shop-tracking-status .image-order-status-delivered .icon{background-image: url({{asset('images/o4.png')}});}
    .shop-tracking-status .image-order-status-delivered .status{top:85px;left:-180px;transform:rotate(-30deg);-webkit-transform:rotate(-30deg);text-align:right}.shop-tracking-status .image-order-status-delivered .status:before{display:none}
    .shop-tracking-status .image-order-status-delivered .status:after{font-family:FontAwesome;content:"\f054";padding-left:5px;vertical-align:middle}
    .shop-tracking-status .image-order-status-completed{right:0px}.shop-tracking-status .image-order-status-completed .icon{background-image: url({{asset('images/o5.png')}});}
    .shop-tracking-status .image-order-status-completed .status{top:85px;left:-180px;transform:rotate(-30deg);-webkit-transform:rotate(-30deg);text-align:right}.shop-tracking-status .image-order-status-completed .status:before{display:none}
    .shop-tracking-status .image-order-status-completed .status:after{font-family:FontAwesome;content:"\f054";padding-left:5px;vertical-align:middle}
    .shop-tracking-status .image-order-status-cancelled{right:0px}
    .shop-tracking-status .image-order-status-cancelled .icon{background-image: url({{asset('images/o6.png')}});}
    .shop-tracking-status .image-order-status-cancelled .status{top:85px;left:-180px;transform:rotate(-30deg);-webkit-transform:rotate(-30deg);text-align:right}
    .shop-tracking-status .image-order-status-cancelled .status:before{display:none}
    .shop-tracking-status .image-order-status-cancelled .status:after{font-family:FontAwesome;content:"\f054";padding-left:5px;vertical-align:middle}
    .mt-50{
      margin-top: 75px;
    }
    .col-md-2 p{
      text-align: center;
    line-height: 17px;
    margin-bottom: 10px !important;
    
    }
    </style>
<div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb2">
          <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li class="breadcrumb-item">Order Details</li>
          </ol>
        </nav>
        <br>
        <div class="row">
          <div class="col-6">
            <h5 class="font-weight-bold">Order Detailed</h5>
          </div>
          <div class="col-6" style="float: right;text-align: right;">
            @if ($order[0]->order_status != 6)
            <a  href="{{route('order.cancel',['id' => $order[0]->order_id])}}" class="btn btn-danger" type="submit">Cancel Order</a>
 
            @else
            <a  href="{{route('order.cancel',['id' => $order[0]->order_id])}}" class="btn btn-danger disabled" type="submit">Order Cancelled</a>
            @endif
            <h5 class="font-weight-bold"></h5>
          </div>
          <div class="clearfix"> </div>
          <div class="col-md-6 mt-4 mb-4">
            <div class="row m-0">
              <div class="col order-details">
                <div class="form-group font-weight-bold">Order number:</div>
                <div class="form-group font-weight-bold">Date:</div>
                <div class="form-group font-weight-bold">Delivered Address:</div>
              </div>
              <div class="col order-details">
              <div class="form-group text-right">{{$order[0]->ordernumber}}</div>
              <div class="form-group text-right">{{$order[0]->order_date}}</div>
              <div class="form-group text-right">{{$order[0]->user_house_number. ' , '. $order[0]->user_society. ' , '. $order[0]->user_locality. ' , '.$order[0]->user_address.' , '
              .App\State::find($order[0]->user_city)->name.' '.App\Country::find($order[0]->user_country)->name}}</div>
      
              </div>
            </div>
          </div>
          <div class="col-md-6 mt-4 mb-4">

              <div class="row m-0 order-details">
                  <div class="col">
                    <div class="form-group font-weight-bold">
                      <h4>Product</h4>
                    </div>
                  </div> 
                  <div class="col"></div><div class="col"></div><div class="col"></div><div class="col"></div>
                  <div class="col">
                      <div class="form-group font-weight-bold">
                        <h4>Total</h4>
                      </div>
                    </div> 

                </div>

            <div class="row m-0 order-details">              
                <div class="col">
                  @foreach ($order as $item)
                  <div class="row">
                      <div class="col-md-6">
                      <div class="form-group text-left">
                        {{$item->product_name.' x '.$item->product_quantity}}
                      </div>
                          </div>
                  
                  <div class="col-md-6">
                    <div class="form-group text-right">
                      {{ ($item->product_mrp) .' '. session('currency_symbol') }}
                    </div>
                    </div>
                    </div>  
                  @endforeach
                  </div>
              <div class="">
                <div class="form-group font-weight-bold">
                </div>

                  </div>              
              <div class="clearfix"></div>
              <div class="col-12">
                <hr>
              </div>
              <div class="clearfix"></div>
              {{-- <div class="col-12">
                <div class="form-group text-right">
                  <h4>{{ ($order[0]->order_total) - ($order[0]->service_charge + $order[0]->delivery_charge).' '. session('currency_symbol') }}</h4>
                </div>
              </div> --}}
              <div class="col order-details">
                <div class="form-group font-weight-bold">
                    <h4>Product Discount</h4>
                </div>
                <div class="form-group font-weight-bold">
                  <h4>Shipping/Delivery Charge</h4>
                </div>
                <div class="form-group font-weight-bold">
                  <h4>Service charge</h4>
                </div>
                <div class="form-group font-weight-bold">
                  <h4>Rewards</h4>
                </div>                                
                <div class="form-group font-weight-bold">
                  <h4>Payment method:</h4>
                </div>
              </div>
              <div class="col order-details">
                <div class="form-group text-right">{{ $order[0]->mrp_discount ? ' - '. $order[0]->mrp_discount .' '. session('currency_symbol') : 0   }}</div>
                <div class="form-group text-right">{{ $order[0]->delivery_charge ? ' + '. $order[0]->delivery_charge .' '. session('currency_symbol') : 0   }}</div>
                <div class="form-group text-right">{{ $order[0]->service_charge ? ' + '. $order[0]->service_charge .' '. session('currency_symbol') : 0  }}</div>
                <div class="form-group text-right">{{ $order[0]->applied_reward ? ' - '. $order[0]->applied_reward .' '. session('currency_symbol') : 0  }}</div>
                <div class="form-group text-right">COD</div>
              </div>
            </div>
            <div class="row m-0">
              <div class="col order-details">
                <div class="form-group font-weight-bold">
                  <h4>Total:</h4>
                </div>
              </div>
              <div class="col order-details">
                <div class="form-group text-right">
                <h4>{{$order[0]->order_total .' '. session('currency_symbol') }} </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
            <div class="row shop-tracking-status">
              <div class="col-12">
                <h5 class="font-weight-bold">Order Status</h5>
              </div>
              <div class="col-md-12">
                  <div class="well">
                <div class="order-status">
          
                          <div class="order-status-timeline">
                              <!-- class names: c0 c1 c2 c3 and c4 -->
                              <div class="order-status-timeline-completion c3"></div>
                              <div class="container">
                              <div class=" row mt-50">
                                <div class="col-md-0"></div>
                                @if ($shippings)
                                  @foreach ($shippings as $shipping)
                                  <div class="col-md-3">
                                      <p>{{$shipping->status_date}}</p>
                                      <p>{{$shipping->status_message}}</p>
                                  </div> 
                                  @endforeach 
                                @endif
                           </div>
                         </div>
                          </div>
                          @if ($shippings)
                          @foreach ($shippings as $shipping)
                          <?php 
                                 $language = $shipping->status_id;
                                  switch ($language) {
                                      case 1:
                                           $class = 'image-order-status-active';
                                          break;
                                      case 2:
                                           $class = 'image-order-status-intransit';
                                          break;
                                      case 3:
                                           $class = 'image-order-status-delivered';
                                          break;
                                      case 4:
                                           $class = 'image-order-status-completed';
                                          break;
                                      case 5:
                                           $class = 'image-order-status-cancelled';
                                          break;
                                      case 6:
                                           $class = 'image-order-status-cancelled';
                                          break;
                                      default:
          
                                      }
                          ?>
                              <div class="image-order-status {{$class}} active img-circle">
                                  <span class="status">{{App\Constant::find($shipping->status_id)->data}}</span>
                                      <div class="icon"></div>
                  
                                  </div>
                      @endforeach  
                          @endif
                      
                      </div>
          </div>
          </div>
          </div>
          </div>
@endsection