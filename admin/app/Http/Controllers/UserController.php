<?php


namespace App\Http\Controllers;
use DB;
use Hash;
use App\User;
use App\Reward;
use App\Vendor;
use App\Country;
use App\Supermarket;
use App\Mail\DisableMail;
use Illuminate\Http\Request;
use App\Mail\WelcomeConsumer;
use App\Jobs\SendDisableMailJob;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $data =  User::role('consumer')->where('status','!=',0)->orderBy('id','DESC')->paginate(5);
        return view('users.listconsumer', ['data'=>$data]);/*->with('i', ($request->input('page', 1) - 1) * 5)*/
    }
    public function listvendor(Request $request)
    {
        $data =  User::role('vendor')->where('status','!=',0)->orderBy('id','DESC')->paginate(5);
        //return $data;
        return view('users.index', ['data'=>$data]);/*->with('i', ($request->input('page', 1) - 1) * 5)*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $roles = Role::where('id','!=' , 1)->pluck('name','name');
        return view('users.create',compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){

       
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'mobile' => 'required|integer|unique:users,mobile',
            'used_refer_code' => 'max:255'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $uniquenumber = rand(1,99999999);
        $unidstr = "GH".$uniquenumber;
        $input['user_refer_code'] = $unidstr;

        /* referral points */
           $referralpointsq =  Reward::where(['action' => 'on_referral', 'status' => 1])->get()->toArray();
           if($referralpointsq) {
                $referralpoints = $referralpointsq[0]['points'];
            }
        /* referral points */
          
        /* crediting to the user who referred */
        $referraluser = User::where(['user_refer_code' => $request->used_refer_code])->get()->toArray();
        if($referraluser) {
            User:: where(['user_refer_code' => $request->referral_code])->update(['credits' => $referralpoints]);
            $input['used_refer_code'] = $request->used_refer_code;
        }
        /* crediting to the user who referred */


        /*validating refercode and rewards */
            if(empty($referraluser)) { 
                $input['credits'] =  $referralpoints;}
            if(!empty($input['used_refer_code'])) { 
                $input['credits'] = $referralpoints;
            }
        /*validating refercode and rewards */
        $user = User::create($input);
        $user->assignRole('consumer');
        Mail::to($user->email)->send(new WelcomeConsumer($user));
        return redirect()->route('users.index')->with('success','Consumer created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $user = User::find($id);
        $roles = $user->getRoleNames();
        if ($roles[0] == 'vendor'){
            $v = new Vendor;
            $vendor =  $v->getVendorDetails($user->id);
            $countries = Country::all('id','name');
            $sm = Supermarket::all('id','name');
             return view('vendor.edit',compact('vendor','countries','sm'));
        }
        else if ($roles[0] == 'consumer') {
            
            return view('users.edit',compact('user'));
        } else if($roles[0] == 'admin') {
            return view('users.edit',compact('user'));
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id){

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile' => 'required|integer|unique:users,mobile,'.$id,
            'status' => 'required|integer'

        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->cash_credits = $request->cash_credits;
        $user->is_enabled = $request->status;
            if($user->is_enabled == 0) {
                Mail::to($user->email)->send(new DisableMail($user));
                //SendDisableMailJob::dispatch($user)->delay(now()->addSeconds(10));
            }
        $user->save();
        /*DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));*/
        return redirect()->route('users.index')->with('success','Consumer updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $user = User::find($id);
        $user->status = 0;
        $user->save();
        return redirect()->route('users.index')->with('success','Consumer deleted successfully');
    }
}