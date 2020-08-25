<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Cart;
use App\User;
use App\Order;
use App\Vendor;
use App\Address;
use App\Payment;
use App\CartItem;
use App\Constant;
use App\Shipping;
use App\OrderItem;
use App\Commission;
use App\Supermarket;
use App\Shippinghistory;
use App\Product;
use App\Productconfig;
use App\Persistantcart;
use App\Lotteryticket;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use App\Http\Traits\PlaceOrderTrait;
use App\Http\Traits\ValidationTrait;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewOrderNotification;
use App\Notifications\CancelOrderNotification;
use App\Mail\PlacedOrderMail;
use App\Mail\CancelledOrderMail;
use App\Mail\BuyLotteryMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Traits\NotificationTrait;

class OrderController extends Controller
{
    use PlaceOrderTrait;
    use ValidationTrait;
    use NotificationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $o =  new Order;
        if (User::checkRole('admin')){
            $orders = $o->getAllOrders();
        }
        elseif (User::checkRole('vendor')){
            $vendor = Vendor::getSupermarketId();
            $orders = $o->getOrdersBySupermarketId($vendor[0]['supermarket_id']);
            
        }
        return view('orders.index',compact('orders'));

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //return $order;
        $o = new Order;
        $orders = $o->getInvoiceDetailsbyOrderId($order->id);
        //return $orders; 
        if(count($orders) > 0){
            return view('orders.show',compact('orders'));
        } else {
            \Session::flash('error','Order No. '.$order->ordernumber.' cannnot be shown due to internal errors.');
            $orders = array();
            if (User::checkRole('admin')){
                $orders = $o->getAllOrders();
            }
            elseif (User::checkRole('vendor')){
                $vendor = Vendor::getSupermarketId();
                $orders = $o->getOrdersBySupermarketId($vendor[0]['supermarket_id']);
                
            }
            return view('orders.index',compact('orders'));
        }

        
    }

    /* APIs*/

    public function checkInventory($orderitemv) {   
        $uid  = Auth::user()->id;         
        $productdata = Productconfig::where(['id' => $orderitemv['productconfig_id']])->get()->toArray();        
        if(@$productdata[0]['quantity'] >=  @$orderitemv['quantity']) {
            $actualdiscount = ($productdata[0]['discountedprice'])*($orderitemv['quantity']);
            if($actualdiscount ==  $orderitemv['mrp_discount']) {
                    $msg = 1;                
            } else {
                Persistantcart::where(['user_id' => $uid, 'productconfig_id' => $orderitemv['productconfig_id']])->update(['discount_price' => $productdata[0]['discountedprice'], 'price' => $productdata[0]['price']]);
                CartItem::where(['id' => $orderitemv['id']])->delete();
                $msg = 2;
            }

        } else {
            Persistantcart::where(['user_id' => $uid, 'productconfig_id' => $orderitemv['productconfig_id']])->update(['maxquantity' => $productdata[0]['quantity'],'quantity' => $productdata[0]['quantity']]);
            CartItem::where(['id' => $orderitemv['id']])->delete();
            $msg = 0;
        }

        return $msg;
    }

    public function updateInventory($orderitemv) {            
        $productdata = Productconfig::where(['id' => $orderitemv['productconfig_id']])->get()->toArray();
        $updated_qty = $productdata[0]['quantity'] - $orderitemv['quantity'];
        Productconfig::where(['id' => $orderitemv['productconfig_id']])->update(['quantity' => $updated_qty]);
        return 1;
}


    public function CreditsToUser($credits,$type) { 
        $newcredits = $credits;     
        $userid = auth()->user()->id;
        $creditdata = User::where(['id' => $userid])->get(['credits'])->toArray();        
        $creditsold = $creditdata[0]['credits'];
        if($type == 'add') {
            $addedcredits = ($creditsold + $newcredits);            
            $add =  User::where(['id' => $userid])->update(['credits' => $addedcredits]);   
            return 1;
        } if ($type == 'remove') {
            if($newcredits > $creditsold) {
                return 0;
            } else {
                $removedcredits = ($creditsold - $newcredits);
                $up =  User::where(['id' => $userid])->update(['credits' => $removedcredits]); 
                return 1;
            }
            
        }                              
    }

    public function placeorder(Request $request) {
        App::setLocale($request->header('locale'));        
        $payment_type = $request->order_mode;
        $userdata  = auth()->user()->toArray();
        $uid       = $userdata['id'];
        $cart_to_order = Cart::where(['user_id' => $uid])->get()->toArray();
        if(isset($cart_to_order[0])) { $orderdetails = $cart_to_order[0]; }
        $cartitem_to_order = CartItem::where(['user_id' => $uid])->get()->toArray();

        if(empty($cart_to_order)) {
            $message = trans('lang.orderblankstatus');
            $redata = array();
            return $this->customerrormessage($message,$redata,401);
        }

        foreach($cartitem_to_order as $orderitemk => $orderitemv) {
                $existingdata = $this->checkInventory($orderitemv);                
                if($existingdata == 0) {
                    $errors_messages[] = $existingdata;
                } else if($existingdata == 2) {
                    $errors_messages[] = $existingdata;
                }
            }
            
            if(!empty($errors_messages)) {
                /* discard cart */
                Cart::where(['user_id' => $uid])->delete();
                CartItem::where(['user_id' => $uid])->delete();
                Persistantcart::Where(['user_id' => $uid])->delete();
                /* discard cart*/
                $message = trans('lang.orderfailstatus');
                $redata = array();
                return $this->customerrormessage($message,$redata,401);
            } 

        /* save order*/        
        if(!empty($payment_type)) {
            $orderobj = new Order;            
            $uniqueorder = rand(100000,999999);
            $orderobj->supermarket_id  =  $orderdetails['supermarket_id'];
            $orderobj->user_id         =  $orderdetails['user_id'];
            $orderobj->ordernumber     =  $uniqueorder;
            $orderobj->address_id      =  $request->addressid;
            $orderobj->mrp_price       =  $orderdetails['mrp_price'];
            $orderobj->mrp_discount    =  $orderdetails['mrp_discount'];
            $orderobj->coupon_discount =  $orderdetails['coupon_discount'];
            $orderobj->coupon_id       =  $orderdetails['coupon_id'];
            $orderobj->delivery_charge =  $orderdetails['delivery_charge'];
            $orderobj->service_charge  =  $orderdetails['service_charge'];
            $orderobj->delivery_time   =  $orderdetails['delivery_time'];
            $orderobj->no_of_items     =  $orderdetails['no_of_items'];            
            $orderobj->subtotal        =  $orderdetails['subtotal'];
            $orderobj->save();
			$uniqueorder='1'.sprintf( '%06d', $orderobj->id );
			$orderobj->ordernumber=$uniqueorder;
			$orderobj->save();
            $order_id = $orderobj->id;

            foreach($cartitem_to_order as $orderitemk => $orderitemv) {            
                $orderitemobj = new OrderItem;
                $orderitemobj->order_id           = $order_id;
                $orderitemobj->product_id         = $orderitemv['product_id'];
                $orderitemobj->productconfig_id   = $orderitemv['productconfig_id'];
                $orderitemobj->supermarket_id     = $orderitemv['supermarket_id'];
                $orderitemobj->category_id        = $orderitemv['category_id'];
                $orderitemobj->user_id            = $uid;
                $orderitemobj->quantity           = $orderitemv['quantity'];
                $orderitemobj->capacity           = $orderitemv['capacity'];
                $orderitemobj->mrp_price          = $orderitemv['mrp_price'];
                $orderitemobj->mrp_discount       = $orderitemv['mrp_discount'];
                $orderitemobj->coupon_discount    = $orderitemv['coupon_discount'];
                $orderitemobj->subtotal           = $orderitemv['subtotal'];
                $orderitemobj->save();
                $upinventory              = $this->updateInventory($orderitemv);
                $productconfigcredits     = Productconfig::where(['id' => $orderitemv['productconfig_id']])->get(['credits'])->toArray();
                $sendcredits              = $productconfigcredits[0]['credits'];
                $addpoints                = $this->CreditsToUser($sendcredits, 'add');
            }
            
            /* save order*/        

           //lottery ticket code//
           $lottery_products =  $this->findLotteryProducts($uid);
		   if(count($lottery_products)>0)
		   {
			    $user1 = auth()->user();
			   foreach ($lottery_products as $lottery_product) {
				   $data = array(
					   'lottery_id' => $lottery_product->lottery_id,
					   'order_id' => $order_id,
					   'productconfig_id' => $lottery_product->productconfig_id,
					   'user_id' => $uid
				   );
				$loterTkt=$this->saveLottery($data);
				
				$data = array(
					'lotterynumber'=> $loterTkt->lotterynumber,
					 'name'      =>  $user1->name,
					'email'     =>  $user1->email       
				);
				Mail::to($user1->email)->send(new BuyLotteryMail($data));	
				
			   }
		   }
           //Lottery ticket code//

            //Commission//
            $commission_charge = Supermarket::find( $orderdetails['supermarket_id'])->commission_percentage;
        
            $commission_payable = ($commission_charge/100)*$orderdetails['subtotal'];
            $commission = new Commission;
            $commission->order_id = $order_id;
            $commission->supermarket_id = $orderdetails['supermarket_id'];
            $commission->payable_to = 1;
            $commission->payable_from = Vendor::where('supermarket_id',$orderdetails['supermarket_id'])
            ->value('user_id');
            $commission->commission_charges = $commission_charge;
            $commission->order_amount = $orderdetails['subtotal'];
            $commission->commission_payable = $commission_payable;
            $commission->save();
            //Commission//

            $sh =  new Shipping;
            $sh->order_id =  $order_id;
            $sh->vendor_id =  $commission->payable_from;
            $sh->supermarket_id =  $orderdetails['supermarket_id'];
            $sh->order_id =  $order_id;
            $sh->address_id =  $request->addressid;
            $sh->save();
            //return $sh;
            $shipping_history =  new Shippinghistory;
            $shipping_history->shipping_id = $sh->id;
            $shipping_history->shipping_status = Constant::where('constant_type','SHIPPING_STATUS')->first()->value('id');
            $shipping_history->status_message = trans('lang.orderplaced');
            $shipping_history->save();
            //return $shipping_history;  
            
            /* deducting credits to user */ 
               $deductcredit = $this->CreditsToUser($request->rewards,'remove');
               if($deductcredit == 0) {
                $rewards = 0;
               } else if($deductcredit == 1) {
                $rewards = $request->rewards;
                $newsubtotal = $orderdetails['subtotal'] - $rewards;
                $updateorder = Order::where(['id' => $order_id])->update(['applied_reward' => $rewards, 'subtotal' => $newsubtotal]);
               }
            /* deducting credits to user */ 

            /* discard cart */
            Cart::where(['user_id' => $uid])->delete();
            CartItem::where(['user_id' => $uid])->delete();
            Persistantcart::Where(['user_id' => $uid])->delete();
            /* discard cart*/

            /* save payments*/
                $paymentobj = new Payment;
                $paidamount = (@$request->amount - @$rewards);
                $paymentobj->amount         = $request->amount;
                $paymentobj->debit_points   = $rewards;
                $paymentobj->order_id       = $order_id;
                $paymentobj->paid_amount    = $paidamount;
                //$paymentobj->payment_token  = $paymenttoken;
                $paymentobj->payment_type   = $payment_type;
                $paymentobj->save();
            /* save payments*/

           /*  Mail and notifications for order */        
            //Order placed Notification to Vendor Admin Panel
            // $vendor_id = Supermarket::findVendorID($orderdetails['supermarket_id']);
            // $vuser = User::find($vendor_id);
			$vendor= Supermarket::findVendorID($orderdetails['supermarket_id']);
            $vuser = User::find($vendor->user_id);
           // $vuser->notify(new NewOrderNotification($uniqueorder));
            //Order placed Notification to Vendor Admin Panel 
            $user = auth()->user();
           // $user->notify(new NewOrderNotification($uniqueorder));
            $data = array(
                'name'      => $user->name,
                'email'     => $user->email,
                'order_id'  => $order_id,
                'ordernumber'  => $uniqueorder
        
            );
			//$css=['email'=>$vuser->email];
			//$user = auth()->user();
			 $admin = User::whereHas('roles', function($q){$q->where('name', 'Admin'); })->first();
            Mail::to($user->email)->cc([$vuser->email,$admin->email])->send(new PlacedOrderMail($data));
			
            $notidata['title'] = 'Order Placed';
            $notidata['message'] = 'Order-Id: '.$uniqueorder.' - Order is placed.';
            $notidata['image'] = '';
            $notidata['user']  = $user->id;
            $this->sendNotification($notidata);
        /*  Mail and notifications for order */

            /* Cash Money Points */
                
                $reffered = $user->used_refer_code;
                if($reffered) {
                    $referred_user        = User::Where(['user_refer_code' => $reffered])->get()->toArray();            
                    $tocredituser         = $referred_user[0]['id'];
                    $updatepoints         = Supermarket::Where(['id' => $orderdetails['supermarket_id']])->get(['cash_money'])->toArray();            
                    $cashpoints           = $updatepoints[0]['cash_money'];
                    $newcashpoints        = $referred_user[0]['cash_credits'] +  $cashpoints;
                    User::Where(['id' => $tocredituser])->update(['cash_credits' => $newcashpoints]);

                    $notidata['title']      = 'Cash Money Credited';
                    $notidata['message']    = 'Cash Money: '.$cashpoints.' - Credited to the account.';
                    $notidata['image']      = '';
                    $notidata['user']       =  $tocredituser;
                    $this->sendNotification($notidata);
                }
            /* Cash Money Points */

            $message = trans('lang.orderdonestatus');
            $redata = array('orderid' => $order_id, 'ordernumber' => $uniqueorder);
            return $this->customerrormessage($message,$redata,200);
        }
    }

    public function orderlist(Request $request) {
        App::setLocale($request->header('locale'));
        $userdata = auth()->user()->toArray();
        $userid = $userdata['id'];
        $orders = Order::with('orderitems','address','address.area')->where(['user_id' => $userid])->orderBy('id', 'DESC')->get()->toArray();
        foreach($orders as $orderk => $orderv) {            
            $supermarketdt = Supermarket::where(['id' => $orderv['supermarket_id']])->get(['name']);
            $orders[$orderk]['supermarket_name'] = $supermarketdt[0]['name'];
        }        
        $error = array();
        $message = trans("lang.success");
        $redata = array('order' =>$orders);
        return $this->customerrormessage($message,$redata,200);
    }

    public function orderview(Request $request) {
        App::setLocale($request->header('locale'));
        $orderobj = new Order;
        $validator = Validator::make($request->all(), [
            'id'         => 'required|int|exists:orders,id'
        ]);
        if ($validator->fails()) {
            return $this->erroroutput($validator);
        }
        $id = $request->id;
        //$orderdata = $orderobj->getInvoiceDetailsbyOrderId($id);  
        $orderdata = Order::with('orderitems','address')->where(['orders.id' => $id])->get()->toArray();           
        foreach($orderdata as $orderk => $orderv) {
            $supermarketdt = Supermarket::where(['id' => $orderv['supermarket_id']])->get(['name']);
            $orderdata[$orderk]['supermarket_name'] = $supermarketdt[0]['name'];
        }   
        foreach($orderdata[0]['orderitems'] as $orderitemk => $orderitemv) {
            $productdetails = Product::Where(['id' => $orderitemv['product_id']])->get(['name'])->toArray();            
            $orderdata[0]['orderitems'][$orderitemk]['productname'] = $productdetails[0]['name'];            
        }
        $message = trans("lang.success");
        $redata = array('order' =>$orderdata);
        return $this->customerrormessage($message,$redata,200); 
    }

    public function cancelorder(Request $request) {
        App::setLocale($request->header('locale'));
        $validator = Validator::make($request->all(), [
            'id'         => 'required|int|exists:orders,id'
        ]);
        if ($validator->fails()) {
            return $this->erroroutput($validator);
        }        
        
        // order cancel process
        $order = Order::find($request->id);
        //return $order;
        if($order->order_status == 5 || $order->order_status == 6){
            $message = trans("lang.orderAlreadyCancelled");
            $redata = array();
            return $this->customerrormessage($message,$redata,200);
        }
        $shipping_id = DB::table('shippings')
                        ->where('shippings.order_id',$order->id)
                        ->get();             
        $status_code = Constant::where('constant_type','SHIPPING_STATUS_FRONTEND')->get();
        if($status_code) {
        $order->order_status = @$status_code[0]->id;
        $order->save();
        }
        
        if($shipping_id) {
        Shippinghistory::where('shipping_id',@$shipping_id[0]->id)->update(['is_complete' => 1]);
        $sh = new Shippinghistory;

        $sh->shipping_id = @$shipping_id[0]->id;
        $sh->shipping_status = @$status_code[0]->id;
        $sh->status_message = "Order Cancelled by you";
        $sh->is_complete = 1;
        $sh->save();
        }
        //check for lottery//
            Lotteryticket::where('order_id',$request->id)->update(['status' => 0]);
        //check for lottery//
        //commissions//
        $c = Commission::where('order_id',$request->id)->get();
        $commission = Commission::find($c[0]->id);
        $commission->status = 0;
        $commission->save();
        //commissions//
        
        //Notifications to user and vendor
        $vendor_id = Vendor::where('supermarket_id',$order->supermarket_id)->value('user_id');        
        $vuser = User::find($vendor_id);        
       // $vuser->notify(new CancelOrderNotification($order));
        $user = auth()->user();
       // $user->notify(new CancelOrderNotification($order));
        //Mails

        $data = array(
            'name' => $user->name,
            'email' => $user->email,
            'order' => $order,
 
        );
        Mail::to($user->email)->send(new cancelledOrderMail($data));
            $notidata['title'] = 'Order Cancelled by user';
            $notidata['message'] = 'Order-Id: '.$order->ordernumber.' - Order is Cancelled.';
            $notidata['image'] = '';
            $notidata['user'] = $order->user_id;
            
        $this->sendNotification($notidata);
        $message = trans("lang.success");
        $redata = array();
        return $this->customerrormessage($message,$redata,200);
    }

    public function setproductexpiredate(Request $request) {        
        $i = 0;        
        foreach($request->orderid as $pk=>$pv) {            
            $id = $request->orderitem_id[$i];
            $product_expiry = $request->product_expiry[$i];
            OrderItem::where(['id' => $id])->update(['product_expiry' => $product_expiry]);        
            $i++;
        }
        return redirect()->route('order.show', ['id' => $request->orderid[0]])->with('success','Product expiry is assigned.');
    }

    public function sendProductExpirationNotification() {
            // get all order items for next day expiry , get user tokens, in each user loop send notification for all products expiry
            $pastdate = date('Y-m-d',strtotime("+1 days"));
            $orderdata = OrderItem::where(['product_expiry' => $pastdate])->groupBy(['user_id'])->get(['user_id'])->toArray();            
            //echo '<pre/>'; print_r($orderdata); exit;
            foreach($orderdata as $orderk => $orderv) {                
                $orderinfo = DB::select("SELECT p.name,o.ordernumber FROM products p INNER JOIN order_items oi ON  p.id = oi.product_id INNER JOIN productconfigs pc ON pc.product_id = p.id INNER JOIN orders o ON o.id = oi.order_id WHERE oi.product_expiry = '".$pastdate."' AND oi.user_id = '".$orderv['user_id']."'");                                
                $orderpinfo = array_map("current", $orderinfo);                
                $productnames = implode(",", $orderpinfo);

                $notidata['title'] = 'Products Expiry Information';
                $notidata['message'] = 'Order-Id: '.$orderinfo[0]->ordernumber.' - Products - '.$productnames.' - will expire by - '.$pastdate;
                $notidata['image'] = '';
                $notidata['user']  = $orderv['user_id'];
                $this->sendNotification($notidata);
            }

            echo 'sent notifications.';            
            
    }

    /* APIs*/
}
