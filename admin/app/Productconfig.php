<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productconfig extends Model
{
    //
    protected $fillable = ['price','discount','sku','capacity'
    ,'quantity','description','supermarket_id','category_id','lotteryproduct'];
    protected $hidden = ['created_at', 'updated_at'];



    public function product() {
    	return $this->belongsTo('App\Product');
    }

    public function category() {
    	return $this->belongsTo('App\Category');
    }


}
