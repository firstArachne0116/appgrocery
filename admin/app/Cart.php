<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $hidden = ['created_at', 'updated_at'];

    public static function checkforLotteryProducts($user_id){
        $lottery_products = DB::table('cart_items')
        ->join('productconfigs','cart_items.productconfig_id','productconfigs.id')
        ->select('productconfigs.lottery_id','productconfigs.id as productconfig_id')
        ->where([['productconfigs.lotteryproduct',1],['cart_items.user_id',$user_id]])
        ->get();
        return $lottery_products;
    }
  
}
