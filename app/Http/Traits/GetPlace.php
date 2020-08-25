<?php
namespace App\Http\Traits;
use App\User;
use Auth;
use Illuminate\Http\Request;

trait GetPlace {
   /**
	* Sending the OTP.
	*
	* @return Response
	*/
	public function getaddress($lat,$long) {		
		$url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$lat.",".$long."&radius=10&key=AIzaSyC4RS6KnIeOvbZ9ESNCTOsFUX-Lh0J6IOM";		
		$curl = curl_init();		
		curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		]);		
		$response = curl_exec($curl);		
		curl_close($curl);
		return $response;
	}

	public function getrelativelocations($lat,$long) {

	}


}