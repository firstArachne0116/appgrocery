<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    protected $hidden = ['updated_at'];
    
    public function order() {
    	return $this->belongsTo('App\Order');
    }
}
