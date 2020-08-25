<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;
class CheckOtp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) { 
            $userid = Auth::user()->id;
            $email_verified    = Auth::user()->email_verified_at;
            $mobile_verified   = Auth::user()->is_mobile_verified;
            $sent_smsotp       = Auth::user()->sms_otp;
            $sent_emailotp     = Auth::user()->email_otp;
            $otptype = '';
            if(empty($email_verified && empty($sent_emailotp))) {
                $otptype = 'sms';
                $sentdata = $this->sendOtp($otptype);

            } else if(empty($mobile_verified) && empty($sent_smsotp)) {
                $otptype = 'email';
                $sentdata = $this->sendOtp($otptype);
            } else {
                return $next($request);
            }
            return $next($request);
        }       
        return $next($request);
    }

    public function sendOtp($otptype) {	    	
        if($otptype == 'sms') {
            $otp = rand(100000, 999999);
            // curl request
            $tonum = Auth::user()->mobile;
            $textmsg = "Please%20use%20this%20OTP%20for%20verification:%20".$otp;
            $nowtime  = date('Y-m-d');
            $url = 'https://smartsmsgateway.com/api/api_http.php?username=a3services&password=pZLrVR4TfJ&senderid=smart%20msg&to='.$tonum.'&text='.$textmsg.'&type=text&datetime='.$nowtime;
            // Initialize a CURL session. 
            $ch = curl_init();  
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            //  curl_setopt($ch,CURLOPT_HEADER, false); 
            $output=curl_exec($ch);
            curl_close($ch);
            if(substr($output,0,5) == 'ERROR') {		        	
                $outputarr = array("mobile_case", $output);
                return $outputarr;									
            } else {
                User::where('id', Auth::user()->id)->update(['sms_otp' => $otp]);
                $outputarr = array("mobile_case", $output,Auth::user()->id);
                return $outputarr;
            }


        } if($otptype == 'email') {
            $otp = rand(100000, 999999);
            $mailsent = 1;
                if($mailsent == 1) {
                User::where('id', Auth::user()->id)->update(['email_otp' => $otp]);
                $outputarr = array("email_case", Auth::user()->id);
                return $outputarr;
                
                } else {
                $outputarr = array("email_case");
                return $outputarr;
                }

        }     	        
    }
    

    public function verifyOtp(Request $request) {
        $otp = $request->input('otp1').$request->input('otp2').$request->input('otp3').$request->input('otp4').
        $request->input('otp5').$request->input('otp6');
	    $userId = Auth::user()->id;  //Getting UserID.	    
        if($request->otp_type == 'mobile_case') {
            $SMSOTP = Auth::user()->sms_otp;
            if($SMSOTP === $otp){
                $outputarr = array("mobile_case", "1");
                // Updating user's status as verified
                User::where('id', $userId)->update(['is_mobile_verified' => 1]);
                //Removing OTP
                User::Where(['id' => $userId])->update(['sms_otp' => NULL]);
                return redirect('/home');
                
            } else{
                $outputarr = array("mobile_case","0");
                return redirect('/otpscreen')->with('otpstatus','your OTP is wrong.');
            }
        } else if($request->otp_type == 'email_case') { 
            $date = date('Y-m-d H:i:s');
            $EOTP = Auth::user()->email_otp;
            if($EOTP === $otp){
                $outputarr = array("email_case", "1");
                // Updating user's status as verified
                User::where('id', $userId)->update(['email_verified_at' => $date]);
                //Removing Email OTP
                User::Where(['id' => $userId])->update(['email_otp' => NULL]);
                return redirect('/home');
                
            }else{
                $outputarr = array("email_case", "0");
                return redirect('/otpscreen')->with('otpstatus','your OTP is wrong.');
            }
        }	    
	}
}
