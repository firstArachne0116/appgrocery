<?php

namespace App\Http\Controllers;
use Hash;
use App\User;
use App\Order;
use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
        if (Auth::check()) {         
            $user = Auth::user();
            $orders = Order::where('user_id',$user->id)->orderBy('created_at', 'desc')->simplePaginate(4);
            //return $orders;
            $addresses = Address::where([['user_id','=',$user->id],['status','=',1]])->get();
            //return $addresses;
            return view('users.index',compact('user','orders','addresses'));
        }
        
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'mobile' => 'required|integer|unique:users,mobile,'.$user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->save();
        return redirect()->route('user.index')->with('success','Profile was updated successfully'); 

  
            

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }


    public function changepassword() {
        return view("users.password");
    }

    public function updatepassword(Request $request) {
        $user               = Auth::user();
        $oldpassword        = $request->oldpassword;
        $password           = $request->password;
        $confirmpassword    = $request->confirmpassword;

        $this->validate($request, [
            'oldpassword'      => 'bail|required',
            'password'         => 'bail|required|confirmed|min:8|different:oldpassword'
        ]);        
        
        if (Hash::check($oldpassword, $user->password)) {            
            $user->fill([
            'password' => Hash::make($password)
            ])->save();
            return redirect()->route('changepassword')->with('success','Password is changed successfully.');                        
        } else {                                   
            return redirect()->route('changepassword')->with('failure','Old Password does not match.');          
        }

    }
}
