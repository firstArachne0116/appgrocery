<?php

namespace App\Http\Controllers;

use App\User;
use App\Vendor;
use App\Commission;
use App\Supermarket;
use Illuminate\Http\Request;
use App\Mail\CommissionPaymentMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\CommissionNotification;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$commissions = Commission::where('is_complete',0)->get();
        $sm = Supermarket::getValidSupermarkets();
        return view('commissions.index',compact('sm'));
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
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function show(Commission $commission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function edit(Commission $commission)
    {
        return view('commissions.edit',compact('commission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commission $commission)
    {
        //return $request;
        $this->validate($request,[
            'commission_status' => 'required|integer',
            'status_message' => 'required|max:1023'
        ]);
        $commission->is_complete = $request->input('commission_status');
        $commission->status_message = $request->input('status_message');
        $commission->updated_at = time();
        $commission->save();
        $vendor_email = Commission::findVendorDetailsfromOrder($commission->id);
        //return User::find($commission->payable_from)->value('name');
        //return $commission;
        $user = Auth::user();
        //$user->notify(new CommissionNotification($commission));
        //Mail::to($vendor_email[0]->email)->send(new CommissionPaymentMail($commission));
        return redirect()->route('commission.index')->with('success','Commission Status was updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commission $commission)
    {
        //
    }
    public function showreport(Request $request){
        $vendor = Vendor::getSupermarketId();
        $r= new Commission;
        
        switch ($request->input('report_type')) {
            case "1":
                $to_date= date("Y-m-d");
                $from_date= date('Y-m-d', strtotime('-7 days'));
                if(User::checkRole('vendor')){
                    $commissions = $r->showReport($from_date,$to_date,$vendor[0]['supermarket_id']);
                }
                if(User::checkRole('admin')){
                    $commissions = $r->showReport($from_date,$to_date,$request->input('supermarket_id'));
                }
                break;
            case 2:
                 $to_date= date("Y-m-d");
                 $from_date= date('Y-m-d', strtotime('-30 days'));
                 if(User::checkRole('vendor')){
                    $commissions = $r->showReport($from_date,$to_date,$vendor[0]['supermarket_id']);
                }
                if(User::checkRole('admin')){
                    $commissions = $r->showReport($from_date,$to_date,$request->input('supermarket_id'));
                }               
                break;
            case 3:
            $from_date = $request->input('date_from');
            $to_date = $request->input('date_to'); 
            if(User::checkRole('vendor')){
                $commissions = $r->showReport($from_date,$to_date,$vendor[0]['supermarket_id']);
            }
            if(User::checkRole('admin')){
                $commissions = $r->showReport($from_date,$to_date,$request->input('supermarket_id'));
            }
                break;
            default:
                return redirect()->route('commissions.index')->with('There was some error in recovering your report');
        }
        $sm = Supermarket::getValidSupermarkets();
        if (count($commissions) == 0){
            \Session::flash('success','There are no commissions for that time period/Supermarket');
            return view('commissions.index',compact('sm'));
        }
        \Session::forget('success');
        return view('commissions.index',compact('commissions','sm'));
    }
}
