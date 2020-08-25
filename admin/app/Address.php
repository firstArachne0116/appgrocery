<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
	use SoftDeletes;
    //
    protected $hidden = ['created_at', 'updated_at'];
    //protected $visible = ['id','honorific','name','houseno','society','locality','addressname','country_id','state_id','city_id','user_id','status','deleted_at','area_id','city.name as city_name','area.name as area_name'];
    public function order() {
    	return $this->hasOne('App\Order');
    }

    public function user() {
    	return $this->hasMany('App\User');
    }
    public function area()
    {       
		return $this->hasOne(Area::class, 'id', 'area_id');
    }
	public function city()
    {       
		return $this->hasOne(City::class, 'id', 'city_id');
    }
	
    public static function formatAddress($id){
        $address = self::find($id);
		if(!empty($address))
		{
        return ' '.$address->houseno .' '.$address->society .' '.$address->locality.' '.$address->address_name; 
		}
		else
		{
			return "";
		}
		
    }
}
