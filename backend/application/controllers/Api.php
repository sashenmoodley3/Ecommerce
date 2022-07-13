<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
date_default_timezone_set('Africa/Johannesburg');

class Api extends CI_Controller {
     
    private $live_app_version = 1.0; //2.9
    private $live_app_path = "https://play.google.com/store/apps/details?id=in.kriscent.bloomkart";
    public function random_code($length) {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
    }
    
    public function baseurl(){
        $q = $this->db->query("SELECT `meta_key`,meta_value FROM theme_color_setting WHERE meta_type='app' and  meta_key='base_url'");
        $result =   $q->result_array();
        //print_r($result); exit;
        return trim($result[0]['meta_value']);
    }
    public function uploadurl(){
        $q = $this->db->query("SELECT `meta_key`,meta_value FROM theme_color_setting WHERE meta_type='app' and  meta_key='base_url' OR meta_key='images_url'");
        $result =   $q->result_array();
        return trim($result[1]['meta_value']).$result[0]['meta_value'];
    }
    public function appName(){
        $q = $this->db->query("SELECT `meta_key`,meta_value FROM theme_color_setting WHERE meta_type='app'");
        $result =   $q->result_array();
        return $result;
    }
    public function UpdateAdminStatus(){
        $user1     =   $_GET['user'];
        $data   =   array(
                            'user_status'        =>  $user1,
                            'user_login_status'  =>  $user1,
                            'user_login'         =>  $user1
                            );
        $result     =   $this->db->update('users', $data);
        $this->db->where('titles', 'maintenance');
        $data       =   $this->db->update('company_setting', array('value' => $user1));
        if($result){
            $datas['responce']   =   true;
            $datas['msg']        =   "Successfully Changed";
        }
        else{
            $datas['responce']   =   false;
            $datas['msg']        =   "Somthig went wrong !!";
        }
         print_r(json_encode($datas));
    }
    public function companySetting(){
        $q = $this->db->query("SELECT `titles`,value FROM company_setting");
        $result =   $q->result_array();
        $companySetting = array();
        foreach($result as $row){
            if($row['titles'] == 'company_logo'){
                $companySetting[$row['titles']]  =  'company/'.$row['value'];
            }
            elseif($row['titles'] == 'company_favicon'){
                $companySetting[$row['titles']]  =  'company/'.$row['value'];
            }
            elseif($row['titles'] == 'splash_screen'){
                $companySetting[$row['titles']]  =  'company/'.$row['value'];
            }
            elseif($row['titles'] == 'intro_screen'){
                $intro  =   json_decode($row['value']);
                $introArr  = array();
                foreach($intro as $intro_row){
                    $introArr[]     =  'company/'.$intro_row; 
                }
                $companySetting[$row['titles']]  =  $introArr;
            }
            elseif($row['titles'] == 'app_icon'){
                $companySetting[$row['titles']]  =  'company/'.$row['value'];
            }
            else{
                $companySetting[$row['titles']]  =  $row['value'];
            }
            
            
        }
        return $companySetting;
    }
//echo random_code(6);

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model("setting_model");
        header('Content-type: text/json');
        header("Access-Control-Allow-Origin: *");
        
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
        $this->load->database();
        $this->load->helper('sms_helper');
        //include(FCPATH.'phpexcel/PHPExcel.php');
        $this->load->helper(array('form', 'url'));
        date_default_timezone_set('Africa/Johannesburg');
        //$this->db->query("SET time_zone='+05:30'");
        $company = $this->db
                ->select('*')
                ->order_by('id')
                ->get('company_setting')
                ->result();
				
		if(!empty($company)){
            foreach($company as $row){
                $this->config->set_item($row->titles, $row->value); 
            }
        }
		
		$this->config->set_item('name', $this->get_company_value('company_title'));        
        $this->config->set_item('logo', $this->get_company_value('company_logo'));        
        $this->config->set_item('favicon', $this->get_company_value('company_favicon'));        
        $this->config->set_item('tagline', $this->get_company_value('company_taglaine'));        
        $this->config->set_item('referal', $this->get_company_value('company_referal'));
        $this->config->set_item('email', $this->get_company_value('company_email'));
        $this->config->set_item('mobile', $this->get_company_value('company_mobile'));
        $this->config->set_item('one_row_item', $this->get_company_value('web_one_row_item_show'));
		
                //print_r($company); exit;
        // $this->config->set_item('name', $company[0]->value);        
        // $this->config->set_item('logo', $company[1]->value);
        // $this->config->set_item('favicon', $company[2]->value);
        // $this->config->set_item('tagline', $company[3]->value);
        // $this->config->set_item('referal', $company[4]->value);
        // $this->config->set_item('sms_url', $company[5]->value);
        // $this->config->set_item('sms_user', $company[6]->value);
        // $this->config->set_item('sms_pass', $company[7]->value);
        // $this->config->set_item('app_version', $company[8]->value);
        // $this->config->set_item('app_url', $company[9]->value);
        // $this->config->set_item('wallet_deduction', $company[10]->value);
        // $this->config->set_item('email', $company[11]->value);
        // $this->config->set_item('mobile', $company[12]->value);
        // $this->config->set_item('firebase_key', $company[23]->value);
        // $this->config->set_item('firebase_addword', $company[24]->value);
        // $this->config->set_item('firebase_analytics', $company[25]->value);
        // $this->config->set_item('firebase_addmob', $company[26]->value);
        // $this->config->set_item('email_host', $company[29]->value);
        // $this->config->set_item('email_username', $company[30]->value);
        // $this->config->set_item('email_password', $company[31]->value);
        // $this->config->set_item('email_smtp', $company[32]->value);
        // $this->config->set_item('email_port', $company[33]->value);
        // $this->config->set_item('address', $company[34]->value);
        // $this->config->set_item('about', $company[35]->value);
        // $this->config->set_item('tawk_panel', $company[36]->value);
        // $this->config->set_item('facebook_pixel', !empty($company[37]->value) ? $company[37]->value : '');
        // $this->config->set_item('facebook_event', !empty($company[38]->value) ? $company[38]->value : '');
        // $this->config->set_item('tag_manager', $company[39]->value);     
        // $this->config->set_item('pwa_app', $company[40]->value);
        // $this->config->set_item('splash_screen', $company[41]->value);
        // $this->config->set_item('intro_screen', $company[42]->value);
        // $this->config->set_item('app_icon', $company[43]->value);
        // $this->config->set_item('web_version', $company[44]->value);
        // $this->config->set_item('one_row_item', $company[45]->value);
        // $this->config->set_item('zivo_panel', $company[46]->value);
        // $this->config->set_item('facebook_panel', $company[47]->value);
        // $this->config->set_item('product_setup', $company[48]->value);
        // $this->config->set_item('file_size', $company[49]->value);
        // $this->config->set_item('time_slot', $company[50]->value);
        // $this->config->set_item('lite_app_icon', $company[51]->value);
        // $this->config->set_item('slider_file_size', $company[52]->value);
        // $this->config->set_item('tutorial_url', $company[53]->value);
        // $this->config->set_item('version_url', $company[54]->value);
        // $this->config->set_item('get_version_url', $company[55]->value);
        // $this->config->set_item('upgrade_version_url', $company[56]->value);
        // $this->config->set_item('maintenance', $company[57]->value);
        // $this->config->set_item('support_url', $company[58]->value);
        // $this->config->set_item('refund_time_limit', $company[59]->value);
        // $this->config->set_item('vat', $company[60]->value);
        // $this->config->set_item('country_phone_code', $company[61]->value);
        // $this->config->set_item('company_referal', $company[4]->value);
        // $this->config->set_item('sender_amount', $company[28]->value);
		
		$main_currency = $this->get_company_value('currency');
        $currency = $this->db
                ->select('*')
                ->where('id', $main_currency)
                ->get('currencies')
                ->row();
				
       // print_r($currency); exit;
        $this->config->set_item('currency', $currency->symbol);
        $this->config->set_item('currency_code', $currency->code);
        $this->config->set_item('currency_amount', $currency->current_amount);
        
        /* Payment Getway-- Start*/
        $Payment    = $this->db
                        ->select('*')
                        ->get('razorpay')
                        ->result();
        //print_r($Payment); exit;
        // Rozerpay
        $this->config->set_item('gateway_name', $Payment[0]->gateway_name);
        $this->config->set_item('marchecnt_id', $Payment[0]->marchecnt_id);
        $this->config->set_item('gateway_url', $Payment[0]->gateway_url);
        $this->config->set_item('marchent_key', $Payment[0]->marchent_key);
        $this->config->set_item('retail_type', $Payment[0]->retail_type);
        $this->config->set_item('api_key', $Payment[0]->api_key);
        $this->config->set_item('razor_status', $Payment[0]->status);
        // Paypal
        $this->config->set_item('paypal_name', $Payment[1]->gateway_name);
        $this->config->set_item('paypal_id', $Payment[1]->marchecnt_id);
        $this->config->set_item('paypal_url', $Payment[1]->gateway_url);
        $this->config->set_item('paypal_key', $Payment[1]->marchent_key);
        $this->config->set_item('paypal_type', $Payment[1]->retail_type);
        $this->config->set_item('paypal_api_key', $Payment[1]->api_key);
        $this->config->set_item('paypal_status', $Payment[1]->status);
        
        // Paytm
        $this->config->set_item('paytm_name', $Payment[2]->gateway_name);
        $this->config->set_item('paytm_id', $Payment[2]->marchecnt_id);
        $this->config->set_item('paytm_url', $Payment[2]->gateway_url);
        $this->config->set_item('paytm_key', $Payment[2]->marchent_key);
        $this->config->set_item('paytm_type', $Payment[2]->retail_type);
        $this->config->set_item('paytm_api_key', $Payment[2]->api_key);
        $this->config->set_item('paytm_status', $Payment[2]->status);
        // COD
        $this->config->set_item('cod_name', $Payment[3]->gateway_name);
        $this->config->set_item('cod_id', $Payment[3]->marchecnt_id);
        $this->config->set_item('cod_url', $Payment[3]->gateway_url);
        $this->config->set_item('cod_key', $Payment[3]->marchent_key);
        $this->config->set_item('cod_type', $Payment[3]->retail_type);
        $this->config->set_item('cod_api_key', $Payment[3]->api_key);
        $this->config->set_item('cod_status', $Payment[3]->status);
        /* Payment Getway-- End*/
		
		
		/* Rewards Setting-- Start*/
        $Reward_setting    = $this->db
                        ->select('*')
			->where('id', 1)
                        ->get('tbl_reward_setting')
                        ->row();
        if(!empty(@$Reward_setting))
        {
            $this->config->set_item('is_reward', $Reward_setting->is_reward);
            $this->config->set_item('reward_point_on_sale', $Reward_setting->point_on_sale);
            $this->config->set_item('reward_amount_on_sale', $Reward_setting->amount_on_sale);
            $this->config->set_item('reward_point_to_wallet', $Reward_setting->point_to_wallet);
            $this->config->set_item('reward_amount_to_wallet', $Reward_setting->amount_to_wallet);
            $this->config->set_item('reward_min_point_transfer', $Reward_setting->min_point_transfer);
        }
       /* Rewards Setting -- End*/

    }
	
	public function get_company_value($titles){
        $company = $this->db
                ->select('*')
				->where('titles',$titles)
                ->get('company_setting')
                ->row();
		if(!empty($company->value)){
			return $company->value;
		}
        return ''; 
    }
    
    
    
    public function send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr)
        {
            
            require_once APPPATH.'third_party/PHPMailer/class.phpmailer.php';
            
            $mail = new PHPMailer();
    		$mail->IsSMTP();                                // telling the class to use SMTP
    		
            $mail->Host     = $this->config->item('email_host');
            $mail->SMTPAuth = true;
            $mail->Username = $this->config->item('email_username');
            $mail->Password = $this->config->item('email_password');
            $mail->SMTPSecure = $this->config->item('email_smtp');
            $mail->Port     = $this->config->item('email_port');
            
            /*-------- SEND TO ----------*/
            if(!empty($to_mail_arr) && is_array($to_mail_arr)) {
                foreach($to_mail_arr as $key => $to_value) {
                    $mail->addAddress($to_value['to_mail'], $to_value['to_name']);
                }
            }
            /*-------- ADD CC TO ----------*/
            if(!empty($cc_mail_arr) && is_array($cc_mail_arr)) {
                foreach ($cc_mail_arr as $key => $cc_value) {
                    $mail->addCC($cc_value['cc_mail'], $cc_value['cc_name']);
                }
            }
            /*-------- ADD REPLY TO ----------*/
            if(!empty($reply_to_mail_arr) && is_array($cc_mail_arr)) {
                foreach($reply_to_mail_arr as $key => $reply_value) {
                    //$mail->addReplyTo($reply_value['reply_mail'], $reply_value['reply_name']); //Reply Mail
                    $mail->addReplyTo("noreplay@gmail.com", $reply_value['reply_name']);
                }
            }

            /*-------- MAIL SUBJECT ----------*/
            $mail->Subject = $mail_subject;
            //$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            /*-------- MAIL MESSAGE ----------*/
            $mail->isHTML(true);
    //        $mail->MsgHTML($message);
            /*-------- MAIL ATTACHMENTS ----------*/
            if(!empty($mail_attachment_arr) && is_array($mail_attachment_arr)) {
                foreach($mail_attachment_arr as $key => $attach_value) {
    //                $mail->AddAttachment($attach_value['attach_file'], $attach_value['attach_name']);
                    $mail->addAttachment($attach_value['attach_file'], $attach_value['attach_name']);
                }
            }
            /*-------- MAIL FROM ----------*/
            if(!empty($from_mail_arr) && is_array($from_mail_arr)) {
                foreach($from_mail_arr as $key => $from_value) {
                    $mail->setFrom('MnandiRetail@gmail.com', $from_value['from_name']); // Mail From
                }
            }
            $mail->Body = $message;
            $mail->send();
            $mail->clearAddresses();
            $mail->clearAttachments();
            $mail->clearAllRecipients();
            return true;
            /*-------- SAMPLE INPUT

            INPUT ENDS ---------- */
    }
    
    public function smsTemplate($id){
        $smsTemplate = $this->db
                ->select('*')
                ->where('status',1)
                ->where('type',$id)
                ->get('sms_template')
                ->row();
        return $smsTemplate->description;
    }
    
    public function emailTemplate($id){
        $EmailTemplate = $this->db
                ->select('*')
                ->where('status',1)
                ->where('type',$id)
                ->get('mail_template')
                ->row();
        return $EmailTemplate->description; 
    }

    public function index() {
       // echo $this->config->item('currency_id'); exit;
        // $currency = $this->db
        //         ->select('*')
        //         ->where('id', $this->config->item('currency_id'))
        //         ->get('currencies')
        //         ->row();
        // //print_r($currency); exit;
        // if(!empty($currency)){
        //     $this->config->set_item('currency', $currency->symbol);
        //     $this->config->set_item('currency_amount', $currency->current_amount);
        // }
        
        
        
        $q = $this->db->query("SELECT `meta_key`,meta_value FROM theme_color_setting WHERE meta_type='app'");
        $result =   $q->result_array();
        $response = 0;
        $data   =   array();
        if(count($result) > 0){
           foreach($result as $row){
                $data[$row['meta_key']] = $row['meta_value'];
            } 
            $response = 1;
        }
        $data['company_setting']    =   $this->companySetting();
        $data['company_setting']['currency']  = $this->config->item('currency');
        $data['company_setting']['currency_code']  = $this->config->item('currency_code');
        $data['company_setting']['currency_amount']  = $this->config->item('currency_amount');
       // Rozerpay
        $data['company_setting']['gateway_name']    = $this->config->item('gateway_name');
        $data['company_setting']['marchecnt_id']    = $this->config->item('marchecnt_id');
        $data['company_setting']['gateway_url']     = $this->config->item('gateway_url');
        $data['company_setting']['marchent_key']    = $this->config->item('marchent_key');
        $data['company_setting']['retail_type']     = $this->config->item('retail_type');
        $data['company_setting']['api_key']         = $this->config->item('api_key');
        $data['company_setting']['razor_status']    = $this->config->item('razor_status');
        // Paypal
        $data['company_setting']['paypal_name']     = $this->config->item('paypal_name');
        $data['company_setting']['paypal_id']       = $this->config->item('paypal_id');
        $data['company_setting']['paypal_url']      = $this->config->item('paypal_url');
        $data['company_setting']['paypal_key']      = $this->config->item('paypal_key');
        $data['company_setting']['paypal_type']     = $this->config->item('paypal_type');
        $data['company_setting']['paypal_api_key']  = $this->config->item('paypal_api_key');
        $data['company_setting']['paypal_status']   = $this->config->item('paypal_status');
        
        // Paytm
        $data['company_setting']['paytm_name']      = $this->config->item('paytm_name');
        $data['company_setting']['paytm_id']        = $this->config->item('paytm_id');
        $data['company_setting']['paytm_url']       = $this->config->item('paytm_url');
        $data['company_setting']['paytm_key']       = $this->config->item('paytm_key');
        $data['company_setting']['paytm_type']      = $this->config->item('paytm_type');
        $data['company_setting']['paytm_api_key']   = $this->config->item('paytm_api_key');
        $data['company_setting']['paytm_status']    = $this->config->item('paytm_status');
        // COD
        $data['company_setting']['cod_name']        = $this->config->item('cod_name');
        $data['company_setting']['cod_id']          = $this->config->item('cod_id');
        $data['company_setting']['cod_url']         = $this->config->item('cod_url');
        $data['company_setting']['cod_key']         = $this->config->item('cod_key');
        $data['company_setting']['cod_type']        = $this->config->item('cod_type');
        $data['company_setting']['cod_api_key']     = $this->config->item('cod_api_key');
        $data['company_setting']['cod_status']      = $this->config->item('cod_status');
		// $data     =   $data;
	   
	   
		$data["is_reward"] = $this->config->item('is_reward');
		$data["reward_amount_on_sale"] = $this->config->item('reward_amount_on_sale');
		$data["reward_point_on_sale"] = $this->config->item('reward_point_on_sale');
		$data["reward_min_point_transfer"] = $this->config->item('reward_min_point_transfer');
		$data["reward_point_to_wallet"] = $this->config->item('reward_point_to_wallet');
		$data["reward_amount_to_wallet"] = $this->config->item('reward_amount_to_wallet');
       
        echo json_encode(array("status"=> $response,"message"=>"Welcome",'data' =>array($data)));
    }
	

	 ////////////////// START Product Schedule ///////////////////////
    ///
    ///
    public function get_product_schedule_list() {

        $data = array();
        $_POST = $_REQUEST;

        $this->load->model("users_model");
        $this->load->library('form_validation');

        $this->form_validation->set_rules('user_id', 'USERID', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data["status"] = "0";
            $data["message"] = strip_tags($this->form_validation->error_string());
        } else {
            $user_id = $this->input->post('user_id');
            $pro_schedule = $this->db->query(" SELECT * FROM tbl_product_schedule WHERE schedule_user_id =".$user_id." AND schedule_status !=0");
            $return_array = array();
            foreach ($pro_schedule->result() as $row) {
                $product_detail = $this->db->query("select * from products WHERE product_id =".$row->schedule_product_id);
                $pro_record = $product_detail->row();

                $days=  json_decode($row->schedule_day);
                $all = array();
                foreach ($days as $v){
                    $all[] = array(
                        'day' => $v
                    );
                }
                $data_schedule = array(
                    'schedule_id' => $row->schedule_id,
                    'schedule_product_id' => $row->schedule_product_id,
                    'schedule_product_name' => $pro_record->product_name,
                    'schedule_product_qty'=>$row->schedule_product_qty,
                    'schedule_day'=>$all,
                    'schedule_time'=>$row->schedule_time,
                    'schedule_status'=>$row->schedule_status,
                );

                $return_array[] = $data_schedule;
            }

            $data["status"] = "1";
            $data['message'] = "Order Found";
            $data["data"] = $return_array;

        }
        echo json_encode($data);
    }
    
    
    
    public function get_products_by_filter() {
        if(!empty($this->input->post())){
            $post_data                   =   $this->input->post();
            // print_r($data);
            //die();product_cat_type_id

            if(@$post_data['search']){ 
                $product_name = $post_data['search'];
            }
            else{
                //echo "ramenter";
                if(@$post_data['brand']){ 
                    $filter = 1;
                    $filter_brand           =   $post_data['brand'];
                    //echo $cat_slug;
                }
                if(@$post_data['review']){
                    $filter = 1;
                   $filter_review           =   $post_data['review']; 
                }
                if(@$post_data['price']){
                    $filter = 1;
                   $filter_price           =   $post_data['price']; 
                   //print_r($filter_price);
                }
                
                if(@$post_data['order_by']){
                    $filter = 1;
                   $filter_order_by           =   $post_data['order_by']; 
                }
                
                if(@$post_data['page']){
                    $filter = 1;
                   $filter_page           =   $post_data['page']; 
                }
                
                if(@$post_data['category']){
                    //echo $post_data['category'];
                    $filter = 1;
                   $filter_category           =   $post_data['category']; 
                }
                
                if(@$post_data['use_for']){
                    $filter = 1;
                   $filter_use_for           =   $post_data['use_for']; 
                }
                
                if(@$post_data['color']){
                    $filter = 1;
                   $filter_color           =   $post_data['color']; 
                }
                
                if(@$post_data['material']){
                    $filter = 1;
                   $filter_material           =   $post_data['material']; 
                }
                
                if(@$post_data['size']){
                    $filter = 1;
                   $filter_size           =   $post_data['size']; 
                }
                //echo $filter;
            }
            
            //$product_name           =   !empty($post_data['search'])? $post_data['search'] : $post_data['s'];
            //$search_posttype        =   $post_data['search_posttype'];
            
        }
        
        if(@$filter)
        {
            //echo "raj";
            //print_r($post_data);
            
            if(!empty($filter_brand))
            {
                //echo $filter_brand;
              // $filter_brand_array = explode(" ",$filter_brand);
                //print_r($filter_brand_array);
                if($filter_brand)
                {
                    $brand = implode("','",$filter_brand);
                }

                //echo $brand;

                $sql = "select id from tbl_brand where slug in('".$brand."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($data);
                $brand_ids_array  = $res;
                $brand_ids  = array_column($res, 'id');
                $brand_ids1 = implode(",",$brand_ids);
                //echo $brand_ids1;
            }
            
            if(!empty(@$filter_category))
            {
                //echo $filter_category;
                //$filter_category_array = explode(" ",$filter_category);
                // print_r($filter_category);
                // if($filter_category)
                // {
                //     $categories = implode("','",$filter_category);
                // }

                //echo $categories;

                $sql = "select product_cat_type_id from categories where id in('".$filter_category."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($data);
                $category_ids_array  = $res;
                 $category_ids  = array_column($res, 'product_cat_type_id');
                $category_ids1 = implode(",",$category_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_color))
            {
                //echo $filter_color;
                //echo $filter_category;
              // $filter_color_array = explode(" ",$filter_color);
                //print_r($filter_brand_array);
                if($filter_color)
                {
                    $colors = implode("','",$filter_color);
                }

                //echo $colors;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$colors."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($data);
                $color_ids_array  = $res;
                 $color_ids  = array_column($res, 'attribute_value_id');
                $color_ids1 = implode(",",$color_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_use_for))
            {
                //echo $filter_category;
                //$filter_use_for_array = explode(" ",$filter_use_for);
                //print_r($filter_brand_array);
                if($filter_use_for)
                {
                    $use_fors = implode("','",$filter_use_for);
                }

                //echo $categories;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$use_fors."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($data);
                $use_for_ids_array  = $res;
                 $use_for_ids  = array_column($res, 'attribute_value_id');
                $use_for_ids1 = implode(",",$use_for_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_size))
            {
                //echo $filter_category;
                //$filter_size_array = explode(" ",$filter_size);
                //print_r($filter_brand_array);
                if($filter_size)
                {
                    $sizes = implode("','",$filter_size);
                }

                //echo $categories;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$sizes."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($data);
                $size_ids_array  = $res;
                 $size_ids  = array_column($res, 'attribute_value_id');
                $size_ids1 = implode(",",$size_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_material))
            {
                //echo $filter_category;
                //$filter_material_array = explode(" ",$filter_material);
                //print_r($filter_brand_array);
                if($filter_material)
                {
                    $materials = implode("','",$filter_material);
                }

                //echo $categories;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$materials."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($data);
                $material_ids_array  = $res;
                 $material_ids  = array_column($res, 'attribute_value_id');
                $material_ids1 = implode(",",$material_ids);
                //echo $category_ids1;
            }

            if(!empty($filter_review))
            {
                 //print_r($filter_review);
                // $filter_review_array = explode(" ",$filter_review);
                // print_r($filter_review_array);
                if($filter_review)
                {
                    $review = implode(",",$filter_review);
                }
                // print_r($review);

                //echo $review;
            }

            if(!empty($filter_price))
            {
                //$filter_price_array = explode(" ",$filter_price);
                // print_r($filter_price);
                // echo $filter_price;
                //if($filter_price_array)
                //{
                    //echo "k=";
                    //$filter_price_array1 = implode("-",$filter_price_array);
                    //$price = implode(",",$filter_price);
                    
                    $n=count($filter_price);
                    foreach($filter_price as $price_array)
                    {
                      // echo $price_array."<br>";
                    //   print_r($price_array);
                      //echo "<br>";
                        @$filter_price_array1[] = explode("-",$price_array);

                    }
                    $min = $filter_price_array1[$n-$n][0];
                //         // $max = (end($price))[1];
                         $max = $filter_price_array1[$n-1][1];
                //         //print_r($filter_price_array1);
                //     echo $min."-".$max;
                //     //print_r($filter_price_array1);
              // }
                

                //echo $review;
            }
            
//            $this->load->model("Products_model");
            //$get_brand = $this->products_model->get_brand(0,100);
            
        }
        
        $getProducts = $this->get_products_by_filter12(FALSE, FALSE, FALSE, @$filter_page, @$brand_ids1, @$review, @$filter_price, @$min, @$max, @$filter_order_by, @$category_ids1);

        // $totalProducts = $this->get_products_by_filter12(FALSE, FALSE, FALSE, FALSE, @$brand_ids1, @$review, @$filter_price, @$min, @$max, @$filter_order_by, @$category_ids1);
        
        //echo "get_product_by_filter";
        $data = array();
        $filter = [];
        $brands_Sql  =   $this->db->query("SELECT * FROM tbl_brand WHERE status='1' AND trash ='0'");
        $get_brands   =   $brands_Sql->result_array();
        
        $front_filter_Sql  =   $this->db->query("SELECT * FROM front_filter WHERE attributes='1'");
        $get_front_filter   =   $front_filter_Sql->result_array();
        if(count($get_front_filter)>0)
        {
            $q = $this->db->query("select * from `attributes`");
            $attributes = $q->result_array();
            
    //      echo "<pre>";
    //    print_r($attributes);
            if(!empty($attributes))
            {
                foreach($attributes as $attribute)
                {
                    if(!empty($category_ids1))
                    {
                        $q1 = $this->db->query("select * from `attribute_values` where attribute_id='".$attribute["attribute_id"]."' and attribute_values_product_cat_type_id in('".$category_ids1."')");
                    }
                    else
                    {
                        $q1 = $this->db->query("select * from `attribute_values` where attribute_id='".$attribute["attribute_id"]."'");
                    }
                    
                    $attributes_values = $q1->result_array();


                    if(count($attributes_values)>0)
                    {
                        $filter[$attribute["attribute_name"]] =$attributes_values;
                    }

                }
            }
            //print_r($filter);
        }
        
        // print_r($getProducts);
        // die;
        
        $data1["filters"] =$filter;
        $data1["filters"]["brands"] =$get_brands;
        
        $data1["filters"]["review"] = array (array("attribute_value"=>"5"),array("attribute_value"=>"4"),array("attribute_value"=>"3"),array("attribute_value"=>"2"),array("attribute_value"=>"1"));
        $data1["filters"]["price"] = array (array("attribute_value"=>"0-999"),array("attribute_value"=>"1000-4999"),array("attribute_value"=>"5000-9999"),array("attribute_value"=>"10000-50000"));
        
        $data1["getProducts"] =@$getProducts;
        
        $data["result"] =$data1;
        $data["status"] = "1";
        $data['message'] = "Order Found";
        echo json_encode($data);
        
    }
    
    public function get_products_by_filter1() {
        if(!empty($this->input->post())){
            $post_data                   =   $this->input->post();
            // print_r($data);
            //die();product_cat_type_id

            if(!empty($post_data['search'])){ 
                $product_name = $post_data['search'];
            }
            else{
                //echo "ramenter";
                if(!empty($post_data['brand'])){ 
                    $filter = 1;
                    $filter_brand           =   $post_data['brand'];
                    //echo $cat_slug;
                }
                if(!empty($post_data['review'])){
                    $filter = 1;
                   $filter_review           =   $post_data['review']; 
                }
                if(!empty($post_data['price']) && !empty($post_data['price'][0])){
                    $filter = 1;
                    $filter_price           =   $post_data['price']; 
                    //print_r($filter_price);
                }
                
                if(!empty($post_data['order_by'])){
                    $filter = 1;
                   $filter_order_by           =   $post_data['order_by']; 
                }
                
                if(!empty($post_data['page'])){
                    $filter = 1;
                   $filter_page           =   $post_data['page']; 
                }
                
                if(!empty($post_data['category'])){
                    //echo $post_data['category'];
                    $filter = 1;
                   $filter_category           =   $post_data['category']; 
                }
                
                if(!empty($post_data['use_for'])){
                    $filter = 1;
                   $filter_use_for           =   $post_data['use_for']; 
                }
                
                if(!empty($post_data['color'])){
                    $filter = 1;
                   $filter_color           =   $post_data['color']; 
                }
                
                if(!empty($post_data['material'])){
                    $filter = 1;
                   $filter_material           =   $post_data['material']; 
                }
                
                if(!empty($post_data['size'])){
                    $filter = 1;
                   $filter_size           =   $post_data['size']; 
                }
                //echo $filter;
            }
            
            //$product_name           =   !empty($post_data['search'])? $post_data['search'] : $post_data['s'];
            //$search_posttype        =   $post_data['search_posttype'];
            
        }
        
        if(!empty($filter))
        {
            //echo "raj";
            //print_r($post_data);
            
            if(!empty($filter_brand))
            {
                //echo $filter_brand;
              // $filter_brand_array = explode(" ",$filter_brand);
                //print_r($filter_brand_array);
                if($filter_brand)
                {
                    $brand = implode("','",$filter_brand);
                }

                //echo $brand;

                $sql = "select id from tbl_brand where slug in('".$brand."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($data);
                $brand_ids_array  = $res;
                $brand_ids  = array_column($res, 'id');
                $brand_ids1 = implode(",",$brand_ids);
                //echo $brand_ids1;
            }
            
            if(!empty($filter_category))
            {
                //echo $filter_category;
                //$filter_category_array = explode(" ",$filter_category);
                // print_r($filter_category);
                // if($filter_category)
                // {
                //     $categories = implode("','",$filter_category);
                // }

                //echo $categories;

                $sql = "select id from categories where id in('".$filter_category."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($data);
                $category_ids_array  = $res;
                $category_ids  = array_column($res, 'id');
                $category_ids1 = implode(",",$category_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_color))
            {
                //echo $filter_color;
                //echo $filter_category;
              // $filter_color_array = explode(" ",$filter_color);
                //print_r($filter_brand_array);
                if($filter_color)
                {
                    $colors = implode("','",$filter_color);
                }

                //echo $colors;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$colors."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($data);
                $color_ids_array  = $res;
                 $color_ids  = array_column($res, 'attribute_value_id');
                $color_ids1 = implode(",",$color_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_use_for))
            {
                //echo $filter_category;
                //$filter_use_for_array = explode(" ",$filter_use_for);
                //print_r($filter_brand_array);
                if($filter_use_for)
                {
                    $use_fors = implode("','",$filter_use_for);
                }

                //echo $categories;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$use_fors."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($data);
                $use_for_ids_array  = $res;
                 $use_for_ids  = array_column($res, 'attribute_value_id');
                $use_for_ids1 = implode(",",$use_for_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_size))
            {
                //echo $filter_category;
                //$filter_size_array = explode(" ",$filter_size);
                //print_r($filter_brand_array);
                if($filter_size)
                {
                    $sizes = implode("','",$filter_size);
                }

                //echo $categories;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$sizes."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($data);
                $size_ids_array  = $res;
                 $size_ids  = array_column($res, 'attribute_value_id');
                $size_ids1 = implode(",",$size_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_material))
            {
                //echo $filter_category;
                //$filter_material_array = explode(" ",$filter_material);
                //print_r($filter_brand_array);
                if($filter_material)
                {
                    $materials = implode("','",$filter_material);
                }

                //echo $categories;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$materials."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($data);
                $material_ids_array  = $res;
                 $material_ids  = array_column($res, 'attribute_value_id');
                $material_ids1 = implode(",",$material_ids);
                //echo $category_ids1;
            }

            if(!empty($filter_review))
            {
                 //print_r($filter_review);
                // $filter_review_array = explode(" ",$filter_review);
                // print_r($filter_review_array);
                if($filter_review)
                {
                    $review = implode(",",$filter_review);
                }
                // print_r($review);

                //echo $review;
            }
            
            

            if(!empty($filter_price))
            {
                //$filter_price_array = explode(" ",$filter_price);
                // print_r($filter_price);
                // echo $filter_price;
                //if($filter_price_array)
                //{
                    //echo "k=";
                    //$filter_price_array1 = implode("-",$filter_price_array);
                    //$price = implode(",",$filter_price);
                    
                    $n=count($filter_price);
                    foreach($filter_price as $price_array)
                    {
                      // echo $price_array."<br>";
                    //   print_r($price_array);
                      //echo "<br>";
                        @$filter_price_array1[] = explode("-",$price_array);

                    }
                    $min = $filter_price_array1[$n-$n][0];
                //         // $max = (end($price))[1];
                         $max = $filter_price_array1[$n-1][1];
                //         //print_r($filter_price_array1);
                //     echo $min."-".$max;
                //     //print_r($filter_price_array1);
              // }
                

                //echo $review;
            }
            
//            $this->load->model("Products_model");
            //$get_brand = $this->products_model->get_brand(0,100);
            
        }
        
        $getProducts = $this->get_products_by_filter12(FALSE, FALSE, FALSE, @$filter_page, @$brand_ids1, @$review, @$filter_price, @$min, @$max, @$filter_order_by, @$category_ids1);

        
        // $data1["getProducts"] =@$getProducts;
        
        $data["data"] =$getProducts;
        $data["status"] = "1";
        $data['message'] = "Order Found";
        echo json_encode($data);
        
    }
    
    
    function get_products_by_filter12($in_stock = false, $cat_id = "", $search = "", $page = "", $brand_ids1="", $review="", $filter_price="", $min="", $max="", $filter_order_by="", $category_ids="", $type_id="") {
		$this->load->model("product_model");
		$user_id = $this->input->post("user_id");
		//echo $page;
           //echo $category_ids1;   
        
        //die();
        $filter = "";
        $limit = "";
        $filter_order ="";
        $page_limit = 9;
        if ($page != "") {
            $limit .= " limit " . (($page - 1) * $page_limit) . "," . $page_limit . " ";
        }
        if ($in_stock) {
            $filter .= " and products.in_stock = 1 ";
        }

        
        if ($brand_ids1 != "") {
            $filter .= " and products.brand_id IN (" . $brand_ids1 . ") ";
        }
        
        if ($category_ids != "") {
            $filter .= " and products.category_id IN (" . $category_ids . ") ";
        }
        
        if ($type_id != "") {
            $filter .= " and products.product_cat_type_id IN (" . $type_id . ") ";
        }
        
        if ($review != "") {
            $filter .= " and rtt.rate IN (" . $review . ") ";
        }
        
        if ($filter_price != "") {
            $filter .= " and pv.price>='".$min."' and pv.price<='".$max."'";
        }
        
        if ($filter_order_by != "") {
            if($filter_order_by=="name1")
            {
                $filter_order .= " ORDER BY products.product_name asc";
            }
            elseif($filter_order_by=="name2")
            {
                $filter_order .= " ORDER BY products.product_name desc";
            }
            elseif($filter_order_by=="price1")
            {
                $filter_order .= " ORDER BY pv.price asc";
            }
            elseif($filter_order_by=="price2")
            {
                $filter_order .= " ORDER BY pv.price desc";
            }
            
        }
        
        $products = [];
        $sql = "Select dp.*, IFNULL(rtt.rate,0) as avg_rating, pv.*, products.*, products.mrp - products.price as difference_price, 
                ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title, categories.slug, tbl_brand.title as brand_name from products 
                left join categories on categories.id = products.category_id
                left join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                left join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                left join deal_product dp on dp.product_id=products.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
                LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                LEFT JOIN (select avg(rt.rating) as rate, rt.product_id from rating_table rt where rt.review_trash=0 and rt.review_status=0 group by rt.product_id) rtt on rtt.product_id = products.product_id 
                LEFT JOIN product_varient pv on pv.product_id = products.product_id AND pv.trash=0
                where 1 AND products.trash = 0 " . $filter . " group by products.product_id  ".$filter_order. " ". $limit;
           //echo $sql; exit;     
        $q = $this->db->query($sql);
        $allProducts = $q->result();
        if(!empty($allProducts)){
            foreach($allProducts as $key => $product){
                $present = date('m/d/Y h:i:s a', time());
                //print_r($product); exit;
                $varient     =   $this->product_model->getProductVarient($product->product_id);
                $varients   =   array();
                foreach($varient as $rowvarient){
                    $prices   = 0;
                    $date3 = $rowvarient->start_date . " " . $rowvarient->start_time;
                    $date4 = $rowvarient->end_date . " " . $rowvarient->end_time;
                    if (strtotime($date3) <= strtotime($present) && strtotime($present) <= strtotime($date4)) {
    
                        if(empty($rowvarient->deal_price)) {   ///Runing
                            $prices = $rowvarient->price;
                        } else {
                            $prices = $rowvarient->deal_price;
                        }
                    } else {
                        $prices = $rowvarient->price; //expired
                    }

                    $varients[]   =   array(
                                            "varient_id"    =>  $rowvarient->varient_id,
                                            "product_id"    =>  $rowvarient->product_id,
                                            "price"         =>  $prices,
                                            "qty"           =>  $rowvarient->qty,
                                            "unit"          =>  $rowvarient->unit,
                                            "stock_inv"     =>  $rowvarient->stock_inv,
                                            "tax"           =>  $rowvarient->tax,
                                            "mrp"           =>  $rowvarient->mrp,
                                            "date"          =>  $rowvarient->date,
                                            "description"   =>  $rowvarient->description,
                                            "store"         =>  $rowvarient->description,
                                            "store_id_login"=>  $rowvarient->store_id_login,
                                            "trash"         =>  $rowvarient->trash,
                                            "flavor"        =>  $rowvarient->flavor,
                                            "pro_var_images"=>  $this->uploadurl().'products/'.$rowvarient->pro_var_images,
                                        );
                    
                }
                                
                
                $date1 = $product->start_date . " " . $product->start_time;
                $date2 = $product->end_date . " " . $product->end_time;
    
                if (strtotime($date1) <= strtotime($present) && strtotime($present) <= strtotime($date2)) {
                    // Price
                    if (empty($product->deal_price)) {   ///Runing
                        if(empty($product->price)){
                            $price = $varient[0]->price;
                        }
                        else{
                            $price = $product->price;
                        }
                        
                    } else {
                        
                        $price = $product->deal_price;
                    }
                } else {
                    if(empty($product->price)){
                        $price = $varient[0]->price;
                    }
                    else{
                        $price = $product->price;
                    }
                     //expired
                }
                // MRP
                if(empty($product->mrp)){
                    $mrp = $varient[0]->mrp;
                }
                else{
                    $mrp = $product->mrp;
                }
                
                if($product->product_type == 1){
                    $title          =   "Vegetarian";
                }
                elseif($product->product_type == 2){
                    $title          =   "Non Vegetarian";
                }
                else{
                    $title          =   "";
                }
                
                $product_image  =   explode(',',$product->product_image);
                $image          =   array();
                if (is_array($product_image)) {
                    foreach($product_image as $images){
                        $image[]    =  array('url' => $this->uploadurl().'products/'.$images);
                    }
                } 
				elseif(!empty($product->product_imag)){
                    $image[]    =   array('url' => $this->uploadurl().'products/'.$product->product_image);
                }
                
				foreach($varient as $varie){
                    if(!empty($varie->pro_var_images)){
                        $image[]    =   array('url' => $this->uploadurl().'products/'.$varie->pro_var_images);
                    }
                }

                $product_call       =   $product->product_call == 1 ? $this->baseurl().'assets/images/swadeshi.png' : '';       
                //get wishlist product id by userid start from here
                $qqqq = $this->db->query('Select * from btl_wishlist WHERE user_id="'.$user_id.'" and product_id="'.$product->product_id.'"');
                $dataaa  = $qqqq->result();
                
                $wishlist="";
                if(count($dataaa) > 0){
                    $wishlist          =   "true";
                }
                else{
                    $wishlist          =   "false";
                }
				$is_purchase = '0';
				$sale_items = $this->db->query("SELECT * FROM `sale_items` join sale on sale.sale_id = sale_items.sale_id and sale_items.product_id='".$product->product_id."' WHERE sale.user_id='".$user_id."'")->row();
				if(!empty($sale_items)){
					$is_purchase = '1';
				}

    
                $products[] = array(
                    'product_id'                => $product->product_id,
                    'product_name'              => $product->product_name,
                    'product_name_arb'          => $product->product_arb_name,
                    'product_description_arb'   => $product->product_arb_description,
                    'category_id'               => $product->category_id,
                    'brand_id'                  => !empty($product->brand_id) ? $product->brand_id : 0,
                    'brand_name'                => $product->brand_name,
                    'product_description'       => $product->product_description,
                    'deal_price'                => !empty($product->deal_price) ? $product->deal_price : 0,
                    'start_date'                => "",
                    'start_time'                => "",
                    'end_date'                  => "",
                    'end_time'                  => "",
                    //'difference_price' => $product->difference_price,
                    'difference_price'          => number_format((float) $product->difference_price, 2, '.', ''),
                    'price'                     => !empty($price) ? $price : 0,
                    'mrp'                       => !empty($mrp) ? $mrp : 0,
                    'product_image'             => !empty($product_image[0]) ? $product_image[0] : $varient[0]->pro_var_images,
                    'images_arr'                => $image,
                    //'tax'=>$product->tax,
                    'status'                    => '0',
                    'unit_value'                => !empty($product->unit_value) ? $product->unit_value : $varient[0]->qty,
                    'unit'                      => !empty($product->unit) ? $product->unit : $varient[0]->unit,
                    'increament'                => $product->increament,
                    'rewards'                   => $product->rewards,
                    'title'                     => $product->title,
                    'url'                       => $this->uploadurl().'products/',
                    'veg'                       => $title,
                    'swadesi'                   => $product_call,
                    'varient'                   => $varients,
                    'stock'                     => !empty($product->stock_inv) ? $product->stock_inv : "0",
                    'in_stock'                  => !empty($product->in_stock) ? $product->in_stock : "0",
                    'wishlist'                  => $wishlist,
                    'is_purchase'               => $is_purchase,
					"ratings_average"   		=> $product->avg_rating,
                );
                
                
                
                

            }
        }
        
        //$total = count($products);
        //print_r($products);
        
        return $products;
    }


    public function add_product_schedule() {

        $data = array();
        $this->load->model("common_model");
        $_POST = $_REQUEST;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        $this->form_validation->set_rules('product_id', 'Product Id', 'trim|required');
        $this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('day', 'day', 'trim|required');
        $this->form_validation->set_rules('time', 'time', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data["status"] = "0";
            $data["message"] = strip_tags($this->form_validation->error_string());
        } else {
            $day = $this->input->post("day");
            
            $count_Sql  =   $this->db->query("SELECT count(tbl_product_schedule.schedule_id) as numt FROM tbl_product_schedule WHERE schedule_user_id='".$this->input->post("user_id")."'
                                        AND schedule_product_id ='".$this->input->post("product_id")."' AND schedule_status=1");
            $count_Sel  =   $count_Sql->row();                             
            if($count_Sel->numt <= 0){
                 $this->db->insert("tbl_product_schedule", array(
                    "schedule_user_id" => $this->input->post("user_id"),
                    "schedule_product_id" => $this->input->post("product_id"),
                    "schedule_product_qty" => $this->input->post("qty"),
                    "schedule_day" => $day,
                    "schedule_time" => $this->input->post("time"),
                    "schedule_status" => 1,
                    "crt_by" => 'App',
                    "crt_at" => date("Y-m-d H:i:s"),
                ));
                $last_insert_id= $this->db->insert_id();
            }
            else{
                $this->common_model->data_update(
                    "tbl_product_schedule", 
                    array(
                        "schedule_product_qty" => $this->input->post("qty"),
                        "schedule_day" => $day,
                        "schedule_time" => $this->input->post("time")
                    ), 
                    array(
                         "schedule_user_id" => $this->input->post("user_id"), 
                         "schedule_product_id" =>$this->input->post("product_id")
                    )
                );
            }
           
            $data["status"] = "1";
            $data["message"] = " Product Schedule Sucessfully..";
        }

        echo json_encode($data);

    }


    public function delete_product_schedule() {

        $data = array();
        $_POST = $_REQUEST;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        $this->form_validation->set_rules('schedule_id', 'Schedule Id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data["status"] = "0";
            $data["message"] = strip_tags($this->form_validation->error_string());
        } else {
            $user_id = $this->input->post("user_id");
            $schedule_id = $this->input->post("schedule_id");
            $update =  $this->db->query("update tbl_product_schedule set schedule_status = 0 where  schedule_id = '" . $schedule_id . "' AND schedule_user_id = '" . $user_id . "'");
            if($update){
                $data["status"] = "1";
            $data["message"] = " Product Schedule Delete Sucessfully..";
            }else{
               $data["status"] = "0";
            $data["message"] = " Product Schedule Not Delete Sucessfully..";
            }

        }

        echo json_encode($data);

    }
    
    
    private function checkUserStatus($user_data){
		if (empty($user_data)) {
			$data['_error'] = "Email & Password Not Valid";
			return $data;
		} elseif ($user_data['status'] == 0) {
			$data['_error'] = "Your A/C has been blocked By Admin";
			return $data;
		}else{
			$data['_success'] = 'Correct Credentials';
			return $data;
		}
	}

        /*cron job*/
    function order_schedule_again(){
        $date = date('Y-m-d');
        $today_day = date('w', strtotime($date));
        $note = "Schedule Product";
        $this->load->model("common_model");
        $schedule_detail = $this->db->query("select * from tbl_product_schedule");
        $sc_detail = $schedule_detail->result();
        foreach ($sc_detail as $k=>$value){
            $schedule_day       =   $value->schedule_day;
            $schedule_product   =   $value->schedule_product_id;
            $sc_userid          =   $value->schedule_user_id;
            $sc_qty             =   $value->schedule_product_qty;
            $schedule_status    =   $value->schedule_status;
            /*get product details*/
            $product_detail     =   $this->db->query("select * from products WHERE product_id =".$schedule_product);
            $pro_record         =   $product_detail->row();
            $pro_price          =   $pro_record->price;
            $total_amount       =   $pro_price*$sc_qty;
            /* END get product details*/

            /*get Last sale  details*/
            $sale_detail        =   $this->db->query("SELECT user_location.*, pincode.*, 
									CONCAT_WS(' ', user_location.house_no, user_location.landmark, user_location.city, user_location.state, pincode.pincode) as address   
                                    FROM user_location
                                    INNER JOIN pincode on pincode.pincode = user_location.pincode
                                    WHERE user_location.user_id = '".$sc_userid."' ORDER by location_id DESC  LIMIT 1");
            $sale_record        =   $sale_detail->row();

            /* END get sale details*/
            //echo $schedule_status; die;
            $schedule_days = json_decode($schedule_day);
            $day_array = array();
            foreach($schedule_days as $v){
                $timeArra   =   explode('-',$value->schedule_time);
                if($v == $today_day){
                    if($schedule_status == 1){
                        $data = array(
                            'user_id'               =>  $sc_userid,
                            'on_date'               =>  $date,
                            'delivery_time_from'    =>  $timeArra[0],
                            'delivery_time_to'      =>  $timeArra[1],
                            'status'                =>  0,
                            'note'                  =>  $note,
                            'is_paid'               =>  0,
                            'total_amount'          =>  $total_amount,
                            'total_rewards'         =>  $pro_record->rewards,
                            'total_kg'              =>  $pro_record->unit,
                            'total_items'           =>  1,
                            // 'socity_id'             =>  $sale_record->socity_id,
                            'delivery_address'      =>  $sale_record->address,
                            'location_id'           =>  $sale_record->location_id,
                            'delivery_charge'       =>  $sale_record->delivery_charge,
                            'new_store_id'          =>  $sale_record->store_id,
                            'assign_to'             =>  '',
                            'payment_method'        =>  "Cash On Delivery",
                            'signin_by'             =>  "App",
                            'by_orasuper'           =>  1,
                        );
                        $id = $this->common_model->data_insert("sale", $data);
                        //$this->db->query("UPDATE sale SET schedule_order = 0 WHERE sale_id =".$sale_id);

                        $itme_array = array(
                            'sale_id'       =>  $id,
                            'product_id'    =>  $schedule_product,
                            'product_name'  =>  $pro_record->product_name,
                            'qty'           =>  $sc_qty,
                            'unit'          =>  $pro_record->unit,
                            'unit_value'    =>  $pro_record->unit_value,
                            'price'         =>  $pro_record->price,
                            'qty_in_kg'     =>  $sc_qty,
                            'rewards'       =>  $pro_record->rewards,
                        );
                        $id_item = $this->common_model->data_insert("sale_items", $itme_array);

                    }

                }
                else{
                    ///echo "No Schedule";
                }

            }

        }

    }

    ////////////////// END Product Schedule ///////////////////////

    public function get_categories() {
        $parent = 0;
        if ($this->input->post("parent")) {
            $parent = $this->input->post("parent");
        }
        $categories = $this->get_categories_short($parent, 0, $this);
        $data["status"] = "1";
        $data["message"] = "Category List";
        $data["data"] = $categories;
        echo json_encode($data);
    }
    
    public function user_block_check(){
        $data   =   array('status' => 0, 'message' => 'User id is blank');
        if(!empty($this->input->post('user_id'))){
            $query  =   $this->db->query("SELECT * FROM `registers` WHERE user_id ='".$this->input->post('user_id')."'");
            if($query->num_rows() > 0){
                $datas  =   $query->row();
                if($datas->status == 1){
                    $data   =   array('status' =>2, 'message' => 'User is Active');
                }
                else{
                    $data   =   array('status' => 1, 'message' => 'User is Block');
                }
            }
            else{
                $data   =   array('status' => 0, 'message' => 'User id not available');
            }
        }
        echo json_encode($data);
    }
    
    public function topsix(){
      $topsix = $this->db->select('categories.title, CONCAT("category/",categories.image) as image, categories.description, categories.id, count(sale_items.pro_var_id) as count')
                   ->from('product_varient')
                  ->join ('products', 'product_varient.product_id = products.product_id')
                  ->join ('sale_items', 'product_varient.varient_id = sale_items.pro_var_id','Left') 
                  ->join ('categories', 'products.category_id = categories.id','Left')
                  ->group_by('categories.title', 'categories.image', 'categories.description','categories.cat_id')
                  ->order_by('categories.id','desc')
                  ->limit(6)
                  ->get();
        if($topsix->num_rows()>0){
        	$message = array('status'=>'1', 'message'=>'Top Six Categories', 'data'=>$topsix->result_array());
        //	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'Nothing in Top Six', 'data'=>[]);
        //	return $message;
        }   
        echo json_encode($message);
  }    
  
    public function getRewardPoint(){
        $q = $this->db->query("SELECT `point` FROM rewards");
        $result =   $q->row();
        return $result;
    }
	
	public function cron() {
		$refund_time_limit = $this->config->item('refund_time_limit');
        $reward_point_on_sale = $this->config->item('reward_point_on_sale');
		$reward_amount_on_sale = $this->config->item('reward_amount_on_sale');
		
		//$date_from = '2020-11-06';
		$date_to = $current_date = date('Y-m-d');
		$date_from = date('Y-m-d', strtotime('-2 months',  strtotime($date_to)));
		if(!empty($refund_time_limit) && $refund_time_limit > 0){
			$date_to = date('Y-m-d', strtotime('-'.$refund_time_limit.' Hours'));
			$date_from = date('Y-m-d', strtotime('-2 months',  strtotime($date_to)));
		}
		
		/*
		 *
		 * Rewards Cron
		 *
		 */
		
		
		
		$q = $this->db->query("Select * from delivered_order where on_date >= '".$date_from."' and on_date <= '".$date_to."' and sale_id not in(Select order_id from tbl_user_rewards where created_date >= '".$date_from."') ORDER BY sale_id DESC");
		$result =  $q->result_array();
		
		if(!empty($result)){
			foreach($result as $res){
				if(!empty($res['total_amount']) && !empty($this->config->item('is_reward'))){
					$total_point = 0;
					if(!empty($reward_point_on_sale) && !empty($reward_amount_on_sale)){
						$total_point = floor($res['total_amount']*$reward_point_on_sale/$reward_amount_on_sale);
						if(!empty($total_point) && !empty($res['user_id'])){
							$this->db->query("insert into tbl_user_rewards(order_id,user_id,point,status,created_date) values  ('".$res['sale_id']."','".$res['user_id']."','".$total_point."', '1','".$current_date."' )");
						}
					}
					
				}
			}
		}
		
		//echo '<pre>';
		//print_r($result);
		
		/*
		 *
		 * Referal Cron
		 *
		 */
		$company_referal = $this->config->item('company_referal');
        $sender_amount = $this->config->item('sender_amount');
		$created_date = date('Y-m-d H:i:s');
		
		
		$q = $this->db->query("Select DISTINCT do.user_id, r.user_rafale_code 
		from delivered_order do 
		left join registers r on(do.user_id=r.user_id)
		where do.on_date <= '".$date_to."' and r.get_reffrl_status = '0' and r.user_rafale_code !='' ORDER BY do.sale_id DESC");
		$result =  $q->result();
		
		if(!empty($result)){
			foreach($result as $res){
				$salf_user = $sender_user = [];
				$q = $this->db->query("Select * from registers where user_id >= '".$res->user_id."' and get_reffrl_status = '0'");
				$salf_user =  $q->row();
				$q = $this->db->query("Select * from registers where salf_rafale_code = '".$res->user_rafale_code."'");
				$sender_user =  $q->row();
				
				if(!empty($salf_user->user_id) && !empty($sender_user->user_id)){
					if(!empty($company_referal)){
						$this->db->query("insert into wallet_history(user_id, transaction_by, description, cr_id, created_date) values($salf_user->user_id, 'Referral', 'Credit By Referral', $company_referal, '$created_date')");
							
					}					
					
					if(!empty($sender_amount)){
						$this->db->query("insert into wallet_history(user_id, transaction_by, description, cr_id, created_date) values($sender_user->user_id, 'Referral', 'Credit By Referral', $sender_amount, '$created_date')");
					}
					
					$this->db->query("update registers set get_reffrl_status = 1 Where user_id  = '".$salf_user->user_id."' ");
				}
			}
		}
		
		
		//print_r($result);
		die;
         
        
    }
	
	
	public function get_rewards() {
		$data = array();
		$_POST = $_REQUEST;
		$this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$data["responce"]   = false;
            $data["message"]      = strip_tags($this->form_validation->error_string());
		}
		else{
			
			$user_id   = set_value('user_id'); 
			$q = $this->db->query("Select SUM(point) as total from tbl_user_rewards where user_id = '".$user_id."' and status = 1 ORDER BY id DESC");
			$res = $q->row_array();
			if(!empty($res['total'])){
				$reward = $res['total'];
			}
			$q = $this->db->query("Select * from tbl_rewards_history where user_id = '".$user_id."' ORDER BY id DESC");
			$reward_history = $q->result();
			
			
			$data["responce"]   = true;
			$data["is_reward"] = $this->config->item('is_reward');
			$data["reward_amount_on_sale"] = $this->config->item('reward_amount_on_sale');
			$data["reward_point_on_sale"] = $this->config->item('reward_point_on_sale');
			$data["reward_min_point_transfer"] = $this->config->item('reward_min_point_transfer');
			$data["reward_point_to_wallet"] = $this->config->item('reward_point_to_wallet');
			$data["reward_amount_to_wallet"] = $this->config->item('reward_amount_to_wallet');
			$data["reward"] = !empty($reward)? $reward : '0';
			$data["reward_history"] = !empty($reward_history)? $reward_history : [];
			
		}

        echo json_encode($data);
    }
    

	public function redeem_reward() {
        $data = array();
		$_POST = $_REQUEST;
		$this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$data["responce"]   = false;
            $data["message"]      = strip_tags($this->form_validation->error_string());
		}
		else{
			$reward = 0;
			$user_id   = set_value('user_id'); 
			$reward_min_transfer = $this->config->item('reward_min_point_transfer');
			$q = $this->db->query("Select SUM(point) as total from tbl_user_rewards where user_id = '".$user_id."' and status = 1 ORDER BY id DESC");
			$res = $q->row_array();
			if(!empty($res['total'])){
				$reward = $res['total'];
			}
			if(!empty($reward)){ 
				if(!empty($reward_min_transfer) && $reward_min_transfer < $reward){ 
						$reward_point_to_wallet = $this->config->item('reward_point_to_wallet');
						$reward_amount_to_wallet = $this->config->item('reward_amount_to_wallet');
						if(!empty($reward_amount_to_wallet) && !empty($reward_point_to_wallet)){
							$total_amount = $reward*$reward_amount_to_wallet/$reward_point_to_wallet;
							$created_date = date('Y-m-d H:i:s');
							$this->db->query("insert into tbl_rewards_history(point,amount,user_id,created_date) values  ('".$reward."','".$total_amount."','".$user_id."','".$created_date."')");

							$description_msg_wallet = "'Credit By Reward'";
							$this->db->query("insert into wallet_history(user_id, transaction_by, description, cr_id, created_date) values($user_id, 'Reward', $description_msg_wallet, $total_amount, '$created_date')");
							$this->db->query("update registers set wallet = wallet +".$total_amount." Where user_id  = '".$user_id."' ");
							$this->db->query("update tbl_user_rewards set status = 2 Where user_id  = '".$user_id."' ");
							

							$data["responce"]   = true;
							$data["message"]    = 'successfully redeem reward points.';
							
						}
						else{
							$data["responce"]   = false;
							$data["message"]    = 'Redeem setting does not set.';
						}
						
				}
				else{
					$data["responce"]   = false;
					$data["message"]    = 'Reward point is less then to min limit.';
				}
			}else{
				$data["responce"]   = false;
				$data["message"]    = 'You do not have any reward points.';
			}
          
		}
		
		
		echo json_encode($data);
		
    }	
	
    public function get_categories_short($parent, $level, $th) {
        $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                         LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                         WHERE a.`parent`=" . $parent." AND status=1");

        $return_array = array();

        foreach ($q->result() as $row) {
            if ($row->Count > 0) {
                $sub_cat = $this->get_categories_short($row->id, $level + 1, $th);
                $row->sub_cat = $sub_cat;
            } elseif ($row->Count == 0) {
                $row->sub_cat = array();
            }
            $row->url     = $this->uploadurl().'category/';
            $return_array[] = $row;
        }
        return $return_array;
    }

    public function pincode() {
        $q = $this->db->query("Select * from pincode");
        echo json_encode($q->result());
    }
    // Cheak Phone number
    public function check_phone_num($phone_no) {
		$result = $this->my_model->dbRowCount('registers','WHERE user_phone="'.$phone_no.'"');
		if($result == 0) {
			$response = true;
		}else {
			$this->form_validation->set_message('check_phone_num', 'Phone Number is Already Taken');
			$response = false;
		}
		return $response;
	}
    /* user registration */
    public function sendReigstrationOtp(){
		//		$this->getPostData();
		$this->form_validation->set_rules('user_mobile', 'Mobile no', 'trim|required|min_length[10]|max_length[10]|callback_check_phone_num');
		if ($this->form_validation->run() == FALSE) {
			$data = strip_tags($this->form_validation->error_string());
			echo json_encode(array('status' =>"0",'data'=>$data,'message'=>$data ));
		}
		else{
		    $user_phone = $this->input->post('user_mobile');
    		$rand_number = rand(1000,9999);
    		$appname      = $this->appName();
    	//	print_r($appArr); exit;
    		//$appname     = explode('@@@',$appArr);
    		$msg= '<#>OTP For '.$this->config->item('name').'  is '.$rand_number .' and valid for the next 30 minutes';
    		$this->sendsmsPOST($user_phone,$msg);
    		$user_otp_array = array('user_phone_number'=>$user_phone,'user_otp'=>$rand_number,'updated_at'=>date('Y-m-d H:i:s'));
    		$data_count = $this->my_model->dbRowCount('tbl_user_otp','WHERE user_phone_number="'.$user_phone.'"');
    		if($data_count == 0){
    			$this->my_model->dbRowInsert('tbl_user_otp',$user_otp_array);
    		}else{
    			$this->my_model->dbRowUpdate('tbl_user_otp',$user_otp_array,'WHERE user_phone_number="'.$user_phone.'"');
    		}
    //		$this->session->set_userdata('user_otp',$rand_number);
    //		$this->session->set_userdata('user_phone',$user_phone);
    		$result = array(
    			'user_phone' => $user_phone
    		);
    		$data  = array("status" => "1",
    		                "data" => $result,
                    		"message" => 'Your OTP is Send Successfully');
		}
		echo json_encode($data);

	}
	/////////////// Send Forget Password Otp ///////////////
	public function sendOtp(){
		//		$this->getPostData();
		$this->form_validation->set_rules('user_mobile', 'User Phone Number', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$data = strip_tags($this->form_validation->error_string());
		    echo json_encode(array('status' =>"0",'data'=>$data,'message'=>$data ));
		}
		else{
		    $user_mobile = $this->input->post('user_mobile');
    		$user_data_array = array('*');
    		$result = $this->my_model->dbRowSelectAll('registers',$user_data_array,'WHERE user_phone="'.$user_mobile.'"');
    
    		//		$result = explode(' ^@^ ',$result_data);
    //				print_r($result);exit;
    		if (empty($result)){
    		    	$data = array('status' =>"0",'data'=>"Invalid Phone",'code'=>'error_invalid_user','message'=>"Invalid  Phone Entered" );
    		}
    		$user_status = $this->checkUserStatus($result);
    		//		print_r($user_status);exit;
    		if (array_key_exists('_error', $user_status)){
    		    $data = array('status' =>"0",'data'=>$user_status['_error'],'code'=>'error_user_status','message'=>$user_status['_error']);
    		}else {
    			$rand_number = rand(1000,9999);
    			$appArr      = $this->appName();
        		$appname     = explode('@@@',$appArr);
        		$msg= '<#>OTP For '.$appname[0].' is '.$rand_number .' and  valid for the next 30 minutes';
    			$this->sendsmsPOST($result['user_phone'],$msg);
    			$user_otp_array = array('user_phone_number'=>$result['user_phone'],'user_otp'=>$rand_number,'updated_at'=>date('Y-m-d H:i:s'));
    			$data_count = $this->my_model->dbRowCount('tbl_user_otp','WHERE user_phone_number='.$result['user_phone']);
    			if($data_count == 0){
    				$this->my_model->dbRowInsert('tbl_user_otp',$user_otp_array);
    			}else{
    				$this->my_model->dbRowUpdate('tbl_user_otp',$user_otp_array,'WHERE user_phone_number='.$result['user_phone']);
    			}
    			$data = array('status' =>"1",'data'=>$result['user_phone'],'code'=>'otp_send','message'=>"Your OTP is Send Successfully");
		    }
			//return $this->json_out($result, TRUE,'otp_send','Your OTP is Send Successfully',$result['uni_id']);
		}
		 echo json_encode($data);
	}

    public function signup() {
        $data = array();
        $_POST = $_REQUEST;

        $this->load->model("users_model");
        $this->load->library('form_validation');
        /* add registers table validation */
        $this->form_validation->set_rules('user_rafale_code', 'Rafale Code', 'trim');
        $this->form_validation->set_rules('user_name', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required|regex_match[/^[0-9]{10}$/]|is_unique[registers.user_phone]');
        $this->form_validation->set_rules('user_email', 'User Email', 'trim|is_unique[registers.user_email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        //$this->form_validation->set_rules('user_otp', 'User Otp', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data["responce"]   = false;
            $data["message"]      = strip_tags($this->form_validation->error_string());
        } else {
           //if($this->my_model->chekOtp($this->input->post("user_mobile"), $this->input->post("user_otp"))){
                $date               = date('d/m/y');
                $user_rafale_code   = set_value('user_rafale_code'); //$this->input->post("user_rafale_code");
                $id                 = null;
                $salf_rafale_point  = 0;
                $salf_wallet        = 0;
                $result_rew =   $this->db
                                ->select('user_id')
                                ->select('salf_rafale_point')
                                ->select('wallet')
                                ->where('salf_rafale_code', $user_rafale_code)
                                ->limit(1)
                                ->get('registers')
                                ->row();
                if (empty($result_rew) && !empty($user_rafale_code)) {
                    $data["responce"]   = false;
                    $data["message"]      = strip_tags("Refer Code Invalid");
                    echo json_encode($data);
                    return FALSE;
                } else {
                    $this->db->insert("registers", array(
                        "salf_rafale_code"  => $this->random_code(6),
                        "user_rafale_code"  => $user_rafale_code,
                        "user_phone"        => $this->input->post("user_mobile"),
                        "user_fullname"     => $this->input->post("user_name"),
                        "user_email"        => $this->input->post("user_email"),
                        "user_password"     => md5($this->input->post("password")),
                        "created_by"        => 'App',
                        "created_at"        => date("Y-m-d H:i:s"),
                        "status"            => 1,
                        "mobile_verified"   => 1
                    ));
                    $user_id = $this->db->insert_id();
                    $data["responce"] = true;
                    $data["message"]  = "User Register Sucessfully..";
                }
            // }
            // else{
            //     $data["responce"] = false;
            //     $data["message"]  = "Otp does not match !!";
            // }
            
        }
        echo json_encode($data);
    }

    public function signup_old() {
        $data = array();
        $_POST = $_REQUEST;
        $this->load->library('form_validation');
        /* add registers table validation */
        $this->form_validation->set_rules('user_name', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required|is_unique[registers.user_phone]');
        $this->form_validation->set_rules('user_email', 'User Email', 'trim|required|is_unique[registers.user_email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        } else {

            $date = date('d/m/y');
            $this->db->insert("registers", array("user_phone" => $this->input->post("user_mobile"),
                "user_fullname" => $this->input->post("user_name"),
                "user_email" => $this->input->post("user_email"),
                "user_password" => md5($this->input->post("password")),
                "status" => 1
            ));
            $user_id = $this->db->insert_id();
            $data["responce"] = true;
            $data["message"] = "User Register Sucessfully..";
        }

        echo json_encode($data);
    }
     /* user login json */

    public function login() {
        $data = array();
        $_POST = $_REQUEST;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('user_password', 'User Password', 'trim|required');
        //$this->form_validation->set_rules('user_otp', 'Otp', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        } else {
           // if($this->my_model->chekOtp($this->input->post("user_mobile"), $this->input->post("user_otp"))){
                //users.user_email='".$this->input->post('user_email')."' or
                $q = $this->db->query("Select * from registers where(user_phone='" . $this->input->post('user_mobile') . "' AND user_password='" . md5($this->input->post('user_password')) . "' ) Limit 1");
                if ($q->num_rows() > 0) {
                    $row = $q->row();
                    if ($row->status == "0") {
                        $data["responce"] = false;
                        $data["message"] = 'Your account currently inactive.Please Contact Admin';
                    } else {
                        $update         =   $this->db->query("UPDATE registers SET user_gcm_code ='".$this->input->post('user_gcm_code')."' WHERE user_id='".$row->user_id."'");
                        $data["responce"] = true;
                        $data["message"]  = "Successfully Login !!";
                        $data["data"]   = array(
                                                "user_id"           => $row->user_id,
                                                "user_fullname"     => $row->user_fullname,
                                                "user_email"        => $row->user_email,
                                                "user_phone"        => $row->user_phone,
                                                "mobile_verified"   => $row->mobile_verified,
                                                "user_image"        => $row->user_image,
                                                "wallet"            => $row->wallet,
                                                "rewards"           => $row->rewards,
                                                'referral_code'     => $row->salf_rafale_code,
                                                'user_gcm_code'     => $this->input->post('user_gcm_code') 
                                            );
                    }
                } else {
                    $data["responce"] = false;
                    $data["message"] = 'Invalide Username or Passwords';
                }
            // }
            // else{
            //         $data["responce"] = false;
            //         $data["message"] = 'Invalide Otp';
            //     }
        }
        echo json_encode($data);
    }

    public function chekuser() {
        $data = array();
        $_POST = $_REQUEST;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|required|regex_match[/^[0-9]{10}$/]');

        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        } else {
           // if($this->my_model->chekOtp($this->input->post("user_mobile"), $this->input->post("user_otp"))){
                //users.user_email='".$this->input->post('user_email')."' or
                $q = $this->db->query("Select * from registers where user_phone='" . $this->input->post('user_mobile') . "' Limit 1");
                if ($q->num_rows() > 0) {
                    $data["responce"] = true;
                    $data["message"]  = "User exists!!";
                } else {
                    $data["responce"] = false;
                    $data["message"] = 'Invalide User';
                }
            
        }
        echo json_encode($data);
    }

    /* user login json */
	public function facebook_login() {
		$data = array();
		$_POST = $_REQUEST;
         $this->load->library('form_validation');
        /* add users table validation */
        $this->form_validation->set_rules('id', 'Oauth ID', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } 
		else {
			// User logged in, get user details
			$userInfo = $this->input->post(); 
			if(!empty($userInfo)){
				$email_already = $this->db->where('user_email', $userInfo['email'])->get('registers')->row();
				if(!empty($email_already->user_id)){
					if(empty($email_already->facebook_oauth)){
						$userUpdate['facebook_oauth']    = !empty($userInfo['id'])?$userInfo['id']:''; 
						$this->db->update('registers',$userUpdate,array('user_id' => $email_already->user_id));
					}
					$userID = $email_already->user_id;
				}
				else{
					$user_oauth = $this->db->where('facebook_oauth', $userInfo['id'])->get('registers')->row();
					if(!empty($user_oauth->user_id)){
						$userID = $user_oauth->user_id;
					}
					else{
						// Preparing data for database insertion 
						$userData['facebook_oauth']    = !empty($userInfo['id'])?$userInfo['id']:''; 
						$userData['user_fullname']    = !empty($userInfo['name'])?$userInfo['name']:''; 
						$userData['user_email']        = !empty($userInfo['email'])?$userInfo['email']:''; 
						// $userData['first_name']    = !empty($userInfo['first_name'])?$userInfo['first_name']:''; 
						// $userData['last_name']    = !empty($userInfo['last_name'])?$userInfo['last_name']:''; 
						// $userData['gender']        = !empty($userInfo['gender'])?$userInfo['gender']:''; 
						// $userData['picture']    = !empty($userInfo['picture']['data']['url'])?$userInfo['picture']['data']['url']:''; 
						// $userData['link']        = !empty($userInfo['link'])?$userInfo['link']:'https://www.facebook.com/'; 
						 
						// Insert or update user data to the database 
						$this->db->insert("registers", $userData);
						$userID = $this->db->insert_id(); 
					}
				}
				// Check user data insert or update status 
				if(!empty($userID)){ 
					$user_info = $this->db->where('user_id', $userID)->get('registers')->row();
					
					$data["responce"] = true;
					$data["message"]  = "Successfully Login !!";
					$data["data"]   = array(
											"user_id"           => $user_info->user_id,
											"user_fullname"     => $user_info->user_fullname,
											"user_email"        => $user_info->user_email,
											"user_phone"        => $user_info->user_phone,
											"mobile_verified"   => $user_info->mobile_verified,
											"user_image"        => $user_info->user_image,
											"wallet"            => $user_info->wallet,
											"rewards"           => $user_info->rewards,
											'referral_code'     => !empty($user_info->salf_rafale_code)? $user_info->salf_rafale_code : '',
											'user_gcm_code'     => $user_info->user_gcm_code,
										);
					
					
				}
				else{
					$data["responce"] = false;
                    $data["message"] = 'Something Went Wrong';
					
				}
             
            }
			

		}
		
        echo json_encode($data);
    }

    /* user login json */
	public function google_login() {
		$data = array();
		$_POST = $_REQUEST;
         $this->load->library('form_validation');
        /* add users table validation */
        $this->form_validation->set_rules('id', 'Oauth ID', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } 
		else {
			// User logged in, get user details
			$userInfo = $this->input->post(); 
			if(!empty($userInfo)){
				$email_already = $this->db->where('user_email', $userInfo['email'])->get('registers')->row();
				if(!empty($email_already->user_id)){
					if(empty($email_already->google_oauth)){
						$userUpdate['google_oauth']    = !empty($userInfo['id'])?$userInfo['id']:''; 
						$this->db->update('registers',$userUpdate,array('user_id' => $email_already->user_id));
					}
					$userID = $email_already->user_id;
				}
				else{
					$user_oauth = $this->db->where('google_oauth', $userInfo['id'])->get('registers')->row();
					if(!empty($user_oauth->user_id)){
						$userID = $user_oauth->user_id;
					}
					else{
						// Preparing data for database insertion 
						$userData['google_oauth']    = !empty($userInfo['id'])?$userInfo['id']:''; 
						$userData['user_fullname']    = !empty($userInfo['name'])?$userInfo['name']:''; 
						$userData['user_email']        = !empty($userInfo['email'])?$userInfo['email']:''; 
						// $userData['first_name']    = !empty($userInfo['first_name'])?$userInfo['first_name']:''; 
						// $userData['last_name']    = !empty($userInfo['last_name'])?$userInfo['last_name']:''; 
						// $userData['gender']        = !empty($userInfo['gender'])?$userInfo['gender']:''; 
						// $userData['picture']    = !empty($userInfo['picture']['data']['url'])?$userInfo['picture']['data']['url']:''; 
						// $userData['link']        = !empty($userInfo['link'])?$userInfo['link']:'https://www.facebook.com/'; 
						 
						// Insert or update user data to the database 
						$this->db->insert("registers", $userData);
						$userID = $this->db->insert_id(); 
					}
				}
				// Check user data insert or update status 
				if(!empty($userID)){ 
					$user_info = $this->db->where('user_id', $userID)->get('registers')->row();
					
					$data["responce"] = true;
					$data["message"]  = "Successfully Login !!";
					$data["data"]   = array(
											"user_id"           => $user_info->user_id,
											"user_fullname"     => $user_info->user_fullname,
											"user_email"        => $user_info->user_email,
											"user_phone"        => $user_info->user_phone,
											"mobile_verified"   => $user_info->mobile_verified,
											"user_image"        => $user_info->user_image,
											"wallet"            => $user_info->wallet,
											"rewards"           => $user_info->rewards,
											'referral_code'     => !empty($user_info->salf_rafale_code)? $user_info->salf_rafale_code : '',
											'user_gcm_code'     => $user_info->user_gcm_code,
										);
					
					
				}
				else{
					$data["responce"] = false;
                    $data["message"] = 'Something Went Wrong';
					
				}
             
            }
			

		}
		
        echo json_encode($data);
    }

    public function update_profile_pic() {
        $data = array();
        $this->load->library('form_validation');
        /* add users table validation */
        $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
            $name        =   $this->input->post('username');
            $email       =   $this->input->post('email');
            $dataIns     =   array();
            if(!empty($this->input->post('username'))){
                $dataIns['user_fullname']  =   $this->input->post('username');
            }
             if(!empty($this->input->post('email'))){
                $dataIns['user_email']  =   $this->input->post('email');
            }
            
            
            //$url        =   $this->uploadurl().'profile/';
            if (isset($_FILES["image"]) && $_FILES["image"]["size"] > 0) {
                $config['upload_path'] = './uploads/profile/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    $data["responce"] = false;
                    $data["message"] = 'Error! : ' . $this->upload->display_errors();
                } else {
                    $img_data = $this->upload->data();
                    $dataIns['user_image']  =   $img_data['file_name'];
                   // $url    =   $url.$img_data['file_name'];
                }
                

            }
            
            
            
            $this->load->model("common_model");
            $this->common_model->data_update("registers", $dataIns, array("user_id" => $this->input->post("user_id")));

            $data["responce"] = true;
            $data["data"] = !empty($img_data['file_name']) ? $img_data['file_name'] : 'admin.png';
            $data["url"] = $this->uploadurl().'profile/';

        }

        echo json_encode($data);
    }

    public function change_password() {
        $data = array();
        $this->load->library('form_validation');
        /* add users table validation */
        $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
        $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        } else {
            $this->load->model("common_model");
            $q = $this->db->query("select * from registers where user_id = '" . $this->input->post("user_id") . "' and  user_password = '" . md5($this->input->post("current_password")) . "' limit 1");
            $user = $q->row();

            if (!empty($user)) {
                $this->common_model->data_update("registers", array(
                    "user_password" => md5($this->input->post("new_password"))
                        ), array("user_id" => $user->user_id));

                $data["responce"] = true;
                 $data["message"] = 'Successfully Change Password';
            } else {
                $data["responce"] = false;
                $data["message"] = 'Current password do not match';
            }
        }

        echo json_encode($data);
    }

    public function update_userdata() {
        $data = array();
        $this->load->library('form_validation');
        /* add users table validation */
        $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
        $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('user_email', 'User Email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('address', 'address', 'trim');
        $this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|required|regex_match[/^[0-9]{10}$/]');


        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
            $insert_array = array(
                "user_fullname" => $this->input->post("user_fullname"),
                "user_phone" => $this->input->post("user_mobile")
            );

            $this->load->model("common_model");
            //$this->db->where(array("user_id",$this->input->post("user_id")));
            if (isset($_FILES["image"]) && $_FILES["image"]["size"] > 0) {
                $config['upload_path'] = './uploads/profile/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {
                    $data["responce"] = false;
                    $data["message"] = 'Error! : ' . $this->upload->display_errors();
                } else {
                    $img_data = $this->upload->data();
                    $image_name = $img_data['file_name'];
                    $insert_array["user_image"] = $image_name;
                }
            }

            $this->common_model->data_update("registers", $insert_array, array("user_id" => $this->input->post("user_id")));

            $q = $this->db->query("Select * from `registers` where(user_id='" . $this->input->post('user_id') . "' ) Limit 1");
            $row = $q->row();
            $imageurl  =  $this->uploadurl().'profile/';
            $data["responce"] = true;
            $data["data"] = array("user_id" => $row->user_id, "user_fullname" => $row->user_fullname, "user_email" => $row->user_email, "user_phone" => $row->user_phone, "user_image" => $row->user_image, "pincode" => $row->pincode, "socity_id" => $row->socity_id, "house_no" => $row->house_no,'url'=>$imageurl);
        }

        echo json_encode($data);
    }

   

    public function share_msg() {
        $refer = $this->input->post('refer');
        //$str = "Hi friends, I am using OraFresh https://play.google.com/store/apps/details?id=com.kriscent.basket2home for the online shopping. Please do signup by mine refer ID: $refer. And get referral bonus.";
        //$str = "Hi friends, Visit on https://play.google.com/store/apps/details?id=com.kriscent.basket2home and get exciting deal, offers and free home delivery, get also ₹10 in your wallet on every share and download of the app.
        $app_path = $this->live_app_path;
        $rewards  = $this->getRewardPoint()->point;
        $str = "Hi friends, Visit on $app_path and get exciting deal, offers and free home delivery, get also ₹".$rewards." in your wallet on every share and download of the app.
        refer ID : $refer";
        $data = array(
            'share_msg' => $str//'Hi, I am Robin Kumar Sharma : ' .$refer
        );
        //return "";
        echo json_encode($data);
    }

    public function login_new() {
        $data = array();
        $_POST = $_REQUEST;
        $this->load->library('form_validation');
//        $this->form_validation->set_rules('user_email', 'Email Id', 'trim|required');
//        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        //$this->form_validation->set_rules('user_email', 'Email Id', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('user_phone', 'Mobile No.', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        } else {
            //users.user_email='".$this->input->post('user_email')."' or
            /* $sql = "Select * from registers where
              (user_email='" . $this->input->post('user_email')
              . "' ) and user_password='" . md5($this->input->post('password'))
              . "' Limit 1";
             */
            $sql = "Select * from registers where
                    (user_phone='" . $this->input->post('user_phone')
                    . "' ) and user_password='" . md5($this->input->post('password'))
                    . "' Limit 1";
            $q = $this->db->query($sql);

            if ($q->num_rows() > 0) {
                $row = $q->row();
                if ($row->status == "0") {
                    $data["responce"] = false;
                    $data["message"] = 'Your account currently inactive.Please Contact Admin';
                    $data["error_arb"] = 'حسابك غير نشط حاليًا. الرجاء الاتصال بالمسؤول';
                } else {
                    $data["responce"] = true;
                    $data["data"] = array("user_id" => $row->user_id,
                        "user_fullname" => $row->user_fullname,
                        "user_email" => $row->user_email,
                        "user_phone" => $row->user_phone,
                        "mobile_verified" => $row->mobile_verified,
                        "user_image" => $row->user_image,
                        "wallet" => $row->wallet,
                        "rewards" => $row->rewards,
                        "salf_rafale_code" => $row->salf_rafale_code
                    );
                }
            } else {
                $data["responce"] = false;
                $data["message"] = 'Invalide Username or Passwords';
                $data["error_arb"] = 'اسم المستخدم أو كلمة المرور غير صالحة';
            }
        }
        echo json_encode($data);
    }

    function city() {
        $q = $this->db->query("SELECT * FROM `socity`");
        $city["response"] = false;
        if(count($q->result()) > 0){
            $city["city"] = $q->result();
            $city["response"] = true;
        }
        echo json_encode($city);
    }

    function store() {
        $data = array();
        $_POST = $_REQUEST;
        $getdata = $this->input->post('city_id');
        if ($getdata != '') {
            $q = $this->db->query("Select user_fullname ,user_id FROM `users` where (user_city='" . $this->input->post('city_id') . "')");
            $data["data"] = $q->result();
            echo json_encode($data);
        } else {
            $data["data"] = "Error";
            echo json_encode($data);
        }
    }

    function get_productByIds() {
        if (empty($this->input->post("product_ids"))) {
            $data["responce"] = FALSE;
            $data['data'] = array();
            echo json_encode($data);
        } else {
            $productIds = $this->input->post("product_ids");
            /*
              $datas = $this->db->query("Select dp.*,products.*,
              products.mrp - products.price as difference_price,
              ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products
              inner join categories on categories.id = products.category_id
              left outer join(select SUM(qty) as c_qty,product_id from sale_items INNER JOIN sale on sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = products.product_id
              left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
              left join deal_product dp on dp.product_id=products.product_id where 1
              AND products.in_stock = 1
              AND products.trash = 0
              AND FIND_IN_SET(products.product_id, '$productIds');");
             * 
             */
            $filter = " and products.in_stock = 1 ";
            $filter .= "AND FIND_IN_SET(products.product_id, '$productIds')";
            $sql = "Select dp.*,products.*, product_varient.varient_id, product_varient.price as var_price, product_varient.qty, product_varient.unit,
            product_varient.stock_inv, product_varient.tax, product_varient.mrp as var_mrp,product_varient.pro_var_images,
                products.mrp - products.price as difference_price,
                ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
            inner join categories on categories.id = products.category_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items INNER JOIN sale on sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            left join deal_product dp on dp.product_id=products.product_id where 1 AND products.trash = 0 
            LEFT JOIN product_varient ON product_varient.varient_id =  dp.pro_var_id  AND product_varient.product_id = products.product_id " . $filter;
            //var_dump($sql);
            $q = $this->db
                    //->where('products.trash',0)
                    ->query($sql);
            $products = $q->result();
            $data["responce"] = true;
            //$datas = $this->product_model->get_products(TRUE, $cat_id, $search, $this->input->post("page"));
            foreach ($products as $product) {
                $present = date('m/d/Y h:i:s a', time());
                $date1 = $product->start_date . " " . $product->start_time;
                $date2 = $product->end_date . " " . $product->end_time;

                if (strtotime($date1) <= strtotime($present) && strtotime($present) <= strtotime($date2)) {

                    if (empty($product->deal_price)) {   ///Runing
                        $price = $product->price;
                    } else {
                        $price = $product->deal_price;
                    }
                } else {
                    $price = $product->price; //expired
                }
                $product_image  =   explode(',',$product->product_image);
                $image          =   array();
                if (in_array(2, $product_image)) {
                    foreach($product_image as $images){
                        $image[]    =   $this->uploadurl().'products/'.$images;
                    }
                } else {
                  $image[]    =   $this->uploadurl().'products/'.$product_image[0];
                }
                                
                $product_call       =   $product->product_call == 1 ? $this->baseurl().'assets/images/swadeshi.png' : ''; 
                if($product->product_type == 1){
                    $title          =   "Vegetarian";
                }
                elseif($product->product_type == 2){
                    $title          =   "Non Vegetarian";
                }
                else{
                    $title          =   "";
                }
                $data['data'][] = array(
                    'product_id'                => $product->product_id,
                    'product_name'              => $product->product_name,
                    'product_name_arb'          => $product->product_arb_name,
                    'product_description_arb'   => $product->product_arb_description,
                    'category_id'               => $product->category_id,
                    'brand_id'                  => !empty($product->brand_id) ? $product->brand_id : 0,
                    'product_description'       => $product->product_description,
                    'veg'                       => $title,
                    'swadesi'                   => $product_call,
                    'deal_price'                => '',
                    'start_date'                => "",
                    'start_time'                => "",
                    'end_date'                  => "",
                    'end_time'                  => "",
                    //'difference_price'        => $product->difference_price,
                    'difference_price'          => number_format((float) $product->difference_price, 2, '.', ''),
                    'price'                     => $price,
                    'mrp'                       => $product->mrp,
                    'product_image'             => $product_image[0],
                    //'tax'                     =>  $product->tax,
                    'status'                    => '0',
                    'in_stock'                  => $product->in_stock,
                    'unit_value'                => $product->unit_value,
                    'unit'                      => $product->unit,
                    'increament'                => $product->increament,
                    'rewards'                   => $product->rewards,
                    'stock'                     => $product->stock_inv,
                    'title'                     => $product->title,
                    'url'                       => $this->uploadurl().'products/',
                    'images_arr'                => $image
                );
            }
            echo json_encode($data);
        }
    }

    function get_products() {
        $this->load->model("product_model");
        $cat_id = "";
        if ($this->input->post("cat_id")) {
            $cat_id = $this->input->post("cat_id");
        }
        $search = $this->input->post("search");

        $data["responce"] = true;
        $datas = $this->product_model->get_products(TRUE, $cat_id, $search, $this->input->post("page"));
        //print_r( $datas);exit();
        foreach ($datas as $product) {
            $varient    =   $this->product_model->getProductVarient($product->product_id);
            $present = date('m/d/Y h:i:s a', time());
            $date1 = $product->start_date . " " . $product->start_time;
            $date2 = $product->end_date . " " . $product->end_time;

            if (strtotime($date1) <= strtotime($present) && strtotime($present) <= strtotime($date2)) {

                if (empty($product->deal_price)) {   ///Runing
                    $price = $product->price;
                } else {
                    $price = $product->deal_price;
                }
            } else {
                $price = $product->price; //expired
            }
            
            if($product->product_type == 1){
                $title          =   "Vegetarian";
            }
            elseif($product->product_type == 2){
                $title          =   "Non Vegetarian";
            }
            else{
                $title          =   "";
            }
            
            $product_image  =   explode(',',$product->product_image);
            $image          =   array();
            if (in_array(2, $product_image)) {
                foreach($product_image as $images){
                    $image[]    =   $this->uploadurl().'products/'.$images;
                }
            } else {
              $image[]    =   $this->uploadurl().'products/'.$product_image[0];
            }
                            
            $product_call       =   $product->product_call == 1 ? $this->baseurl().'assets/images/swadeshi.png' : '';  
            

            $data['data'][] = array(
                'product_id'                => $product->product_id,
                'product_name'              => $product->product_name,
                'product_name_arb'          => $product->product_arb_name,
                'product_description_arb'   => $product->product_arb_description,
                'category_id'               => $product->category_id,
                'brand_id'                  => !empty($product->brand_id) ? $product->brand_id : 0,
                'product_description'       => $product->product_description,
                'deal_price'                => '',
                'start_date'                => "",
                'start_time'                => "",
                'end_date'                  => "",
                'end_time'                  => "",
                //'difference_price' => $product->difference_price,
                'difference_price'          => number_format((float) $product->difference_price, 2, '.', ''),
                'price'                     => $price,
                'mrp'                       => $product->mrp,
                'product_image'             => $product->product_image,
                'images_arr'                => $image,
                //'tax'=>$product->tax,
                'status'                    => '0',
                'in_stock'                  => $product->in_stock,
                'unit_value'                => $product->unit_value,
                'unit'                      => $product->unit,
                'increament'                => $product->increament,
                'rewards'                   => $product->rewards,
                'stock'                     => $product->stock_inv,
                'title'                     => $product->title,
                'url'                       => $this->uploadurl().'products/',
                'veg'                       => $title,
                'swadesi'                   => $product_call,
                'varient'                   => $varient
            );
        }




        echo json_encode($data);
    }

    function get_products_suggestion() {
        $this->load->model("product_model");
        $cat_id     =   "";
        $barnd_id   =   "";
        $product_id =   '';
        if ($this->input->post("cat_id")) {
            $cat_id     = $this->input->post("cat_id");
        }
        if ($this->input->post("barnd_id")) {
            $barnd_id   = $this->input->post("barnd_id");
        }
        if ($this->input->post("product_id")) {
            $product_id   = $this->input->post("product_id");
        }
        $search = $this->input->post("search");
        $user_id = $this->input->post("user_id");

        //$data["responce"] = true;  
        $datas = $this->product_model->get_products_suggestion(false, $cat_id, $search, $this->input->post("page"), $barnd_id, $product_id);
        //print_r($datas); exit;
        if(!empty($datas)){
            foreach ($datas as $product) {
                $present = date('m/d/Y h:i:s a', time());
                //print_r($product); exit;
                $varient     =   $this->product_model->getProductVarient($product->product_id);
                $varients   =   array();
                foreach($varient as $rowvarient){
                    $prices   = 0;
                    $date3 = $rowvarient->start_date . " " . $rowvarient->start_time;
                    $date4 = $rowvarient->end_date . " " . $rowvarient->end_time;
                    if (strtotime($date3) <= strtotime($present) && strtotime($present) <= strtotime($date4)) {
    
                        if(empty($rowvarient->deal_price)) {   ///Runing
                            $prices = $rowvarient->price;
                        } else {
                            $prices = $rowvarient->deal_price;
                        }
                    } else {
                        $prices = $rowvarient->price; //expired
                    }

                    $varients[]   =   array(
                                            "varient_id"    =>  $rowvarient->varient_id,
                                            "product_id"    =>  $rowvarient->product_id,
                                            "price"         =>  $prices,
                                            "qty"           =>  $rowvarient->qty,
                                            "unit"          =>  $rowvarient->unit,
                                            "stock_inv"     =>  $rowvarient->stock_inv,
                                            "tax"           =>  $rowvarient->tax,
                                            "mrp"           =>  $rowvarient->mrp,
                                            "date"          =>  $rowvarient->date,
                                            "description"   =>  $rowvarient->description,
                                            "store"         =>  $rowvarient->description,
                                            "store_id_login"=>  $rowvarient->store_id_login,
                                            "trash"         =>  $rowvarient->trash,
                                            "flavor"        =>  $rowvarient->flavor,
                                            "pro_var_images"=>  $this->uploadurl().'products/'.$rowvarient->pro_var_images,
                                        );
                    
                }
                                
                
                $date1 = $product->start_date . " " . $product->start_time;
                $date2 = $product->end_date . " " . $product->end_time;
    
                if (strtotime($date1) <= strtotime($present) && strtotime($present) <= strtotime($date2)) {
                    // Price
                    if (empty($product->deal_price)) {   ///Runing
                        if(empty($product->price)){
                            $price = $varient[0]->price;
                        }
                        else{
                            $price = $product->price;
                        }
                        
                    } else {
                        
                        $price = $product->deal_price;
                    }
                } else {
                    if(empty($product->price)){
                        $price = $varient[0]->price;
                    }
                    else{
                        $price = $product->price;
                    }
                     //expired
                }
                // MRP
                if(empty($product->mrp)){
                    $mrp = $varient[0]->mrp;
                }
                else{
                    $mrp = $product->mrp;
                }
                
                if($product->product_type == 1){
                    $title          =   "Vegetarian";
                }
                elseif($product->product_type == 2){
                    $title          =   "Non Vegetarian";
                }
                else{
                    $title          =   "";
                }
                
                $product_image  =   explode(',',$product->product_image);
                $image          =   array();
                if (is_array($product_image)) {
                    foreach($product_image as $images){
                        $image[]    =  array('url' => $this->uploadurl().'products/'.$images);
                    }
                } 
				elseif(!empty($product->product_imag)){
                  $image[]    =   array('url' => $this->uploadurl().'products/'.$product->product_image);
                }
                
				foreach($varient as $varie){
                    if(!empty($varie->pro_var_images)){
                        $image[]    =   array('url' => $this->uploadurl().'products/'.$varie->pro_var_images);
                    }
                }

                $product_call       =   $product->product_call == 1 ? $this->baseurl().'assets/images/swadeshi.png' : '';       
                //get wishlist product id by userid start from here
                $qqqq = $this->db->query('Select * from btl_wishlist WHERE user_id="'.$user_id.'" and product_id="'.$product->product_id.'"');
                $dataaa  = $qqqq->result();
//                echo "<br><br>";
//               print_r($dataaa);
           // echo "<br><br>";
                $wishlist="";
                if(count($dataaa) > 0){
                    $wishlist          =   "true";
                }
                else{
                    $wishlist          =   "false";
                }
				$is_purchase = '0';
				$sale_items = $this->db->query("SELECT * FROM `sale_items` join sale on sale.sale_id = sale_items.sale_id and sale_items.product_id='".$product->product_id."' WHERE sale.user_id='".$user_id."'")->row();
				if(!empty($sale_items)){
					$is_purchase = '1';
				}
                //get wishlist product id by userid start from end
                
                $data['data'][] = array(
                    'product_id'                => $product->product_id,
                    'product_name'              => $product->product_name,
                    'product_name_arb'          => $product->product_arb_name,
                    'product_description_arb'   => $product->product_arb_description,
                    'category_id'               => $product->category_id,
                    'brand_id'                  => !empty($product->brand_id) ? $product->brand_id : 0,
                    'brand_name'                => $product->brand_name,
                    'product_description'       => $product->product_description,
                    'deal_price'                => !empty($product->deal_price) ? $product->deal_price : 0,
                    'start_date'                => "",
                    'start_time'                => "",
                    'end_date'                  => "",
                    'end_time'                  => "",
                    //'difference_price' => $product->difference_price,
                    'difference_price'          => number_format((float) $product->difference_price, 2, '.', ''),
                    'price'                     => !empty($price) ? $price : 0,
                    'mrp'                       => !empty($mrp) ? $mrp : 0,
                    'product_image'             => !empty($product_image[0]) ? $product_image[0] : $varient[0]->pro_var_images,
                    'images_arr'                => $image,
                    //'tax'=>$product->tax,
                    'status'                    => '0',
                    'unit_value'                => !empty($product->unit_value) ? $product->unit_value : $varient[0]->qty,
                    'unit'                      => !empty($product->unit) ? $product->unit : $varient[0]->unit,
                    'increament'                => $product->increament,
                    'rewards'                   => $product->rewards,
                    'title'                     => $product->title,
                    'url'                       => $this->uploadurl().'products/',
                    'veg'                       => $title,
                    'swadesi'                   => $product_call,
                    'varient'                   => $varients,
                    'stock'                     => !empty($product->stock_inv) ? $product->stock_inv : "0",
                    'in_stock'                  => !empty($product->in_stock) ? $product->in_stock : "0",
                    'wishlist'                  => $wishlist,
                    'is_purchase'               => $is_purchase,
                    "ratings_average"   		=> $product->ratings_average,
                );
                unset($varients);
            }
            $data['status']     =   1;
            $data['message']     =   "Product Found";
        }
        else{
            $data['status']     =   0;
            $data['message']    =   "Product Not Found";
            $data['data']       =   array();     
        }
        echo json_encode($data);
    }

    function get_time_slot() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('date', 'date', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
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
            $current_Time   =   date('h:i a');
            $time_array = array();
            foreach ($times as $time) {
                if (!empty($cloasing_hours)) {
                    foreach ($cloasing_hours as $c_hr) {
                        if ($date == date("Y-m-d")) {
                            if (strtotime($time->format('h:i A')) > strtotime(date("h:i A")) && strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) < strtotime($c_hr->to_time)) {
                                
                            } else {
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
                        if (strtotime($time->format('h:i A')) > strtotime(date("h:i A"))) {
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
            
             //$time_array = array(); //please remove this code after testing
            $data["times"] = $time_array;
        }
        echo json_encode($data);
    }

    function text_for_send_order() {
        echo json_encode(array("data" => "<p>Our delivery boy will come withing your choosen time and will deliver your order. \n 
            </p>"));
    }

   function send_order() {
        
        $smsTemplate   = $this->smsTemplate(7);        
        $emailTemplate   = $this->emailTemplate(7);        
                
        //print_r($_POST); exit;        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('time', 'Time', 'trim|required');
        $this->form_validation->set_rules('data', 'data', 'trim|required');
        $this->form_validation->set_rules('location', 'Location', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
            $this->load->model("product_model");
            $currentdatetime    =   date("Y-m-d H:i:s");
            $get_current_order  =   $this->product_model->getUserCurrentOrder($this->input->post("user_id"), date('Y-m-d', strtotime($this->input->post('date'))));
            if(!empty($get_current_order)){
                $beforOrderTime         =   date('Y-m-d H:i:s', strtotime( '+30 second', strtotime($get_current_order->created_at)));
                if(strtotime($currentdatetime) <= strtotime($beforOrderTime)){
                    $data["responce"]   = true;
                    $data["data"]       = addslashes("<p>Your order No #" . $get_current_order->sale_id . " is 
                    send success fully \n Our delivery person will delivered order \n                         
                    between " . $get_current_order->delivery_time_from . " to " . $get_current_order->delivery_time_to . " on " . $get_current_order->on_date .
                    " \n Please keep <strong>" .$get_current_order->total_amount . "</strong> on delivery Thanks for being with Us.</p>");
                }
                else{
					
					
                    
                    $ld         =   $this->db->query("SELECT user_location.*, pincode.*, 
									CONCAT_WS(' ', user_location.house_no, user_location.landmark, user_location.city, user_location.state, pincode.pincode) as address  
                                    FROM user_location
                                    INNER JOIN pincode on pincode.pincode = user_location.pincode
                                    WHERE user_location.location_id = '" . $this->input->post("location") . "' limit 1");
                    $location   =   $ld->row();
        
                    $store_id   =   $this->input->post("store_id");
                    $payment_method = $this->input->post("payment_method");
                    $sales_id   =   $this->input->post("sales_id");
                    $app_version   =   $this->input->post("app_version");
                    $date       =   date("Y-m-d", strtotime($this->input->post("date")));
                    //$timeslot =   explode("-",$this->input->post("timeslot"));
        
                    $times      =   explode('-', $this->input->post("time"));
                    $fromtime   =   date("h:i a", strtotime(trim($times[0])));
                    $totime     =   date("h:i a", strtotime(trim($times[1])));
        
        
                    $user_id    =   $this->input->post("user_id");
                    $insert_array = array(
                                    "user_id"               => $user_id,
                                    'signin_by'             => 'App',
                                    "created_at"            => date("Y-m-d H:i:s"),
                                    "on_date"               => $date,
                                    "delivery_time_from"    => $fromtime,
                                    "delivery_time_to"      => $totime,
                                    "delivery_address"      => !empty($location->address)? $location->address : '',
                                    //"socity_id"             => $location->socity_id,
                                    "location_id"           => !empty($location->location_id)? $location->location_id : '',
                                    "payment_method"        => $payment_method,
                                    "new_store_id"          => $store_id,
                                    "app_version"          => !empty($app_version)? $app_version : '',
                                    'order_by'              => 'App'
                                    
                                    
                    );
                    $this->load->model("common_model");
                    $order_id       =   $this->common_model->data_insert("sale", $insert_array);
                    $id             =   $order_id;
                    $data_post      =   $this->input->post("data");
                    $data_array     =   json_decode($data_post);
                    $total_rewards  =   0;
                    $total_price    =   0;
                    $total_kg       =   0;
                    $total_items    =   array();
                    foreach ($data_array as $dt) {
                        $qty_in_kg = $dt->qty;
                        if ($dt->unit == "gram") {
                            $qty_in_kg = ($dt->qty * $dt->unit_value) / 1000;
                        }
                        $total_rewards  = $total_rewards + ($dt->qty * $dt->rewards);
                        $total_price    = $total_price + ($dt->qty * $dt->price);
                        $total_kg       = $total_kg + $qty_in_kg;
                        $total_items[$dt->product_id] = $dt->product_id;
        
                        $array = array(
                            "product_id"    => $dt->product_id,
                            "pro_var_id"    => $dt->varient_id,
                            "product_name"  => $dt->product_name,
                            "qty"           => $dt->qty,
                            "unit"          => $dt->unit,
                            "unit_value"    => $dt->unit_value,
                            "sale_id"       => $id,
                            "price"         => $dt->price,
                            "qty_in_kg"     => $qty_in_kg,
                            "rewards"       => $dt->rewards
                        );
                        $this->common_model->data_insert("sale_items", $array);
                        
                        $this->db->query('Update product_varient SET stock_inv = stock_inv-"'.$dt->qty.'" WHERE  varient_id ="'.$dt->varient_id.'" AND product_id ="'.$dt->product_id.'" ');
                    }
        
                    if ($this->input->post("total_ammount") != "" || $this->input->post("total_ammount") != 0) {
                        $total_price = $this->input->post("total_ammount");
                    }
                    //$total_price = $total_price + $location->delivery_charge;
					
					
        
                    $coupanamount   =   !empty($this->input->post("coupan_amount")) ? $this->input->post("coupan_amount") : 0;
                    $wallet_amount  =   !empty($this->input->post("wallet_amount")) ? $this->input->post("wallet_amount") : 0;
                    $delivery_charge  = !empty($location->free_delivery_amount) && $location->free_delivery_amount < $total_price ? 0 :  (!empty($location->delivery_charge) ? $location->delivery_charge : 0 );
                    $this->db->query("Update sale set total_amount = '" . $total_price . "',  delivery_charge = '" . $delivery_charge . "', total_kg = '" . $total_kg . "', total_items = '" . count($total_items) . "', total_rewards = '" . $total_rewards . "', coupan_amount_use = '" . $coupanamount . "', wallet_amount = '" . $wallet_amount . "'  where sale_id = '" . $id . "'");
                
                    $transaction_Arr    =   array(
                                            'user_id'           =>  $user_id,
                                            'order_id'          =>  $order_id,
                                            'transction_code'   =>  $payment_method,
                                            'description'       =>  $order_id." purchase product amount is ".$this->config->item('currency')." ".$total_price."/ , coupan amount is ".$this->config->item('currency')." ".$coupanamount."/ and  AND delivery charges is ".$this->config->item('currency')." ".$location->delivery_charge."/",
                                            'cr'                =>   0,
                                            'dr'                =>   $total_price, 
                                            'status'            =>   0,
                                            'create_at'         =>   date("Y-m-d H:i:s"),
                                        );
                    $this->common_model->data_insert('transaction', $transaction_Arr);
                    if($payment_method == 'PayTm'){
					    $data["data"] = $this->paytmpost($order_id, $total_price, $user_id);
    				}
    				elseif($payment_method == 'rozerpay'){
    				    $data["data"]['order_id']   =   $order_id;
    				    $data["data"]['amount']     =   $total_price;
    				    $data["data"]['currency']   =   $this->config->item('currency');
    				}
    				else{
                        $data["message"] = "Place  Order";
                        $data["responce"] = true;
                        $data["msg"] = addslashes("<p>Your order No #" . $order_id . " is 
                                send success fully \n Our delivery person will delivered order \n                         
                                between " . $fromtime . " to " . $totime . " on " . $date .
                                " \n Please keep <strong>" . $this->config->item('currency').''.$total_price . "</strong> on delivery Thanks for being with Us.</p>");
                                
                        $data["data_arb"] = addslashes("<p> تم إرسال طلبك رقم  #" . $id . " بنجاح . سوف يقوم موظف التسليم الخاص بنا بتسليم الطلب بين الساعة  " . $fromtime . "ص و  " . $totime . " ص في  " . $date . " \n . الرجاء الاحتفاظ بالرقم  <strong>" . $total_price . "</strong> عند التسليم . شكراً لكونك معنا..</p>");
    
                       $token = array(
                            'orderid'   => $id,
                            'fromtime'  => $fromtime,
                            'totime'    => $totime,
                            'date'      => $date,
                            'amount'    => $this->config->item('currency').''.$total_price
                        );
                        $pattern = '[%s]';
                        foreach($token as $key=>$val){
                            $varMap[sprintf($pattern,$key)] = $val;
                        }
                        
                        //$data["data"]      = $token;
						$this->load->model("product_model");
                        $row  =   $this->product_model->get_sale_by_user_id($this->input->post("user_id"), $order_id);
						
                        if(!empty($row)){
							$statue     =   '';
							if($row->status == 0){
								$statue     =   "Pending";
							}
							elseif($row->status == 1){
								$statue     =   "Confirmed";
							}
							elseif($row->status == 2){
								$statue     =   "Out For Delivery";
							}
							elseif($row->status == 3){
								$statue     =   "Cancelled";
							}
							elseif($row->status == 4){
								$statue     =   "Completed";
							}
							$row->status    =   $statue;
						}
						//$row  = json_encode($row);
						$data["data"] = $row;
                        
                        $message1['notification']["title"] = "Place Order";
                        $message1['notification']["body"] = strtr($smsTemplate,$varMap);
                        $message1['notification']["icon"] = base_url()."uploads/company/".$this->config->item('logo');
                        $message1['data'] = $row;
						//$message1  = json_encode($message1);
						
                        
                        // $message1["title"]      = "Place Order";
                        // $message1["data"]      = $token;
                        // $message1["body"]    = strtr($smsTemplate,$varMap);
                        // $message1["icon"]      = base_url()."uploads/company/".$this->config->item('logo');
                        // $message1["created_at"] = date("Y-m-d h:i:s");
                        // $message1["obj"]        = "";
						//echo '<pre>';
						//print_r($message1);
						// die;
                        
                        $msg               =  strtr($smsTemplate,$varMap);
                        
                        $q = $this->db->query("SELECT registers.user_email, registers.user_gcm_code,
                                            registers.user_ios_token, user_location.receiver_name, user_location.receiver_mobile  
                                            FROM registers 
                                            LEFT JOIN sale on sale.user_id=registers.user_id AND sale.sale_id='".$order_id."'
                                            LEFT JOIN user_location on user_location.location_id=sale.location_id
                                            WHERE  registers.user_id='".$user_id."'");
                        $user = $q->row();
                        
                        /*Order Mail Send Start*/
                        if(!empty($user->user_email)){
                            $to_mail_arr            = array();
                            $to_mail_arr[0]         = array('to_mail' => $user->user_email, 'to_name' => $user->receiver_name);
                            $cc_mail_arr            = array();
                            $reply_to_mail_arr      = array();
                            $reply_to_mail_arr[0]   = array('reply_mail'=>$this->config->item('email'),'reply_name'=>'noreply');
                            $mail_subject           = "Order Confirmation";
                            $mail_attachment_arr    = array();
                            $from_mail_arr          = array();
                            $from_mail_arr[0]       = array('from_mail' => $this->config->item('email'), 'from_name' => $this->config->item('name'));
                            $message                = "<a href='".base_url()."' title='".$this->config->item('name')."'><img src='".base_url()."uploads/company/".$this->config->item('logo')."' style='float:right; width:30%;' alt='".$this->config->item('name')."' title='".$this->config->item('name')."'></a><br><br><br><br>";
                            $message                .= strtr($emailTemplate,$varMap);
            
                            $result                 =  $this->send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr);
                        }
                        /*Order Mail Send End*/
                       
                        if(!empty($this->config->item('firebase_key')) && !empty($user->user_gcm_code)){
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();
                            if ($user->user_gcm_code != "") {
                                $result = $gcm->send_notification_data($user->user_gcm_code, $message1, "android",$this->config->item('firebase_key'));
                            }
                            if ($user->user_ios_token != "") {
                                $result = $gcm->send_notification_data($user->user_ios_token, $message1, "ios", $this->config->item('firebase_key'));
                            }
                            
                        }
    
                         if(!empty($user->receiver_mobile)){
                            $this->setting_model->sendsmsPOST($user->receiver_mobile, $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));
                         }
    				}
                }
            }
            else{
                $ld         =   $this->db->query("SELECT user_location.*, pincode.*, 
									CONCAT_WS(' ', user_location.house_no, user_location.landmark, user_location.city, user_location.state, pincode.pincode) as address 
                                    FROM user_location
                                    INNER JOIN pincode on pincode.pincode = user_location.pincode
                                    WHERE user_location.location_id = '" . $this->input->post("location") . "' limit 1");
                $location   =   $ld->row();
    
                $store_id   =   $this->input->post("store_id");
                $payment_method = $this->input->post("payment_method");
                $sales_id   =   $this->input->post("sales_id");
                $date       =   date("Y-m-d", strtotime($this->input->post("date")));
                //$timeslot = explode("-",$this->input->post("timeslot"));
    
                $times      =   explode('-', $this->input->post("time"));
                $fromtime   =   date("h:i a", strtotime(trim($times[0])));
                $totime     =   date("h:i a", strtotime(trim($times[1])));
    
    
                $user_id    =   $this->input->post("user_id");
                $insert_array = array(
                                    "user_id"               => $user_id,
                                    'signin_by'             => 'App',
                                    "created_at"            => date("Y-m-d H:i:s"),
                                    "on_date"               => $date,
                                    "delivery_time_from"    => $fromtime,
                                    "delivery_time_to"      => $totime,
                                    "delivery_address"      => $location->address,
                                   // "socity_id"             => $location->socity_id,
                                    "location_id"           => $location->location_id,
                                    "payment_method"        => $payment_method,
                                    "new_store_id"          => $store_id,
                                    'order_by'              => 'App'
                                );
                $this->load->model("common_model");
                $order_id       =   $this->common_model->data_insert("sale", $insert_array);
                $id             =   $order_id;    
                
                $data_post      =   $this->input->post("data");
                $data_array     =   json_decode($data_post);
                $total_rewards  =   0;
                $total_price    =   0;
                $total_kg       =   0;
                $total_items    =   array();
                foreach ($data_array as $dt) {
                    $qty_in_kg  =   $dt->qty;
                    if ($dt->unit == "gram") {
                        $qty_in_kg = ($dt->qty * $dt->unit_value) / 1000;
                    }
                    $total_rewards  = $total_rewards + ($dt->qty * $dt->rewards);
                    $total_price    = $total_price + ($dt->qty * $dt->price);
                    $total_kg       = $total_kg + $qty_in_kg;
                    $total_items[$dt->product_id] = $dt->product_id;
    
                    $array = array(
                            "product_id"    => $dt->product_id,
                            "pro_var_id"    => $dt->varient_id,
                            "product_name"  => $dt->product_name,
                            "qty"           => $dt->qty,
                            "unit"          => $dt->unit,
                            "unit_value"    => $dt->unit_value,
                            "sale_id"       => $order_id,
                            "price"         => $dt->price,
                            "qty_in_kg"     => $qty_in_kg,
                            "rewards"       => $dt->rewards
                    );
                    $this->common_model->data_insert("sale_items", $array);
                    
                    $this->db->query('Update product_varient SET stock_inv = stock_inv-"'.$dt->qty.'" WHERE  varient_id ="'.$dt->varient_id.'" AND product_id ="'.$dt->product_id.'" ');
                }
    
                if ($this->input->post("total_ammount") != "" || $this->input->post("total_ammount") != 0) {
                    $total_price = $this->input->post("total_ammount");
                }
                //$total_price = $total_price + $location->delivery_charge;
                $coupanamount   =   !empty($this->input->post("coupan_amount")) ? $this->input->post("coupan_amount") : 0;
                $wallet_amount  =   !empty($this->input->post("wallet_amount")) ? $this->input->post("wallet_amount") : 0;
                $delivery_charge  = $location->free_delivery_amount < $total_price ? 0 :  $location->delivery_charge;
                $this->db->query("Update sale set total_amount = '" . $total_price . "',  delivery_charge = '" . $delivery_charge . "', total_kg = '" . $total_kg . "', total_items = '" . count($total_items) . "', total_rewards = '" . $total_rewards . "', coupan_amount_use = '" . $coupanamount . "', wallet_amount = '" . $wallet_amount . "'  where sale_id = '" . $id . "'");                
                $transaction_Arr    =   array(
                                            'user_id'           =>  $user_id,
                                            'order_id'          =>  $order_id,
                                            'transction_code'   =>  $payment_method,
                                            'description'       =>  $order_id." purchase product amount is ".$this->config->item('currency')." ".$total_price."/ , coupan amount is ".$this->config->item('currency')." ".$coupanamount."/ and  AND delivery charges is ".$this->config->item('currency')." ".$location->delivery_charge."/",
                                            'cr'                =>   0,
                                            'dr'                =>   $total_price, 
                                            'status'            =>   0,
                                            'create_at'         =>   date("Y-m-d H:i:s"),
                                        );
                $this->common_model->data_insert('transaction', $transaction_Arr);
                
                if($payment_method == 'PayTm'){
					$data["data"] = $this->paytmpost($order_id, $total_price, $user_id);
				}
				elseif($payment_method == 'rozerpay'){
    				    $data["data"]['order_id']   =   $order_id;
    				    $data["data"]['amount']     =   $total_price;
    				    $data["data"]['currency']   =   $this->config->item('currency');
    				}
				else{
                    $data["message"] = "Place  Order";
				    $data["responce"] = true;
                    $data["msg"] = addslashes("<p>Your order No #" . $order_id . " is 
                            send success fully \n Our delivery person will delivered order \n                         
                            between " . $fromtime . " to " . $totime . " on " . $date .
                            " \n Please keep <strong>" . $this->config->item('currency').''.$total_price . "</strong> on delivery Thanks for being with Us.</p>");
                    $msg = "Your order No #" . $order_id . " is send success fully Our delivery person will delivered order between " . $fromtime . " to " . $totime . " on " . $date . " Please keep " . $this->config->item('currency').''.$total_price . " on delivery Thanks for being with Us.";
                    $data["data_arb"] = addslashes("<p> تم إرسال طلبك رقم  #" . $id . " بنجاح . سوف يقوم موظف التسليم الخاص بنا بتسليم الطلب بين الساعة  " . $fromtime . "ص و  " . $totime . " ص في  " . $date . " \n . الرجاء الاحتفاظ بالرقم  <strong>" . $total_price . "</strong> عند التسليم . شكراً لكونك معنا..</p>");
                    $token = array(
                            'orderid'   => $order_id,
                            'fromtime'  => $fromtime,
                            'totime'    => $totime,
                            'date'      => $date,
                            'amount'    => $this->config->item('currency').''.$total_price
                        );
                        $pattern = '[%s]';
                        foreach($token as $key=>$val){
                            $varMap[sprintf($pattern,$key)] = $val;
                        }
                        //$data["data"] =$token;
                        $this->load->model("product_model");
                        $row  =   $this->product_model->get_sale_by_user_id($this->input->post("user_id"), $order_id);
						
                        if(!empty($row)){
							$statue     =   '';
							if($row->status == 0){
								$statue     =   "Pending";
							}
							elseif($row->status == 1){
								$statue     =   "Confirmed";
							}
							elseif($row->status == 2){
								$statue     =   "Out For Delivery";
							}
							elseif($row->status == 3){
								$statue     =   "Cancelled";
							}
							elseif($row->status == 4){
								$statue     =   "Completed";
							}
							$row->status    =   $statue;
						}
						//$row  = json_decode(json_encode($row), true);
						$data["data"] = $row;
                        
                        $message1['notification']["title"] = "Place Order";
                        $message1['notification']["body"] = strtr($smsTemplate,$varMap);
                        $message1['notification']["icon"] = base_url()."uploads/company/".$this->config->item('logo');
                        $message1['data'] = $row;
                        // $message1["created_at"] = date("Y-m-d h:i:s");
                        // $message1["obj"] = "";
                        //echo '<pre>';
						//print_r($message1);
                        
                        $msg               =  strtr($smsTemplate,$varMap);
                        
                        $q = $this->db->query("SELECT registers.user_email, registers.user_gcm_code,
                                            registers.user_ios_token, user_location.receiver_name, user_location.receiver_mobile  
                                            FROM registers 
                                            LEFT JOIN sale on sale.user_id=registers.user_id 
                                            AND sale.sale_id='".$order_id."'
                                            LEFT JOIN user_location on user_location.location_id=sale.location_id
                                            where  registers.user_id='".$user_id."'");
                        $user = $q->row();
                        
                        /*Order Mail Send Start*/
                        if(!empty($user->user_email)){
                            $to_mail_arr            = array();
                            $to_mail_arr[0]         = array('to_mail' => $user->user_email, 'to_name' => $user->receiver_name);
                            $cc_mail_arr            = array();
                            $reply_to_mail_arr      = array();
                            $reply_to_mail_arr[0]   = array('reply_mail'=>$this->config->item('email'),'reply_name'=>'noreply');
                            $mail_subject           = "Order Confirmation";
                            $mail_attachment_arr    = array();
                            $from_mail_arr          = array();
                            $from_mail_arr[0]       = array('from_mail' => $this->config->item('email'), 'from_name' => $this->config->item('name'));
                            $message                = "<a href='".base_url()."' title='".$this->config->item('name')."'><img src='".base_url()."uploads/company/".$this->config->item('logo')."' style='float:right; width:30%;' alt='".$this->config->item('name')."' title='".$this->config->item('name')."'></a><br><br><br><br>";
                            $message                .= strtr($emailTemplate,$varMap);
            
                            $result                 =  $this->send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr);
                        }
                        /*Order Mail Send End*/
                        //echo $this->config->item('firebase_key'); exit;
                        if(!empty($this->config->item('firebase_key'))  && !empty($user->user_gcm_code)){
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();
                            if ($user->user_gcm_code != "") {
                                $result = $gcm->send_notification($user->user_gcm_code, $message1, "android",$this->config->item('firebase_key'));
                            }
                            if ($user->user_ios_token != "") {
                                $result = $gcm->send_notification($user->user_ios_token, $message1, "ios", $this->config->item('firebase_key'));
                            }
                        }
    				}
                
                
                     if(!empty($user->receiver_mobile)){
                        $this->setting_model->sendsmsPOST($user->receiver_mobile, $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));
                     }    
            }
            
           
        }
        echo json_encode($data);
    }
    
    function paytmpost($id, $total_price, $user_id){
           header("Pragma: no-cache");
           header("Cache-Control: no-cache");
           header("Expires: 0");
           // following files need to be included
           //require_once(APPPATH . "/libraries/paytm/config_paytm.php");
           require_once(APPPATH . "/libraries/paytm/encdec_paytm.php");
            
			$q = $this->db->query("SELECT * FROM registers where user_id='".$user_id."'");
			$user = $q->row();
			
			/*Order Mail Send Start*/
			$user_email = '';
			if(!empty($user->user_email)){
				$user_email = $user->user_email;
			}
			
			
            $base_url_home = str_replace('/backend', '', $this->config->item('base_url'));
			
			$checkSum = "";
			$paramList = array();
			// Create an array having all required parameters for creating checksum.
// 			$paramList["MID"]                = $this->config->item('paytm_id');
// 			$paramList["ORDER_ID"]           = $id;
// 			$paramList["CUST_ID"]            = $user_id;
// 			$paramList["EMAIL"]            	= $user_email;
// 			$paramList["INDUSTRY_TYPE_ID"]   = $this->config->item('paytm_type');
// 			$paramList["CHANNEL_ID"]         = "WAP";
// 			$paramList["TXN_AMOUNT"]         = $total_price;
// 			$paramList["WEBSITE"]            = $this->config->item('paytm_api_key');
// 			$paramList["CALLBACK_URL"]       = $base_url_home.'/paytm_response?ORDER_ID='.$id;

			$paramList["MID"]                = $this->config->item('paytm_id');
			$paramList["ORDER_ID"]           = $id;
			$paramList["CUST_ID"]            = $user_id;
			$paramList["INDUSTRY_TYPE_ID"]   = $this->config->item('paytm_type');
			$paramList["CHANNEL_ID"]         = "WAP";
			$paramList["TXN_AMOUNT"]         = $total_price;
			$paramList["EMAIL"]            	 = $user_email;
			$paramList["WEBSITE"]            = $this->config->item('paytm_api_key');
			$paramList["CALLBACK_URL"]       = 'https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID='.$id;
			
           
           
			//'https://securegw.paytm.in/theia/paytmCallback?ORDER_ID='.$id;
            //Here checksum string will return by getChecksumFromArray() function.
            return array("array" => $paramList, 'key'=>$this->config->item('paytm_key'), "url" => $this->config->item('paytm_url')); exit;
            $checkSum = getChecksumFromArray($paramList,$this->config->item('paytm_key'));
            $list     =  array(
                            'checkSum'      =>$checkSum,
                            'marchent'      =>$paramList,
                            'transactionURL'=>$this->config->item('paytm_url')
                         );
            return $list;

        }
        function payonline(){
           date_default_timezone_set('Africa/Johannesburg');
           header("Pragma: no-cache");
           header("Cache-Control: no-cache");
           header("Expires: 0");
           // following files need to be included
           //require_once(APPPATH . "/libraries/paytm/config_paytm.php");
           require_once(APPPATH . "/libraries/paytm/encdec_paytm.php");
            
            
            $paytmChecksum = "";
            $paramList = array();
            $isValidChecksum = FALSE;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('order_id', 'Order ID',  'trim|required');
            $this->form_validation->set_rules('transaction_id', 'Transaction Id',  'trim|required');
            // $this->form_validation->set_rules('status', 'Transaction Status',  'trim|required');
            if ($this->form_validation->run() == FALSE){
                $data["responce"] = false;  
                $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                
            }
            else{
                $order_id                       =   $this->input->post("order_id");
                $transaction_id                 =   $this->input->post("transaction_id");
                $total_price                    =   $this->input->post("total_price");
            	$status                         =   $this->input->post("status");
            	$type                           =   $this->input->post("type");
            	$data                           =   array();
                if($type == 'PayTm'){
                    $paramList["MID"]               =   $this->config->item('paytm_id');
                    $paramList["ORDER_ID"]          =   $order_id;
                    $paramList["CUST_ID"]           =   $order_id;
                    $paramList["INDUSTRY_TYPE_ID"]  =   $this->config->item('paytm_type');
                    $paramList["CHANNEL_ID"]        =   "WAP";
                    $paramList["TXN_AMOUNT"]        =   $total_price;
                    $paramList["WEBSITE"]           =   $this->config->item('paytm_api_key');
                    $paramList["CALLBACK_URL"]      =   'https://securegw.paytm.in/theia/paytmCallback?ORDER_ID='.$order_id;
    
                    $paytmChecksum    = $this->input->post("CHECKSUMHASH");
                    $isValidChecksum  = verifychecksum_e($paramList, $this->config->item('paytm_key'), $paytmChecksum);
                    $return_array     = $isValidChecksum ? "Y" : "N";
                    $data["responce"] =   false;
                    $code 			  =   "error_payment_failuer";	
                    if(!empty($transaction_id) && !empty($order_id) && $return_array=='Y' && $status =='TXN_SUCCESS'){
                        $datas 	=  $this->db->query("UPDATE sale SET  paymentid='".$transaction_id."', is_paid='1' WHERE sale_id = '".$order_id."'");
                       if($datas){
    		            	$msg 	= '';
    						$code 	= 'success_order_place';
    						$result = array(
    							'id' => 1,
    							'api' => 'placeOrder',
    							'key' => 'success_place_order',
    							'data' => $order_id,
    						);
    						$data['msg']        =   "Order Placed Successfully!";
    						$data['code']       =   "success_order_place";
    						$data['responce']   =   true;
    					}else{
    					    $data['msg']        =   "Something Went Wrong...Order Not Placed!";
    						$data['code']       =   "error_payment_failuer";
    						$data['responce']   =   false;
    					}
                    }
                }
                elseif($type == 'rozerpay'){
				    $datas 	=  $this->db->query("UPDATE sale SET  paymentid='".$transaction_id."', is_paid='1' WHERE sale_id = '".$order_id."'");
                    if($datas){
		            	$msg 	= '';
						$code 	= 'success_order_place';
						$result = array(
							'id' => 1,
							'api' => 'placeOrder',
							'key' => 'success_place_order',
							'data' => $order_id,
						);
						$data['msg']        =   "Order Placed Successfully!";
						$data['code']       =   "success_order_place";
						$data['responce']   =   true;
					}else{
					    $data['msg']        =   "Something Went Wrong...Order Not Placed!";
						$data['code']       =   "error_payment_failuer";
						$data['responce']   =   false;
					}
				}
            }
            echo json_encode($data);
        }
    function payonlines(){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('order_id', 'Order ID',  'trim|required');
            $this->form_validation->set_rules('transaction_id', 'Transaction Id',  'trim|required');
            // $this->form_validation->set_rules('status', 'Transaction Status',  'trim|required');
            if ($this->form_validation->run() == FALSE){
                $data["responce"] = false;  
                $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
            }
            else{
                $order_id                       =   $this->input->post("order_id");
                $transaction_id                 =   $this->input->post("transaction_id");
                $total_price                    =   $this->input->post("total_price");
            	$status                         =   $this->input->post("status");
                if(!empty($transaction_id) && !empty($order_id)){
                    $data 	=  $this->db->query("UPDATE sale SET  paymentid='".$transaction_id."', is_paid='1' WHERE sale_id = '".$order_id."'");
                   if($data){
		            	$data['msg']        =   "Order Placed Successfully!";
						$data['code']       =   "success_order_place";
						$data['responce']   =   true;
					}else{
						$data['msg']        =   "Something Went Wrong...Order Not Placed!";
						$data['code']       =   "error_payment_failuer";
						$data['responce']   =   false;
					}
                }

            }
        echo json_encode($data);
    }

    function my_orders() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
            $this->load->model("product_model");
            $order  =   $this->product_model->get_sale_by_user($this->input->post("user_id"));
            $rows  =   array();
            $refund  =   array();
            //print_r($order); exit;
            foreach($order as $row){
                $statue     =   '';
                //echo $row->status."<br>";
                
                if($row->status == 0){
                    $statue     =   "Pending";
                }
                elseif($row->status == 1){
                    $statue     =   "Confirmed";
                }
                elseif($row->status == 2){
                    $statue     =   "Out For Delivery";
                }
                elseif($row->status == 3){
                    $statue     =   "Cancelled";
                }
                elseif($row->status == 4){
                    $statue     =   "Completed";
                }
                elseif($row->status == -1){
                    $statue     =   "Return";
                }
                $row->status    =   $statue;
               
                $request = $this->db->query('select * from refund_request where user_id = "'.$this->input->post("user_id").'" AND order_id = "'.$row->sale_id.'"')->result();
                
                if(!empty($request))
                {
                
                    foreach($request as $req)
                    {
                        //print_r($req);
                        $refund_status     =   '';
                        if($req->status == 1){
                            $refund_status     =   "Return in processing";
                        }
                        elseif($req->status == 2){
                            $refund_status     =   "Return process cancelled";
                        }
                        elseif($req->status == 3){
                            $refund_status     =   "Return processed";
                        }
                        else{
                            $refund_status     =   "return";
                        }                    
                        $row->refund_status    =   $refund_status;
                        
                        $row->requestfor    =   $req->requestfor;
                        //$row->refund_status_no    =   $req->status;
                        //$refund     =  json_decode(json_encode($req), true);
                    }
                }
                else{
                    $row->refund_status    =   "";
                }
                
                
                
                $rows[]     =  json_decode(json_encode($row), true);
            }
            
            $data['status'] = "1";
            $data['url'] =  $this->uploadurl().'products/';
            $data['data'] = $rows;
        }
        echo json_encode($data);
    }

    function delivered_complete() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
            $this->load->model("product_model");
            $order  =   $this->product_model->get_sale_by_user2($this->input->post("user_id"));
            $rows  =   array();
            foreach($order as $row){
                $statue     =   '';
                if($row->status == 0){
                    $statue     =   "Pending";
                }
                elseif($row->status == 1){
                    $statue     =   "Confirmed";
                }
                elseif($row->status == 2){
                    $statue     =   "Out For Delivery";
                }
                elseif($row->status == 3){
                    $statue     =   "Cancelled";
                }
                elseif($row->status == 4){
                    $statue     =   "Completed";
                }
                $row->status    =   $statue;
                $rows[]     =  json_decode(json_encode($row), true);;
            }
            $data['status'] = "1";
            $data['url'] =  $this->uploadurl().'products/';
            $data['data'] = $rows;
            
        }
        echo json_encode($data);
    }

    function order_details() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('sale_id', 'Sale ID', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
            $this->load->model("product_model");
            $data['data'] = $this->product_model->get_sale_order_items($this->input->post("sale_id"));
            $data['url'] =  $this->uploadurl().'products/';
        }
        echo json_encode($data);
    }

    function cancel_order() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('sale_id', 'Sale ID', 'trim|required');
        $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
           // echo "Update sale set status = 3 where user_id = '" . $this->input->post("user_id") . "' and  sale_id = '" . $this->input->post("sale_id") . "' "; exit;
            $this->db->query("Update sale set status = '3' where user_id = '" . $this->input->post("user_id") . "' and  sale_id = '" . $this->input->post("sale_id") . "' ");
            //$this->db->delete('sale_items', array('sale_id' => $this->input->post("sale_id")));
            $data["responce"] = true;
            $data["message"] = "Your order cancel successfully";
        }
        echo json_encode($data);
    }

    function get_society() {

        $this->load->model("product_model");
        $data['socity']  = $this->product_model->get_socities();

        echo json_encode($data);
    }

    function get_varients_by_id() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ComaSepratedIdsString', 'IDS', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
            $this->load->model("product_model");
            $data = $this->product_model->get_prices_by_ids($this->input->post("ComaSepratedIdsString"));
        }
        echo json_encode($data);
    }

    function get_sliders() {
        $q = $this->db->query("Select * from slider WHERE trash=0 AND slider_status=1");
        $data  = $q->result();
        $result['response']  = false;
        if(count($data) > 0){
            $url    =   $this->uploadurl().'sliders/';
            $result     =   array('data' => $data, 'url' => $url,'response' => true);
        }
        echo json_encode($result);
    }
    
    
    function getBanners($type){
        $bannerArr      =   array();
        $type_name      = $this->db->query('SELECT feature_slider_type.type_id, feature_slider_type.type_name FROM  feature_slider_type
                                    INNER JOIN feature_slider ON feature_slider.slider_title = feature_slider_type.type_id
                                    WHERE feature_slider.banner_type = "'.$type.'" group by feature_slider_type.type_id')->result_array();
        if(!empty($type_name)){
            foreach($type_name as $rows){
                $sql_cat = "SELECT 
                            feature_slider.id as id,
                            feature_slider.image_type as image_type,
                            feature_slider.slider_title as slider_title,
                            feature_slider.slider_url as slider_url,
                            feature_slider.slider_image as slider_image,
                            feature_slider.sub_cat as sub_cat,
                            feature_slider.sub_type,
                            feature_slider.slider_status as slider_status,
                            feature_slider.banner_type,
                            categories.title as cat_title,
                            tbl_brand.title as brand_title,
                            products.product_name as product_name,
                            categories.slug as slug,
                            tbl_brand.slug as brand_slug,
                            products.product_slug as product_slug
                            FROM feature_slider 
                            LEFT JOIN categories ON categories.id = feature_slider.sub_cat AND categories.status = 1 AND feature_slider.sub_type='category'
                            LEFT JOIN tbl_brand  ON tbl_brand.id = feature_slider.sub_cat AND tbl_brand.status = 1 AND feature_slider.sub_type='brand'
                            LEFT JOIN products  ON products.product_id = feature_slider.sub_cat AND products.trash = 0 AND feature_slider.sub_type='product'
                            WHERE feature_slider.slider_title = '" . $rows['type_id'] . "' AND feature_slider.banner_type='".$type."' AND feature_slider.slider_status=1 AND feature_slider.trash =0";
                            //echo $sql_cat; exit;
                $q              = $this->db->query($sql_cat);
               
                $smallimage     = array();
                $bigimage       = array();
                if($q->num_rows() > 0){
                    $slider         = $q->result_array();
                    foreach($slider as $row){
                        $banner_type    =   $row['banner_type'];
                        $sub_type       =   $row['sub_type'];
                        
                        $image          =   $this->uploadurl().'sliders/'.$row['slider_image'];
                        if($row['image_type'] == 1){
                           $smallimage[]        =   array(
                                                            'sub_type'      =>  $row['sub_type'],
                                                            'category_id'   =>  $row['sub_cat'],
                                                            'image'         =>  $image,
                                                            'type'          =>  'small'
                                                        );
                       } 
                       if($row['image_type'] == 0){
                           $bigimage[]        =   array(
                                                            'sub_type'      =>  $row['sub_type'],
                                                            'category_id'   =>  $row['sub_cat'],
                                                            'image'         =>  $image,
                                                            'type'          =>  'Fullsize'
                                                        );
                       } 
                        
                        
                    }
                    $text =     "";
                    if($banner_type == 1){
                        $text = "4 Small + 1 Big Banner";
                    }
                    elseif($banner_type == 2){
                        $text = "4 Small Banner";
                    }
                    elseif($banner_type == 3){
                        $text = "3 Small + 1 Big Banner";
                    }
                    elseif($banner_type == 4){
                        $text = "1 Big Banner";
                    }
                    
                    $bannerArr[$rows['type_name']]  =   array(
                                                            'banner_type_id'    =>  $rows['type_id'],
                                                            'slider_title'      =>  $rows['type_name'],
                                                            'banner_type'       =>  $banner_type,
                                                            'text'              =>  $text,
                                                            'smallimages'       =>  $smallimage,
                                                            'bigimages'         =>  $bigimage,
                                                        
                                                        );
                    
                    unset($smallimage);
                    unset($bigimage);
                }
            }
        }
        if(!empty($bannerArr)){
            return $bannerArr;
        }
        else{ 
            return (object)$bannerArr;
        }
        
    }

    function get_banner() {
        
        $data['type1'] =   $this->getBanners(1);
        $data['type2'] =   $this->getBanners(2);  
        $data['type3'] =   $this->getBanners(3);
        $data['type4'] =   $this->getBanners(4);
        $data['type5'] =   $this->getBanners(5);

        if(count($data) > 0){
            $url    =   $this->uploadurl().'sliders/';
            $result     =   array('data' => $data, 'url' => $url,'response' => true);
        }
        else{
            $url    =   $this->uploadurl().'sliders/';
            $result     =   array('data' => $data, 'url' => $url,'response' => false);
        }
        echo json_encode($result);
    }

    function get_feature_banner() {
        $q = $this->db->query("Select * from feature_slider");
        $data  = $q->result();
        $result['response']  = false;
        if(count($data) > 0){
            $url    =   $this->uploadurl().'sliders/';
            $result     =   array('data' => $data, 'url' => $url,'response' => true);
        }
        echo json_encode($result);
    }

    /*
      function get_limit_settings($var = false) {
      if($var){
      $q = $this->db->query("Select * from settings");
      echo json_encode($q->result());
      }else{
      echo json_encode(array(array('id'=> 1, 'value'=>100000, 'title'=>'Please Download Updated App')));
      }
      }
     * 
     */

    function minmax() {
        $q = $this->db->query("Select * from settings");
        $data   =   array('data'=> array(), 'status' => false, 'message' =>'Not found'); 
        if($q->num_rows() > 0){
            $result     =   $q->result();
            $data['data']     = array('min_max_id'=>$result[0]->id, 'min_value' =>$result[0]->value, 'max_value'=>$result[1]->value);
            $data['status']   = true;    
            $data['message']  = "Found";
        }
        echo json_encode( $data);
    }

    function get_limit_settings_new() {
        $version = $this->input->post("version");
        if ($version < 3.1 || empty($version)) {
            //echo json_encode(TRUE);
            echo json_encode(array(array('id' => 0, 'value' => 100000, 'title' => 'Please Download New Version App')));
            return FALSE;
        }
        $q = $this->db->query("Select * from settings");
        echo json_encode($q->result());
    }

    function get_limit_settings() {
        echo json_encode(array(array('id' => 1, 'value' => "1000000", 'title' => 'Please Download New Version App')));
        /*
          $q = $this->db->query("Select * from settings");
          echo json_encode($q->result());
         * 
         */
    }

    function checkVersion_update() {
        $version = $this->input->post("version");
        if (!empty($version) && $version >= $this->live_app_version) {
            $result = array(
                array('id' => 1,
                    'key' => 'VALID_APP_MSG',
                    'value' => TRUE,
                    'msg' => 'Welcome To OraFresh')
            );
        } else {
            $result = array(
                array('id' => 0,
                    'key' => '_error',
                    'value' => $this->live_app_path,
                    'msg' => 'Please Download New Version App')
            );
        }
        echo json_encode($result);
    }

    function checkVersion() {
        $version = $this->input->post("version");
        if (!empty($version) && $version >= 2.9) {
            echo json_encode(TRUE);
        } else {
            echo json_encode(FALSE);
        }
    }
	
	public function _check_pincode_service($pincode){
		$result_rew = $this->db
						->select('pincode')
						->where('pincode', $pincode)
						->get('pincode')
						->row();
						
		if(empty($result_rew)){
			$this->form_validation->set_message('_check_pincode_service', 
				'We are not provide service on this location.'
			);
			return FALSE;
		}
		
		return TRUE;
    }

    function add_address() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        $this->form_validation->set_rules('pincode', 'Pincode ID', 'trim|required|callback__check_pincode_service');
        $this->form_validation->set_rules('lat', 'Latitude', 'trim');
        $this->form_validation->set_rules('lang', 'Langitude', 'trim');
        $this->form_validation->set_rules('default_address', 'Default Address', 'trim');
        //$this->form_validation->set_rules('socity_id', 'Socity', 'trim');
        $this->form_validation->set_rules('house_no', 'House', 'trim|required');
        $this->form_validation->set_rules('receiver_mobile', 'Mobile No.', 'trim|regex_match[/^[0-9]{10}$/]'); //regex_match[/^[0-9]{10}$/]
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        } else {
            $user_id = $this->input->post("user_id");
            $pincode = $this->input->post("pincode");
            //$socity_id = $this->input->post("socity_id");
            $lat = $this->input->post("lat");
            $lang = $this->input->post("lang");
            $default_address = $this->input->post("default_address");
            //$socity_id = 1;
            $house_no = $this->input->post("house_no");
            $receiver_name = $this->input->post("receiver_name");
            $receiver_mobile = $this->input->post("receiver_mobile");
            $landmark = $this->input->post("landmark");
            $city   = $this->input->post("city");
            $add_type = $this->input->post("add_type"); //home, office, or etc

            $array = array(
                "user_id" => $user_id,
                "pincode" => $pincode,
                //"socity_id" => $socity_id,
                "lat" => $lat,
                "lang" => $lang,
                "default_address" => $default_address,
                "house_no" => $this->input->post("house_no"),
                "receiver_name" => $receiver_name,
                "receiver_mobile" => $receiver_mobile,
                'landmark'  => $landmark,
                'city'   => $city,
                'state'   => $this->input->post("state"),
                'add_type' => $add_type
            );
            
            if(!empty($this->input->post("default_address")))
               {
                    $q = $this->db->query("update user_location set default_address = ''
                    where user_id = '" . $this->input->post("user_id") . "'");
               }
            
            $this->db->insert("user_location", $array);
            $insert_id = $this->db->insert_id();
            $q = $this->db->query("Select user_location.*,
                    pincode.* from user_location 
                    inner join pincode on pincode.pincode = user_location.pincode
                    where location_id = '" . $insert_id . "'");
            $data["responce"] = true;
            $data["data"] = $q->row();
        }
        echo json_encode($data);
    }

    function add_address_old() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'Pincode', 'trim|required');
        $this->form_validation->set_rules('pincode', 'Pincode ID', 'trim|required');
        $this->form_validation->set_rules('socity_id', 'Socity', 'trim|required');
        $this->form_validation->set_rules('house_no', 'House', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        } else {
            $user_id = $this->input->post("user_id");
            $pincode = $this->input->post("pincode");
            $socity_id = $this->input->post("socity_id");
            $house_no = $this->input->post("house_no");
            $receiver_name = $this->input->post("receiver_name");
            $receiver_mobile = $this->input->post("receiver_mobile");

            $array = array(
                "user_id" => $user_id,
                "pincode" => $pincode,
                "socity_id" => $socity_id,
                "house_no" => $this->input->post("house_no"),
                "receiver_name" => $receiver_name,
                "receiver_mobile" => $receiver_mobile
            );

            $this->db->insert("user_location", $array);
            $insert_id = $this->db->insert_id();
            $q = $this->db->query("Select user_location.*,
                    socity.* from user_location 
                    inner join socity on socity.socity_id = user_location.socity_id
                    where location_id = '" . $insert_id . "'");
            $data["responce"] = true;
            $data["data"] = $q->row();
        }
        echo json_encode($data);
    }

    public function edit_address() {
        $data = array();
        $this->load->library('form_validation');
        /* add users table validation */
        $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        //$this->form_validation->set_rules('socity_id', 'Socity ID', 'trim');
        $this->form_validation->set_rules('lat', 'Latitude', 'trim');
        $this->form_validation->set_rules('lang', 'Langitude', 'trim');
        $this->form_validation->set_rules('default_address', 'Default Address', 'trim');
        $this->form_validation->set_rules('house_no', 'House Number', 'trim|required');
        $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'trim|required');
        $this->form_validation->set_rules('receiver_mobile', 'Receiver Mobile', 'trim|required');
        $this->form_validation->set_rules('location_id', 'Location ID', 'trim|required');
        $this->form_validation->set_rules('receiver_mobile', 'Mobile No.', 'trim|regex_match[/^[0-9]{10}$/]'); //regex_match[/^[0-9]{10}$/]

        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
            $insert_array = array(
                "pincode"           => $this->input->post("pincode"),            
                //"socity_id"         => $this->input->post("socity_id"),
                "lat"               => $this->input->post("lat"),
                "lang"              => $this->input->post("lang"),
                "default_address"   => $this->input->post("default_address"),
                "house_no"          => $this->input->post("house_no"),
                "receiver_name"     => $this->input->post("receiver_name"),
                "receiver_mobile"   => $this->input->post("receiver_mobile"),
                'landmark'          => $this->input->post("landmark"),
                'city'              => $this->input->post("city"),
                'state'             => $this->input->post("state"),
                'add_type'          => $this->input->post("add_type")
            );

            $this->load->model("common_model");

            if(!empty($this->input->post("default_address")))
               {
                    $q = $this->db->query("update user_location set default_address = ''
                    where user_id = '" . $this->input->post("user_id") . "'");
               }
            

            $this->common_model->data_update("user_location", $insert_array, array("location_id" => $this->input->post("location_id")));

            $q = $this->db->query("Select user_location.*,
                    pincode.* from user_location 
                    inner join pincode on pincode.pincode = user_location.pincode
                    where location_id = '" . $this->input->post("location_id") . "'");
                    
            $data["responce"] = true;
            $data["data"] = $q->row();
        }

        echo json_encode($data);
    }

    /* Delete Address */

    public function delete_address() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('location_id', 'Location ID', 'trim|required');
        $this->form_validation->set_rules('user_id', 'User id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {

            $this->db->delete("user_location", array("location_id" => $this->input->post("location_id"),"user_id" => $this->input->post("user_id")));

            $data["responce"] = true;
            $data["message"] = 'Your Address deleted successfully...';
        }
        echo json_encode($data);
    }

    /* End Delete  Address */

    function get_address() {
//        echo $this->input->post("user_id");die;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'User', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        } else {
            $user_id = $this->input->post("user_id");
            
            
            $q = $this->db->query("Select user_location.*, pincode.*, CONCAT_WS(' ', user_location.house_no, user_location.landmark, user_location.city, user_location.state, pincode.pincode) as address 
				from user_location
				inner join pincode on pincode.pincode = user_location.pincode
				where user_id = '" . $user_id . "'");


            $result_data = $q->result();

            
            $data["responce"] = true;
            $data["data"] = $result_data;
        }
        echo json_encode($data);
    }

    /* contact us */

    public function support() {

        $q = $this->db->query("select * from `pageapp` WHERE id =1");


        $data["responce"] = true;
        $data['data'] = $q->result();


        echo json_encode($data);
    }

    /* end contact us */

    /* about us */

    public function aboutus() {

        $q = $this->db->query("select * from `pageapp` where id=2");


        $data["responce"] = true;
        $data['data'] = $q->result();


        echo json_encode($data);
    }

    /* end about us */
    /* about us */

    public function terms() {

        $q = $this->db->query("select * from `pageapp` where id=3");


        $data["responce"] = true;
        $data['data'] = $q->result();


        echo json_encode($data);
    }
    public function faq() {

        $q = $this->db->query("select * from `pageapp` where id=5");


        $data["responce"] = true;
        $data['data'] = $q->result();


        echo json_encode($data);
    }
    /* end about us */

    public function register_fcm() {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
        $this->form_validation->set_rules('token', 'Token', 'trim|required');
        $this->form_validation->set_rules('device', 'Device', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = $this->form_validation->error_string();
        } else {
            $device = $this->input->post("device");
            $token = $this->input->post("token");
            $user_id = $this->input->post("user_id");

            $field = "";
            if ($device == "android") {
                $field = "user_ios_token";
            } else if ($device == "ios") {
                $field = "user_ios_token";
            }
            if ($field != "") {
                $this->db->query("update registers set " . $field . " = '" . $token . "' where user_id = '" . $user_id . "'");
                $data["responce"] = true;
            } else {
                $data["responce"] = false;
                $data["message"] = "Device type is not set";
            }
        }
        echo json_encode($data);
    }

    public function test_fcm() {
        $message["title"] = "test";
        $message["message"] = "grocery test";
        $message["image"] = "";
        $message["created_at"] = date("Y-m-d");

        //$this->load->helper('gcm_helper');
        $this->load->helper('fcm_helper');
        //$gcm = new GCM();
        $fcm = new FCM();
        // $result = $gcm->send_notification(array("AIzaSyCeC9WQR38Sbg7EAM40YVxZGgVSOOAxwjE"),$message ,"android");
        // $result= $gcm->send_topics("/topics/grocery",$message ,"android");
        // $result = $gcm->send_notification(array("AIzaSyCeC9WQR38Sbg7EAM40YVxZGgVSOOAxwjE"),$message ,"android");
        $result = $fcm->send_topics("gorocer", $message, "android");
        //print_r($result);
        echo $result;
    }

    /* Forgot Password */

    public function forgot_password() {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_phone', 'User Phone', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["status"] = "0";
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
            $request = $this->db->query("Select * from registers where user_phone = '" . $this->input->post("user_phone") . "' limit 1");
            if ($request->num_rows() > 0) {

                $user = $request->row();
                //$token = uniqid(uniqid());
                //$this->db->update("registers",array("varified_token"=>$token),array("user_id"=>$user->user_id)); 
                //$this->load->library('email');
                //$this->email->from($this->config->item('default_email'), $this->config->item('email_host'));
                if(!empty($this->input->post('user_password'))){
                    $code       = $this->input->post('user_password'); //mt_rand(100000, 999999);
                    $user_phone = $this->input->post('user_phone');
    
                    $update = $this->db->query("UPDATE `registers` SET user_password='" . md5($code) . "' where user_phone='" . $user_phone . "' ");
                    // $email = $user->user_email;
                    // $name = $user->user_fullname;
                    // $return = $this->send_email_verified_mail($email,$token,$name);
    
                    if ($update) {
                        //$msg = "New Password :  . $code";
                        //TEmplate 
                        $emailforgot_password     =   $this->emailTemplate(8);
                        $smsforgot_password       =   $this->smsTemplate(8);
                        $use                      =   $user;
                        $user_phone               =   $use->user_phone;
                        $token = array(
                                'Name'      => $use->user_fullname,
                                'Password'  => $code,
                                'Website'   => $this->config->item('name')
                            );
                            $pattern = '[%s]';
                            foreach($token as $key=>$val){
                                $varMap[sprintf($pattern,$key)] = $val;
                            }
                        $msg               =  strtr($smsforgot_password,$varMap);
                        $message1["title"] = "Forgot Password";
                        $message1["message"] = strtr($smsforgot_password,$varMap);
                        $message1["image"] = base_url()."uploads/company/".$this->config->item('logo');
                        $message1["created_at"] = date("Y-m-d h:i:s");
                        $message1["obj"] = "";
        
                        /*Order Mail Send Start*/
                        $to_mail_arr = array();
                        $to_mail_arr[0] = array('to_mail' => $use->user_email, 'to_name' => $use->user_fullname);
                        $cc_mail_arr = array();
                        $reply_to_mail_arr = array();
                        $reply_to_mail_arr[0] = array('reply_mail'=>$this->config->item('email'),'reply_name'=>'noreply');
                        $mail_subject = "Forgot Password";
                        $mail_attachment_arr = array();
                        $from_mail_arr = array();
                        $from_mail_arr[0] = array('from_mail' => $this->config->item('email'), 'from_name' => $this->config->item('name'));
                        $message = "<a href='".base_url()."' title='".$this->config->item('name')."'><img src='".base_url()."uploads/company/".$this->config->item('logo')."' style='float:right; width:30%;' alt='".$this->config->item('name')."' title='".$this->config->item('name')."'></a><br><br><br><br>";
                   
                        $message .= strtr($emailforgot_password,$varMap);
                        
                        $this->send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr);
                       
                        /*Register Mail Send End*/
                       /*Register SMS*/
                        
                        $this->setting_model->sendsmsPOST($user_phone, $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));
        
                        //Template
                        /*Order Mail Send End*/
                        if(!empty($this->config->item('firebase_key'))){
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();
                            $message2["title"] = "Forgot Password";
                            $message2["message"] = strtr($smsforgot_password,$varMap);
                            $message2["icon"]  = base_url()."uploads/company/".$this->config->item('favicon');
                            
                            $message2["created_at"] = date("Y-m-d h:i:s");
                            if ($user->user_gcm_code != "") {
                                $result = $gcm->send_notification($user->user_gcm_code, $message2, "android",$this->config->item('firebase_key'));
                            }
                            if ($user->user_ios_token != "") {
                                $result = $gcm->send_notification(array($user->user_ios_token), $message2, "ios",$this->config->item('firebase_key'));
                            }
                            //print_r($result); exit;
                        }
                       
                        $msg = "New Password Send On Registered Mobile No & Email.";
                        
                        $data["status"]     = "1";
                        $data["message"]    = "Success! : " . $msg;
                        $data['code']       = $code;  
                    } else {
                        $data["status"] = "0";
                        $data["message"] = 'Warning! : Something is wrong with system.';
                    }
                }
                else{
                    $data["status"]     = "1";
                    $data["message"]    = "Success!";
                    $data['code']       = '';  
                }
                
            } else {
                $data["status"] = "0";
                $data["message"] = 'Warning! : No user found with this Mobile Number.';
                //$data["error_arb"] = 'خطـأ! : لا يوجد مستخدم مسجل بهذا البريد الإلكتروني.';
            }
        }
        echo json_encode($data);
    }

    public function send_email_verified_mail($email, $token, $name) {
        $message = $this->load->view('users/modify_password', array("name" => $name, "active_link" => site_url("users/verify_email?email=" . $email . "&token=" . $token)), TRUE);

        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->to($email);
        $this->email->from('saurabh.rawat@tecmanic.com', 'Saurabh Rawat');
        $this->email->subject('Forgot password request');
        $this->email->message('Hi ' . $name . ' \n Your password forgot request is accepted plase visit following link to change your password. \n
                                ' . base_url() . 'users/modify_password/' . $token);

        return $this->email->send();
    }

    /* End Forgot Password */

    public function wallet() {
        $data = array();
        $q = $this->db->query("Select wallet  from registers where user_id ='" . $this->input->post('user_id') . "'");
        if ($q->num_rows() > 0) {

            $row        =   $q->row();
            $wallet     =   $row->wallet;
            
            $data = array("responce" => 'true', "wallet" => $wallet);
        } else {
            $data = array("responce" => 'false', "wallet" => 0);
        }
        echo json_encode($data);
    }

    public function rewards() {
        $data = array();
        $_GET = $_REQUEST;
        if ($this->input->post('user_id') == "") {
            $data = array("responce" => false, "total_rewards" => 0);
        } else {
            // $q = $this->db->query("Select sum(total_rewards) AS total_rewards from `delivered_order` where(user_id='".$this->input->get('user_id')."' )");
            $q = $this->db->query("Select rewards from `registers` where(user_id='" . $this->input->post('user_id') . "' )");
            error_reporting(0);
            if ($q->num_rows() > 0) {

                $row = $q->row();

                $data = array("responce" => true, "total_rewards" => $row->rewards);
            } else {
                $data = array("responce" => false, "total_rewards" => 0);
            }
        }
        echo json_encode($data);
    }

    public function shift() {
        $data = array();
        $_POST = $_REQUEST;
        if ($this->input->post('user_id') == "") {
            $data = array("responce" => false, "total_rewards" => 0);
        } else {
            error_reporting(0);
            $amount = $this->input->post('amount');
            $rewards = $this->input->post('rewards');
            //$user_id=$this->input->post('user_id');
            //$final_amount=$amount+$rewards;
            //$reward_value = $rewards*.50; 
            $final_rewards = 0;


            $select = $this->db->query("SELECT * from rewards where id=1");
            if ($select->num_rows() > 0) {
                $row = $select->row_array();
                $point = $row['point'];
            }

            $reward_value = $point * $rewards;
            $final_amount = $amount + $reward_value;
            $data["wallet_amount"] = [array("final_amount" => $final_amount, "final_rewards" => 0, "amount" => $amount, "rewards" => $rewards, "pont" => $point)];
            $this->db->query("delete from delivered_order where user_id = '" . $this->input->post('user_id') . "'");
            $this->db->query("UPDATE `registers` SET wallet='" . $final_amount . "', rewards='0' where(user_id='" . $this->input->post('user_id') . "' )");
        }
        echo json_encode($data);
    }

    public function wallet_on_checkout() {
        $data = array();
        $_POST = $_REQUEST;
        if ($this->input->post('wallet_amount') >= $this->input->post('total_amount')) {
            /*
              $wallet_amount = $this->input->post('wallet_amount');
              $amount = $this->input->post('total_amount');

              $final_amount = $wallet_amount - $amount;
              $balance = 0;

              $data["final_amount"] = [array("wallet" => $final_amount, "total" => $balance)];
             * 
             */
            $wallet_amount = $this->input->post('wallet_amount');
            $amount = $this->input->post('total_amount');
            $final_amount = $wallet_amount;
            //$wallet_amount *=.2; 
            $wallet_amount = $amount * ($this->config->item('wallet_deduction')/100);
            $final_amount -= $wallet_amount;
            $balance = $amount - $wallet_amount;
            //number_format(, 2, '.', '')
            $data["final_amount"] = [array(
            "wallet" => number_format($final_amount, 2, '.', ''),
            "total" => number_format($balance, 2, '.', ''),
            "used_wallet" => number_format($wallet_amount, 2, '.', '')
            )];
        }
        if ($this->input->post('wallet_amount') <= $this->input->post('total_amount')) {
            /*
              $wallet_amount = $this->input->post('wallet_amount');
              $amount = $this->input->post('total_amount');

              $final_amount = 0;
              $balance = $amount - $wallet_amount;

              $data["final_amount"] = [array(
              "wallet" => $final_amount,
              "total" => $balance,
              "used_wallet" => $wallet_amount
              )];
             * 
             */
            $wallet_amount = $this->input->post('wallet_amount');
            $amount = $this->input->post('total_amount');
            $final_amount = $wallet_amount;
            $wallet_amount *= ($this->config->item('wallet_deduction')/100);//10%
            $final_amount -= $wallet_amount;
            $balance = $amount - $wallet_amount;
            //number_format(, 2, '.', '')
            $data["final_amount"] = [array(
            "wallet" => number_format($final_amount, 2, '.', ''),
            "total" => number_format($balance, 2, '.', ''),
            "used_wallet" => number_format($wallet_amount, 2, '.', '')
            )];
        } else {
            
        }

        echo json_encode($data);
    }

    public function recharge_wallet() {
        $data = array();
        $_POST = $_REQUEST;
        //print_r($_POST);

        // $q = $this->db->query("Select wallet from `registers` where(user_id='" . $this->input->post('user_id') . "' )");
        // error_reporting(0);
        // if ($q->num_rows() > 0) {

        //     $row = $q->row();

        //     $current_amount = $q->row()->wallet;
        //     $request_amount = $this->input->post('wallet_amount');

        //     $new_amount = $current_amount + $request_amount;
        //     $this->db->query("UPDATE `registers` SET wallet='" . $new_amount . "' where(user_id='" . $this->input->post('user_id') . "' )");

        //     $data = array("success" => success, "wallet_amount" => "$new_amount");
        // }
        $recharge_status = $this->input->post('recharge_status');
        $transaction_id = $this->input->post('transaction_id');
        $user_id = $this->input->post('user_id');
        
        if(!empty($transaction_id))
        {
            $q = $this->db->query("Select wallet from `registers` where(user_id='" . $this->input->post('user_id') . "' )");
            //error_reporting(0);
            if ($q->num_rows() > 0) {
    
                $row = $q->row();
    
                $current_amount = $q->row()->wallet;
                $request_amount = $this->input->post('amount');
				
                $new_amount = round(($current_amount + $request_amount), 2);
    
                $this->db->query("UPDATE `registers` SET wallet='" . $new_amount . "' where(user_id='" . $this->input->post('user_id') . "' )");
                
                $description_msg_wallet = "'Credit By User trasaction ID: ".$transaction_id."'";
                
                $today_date = date("Y-m-d H:i:s");

                $this->db->query("insert into wallet_history(user_id, transaction_by, description, cr_id, created_date) values('$user_id', 'Recharge', $description_msg_wallet, '$request_amount', '$today_date')");
    
                $data = array("success" => "success", "wallet_amount" => ''.$new_amount.'');
				
            }
        }
        else
        {
            $data = array("success" => "failed", "wallet_amount" => '0.00');
        }
        echo json_encode($data);
    }

    public function deelOfDay() {
        $data = array();
        $_POST = $_REQUEST;
        error_reporting(0);
        $q = $this->db->get('deelofday');
        $data[responce] = "true";
        $data[Deal_of_the_day] = $q->result();
        echo json_encode($data);
    }

    public function top_selling_product() { //ok
        $data = array();
        $_POST = $_REQUEST;
        error_reporting(0);
        /*
          $q = $this->db->query("select p.*,dp.start_date,dp.start_time,dp.end_time,dp.deal_price,c.title,
          p.mrp - p.price as difference_price,
          count(si.product_id) as top,si.product_id from products p
          INNER join sale_items si on p.product_id=si.product_id INNER join categories c ON c.id=p.category_id
          left join deal_product dp on dp.product_id=si.product_id GROUP BY si.product_id order by top DESC LIMIT 16");
         * 
         */
//        $sql = "SELECT 
//                    p.*,
//                    dp.start_date,
//                    dp.start_time,
//                    dp.end_time,
//                    dp.deal_price,
//                    c.title,
//                    p.mrp - p.price AS difference_price
//
//                FROM
//                    products p
//                        INNER JOIN
//                    categories c ON c.id = p.category_id
//                        LEFT JOIN
//                    deal_product dp ON dp.product_id = p.product_id
//                GROUP BY p.product_id
//                ORDER BY p.product_id DESC LIMIT 16;";
        $sql = "SELECT 
		p.*,
		dp.start_date,
		dp.start_time,
		dp.end_time,
		dp.deal_price,
		( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock,
		c.title,
		p.mrp - p.price AS difference_price, tbl_brand.title as brand_name

	    FROM
		products p
		INNER JOIN categories c ON c.id = p.category_id
        left outer join(select SUM(qty) as c_qty,product_id from sale_items INNER JOIN sale on sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = p.product_id 
		left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = p.product_id
		LEFT JOIN deal_product dp ON dp.product_id = p.product_id
		LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                WHERE p.trash = 0
                GROUP BY p.product_id
                ORDER BY p.product_id DESC LIMIT 16;";
        $q = $this->db->query($sql);
        $data[responce] = "true";
        //print_r($q->result());exit();
        //$data[top_selling_product] = $q->result();
        foreach ($q->result() as $product) {
            $present = date('m/d/Y h:i:s a', time());
            $date1 = $product->start_date . " " . $product->start_time;
            $date2 = $product->start_date . " " . $product->end_time;

            if (strtotime($date1) <= strtotime($present) && strtotime($present) <= strtotime($date2)) {

                if (empty($product->deal_price)) {   ///Runing
                    $price = $product->price;
                } else {
                    $price = $product->deal_price;
                }
            } else {
                $price = $product->price; //expired
            }
            // if (strlen($product->product_name) >= 20) {
            //     $product_name = $product->product_name;
            // } else {
            //     $product_name = $product->product_name;
            // }
            $data[top_selling_product][] = array(
                'product_id' => $product->product_id,
                'product_name' => $product->product_name, //$product->product_name,
                'product_name_arb' => $product->product_arb_name,
                'product_description_arb' => $product->product_arb_description,
                'category_id'               => $product->category_id,
                'brand_id'                  => !empty($product->brand_id) ? $product->brand_id : 0,
                'brand_name' => $product->brand_name,
                'product_description' => $product->product_description,
                'deal_price' => '',
                'start_date' => '',
                'start_time' => '',
                'end_date' => '',
                'end_time' => '',
                'product_description' => $product->product_description,
                'difference_price' => number_format((float) $product->difference_price, 2, '.', ''),
                'price' => $price,
                'mrp' => $product->mrp,
                'product_image' => 'products/'.$product->product_image,
                'status' => '',
                'in_stock' => $product->in_stock,
                'unit_value' => $product->unit_value,
                'unit' => $product->unit,
                'increament' => $product->increament,
                'rewards' => $product->rewards,
                'stock' => $product->stock,
                'title' => $product->title
            );
        }

        echo json_encode($data);
    }

    public function get_all_top_selling_product() {
        $data = array();
        $_POST = $_REQUEST;
        error_reporting(0);
        if ($this->input->post('top_selling_product')) {
            //$q = $this->db->query("select p.*,dp.start_date,dp.start_time,dp.end_time,dp.deal_price,c.title,count(si.product_id) as top,si.product_id from products p INNER join //sale_items si on p.product_id=si.product_id INNER join categories c ON c.id=p.category_id left join deal_product dp on dp.product_id=si.product_id GROUP BY si.product_id //order by top DESC LIMIT 8");


            $q = $this->db->query("Select dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title, tbl_brand.title as brand_name from products 
            inner join categories on categories.id = products.category_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items INNER JOIN sale on sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            left join deal_product dp on dp.product_id=products.product_id 
            LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
           where 1 AND products.trash = 0 " . $filter . " " . $limit);
            //$products =$q->result();  

            $data[responce] = "true";
            foreach ($q->result() as $product) {
                $present = date('m/d/Y h:i:s a', time());
                $date1 = $product->start_date . " " . $product->start_time;
                $date2 = $product->end_date . " " . $product->end_time;

                if (strtotime($date1) <= strtotime($present) && strtotime($present) <= strtotime($date2)) {

                    if (empty($product->deal_price)) {   ///Runing
                        $price = $product->price;
                    } else {
                        $price = $product->deal_price;
                    }
                } else {
                    $price = $product->price; //expired
                }

                $data[top_selling_product][] = array(
                    'product_id'                => $product->product_id,
                    'product_name'              => $product->product_name,
                    'product_name_arb'          => $product->product_arb_name,
                    'product_description_arb'   => $product->product_arb_description,
                    'category_id'               => $product->category_id,
                    'brand_id'                  => !empty($product->brand_id) ? $product->brand_id : 0,
                    'brand_name'                => $product->brand_name,
                    'product_description'       => $product->product_description,
                    'deal_price'                => '',
                    'start_date'                => '',
                    'start_time'                => '',
                    'end_date'                  => '',
                    'end_time'                  => '',
                    'price'                     => $price,
                    'mrp'                       => $product->mrp,
                    'product_image'             => 'products/'.$product->product_image,
                    'status'                    => '',
                    'in_stock'                  => $product->in_stock,
                    'unit_value'                => $product->unit_value,
                    'unit'                      => $product->unit,
                    'increament'                => $product->increament,
                    'rewards'                   => $product->rewards,
                    'stock'                     => $product->stock,
                    'title'                     => $product->title
                );
            }
        }
        echo json_encode($data);
    }

    public function deal_product() {

        $data = array();
        $_POST = $_REQUEST;
        error_reporting(0);
        //products.mrp - products.price as difference_price,
        $sql = "SELECT deal_product.*,products.*,categories.title from deal_product 
                inner JOIN products on deal_product.product_name = products.product_name 
                INNER JOIN categories on categories.id=products.category_id limit 16";
        $sql = "SELECT 
                    ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock,
                        deal_product.*, products.*, categories.title, tbl_brand.title as brand_name
                    FROM
                        deal_product
                            INNER JOIN
                        products ON deal_product.product_name = products.product_name
                            INNER JOIN
                        categories ON categories.id = products.category_id
                        INNER JOIN product_varient ON product_varient.varient_id = deal_product.pro_var_id
                        left outer join(select SUM(qty) as c_qty,product_id from sale_items INNER JOIN sale on sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = products.product_id 
                        left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                        LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1    
                            where 1 AND products.trash = 0 
                    LIMIT 16";
        $q = $this->db->query($sql);

        // $this->db->query("SELECT dp.*,p.*,c.title from deal_product dp inner JOIN products p on dp.product_name = p.product_name INNER JOIN categories c on c.id=p.category_id limit 4");

        $data['responce'] = "true";
        // $data['Deal_of_the_day']=array();
        foreach ($q->result() as $product) {

            $present = date('d/m/Y H:i ', time());
            $date1 = $product->start_date . " " . $product->start_time;
            $date2 = $product->end_date . " " . $product->end_time;

            if ($date1 <= $present && $present <= $date2) {
                $status = 1; //running 
            } else if ($date1 > $present) {
                $status = 2; //is going to 
                continue;
            } else {
                $status = 0; //expired
                continue;
            }

            // if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
            // {
            //   $status = 1;//running 
            // }else if(strtotime($date1) > strtotime($present)){
            //  $status = 2;//is going to
            // }else{
            //  $status = 0;//expired
            // } 
            // if (strlen($product->product_name) >= 20) {
            //     $product_name = substr($product->product_name, 0, 15) . " ... ";
            // } else {
            //     $product_name = $product->product_name;
            // }
			
			
            $data['Deal_of_the_day'][] = array(
                'category_id'       => $product->category_id,
                'brand_id'          => !empty($product->brand_id) ? $product->brand_id : 0,
                'product_id'        => $product->product_id,
                'product_name'      => $product->product_name, //$product->product_name,
                'product_name_arb'  => $product->product_arb_name,
                'product_description_arb' => $product->product_arb_description,
                'product_description' => $product->product_description,
                'brand_name'        => $product->brand_name,
                'start_date'        => $product->start_date,
                'start_time'        => $product->start_time,
                'end_date'          => $product->end_date,
                'end_time'          => $product->end_time,
                'deal_price'        => !empty($product->price) ? $product->price : 0, //$product->deal_price,
                'price'             => $product->mrp, //$product->price,
                'difference_price'  => intval($product->mrp) - intval($product->price), //intval($product->price) - intval($product->deal_price),
                'mrp'               => $product->mrp,
                'product_image'     => 'products/'.$product->product_image,
                'status'            => $status,
                'in_stock'          => $product->in_stock,
                'unit_value'        => $product->unit_value,
                'unit'              => $product->unit,
                'increament'        => $product->increament,
                'rewards'           => $product->rewards,
                'stock'             => $product->stock_inv,
                'title'             => $product->title,
                'in_stock'          => $product->in_stock,
            );
        }
        echo json_encode($data);
    }
    
    
    //Recent
    public function recentselling(){
        $user_id = $this->input->post("user_id");
        $sql = "SELECT  
                    p.*, dp.start_date, dp.start_time, dp.end_date, dp.end_time, dp.deal_price, c.title,
                    p.mrp - p.price AS difference_price,
                    si.product_id , product_varient.*, tbl_brand.title as brand_name,
                    count(rating_table.product_id) as review_count, IFNULL(AVG(rating_table.rating),0) as ratings_average
                FROM
                    products p
                        INNER JOIN sale_items si ON p.product_id = si.product_id
                        INNER JOIN product_varient ON product_varient.varient_id = si.pro_var_id
                        INNER JOIN categories c ON c.id = p.category_id
                        LEFT JOIN deal_product dp ON dp.product_id = si.product_id
                        LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                        LEFT JOIN rating_table on rating_table.product_id = p.product_id
                    WHERE p.trash = 0
                    GROUP BY si.product_id
                    ORDER BY rand()
                    LIMIT 0,12";

                    //echo $sql;die;
        $query = $this->db->query($sql);
        if(count($query->result()) > 0){
            foreach ($query->result() as $product) {
                $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product->product_id."'");
				$variants_pro       = $q_variants->result_array();
                $present = date('Y-m-d H:i:s', time());
                $date1 = $product->start_date . " " . $product->start_time;
                $date1 = date('Y-m-d H:i:s', strtotime($date1));
                $date2 = $product->end_date . " " . $product->end_time;
                $date2 = date('Y-m-d H:i:s', strtotime($date2));
                if ($date1 <= $present && $present <= $date2) {
    
                    if (empty($product->deal_price)) {   ///Runing
                        $price = $product->price;
                    } else {
                        $price = $product->deal_price;
                    }
                } else {
                    $price = $product->price; //expired
                }
                $product_call       =   $product->product_call == 1 ? $this->baseurl().'assets/images/swadeshi.png' : ''; 
                if($product->product_type == 1){
                    $title          =   "Vegetarian";
                }
                elseif($product->product_type == 2){
                    $title          =   "Non Vegetarian";
                }
                else{
                    $title          =   "";
                }
                
                //get wishlist product id by userid start from here
                $qqqq = $this->db->query('Select * from btl_wishlist WHERE user_id="'.$user_id.'" and product_id="'.$product->product_id.'"');
                $dataaa  = $qqqq->result();
//                echo "<br><br>";
//               print_r($dataaa);
           // echo "<br><br>";
                $wishlist="";
                if(count($dataaa) > 0){
                    $wishlist          =   "true";
                }
                else{
                    $wishlist          =   "false";
                }
				$is_purchase = '0';
				$sale_items = $this->db->query("SELECT * FROM `sale_items` join sale on sale.sale_id = sale_items.sale_id and sale_items.product_id='".$product->product_id."' WHERE sale.user_id='".$user_id."'")->row();
				if(!empty($sale_items)){
					$is_purchase = '1';
				}
                //get wishlist product id by userid start from end
                
                
                //print_r($product); exit;
                    $data[] = array(
                        "varient_id"        => $product->varient_id,
                        "product_id"        => $product->product_id,
                        "product_name"      => $product->product_name,
                        "product_image"     => "products/".$product->product_image,
                        "description"       => $product->product_description,
                        "price"             => $price,
                        "mrp"               => $product->mrp,
                        "varient_image"     => 'products/'.$product->pro_var_images,
                        "unit"              =>  $product->unit,
                        "quantity"          =>  $product->qty,
                        "count"             =>  count($variants_pro),
                         'veg'              =>  $title,
                        'swadesi'           =>  $product_call,
                        'brand_name'        =>  $product->brand_name,
                        'stock'             => !empty($variants_pro[0]['stock_inv']) ? $variants_pro[0]['stock_inv'] : "0",
                        'in_stock'          => !empty($product->in_stock) ? $product->in_stock : "0",
                        'category_id'       => $product->category_id,
                        'brand_id'          => !empty($product->brand_id) ? $product->brand_id : 0,
                        'wishlist'          => $wishlist,
                        'is_purchase'       => $is_purchase,
                        "review_count"      => $product->review_count,
                        "ratings_average"   => $product->ratings_average,
                    );
            }
            
            $message = array('status'=>'1', 'message'=>'Products found', 'data'=>$data);
        }
        else{
            $message = array('status'=>'0', 'message'=>'Products not found', 'data'=>[]);
        }
        echo json_encode($message);
    }
    //Whats New
    public function whatsnew(){
        $user_id = $this->input->post("user_id");
        $sql = "SELECT  
                    p.*, dp.start_date, dp.start_time, dp.end_date, dp.end_time, dp.deal_price, c.title,
                    p.mrp - p.price AS difference_price, tbl_brand.title as brand_name,
                    count(rating_table.product_id) as review_count, IFNULL(AVG(rating_table.rating),0) as ratings_average
                FROM
                    products p
                    INNER JOIN categories c ON c.id = p.category_id
                    LEFT JOIN deal_product dp ON dp.product_id = p.product_id
                    LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                    LEFT JOIN rating_table on rating_table.product_id = p.product_id 
                    WHERE p.trash = 0
                    GROUP BY p.product_id
                    ORDER BY p.product_id DESC 
                    LIMIT  0, 12";

                    //echo $sql;die;
        $query = $this->db->query($sql);
        if(count($query->result()) > 0){
            foreach ($query->result() as $product) {
                $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product->product_id."'");
				$variants_pro       = $q_variants->result_array();
                $present = date('Y-m-d H:i:s', time());
                $date1 = $product->start_date . " " . $product->start_time;
                $date1 = date('Y-m-d H:i:s', strtotime($date1));
                $date2 = $product->end_date . " " . $product->end_time;
                $date2 = date('Y-m-d H:i:s', strtotime($date2));
                $product_call       =   $product->product_call == 1 ? $this->baseurl().'assets/images/swadeshi.png' : ''; 
                if($product->product_type == 1){
                    $title          =   "Vegetarian";
                }
                elseif($product->product_type == 2){
                    $title          =   "Non Vegetarian";
                }
                else{
                    $title          =   "";
                }
                foreach($variants_pro as $variants){ //print_r($variants); exit;
                    if ($date1 <= $present && $present <= $date2) {
        
                        if (empty($product->deal_price)) {   ///Runing
                            $price = $variants['price'];
                        } else {
                            $price = $product->deal_price;
                        }
                    } else {
                        $price = $variants['price']; //expired
                    }
                    
                //get wishlist product id by userid start from here
                $qqqq = $this->db->query('Select * from btl_wishlist WHERE user_id="'.$user_id.'" and product_id="'.$product->product_id.'"');
                $dataaa  = $qqqq->result();
//                echo "<br><br>";
//               print_r($dataaa);
           // echo "<br><br>";
                $wishlist="";
                if(count($dataaa) > 0){
                    $wishlist          =   "true";
                }
                else{
                    $wishlist          =   "false";
                }
				
				$is_purchase = '0';
				$sale_items = $this->db->query("SELECT * FROM `sale_items` join sale on sale.sale_id = sale_items.sale_id and sale_items.product_id='".$product->product_id."' WHERE sale.user_id='".$user_id."'")->row();
				if(!empty($sale_items)){
					$is_purchase = '1';
				}
				
                //get wishlist product id by userid start from end
                    
                    $data[] = array(
                        "varient_id"        => $variants['varient_id'],
                        "product_id"        => $product->product_id,
                        "product_name"      => $product->product_name,
                        "product_image"     => "products/".$product->product_image,
                        "description"       => $product->product_description,
                        "price"             => $price,
                        "mrp"               => $variants['mrp'],
                        "varient_image"     => 'products/'.$variants['pro_var_images'],
                        "unit"              => $variants['unit'],
                        "quantity"          =>  $variants['qty'],
                        'veg'               =>  $title,
                        'swadesi'           =>  $product_call,
                        'brand_name'        =>  $product->brand_name,
                        'stock'             => !empty($variants['stock_inv']) ? $variants['stock_inv'] : "0",
                        'in_stock'          => !empty($product->in_stock) ? $product->in_stock : "0",
                        'category_id'       => $product->category_id,
                        'brand_id'          => !empty($product->brand_id) ? $product->brand_id : 0,
                        'wishlist'          => $wishlist,
                        'is_purchase'       => $is_purchase,
                        "review_count"      => $product->review_count,
                        "ratings_average"   => $product->ratings_average,
                    );
                }
               
            }
            
            $message = array('status'=>'1', 'message'=>'Products found', 'data'=>$data);
        }
        else{
            $message = array('status'=>'0', 'message'=>'nothing in new', 'data'=>[]);
        }
        echo json_encode($message);
    }
    
    public function brandwise(){
        $user_id = $this->input->post("user_id");
        $sql = "SELECT  
                    p.*, dp.start_date, dp.start_time, dp.end_date, dp.end_time, dp.deal_price, c.title,
                    p.mrp - p.price AS difference_price, tbl_brand.title as brand_name,
                    count(rating_table.product_id) as review_count, IFNULL(AVG(rating_table.rating),0) as ratings_average
                FROM
                    products p
                    INNER JOIN categories c ON c.id = p.category_id
                    LEFT JOIN deal_product dp ON dp.product_id = p.product_id
                    LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                    LEFT JOIN rating_table on rating_table.product_id = p.product_id 
                    WHERE p.trash = 0 AND p.brand_id IS NOT NULL
                    GROUP BY p.product_id
                    ORDER BY tbl_brand.title ASC 
                    LIMIT  0, 12";

                    //echo $sql;die;
        $query = $this->db->query($sql);
        if(count($query->result()) > 0){
            foreach ($query->result() as $product) {
                $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product->product_id."'");
				$variants_pro       = $q_variants->result_array();
                $present = date('Y-m-d H:i:s', time());
                $date1 = $product->start_date . " " . $product->start_time;
                $date1 = date('Y-m-d H:i:s', strtotime($date1));
                $date2 = $product->end_date . " " . $product->end_time;
                $date2 = date('Y-m-d H:i:s', strtotime($date2));
                $product_call       =   $product->product_call == 1 ? $this->baseurl().'assets/images/swadeshi.png' : ''; 
                if($product->product_type == 1){
                    $title          =   "Vegetarian";
                }
                elseif($product->product_type == 2){
                    $title          =   "Non Vegetarian";
                }
                else{
                    $title          =   "";
                }
                foreach($variants_pro as $variants){ //print_r($variants); exit;
                    if ($date1 <= $present && $present <= $date2) {
        
                        if (empty($product->deal_price)) {   ///Runing
                            $price = $variants['price'];
                        } else {
                            $price = $product->deal_price;
                        }
                    } else {
                        $price = $variants['price']; //expired
                    }
                    
                //get wishlist product id by userid start from here
                $qqqq = $this->db->query('Select * from btl_wishlist WHERE user_id="'.$user_id.'" and product_id="'.$product->product_id.'"');
                $dataaa  = $qqqq->result();
//                echo "<br><br>";
//               print_r($dataaa);
           // echo "<br><br>";
                $wishlist="";
                if(count($dataaa) > 0){
                    $wishlist          =   "true";
                }
                else{
                    $wishlist          =   "false";
                }
				
				$is_purchase = '0';
				$sale_items = $this->db->query("SELECT * FROM `sale_items` join sale on sale.sale_id = sale_items.sale_id and sale_items.product_id='".$product->product_id."' WHERE sale.user_id='".$user_id."'")->row();
				if(!empty($sale_items)){
					$is_purchase = '1';
				}
				
                //get wishlist product id by userid start from end
                    
                    $data[] = array(
                        "varient_id"        => $variants['varient_id'],
                        "product_id"        => $product->product_id,
                        "product_name"      => $product->product_name,
                        "product_image"     => "products/".$product->product_image,
                        "description"       => $product->product_description,
                        "price"             => $price,
                        "mrp"               => $variants['mrp'],
                        "varient_image"     => 'products/'.$variants['pro_var_images'],
                        "unit"              => $variants['unit'],
                        "quantity"          =>  $variants['qty'],
                        'veg'               =>  $title,
                        'swadesi'           =>  $product_call,
                        'brand_name'        =>  $product->brand_name,
                        'stock'             => !empty($variants['stock_inv']) ? $variants['stock_inv'] : "0",
                        'in_stock'          => !empty($product->in_stock) ? $product->in_stock : "0",
                        'category_id'       => $product->category_id,
                        'brand_id'          => !empty($product->brand_id) ? $product->brand_id : 0,
                        'wishlist'          => $wishlist,
                        'is_purchase'       => $is_purchase,
                        "review_count"      => $product->review_count,
                        "ratings_average"   => $product->ratings_average,
                    );
                }
               
            }
            
            $message = array('status'=>'1', 'message'=>'Products found', 'data'=>$data);
        }
        else{
            $message = array('status'=>'0', 'message'=>'nothing in new', 'data'=>[]);
        }
        echo json_encode($message);
    }
    
    public function ratingwise(){
        $user_id = $this->input->post("user_id");
        $sql = "SELECT  
                    p.*, dp.start_date, dp.start_time, dp.end_date, dp.end_time, dp.deal_price, c.title,
                    p.mrp - p.price AS difference_price, tbl_brand.title as brand_name,
                    count(rating_table.product_id) as review_count, IFNULL(AVG(rating_table.rating),0) as ratings_average
                FROM
                    products p
                    INNER JOIN categories c ON c.id = p.category_id
                    LEFT JOIN deal_product dp ON dp.product_id = p.product_id
                    LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                    LEFT JOIN rating_table on rating_table.product_id = p.product_id 
                    WHERE p.trash = 0
                    GROUP BY p.product_id
                    ORDER BY ratings_average DESC 
                    LIMIT  0, 12";

                    //echo $sql;die;
        $query = $this->db->query($sql);
        if(count($query->result()) > 0){
            foreach ($query->result() as $product) {
                $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product->product_id."'");
				$variants_pro       = $q_variants->result_array();
                $present = date('Y-m-d H:i:s', time());
                $date1 = $product->start_date . " " . $product->start_time;
                $date1 = date('Y-m-d H:i:s', strtotime($date1));
                $date2 = $product->end_date . " " . $product->end_time;
                $date2 = date('Y-m-d H:i:s', strtotime($date2));
                $product_call       =   $product->product_call == 1 ? $this->baseurl().'assets/images/swadeshi.png' : ''; 
                if($product->product_type == 1){
                    $title          =   "Vegetarian";
                }
                elseif($product->product_type == 2){
                    $title          =   "Non Vegetarian";
                }
                else{
                    $title          =   "";
                }
                foreach($variants_pro as $variants){ //print_r($variants); exit;
                    if ($date1 <= $present && $present <= $date2) {
        
                        if (empty($product->deal_price)) {   ///Runing
                            $price = $variants['price'];
                        } else {
                            $price = $product->deal_price;
                        }
                    } else {
                        $price = $variants['price']; //expired
                    }
                    
                //get wishlist product id by userid start from here
                $qqqq = $this->db->query('Select * from btl_wishlist WHERE user_id="'.$user_id.'" and product_id="'.$product->product_id.'"');
                $dataaa  = $qqqq->result();
//                echo "<br><br>";
//               print_r($dataaa);
           // echo "<br><br>";
                $wishlist="";
                if(count($dataaa) > 0){
                    $wishlist          =   "true";
                }
                else{
                    $wishlist          =   "false";
                }
				
				$is_purchase = '0';
				$sale_items = $this->db->query("SELECT * FROM `sale_items` join sale on sale.sale_id = sale_items.sale_id and sale_items.product_id='".$product->product_id."' WHERE sale.user_id='".$user_id."'")->row();
				if(!empty($sale_items)){
					$is_purchase = '1';
				}
				
                //get wishlist product id by userid start from end
                    
                    $data[] = array(
                        "varient_id"        => $variants['varient_id'],
                        "product_id"        => $product->product_id,
                        "product_name"      => $product->product_name,
                        "product_image"     => "products/".$product->product_image,
                        "description"       => $product->product_description,
                        "price"             => $price,
                        "mrp"               => $variants['mrp'],
                        "varient_image"     => 'products/'.$variants['pro_var_images'],
                        "unit"              => $variants['unit'],
                        "quantity"          =>  $variants['qty'],
                        'veg'               =>  $title,
                        'swadesi'           =>  $product_call,
                        'brand_name'        =>  $product->brand_name,
                        'stock'             => !empty($variants['stock_inv']) ? $variants['stock_inv'] : "0",
                        'in_stock'          => !empty($product->in_stock) ? $product->in_stock : "0",
                        'category_id'       => $product->category_id,
                        'brand_id'          => !empty($product->brand_id) ? $product->brand_id : 0,
                        'wishlist'          => $wishlist,
                        'is_purchase'       => $is_purchase,
                        "review_count"      => $product->review_count,
                        "ratings_average"   => $product->ratings_average,
                    );
                }
               
            }
            
            $message = array('status'=>'1', 'message'=>'Products found', 'data'=>$data);
        }
        else{
            $message = array('status'=>'0', 'message'=>'nothing in new', 'data'=>[]);
        }
        echo json_encode($message);
    }
   
    public function discountwise(){
        $user_id = $this->input->post("user_id");
        $sql = "SELECT  
                    p.*, dp.start_date, dp.start_time, dp.end_date, dp.end_time, dp.deal_price, c.title,
                    p.mrp - p.price AS difference_price, tbl_brand.title as brand_name,
                    count(rating_table.product_id) as review_count, IFNULL(AVG(rating_table.rating),0) as ratings_average
                FROM
                    products p
                    INNER JOIN categories c ON c.id = p.category_id
                    LEFT JOIN deal_product dp ON dp.product_id = p.product_id
                    LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                    LEFT JOIN rating_table on rating_table.product_id = p.product_id
                    WHERE p.trash = 0
                    GROUP BY p.product_id
                    ORDER BY difference_price DESC 
                    LIMIT  0, 12";

                    //echo $sql;die;
        $query = $this->db->query($sql);
        if(count($query->result()) > 0){
            foreach ($query->result() as $product) {
                $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product->product_id."'");
				$variants_pro       = $q_variants->result_array();
                $present = date('Y-m-d H:i:s', time());
                $date1 = $product->start_date . " " . $product->start_time;
                $date1 = date('Y-m-d H:i:s', strtotime($date1));
                $date2 = $product->end_date . " " . $product->end_time;
                $date2 = date('Y-m-d H:i:s', strtotime($date2));
                $product_call       =   $product->product_call == 1 ? $this->baseurl().'assets/images/swadeshi.png' : ''; 
                if($product->product_type == 1){
                    $title          =   "Vegetarian";
                }
                elseif($product->product_type == 2){
                    $title          =   "Non Vegetarian";
                }
                else{
                    $title          =   "";
                }
                foreach($variants_pro as $variants){ //print_r($variants); exit;
                    if ($date1 <= $present && $present <= $date2) {
        
                        if (empty($product->deal_price)) {   ///Runing
                            $price = $variants['price'];
                        } else {
                            $price = $product->deal_price;
                        }
                    } else {
                        $price = $variants['price']; //expired
                    }
                    
                //get wishlist product id by userid start from here
                $qqqq = $this->db->query('Select * from btl_wishlist WHERE user_id="'.$user_id.'" and product_id="'.$product->product_id.'"');
                $dataaa  = $qqqq->result();
//                echo "<br><br>";
//               print_r($dataaa);
           // echo "<br><br>";
                $wishlist="";
                if(count($dataaa) > 0){
                    $wishlist          =   "true";
                }
                else{
                    $wishlist          =   "false";
                }
				
				$is_purchase = '0';
				$sale_items = $this->db->query("SELECT * FROM `sale_items` join sale on sale.sale_id = sale_items.sale_id and sale_items.product_id='".$product->product_id."' WHERE sale.user_id='".$user_id."'")->row();
				if(!empty($sale_items)){
					$is_purchase = '1';
				}
				
                //get wishlist product id by userid start from end
                    
                    $data[] = array(
                        "varient_id"        => $variants['varient_id'],
                        "product_id"        => $product->product_id,
                        "product_name"      => $product->product_name,
                        "product_image"     => "products/".$product->product_image,
                        "description"       => $product->product_description,
                        "price"             => $price,
                        "mrp"               => $variants['mrp'],
                        "varient_image"     => 'products/'.$variants['pro_var_images'],
                        "unit"              => $variants['unit'],
                        "quantity"          =>  $variants['qty'],
                        'veg'               =>  $title,
                        'swadesi'           =>  $product_call,
                        'brand_name'        =>  $product->brand_name,
                        'stock'             => !empty($variants['stock_inv']) ? $variants['stock_inv'] : "0",
                        'in_stock'          => !empty($product->in_stock) ? $product->in_stock : "0",
                        'category_id'       => $product->category_id,
                        'brand_id'          => !empty($product->brand_id) ? $product->brand_id : 0,
                        'wishlist'          => $wishlist,
                        'is_purchase'       => $is_purchase,
                        "review_count"      => $product->review_count,
                        "ratings_average"   => $product->ratings_average,
                    );
                }
               
            }
            
            $message = array('status'=>'1', 'message'=>'Products found', 'data'=>$data);
        }
        else{
            $message = array('status'=>'0', 'message'=>'nothing in new', 'data'=>[]);
        }
        echo json_encode($message);
    }
   
    //Top Selling
    public function top_selling(){
        
        $user_id = $this->input->post("user_id");
        
         $sql = "SELECT  
                    p.*, dp.start_date, dp.start_time, dp.end_date, dp.end_time, dp.deal_price, c.title,
                    p.mrp - p.price AS difference_price,
                    COUNT(si.product_id) AS top,
                    si.product_id  , product_varient.*, tbl_brand.title as brand_name,
                    count(rating_table.product_id) as review_count, IFNULL(AVG(rating_table.rating),0) as ratings_average
                FROM
                    products p
                        INNER JOIN sale_items si ON p.product_id = si.product_id
                        INNER JOIN product_varient ON product_varient.varient_id = si.pro_var_id
                        INNER JOIN categories c ON c.id = p.category_id
                        LEFT JOIN deal_product dp ON dp.product_id = si.product_id
                        LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                        LEFT JOIN rating_table on rating_table.product_id = p.product_id
                    WHERE p.trash = 0
                    GROUP BY si.product_id
                    ORDER BY top DESC
                    LIMIT 0,12";

                    //echo $sql;die;
        $query = $this->db->query($sql);
        if(count($query->result()) > 0){
            foreach ($query->result() as $product) {
                $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product->product_id."' AND varient_id ='".$product->varient_id."' ");
				$variants_pro       = $q_variants->result_array();
                $present = date('Y-m-d H:i:s', time());
                $date1 = $product->start_date . " " . $product->start_time;
                $date1 = date('Y-m-d H:i:s', strtotime($date1));
                $date2 = $product->end_date . " " . $product->end_time;
                $date2 = date('Y-m-d H:i:s', strtotime($date2));
                if ($date1 <= $present && $present <= $date2) {
                    if (empty($product->deal_price)) {   ///Runing
                            $price = $product->price;
                    } else {
                        $price = $product->deal_price;
                    }
                } else {
                    $price = $product->price; //expired
                }

                $product_call       =   $product->product_call == 1 ? $this->baseurl().'assets/images/swadeshi.png' : ''; 
                if($product->product_type == 1){
                    $title          =   "Vegetarian";
                }
                elseif($product->product_type == 2){
                    $title          =   "Non Vegetarian";
                }
                else{
                    $title          =   "";
                }
                
                //get wishlist product id by userid start from here
                //$qqqq = $this->db->query('Select * from btl_wishlist WHERE user_id="'.$user_id.'" AND product_id="'.$product->product_id.'"');
                
                //echo 'Select * from btl_wishlist WHERE user_id="'.$user_id.'" and product_id="'.$product->product_id.'"';
                
                $qqqq = $this->db->query('Select * from btl_wishlist WHERE user_id="'.$user_id.'" and product_id="'.$product->product_id.'"');
                $dataaa  = $qqqq->result();
//                echo "<br><br>";
//               print_r($dataaa);
           // echo "<br><br>";
                $wishlist="";
                if(count($dataaa) > 0){
                    $wishlist          =   "true";
                }
                else{
                    $wishlist          =   "false";
                }
                //get wishlist product id by userid start from end
                $is_purchase = '0';
				$sale_items = $this->db->query("SELECT * FROM `sale_items` join sale on sale.sale_id = sale_items.sale_id and sale_items.product_id='".$product->product_id."' WHERE sale.user_id='".$user_id."'")->row();
				if(!empty($sale_items)){
					$is_purchase = '1';
				}
                //print_r($product); exit;
                $data1[] = array(
                        "varient_id"        => $product->varient_id,
                        "product_id"        => $product->product_id,
                        "product_name"      => $product->product_name,
                        "product_image"     => "products/".$product->product_image,
                        "description"       => $product->product_description,
                        "price"             => $price,
                        "mrp"               => $product->mrp,
                        "varient_image"     => 'products/'.$product->pro_var_images,
                        "unit"              =>  $product->unit,
                        "quantity"          =>  $product->qty,
                        "count"             =>  count($variants_pro),
                        'veg'               =>  $title,
                        'swadesi'           =>  $product_call,
                        'brand_name'        =>  $product->brand_name,
                        'stock'             => !empty($product->stock_inv) ? $product->stock_inv : "0",
                        'in_stock'          => !empty($product->in_stock) ? $product->in_stock : "0",
                        'category_id'       => $product->category_id,
                        'brand_id'          => !empty($product->brand_id) ? $product->brand_id : 0,
                        'wishlist'          => $wishlist,
                        'is_purchase'       => $is_purchase,
                        "review_count"      => $product->review_count,
                        "ratings_average"   => $product->ratings_average,
                    );
            }
            
            $message = array('status'=>'1', 'message'=>'Products found', 'data'=>$data1);
        }
        else{
            $message = array('status'=>'0', 'message'=>'Products not found', 'data'=>[]);
        }
        echo json_encode($message);
    }
    
    public function test_get_data() {
        
        $qqqq = $this->db->query('Select * from btl_wishlist ');
        $dataaa  = $qqqq->result();
        
        foreach ($dataaa as $product) {
            print_r($product);
            echo("<br>");
        }
    }
    
    //Deals Of the day
    public function get_all_deal_product() {
        $user_id = $this->input->post("user_id");
        $data = array();
        $_POST = $_REQUEST;
        error_reporting(0);
        $present = date('Y-m-d H:i:s', time());
        $sql = "SELECT 
                    deal_product.deal_price as price,  product_varient.pro_var_images ,  product_varient.qty,product_varient.unit, product_varient.mrp,products.product_description ,
                    products.product_name,products.product_image,product_varient.varient_id,products.product_id,deal_product.start_date,deal_product.end_date, deal_product.start_time,
                    deal_product.end_time, products.product_type, products.product_call, tbl_brand.title as brand_name, product_varient.stock_inv,products.in_stock,products.category_id,
                    count(rating_table.product_id) as review_count, IFNULL(AVG(rating_table.rating),0) as ratings_average
                FROM
                    deal_product
                        INNER JOIN products ON deal_product.product_id = products.product_id
                        INNER JOIN product_varient ON product_varient.varient_id = deal_product.pro_var_id
                        INNER JOIN categories ON categories.id = products.category_id
                        LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                        LEFT JOIN rating_table on rating_table.product_id = deal_product.product_id
                    WHERE CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()";
        $q = $this->db->query($sql);
            
            // print_r($this->db->last_query()); exit;
            // AND  NOW()
            //   $this->db->query("SELECT dp.*,p.*,c.title from deal_product dp 
            //   inner JOIN products p on dp.product_name = p.product_name 
            //   INNER JOIN categories c on c.id=p.category_id");
        if(count($q->result()) > 0){
            $responce = 1;
            //$data['Deal_of_the_day'][]=array();
            foreach ($q->result() as $product) {
                if(!empty($product->product_id)){
                    $present = date('Y-m-d H:i:s', time());
                    $date1_Arr  =   explode('/', $product->start_date);
                    $date2_Arr  =   explode('/', $product->end_date);
                    $date1 = $date1_Arr[2].'-'.$date1_Arr[1].'-'.$date1_Arr[0]. " " . $product->start_time;
                    $date1 = date('Y-m-d H:i:s', strtotime($date1));
                    $date2 = $date2_Arr[2].'-'.$date2_Arr[1].'-'.$date2_Arr[0]." " . $product->end_time;
                    $date2 = date('Y-m-d H:i:s', strtotime($date2));
                    
                    if (empty($product->deal_price)) {   ///Runing
                            $price = $product->price;
                    } else {
                        $price = $product->deal_price;
                    }
                    
                    $price   = $product->price;
                    //echo ($date2).' >> '. ($present).'<br/>';
                    $diff    = (strtotime($date2) - strtotime($present));
                    //echo $diff; exit;
                    $timediff = date('H:i:s', $diff);
                    
                    $product_call       =   $product->product_call == 1 ? $this->baseurl().'assets/images/swadeshi.png' : ''; 
                     if($product->product_type == 1){
                        $title          =   "Vegetarian";
                    }
                    elseif($product->product_type == 2){
                        $title          =   "Non Vegetarian";
                    }
                    else{
                        $title          =   "";
                    }
                    
                    
                    //get wishlist product id by userid start from here
                    $qqqq = $this->db->query('Select * from btl_wishlist WHERE user_id="'.$user_id.'" and product_id="'.$product->product_id.'"');
                    $dataaa  = $qqqq->result();
    //                echo "<br><br>";
    //               print_r($dataaa);
               // echo "<br><br>";
                    $wishlist="";
                    if(count($dataaa) > 0){
                        $wishlist          =   "true";
                    }
                    else{
                        $wishlist          =   "false";
                    }
    				
    				$is_purchase = '0';
    				$sale_items = $this->db->query("SELECT * FROM `sale_items` join sale on sale.sale_id = sale_items.sale_id and sale_items.product_id='".$product->product_id."' WHERE sale.user_id='".$user_id."'")->row();
    				if(!empty($sale_items)){
    					$is_purchase = '1';
    				}
    				
                    //get wishlist product id by userid start from end
                    
                    
                    $data[] = array(
                        'product_id'    => $product->product_id,
                        'varient_id'    => $product->varient_id,
                        'product_name'  => $product->product_name,
                        'product_image' => 'products/'.$product->product_image,
                        'description'   => $product->product_description,
                        'price'         => $price,
                        'quantity'      => $product->qty,
                        'varient_image' => 'products/'.$product->pro_var_images,
                        'mrp'           => $product->mrp,
                        'unit'          => $product->unit,
                        'valid_to'      => $date1,
                        'valid_from'    => $date2,
                        'timediff'      => $diff,
                        'hoursmin'      => $timediff,
                        'veg'           => $title,
                        'swadesi'       => $product_call,
                        'brand_name'    => $product->brand_name,
                        'stock'         => !empty($product->stock_inv) ? $product->stock_inv : "0",
                        'in_stock'      => !empty($product->in_stock) ? $product->in_stock : "0",
                        'category_id'   => $product->category_id,
                        'brand_id'      => !empty($product->brand_id) ? $product->brand_id : 0,
                        'wishlist'      => $wishlist,
                        'is_purchase'   => $is_purchase,
                        "review_count"      => $product->review_count,
                        "ratings_average"   => $product->ratings_average,
                    );
                }
                 
            }
             $message = array('status'=>$responce, 'message'=>'Products found', 'data'=>$data);
        }
        else{
            $message = array('status'=>'0', 'message'=>'Products not found', 'data'=>[]);
        }
        echo json_encode($message);
    }

    public function icon() {
        $parent = 0;
        if ($this->input->post("parent")) {
            $parent = $this->input->post("parent");
        }
        $categories = $this->get_header_categories_short($parent, 0, $this);
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
    }

    public function get_header_categories_short($parent, $level, $th) {
        $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `header_categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `header_categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                         LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `header_products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                         WHERE a.`parent`=" . $parent);

        $return_array = array();

        foreach ($q->result() as $row) {
            if ($row->Count > 0) {
                $sub_cat = $this->get_header_categories_short($row->id, $level + 1, $th);
                $row->sub_cat = $sub_cat;
            } elseif ($row->Count == 0) {
                
            }
            $return_array[] = $row;
        }
        return $return_array;
    }

    function get_header_products() {
        $this->load->model("product_model");
        $cat_id = "";
        if ($this->input->post("cat_id")) {
            $cat_id = $this->input->post("cat_id");
        }
        $search = $this->input->post("search");

        $data["responce"] = true;
        $datas = $this->product_model->get_header_products(false, $cat_id, $search, $this->input->post("page"));

        foreach ($datas as $product) {
            $data['data'][] = array(
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'product_name_arb' => $product->product_arb_name,
                'product_description_arb' => $product->product_arb_description,
                'category_id' => $product->category_id,
                'product_description' => $product->product_description,
                'deal_price' => "",
                'start_date' => "",
                'start_time' => "",
                'end_date' => "",
                'end_time' => "",
                'price' => $product->price,
                'product_image' => $product->product_image,
                'status' => '0',
                'in_stock' => $product->in_stock,
                'unit_value' => $product->unit_value,
                'unit' => $product->unit,
                'increament' => $product->increament,
                'rewards' => $product->rewards,
                'stock' => $product->stock,
                'title' => $product->title
            );
        }
        echo json_encode($data);
    }

    public function coupons() {

        $q = $this->db->query("select * from `tbl_coupons` WHERE trash=0 AND coupon_status=1");
        
        $row =  $q->result();
        $coupans    =   array();
        foreach($row as $coupan){
            if(date('Y-m-d', strtotime($coupan->valid_from)) <= date('Y-m-d') && date('Y-m-d', strtotime($coupan->valid_to)) >= date('Y-m-d')) {
                 
                $coupans[]    =   array(
                                    "coupon_id"             => $coupan->coupon_id,
                                    "coupon_name"           => $coupan->coupon_name,
                                    "coupon_code"           => $coupan->coupon_code,
                                    "valid_from"            => $coupan->valid_from,
                                    "valid_to"              => $coupan->valid_to,
                                    "discount_type"         => $coupan->discount_type,
                                    "discount_value"        => $coupan->discount_value,
                                    "minimum_cart_amt"      => $coupan->minimum_cart_amt,
                                    "uses_restriction"      => $coupan->uses_restriction,
                                    "max_limit"             => $coupan->max_limit,
                                    "coupon_created_at"     => $coupan->coupon_created_at,
                                    "coupon_description"    => base64_decode($coupan->coupon_description),
                                    "coupon_status"         => $coupan->coupon_status,
                                    "trash"                 => $coupan->trash,
                                );
            }
        }
        
        
        $data["responce"] = true;
        $data['data'] = $coupans;
        echo json_encode($data);
    }

    public function get_coupons() {
        $this->load->model("setting_model");
        $userid                =   $this->input->post('user_id');
        $total_service_amt      =   $this->input->post('payable_amount');
        $coupon_code            =   $this->input->post('coupon_code');
        $product_ids            =   $this->input->post('product_ids');
        $brand_ids              =   $this->input->post('brand_ids');
        $category_ids            =   $this->input->post('category_ids');
        $coupon_data            =   $this->setting_model->checkCouponCode($userid,$coupon_code);
        //print_r($coupon_data);
        //echo $coupon_data["_success"]["coupon_id"];
        //die();
        if(array_key_exists('_success', $coupon_data)){
            
             $is_coupon_apply = true;
            
            if(strpos($coupon_data["_success"]["type_value"], ',')!== false){
                $coupanArr  =   explode(',', $coupon_data["_success"]["type_value"]);
            }
            else{
                $coupanArr  =   array($coupon_data["_success"]["type_value"]);
            }
            
            if($coupon_data["_success"]["apply_type"]=="category")
                {
                    if(!empty($category_ids)){
                        $category_idsArr  =   explode(',', $category_ids);
                        foreach ($category_idsArr as $category_id)
                        {   
                            if (in_array($category_id, $coupanArr)==false)
                            {
                                $is_coupon_apply = false;
                            }
                        }
                    }
                    
                    
                }
                
                if($coupon_data["_success"]["apply_type"]=="single_product"){                    
                    if(!empty($product_ids)){
                        $product_idsArr  =   explode(',', $product_ids);
                        foreach ($product_idsArr as $product_id)
                        {   
                            if (in_array($product_id, $coupanArr)==false)
                            {
                                $is_coupon_apply = false;
                            }
                        } 
                    }
                       
                    
                }
                
                if($coupon_data["_success"]["apply_type"]=="brand"){
                    if(!empty($brand_ids)){
                        $brand_idsArr  =   explode(',', $brand_ids);
                        foreach ($brand_idsArr as $brand_id)
                        {   
                            if (in_array($brand_id, $coupanArr)==false)
                            {
                                $is_coupon_apply = false;
                            }
                        }
                    }
                    
                }
            
           
            if($is_coupon_apply==true){
                $coupon_data        =   $coupon_data['_success'];
                $coupon_id          =   $coupon_data['coupon_uni_id'] ;
                $discount_type      =   $coupon_data['discount_type'];
                $discount_value     =   $coupon_data['discount_value'];
                $minimum_cart_amt   =   $coupon_data['minimum_cart_amt'];
                $max_discount_limit =   $coupon_data['max_limit'];
                $discount_amount    =  0;
            
                if($total_service_amt >= $minimum_cart_amt){
                    if($discount_type == '%'){
                        $discount_amount_applied   = floor($total_service_amt * ($discount_value/100));
                        if($discount_amount_applied >= $max_discount_limit){
                            $discount_amount   = $max_discount_limit;
                        }else{
                            $discount_amount   = $discount_amount_applied;
                        }
                    }else{
                        $discount_amount  = $discount_value;

                    }
                    $coupon_apply_data      =   array(
                        'coupon_id'          => $coupon_id,
                        'user_id'            => $userid,
                        'coupon_apply_date'  => date('Y-m-d'),
                        'coupon_apply_status'=> 1, // Coupon Activated
                        'coupon_discount_amt'=> $discount_amount
                    );
                   // print_r($coupon_apply_data); exit;
                    $result =   $this->db->insert('tbl_coupon_apply', $coupon_apply_data);
                    $coupon_apply_id   =   $this->db->insert_id();
                    if ($result > 0){
                        $remainingAmount        = ($this->input->post('payable_amount') - $discount_amount);
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
                    echo json_encode($data);
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
        else {
            $data["responce"] = false;
            $data["msg"] = "Invalid Coupon";
            $data["Total_amount"] = $this->input->post("payable_amount");
            $data["coupon_value"] = 0;
			echo json_encode($data);
        }            

        
    }

    public function get_sub_cat() {
        $parent = 0;
        if ($this->input->post("sub_cat") != 0) {
            $q = $this->db->query("SELECT * FROM `categories` where id='" . $this->input->post("sub_cat") . "'");
            $data["responce"] = true;
            $data["subcat"] = $q->result();
            echo json_encode($data);
        } else {
            $data["responce"] = false;
            $data["subcat"] = "";
            echo json_encode($data);
        }
    }

    public function delivery_boy() {

        $q = $this->db->query("select id,user_name from `delivery_boy` where user_status=1");
        $data['delivery_boy'] = $q->result();

        echo json_encode($data);
    }

    public function delivery_boy_login() {
        error_reporting(0);
        $data = array();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_password', 'Password', 'trim|required');

        if (!$this->input->post('user_password')) {
            $data["responce"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        } else {
            //users.user_email='".$this->input->post('user_email')."' or
            $q = $this->db->query("Select * from delivery_boy where user_password='" . md5($this->input->post('user_password')) . "'");

            if ($q->result() > 0) {
                $row = $q->result();
                $access = $row->user_status;
                if ($access == '0') {
                    $data["responce"] = false;
                    $data["data"] = 'Your account currently inactive.Please Contact Admin';
                } else {
                    //$error_reporting(0);
                    $data["responce"] = true;
                    $q = $this->db->query("Select id,user_name from delivery_boy where user_password='" . md5($this->input->post('user_password')) . "'");
                    $product = $q->result();
                    $data['product'] = $product;
                }
            } else {
                $data["responce"] = false;
                $data["data"] = 'Invalide Username or Passwords';
            }
        }
        echo json_encode($data);
    }

    public function add_purchase() {
        if (_is_user_login($this)) {

            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
                $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
                $this->form_validation->set_rules('unit', 'Unit', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "")
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                }
                else {

                    $this->load->model("common_model");
                    $array = array(
                        "product_id" => $this->input->post("product_id"),
                        "qty" => $this->input->post("qty"),
                        "price" => $this->input->post("price"),
                        "unit" => $this->input->post("unit"),
                        "store_id_login" => $this->input->post("store_id_login")
                    );
                    $this->common_model->data_insert("purchase", $array);

                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/add_purchase");
                }

                $this->load->model("product_model");
                $data["purchases"] = $this->product_model->get_purchase_list();
                $data["products"] = $this->product_model->get_products();
                $this->load->view("admin/product/purchase", $data);
            }
        }
    }

    public function stock() {
        $this->load->model("product_model");
        $cat_id = "";
        if ($this->input->post("cat_id")) {
            $cat_id = $this->input->post("cat_id");
        }
        $search = $this->input->post("search");

        $datas = $this->product_model->get_products(false, $cat_id, $search, $this->input->post("page"));
        //print_r( $datas);exit();
        foreach ($datas as $product) {
            $present = date('m/d/Y h:i:s a', time());
            $date1 = $product->start_date . " " . $product->start_time;
            $date2 = $product->end_date . " " . $product->end_time;

            if (strtotime($date1) <= strtotime($present) && strtotime($present) <= strtotime($date2)) {

                if (empty($product->deal_price)) {   ///Runing
                    $price = $product->price;
                } else {
                    $price = $product->deal_price;
                }
            } else {
                $price = $product->price; //expired
            }

            $data['products'][] = array(
                'product_id' => $product->product_id,
                'product_name' => $product->product_name
            );
        }

        echo json_encode($data);
    }

    public function stock_insert() {
        $this->load->library('form_validation');

        $this->input->post('product_id');
        $this->input->post('qty');
        $this->input->post('unit');
        if (!$this->input->post('product_id')) {
            $data["data"] = 'Please select the product';
        } else {

            $this->load->model("common_model");
            $array = array(
                "product_id" => $this->input->post("product_id"),
                "qty" => $this->input->post("qty"),
                "price" => $this->input->post("price"),
                "unit" => $this->input->post("unit"),
                "store_id_login" => $this->input->post("store_id_login")
            );
            $this->common_model->data_insert("purchase", $array);
            

            $data['product'][] = array("msg" => 'Your Stock is Updated');
        }
        echo json_encode($data);
        $this->load->model("product_model");
        $data["purchases"] = $this->product_model->get_purchase_list();
        $data["products"] = $this->product_model->get_products();
    }

    public function assign() {
        $order = $this->input->post("order_id");
        $order = $this->input->post("d_boy");
        $this->load->model("common_model");
        $this->common_model->data_update("sale", $update_array, array("sale_id" => $order));
    }

    public function delivery_boy_order() {
        $delivery_boy_id = $this->input->post("d_id");
        $date = date("d-m-Y", strtotime('-3 day'));
        $this->load->model("product_model");
        $data = $this->product_model->delivery_boy_order($delivery_boy_id);

        $this->db->query("DELETE FROM signature WHERE `date` < '.$date.'");
        //$data['assign_orders'] = $q->result();
        echo json_encode($data);
    }

    public function assign_order() {
        $order_id = $this->input->post("order_id");
        $boy_name = $this->input->post("boy_name");

        $update_array = array("assign_to" => $boy_name);

        $this->load->model("common_model");
        //$q= $this->common_model->data_update("sale",$update_array,array("sale_id"=>$order_id));
        $hit = $this->db->query("UPDATE sale SET `assign_to`='" . $boy_name . "' where `sale_id`='" . $order_id . "'");
        if ($hit) {
            $data['assign'][] = array("msg" => "Assign Successfully");
        } else {
            $data['assign'][] = array("msg" => "Assign Not Successfully");
        }
        echo json_encode($data);
    }

    public function mark_delivered() {

        $this->load->library('form_validation');
        $signature = $this->input->post("signature");

        if (empty($_FILES['signature']['name'])) {
            $this->form_validation->set_rules('signature', 'signature', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $data["message"] = $data["message"] = array("error" => "not found");
        } else {
            $add = array(
                "order_id" => $this->input->post("id")
            );

            if ($_FILES["signature"]["size"] > 0) {
                $config['upload_path'] = './uploads/signature/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('signature')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $img_data = $this->upload->data();
                    $add["signature"] = $img_data['file_name'];
                }
            }

            $q = $this->db->insert("signature", $add);
            if ($q) {
                $data = array("msg" => "Upload Successfull");
            } else {
                $data = array("msg" => "Upload Not Successfull");
            }
        }

        echo json_encode($data);
    }

    public function mark_delivered2() {


        if ((($_FILES["signature"]["type"] == "image/gif") || ($_FILES["signature"]["type"] == "image/jpeg") || ($_FILES["signature"]["type"] == "image/jpg") || ($_FILES["signature"]["type"] == "image/jpeg") || ($_FILES["signature"]["type"] == "image/png") || ($_FILES["signature"]["type"] == "image/png"))) {


            //Move the file to the uploads folder
            move_uploaded_file($_FILES["signature"]["tmp_name"], "./uploads/signature/" . $_FILES["signature"]["name"]);

            //Get the File Location
            $filelocation = './uploads/signature/' . $_FILES["signature"]["name"];

            //Get the File Size
            $order_id = $this->input->post("id");

            $q = $this->db->query("INSERT INTO signature (order_id, signature) VALUES ('$order_id', '$filelocation')");

            //$this->db->insert("signature",$add);
            if ($q) {

                $data = array("success" => "1", "msg" => "Upload Successfull");
                $this->db->query("UPDATE `sale` SET `status`=4 WHERE `sale_id`='" . $order_id . "'");
                $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method)
                                SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method FROM sale where sale_id = '" . $order_id . "'");


                $q2 = $this->db->query("Select total_rewards, user_id from sale where sale_id = '" . $order_id . "'");
                $user2 = $q2->row();

                $q = $this->db->query("Select * from registers where user_id = '" . $user2->user_id . "'");
                $user = $q->row();

                $rewrd_by_profile = $user->rewards;
                $rewrd_by_order = $user2->total_rewards;

                $new_rewards = $rewrd_by_profile + $rewrd_by_order;
                $this->db->query("update registers set rewards = '" . $new_rewards . "' where user_id = '" . $user2->user_id . "'");
            } else {
                $data = array("success" => "0", "msg" => "Upload Not Successfull");
            }
        } else {
            $data = array("success" => "0", "msg" => "Image Type Not Right");
        }
        echo json_encode($data);
    }

    public function ads() {
        $qry = $this->db->query("SELECT * FROM `ads`");
        $data = $qry->result();
        echo json_encode($data);
    }

    public function paypal() {
        $qry = $this->db->query("SELECT * FROM `paypal`");
        $data['paypal'] = $qry->result();
        echo json_encode($data);
    }

    public function razorpay() {
        $qry = $this->db->query("SELECT * FROM `razorpay`");
        $data = $qry->result();
        echo json_encode($data);
    }

    public function get_categories12() {
        $parent = 0;
        if ($this->input->post("parent")) {
            $parent = $this->input->post("parent");
        }
        $categories = $this->get_categories_short2($parent, 0, $this);
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
    }

    public function get_categories_short2($parent, $level, $th) {
        $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                                 LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                                 WHERE a.`parent`=" . $parent . " LIMIT 12");

        $return_array = array();

        foreach ($q->result() as $row) {
            if ($row->Count > 0) {
                $sub_cat = $this->get_categories_short2($row->id, $level + 1, $th);
                $row->sub_cat = $sub_cat;
            } elseif ($row->Count == 0) {
                $row->sub_cat  = array();
            }
            $return_array[] = $row;
        }
        return $return_array;
    }

    public function cart() {

        $user_id = $this->input->post("user_id");
        $pro_id = $this->input->post("product_id");
        $qty = $this->input->post("qty");

        if ($user_id) {
            $cart_create = $this->db->query("INSERT INTO cart (qty, user_id, product_id) VALUES ('$qty', '$user_id', '$pro_id')");

            if ($cart_create) {
                $data['responce'] = true;
                $data['msg'] = "Add Cart Successfull";
            } else {
                $data['responce'] = false;
                $data['msg'] = "Add Cart Not Successfull";
            }
        } else {
            $data['responce'] = false;
            $data['msg'] = "Add Cart Not Successfull";
        }

        echo json_encode($data);
    }

    public function view_cart() {

        $user_id = $this->input->post("user_id");
        if ($user_id) {


            $cart_productr = $this->db->query("select * from cart where user_id = '" . $this->input->post("user_id") . "'");
            $user = $cart_productr->result();
            $cart_quantity = $cart_productr->num_rows(); 
            if ($cart_quantity > 0) {
                $i = 1;
                foreach ($user as $user) {

                    $id = $user->product_id;
                    $qty = $user->qty;
                    $cart_id = $user->cart_id;
                    $q = $this->db->query("Select dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title, tbl_brand.title as brand_name 
                        from products 
                          inner join categories on categories.id = products.category_id
                          left outer join(select SUM(qty) as c_qty,product_id from sale_items INNER JOIN sale on sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = products.product_id 
                          left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                          left join deal_product dp on dp.product_id=products.product_id 
                          LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                          where products.product_id =  '" . $id . "'");
                    $products = $q->result();


                    foreach ($products as $product) {
                        $present = date('m/d/Y h:i:s a', time());
                        $date1 = $product->start_date . " " . $product->start_time;
                        $date2 = $product->end_date . " " . $product->end_time;

                        if (strtotime($date1) <= strtotime($present) && strtotime($present) <= strtotime($date2)) {

                            if (empty($product->deal_price)) {   ///Runing
                                $price = $product->price;
                            } else {
                                $price = $product->deal_price;
                            }
                        } else {
                            $price = $product->price; //expired
                        }
                        $data['responce'] = true;
                        $data['total_item'] = $i;
                        $sum['total'] = $price * $qty;
                        //array_push($data['total_amount'], $sum);
                        //$data['total_amount']=$sum;
                        $data['data'][] = array(
                            'product_id' => $product->product_id,
                            'product_name' => $product->product_name,
                            'category_id' => $product->category_id,
                            'product_description' => $product->product_description,
                            'deal_price' => '',
                            'start_date' => "",
                            'start_time' => "",
                            'end_date' => "",
                            'end_time' => "",
                            'price' => $price,
                            'mrp' => $product->mrp,
                            'product_image' => $product->product_image,
                            //'tax'=>$product->tax,
                            'status' => '0',
                            'in_stock' => $product->in_stock,
                            'unit_value' => $product->unit_value,
                            'unit' => $product->unit,
                            'increament' => $product->increament,
                            'rewards' => $product->rewards,
                            'stock' => $product->stock,
                            'title' => $product->title,
                            'qty' => $qty,
                            'cart_id' => $cart_id,
                            'total_product_amount' => $qty * $price,
                            'brand_name'    =>  $product->brand_name
                        );
                    } $i++;
                }
            } else if ($cart_quantity < 1) {
                $data['total_item'] = 0;
                $data['responce'] = false;
                $data['msg'] = "Your Cart is Empty ";
            }
        } else {
            $data['responce'] = false;
            $data['msg'] = "Cart Not Available ";
        }

        echo json_encode($data);
    }

    public function view_carts() {

        $product_id         =   $this->input->post("product_id");
        $pro_varient_id     =   $this->input->post("pro_varient_id");
        $id                 =   '';
        $ids                 =   '';
        foreach($product_id as $ros){
            if(empty($id)){
                $id     =   $ros;
            }
            else{
                $id     =   $id.','.$ros;
            }
        }
        foreach($pro_varient_id as $row){
            if(empty($ids)){
                $ids     =   $row;
            }
            else{
                $ids     =   $ids.','.$row;
            }
        }
        

        $q = $this->db->query("SELECT dp.,products., ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title, tbl_brand.title as brand_name, product_varient.* 
                                FROM product_varient
                                INNER JOIN products ON products.product_id = product_varient.product_id
                                LEFT JOIN categories on categories.id = products.category_id
                                LEFT JOIN(select SUM(qty) as c_qty,product_id from sale_items INNER JOIN sale on sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = products.product_id 
                                LEFT JOIN(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                                LEFT JOIN deal_product dp on dp.product_id=products.product_id 
                                LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                                WHERE products.product_id IN(".$id.")  AND product_varient.varient_id IN(".$ids.")");
        $products = $q->result();


        foreach ($products as $product) {
            $present = date('m/d/Y h:i:s a', time());
            $date1 = $product->start_date . " " . $product->start_time;
            $date2 = $product->end_date . " " . $product->end_time;

            if (strtotime($date1) <= strtotime($present) && strtotime($present) <= strtotime($date2)) {

                if (empty($product->deal_price)) {   ///Runing
                    $price = $product->price;
                } else {
                    $price = $product->deal_price;
                }
            } else {
                $price = $product->price; //expired
            }
            $data['responce'] = true;
            $data['total_item'] = $i;
            $sum['total'] = $price * $qty;
            //array_push($data['total_amount'], $sum);
            //$data['total_amount']=$sum;
            $data['data'][] = array(
                        "varient_id"        => $product->varient_id,
                        "product_id"        => $product->product_id,
                        "product_name"      => $product->product_name,
                        "product_image"     => "products/".$product->product_image,
                        "description"       => $product->product_description,
                        "price"             => $price,
                        "mrp"               => $product->mrp,
                        "varient_image"     => 'products/'.$product->pro_var_images,
                        "unit"              =>  $product->unit,
                        "quantity"          =>  $product->qty,
                        "count"             =>  count($variants_pro),
                        'veg'               =>  $title,
                        'swadesi'           =>  $product_call,
                        'brand_name'        =>  $product->brand_name,
                        'stock'             => !empty($product->stock_inv) ? $product->stock_inv : "0",
                        'in_stock'          => !empty($product->in_stock) ? $product->in_stock : "0",
                        'category_id'       => $product->category_id,
                        'brand_id'          => !empty($product->brand_id) ? $product->brand_id : 0,
                    );
        }
        echo json_encode($data);
    }
    
    
    public function delete_from_cart() {
        $user_id = $this->input->post("user_id");
        $cart_id = $this->input->post("cart_id");
        $done = $this->db->query("delete from cart where user_id = '" . $user_id . "' AND cart_id ='" . $cart_id . "'");
        if ($done) {
            $data['responce'] = true;
            $data['msg'] = "Product Delete From Cart Successfully";
        }

        echo json_encode($data);
    }

    public function payment_success() {
        $order_id = $this->input->post("order_id");
        $amount = $this->input->post("amount");

        $done = $this->db->query("UPDATE `sale` SET `is_paid`='" . $amount . "' WHERE `sale_id`='" . $order_id . "'");
        if ($done) {
            $data['responce'] = true;
            $data['msg'] = "Successfully Payment";
        }

        echo json_encode($data);
    }

    public function update_cart() {

        $cart_id = $this->input->post("cart_id");
        $qty = $this->input->post("qty");

        $this->load->library('form_validation');
        $this->form_validation->set_rules('cart_id', 'Cart ID', 'trim|required');
        $this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
            $cart_update = $this->db->query("UPDATE `cart` SET `qty`='" . $qty . "' WHERE `cart_id`='" . $cart_id . "'");

            if ($cart_update) {
                $data['responce'] = true;
                $data['msg'] = "Update Successfull";
            } else {
                $data['responce'] = false;
                $data['msg'] = "Add Cart Not Successfull";
            }
        }



        echo json_encode($data);
    }

    public function get_categories22() {
        $parent = 0;
        if ($this->input->post("parent")) {
            $parent = $this->input->post("parent");
        }
        $categories = $this->get_categories_short22($parent, 0, $this);
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
    }

    public function get_categories_short22($parent, $level, $th) {
        $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                                 LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                                 WHERE a.`parent`=" . $parent . " LIMIT 9");

        $return_array = array();

        foreach ($q->result() as $row) {
            if ($row->Count > 0) {
                $sub_cat = $this->get_categories_short($row->id, $level + 1, $th);
                $row->sub_cat = $sub_cat;
            } elseif ($row->Count == 0) {
                
            }
            $return_array[] = $row;
        }
        return $return_array;
    }

    public function get_categoriesz() {
        $parent = 0;
        if ($this->input->post("parent")) {
            $parent = $this->input->post("parent");
        }
        $categories = $this->get_categories_shortz($parent, 0, $this);
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
    }

    public function get_categories_shortz($parent, $level, $th) {
        $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                                 LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                                 WHERE a.`parent`=" . $parent . "");

        $return_array = array();

        foreach ($q->result() as $row) {
            if ($row->Count > 0) {
                $sub_cat = $this->get_categories_shortz($row->id, $level + 1, $th);
                $row->sub_cat = $sub_cat;
            } elseif ($row->Count == 0) {
                
            }
            $return_array[] = $row;
        }
        return $return_array;
    }

    public function ios_send_order() {
        $total_rewards = "";
        $total_price = "";
        $total_kg = "";
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('time', 'Time', 'trim|required');
        $this->form_validation->set_rules('location', 'Location', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
            $ld = $this->db->query("SELECT user_location.*, pincode.*, 
				CONCAT_WS(' ', user_location.house_no, user_location.landmark, user_location.city, user_location.state, pincode.pincode) as address  
				FROM user_location
				INNER JOIN pincode on pincode.pincode = user_location.pincode
				WHERE user_location.location_id = '" . $this->input->post("location") . "' limit 1");
            $location   =   $ld->row();

            $store_id   =   $this->input->post("store_id");
            $payment_method = $this->input->post("payment_method");
            $date       =   date("Y-m-d", strtotime($this->input->post("date")));
            //$timeslot =   explode("-",$this->input->post("timeslot"));

            $times      =   explode('-', $this->input->post("time"));
            $fromtime   =   date("h:i a", strtotime(trim($times[0])));
            $totime     =   date("h:i a", strtotime(trim($times[1])));


            $user_id    =   $this->input->post("user_id");
            $insert_array = array("user_id" => $user_id,
                                "on_date" => $date,
                                "delivery_time_from" => $fromtime,
                                "delivery_time_to" => $totime,
                                "delivery_address" => $location->address,
                                // "socity_id" => $location->socity_id,
                                "delivery_charge" => $location->delivery_charge,
                                "location_id" => $location->location_id,
                                "payment_method" => $payment_method,
                                "new_store_id" => $store_id
                            );
            $this->load->model("common_model");
            //$id         =   $this->common_model->data_insert("sale", $insert_array);

            //$cart = $this->db->query("select * from cart WHERE user_id='" . $user_id . "'");
            //$cart_value = $cart->result();
            $cart_value     =   $this->input->post('data');
            foreach ($cart_value as $cart_value) {

                $q          =   $this->db->query("Select dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title, tbl_brand.title as brand_name 
                                FROM products 
                                INNER JOIN categories on categories.id = products.category_id
                                INNER JOIN product_varient ON product_varient.product_id = products.product_id AND product_varient.varient_id = '".$cart_value->varient_id."'
                                LEFT JOIN(select SUM(qty) as c_qty,product_id from sale_items INNER JOIN sale on sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = products.product_id 
                                LEFT JOIN(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                                LEFT JOIN  deal_product dp on dp.product_id=products.product_id 
                                LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                                WHERE product_varient.product_id =  '" . $cart_value->product_id . "' AND product_varient.varient_id = '".$cart_value->varient_id."'");
                $products   =   $q->result();
                
                foreach ($products as $product) {
                    $present =  date('m/d/Y h:i:s a', time());
                    $date1  =   $product->start_date . " " . $product->start_time;
                    $date2  =   $product->end_date . " " . $product->end_time;

                    if (strtotime($date1) <= strtotime($present) && strtotime($present) <= strtotime($date2)) {
                        if (empty($product->deal_price)) {   ///Runing
                            $price = $product->price;
                        } else {
                            $price = $product->deal_price;
                        }
                    } else {
                        $price = $product->price; //expired
                    }


                    $qty_in_kg = $cart_value->qty;
                    if ($product->unit == "gram") {
                        $qty_in_kg = ($cart_value->qty * $product->unit_value) / 1000;
                    }
                    $total_rewards = $total_rewards + ($cart_value->qty * $product->rewards);
                    $total_price = $total_price + ($cart_value->qty * $product->price);
                    $total_kg = $total_kg + $qty_in_kg;
                    $total_items[$product->product_id] = $product->product_id;


                    $array = array(
                        "product_id" => $product->product_id,
                        "pro_var_id"    => $cart_value->varient_id,
                        "qty"           => $cart_value->qty,
                        "unit"          => $product->unit,
                        "unit_value"    => $product->unit_value,
                        "sale_id"       => $id,
                        "price"         => $product->price,
                        "qty_in_kg"     => $qty_in_kg,
                        "rewards"       => $product->rewards,
                        'brand_name'    => $product->brand_name
                    );
                    $this->common_model->data_insert("sale_items", $array);
                }
            }



            // $data_post = $this->input->post("data");
            // $data_array = json_decode($data_post);
            // $total_rewards = 0;
            // $total_price = 0;
            // $total_kg = 0;
            // $total_items = array();
            // foreach($data_array as $dt){
            //     $qty_in_kg = $dt->qty; 
            //     if($dt->unit=="gram"){
            //         $qty_in_kg =  ($dt->qty * $dt->unit_value) / 1000;     
            //     }
            //     $total_rewards = $total_rewards + ($dt->qty * $dt->rewards);
            //     $total_price = $total_price + ($dt->qty * $dt->price);
            //     $total_kg = $total_kg + $qty_in_kg;
            //     $total_items[$dt->product_id] = $dt->product_id;    
            //     $array = array("product_id"=>$dt->product_id,
            //     "qty"=>$dt->qty,
            //     "unit"=>$dt->unit,
            //     "unit_value"=>$dt->unit_value,
            //     "sale_id"=>$id,
            //     "price"=>$dt->price,
            //     "qty_in_kg"=>$qty_in_kg,
            //     "rewards" =>$dt->rewards
            //     );
            //     $this->common_model->data_insert("sale_items",$array);
            // }







            $total_price = $total_price + $location->delivery_charge;
            $this->db->query("Update sale set total_amount = '" . $total_price . "', total_kg = '" . $total_kg . "', total_items = '" . count($total_items) . "', total_rewards = '" . $total_rewards . "' where sale_id = '" . $id . "'");

            $data["responce"] = true;
            $data["data"] = addslashes("<p>Your order No #" . $id . " is send success fully \n Our delivery person will delivered order \n 
                    between " . $fromtime . " to " . $totime . " on " . $date . " \n
                    Please keep <strong>" . $total_price . "</strong> on delivery
                    Thanks for being with Us.</p>");
        }
        echo json_encode($data);
    }

    function add_coupons() {

        $this->load->helper('form');
        $this->load->model('product_model');
        $this->load->library('session');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]|alpha_numeric');
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
        $this->form_validation->set_rules('from', 'From', 'required'); //|callback_date_valid
        $this->form_validation->set_rules('to', 'To', 'required'); //|callback_date_valid

        $this->form_validation->set_rules('discount_type', 'Discount Type', 'required|numeric');
        $this->form_validation->set_rules('discount_value', 'Discount Value', 'required|numeric');
        $this->form_validation->set_rules('minimum_cart_amt', 'Minimum Cart Amount', 'required|numeric');
		
		$this->form_validation->set_rules('uses_restriction', 'Value', 'required|numeric');
		$this->form_validation->set_rules('max_limit', 'Max limit', 'required|numeric');
		
		$this->form_validation->set_rules('coupon_description', 'Cart Value', 'required');
		$this->form_validation->set_rules('coupon_status', 'Coupon Status', 'required|numeric');

        $data = array();
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
            $data = array(
                'coupon_name' => $this->input->post('coupon_title'),
                'coupon_code' => $this->input->post('coupon_code'),
                'valid_from' => $this->input->post('from'),
                'valid_to' => $this->input->post('to'),
                'discount_type' => $this->input->post('discount_type'),
                'discount_value' => $this->input->post('discount_value'),
                'minimum_cart_amt' => $this->input->post('minimum_cart_amt'),
                'max_limit' => $this->input->post('max_limit'),
                'coupon_description' => $this->input->post('coupon_description'),
                'coupon_status' => $this->input->post('coupon_status'),
				'uses_restriction' => $this->input->post('uses_restriction'),
				'coupon_created_at' => $this->input->post('coupon_created_at')
            );
            //print_r($data);
            if ($this->product_model->coupon($data)) {
                $data["responce"] = true;
                $data["msg"] = 'Coupon Create Successfull';
            }
        }
        //$data['coupons'] = $this->product_model->coupon_list();
        echo json_encode($data);
    }
	
	
	
	function edit_coupons() {

        $this->load->helper('form');
        $this->load->model('product_model');
        $this->load->library('session');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]|alpha_numeric');
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
        $this->form_validation->set_rules('from', 'From', 'required'); //|callback_date_valid
        $this->form_validation->set_rules('to', 'To', 'required'); //|callback_date_valid

        $this->form_validation->set_rules('discount_type', 'Discount Type', 'required|numeric');
        $this->form_validation->set_rules('discount_value', 'Discount Value', 'required|numeric');
        $this->form_validation->set_rules('minimum_cart_amt', 'Minimum Cart Amount', 'required|numeric');
		
		$this->form_validation->set_rules('uses_restriction', 'Value', 'required|numeric');
		$this->form_validation->set_rules('max_limit', 'Max limit', 'required|numeric');
		
		$this->form_validation->set_rules('coupon_description', 'Cart Value', 'required');
		$this->form_validation->set_rules('coupon_status', 'Coupon Status', 'required|numeric');

        $data = array();
        if ($this->form_validation->run() == FALSE) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : ' . strip_tags($this->form_validation->error_string());
        } else {
			$coupon_id = $this->input->post("coupon_id");
            $data = array(
                'coupon_name' => $this->input->post('coupon_title'),
                'coupon_code' => $this->input->post('coupon_code'),
                'valid_from' => $this->input->post('from'),
                'valid_to' => $this->input->post('to'),
                'discount_type' => $this->input->post('discount_type'),
                'discount_value' => $this->input->post('discount_value'),
                'minimum_cart_amt' => $this->input->post('minimum_cart_amt'),
                'max_limit' => $this->input->post('max_limit'),
                'coupon_description' => $this->input->post('coupon_description'),
                'coupon_status' => $this->input->post('coupon_status'),
				'uses_restriction' => $this->input->post('uses_restriction'),
				'coupon_created_at' => $this->input->post('coupon_created_at')
            );
            //print_r($data);
            if ($this->product_model->editCoupon($coupon_id,$data)) {
                $data["responce"] = true;
                $data["msg"] = 'Coupon Create Successfull';
            }
        }
        //$data['coupons'] = $this->product_model->coupon_list();
        echo json_encode($data);
    }

    public function assign_client_count() {
        $d = date('d/m/y');
        $q = $this->db->query("Select * from assign_client where sale_user_id = '" . $this->input->post('sales_id') . "'");
        $data['count'] = $q->num_rows();
        echo json_encode($data);
    }

    public function sales_report() {
        $d = date('d/m/y');
        $create_by = $this->input->post("sales_id");
        $sql = "Select * FROM sale 
     inner join socity on socity.socity_id = sale.socity_id 
     inner join registers on registers.user_id = sale.user_id
     WHERE sale.created_by='" . $create_by . "' AND sale.created_on ='" . $d . "' ORDER BY sale.sale_id DESC ";
        $q = $this->db->query($sql);
        $data["responce"] = true;
        $data['run'] = $q->result();

        echo json_encode($data);
    }

    public function user_create_by() {
        $create_by = $this->input->post("sales_id");
        $q = $this->db->query("Select * from registers where created_by = '" . $create_by . "'");
        $data['create_by'] = $q->num_rows();
        echo json_encode($data);
    }

    public function sale_by_salesman() {
        $create_by = $this->input->post("sales_id");
        $q = $this->db->query("Select * from sale where created_by = '" . $create_by . "'");
        $data['create_by'] = $q->num_rows();
        echo json_encode($data);
    }

    public function created_by_salesman() {
        $create_by = $this->input->post("sales_id");
        $q = $this->db->query("Select * from registers where created_by = '" . $create_by . "'");
        $data['create_by'] = $q->result();
        echo json_encode($data);
    }

    public function today_user_create_by() {
        $create_by = $this->input->post("sales_id");
        $today = date('d/m/y');
        $q = $this->db->query("Select * from registers where created_by = '" . $create_by . "' AND created_on = '" . $today . "' ");
        $data['create_by'] = $q->num_rows();
        echo json_encode($data);
    }

    public function today_sale_by_salesman() {
        $create_by = $this->input->post("sales_id");
        $today = date('d/m/y');
        $q = $this->db->query("Select * from sale where created_by = '" . $create_by . "' AND created_on = '" . $today . "'");
        $data['create_by'] = $q->num_rows();
        echo json_encode($data);
    }

    public function today_created_by_salesman() {
        $create_by = $this->input->post("sales_id");
        $today = date('d/m/y');
        $q = $this->db->query("Select * from registers where created_by = '" . $create_by . "' AND created_on = '" . $today . "'");
        $data['create_by'] = $q->result();
        echo json_encode($data);
    }

    public function today_assign_client_count() {
        $date = date('d/m/y');
        $q = $this->db->query("Select * from assign_client where sale_user_id = '" . $this->input->post('sales_id') . "' AND on_date = '" . $date . "'");
        $data['count'] = $q->num_rows();
        echo json_encode($data);
    }

    public function user_profile_detail() {
        error_reporting(0);
        $q = $this->db->query("Select * from registers where user_id = '" . $this->input->post('detail_id') . "'");
        $data['detail'] = $q->result();
        //$q =$this->db->query("Select registers.*, user_location.* from registers left join user_location on user_location.user_id=registers.user_id where registers.user_id = '".$this->input->post('user_id')."'");
        $que = $this->db->query("Select user_location.* , socity.socity_name from user_location left join socity on socity.socity_id=user_location.socity_id where user_location.user_id = '" . $this->input->post('detail_id') . "'");
        foreach ($que->result() as $addresses) {
            $get[] = $addresses->receiver_name . " , " . $addresses->house_no . " " . $addresses->socity_name . " " . $addresses->pincode . "";
        }
        $data['address'] = $get;
        echo json_encode($data);
    }

    public function purchase_history() {
        //error_reporting(0);
        $q = $this->db->query("Select * from sale where user_id = '" . $this->input->post('user_id') . "'");
        $data['purchase_history'] = $q->result();
        echo json_encode($data);
    }

    public function order_by_salesman() {
        $create_by = $this->input->post("sales_id");
        $q = $this->db->query("Select * from sale where created_by = '" . $create_by . "'");
        $data['order'] = $q->result();
        echo json_encode($data);
    }

    public function user_detail() {

        $this->load->model("product_model");
        $qry = $this->db->query("SELECT * FROM `registers` where user_id = '" . $this->input->post('user_id') . "'");
        $data["user"] = $qry->result();
        //$data["order"] = $this->product_model->get_sale_orders(" and sale.user_id = '".$user_id."' AND sale.status=4 ");
        echo json_encode($data);
    }

    public function wallet_at_checkout() {

        $id = $this->input->post('user_id');
        $q = $this->db->query("SELECT * FROM `registers` where user_id = '" . $id . "'");
        $row = $q->row();
        $profile_amount = $row->wallet;
        $wallet_amount = $this->input->post('wallet_amount');
        $new_wallet_amount = $profile_amount - $wallet_amount;

        $this->db->query("UPDATE registers set wallet = '" . $new_wallet_amount . "' WHERE user_id = '" . $this->input->post('user_id') . "'");
        //$this->db->query("INSERT INTO `wallet_history` ( `user_id`, `cr_id`, `dr_id`, `created_date`) VALUES ($id,0,$wallet_amount,CURRENT_TIMESTAMP);");
        $this->load->model("users_model");
        $msg = htmlspecialchars("“By Order : ”");
        $this->users_model->drUserWalletHistory($id, $wallet_amount, $msg);
    }

    public function getUserWalletHistory() {
        $user_id = $this->input->post('user_id');
        if (empty($user_id)) {
            $data["responce"] = false;
            $data["message"] = 'Warning! : User Login Must Be';
        } else {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $data["responce"] = TRUE;
            $this->load->model("users_model");
            $data["wallet_history"] = $this->users_model->getUserWalletHistory($user_id, $start_date,$end_date);
            $rows = array();
            foreach ($data["wallet_history"] as $key => $value) {
                $row = array(
                    'transaction'   => $value->transaction_by,
                    'description'   => $value->description, //"descrption ....... Details.. Column Info",
                    'debit'         => $value->dr_id,
                    'credit'        => $value->cr_id,
                    'created_date'  => date('d-m-Y', strtotime($value->created_date))
                );
                $rows[] = $row;
            }
            $data["wallet_history"] = $rows;
        }
        echo json_encode($data);
    }

    //$this->order_sms($user_id,$msg);
    private function order_sms($user_id, $message) {
        $user_phone = $this->db
                        ->select('user_phone')
                        ->where('user_id', $user_id)
                        ->limit(1)
                        ->get('registers')
                        ->row()
                ->user_phone;
        //$this->sendsmsPOST($user_phone, $message);
    }

    // SEND SMS
    function sendsmsPOST($mobileNumber, $message) {
        define("SENDER_ID", "BLMKRT");
        define("ROUTE_ID", "1");
        define("SERVER_URL", "smsclub.kriscent.in");
        define("AUTH_KEY", "9426677d76e2c1051f21e99a18e479f");
        
        $getData = 'mobileNos=' . $mobileNumber . '&message=' . urlencode($message) . '&senderId=' . SENDER_ID . '&routeId=' . ROUTE_ID;
        //API URL
        $url = "http://" . SERVER_URL . "/rest/services/sendSMS/sendGroupSms?AUTH_KEY=" . AUTH_KEY . "&" . $getData;
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

    function set_mobile_verification() {
        $return = array(
            '_error_code' => "500",
            '_error_msg' => "Server Process Faild_ Plz, Try Again"
        );
        //$return = FALSE;
        $user_id = $this->input->post('user_id');
        $user_phone = $this->input->post('user_phone');
        $mobile_verified = $this->input->post('mobile_verified'); // 1 => For Varified, 0 => For Not Varified
        if (!empty($mobile_verified)) {
            // Update
            /*
              $update = $this->db->query("UPDATE `registers` SET
              user_phone ='$user_phone',
              mobile_verified='$mobile_verified'
              where
              user_id='$user_id'");
             *
             */
            if ($this->db
                            ->set('user_phone', $user_phone)
                            ->set('mobile_verified', $mobile_verified)
                            ->where('user_id', $user_id)
                            ->update('registers')) {
                $return = array(
                    '_success_code' => "200",
                    '_success_msg' => "Server Process Update Successfully"
                );
                $this->reffrelPointToWalletTransfer($user_id);
                /*
                  else{
                  $return = array(
                  '_error_code' => "500",
                  '_error_msg' => "Server Wallet Process Faild Plz, Try Again"
                  );
                  }
                 * 
                 */
            }
        }
        echo json_encode($return);
    }

    function is_mobile_verified() {
        $user_id = $this->input->post('user_id');
        @$mobile_verified = $this->db
                        ->select('mobile_verified')
                        ->where('user_id', $user_id)
                        ->limit(1)
                        ->get('registers')
                        ->row()
                ->mobile_verified;
        if (empty($mobile_verified)) {
            $mobile_verified = 0;
        }
        $mobile_verified = array('mobile_verified' => $mobile_verified);
        echo json_encode($mobile_verified);
    }

    function send_mobile_verified_otp() {
        $user_id = $this->input->post('user_id');
        $send_user_phone = $this->input->post('user_phone');
        @$save_user_phone = $this->db
                        ->select('user_phone')
                        ->where('user_id', $user_id)
                        ->limit(1)
                        ->get('registers')
                        ->row()
                ->user_phone;
        if (@$save_user_phone !== $send_user_phone) {
            @$save_user_phone = $this->db
                            ->select('user_phone')
                            ->where("user_phone = $send_user_phone AND user_id != $user_id")
                            //->where('user_phone', $send_user_phone)
                            //->and_where('user_id !=', $user_id)
                            ->limit(1)
                            ->get('registers')
                            ->row()
                    ->user_phone;
            if (@($save_user_phone === $send_user_phone)) {
                $mobile_verified = array(
                    '_error_code' => "500",
                    '_error_msg' => "Enter User Mobile No. $send_user_phone Not Allow, Try Again"
                );
                echo json_encode($mobile_verified);
                return FALSE;
            }
        }
        $code = mt_rand(1000, 9999);
        $msg = "Orafresh \n Moblie Number Verified OTP : " . $code;
        if ($this->sendsmsPOST($send_user_phone, $msg)) {
            $mobile_verified = array(
                /*
                  '_success' => "Send OTP Successfully",
                  'mobile_verified_otp_code' => $code
                 */
                'mobile_verified_otp_code' => $code,
                '_success_msg' => "Send OTP Successfully",
                '_sucsess_code' => "200"
            );
        } else {
            $mobile_verified = array(
                '_error_code' => "500",
                '_error_msg' => "Send OTP Faild Plz, Try Again"
            );
        }
        echo json_encode($mobile_verified);
    }

    private function reffrelPointToWalletTransfer($verified_user_id) {
        //$verified_user_id = null;
        $this->load->model("users_model");
        $data = array();
        $user_rafale_code = NULL;
        $verified_user_result_row = $this->db
                ->select('user_id')
                ->select('user_rafale_code')
                ->select('wallet')
                ->select('salf_rafale_point')
                ->where('user_id', $verified_user_id)
                ->limit(1)
                ->get('registers')
                ->row();
        $user_rafale_code = $verified_user_result_row->user_rafale_code;
        if (empty($user_rafale_code)) {
            $data["responce"] = false;
            $data["message"] = strip_tags("Refer Code Invalid");
            return $data;
        }
        $existing_user_id = null;
        $salf_rafale_point = 0;
        $salf_wallet = 0;
        $existing_user_result_row = $this->db
                ->select('user_id')
                ->select('salf_rafale_point')
                ->select('wallet')
                ->where('salf_rafale_code', $user_rafale_code)
                ->limit(1)
                ->get('registers')
                ->row();
        if (empty($existing_user_result_row)) {
            $data["responce"] = false;
            $data["message"] = strip_tags("Refer Code Invalid");
            //echo json_encode($data);
            return $data;
        } else {
            $existing_user_id = $existing_user_result_row->user_id;
            $cr_wallet_amount = $this->getRewardPoint()->point;
            $salf_rafale_point = $existing_user_result_row->salf_rafale_point + $cr_wallet_amount;
            $salf_wallet = $existing_user_result_row->wallet + $cr_wallet_amount;
            $set_array = array(
                "salf_rafale_point" => $salf_rafale_point,
                "wallet" => $salf_wallet
            );
            $this->db->where('user_id', $existing_user_id);
            $this->db->update('registers', $set_array);
            $this->users_model->crUserWalletHistory($existing_user_id, $cr_wallet_amount);

            /*             * ********************************* */

            $cr_wallet_amount = $this->getRewardPoint()->point;
            $salf_rafale_point = $verified_user_result_row->salf_rafale_point + $cr_wallet_amount;
            $salf_wallet = $verified_user_result_row->wallet + $cr_wallet_amount;
            $set_array = array(
                "salf_rafale_point" => $salf_rafale_point,
                "wallet" => $salf_wallet
            );
            $this->db->where('user_id', $verified_user_id);
            $this->db->update('registers', $set_array);
            $this->users_model->crUserWalletHistory($verified_user_id, $cr_wallet_amount);
            $data = array(
                '_success_code' => "200",
                '_success_msg' => "Server Process Update Successfully"
            );
            return $data;
        }
    }
    public function getCartDetail(){
        $this->load->model('product_model');
        $this->load->library('session');

            $productid_Arr      =   json_decode($this->input->post('product'), true);
            $proid              =   '';
            $proqty              =   '';
            foreach($productid_Arr as $row){ 
                if(empty($proid)){
                    $proid      =   $row['id'];
                    $proqty     =   $row['qty'];
                }
                else{
                    $proid      =   $proid.', '.$row['id'];
                    $proqty     =   $proqty.', '.$row['qty'];
                }    
            }
            $product    =   $this->product_model->get_productstock($proid);
            
            $Product_data   =   array();
            $proqty_Arr     =   explode(',',$proqty);
            for($i=0; $i<count($product); $i++){
                $Product_data[] = array(
                    'id'            =>  $product[$i]['product_id'],
                    'qty'           =>  trim($proqty_Arr[$i]),
                    'product_name'  =>  $product[$i]['product_name'],
                    'product_image' =>  $product[$i]['product_image'],
                    'category_id'   =>  $product[$i]['category_id'],
                    'rewards'       =>  $product[$i]['rewards'],
                    'unit_value'    =>  $product[$i]['unit_value'],
                    'unit'          =>  $product[$i]['unit'],
                    'price'         =>  $product[$i]['price'],
                    'mrp'           =>  $product[$i]['mrp'],
                    'stock'         =>  $product[$i]['stock'],
                    'increament'    =>  $product[$i]['increament']
                 );
            }
            $data['product']          =   $Product_data;
            //print_r($data);
            if (count($Product_data) > 0) {
                $data["responce"] = true;
                $data["msg"] = 'cart item list';
            }
        //$data['coupons'] = $this->product_model->coupon_list();
        echo json_encode($data);
    }
    public function returnOrder() {
        $user_id = $this->input->post('user_id');
        $order_id = $this->input->post('order_id');
        if(!empty($_POST)){
           
           $reason  = $this->input->post('reason');
           $requestfor  = $this->input->post('requestfor');
           $date= date('Y-m-d');
           if ($_FILES["pic"]["name"]) {  
		   
				$path = './uploads/returnOrder/';
				if (!is_dir($path)){
					@mkdir($path, 0777, true);
				}
				
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $this->load->library('upload', $config);
                $array_image            = '';
                if (!$this->upload->do_upload('pic')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $img_data = $this->upload->data();
                    $array_image = $img_data['file_name'];
                }
				
                $this->db->query('insert into refund_request(name,user_id,order_id,request_date,reason,pic,status, requestfor) values("'.$user_id.'","'.$user_id.'", "'.$order_id.'",  "'.$date.'" , "'.$reason.'","'.$array_image.'","0", "'.$requestfor.'") '); 
                $message = 'SucccessFully Submit Your Request ..';
                $this->db->query("Update sale SET status='-1' WHERE sale_id='".$order_id."'");
                //TEmplate 
                 $q = $this->db->query("SELECT registers.user_email, registers.user_gcm_code, 
                                        registers.user_ios_token, user_location.receiver_name, user_location.receiver_mobile  
                                        FROM registers 
                                        LEFT JOIN sale on sale.user_id=registers.user_id 
                                        AND sale.sale_id='".$order_id."'
                                        LEFT JOIN user_location on user_location.location_id=sale.location_id
                                        where  registers.user_id='".$user_id."'");
                $user = $q->row();
				
                
                $emailorder_refund     =   $this->config->item('emailorder_refund');
                $smsorder_refund       =   $this->config->item('smsorder_refund');
                $token = array(
                        'Name'      => $user->receiver_name,
                        'Username'  => $user->user_email,
                        'Password'  => $this->input->cookie("nspl_password"),
                        'Website'   => $this->config->item('name')
                    );
                    $pattern = '[%s]';
                    foreach($token as $key=>$val){
                        $varMap[sprintf($pattern,$key)] = $val;
                    }
                $msg               =  strtr($smsorder_refund,$varMap);
                $message1["title"] = "Return Order";
                $message1["message"] = strtr($smsorder_refund,$varMap);
                $message1["image"] = base_url()."uploads/company/".$this->config->item('logo');
                $message1["created_at"] = date("Y-m-d h:i:s");
                $message1["obj"] = "";

                //Order Mail Send Start
                $to_mail_arr = array();
                $to_mail_arr[0] = array('to_mail' => $user->user_email, 'to_name' => $user->receiver_name);
                $cc_mail_arr = array();
                $reply_to_mail_arr = array();
                $reply_to_mail_arr[0] = array('reply_mail'=>$this->config->item('email'),'reply_name'=>'noreply');
                $mail_subject = "Return Order";
                $mail_attachment_arr = array();
                $from_mail_arr = array();
                $from_mail_arr[0] = array('from_mail' => $this->config->item('email'), 'from_name' => $this->config->item('name'));
                $message = "<a href='".base_url()."' title='".$this->config->item('name')."'><img src='".base_url()."uploads/company/".$this->config->item('logo')."' style='float:right; width:30%;' alt='".$this->config->item('name')."' title='".$this->config->item('name')."'></a><br><br><br><br>";
           
                $message .= strtr($emailorder_refund,$varMap);
               // echo $message; print_r($message1); exit;
                
                $result  =  $this->send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr);

                //Register Mail Send End
                
                $this->setting_model->sendsmsPOST($user->receiver_mobile, $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));

                //Template
                $returndata = array('status'=>'1', 'message'=>'Refund Successfully', 'msg'=>$message);
                    // $this->session->set_flashdata('message', $message);
                    // redirect('home/returnOrder/'.$order_id);
            }
			else{
                
                $this->db->query('insert into refund_request(name,user_id,order_id,request_date,reason,pic,status) values("'.$user_id.'","'.$user_id.'", "'.$order_id.'",  "'.$date.'" , "'.$reason.'","","0") '); 
                $message = 'SucccessFully Submit Your Request ..';
                     //$messge = array('message' => 'Welcome To Eduncle Development Compamy', 'class' => 'alert alert-danger fade in');
                $returndata = array('status'=>'1', 'message'=>'Refund Successfully', 'msg'=>$message);
            }
           
        }
        $request = $this->db->query('select * from refund_request where user_id = "'.$user_id.'" AND order_id = "'.$order_id.'"   ')->result();
        
        $data = array(
             'user_order' => $order_id,
             'request' => $request
        );
        $returndata['data'] =   $data;
         echo json_encode($returndata);
       
    }
    
    public function payment_getway(){
        $qry = $this->db->query("SELECT * FROM `razorpay` WHERE status = 1");
        $data = $qry->result();
        if(count($data) > 0){
            $message = array('status'=>'1', 'message'=>'Gateway found', 'data'=>$data);
        }
        else{
            $message = array('status'=>'0', 'message'=>'Gateway not found', 'data'=>[]);
        }
        echo json_encode($message);
    }
    
    public function notification(){
        $user_id = $this->input->post('user_id');
        if(!empty($user_id)){
            $qry = $this->db->query("SELECT * FROM `notification` WHERE user_id IN($user_id, 0)");
        }
        else{
            $qry = $this->db->query("SELECT * FROM `notification` WHERE user_id IN(0)");
        }
        
        $data = $qry->result();
        if(count($data) > 0){
            $message = array('status'=>'1', 'message'=>'Notification found', 'data'=>$data);
        }
        else{
            $message = array('status'=>'0', 'message'=>'Notification not found', 'data'=>[]);
        }
        echo json_encode($message);
    }
    
     public function delete_notification(){
        $notification_id = $this->input->post('notification_id');
        if(!empty($notification_id)){
            $qry = $this->db->query("delete FROM `notification` WHERE user_id IN($notification_id, 0)");
            if($qry){
                $message = array('status'=>'1', 'message'=>'Notification Deleted');
            }
            else{
                $message = array('status'=>'0', 'message'=>'Notification not Deleted. Please Try Again.');
            }
        }
        else{
             $message = array('status'=>'0', 'message'=>'Please Enter Notification Id for Delete.');
        }
        
       
        echo json_encode($message);
    }
    
    
    public function wish_list() {
        $user_id = $this->input->post('user_id');
        $product_id = $this->input->post('product_id');
        $filter = $this->input->post('filter');
        if($filter=="add")
        {
            $this->db->query('insert into btl_wishlist(product_id,user_id,status) values("'.$product_id.'","'.$user_id.'",  "0") '); 
            $message = "product successfully added in wishlist.";
        }else if($filter=="remove")
        {
            $this->db->query('delete from btl_wishlist where product_id= "'.$product_id.'" and user_id = "'.$user_id.'" '); 
            $message = "product successfully removed from wishlist.";
        }
        
        $data = array(
             'status' => true,
             'message' => $message,
        );
        $returndata['data'] =   $data;
         echo json_encode($returndata);

    }
    
    
     public function notifyme() {
        $user_id = $this->input->post('user_id');
        $product_id = $this->input->post('product_id');
        $filter = $this->input->post('filter');
        if($filter=="add")
        {
            $this->db->query('insert into product_notifyme(product_id,user_id,status) values("'.$product_id.'","'.$user_id.'",  "0") '); 
            $message = "product successfully added in notify me.";
        }else if($filter=="remove")
        {
            $this->db->query('delete from product_notifyme where product_id= "'.$product_id.'" and user_id = "'.$user_id.'" '); 
            $message = "product successfully removed from notify me.";
        }
        
        $data = array(
             'status' => true,
             'message' => $message,
        );
        $returndata['data'] =   $data;
         echo json_encode($returndata);

    }
    
    
    function get_wishlist_products() {
        $this->load->model("product_model");
        $cat_id     =   "";
        $barnd_id   =   "";
        $product_id =   '';
        if ($this->input->post("cat_id")) {
            $cat_id     = $this->input->post("cat_id");
        }
        if ($this->input->post("barnd_id")) {
            $barnd_id   = $this->input->post("barnd_id");
        }
        if ($this->input->post("product_id")) {
            $product_id   = $this->input->post("product_id");
        }
        $search = $this->input->post("search");
        $user_id = $this->input->post("user_id");

        //$data["responce"] = true;  
        //$datas = $this->product_model->get_products_suggestion(false, $cat_id, $search, $this->input->post("page"), $barnd_id, $product_id);
        
        $datas = $this->product_model->get_wishlist_products($user_id);
        
        //print_r($datas); exit;
        if(!empty($datas)){
            foreach ($datas as $product) {
                $present = date('m/d/Y h:i:s a', time());
                //print_r($product); exit;
                $varient     =   $this->product_model->getProductVarient($product->product_id);
                 $varients   =   array();
                foreach($varient as $rowvarient){
                    $prices   = 0;
                    $date3 = $rowvarient->start_date . " " . $rowvarient->start_time;
                    $date4 = $rowvarient->end_date . " " . $rowvarient->end_time;
                    if (strtotime($date3) <= strtotime($present) && strtotime($present) <= strtotime($date4)) {
    
                        if(empty($rowvarient->deal_price)) {   ///Runing
                            $prices = $rowvarient->price;
                        } else {
                            $prices = $rowvarient->deal_price;
                        }
                    } else {
                        $prices = $rowvarient->price; //expired
                    }

                    $varients[]   =   array(
                                            "varient_id"    =>  $rowvarient->varient_id,
                                            "product_id"    =>  $rowvarient->product_id,
                                            "price"         =>  $prices,
                                            "qty"           =>  $rowvarient->qty,
                                            "unit"          =>  $rowvarient->unit,
                                            "stock_inv"     =>  $rowvarient->stock_inv,
                                            "tax"           =>  $rowvarient->tax,
                                            "mrp"           =>  $rowvarient->mrp,
                                            "date"          =>  $rowvarient->date,
                                            "description"   =>  $rowvarient->description,
                                            "store"         =>  $rowvarient->description,
                                            "store_id_login"=>  $rowvarient->store_id_login,
                                            "trash"         =>  $rowvarient->trash,
											"flavor"        =>  $rowvarient->flavor,
                                            "pro_var_images"=>  $this->uploadurl().'products/'.$rowvarient->pro_var_images,
                                        );
                    
                }
                                
                
                $date1 = $product->start_date . " " . $product->start_time;
                $date2 = $product->end_date . " " . $product->end_time;
    
                if (strtotime($date1) <= strtotime($present) && strtotime($present) <= strtotime($date2)) {
                    // Price
                    if (empty($product->deal_price)) {   ///Runing
                        if(empty($product->price)){
                            $price = $varient[0]->price;
                        }
                        else{
                            $price = $product->price;
                        }
                        
                    } else {
                        
                        $price = $product->deal_price;
                    }
                } else {
                    if(empty($product->price)){
                        $price = $varient[0]->price;
                    }
                    else{
                        $price = $product->price;
                    }
                     //expired
                }
                // MRP
                if(empty($product->mrp)){
                    $mrp = $varient[0]->mrp;
                }
                else{
                    $mrp = $product->mrp;
                }
                
                if($product->product_type == 1){
                    $title          =   "Vegetarian";
                }
                elseif($product->product_type == 2){
                    $title          =   "Non Vegetarian";
                }
                else{
                    $title          =   "";
                }
                
                $product_image  =   explode(',',$product->product_image);
                $image          =   array();
                if (in_array(2, $product_image)) {
                    foreach($product_image as $images){
                        $image[]    =  array('url' => $this->uploadurl().'products/'.$images);
                    }
                } elseif(!empty($product->product_imag)){
                  $image[]    =   array('url' => $this->uploadurl().'products/'.$product->product_image);
                }
                else{
                  $image[]    =   array('url' => $this->uploadurl().'products/'.$varient[0]->pro_var_images);
                }

                $product_call       =   $product->product_call == 1 ? $this->baseurl().'assets/images/swadeshi.png' : '';       
                //get wishlist product id by userid start from here
                $qqqq = $this->db->query('Select * from btl_wishlist WHERE user_id="'.$user_id.'" and product_id="'.$product->product_id.'"');
                $dataaa  = $qqqq->result();
//                echo "<br><br>";
//               print_r($dataaa);
           // echo "<br><br>";
                $wishlist="";
                if(count($dataaa) > 0){
                    $wishlist          =   "true";
                }
                else{
                    $wishlist          =   "false";
                }
                //get wishlist product id by userid start from end
                
                $data['data'][] = array(
                    'product_id'                => $product->product_id,
                    'product_name'              => $product->product_name,
                    'product_name_arb'          => $product->product_arb_name,
                    'product_description_arb'   => $product->product_arb_description,
                    'category_id'               => $product->category_id,
                    'brand_id'                  => !empty($product->brand_id) ? $product->brand_id : 0,
                    'brand_name'                => $product->brand_name,
                    'product_description'       => $product->product_description,
                    'deal_price'                => !empty($product->deal_price) ? $product->deal_price : 0,
                    'start_date'                => "",
                    'start_time'                => "",
                    'end_date'                  => "",
                    'end_time'                  => "",
                    //'difference_price' => $product->difference_price,
                    'difference_price'          => number_format((float) $product->difference_price, 2, '.', ''),
                    'price'                     => !empty($price) ? $price : 0,
                    'mrp'                       => !empty($mrp) ? $mrp : 0,
                    'product_image'             => !empty($product_image[0]) ? $product_image[0] : $varient[0]->pro_var_images,
                    'images_arr'                => $image,
                    //'tax'=>$product->tax,
                    'status'                    => '0',
                    'unit_value'                => !empty($product->unit_value) ? $product->unit_value : $varient[0]->qty,
                    'unit'                      => !empty($product->unit) ? $product->unit : $varient[0]->unit,
                    'increament'                => $product->increament,
                    'rewards'                   => $product->rewards,
                    'title'                     => $product->title,
                    'url'                       => $this->uploadurl().'products/',
                    'veg'                       => $title,
                    'swadesi'                   => $product_call,
                    'varient'                   => $varients,
                    'stock'                     => !empty($product->stock_inv) ? $product->stock_inv : "0",
                    'in_stock'                  => !empty($product->in_stock) ? $product->in_stock : "0",
                    'wishlist'                  => $wishlist,
                );
                unset($varients);
            }
            $data['status']     =   1;
            $data['message']     =   "Product Found";
        }
        else{
            $data['status']     =   0;
            $data['message']    =   "Product Not Found";
            $data['data']       =   array();     
        }
        echo json_encode($data);
    }
    
    
    //    --delivery boy api 1.3 version funtion start from here--   
    
    //delivery_boy_login
    public function driver_login() {
        //error_reporting(0);
        $data = array();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'Mobile Number', 'trim|required|max_length[10]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('device_id', 'Device Id', 'trim|required');
        
        if($this->form_validation->run() === FALSE) {
            $data["responce"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        }
        else{                
                //users.user_email='".$this->input->post('user_email')."' or
            //echo "Select * from delivery_boy where user_phone='".$this->input->post('phone')."' and user_password='" . md5($this->input->post('password')) . "' and trash='0'";
            
                $q = $this->db->query("Select * from delivery_boy where user_phone='".$this->input->post('phone')."' and user_password='" . md5($this->input->post('password')) . "' and trash='0'");
				$delivery_boy = $q->row();
                if(!empty($delivery_boy->id)) {
					$q1 = $this->db->query("select delivery_boy.*, country.name as country_name, tbl_states.state_name,tbl_city.city_name 
					from delivery_boy 
					LEFT JOIN country On country.id = delivery_boy.user_country
					LEFT JOIN tbl_states On tbl_states.state_id = delivery_boy.user_state
					LEFT JOIN tbl_city ON tbl_city.city_id = delivery_boy.user_city 
					where delivery_boy.id='".$delivery_boy->id."'");
					
                    $delivery_boy_details = $q1->row();
                    
                    //print_r($row);
                    
                    $access = $delivery_boy_details->user_status;
                    if($access == '0') {
                        $data["responce"] = false;
                        $data["message"] = 'Your account currently inactive. Please Contact Admin';
                    } else{
						
                        $delivery_boy_details->db_img_path = '';
						if(!empty($delivery_boy_details->deliverBoyImage)){
							$delivery_boy_details->db_img_path = base_url('./uploads/deliver/'.$delivery_boy_details->deliverBoyImage);
						}
						
						
                        $query_execute = $this->db->query('insert into user_last_login(user_id,  status, login_by, device_id, login_date) values("'.$delivery_boy_details->id.'", "0",  "delivery boy", "'.$this->input->post('device_id').'", "'.date("Y-m-d h:i:s").'")');
                        
                        if($query_execute)
                        {
                            $data["responce"] = true;
                            $data["message"] = 'Login Successfully.';
                            $data['data'] = $delivery_boy_details;
                        }
                        else{
                            $data["responce"] = false;
                            $data["message"] = 'login failed. Please Login Again';                            
                        }
                        
                    }    
                } else{
                    $data["responce"] = false;
                    $data["message"] = 'Invalide Username or Passwords. Please Try Again.';
                }
            }

        echo json_encode($data);
    }
    
    
    //ordersfortoday
    public function dboy_orders() {
		$data = array();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('dboy_id', 'Delivery Boy Id', 'trim|required');
		$this->form_validation->set_rules('custome_date', '', 'trim');
		if ($this->form_validation->run() === FALSE) {
			$data["responce"] = false;
			$data["message"] = strip_tags($this->form_validation->error_string());
		}
		else 
		{
			//echo "ram";
//                $q = $this->db->query("select * from `delivery_boy` where user_status=1");
//                $data['delivery_boy'] = $q->result();
			
			$custome_date = $this->input->post('custome_date');
			$where    =   "WHERE 1=1";
			if(!empty($custome_date)){
				$where .= " AND sale.on_date = '".$custome_date."'"; 
			}    
			$where .= " and sale.delivery_boy_id='".@$this->input->post('dboy_id')."'"; 
			
			$sql = "SELECT sale_items.*, sale.*, sale.status as sale_status, user_location.*, products.*,refund_request.refund_id as refund_id, product_varient.*, registers.*
								FROM sale
								LEFT JOIN  user_location ON user_location.location_id = sale.location_id
								LEFT JOIN  sale_items ON sale_items.sale_id = sale.sale_id
								LEFT JOIN  refund_request ON refund_request.order_id = sale.sale_id
								LEFT JOIN  registers ON registers.user_id = sale.user_id
								LEFT JOIN  products ON products.product_id = sale_items.product_id
								LEFT JOIN  product_varient ON product_varient.varient_id = sale_items.pro_var_id 
								 ".$where." ORDER BY sale.sale_id ASC";
								 
			
			$q = $this->db->query($sql);
			
			if(!empty($q->result()))
			{
				$today_orders =$q->result();
				if ($q->num_rows() > 0) {
					//print_r($today_orders);
					$data["responce"] = true;
					$data["message"] = 'Today Orders Details';
					$data['data'] = $today_orders;
				}
			}
			else
			{
				$data["responce"] = false;
				$data["message"] = 'Orders Not Exist.';
				$data['data'] = array();
			}
			
		}
		
		echo json_encode($data);
	}
	
	
    //ordersfortoday
    public function dboy_dashboard() {
		$data = array();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('dboy_id', 'Delivery Boy Id', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if ($this->form_validation->run() === FALSE) {
			$data["responce"] = false;
			$data["message"] = strip_tags($this->form_validation->error_string());
		}
		else 
		{
			
			$this->load->model("product_model");
			
			$status = $this->input->post('status');
			$dboy_id = $this->input->post('dboy_id');
			
			$where = "WHERE sale.delivery_boy_id='".$dboy_id."'";
			if($status == 'running'){
				$where .= " AND sale.status IN(2,5)"; 
			}
			elseif($status == 'complete'){
				$where .= " AND sale.status IN(4,-1)"; 
			} 
			elseif($status == 'assign'){
				$where .= " AND sale.status IN(1)"; 
			}
			else{
				// $where .= " AND sale.status =''";
			}
			
			
			
			$where1 = "WHERE refund_request.delivery_boy_id='".$dboy_id."'";
			if($status == 'running'){
				$where1 .= " AND refund_request.status IN(3,4,5)"; 
			}
			elseif($status == 'complete'){
				$where1 .= " AND refund_request.status IN(7)"; 
			} 
			elseif($status == 'assign'){
				$where1 .= " AND refund_request.status IN(1)"; 
			}
			else{
				// $where1 .= " AND refund_request.status =''";
			}
			
			
			$data['total_orders'] = '';
			$data['delivered_orders'] = '';
			
			$q = $this->db->query("SELECT count(*) AS tot FROM sale WHERE sale.delivery_boy_id='".$dboy_id."'");
			$data['total_orders'] = $data['delivered_orders'] = 0;
			$total_orders = $q->row();
			if(!empty($total_orders->tot)){
				$data['total_orders'] = $total_orders->tot;
			}
			
			$q = $this->db->query("SELECT count(*) AS tot FROM refund_request WHERE refund_request.delivery_boy_id='".$dboy_id."'");
			$total_orders = $q->row();
			if(!empty($total_orders->tot)){
				$data['total_orders'] += $total_orders->tot;
			}
			
			$q = $this->db->query("SELECT count(*) AS tot FROM sale WHERE sale.delivery_boy_id='".$dboy_id."' AND sale.status IN(4,-1)");
			$delivered_orders = $q->row();
			if(!empty($delivered_orders->tot)){
				$data['delivered_orders'] = $delivered_orders->tot;
			}
			
			$q = $this->db->query("SELECT count(*) AS tot FROM refund_request WHERE refund_request.delivery_boy_id='".$dboy_id."' AND refund_request.status IN(4,7,8)");
			$delivered_orders = $q->row();
			if(!empty($delivered_orders->tot)){
				$data['delivered_orders'] += $delivered_orders->tot;
			}
			
			$today_orders = [];
			
			$sql = "SELECT sale.*, sale.status as sale_status, user_location.*, registers.*, sale.on_date as order_date1
				FROM sale
				LEFT JOIN  user_location ON user_location.location_id = sale.location_id
				LEFT JOIN  registers ON registers.user_id = sale.user_id
				".$where." 
				ORDER BY sale.on_date DESC";
			
			$q = $this->db->query($sql);
			$sale =$q->result();
			
			
			$sql = "SELECT refund_request.*, sale.*, refund_request.assign_dboy_date as assign_dboy_date, refund_request.status as sale_status, user_location.*, registers.*, refund_request.request_date as order_date1
				FROM refund_request
				LEFT JOIN sale ON sale.sale_id = refund_request.order_id
				LEFT JOIN user_location ON user_location.location_id = sale.location_id
				LEFT JOIN registers ON registers.user_id = sale.user_id
				".$where1." 
				ORDER BY refund_request.request_date DESC";
			
			$q = $this->db->query($sql);
			$refund_request = $q->result();
			
			$today_orders = array_merge($sale,$refund_request);
			
			$price = array();
			foreach ($today_orders as $key => $row)
			{
				$price[$key] = $row->assign_dboy_date;
			}
			array_multisort($price, SORT_DESC, $today_orders);


			foreach($today_orders as $key => $value){
				$order_items = $this->product_model->get_sale_order_items($value->sale_id);
				foreach($order_items as $key1 => $pv){
					$pv_image  =   explode(',',$pv->product_image);
					if(!empty($pv_image[0])){
						$order_items[$key1]->product_image_path = $this->uploadurl().'products/'.$pv_image[0];
					}
				}
				
				if(!empty($value->refund_id)){
					$today_orders[$key]->order_type = 1;
				}
				else{
					$today_orders[$key]->order_type = 0;
					$today_orders[$key]->refund_id = 0;
				}
				
				$today_orders[$key]->item = $order_items;
			}
			
			
			if(!empty($today_orders))
			{
				
				$data["responce"] = true;
				$data["message"] = 'Today Orders Details';
				$data['data'] = $today_orders;
				
			}
			else
			{
				$data["responce"] = false;
				$data["message"] = 'Orders Not Exist.';
				$data['data'] = array();
			}
			
		}
		
		echo json_encode($data);
	}
        
    
    public function dboy_forgot_password() {
		$data = array();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('mobile_no', 'Mobile NUmber', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() === FALSE) {
			$data["response"] = false;
			$data["message"] = strip_tags($this->form_validation->error_string());
		}
		else 
		{
			
			
			$q = $this->db->query("Select * from delivery_boy where user_phone='".$this->input->post('mobile_no')."' and trash='0'");
			
		//echo $q->num_rows();
			if ($q->num_rows() > 0) {
				$delivery_boy_details = $q->row();                    
				//print_r($row);                    
				$access = $delivery_boy_details->user_status;
				if ($access == '0') {
					$data["response"] = false;
					$data["message"] = 'Your Account Currently Inactive. Please Contact Admin';
				} 
				else {
					$data   =   array(
						'user_password'   =>  md5($this->input->post('password'))                            
						);
					$this->db->where('user_phone', $this->input->post('mobile_no'));
					$result     =   $this->db->update('delivery_boy', $data);
					if($result)
					{
						$data["response"] = true;
						$data["message"] = 'Password Updated Successfully.';
						//$data['data'] = $delivery_boy_details;
					}
					else
					{
						$data["response"] = false;
						$data["message"] = 'Password Updation failed. Please Try Again';                            
					}
				}
			}
			else
			{
				$data["response"] = false;
				$data["message"] = 'Mobile Number Not Exist. Please Enter Correct Mobile Number.';  
			}               
			
		}
		echo json_encode($data);
	}
    
    public function dboy_profile() {
		$data = array();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('dboy_id', 'Delivery Boy Id', 'trim|required');
		$this->form_validation->set_rules('user_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('user_phone', 'Mobile Number', 'trim|required');
		$this->form_validation->set_rules('user_email', 'Email Number', 'trim|required');
		// $this->form_validation->set_rules('user_address', 'Address', 'trim|required');
		// $this->form_validation->set_rules('user_city', 'City', 'trim|required');
		// $this->form_validation->set_rules('user_state', 'State', 'trim|required');
		// $this->form_validation->set_rules('user_country', 'Country', 'trim|required');
		// $this->form_validation->set_rules('user_pincode', 'Pincode', 'trim|required');
		if ($this->form_validation->run() === FALSE) {
			$data["response"] = false;
			$data["message"] = strip_tags($this->form_validation->error_string());
		}
		else 
		{
			
			$dboy_id = $this->input->post('dboy_id');
			$user_phone = $this->input->post('user_phone');
			$q = $this->db->query("Select * from delivery_boy where id='".$dboy_id."' and trash='0'");
			if ($q->num_rows() > 0) {
				
				$q1 = $this->db->query("Select * from delivery_boy where user_phone='".$user_phone."' and id!='".$dboy_id."' and trash='0'");
				if ($q1->num_rows() == 0) {
				    $user_address = $this->input->post("user_address");
				    $user_city = $this->input->post("user_city");
				    $user_state = $this->input->post("user_state");
				    $user_country = $this->input->post("user_country");
				    $user_pincode = $this->input->post("user_pincode");
					$data1 = array(
						"user_name" => $this->input->post("user_name"),
                        "user_phone" => $this->input->post("user_phone"),
                        "user_email" => $this->input->post("user_email"),
                        // "user_address" => !empty($user_address)? $user_address : '',
                        // "user_city" => !empty($user_city)? $user_city : '',
                        // "user_state" => !empty($user_state)? $user_state : '',
                        // "user_country" => !empty($user_country)? $user_country : '',
                        // "user_pincode" => !empty($user_pincode)? $user_pincode : '',
					);
					
					$this->db->where('id', $this->input->post('dboy_id'));
					$result = $this->db->update('delivery_boy', $data1);
					if($result) {
						$data["response"] = true;
						$data["message"] = 'Profile Updated Successfully.';
						//$data['data'] = $delivery_boy_details;
					}
					else {
						$data["response"] = false;
						$data["message"] = 'Profile Updation failed. Please Try Again';                            
					}
				}
				else
				{
					$data["response"] = false;
					$data["message"] = 'Mobile Number Aleady Exits.';  
				}               
				
			}
			else
			{
				$data["response"] = false;
				$data["message"] = 'Invalid ID.';  
			}               
			
		}
		echo json_encode($data);
	}
    
    
    public function dboy_profile_img() {
		$data = array();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('dboy_id', 'Delivery Boy Id', 'trim|required');
		if ($this->form_validation->run() === FALSE) {
			$data["response"] = false;
			$data["message"] = strip_tags($this->form_validation->error_string());
		}
		else 
		{
			
			$dboy_id = $this->input->post('dboy_id');
			$q = $this->db->query("Select * from delivery_boy where id='".$dboy_id."' and trash='0'");
			if ($q->num_rows() > 0) {
				$file_size = 2097152;
				if (isset($_FILES["db_image"]) && $_FILES["db_image"]["size"] > 0) {
					if($_FILES['db_image']['size'] <= $file_size){
						$config['upload_path'] = './uploads/deliver/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$this->load->library('upload', $config);

						if (!$this->upload->do_upload('db_image')) {
							$error = strip_tags($this->upload->display_errors());
						} 
						else {
							$img_data = $this->upload->data();
							$array["deliverBoyImage"] = $img_data['file_name'];
						}
					}
					else{
						$error = 'Error! File size is greater then '.($file_size/1024/1024).' MB';
					}
				}
				
				
				if (empty($error) && !empty($array)) {
				    
					$this->db->where('id', $this->input->post('dboy_id'));
					$result = $this->db->update('delivery_boy', $array);
					if($result) {
						$data["response"] = true;
						$data["message"] = 'Profile Updated Successfully.';
						//$data['data'] = $delivery_boy_details;
					}
					else {
						$data["response"] = false;
						$data["message"] = 'Profile Updation failed. Please Try Again';                            
					}
				}
				else
				{
					$data["response"] = false;
					$data["message"] = $error;  
				}               
				
			}
			else
			{
				$data["response"] = false;
				$data["message"] = 'Invalid ID.';  
			}               
			
		}
		echo json_encode($data);
	}
    
    
    public function dboy_delivery_order_status() {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dboy_id', 'Delivery Boy Id', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        // $this->form_validation->set_rules('status', 'Status', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $data["response"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        }
        else {    
			$status = $this->input->post('status');
			$signature = '';
			if (isset($_FILES["signature"]) && $_FILES["signature"]["size"] > 0) {
				$path = './uploads/signature/';
				if (!is_dir($path)){
					@mkdir($path, 0777, true);
				}
				
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('signature')) {
                    $data["responce"] = false;
                    $data["message"] = 'Error! : ' . $this->upload->display_errors();
                } else {
                    $img_data = $this->upload->data();
                    $signature  =   $img_data['file_name'];
					// $url    =   $url.$img_data['file_name'];
                }
            }
			
			$error = '';
			if(empty($signature)){
				$error = 'Please upload customer signature image.';
			}
			
			
            $q = $this->db->query("Select * from sale where sale_id='".$this->input->post('order_id')."'");
            if ($q->num_rows() > 0) {
				if(empty($error)){
					$data1   =   array(
						'status' =>  '4',                            
						'signature' =>  $signature,
						'dboy_description' =>  $this->input->post('description'),
						'order_deliverd_date'   =>  date('Y-m-d H:i:s'),
					);  
                
                    $this->db->where('delivery_boy_id', $this->input->post('dboy_id'));
                    $this->db->where('sale_id', $this->input->post('order_id'));
                    $result = $this->db->update('sale', $data1);
                    if($result)
                    {
						$data["response"] = true;
						$data["message"] = 'Order Delivered Updated Successfully.';
                    }
                    else {
                        $data["response"] = false;
                        $data["message"] = 'Record Updation failed. Please Try Again';
                    }
                }
				else
				{
					$data["response"] = false;
					$data["message"] = $error;
				}
				
            }
            else{
                $data["response"] = false;
                $data["message"] = 'Order id Not Exist. Please Enter Correct Order id.';  
            }               

        }
        echo json_encode($data);
    }
    
    
    public function return_order() {
        $data = array();
		
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('refund_id', 'Refund Id', 'trim|required');
        $this->form_validation->set_rules('dboy_id', 'Delivery Boy Id', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $data["response"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        }
        else 
        {  
			
			$product_images = '';
			if (isset($_FILES["product_images"]) && $_FILES["product_images"]["size"] > 0) {
				$path = './uploads/return_order/';
				if (!is_dir($path)){
					@mkdir($path, 0777, true);
				}
				
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('product_images')) {
                    $data["responce"] = false;
                    $data["message"] = 'Error! : ' . $this->upload->display_errors();
                } else {
                    $img_data = $this->upload->data();
                    $product_images  =   $img_data['file_name'];
                }
                

            }
			
			$error = '';
			if(empty($product_images)){
				$error = 'Please upload product image.';
			}
			
            $q = $this->db->query("Select * from refund_request where refund_id='".$this->input->post('refund_id')."'");
       
            if ($q->num_rows() > 0) {
				if(empty($error)){
					$data1   =   array(
						'status' =>  '5',                            
						'dboy_images' =>  $product_images,
						'dboy_description' =>  $this->input->post('description'),
						'refund_date'   =>  date('Y-m-d H:i:s'),
					);   
                                       

                    $this->db->where('refund_id', $this->input->post('refund_id'));
                    $result     =   $this->db->update('refund_request', $data1);
                    if($result)
                    {
						$data["response"] = true;
						$data["message"] = 'Order Return Process Successfully.';
                    }
                    else {
                        $data["response"] = false;
                        $data["message"] = 'Order Return Process failed. Please Try Again';
                    }
				}
				else
				{
					$data["response"] = false;
					$data["message"] = $error;                           
				}
                
            }
            else
            {
                $data["response"] = false;
                $data["message"] = 'Refund Request Not Exist for this Order Id. Please Enter Correct Order id.';  
            }               

        }
        echo json_encode($data);
    }
    
    public function delivery_boy_presents() {
        $data = array();
        $this->load->library('form_validation');        

        $this->form_validation->set_rules('dboy_id', 'Delivery Boy Id', 'trim|required');
        $this->form_validation->set_rules('status', 'Delivery Boy Present Status', 'trim|required');       

        if ($this->form_validation->run() === FALSE) {
            $data["response"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        }
        else 
        {  

            $query_execute = $this->db->query('insert into delivery_boy_presents(delivery_boy_id,  status, punch_date, punch_time) values("'.$this->input->post('dboy_id').'", "'.$this->input->post('status').'", "'.date("Y-m-d").'", "'.date("h:i:s").'")');
                        
            if($query_execute)
            {
                
                $query_execute = $this->db->query('update delivery_boy set present_status="'.$this->input->post('status').'" where id="'.$this->input->post('dboy_id').'"');
                
                $data["responce"] = true;
                
                if($this->input->post('status')=="1")
                {
                    $data["message"] = 'User is Active.';
                }
                else
                {
                     $data["message"] = 'User is Inactive.';
                }
                
               
                //$data['data'] = $delivery_boy_details;
            }
            else
            {
                $data["responce"] = false;
                $data["message"] = 'Staus Activation failed. Please Try Again';                            
            }            

        }
        echo json_encode($data);
    }

    public function dboy_upload_doc() {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dboy_id', 'Delivery Boy Id', 'trim|required');
        $this->form_validation->set_rules('id_proof_name', 'Id Proof Name', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $data["response"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        }
        else {    
			$file_size = 2097152;
			$image_file = $image_file_back = '';
			if (isset($_FILES["image_file"]) && $_FILES["image_file"]["size"] > 0) {
				if($_FILES['image_file']['size'] <= $file_size){
					$path = './uploads/deliver/';
					if (!is_dir($path)){
						@mkdir($path, 0777, true);
					}
					
					$config['upload_path'] = $path;
					$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('image_file')) {
						$error = 'Error! : ' . strip_tags($this->upload->display_errors());
					} else {
						$img_data = $this->upload->data();
						$image_file = $img_data['file_name'];
					   // $url    =   $url.$img_data['file_name'];
					}

				}
				else{
					$error = 'Error! File size is greater then '.($file_size/1024/1024).' MB';
				}
			}
			
			if (isset($_FILES["image_file_back"]) && $_FILES["image_file_back"]["size"] > 0) {
				if($_FILES['image_file_back']['size'] <= $file_size){
					$path = './uploads/deliver/';
					if (!is_dir($path)){
						@mkdir($path, 0777, true);
					}
					
					$config['upload_path'] = $path;
					$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('image_file_back')) {
						$error = 'Error! : ' . strip_tags($this->upload->display_errors());
					} else {
						$img_data = $this->upload->data();
						$image_file_back = $img_data['file_name'];
					   // $url    =   $url.$img_data['file_name'];
					}

				}
				else{
					$error = 'Error! File size is greater then '.($file_size/1024/1024).' MB';
				}
			}
			
			// echo $image_file;
			$dboy_id = $this->input->post('dboy_id');
			$id_proof_name = $this->input->post('id_proof_name');
			$q = $this->db->query("Select * from delivery_boy where id='".$dboy_id."'");
			if ($q->num_rows() > 0) {
				if(empty($error)){
					
					$doc_exitas = $this->db->query("Select * from delivery_boy_doc where id_proof_name='".$id_proof_name."' and delivery_boy_id='".$dboy_id."'")->row();
					
					if(!empty($doc_exitas->id)){
						$data1['image_file'] = $image_file;
						if(!empty($image_file_back)){	
							$data1['image_file_back'] = $image_file_back;
						}
						
						$this->db->where('id', $doc_exitas->id);
						$result = $this->db->update('delivery_boy_doc', $data1);
					}
					else{
						$data1['delivery_boy_id'] = $this->input->post('dboy_id');
						$data1['id_proof_name'] = $id_proof_name;
						$data1['image_file'] = $image_file;
						if(!empty($image_file_back)){	
							$data1['image_file_back'] = $image_file_back;
						}
						
						
						$result = $this->db->insert('delivery_boy_doc', $data1);
					}
					if($result){
						$data["response"] = true;
						$data["message"] = 'File Updated Successfully.';
					}
					else{
						$data["response"] = false;
						$data["message"] = 'File Updation failed. Please Try Again';
					}
					
				}
				else{
					$data["response"] = false;
					$data["message"] = $error;  
				}               

            }
            else{
                $data["response"] = false;
                $data["message"] = 'Delivery Boy does not exist. Please Enter Correct Delivery Boy id.';  
            }               

        }
        echo json_encode($data);
    }
    
    public function dboy_doc() {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dboy_id', 'Delivery Boy Id', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $data["response"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        }
        else {    
			
			
			$path = $this->uploadurl().'deliver/';
			$q = $this->db->query("Select * from delivery_boy_doc where delivery_boy_id='".$this->input->post('dboy_id')."'");
			$dboy_doc = $q->result_array();
			if($dboy_doc){
				$data["response"] = true;
				$data["message"] = 'Delivery Boy document List.';
				$data['data'] = $dboy_doc;
			}
			else{
				$data["response"] = false;
				$data["message"] = 'No record Found';
			}        

        }
        echo json_encode($data);
    }
    
    public function review_add() {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('product_id', 'Product Id', 'trim|required');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        $this->form_validation->set_rules('description', 'Review', 'trim|required');
        $this->form_validation->set_rules('rating', 'Rating', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $data["response"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        }
        else {    
			
			
			// echo $image_file;
			$user_id = $this->input->post('user_id');
			$product_id = $this->input->post('product_id');
			$description = $this->input->post('description');
			$rating = $this->input->post('rating');
			$registers = $this->db->query("SELECT * FROM `registers` WHERE user_id='".$user_id."'")->row();
			if (!empty($registers)) {
				$sale_items = $this->db->query("SELECT * FROM `sale_items` join sale on sale.sale_id = sale_items.sale_id and sale_items.product_id='".$product_id."' WHERE sale.user_id='".$user_id."'")->row();
				if(!empty($sale_items)){
					$data1['user_id'] = $user_id;
					$data1['product_id'] = $product_id;
					$data1['description'] = $description;
					$data1['rating'] = $rating;
					$data1['username'] = $registers->user_fullname;
					$data1['created_date'] = date('Y-m-d H:i:s');
					
					$doc_exitas = $this->db->query("Select * from rating_table where product_id='".$product_id."' and user_id='".$user_id."'")->row();
					
					if(!empty($doc_exitas->review_id)){
						$this->db->where('review_id', $doc_exitas->review_id);
						$result = $this->db->update('rating_table', $data1);
						if($result){
							$data["response"] = true;
							$data["message"] = 'Review updated Successfully.';
						}
					}
					else{
						$result = $this->db->insert('rating_table', $data1);
						if($result){
							$data["response"] = true;
							$data["message"] = 'Review saved Successfully.';
						}
					}
					
					if(empty($result)){
						$data["response"] = false;
						$data["message"] = 'Review are not saved. Please Try Again';
					}
					
				}
				else{
					$data["response"] = false;
					$data["message"] = 'First you need to perchase this product.';   
				}               

            }
            else{
                $data["response"] = false;
                $data["message"] = 'Invalid User.';  
            }               

        }
        echo json_encode($data);
    }
    
    public function review_list() {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('product_id', 'Product Id', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $data["response"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        }
        else {    
			
			
			$product_id = $this->input->post('product_id');
			$q = $this->db->query("Select * from rating_table where product_id='".$product_id."' and review_status='0' and review_trash='0'");
			$records = $q->result_array();
			if($records){
				$count = $this->db->query("Select count(*) as review, avg(rating) as rating_avg from rating_table where product_id='".$product_id."' and review_status='0' and review_trash='0'")->row_array();
			
				$data["response"] 		= true;
				$data["message"] 		= 'Review List.';
				$data['total_review']	= !empty($count['review'])? $count['review'] : 0;
				$data['total_rating']	= !empty($count['rating_avg'])? round($count['rating_avg'],1) : 0;
				$data['data'] 			= $records;
			}
			else{
				$data["response"] = false;
				$data["message"] = 'No record Found';
				$data['data'] = [];
			}        

        }
        echo json_encode($data);
    }
    
    public function dboy_accept() {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dboy_id', 'Delivery Boy Id', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('order_type', 'Order Type', 'trim|required');
		if($this->input->post('status') == 0 || $this->input->post('status') == 2){
			// $this->form_validation->set_rules('description', 'Description', 'trim|required');
		}
		if($this->input->post('order_type')  == 1){
			$this->form_validation->set_rules('refund_id', 'Refund Id', 'trim|required');
		}
		
        if ($this->form_validation->run() === FALSE) {
            $data["response"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        }
        else {    
			$status = $this->input->post('status');
			$dboy_id = $this->input->post('dboy_id');
			$order_id = $this->input->post('order_id');
			$refund_id = $this->input->post('refund_id');
			$order_type = $this->input->post('order_type');
			$description = $this->input->post('description');
			if($order_type == 1){
				$q = $this->db->query("Select * from refund_request where refund_id='".$refund_id."'");
			}
			else{
				
				$q = $this->db->query("Select * from sale where sale_id='".$order_id."'");
			}
			$order = $q->row_array();
			if (!empty($order)){
				// for reject  
				if($status == 0){ 
					// for return process 
					if($order_type == 1){
						$data1   =   array(
							'status' => '1',
							'delivery_boy_id' => '',
							'dboy_description' => !empty($description)? $description : '',
						); 
						$this->db->where('refund_id', $refund_id);
						$result = $this->db->update('refund_request', $data1);
					}
					// for order 
					else{
						$data1   =   array(
							'status' => '1',
							'delivery_boy_id' => '',
							'dboy_description' => !empty($description)? $description : '',
						); 
						$this->db->where('sale_id', $order_id);
						$result = $this->db->update('sale', $data1);
					}
				}
				// for accept 
				else if($status == 1){ 
					// for return process 
					if($order_type == 1){
						$data1   =   array(
							'status' => '3',
						); 
						$this->db->where('refund_id', $refund_id);
						$result = $this->db->update('refund_request', $data1);
					}
					// for order 
					else{
						$data1   =   array(
							'status' => '2',
						); 
						$this->db->where('sale_id', $order_id);
						$result = $this->db->update('sale', $data1);
					}
				}
				// for hold 
				else if($status == 2){ 
					// for return process 
					if($order_type == 1){
						$data1   =   array(
							'status' => '4',
							'dboy_description' => !empty($description)? $description : '',
						); 
						$this->db->where('refund_id', $refund_id);
						$result = $this->db->update('refund_request', $data1);
					}
					// for order 
					else{
						$data1   =   array(
							'status' => '5',
							'dboy_description' => !empty($description)? $description : '',
						); 
						$this->db->where('sale_id', $order_id);
						$result = $this->db->update('sale', $data1);
					}
				}
					
				$data2 = array(
					'status' => $status,
					'order_id' => $order_id,
					'order_type' => $order_type,
					'delivery_boy_id' => $dboy_id,
					'description' => !empty($description)? $description : '',
					'created_date' => date("Y-m-d h:i:s"),
				); 
				if($order_type == 1){
					$data2['refund_id'] = $refund_id;
				}
				$result = $this->db->insert('delivery_boy_accept', $data2);
				if($result){
					$data["response"] = true;
					$data["message"] = 'Request Updated Successfully.';
				}
				else{
					$data["response"] = false;
					$data["message"] = 'Request Updation failed. Please Try Again';
				}
					
				            

            }
            else{
                $data["response"] = false;
                $data["message"] = 'Invalid Order id.';  
            }               

        }
        echo json_encode($data);
    }
    
    public function dboy_return_denied() {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dboy_id', 'Delivery Boy Id', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('refund_id', 'Refund Id', 'trim|required');
		
        if ($this->form_validation->run() === FALSE) {
            $data["response"] = false;
            $data["message"] = strip_tags($this->form_validation->error_string());
        }
        else {    
			$dboy_id = $this->input->post('dboy_id');
			$order_id = $this->input->post('order_id');
			$refund_id = $this->input->post('refund_id');
			$q = $this->db->query("Select * from refund_request where refund_id='".$refund_id."'");
			$order = $q->row_array();
			if (!empty($order)){
				 
				$data1   =   array(
					'status' => '6',
					'dboy_description'   =>  $this->input->post('description'),
				); 
				$this->db->where('refund_id', $refund_id);
				$result = $this->db->update('refund_request', $data1);
				
				if($result){
					$data["response"] = true;
					$data["message"] = 'Request Updated Successfully.';
				}
				else{
					$data["response"] = false;
					$data["message"] = 'Request Updation failed. Please Try Again';
				}
					
				            

            }
            else{
                $data["response"] = false;
                $data["message"] = 'Invalid Order id.';  
            }               

        }
        echo json_encode($data);
    }
    
    
    //    --delivery boy api 1.3 version funtion end here--

}
class MyFunction {
    
}

/*
  ALTER TABLE `registers`
  ADD COLUMN `user_rafale_code` VARCHAR(15) NULL AFTER `rewards`,
  ADD COLUMN `salf_rafale_code` VARCHAR(15) NULL AFTER `user_rafale_code`,
  ADD COLUMN `salf_rafale_point` INT(11) NOT NULL DEFAULT 0 AFTER `salf_rafale_code`;

 */
?>
