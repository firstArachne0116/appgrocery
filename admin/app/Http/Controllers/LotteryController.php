<?php

namespace App\Http\Controllers;

use App\User;
use App\Lottery;
use App\Supermarket;
use App\Lotteryticket;
use App\Constant;
use Illuminate\Http\Request;
use App\Mail\LotteryWinnerMail;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Session\Session;
use Auth;
use Illuminate\Support\Facades\App;
use App\Http\Traits\ValidationTrait;

class LotteryController extends Controller
{
    use ValidationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lotteries = Lottery::where('status','!=',0)->get();
        return view('lotteries.index',compact('lotteries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sm = Supermarket::select('id','name')->where('status', '!=',0)->get();
        return view('lotteries.create',compact('sm'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $this->validate($request,[
            'lottery_name' => "required|max:255",
            'name_arabic' => "required|max:255",
            'description' => "required|max:1023",
            'description_arabic' => "required|max:1023",
            'lottery_rule' => "required|max:1023",
            'valid_from' => 'required|date|after:yesterday',
            'valid_till' => 'required|date|after:valid_from',

        ]);
        $lottery = new Lottery;
        if ($request->input('lottery_type') == 1) {
            $this->validate($request,[
                'supermarket_id' => "required|integer"
            ]);
            $lottery->supermarket_id = $request->input('supermarket_id');
        } 
        else {
            $lottery->supermarket_id = -1;
        }

        $lottery->lottery_type =  $request->input('lottery_type');
        $lottery->name = $request->input('lottery_name');
        $lottery->name_arabic = $request->input('name_arabic');
        $lottery->description = $request->input('description');
        $lottery->description_arabic = $request->input('description_arabic');
        $lottery->lottery_rule = $request->input('lottery_rule');    
        $lottery->valid_from = $request->input('valid_from');   
        $lottery->valid_till = $request->input('valid_till'); 
        $lottery->save();
        return redirect()->route('lottery.index')->with('success','Lottery Reward was added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function show(Lottery $lottery)
    {
        $sm = '';
        if ($lottery->lottery_type == 1){
            $sm = Supermarket::select('name')->where('id',$lottery->supermarket_id)->get();
        }
        //return $lottery;
        return view('lotteries.show',compact('lottery','sm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function edit(Lottery $lottery)
    {
        $sm = Supermarket::select('id','name')->where('status', '!=',0)->get();
        return view('lotteries.edit',compact('lottery','sm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lottery $lottery)
    {
        $this->validate($request,[
            'lottery_name' => "required|max:255",
            'name_arabic' => "required|max:255",
            'description' => "required|max:1023",
            'description_arabic' => "required|max:1023",
            'lottery_rule' => "required|max:1023",
            'valid_from' => 'required|date|after:yesterday',
            'valid_till' => 'required|date|after:valid_from',

        ]);
        $lottery->lottery_rule = $request->input('lottery_rule');
        $lottery->lottery_type = $request->input('lottery_type');
        if ($request->input('lottery_type') == 1) {
            $lottery->supermarket_id = $request->input('supermarket_id');
        }
        else{
            $lottery->supermarket_id = -1;
        }
        $lottery->description_arabic = $request->input('description_arabic');
        $lottery->description = $request->input('description');
        $lottery->name_arabic = $request->input('name_arabic');
        $lottery->name = $request->input('lottery_name');
        $lottery->valid_from = $request->input('valid_from');   
        $lottery->valid_till = $request->input('valid_till'); 
        $lottery->lottery_rule = $request->input('lottery_rule');
        $lottery->is_enabled = $request->input('status');

        $lottery->save();

         return redirect()->route('lottery.index')->with('success','Lottery was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lottery $lottery)
    {
        $lottery->status = 0;
        $lottery->is_enabled = 0;
        $lottery->save();
        return redirect()->route('lottery.index')->with('success','Lottery was deleted successfully');
        
    }
    public function winner(){
        $lotteries =  Lottery::getValidLotteries();
        return view('lotteries.winner',compact('lotteries'));
    }
    public function winnerupload(Request $request){
       $this->validate($request,[
            'lottery_id' => 'required|integer',
            'winner_id' => 'required|integer',
            'message' => 'required|max:255',
       ]);  
       $ticket_id = Lotteryticket::where([['user_id',$request->winner_id],['lottery_id',$request->lottery_id]])->get();
       $lw = Lotteryticket::find($ticket_id[0]->id);
       $lw->lottery_winner = 1;
       $lw->message = $request->message;
       $lw->save();
       $user = User::find($request->winner_id);
       $lottery = Lottery::find($request->lottery_id);

       $data = array(
           'name' => $user->name,
           'email' => $user->email,
           'lottery_name' => $lottery->name,

       );
       Mail::to($user->email)->send(new LotteryWinnerMail($data));
       $lottery->is_enabled = 0;
       $lottery->save();
       return redirect()->route('lottery.winner')->with('success','Lottery winner was uploaded successfully!');

    }
    public function reports(){
        $lotteries = Lottery::getValidLotteries();
        $lotteryreports = [];
        return view('lotteries.report',compact('lotteries','lotteryreports'));    
        
    }
    public function showlotteryreport(Request $request) {
        $lotteryreports = Lotteryticket::getLotteryReports($request->lottery_id);
        $lotteries = Lottery::getValidLotteries();
        if (count($lotteryreports) == 0 ){
            \Session::flash('success','There are no reports for this lottery');
            return view('lotteries.report',compact('lotteries','lotteryreports'));  
        }
        \Session::forget('success');
        return view('lotteries.report',compact('lotteries','lotteryreports'));  
        
    }

    public function boughtdeals(Request $request) {
        App::setLocale($request->header('locale'));
        $userid = Auth::user()->id;
        $lotteries = Lottery::boughtLotteryDetails($userid);
        //$lotteries = Lotteryticket::where(['user_id' => $userid])->get();
        $path      = Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data');
        if($lotteries) {            
            $redata = array("lotteries" => $lotteries, 'product_image_path' => $path);
            $message = trans("lang.success");
            return $this->customerrormessage($message,$redata,200); 
        } else {            
            $redata = array();
            $message = trans("lang.success");
            return $this->customerrormessage($message,$redata,200); 
        }
    }

    // public function wondeals() {
    //     $userid = Auth::user()->id;
    //     $lotteries = Lotteryticket::where(['user_id' => $userid, 'lottery_winner' => 1])->get();
    //     $path = Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data');
    //     if($lotteries) {            
    //         $redata = array("lotteries" => $lotteries, 'product_image_path' => $path);
    //         $msg = "Request Done";
    //         return response()->json(["message" => $msg,"data" => $redata,"status" => 200]);
    //     } else {            
    //         $redata = array();
    //         $msg = "No Data";
    //         return response()->json(["message" => $msg,"data" => $redata,"status" => 200]);
    //     }
    // }
}
