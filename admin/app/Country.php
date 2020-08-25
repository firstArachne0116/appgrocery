<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public  static function getCountryName ($id){
        $countries = self::where(['id' => $id])->pluck('name');
        return $countries;
    }
}
