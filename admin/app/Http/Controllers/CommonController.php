<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Product;
use App\Supermarket;
use App\Mail\Welcome;
use App\Mail\DisableMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Traits\PlaceOrderTrait;
use App\Http\Traits\ValidationTrait;
use Illuminate\Support\Facades\Mail;
use App\Notifications\testNotification;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller
{
    use PlaceOrderTrait;
    use ValidationTrait;
    
    public function getstate(Request $request){
      
        $states = DB::table("states")
                    ->where("country_id",$request->id)
                    ->pluck('name','id');
        return response()->json($states);

    }
    public function getcity(Request $request){
      
        $cities = DB::table("cities")
                    ->where("state_id",$request->id)
                    ->pluck('name','id');
    return response()->json($cities);

    }
	public function getArea(Request $request){
      
        $cities = DB::table("areas")
                    ->where("city_id",$request->id)
                    ->pluck('name','id');
    return response()->json($cities);

    }
    public function getsubcategory(Request $request){
        $subcategories = DB::table("categories")
                    ->where("parentid",$request->id)
                    ->pluck('name','id');
        return response()->json($subcategories);
        
    }

    public function getproductbysupermarketid(Request $request){
        $p = new Product;
        $products = $p->getProductBySupermarketID($request->id);
        return response()->json($products);
    }
    public function getcategorybysupermarketid(Request $request){
        
        $supermarket = Supermarket::find($request->input('id'));
        $categories = $supermarket->categories()->where('categories.parentid','=',0)->pluck('categories.name','categories.id');
        return response()->json($categories);
    }
    public function getusersbylotteryid(Request $request){
        $users = DB::table('lotterytickets')
                ->join('users','lotterytickets.user_id','=','users.id')
                ->select('users.id','users.name','users.mobile')
                ->where('lotterytickets.lottery_id',$request->id)
                ->get();
        return $users;
    }
    public function getproductsbycategory(Request $request){        
        $p = new Product;
        $products = $p->getproductsbycategory($request->id,$request->supermarket_id);
        return $products;
    }
    
    public function getnotifications(Request $request) {
        App::setLocale($request->header('locale'));
        $userid = Auth::user()->id;
        $notificationdata = DB::select("SELECT * FROM notifications WHERE notifiable_id = '".$userid."' order by created_at desc");
        foreach($notificationdata as $notifk => $notifv) {
            $dataArr =  json_decode($notifv->data);
            $notificationdata[$notifk]->data = $dataArr;
        }
        $redata = array("notifications" => $notificationdata); 
        $message = trans("lang.success");
        return $this->customerrormessage($message,$redata,200);    
    }

    // public function test(Request $request){
    //     App::setLocale($request->header('locale'));
    //     // $validation = Validator::make($request->all(),[ 
    //     //     'phone_number' => 'required|integer'
    //     // ]);
    //     $msg = trans('lang.msg');
    //     return json_encode($msg,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    // }

        // public function test(Request $request){
        //     //return $request;
        //      $lottery_products =  $this->findLotteryProducts($request->user_id);
        //      foreach ($lottery_products as $lottery_product) {
        //          $data = array(
        //              'lottery_id' => $lottery_product->lottery_id,
        //              'order_id' => 1,
        //              'productconfig_id' => $lottery_product->productconfig_id,
        //              'user_id' => $request->user_id
        //          );
        //          return $this->saveLottery($data);
        //      }
            
        // }


        // public  function test(){
            
        //     // Mail::send(['text' => 'mail'],['name' => 'Ratul'],function($message){
        //     //     $message::to('dabbagroup@gmail.com','Test')->subject('Test Email')
        //     //     ->from('mailto:noreply@appgrocery.store');
        //     // });
        //     $user = User::find(7);
        //     Mail::to('dabbagroup@gmail.com')->send(new DisableMail($user));
        // }

}
