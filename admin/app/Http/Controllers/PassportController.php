<?php
namespace App\Http\Controllers;
use DB;
use Auth;
use Hash;
use App\User;
use App\Reward;
use App\Product;
use App\Constant;
use Carbon\Carbon;
use App\Productconfig;
use Lcobucci\JWT\Parser;
use App\Http\Traits\OtpTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use App\Http\Traits\ValidationTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Traits\NotificationTrait;

class PassportController extends Controller
{

    use SendsPasswordResetEmails;
    use OtpTrait;
    use ValidationTrait;
    use NotificationTrait;
    /**
     * Handles Registration Request
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
    	// if API Call:  if($request->wantsJson()){ }
    	// IF Web Call:  else {} apply this when will implement the web also
        App::setLocale($request->header('locale'));        
        $validator = Validator::make($request->all(), [
            'name' 		=> 'bail|required|min:3',
            'email' 	=> 'bail|required|email|unique:users,email',
            'password' 	=> 'bail|required|min:6',
            'mobile'   	=> 'bail|required|min:10|unique:users,mobile',
            'referral_code' => 'bail|sometimes|nullable|exists:users,user_refer_code',
            //'device_token'  => 'bail|required'
        ]);

        if ($validator->fails()) {            
            return $this->erroroutput($validator);
            
        }

        $unidstr = "GH".substr($request->mobile,-3);
        $refercode = substr(uniqid($unidstr,true),0,8);

        /* referral points */
           $referralpointsq =  Reward::where(['action' => 'on_referral', 'status' => 1])->get()->toArray();
           if($referralpointsq) {
                $referralpoints = $referralpointsq[0]['points'];
            }
        /* referral points */

        /* crediting to the user who referred */
        $usedrefercode = ''; $earnedpoints = 0;
        $referraluser = User::where(['user_refer_code' => $request->referral_code])->get()->toArray();
        if($referraluser) {
            $updatedpoints = $referraluser[0]['credits'] + $referralpoints;
            User:: where(['user_refer_code' => $request->referral_code])->update(['credits' => $updatedpoints]);
            $usedrefercode = $request->referral_code;
			$tocredituser=$referraluser[0]['id'];
			
			        $notidata['title']      = 'Reward Credited';
                    $notidata['message']    = 'Reward Point: '.$referralpoints.' - Credited to the account.';
                    $notidata['image']      = '';
                    $notidata['user']       =  $tocredituser;
                    $this->sendNotification($notidata);
					
					
        }
        /* crediting to the user who referred */

        /*validating refercode and rewards */
            if(!empty($usedrefercode)) { $earnedpoints = $referralpoints;}
        /*validating refercode and rewards */

        $user = User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'mobile'          => $request->mobile,
            //'user_refer_code' => $refercode,
            'used_refer_code' => $usedrefercode,
            'credits'         => $earnedpoints,
            'device_token'    => $request->device_token
        ]);
		$user->user_refer_code='GH'.sprintf( '%06d', $user->id );
        $user->save();
		
        $consumerrole = 'consumer';
        $user->assignRole($consumerrole);               
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();
        $redata = array("access_token" => $tokenResult->accessToken, "token_type" => "bearer", "expires_at" => Carbon::parse(
        $tokenResult->token->expires_at)->toDateTimeString(), 'mobile_verified' => $user->is_mobile_verified, 'email_verified' => $user->email_verified_at);
        $message    = trans('lang.success');
        return $this->customerrormessage($message,$redata,200);
    }
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        App::setLocale($request->header('locale'));
        $validator = Validator::make($request->all(), [
            'username'      => 'bail|required',
            'password'      => 'bail|required|min:6',
            'remember_me'   => 'bail|boolean'
        ]);

        if ($validator->fails()) {            
            return $this->erroroutput($validator);
        }     

        if(is_numeric($request->get('username'))) {
            $validator = Validator::make($request->all(), [
                'username'        => 'bail|required|exists:users,mobile',
                'password'        => 'bail|required|min:6|exists:users,password',
                'remember_me'     => 'bail|boolean',
                'device_token'    => 'bail|required'
            ]);
            $credentials = ['mobile'=>$request->get('username'),'password'=>$request->get('password')];
        }
        elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $validator = Validator::make($request->all(), [
                'username'        => 'bail|required|exists:users,email',
                'password'        => 'bail|required|min:6|exists:users,password',
                'remember_me'     => 'bail|boolean'
            ]);
            $credentials = ['email' => $request->get('username'), 'password'=>$request->get('password')];
        } else {
            $validator = Validator::make($request->all(), [
                'username'        => 'bail|required|exists:users,email',
                'password'        => 'bail|required|min:6|exists:users,password',
                'remember_me'     => 'bail|boolean'
            ]);
            $credentials = ['email' => $request->get('username'), 'password'=>$request->get('password')];
        }

        if(!Auth::attempt($credentials)) {
            return $this->erroroutput($validator);
        }

        $user = Auth::user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $user->device_token = $request->device_token;
        $user->save();

        $redata = array("access_token" => $tokenResult->accessToken, "token_type" => "bearer", "expires_at" => Carbon::parse(
        $tokenResult->token->expires_at)->toDateTimeString(), 'mobile_verified' => $user->is_mobile_verified, 'email_verified' => $user->email_verified_at);
        $message    = trans('lang.success');
        return $this->customerrormessage($message,$redata,200);
    }


    /* send otp and verify login*/
    public function initotp(Request $request) { 
        App::setLocale($request->header('locale'));
        $user = auth()->user()->toArray();
        $data = $this->sendOtp($user);
        if($data[0] == 'mobile_case') {
            if(substr($data[1],0,5) == 'ERROR') {                
                $redata = array();                
                $message    = $data[1];
                return $this->customerrormessage($message,$redata,401);
            } else {                
                $message = 'Your OTP is created. ';
                $redata = array("id" => $data[2], "otp_type" => 'sms');
                return $this->customerrormessage($message,$redata,200);
            }
        }

       if($data[0] == 'email_case') {
           if(!empty($data[1])) {                
                $message = 'Your OTP is created.';
                $redata = array("userid" => $data[1], "otp_type" => 'email');
                return $this->customerrormessage($message,$redata,200);
           } else {                
                $message = 'OTP is not created';
                $redata = array();
                return $this->customerrormessage($message,$redata,401);
           }
       }

       if($data[0] == "no_case") {            
            $message = 'user is already verified.';
            $redata = array();
            return $this->customerrormessage($message,$redata,200);
       }
    }

    public function endotp(Request $request) {
        App::setLocale($request->header('locale'));
        /*$request->validate([
            'otp'      => 'bail|required',
            'otp_type' => 'bail|required'
        ]);*/
        
        $validator = Validator::make($request->all(), [
            'otp'      => 'bail|required',
            'otp_type' => 'bail|required'
        ]);

        if ($validator->fails()) {            
            return $this->erroroutput($validator);
        }
       $data =  $this->verifyOtp($request);

       if($data[0] == "mobile_case") {
            if($data[1] == "1") {                    
                    $redata = array('is_mobile_verified' => 1);
                    $message = "Your Number is Verified.";
                    return $this->customerrormessage($message,$redata,200);
            } else {                    
                    $redata = array('is_mobile_verified' => 0);
                    $message 	= "OTP does not match.";
                    return $this->customerrormessage($message,$redata,401);
            }
        }

       if($data[0] == "email_case") {
            if($data[1] == "1") {                    
                    $redata =  array('email_verified' => 1);
                    $message    = "Your Email is Verified.";
                    return $this->customerrormessage($message,$redata,200);
            } else {                    
                    $redata = array('email_verified' => 0);
                    $message    = "OTP does not match.";
                    return $this->customerrormessage($message,$redata,401);
            }
        }

        if($data[0] == "no_case") {            
	        $message = 'Something is wrong, check your login status';
			$redata = array();
            return $this->customerrormessage($message,$redata,200);
        }

    }
 
    /*logout the user */
 	public function logout(Request $request)
    {
        App::setLocale($request->header('locale'));
		$value = $request->bearerToken();
	    if ($value) {
	        $id = (new Parser())->parse($value)->getHeader('jti');
	        $revoked = DB::table('oauth_access_tokens')->where('id', '=', $id)->update(['revoked' => 1]);
	        //$this->guard()->logout();
	    }
        //$this->auth()->logout();        
        $redata = array();
        $message = trans("lang.logout");
	    return $this->customerrormessage($message,$redata,200);
    }

    public function getresettoken(Request $request)
    {
        App::setLocale($request->header('locale'));
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {            
            return $this->erroroutput($validator);
        }
        $user = User::where('email', $request->input('email'))->first();   
        if($user) {
            $token = rand(100000, 999999);
            $maildata = array(
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token,
     
            );
            Mail::to($user->email)->send(new ResetPasswordMail($maildata));
        } else { 
            $message = trans("lang.resetpasswordtoken");
            $redata = array();
            return $this->customerrormessage($message,$redata,401); 
        }               
        $redata = array("token" => $token);
        $message = trans("lang.success");
	    return $this->customerrormessage($message,$redata,200);    
    }


    public function resetpassword(Request $request) {

        App::setLocale($request->header('locale'));
    	$email = $request->email;
    	$userdata = User::where(['email' => $email])->get(['id'])->toArray();
        $id = $userdata[0]['id'];        

        $validator = Validator::make($request->all(), [
            'token' => 'bail|required',
            'email' => 'bail|required|email',
            'password' => 'bail|required|confirmed|min:8',
        ]);
        if ($validator->fails()) {            
            return $this->erroroutput($validator);
        }
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);

        } else{
            $input = array_except($input,array('password'));    
        }
        $user = User::find($id);
        $user->update($input);        
        $deltoken = DB::delete("DELETE FROM password_resets WHERE email = '".$email."'");        
        $redata = array();
        $message = trans("lang.success");
        return $this->customerrormessage($message,$redata,200);
    }

    public function getprofile(Request $request)
    {
        App::setLocale($request->header('locale'));
    	$userdata = auth()->user()->toArray();
    	$name = $userdata['name'];
        $mobile = $userdata['mobile'];
        $email = $userdata['email'];
        $userid = $userdata['id'];
        $redata = array("name" => $name, "mobile" => $mobile, 'userid' => $userid, 'email' => $email);        
        $message = trans("lang.success");
        return $this->customerrormessage($message,$redata,200);
    }

    public function updateprofile(Request $request) {          
        App::setLocale($request->header('locale'));
        $user = auth()->user()->toArray();
        $validator = Validator::make($request->all(), [
            'name'    => 'bail|required',
            'mobile' =>  'bail|min:10|unique:users,mobile,'.$user['id']
        ]);
        
        if ($validator->fails()) {            
            return $this->erroroutput($validator);
        }
        else {
            $mobile = $request->mobile;
            $name   = $request->name;
            $user = auth()->user()->toArray();
            $id = $user['id'];
            $userdt = User::where(['id' => $id])->get(['mobile'])->toArray();                        
            if(!empty($mobile) && ($mobile !== $userdt[0]['mobile'])) {
                User::where(['id' => $id])->update(['mobile' => $mobile,'is_mobile_verified' => 0]);
            }
            User::where(['id' => $id])->update(['name' => $name]);        
            $redata = array(); //array("mobile_verified" => $user->is_mobile_verified);
            $message = trans("lang.success");
            return $this->customerrormessage($message,$redata,200);
        }
    }

    public function changepassword(Request $request) {
        App::setLocale($request->header('locale'));
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'old_password'     => 'bail|required',
            'password'         => 'bail|required|confirmed|min:6|different:old_password'
        ]);
        if ($validator->fails()) {            
            return $this->erroroutput($validator);
        }
        if (Hash::check($request->old_password, $user->password)) {            
            $user->fill([
            'password' => Hash::make($request->password)
            ])->save();
            
            $redata = array();
            $message = trans('lang.passwordsuccess');
            return $this->customerrormessage($message,$redata,200);

        } else {                       
            $redata = array();
            $message = trans('lang.passworderror');
            return $this->customerrormessage($message,$redata,401);
        }
    }

    public function userrewards(Request $request) {
        App::setLocale($request->header('locale'));
        $user = auth()->user()->toArray();
        $earnedpoints   = $user['credits'];
        $cashpoints     = $user['cash_credits'];
        $refer_code     = $user['user_refer_code'];  
        $cashpoints = $cashpoints ? $cashpoints : 0;       
        $redata = array("points" => $earnedpoints, "cash_credits" => $cashpoints, "code" => $refer_code);
        $message = trans("lang.success");
        return $this->customerrormessage($message,$redata,200);
    }

    public function getwishlist(Request $request) {
        App::setLocale($request->header('locale'));
        $user = auth()->user()->toArray();
        $wishlistdata = DB::select("select * from wishlists WHERE user_id = '".$user['id']."' AND status = 1");
        $path = '';
		$allData=[];
        if($wishlistdata) {
            foreach($wishlistdata as $wishk => $wishv) {                
                $productdata = DB::select("select pc.*,p.name,p.name_arabic from products p INNER JOIN productconfigs pc ON pc.product_id = p.id WHERE pc.id = '".$wishv->productconfig_id."' and pc.status=1 and pc.is_enabled=1 and pc.is_approved=1");
				if(count($productdata)>0)
				{
			   
                $unit = Constant::Where(['id' => $productdata[0]->unit_id])->value('data');
              /*$wishlistdata[$wishk]->name           =  $productdata[0]->name;
                $wishlistdata[$wishk]->name_arabic    =  $productdata[0]->name_arabic;
                $wishlistdata[$wishk]->sku            =  $productdata[0]->sku;
                $wishlistdata[$wishk]->price          =  $productdata[0]->price;
                $wishlistdata[$wishk]->discountedprice =  $productdata[0]->discountedprice;
                $wishlistdata[$wishk]->discount       =  $productdata[0]->discount;
                $wishlistdata[$wishk]->capacity       =  $productdata[0]->capacity;
                $wishlistdata[$wishk]->unit_id        =  $unit;
                $wishlistdata[$wishk]->quantity       =  $productdata[0]->quantity;
                $wishlistdata[$wishk]->description    =  $productdata[0]->description;
                $wishlistdata[$wishk]->supermarket_id =  $productdata[0]->supermarket_id;
                $wishlistdata[$wishk]->category_id    =  $productdata[0]->category_id;
                $wishlistdata[$wishk]->lotteryproduct =  $productdata[0]->lotteryproduct;
                $wishlistdata[$wishk]->productstatus  =  $productdata[0]->status;
                $wishlistdata[$wishk]->productimage   =  $productdata[0]->image_path; */
				
				
				$wishv->name           =  $productdata[0]->name;
				$wishv->name_arabic    =  $productdata[0]->name_arabic;
				$wishv->sku            =  $productdata[0]->sku;
				$wishv->price          =  $productdata[0]->price;
				$wishv->discountedprice =  $productdata[0]->discountedprice;
				$wishv->discount       =  $productdata[0]->discount;
				$wishv->capacity       =  $productdata[0]->capacity;
				$wishv->unit_id        =  $unit;
				$wishv->quantity       =  $productdata[0]->quantity;
				$wishv->description    =  $productdata[0]->description;
				$wishv->supermarket_id =  $productdata[0]->supermarket_id;
				$wishv->category_id    =  $productdata[0]->category_id;
				$wishv->lotteryproduct =  $productdata[0]->lotteryproduct;
				$wishv->productstatus  =  $productdata[0]->status;
				$wishv->productimage   =  $productdata[0]->image_path;		
				$allData[]=$wishv;
				
				}
                				
            }
            $path = Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data');
            
        }
                
        $redata = array("wishlistdata" => $allData, 'product_image_path' => $path);
        $message = trans("lang.success");
        return $this->customerrormessage($message,$redata,200);
    }

    public function addtowishlist(Request $request) {
        App::setLocale($request->header('locale'));
        $user = auth()->user()->toArray();        
        $validator = Validator::make($request->all(), [
            'product_id'        => 'bail|required|min:1|int|exists:products,id',
            'productconfig_id'  => 'bail|required|min:1|int|exists:productconfigs,id'
        ]);

        if ($validator->fails()) {            
            return $this->erroroutput($validator);
        }

        $product_id         = $request->product_id;
        $productconfig_id   = $request->productconfig_id;
        $user_id            = $user['id'];
        $datenow = date("Y-m-d H:s:s");

        $existeddata = DB::select("select count(id) as wishcount FROM wishlists WHERE user_id = '".$user_id."' AND productconfig_id = '".$productconfig_id."' AND product_id = '".$product_id."'AND status = 1");
        if(!empty($existeddata) && ($existeddata[0]->wishcount > 0)) {
            DB::delete("DELETE FROM wishlists WHERE user_id = '".$user_id."' AND productconfig_id = '".$productconfig_id."' AND product_id = '".$product_id."'");            
            $redata = array();
            $message = trans("lang.removewishsuccess");
            return $this->customerrormessage($message,$redata,200);
        } else if(!empty($existeddata) && ($existeddata[0]->wishcount < 1)) {
            DB::insert("INSERT INTO wishlists SET user_id = '".$user_id."', productconfig_id = '".$productconfig_id."', product_id = '".$product_id."', status = '1', created_at = '".$datenow."'");            
            $redata = array();
            $message = trans("lang.addwishsuccess");
            return $this->customerrormessage($message,$redata,200);
        } else { }
    }

    public function deletefromwishlist(Request $request) {
        App::setLocale($request->header('locale'));
        $user = auth()->user()->toArray();
        $user_id = $user['id'];        
        $validator = Validator::make($request->all(), [
            'id'        => 'required|min:1|int|exists:wishlists,id',
        ]);

        if ($validator->fails()) {            
            return $this->erroroutput($validator);
        }

        $wishid  = $request->id;
        $wishend = DB::delete("DELETE FROM wishlists WHERE id = '".$wishid."' AND user_id = '".$user_id."'");
        if($wishend) {            
            $redata = array();
            $message = trans('lang.wishlistsuccess');
            return $this->customerrormessage($message,$redata,200);
        } else {  
           $redata = array();          
           $message = trans('lang.wishlisterror');
           return $this->customerrormessage($message,$redata,401);
        }
    }

    /* weekly list APIs*/

    public function getweeklylist(Request $request) {
        App::setLocale($request->header('locale'));
        $user = auth()->user()->toArray();
        $weeklydata = array();
        $weeklydata = DB::select("select * from weeklylists WHERE user_id = '".$user['id']."' AND status = 1");
		$allData=[];
       if($weeklydata) {
            foreach($weeklydata as $week => $weekv) {
                $productdata = DB::select("select pc.*,p.name,p.name_arabic from products p INNER JOIN productconfigs pc ON pc.product_id = p.id WHERE pc.id = '".$weekv->productconfig_id."' and pc.status=1 and pc.is_enabled=1 and pc.is_approved=1");
				if(count($productdata)>0)
				{
                $unit = Constant::Where(['id' => $productdata[0]->unit_id])->value('data');
               /* $weeklydata[$week]->name           =  $productdata[0]->name;
                $weeklydata[$week]->name_arabic    =  $productdata[0]->name_arabic;
                $weeklydata[$week]->sku            =  $productdata[0]->sku;
                $weeklydata[$week]->price          =  $productdata[0]->price;
                $weeklydata[$week]->discountedprice =  $productdata[0]->discountedprice;
                $weeklydata[$week]->discount        =  $productdata[0]->discount;
                $weeklydata[$week]->capacity        =  $productdata[0]->capacity;
                $weeklydata[$week]->unit_id         =  $unit;
                $weeklydata[$week]->quantity        =  $productdata[0]->quantity;
                $weeklydata[$week]->description     =  $productdata[0]->description;
                $weeklydata[$week]->supermarket_id  =  $productdata[0]->supermarket_id;
                $weeklydata[$week]->category_id     =  $productdata[0]->category_id;
                $weeklydata[$week]->lotteryproduct  =  $productdata[0]->lotteryproduct;
                $weeklydata[$week]->productstatus         =  $productdata[0]->status; 
                $weeklydata[$week]->productimage         =  $productdata[0]->image_path; */  
                
                 $weekv->name           =  $productdata[0]->name;
				$weekv->name_arabic    =  $productdata[0]->name_arabic;
				$weekv->sku            =  $productdata[0]->sku;
				$weekv->price          =  $productdata[0]->price;
				$weekv->discountedprice =  $productdata[0]->discountedprice;
				$weekv->discount       =  $productdata[0]->discount;
				$weekv->capacity       =  $productdata[0]->capacity;
				$weekv->unit_id        =  $unit;
				$weekv->quantity       =  $productdata[0]->quantity;
				$weekv->description    =  $productdata[0]->description;
				$weekv->supermarket_id =  $productdata[0]->supermarket_id;
				$weekv->category_id    =  $productdata[0]->category_id;
				$weekv->lotteryproduct =  $productdata[0]->lotteryproduct;
				$weekv->productstatus  =  $productdata[0]->status;
				$weekv->productimage   =  $productdata[0]->image_path;		
				$allData[]=$weekv;
				}			
            }            
        }
        $path = Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data');
                
        $redata = array("weeklydata" => $allData, "product_image_path" => $path);
        $message    = trans("lang.success");
        return $this->customerrormessage($message,$redata,200);
    }

    public function addtoweeklylist(Request $request) {
        App::setLocale($request->header('locale'));
        $user = auth()->user()->toArray();        

        $validator = Validator::make($request->all(), [
            'product_id'        => 'bail|required|min:1|int|exists:products,id',
            'productconfig_id'  => 'bail|required|min:1|int|exists:productconfigs,id'
        ]);

        if ($validator->fails()) {            
            return $this->erroroutput($validator);
        }

        $product_id = $request->product_id;
        $productconfig_id   = $request->productconfig_id;
        $user_id            = $user['id'];
        $datenow            = date("Y-m-d H:s:s");

        $existeddata = DB::select("select count(id) as weekcount FROM weeklylists WHERE user_id = '".$user_id."' AND productconfig_id = '".$productconfig_id."' AND product_id = '".$product_id."'AND status = 1");
        if(!empty($existeddata) && ($existeddata[0]->weekcount > 0)) {
            DB::delete("DELETE FROM weeklylists WHERE user_id = '".$user_id."' AND productconfig_id = '".$productconfig_id."' AND product_id = '".$product_id."'");            
            $redata = array();
            $message    = trans("lang.removeweeklistsuccess");
            return $this->customerrormessage($message,$redata,200);
        } else if(!empty($existeddata) && ($existeddata[0]->weekcount < 1)) {
            DB::insert("INSERT INTO weeklylists SET user_id = '".$user_id."', productconfig_id = '".$productconfig_id."', product_id = '".$product_id."', status = '1', created_at = '".$datenow."'");            
            $redata = array();
            $message    = trans("lang.addweeklistsuccess");
            return $this->customerrormessage($message,$redata,200);
        } else { }
    }

    public function deletefromweeklylist(Request $request) {
        $user = auth()->user()->toArray();
        $user_id = $user['id'];
        App::setLocale($request->header('locale'));

        $validator = Validator::make($request->all(), [
            'id'        => 'required|min:1|int|exists:weeklylists,id',
        ]);

        if ($validator->fails()) {
            return $this->erroroutput($validator);
        }

        $weekid  = $request->id;
        $weekend = DB::delete("DELETE FROM weeklylists WHERE id = '".$weekid."' AND user_id = '".$user_id."'");
        if($weekend) {            
            $redata = array();
            $message    = trans('lang.weeklistsuccess');
            return $this->customerrormessage($message,$redata,200);
        } else { 
            $redata = array();
            $message = trans('lang.weeklylisterror');
            return $this->customerrormessage($message,$redata,401);
        }
    }

    public function movefromweeklylist(Request $request) {
        $user    = auth()->user()->toArray();
        $user_id = $user['id'];
        App::setLocale($request->header('locale'));
        $validator = Validator::make($request->all(), [
            'id.*'        => 'required|min:1|int|exists:weeklylists,id',
        ]);

        if ($validator->fails()) {            
            return $this->erroroutput($validator);
        }

        $weekid  = $request->id;
        $weekids = implode("','",$weekid);
        $weekend = DB::delete("DELETE FROM weeklylists WHERE id IN ('".$weekids."') AND user_id = '".$user_id."'");
        if($weekend) {            
            $redata = array();
            $message    = trans('lang.weeklistsuccess');
            return $this->customerrormessage($message,$redata,200);
        } else {
            $redata = array(); 
            $message = trans('lang.weeklylisterror');
            return $this->customerrormessage($message,$redata,401);            
        }
    }

    /* weekly list APIs*/
	
	Public function sendWebOtp(Request $request)
	{
		$response=$this->sendMobileOtp($request);
		return json_encode($response);
	}
	public function updateToken(Request $request)
	{
		$userId=$request->user_id;
		$token=$request->token;
		$user= User::find($userId);
		if(!empty($user))
		{
			$user->device_token=$token;
			$user->save();
			$redata = array();
            $message    = trans('lang.tokenUpdated');
			return $this->customerrormessage($message,$redata,200);
		}
		else{
			$redata = array(); 
            $message = trans('lang.invalidUser');
            return $this->customerrormessage($message,$redata,401); 
		}
		
	}
}
