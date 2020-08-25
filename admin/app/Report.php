<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function showReport($from_date,$to_date,$supermarket_id){
        $reports = DB::table('orders')
        ->select(DB::raw('count(*) as no_of_orders,
        sum(subtotal) as total_revenue, sum(mrp_price) as mrp_total, 
        sum(mrp_discount) as total_discount,
        count(coupon_id) as total_coupons_used,sum(no_of_items) as number_of_items, 
        sum(coupon_discount) as total_coupon_discount,sum(delivery_charge) as total_shipping
        '))
        ->wheredate('created_at','>=',$from_date)
        ->wheredate('created_at','<=',$to_date)
        ->where('supermarket_id',$supermarket_id)
        ->get();
        return $reports;            
    }
    public function showSupermarketReport($from_date,$to_date,$supermarket_id){
        $reports = DB::table('orders')
        ->join('users','users.id','orders.user_id')
        ->join('supermarkets','supermarkets.id','orders.supermarket_id')
        ->select('supermarkets.name as supermarket_name','users.name as consumer_name',
        'orders.mrp_price as billed_amount','orders.mrp_discount as mrp_discount','orders.created_at as purchased_on',
        'orders.id as order_id','orders.subtotal as total_amount','orders.coupon_id as coupon_id',
        'orders.coupon_discount as total_coupon_discount','orders.delivery_charge as delivery_charges',
        'orders.status as order_status')
        ->wheredate('orders.created_at','>=',$from_date)
        ->wheredate('orders.created_at','<=',$to_date)
        ->where('orders.supermarket_id',$supermarket_id)
        ->get();
        return $reports;
    }
}
