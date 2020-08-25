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
use App\OrderItem;
use App\Commission;
use App\Lotteryticket;
use App\Productconfig;
use App\Persistantcart;
use App\Shippinghistory;
use App\Shipping;
use App\Supermarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CancelOrderNotification;
use App\Notifications\NewOrderNotification;
use App\Mail\PlacedOrderMail;
use App\Mail\CancelledOrderMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\BuyLotteryMail;
use App\Http\Traits\NotificationTrait;


class OrderController extends Controller
{
	 use NotificationTrait;

    public function findLotteryProducts($user_id,$order_id){
       // return Cart::checkforLotteryProducts($user_id,$order_id);
        return Cart::checkforOrderLotteryProducts($user_id,$order_id);
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

    public function checkInventory($orderitemv) {   
        $uid  = Auth::user()->id;         
        $productdata = Productconfig::where(['id' => $orderitemv['productconfig_id']])->get()->toArray();        
        if($productdata[0]['quantity'] >=  $orderitemv['quantity']) {
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
        $creditsold = auth()->user()->credits;
        if($type == 'add') {
            $updatedcredits = $creditsold + $newcredits;
        } if ($type == 'remove') {
            $updatedcredits = $creditsold - $newcredits;
        }        
        User::where(['id' => $userid])->update(['credits' => $updatedcredits]);
        return 1;
    }

    

    public function miscOrderTask($order_id,$supermarketid,$subtotal,$addressid) {
        $userdata  = auth()->user()->toArray();
        $uid       = $userdata['id'];
        //lottery ticket code//
        $lottery_products =  $this->findLotteryProducts($uid,$order_id);           
        foreach ($lottery_products as $lottery_product) {            
            $data = array(
                'lottery_id' => $lottery_product->lottery_id,
                'order_id' => $order_id,
                'productconfig_id' => $lottery_product->productconfig_id,
                'user_id' => $uid
            );
        $this->saveLottery($data);
        }        
        //Lottery ticket code//
            
        //Commission//
            $commission_charge = Supermarket::find( $supermarketid)->commission_percentage;
            $commission_payable = ($commission_charge/100)*$subtotal;
            $commission = new Commission;
            $commission->order_id = $order_id;
            $commission->supermarket_id = $supermarketid;
            $commission->payable_to = 1;
            $commission->payable_from = Vendor::where('supermarket_id',$supermarketid)
            ->value('user_id');
            $commission->commission_charges = $commission_charge;
            $commission->order_amount = $subtotal;
            $commission->commission_payable = $commission_payable;
            $commission->save();
        //Commission//


        $sh =  new Shipping;
        $sh->order_id =  $order_id;
        $sh->vendor_id =  $commission->payable_from;
        $sh->supermarket_id =  $supermarketid;
        $sh->order_id =  $order_id;
        $sh->address_id =  $addressid;
        $sh->save();
        //return $sh;
        $shipping_history =  new Shippinghistory;
        $shipping_history->shipping_id = $sh->id;
        $shipping_history->shipping_status = Constant::where('constant_type','SHIPPING_STATUS')->first()->value('id');
        $shipping_history->status_message = 'Your order is Placed.';
        $shipping_history->save();
        //return $shipping_history;
    } 

    

    public function placeorder(Request $request) {        
        $addressid          = $request->order_address_id;
        $order_comments     = $request->order_comments;
        $order_method       = $request->payment_method;       
        if(Auth::check()) { 
            $uid  = Auth::user()->id; 
            $cart_to_order = Cart::where(['user_id' => $uid])->get()->toArray();
            if(isset($cart_to_order[0])) { $orderdetails = $cart_to_order[0]; } 
            else { return redirect()->route('cart')->with('message', "Your cart is empty"); }
            $cartitem_to_order = CartItem::where(['user_id' => $uid])->get()->toArray();

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
                return redirect('/cart')->with('message', 'Some of the cart Items have updated price and quantity. Please recheck before ordering.');
            }            
        
            /* save order*/        
            if(!empty($order_method)) {
                $orderobj = new Order;                
                $uniqueorder = rand(100000,999999);
                $orderobj->supermarket_id  =  $orderdetails['supermarket_id'];
                $orderobj->user_id         =  $orderdetails['user_id'];
                $orderobj->ordernumber     =  $uniqueorder;
                $orderobj->address_id      =  $addressid;
                $orderobj->mrp_price       =  $orderdetails['mrp_price'];
                $orderobj->mrp_discount    =  $orderdetails['mrp_discount'];
                $orderobj->coupon_discount =  $orderdetails['coupon_discount'];
                $orderobj->coupon_id       =  $orderdetails['coupon_id'];
                $orderobj->delivery_charge =  $orderdetails['delivery_charge'];
                $orderobj->service_charge  =  $orderdetails['service_charge'];
                $orderobj->delivery_time   =  $orderdetails['delivery_time'];
                $orderobj->no_of_items     =  $orderdetails['no_of_items'];
                $orderobj->applied_reward     =  $orderdetails['applied_reward'];
                $orderobj->subtotal        =  $orderdetails['subtotal'];
                $orderobj->save();
				$uniqueorder='1'.sprintf('%06d', $orderobj->id );
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
                    $upinventory       = $this->updateInventory($orderitemv);
                    $productconfigcredits     =  Productconfig::where(['id' => $orderitemv['productconfig_id']])->get(['credits'])->toArray();
                    $sendcredits              = $productconfigcredits[0]['credits'];
                    $addpoints                = $this->CreditsToUser($sendcredits, 'add');
                }
                /* save order*/
                /* commision, lottery and shipping status */
                    $tasks = $this->miscOrderTask($order_id,$orderdetails['supermarket_id'],$orderdetails['subtotal'],$addressid);
                /* commision, lottery and shipping status */                

                /* discard cart */
                Cart::where(['user_id' => $uid])->delete();
                CartItem::where(['user_id' => $uid])->delete(); 
                Persistantcart::Where(['user_id' => $uid])->delete();    
                session(['cartcount' => '0', 'cartinfo' => '']);
                /* discard cart*/
                
                

                /* save payments*/
                if($order_method == 'cod') { $paymenttoken = ''; }
                    $paymentobj                 = new Payment;
                    $paymentobj->amount         = $orderdetails['mrp_price'];
                    $paymentobj->order_id       = $order_id;
                    $paymentobj->paid_amount    = $orderdetails['subtotal'];
                    //$paymentobj->payment_token  = $paymenttoken;
                    $paymentobj->payment_type   = $order_method;
                    $paymentobj->save();
                /* save payments*/  
                
                /*  Mail and notifications for order */

                    //Order placed Notification to Vendor Admin Panel
                    $vendor= Supermarket::findVendorID($orderdetails['supermarket_id']);
                    $vuser = User::find($vendor->user_id);
                   // $vuser->notify(new NewOrderNotification($uniqueorder));
                    //Order placed Notification to Vendor Admin Panel 
                    
                    $user = auth()->user();
                   // $user->notify(new NewOrderNotification($uniqueorder));
                    $admin = User::whereHas('roles', function($q){$q->where('name', 'Admin'); })->first();
                    $data = array(
                        'name' => $user->name,
                        'email' => $user->email,
                        'order_id' => $order_id,
						'ordernumber'  => $uniqueorder
             
                    );
                    Mail::to($user->email)->cc([$vuser->email,$admin->email])->send(new PlacedOrderMail($data));
			
					$notidata['title'] = 'Order Placed';
					$notidata['message'] = 'Order-Id: '.$uniqueorder.' - Order is placed.';
					$notidata['image'] = '';
					$notidata['user']  = $user->id;
					$this->sendNotification($notidata);
				//lottery ticket code//
						 $lottery_products =  $this->findLotteryProducts($uid,$order_id);					
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
			
                    
                /*  Mail and notifications for order */

                /* Cash Money Points */
                    $user = auth()->user();
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

            }  
            return redirect()->route('order.show', ['id' => $order_id]);  
        }        
        
    }
    


    // public function orderreceived() {
    //     return view('orders.order_received');
    // }
    public function show(Request $request) {
        $o = new Order;
        $order = $o->getInvoiceDetailsbyOrderId($request->id);
        //return $order;
        $so = new Order;
        $shippings = $so->getShippingInfoByOrderId($request->id);
        //return $shippings; 
        return view('orders.show',compact('shippings','order'));

    }
    public function ordercancel(Request $request) {
        $order = Order::find($request->id);
        $shipping_id = DB::table('shippings')
                        ->where('shippings.order_id',$order->id)
                        ->get();             
        $status_code = Constant::where('constant_type','SHIPPING_STATUS_FRONTEND')->get();
        $order->order_status = $status_code[0]->id;
        $order->save();
        Shippinghistory::where('shipping_id',$shipping_id[0]->id)->update(['is_complete' => 1]);
        $sh = new Shippinghistory;
        $sh->shipping_id = $shipping_id[0]->id;
        $sh->shipping_status = $status_code[0]->id;
        $sh->status_message = "Order Cancelled by you";
        $sh->is_complete = 1;
        $sh->save();
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
        $vuser->notify(new CancelOrderNotification($order));
        $user = auth()->user();
        $user->notify(new CancelOrderNotification($order));
        //Mails

        $data = array(
            'name' => $user->name,
            'email' => $user->email,
            'order' => $order,
 
        );
        Mail::to($user->email)->send(new cancelledOrderMail($data));

        return redirect()->route('order.show',$request->id); 

    }


    
}
