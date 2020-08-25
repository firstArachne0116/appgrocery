<?php

namespace App\Http\Controllers;

use DB;
use App\City;
use App\User;
use App\State;
use App\Address;
use App\Country;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use App\Http\Traits\ValidationTrait;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
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
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }

    /*API Calls*/

    public function addaddress(Request $request) {
        App::setLocale($request->header('locale'));
        $userdata = auth()->user()->toArray();
        $validator = Validator::make($request->all(), [
            'honorific' => 'bail|required',
            'name'      => 'bail|required|min:3',
            'houseno'   => 'bail|required',
            'society'   => 'bail|required',
            'locality'  => 'bail|required',
            'addressname' => 'bail|required',
            'country'   =>  'bail|required|int',
            'city'      =>  'bail|required|int',
            'area_id'      =>  'bail|required|int',
        ]);
        if ($validator->fails()) {            
            return $this->erroroutput($validator);
        }
        $address = new Address;
        $address->user_id       = $userdata['id'];
        $address->honorific     = $request->honorific;
        $address->name          = $request->name;
        $address->houseno       = $request->houseno;
        $address->society       = $request->society;
        $address->locality      = $request->locality;
        $address->addressname   = $request->addressname;
        $address->country_id    = $request->country;
        $address->city_id       = $request->city;
        $address->area_id       = $request->area_id;
        $address->save();
        $redata = array();
        $message    = trans('lang.success');
        return $this->customerrormessage($message,$redata,200);        
    }

    public function listaddress(Request $request) { 
        App::setLocale($request->header('locale'));       
        $userid    = auth()->user()->id;        
        $list      = Address::with(['city','area'])->where(['user_id' => $userid])->whereNull('deleted_at')->orderBy('id','DESC')->get();
        // foreach($list as $lk =>$lv) {
            // if($list[$lk]['country_id'] !== '') {
                // $namelist = Country::where(['id'=> $list[$lk]['country_id']])->select('name')->get();                
               // if($namelist) {  $list[$lk]['country_id'] = @$namelist[0]->name; }
            // }
            // if($list[$lk]['state_id'] !== '') {
            //     $namelist = State::where(['id'=> $list[$lk]['state_id']])->select('name')->get();
            //     $list[$lk]['state_id'] = $namelist[0]->name;
            // }
            // if($list[$lk]['city_id'] !== '') {
                // $namelist = State::where(['id'=> $list[$lk]['city_id']])->select('name')->get();
                // if($namelist) { $list[$lk]['city_id'] = @$namelist[0]->name; }
            // }
			// if(!empty($lv->area))
			// {
				// $list[$lk]['area_name']=$lv->area->name;
			// }
       // }                
        $redata     = array('addresslist' => $list);
        $message    = trans('lang.success');
        return $this->customerrormessage($message,$redata,200);        
    }

    public function deleteaddress(Request $request) {
        App::setLocale($request->header('locale'));
        $id = $request->id;
        Address::where(['id' => $id])->delete();        
        $redata = array();
        $message    = trans('lang.success');
        return $this->customerrormessage($message,$redata,200);
    }
}
