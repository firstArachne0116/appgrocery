<?php
namespace App\Http\Traits;

trait ValidationTrait {
    public function erroroutput($validator){
        $msg = $validator->errors()->first();
            $redata = new \stdClass();
            $data = array(
                'message' => $msg,
                'data' => new \stdClass(),
                'status' => 401
            );
            $response = json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
            return $response;
    }
    public function customerrormessage($message,$data,$status){
            $msg = $message;
            if(empty($data)) {
                $returndata = new \stdClass();
            } else {
                $returndata = $data;
            }
            $data = array(
                'message' => $msg,
                'data' => $returndata,
                'status' => $status
            );
            $response = json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
            return $response; 
    }
}