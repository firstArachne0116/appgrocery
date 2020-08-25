<?php

namespace App;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public function supermarket(){
    return $this->hasOne('App\Supermarket');
        
    }
    public function getVendorDetails($id){
        $vendors = DB::table('users')
            ->join('vendors', 'users.id', '=', 'vendors.user_id')
            ->leftJoin('countries','vendors.country_id','=','countries.id')
            ->leftJoin('areas','vendors.area_id','=','areas.id')
            ->leftJoin('cities','vendors.city_id','=','cities.id')
            ->select('users.email','users.id','users.name','users.mobile','users.id','vendors.supermarket_id',
            'vendors.address', 'vendors.status','countries.id as country_id','vendors.is_enabled',
            'countries.name as country_name','areas.id as area_id','areas.name as area_name','cities.id as city_id','cities.name as city_name')
            ->where('users.id',$id)->get();

            return $vendors;
    }

        public  static function getSupermarketId(){
            if (Auth::check()){
            $user = Auth::user();
            $vendor = self::select('supermarket_id')->where('user_id',$user->id)->get();
            return $vendor;
            } else {
                return redirect()->route('login');
            }
            
        }
}
