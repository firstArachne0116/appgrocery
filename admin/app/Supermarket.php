<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supermarket extends Model
{
    //
    protected $hidden = ['created_at', 'updated_at'];
    public function product() {
    	return $this->hasMany('App\Product');
    }

    public function productconfig() {
    	return $this->hasMany('App\Productconfig');
    }
    public function city()
    {       
		return $this->hasOne(City::class, 'id', 'city_id');
    }
	 public function area()
    {       
		return $this->hasOne(Area::class, 'id', 'area_id');
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
