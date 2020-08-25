@extends('mails/default')
@section('content')
    <style>
            .slip{
            background:#fff;
            padding:25px;
            margin:13px 30px;
            }
        
            .invoice-title h2, .invoice-title h3 {
            display: inline-block;
            }
            address{
            font-size: 15.8px;
            }
            .table1 td, .table1 th{
        
            border-top:0px solid #fff !important;
            } 
        </style>
        <div class="kt-container">
                <div class="slip">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="invoice-title">
                        <h2>Invoice</h2><h3 class="pull-right">Order #{{$orders[0]->order_id}}</h3>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-6">
                            <address>
                            <strong>{{$orders[0]->supermarket_name }}</strong><br>
                             {{$orders[0]->supermarket_address}}<br>
                             {{App\Country::find($orders[0]->supermarket_country)->name.", ". 
                             App\City::find($orders[0]->supermarket_city)->name }}
                            </address>
                            </div> <div class="col-lg-6 text-right">
                                <address>
                                <strong>Shipped To:</strong><br>
                                {{$orders[0]->user_name }} <br>
                                {{$orders[0]->user_house_number." ".$orders[0]->user_society." ". $orders[0]->user_locality}}<br>
                                {{$orders[0]->user_address.",".App\Country::find($orders[0]->user_country)->name.", ". 
                                App\City::find($orders[0]->user_city)->name}}
                                </address>
                                </div>
                           
                        </div>
                        <div class="row">
                             <div class="col-lg-6">
                                {{-- <address>
                                <strong>Payment Method:</strong><br>
                                Visa ending **** 4242<br>
                                jsmith@email.com
                                </address> --}}
                            </div> 
                            <div class="col-lg-6 text-right">
                                    <address>
                                            <strong>Billed To:</strong><br>
                                            {{$orders[0]->user_name }} <br>
                                            {{$orders[0]->user_house_number." ".$orders[0]->user_society." ". $orders[0]->user_locality}}<br>
                                            {{$orders[0]->user_address.",".App\Country::find($orders[0]->user_country)->name.", ". 
                                            App\City::find($orders[0]->user_city)->name}}
                                    </address>
                                <address>
                                <strong>Order Date:</strong><br>
                                {{date('d-M-Y', strtotime($orders[0]->order_date))}}<br><br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            <h3 class="panel-title"><strong>Order summary</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                <table class="table table-condensed">
                                <thead>
                                <tr>
                                <td><strong>Item</strong></td>
                                <td class="text-center"><strong>Price</strong></td>
                                <td class="text-center"><strong>Quantity</strong></td>
                                <td class="text-right"><strong>Total</strong></td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $item)
                                <tr>
                                    <td>{{$item->product_name}}</td>
                                    <td class="text-center">{{$item->product_mrp}}</td>
                                    <td class="text-center">{{$item->product_quantity}}</td>
                                    <td class="text-right">{{$item->item_cost}}</td>
                                </tr>
                                @endforeach
                                </table>
            
                                <div class="table-responsive"> 
                                <table class="table table1 table-condensed">
                                    <tr>
                                <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                <td class="thick-line">&nbsp;</td><td class="thick-line">&nbsp;</td>
                                <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                    <td class="thick-line text-right">{{$orders[0]->order_total}}</td>
                                </tr>
                                    <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                    <td class="no-line"></td>
                                <td class="thick-line">&nbsp;</td><td class="thick-line">&nbsp;</td>
                                <td class="no-line text-center"><strong>Shipping</strong></td>
                                    <td class="no-line text-right">+{{$orders[0]->delivery_amount}}</td>
                                </tr>
                                <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line">&nbsp;</td><td class="thick-line">&nbsp;</td>
                                <td class="no-line text-center"><strong>Total</strong></td>
                                <td class="no-line text-right">{{$orders[0]->order_total + $orders[0]->delivery_amount}}</td>
                                </tr>
                                <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line">&nbsp;</td><td class="thick-line">&nbsp;</td>
                                <td class="no-line text-center"><strong>Discount</strong></td>
                                <td class="no-line text-right">-{{$orders[0]->mrp_discount}}</td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="thick-line">&nbsp;</td><td class="thick-line">&nbsp;</td>
                                    <td class="no-line text-center"><strong>Coupon</strong></td>
                                    <td class="no-line text-right">{{$orders[0]->coupon_id == -1 ? "No coupons added" : $orders[0]->coupon_discount_amount}}</td>
                                    </tr>
                                <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line">&nbsp;</td><td class="thick-line">&nbsp;</td>
                                <td class="no-line text-center"><strong>Total</strong></td>
                                <td class="no-line text-right">{{($orders[0]->order_total + $orders[0]->delivery_amount) - ($orders[0]->mrp_discount + $orders[0]->coupon_discount_amount)  }}</td>
                                </tr>
                            
                                <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                    <td class="no-line"></td>
                                <td class="no-line text-center"><strong></strong></td>
                                <td class="no-line text-right"></td>
                                </tr>
            
                                </table>
                                </div>
            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
			@stop