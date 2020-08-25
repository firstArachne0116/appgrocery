<?php
namespace App\Http\Traits;
use App\User;
use Auth,DB;
use Illuminate\Http\Request;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

trait OtpTrait {
   /**
	* Sending the OTP.
	*
	* @return Response
	*/
	public function sendOtp($userdata) {
	    //echo '<pre/>'; print_r($userdata); exit;
		$id = $userdata['id'];
		
	    if (!empty($userdata['is_mobile_verified']) && !empty($userdata['email_verified_at'])) {
			$outputarr = array("no_case");
			return $outputarr;
	    } else {
	    	$otp = rand(100000, 999999);
	    	if(empty($userdata['is_mobile_verified'])) {
				// curl request
				$tonum = $userdata['mobile'];
				$textmsg = "Please%20use%20this%20OTP%20for%20verification:%20".$otp;
				$nowtime  = date('Y-m-d');
				$url = 'https://smartsmsgateway.com/api/api_http.php?username=appdeliverys&password=bJzZgsXpbX&senderid=AppDelivery&to='.$tonum.'&text='.$textmsg.'&type=text&datetime='.$nowtime;
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
					User::where('id', $id)->update(['sms_otp' => $otp]);
					$outputarr = array("mobile_case", $output,$id);
					return $outputarr;
		        }


	    	} else if(empty($userdata['email_verified_at'])) {
	    	    
	    	    $data = array(
                    'email_otp'      => $otp,
                    'email'     => $userdata['email']
            
                );
                Mail::to($userdata['email'])->send(new OtpMail($data));
	    	    
	    		$mailsent = 1;
	    		 if($mailsent == 1) {
					User::where('id', $id)->update(['email_otp' => $otp]);
					$outputarr = array("email_case", $id);
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
	public function verifyOtp($request) {
	    $otp = $request->input('otp');		

	    $userId = Auth::user()->id;  //Getting UserID.

	    if($userId == "" || $userId == null) {
			$outputarr = array("no_case");
			return $outputarr;
	    } else {
	    	if($request->otp_type == 'sms') {
		        $SMSOTP = Auth::user()->sms_otp;
		        if($SMSOTP === $otp){
					$outputarr = array("mobile_case", "1");
		            // Updating user's status as verified
		            User::where('id', $userId)->update(['is_mobile_verified' => 1]);
		            //Removing OTP
					User::Where(['id' => $userId])->update(['sms_otp' => NULL]);
					return $outputarr;
		            
		        } else{
					$outputarr = array("mobile_case","0");
					return $outputarr;
		        }
		    } else {
		    	$date = date('Y-m-d H:i:s');
		    	$EOTP = Auth::user()->email_otp;
		    	if($EOTP === $otp){
					$outputarr = array("email_case", "1");
		            // Updating user's status as verified
		            User::where('id', $userId)->update(['email_verified_at' => $date]);
		            //Removing Email OTP
		            User::Where(['id' => $userId])->update(['email_otp' => NULL]);
					return $outputarr;
		            
		        } else {
					$outputarr = array("email_case", "0");
					return $outputarr;
		        }
		    }
	    }
	}
	public function sendMobileOtp($request) {
		  
		  $mobile=$request->mobile;
		   $status="0";
		   $msg="Invalid Mobile No.";
		  if($mobile!="")
		  {
		      $otp = rand(100000, 999999);
		      // curl request
				$tonum = $mobile;
				$textmsg = "Please%20use%20this%20OTP%20for%20verification:%20".$otp;
				$nowtime  = date('Y-m-d');
				$url = 'https://smartsmsgateway.com/api/api_http.php?username=appdeliverys&password=bJzZgsXpbX&senderid=AppDelivery&to='.$tonum.'&text='.$textmsg.'&type=text&datetime='.$nowtime;
				// Initialize a CURL session. 
				$ch = curl_init();  
				curl_setopt($ch,CURLOPT_URL,$url);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				//  curl_setopt($ch,CURLOPT_HEADER, false); 
				$output=curl_exec($ch);
				curl_close($ch);
				if(substr($output,0,5) == 'ERROR') {		        	
					 $status="0";
		             $msg="Please try again";									
		        } else {
					 $status="1";
		              $msg="Otp Sent";
					  DB::table('otps')->where('mobile', '=', $mobile)->delete();
					$savetodb = DB::insert("INSERT INTO otps (mobile,otp)values('".$mobile."','".$otp."')");
		        }
		  }
		  
				return array('status'=>$status,'msg'=>$msg);
	}
}