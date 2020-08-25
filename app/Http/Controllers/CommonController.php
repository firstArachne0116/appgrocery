<?php

namespace App\Http\Controllers;

use App\Country;
use App\Contactform;
use App\Supermarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use App\Http\Traits\GetPlace;

class CommonController extends Controller
{
    use GetPlace;

    public function contactus(){
        
        return view('common.contact_us');
    }
    public function termsandconditions(){
        
        return view('common.terms');
    }
    public function privacy(){
        
        return view('common.privacy');
    }
    public function aboutus(){
        
        return view('common.about_us');
    }
    public function faq(){
        
        return view('common.faq');
    }
    public function contactform(Request $request){
         $this->validate($request,[
             'name' => 'required|string|max:100',
             'email' => 'required|email|',
             'message' => 'required|string|max:1023',
         ]);
         $form = new Contactform;
         $form->name = $request->name;
         $form->email = $request->email;
         $form->message = $request->message;
         $form->save();
         return redirect()->route('common.contactus')->with('success','Message was added successfully'); 
    }
    public function change(Request $request){
        /*$this->validate($request,[
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
        ]);*/
       $country = Country::find($request->country_id);
       //return $country;
       session(['currency_htmlcode' => $country->currency_htmlcode,'currency_name' => $country->currency_name, 'currency_code' => $country->currency_code]);
       if(isset($request->country_id) && isset($request->city_id)) {
            $listObj = Supermarket::where(['country_id' => $request->country_id, 'is_enabled' => 1]);
			 if(isset($request->city_id) && $request->city_id>0)
			 {
				   $listObj->where(['city_id' => $request->city_id]);
			 }
			 if(isset($request->area_id) && $request->area_id>0)
			 {
				   $listObj->where(['area_id' => $request->area_id]);
			 }
			$list=$listObj->paginate(2)->toArray();

            return view('supermarkets.index', ['supermarkets' => $list]);
        }
    }
    public function getstate(Request $request){
      
        $states = DB::table("states")
                    ->where("country_id",$request->id)
                    ->pluck('name','id');
        return response()->json($states);

    }
    public function getcity(Request $request){
      
        $cities = DB::table("cities")
                    ->where("state_id",$request->id)
                    ->pluck('name','id');
    return response()->json($cities);

    }
	 public function getArea(Request $request){
      
        $cities = DB::table("areas")
                    ->where("city_id",$request->id)
                    ->pluck('name','id');
    return response()->json($cities);

    }
	

    public function show(Request $request){
        return $request;
    }
    public function changelanguage(Request $request){
        $language = $request->id;
        session(['currency_symbol' => '']);        
        switch ($language) {
            case 1://English
                session(['name' => 'name','description' => 'description']);  
                session(['currency_symbol' => session('currency_code')]);             
                return back();
                break;
            case 2://Arabic            
            session(['name' => 'name_arabic','description' => 'description_arabic']); 
            session(['currency_symbol' => html_entity_decode(session('currency_htmlcode'))]);                  
            return back();
                break;
            
            default://English
                session(['name' => 'name','description' => 'description']); 
                session(['currency_symbol' => session('currency_code')]);                               
                return back();
                break;
                
        }
    }

    public function setlocation(Request $request) {        
        session(['latitude' => $request->lat]);
        session(['longitude' => $request->long]);        
        $address = $this->getaddress(session('latitude'), session('longitude'));   
        $addressArr = json_decode($address);
        //echo '<pre/>'; print_r($addressArr->results[1]->name); exit;  
        session(['location_addressname' => $addressArr->results[1]->name]);
        echo session('location_addressname'); 
    }
}
