<?php
namespace App\Http\Traits;
use Auth;
use App\Cart;
use App\User;
use App\Lotteryticket;
use Illuminate\Http\Request;

trait PlaceOrderTrait {
    public function findLotteryProducts($user_id){
        return Cart::checkforLotteryProducts($user_id);
    }
    public function saveLottery($data){
        $ticket = new Lotteryticket;

        $ticket_number =  'LOTTR'.mt_rand(100,100000);
        //return $ticket_number;
        $ticket->order_id = $data['order_id'];
        $ticket->lottery_id = $data['lottery_id'];
        $ticket->productconfig_id = $data['productconfig_id'];
        $ticket->user_id = $data['user_id'];
        $ticket->lotterynumber = $ticket_number;
        $ticket->save();
        return $ticket;

    }
}