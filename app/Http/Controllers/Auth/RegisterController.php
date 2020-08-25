<?php

namespace App\Http\Controllers\Auth;
use DB;
use App\User;
use App\Reward;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
		//dd($data);
       $validator=Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile' => ['required', 'integer', 'unique:users']
			
        ]);
		$validator->after(function($validator)use($data) {
		        $otpValid=$this->checkOtp($data);
				if(!$otpValid)
				{
		          $validator->errors()->add('otp', 'Invalid Otp');
				}
				$isvalidRCode=$this->checkCode($data);
				if(!$isvalidRCode)
				{
		           $validator->errors()->add('referral_code', 'Invalid Code');
				}
		
		});
	return $validator;
	
    }
	private function checkOtp($data)
	{
		$otp = DB::table('otps')->where(['otp'=>$data['otp'],'mobile'=>$data['mobile']])->get();
		//dd(count($otp));
		return count($otp);
	}
	private function checkCode($data)
	{
		if($data['referral_code']=="")
		{
			return true;
		}
		$otp = DB::table('users')->where(['user_refer_code'=>$data['referral_code']])->get();		
		return count($otp);
	}

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $uniquenumber = rand(1,99999999);
        $unidstr = "GH".$uniquenumber;
        //$data['user_refer_code'] = $unidstr;
		$referralpoints=0;
		$referral_code=isset($data['referral_code'])?$data['referral_code']:'';
		if($referral_code!="")
		{
						
			$referraluser = User::where(['user_refer_code' => $referral_code])->get()->toArray();
			if(!empty($referraluser)){
				$referralpointsq =  Reward::where(['action' => 'on_referral', 'status' => 1])->get()->toArray();
				if($referralpointsq) {
				$referralpoints = $referralpointsq[0]['points'];
				}
			    $updatedpoints = $referraluser[0]['credits'] + $referralpoints;
                User:: where(['user_refer_code' => $request->referral_code])->update(['credits' => $updatedpoints]);
				
				$data['used_refer_code'] = $referral_code;
			}			
		}
         $data['credits'] = $referralpoints;
         $data['password'] = Hash::make($data['password']);
         $user = User::create($data); 

         $user->user_refer_code='GH'.sprintf( '%06d', $user->id );	
         $user->save();		 
         $consumerrole = 'consumer';
         $user->assignRole($consumerrole);          
         $role_users = DB::select("DELETE FROM model_has_roles WHERE model_id = '".$user->id."' AND role_id = '3'");
         return $user;

    }
}
