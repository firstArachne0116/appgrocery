<?php

namespace App\Http\Controllers;

use App\Cart;
use App\User;
use App\CartItem;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use App\Http\Traits\ValidationTrait;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    use ValidationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }

    /*public function cartold(Request $request) {
        // if flag empty or if has value either 0 or 1 test cases
        $uid = $request->userid;
        $pid = $request->productid;
        $sid = $request->supermarketid;
        $qty = $request->quantity;
        $cid = $request->categoryid;

        $this->validate($request, [
            'uid' => 'min:1|int',
            'pid' => 'min:1|int',
            'sid' => 'min:1|int',
            'cid' => 'min:1|int',
            'qty' => 'min:1|int',
        ]);

        $userproducts = Cart::where(['user_id' => $uid, 'product_id' => $pid, 'supermarket_id' => $sid])->count();
        if($request->has('switchmarket')) {
            $flag = $request->switchmarket;
            if($flag == 1) {
                Cart::where(['user_id' => $uid])->delete();
                $cartfon = new Cart;
                $cartfon->product_id         = $request->productid;
                $cartfon->supermarket_id     = $request->supermarketid;
                $cartfon->category_id        = $request->categoryid;
                $cartfon->user_id            = $request->userid;
                $cartfon->quantity          = $request->quantity;
                $cartfon->save();
                return response()->json(['message' => 'New Supermarket items added to cart successfully!']);

            } else if($flag == 0) {
                return response()->json(['message' => 'Keep on adding products from same supermarket then.']);
            } else {
                return response()->json(['message' => 'Something is Wrong']);
            }
            
        } else {
            if($userproducts > 0) {
            $newqty = $qty;
            Cart::where(['user_id' => $uid, 'product_id' => $pid, 'supermarket_id' => $sid])->update(['quantity' => $newqty]);
            return response()->json(['message' => 'product is added successfully.']);
            } else {
                $usermarkets = Cart::where(['user_id' => $uid])->get(['supermarket_id'])->toArray();
                if(isset($usermarkets)) {
                    $market = $usermarkets[0]['supermarket_id'];
                }

                if($market == $sid)  {
                    $cart = new Cart;
                    $cart->product_id         = $request->productid;
                    $cart->supermarket_id     = $request->supermarketid;
                    $cart->category_id        = $request->categoryid;
                    $cart->user_id            = $request->userid;
                    $cart->quantity          = $request->quantity;
                    $cart->save();
                    return response()->json(['message' => 'Item added to cart successfully!']);
                } else {
                    return response()->json(['productid' => $pid, 'supermarketid' => $sid, 'categoryid' => $cid , 'quantity' => $qty, 'userid' => $uid ,'message' => 'Do you want to switch to new market?']);                
                }
                
            }

        }

    }*/

    public function checkout(Request $request) {
       $cartitems = $request->items;
       $carts     = $request->cart;
       $userdata = auth()->user()->toArray();
       App::setLocale($request->header('locale'));
       $uid = $userdata['id'];
       if(empty($carts) && empty($cartitems)) {
           $redata = array();
           //$msg = 'Please send validated cart data.';
           $message = trans('lang.cartgenerationerror');
           return $this->customerrormessage($message,$redata,200);
           //return response()->json(["message" => $msg,"data" => $redata,"status" => 401]);
       }

       Cart::where(['user_id' => $uid])->delete();
       CartItem::where(['user_id' => $uid])->delete();


       $cartobj = new Cart;
       $cartobj->supermarket_id     = $carts['supermarket_id'];
       $cartobj->user_id            = $uid;
       $cartobj->mrp_price          = $carts['mrp_price'];
       $cartobj->mrp_discount       = $carts['mrp_discount'];
       $cartobj->coupon_discount    = $carts['coupon_discount'];
       $cartobj->coupon_id          = $carts['coupon_id'];
       $cartobj->delivery_charge    = $carts['delivery_charge'];
       $cartobj->service_charge     = $carts['service_charge'];
       $cartobj->delivery_time      = $carts['delivery_time'];
       $cartobj->no_of_items        = $carts['no_of_items'];
       $cartobj->subtotal           = $carts['subtotal'];
       $cartobj->save();
       $cart_id = $cartobj->id;

        foreach($cartitems as $cartitemk => $cartitemv) {            
           $cartitemobj = new CartItem;
           $cartitemobj->cart_id            = $cart_id;
           $cartitemobj->product_id         = $cartitemv['product_id'];
           $cartitemobj->productconfig_id   = $cartitemv['productconfig_id'];
           $cartitemobj->supermarket_id     = $cartitemv['supermarket_id'];
           //$cartitemobj->category_id        = $cartitemv['category_id'];
           $cartitemobj->user_id            = $uid;
           $cartitemobj->quantity           = $cartitemv['quantity'];
           $cartitemobj->capacity             = $cartitemv['weight'];
           $cartitemobj->mrp_price          = $cartitemv['mrp_price'];
           $cartitemobj->mrp_discount       = $cartitemv['mrp_discount'];
           //$cartitemobj->coupon_discount    = $cartitemv['coupon_discount'];
           $cartitemobj->subtotal           = $cartitemv['subtotal'];
           $cartitemobj->save();

        } 
        //$msg = 'cart is generated';
        $message = trans('lang.cartgeneration');
        $redata = array();
        return $this->customerrormessage($message,$redata,200);
        //return response()->json(["message" => $msg,"data" => $redata,"status" => 200]);
    }
}



/*{"items": [{
"product_id": "9",
"productconfig_id": "11",
"supermarket_id": "1",
"user_id": "4",
"quantity": "2",
"weight": "500",
"mrp_price": "300",
"mrp_discount": "286",
"subtotal": "286"
}
],
"cart": {
"supermarket_id": "1",
"user_id": "4",
"mrp_price": "300",
"mrp_discount": "14",
"coupon_discount": "0",
"coupon_id": "1",
"delivery_charge": "0",
"service_charge": "100",
"delivery_time": "20:00:00",
"no_of_items": "2",
"subtotal": "386"
}
}*/









