<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\City;
use App\User;
use App\State;
use App\Vendor;
use App\Country;
use App\Category;
use App\Constant;
use App\Supermarket;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use App\Http\Traits\ImageUploadTrait;
use App\Http\Requests\SupermarketRequest;
use App\Http\Traits\ValidationTrait;
use Illuminate\Support\Facades\Validator;

class SupermarketController extends Controller
{
    use ImageUploadTrait;
    use ValidationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sm = Supermarket::where('status','!=',0)->get();
        return view('supermarkets.index',compact('sm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all('name','id');
        return view('supermarkets.create',['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupermarketRequest $request)
    {
        
        $sm = new Supermarket;
        $sm->name = $request->input('name');
        $sm->name_arabic = $request->input('name_arabic');
        $sm->latitude = $request->input('latitude');
        $sm->longitude = $request->input('longitude');
        $sm->country_id = $request->input('country_id');
       // $sm->state_id = $request->input('state_id');
        $sm->city_id = $request->input('city_id');
        $sm->area_id = $request->input('area_id');
        $sm->address = $request->input('address');
        $sm->freedeliveryamount = $request->input('freedeliveryamount');
        $sm->fixeddeliveryamount = $request->input('fixeddeliveryamount');
        $sm->fixedserviceamount = $request->input('fixedserviceamount');
        $sm->commission_percentage = $request->input('commission_percentage');
        $sm->cash_money = $request->input('cash_money');
        $sm->deliverytime = $request->input('deliverytime');
        $sm->status = $request->input('status');
        if($request->hasfile('filename'))
        {
            $path = Constant::where('constant_type','SUPERMARKET_IMAGE_PATH')->value('data');
            $data = $this->uploadImage($request->file('filename'),$path); 
            $sm->image_path = json_encode($data);
        }
        $sm->save();
        return redirect()->route('supermarket.index')->with('success','Super Market was added successfully');
        
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supermarket  $supermarket
     * @return \Illuminate\Http\Response
     */
    public function show(Supermarket $supermarket)
    {
        $vendors = DB::table('users')
            ->join('vendors', 'users.id', '=', 'vendors.user_id')
            ->select('users.email','users.is_enabled','users.name','users.mobile','users.id','vendors.address', 'vendors.status')
            ->where('vendors.supermarket_id',$supermarket->id)->get();
       $sup = Supermarket::find($supermarket->id);
        $categories = $sup->categories()->where('parentid',0)->get();   
        return view('supermarkets.show',compact('vendors','supermarket','categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supermarket  $supermarket
     * @return \Illuminate\Http\Response
     */
    public function edit(Supermarket $supermarket)
    {
         
       
        return view('supermarkets.edit',['sm' => $supermarket,
            'countries' => Country::all('name','id'),  
            'states' => State::all('name','id'),  
            'city' => City::find($supermarket->city_id)  
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supermarket  $supermarket
     * @return \Illuminate\Http\Response
     */
    public function update(SupermarketRequest $request, Supermarket $supermarket)
    {
        //Validate request
        $sm = Supermarket::find($supermarket->id);
        $sm->name = $request->input('name');
        $sm->name_arabic = $request->input('name_arabic');
        $sm->latitude = $request->input('latitude');
        $sm->longitude = $request->input('longitude');
        $sm->country_id = $request->input('country_id');
        //$sm->state_id = $request->input('state_id');
        $sm->city_id = $request->input('city_id');
		$sm->area_id = $request->input('area_id');
        $sm->address = $request->input('address');
        $sm->freedeliveryamount = $request->input('freedeliveryamount');
        $sm->fixeddeliveryamount = $request->input('fixeddeliveryamount');
        $sm->fixedserviceamount = $request->input('fixedserviceamount');
        $sm->commission_percentage = $request->input('commission_percentage');
        $sm->cash_money = $request->input('cash_money');
        $sm->deliverytime = $request->input('deliverytime');
        $sm->is_enabled = $request->input('status');
        if($request->hasfile('filename'))
        {
            $file = json_decode($sm->image_path);
            $path = Constant::where('constant_type','SUPERMARKET_IMAGE_PATH')->value('data');
            $this->deleteIfExists($file,$path);
            $data = $this->uploadImage($request->file('filename'),$path); 
            $sm->image_path = json_encode($data); 
        }
        $sm->save();
        return redirect('/supermarket')->with('success', 'Supermarket updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supermarket  $supermarket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supermarket $supermarket)
    {
        $sm = Supermarket::find($supermarket->id);
        $sm->status = 0;
        $sm->is_enabled = 0;
        $sm->save();
        return redirect('/supermarket')->with('success', 'Supermarket was deleted!');
    }


/* API Calls */

    public function marketlist(Request $request) {
        App::setLocale($request->header('locale'));
        $latitude   = $request->latitude;
        $longitude  = $request->longitude;
        $country    = $request->country;
        $city       = $request->city;
        if(isset($latitude) && isset($longitude)) {
            $validator = Validator::make($request->all(), [
                'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
                'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
            ]);
            if ($validator->fails()) {
                return $this->erroroutput($validator);
            }
            $list = Supermarket::where(['latitude' => $latitude, 'longitude' => $longitude,'is_enabled'=>1])->get();
            $path = Constant::where('constant_type','SUPERMARKET_IMAGE_PATH')->value('data');

            $message = trans("lang.success");          
            $redata = array('list' => $list, 'supermarket_image_path' => $path);
            return $this->customerrormessage($message,$redata,200); 
        } else if(isset($country) && isset($city)) {
            $validator = Validator::make($request->all(), [
                'country' => 'bail|required',
                'city' => 'bail|required'
            ]);
            if ($validator->fails()) {
                return $this->erroroutput($validator);
            }
            $list = Supermarket::where(['city_id' => $city,'is_enabled'=>1])->get();
            $path = Constant::where('constant_type','SUPERMARKET_IMAGE_PATH')->value('data');
            $message = trans("lang.success");           
            $redata = array('list' => $list, 'supermarket_image_path' => $path);
            return $this->customerrormessage($message,$redata,200); 
        }
    }

    public function market(Request $request) {
        App::setLocale($request->header('locale'));
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'id' => 'required|int|min:1',
        ]);
        if ($validator->fails()) {
            return $this->erroroutput($validator);
        }
        if(isset($id)) {
            $market = Supermarket::find($id)->toArray();
            $path = Constant::where('constant_type','SUPERMARKET_IMAGE_PATH')->value('data');
        }
        $message = trans("lang.success");          
        $redata = array('market' => $market, 'supermarket_image_path' => $path);
        return $this->customerrormessage($message,$redata,200);        
    }

}
