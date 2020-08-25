<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    
    public static function getValidLotteries(){
        $date = new Carbon;
        return self::select('id','name')->where([['valid_till', '>',$date],['is_enabled','!=',0],['status',1]])->get();
    }
    public static function getDetailsValidLotteries(){
        $date = new Carbon;
        return self::where([['valid_till', '>',$date],['is_enabled','!=',0]])->get();
    }
    public static function disableExpiredLotteries(){
        $date = new Carbon;
        self::where('valid_till','<',$date)->update(['is_enabled' => 0]);    
    }
    public static function boughtLotteryDetails($id){
        $boughtlotteries = DB::table('lotterytickets')
        ->join('productconfigs', 'productconfigs.id', '=', 'lotterytickets.productconfig_id')
        ->join('products', 'products.id', '=', 'productconfigs.product_id')
        ->join('categories','categories.id','=','productconfigs.category_id')
        ->join('constants','productconfigs.unit_id','constants.id')
        ->select('products.id as product_id','products.name as name',
        'products.name_arabic as name_arabic','productconfigs.discount',
        'productconfigs.discountedprice','products.supermarket_id as supermarket_id',
        'productconfigs.id as productconfig_id','productconfigs.price',
        'productconfigs.capacity','constants.data as unit_id','productconfigs.quantity','productconfigs.lottery_id',
        'productconfigs.is_enabled','productconfigs.lotteryproduct','productconfigs.fixedlotteryproduct',
        'productconfigs.status as status','productconfigs.description as description','productconfigs.image_path',
        'productconfigs.is_approved','productconfigs.category_id as category_id',
        'productconfigs.description_arabic as description_arabic','productconfigs.credits as credits',
        'categories.name as category_name','categories.name_arabic as category_name_arabic','lotterytickets.lotterynumber','lotterytickets.lottery_winner')
        ->where('lotterytickets.user_id',$id)
        ->get();
        return $boughtlotteries;
    }
}
