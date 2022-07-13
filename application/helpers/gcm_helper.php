<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GCM
 *
 * @author Rajkumar Jain
 */

class GCM {

    //put your code here
    // constructor
    function __construct() {
        
    }

    /**
     * Sending Push Notification
     */
    public function send($type, $fields, $apikey){
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $api_key = $apikey; //"AAAA0fL61sM:APA91bGHw0IMVP_ttl2997uCy5hGach-MbU0oPIRLW-sSNcEH1C3UXSaTcNMHNLGNuLZqjGKbSrEMZvx6R98h7BXLpcar1LRvdSKNcxPGPKQbjVZurQQS83t3th.100148163hjAhXXqFuLS1xSsT3";
        //echo $api_key; exit;
        
        $headers = array(
            'Authorization: key=' .$api_key ,
            'Content-Type: application/json'
        );
        
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        
        // Close connection
        curl_close($ch);
        
        return $result;
        

    }
    public function send_notification($registatoin_ids, $message, $type, $apikey) {
        
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
            'notification' => $message,
        ); 
        if($type == "android")
        {
            $fields = array(
                        'to' => $registatoin_ids,
                        'notification' => $message,
                        'priority' => 'high',
                        'content_available' => true
                    );

        }
      return  $this->send($type, $fields, $apikey);
    }
    public function send_topics($topics, $message, $type, $apikey) {
        
        $fields = array(
            'to' => $topics,
            'data' => $message,
        );
        if($type=="android")
        {
            $fields = array(
                'to' => $topics,
                'notification' => $message,
                'priority' => 'high',
                'content_available' => true
            );
            
} 
        return $this->send($type, $fields, $apikey);
    }

}

?>