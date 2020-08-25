<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use App\Vendor;
use App\Country;
use App\Supermarket;
use App\Mail\Welcome;
use App\Mail\DisableMail;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\VendorRequest;
use Illuminate\Support\Facades\Mail;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all('id','name');
        $supermarkets =  Supermarket::where('status','!=',0)->get();
        return view('vendor.create',
        ['countries' => $countries,
          'sm' => $supermarkets
        
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'country_id' => 'required|integer|min:1',
            'city_id' => 'required|integer|min:1',
            'area_id' => 'required|integer|min:1',
            'address' => 'required|max:255',
            'email' => 'email|required|unique:users',
            'mobile' => 'integer|required|unique:users',
            'status' => 'required|integer',
            'supermarket_id' => 'required|integer',
            'status' => 'required|integer',
        ]);
        
        $input = $request->all();
        $password = 'pass123';
        $input['password'] = Hash::make($password);
        $uniquenumber = rand(10000,99999999);
        $unidstr = "GH".$uniquenumber;
        $input['user_refer_code'] = $unidstr;  
        $input['used_refer_code'] = 0;
        $input['credits'] = 0;        $user = User::create($input);
        $user->assignRole('vendor');
        $user->is_enabled = $request->status;

        

        $vendor = new Vendor;
        $vendor->user_id = $user->id;
        $vendor->address = $request->address;
        $vendor->country_id = $request->country_id;
        $vendor->area_id = $request->area_id;
        $vendor->city_id = $request->city_id;        
        $vendor->status = $request->status;
        $vendor->supermarket_id = $request->supermarket_id;
        //$vendor->commission_percentage = $request->commission_percentage;
        $vendor->is_enabled = $request->status;
        $vendor->save();
        Mail::to($user->email)->send(new Welcome($user));

        return redirect()->route('users.listvendor')->with('success','Vendor created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        //return $user;
        return view('vendor.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        return view('vendors.edit',compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id)
    {
           
        
            $this->validate($request, [
            'name' => 'required|max:255',
            'country_id' => 'required|integer|min:1',
            'city_id' => 'required|integer|min:1',
            'area_id' => 'required|integer|min:1',
            'address' => 'required|max:255',
            'email' => 'email|required|unique:users,email,'.$id.',id',
            'mobile' => 'integer|required|unique:users,mobile,'.$id.'id',
            'status' => 'required|integer',
            'supermarket_id' => 'required|integer',
            'status' => 'required|integer',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->is_enabled = $request->status;
        $user->save();

        $vendor_id = Vendor::where('user_id',$id)->get(); 
        $vendor = Vendor::find($vendor_id[0]->id);
        $vendor->address = $request->address;
        $vendor->country_id = $request->country_id;
        $vendor->area_id = $request->area_id;
        $vendor->city_id = $request->city_id;        
        //$vendor->is_enabled = $request->status;
        $vendor->supermarket_id = $request->supermarket_id;
        $vendor->is_enabled = $request->status;
        if($user->is_enabled == 0){
            Mail::to($user->email)->send(new DisableMail($user));
        }
        $vendor->save();

        return redirect()->route('users.listvendor')->with('success','Vendor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->status = 0;
        $user->save();
        return redirect()->route('users.listvendor')->with('success','Vendor deleted successfully');
        //return redirect('/vendor')->with('success', 'Vendor was deleted!');
    }
}
