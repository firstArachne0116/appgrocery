<?php

namespace App\Http\Controllers;

use App\User;
use App\Report;
use App\Vendor;
use App\Supermarket;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $sm = Supermarket::getValidSupermarkets();
        return view('reports.index',compact('sm'));    
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
    public function list(){
        //return "hello";
        $sm = Supermarket::getValidSupermarkets();
        return view('reports.list',compact('sm'));

    }
    public function showreport(Request $request){
        
        
        $vendor = Vendor::getSupermarketId();
        $r= new Report;
        switch ($request->input('report_type')) {
            case "1":
                $to_date= date("Y-m-d");
                $from_date= date('Y-m-d', strtotime('-7 days'));
                if(User::checkRole('vendor')){
                    $reports = $r->showReport($from_date,$to_date,$vendor[0]['supermarket_id']);
                }
                if(User::checkRole('admin')){
                    $reports = $r->showReport($from_date,$to_date,$request->input('supermarket_id'));
                }
                break;
            case 2:
                 $to_date= date("Y-m-d");
                 $from_date= date('Y-m-d', strtotime('-30 days'));
                 if(User::checkRole('vendor')){
                    $reports = $r->showReport($from_date,$to_date,$vendor[0]['supermarket_id']);
                }
                if(User::checkRole('admin')){
                    $reports = $r->showReport($from_date,$to_date,$request->input('supermarket_id'));
                }               
                break;
            case 3:
            $from_date = $request->input('date_from');
            $to_date = $request->input('date_to'); 
            if(User::checkRole('vendor')){
                $reports = $r->showReport($from_date,$to_date,$vendor[0]['supermarket_id']);
            }
            if(User::checkRole('admin')){
                $reports = $r->showReport($from_date,$to_date,$request->input('supermarket_id'));
            }
                break;
            default:
                return redirect()->route('reports.index')->with('There was some error in recovering your report');
        }
        $sm = Supermarket::getValidSupermarkets();
        if ($reports[0]->no_of_orders == 0){
            \Session::flash('success','There are no reports for this Supermarket/Time period');
                return view('reports.index',compact('sm'));
        }
        \Session::forget('success');
        
        return view('reports.index',compact('sm','reports'));
        
        //return view('reports.index',compact('reports','sm'));
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
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }

    public function showsupermarketreport(Request $request){
        $r= new Report;
        switch ($request->input('report_type')) {
            case "1":
                $to_date= date("Y-m-d");
                $from_date= date('Y-m-d', strtotime('-7 days'));
                $orders = $r->showSupermarketReport($from_date,$to_date,$request->input('supermarket_id'));
                break;
            case 2:
                 $to_date= date("Y-m-d");
                 $from_date= date('Y-m-d', strtotime('-30 days'));
                $orders = $r->showSupermarketReport($from_date,$to_date,$request->input('supermarket_id'));
                break;
            case 3:
            $from_date = $request->input('date_from');
            $to_date = $request->input('date_to'); 
                $orders = $r->showSupermarketReport($from_date,$to_date,$request->input('supermarket_id'));
            
                break;
            default:
                return redirect()->route('reports.list')->with('There was some error in recovering your report');
                
        }
        $sm = Supermarket::getValidSupermarkets();
        if (count($orders) == 0){
            \Session::flash('success','There are no reports for this lottery');
                return view('reports.list',compact('sm'));
        }
        \Session::forget('success');
        return view('reports.list',compact('sm','orders'));
    }
}
