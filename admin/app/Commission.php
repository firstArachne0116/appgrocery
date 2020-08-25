<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    public function showReport($from_date,$to_date,$supermarket_id){
        $commissions = DB::table('commissions')
        ->wheredate('created_at','>=',$from_date)
        ->wheredate('created_at','<=',$to_date)
        ->where('supermarket_id',$supermarket_id)
        ->get();
        return $commissions;
    }
    public static function  findVendorDetailsfromOrder($id){
        $vendor_details = DB::table('commissions')
        ->join('orders','orders.id','commissions.order_id')
        ->join('users','users.id','orders.vendor_id')
        ->select('users.email')
        ->where('commissions.id',$id)
        ->get();

        return $vendor_details;
    }
}
