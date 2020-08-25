<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Shippinghistory extends Model
{
    public  static function getstatusByType($type){
        $vendor = Vendor::getSupermarketId();
        $details = DB::table('shippings')
        ->join('addresses', 'shippings.address_id', '=', 'addresses.id')
        ->join('orders','orders.id','=','shippings.order_id')
        ->join('shippinghistories','shippinghistories.shipping_id','=','shippings.id')
        ->select('shippinghistories.id as shipping_history_id','shippinghistories.status_message as status_message','shippings.id as shipping_id','orders.id as order_id','orders.user_id as consumer_id','addresses.id as address_id','shippinghistories.shipping_status')
        ->where([['shippinghistories.shipping_status', '=', $type],
                ['shippinghistories.is_complete','=', 0],
                ['orders.supermarket_id','=',$vendor[0]['supermarket_id']]])
        ->get();

        return $details;
    }
    public  static function getstatusByTypeAndSupermarketid($type,$supermarket_id){
        $details = DB::table('shippings')
        ->join('addresses', 'shippings.address_id', '=', 'addresses.id')
        ->join('orders','orders.id','=','shippings.order_id')
        ->join('shippinghistories','shippinghistories.shipping_id','=','shippings.id')
        ->select('shippinghistories.id as shipping_history_id','shippinghistories.status_message as status_message',
        'shippings.id as shipping_id','orders.id as order_id','orders.user_id as consumer_id',
        'addresses.id as address_id','shippinghistories.shipping_status')
        ->where([['shippinghistories.shipping_status', '=', $type],
                ['shippinghistories.is_complete','=', 0],
                ['orders.supermarket_id','=',$supermarket_id]])
        ->get();

        return $details;
    }

    public static function getUserDataforShipping($id){
        $details = DB::table('shippings')
        ->join('orders','orders.id','=','shippings.order_id')
        ->join('users','users.id','=','orders.user_id')
        ->join('constants','constants.id','=','orders.order_status')
        ->select('users.name as user_name','users.email as user_email','constants.data as order_status')
        ->where('shippings.id',$id)
        ->get();

        return $details;
    }

    public static function findOrderIdByShippingId($id){
        $order_id = DB::table('shippings')
                ->select('shippings.order_id')
                ->where('id',$id)
                ->get();
        return $order_id;
    }

}
