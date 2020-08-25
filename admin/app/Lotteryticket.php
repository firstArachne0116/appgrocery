<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Lotteryticket extends Model
{
    public static function getLotteryReports($id){
        $reports = DB::table('lotterytickets')
        ->join('users','lotterytickets.user_id','=','users.id')
        ->join('orders','lotterytickets.order_id','=','orders.id')
        ->join('lotteries','lotterytickets.lottery_id','=','lotteries.id')
        ->select('lotteries.name as lottery_name','lotteries.valid_till as lottery_validity',
        'lotteries.lottery_rule as lottery_reward','users.name as user_name','users.mobile as user_mobile',
        'lotterytickets.lotterynumber as lottery_ticket','orders.id as order_id','orders.created_at as purchased_at')
        ->where([['lotterytickets.lottery_id',$id],['lotterytickets.status',1]])
        ->get();

        return $reports;
    }
}
