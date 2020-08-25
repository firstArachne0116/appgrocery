<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Constant;
use App\Supermarket;
use App\Shippinghistory;
use Illuminate\Http\Request;
use App\Mail\sendInvoiceMail;
use App\Mail\ShippingstatusMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Traits\NotificationTrait;

class ShippingController extends Controller
{
	use NotificationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $placed_orders = Shippinghistory::getstatusByType(1);
         $in_progress_orders =  Shippinghistory::getstatusByType(2);
         $transit_orders =  Shippinghistory::getstatusByType(3);
         $delivered_orders =  Shippinghistory::getstatusByType(4);
    
        return view('shipping.index',compact('placed_orders','in_progress_orders','transit_orders','delivered_orders'));

    }
    public function list(){
        
        $sm = Supermarket::getValidSupermarkets();
        return view('shipping.list',compact('sm'));
    }
    public function showshipping(Request $request){
        $placed_orders = Shippinghistory::getstatusByTypeAndSupermarketid(1,$request->supermarket_id);
        $in_progress_orders =  Shippinghistory::getstatusByTypeAndSupermarketid(2,$request->supermarket_id);
        $transit_orders =  Shippinghistory::getstatusByTypeAndSupermarketid(3,$request->supermarket_id);
        $delivered_orders =  Shippinghistory::getstatusByTypeAndSupermarketid(4,$request->supermarket_id);
        $sm = Supermarket::getValidSupermarkets();
        $shipping = true;
        return view('shipping.list',compact('placed_orders',
        'in_progress_orders','transit_orders',
        'delivered_orders','sm','shipping'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$status=  \Config::get('constants.shipping_status');
        $shipping= Shippinghistory::find($id);
        $statuses = Constant::select('id','data')->where('constant_type','SHIPPING_STATUS')->get();
        //return $shipping;
        return view('shipping.edit',compact('shipping','statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request,[
            'shipping_status' => 'required|integer|min:1',
            'status_message' => 'required|max:255',
        ]);
        $shipping = Shippinghistory::find($id);
        $shipping->is_complete = 1;
        $shipping->save();
        $new_shipping_entry = New Shippinghistory;
        $new_shipping_entry->shipping_id = $shipping->shipping_id;
        $new_shipping_entry->shipping_status = $request->input('shipping_status');
        $new_shipping_entry->status_message = $request->input('status_message');
        $new_shipping_entry->save();
        $order_id = Shippinghistory::findOrderIdByShippingId($shipping->shipping_id);   
        $orderUpdate = Order::find($order_id[0]->order_id);
        $orderUpdate->order_status = $request->input('shipping_status');
        $orderUpdate->save();
		//dd($shipping->shipping_id);
        $shippingdata = Shippinghistory::where(['shipping_id'=>$shipping->shipping_id])->get();
        $userData= Shippinghistory::getUserDataforShipping($shipping->shipping_id);
        // if ($request->input('shipping_status') == 4){
        //     $order_id = DB::table('shippings')
        //     ->select('shippings.order_id as order_id')
        //     ->where('shippings.id',$shipping->shipping_id)
        //     ->get();
        //     //return $order_id;
        //     $o = new Order;
        //     $data = $o->getInvoiceDetailsbyOrderId($order_id[0]->order_id);
        //     return $data;
        //     Mail::to($userData[0]->user_email)->send(new sendInvoiceMail($data));
        // }
		   $status=Constant::find($orderUpdate->order_status)->data;
		    $notidata['title'] = 'Order '.$status;
            $notidata['message'] = 'Order-Id: '.$orderUpdate->ordernumber.' - Order '.$status;
            $notidata['image'] = '';
            $notidata['user']  = $orderUpdate->user_id;
            $this->sendNotification($notidata);
			
        Mail::to($userData[0]->user_email)->send(new ShippingstatusMail($userData,$shippingdata));
        if (User::checkRole('vendor')){
            return redirect()->route('shipping.index')->with('success','Shipping Status was Updated!');
        }
        if (User::checkRole('admin')){
            return redirect()->route('shipping.list')->with('success','Shipping Status was Updated!');
        }     

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
