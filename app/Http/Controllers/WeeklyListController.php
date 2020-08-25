<?php

namespace App\Http\Controllers;

use App\Weeklylist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeeklyListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weeklylists = Weeklylist::getWeeklyList(Auth::user()->id);
        //return $weeklylists;
        return view('weeklylists.index',compact('weeklylists'));
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

        $weekly = new WeeklyList;
        $weekly->product_id            = $request->product_id;
        $weekly->productconfig_id      = $request->productconfig_id;
        $weekly->user_id               = $request->user_id;
        $weekly->status                = '1';
        $weekly->created_at             = date('Y-m-d H:i:s');
        $weekly->save();
        
        echo '1';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Weeklylist  $weeklylist
     * @return \Illuminate\Http\Response
     */
    public function show(Weeklylist $weeklylist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Weeklylist  $weeklylist
     * @return \Illuminate\Http\Response
     */
    public function edit(Weeklylist $weeklylist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Weeklylist  $weeklylist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Weeklylist $weeklylist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Weeklylist  $weeklylist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Weeklylist $weeklylist)
    {
        $weeklylist->delete();
        return redirect('/weeklylist')->with('success', 'List item  was removed!');
    }
}
