<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persistantcart extends Model
{
    public function cartinfo($user_id){
        $wishlists = DB::table('wishlists')
        ->join('products','products.id','wishlists.product_id')
        ->join('productconfigs','productconfigs.id','wishlists.productconfig_id')
        ->select('products.name as product_name','productconfigs.quantity as product_stock',
                'productconfigs.discountedprice as product_price','wishlists.created_at as added_on',
                'productconfigs.image_path as product_image')
        ->where([['wishlists.user_id',$id],['wishlists.status',1]])
        ->get();
    }
}
