<?php
namespace App\Http\Traits;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;

trait NotificationTrait {

    //const API_ACCESS_KEY = 'AIzaSyC9EEwXendw64gCCbLjFnNapwxfK9GIf_I';    //AIzaSyBkxfBWc3U4ucRB0JvN0iwLCw1cawgSFEo                  
   
	public function sendNotification($notificationdata) {  
        $API_ACCESS_KEY = 'AIzaSyC9EEwXendw64gCCbLjFnNapwxfK9GIf_I';        
       if($notificationdata["user"]) { 
           $userid = $notificationdata["user"]; 
           $tokendata      = DB::select("SELECT device_token FROM users WHERE id = '".$userid."'");
           $token = $tokendata[0]->device_token;
        } else { 
            $userid     = Auth::user()->id; 
            $token      = Auth::user()->device_token;
        }
        $title      = $notificationdata["title"];
        $message    = $notificationdata["message"];
        $image      = $notificationdata["image"];
        $token      = htmlspecialchars($token,ENT_COMPAT);
        $title      = htmlspecialchars($title,ENT_COMPAT);
        $message    = htmlspecialchars($message,ENT_COMPAT);
        $image   = htmlspecialchars($image,ENT_COMPAT);
        // Push Data's
        $data = array(
            "to"            => "$token",
            "notification"  => array( 
                "title"         => "$title", 
                "body"          => "$message", 
                "icon"          => "https://example.com/icon.png", // Replace https://example.com/icon.png with your PUSH ICON URL
                "click_action"  => "$image"
            )
        );
        // Print Output in JSON Format
        $data_string = json_encode($data); 

        // FCM API Token URL
        $url = "https://fcm.googleapis.com/fcm/send";
        //Curl Headers
        $headers = array
        (
        'Authorization: key=' . $API_ACCESS_KEY, 
        'Content-Type: application/json'
        );  
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_URL, $url);                                                                 
        curl_setopt($ch, CURLOPT_POST, 1);  
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string);                                                                  

        // Variable for Print the Result
        $result = curl_exec($ch);
        curl_close ($ch);

        /* saving to database */
            $db_data['message']     = $message;
            $db_data['title']       = $title;
            $db_date['user_id']     = $userid;
            $db_data['image']       = $image;
            //$date = date('Y-m-d H:i:s');
            $nid = uniqid();
            $db_notification_data   = json_encode($db_data);           
          $savetodb = DB::insert("INSERT INTO notifications SET id='".$nid."', type= '', notifiable_type= '',notifiable_id = '".$userid."', data = '".$db_notification_data."', created_at = now()");
        /* saving to database */
    
    }
}