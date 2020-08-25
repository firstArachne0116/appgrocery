<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public static function getWishlist($id){
        
        $wishlists = DB::table('wishlists')
        ->join('products','products.id','wishlists.product_id')
        ->join('productconfigs','productconfigs.id','wishlists.productconfig_id')
        ->select('products.id as product_id','productconfigs.id as productconfig_id','productconfigs.description as product_description',
        'productconfigs.price as product_price','productconfigs.capacity as unit','productconfigs.supermarket_id',
        'products.name as product_name','productconfigs.quantity as product_stock','productconfigs.discountedprice as product_discount_price',
        'wishlists.created_at as added_on','productconfigs.image_path as product_image','wishlists.id as wishlist_id')
        ->where([['wishlists.user_id',$id],['wishlists.status',1]])
        ->get();        
        return $wishlists;
    }

    public static function wishcount($id){
        $wishcount = DB::table('wishlists')
        ->where([['wishlists.user_id',$id],['wishlists.status',1]])
        ->count();
         session(['wishcount' => $wishcount]); 
    }
}
