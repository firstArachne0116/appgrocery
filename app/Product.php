<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['name','description','supermarket_id','category_id'];

    
    public function productconfig() {
    	return $this->hasMany('App\Productconfig');
    }

    public function supermarket() {
    	return $this->belongsTo('App\Supermarket');
    }

    public function category() {
    	return $this->belongsTo('App\Category');
    }    

    public function findSimilarProducts($cid,$pid){
    $recommendedProducts =  DB::table('productconfigs')
        ->join('products','products.id','productconfigs.product_id')
        ->where([['productconfigs.product_id','!=',$pid],
                ['productconfigs.category_id',$cid]])
        ->select('productconfigs.price as product_price','productconfigs.product_id as product_id',
        'productconfigs.unit_id','productconfigs.id as productconfig_id','products.name as name',
        'products.name_arabic as name_arabic','productconfigs.category_id',
        'productconfigs.description as description','productconfigs.description_arabic as description_arabic',
        'productconfigs.image_path as product_image','productconfigs.price as product_mrp',
        'productconfigs.discountedprice	 as product_discounted_price','productconfigs.quantity as product_quanity',
        'productconfigs.capacity as product_weight',
        'productconfigs.supermarket_id as supermarket_id')
        ->get();
        return $recommendedProducts;
    }

    public function searchProducts(){
        
    }


}
