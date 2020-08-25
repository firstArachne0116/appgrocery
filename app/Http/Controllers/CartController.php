<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartItem;
use App\User;
use App\Coupon;
use App\Order;
use App\Supermarket;
use App\Productconfig;
use App\Address;
use DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function addtocart(Request $request) {
        if(Auth::check()) { $userid             = Auth::user()->id; }
        $product_id         = $request->product_id;
        $productconfig_id   = $request->productconfig_id;
        $user_id            = $request->user_id;
        $name               = $request->name;
        $description        = $request->description;
        $image_path         = $request->image_path;
        $price              = $request->price;
        $discount_price     = $request->discountedprice;
        $unit               = $request->unit;
        $quantity           = $request->quantity;
        $maxquantity        = $request->maxquantity;
        $market             = $request->market;
        $crtime             = date('Y-m-d H:i:s');

        // check market switch
        $checkmarket = DB::select("select id from persistantcarts WHERE supermarket_id = '".$market."' AND user_id = '".$userid."'");
        if(!empty($checkmarket)) {
            $checkcart = DB::select("select id from persistantcarts WHERE product_id='".$product_id."' AND productconfig_id = '".$productconfig_id."' AND user_id = '".$userid."'");
            if(!empty($checkcart)) {
                $id = $checkcart[0]->id;            
                $upflag = DB::update("UPDATE persistantcarts SET quantity = '".$quantity."', maxquantity = '".$maxquantity."', price = '".$price."', discount_price = '".$discount_price."' WHERE id = '".$id."'");
                if(isset($request->act) && ($request->act == 'ajaxaddtocart')) {
                    echo '2';
                } else {
                    return redirect('/cart');
                }
            }
            else {
                $insertflag = DB::insert('insert into persistantcarts (product_id, productconfig_id, user_id, name, description, image_path, price, discount_price, unit, quantity,maxquantity, supermarket_id, created_at) 
                values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$product_id, $productconfig_id, $user_id, $name, $description, $image_path, $price, $discount_price, $unit, $quantity,$maxquantity, $market, $crtime]);
                if(isset($request->act) && ($request->act == 'ajaxaddtocart')) {
                    echo '1';
                } else {
                    return redirect('/cart');
                }
            }
        } else {
            // delete old records
            $delcart = DB::delete("DELETE FROM persistantcarts WHERE user_id = '".$userid."'");
            // insert new market data
            $insertflag = DB::insert('insert into persistantcarts (product_id, productconfig_id, user_id, name, description, image_path, price, discount_price, unit, quantity,maxquantity, supermarket_id, created_at) 
            values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$product_id, $productconfig_id, $user_id, $name, $description, $image_path, $price, $discount_price, $unit, $quantity,$maxquantity, $market, $crtime]);
            if(isset($request->act) && ($request->act == 'ajaxaddtocart')) {
                echo '1';
            } else {
                return redirect('/cart');
            }
        }
        
    }

    public function cart() {
        if(Auth::check()) { $userid  = Auth::user()->id; }
        $cartdata = $couponlist = $supermarketdata[0] = array();
        $cartdata = DB::select("SELECT * FROM persistantcarts WHERE user_id = '".$userid."'");
        $coupons = array();
        if($cartdata) {
            $couponsdata = Coupon::where(['status' => 1])->whereIn('supermarket_id', [$cartdata[0]->supermarket_id, '0'])->get()->toArray();
        
            foreach($couponsdata as $couponk => $couponv) {
                $coupons[] = $couponv['id'];
            }
        
            
        if($coupons) {
            $allowedcoupon = array();
            $usedcouponsdata = Order::where(['user_id' => $userid])->get(['coupon_id'])->toArray();
            foreach($usedcouponsdata as $usecouponk => $usecouponv) {
                $usedcoupons[] = $usecouponv['coupon_id'];
            }
            if(!empty($coupons) && !empty($usedcoupons)) {
                $allowedcoupon = array_diff($coupons,$usedcoupons); 
            } else if(!empty($coupons) && empty($usedcoupons)) {
                $allowedcoupon = $coupons;
            } else {
                $allowedcoupon = '';
            }
            if(!empty($allowedcoupon)) {
                $couponlist =  Coupon::whereIn('id' , $allowedcoupon)->get()->toArray();
            }               
        } else { $couponlist = array(); }
    
    // getting coupon for particular user

        // get supermarket related charges
        $supermarketdata = Supermarket::Where(['id' => $cartdata[0]->supermarket_id])->get()->toArray();
    }

        // getting reward points for user
        $reward = User::where(['id' => $userid])->get(['credits'])->toArray();
        return view('carts.cart', ['cartdata' => $cartdata, 'coupons' => $couponlist, 'market_service_charge' => @$supermarketdata[0]['fixedserviceamount'], 'market_delivery_amount' => @$supermarketdata[0]['freedeliveryamount'], 'market_delivery_charge' => @$supermarketdata[0]['fixeddeliveryamount'], 'userrewards' => $reward[0]['credits']]);        
    }

    public function updatecart(Request $request) {
        if(Auth::check()) { $userid  = Auth::user()->id; }
       $cartquantity =  $request->post();
       unset($cartquantity['_token']);
       foreach($cartquantity as $cartquantk => $cartquantv) {
          $cartid = str_replace('cartquant', '', $cartquantk);
          $up = DB::update("UPDATE persistantcarts SET quantity = '".$cartquantv."' WHERE id = '".$cartid."'");          
       }
       return redirect('/cart');

    }

    public function cartdelete(Request $request) {
        if(Auth::check()) { $userid  = Auth::user()->id; }
        $cartid = $request->cartid;
        $delstatus = DB::delete("DELETE FROM persistantcarts WHERE id = '".$cartid."'");
        return redirect('/cart');
    }

    public function getcoupondiscount($coupon_id,$mrp) {        
        $data = array();
        $coupondata = Coupon:: Where(['status' => 1, 'coupon_code' => $coupon_id])->get()->toArray();
        if($coupondata[0]['coupon_reward_type'] == 7) {
            $data['coupondiscount']     = 0;
            $data['delivery_charge']    = 0;
            return(array($coupondiscount));
        } else if($coupondata[0]['coupon_reward_type'] == 8) {
                $data['coupon_discount'] = 0;
                $data['service_charge']  = 0;

        } else if($coupondata[0]['coupon_reward_type'] == 9) {
                $data['coupon_discount'] = ($mrp/100) * ($coupondata[0]['coupon_rule']);
        } else if($coupondata[0]['coupon_reward_type'] == 10) {
                $data['coupon_discount'] = ($mrp) - ($coupondata[0]['coupon_rule']);
        } else {
                $data['coupon_discount'] = 0;
        }
        return $data;
       // if($coupons)
    }

    public function verifycoupon($couponcode) {        
        $userid = auth()->user()->id;
        $coupondata = $usedcoupons = array();
        $coupondata = Coupon::where(['coupon_code' => $couponcode])->get(['id'])->toArray();        
        if($coupondata) { $vcouponid = $coupondata[0]['id']; }
        $usedcouponsdata = Order::where(['user_id' => $userid])->get(['coupon_id'])->toArray();
        if($usedcouponsdata)  {  
            foreach($usedcouponsdata as $usecouponk => $usecouponv) {
                    $usedcoupons[] = $usecouponv['coupon_id'];
            }
            if(@$vcouponid) {
                if(!in_array(@$vcouponid,$usedcoupons)) {
                    return 1;   
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }

        if(@$vcouponid) {            
            return 1;               
        } else {
            return 0;
        }
        
    }

    public function searchcoupon(Request $request) {
        $code = $request->code;
        $verifiedcode = $this->verifycoupon($code); 
        if($verifiedcode == 1) {
            $coupondata = Coupon::where(['coupon_code' => $code])->get(['name', 'coupon_code','coupon_rule','coupon_reward_type'])->toArray();
        } else {
            $coupondata[0] = array();
        }  
        echo json_encode($coupondata[0], JSON_FORCE_OBJECT);       
    }


    public function proceedtocheckout(Request $request) {
       if(Auth::check()) { $userid  = Auth::user()->id; }    
       $cartdata        = DB::select("SELECT * FROM persistantcarts WHERE user_id = '".$userid."'");
       if(empty($cartdata)) { return redirect('cart'); }
       $coupon_id       = $request->applied_coupon_id;
       $earned_points   = $request->applied_earned_points;    

       // remove old cart 
       //    $userdata = auth()->user()->toArray();
       //    $uid = $userdata['id'];        
        $c_user_id                    = $userid;
        Cart::where(['user_id' => $c_user_id])->delete();
        CartItem::where(['user_id' => $c_user_id])->delete();
       
       // get supermarket related charges
       $supermarketdata             = Supermarket::Where(['id' => $cartdata[0]->supermarket_id])->get()->toArray();
       $c_supermarket_id             = $cartdata[0]->supermarket_id;

       $mrps_total = 0; $mrps_discount_total = 0;
        foreach($cartdata as $cartdk => $cartdv) {
            $mrps_total = $mrps_total+ ($cartdv->price * $cartdv->quantity);
            $mrps_discount_total = $mrps_discount_total+ ($cartdv->discount_price * $cartdv->quantity);
        }


       //calculating totals and charges
    //    $mrps = array_column($cartdata, 'price');
    //    $mrps_total = array_sum($mrps);

    //    $mrps_discount = array_column($cartdata, 'discount_price');
    //    $mrps_discount_total = array_sum($mrps_discount);
       $discount_total = $mrps_total - $mrps_discount_total;

       $quantities      = array_column($cartdata, 'quantity');
       $total_quantity  = array_sum($quantities);

       $coupon_discount_total = 0;
       $service_charge = $supermarketdata[0]['fixedserviceamount'];
       if($mrps_total > $supermarketdata[0]['freedeliveryamount']) {
            $delivery_charge = '0';
        } else {
            $delivery_charge = $supermarketdata[0]['fixeddeliveryamount'];            
        } 

       if($coupon_id) { $thiscoupondiscount   = $this->getcoupondiscount($coupon_id,$mrps_total); 
            if($thiscoupondiscount['coupon_discount']) {
                $coupon_discount_total = $thiscoupondiscount['coupon_discount'];
            }
            if(isset($thiscoupondiscount['service_charge'])) {
                $service_charge = $thiscoupondiscount['service_charge'];
                $coupon_discount_total = 0;
            }
            if(isset($thiscoupondiscount['delivery_charge'])) {
                    $delivery_charge = $thiscoupondiscount['delivery_charge']; 
                    $coupon_discount_total = 0;                      
            } 
        }
        $final_total = ($mrps_total+$delivery_charge+$service_charge) - ($discount_total+$coupon_discount_total+$earned_points); 
                             


       $cartobj = new Cart;
       $cartobj->supermarket_id     = $c_supermarket_id;
       $cartobj->user_id            = $c_user_id;
       $cartobj->mrp_price          = $mrps_total;
       $cartobj->mrp_discount       = $discount_total;
       $cartobj->coupon_discount    = $coupon_discount_total;
       $cartobj->coupon_id          = $coupon_id;
       $cartobj->delivery_charge    = $delivery_charge;
       $cartobj->service_charge     = $service_charge;
       $cartobj->delivery_time      = $supermarketdata[0]['deliverytime'];
       $cartobj->no_of_items        = $total_quantity;
       $cartobj->applied_reward     = $earned_points;
       $cartobj->subtotal           = $final_total;
       $cartobj->save();
       $cart_id = $cartobj->id;

        foreach($cartdata as $cartitemk => $cartitemv) { 
           $mrp_price =  $mrp_discount = $subtotal = 0;
           $mrp_price          = ($cartitemv->price * $cartitemv->quantity);
           $mrp_discount       = ($cartitemv->discount_price) * ($cartitemv->quantity);
           $subtotal           = ($mrp_discount);          
           $cartitemobj = new CartItem;
           $cartitemobj->cart_id            = $cart_id;
           $cartitemobj->product_id         = $cartitemv->product_id;
           $cartitemobj->productconfig_id   = $cartitemv->productconfig_id;
           $cartitemobj->supermarket_id     = $cartitemv->supermarket_id;
           $cartitemobj->user_id            = $c_user_id;
           $cartitemobj->quantity           = $cartitemv->quantity;
           $cartitemobj->capacity           = $cartitemv->unit;
           $cartitemobj->mrp_price          = $mrp_price;
           $cartitemobj->mrp_discount       = $mrp_discount;
           $cartitemobj->subtotal           = $subtotal;
           $cartitemobj->save();
        }
        
       return redirect('checkout');
    }

    public function add_address(Request $request) {
        if(Auth::check()) { $userid  = Auth::user()->id; }
        $honorific        = $request->honorific;
        $name             = $request->name;
        $house_address    = $request->house_address;
        $area_address     = $request->area_address;
        $locality_address = $request->locality_address;
        $nickname         = $request->nickname;

        $addressobj = new Address();
        $addressobj->honorific    = $honorific;
        $addressobj->name       = $name;
        $addressobj->houseno    = $house_address;
        $addressobj->society    = $area_address;
        $addressobj->locality   = $locality_address;
        $addressobj->addressname = $nickname;
        $addressobj->country_id = '101';
        $addressobj->state_id   = '0';
        $addressobj->city_id    = '1126';
        $addressobj->user_id    = $userid;

        $addressobj->save();
        echo '1';        
    }

    public function checkout() {
        if(Auth::check()) { $userid  = Auth::user()->id; }
        $payableamountdata = Cart::where(['user_id' => $userid])->get(['subtotal'])->toArray();
        $payableamount =  $payableamountdata[0]['subtotal'];
        $addressdata = Address::where(['user_id' => $userid])->get()->toArray();
        return view('carts.checkout', ['addressdata' => $addressdata, 'payable_amount' => $payableamount]);
    }


}
