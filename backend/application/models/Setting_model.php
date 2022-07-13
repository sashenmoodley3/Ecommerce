<?php
//$this->load->model("product_model");
class Setting_model extends CI_Model {

    function get_settings() {
        $q = $this->db->query("Select * from settings");
        return $q->result();
    }
    
    function get_themesettings($theme){
        $q = $this->db->query("Select * from theme_color_setting WHERE meta_type='".$theme."'");
        return $q->result();
    }

    function get_setting_by_id($id) {
        $q = $this->db->query("Select * from settings where id = '" . $id . "'");
        return $q->row();
    }
    /***********Rajkumar Sir***********/
    function insertReferralPoint($referral_point){
        /*
         * 
            $this->db->set('field', 'field+1', FALSE);
            $this->db->where('id', 2);
            $this->db->update('mytable'); // gives UPDATE mytable SET field = field+1 WHERE id = 2
         */
        $this->db->set('referral_point', $referral_point, FALSE)
                ->where('id', 2)
                ->update('mytable');
        //$sql = $this->db->last_query();
        return;
        $data = array(
            'referral_point' => $referral_point,
            'admin_id' => $admin_id
        );
        $this->db->insert('mytable');
    }
    //$this->order_sms($user_id,$msg);
    function order_sms($user_id,$message) {
        $user_phone = $this -> db
                -> select('user_phone')
                -> where('user_id', $user_id)
                -> limit(1)
                -> get('registers')
                -> row()
                ->user_phone;
        $this->sendsmsPOST($user_phone, $message);
    }

    function sendsmsPOST($mobileNumber, $message, $url, $user, $password)
    {
        $curl = curl_init();

        $postRequest = array(
            'type' => 'transactional',
            'sender' => $user,
            'recipient' => substr_replace($mobileNumber, "27", 0, 1),
            'content' => $message
        );
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $url, //"https://api.sendinblue.com/v3/transactionalSMS/sms"
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postRequest),
            CURLOPT_HTTPHEADER => [
              "Accept: application/json",
              "Content-Type: application/json",
              $password
            ],
          ]);
          
          $response = curl_exec($curl);
          $err = curl_error($curl);
          
          curl_close($curl);
          
        //   if ($err) {
        //     echo "cURL Error #:" . $err;
        //   } else {
        //     echo $response;
        //   }
    }

    // SEND SMS
    function old_sendsmsPOST($mobileNumber, $message, $url, $user, $password)
    {
        define("SENDER_ID", "DEMOOS");
        define("ROUTE_ID", "1");
        define("SERVER_URL", $url);
        define("AUTH_KEY", "334b9a58d3c90766da228aa3083ffc");
            /*
            $mobileNumber = '';
            $message = '';
            echo sendsmsPOST($mobileNumber, $message);
            */
            //http://sms.dheersoftwaresolutions.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY=334b9a58d3c90766da228aa3083ffc&message=hello&senderId=DEMOOS&routeId=1&mobileNos=7568832271&smsContentType=english
            $getData = '&message='.urlencode($message).'&senderId='.SENDER_ID.'&routeId='.ROUTE_ID.'mobileNos='.$mobileNumber.'&smsContentType=english';
            //API URL
            $url="http://" . SERVER_URL . "/rest/services/sendSMS/sendGroupSms?AUTH_KEY=".AUTH_KEY."&".$getData;
            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            ));
            //get response
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                //echo 'error:' . curl_error($ch);
                return FALSE;
            }
            curl_close($ch);
            return $output;
    }
    public function checkCouponCode($uni_id, $coupon_code)
    {
        $today_date = date('Y-m-d');
        $coupons_list = $this->db->select('tbl_coupons.*,tbl_coupons.coupon_id as coupon_uni_id, 
  											COUNT(tbl_coupon_apply.coupon_id) = tbl_coupons.uses_restriction as used_coupon')
            ->from('tbl_coupons')
            ->join('tbl_coupon_apply','tbl_coupon_apply.coupon_id = tbl_coupons.coupon_id AND tbl_coupon_apply.user_id = "'.$uni_id.'" AND tbl_coupon_apply.coupon_apply_status = 1','left')
            ->where('tbl_coupons.trash',0)
            ->where('tbl_coupons.coupon_code',$coupon_code)
            ->get()
            ->result_array();
        //echo $this->db->last_query();
        $coupons_list = $coupons_list[0];
        if(!empty($coupons_list['coupon_uni_id'])){
            if($coupons_list['coupon_status'] == 1){
              //  echo $today_date; die;
                if($coupons_list['valid_from'] <= $today_date && $coupons_list['valid_to'] >= $today_date){
                    if($coupons_list['used_coupon'] == 0){
                        return array('_success'=>$coupons_list);
                    }else{
                        return array('_error'=>$coupon_code.' Coupon Code Already Used Maximum Time');
                    }
                }else{
                    return array('_error'=>$coupon_code.' Coupon Code Valid Offer Period is Over.');
                }
            }else{
                return array('_error'=>$coupon_code.' Coupon Has Been Expired.');
            }
        }else{
            return array('_error'=>$coupon_code.' is not a valid voucher code');
        }
    }
}

?>