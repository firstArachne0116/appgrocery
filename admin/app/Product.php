<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['name','description','supermarket_id','category_id'];
    protected $hidden = ['created_at', 'updated_at'];

    
    public function productconfig() {
    	return $this->hasMany('App\Productconfig');
    }

    public function supermarket() {
    	return $this->belongsTo('App\Supermarket');
    }

    public function category() {
    	return $this->belongsTo('App\Category');
    }


    public function getProductsbyConfigId($id){

        $vendors = DB::table('products')
            ->join('productconfigs', 'products.id', '=', 'productconfigs.product_id')
            ->join('categories','categories.id','productconfigs.category_id')
            ->select('products.id as product_id','products.name as product_name',
            'products.name_arabic as product_name_arabic','productconfigs.discount',
            'productconfigs.discountedprice','products.supermarket_id as supermarket_id',
            'productconfigs.id as productconfig_id','productconfigs.price',
            'productconfigs.capacity','productconfigs.unit_id','productconfigs.quantity', 'productconfigs.sku', 'productconfigs.lottery_id',
            'productconfigs.is_enabled','productconfigs.lotteryproduct','productconfigs.fixedlotteryproduct',
            'productconfigs.status as status','productconfigs.description as description','productconfigs.image_path',
            'productconfigs.is_approved','productconfigs.category_id as category_id',
            'productconfigs.description_arabic as description_arabic','productconfigs.credits as credits',
            'categories.name as category_name')
            ->where('productconfigs.id',$id)->get();

        return $vendors;
        
    }

    // get only product name and id using only supermarket id. Use for selects in frontend only.
    public function getProductBySupermarketID($id){
        $products = DB::table("products")
        ->where("supermarket_id",$id)
        ->pluck('name','id');
        return $products;
    }
    // fetch all products from supermarket of a particular category
    public function getProductBySupermarketIDAndCategoryId($supermarket_id,$category_id){
        $products = DB::table("products")
        ->join('productconfigs','products.id', '=','productconfigs.product_id')
        ->join('categories','categories.id','products.category_id')
        ->where([["products.supermarket_id",$supermarket_id],
        ['products.category_id',$category_id]
        ])->select('products.id as product_id','products.name as product_name','productconfigs.discount',
        'productconfigs.discountedprice','products.supermarket_id as supermarket_id','productconfigs.id as productconfig_id','productconfigs.price',
        'productconfigs.capacity','productconfigs.quantity','productconfigs.status as status','productconfigs.description as description','productconfigs.image_path','productconfigs.is_approved','productconfigs.category_id as category_id',
        'categories.name as category_name')
        ->get();
        
        return $products;
    }

    // fetch all products of a supermarket by giving id

    public function getProductDetailsBySupermarketID($supermarket_id){
        $products = DB::table("products")
        ->join('productconfigs','products.id', '=','productconfigs.product_id')
        ->join('categories','categories.id','products.category_id')
        ->where([["products.supermarket_id",$supermarket_id],['productconfigs.status',1]
        ])->select('products.id as product_id','products.name as product_name','productconfigs.discount',
        'productconfigs.discountedprice','products.supermarket_id','productconfigs.id as productconfig_id','products.description','productconfigs.price',
        'productconfigs.capacity','productconfigs.unit_id','productconfigs.is_enabled','productconfigs.quantity', 'productconfigs.sku', 'productconfigs.is_approved','categories.name as category_name')
        ->get();

        return $products;
    }

    public function getProductBySupermarketIDAndVendorId($supermarket_id,$vendor_id){
        $products = DB::table("products")
        ->join('productconfigs','products.id', '=','productconfigs.product_id')
        ->join('categories','categories.id','products.category_id')
        ->where([["products.supermarket_id",$supermarket_id],['products.vendor_id',$vendor_id]
        ])->select('products.id as product_id','products.name as product_name','productconfigs.discount',
        'productconfigs.discountedprice','products.supermarket_id','productconfigs.id as productconfig_id','products.description','productconfigs.price',
        'productconfigs.capacity','productconfigs.unit_id','productconfigs.quantity','productconfigs.is_approved','categories.name as category_name')
        ->get();

        return $products; 
    }

    // Approve all products by giving all supermarket id. 
    public function approveAll($id){
        $products = DB::table("productconfigs")
        ->where("productconfigs.supermarket_id",$id)
        ->update(['productconfigs.is_approved' => 1]);
    }
    public function getproductsbycategory($productcategory_id,$supermarket_id){
        $products = DB::table('productconfigs')
        ->join('products','products.id','productconfigs.product_id')
                ->where([['productconfigs.category_id',$productcategory_id],
                ['productconfigs.supermarket_id',$supermarket_id]
                ])
                ->pluck('products.name','productconfigs.id');
        return $products;
    }

}
