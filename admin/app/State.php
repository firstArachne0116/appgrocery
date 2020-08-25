<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public  static function getStateName ($id){
        $states = self::where(['id' => $id])->pluck('name');
        return $states;
    }
}
