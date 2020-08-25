<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    public function boughtLotteryDetails($id){
        $boughtlotteries = DB::table('lotterytickets')
        ->join('productconfigs', 'productconfigs.id', '=', 'lotterytickets.productconfig_id')
        ->join('products', 'products.id', '=', 'productconfigs.product_id')
        ->join('categories','categories.id','=','productconfigs.category_id')
        ->select('products.id as product_id','products.name as name',
        'products.name_arabic as name_arabic','productconfigs.discount',
        'productconfigs.discountedprice','products.supermarket_id as supermarket_id',
        'productconfigs.id as productconfig_id','productconfigs.price',
        'productconfigs.capacity','productconfigs.quantity','productconfigs.lottery_id',
        'productconfigs.is_enabled','productconfigs.lotteryproduct','productconfigs.fixedlotteryproduct',
        'productconfigs.status as status','productconfigs.description as description','productconfigs.image_path',
        'productconfigs.is_approved','productconfigs.category_id as category_id',
        'productconfigs.description_arabic as description_arabic','productconfigs.credits as credits',
        'categories.name as category_name','lotterytickets.lotterynumber','lotterytickets.lottery_winner')
        ->where('lotterytickets.user_id',$id)
        ->get();
        return $boughtlotteries;
    }
}
