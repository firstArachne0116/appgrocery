<?php

namespace App\Http\Controllers;

use App\Auth;
use App\User;
use App\Coupon;
use App\Order;
use App\Constant;
use App\Supermarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\ValidationTrait;
use Illuminate\Support\Facades\App;

class CouponController extends Controller
{
    use ValidationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::where('status','!=',0)->get();
        return view('coupons.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sm = Supermarket::select('id','name')->where('status', '!=',0)->get();
        $couponrewards = Constant::select('id','data')->where('constant_type','COUPON_REWARD_TYPE')->get();
        return view('coupons.create',compact('sm','couponrewards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request;
        
        $this->validate($request,[
            'coupon_type' => 'required|integer',
            'coupon_name' => 'required|max:255|string',
            'name_arabic' => 'required|max:255',
            'description' => 'required|max:255|string',
            'description_arabic' => 'required|max:255',
            'coupon_reward_type' => 'required|integer',
            'valid_from' => 'required|date|after:yesterday',
            'valid_till' => 'required|date|after:valid_from',

        ]);
        
        if($request->input('coupon_type') == 1){
            $this->validate($request,[
                'supermarket_id' => 'required|integer'
            ]);
        }
        if($request->input('coupon_reward_type') == 9){
            $this->validate($request,[
                'coupon_reward' => 'required|integer|max:100|min:0  '
            ]);
        }
        if($request->input('coupon_reward_type') == 10){
            $this->validate($request,[
                'coupon_reward' => 'required|integer|min:1'
            ]);
        }
        $coupon = new Coupon;
        if ($request->input('coupon_type') == 2) {
            $coupon_code = "GH".substr($request->input('coupon_name'),-3);
           
        } 
        else if ($request->input('coupon_type') == 1) {
            $coupon_code = "SM".substr($request->input('coupon_name'),-3);
            $coupon->supermarket_id = $request->input('supermarket_id');
        }
        //return $coupon;
        if($request->input('coupon_reward_type') == 7 || $request->input('coupon_reward_type') == 8){
            $coupon->coupon_rule = 0;
        }
        $coupon->name = $request->input('coupon_name');
        $coupon->name_arabic = $request->input('name_arabic');
        $coupon->coupon_reward_type = $request->input('coupon_reward_type');
        $coupon->coupon_code = strtoupper($coupon_code);
        $coupon->description = $request->description;
        $coupon->description_arabic = $request->description_arabic;
        if($request->input('coupon_reward') != null){
            $coupon->coupon_rule = $request->input('coupon_reward');
         }         
        $coupon->valid_from = $request->input('valid_from');   
        $coupon->valid_till = $request->input('valid_till');
        
     
        
        $coupon->save();
        return redirect()->route('coupon.index')->with('success','Coupon was added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        return view('coupons.show',compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        $sm = Supermarket::select('id','name')->where('status', '!=',0)->get();
        return view('coupons.edit',compact('coupon','sm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $this->validate($request,[
            'valid_from' => 'required|date|after:yesterday',
            'valid_till' => 'required|date|after:valid_from',

        ]);
        $coupon->coupon_rule = $request->input('coupon_rule');
        if ($request->input('coupon_type') == 1) {
            $coupon->supermarket_id = $request->input('supermarket_id');
        }
        else{
            $coupon->supermarket_id = 0;
        }
        $coupon->valid_from = $request->input('valid_from');   
        $coupon->valid_till = $request->input('valid_till'); 
        $coupon->coupon_rule = $request->input('coupon_reward');
        $coupon->coupon_rule = $request->input('coupon_reward');
        $coupon->is_enabled = $request->input('status');
        $coupon->save();

         return redirect()->route('coupon.index')->with('success','Coupon was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->status = 0;
        $coupon->save();
        return redirect()->route('coupon.index')->with('success','Coupon was deleted successfully');
    }

    /*public function getcoupons(Request $request) {
        App::setLocale($request->header('locale'));
        $userid = auth()->user()->id;

        $couponsdata = Coupon::where(['status' => 1])->get()->toArray();        
        foreach($couponsdata as $couponk => $couponv) {
            $coupons[] = $couponv['id'];
        }    
        $couponlist = array();
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

        $couponlist = $couponlist;
        $message    = trans('lang.success');      
        $redata     = array('couponlist' => $couponlist);
        return $this->customerrormessage($message,$redata,200); 
    }

    public function couponview(Request $request) {
        App::setLocale($request->header('locale'));
        $validator = Validator::make($request->all(), [
            'id'         => 'required|int|exists:coupons,id'
        ]);
        if ($validator->fails()) {
            return $this->erroroutput($validator);
        }
        $couponid = $request->id;
        $coupondata = Coupon::where(['id' => $couponid])->get(['id','coupon_code','coupon_rule']);
        $message    = trans('lang.success');       
        $redata = array('coupondata' => $coupondata);
        return $this->customerrormessage($message,$redata,200); 
    } */

    public function verifycoupon($couponcode, $sid) {
        $userid = auth()->user()->id;
        $coupondata = $usedcoupons = array();
        $coupondata = Coupon::where(['coupon_code' => $couponcode, 'supermarket_id' => $sid])->get(['id'])->toArray();
        if (count($coupondata) > 0) {
            $vcouponid = $coupondata[0]['id'];
            $usedcouponsdata = Order::where(['user_id' => $userid])->get(['coupon_id'])->toArray();
            foreach($usedcouponsdata as $usecouponk => $usecouponv) {
                $usedcoupons[] = $usecouponv['coupon_id'];
            }
            if(!in_array($vcouponid, $usedcoupons)) {
                return 1;   
            } else {
                return 0;
            }
        }
        $coupondata = Coupon::where(['coupon_code' => $couponcode, 'supermarket_id' => 0])->get(['id'])->toArray();
        if (count($coupondata) > 0) {
            $vcouponid = $coupondata[0]['id'];
            $usedcouponsdata = Order::where(['user_id' => $userid])->get(['coupon_id'])->toArray();
            foreach($usedcouponsdata as $usecouponk => $usecouponv) {
                $usedcoupons[] = $usecouponv['coupon_id'];
            }
            if(!in_array($vcouponid, $usedcoupons)) {
                return 1;   
            } else {
                return 0;
            }
        }
        return -1;
    }

    public function getcoupon(Request $request) {
        App::setLocale($request->header('locale'));                
        $validator = Validator::make($request->all(), [
            'couponcode'         => 'required|exists:coupons,coupon_code',
            'sid'         => 'required|exists:supermarkets,id'
        ]);
        if ($validator->fails()) {
            return $this->erroroutput($validator);
        }
        $couponcode = $request->couponcode;
        $sid = $request->sid;
        $verifycoupon = $this->verifycoupon($couponcode, $sid);
        if ($verifycoupon == 1) {
            $coupondata = Coupon::where(['coupon_code' => $couponcode])->get(['id','coupon_code','coupon_rule'])->toArray();
            $message    = trans('lang.success');       
            $redata = array('coupondata' => $coupondata);
            return $this->customerrormessage($message,$redata,200);
        } else if ($verifycoupon == -1) {
            $message    = trans('lang.couponinvalidshop');
            $redata = array();
            return $this->customerrormessage($message,$redata,200);
        } else {
            $message    = trans('lang.couponcustomfail');
            $redata = array();
            return $this->customerrormessage($message,$redata,200);
        }

    }
}

