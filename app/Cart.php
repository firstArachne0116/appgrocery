<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public static function checkforLotteryProducts($user_id){
        $lottery_products = DB::table('cart_items')
        ->join('productconfigs','cart_items.productconfig_id','productconfigs.id')
        ->select('productconfigs.lottery_id','productconfigs.id as productconfig_id')
        ->where([['productconfigs.lotteryproduct',1],['cart_items.user_id',$user_id]])
        ->get();
        return $lottery_products;
    }
	
	public static function checkforOrderLotteryProducts($user_id,$order_id){
        $lottery_products = DB::table('order_items')
        ->join('productconfigs','order_items.productconfig_id','productconfigs.id')
        ->select('productconfigs.lottery_id','productconfigs.id as productconfig_id')
        ->where([['productconfigs.lotteryproduct',1],['order_items.user_id',$user_id],['order_items.order_id',$order_id]])
        ->get();
        return $lottery_products;
    }
	
	
}
