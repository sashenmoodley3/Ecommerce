<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 date_default_timezone_set('Africa/Johannesburg');
class Api extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                // Your own constructor code
                header('Content-type: text/json');
                date_default_timezone_set('Africa/Johannesburg');
                $this->load->database();
                $this->load->helper('sms_helper');
                $this->load->helper(array('form', 'url'));
                $this->db->query("SET time_zone='+05:30'");
				$min_cart   = $this->db->query('SELECT min_cart_amount_shipping FROM rewards')->row();
				$this->config->set_item('delivery_charg', $min_cart->min_cart_amount_shipping);
        }
        public function index(){
			$min_cart   = $this->db->query('SELECT min_cart_amount_shipping FROM rewards')->row();
		
            echo json_encode(array("api"=>"welcome","min_cart_amount_shipping"=>$min_cart->min_cart_amount_shipping,"cart_text" => "Delivery Charges on Order Value Up to R ".($min_cart->min_cart_amount_shipping-1)."/-. Please increase cart value up  to R ".$min_cart->min_cart_amount_shipping."/- to avoid Delivery Charges."));
        }
        public function get_categories(){
            $parent = 0 ;
            if($this->input->post("parent")){
                $parent    = $this->input->post("parent");
            }
        $categories = $this->get_categories_short($parent,0,$this) ;
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
        
    }
public function send_sms($mobilenumber,$textmessage){
    $authKey = "1HsYrNBPFky6bREGh6jO9Q";
    $user    =  'greensh';
    $password    =  '%207ITL7Y4U';
    $mobileNumber = $mobilenumber;
    $senderId = "MANIAM";
    $message = urlencode($textmessage);
    $route = "46";
    $channel = 'trans';
    $DCS     =  0;
    $flashsms = 0;
    // $postData = array(
    //     'user'      => $user,
    //     'password'  =>  $password,
    //     'senderid'  => $senderId,
    //     'channel'   => 'Promo' ,
    //     'DCS'       => '0' ,
    //     'flashsms'  => '0' ,
    //     'mobiles'   => $mobileNumber,
    //     'message'   => $message,
    //     'route'     => $route
    // );
    
    //API URL
    $url="http://103.10.234.154/vendorsms/pushsms.aspx?";
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
        //,CURLOPT_FOLLOWLOCATION => true
    ));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //get response
    $output = curl_exec($ch);
    //Print error if any
    if(curl_errno($ch)){
        return false;
        //echo 'error:' . curl_error($ch);
    }
    curl_close($ch);
    //echo $output;
    return true;
}


public function smsSend($mobilenumber,$textmessage){
        $authKey      = "1HsYrNBPFky6bREGh6jO9Q";
        $user         = "stsfood";
        $password     = "food123";
        $mobileNumber = $mobilenumber;
        $senderId     = "MANIAM";
        $message      = $textmessage;
        $route        = "46";
        $flashsms     = 0;
        $DCS          = 0;
        $channel      = 'trans';

        //$sendmessage    =   'http://103.10.234.154/vendorsms/pushsms.aspx?user=greensh&password=%207ITL7Y4U&msisdn='.$mobilenumber.'&sid=GREENG&msg='.$textmessage.'&fl=0&gwid=2';
	//http://88.99.209.80/http-tokenkeyapi.php?authentic-key=3236677265656e6f3435331596005912&senderid=GREENO&route=5&number=8107388824&message=hello%20there
	 $sendmessage    =   'http://88.99.209.80/http-tokenkeyapi.php?authentic-key=3236677265656e6f3435331596005912&senderid=GREENO&route=5&number='.$mobilenumber.'&message='.$textmessage;
        
        $curl           =   curl_init();
        curl_setopt($curl,  CURLOPT_URL, $sendmessage);
        curl_setopt($curl,  CURLOPT_HTTPHEADER, array('Content-Length: 0'));
        curl_setopt($curl,  CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl,  CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,  CURLINFO_HEADER_OUT, true);
        curl_setopt($curl,  CURLOPT_SSL_VERIFYHOST,2);
        curl_setopt($curl,  CURLOPT_SSL_VERIFYPEER,0);
        $curl_res    =      curl_exec($curl);
        //var_dump($curl_res); exit;
        $info        =      curl_getinfo($curl, CURLINFO_HTTP_CODE);
        return $curl_res;
    }

    public function wlcomeSms($mobilenumber,$textmessage){
        $authKey      = "1HsYrNBPFky6bREGh6jO9Q";
        $user         = "limaraevent";
        $password     = "stsfoods";
        $mobileNumber = $mobilenumber;
        $senderId     = "MEATMN";
        $message      = $textmessage;
        $route        = "2";
        $flashsms     = 0;
        $DCS          = 0;
        $channel      = 'Trans';

        $sendmessage    =   'http://88.99.209.80/http-tokenkeyapi.php?authentic-key=3236677265656e6f3435331596005912&senderid=GREENO&route=5&number='.$mobilenumber.'&message='.$textmessage;
        $curl           =   curl_init();
        curl_setopt($curl,  CURLOPT_URL, $sendmessage);
        curl_setopt($curl,  CURLOPT_HTTPHEADER, array('Content-Length: 0'));
        curl_setopt($curl,  CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl,  CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,  CURLINFO_HEADER_OUT, true);
        curl_setopt($curl,  CURLOPT_SSL_VERIFYHOST,2);
        curl_setopt($curl,  CURLOPT_SSL_VERIFYPEER,0);
        $curl_res    =      curl_exec($curl);
        //var_dump($curl_res); exit;
        $info        =      curl_getinfo($curl, CURLINFO_HTTP_CODE);
        return $curl_res;
    }

     public function generateRandomString($length = 6) {
              $characters = '0123456789';
              $charactersLength = strlen($characters);
              $randomString = '';
              for ($i = 0; $i < $length; $i++) {
                  $randomString .= $characters[rand(0, $charactersLength - 1)];
              }
              $this->load->model("common_model");
              $q = $this->db->query("select `varified_token` from registers where varified_token = '".$randomString."' limit 1");
              if($q->num_rows() > 0){
                  $this->generateRandomString(6);
              }
              else{
                 return $randomString;
              }
              
      }

     public function generateRandomStringUniqe($length = 6){
              $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
              $charactersLength = strlen($characters);
              $randomString = '';
              for ($i = 0; $i < $length; $i++) {
                  $randomString .= $characters[rand(0, $charactersLength - 1)];
              }
              $this->load->model("common_model");
              $q = $this->db->query("select `referralnumber` from registers where referralnumber = '".$randomString."' limit 1");
              if($q->num_rows() > 0){
                  $this->generateRandomStringUniqe(6);
              }
              else{
                 return $randomString;
              }
     }
     public function get_categories_short($parent,$level,$th){
		 $query 	=	'';
		 if($parent == 0){
		 	$query 	=	"a.id IN(54,55) AND";
		 }
            $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                         LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                         WHERE ".$query."  a.`parent`=" . $parent." order by a.ordering ASC");
                        
                        $return_array = array();
                        
                        foreach($q->result() as $row){
                                    if ($row->Count > 0) {
                                        $sub_cat =  $this->get_categories_short($row->id, $level + 1,$th);
                                        $row->sub_cat = $sub_cat;       
                                    } elseif ($row->Count==0) {
                                    
                                    }
                            $return_array[] = $row;
                        }
        return $return_array;
    }
        public function pincode(){
            $q =$this->db->query("Select * from pincode");
             echo json_encode($q->result());
        }
/* user registration */               
public function signup(){
        date_default_timezone_set('Africa/Johannesburg');
      $data = array(); 
      $_POST = $_REQUEST;      
          $this->load->library('form_validation');
          /* add registers table validation */
          $this->form_validation->set_rules('user_name', 'Full Name', 'trim|required');
          $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required|is_unique[registers.user_phone]');
          $this->form_validation->set_rules('user_email', 'User Email', 'trim|is_unique[registers.user_email]');
          $this->form_validation->set_rules('password', 'Password', 'trim|required');
          $this->form_validation->set_rules('referral', 'Referral Code', 'trim');

          if ($this->form_validation->run() == FALSE){
              $data["responce"] = false; 
              if (\strpos(strip_tags($this->form_validation->error_string()), 'Mobile Number') !== false) {
                  $data["status"] = 2;
              }
              else{
                  $data["status"] = 1;
              }
                
              $data["message"] = strip_tags($this->form_validation->error_string());
          }
          else{
              $accesscode       =  $this->generateRandomString(6); 
              $refrralnumber    =  $this->generateRandomStringUniqe(6); 
              $referraluserid   =   '';
              $this->load->model("common_model");
              if(!empty($this->input->post("referral"))){
                  $q = $this->db->query("select user_id from registers where referralnumber = '".$this->input->post("referral")."' limit 1");
                  if($q->num_rows() > 0){
                    $user = $q->row();  
                    $referraluserid   = $user->user_id;
                  }
              }
              $this->db->insert("registers", array("user_phone"=>$this->input->post("user_mobile"), "user_fullname"=>$this->input->post("user_name"), 
                "user_email"=>$this->input->post("user_email"), "user_password"=>md5($this->input->post("password")), "varified_token"=>$accesscode, 
                "status"=>0,'referralnumber'=>$refrralnumber,'referralid'=>$referraluserid));
              
              $user_id          =  $this->db->insert_id();  
              if(!empty($user_id)){
                    $user_gcm_code    = $this->input->post('user_gcm_code');
                    $user_ios_token   = $this->input->post('user_ios_token');
                    $this->db->query("UPDATE registers SET user_gcm_code ='".$user_gcm_code."', user_ios_token ='".$user_ios_token."' WHERE user_id = '".$user_id."'");
              }
              $q                =  $this->db->query("Select * from registers where(user_id='".$user_id."') Limit 1");
              $row              =  $q->row();
              $message          = urlencode('<#> OTP for Green Grocers is '.$accesscode.' and valid for next 30 minutes( Generated at '.date('d-m-Y h:i a').')  63po3H4c2lE');
              $mobile           = '91'.$this->input->post("user_mobile");
              $sendsms          = $this->smsSend($mobile,$message);  
             // $smsdeliverdArray = json_decode($sendsms);
              $data["responce"] = true; 
              $data["refrral"]  = $refrralnumber; 
              $data["data"] = array("user_id"=>$user_id,"user_fullname"=>$row->user_fullname,
                "user_email"=>$row->user_email,"user_phone"=>$row->user_phone,"user_image"=>$row->user_image,"wallet"=>$row->wallet,"rewards"=>$row->rewards,"referralnumber"=>$row->referralnumber,"user_gcm_code"=>$row->user_gcm_code,'user_ios_token'=>$row->user_ios_token) ;

              $data["message"]  = "";
              if($sendsms){
                $data["message"]  = "Send OTP...";
              }
              
              
            }                  
     echo json_encode($data);
}     

      public function socialSignup(){
            $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');
                /* add registers table validation */
                $this->form_validation->set_rules('user_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('oauth_uid', 'Auth Id', 'trim|required|is_unique[registers.oauth_uid]');
                $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required|is_unique[registers.user_phone]');
                $this->form_validation->set_rules('user_email', 'User Email', 'trim|is_unique[registers.user_email]');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                $this->form_validation->set_rules('referral', 'Referral Code', 'trim');

                if ($this->form_validation->run() == FALSE){
                    $data["responce"] = false; 
                    if (\strpos(strip_tags($this->form_validation->error_string()), 'Mobile Number') !== false) {
                        $data["message"] = 2;
                    }
                    else{
                        $data["message"] = 1;
                    }
                      
                    $data["error"] = strip_tags($this->form_validation->error_string());
                }
                else{
                    $accesscode       =  $this->generateRandomString(6); 
                    $refrralnumber    =  $this->generateRandomStringUniqe(6); 
                    $referraluserid   =   '';
                    $this->load->model("common_model");
                    if(!empty($this->input->post("referral"))){
                        $q = $this->db->query("select user_id from registers where referralnumber = '".$this->input->post("referral")."' limit 1");
                        if($q->num_rows() > 0){
                          $user = $q->row();  
                          $referraluserid   = $user->user_id;
                        }
                    }
                    $this->db->insert("registers", array("user_phone"=>$this->input->post("user_mobile"), "user_fullname"=>$this->input->post("user_name"), 
                      "user_email"=>$this->input->post("user_email"), "user_password"=>md5($this->input->post("password")), "varified_token"=>$accesscode, 
                      "status"=>0,'referralnumber'=>$refrralnumber,'referralid'=>$referraluserid,'oauth_provider'=>$this->input->post("oauth_provider"),'oauth_uid'=>$this->input->post("oauth_uid")));
                    
                    $user_id          =  $this->db->insert_id();  
                    if(!empty($user_id)){
                          $user_gcm_code    = $this->input->post('user_gcm_code');
                          $user_ios_token   = $this->input->post('user_ios_token');
                          $this->db->query("UPDATE registers SET user_gcm_code ='".$user_gcm_code."', user_ios_token ='".$user_ios_token."' WHERE user_id = '".$user_id."'");
                    }
                    $q                =  $this->db->query("Select * from registers where(user_id='".$user_id."') Limit 1");
                    $row              =  $q->row();
                    $data["responce"] = true; 
                    $data["refrral"]  = $refrralnumber; 
                    $data["data"] = array("user_id"=>$user_id,"user_fullname"=>$row->user_fullname,
                      "user_email"=>$row->user_email,"user_phone"=>$row->user_phone,"user_image"=>$row->user_image,"wallet"=>$row->wallet,"rewards"=>$row->rewards,"referralnumber"=>$row->referralnumber,"user_gcm_code"=>$row->user_gcm_code,'user_ios_token'=>$row->user_ios_token) ;

                    $data["message"]  = "Successfully Sign up user !!";
                    
                  }                  
           echo json_encode($data);
      }     

public function otpRegenrate(){
        date_default_timezone_set('Africa/Johannesburg');
      $data = array(); 
      $_POST = $_REQUEST;  
          $this->load->library('form_validation');
          /* add registers table validation */
          $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required');
          if ($this->form_validation->run() == FALSE){
              $data["responce"] = false;  
              $data["message"] = strip_tags($this->form_validation->error_string());
          }
          else{
              $accesscode       =  $this->generateRandomString(6); 
              $this->load->model("common_model");
              $this->common_model->data_update("registers", array(
                                      "varified_token" => $accesscode
                                      ),array("user_phone"=>$this->input->post("user_mobile")));
              
              $message          = urlencode('<#> OTP for Green Grocers is '.$accesscode.' and is valid for 30 minutes( Generated at '.date('d-m-Y h:i a').') 63po3H4c2lE');
              $mobile           = '91'.$this->input->post("user_mobile");
              $sendsms          = $this->smsSend($mobile,$message); 
             // $sendsms          = $this->smsSend($mobile,$message);  
              $smsdeliverdArray = json_decode($sendsms);
              $data["responce"] = true; 
              if($smsdeliverdArray){
                $q                =  $this->db->query("Select * from registers where(user_phone='".$this->input->post("user_mobile")."') Limit 1");
                $row              =  $q->row();
                $data["data"] = array("user_id"=>$row->user_id,"user_fullname"=>$row->user_fullname,
                      "user_email"=>$row->user_email,"user_phone"=>$row->user_phone,"user_image"=>$row->user_image,"wallet"=>$row->wallet,"rewards"=>$row->rewards,"referralnumber"=>$row->referralnumber,"user_gcm_code"=>$row->user_gcm_code,'user_ios_token'=>$row->user_ios_token) ;
                $data["message"]  = "Send OTP...";
              }
              
            }                  
     echo json_encode($data);
}   
public function otpChecked(){
      $data = array(); 
      $_POST = $_REQUEST;      
      $this->load->library('form_validation');
      /* add registers table validation */
      $this->form_validation->set_rules('otp_number', 'OTP Code', 'trim|required');
      $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
      
      if ($this->form_validation->run() == FALSE){
          $data["responce"] = false;  
          $data["error"] = strip_tags($this->form_validation->error_string());
      }
      else{

          $this->load->model("common_model");
          $q = $this->db->query("select user_id from registers where   varified_token = '".$this->input->post("otp_number")."' limit 1"); //user_id = '".$this->input->post("user_id")."' and
          $user = $q->row();
          if(!empty($user->user_id)){
            $this->common_model->data_update("registers", array("mobile_verified"=>1, "varified_token" => '', "status" => 1), array("user_id"=>$user->user_id));
            
            $data["responce"] = true;
            $data["message"]  = "Sucessfully Mobile verify...";
          }
          else{
            $data["responce"] = false; 
            $data["message"]  = "OTP Code is Wrong...";
          }
      }                  
    echo json_encode($data);
}

 public function update_profile_pic(){
        date_default_timezone_set('Africa/Johannesburg');
        $data = array(); 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                
                if(isset($_FILES["image"]) && $_FILES["image"]["size"] > 0){
                    $config['upload_path']          = './uploads/profile/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
    
                    if ( ! $this->upload->do_upload('image'))
                    {
                    $data["responce"] = false;  
                    $data["error"] = 'Error! : '.$this->upload->display_errors();
                           
                    }
                    else
                    {
                        $img_data = $this->upload->data();
                        $this->load->model("common_model");
                        $this->common_model->data_update("registers", array(
                                            "user_image"=>$img_data['file_name']
                                            ),array("user_id"=>$this->input->post("user_id")));
                                            
                        $data["responce"] = true;
                        $data["data"] = $img_data['file_name'];
                    }
                    
                    }else{
                $data["responce"] = false;  
                    $data["error"] = 'Please choose profile image';
                
                    }
               
               
                  }                  
           
                     echo json_encode($data);
        
        }     

public function change_password(){
            date_default_timezone_set('Africa/Johannesburg');
            $data = array(); 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
                $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $this->load->model("common_model");
                    $q = $this->db->query("select * from registers where user_id = '".$this->input->post("user_id")."' and  user_password = '".md5($this->input->post("current_password"))."' limit 1");
                    $user = $q->row();
                    
                    if(!empty($user)){
                    $this->common_model->data_update("registers", array(
                                            "user_password"=>md5($this->input->post("new_password"))
                                            ),array("user_id"=>$user->user_id));
                    
                    $data["responce"] = true;
                    }else{
                    $data["responce"] = false;  
                    $data["error"] = 'Current password do not match';
                    }
                  }                  
           
                     echo json_encode($data);
}      

public function update_userdata(){
            date_default_timezone_set('Africa/Johannesburg');
          $data = array(); 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                 $this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|required');
                
                
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $insert_array=  array(
                                            "user_fullname"=>$this->input->post("user_fullname"),
                                            "user_phone"=>$this->input->post("user_mobile")
                                            
                                            );
                     
                    $this->load->model("common_model");
                    //$this->db->where(array("user_id",$this->input->post("user_id")));
                        if(isset($_FILES["image"]) && $_FILES["image"]["size"] > 0){
                    $config['upload_path']          = './uploads/profile/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                   
                    if ( ! $this->upload->do_upload('image'))
                    {
                    $data["responce"] = false;  
                    $data["error"] = 'Error! : '.$this->upload->display_errors();
                           
                    }
                    else
                    {
                         $img_data = $this->upload->data();
                         $image_name = $img_data['file_name'];
                         $insert_array["user_image"]=$image_name;
                    }
                    
                    } 
                    
                   $this->common_model->data_update("registers",$insert_array,array("user_id"=>$this->input->post("user_id")));
                    
                      $q = $this->db->query("Select * from `registers` where(user_id='".$this->input->post('user_id')."' ) Limit 1");  
                      $row = $q->row();
                    $data["responce"] = true;
                    $data["data"] = array("user_id"=>$row->user_id,"user_fullname"=>$row->user_fullname,"user_email"=>$row->user_email,"user_phone"=>$row->user_phone,"user_image"=>$row->user_image,"pincode"=>$row->pincode,"socity_id"=>$row->socity_id,"house_no"=>$row->house_no) ;
                  }                  
           
                     echo json_encode($data);
}           
/* user login json */
     
public function login(){
            date_default_timezone_set('Africa/Johannesburg');
            $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');
                 //$this->form_validation->set_rules('user_email', 'Email Id / Mobile Number',  'trim|required');
                 $this->form_validation->set_rules('user_email', 'Mobile Number',  'trim|required');
                 $this->form_validation->set_rules('password', 'Password', 'trim|required');
                 $this->form_validation->set_rules('user_gcm_code', 'GSM Code', 'trim');
                 $this->form_validation->set_rules('user_ios_token', 'Ios Code', 'trim');
               
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] =  strip_tags($this->form_validation->error_string());
                    
                }else
                {
                   //users.user_email='".$this->input->post('user_email')."' or
 //$q = $this->db->query("Select * from registers where(user_email='".$this->input->post('user_email')."' OR user_phone='".$this->input->post('user_email')."' ) and user_password='".md5($this->input->post('password'))."' Limit 1");
 $q = $this->db->query("Select * from registers where(user_phone='".$this->input->post('user_email')."' ) and user_password='".md5($this->input->post('password'))."' Limit 1");
                    
                    
                    if ($q->num_rows() > 0)
                    {
                        $row = $q->row(); 
                        if($row->status == "0")
                        {
                                $data["responce"] = false;  
                                $data["error"] = 'Your account currently inactive.Please Contact Admin';
                            
                        }
                       
                        else
                        {
                              $data["responce"] = true;  
                              $user_gcm_code    = $this->input->post('user_gcm_code');
                              $user_ios_token   = $this->input->post('user_ios_token');
                              //echo "UPDATE registers SET user_gcm_code ='".$user_gcm_code."', user_ios_token ='".$user_ios_token."' WHERE user_id = '".$row->user_id."'"; exit;
                              $this->db->query("UPDATE registers SET user_gcm_code ='".$user_gcm_code."', user_ios_token ='".$user_ios_token."' WHERE user_id = '".$row->user_id."'");

              $data["data"] = array("user_id"=>$row->user_id,"user_fullname"=>$row->user_fullname,
                "user_email"=>$row->user_email,"user_phone"=>$row->user_phone,"user_image"=>$row->user_image,"wallet"=>$row->wallet,"rewards"=>$row->rewards,"referralnumber"=>$row->referralnumber,"user_gcm_code"=>$user_gcm_code,'user_ios_token'=>$user_ios_token) ;
                               
                        }
                    }
                    else
                    {
                              $data["responce"] = false;  
                              $data["error"] = 'Invalide Username or Passwords';
                    }
                   
                    
                }
           echo json_encode($data);
            
        }
        
        public function socialLogin(){
            $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');
                 //$this->form_validation->set_rules('user_email', 'Email Id / Mobile Number',  'trim|required');
                 $this->form_validation->set_rules('user_email', 'Mobile Number',  'trim|required');
                 $this->form_validation->set_rules('oauth_uid', 'Auth id', 'trim|required');
                 $this->form_validation->set_rules('user_gcm_code', 'GSM Code', 'trim');
                 $this->form_validation->set_rules('user_ios_token', 'Ios Code', 'trim');
               
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] =  strip_tags($this->form_validation->error_string());
                    
                }
                else{
                   //users.user_email='".$this->input->post('user_email')."' or
                  // $q = $this->db->query("Select * from registers where(user_email='".$this->input->post('user_email')."' OR user_phone='".$this->input->post('user_email')."' ) and oauth_uid='".($this->input->post('oauth_uid'))."' Limit 1");
                   $q = $this->db->query("Select * from registers where(user_phone='".$this->input->post('user_email')."' ) and oauth_uid='".($this->input->post('oauth_uid'))."' Limit 1");
                    
                    
                    if ($q->num_rows() > 0)
                    {
                        $row = $q->row(); 
                        if($row->status == "0")
                        {
                                $data["responce"] = false;  
                              $data["error"] = 'Your account currently inactive.Please Contact Admin';
                            
                        }
                       
                        else
                        {
                              $data["responce"] = true;  
                              $user_gcm_code    = $this->input->post('user_gcm_code');
                              $user_ios_token   = $this->input->post('user_ios_token');
                              //echo "UPDATE registers SET user_gcm_code ='".$user_gcm_code."', user_ios_token ='".$user_ios_token."' WHERE user_id = '".$row->user_id."'"; exit;
                              $this->db->query("UPDATE registers SET user_gcm_code ='".$user_gcm_code."', user_ios_token ='".$user_ios_token."' WHERE user_id = '".$row->user_id."'");

              $data["data"] = array("user_id"=>$row->user_id,"user_fullname"=>$row->user_fullname,
                "user_email"=>$row->user_email,"user_phone"=>$row->user_phone,"user_image"=>$row->user_image,"wallet"=>$row->wallet,"rewards"=>$row->rewards,"referralnumber"=>$row->referralnumber,"user_gcm_code"=>$user_gcm_code,'user_ios_token'=>$user_ios_token) ;
                               
                        }
                    }
                    else
                    {
                              $data["responce"] = false;  
                              $data["error"] = 'Invalide Username or Passwords';
                    }
                   
                    
                }
           echo json_encode($data);
            
        }
        
         function appVersion()
         {
           $q = $this->db->query("SELECT * FROM app_android_setting WHERE app_id IN('1','3')");
           $app["app"] = $q->result();
           echo json_encode($app);
           } 
           
        function appVersionDelivery(){
           $q = $this->db->query("SELECT * FROM app_android_setting WHERE app_id IN('4')");
           $app["app"] = $q->result();
           echo json_encode($app);
        } 
          function city()
                   {
                     $q = $this->db->query("SELECT * FROM `city`");
                     $city["city"] = $q->result();
                     echo json_encode($city);
                     } 
        function store(){
            $data = array(); 
            $_POST = $_REQUEST;          
            $getdata =$this->input->post('city_id');
            if($getdata!=''){      
                  $q = $this->db->query("Select user_fullname ,user_id FROM `users` where (user_city='".$this->input->post('city_id')."')");
                  $data["data"] = $q->result();                  
                  echo json_encode($data);
               }
               else{
                    $data["data"] ="Error";                 
                    echo json_encode($data);  
               }
         }

        function get_products(){
            date_default_timezone_set('Africa/Johannesburg');
            $this->load->model("product_model");
            $cat_id = "";
            if($this->input->post("cat_id")){
                $cat_id = $this->input->post("cat_id");
            }
            $search= $this->input->post("search");
            $data["responce"] = true;  
            $datas = $this->product_model->get_products(false,$cat_id,$search,$this->input->post("page"));
                //print_r( $datas);exit();
                foreach ($datas as  $product) {
                    $present = date('m/d/Y h:i:s a', time());
                      $date1 = $product->start_date." ".$product->start_time;
                      $date2 = $product->end_date." ".$product->end_time;

                     if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2)){
                       if(empty($product->deal_price))   ///Runing
                       {
                          $price= $product->price;
                       }else{
                          $price= $product->deal_price;
                       }
                     }
                     else{
                      $price= $product->price;//expired
                     } 
                            
                  $data['data'][] = array(
                      'product_id' => $product->product_id,
                      'product_name'=> $product->product_name,
                      'category_id'=> $product->category_id,
                      'product_description'=>$product->product_description,
                      'deal_price'=>'',
                      'start_date'=>"",
                      'start_time'=>"",
                      'end_date'=>"",
                      'end_time'=>"",
                      'price' =>$price,
                      'mrp' =>$product->mrp,
                      'product_image'=>$product->product_image,
                      //'tax'=>$product->tax,
                      'status' => '0',
                      'in_stock' =>$product->in_stock,
                      'unit_value'=>$product->unit_value,
                      'unit'=>$product->unit,
                      'increament'=>$product->increament,
                      'rewards'=>$product->rewards,
                      'stock'=>$product->stock,
                      'title'=>$product->title
                   );
                }
                echo json_encode($data);
        }       
        
        function get_products_suggestion(){
             $this->load->model("product_model");
                $cat_id = "";
                if($this->input->post("cat_id"))
                {
                    $cat_id = $this->input->post("cat_id");
                }
                $search= $this->input->post("search");
                
                //$data["responce"] = true;  
                $data["data"] = $this->product_model->get_products_suggestion(false,$cat_id,$search,$this->input->post("page"));
                echo json_encode($data);

        }
        function get_time_slots(){
          $date = date("Y-m-d");
          $this->load->model("time_model");
          $time_slot = $this->time_model->get_time_slots($date);
			//print_r($time_slot); exit;
          if(!empty($time_slot)){
            $data["responce"] = true;
            $data["times"] = $time_slot;
          }
          else{
            $data["responce"] = false;
            $data["times"] = array();
          }
          echo json_encode($data);
        }


         function get_time_slot(){ 
            date_default_timezone_set('Africa/Johannesburg');
            $this->load->library('form_validation');
			 $this->form_validation->set_rules('date', 'date', 'trim|required');
			 if ($this->form_validation->run() == FALSE) {
				 $data["responce"] = false;
				 $data["error"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
			 } else {
				 $date = date("Y-m-d", strtotime($this->input->post("date")));

				 $time = date("H:i:s");



				 $this->load->model("time_model");
				 $time_slot = $this->time_model->get_time_slot();
				 $cloasing_hours = $this->time_model->get_closing_hours($date);


				 $begin = new DateTime($time_slot->opening_time);
				 $end = new DateTime($time_slot->closing_time);

				 $interval = DateInterval::createFromDateString($time_slot->time_slot . ' min');

				 $times = new DatePeriod($begin, $interval, $end);
				 $current_Time   =   date('h:i a', time() + 3600);
				 //echo $current_Time; exit;
				 $time_array = array();
				 foreach ($times as $time) {
					 if (!empty($cloasing_hours)) {
						 foreach ($cloasing_hours as $c_hr) {
							 if ($date == date("Y-m-d")) {
								 if (strtotime($time->format('h:i A')) > strtotime(date("h:i A")) && strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) < strtotime($c_hr->to_time)) {

								 } else {
									 //echo ($time->format('h:i A')).' >>>> '.($current_Time).'<br/>';
									 if(strtotime($time->format('h:i A')) >  strtotime($current_Time)){ 
										 $time_array[] = $time->format('h:i A') . ' - ' .$time->add($interval)->format('h:i A');
									 }

								 }
							 } else {
								 if (strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) < strtotime($c_hr->to_time)) {

								 } elseif(strtotime($time->format('h:i A')) >  strtotime($current_Time)){ 
									 $time_array[] = $time->format('h:i A') . ' - ' .$time->add($interval)->format('h:i A');
								 }
							 }
						 }
					 } else {
						 if (strtotime($date) == strtotime(date("Y-m-d"))) {
							 if (strtotime($time->format('h:i A')) > strtotime($current_Time)) {
								 $time_array[] = $time->format('h:i A') . ' - ' .
									 $time->add($interval)->format('h:i A');
							 }
						 } else {
							 $time_array[] = $time->format('h:i A') . ' - ' .
								 $time->add($interval)->format('h:i A')
								 ;
						 }
					 }
				 }
				 $data["responce"] = true;
				 $data["times"] = $time_array;
			 }
			 echo json_encode($data);
            
        } 
         
        function text_for_send_order(){
            echo json_encode(array("data"=>"<p>Our delivery boy will come withing your choosen time and will deliver your order. \n 
            </p>"));
        }
        function deductionRewardsPoint(){
          $amount               = $this->input->post("amount");
          $rewards              = $this->input->post("rewards");
          $user_id              = $this->input->post("user_id");
          $data['status']       =   '1';  
          $ld = $this->db->query("SELECT referralcut FROM rewards WHERE 1");
          if($ld->num_rows() > 0 ){
               $referralcut = $ld->row()->referralcut; 
               $calculatepercentage  =   ($amount*$referralcut)/100;
               $rewardsAmountUse     =   $calculatepercentage;
               if($rewardsAmountUse < $rewards){
                  $remainingReward   =   ($rewards-$calculatepercentage);
               }
               elseif($rewardsAmountUse > $rewards){
                  $remainingReward   =   0;
               }
               $data['status']       =   '1';  
               $data['response']     =   array(
                                                'remainingReward'   =>  $remainingReward,
                                                'rewardsAmountUse'  =>  $rewardsAmountUse
                                          );
            } 
            echo json_encode($data);
        }
        function send_order(){
            date_default_timezone_set('Africa/Johannesburg');
			$delivery_charg  = $this->config->item('delivery_charg');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                $this->form_validation->set_rules('date', 'Date',  'trim|required');
                $this->form_validation->set_rules('time', 'Time',  'trim|required');
                $this->form_validation->set_rules('data', 'data',  'trim|required');
                $this->form_validation->set_rules('location', 'Location',  'trim');
                if ($this->form_validation->run() == FALSE){
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }
                else{
                    if(!empty($this->input->post("location"))){
                         $ld = $this->db->query("select user_location.*, socity.* from user_location
                        inner join socity on socity.socity_id = user_location.socity_id
                         where user_location.location_id = '".$this->input->post("location")."' limit 1");
                        $location = $ld->row(); 
                        $diliveryaddress  = $location->receiver_name."\n, ".$location->house_no;
                        $socity           = $location->socity_id;
                        $delivery_charge  = $location->delivery_charge;
                        $location_id      = $location->location_id;
                    }
                    else{
                        $location_id   = $this->input->post("location");
                    }
                    
                    if(!empty($this->input->post("store_id"))){
                       $q = $this->db->query("SELECT users.user_id, users.user_name, users.user_email, users.user_phone, 
                                              users.user_fullname, users.user_image, users.user_address, users.user_landmark, 
                                              users.user_pincode, states.name AS statename, city.city_name AS cityname
                                              FROM users
                                              LEFT JOIN states ON states.indexId=users.user_state
                                              LEFT JOIN city ON city.city_id=users.user_city
                                              WHERE users.user_status=1 AND users.user_id='".$this->input->post("store_id")."' limit 1");
                       $store = $q->row();
                       $diliveryaddress   = $store->user_address."\n, ".$store->user_landmark."\n, ".$store->cityname."\n, ".$store->statename."\n, ".$store->user_pincode;
                       $socity            = 0;
                       $delivery_charge   = 0;
                       $store_id          = $this->input->post("store_id");
                    }  
                    else{
                       $store_id          = $this->input->post("store_id");
                    }
                    $payment_method = $this->input->post("payment_method");
                    $date           = date("Y-m-d", strtotime($this->input->post("date")));
                    $Mmony          = $this->input->post("Mmoney");
                    $Mrupee         = $this->input->post("Mrupee");
                    $amount         = $this->input->post("amount");
                    //$timeslot = explode("-",$this->input->post("timeslot"));
                    
                    $times = explode('-',$this->input->post("time"));
                    $fromtime = date("h:i a",strtotime(trim($times[0]))) ;
                    $totime = date("h:i a",strtotime(trim($times[1])));
                    
                   
                    $user_id = $this->input->post("user_id");
                    
                    $insert_array = array("user_id"=>$user_id,
                    "on_date"=>$date,
                    "delivery_time_from"=>$fromtime,
                    "delivery_time_to"=>$totime,
                    "delivery_address"=>$diliveryaddress,
                    "socity_id" => $socity, 
                    "delivery_charge" => $delivery_charge,
                    "location_id" => $location_id, 
                    "payment_method" => $payment_method,
                    "new_store_id" => $store_id,
                    "orderdatetime"=> date('Y-m-d H:i:s')
                    );
                    if($payment_method =='COD'){
                        $insert_array['status'] = 0;
                    }
                    else{
                        $insert_array['status'] = 0;
                    }
                    $this->load->model("common_model");
                    $id = $this->common_model->data_insert("sale",$insert_array);
                    
                    $data_post = $this->input->post("data");
                    $data_array = json_decode($data_post);
                    $total_rewards = 0;
                    $total_price = 0;
                    $total_kg = 0;
                    $total_items = array();
                    foreach($data_array as $dt){
                        $qty_in_kg = $dt->qty; 
                        if($dt->unit=="gram"){
                            $qty_in_kg =  ($dt->qty * $dt->unit_value) / 1000;     
                        }
                        $total_rewards = $total_rewards + ($dt->qty * $dt->rewards);
                        $total_price = $total_price + ($dt->qty * $dt->price);
                        $total_kg = $total_kg + $qty_in_kg;
                        $total_items[$dt->product_id] = ($dt->qty * $dt->rewards);    
                        
                        $array = array("product_id"=>$dt->product_id,
                        "qty"=>$dt->qty,
                        "unit"=>$dt->unit,
                        "unit_value"=>$dt->unit_value,
                        "sale_id"=>$id,
                        "price"=>$dt->price,
                        "qty_in_kg"=>$qty_in_kg,
                        "rewards" =>$dt->rewards
                        );
                        $this->common_model->data_insert("sale_items",$array);
                         
                    }
					
					if($total_price < $delivery_charg){
						$total_price = $total_price + $delivery_charge;
					}
					else{
						$total_price = $total_price;
					}
                    

                   /*  $rewardsSql   =   $this->db->query("SELECT `point` FROM rewards LIMIT 1");    
                    if($rewardsSql->num_rows() > 0 ){
                       $point = $rewardsSql->row()->point; 
                        $calculatepercentage  =   (array_sum($total_items)*$point);

                       $this->db->query("INSERT INTO mmoney (mmoney, mtype, transactionid, userid, depositdatetime, remark, status,mstatus) VALUES('$calculatepercentage', 'cr', '$id', '$user_id', NOW(), 'Purchase Point', '103','1')");
                    }  */
                    
                    $this->db->query("UPDATE sale SET amount ='".$amount."', mmoney ='".$Mmony."', mrupee ='".$Mrupee."', total_amount = '".$total_price."', total_kg = '".$total_kg."', total_items = '".count($total_items)."', total_rewards = '".$total_rewards."' WHERE sale_id = '".$id."'");

                    if(!empty($Mmony)){
                         $this->db->query("INSERT INTO mmoney (mmoney, mtype, transactionid, userid, depositdatetime, remark, status,mstatus) VALUES('$Mmony', 'dr', '$id', '$user_id', NOW(), 'Use Order Place', '103','2')");
                    }

                    if(!empty($Mrupee)){
                        $this->db->query("INSERT INTO mrupees (mrupee, mtype, transactionid, userid, depositdatetime, remark, `status`,mstatus) 
                              VALUES('$Mrupee', 'dr', '$id', '$user_id', 'NOW()', 'Use Order Place', '103','1')");
                    }

                    $print_date     = date("d-m-Y", strtotime($date)); 
                    $payamount      = (($total_price)-($Mmony+$Mrupee));
                    $data["responce"] = true;  
                    if($payment_method == 'COD'){
                        $data["data"] = addslashes( "<p>Your order No #".$id." is send success fully \n Our Delivery Person will try to Deliver Order \n 
                                        between ".$fromtime." to ".$totime." on ".$print_date." \n
                                        Please Pay <strong>".$payamount."</strong> on delivery
                                        Thanks For Being With us.</p>" );
                    }
                    else{
                        $data["data"] = $this->paytmpost($id, $total_price);
                    }
                    
                    
                }
                echo json_encode($data);
        } 
         function paytmpost($id, $total_price){
           header("Pragma: no-cache");
           header("Cache-Control: no-cache");
           header("Expires: 0");
           // following files need to be included
           require_once(APPPATH . "/libraries/paytm/config_paytm.php");
           require_once(APPPATH . "/libraries/paytm/encdec_paytm.php");
            
           $checkSum = "";
           $paramList = array();
          // Create an array having all required parameters for creating checksum.
           $paramList["MID"] = PAYTM_MERCHANT_MID;
           $paramList["ORDER_ID"] = $id;
           $paramList["CUST_ID"] = $id;
           $paramList["INDUSTRY_TYPE_ID"] = INDUSTRY_TYPE_ID;
           $paramList["CHANNEL_ID"] = CHANNEL_ID;
           $paramList["TXN_AMOUNT"] = $total_price;
           $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
           $paramList["CALLBACK_URL"] = 'https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID='.$id;
			//'https://securegw.paytm.in/theia/paytmCallback?ORDER_ID='.$id;
          //Here checksum string will return by getChecksumFromArray() function.
           $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
           $list     =  array(
                            'checkSum'      =>$checkSum,
                            'marchent'      =>$paramList
                         );
            return $list;

        }
        function payonline(){
            date_default_timezone_set('Africa/Johannesburg');
           header("Pragma: no-cache");
           header("Cache-Control: no-cache");
           header("Expires: 0");
           // following files need to be included
           require_once(APPPATH . "/libraries/paytm/config_paytm.php");
           require_once(APPPATH . "/libraries/paytm/encdec_paytm.php");
            
            
            $paytmChecksum = "";
            $paramList = array();
            $isValidChecksum = FALSE;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('order_id', 'Order ID',  'trim|required');
            $this->form_validation->set_rules('transaction_id', 'Transaction Id',  'trim|required');
            $this->form_validation->set_rules('status', 'Transaction Status',  'trim|required');
            if ($this->form_validation->run() == FALSE){
                $data["responce"] = false;  
                $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                
            }
            else{
                $order_id         =   $this->input->post("order_id");
                $transaction_id   =   $this->input->post("transaction_id");
                $status           =   $this->input->post("status");
                $total_price      =   $this->input->post("total_price");
                $paramList["MID"] = PAYTM_MERCHANT_MID;
                $paramList["ORDER_ID"] = $order_id;
                $paramList["CUST_ID"] = $order_id;
                $paramList["INDUSTRY_TYPE_ID"] = INDUSTRY_TYPE_ID;
                $paramList["CHANNEL_ID"] = CHANNEL_ID;
                $paramList["TXN_AMOUNT"] = $total_price;
                $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
                $paramList["CALLBACK_URL"] = 'https://securegw.paytm.in/theia/paytmCallback?ORDER_ID='.$order_id;

                $paytmChecksum    = $this->input->post("CHECKSUMHASH");
                $isValidChecksum  = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum);
                $return_array     = $isValidChecksum ? "Y" : "N";
                $data["responce"] =   false;
                if(!empty($transaction_id) && !empty($order_id) && $return_array=='Y' && $status =='TXN_SUCCESS'){
                    $this->db->query("UPDATE sale SET status ='0', transaction_id='".$transaction_id."', is_paid='1' WHERE sale_id = '".$order_id."'");
                    $rewardsSql   =   $this->db->query("SELECT * FROM sale WHERE sale_id = '".$order_id."'");   
                    $row          =   $rewardsSql->row();
                    
                    $payamount      = (($row->total_amount)-($row->mmoney+$row->mrupee));
                    $data["responce"] = true; 
                    $data["data"] = addslashes( "<p>Your order No #".$order_id." is send success fully \n Our delivery person will delivered order \n 
                                        between ".$row->delivery_time_from." to ".$row->delivery_time_to." on ".$row->on_date." \n
                                        Thanks for being with Us.</p>" );
                }
            }
          echo json_encode($data);  
        }
        function my_orders(){
            date_default_timezone_set('Africa/Johannesburg');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $this->load->model("product_model");
                    $datas = $this->product_model->get_sale_by_user($this->input->post("user_id"));
                    foreach($datas as $row){
                        $transaction_id      =   '';
                        $store_landmark      =   '';
                        $store_city_name     =   '';
                        $store_pincode       =   '';
                        $store_statename     =   '';
                        $paid                =  '';
                        $store_address       =  '';
                        if(!empty($row->transaction_id)){
                            $transaction_id =   $row->transaction_id;
                        }
                        if(!empty($row->store_address)){
                            $store_address =   $row->store_address;
                        }
                        if(!empty($row->store_landmark)){
                            $store_landmark =   $row->store_landmark;
                        }
                        if(!empty($row->store_pincode)){
                            $store_pincode =   $row->store_pincode;
                        }
                        if(!empty($row->statename)){
                            $store_statename =   $row->statename;
                        }
                        if(!empty($row->city_name)){
                            $store_city_name =   $row->city_name;
                        }
                        
                        if($row->payment_method !='COD'){
                            if(!empty($transaction_id)){
                                $paid  = 'Paid';
                            }
                            else{
                                $paid  = 'Payment Failuer';
                            }
                        }
                        else{
                            if($row->status == 0){
                               $paid    =   'Pending'; 
                            }
                            elseif($row->status == 1){
                               $paid    =   'Confirm'; 
                            }
                            elseif($row->status == 2){
                               $paid    =   'Out For Delivery'; 
                            }
                            elseif($row->status == 3){
                               $paid    =   'Cancel'; 
                            }
                            elseif($row->status == 4){
                               $paid    =   'Delivered'; 
                            }
                            
                        }

                        
                        
                        $data[] = array(
                                                    "sale_id"                   => $row->sale_id,
                                                    "user_id"                   => $row->user_id,
                                                    "on_date"                   => $row->on_date,
                                                    "delivery_time_from"        => $row->delivery_time_from,
                                                    "delivery_time_to"          => $row->delivery_time_to,
                                                    "status"                    => $row->status,
                                                    "note"                      => "",
                                                    "is_paid"                   => $row->status,
                                                    "amount"                    => $row->amount,
                                                    "mmoney"                    => $row->mmoney,
                                                    "mrupee"                    => $row->mrupee,
                                                    "total_amount"              => $row->total_amount,
                                                    "total_rewards"             => $row->total_rewards,
                                                    "total_kg"                  => $row->total_kg,
                                                    "total_items"               => $row->total_items,
                                                    "socity_id"                 => $row->socity_id,
                                                    "delivery_address"          => $row->delivery_address,
                                                    "location_id"               => $row->location_id,
                                                    "delivery_charge"           => $row->delivery_charge,
                                                    "new_store_id"              => $row->new_store_id,
                                                    "assign_to"                 => $row->assign_to,
                                                    "payment_method"            => $row->payment_method,
                                                    "orderdatetime"             => $row->orderdatetime,
                                                    "transaction_id"            => $transaction_id,
                                                    "Pay"                       => $paid,
                                                    "store_address"             => $store_address,
                                                    "store_landmark"            => $store_landmark,
                                                    "store_pincode"             => $store_pincode,
                                                    "store_statename"           => $store_statename,
                                                    "store_city_name"           => $store_city_name,
                            
                            
                                            );
                    }
                }
                echo json_encode($data);
        }
        function delivered_complete1(){
                date_default_timezone_set('Africa/Johannesburg');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $this->load->model("product_model");
                    $data = $this->product_model->get_sale_by_user2($this->input->post("user_id"));
                }
                echo json_encode($data);
        }
        function delivered_complete(){
                date_default_timezone_set('Africa/Johannesburg');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $this->load->model("product_model");
                    $datas = $this->product_model->get_sale_by_user3($this->input->post("user_id"));
                    if(!empty($datas)){
                        foreach($datas as $row){
                            $transaction_id      =   '';
                            $store_landmark      =   '';
                            $store_city_name     =   '';
                            $store_pincode       =   '';
                            $store_statename     =   '';
                            $paid                =  '';
                            $store_address       =  '';
                            if(!empty($row->transaction_id)){
                                $transaction_id =   $row->transaction_id;
                            }
                            if(!empty($row->store_address)){
                                $store_address =   $row->store_address;
                            }
                            if(!empty($row->store_landmark)){
                                $store_landmark =   $row->store_landmark;
                            }
                            if(!empty($row->store_pincode)){
                                $store_pincode =   $row->store_pincode;
                            }
                            if(!empty($row->statename)){
                                $store_statename =   $row->statename;
                            }
                            if(!empty($row->city_name)){
                                $store_city_name =   $row->city_name;
                            }
                            
                            if($row->payment_method !='COD'){
                                if(!empty($transaction_id)){
                                    $paid  = 'Paid';
                                }
                                else{
                                    $paid  = 'Payment Failuer';
                                }
                            }
                            else{
                                if($row->status == 0){
                                   $paid    =   'Pending'; 
                                }
                                elseif($row->status == 1){
                                   $paid    =   'Confirm'; 
                                }
                                elseif($row->status == 2){
                                   $paid    =   'Out For Delivery'; 
                                }
                                elseif($row->status == 3){
                                   $paid    =   'Cancel'; 
                                }
                                elseif($row->status == 4){
                                   $paid    =   'Delivered'; 
                                }
                                
                            }
                            $amount         =   '';
                            $mmoney         =   '';
                            $mrupee         =   '';
                            if(!empty($row->amount)){
                                $amount = $row->amount;
                            }
                            if(!empty($row->mmoney)){
                                $mmoney = $row->mmoney;
                            }
                            if(!empty($row->mrupee)){
                                $mrupee = $row->mrupee;
                            }
                            
                            
                            $data[] = array(
                                                        "sale_id"                   => $row->sale_id,
                                                        "user_id"                   => $row->user_id,
                                                        "on_date"                   => $row->on_date,
                                                        "delivery_time_from"        => $row->delivery_time_from,
                                                        "delivery_time_to"          => $row->delivery_time_to,
                                                        "status"                    => $row->status,
                                                        "note"                      => "",
                                                        "is_paid"                   => $row->status,
                                                        "amount"                    => $amount,
                                                        "mmoney"                    => $mmoney,
                                                        "mrupee"                    => $mrupee,
                                                        "total_amount"              => $row->total_amount,
                                                        "total_rewards"             => $row->total_rewards,
                                                        "total_kg"                  => $row->total_kg,
                                                        "total_items"               => $row->total_items,
                                                        "socity_id"                 => $row->socity_id,
                                                        "delivery_address"          => $row->delivery_address,
                                                        "location_id"               => $row->location_id,
                                                        "delivery_charge"           => $row->delivery_charge,
                                                        "new_store_id"              => $row->new_store_id,
                                                        "assign_to"                 => $row->assign_to,
                                                        "payment_method"            => $row->payment_method,
                                                        "orderdatetime"             => $row->on_date,
                                                        "transaction_id"            => $transaction_id,
                                                        "Pay"                       => $paid,
                                                        "store_address"             => $store_address,
                                                        "store_landmark"            => $store_landmark,
                                                        "store_pincode"             => $store_pincode,
                                                        "store_statename"           => $store_statename,
                                                        "store_city_name"           => $store_city_name,
                                
                                
                                                );
                        }
                        //$data['responce']   =   true;
                    }
                    else{
                            $data[]   =   '';  //array('responce'=>false, "msg" => "Not Found Order !!")
                    }

                }
                echo json_encode($data);
        }
        function order_details(){
                date_default_timezone_set('Africa/Johannesburg');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('sale_id', 'Sale ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $this->load->model("product_model");
                    $data = $this->product_model->get_sale_order_items($this->input->post("sale_id"));
                }
                echo json_encode($data);
        }
        function cancel_order(){
                date_default_timezone_set('Africa/Johannesburg');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('sale_id', 'Sale ID',  'trim|required');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $this->db->query("Update sale set status = 3 where user_id = '".$this->input->post("user_id")."' and  sale_id = '".$this->input->post("sale_id")."' ");  
                    $this->db->query("delete from mmoney where transactionid = '".$this->input->post("sale_id")."'");
                    $this->db->query("delete from mrupees where transactionid = '".$this->input->post("sale_id")."'");
                    $data["responce"] = true;
                    $data["message"] = "Your order cancel successfully";
                }
                echo json_encode($data);
        }
        
        function get_society(){
                    
                    $this->load->model("product_model");
                    $data  = $this->product_model->get_socities();
                
                echo json_encode($data);
        }
         
        function get_varients_by_id(){
                date_default_timezone_set('Africa/Johannesburg');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('ComaSepratedIdsString', 'IDS',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $this->load->model("product_model");
                    $data  = $this->product_model->get_prices_by_ids($this->input->post("ComaSepratedIdsString"));
                }
                echo json_encode($data);
        }
        
        
        function get_sliders(){
            $q = $this->db->query("Select * from slider");
            echo json_encode($q->result());
        } 
        function get_banner(){
            $q = $this->db->query("Select * from banner");
            echo json_encode($q->result());
        }
        
        function get_feature_banner(){
            $q = $this->db->query("Select * from feature_slider");
            echo json_encode($q->result());
        }
        
        
        function get_limit_settings(){
            $q = $this->db->query("Select * from settings");
            echo json_encode($q->result());
        }
         
         
          function add_address(){
                date_default_timezone_set('Africa/Johannesburg');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'Pincode',  'trim|required');
                 $this->form_validation->set_rules('pincode', 'Pincode ID', 'trim|required');
                $this->form_validation->set_rules('socity_id', 'Socity',  'trim|required');
                $this->form_validation->set_rules('house_no', 'House',  'trim|required');
               // $this->form_validation->set_rules('landmark', 'Landmark',  'trim');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $user_id = $this->input->post("user_id");
                    $pincode = $this->input->post("pincode");
                    $socity_id = $this->input->post("socity_id");
                    $house_no = $this->input->post("house_no");
                   // $landmark         = $this->input->post("landmark");
                    $receiver_name = $this->input->post("receiver_name");
                    $receiver_mobile = $this->input->post("receiver_mobile");
                    
                    $array = array(
                    "user_id" => $user_id,
                    "pincode" => $pincode,
                    "socity_id" => $socity_id,
                    "house_no" => $this->input->post("house_no"),
                   // "landmark"        => $landmark,
                    "receiver_name" => $receiver_name
                    );
                    
                    $this->db->insert("user_location",$array);
                    $insert_id = $this->db->insert_id();
                    $q = $this->db->query("Select user_location.*,
                    socity.* from user_location 
                    inner join socity on socity.socity_id = user_location.socity_id
                    where location_id = '".$insert_id."'");
                    $data["responce"] = true;
                    $data["data"] = $q->row();
                    
                }
                echo json_encode($data);
        }
        function add_address2(){
                date_default_timezone_set('Africa/Johannesburg');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'Pincode',  'trim|required');
                 $this->form_validation->set_rules('pincode', 'Pincode ID', 'trim|required');
                $this->form_validation->set_rules('socity_id', 'Socity',  'trim|required');
                $this->form_validation->set_rules('house_no', 'House',  'trim|required');
                $this->form_validation->set_rules('landmark', 'Landmark',  'trim');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $user_id = $this->input->post("user_id");
                    $pincode = $this->input->post("pincode");
                    $socity_id = $this->input->post("socity_id");
                    $house_no = $this->input->post("house_no");
                    $landmark         = $this->input->post("landmark");
                    $receiver_name = $this->input->post("receiver_name");
                    $receiver_mobile = $this->input->post("receiver_mobile");
                    
                    $array = array(
                    "user_id" => $user_id,
                    "pincode" => $pincode,
                    "socity_id" => $socity_id,
                    "house_no" => $this->input->post("house_no"),
                    "landmark"        => $landmark,
                    "receiver_name" => $receiver_name,
                    "receiver_mobile" => $receiver_mobile
                    );
                    
                    $this->db->insert("user_location",$array);
                    $insert_id = $this->db->insert_id();
                    $q = $this->db->query("Select user_location.*,
                    socity.* from user_location 
                    inner join socity on socity.socity_id = user_location.socity_id
                    where location_id = '".$insert_id."'");
                    $data["responce"] = true;
                    $data["data"] = $q->row();
                    
                }
                echo json_encode($data);
        }
        
         public function edit_address(){
                date_default_timezone_set('Africa/Johannesburg');
                $data = array(); 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
                $this->form_validation->set_rules('socity_id', 'Socity ID', 'trim|required');
                 $this->form_validation->set_rules('house_no', 'House Number', 'trim|required');
                $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'trim|required');
                $this->form_validation->set_rules('receiver_mobile', 'Receiver Mobile', 'trim|required'); 
                $this->form_validation->set_rules('location_id', 'Location ID', 'trim|required');
               // $this->form_validation->set_rules('landmark', 'Landmark',  'trim|required');

                 
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $insert_array=  array(
                                            "pincode"=>$this->input->post("pincode"),
                                            "socity_id"=>$this->input->post("socity_id"),
                                            "house_no"=>$this->input->post("house_no"),
                                            "receiver_name"=>$this->input->post("receiver_name"),
                                            "receiver_mobile"=>$this->input->post("receiver_mobile")
                                            //"landmark"        => $this->input->post("landmark")
                                            );
                     
                    $this->load->model("common_model");
                     
                    
                   $this->common_model->data_update("user_location",$insert_array,array("location_id"=>$this->input->post("location_id")));
                    
                      
                    $data["responce"] = true;
                    $data["data"] = "Your Address Update successfully";  
                  }                  
           
                     echo json_encode($data);
        }
        public function edit_address2(){
                date_default_timezone_set('Africa/Johannesburg');
                $data = array(); 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
                $this->form_validation->set_rules('socity_id', 'Socity ID', 'trim|required');
                 $this->form_validation->set_rules('house_no', 'House Number', 'trim|required');
                $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'trim|required');
                $this->form_validation->set_rules('receiver_mobile', 'Receiver Mobile', 'trim|required'); 
                $this->form_validation->set_rules('location_id', 'Location ID', 'trim|required');
                $this->form_validation->set_rules('landmark', 'Landmark',  'trim|required');

                 
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $insert_array=  array(
                                            "pincode"=>$this->input->post("pincode"),
                                            "socity_id"=>$this->input->post("socity_id"),
                                            "house_no"=>$this->input->post("house_no"),
                                            "receiver_name"=>$this->input->post("receiver_name"),
                                            "receiver_mobile"=>$this->input->post("receiver_mobile"),
                                            "landmark"        => $this->input->post("landmark")
                                            );
                     
                    $this->load->model("common_model");
                     
                    
                   $this->common_model->data_update("user_location",$insert_array,array("location_id"=>$this->input->post("location_id")));
                    
                      
                    $data["responce"] = true;
                    $data["data"] = "Your Address Update successfully";  
                  }                  
           
                     echo json_encode($data);
        }
        
        
         /* Delete Address */
     public function delete_address(){
         date_default_timezone_set('Africa/Johannesburg');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('location_id', 'Location ID', 'trim|required');
        if ($this->form_validation->run() == FALSE){
          $data["responce"] = false;
          $data["error"] = 'field is required';
        }
        else{
           $this->db->delete("user_location",array("location_id"=>$this->input->post("location_id")));
           $data["responce"] = true;
           $data["message"] = 'Your Address deleted successfully...';
        }
        echo json_encode($data);
    }
    /* End Delete  Address */
        
        
        function get_address(){
            date_default_timezone_set('Africa/Johannesburg');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User',  'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $user_id = $this->input->post("user_id");
                    
                    $q = $this->db->query("Select user_location.*,
                    socity.* from user_location 
                    inner join socity on socity.socity_id = user_location.socity_id
                    where user_id = '".$user_id."'  order by location_id DESC");
                    $data["responce"] = true;
                    $data["data"] = $q->result();
					
                }
                echo json_encode($data);
        }
         
         
          /* contact us */
 
 public function support(){
    
     $q = $this->db->query("select * from `pageapp` WHERE id =1"); 
     
      
     $data["responce"] = true;
    $data['data'] = $q->result();
    
            
       echo json_encode($data);  
 }
 
 
 /* end contact us */
 
 /* about us */
  public function aboutus(){
    
     $q = $this->db->query("select * from `pageapp` where id=2"); 
     
      
     $data["responce"] = true;     
    $data['data'] = $q->result();
    
            
       echo json_encode($data);  
 }
 /* end about us */
  /* referral */
  public function referral(){
    
     $q = $this->db->query("select * from `pageapp` where id=4"); 
     
      
     $data["responce"] = true;     
    $data['data'] = $q->result();
    
            
       echo json_encode($data);  
 }
 /* end referral */
/* about us */
  public function terms(){
    
     $q = $this->db->query("select * from `pageapp` where id=3"); 
     
      
     $data["responce"] = true;     
    $data['data'] = $q->result();
    
            
       echo json_encode($data);  
 }
 public function privacy(){
    
     $q = $this->db->query("select * from `pageapp` where id=5"); 
     
      
     $data["responce"] = true;     
    $data['data'] = $q->result();
    
            
       echo json_encode($data);  
 }
 public function payment(){
    
     $q = $this->db->query("select * from `pageapp` where id=6"); 
     
      
     $data["responce"] = true;     
    $data['data'] = $q->result();
    
            
       echo json_encode($data);  
 }
 public function return(){
    
     $q = $this->db->query("select * from `pageapp` where id=7"); 
     
      
     $data["responce"] = true;     
    $data['data'] = $q->result();
    
            
       echo json_encode($data);  
 }
 /* end about us */         
  
    public function register_fcm(){
            $data = array();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
            $this->form_validation->set_rules('token', 'Token', 'trim|required');
            $this->form_validation->set_rules('device', 'Device', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
        {
                $data["responce"] = false;
               $data["error"] = $this->form_validation->error_string();
                                
        }else
            {   
                $device = $this->input->post("device");
                $token = $this->input->post("token");
                $user_id = $this->input->post("user_id");
                
                $field = "";
                if($device=="android"){
                    $field = "user_gcm_code";
                }else if($device=="ios"){
                    $field = "user_ios_token";
                }
                if($field!=""){
                    $this->db->query("update registers set ".$field." = '".$token."' where user_id = '".$user_id."'");
                    $data["responce"] = true;    
                }else{
                    $data["responce"] = false;
                    $data["error"] = "Device type is not set";
                }
                
                
            }
            echo json_encode($data);
    }
     public function test_fcm(){
        $message["title"] = "test";
        $message["message"] = "grocery test";
        $message["image"] = "";
        $message["created_at"] = date("Y-m-d h:i:s");  
    
    $this->load->helper('gcm_helper');
    $gcm = new GCM();   
    $result = $gcm->send_notification(array("AAAAgv35W5M:APA91bE4Q6EArUAWlBiJwV4GoHwnPmzj0aLf8aUSJDjXrFLHU3B0Jh9YSSbfUCIB2d33xNSDHh7LsY3BibyNkKE3cQfW0GjLuboEjtYQME3YAtJaSucbHWAsyJdGovRhWsf6TfbQB2I-"),$message ,"android");
      // $result = $gcm->send_topics("/topics/rabbitapp",$message ,"ios"); 
    print_r($result);
    }      
     
     /* Forgot Password */
    
    
    
       public function forgot_password(){
            $data = array();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
        {
                  $data["responce"] = false;  
               $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                        
        }else
            {
                   $request = $this->db->query("Select * from registers where user_phone = '".$this->input->post("mobile")."' limit 1");
                   if($request->num_rows() > 0){
                                
                                $user = $request->row();
                                //$token = uniqid(uniqid());
                                $accesscode       =  $this->generateRandomString(6);
                                $this->db->update("registers",array("varified_token"=>$accesscode),array("user_id"=>$user->user_id)); 
                               // $this->email->from($this->config->item('default_email'), $this->config->item('email_host'));
                                
                                $mobile   = $user->user_phone;
                                $user_id  = $user->user_id;
                                $email    = $user->user_email;
                                $name     = $user->user_fullname;

                                $message          = urlencode('<#> OTP for Green Grocers Forgot Password is '.$accesscode.' and valid for next 30 minutes( Generated at '.date('d-m-Y h:i a').')  63po3H4c2lE');//63po3H4c2lE
                                $mobiles          = '91'.$mobile;
                                $sendsms          = $this->smsSend($mobiles,$message);  
                                $smsdeliverdArray = json_decode($sendsms);
                                // $subject  = 'Forgot password request';
                                // $message  =  "Hi ".$name." \n Your password forgot request is accepted plase visit following link to change your password. \n ".site_url("users/modify_password/".$token)."";

                                // $return = $this->send_email_verified_mail($email,$token,$name,$subject,$message);
                                
                               
                                if ($smsdeliverdArray){
                                                  $data["responce"] = false;  
                                                  $data["error"] = 'Warning! : Something is wrong with system to send SMS.';
    
                                }else{
                                                  $data["responce"] = true;  
                                                  $data["error"]    = 'Success! : Send OTP Your Mobile.';
                                                  $data['user_id']  =  $user_id;
    
                                }
                   }else{
                                             $data["responce"] = false;  
                                             $data["error"] = 'Warning! : No user found with this Mobile Number.';
    
                   }
                }
                echo json_encode($data);
        }


        function resetPassword(){
            $data = array();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('confirmpass', 'Confirm Password', 'trim|required');
            $this->form_validation->set_rules('user_id',  'User Id', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
              {
                     $data["responce"] = false;  
                     $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                              
              }else
                  {
                    if($this->input->post("password") != $this->input->post("confirmpass")){
                         $data["responce"] = false;  
                         $data["error"] = 'Warning! : Password And Confirm Password Not Matche.';
                    }
                    else{
                         $request = $this->db->query("Select * from registers where user_id = '".$this->input->post("user_id")."' limit 1");
                         if($request->num_rows() > 0){
                                      
                              $user = $request->row();
                              $this->db->update("registers",array("user_password"=>md5($this->input->post("password"))),array("user_id"=>$user->user_id)); 
                              $data["responce"] = true;  
                              $data["error"]    = 'Success! : Change Password.';
                              $data['user_id']  =  $this->input->post("user_id");

                                  
                         }else{
                                 $data["responce"]  = false;  
                                 $data["error"]     = 'Warning! : No user found with this User Id.';
                                 $data['user_id']   =  '';
          
                         }
                    }
                   
                }
                echo json_encode($data);          
        }
        
        
        public function send_email_verified_mail($email,$token,$name,$subject,$message){
          //$message = $this->load->view('emails/email_verify',array("name"=>$name,"active_link"=>site_url("users/verify_email?email=".$email."&token=".$token)),TRUE);
                            // echo $token; exit;

                           //  $this->load->library('email');
                           //  $this->email->from("shreeharitest@gmail.com","Grocery Store");
                           //  $list = array($email);
                           //  $this->email->to($list); 
                           //  $this->email->reply_to("shreeharitest@gmail.com","Grocery Store");
                           //  $this->email->subject($subject);
                           //  $this->email->message($message);
                           // return $this->email->send();
              
              $list                   = array($email);
              $config['protocol']     = 'smtp';
              $config['smtp_host']    = 'ssl://smtp.googlemail.com';
              $config['smtp_port']    = '465';
              $config['smtp_timeout'] = '7';
              $config['smtp_user']    = 'rajkumar.dolphintechno@gmail.com';
              $config['smtp_pass']    = '';
              $config['charset']      = 'utf-8';
              $config['newline']      = "\r\n";
              $config['mailtype']     = 'html'; // or html
              $config['validation']   = TRUE; // bool whether to validate email or not   
              $config['wordwrap']     = TRUE; 

              $this->load->library('email',$config);
              //$this->email->initialize();
              $this->email->from('rajkumar.dolphintechno@gmail.com', 'Grocery Store');
              $this->email->to($list); 
              $this->email->subject($subject);
              $this->email->message($message);  
              return $this->email->send();





    }
    /* End Forgot Password */   
        
    public function wallet(){
            $data = array(); 
            $_POST = $_REQUEST;
            if($this->input->post('user_id')==""){
                
            }
            else{
                $cr = $this->db->query("SELECT SUM(mrupee) AS wallet FROM mrupees WHERE `status`=101 AND mtype='cr' AND userid ='".$this->input->post('user_id')."'");
                error_reporting(0);
                if ($cr->num_rows() > 0)
                    {                      
                      $rowcr  = $cr->row(); 
                      $dr     = $this->db->query("SELECT SUM(mrupee) AS wallet FROM mrupees WHERE `status`=101 AND mtype='dr' AND userid ='".$this->input->post('user_id')."'");
                      $rowdr  = $dr->row(); 
                      $remaining  = $rowcr->wallet - $rowdr->wallet;
                            $data["responce"] = true;  
                            $data= array("success" => success, "wallet"=>$remaining) ;
                               
                    }
                    else{
                        $data= array("success" => unsucess, "wallet"=>0 ) ;
                    }
            }
            echo json_encode($data);
        }
        
    public function rewards(){
            $data = array(); 
            $_GET = $_REQUEST;
            if($this->input->post('user_id')==""){
                $data= array("success" => unsucess, "total_rewards"=> 0 ) ;
            }
            else{
                $cr = $this->db->query("SELECT SUM(mmoney) AS rewards FROM mmoney WHERE `status`=101 AND mtype='cr' AND userid ='".$this->input->post('user_id')."'");
                error_reporting(0);
                if ($cr->num_rows() > 0)
                    {                      
                      $rowcr  = $cr->row(); 
                      $dr     = $this->db->query("SELECT SUM(mmoney) AS rewards FROM mmoney WHERE `status`=101 AND mtype='dr' AND userid ='".$this->input->post('user_id')."'");
                      $rowdr  = $dr->row(); 
                      $remaining  = $rowcr->rewards - $rowdr->rewards;
                            $data["responce"] = true;  
                            $data= array("success" => success, "total_rewards"=>$remaining) ;
                               
                    }
                    else{
                        $data= array("success" => hastalavista, "total_rewards"=> 0 ) ;
                    }
            }
            echo json_encode($data);
        }
        
    public function shift(){
            $data = array(); 
            $_POST = $_REQUEST;
            if($this->input->post('user_id')==""){
                $data= array("success" => unsucess, "total_rewards"=> 0 ) ;
            }
            else{
                error_reporting(0);
                $amount=$this->input->post('amount');
                $rewards=$this->input->post('rewards');
                //$user_id=$this->input->post('user_id');
                //$final_amount=$amount+$rewards;
                //$reward_value = $rewards*.50; 
                $final_rewards= 0;
                            
                            
                $select= $this->db->query("SELECT * from rewards where id=1");
                if ($select->num_rows() > 0)
                    {
                       $row = $select->row_array(); 
                       $point= $row['point'];
                    }
                    
                $reward_value = $point+$rewards;
                $final_amount=$amount+$reward_value;
                $data["wallet_amount"]= [array("final_amount"=>$final_amount, "final_rewards"=>0,"amount"=>$amount,"rewards"=>$rewards,"pont"=>$point)];
                $this->db->query("delete from delivered_order where user_id = '".$this->input->post('user_id')."'");
                $this->db->query("UPDATE `registers` SET wallet='".$final_amount."' where(user_id='".$this->input->post('user_id')."' )"); 
            }
            echo json_encode($data);
        }
        
     public function wallet_on_checkout(){
		 
            $data = array(); 
            $_POST = $_REQUEST;
             $user_id                  =   $this->input->post('user_id');
             $mruppeyCr = $this->db->query("SELECT cr_tbl.userid, SUM(cr_tbl.mrupee) AS creditbal
                                        FROM  mrupees AS cr_tbl  WHERE cr_tbl.mtype='cr' AND cr_tbl.status='101' AND cr_tbl.userid='$user_id'");
              $wallet_amount          = 0;
              $creditbal              = 0; 
              $deditbal               = 0;
              if($mruppeyCr->num_rows() > 0){
                  $creditbal          =   $mruppeyCr->row()->creditbal;
              }
             $mruppeyDr = $this->db->query("SELECT dr_tbl.userid, SUM(dr_tbl.mrupee) AS deditbal 
                                            FROM  mrupees AS dr_tbl  WHERE dr_tbl.mtype='dr' AND dr_tbl.status='101' 
                                            AND dr_tbl.userid='$user_id'");
              if($mruppeyDr->num_rows() > 0){
                  $deditbal          =   $mruppeyDr->row()->deditbal;
              }

              if(!empty($creditbal)){
                 $wallet_amount          =   $creditbal - $deditbal;
              }

            if($wallet_amount >= $this->input->post('total_amount')){
                $amount=$this->input->post('total_amount');
                
                $final_amount=$wallet_amount-$amount;
                $balance=0;
                
                $data["final_amount"]= [array("Mrupee_amount"=>$final_amount, "total"=>$balance,"used_Mrupee" => $amount)];
            }
            elseif($wallet_amount <= $this->input->post('total_amount')  && $wallet_amount >= 0){
                $amount=$this->input->post('total_amount');
                
                $final_amount=0;
                $balance=$amount-$wallet_amount;
                
                $data["final_amount"]= [array("Mrupee_amount"=>$final_amount, "total"=>$balance, "used_Mrupee" => $wallet_amount)];
            }
            elseif($wallet_amount < 0){
                  $final_amount   = 0;
                  $walletuse      = 0;
                  $balance        = $amount;
                  $data["final_amount"]= [array("Mrupee_amount"=>$final_amount, "total"=>$balance, "used_Mrupee" => $walletuse)];
            }
		 	$data['max_delivery_amount'] = $this->config->item('delivery_charg');
            echo json_encode($data);
        }
    
    public function wallet_on_checkout_Mmoney(){
            $data = array(); 
            $_POST = $_REQUEST;
            $final_amount   = 0;
            $walletuse      = 0;
            $balance        =  $this->input->post('total_amount');
            $q = $this->db->query("SELECT orderMmonypercentageuse,rewardpointuse FROM rewards LIMIT 1");
            if($q->num_rows() > 0 ){
                $orderMmonypercentageuse  =   $q->row()->orderMmonypercentageuse;
                $rewardpointuse           =   $q->row()->rewardpointuse;
                $user_id                  =   $this->input->post('user_id');
                $interval                 = 'INTERVAL '.$rewardpointuse.' DAY';
             $mMonyCr = $this->db->query("SELECT cr_tbl.userid, SUM(cr_tbl.mmoney) AS creditbal
                                            FROM  mmoney AS cr_tbl  WHERE cr_tbl.mtype='cr' AND cr_tbl.status='101' 
                                            AND cr_tbl.depositdatetime BETWEEN DATE_SUB(NOW(), $interval) AND NOW() AND
                                            cr_tbl.userid='$user_id'");
              $wallet_amount          = 0;
              $creditbal              = 0; 
              $deditbal               = 0;
              if($mMonyCr->num_rows() > 0){
                  $creditbal          =   $mMonyCr->row()->creditbal;
              }
             $mMonyDr = $this->db->query("SELECT  dr_tbl.userid,SUM(dr_tbl.mmoney) AS deditbal 
                                            FROM mmoney AS dr_tbl WHERE dr_tbl.mtype='dr' AND dr_tbl.status='101' 
                                            AND dr_tbl.depositdatetime BETWEEN DATE_SUB(NOW(), $interval) AND NOW()  AND 
                                            dr_tbl.userid='$user_id'");
              if($mMonyDr->num_rows() > 0){
                  $deditbal          =   $mMonyDr->row()->deditbal;
              }

              if(!empty($creditbal)){
                 $wallet_amount          =   $creditbal - $deditbal;
              }
               
                $amount                   =   $wallet_amount;
                $totlaamount              =    $this->input->post('total_amount');
                $amountpercent            = floor(($orderMmonypercentageuse*$amount)/100);

                if($amountpercent <= $wallet_amount){
                  $final_amount   = $wallet_amount-$amountpercent;
                  $balance        = $totlaamount-$amountpercent;
                  $walletuse      = $amountpercent;
                }
                elseif($amountpercent >= $wallet_amount && $wallet_amount >= 0){
                  $final_amount   = 0;
                  $balance        = $totlaamount-$wallet_amount;
                  $walletuse      = $wallet_amount;
                }
                elseif($wallet_amount < 0){
                  $final_amount   = 0;
                  $walletuse      = 0;
                  $balance        = $totlaamount;
                }
            }
            $data["final_amount"]= [array("Mmoney_amount"=>$final_amount, "total"=>$balance, "used_Mmoney" => $walletuse)];
			$data['max_delivery_amount'] = $this->config->item('delivery_charg');
			$data["cart_text"] 		 = "Delivery Charges on Order Value Up to R ".($this->config->item('delivery_charg')-1)."/-. Please increase cart value up  to R ".$this->config->item('delivery_charg')."/- to avoid Delivery Charges.";
            echo json_encode($data);
        }    

    public function recharge_wallet(){
        $data = array(); 
        $_POST = $_REQUEST;
        $request_amount   = $this->input->post('wallet_amount');
        $transactionid    = $this->input->post('transactionid');
        $userid           = $this->input->post('userid');
        $remark           = $this->input->post('remark');
        $q = $this->db->query("SELECT user_id FROM registers WHERE (user_id='".$this->input->post('userid')."' )");
                error_reporting(0);
                if ($q->num_rows() > 0)
                    {
                      $this->db->query("INSERT INTO  `mrupees` (mrupee, mtype,  transactionid,  userid,  depositdatetime,  remark) VALUE('$request_amount','cr','$transactionid','$userid',NOW(),'$remark')"); 
                      
                      $data= array("success" => success, "wallet_amount"=>"$new_amount") ;
                    }
            echo json_encode($data);
    }

  
  public function deelOfDay()
  {
    $data = array();
    $_POST = $_REQUEST;
    error_reporting(0);
    $q = $this->db->get('deelofday');
    $data[responce]="true";
    $data[Deal_of_the_day] = $q->result();
    echo json_encode($data);
  }
  
  public function top_selling_product()
  {
    $data = array();
    $_POST = $_REQUEST;
    error_reporting(0);
    $q = $this->db->query("select p.*,dp.start_date,dp.start_time,dp.end_time,dp.deal_price,c.title,count(si.product_id) as top,si.product_id from products p INNER join sale_items si on p.product_id=si.product_id INNER join categories c ON c.id=p.category_id left join deal_product dp on dp.product_id=si.product_id GROUP BY si.product_id order by top DESC LIMIT 4");
    $data[responce]="true";
    //print_r($q->result());exit();
    //$data[top_selling_product] = $q->result();
    foreach($q->result() as $product)
   {
       $present = date('m/d/Y h:i:s a', time());
                      $date1 = $product->start_date." ".$product->start_time;
                      $date2 = $product->start_date." ".$product->end_time;

                     if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                     {
                        
                       if(empty($product->deal_price))   ///Runing
                       {
                           $price= $product->price;
                       }else{
                             $price= $product->deal_price;
                       }
                    
                     }else{
                      $price= $product->price;//expired
                     } 
      
       $data[top_selling_product][] = array(
        'product_id' => $product->product_id,
            'product_name'=> $product->product_name,
            'category_id' => $product->category_id,
            'product_description'=>$product->product_description,
            'deal_price'=>'',
            'start_date'=>'',
            'start_time'=>'',
            'end_date'=>'',
            'end_time'=>'',
            'price' =>$price,
            'product_image'=>$product->product_image,
            'status' => '',
            'in_stock' =>$product->in_stock,
            'unit_value'=>$product->unit_value,
            'unit'=>$product->unit,
            'increament'=>$product->increament,
            'rewards'=>$product->rewards,
            'stock' => '',
            'title'=>$product->title
           
        );
   }
    
    
    
    echo json_encode($data);
  }
  
  public function get_all_top_selling_product()
  {
       $data = array();
    $_POST = $_REQUEST;
    error_reporting(0);
    if($this->input->post('top_selling_product')){
    $q = $this->db->query("select p.*,dp.start_date,dp.start_time,dp.end_time,dp.deal_price,c.title,count(si.product_id) as top,si.product_id from products p INNER join sale_items si on p.product_id=si.product_id INNER join categories c ON c.id=p.category_id left join deal_product dp on dp.product_id=si.product_id GROUP BY si.product_id order by top DESC LIMIT 8");
    
    $data[responce]="true";
   foreach($q->result() as $product)
   {
       $present = date('m/d/Y h:i:s a', time());
                      $date1 = $product->start_date." ".$product->start_time;
                      $date2 = $product->end_date." ".$product->end_time;

                     if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                     {
                        
                       if(empty($product->deal_price))   ///Runing
                       {
                           $price= $product->price;
                       }else{
                             $price= $product->deal_price;
                       }
                    
                     }else{
                      $price= $product->price;//expired
                     } 
       
       $data[top_selling_product][] = array(
        'product_id' => $product->product_id,
            'product_name'=> $product->product_name,
            'category_id' => $product->category_id,
            'product_description'=>$product->product_description,
            'deal_price'=>'',
            'start_date'=>'',
            'start_time'=>'',
            'end_date'=>'',
            'end_time'=>'',
            'price' =>$price,
            'product_image'=>$product->product_image,
            'status' => '',
            'in_stock' =>$product->in_stock,
            'unit_value'=>$product->unit_value,
            'unit'=>$product->unit,
            'increament'=>$product->increament,
            'rewards'=>$product->rewards,
            'stock' => '',
            'title'=>$product->title
           
        );
   }
    }
    echo json_encode($data);
  }
public function dobChange($dob,$seprator,$newseprator){
      $dobArray  = explode($seprator, $dob);
      $Month     = $dobArray[1];
      $Day     = $dobArray[0];
      $Year      = $dobArray[2];
      $pass      = $Year.''.$newseprator.''.$Month.''.$newseprator.''.$Day;
    
    return $pass;
    }
                                                
  public function deal_product(){
    $data = array();
    $_POST = $_REQUEST;
    error_reporting(0);
    $q = $this->db->query("SELECT dp.*,p.*,c.title from deal_product dp inner JOIN products p on dp.product_name = p.product_name INNER JOIN categories c on c.id=p.category_id limit 12");
   
    $data['responce']="true";
    // $data['Deal_of_the_day']=array();
    $productArray     =   $q->result();
    //print_r($productArray); exit;
  $data['Deal_of_the_day']      =   array();
   foreach ($productArray as $product) {
       $present = date('Y-m-d H:i', time());
          $date1Convert  = $this->dobChange($product->start_date,'/','-');
          $date2Convert  = $this->dobChange($product->end_date,'/','-');
          $date1 = $date1Convert." ".$product->start_time;
          $date2 = $date2Convert." ".$product->end_time;
          $pricedifrance      =   ( $product->price - $product->deal_price).' Off';
         if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
         {
           $status = 1;//running 
         }else if(strtotime($date1) > strtotime($present)){
          $status = 2;//is going to
         }else{
          $status = 0;//expired
         } 
     if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
         {
              $data['Deal_of_the_day'][] = array(
                    'product_id' => $product->product_id,
                    'product_name'=> $product->product_name,
                    'product_description'=>$product->product_description,
                    'deal_price'=>$product->price,
                    'start_date'=>$product->start_date,
                    'start_time'=>$product->start_time,
                    'end_date'=>$product->end_date,
                    'end_time'=>$product->end_time,
                    'price' =>$product->deal_price,
                    'product_image'=>$product->product_image,
                    'status' => $status,
                    'in_stock' =>$product->in_stock,
                    'unit_value'=>$product->unit_value,
                    'unit'=>$product->unit,
                    'increament'=>$product->increament,
                    'rewards'=>$product->rewards,
                    'title'=>$product->title,
                    'pricedifrance'=>$pricedifrance
                );
         }
    }
  echo json_encode($data);

  }
   
  public function get_all_deal_product()
  {

    $data = array();
    $_POST = $_REQUEST;
    error_reporting(0);
   
    if($this->input->post('dealproduct'))
    {
      $q = $this->db->query("SELECT dp.*,p.*,c.title from deal_product dp inner JOIN products p on dp.product_name = p.product_name INNER JOIN categories c on c.id=p.category_id");
   }
    $data['responce']="true";
   //$data['Deal_of_the_day'][]=array();
    foreach ($q->result() as $product) {
        $present        = date('Y-m-d H:i', time());
        $date1Convert   = $this->dobChange($product->start_date,'/','-');
        $date2Convert   = $this->dobChange($product->end_date,'/','-');
        $date1          = $date1Convert." ".$product->start_time;
        $date2          = $date2Convert." ".$product->end_time;
                     if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                     {
                        
                       if(empty($product->deal_price))   ///Runing
                       {
                           $price= $product->price;
                       }else{
                             $price= $product->deal_price;
                       }
                    
                     }else{
                      $price= $product->price;//expired
                     } 
        
      $data['Deal_of_the_day'][] = array(
            'product_id' => $product->product_id,
            'product_name'=> $product->product_name,
            'category_id' => '0',
            'product_description'=>$product->product_description,
            'deal_price'=>$product->deal_price,
            'start_date'=>$product->start_date,
            'start_time'=>$product->start_time,
            'end_date'=>$product->end_date,
            'end_time'=>$product->end_time,
            'price' =>  $price,
            'product_image'=>$product->product_image,
            'status' => '',
            'in_stock' =>$product->in_stock,
            'unit_value'=>$product->unit_value,
            'unit'=>$product->unit,
            'increament'=>$product->increament,
            'rewards'=>$product->rewards,
            'stock' =>'0',
            'title'=>$product->title
           
        );
    }
  echo json_encode($data);

  }
  public function icon(){
            $parent = 0 ;
            if($this->input->post("parent")){
                $parent    = $this->input->post("parent");
            }
        $categories = $this->get_header_categories_short($parent,0,$this) ;
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
        
    }

    
    public function get_header_categories_short($parent,$level,$th){
            $q = $this->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `header_categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `header_categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                         LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `header_products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                         WHERE a.`parent`=" . $parent);
                        
                        $return_array = array();
                        
                        foreach($q->result() as $row){
                                    if ($row->Count > 0) {
                                        $sub_cat =  $this->get_header_categories_short($row->id, $level + 1,$th);
                                        $row->sub_cat = $sub_cat;       
                                    } elseif ($row->Count==0) {
                                    
                                    }
                            $return_array[] = $row;
                        }
        return $return_array;
    }
    
    function get_header_products(){
                 $this->load->model("product_model");
                $cat_id = "";
                if($this->input->post("cat_id")){
                    $cat_id = $this->input->post("cat_id");
                }
              $search= $this->input->post("search");
                
                $data["responce"] = true;  
   $datas = $this->product_model->get_header_products(false,$cat_id,$search,$this->input->post("page"));

foreach ($datas as $product) {
 $data['data'][] =  array(
            'product_id' => $product->product_id,
                  'product_name'=> $product->product_name,
                  'category_id'=> $product->category_id,
                  'product_description'=>$product->product_description,
                  'deal_price'=>"",
                  'start_date'=>"",
                  'start_time'=>"",
                  'end_date'=>"",
                  'end_time'=>"",
                  'price' =>$product->price,
                  'product_image'=>$product->product_image,
                  'status' => '0',
                  'in_stock' =>$product->in_stock,
                  'unit_value'=>$product->unit_value,
                  'unit'=>$product->unit,
                  'increament'=>$product->increament,
                  'rewards'=>$product->rewards,
                  'stock'=>$product->stock,
                  'title'=>$product->title
           
        );
}
                echo json_encode($data);
        }
        
        public function coupons(){
    
            $q = $this->db->query("select * from `coupons`"); 
            $data["responce"] = true;     
            $data['data'] = $q->result();
            echo json_encode($data);  
         }
         
 public function get_coupons(){
        $this->load->model("setting_model");
		$userid					=	$this->input->post("user_id");
		$coupon_code 			=	$this->input->post("coupon_code");
    	
			
        if(array_key_exists("_success", $coupon_data)){
			$is_coupon_apply = true;
            if($is_coupon_apply==true){
				$coupon_data        =   $coupon_data['_success'];
				$coupon_id          =   $coupon_data['coupon_uni_id'] ;
				$discount_type      =   $coupon_data['discount_type'];
				$discount_value     =   $coupon_data['discount_value'];
				$minimum_cart_amt   =   $coupon_data['cart_value'];
				$max_discount_limit =   $coupon_data['uses_restriction'];
				$discount_amount    =  0;
                if($this->input->post("payable_amount") >= $minimum_cart_amt){
  					$payable_amount 	=	$this->input->post("payable_amount");
                    $coupon_amount 		=	$discount_value;
                    $new_amount 		  =	$payable_amount-$coupon_amount;
  							
					$coupon_apply_data      =   array(
						'coupon_id'           => $coupon_id,
						'user_id'             => $userid,
						'coupon_apply_date'   => date('Y-m-d'),
						'coupon_apply_status' => 1, // Coupon Activated
						'coupon_discount_amt' => $coupon_amount
					);
                    $result =   $this->db->insert('tbl_coupon_apply', $coupon_apply_data);
      					$coupon_apply_id   =   $this->db->insert_id();
						if ($result > 0){
							$remainingAmount        = ($payable_amount - $coupon_amount);
							$data["responce"]       = true;
							$data["msg"]            = "Coupon code apply successfully ";
							$data["Total_amount"]   = $remainingAmount;
							$data["coupon_value"]   = $discount_amount;
							echo json_encode($data);
						}else{
							$data["responce"] = false;
							$data["msg"] = "This coupon is Expired";
							$data["Total_amount"] = $this->input->post("payable_amount");
							$data["coupon_value"] = 0;
							echo json_encode($data);
						}
                             
                }
                else{
                    $data["responce"] = false;
                    $data["msg"] = "Your Cart Amount is not Enough For This Coupon ";
                    $data["Total_amount"] = $this->input->post("payable_amount");
                    $data["coupon_value"] = 0;
                }
            }
            else{
                $data["responce"] = false;
                $data["msg"] = "Coupon not Applicable";
                $data["Total_amount"] = $this->input->post("payable_amount");
                $data["coupon_value"] = 0;
                echo json_encode($data);
            }
				
            
        }
        else{
            $data["responce"] = false;
            $data["msg"] = "Invalid Coupon";
            $data["Total_amount"] = $this->input->post("payable_amount");
            $data["coupon_value"] = 0;
        }
        
        echo json_encode($data);
    }
         
         public function get_sub_cat(){
            $parent = 0 ;
            if($this->input->post("sub_cat")!=0){
                $q = $this->db->query("SELECT * FROM `categories` where id='".$this->input->post("sub_cat")."'");
                    $data["responce"] = true;
                     $data["subcat"] = $q->result();
                     echo json_encode($data);
            }
            else{
                $data["responce"] = false;
                $data["subcat"]="";
                echo json_encode($data);
            }
        
        
        }
        
        public function delivery_boy(){
    
            $q = $this->db->query("select id,user_name from `delivery_boy` where user_status=1");
            $data['delivery_boy'] = $q->result();
            
            echo json_encode($data); 
         }
         public function delivery_boy_fcm(){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_fcm', 'Fcm Tocken', 'trim|required');  
            $this->form_validation->set_rules('user_id', 'userid', 'trim|required');  
              if (!$this->input->post('user_password')){
                    $data["responce"] = false;  
                    $data["error"] =  strip_tags($this->form_validation->error_string());
                }
            else{
                  $q = $this->db->query("update delivery_boy set user_fcm ='".$this->input->post('user_fcm')."' where id='".$this->input->post('user_id')."' ");
                   $data["responce"] = true;     
                }       
            echo json_encode($data); 
         }

         public function delivery_boy_login(){
             error_reporting(0);
            $data = array();
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');  
            //$this->form_validation->set_rules('username', 'Mobile Number', 'trim|required');  
            
                if (!$this->input->post('user_password')) 
                {
                    $data["responce"] = false;  
                    $data["error"] =  strip_tags($this->form_validation->error_string());
                    
                }else
                {
                   //users.user_email='".$this->input->post('user_email')."' or
                    $q = $this->db->query("Select * from delivery_boy where user_password='".$this->input->post('user_password')."' ");
                  //  $q = $this->db->query("Select * from delivery_boy where user_password='".$this->input->post('user_password')."' AND user_phone='".$this->input->post('username')."' ");
                    
                    if ($q->result() > 0)
                    {
                        $row = $q->result(); 
                        $access=$row->user_status;
                        if($access=='0')
                        {
                            $data["responce"] = false;  
                            $data["data"] = 'Your account currently inactive.Please Contact Admin';
                            
                        }
                       
                        else
                        {
                            //$error_reporting(0);
                            $data["responce"] = true;  
                            $q = $this->db->query("Select id,user_name from delivery_boy where user_password='".$this->input->post('user_password')."'");
                            $product=$q->result();
                            $data['product']= $product;
                               
                        }
                    }
                    else
                    {
                              $data["responce"] = false;  
                              $data["data"] = 'Invalide Username or Passwords';
                    }
                   
                    
                }
           echo json_encode($data);
            
        }
        
        
        public function add_purchase(){
    if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
                $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
                $this->form_validation->set_rules('unit', 'Unit', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "product_id"=>$this->input->post("product_id"),
                    "qty"=>$this->input->post("qty"),
                    "price"=>$this->input->post("price"),
                    "unit"=>$this->input->post("unit"),
                    "store_id_login"=>$this->input->post("store_id_login")
                    );
                    $this->common_model->data_insert("purchase",$array);
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/add_purchase");
                }
                
                $this->load->model("product_model");
                $data["purchases"]  = $this->product_model->get_purchase_list();
                $data["products"]  = $this->product_model->get_products();
                $this->load->view("admin/product/purchase",$data);  
                
            }
        }
    
}

        public function stock() 
        {
                 $this->load->model("product_model");
                $cat_id = "";
                if($this->input->post("cat_id")){
                    $cat_id = $this->input->post("cat_id");
                }
              $search= $this->input->post("search");
                
                $datas = $this->product_model->get_products(false,$cat_id,$search,$this->input->post("page"));
                //print_r( $datas);exit();
                foreach ($datas as  $product) {
                    $present = date('m/d/Y h:i:s a', time());
                      $date1 = $product->start_date." ".$product->start_time;
                      $date2 = $product->end_date." ".$product->end_time;

                     if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                     {
                        
                       if(empty($product->deal_price))   ///Runing
                       {
                           $price= $product->price;
                       }else{
                             $price= $product->deal_price;
                       }
                    
                     }else{
                      $price= $product->price;//expired
                     } 
                  $q   = $this->db->query("SELECT qty,unit FROM `purchase` where product_id='".$product->product_id."'");          
                  $qty = $q->result();
                  $data['products'][] = array(
                  'product_id' => $product->product_id,
                  'product_name'=> $product->product_name,
                  'Stock'=> $qty
                  
                 );
                }
                
                echo json_encode($data);
        }
        
        public function stock_insert()
        {
             $this->load->library('form_validation');
             
                $this->input->post('product_id');
                $this->input->post('qty');
                $this->input->post('unit');
                if (!$this->input->post('product_id'))
                {
                         $data["data"] = 'Please select the product';
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "product_id"=>$this->input->post("product_id"),
                    "qty"=>$this->input->post("qty"),
                    "price"=>$this->input->post("price"),
                    "unit"=>$this->input->post("unit"),
                    "store_id_login"=>$this->input->post("store_id_login")
                    );
                    $this->common_model->data_insert("purchase",$array);
                    
                        $data['product'][] = array("msg"=>'Your Stock is Updated');  
                        
                }
                echo json_encode($data);
                $this->load->model("product_model");
                $data["purchases"]  = $this->product_model->get_purchase_list();
                $data["products"]  = $this->product_model->get_products();
        }
        
        public function assign()
        {
            $order=$this->input->post("order_id");
            $order=$this->input->post("d_boy");
            $this->load->model("common_model");
            $this->common_model->data_update("sale",$update_array,array("sale_id"=>$order));
        }
        
        public function delivery_boy_order()
        {
            $delivery_boy_id=$this->input->post("d_id");
            $date = date("d-m-Y", strtotime('-3 day'));
            $this->load->model("product_model");
            $data = $this->product_model->delivery_boy_order($delivery_boy_id);
            
            $this->db->query("DELETE FROM signature WHERE `date` < '.$date.'");
            //$data['assign_orders'] = $q->result();
            echo json_encode($data);
        }
        
        public function assign_order()
        {
            $order_id = $this->input->post("order_id");
            $boy_name = $this->input->post("boy_name");
                    
            $update_array = array("assign_to"=>$boy_name);
                       
            $this->load->model("common_model");
            //$q= $this->common_model->data_update("sale",$update_array,array("sale_id"=>$order_id));
            $hit=$this->db->query("UPDATE sale SET `assign_to`='".$boy_name."' where `sale_id`='".$order_id."'" );
            if($hit){
                $data['assign'][]=array("msg"=>"Assign Successfully");
            }
            else{
                $data['assign'][]=array("msg"=>"Assign Not Successfully");
            }
            echo json_encode($data);
        }
        
        public function mark_delivered()
        {   
            $this->load->library('form_validation');
            $signature = $this->input->post("signature");
            
                if (empty($_FILES['signature']['name']))
                {
                    $this->form_validation->set_rules('signature', 'signature', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
            {
                $data["error"] = $data["error"] = array("error"=>"not found");
            }
            else
            {
                    $add = array(
                                    "order_id"=>$this->input->post("id")
                                    );
                    
                        if($_FILES["signature"]["size"] > 0){
                            $config['upload_path']          = './uploads/signature/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('signature'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["signature"]=$img_data['file_name'];
                            }
                            
                       }
                       
                    $q =$this->db->insert("signature",$add);
                    if($q){
                        $data=array("msg"=>"Upload Successfull");
                    }
                    else{
                        $data=array("msg"=>"Upload Not Successfull");
                    }
                }
            
                echo json_encode($data);
                
        }
        
        public function mark_delivered2(){
            date_default_timezone_set('Africa/Johannesburg');
            if (($_FILES["signature"]["type"] == "image/gif")
            || ($_FILES["signature"]["type"] == "image/jpeg")
            || ($_FILES["signature"]["type"] == "image/jpg")
            || ($_FILES["signature"]["type"] == "image/jpeg")
            || ($_FILES["signature"]["type"] == "image/png")
            || ($_FILES["signature"]["type"] == "image/png")) {
        
              
                //Move the file to the uploads folder
                move_uploaded_file($_FILES["signature"]["tmp_name"], "./uploads/signature/" . $_FILES["signature"]["name"]);
        
                //Get the File Location
                $filelocation = './uploads/signature/'.$_FILES["signature"]["name"];
        
                //Get the File Size
                $order_id=$this->input->post("id");
                $datecr  = date('Y-m-d H:i:s');
                
                $q =$this->db->query("INSERT INTO signature (order_id, signature,date) VALUES ('$order_id', '$filelocation','$datecr')");
                
                //$this->db->insert("signature",$add);
                    if($q){
                        $data=array("success"=>"1", "msg"=>"Upload Successfull");
                        $q =$this->db->query("SELECT user_id FROM sale WHERE sale_id='".$order_id."'");
                        if($q->num_rows()<=0){
                            $row  = $q->row();
                            $loginuserid  = $row->user_id;
                            $t =$this->db->query("SELECT referralid,wallet FROM registers WHERE user_id='".$user_id."'");
                            if($t->num_rows()>0){
                                $rows           =   $t->row();
                                $referralid     =   $rows->referralid;
                                $referralwallet =   $rows->wallet;
                                $select= $this->db->query("SELECT * from rewards where id=1");
                                if ($select->num_rows() > 0){
                                   $rowt = $select->row_array(); 
                                   $referralrupUse  = $rowt['referralrupUse'];
                                   $referralrupEarn = $rowt['referralrupEarn'];
                                   $referralwallet = $referralwallet+$referralrup;
                                      $this->db->query("INSERT INTO mmoney (mmoney, mtype, transactionid, userid, depositdatetime, remark,mstatus) VALUES('$referralrupEarn', 'cr', '$order_id', '$referralid', NOW(), 'Referral First Order Delivered','2')");
                                      $this->db->query("INSERT INTO mmoney (mmoney, mtype, transactionid, userid, depositdatetime, remark,mstatus) VALUES('$referralrupUse', 'cr', '$order_id', '$loginuserid', NOW(), 'Referral First Order Delivered','2')");
                                      
                                  }
                              }
                        }

                        $this->db->query("UPDATE `sale` SET `status`=4 WHERE `sale_id`='".$order_id."'");
                        $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid,amount,mmoney,mrupee,total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method,delivereddatetime,transaction_id)
SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid,amount,mmoney,mrupee,total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method, NOW(),transaction_id FROM sale
where sale_id = '".$order_id."'");

                      $moneyStatusQuery   = $this->db->query("SELECT indexId FROM mmoney WHERE `transactionid`='".$order_id."'");
                      if($moneyStatusQuery->num_rows() > 0){
                          $this->db->query("UPDATE `mmoney` SET `status`=101 WHERE `transactionid`='".$order_id."'"); 
                      }
                      $mrupeesStatusQuery   = $this->db->query("SELECT indexId FROM mrupees WHERE `transactionid`='".$order_id."'");
                      if($mrupeesStatusQuery->num_rows() > 0){
                          $this->db->query("UPDATE `mrupees` SET `status`=101 WHERE `transactionid`='".$order_id."'");
                      }

                    }
                    else{
                        $data=array("success"=>"0", "msg"=>"Upload Not Successfull");
                    }
            }
            else
            {
                $data=array("success"=>"0", "msg"=>"Image Type Not Right");
            }
            echo json_encode($data);
        }


    public function showMrupeeStatement(){
        $data        = array("success" => faliur, "statement"=>""); 
        $_POST       = $_REQUEST;
        $startdate   = '';
        $enddate     = '';
        $userid      = $this->input->post('userid');
        $pageno      = $this->input->post('pageno'); 
        $low         = 0;
        $high        = 12; 
        if(!empty($pageno)){
          $low  = $pageno*$high;
        }
        $q = $this->db->query("SELECT user_id FROM registers WHERE (user_id='".$this->input->post('userid')."' )");
                error_reporting(0);
                if ($q->num_rows() > 0)
                    {
                      $query   = $this->db->query("SELECT * FROM mrupees WHERE `status`=101 AND userid='".$this->input->post('userid')."' ORDER BY depositdatetime DESC LIMIT ".$low.", ".$high."  "); 
                        if($query->num_rows() > 0){
                            $Sql                =  $query->result();
                            $data['statement']  =  $Sql;
                            $data['success']    = "success";

                        }
                    }
            echo json_encode($data);
    }

    public function showMmoneyStatement(){
        $data        = array("success" => false, "statement"=>"", "amount"=>""); 
        $_POST       = $_REQUEST;
        $startdate   = '';
        $enddate     = '';
        $userid      = $this->input->post('userid');
        $pageno      = $this->input->post('pageno'); 
        $low         = 0;
        $high        = 12; 
        if(!empty($pageno)){
          $low  = $pageno*$high;
        }
        $q = $this->db->query("SELECT user_id FROM registers WHERE (user_id='".$this->input->post('userid')."' )");
                error_reporting(0);
                if ($q->num_rows() > 0)
                    {
                        $interval       =   '';
                        $wallet_amount  =   0;
                        $q = $this->db->query("SELECT orderMmonypercentageuse,rewardpointuse FROM rewards LIMIT 1");
                            if($q->num_rows() > 0 ){
                                $orderMmonypercentageuse  =   $q->row()->orderMmonypercentageuse;
                                $rewardpointuse           =   $q->row()->rewardpointuse;
                                $user_id                  =   $this->input->post('user_id');
                                $interval                 = 'INTERVAL '.$rewardpointuse.' DAY';
                            }
                             $mMonyCr = $this->db->query("SELECT cr_tbl.userid, SUM(cr_tbl.mmoney) AS creditbal
                                                            FROM  mmoney AS cr_tbl  WHERE cr_tbl.mtype='cr' AND cr_tbl.status='101' 
                                                            AND cr_tbl.depositdatetime BETWEEN DATE_SUB(NOW(), $interval) AND NOW() AND
                                                            cr_tbl.userid='$userid'");
                              $wallet_amount          = 0;
                              $creditbal              = 0; 
                              $deditbal               = 0;
                              if($mMonyCr->num_rows() > 0){
                                  $creditbal          =   $mMonyCr->row()->creditbal;
                              }
                             $mMonyDr = $this->db->query("SELECT  dr_tbl.userid,SUM(dr_tbl.mmoney) AS deditbal 
                                                            FROM mmoney AS dr_tbl WHERE dr_tbl.mtype='dr' AND dr_tbl.status='101' 
                                                            AND dr_tbl.depositdatetime BETWEEN DATE_SUB(NOW(), $interval) AND NOW()  AND 
                                                            dr_tbl.userid='$userid'");
                              if($mMonyDr->num_rows() > 0){
                                  $deditbal          =   $mMonyDr->row()->deditbal;
                              }
                
                              if(!empty($creditbal)){
                                 $wallet_amount          =   $creditbal - $deditbal;
                              }
                              
                       $data['amount']      =   $wallet_amount;       
                      $query   = $this->db->query("SELECT * FROM mmoney WHERE `status`=101 AND userid='".$this->input->post('userid')."' ORDER BY depositdatetime DESC LIMIT ".$low.", ".$high."  "); 
                        if($query->num_rows() > 0){
                            $Sql                =  $query->result();
                            foreach ($Sql as $statement) {
                                if($statement->mmoney > 0){
                                     $data['statement'][] =  array(
                                            "indexId"=> $statement->indexId,
                                "mmoney"=> $statement->mmoney,
                                "mtype"=> $statement->mtype,
                                "transactionid"=> $statement->transactionid,
                                "userid"=> $statement->userid,
                                "depositdatetime"=> date('d M Y',strtotime($statement->depositdatetime)),
                                "remark"=> $statement->remark,
                                "status"=> $statement->status,
                                "mstatus"=> $statement->mstatus
                                           
                                        );
                                }
                                
                        }
                            
                            $data['success']    = "true";

                        }
                    }
            echo json_encode($data);
    }
    public function storelist(){
      $q = $this->db->query("SELECT users.user_id, users.user_name, users.user_email, users.user_phone, users.user_fullname, 
                            users.user_image, users.user_address, users.user_landmark, users.user_pincode, states.name AS statename, 
                            city.city_name AS cityname
                            FROM users
                            LEFT JOIN states ON states.indexId=users.user_state
                            LEFT JOIN city ON city.city_id=users.user_city
                            WHERE users.user_status=1 AND users.user_type_id='2'");
      $data['storelist'] = $q->result();
      echo json_encode($data); 
    }

     function genrateRefeeralCode(){
        $q = $this->db->query("SELECT * FROM `registers` where user_id <= '2201'");
        if($q->result()>0){
          foreach($q->result() as $row){
            $user_id=$row->user_id;
            $randomnumber   = $this->generateRandomStringUniqe(6);
			 // echo $randomnumber; exit;
            $this->db->query("UPDATE registers SET `referralnumber`='".$randomnumber."' where user_id ='".$user_id."'");
          }
        }
    }
	
	public function wishlist(){
		//print_r($_POST);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['responce']		=  false;
			$data['data'] 			=  $this->form_validation->error_string();
		}
		else{

			$this->load->model("common_model");
			$array = array(
				"product_id"=>$this->input->post("product_id"),
				"user_id"=>$this->input->post("user_id"),
				"status"=>0
			);
			$check =	$this->db->query("SELECT id FROM btl_wishlist WHERE user_id='".$this->input->post("user_id")."' AND product_id ='".$this->input->post("product_id")."' ");
				
			if($check->num_rows() <= 0){
				$result 	=	$this->db->insert("btl_wishlist",$array);
				$last_id 	=	$this->db->insert_id();
				if(!empty($last_id)){
					$data['responce']		=  true;
					$data['data'] 			=  "Successfully add whislist";
				}
				else{
					$data['responce']		=  false;
					$data['data'] 			=  "Something went Wrong";
				}
			}
			else{
				$data['responce']		=  false;
				$data['data'] 			=  "Already Added your whish List Product";
			}
		}
         echo json_encode($data);   	
	}
	public function Deletewishlist(){
		//print_r($_POST);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['responce']		=  false;
			$data['data'] 			=  $this->form_validation->error_string();
		}
		else{

			$this->load->model("common_model");
			$array = array(
				"product_id"=>$this->input->post("product_id"),
				"user_id"=>$this->input->post("user_id")
			);
			$check =	$this->db->query("SELECT id FROM btl_wishlist WHERE user_id='".$this->input->post("user_id")."' AND product_id ='".$this->input->post("product_id")."' ");
				
			if($check->num_rows() > 0){
				$result 	=	$this->db->delete("btl_wishlist",$array);
				if($result){
					$data['responce']		=  true;
					$data['data'] 			=  "Successfully Delete whislist";
				}
				else{
					$data['responce']		=  false;
					$data['data'] 			=  "Something went Wrong";
				}
			}
			else{
				$data['responce']		=  false;
				$data['data'] 			=  "Whishlist Not Available";
			}
		}
         echo json_encode($data);   	
	}
	public function whishListProduct(){
		$userid 	=	$this->input->post("user_id");
		$ProductList 	=	$this->db->query("SELECT products.*, deal_product.deal_price FROM `btl_wishlist`
							LEFT JOIN products ON products.product_id = btl_wishlist.product_id AND products.trash=0
							LEFT JOIN categories On categories.id = products.category_id
							LEFT JOIN deal_product On deal_product.product_id = products.product_id
							WHERE btl_wishlist.user_id ='".$userid."'");
		//echo $ProductList->num_rows(); exit;
		if($ProductList->num_rows() > 0){
			$data['responce']		=  true;
			$data['data'] 			=  $ProductList->result();
		}
		else{
			$data['responce']		=  false;
			$data['data'] 			=  "Something went Wrong";
		}
		echo json_encode($data); 
	}

				
}
?>