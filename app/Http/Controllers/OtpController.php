<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $sentdata = $this->sendOtp();                               
        return view('otps.index', ['sentdata' => $sentdata]);
    }

    public function sendOtp() {        
	    if (!empty(Auth::user()->mobile_verified) && !empty(Auth::user()->email_verified)) {
			$outputarr = array("no_case");
			return $outputarr;
	    } else {
	    	$otp = rand(100000, 999999);
	    	if(empty(Auth::user()->mobile_verified)) {
				// curl request
				$tonum = Auth::user()->mobile;
				$textmsg = "Please%20use%20this%20OTP%20for%20verification:%20".$otp;
				$nowtime  = date('Y-m-d');
				$url = 'https://smartsmsgateway.com/api/api_http.php?username=appdeliverys&password=bJzZgsXpbX&senderid=smart%20msg&to='.$tonum.'&text='.$textmsg.'&type=text&datetime='.$nowtime;
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


	    	} else if(empty(Auth::user()->email_verified)) {
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
	}

    /**
	* Function to verify OTP.
	*
	* @return Response
	*/
	public function verifyOtp(Request $request) {
	    $otp = $request->input('otp1').$request->input('otp2').$request->input('otp3').$request->input('otp4').$request->input('otp5').$request->input('otp6');
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
