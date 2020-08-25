<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function orderitems() {
    	return $this->hasMany('App\OrderItem');
    }

    public function address() {
    	return $this->belongsTo('App\Address');
    }

    public function getAllOrders(){
        $orders = DB::table('orders')
            ->join('supermarkets', 'orders.supermarket_id', '=', 'supermarkets.id')
            ->join('users','orders.user_id','=','users.id')
            ->select('orders.id as order_id','orders.subtotal as total','orders.no_of_items as no_of_items',
            'orders.created_at as order_date','supermarkets.id as supermarket_id','supermarkets.name as supermarket_name'
            ,'users.id as user_id','orders.status','users.name as user_name')
            ->get();
        return $orders;
    }
    public function getOrdersBySupermarketId($id){
        $orders = DB::table('orders')
            ->join('supermarkets', 'orders.supermarket_id', '=', 'supermarkets.id')
            ->join('users','orders.user_id','=','users.id')
            ->select('orders.id as order_id','orders.subtotal as total','orders.no_of_items',
            'orders.created_at as order_date','supermarkets.id as supermarket_id','orders.status'
            ,'supermarkets.name as supermarket_name','orders.status','users.id as user_id','users.name as user_name')
            ->where('orders.supermarket_id',$id)
            ->get();
        return $orders;
    }
    public function getInvoiceDetailsbyOrderId($id){
        $orders = DB::table('orders')
            ->join('supermarkets', 'orders.supermarket_id', '=', 'supermarkets.id')
            ->join('users','orders.user_id','=','users.id')
            ->join('order_items','orders.id','=','order_items.order_id')
            ->join('productconfigs','order_items.productconfig_id','=','productconfigs.id')
            ->join('addresses','addresses.id','=','orders.address_id')
            ->join('products','products.id','=','productconfigs.product_id')
            ->select('orders.id as order_id','orders.ordernumber','orders.subtotal as order_total','orders.no_of_items as total_ordered_items',
            'orders.created_at as order_date','supermarkets.name as supermarket_name','supermarkets.address as supermarket_address',
            'supermarkets.country_id as supermarket_country','supermarkets.state_id as supermarket_state','supermarkets.city_id as supermarket_city',
            'orders.order_status as order_status','orders.mrp_discount','orders.applied_reward','orders.coupon_discount as coupon_discount_amount','orders.coupon_id','orders.delivery_charge','orders.service_charge',
            'supermarkets.name as supermarket_name','products.name as product_name',
            'order_items.quantity as product_quantity','order_items.subtotal as order_subtotal','order_items.mrp_price as product_mrp','order_items.mrp_discount as product_after_discount',
            'users.id as user_id','users.name as user_name','addresses.houseno as user_house_number','addresses.society as user_society','addresses.locality as user_locality',
            'addresses.addressname as user_address','addresses.country_id as user_country','addresses.state_id as user_state','addresses.city_id as user_city')
            ->where('order_items.order_id',$id)
            ->get();
        
            return $orders;
    }
    public function getShippingInfoByOrderId($id) {
        $orders = DB::table('orders')
            ->join('shippings', 'orders.id', '=', 'shippings.order_id')
            ->join('shippinghistories','shippinghistories.shipping_id','=','shippings.id')
            ->select('shippinghistories.shipping_status as status_id','shippinghistories.status_message as status_message',
            'shippinghistories.created_at as status_date')
            ->where('orders.id',$id)
            ->get();
        return $orders;
    }

}
