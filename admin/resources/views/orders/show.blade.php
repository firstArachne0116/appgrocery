@extends('layouts.app')
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
<?php
$city=App\City::find($orders[0]->supermarket_city);
$cityName="";
if(!empty($city))
{
	$cityName=$city->name;
}
$user_city=App\City::find($orders[0]->user_city);
$user_city_name="";
if(!empty($user_city))
{
	$user_city_name=$user_city->name;
}


?>
<div class="kt-container">
        <div class="slip">
        <div class="row ">
            <div class="col-lg-12">
                <div class="invoice-title">
                <h2>Invoice</h2><h3 class="pull-right">Order #{{$orders[0]->ordernumber}}</h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                    <address>
                    <strong>{{$orders[0]->supermarket_name }}</strong><br>
                     {{$orders[0]->supermarket_address}}<br>
                     {{App\Country::find($orders[0]->supermarket_country)->name.", ". 
                     $cityName }}
                    </address>
                    </div> <div class="col-lg-6 text-right">
                        <address>
                        <strong>Shipped To:</strong><br>
                        {{$orders[0]->user_name }} <br>
                        {{$orders[0]->user_house_number." ".$orders[0]->user_society." ". $orders[0]->user_locality}}<br>
                        {{$orders[0]->user_address.",".App\Country::find($orders[0]->user_country)->name.", ". 
                        $user_city_name}}<br>
                        {{$orders[0]->user_mobile}}
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
                                   $user_city_name}}
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
                                    <td><strong>No</strong></td>
                                    <td class="text-center"><strong>Stock Keeping Unit</strong></td>
                                    <td class="text-center"><strong>Item</strong></td>
                                    <td class="text-center"><strong>Quantity</strong></td>
                                    <td class="text-right"> <strong>Price</strong></td>
                                </tr>
                            </thead>
                        <tbody>
                        @foreach ($orders as $index => $item)
                        <tr>
                            <td>{{$index}}</td>
                            <td class="text-center">{{$item->sku}}</td>
                            <td class="text-center">{{$item->product_name}}</td>
                            <td class="text-center">{{$item->product_quantity}}</td>
                            <td class="text-right"> {{$item->product_mrp}}</td>
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
                                <td class="thick-line text-center"><strong>Product discount</strong></td>
                                <td class="thick-line text-right">{{$orders[0]->mrp_discount ? ' - '. $orders[0]->mrp_discount .' '. session('currency_symbol') : 0}}</td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line">&nbsp;</td><td class="thick-line">&nbsp;</td>
                                <td class="no-line text-center"><strong>Shipping/Delivery Charge</strong></td>
                                <td class="no-line text-right">{{$orders[0]->delivery_charge ? ' + '. $orders[0]->delivery_charge .' '. session('currency_symbol') : 0}}</td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line">&nbsp;</td><td class="thick-line">&nbsp;</td>
                                <td class="no-line text-center"><strong>Service charge</strong></td>
                                <td class="no-line text-right">{{$orders[0]->service_charge ? ' + '. $orders[0]->service_charge .' '. session('currency_symbol') : 0}}</td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line">&nbsp;</td><td class="thick-line">&nbsp;</td>
                                <td class="no-line text-center"><strong>Rewards</strong></td>
                                <td class="no-line text-right">{{ $orders[0]->applied_reward ? ' - '. $orders[0]->applied_reward .' '. session('currency_symbol') : 0  }}</td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line">&nbsp;</td><td class="thick-line">&nbsp;</td>
                                <td class="no-line text-center"><strong>Payment method:</strong></td>
                                <td class="no-line text-right">COD</td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line">&nbsp;</td><td class="thick-line">&nbsp;</td>
                                <td class="no-line text-center"><strong>Total</strong></td>
                                <td class="no-line text-right">{{$orders[0]->order_total .' '. session('currency_symbol') }}</td>
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
@endsection