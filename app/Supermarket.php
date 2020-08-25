<?php

namespace App;

use App\Vendor;
use Illuminate\Database\Eloquent\Model;

class Supermarket extends Model
{
    //
    public function product() {
    	return $this->hasMany('App\Product');
    }

    public function productconfig() {
    	return $this->hasMany('App\Productconfig');
    }

    public function vendors(){
        return $this->hasMany('App\Vendor');
        
    }
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
    public static function getValidSupermarkets(){
        return self::where('is_enabled','!=',0)->get();
        
    }

    public static function findVendorID($id){
        return Vendor::where('supermarket_id',$id)->first();
    }
    
    
}
