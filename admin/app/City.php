<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public  static function getCityName ($id){
        $cities = self::where(['id' => $id])->pluck('name');
        return $cities;
    }
	
	public function area()
    {       
		return $this->hasMany(Area::class, 'city_id', 'id');
    }
}
