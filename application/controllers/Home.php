<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    private $live_app_path = "";//https://play.google.com/store/apps/details?id=in.kriscent.basket2home2";
    private $data = array();
    private $cart_product_arr = array();

    public function __construct() {
        //echo "hello"; exit;
        parent::__construct();
        date_default_timezone_set('Africa/Johannesburg');
        
        $this->load->library('session');
        $this->load->model('Oauth_model', 'oauth_model');
        $this->load->model("Products_model", 'Products_model');
        $this->load->model("Setting_model", "setting_model");
        $this->load->helper('cookie');
		$this->load->helper('url');
        $this->config->set_item('images_url', 'backend/uploads/');
        //$this->config->set_item('isPlaceOrderRunning', false);
        //$this->load->helper('login_helper');
        //$this->load->helper('sms_helper');
        
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
        // $this->config->set_item('minimum_order_deduction', $company[13]->value);
        // $this->config->set_item('delivery_start_time', $company[14]->value);
        // $this->config->set_item('delivery_end_time', $company[15]->value);
        // $this->config->set_item('company_whatsappno', $company[16]->value);
        // $this->config->set_item('fb', $company[17]->value);
        // $this->config->set_item('insta', $company[18]->value);
        // $this->config->set_item('twitter', $company[19]->value);
        // $this->config->set_item('linkedn', $company[20]->value);
        // $this->config->set_item('youtube', $company[21]->value);
        // $this->config->set_item('rewards', $company[22]->value);
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
        // $this->config->set_item('facebook_app_id', $company[65]->value);
        // $this->config->set_item('facebook_app_secret', $company[66]->value);
        // $this->config->set_item('google_client_id', $company[67]->value);
        // $this->config->set_item('google_client_secret', $company[68]->value);
        // $this->config->set_item('delivery_date_after_days', $company[69]->value);
        // $this->config->set_item('get_version_download', $company[70]->value);
		
		
		$this->config->set_item('name', $this->get_company_value('company_title'));        
        $this->config->set_item('logo', $this->get_company_value('company_logo'));        
        $this->config->set_item('favicon', $this->get_company_value('company_favicon'));        
        $this->config->set_item('tagline', $this->get_company_value('company_taglaine'));        
        $this->config->set_item('referal', $this->get_company_value('company_referal'));
        $this->config->set_item('email', $this->get_company_value('company_email'));
        $this->config->set_item('mobile', $this->get_company_value('company_mobile'));
        $this->config->set_item('one_row_item', $this->get_company_value('web_one_row_item_show'));
		
		
        $main_currency = $this->get_company_value('currency');
        //print_r($this->config); exit;
        
        $currency = $this->db
                ->select('*')
                ->where('id', $main_currency)
                ->get('currencies')
                ->row();
        //print_r($currency); exit;
        $this->config->set_item('currency', $currency->symbol);
        $this->config->set_item('currency_amount', $currency->current_amount);
        
        // Theme Setting
        $theme = $this->db
                ->select('*')
                ->where('meta_type','web')
                ->get('theme_color_setting')
                ->result();
        if(!empty($theme)){
            foreach($theme as $row){
                $this->config->set_item($row->meta_key, $row->meta_value); 
            }
        }
        
        //Order Minimum & Maximum value
        $settings = $this->db
                ->select('*')
                ->get('settings')
                ->result();
        if(!empty($settings)){
            foreach($settings as $row){
                $this->config->set_item($row->title, $row->value); 
            }
        }
        
        
        $themes = $this->db
                ->select('*')
                ->where('meta_type','app')
                ->where('meta_key IN("base_url","images_url")')
                ->get('theme_color_setting')
                ->result();
                //print_r($themes); exit;
        if(!empty($themes)){
            foreach($themes as $row){
                $this->config->set_item($row->meta_key, $row->meta_value); 
            }
        }
        
        //print_r($this->config); exit;
        
       // $smsTemplate = $this->db
                // ->select('*')
                // ->where('status',1)
                // ->get('sms_template')
                // ->result();
        // if(!empty($smsTemplate)){
            // $this->config->set_item('smsorder_confirmation', $smsTemplate[0]->description);
            // $this->config->set_item('smsorder_dispatch', $smsTemplate[1]->description);
            // $this->config->set_item('smsorder_delivery', $smsTemplate[2]->description);
            // $this->config->set_item('smsorder_cancel', $smsTemplate[3]->description);
            // $this->config->set_item('smsorder_refund', $smsTemplate[4]->description);
            // $this->config->set_item('smssignup', $smsTemplate[5]->description);
            // $this->config->set_item('smssend_order', $smsTemplate[6]->description);
            // $this->config->set_item('smsforgot_password', $smsTemplate[7]->description);
        // } 
        
		$this->config->set_item('smsorder_confirmation', $this->smsTemplate(1));
		$this->config->set_item('smsorder_dispatch', $this->smsTemplate(2));
		$this->config->set_item('smsorder_delivery', $this->smsTemplate(3));
		$this->config->set_item('smsorder_cancel', $this->smsTemplate(4));
		$this->config->set_item('smsorder_refund', $this->smsTemplate(5));
		$this->config->set_item('smssignup', $this->smsTemplate(6));
		$this->config->set_item('smssend_order', $this->smsTemplate(7));
		$this->config->set_item('smsforgot_password', $this->smsTemplate(8));
		
		
		// $EmailTemplate = $this->db
                // ->select('*')
                // ->where('status',1)
                // ->get('mail_template')
                // ->result();
        // if(!empty($EmailTemplate)){
            // $this->config->set_item('emailorder_confirmation', $EmailTemplate[0]->description);
            // $this->config->set_item('emailorder_dispatch', $EmailTemplate[1]->description);
            // $this->config->set_item('emailorder_delivery', $EmailTemplate[2]->description);
            // $this->config->set_item('emailorder_cancel', $EmailTemplate[3]->description);
            // $this->config->set_item('emailorder_refund', $EmailTemplate[4]->description);
            // $this->config->set_item('emailsignup', $EmailTemplate[5]->description);
            // $this->config->set_item('emailsend_order', $EmailTemplate[6]->description);
            // $this->config->set_item('emailforgot_password', $EmailTemplate[7]->description);
        // } 
		
		$this->config->set_item('emailorder_confirmation', $this->emailTemplate(1));
		$this->config->set_item('emailorder_dispatch', $this->emailTemplate(2));
		$this->config->set_item('emailorder_delivery', $this->emailTemplate(3));
		$this->config->set_item('emailorder_cancel', $this->emailTemplate(4));
		$this->config->set_item('emailorder_refund', $this->emailTemplate(5));
		$this->config->set_item('emailsignup', $this->emailTemplate(6));
		$this->config->set_item('emailsend_order', $this->emailTemplate(7));
		$this->config->set_item('emailforgot_password', $this->emailTemplate(8));
		$this->config->set_item('email_vew_version', $this->emailTemplate(9));
		
		
        //echo $this->config->item('app_url'); exit;
        $web_setting = array(
            array('id'=>0,'key' => '_copy_right', 'value' => 'Product By: <a href="https://www.mnandiretail.com" target="_blank">Mnandi Retail Solution</a>'),
            array('id'=>0,'key' => '_copy_right_mobile', 'value' => 'Product By: <a href="https://www.mnandiretail.com" target="_blank">Mnandi Retail Solution</a>'),
            array('id'=>1,'key' => '_email', 'value' => $this->config->item('email')),
            array('id'=>2,'key' => '_contect', 'value' =>  $this->config->item('mobile')),
            array('id'=>3,'key' => '_address', 'value' => $this->config->item('address')),
            array('id'=>5,'key' => '_tag_line', 'value' => 'Bringing hope to the community'),
            array('id'=>6,'key' => '_fb_link', 'value' => $this->config->item('fb')),
            array('id'=>7,'key' => '_tw_plus_link', 'value' => $this->config->item('twitter')),
            array('id'=>8,'key' => '_linkedin_link', 'value' => $this->config->item('linkedn')),
            array('id'=>9,'key' => '_instagram_link', 'value' => $this->config->item('insta')),
            array('id'=>10,'key' => '_android_play_store_link', 'value' => $this->config->item('app_url')),
            array('id'=>11,'key' => '_logo_header', 'value' => base_url().'backend/uploads/company/'.$this->config->item('company_logo1')),
            array('id'=>12,'key' => '_logo_footer', 'value' => base_url().'backend/uploads/company/'.$this->config->item('logo')),
            array('id'=>13,'key' => '_favicon', 'value' => base_url().'backend/uploads/company/'.$this->config->item('favicon')),
            array('id'=>14,'key' => '_title', 'value' => $this->config->item('name')),
            array('id'=>15,'key' => '_about', 'value' => $this->config->item('about')),
            array('id'=>16,'key' => '_pwa_link', 'value' => $this->config->item('pwa_app')),
        );
        
		$allowmethod = array('login', 'registration', 'forget_account_password');
		// $currclass = $this->router->fetch_class()
		$currmethod = $this->router->fetch_method();
		if (!parent::isLogin() && !in_array($currmethod, $allowmethod)) {
            redirect(base_url('login'), 'refresh');
        }
		
		
		$q = $this->db->query("SELECT * FROM `product_cat_type` WHERE status = 1 and homepage = 1 ");
		$menu_cat_array = $q->result();
		
		$cat_array = [];
		$q = $this->db->query("SELECT * FROM `product_cat_type` WHERE status = 1 ");
		$cat_type = $q->result();
		if(!empty($cat_type)){  
			foreach($cat_type as $key => $cat_tp){
				$cats = $this->products_model->getCategoriesShort(0,0,$this, $cat_tp->product_cat_type_id);
				if(!empty($cats)){
					$cat_array[$key] = $cat_tp;
					$cat_array[$key]->cat = $cats;
				}
			}
		}
		// echo '<pre>';
		// print_r($cat_array);
		// die;
        
        $this->cart_product_arr = $this->setting_model->getCartData();
        $this->data = array(
            'loader_image'          =>  base_url() . 'assets/images/no-image.png',
            'menu_cat_array'    			=>  $menu_cat_array,
            'cat_array'    			=>  $cat_array,
            'getCategoriesShort'    =>  $this->products_model->getCategoriesShort(0,0,$this),
            'total_cart_item'       =>  $this->setting_model->countCartItem(),
            'get_cart_product_arr'  =>  $this->cart_product_arr,
            'product_img_url'       =>  $this->config->item('product_img_url'),
            'return_img_url'        =>  $this->config->item('return_img_url'),
            'category_img_url'      =>  $this->config->item('category_img_url'),
            'slider_img_url'        =>  $this->config->item('slider_img_url'),
            'web_setting'           =>  $web_setting,
            'getbrand1'             => $this->products_model->get_brand(0,10),
            'getbrand2'             => $this->products_model->get_brand(10,10),
            'getbrand3'             => $this->products_model->get_brand(20,10),
            'getbrand4'             => $this->products_model->get_brand(30,10),
            'getbrand5'             => $this->products_model->get_brand(40,10),
            'getallbrand'           => $this->products_model->get_brand(0,10000),
            'getallmenu'           => $this->products_model->get_menu(),
        );
        
        /* Language Setting-- Start*/
        $language = $this->db
                ->select('language_name')
                ->where('status', 1)
                ->get('language_setting')
                ->row();
        if($language->language_name == "arabic"){
            $this->lang->load('ps', 'arabic');
        }elseif($language->language_name == "english"){
            $this->lang->load('ps', 'english');
        }elseif($language->language_name == "spanish"){
            $this->lang->load('ps', 'spanish');
        }elseif($language->language_name == "hindi"){
            $this->lang->load('ps', 'hindi');
        }elseif($language->language_name == "greek"){
            $this->lang->load('ps', 'greek');
        }
        $this->session->set_userdata(array("language" => $language->language_name));
        if(empty($this->session->userdata('lang'))){
			$this->session->set_userdata('lang', "english");
		}
		
        if(!empty($this->session->userdata('lang'))){
            $this->lang->load('ps', $this->session->userdata('lang'));
             //echo $this->session->userdata('lang'); exit;
        }
        
        /* Language Setting-- END*/
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
        
        /* Popup-- Start*/
        $Popup    = $this->db
                        ->select('*')
                        ->get('tbl_popup')
                        ->result();
        if(!empty(@$Popup))
        {
            $this->config->set_item('popup_pagename', $Popup[0]->page_name);
            $this->config->set_item('popup_title', $Popup[0]->title);
            $this->config->set_item('popup_desc_type', $Popup[0]->desc_type);
            $this->config->set_item('popup_desc', $Popup[0]->desc);
        }
       /* Popup-- End*/
        
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
        
        
        // $this->load->library('google');
		// $this->load->library('facebook');


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
	
	public function emailTemplate($id){
        $EmailTemplate = $this->db
                ->select('*')
                ->where('status',1)
                ->where('type',$id)
                ->get('mail_template')
                ->row();
		if(!empty($EmailTemplate->description)){
			return $EmailTemplate->description; 
		}
		return '';
    }
       
    public function smsTemplate($id){
        $smsTemplate = $this->db
                ->select('*')
                ->where('status',1)
                ->where('type',$id)
                ->get('sms_template')
                ->row();
		if(!empty($smsTemplate->description)){
			return $smsTemplate->description; 
		}
		return '';
    }

    public function maintenance(){
        $this->config->set_item('body_content', 'common/template.maintenance.php');
        parent::output_parse('home/home.maintenance.php', $this->data); 
    }

    public function index() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $this->dashboard();
    }
    
    public function change_language(){
        $language   =   $this->input->get('lang');
        $this->session->set_userdata(array("lang" => $language));
        echo 1;
    }
    
    public function send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr){
            
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
                    //$mail->addAddress("sashen.moodley1@gmail.com", "sash");
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
                    //$mail->addReplyTo($reply_value['reply_mail']); //Reply Mail
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
                    $mail->setFrom("MnandiRetail@gmail.com", $from_value['from_name']); // Mail From
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

    public function dashboard() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        //print_r($this->products_model->get_brand()); exit;
        $data = array(
            'getTopSellingProducts' => $this->products_model->getTopSellingProducts(),
            'getCategoriesShort'    => $this->products_model->getCategoriesShort(0,0,$this),
            'getDealProducts'       => $this->products_model->getDealProducts(),
            'getFeatureBanner'      => $this->setting_model->getFeatureBanner(),
            'getBanner'             => $this->setting_model->getBanner(),
			'getSlider'             => $this->setting_model->getSliders(),
			'getRecentAddProduct'   => $this->products_model->getRecentAddProduct(),
			'getCategoryWiseProduct'=> $this->products_model->getCategoryWiseProduct(),
			
                //'popup' => 'home/page/template.quick_view.php'
        );
        //$this->config->set_item('content','admin/dashboard.content/dashboard.0.html');
        $this->data = array_merge($this->data, $data);
        parent::output_parse('home/home.template.php', $this->data);
    }
    
    public function orderdetails($order_id) {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        
        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
        
        $this->config->set_item('body_content', 'home/page/account.section/order_invoice.php');
        $data = array(
            'order' => $this->products_model->get_sale_order_by_id($order_id),
            'order_item' => $this->products_model->get_sale_order_items($order_id),
        );
        
        $this->data = array_merge($this->data, $data);
        parent::output_parse('home/home.template.php', $this->data);
      
        
    }

    public function shop($cat_slug = '', $product_name = '', $search_posttype = '') {
        //echo "ram";
        $get_brand = $this->products_model->get_brand(0,100);
        $type = '';
        if(!empty($this->input->get())){
            $get_data  =   $this->input->get();

            if($get_data['search']){ 
                $product_name = $get_data['search'];
            }
            else{
                //echo "ramenter";
                if(!empty($get_data['brand'])){ 
                    $filter = 1;
                    $filter_brand           =   $get_data['brand'];
                    //echo $cat_slug;
                }
                if(!empty($get_data['review'])){
                    $filter = 1;
                   $filter_review           =   $get_data['review']; 
                }
                if(!empty($get_data['price'])){
                    $filter = 1;
                   $filter_price           =   $get_data['price']; 
                }
                
                if(!empty($get_data['order_by'])){
                    $filter = 1;
                   $filter_order_by           =   $get_data['order_by']; 
                }
                
                if(!empty($get_data['page'])){
                    $filter = 1;
					$filter_page           =   $get_data['page']; 
                }
                
                if(!empty($get_data['category'])){
                    //echo $get_data['category'];
                    $filter = 1;
                   $filter_category           =   $get_data['category']; 
                }
                if(!empty($get_data['cat_type'])){
                    //echo $get_data['category'];
                    $filter = 1;
                   $filter_cat_type           =   $get_data['cat_type']; 
                }
                
                if(!empty($get_data['use_for'])){
                    $filter = 1;
                   $filter_use_for           =   $get_data['use_for']; 
                }
                
                if(!empty($get_data['color'])){
                    $filter = 1;
                   $filter_color           =   $get_data['color']; 
                }
                
                if(!empty($get_data['material'])){
                    $filter = 1;
                   $filter_material           =   $get_data['material']; 
                }
                
                if(!empty($get_data['size'])){
                    $filter = 1;
                   $filter_size           =   $get_data['size']; 
                }
                //echo $filter;
            }
            
            //$product_name           =   !empty($data['search'])? $data['search'] : $data['s'];
            //$search_posttype        =   $data['search_posttype'];
            
        }

        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        
        //parent::preOutput($this->products_model->getCategoriesShort(0,0, $this));
        $data = array();
         
        if($filter){
            //echo "raj";
            
            if(!empty($filter_brand)){
                $filter_brand_array = explode(" ",$filter_brand);
                if($filter_brand_array){
                    $brand = implode("','",$filter_brand_array);
                }

                $sql = "select id from tbl_brand where slug in('".$brand."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($res);
                $brand_ids_array  = $res;
                $brand_ids  = array_column($res, 'id');
                $brand_ids1 = implode(",",$brand_ids);
                //echo $brand_ids1;
            }
            
            if(!empty($filter_category)){
                //echo $filter_category;
                $filter_category_array = explode(" ",$filter_category);
                //print_r($filter_brand_array);
                if($filter_category_array) {
                    $categories = implode("','",$filter_category_array);
                }
				
				$sql = "select id from categories where slug in('".$categories."')";
                $query = $this->db->query($sql);
                $cats = $query->result_array();
				$catids  = array_column($cats, 'id');
				$catid_str = implode(",",$catids);
                $res = $this->Products_model->getCategoryChild($catid_str);
               
				$res = array_merge($cats,$res);
				
                $category_ids_array  = $res;
                $category_ids  = array_column($res, 'id');
                $category_ids1 = implode(",",$category_ids);
				
            }
            
            if(!empty($filter_cat_type))
            {
                //echo $filter_category;
                $filter_cat_type_array = explode(" ",$filter_cat_type);
                //print_r($filter_brand_array);
                if($filter_cat_type_array) {
                    $cat_type = implode("','",$filter_cat_type_array);
                }

                //echo $categories;

                $sql = "select product_cat_type_id from product_cat_type where slug in('".$cat_type."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($res);
                $cat_type_array  = $res;
                $cat_type_ids  = array_column($res, 'product_cat_type_id');
                $cat_type_ids1 = implode(",",$cat_type_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_color))
            {
                //echo $filter_category;
                $filter_color_array = explode(" ",$filter_color);
                //print_r($filter_brand_array);
                if($filter_color_array)
                {
                    $colors = implode("','",$filter_color_array);
                }

                //echo $colors;

                $sql = "select attribute_value_id from attribute_values where attribute_value_id in('".$colors."')";
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
                $filter_use_for_array = explode(" ",$filter_use_for);
                //print_r($filter_brand_array);
                if($filter_use_for_array)
                {
                    $use_fors = implode("','",$filter_use_for_array);
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
                $filter_size_array = explode(" ",$filter_size);
                //print_r($filter_brand_array);
                if($filter_size_array)
                {
                    $sizes = implode("','",$filter_size_array);
                }

                //echo $categories;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$sizes."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($res);
                $size_ids_array  = $res;
                $size_ids  = array_column($res, 'attribute_value_id');
                $size_ids1 = implode(",",$size_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_material))
            {
                //echo $filter_category;
                $filter_material_array = explode(" ",$filter_material);
                //print_r($filter_brand_array);
                if($filter_material_array)
                {
                    $materials = implode("','",$filter_material_array);
                }

                //echo $categories;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$materials."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($res);
                $material_ids_array  = $res;
                $material_ids  = array_column($res, 'attribute_value_id');
                $material_ids1 = implode(",",$material_ids);
                //echo $category_ids1;
            }

            if(!empty($filter_review)) {
                $filter_review_array = explode(" ",$filter_review);
                //print_r($filter_review_array);
                if($filter_review_array)
                {
                    $review = implode(",",$filter_review_array);
                }

                //echo $review;
            }

            if(!empty($filter_price)) {
                $filter_price_array = explode(" ",$filter_price);
                //print_r($filter_price_array);
                if($filter_price_array) {
                    //echo "k=";
                    //$filter_price_array1 = implode("-",$filter_price_array);
                    //$review = implode(",",$filter_price_array);
                    foreach($filter_price_array as $price_array) {
                       // echo $price_array."<br>";
                        $filter_price_array1[] = explode("-",$price_array);

                    }
					
                    $min = $filter_price_array1[0][0];
                    $max = (end($filter_price_array1))[1];
                    
                }
                

                //echo $review;
            }
            
            
            //$get_brand = $this->products_model->get_brand(0,100);
            $getProducts = $this->products_model->get_products_by_filter(FALSE, FALSE, FALSE, $filter_page, $brand_ids1, $review, $filter_price, @$min, @$max, @$filter_order_by, @$category_ids1, @$cat_type_ids1);
            
            $totalProducts = $this->products_model->get_products_by_filter(FALSE, FALSE, FALSE, FALSE, $brand_ids1, $review, $filter_price, @$min, @$max, @$filter_order_by, @$category_ids1, @$cat_type_ids1);
            //print_r($get_brand);
            //echo "filetr2";
            //die();
           // if (!empty($getProducts)) {
			   
			   // $sql = "select product_cat_type_id from product_cat_type where slug in('".$cat_type."')";
			   // $query = $this->db->query($sql);
				$getCategories = [];
				if(!empty($cat_type_ids1)){
					$query = $this->db->query("select * from categories where status = 1 and product_cat_type_id in('".$cat_type_ids1."')");
					$getCategories = $query->result();
				}
				
				// echo '<pre>';
				// print_r($getCategories);
				// die;
			   
                $data = array(
                    'get_brands' => $get_brand,
                    'getProducts' => $getProducts,
                    'getCategories' =>$getCategories,
                    'filter_category_array' =>$filter_category_array,
                    'brand_array' =>$filter_brand_array,
                    'use_for_array' =>$filter_use_for_array,
                    'size_array' =>$filter_size_array,
                    'color_array' =>$filter_color_array,
                    'material_array' =>$filter_material_array,
                    'review_array' =>$filter_review_array,
                    'filter_price_array' =>$filter_price_array,
                    'filter_order_by' =>$filter_order_by,
                    'current_page' =>$filter_page,
                    'totalProducts' =>count($totalProducts)
                    
                );
                $this->config->set_item('body_content', 'home/page/template.shop.php');
            //} 
//            else {
//                $this->config->set_item('body_content', 'common/template.product_not_found.php');
//            }
        }
        elseif(empty($cat_slug) && empty($product_name)) {
            
			//echo "ram2";
			//$get_brand = $this->products_model->get_brand(0,100);
            //print_r($get_brands);
            $getProducts = $this->products_model->get_products();
            $data = array(
                'getProducts' => $getProducts,
                'get_brands' => $get_brand
            );
            $this->config->set_item('body_content', 'home/page/template.shop.php');
        } 
        else {
            $id     =   array();
            if(!empty($cat_slug)){
                $data = $this->db
                            ->select('id,parent')
                            ->where('slug', $cat_slug)
                            ->where('status', 1)
                            ->limit(1)
                            ->get('categories')
                            ->row();

            $id     =   $data->id;
                $parent =   $data->parent;
                if($parent == 0){
                    $dataArr    =  '';
                    $data = $this->db
                                ->select('id')
                                ->where('parent', $id)
                                ->where('status', 1)
                                ->limit(1)
                                ->get('categories')
                                ->result_array();
                    if(!empty($data)){
                        foreach($data as $row){
                            if($dataArr ==''){
                                $dataArr = $row['id'];
                            }
                            else{
                                $dataArr = $dataArr.','.$row['id'];
                            }
                        }
                        $id = $dataArr;
                    }
                }
            }
            
           
            if (!empty($id) && !empty($product_name)) {
                //var_dump(!empty($product_name));
                $getProducts = $this->products_model->get_products(FALSE, $id, FALSE, FALSE, $product_name);
            } elseif (!empty($id)) {
                $getProducts = $this->products_model->get_products(FALSE, $id, FALSE, FALSE, FALSE);
            } elseif (!empty($product_name)) {
                $getProducts = $this->products_model->get_products(FALSE, FALSE, FALSE, FALSE, $product_name);
            } elseif (empty($id) && !empty($cat_slug)) {
                $getProducts = $this->products_model->get_products(FALSE, FALSE, FALSE, FALSE, FALSE, $cat_slug, $type);
            } else {
                $getProducts = NULL;
                //$this->config->set_item('body_content', 'common/template.404.php');
            }
			
            //if (!empty($getProducts)) {
                $data = array(
                    'get_brands' => $get_brand,
                    'getProducts' => $getProducts
                );
                $this->config->set_item('body_content', 'home/page/template.shop.php');
            //} 
//            else {
//                $this->config->set_item('body_content', 'common/template.product_not_found.php');
//            }
        }
        //if(!empty($getProducts)){
            $this->data = array_merge($this->data, $data);
       // }
        parent::output_parse('home/home.template.php', $this->data);
    }
    
    
    public function shop_products($cat_slug = '', $product_name = '', $search_posttype = '') {
        //echo "ram";
        $get_brand = $this->products_model->get_brand(0,100);
        $type = '';
        if(!empty($this->input->get())){
            $data = $this->input->get();

            if($data['search']){ 
                $product_name = $data['search'];
            }
            else{
                //echo "ramenter";
                if($data['brand']){ 
                    $filter = 1;
                    $filter_brand           =   $data['brand'];
                    //echo $cat_slug;
                }
                if($data['review']){
                    $filter = 1;
                   $filter_review           =   $data['review']; 
                }
                if($data['price']){
                    $filter = 1;
                   $filter_price           =   $data['price']; 
                }
                
                if($data['order_by']){
                    $filter = 1;
                   $filter_order_by           =   $data['order_by']; 
                }
                
                if($data['page']){
                    $filter = 1;
                   $filter_page           =   $data['page']; 
                }
                
                if($data['category']){
                    $filter = 1;
                   $filter_category           =   $data['category']; 
                }
                
                if($data['cat_type']){
                    $filter = 1;
                   $filter_cat_type           =   $data['cat_type']; 
                }
                
                if($data['use_for']){
                    $filter = 1;
                   $filter_use_for           =   $data['use_for']; 
                }
                
                if($data['color']){
                    $filter = 1;
                   $filter_color           =   $data['color']; 
                }
                
                if($data['material']){
                    $filter = 1;
                   $filter_material           =   $data['material']; 
                }
                
                if($data['size']){
                    $filter = 1;
                   $filter_size           =   $data['size']; 
                }
                //echo $filter;
            }
            
            //$product_name           =   !empty($data['search'])? $data['search'] : $data['s'];
            //$search_posttype        =   $data['search_posttype'];
            
        }
//die();
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        
        //parent::preOutput($this->products_model->getCategoriesShort(0,0, $this));
        $data = array();
         
        if($filter)
        {
            //echo "raj";
            
            if(!empty($filter_brand))
            {
                //echo $filter_brand;
                $filter_brand_array = explode(" ",$filter_brand);
                //print_r($filter_brand_array);
                if($filter_brand_array)
                {
                    $brand = implode("','", $filter_brand_array);
                }

                //echo $brand;

                $sql = "select id from tbl_brand where slug in('".$brand."')";
                $query = $this->db->query($sql);

                $data = $query->result_array();
                //print_r($data);
                $brand_ids_array  = $data;
                 $brand_ids  = array_column($data, 'id');
                $brand_ids1 = implode(",",$brand_ids);
                //echo $brand_ids1;
            }
            
            if(!empty($filter_category)){
                //echo $filter_category;
                $filter_category_array = explode(" ",$filter_category);
                //print_r($filter_brand_array);
                if($filter_category_array) {
                    $categories = implode("','",$filter_category_array);
                }
				
				$sql = "select id from categories where slug in('".$categories."')";
                $query = $this->db->query($sql);
                $cats = $query->result_array();
				$catids  = array_column($cats, 'id');
				$catid_str = implode(",",$catids);
                $res = $this->Products_model->getCategoryChild($catid_str);
               
				$res = array_merge($cats,$res);
				
                $category_ids_array  = $res;
                $category_ids  = array_column($res, 'id');
                $category_ids1 = implode(",",$category_ids);
				
            }
            
            if(!empty($filter_cat_type)){
                //echo $filter_category;
                $filter_cat_type_array = explode(" ",$filter_cat_type);
                //print_r($filter_brand_array);
                if($filter_cat_type_array) {
                    $cat_type = implode("','",$filter_cat_type_array);
                }

                //echo $categories;

                $sql = "select product_cat_type_id from product_cat_type where slug in('".$cat_type."')";
                $query = $this->db->query($sql);

                $res = $query->result_array();
                //print_r($res);
                $cat_type_array  = $res;
                $cat_type_ids  = array_column($res, 'product_cat_type_id');
                $cat_type_ids1 = implode(",",$cat_type_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_color))
            {
                //echo $filter_category;
                $filter_color_array = explode(" ",$filter_color);
                //print_r($filter_brand_array);
                if($filter_color_array)
                {
                    $colors = implode("','",$filter_color_array);
                }

                //echo $colors;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$colors."')";
                $query = $this->db->query($sql);

                $data = $query->result_array();
                //print_r($data);
                $color_ids_array  = $data;
                 $color_ids  = array_column($data, 'attribute_value_id');
                $color_ids1 = implode(",",$color_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_use_for))
            {
                //echo $filter_category;
                $filter_use_for_array = explode(" ",$filter_use_for);
                //print_r($filter_brand_array);
                if($filter_use_for_array)
                {
                    $use_fors = implode("','",$filter_use_for_array);
                }

                //echo $categories;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$use_fors."')";
                $query = $this->db->query($sql);

                $data = $query->result_array();
                //print_r($data);
                $use_for_ids_array  = $data;
                 $use_for_ids  = array_column($data, 'attribute_value_id');
                $use_for_ids1 = implode(",",$use_for_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_size))
            {
                //echo $filter_category;
                $filter_size_array = explode(" ",$filter_size);
                //print_r($filter_brand_array);
                if($filter_size_array)
                {
                    $sizes = implode("','",$filter_size_array);
                }

                //echo $categories;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$sizes."')";
                $query = $this->db->query($sql);

                $data = $query->result_array();
                //print_r($data);
                $size_ids_array  = $data;
                 $size_ids  = array_column($data, 'attribute_value_id');
                $size_ids1 = implode(",",$size_ids);
                //echo $category_ids1;
            }
            
            if(!empty($filter_material))
            {
                //echo $filter_category;
                $filter_material_array = explode(" ",$filter_material);
                //print_r($filter_brand_array);
                if($filter_material_array)
                {
                    $materials = implode("','",$filter_material_array);
                }

                //echo $categories;

                $sql = "select attribute_value_id from attribute_values where attribute_value in('".$materials."')";
                $query = $this->db->query($sql);

                $data = $query->result_array();
                //print_r($data);
                $material_ids_array  = $data;
                 $material_ids  = array_column($data, 'attribute_value_id');
                $material_ids1 = implode(",",$material_ids);
                //echo $category_ids1;
            }

            if(!empty($filter_review))
            {
                $filter_review_array = explode(" ",$filter_review);
                //print_r($filter_review_array);
                if($filter_review_array)
                {
                    $review = implode(",",$filter_review_array);
                }

                //echo $review;
            }

            if(!empty($filter_price))
            {
                $filter_price_array = explode(" ",$filter_price);
                //print_r($filter_price_array);
                if($filter_price_array)
                {
                    //echo "k=";
                    //$filter_price_array1 = implode("-",$filter_price_array);
                    //$review = implode(",",$filter_price_array);
                    foreach($filter_price_array as $price_array)
                    {
                       // echo $price_array."<br>";
                        $filter_price_array1[] = explode("-",$price_array);

                    }
                    $min = $filter_price_array1[0][0];
                        $max = (end($filter_price_array1))[1];
                        //print_r($filter_price_array1);
                    //echo $min."-".$max;
                    //print_r($filter_price_array1);
                }
                

                //echo $review;
            }
            
            
            //$get_brand = $this->products_model->get_brand(0,100);
            $getProducts = $this->products_model->get_products_details_by_filter(FALSE, FALSE, FALSE, $filter_page, $brand_ids1, $review, $filter_price, @$min, @$max, @$filter_order_by, @$category_ids1, @$cat_type_ids1);
            
            $totalProducts = $this->products_model->get_products_details_by_filter(FALSE, FALSE, FALSE, FALSE, $brand_ids1, $review, $filter_price, @$min, @$max, @$filter_order_by, @$category_ids1, @$cat_type_ids1);
            //print_r($get_brand);
            //echo "filetr2";
            //die();
           // if (!empty($getProducts)) {
                $data = array(
                    'get_brands' => $get_brand,
                    'getProducts' => $getProducts,
                    'brand_array' =>$filter_brand_array,
                    'review_array' =>$filter_review_array,
                    'filter_price_array' =>$filter_price_array,
                    'filter_order_by' =>$filter_order_by,
                    'current_page' =>$filter_page,
                    'totalProducts' =>count($totalProducts)
                    
                );
                $products = $this->parser->parse('home/page/template.shop_products.php', $data);
            //} 
//            else {
//                $this->config->set_item('body_content', 'common/template.product_not_found.php');
//            }
        }
        elseif(empty($cat_slug) && empty($product_name)) {
            
			//echo "ram2";
			//$get_brand = $this->products_model->get_brand(0,100);
            //print_r($get_brands);
            $getProducts = $this->products_model->get_products();
            $data = array(
                'getProducts' => $getProducts,
                'get_brands' => $get_brand
            );
            $products = $this->parser->parse('home/page/template.shop_products.php', $data);
        } 
        else {
            $id     =   array();
            if(!empty($cat_slug)){
                $data = $this->db
                            ->select('id,parent')
                            ->where('slug', $cat_slug)
                            ->where('status', 1)
                            ->limit(1)
                            ->get('categories')
                            ->row();

            $id     =   $data->id;
                $parent =   $data->parent;
                if($parent == 0){
                    $dataArr    =  '';
                    $data = $this->db
                                ->select('id')
                                ->where('parent', $id)
                                ->where('status', 1)
                                ->limit(1)
                                ->get('categories')
                                ->result_array();
                    if(!empty($data)){
                        foreach($data as $row){
                            if($dataArr ==''){
                                $dataArr = $row['id'];
                            }
                            else{
                                $dataArr = $dataArr.','.$row['id'];
                            }
                        }
                        $id = $dataArr;
                    }
                }
            }
            //echo "gagan";
           
            if (!empty($id) && !empty($product_name)) {
                //echo "1-";
                //var_dump(!empty($product_name));
                $getProducts = $this->products_model->get_products_details_by_filter(FALSE, $id, FALSE, FALSE, $product_name);
            } elseif (!empty($id)) {
                //echo "-11-";
                $getProducts = $this->products_model->get_products_details_by_filter(FALSE, $id, FALSE, FALSE, FALSE);
            } elseif (!empty($product_name)) {
                //echo "-111-";
                $getProducts = $this->products_model->get_products_details_by_filter(FALSE, FALSE, FALSE, FALSE, $product_name);
            } elseif (empty($id) && !empty($cat_slug)) {
                //echo "-1111-";
                $getProducts = $this->products_model->get_products_details_by_filter(FALSE, FALSE, FALSE, FALSE, FALSE, $cat_slug, $type);
            }else {
                //echo "else";
                $getProducts = NULL;
                //$this->config->set_item('body_content', 'common/template.404.php');
            }
			
            //if (!empty($getProducts)) {
                $data = array(
                    'get_brands' => $get_brand,
                    'getProducts' => $getProducts
                );
            
            $products = $this->parser->parse('home/page/template.shop_products.php', $data);
            //$products =$this->load->view('home/page/template.shop_products.php');
                //$products = $this->config->set_item('body_content', 'home/page/template.shop_products.php');
            //} 
//            else {
//                $this->config->set_item('body_content', 'common/template.product_not_found.php');
//            }
        }
        
        return $products;
        //if(!empty($getProducts)){
            //$this->data = array_merge($this->data, $data);
       // }
//        parent::output_parse('home/home.template.php', $this->data);
    }

    public function search_view_page() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
       //echo  $cat_slug = $this->input->get('slug');
        $search_text = $this->input->get('search');
		//print_r($cat_slug);
        $this->shop($cat_slug="", $search_text);
        /*
          $this->config->set_item('body_content', 'common/template.contact_us.php');
          parent::output_parse('home/home.template.php', $this->data);
         * 
         */
    }

    public function search_process() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $searchkey              =   $this->input->post('searchkey');
        
        $getProducts    =   $this->products_model->get_products($in_stock = '', $cat_id = "", $search = $searchkey, $page = "");
        if(!empty($getProducts)){
            foreach ($getProducts as $key => $value){
                $category_id        = $value['category_id'];
                $category_title     = $value['title'];
                $product_id         = $value['product_id'];
                $pro1               = explode(',',$value['product_image']);
                $product_image      = $this->config->item('base_url').'backend/'.$this->config->item('upload_folder').'products/'.$pro1[0];
                $product_name       = $value['product_name'];
                $product_wishlist   = $value['wishlist'];
                $product_slug       = $value['product_slug'];
                $in_stock           = $value['in_stock'];
				
                
            	$q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product_id."' and stock_inv>0");
    			$variants_pro       = $q_variants->result_array();
                
                if(empty($variants_pro))
                {
                    $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product_id."'");
                     $variants_pro       = $q_variants->result_array();
                }
                
    			$eleid              = $variants_pro[0]['product_id']; 
    			$product_mrp        = number_format((float)$variants_pro[0]['mrp'], 2, '.', '');
                $product_price      = number_format((float)$variants_pro[0]['price'], 2, '.', '');//$value['price'];
                $product_unit       = $variants_pro[0]['unit'];
                $product_unit_value = $variants_pro[0]['qty'];
                $varientid          = $variants_pro[0]['varient_id'];
                $flavors            = $variants_pro[0]['flavor'];
                $stock              = $variants_pro[0]['stock_inv'];
    		    $product_type       = $value['product_type'];
    		    if(!empty($variants_pro[0]['pro_var_images'])){
                    $product_image  = base_url().'backend/uploads/products/'.$variants_pro[0]['pro_var_images'];
                }
    		    
    			
    			
    			$q                  = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id='".$variants_pro[0]['varient_id']."'   AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                                        AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
    			$del_price          = $q->row();
    			if(!empty($del_price)){
    				$difference_price   = $variants_pro[0]['mrp'] - $del_price->deal_price;	
    				$product_price      = number_format((float)$del_price->deal_price, 2, '.', '');
    				$single_price       = $del_price->deal_price;
    			} else {
    				$difference_price   = $variants_pro[0]['mrp'] - $variants_pro[0]['price'];
    				$product_price      = number_format((float)$variants_pro[0]['price'], 2, '.', '');
    				$single_price       = $variants_pro[0]['price'];
    			}
    			$option     =   '';
    			foreach ($variants_pro as $key => $valuess) {
                    if ($this->session->userdata("product")) {
                        $product_arr = json_decode($this->session->userdata("product"), TRUE);
                    }  
                    $dataCount = 0;
                    $dataCounthtml = '<button id="btnSrch1" class="product-search__btn-addtocart button-primary" type="button" data-id="'.$product_id.'" data-title="113501"><i class="fa fa-shopping-basket"></i> &nbsp ADD TO CART</button>';
                    if(!empty($product_arr)){
                        foreach ($product_arr as $key => $product_session) {
                            if (in_array($valuess['varient_id'], $product_session)) {
                                $dataCount  +=1;
                                $dataCounthtml   = '<div class="product-added-to-cart__icon-wrap"><a class="product-added-to-cart__icon-cta cart-icon" href="javascript:;"><i class="fa fa-shopping-basket"></i><span class="badge">'.$dataCount.'</span></a></div>';
                            }
                            else{
                               $dataCount   =  0;
                               $dataCounthtml = '<button id="btnSrch1" class="product-search__btn-addtocart button-primary" type="button" data-id="'.$product_id.'" data-title="113501"><i class="fa fa-shopping-basket"></i> &nbsp ADD TO CART</button>';
                            }
                        }
                    } 
                    
                    //if($stock < 1 || empty($in_stock)){
                    //if($in_stock < 1 && $stock < 1){
                    if($stock < 1 || empty($in_stock)){
                        
                        $dataCounthtml     =   '<button class="product-search__btn-addtocart button-primary" type="button"><i class="fa fa-shopping-basket"></i> &nbsp OUT OF STOCK</button>';
                    }
                    
                    
    				$product_price_v = number_format((float)$valuess['price'], 2, '.', '');
    				$product_mrp_v = number_format((float)$valuess['mrp'], 2, '.', '');
    				$q_v = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id='".$valuess['varient_id']."'   AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                                        AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
    				
    				$del_price_v = $q_v->row();
    				if(!empty($del_price_v)){
    					$difference_price_v = $valuess['mrp'] - $del_price_v->deal_price;	
    					$product_price_v = number_format((float)$del_price_v->deal_price, 2, '.', '');
    					$single_price_v  = $del_price_v->deal_price;
    				} else {
    					$difference_price_v = $valuess['mrp'] - $valuess['price'];
    					$product_price_v = number_format((float)$valuess['price'], 2, '.', '');
    					$single_price_v  = $valuess['price'];
    				}
    				$flavor     =   $valuess['flavor'];
    				$stocks     =   $valuess['stock_inv'];
    				$option  .=   '<option value="'.$valuess['qty'].'"
    				                data-cart = "'.$dataCount.'"
                                    data-vid="'.$valuess['purchase_id'].'"
                                    data-price="'.$product_price_v.'"
                                    data-mrp  = "'.$product_mrp_v.'"
                                    data-difference  = "'.$difference_price_v.'"
                                    data-units  = "'.$valuess['unit'].'"
                                    data-idd="'.$valuess['product_id'].'" 
                                    data-varient="'.$valuess['varient_id'].'"
                                    data-flavor = "'.$flavor.'"
                                    data-stock = "'.$stocks.'"
                                    data-single = "'.$single_price_v.'">  '.$valuess['qty'].' '.$valuess['unit'].' - '.$this->config->item('currency').' '.$product_price_v.' </option>';
    				
    				
    				
    			}
    			
    			
    			
    			
    			$html  .= '<li class="search-dropdown-li" id="item1" data-itemid="113501" data-bulkthreshold=" " data-bulkquantity="" data-productid="113003" data-maxquantity="3">
                              <div class="row">
                                <div class="col-md-1">
                                    <a href="'.$this->config->item('base_url').'product/'.$product_slug.'" title="'.$searchkey.'" title="">
                                        <img class="imgSrch img-responsive" src="'.$product_image.'" alt="'.$product_name.'">
                                        <span class="product-listing--label-out-of-stock hide"><span>Out of Stock!</span></span>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                  <h6 class="product-search-brand">
                            		<a href="'.$this->config->item('base_url').'product/'.$product_slug.'" title="'.$searchkey.'">'.$searchkey.'</a>
                                  </h6>
                                  <h6 class="product-search-item">
                                  	<a href="'.$this->config->item('base_url').'product/'.$product_slug.'">  '.$product_name.' : '.$product_unit_value.' '.$product_unit.' </a>
                                  	<span style="font-size:11px" class="product-listing__save--price fls'.$product_id.'">'.$flavors.'</span>
                                  </h6>
                                </div>    
                                <div class="col-md-2 padding-reset-right">
                                	<div class="custom-dropdown">
                                  		<select class="product-search-item--size-select select_option_item">    
                        			           '.$option.'    
                                        </select>
                               		</div>
                              	</div> 
                              	<div class="col-md-4 col-lg-3 ">
                                  <h6 class="product-listing--original-price">MRP <span class="strike-diagonal" id="ids'.$product_id.'">'.$this->config->item('currency').' '.$product_mrp.'</span></h6>
                                  <h4 class="product-search-listing--discounted-price" data-id="'.$product_price.'" id="regids'.$product_id.'">'.$this->config->item('currency').' '.$product_price.'</h4>
                                </div>
                        
                                <div class="col-md-2 col-lg-3 ">
                                  	<div class="search-cart-button">
                                  	    <input type="hidden" name="product_id" id="product_id1_'.$product_id.'" value="'.$product_id.'">
                                        <input type="hidden" name="product_varient_id" id="product_varient_id1_'.$product_id.'" value="'.$varientid.'">
                                        <input type="hidden" name="price" id="price1_'.$product_id.'" value="'.$single_price.'" class="priceee">
                                        <input type="hidden" name="unit" id="unit1_'.$product_id.'" value="'.$product_unit_value.'" class="units">
                                        <input type="hidden" name="unit_value" id="unit_value1_'.$product_id.'" value="'.$product_unit.'" class="unit_value">
                                        <input type="hidden" name="qty" id="qty1_'.$product_id.'" value="1" class="qty">
                              			'.$dataCounthtml.'
                                  	</div>
                                </div>
                            </div>
                        </li>';
            }
            $response['status'] =   1;
            $response['html']   =   $html;
        }
        else{
            $response['status'] =   0;
            $response['html']   =   '';
        }
        header("Content-Type: application/json");
        echo json_encode($response);
        ////echo "$out";
    }

    public function contact_us() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $this->config->set_item('body_content', 'common/template.contact_us.php');
        $data = array(
            'getPageDescri' => $this->setting_model->getPageDescri('contact-us'),
        );
        $this->data = array_merge($this->data, $data);
        parent::output_parse('home/home.template.php', $this->data);
    }

    public function terms_conditions() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $this->config->set_item('body_content', 'common/template.terms_conditions.php');
        $data = array(
            'getPageDescri' => $this->setting_model->getPageDescri('terms-and-conditions'),
        );
        $this->data = array_merge($this->data, $data);
        parent::output_parse('home/home.template.php', $this->data);
    }

    public function policy() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $this->config->set_item('body_content', 'common/template.policy.php');
        $data = array(
            'getPageDescri' => $this->setting_model->getPageDescri('policy'),
        );
        $this->data = array_merge($this->data, $data);
        parent::output_parse('home/home.template.php', $this->data);
    }

    public function _404() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $this->config->set_item('body_content', 'common/template.404.php');
        parent::output_parse('home/home.template.php', $this->data);
    }

    public function about_us() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $this->config->set_item('body_content', 'common/template.about_us.php');
        $data = array(
            'getPageDescri' => $this->setting_model->getPageDescri('about-us'),
        );
        $this->data = array_merge($this->data, $data);
        parent::output_parse('home/home.template.php', $this->data);
    }
    
    public function faq() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $this->config->set_item('body_content', 'common/template.faq.php');
        $data = array(
            'getPageDescri' => $this->setting_model->getPageDescri('faq'),
        );
        $this->data = array_merge($this->data, $data);
        parent::output_parse('home/home.template.php', $this->data);
    }
    
    public function refundpolicy() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $this->config->set_item('body_content', 'common/template.refundPolicy.php');
        $data = array(
            'getPageDescri' => $this->setting_model->getPageDescri('refund-policy'),
        );
        $this->data = array_merge($this->data, $data);
        parent::output_parse('home/home.template.php', $this->data);
    }
    
    
    
    

    public function wishlist() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
       
        $data = array(
                //'getPaddroducts' => $getProductRow,
        );
        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'common/template.wishlist.php');
        parent::output_parse('home/home.template.php', $this->data);
        
       
    }
    
    
    public function notifyme() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        
        //$this->check_user_status();
        // echo "ram";
        // die();
        $user_id  = $this->session->userdata('user_id');
        if(empty($user_id)){
            echo "2";
        }else{
            $product_id = $_GET['product_id'];
            $filter = $_GET['filter'];
                //print_r($_SESSION);
            if($filter=="add")
            {
                $this->db->query("insert into product_notifyme(product_id,user_id,status) values  ('".$product_id."','".$user_id."', '1' )");
                echo "add";
            }
            else
            {
                $this->db->query('delete from product_notifyme where product_id= "'.$product_id.'" and user_id = "'.$user_id.'" ');
                echo "remove";
            }
                    
            
            
        }
    }
    
    
    public function addToWishlist() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        
        $user_id  = $this->session->userdata('user_id');
        if(empty($user_id)){
            echo "2";
        }else{
            $product_id = $_GET['product_id'];
            $wishlist   =  $this->db->query("select * from products where product_id  = '".$product_id."' AND  trash = 0")->row();
            $wish       =  $wishlist->wishlist;
            
            
            $wishlist_user   =  $this->db->query("select * from btl_wishlist where user_id = '".$user_id."' AND   product_id  = '".$product_id."' ")->row();
            
            if(empty($wishlist_user)){
                
                    $this->db->query("insert into btl_wishlist(product_id,user_id,status) values  ('".$product_id."','".$user_id."', '1' )");
                    $this->db->query("update products set wishlist = 1 Where product_id  = '".$product_id."' ");
                    echo "1";
                
            }
            else{
                if($wishlist_user->status == 0){
                    $this->db->query("update btl_wishlist set status = 1 Where product_id  = '".$product_id."' ");
                    $this->db->query("update products set wishlist = 1 Where product_id  = '".$product_id."' ");
                     echo "1";
                }else{
                    $this->db->query("update btl_wishlist set status = 0 Where product_id  = '".$product_id."' ");
                    $this->db->query("update products set wishlist = 0 Where product_id  = '".$product_id."' ");
                    echo "0";
                }
                 
                 
            }
            
        }
    }
    public function remove_wishlist($product_id) {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        
        $user_id  = $this->session->userdata('user_id');
        if(!empty($product_id)){
              $this->db->query("update btl_wishlist set status = 0 Where user_id = '".$user_id."' AND  product_id  = '".$product_id."' ");
              $this->db->query("update products set wishlist = 0 Where product_id  = '".$product_id."' ");  
              redirect('wishlist');
        }
        
    }
    
    

    public function compare() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $this->config->set_item('body_content', 'common/template.compare.php');
        parent::output_parse('home/home.template.php', $this->data);
    }

    public function product($product_slug) {//Single Product  
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        //echo $product_slug; exit;
        if (!empty($product_slug)) {
            $getProduct = $this->products_model->get_products($in_stock = false, $cat_id = "", $search = "", $page = "", $product_slug);
            $category   =   $getProduct[0]['category_id'];
            $data = array(
                'getProduct' => $getProduct,
                'relatedProduct' => $this->products_model->get_products($in_stock = false, $category, $search = "", $page = "", $product_slug ="")
            );
            $this->config->set_item('body_content', 'common/template.single_product.php');
        } else {
            $this->config->set_item('body_content', 'common/template.404.php');
        }

        $this->data = array_merge($this->data, $data);
        parent::output_parse('home/home.template.php', $this->data);
    }

    public function quick_view() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        //var_dump($getProduct);
        //parent::output_parse('home/page/template.quick_view.php');
//        $this->config->set_item('body_content', 'home/page/template.quick_view.php');
//        parent::output_parse('home/home.template.php', $this->data);
    }

    public function delete_cart() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $product_id             =   $this->input->post('product_id');
        $product_varient_id     =   $this->input->post('product_varient_id');
        $this->setting_model->deleteToCart($product_id, $product_varient_id);
        $product_arr = array();
        
        if ($this->session->userdata("product")) {
            $product_arr = json_decode($this->session->userdata("product"), TRUE);
        }
        
       
        if (!empty($product_arr)) {
            foreach ($product_arr as $key => $products) {
                /* Use Multi-Array */
                $user_select_product_qty        = $products['buy_qty'];
                $user_select_product_id         = $products['product_id'];
                $user_select_product_varient_id = $products['product_varient_id'];
                /*
                 * 
                  $user_select_product_qty = $products;
                  $user_select_product_id = $key;
                 * 
                 */
                $product_row = $this->products_model->getProductByVarient($user_select_product_id, $user_select_product_varient_id);
               //print_r($product_row); exit;
                if (!empty($user_select_product_qty) && !empty($product_row)) {
                    $product_row = array_merge($product_row, array('buy_qty' => $user_select_product_qty));
                }
                $getProductRow[] = $product_row;
            }
        }
        $get_cart_product_arr = $getProductRow;
        
        $total_order_price = 0;
        if(!empty($get_cart_product_arr)){
            $total_item        =    count($get_cart_product_arr);
            foreach ($get_cart_product_arr as $key => $product){
                $qty                    = $product['buy_qty'];
                $product_id             = $product['product_id'];
                $product_varient_id     = $product['varient_id'];
                $product_name           = $product['product_name'];
                $product_description    = $product['product_description'];
                $product_image          = $this->config->item('base_url').'backend/'.$this->config->item('upload_folder').'products/'. $product['product_image'];
                $category_id            = $product['category_id'];
                $in_stock               = $product['in_stock'];
                $product_price          = $product['price'];
                $mrp                    = $product['mrp'];
                $unit_value             = $product['unit_value'];
                $unit                   = $product['unit'];
                $increament             = $product['increament'];
                $rewards                = $product['rewards'];
                $tax                    = $product['tax'];
               //$total_product_price = $product_price * $qty;
                //$total_order_price += $total_product_price;
    			
    			$q                      = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."'  AND pro_var_id = '".$product_varient_id."'");
    			$del_price              = $q->row();
    			
    			if(!empty($del_price)){
    				$product_price      = $del_price->deal_price;
    				$total_product_price = $product_price * $qty;
    				$total_order_price  += $total_product_price;
    										
    			} else {
    				$product_price      = $product['price'];
    				$total_product_price = $product_price * $qty;
    				$total_order_price  += $total_product_price;
    			}
    			
                $html  .=    '<li class="item odd" id="list_'.$product_id.'"> 
                                <a href="" title="'.$product_name.'" 
                                   class="product-image">
                                    <img class = "lazy" 
                                         src="'.$product_image.'" 
                                         alt="'.$product_name.'" width="65"></a>
                                <div class="product-details"> 
                                    <a data-id="'.$product_id.'" data-varient="'.$product_varient_id.'" title="Remove This Item" class="remove-cart"><i class="icon-close"></i></a>
                                    <p class="product-name">
                                        <a href="">'.$product_name.'</a> 
                                    </p>
                                    <strong>'.$qty.'</strong> x <span class="price">'.$this->config->item('currency').$product_price.'</span> </div>
                            </li>';
                }
                
        
            $dataArr    =   array(
                                    'html'              =>  $html,
                                    'total_order_price' =>  $total_order_price,
                                    'total_item'        =>  $total_item,
                                    'status'            =>  1
                                 );
        }
        else{
            $dataArr    =   array(
                                    'html'              =>  '',
                                    'total_order_price' =>  0,
                                    'total_item'        =>  0,
                                    'status'            =>  0
                                 );
        }
        
        echo  json_encode($dataArr);
        
    }

    public function add_cart() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
       // print_r($_POST); exit;
        $this->load->library('session');
       
        $_REQUEST   =   $_POST;
        $product_id         = $_REQUEST['product_id'];
        $product_varient_id = $_REQUEST['product_varient_id'];
        $qty                = $_REQUEST['qty'];
        $stock              = $_REQUEST['stock'];
        
        //print_r($product_varient_id); exit;
        
        $array  = array(
                'unit'          =>  $_REQUEST['unit'],
                'price'         =>  $_REQUEST['price'],
                'unit_value'    =>  $_REQUEST['unit_value'],
                'stock'         => $stock
            );
           
        $this->session->set_userdata($array);
       
        $test = $this->setting_model->addToCart($product_id, $product_varient_id, $qty, $stock);
        
        
        $product_arr = array();
        if ($this->session->userdata("product")) {
            $product_arr = json_decode($this->session->userdata("product"), TRUE);
        }
        if (!empty($product_arr)) {
            foreach ($product_arr as $key => $products) {
                /* Use Multi-Array */
                $user_select_product_qty        = $products['buy_qty'];
                $user_select_product_id         = $products['product_id'];
                $user_select_product_varient_id = $products['product_varient_id'];
                /*
                 * 
                  $user_select_product_qty = $products;
                  $user_select_product_id = $key;
                 * 
                 */
                $product_row = $this->products_model->getProductByVarient($user_select_product_id, $user_select_product_varient_id);
               //print_r($product_row); exit;
                if (!empty($user_select_product_qty) && !empty($product_row)) {
                    $product_row = array_merge($product_row, array('buy_qty' => $user_select_product_qty));
                }
                $getProductRow[] = $product_row;
            }
        }
        $get_cart_product_arr = $getProductRow;
        
        $total_order_price = 0;
        $total_item        =    count($get_cart_product_arr);
       // print_r($get_cart_product_arr); exit;
        foreach ($get_cart_product_arr as $key => $product){
            $qty                    = $product['buy_qty'];
            $product_id             = $product['product_id'];
            $product_varient_id     = $product['varient_id'];
            $product_name           = $product['product_name'];
            $product_description    = $product['product_description'];
            $pro1                   = explode(',',$product['product_image']);
            $product_image          = $this->config->item('base_url').'backend/'.$this->config->item('upload_folder').'products/'. $pro1[0];
            $category_id            = $product['category_id'];
            $in_stock               = $product['in_stock'];
            $product_price          = $product['price'];
            $mrp                    = $product['mrp'];
            $unit_value             = $product['qty'];
            $unit                   = $product['unit'];
            $increament             = $product['increament'];
            $rewards                = $product['rewards'];
            $tax                    = $product['tax'];
            $product_slug           = $product['product_slug'];
            $q_variants             = $this->db->query("Select * from product_varient where product_id = '".$product_id."' AND varient_id='".$product_varient_id."'")->row();
            if(!empty($q_variants->pro_var_images)){
                $product_image  = base_url().'backend/uploads/products/'.$q_variants->pro_var_images;
            }
           //$total_product_price = $product_price * $qty;
            //$total_order_price += $total_product_price;
			
			$q                      = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."'  AND pro_var_id = '".$product_varient_id."' and CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
			$del_price              = $q->row();
			
			if(!empty($del_price)){
				$product_price      = $del_price->deal_price;
				$total_product_price = $product_price * $qty;
				$total_order_price  += $total_product_price;
										
			} else {
				$product_price      = $product['price'];
				$total_product_price = $product_price * $qty;
				$total_order_price  += $total_product_price;
			}
			$producturl     =   $this->config->item('base_url')."product/". $product_slug;
            $html  .=    '<li class="item odd" id="list_'.$product_varient_id.'"> 
                                <a href="'.$producturl.'" title="'.$product_name.'" 
                                   class="product-image">
                                    <img class = "lazy" 
                                         src="'.$product_image.'" 
                                         alt="'.$product_name.'" width="65"></a>
                                <div class="product-details"> 
                                    <a data-id="'.$product_id.'" data-varient="'.$product_varient_id.'" title="Remove This Item" class="remove-cart"><i class="icon-close"></i></a>
                                    <p class="product-name">
                                        <a href="'.$producturl.'">'.$product_name.'</a> 
                                    </p>
                                    <span style="display: block;">'.$unit_value.' '.$unit.'</span>
                                    <strong>'.$qty.'</strong> x <span class="price">'.$this->config->item('currency').$product_price.'</span> </div>
                            </li>';
            }
    
        $dataArr    =   array(
                                'html'              =>  $html,
                                'total_order_price' =>  $total_order_price,
                                'total_item'        =>  $total_item
                             );
        
        echo  json_encode($dataArr);
    }
    
      public function add_carts() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        
        $this->load->library('session');
       // print_r($_POST); exit;
        $_REQUEST   =   $_POST;
        $product_id         = $_REQUEST['product_id'];
        $product_varient_id = $_REQUEST['product_varient_id'];
        $qty                = $_REQUEST['qty'];
        $key                = $_REQUEST['key'];
        //print_r($product_varient_id); exit;
        
        $array  = array(
                'unit'          =>  $_REQUEST['unit'],
                'price'         =>  $_REQUEST['price'],
                'unit_value'    =>  $_REQUEST['unit_value']
            );
           
        $this->session->set_userdata($array);
        //print_r($array);
        $this->setting_model->addToCarts($product_id, $product_varient_id, $qty,$key);
        
        
        $product_arr = array();
        if ($this->session->userdata("product")) {
            $product_arr = json_decode($this->session->userdata("product"), TRUE);
        }
        if (!empty($product_arr)) {
            foreach ($product_arr as $key => $products) {
                /* Use Multi-Array */
                $user_select_product_qty        = $products['qty'];
                $user_select_product_id         = $products['product_id'];
                $user_select_product_varient_id = $products['product_varient_id'];
                /*
                 * 
                  $user_select_product_qty = $products;
                  $user_select_product_id = $key;
                 * 
                 */
                $product_row = $this->products_model->getProductByVarient($user_select_product_id, $user_select_product_varient_id);
               //print_r($product_row); exit;
                if (!empty($user_select_product_qty) && !empty($product_row)) {
                    $product_row = array_merge($product_row, array('buy_qty' => $user_select_product_qty));
                }
                $getProductRow[] = $product_row;
            }
        }
        $get_cart_product_arr = $getProductRow;
        
        $total_order_price = 0;
        $total_item        =    count($get_cart_product_arr);
        foreach ($get_cart_product_arr as $key => $product){
            $qty                    = $product['buy_qty'];
            $product_id             = $product['product_id'];
            $product_varient_id     = $product['varient_id'];
            $product_name           = $product['product_name'];
            $product_description    = $product['product_description'];
            $pro1                   = explode(',',$product['product_image']);
            $product_image          = $this->config->item('base_url').'backend/'.$this->config->item('upload_folder').'products/'. $pro1[0];
            $category_id            = $product['category_id'];
            $in_stock               = $product['in_stock'];
            $product_price          = $product['price'];
            $mrp                    = $product['mrp'];
            $unit_value             = $product['qty'];
            $unit                   = $product['unit'];
            $increament             = $product['increament'];
            $rewards                = $product['rewards'];
            $tax                    = $product['tax'];
           //$total_product_price = $product_price * $qty;
            //$total_order_price += $total_product_price;
			
			$q                      = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."'  AND pro_var_id = '".$product_varient_id."'");
			$del_price              = $q->row();
			
			if(!empty($del_price)){
				$product_price      = $del_price->deal_price;
				$total_product_price = $product_price * $qty;
				$total_order_price  += $total_product_price;
										
			} else {
				$product_price      = $product['price'];
				$total_product_price = $product_price * $qty;
				$total_order_price  += $total_product_price;
			}
			
            $html  .=    '<li class="item odd" id="list_'.$product_varient_id.'"> 
                                <a href="" title="'.$product_name.'" 
                                   class="product-image">
                                    <img class = "lazy" 
                                         src="'.$product_image.'" 
                                         alt="'.$product_name.'" width="65"></a>
                                <div class="product-details"> 
                                    <a data-id="'.$product_id.'" data-varient="'.$product_varient_id.'" title="Remove This Item" class="remove-cart"><i class="icon-close"></i></a>
                                    <p class="product-name">
                                        <a href="">'.$product_name.'</a> 
                                    </p>
                                    <span style="display: block;">'.$unit_value.' '.$unit.'</span>
                                    <strong>'.$qty.'</strong> x <span class="price">'.$this->config->item('currency').$product_price.'</span> </div>
                            </li>';
            }
    
        $dataArr    =   array(
                                'html'              =>  $html,
                                'total_order_price' =>  $total_order_price,
                                'total_item'        =>  $total_item
                             );
        
        echo  json_encode($dataArr);
    }

    public function view_cart() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
       // delete_cookie("product");
        $data = array(
                //'getPaddroducts' => $getProductRow,
        );
		// echo '<pre>';
        // print_r($this->data); exit;
        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.view_cart.php');
        parent::output_parse('home/home.template.php', $this->data);
        //$this->setting_model->deletesToCart();
    }

    public function checkout() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        
        $this->check_user_status();
        //var_dump(parent::getLoginUserAddresses());
//        var_dump($this->setting_model->getTotalCartAmount());
//        var_dump(parent::getWalletOnCheckout());
        if (!parent::isLogin()) {
              redirect('account');
        } else {
			//echo "Testtts";
			//die();
            //$getProductRow = $this->cart_product_arr ; 
            $data = array(
                'page_2' => 'home/page/checkout.section/2.php',
                'page_3' => 'home/page/checkout.section/3.php',
                'getLoginUserAddresses' => parent::getLoginUserAddresses(),
                'add_address' => 'home/page/checkout.section/add_address.php',
                'getWalletOnCheckout' => parent::getWalletOnCheckout(),
                    //'getProducts' => $getProductRow,
            );
            $address_data = array(
                'address_user_name' => '',
                'address_mobile_no' => '',
                'address_pincode' => '',
                'address_address' => '',
                '' => '',
            );
            $this->data = array_merge($this->data, $address_data);
            
        }
        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.checkout.php');
        parent::output_parse('home/home.template.php', $this->data);
    }

    public function place_order() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        //print_r($_POST); exit;
        if (!parent::isLogin() || ($this->input->method() !== 'post')) {
            redirect(base_url('checkout'), 'refresh');
        } else {
            
            $isOrderPlaced = $this->config->item('isPlaceOrderRunning');
            
            if ($isOrderPlaced){
                return;
            }

            $this->config->set_item('isPlaceOrderRunning', true);
            $as = $this->config->item('isPlaceOrderRunning');
            $smssend_order      =   $this->config->item('smssend_order');
            $emailsend_order    =   $this->config->item('emailsend_order');

// 			$row = $this->db->query('select stock_inv from product_varient WHERE price ="'.$current_price.'" AND  product_id ="'.$product_id.'" ')->row();
// 			if(!empty($row)){
// 				$quantity = $row->stock_inv;
// 				$total_quantity = $quantity-$current_qty;
// 				$this->db->query('Update product_varient SET stock_inv = "'.$total_quantity.'" WHERE  price ="'.$current_price.'" AND product_id ="'.$product_id.'" '); 
// 			}
			
            $place_order_arr = parent::place_order();
            //var_dump($place_order_arr); die;
            if (!empty($place_order_arr)) {
                $place_order_detalis = $this->session->flashdata('place_order_detalis');
                $user_id = $this->session->userdata('user_id');
                $delivery_charge = $place_order_detalis['delivery_charge'];
                $order_id = $place_order_detalis['order_id'];
                $token = array(
                        'orderid'   => $place_order_detalis['order_id'],
                        'fromtime'  => $place_order_detalis['fromtime'],
                        'totime'    => $place_order_detalis['totime'],
                        'date'      => $place_order_detalis['delivery_date'],
                        'amount'    => ($place_order_detalis['order_price']+$delivery_charge)
                    );
                $pattern = '[%s]';
                foreach($token as $key=>$val){
                    $varMap[sprintf($pattern,$key)] = $val;
                }
                
                $message1["title"] = "Place  Order";
                $message1["message"] = strtr($smssend_order,$varMap);
                $message1["image"] = base_url()."backend/uploads/company/".$this->config->item('logo');
                $message1["created_at"] = date("Y-m-d h:i:s");
                $message1["obj"] = "";
                
                $msg               =  strtr($smssend_order,$varMap);

                $q = $this->db->query("SELECT registers.user_email, registers.user_gcm_code,
                                    registers.user_ios_token, user_location.receiver_name, user_location.receiver_mobile  
                                    FROM registers 
                                    LEFT JOIN sale on sale.user_id=registers.user_id 
                                    AND sale.sale_id='".$order_id."'
                                    LEFT JOIN user_location on user_location.location_id=sale.location_id
                                    where  registers.user_id='".$user_id."'");
                $user = $q->row();
                
                /*Order Mail Send Start*/
                $to_mail_arr = array();
                $to_mail_arr[0] = array('to_mail' => $user->user_email, 'to_name' => $user->receiver_name);
                $cc_mail_arr = array();
                $reply_to_mail_arr = array();
                $reply_to_mail_arr[0] = array('reply_mail'=>$this->config->item('email'),'reply_name'=>'noreply');
                $mail_subject = "Order Confirmation";
                $mail_attachment_arr = array();
                $from_mail_arr = array();
                $from_mail_arr[0] = array('from_mail' => $this->config->item('email'), 'from_name' => $this->config->item('name'));
                $message = "<a href='".base_url()."' title='".$this->config->item('name')."'>
                            <img src='".base_url()."backend/uploads/company/".$this->config->item('logo')."' style='float:right; width:30%;' alt='".$this->config->item('name')."' title='".$this->config->item('name')."'></a>
                            <br><br><br><br>";
                $message .= strtr($emailsend_order,$varMap);
                $result  =  $this->send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr);
				
                /*Order Mail Send End*/
                // $this->load->helper('gcm_helper');
                
                // $gcm = new GCM();
                // if ($user->user_gcm_code != "") {
                //     $result = $gcm->send_notification(array($user->user_gcm_code), $message1, "android");
                // }
                // if ($user->user_ios_token != "") {
                //     $result = $gcm->send_notification(array($user->user_ios_token), $message1, "ios");
                // }
				
				$sms_url = $this->config->item('sms_url');
				$sms_user = $this->config->item('sms_user');
				$sms_pass = $this->config->item('sms_pass');
				if(!empty($sms_url)){
					$this->setting_model->sendsmsPOST($user->receiver_mobile, $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));
				}
				
                $newdata = array(
                    'order_id' => $place_order_detalis['order_id'],
                    'order_price' => $place_order_detalis['order_price'],
                    'customer_name' =>  $user->receiver_name,
                    'customer_email' => $user->user_email,
                    'delivery_charge'=> $place_order_detalis['delivery_charge'],
                );
                $this->session->set_userdata($newdata);
				
                if($this->input->post('payment_type') == 'Cash On Delivery'){
                    $this->config->set_item('isPlaceOrderRunning', false);
                    redirect(base_url('orderinfo'), 'refresh');
                }
                elseif($this->input->post('payment_type') == 'Razorpay'){
                    $this->config->set_item('isPlaceOrderRunning', false);
                    redirect(base_url('orderPayment'), 'refresh');
                }
                elseif($this->input->post('payment_type') == 'Paypal'){
                    $this->config->set_item('isPlaceOrderRunning', false);
                    redirect(base_url('orderpaymentpaypal'), 'refresh');
                }
                elseif($this->input->post('payment_type') == 'Paytm'){
                    $this->config->set_item('isPlaceOrderRunning', false);
                    redirect(base_url('orderpaymentpaytm'), 'refresh');
                }
                else{
                    $this->config->set_item('isPlaceOrderRunning', false);
                    redirect(base_url('orderinfo'), 'refresh');
                }
               
            } else {
                //redirect(base_url('checkout'), 'refresh');
                $this->config->set_item('isPlaceOrderRunning', false);
                $this->checkout();
            }
        }

        $this->config->set_item('isPlaceOrderRunning', false);
    }
    public function orderPayment() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $data_pay = array(
            'order_id'  => $this->session->userdata('order_id'),
            'price'     => $this->session->userdata('order_price'),
            'name'      => $this->session->userdata('customer_name'),
            'email'     => $this->session->userdata('customer_email'),
            
            );
            
        $data = array(
            'data_payment' => $data_pay,
            
        );
       
        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.orderpayment.php');
        parent::output_parse('home/home.template.php', $this->data);
    }
    public function orderpaymentpaypal(){
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
       // echo "hello"; exit;
        $data_pay = array(
            'order_id'  => $this->session->userdata('order_id'),
            'price'     => $this->session->userdata('order_price'),
            'name'      => $this->session->userdata('customer_name'),
            'email'     => $this->session->userdata('customer_email'),
            'delivery_charge'=> $this->session->userdata('delivery_charge'),
            
            );
            
        $data = array(
            'data_payment' => $data_pay,
            
        );
       
        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.orderpaymentpaypal.php');
        parent::output_parse('home/home.template.php', $this->data);
    }
    public function orderpaymentpaytm(){
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0"); 
        require_once(FCPATH . "third_party/paytmlib/config_paytm.php");
        require_once(FCPATH . "third_party/paytmlib/encdec_paytm.php");
        $delivery_charge  =  $this->session->userdata('delivery_charge');
			$data_pay = array(
                'ORDER_ID'      => $this->session->userdata('order_id'),
                'TXN_AMOUNT'    => ($this->session->userdata('order_price') + $delivery_charge),
                'CUST_ID'       => $this->session->userdata('user_id'),
                'EMAIL'         => $this->session->userdata('customer_email'),
            );
			
            $data_pay["MID"] 			    = $this->config->item('paytm_id');
		    $data_pay["CHANNEL_ID"] 	    = "WEB";
		    $data_pay["WEBSITE"] 		    = $this->config->item('paytm_api_key');
		    $data_pay["CALLBACK_URL"] 	    = $this->config->item('base_url')."paytm_response";
		    $data_pay["INDUSTRY_TYPE_ID"]   = $this->config->item('paytm_type');
		    $paytmChecksum                  = getChecksumFromArray($data_pay, $this->config->item('paytm_key'));
		    $data_pay["CHECKSUMHASH"] = $paytmChecksum;
		    
		    $transactionURL = $this->config->item('paytm_url');
    		// p($paytmParams,1);

    		$data = array();
    		$data['paytmParams'] 	= $data_pay;
    		$data['transactionURL'] = $transactionURL;
            
       
        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.orderpaymentpaytm.php');
        parent::output_parse('home/home.template.php', $this->data);
    }
    function paymentReportCustomer(){
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $paymentid      =   $this->uri->segment(3);
        $orderid        =   $this->uri->segment(4);
        $user_id        =   $this->session->userdata('user_id');
        if(!empty($paymentid)){
            //echo "raj";
            $result         =   $this->db->query("UPDATE sale SET status ='0',paymentid ='".$paymentid."', is_paid='1' WHERE sale_id ='".$orderid."' AND user_id = '".$user_id."'");
            if($result){
                //echo "raj1";
                 $result         =   $this->db->query("UPDATE transaction SET transaction_id ='".$paymentid."', status = '1' WHERE order_id ='".$orderid."' AND user_id = '".$user_id."'");
                 $this->setting_model->deletesToCart();
                 redirect(base_url('orderinfo'), 'refresh');
            }
            else{
                //echo "raj2";
                redirect(base_url('orderPayment'), 'refresh');
            }
        }
        else{
            //echo "raj3";
                redirect(base_url('orderPayment'), 'refresh');
            }
    }
    
    function paytm_response(){
        $user_id        =   $this->session->userdata('user_id');
        require_once(FCPATH . "third_party/paytmlib/config_paytm.php");
        require_once(FCPATH . "third_party/paytmlib/encdec_paytm.php");
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $paytmChecksum 	= "";
		$paramList 		= array();
		$isValidChecksum= "FALSE";
		//$_POST          =   array( 'CURRENCY' => 'INR', 'GATEWAYNAME' => 'WALLET' ,'RESPMSG' => 'Txn Success' ,'BANKNAME' =>'WALLET' ,'PAYMENTMODE' => 'PPI','MID' => 'EyXoMn47443409381399' ,'RESPCODE' => '01' ,'TXNID' => '20200731111212800110168010501748865' ,'TXNAMOUNT' => '600.00' ,'ORDERID' => '49' ,'STATUS' => 'TXN_SUCCESS' ,'BANKTXNID' => '62953707' ,'TXNDATE' => '2020-07-31 12:17:00.0' ,'CHECKSUMHASH' => 'lA3HCt9jH6lBCYyEfZ53amWNZ3JuoyHiZ/wQ78Tr0NoZpb4gWISBMZhw+RQMWb33edmIPjAsQntn6VX04jWB8TT0gQNuTUtqw2s7V5rQ+Hc='); 
		$paramList = $_POST;
		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
		//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
		$isValidChecksum = verifychecksum_e($paramList, $this->config->item('paytm_key'), $paytmChecksum); //will return TRUE or FALSE string.

		if($isValidChecksum == "TRUE") {
			if ($_POST["STATUS"] == "TXN_SUCCESS") {
			    $paymentid      =   $_POST['TXNID'];
			    $orderid        =   $_POST['ORDERID'];
			    
                $result         =   $this->db->query("UPDATE sale SET status = '0', paymentid ='".$paymentid."', is_paid='1' WHERE sale_id ='".$orderid."'");
                if($result){
                     $result         =   $this->db->query("UPDATE transaction SET transaction_id ='".$paymentid."', status = '1' WHERE order_id ='".$orderid."'");
                     $this->setting_model->deletesToCart();
                     redirect(base_url('my_order'), 'refresh');
                }
                else{
                    redirect(base_url('orderpaymentpaytm'), 'refresh');
                }
			}
        }
        else{
                redirect(base_url('orderpaymentpaytm'), 'refresh');
            }
    }
    
    public function orderinfo($payment_id=NULL) {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
		
		if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
		
		//$user_id        =   $this->session->userdata('user_id');
		
		
          // $place_order_detalis = array(
          // 'order_id' => 'xxx101',
          // 'order_price' => '5000',
          // 'delivery_date' => '12-12-2019',
          // 'fromtime' => '1:20 AM',
          // 'totime' => '5:30 AM',
          // );
         
        $place_order_detalis = $this->session->flashdata('place_order_detalis');
		
		
		// echo '<pre>';
		// print_r($place_order_detalis);
		// die;
		// var_dump($place_order_detalis['order_price']);
        $data = array(
            'place_order_detalis' => $place_order_detalis,
            'page_1' => 'home/page/plase_order.section/msg.php',
        );
        if (empty($place_order_detalis)) {
            redirect(base_url('my_order'), 'refresh');
        }
        else
        {
            $this->setting_model->deletesToCart();
        }
        
        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.orderinfo.php');
        parent::output_parse('home/home.template.php', $this->data);
    }
    
	public function recharge_wallet() {
		
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
		
		$data = [];
        // print_r($_POST); exit;
        if (!empty($this->session->userdata('user_id'))) {
			$user_id = $this->session->userdata('user_id');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
			$this->form_validation->set_rules('payment_type', 'Payment Method', 'trim|required');
			if ($this->form_validation->run() !== FALSE) {
				$totalAmount = $this->input->post('amount');
				$payment_type = $this->input->post('payment_type');
				$transaction_Arr    =   array(
                                            'user_id'           =>  $user_id,
                                            'transction_code'   =>  $payment_type,
                                            'description'       =>  "Recharge By User",
                                            'cr'                =>   $totalAmount,
                                            'dr'                =>   0, 
                                            'status'            =>   0,
                                            'create_at'         =>   date("Y-m-d H:i:s"),
                                        );
				$this->db->insert('transaction', $transaction_Arr);
				
				if($sale_order_id = $this->db->insert_id()){
					$data["status"] = 1;
					$data["msg"] = 'success.';
					$data["order_id"] = $sale_order_id;
				}
				else{
					$data["status"] = 0;
					$data["msg"] = 'Something went wrong, Please try again.';
				}
				
				
				// if($this->input->post('payment_type') == 'Razorpay'){
                    // redirect(base_url('orderPayment'), 'refresh');
                // }
                // elseif($this->input->post('payment_type') == 'Paypal'){
                    // redirect(base_url('orderpaymentpaypal'), 'refresh');
                // }
                // elseif($this->input->post('payment_type') == 'Paytm'){
                    // redirect(base_url('orderpaymentpaytm'), 'refresh');
                // }
			}
			else{
				$data["status"] = 0;
				$data["msg"] = strip_tags($this->form_validation->error_string());
				
			}
        } 
		else {		
			$data["status"] = 0;
			$data["msg"] = 'Please login first.';
        }
		
		echo json_encode($data);
		die;
		
    }
	
	public function payment_success() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
		$data = [];
        //print_r($_POST); exit;
        if (!empty($this->session->userdata('user_id'))) {
            $user_id = $this->session->userdata('user_id');
			
			$this->form_validation->set_rules('paymentid', 'Transaction ID', 'trim|required');
			$this->form_validation->set_rules('order_id', 'Payment Method', 'trim|required');
			if ($this->form_validation->run() !== FALSE) {
				$paymentid = $this->input->post('paymentid');
				$order_id = $this->input->post('order_id');
				
				$q = $this->db->query("SELECT cr FROM transaction where id='".$order_id."' and status = '0'");
                $trans = $q->row_array();
				
				if(!empty($trans['cr'])){
					$amount = $trans['cr'];
					$this->db->query("UPDATE registers SET wallet=wallet+'".$amount."' where user_id='". $user_id. "' ");
					$result = $this->db->query("UPDATE transaction SET transaction_id ='".$paymentid."', status = '1' WHERE id ='".$order_id."'");
					
					if(!empty($result)){
						$data["status"] = 1;
						$data["msg"] = 'Update your Wallet Successfully.';
					}
					else{
						$data["status"] = 0;
						$data["msg"] = 'Something went wrong, Please try again.';
					}
				}
				else{
					$data["status"] = 0;
					$data["msg"] = 'Invalid order ID.';
				}
				
			}
			else{
				$data["status"] = 0;
				$data["msg"] = strip_tags($this->form_validation->error_string());
				
			}
        } 
		else {		
			$data["status"] = 0;
			$data["msg"] = 'Please login first.';
        }
		
		echo json_encode($data);
		die;
		
    }
	
    public function rechargewalletpaytm($order_id='', $txn_amount=''){
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0"); 
        require_once(FCPATH . "third_party/paytmlib/config_paytm.php");
        require_once(FCPATH . "third_party/paytmlib/encdec_paytm.php");
        
		$data_pay = array(
			'ORDER_ID'      => $order_id,
			'TXN_AMOUNT'    => urldecode($txn_amount),
			'CUST_ID'       => $this->session->userdata('user_id'),
			'EMAIL'         => '',
		);
		
		
		
		$data_pay["MID"] 			    = $this->config->item('paytm_id');
		$data_pay["CHANNEL_ID"] 	    = "WEB";
		$data_pay["WEBSITE"] 		    = $this->config->item('paytm_api_key');
		$data_pay["CALLBACK_URL"] 	    = $this->config->item('base_url')."recharge_paytm_response";
		$data_pay["INDUSTRY_TYPE_ID"]   = $this->config->item('paytm_type');
		$paytmChecksum                  = getChecksumFromArray($data_pay, $this->config->item('paytm_key'));
		$data_pay["CHECKSUMHASH"] = $paytmChecksum;
		
		$transactionURL = $this->config->item('paytm_url');
		// p($paytmParams,1);

		$data = array();
		$data['paytmParams'] 	= $data_pay;
		$data['transactionURL'] = $transactionURL;
            
       
        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.orderpaymentpaytm.php');
        parent::output_parse('home/home.template.php', $this->data);
    }
	
	function recharge_paytm_response(){
        $user_id        =   $this->session->userdata('user_id');
        require_once(FCPATH . "third_party/paytmlib/config_paytm.php");
        require_once(FCPATH . "third_party/paytmlib/encdec_paytm.php");
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $paytmChecksum 	= "";
		$paramList 		= array();
		$isValidChecksum= "FALSE";
		//$_POST          =   array( 'CURRENCY' => 'INR', 'GATEWAYNAME' => 'WALLET' ,'RESPMSG' => 'Txn Success' ,'BANKNAME' =>'WALLET' ,'PAYMENTMODE' => 'PPI','MID' => 'EyXoMn47443409381399' ,'RESPCODE' => '01' ,'TXNID' => '20200731111212800110168010501748865' ,'TXNAMOUNT' => '600.00' ,'ORDERID' => '49' ,'STATUS' => 'TXN_SUCCESS' ,'BANKTXNID' => '62953707' ,'TXNDATE' => '2020-07-31 12:17:00.0' ,'CHECKSUMHASH' => 'lA3HCt9jH6lBCYyEfZ53amWNZ3JuoyHiZ/wQ78Tr0NoZpb4gWISBMZhw+RQMWb33edmIPjAsQntn6VX04jWB8TT0gQNuTUtqw2s7V5rQ+Hc='); 
		$paramList = $_POST;
		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
		//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
		$isValidChecksum = verifychecksum_e($paramList, $this->config->item('paytm_key'), $paytmChecksum); //will return TRUE or FALSE string.

		if($isValidChecksum == "TRUE") {
			if ($_POST["STATUS"] == "TXN_SUCCESS") {
			    $paymentid      =   $_POST['TXNID'];
			    $orderid        =   $_POST['ORDERID'];
				
				$q = $this->db->query("SELECT cr FROM transaction where id='".$orderid."' and status = '0'");
                $trans = $q->row_array();
				
				if(!empty($trans['cr'])){
					$amount = $trans['cr'];
					$this->db->query("UPDATE registers SET wallet=wallet+'".$amount."' where user_id='". $user_id. "' ");
					$result = $this->db->query("UPDATE transaction SET transaction_id ='".$paymentid."', status = '1' WHERE id ='".$orderid."'");
					
					if(!empty($result)){
						$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Update your Wallet Successfully..
                                </div>');
						redirect(base_url('my_wallet'), 'refresh');
						
					}
					else{
						$data["status"] = 0;
						$data["msg"] = 'Something went wrong, Please try again.';
						$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
								  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								  <strong>Error!</strong> Something went wrong, Please try again.
								</div>');
						redirect(base_url('my_wallet'), 'refresh');
						
					}
				}
				else{
					
					
					$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
								  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								  <strong>Error!</strong> Invalid order ID.
								</div>');
					redirect(base_url('my_wallet'), 'refresh');
					
				}
			    
                
			
			}
			else{
				
				$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
								  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								  <strong>Error!</strong> Something went wrong.
								</div>');
				redirect(base_url('my_wallet'), 'refresh');
				
			}
        }
        else{
			
			$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
								  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								  <strong>Error!</strong> Invalid Checksum.
								</div>');
			redirect(base_url('my_wallet'), 'refresh');
			
		}
    }
	

    public function add_address() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
		
        parent::insertLoginAddress();
        redirect(base_url('checkout'), 'refresh');
        
    }

  
    protected function unsetOtpSessionInfo() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $array_items = array('otp_code');
        $this->session->unset_userdata($array_items);
    }

    protected function setOtpSessionInfo($otp_code) {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $session_data = array(
            'otp_code' => $otp_code,
        );
        $this->session->set_userdata($session_data);
    }

    protected function getOtpSessionInfo() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        return $this->session->userdata('otp_code');
    }

    protected function reffrelPointToWalletTransfer($verified_user_id) {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
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
            $data["error"] = strip_tags("Refer Code Invalid");
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
            $data["error"] = strip_tags("Refer Code Invalid");
            //echo json_encode($data);
            return $data;
        } else {
            $existing_user_id = $existing_user_result_row->user_id;
            $cr_wallet_amount = 5;
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

            $cr_wallet_amount = 10;
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

    private function mobile_verified($user_phone, $mobile_verified) {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $user_id = $this->session->userdata('user_id');
        $return = FALSE;
        if ($this->db
                        ->set('user_phone', $user_phone)
                        ->set('mobile_verified', $mobile_verified)
                        ->where('user_id', $user_id)
                        ->update('registers')) {
            $return = array(
                '_success_code' => "200",
                '_success_msg' => "Server Process Update Successfully"
            );
        }
        return $return;
    }
    
    public function mobile_verifiaction() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $mobile = $_GET['mobile'];
        if(!empty($mobile)){
            $user = $this->db->query("select * from registers WHERE user_phone = '".$mobile."' AND status = 1 ")->row();
            $phone = $user->user_phone;
            if(empty($user)){
                        $otp = rand(1000,9999);
                        
                        $msg = $this->config->item('name')." \n Your One Time Passowrd is : " . $otp;
                        
                        $this->setting_model->sendsmsPOST($phone, $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));
                        $otp_select  = $this->db->query("select * from tbl_user_otp WHERE user_phone_number = '".$mobile."' ")->row();
                        if(empty($otp_select)){
                            
                            $this->db->query("insert into tbl_user_otp(user_phone_number,user_otp) values('".$mobile."' , '".$otp."') ");
                        }else{
                           $this->db->query("update  tbl_user_otp set user_otp  = '".$otp."' where user_phone_number =  '".$mobile."' "); 
                        }
                        echo "Done";
                        
            }else{
                    echo "Already Exist";
                }
            
        }else{
            echo "Not Blanked";
        }
        
        
    }

    public function account_mobile_verified() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $user_id = $this->session->userdata('user_id');
        $user_phone = set_value('update_profile_mobile_no');
        $mobile_verified = 0;
        if (!empty(set_value('send_otp')) || !empty(set_value('resend_otp'))) {
            if (empty(set_value('update_profile_mobile_no'))) {
                $this->session->set_flashdata('mobile_no_required', 'Mobile No Must Be Required');
            } elseif ((set_value('update_profile_mobile_no') !== parent::getLoginUserMobileNo())) {
                // Update Mobile No.
                $this->mobile_verified($user_phone, $mobile_verified);
            }
            $code = $this->random_code(4);
            $this->setOtpSessionInfo($code);
            $msg = "Basket2Home \n Moblie Number Verified OTP : " . $code;
            $this->setting_model->sendsmsPOST($user_phone, $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));
        } elseif (!empty(set_value('conform_otp'))) {
            $msg = 'Your Not OTP Verified, Plz, try again';
            if (set_value('update_profile_mobile_no') == parent::getLoginUserMobileNo()) {
                if (set_value('mobile_verified_otp') === $this->getOtpSessionInfo()) {
                    $this->unsetOtpSessionInfo();
                    $user_phone = set_value('update_profile_mobile_no');
                    $mobile_verified = 1;
                    if (!empty($this->mobile_verified($user_phone, $mobile_verified))) {
                        $this->reffrelPointToWalletTransfer($user_id);
                        $msg = 'Your Mobile No. Verified, Thanks ';
                    }
                }
            } else {
                $msg = 'Your Mobile Not Verified, Plz, try again';
            }
            $this->session->set_flashdata('conform_otp_msg', $msg);
            $this->session->keep_flashdata('conform_otp_msg_1', $msg);
            $this->session->set_tempdata('conform_otp_msg_2', $msg, 300);
        }
        //$this->setOtpSessionInfo($this->random_code(4));
        //$this->unsetOtpSessionInfo();
        redirect(base_url('my_account'), 'refresh');
        //$this->account();
    }

    public function account() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        
        $this->check_user_status();
        
        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
        if ($this->verifiy_ProfileUpdate()) {
            $messge = array('message' => 'Wrong Not Match Login, Plz...', 'class' => 'alert alert-danger fade in');
            $this->form_validation->set_message('_processProfileUpdate', $messge['message']);
        }
        if (!empty(set_value('update_profile_passconf')) && $this->changePassword()) {
            $messge = array('message' => 'Wrong Not Match Login, Plz...', 'class' => 'alert alert-danger fade in');
            $this->form_validation->set_message('_processProfileUpdate', $messge['message']);
        }
        $getLoginUserInfo = parent::getLoginUserInfo();
        
        //parent::preOutput($getLoginUserInfo);
        $data = array(
            'update_profile_useremail' => $getLoginUserInfo->user_email,
            'update_profile_profilename' => $getLoginUserInfo->user_fullname,
            'update_profile_mobile_no' => $getLoginUserInfo->user_phone,
            'update_mobile_verified' => $getLoginUserInfo->mobile_verified,
            'mobile_verification_code' => $this->getOtpSessionInfo(),
            'update_profile_password' => '',
            'update_profile_passconf' => '',
            'page_1' => 'home/page/account.section/my_account.php',
        );
        
        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.account.php');
        parent::output_parse('home/home.template.php', $this->data);
    }

     public function changepass(){
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }

        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }

        if (!empty(set_value('update_profile_passconf')) && $this->changePassword()) {
            $messge = array('message' => 'Wrong Not Match Login, Plz...', 'class' => 'alert alert-danger fade in');
            $this->form_validation->set_message('_processProfileUpdate', $messge['message']);
        }

        $getLoginUserInfo = parent::getLoginUserInfo();
        
        $data = array(
            'update_profile_useremail' => $getLoginUserInfo->user_email,
            'update_profile_profilename' => $getLoginUserInfo->user_fullname,
            'update_profile_mobile_no' => $getLoginUserInfo->user_phone,
            'update_mobile_verified' => $getLoginUserInfo->mobile_verified,
            'mobile_verification_code' => $this->getOtpSessionInfo(),
            'update_profile_password' => '',
            'update_profile_passconf' => '',
            'page_1' => 'home/page/account.section/my_account.php',
        );

        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.account.php');
        parent::output_parse('home/home.template.php', $this->data);
    }

    public function my_wallet() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
		
		$loginUser = json_decode(json_encode(parent::getLoginUserInfo()),true);
        $data = array(
            'wallet' => parent::getWallet(),
            'wallet_history' => parent::getUserWalletHistory(),
            'user_order_list' => $this->products_model->getMyOrders(),
            'getLoginUserInfo' => $loginUser,
            'page_1' => 'home/page/account.section/my_wallet.php',
        );
        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.account.php');
        parent::output_parse('home/home.template.php', $this->data);
    }
	
	public function my_rewards() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
		
        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
		
		$reward = $this->products_model->getMyRewards();
		$reward_history = $this->products_model->getUserRewardHistory();
		
        $data = array(
            'reward' => $reward,
            'reward_history' => $reward_history,
            'page_1' => 'home/page/account.section/my_rewards.php',
        );

        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.account.php');
        parent::output_parse('home/home.template.php', $this->data);
    }
    
	public function redeem_reward() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
		if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
		
		$user_id = $this->session->userdata('user_id');
		$reward_min_transfer = $this->config->item('reward_min_point_transfer');
		$reward = $this->products_model->getMyRewards();
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
					$this->db->query("update registers set wallet = wallet + ".$total_amount." Where user_id  = '".$user_id."' ");
					$this->db->query("update tbl_user_rewards set status = 2 Where user_id  = '".$user_id."' ");
					
					
					$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> successfully redeem reward poins.
                                </div>');
				}
				else{
					$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
									  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									  <strong>Error!</strong>Redeem setting does not set.
									</div>');
				}
			}
			else{
				$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
										  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										  <strong>Error!</strong> Reward point is less then to min limit.
										</div>');
			}
				
		}
		else{
			$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
							  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							  <strong>Error!</strong>You do not have any reward points.
							</div>');
		}
          
		redirect(base_url('my_rewards'), 'refresh');
    }
	
    public function my_address() {
        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
        $data = array(
            'address' => parent::getLoginUserAddresses(),
            'page_1' => 'home/page/account.section/my_address.php',
        );
        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.account.php');
        parent::output_parse('home/home.template.php', $this->data);
    }
    
    public function edit_addres($address_id) {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        
        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
		$user_id = $this->session->userdata('user_id');
        $data = array(
            'address' => $address_id,
            'page_1' => 'home/page/account.section/edit_address.php',
        );
        if(!empty($_POST['location_id'])){
            
            $location_id    	= $this->input->post('location_id');
            $name           	= $this->input->post('address_user_name');
            $mobile         	= $this->input->post('address_mobile_no');
            $society        	= $this->input->post('socity_id');
            $pincode        	= $this->input->post('address_pincode');
            $address        	= $this->input->post('address_address');
            $lat    = $this->input->post('address_lat');
            $lang    = $this->input->post('address_lang');
            $default_address    = $this->input->post('default_address');
			if(!empty($default_address)){
				$this->db->query('Update user_location SET default_address="0" WHERE user_id="'.$user_id.'"'); 
			}
			else{
				$default_address = '0';
			}
			
			
           
            $result = $this->db->query('update user_location set 
                receiver_name       = "'.$name.'"   ,
                receiver_mobile     = "'.$mobile.'"  , 
                pincode             = "'.$pincode.'"  , 
                socity_id           = "'.$society.'"  , 
                house_no            = "'.$address.'"  ,
                lat                 = "'.$lat.'"  ,
                lang                = "'.$lang.'"  ,
                default_address     = "'.$default_address.'"  
                where location_id   = "'.$location_id.'"
            ');
            if($result){
                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> successfully edit address.
                                </div>');
            }
            else{
                $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Error!</strong> Please try again...
                                </div>');
            }
            
        }
        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.account.php');
        parent::output_parse('home/home.template.php', $this->data);
    }

    public function deleteaddres(){
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
        $location_id    =   $this->uri->segment(2);
        $this->db->query('update  user_location  set trash = 1  where location_id = "'.$location_id.'"   ');
         redirect('my_address');
    }

    public function my_order() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
        $data = array(
            'user_order_list' => $this->products_model->getMyOrders(),
            'page_1' => 'home/page/account.section/my_order.php',
        );

        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.account.php');
        parent::output_parse('home/home.template.php', $this->data);
    }
    
    public function invoice($order_id){
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
        $data = array(
            'user_order_list'       => $this->products_model->get_sale_order_by_id($order_id),
            'user_orderItem_list'   => $this->products_model->get_sale_order_items($order_id),
            'page_1'                => 'home/page/account.section/invoice.php',
        );

        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.account.php');
        parent::output_parse('home/home.template.php', $this->data);
    }
    
    
    public function history($order_id){
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
        $data = array(
            'user_order_list'       => $this->products_model->get_sale_order_by_id($order_id),
            'user_orderItem_list'   => $this->products_model->get_sale_order_items($order_id),
            //'page_1'                => 'home/page/account.section/invoice.php',
            'page_1'                => 'home/page/account.section/history.php',
        );

        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.account.php');
        parent::output_parse('home/home.template.php', $this->data);
    }
    
    public function cancel_order($order_id) {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
        
        $canceledProducts = $this->db->query('select * from sale_items where sale_id = "'.$order_id.'"')->result();

        foreach($canceledProducts as $canceledItem){
            $stockCount = $canceledItem->qty;
            $varentID = $canceledItem->pro_var_id;
            $this->db->query('update  product_varient set stock_inv = stock_inv + "'.$stockCount.'"  where varient_id = "'.$varentID.'" ');    
        }

        $this->db->query('update  sale  set status = 3  where sale_id = "'.$order_id.'"   ');
        
        redirect('my_order');
       
    }
    public function returnOrder($order_id) {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
         $user_id = $this->session->userdata('user_id');
        if(!empty($_POST)){
           
           $user_id = $this->session->userdata('user_id');
           $reason  = $this->input->post('reason');
           $requestfor  = $this->input->post('requestfor');
           $date= date('Y-m-d');
		   $this->form_validation->set_rules('reason', 'Reason', 'trim|required|xss_clean');
			if ($this->form_validation->run() == FALSE) {
				 if ($this->form_validation->error_string() != "") {
					$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						  <strong>Error!</strong> '.strip_tags($this->form_validation->error_string()) . '
						</div>');
				}
			}
			else{
				if ($_FILES["pic"]["name"]) {
				   //echo $_FILES["pic"]["name"]."-";
	//                $config['upload_path'] = 'backend/uploads/returnOrder/';
				   
				   $path = './backend/uploads/returnOrder/';
					if (!is_dir($path)){
						@mkdir($path, 0777, true);
					}
					
					$config['upload_path'] = $path;
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('pic')) {
						$error = strip_tags($this->upload->display_errors());
					} else {
						//echo "enter-";
						$img_data = $this->upload->data();
						$array_image = $img_data['file_name'];
					}
				   //echo '-insert into refund_request values("","'.$user_id.'","'.$user_id.'", "'.$order_id.'",  "'.$date.'" , "'.$reason.'","'.$array_image.'","0") ';
	//                $this->db->query('insert into refund_request values("","'.$user_id.'","'.$user_id.'", "'.$order_id.'",  "'.$date.'" , "'.$reason.'","'.$array_image.'","0") ');
				   if(empty($error)){
					   $this->db->query('insert into refund_request(user_id, order_id, request_date, reason, pic,status, requestfor) values("'.$user_id.'", "'.$order_id.'",  "'.$date.'" , "'.$reason.'","'.$array_image.'","0",  "'.$requestfor.'") '); 
					   
					   $message = 'Successfully Submit Your Request.';
		//               die();
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
								'Name'      => set_value('reg_profilename'),
								'Username'  => set_value('reg_useremail'),
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

						/*Order Mail Send Start*/
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

						/*Register Mail Send End*/
						
						$this->setting_model->sendsmsPOST(set_value('reg_mobile_no'), $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));

						//Template
						$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
									  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									  <strong>Success!</strong> Successfully Submit Your Request.
									</div>');
									
							// $this->session->set_flashdata('message', $message);
							redirect('home/returnOrder/'.$order_id);
					}
					else{
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">
									  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									  <strong>Error!</strong> '.$error.'
									</div>');
					}
			   
				}
				else{
					
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">
									  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									  <strong>Error!</strong> Please upload picture.
									</div>');
						 
						
					   
						
				}
			}
           
        }
		
        $request = $this->db->query('select * from refund_request where user_id = "'.$user_id.'" AND order_id = "'.$order_id.'"   ')->result();
        
        $data = array(
            'user_order' => $order_id,
            'request' => $request,
            'page_1' => 'home/page/account.section/return_order.php',
        );

        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.account.php');
		
        // $this->data = array_merge($this->data, $data);
        // $this->config->set_item('body_content', 'common/template.returnRequest.php');
        parent::output_parse('home/home.template.php', $this->data);
       
    }
    
    
    
    

    public function my_order_tracking($order_id) {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        if (!parent::isLogin()) {
            redirect(base_url('login'), 'refresh');
        }
        $data = array(
            'user_order_info' => $this->products_model->getMyOrder($order_id),
            'page_1' => 'home/page/account.section/my_order_tracking.php',
        );
        $data["order"] = $this->products_model->get_sale_order_by_id($order_id);
        $data["order_items"] = $this->products_model->get_sale_order_items($order_id);
        //print_r($data); exit;
        $this->data = array_merge($this->data, $data);
        $this->config->set_item('body_content', 'home/page/template.account.php');
        parent::output_parse('home/home.template.php', $this->data);
    }

    public function coming_soon() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $this->config->set_item('body_content', 'common/template.coming_soon.php');
        parent::output_parse('home/home.template.php', $this->data);
    }

    public function forget_account_password() { // Not Processed Plz... Create
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        //parent::forget_Account_Password();
        $data = array(
            'title' => "Forgot Account Password",
           
        );
        if(!empty($_POST)){
            
                 $user_phone = $this->input->post('mobile_no');
                 $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|required|min_length[10]|xss_clean');
                 if ($this->form_validation->run() == FALSE) {
                     if ($this->form_validation->error_string() != "") {
                        $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Error!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                    }
                 }
                else{
                    
                
                     $use = $this->db->query("select * from registers WHERE user_phone = '".$user_phone."' AND status = 1 ")->row();
                     $usphone = $use->user_phone;
                     if($usphone == $user_phone ){
                        $pass = $use->user_password;
                       //$msg = $this->config->item('name')." \n Your Password is : " . $pass;

                        //TEmplate 
                        $emailforgot_password     =   $this->config->item('emailforgot_password');
                        $smsforgot_password       =   $this->config->item('smsforgot_password');
                        $token = array(
                                'Name'      => $use->user_fullname,
                                'Password'  => $pass,
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
                         
                        //echo $message; print_r($message1); exit;

                        $result  =  $this->send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr);

                        /*Register Mail Send End*/

                        $this->setting_model->sendsmsPOST($user_phone, $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));

                        //Template


                        $message = '<div class="alert alert-success alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Successfully Send Password to your Mobile Number & Email address
                                    </div>';
                         //$messge = array('message' => 'Welcome To Eduncle Development Compamy', 'class' => 'alert alert-danger fade in');
                        $this->session->set_flashdata('message', $message);
                        redirect('forget_account_password');
                     }else{
                          $message = '<div class="alert alert-danger alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Error!</strong> Mobile Number Not Matched .. ..
                                    </div>';
                          //$messge = array('message' => 'Welcome To Eduncle Development Compamy', 'class' => 'alert alert-danger fade in');
                          $this->session->set_flashdata('message', $message);
                          redirect('forget_account_password');
                     }
                }
            }
        
        $this->data = array_merge($this->data, $data);
        // $this->config->set_item('body_content', 'common/template.forgot_password.php');
        parent::output_parse('common/template.forgot_password.php', $this->data);
    }

    public function registration() {
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $data       = array();
        if (parent::isLogin()) {
            parent::redirect_dashboard();
        }
        if ($this->verifiy_Registration()) {
            
            $emailsignup     =   $this->config->item('emailsignup');
            $smssignup       =   $this->config->item('smssignup');
				$token = array(
                    'Name'      => set_value('reg_profilename'),
                    'Username'  => set_value('reg_useremail'),
                    'Password'  => set_value("reg_passconf"),
                    'Website'   => $this->config->item('name')
                );
                $pattern = '[%s]';
                foreach($token as $key=>$val){
                    $varMap[sprintf($pattern,$key)] = $val;
                }
                $msg               =  strtr($smssignup,$varMap);
                $message1["title"] = "Welcome To ".$this->config->item('name');
                $message1["message"] = strtr($smssignup,$varMap);
                $message1["image"] = base_url()."uploads/company/".$this->config->item('logo');
                $message1["created_at"] = date("Y-m-d h:i:s");
                $message1["obj"] = "";

            //     /*Order Mail Send Start*/
            //     $to_mail_arr = array();
            //     $to_mail_arr[0] = array('to_mail' => set_value('reg_useremail'), 'to_name' => set_value('reg_profilename'));
            //     $cc_mail_arr = array();
            //     $reply_to_mail_arr = array();
            //     $reply_to_mail_arr[0] = array('reply_mail'=>$this->config->item('email'),'reply_name'=>'noreply');
            //     $mail_subject = "Order Confirmation";
            //     $mail_attachment_arr = array();
            //     $from_mail_arr = array();
            //     $from_mail_arr[0] = array('from_mail' => $this->config->item('email'), 'from_name' => $this->config->item('name'));
            //     $message = "<a href='".base_url()."' title='".$this->config->item('name')."'><img src='".base_url()."uploads/company/".$this->config->item('logo')."' style='float:right; width:30%;' alt='".$this->config->item('name')."' title='".$this->config->item('name')."'></a><br><br><br><br>";
               
            //     $message .= strtr($emailsignup,$varMap);
               // echo $message; print_r($message1); exit;
                
            //    $result  =  $this->send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr);

                /*Order Mail Send End*/
                // $this->load->helper('gcm_helper');
                // $gcm = new GCM();
                // if ($user->user_gcm_code != "") {
                //     $result = $gcm->send_notification(array($user->user_gcm_code), $message1, "android");
                // }
                // if ($user->user_ios_token != "") {
                //     $result = $gcm->send_notification(array($user->user_ios_token), $message1, "ios");
                // }
                $this->setting_model->sendsmsPOST(set_value('reg_mobile_no'), $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));
            //print_r($msg);
             $this->session->set_flashdata('login_load_msg', $msg);
             //print_r($this->session->flashdata('login_load_msg')); exit;
            redirect('registration');
            
        }
        else{
            $data = array(
                'reg_profilename' => set_value('reg_profilename'),
                'reg_mobile_no' => set_value('reg_mobile_no'),
                'reg_password' => '',
                'reg_passconf' => '',
                'reg_useremail' => set_value('reg_useremail'),
                'send_otp' => set_value('send_otp'),
                'reg_referral_code' => set_value('reg_referral_code'), //parent::random_code(6),
                'reg_private_policy' => '',
                'mobile_no' => (set_value('mobile_no') ? set_value('mobile_no') : ($this->input->cookie("nspl_mobile_no") ? $this->input->cookie("nspl_mobile_no") : '')),
                'password' => ($this->input->cookie("nspl_password") ? $this->input->cookie("nspl_password") : ''),
                'log_title' => "Sign in with ".$this->config->item('name'),
                'reg_title' => "Welcome To registration",
                'unique_id' => empty(set_value('username')) || empty(set_value('useremail')) ? '' : sprintf('%s%s%03d', substr(set_value('username'), 0, 2), substr(set_value('password'), -4), mt_rand(0, 0777)
                ) . parent::random_code(6),
                'error_'    =>  'register'
            );
        }
        
        $this->data = array_merge($this->data,$data);
        // $this->config->set_item('body_content', 'common/template.account.php');
        parent::output_parse('common/template.register.php', $this->data);
    }

    public function login() { 
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
       //echo "Asd"; die;
        // Ok
        if (parent::isLogin()) {
            parent::redirect_dashboard();
        }
        $data = array(
            'reg_profilename' => set_value('reg_profilename'),
            'reg_mobile_no' => set_value('reg_mobile_no'),
            'reg_password' => '',
            'reg_passconf' => '',
            'reg_useremail' => set_value('reg_useremail'),
            'reg_referral_code' => set_value('reg_referral_code'), //parent::random_code(6),
            'reg_private_policy' => '',
            'mobile_no' => (set_value('mobile_no') ? set_value('mobile_no') : ($this->input->cookie("nspl_mobile_no") ? $this->input->cookie("nspl_mobile_no") : '')),
            'password' => ($this->input->cookie("nspl_password") ? $this->input->cookie("nspl_password") : ''),
            'log_title' => "Sign in with your Account",
            'reg_title' => "Welcome To registration",
            'unique_id' => empty(set_value('username')) || empty(set_value('useremail')) ? '' : sprintf('%s%s%03d', substr(set_value('username'), 0, 2), substr(set_value('password'), -4), mt_rand(0, 0777)
            ) . parent::random_code(6),
        );
        if ($this->verifiy_Login()) {
            parent::redirect_dashboard();
        }
        $this->data = array_merge($this->data, $data);
        // $this->config->set_item('body_content', 'common/template.account.php');
        parent::output_parse('common/template.login.php', $this->data);
    }
	
	public function facebook_login(){
		if($this->config->item('maintenance') == 0)
		{
		            redirect('maintenance'); 
		}
		
		
		// Check if user is logged in
		if ($this->facebook->is_authenticated())
		{
			// User logged in, get user details
			$userInfo = $this->facebook->request('get', '/me?fields=id,name,first_name,last_name,email,link,gender,picture'); 
			if(!empty($userInfo)){
				$email_already = $this->oauth_model->getMdbAccountByEmail($userInfo['email']);
				if(!empty($email_already->user_id)){
					if(empty($email_already->facebook_oauth)){
						$userUpdate['facebook_oauth']    = !empty($userInfo['id'])?$userInfo['id']:''; 
						$this->oauth_model->updateProfileByUserId($email_already->user_id,$userUpdate);
					}
					$userID = $email_already->user_id;
				}
				else{
					$user_oauth = $this->oauth_model->getMdbAccountByFB($userInfo['id']);
					if(!empty($user_oauth->user_id)){
						$userID = $user_oauth->user_id;
					}
					else{
						// Preparing data for database insertion 
						$userData['salf_rafale_code']    = parent::random_code(6); 
						$userData['facebook_oauth']    = !empty($userInfo['id'])?$userInfo['id']:''; 
						$userData['user_fullname']    = !empty($userInfo['name'])?$userInfo['name']:''; 
						$userData['user_email']        = !empty($userInfo['email'])?$userInfo['email']:''; 
						// $userData['first_name']    = !empty($userInfo['first_name'])?$userInfo['first_name']:''; 
						// $userData['last_name']    = !empty($userInfo['last_name'])?$userInfo['last_name']:''; 
						// $userData['gender']        = !empty($userInfo['gender'])?$userInfo['gender']:''; 
						// $userData['picture']    = !empty($userInfo['picture']['data']['url'])?$userInfo['picture']['data']['url']:''; 
						// $userData['link']        = !empty($userInfo['link'])?$userInfo['link']:'https://www.facebook.com/'; 
						 
						// Insert or update user data to the database 
						$userID = $this->oauth_model->setMemberAccount($userData); 
					}
				}
				// Check user data insert or update status 
				if(!empty($userID)){ 
					$user_info = $this->oauth_model->getMdbAccountById($userID);
					$this->setAccountSessionInfo($user_info);
					
					$messge = array('message' => 'Welcome To Ecommerce', 'class' => 'alert alert-success fade in');
					$this->session->set_flashdata('login_load_msg', $messge);
					$messages    = "Hello ".$user_info->user_fullname.". Welcome to ".$this->config->item('name');
					$this->session->set_flashdata('mess', $messages);
					$this->session->keep_flashdata('item', $messge);
					
					parent::redirect_dashboard();
				}
				else{
					$messge = array('message' => 'Something Went Wrong.', 'class' => 'alert alert-danger fade in');
					$this->session->set_flashdata('error_msg', $messge);
					$this->session->keep_flashdata('error_msg', $messge);
					parent::redirect_login();
				}
             
            }
			

		}
		
		$messge = array('message' => 'Facebook Auth failed.', 'class' => 'alert alert-danger fade in');
		$this->session->set_flashdata('error_msg', $messge);
		$this->session->keep_flashdata('error_msg', $messge);
		parent::redirect_login();

		
	}
    
	public function google_login(){
		if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
		
		 if(isset($_GET['code'])){ 
             
            // Authenticate user with google 
            if($this->google->getAuth()){ 
             
                // Get user info from google 
                $userInfo = $this->google->getUserInfo(); 
				
				if(!empty($userInfo)){
					$email_already = $this->oauth_model->getMdbAccountByEmail($userInfo['email']);
					if(!empty($email_already->user_id)){
						if(empty($email_already->google_oauth)){
							$userUpdate['google_oauth'] = !empty($userInfo['id'])?$userInfo['id']:''; 
							$this->oauth_model->updateProfileByUserId($email_already->user_id,$userUpdate);
						}
						$userID = $email_already->user_id;
					}
					else{
						$user_oauth = $this->oauth_model->getMdbAccountByGoogle($userInfo['id']);
						if(!empty($user_oauth->user_id)){
							$userID = $user_oauth->user_id;
						}
						else{
							// Preparing data for database insertion 
							$userData['salf_rafale_code']    = parent::random_code(6); 
							$userData['google_oauth']    = !empty($userInfo['id'])?$userInfo['id']:''; 
							$userData['user_fullname']    = !empty($userInfo['name'])?$userInfo['name']:''; 
							$userData['user_email']        = !empty($userInfo['email'])?$userInfo['email']:''; 
							// $userData['first_name']    = !empty($userInfo['given_name'])?$userInfo['given_name']:''; 
							// $userData['last_name']    = !empty($userInfo['family_name'])?$userInfo['family_name']:''; 
							// $userData['gender']        = !empty($userInfo['gender'])?$userInfo['gender']:''; 
							// $userData['picture']    = !empty($userInfo['picture'])?$userInfo['picture']:''; 
							// $userData['link']        = !empty($userInfo['link'])?$userInfo['link']:''; 
							 
							// Insert or update user data to the database 
							$userID = $this->oauth_model->setMemberAccount($userData); 
						}
					}
					// Check user data insert or update status 
					if(!empty($userID)){ 
						$user_info = $this->oauth_model->getMdbAccountById($userID);
						$this->setAccountSessionInfo($user_info);
						
						$messge = array('message' => 'Welcome To Ecommerce', 'class' => 'alert alert-success fade in');
						$this->session->set_flashdata('login_load_msg', $messge);
						$messages    = "Hello ".$user_info->user_fullname.". Welcome to ".$this->config->item('name');
						$this->session->set_flashdata('mess', $messages);
						$this->session->keep_flashdata('item', $messge);
						
						parent::redirect_dashboard();
					}
					else{
						$messge = array('message' => 'Something Went Wrong.', 'class' => 'alert alert-danger fade in');
						$this->session->set_flashdata('error_msg', $messge);
						$this->session->keep_flashdata('error_msg', $messge);
						parent::redirect_login();
					}
				 
				}
				
				
            } 
        } 
		
		
		$messge = array('message' => 'Google Auth failed.', 'class' => 'alert alert-danger fade in');
		$this->session->set_flashdata('error_msg', $messge);
		$this->session->keep_flashdata('error_msg', $messge);
		parent::redirect_login();

		
	}
    
    public function check_user_status() { 
        $getLoginUserInfo = parent::getLoginUserInfo();
       // print_r($getLoginUserInfo);
        if($getLoginUserInfo->status==0)
        {
            redirect('logout');
        }
    }

    public function logout() { //OK
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        if ($this->process_Logout()) {
            //$this->login();
            //parent::redirect_login();
            //echo $this->session->flashdata('mess'); exit;
            redirect('login');
        }
    }

    public function getordertime(){
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
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
				 $end   = new DateTime($time_slot->closing_time);

				 $interval = DateInterval::createFromDateString($time_slot->time_slot . ' min');

				 $times = new DatePeriod($begin, $interval, $end);
				 $current_Time   =   date('h:i a', time() + 3600);
				 //print_r($cloasing_hours); exit;
				 $time_array = array();
				 foreach ($times as $time) {
					 if (!empty($cloasing_hours)) {
						 foreach ($cloasing_hours as $c_hr) {
							 if ($date == date("Y-m-d")) {
								 if (strtotime($time->format('h:i A')) > strtotime(date("h:i A")) && strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) < strtotime($c_hr->to_time)) {

								 } else {
									 //echo ($time->format('h:i A')).' bolo>>>> '.($current_Time).'<br/>'; exit;
									 if(strtotime($time->format('h:i A')) >  strtotime($current_Time)){ 
										 $time_array[] = $time->format('h:i A') . ' - ' .$time->add($interval)->format('h:i A');
									 }

								 }
							 } else {
								 if (strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) < strtotime($c_hr->to_time)) {

								 } elseif(strtotime($time->format('h:i A')) >  strtotime($current_Time)){ 
								      ///echo ($time->format('h:i A')).'hello>>>> '.($current_Time).'<br/>'; exit;
									 $time_array[] = $time->format('h:i A') . ' - ' .$time->add($interval)->format('h:i A');
								 }
							 }
						 }
					 } else {
						 if (strtotime($date) == strtotime(date("Y-m-d"))) {
							 if (strtotime($time->format('h:i A')) > strtotime($current_Time)) {
							     //echo '>>>>>>'.$time->format('h:i A') . ' - ' . $time->add($interval)->format('h:i A').'<br/>'; exit;
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
            
            
            if(count($time_array) > 0){
                $data["status"] = 1;
                $data["times"] = $time_array;
            }
            else{
                $data["status"] = 0;
            }
        }
        echo json_encode($data);
    }
    
    public function enquiry(){
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('phone', 'Mobile Number', 'trim|required|xss_clean|min_length[10]');
        if ($this->form_validation->run() == FALSE) {
            $message = 'Error ..';
            $this->session->set_flashdata('mess', $message);
            redirect('contact_us');
        }
        $name       = $this->input->post('name');
        $email          = $this->input->post('email');
        $phone       = $this->input->post('phone');
        $message    = $this->input->post('message');
        $date       = date('Y-m-d h:i:s');
        $this->db->query("insert into tbl_enquiry values('','".$name."', '".$email."','".$phone."','".$message."','".$date."')");
        
         $message = 'Successfully Send Your Request ..';
         $this->session->set_flashdata('mess', $message);
         redirect('contact_us');
    }
    
    public function add_review(){
        //echo "raam";
        //echo $rating    = $this->input->post('ratting');
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $this->form_validation->set_rules('ratting', 'Rating', 'trim|required');
        $this->form_validation->set_rules('review_submit_type', '', 'trim|required');
//        $this->form_validation->set_rules('title', 'Review Title', 'trim|required');
        $this->form_validation->set_rules('desc', 'Review Description', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $message = $this->form_validation->error_array();
            $data   =   array('msg'=>$message, 'response' => 0);
            //$this->session->set_flashdata('mess', $message);
            
        }
        else{
            $product_id       = $this->input->post('product_id');
            $name          = $this->input->post('user_name');
            $user_id       = $this->input->post('user_id');
            $review_submit_type       = $this->input->post('review_submit_type');
            $rating    = $this->input->post('ratting');            
            $desc    = $this->input->post('desc');
            $date       = date('Y-m-d h:i:s');
            
            if($review_submit_type=="insert")
            {
                $this->db->query("insert into rating_table (`username`, `user_id`, `product_id`, `description`, `rating`, `created_date`) values('".$name."', '".$user_id."','".$product_id."','".$desc."','".$rating."','".$date."')");
                $message = 'Successfully Inserted Your Review ..';
            }
            else
            {
                $sql = "update rating_table set `description`='".$desc."', `rating`='".$rating."', `updated_date`='".$date."' where user_id='".$user_id."' and product_id='".$product_id."'";
                $this->db->query($sql);
                $message = 'Successfully Updated Your Review ..';
            }
            

             
            $data   =   array('msg'=>$message, 'response' => 1);
             //$this->session->set_flashdata('mess', $message);
             //redirect('contact_us');
        }
        echo json_encode($data);
        
    }
    
    
    function voucherList(){
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $userid     =   $this->session->userdata('user_id');
        $coupons_array         =   $this->setting_model->getCouponList($userid); 
        
        $get_cart_product_arr = $this->setting_model->getCartData();
//        print_r($get_cart_product_arr); die();
        
        $data = array('Couponslist' => $html, 'response'=>0);
        if(!empty($coupons_array)){
            
            $is_coupon_apply = true;
            
            foreach ($coupons_array as $coupon ){  
                if(strpos($coupon['type_value'], ',')!== false){
                    $coupanArr  =   explode(',', $coupon['type_value']);
                }
                else{
                    $coupanArr  =   array($coupon['type_value']);
                }
                if($coupon['apply_type']=="category")
                {
                    foreach ($get_cart_product_arr as $key => $product)
                    {   
                        if (in_array($product['category_id'], $coupanArr)==false)
                        {
                            $is_coupon_apply = false;
                        }
                    }
                    
                }else if($coupon['apply_type']=="single_product"){
                    foreach ($get_cart_product_arr as $key => $product)
                    {   
                        if (in_array($product['product_id'], $coupanArr)==false)
                        {
                            $is_coupon_apply = false;
                        }
                    }    
                    
                }else if($coupon['apply_type']=="brand"){
                     
                    foreach ($get_cart_product_arr as $key => $product)
                    {   
                        if (in_array($product['brand_id'], $coupanArr)==false)
                        {
                            $is_coupon_apply = false;
                        }
                    }
                }
                if($is_coupon_apply==true)
                { //echo $coupon['coupon_id'];
                    //if($coupon['used_coupon'] == 1){continue;}
                    if($coupon['discount_type'] == 'Flat'){
                        $offer      =   $coupon['discount_value'].'% discount';
                    }else{
                        $offer                      =   $this->config->item('currency').number_format($coupon['discount_value'],2).' cashback';
                        $minimum_cart_amt           =   $this->config->item('currency').number_format($coupon['minimum_cart_amt'],2);
                        $max_limit                  =   $this->config->item('currency').number_format($coupon['max_limit'],2);

                        $Showooffer                  =   number_format($coupon['discount_value'],2);
                        $Showominimum_cart_amt       =   number_format($coupon['minimum_cart_amt'],2);
                        $Showomax_limit              =   number_format($coupon['max_limit'],2);                    
                    }
                    $message        =   'Use code '.$coupon['coupon_code'].' & get '.$offer.' in your orders above '.$minimum_cart_amt.' and Maximum Discount is '.$max_limit;
                    if(!empty($coupon['coupon_description'])){
                        $message    =   base64_decode($coupon['coupon_description']);
                    }
                
                
                    
                
               // echo $message; exit;
                
                    $html  .='<div class="panel panel-voucher panel-default" id="panel_'.$coupon['coupon_uni_id'].'">
                            <div class="panel-body padding-left-10">
                                <div class="row">
                                    <div class="col-md-3" style="width: 23% !important;">
                                        <span id="active_radio_panel_'.$coupon['coupon_uni_id'].'" class="bb-icon bb-icon-radio-inactive voucher"></span>
                                        <button onClick="applyCoupan('.$coupon['coupon_uni_id'].')" type="button" style="border: 1px dashed black !important;background:transparent!important;width:144px;" class="btn-outline-default padding-top-10 padding-bottom-10 coupancode">
                                            <span class="ng-binding" id="coupan_code_'.$coupon['coupon_uni_id'].'">'.$coupon['coupon_code'].'</span>
                                        </button>
                                    </div>
                                    <div class="col-md-9 no-padding-left">
                                        <code class="coupan_error" id="coupan_error_'.$coupon['coupon_uni_id'].'" style="display:none"></code>
                                        <p class="bb-text-large no-margin">
                                            <span class="bb-text-black ng-binding">'.$message.'</span>
                                        </p>
                                        <div class="row">
                                        <div class="col-md-10 padding-right-5">
                                            <span class="text-muted ng-binding"></span>
                                            <span class="text-muted bb-text-small">
                                                <span class="ng-binding"></span>
                                                <!--voucher.condition -->
                                                Expires on
                                                <span  class="ng-binding">'.date('d F y', strtotime($coupon['valid_to'])).'</span>
                                            </span>
                                        </div>
                                            <div class="col-md-2 no-padding">
                                                <a ng-click="toggleVoucherTermsAndConditions('.$coupon['coupon_uni_id'].')" class="ng-scope" style="font-size: 12px; text-decoration: underline; cursor:pointer">
                                                    Terms &amp; Conditions
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="well well-sm arrow-up-right margin-top-15 in collapse" id="collapse_'.$coupon['coupon_uni_id'].'" style="max-height: 10em; overflow-y: scroll;" aria-expanded="true" aria-hidden="false">
                                            <small class="text-muted ng-binding">Add Minimum '.$this->config->item('currency').$Showominimum_cart_amt.' more of products to checkout process </small>
                                        </p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>';
                }
                $is_coupon_apply = true;
            }
            $data = array('Couponslist' => $html, 'response'=>1);
        }
        echo json_encode($data);
    }
    public function applyVoucher(){
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $userid             =   $this->session->userdata('user_id');
        $coupon_code        =   $this->input->post('coupanCode');
        $total_service_amt  =   $this->input->post('amt');
        $coupon_data         =   $this->setting_model->checkCouponCode($userid,$coupon_code);
        if(array_key_exists('_success', $coupon_data)){
            $coupon_data        = $coupon_data['_success'];
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
                    $coupon_apply_data['coupon_apply_id'] = $coupon_apply_id;
                    $coupon_apply_data['coupon_discount_amt'] = $discount_amount;
                    $coupon_apply_data['remainingAmount'] = ($this->input->post('amt') - $discount_amount);
                    $data   =   array('msg'=>'Coupon Applied Successfully', 'response' => 1, 'datas'=>$coupon_apply_data);
                }else{
                    $data   =   array('msg'=>'Something went Wrong Coupon Not Applied.', 'response' => 0);
                } 
            }
            else{
                $msg = 'Coupon Code Cannot be Applied On This cart Amount. Minimum Amount : '.$minimum_cart_amt;
                $data   =   array('msg'=>$msg, 'response' => 0);
            }
        }
        else{
                $data   =   array('msg'=>$coupon_data['_error'], 'response' => 0);
            }
      echo json_encode($data);
    } 
    
    public function removeCoupon(){
        if($this->config->item('maintenance') == 0){
            redirect('maintenance'); 
        }
        $userid             =   $this->session->userdata('user_id');
        $coupanCode      = $this->input->post('coupanCode');
        $coupon_apply_id = $this->input->post('coupon_apply_id'); // Coupon Removed From Database
        $results         = $this->db->query("SELECT coupon_id FROM tbl_coupons WHERE coupon_code='".$coupanCode."'");
        $coupancode_sel  = $results->row();
        $coupan_id       = $coupancode_sel->coupon_id;
        //echo 'DELETE FROM tbl_coupon_apply WHERE coupon_apply_id = "'.$coupon_apply_id.'" AND user_id="' . $userid . '" AND coupon_id = "' . $coupan_id.'"'; exit;
        $result = $this->db->query('DELETE FROM tbl_coupon_apply WHERE coupon_apply_id = "'.$coupon_apply_id.'" AND user_id="' . $userid . '" AND coupon_id = "' . $coupan_id.'"');
        if ($result == 1) {
            $msg = 'Coupon Removed Successfully';
            $data =  array('msg'=>$msg, 'response'=>1);
        } else {
            $data =  array('msg'=>"Something Went Wrong Coupon Not Removed", 'response'=>0);
        }
         echo json_encode($data);
    }

}




/*
 * $post_rseult =  $this->db
                ->select(TblSclPosts::col_id.' as '.TblSclPosts::col_id_out)
                ->join(TblSclPosts::tbl_name, TblSclPosts::col_type_id. " = ".TblSclPostArticles::col_id)
                ->join(TblCatCategories::tbl_name, TblCatCategories::col_id." = ".TblSclPosts::col_default_category_id)
                ->where(TblSclPosts::col_type, 'ARTICLES')
                ->where(TblCatCategories::col_id, (is_array($categoryId)?(int)$categoryId[0]:(int)$categoryId))
                ->get(TblSclPostArticles::tbl_name)
                ->result_array();
 * 
 * 
 * /*
 * $id = $this -> db
       -> select('id')
       -> where('email', $email)
       -> limit(1)
       -> get('users')
       -> row()
       ->id;
echo "ID is ".$id;
 * ------------------------------------------
 *  $array = array('name' => $name, 'title' => $title, 'status' => $status);
    $this->db->where($array);
 * ------------------------------------------
 * $this->db->last_query();
 * var_dump($this->db->last_query());
 * 
 * 
 * ---------------------------------------------------------
 * 
        if ($this->db->simple_query($sql))
        {
                //echo "Success!";
                var_dump($query->result_array());
        }
        else
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            //echo "Query failed! ".$error;
            var_dump($error);        
 *      }
 */


