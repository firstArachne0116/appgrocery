<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Weeklylist extends Model
{
    public static function getWeeklyList($id){
        $weeklylist = DB::table('weeklylists')
        ->join('products','products.id','weeklylists.product_id')
        ->join('productconfigs','productconfigs.id','weeklylists.productconfig_id')
        ->select('products.id as product_id','productconfigs.id as productconfig_id','productconfigs.description as product_description',
                'productconfigs.price as product_price','productconfigs.capacity as unit','productconfigs.supermarket_id',
                'products.name as product_name','productconfigs.quantity as product_stock',
                'productconfigs.discountedprice as product_discount_price','weeklylists.created_at as added_on',
                'productconfigs.image_path as product_image','weeklylists.id as list_id')
        ->where([['weeklylists.user_id',$id],['weeklylists.status',1]])
        ->get();
        
        return $weeklylist;
    }
}
