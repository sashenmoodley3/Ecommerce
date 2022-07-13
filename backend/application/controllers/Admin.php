<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once ('../third_party/razorpay-php/Razorpay.php');
require_once ('../third_party/vendor/autoload.php');
use Razorpay\Api\Api as RazorpayApi;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Admin extends MY_Controller {

    private static $API_SERVER_KEY = 'Your Server Key';
    private static $is_background = "TRUE";

    public function __construct() {
        parent::__construct();
		date_default_timezone_set('Africa/Johannesburg');
        // Your own constructor code
        $this->load->model("setting_model");
        $this->load->model("csv_model");
        $this->load->model("product_model");
        $this->load->model("common_model");
        $this->load->database();
        $this->load->helper('login_helper');
        $this->load->library('form_validation');
        $this->load->helper('sms_helper');
        $this->load->model("users_model");
        // include(FCPATH.'phpexcel/PHPExcel.php');
        $panding_sale = $this->db
                ->select('sale_id')
                ->where('status', 0)
                ->count_all_results('sale');
        $this->config->set_item('notification', $panding_sale);
        
        // Company Data
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
        // $this->config->set_item('add_product_text_box', $company[62]->value);
        // $this->config->set_item('out_of_stock_quantity', $company[63]->value);
        // $this->config->set_item('get_payment_details_url', $company[64]->value);
        // $this->config->set_item('company_referal', $company[4]->value);
        // $this->config->set_item('sender_amount', $company[28]->value);
        // $this->config->set_item('facebook_app_id', $company[65]->value);
        // $this->config->set_item('facebook_app_secret', $company[66]->value);
        // $this->config->set_item('google_client_id', $company[67]->value);
        // $this->config->set_item('google_client_secret', $company[68]->value);
        // $this->config->set_item('delivery_date_after_days', $company[69]->value);
        // $this->config->set_item('superadmin_url', $company[70]->value);		
				
       
        // $this->config->set_item('sms_url', $this->get_company_value('sms_url'));
        // $this->config->set_item('sms_user', $this->get_company_value('sms_user'));
        // $this->config->set_item('sms_pass', $this->get_company_value('sms_pass'));
        // $this->config->set_item('app_version', $this->get_company_value('app_version'));
        // $this->config->set_item('app_url', $this->get_company_value('app_url'));
        // $this->config->set_item('wallet_deduction', $this->get_company_value('wallet_deduction'));
        // $this->config->set_item('firebase_key', $this->get_company_value('firebase_key'));
        // $this->config->set_item('firebase_addword', $this->get_company_value('firebase_addword'));
        // $this->config->set_item('firebase_analytics', $this->get_company_value('firebase_analytics'));
        // $this->config->set_item('firebase_addmob', $this->get_company_value('firebase_addmob'));
        // $this->config->set_item('email_host', $this->get_company_value('email_host'));
        // $this->config->set_item('email_username', $this->get_company_value('email_username'));
        // $this->config->set_item('email_password', $this->get_company_value('email_password'));
        // $this->config->set_item('email_smtp', $this->get_company_value('email_smtp'));
        // $this->config->set_item('email_port', $this->get_company_value('email_port'));
        // $this->config->set_item('address', $this->get_company_value('address'));
        // $this->config->set_item('about', $this->get_company_value('about'));
        // $this->config->set_item('tawk_panel', $this->get_company_value('tawk_panel'));
        // $this->config->set_item('facebook_pixel', $this->get_company_value('facebook_pixel'));
        // $this->config->set_item('facebook_event', $this->get_company_value('facebook_event'));
        // $this->config->set_item('tag_manager', $this->get_company_value('tag_manager'));
        // $this->config->set_item('pwa_app', $this->get_company_value('pwa_app'));
        // $this->config->set_item('splash_screen', $this->get_company_value('splash_screen'));
        // $this->config->set_item('intro_screen', $this->get_company_value('intro_screen'));
        // $this->config->set_item('app_icon', $this->get_company_value('app_icon'));
        // $this->config->set_item('web_version', $this->get_company_value('web_version'));
        // $this->config->set_item('zivo_panel', $this->get_company_value('zivo_panel'));
        // $this->config->set_item('facebook_panel', $this->get_company_value('facebook_panel'));
        // $this->config->set_item('product_setup', $this->get_company_value('product_setup'));
        // $this->config->set_item('file_size', $this->get_company_value('file_size'));
        // $this->config->set_item('time_slot', $this->get_company_value('time_slot'));
        // $this->config->set_item('lite_app_icon', $this->get_company_value('lite_app_icon'));
        // $this->config->set_item('slider_file_size', $this->get_company_value('slider_file_size'));
        // $this->config->set_item('tutorial_url', $this->get_company_value('tutorial_url'));
        // $this->config->set_item('version_url', $this->get_company_value('version_url'));
        // $this->config->set_item('get_version_url', $this->get_company_value('get_version_url'));
        // $this->config->set_item('upgrade_version_url', $this->get_company_value('upgrade_version_url'));
        // $this->config->set_item('maintenance', $this->get_company_value('maintenance'));
        // $this->config->set_item('support_url', $this->get_company_value('support_url'));
        // $this->config->set_item('refund_time_limit', $this->get_company_value('refund_time_limit'));
        // $this->config->set_item('vat', $this->get_company_value('vat'));
        // $this->config->set_item('country_phone_code', $this->get_company_value('country_phone_code'));
        // $this->config->set_item('add_product_text_box', $this->get_company_value('add_product_text_box'));
        // $this->config->set_item('out_of_stock_quantity', $this->get_company_value('out_of_stock_quantity'));
        // $this->config->set_item('get_payment_details_url', $this->get_company_value('get_payment_details_url'));
        // $this->config->set_item('company_referal', $this->get_company_value('company_referal'));
        // $this->config->set_item('sender_amount', $this->get_company_value('sender_amount'));
        // $this->config->set_item('facebook_app_id', $this->get_company_value('facebook_app_id'));
        // $this->config->set_item('facebook_app_secret', $this->get_company_value('facebook_app_secret'));
        // $this->config->set_item('google_client_id', $this->get_company_value('google_client_id'));
        // $this->config->set_item('google_client_secret', $this->get_company_value('google_client_secret'));
        // $this->config->set_item('delivery_date_after_days', $this->get_company_value('delivery_date_after_days'));
        // $this->config->set_item('superadmin_url', $this->get_company_value('superadmin_url'));
		
        $main_currency = $this->get_company_value('currency');
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
                ->where('meta_type','back')
                ->get('theme_color_setting')
                ->result();
        if(!empty($theme)){
            foreach($theme as $row){
                $this->config->set_item($row->meta_key, $row->meta_value); 
            }
        }
        
        
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
            // $this->config->set_item('email_vew_version', $EmailTemplate[8]->description);
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
         
        
       // echo $this->config->item('maintenance'); exit;
       
        $clss = $this->router->fetch_class();
        $mthd = $this->router->fetch_method();
        
        if($this->config->item('maintenance') == 0 && $mthd != 'UpdateAdminStatus'){
            redirect(dirname($this->config->item('base_url')));
        }

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
       
	
    public function get_new_version(){
        echo $this->config->item('web_version');
    }
    public function get_tutorial(){
        $tutorial = $this->db
                    ->select('*')
                    ->where('trash',0)
                    ->where('status',1)
                    ->get('tbl_videotutorial')
                    ->result_array();
        print_r(json_encode($tutorial));
    }
   
    public function check_version(){
        // $url    =   $this->config->item('version_url');
		$url = rtrim($this->config->item('superadmin_url'), '/').'/index.php/superadmin/get_new_version';
        // Step 1
        $rajkumar = curl_init(); 
        // Step 2
        curl_setopt($rajkumar,CURLOPT_URL,$url);
        curl_setopt($rajkumar,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($rajkumar,CURLOPT_HEADER, false); 
        // Step 3
        $result=curl_exec($rajkumar);
        // Step 4
        curl_close($rajkumar);
        // Step 5
        $notification_msg   =   '';
        // if($result != $this->config->item('web_version')){
        //     $notification_msg = "New version of Kart Supermarket is available. Version ".$result;
        //     $this->config->set_item('notification_msg', $notification_msg);
        // }
        return $notification_msg;
        
    }

    public function slugify($text){
          // replace non letter or digits by -
          $text = preg_replace('~[^\pL\d]+~u', '-', $text);
          // transliterate
          $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
          // remove unwanted characters
          $text = preg_replace('~[^-\w]+~', '', $text);
          // trim
          $text = trim($text, '-');
          // remove duplicate -
          $text = preg_replace('~-+~', '-', $text);
          // lowercase
          $text = strtolower($text);
          if (empty($text)) {
            return 'n-a';
          }
          return $text;
    }
    
    public function convertdmyToymd($date){
        $date = str_replace('/', '-', $date);
        return date('Y-m-d', strtotime($date));
    }
    
    
    public function unique_key(){
        return md5(microtime().rand());
    }

    function signout() {
        $this->session->sess_destroy();
        redirect("admin");
    }
    
    public function edit_mainadmin($user_id){
        if(_is_user_login($this)){

            $data = array();
            $this->load->model("users_model");
            $data["user_types"] = $this->users_model->get_user_type();
            $user = $this->users_model->get_mainuser_by_id($user_id);
            //print_r($user); die;
            $data["user"] = $user;
            if($_POST){
                $this->load->library('form_validation');
				$update_array = [];
                
                $this->form_validation->set_rules('user_fullname', 'Store Name', 'trim|required');
                $this->form_validation->set_rules('user_name', 'Employee Name', 'trim|required');
                $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> <strong>Warning!</strong> '.$this->form_validation->error_string().' </div>');
                    
                }
				else{
					
					if($_FILES["pro_pic"]["size"] > 0)
					{
						$config['upload_path']          = './uploads/profile/';
						$config['allowed_types']        = 'gif|jpg|png|jpeg';
						$this->load->library('upload', $config);
		
						if (!$this->upload->do_upload('pro_pic'))
						{
							$this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> <strong>Warning!</strong> '.$this->upload->display_errors().' </div>');
						}
						else{
							$img_data = $this->upload->data();
							$update_array['user_image']=$img_data['file_name'];
						}
					}
					 
					
					$update_array['user_fullname'] = $this->input->post("user_fullname");
					$update_array['user_name'] = $this->input->post("emp_fullname"); 
					$update_array['user_phone'] = $this->input->post("mobile"); 
					// $update_array['user_status'] = ($this->input->post("status")=="on")? 1 : 0;; 
					// $update_array['user_city'] = $this->input->post("city"); 
					
					
					$this->load->model("common_model");
					$this->common_model->data_update("users",$update_array,array("user_id"=>$user_id)
						);
					$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Success!</strong> Admin Update Successfully</div>');
					redirect("admin/edit_mainadmin/".$user_id);
                        
                }
            }
            
            
            $this->load->view("admin/edit_mainadmin",$data);
        }
        else
        {
            redirect('admin');
        }
    }

    public function delete_order_schedule($order_id) {

           if (_is_user_login($this)) {
           // $this->load->model("product_model");
            //$order = $this->product_model->get_sale_order_by_id($order_id);
            //if (!empty($order)) {
                $this->db->query("update  tbl_product_schedule set schedule_status = 0 where schedule_id = '" . $order_id . "'");

                //$this->load->view("admin/orders/orderslist_schedule");
                redirect('admin/schedule_orders');
               
            //}
        }
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
        
        
    public function UpdateAdminStatus(){
        $user1     =   $_GET['user'];
        $not_close =   !empty($_GET['not_close'])? $_GET['not_close'] : '';
        
        $data   =   array(
                            'user_status'        =>  $user1,
                            'user_login_status'  =>  $user1,
                            'user_login'         =>  $user1
                            );
        $result     =   $this->db->update('users', $data);
		if(empty($not_close)){
			$this->db->where('titles', 'maintenance');
			$data       =   $this->db->update('company_setting', array('value' => $user1));
		}
		
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
    
    
    public function index() {
        if($this->config->item('maintenance') == 0){
            redirect(dirname($this->config->item('base_url')));
        }
        // if(_is_user_login($this)){
        //     redirect(_get_user_redirect($this));
        // }else{
        $this->config->set_item('title', "Login");
        $data = array("error" => "");
        if (isset($_POST)) {

            $this->load->library('form_validation');

            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                if ($this->form_validation->error_string() != "") {
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                </div>';
                }
            } else {

                $q = $this->db->query("SELECT * FROM `users` WHERE (`user_email`='" . $this->input->post("email") . "')  AND user_type_id ='2'");

                if ($q->num_rows() > 0) {
                    $row = $q->row();
                    if ($row->user_status == "0" || $row->user_login_status =="0") {
                        $data["error"] = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Your account currently inactive.</div>';
                    } else {
                        if($row->user_password == md5($this->input->post("password"))){
                             $user_login     =   array(
                                                        'user_id'       =>  $row->user_id,
                                                        'login_date'    =>  date('Y-m-d H:i:s'),
                                                        'status'        =>  0,
                                                        'ipaddress'     =>  $_SERVER['REMOTE_ADDR'],
                                                );    
                            
                            $this->db->insert('user_last_login', $user_login);
                            $unique_key     =   $this->unique_key();
                            $update_array   =   array(
                                                    'user_login'    => 1,
                                                    'user_key'      => $unique_key,
                                                    );
                            $this->db->where('user_id', $row->user_id);
                            $this->db->update('users', $update_array);
                            
                            $newdata = array(
                                'user_name'         =>  $row->user_fullname,
                                'user_email'        =>  $row->user_email,
                                'logged_in'         =>  TRUE,
                                'user_id'           =>  $row->user_id,
                                'user_type_id'      =>  $row->user_type_id,
                                'unique_key'        =>  $unique_key,
                            );
                            $this->session->set_userdata($newdata);
                            redirect(_get_user_redirect($this));
                        }
                        else{
                            $data["error"] = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Invalid password. </div>';
                        }
                    }
                } else {
                    $data["error"] = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> This user name not register </div>';
                }
            }
        } else {
            $this->session->sess_destroy();
        }
        $data["active"] = "login";

        $this->load->view("admin/login2", $data);
        // }
    }

    public function mange_setting() {
        $data = array();
        $this->load->view("admin/mange_setting/index.php", $data);
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
       
   /************* Get State By Country *********************************/
   public function getStateByCountry(){
       $country     =   $this->input->get('country');
       $sql         =   $this->db->query("SELECT * FROM tbl_states WHERE country_id='".$country."'  ORDER BY state_name");
       $sql_result  =   $sql->result_array();
       $option      =   '';
       foreach($sql_result as $row){
           $option  .=   '<option value="'.$row['state_id'].'">'.$row['state_name'].'</option">';
       }
       echo $option;
   }
   /************* Get City By State *********************************/
   public function getCityByState(){
       $state     =   $this->input->get('state');
       $sql         =   $this->db->query("SELECT * FROM tbl_city WHERE state_id='".$state."' ORDER BY city_name");
       $sql_result  =   $sql->result_array();
       $option      =   '';
       foreach($sql_result as $row){
           $option  .=   '<option value="'.$row['city_id'].'">'.$row['city_name'].'</option">';
       }
       echo $option;
   }
    
    public function dashboard() {
        $this->config->set_item('title', "Dashboard");
        if (_is_user_login($this)) {
            $data = array();
            $this->load->model("product_model");
            $this->check_version();
            $date = date("Y-m-d");
            $data["today_orders"] = $this->product_model->get_sale_orders(" and sale.status = 4 and sale.on_date = '" . $date . "' ");
            $nexday = date('Y-m-d', strtotime(' +1 day'));
            $data["nextday_orders"] = $this->product_model->get_sale_orders(" and sale.on_date = '" . $nexday . "' ");
            $date = date("Y-m-d");
            $data["today_deli_orders"] = $this->product_model->get_sale_orders(" and  sale.on_date = '" . $nexday . "' ");
            $this->load->view("admin/dashboard", $data);
        } else {
            redirect("admin");
        }
    }
	
	
	public function change_password(){
		
		$this->config->set_item('title', "Change Password");
        if (_is_user_login($this)) {
			$data = array();
			$user_id = $this->session->userdata("user_id");
			if ($_POST) {
				
				$this->load->library('form_validation');
				$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
				$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
				$this->form_validation->set_rules('con_password', 'Confirm Password', 'trim|required|matches[new_password]');
				

				if ($this->form_validation->run() == FALSE) {
					if ($this->form_validation->error_string() != "") {
						$this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
										<i class="fa fa-success"></i>
									  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									  <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
									</div>');
						
					}
				}
				else
				{
					$q = $this->db->query("select * from users where user_id = '".$user_id."'");
					$user = $q->row();
					
					if($user->user_password == md5($_POST['old_password'])){
					
						$data = array(                        
							'user_password' => md5($_POST['new_password'])                       
						);
						$data = $this->security->xss_clean($data);
						
						$this->db->where('user_id', $user_id);
						$this->db->update('users', $data);
						
						
						$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
										<i class="fa fa-success"></i>
									  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									  <strong>Success!</strong> Password successfully Updated.</div>');
						redirect("admin/change_password");
					}
					else
					{
						
						$this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
										<i class="fa fa-warning"></i>
									  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									  <strong>Warning!</strong> Old Password Does Not Matched. Please Enter correct Password.</div>');
					}
					

				}
			}
			
       
			$this->load->view('admin/change_password', $data);
		} else {
            redirect("admin");
        }
    }
	
	public function plan_renewal__old(){
        //print_r($_GET); exit;
        $client_name            =   urldecode($_GET['client_name']);
        $client_email           =   urldecode($_GET['client_email']);
        $mobile_no              =   urldecode($_GET['client_mobile']);
        $currency               =   urldecode($_GET['currency']);
        $amount                 =   urldecode($_GET['amount']);
        $language               =   urldecode($_GET['language']);
        $plan_id                =   urldecode($_GET['plan_id']);
        $user_uni_id            =   $this->randome_uni_id();
        
        
        $userdata               =   array(
                                        'user_name'             => ($client_name),
                                        'user_fullname'         => ($client_name),
                                        'user_phone'            => ($mobile_no),
                                        'user_email'            => ($client_email),
                                        'create_date'           => date('Y-m-d H:i:s'),
                                        'plan_id'               => $plan_id,
                                        'user_type_id'          => 2,
                                        'pkg_id'                => 'Kart Supermarket',
                                        'version'               => '1.1',
                                        'pakg_amount'           => ($amount),
                                        'user_status'           => 0,
                                        'user_login_status'     => 0,
                                        'user_login'            => 0,
                                        'user_uni_id'           => $user_uni_id
                                    );
        
        $result                 =   $this->db->insert('users', $userdata);
        $user_id                =   $this->db->insert_id();
        $data                   =   array(
                                        'client_name'           => ($client_name),
                                        'client_email'          => ($client_email),
                                        'client_mobile'         => ($mobile_no),
                                        'currency'              => ($currency),
                                        'amount'                => ($amount),
                                        'created_at'            => date('Y-m-d H:i:s'),
                                        'language'              => ($language),
                                        'user_id'               =>  $user_id
                                    );
        //print_r($data); exit;
         $result                =   $this->db->insert('payments_tabel', $data);
        
        
        
        $result                 =   $this->db->insert('payments_tabel', $data);
        $last_id                =   $this->db->insert_id();
        if($result){
            $datas['responce']          =   true;
            $datas['msg']               =   "Your request successfully submit";
            $datas['order_id']          =    $last_id; 
            $datas['user_id']           =    $user_id; 
            $datas['client_name']       =    $client_name; 
            $datas['client_email']      =    $client_email; 
            $datas['client_mobile']     =    $mobile_no; 
            $datas['currency']          =    $currency; 
            $datas['amount']            =    $amount; 
        }
        else{
            $datas['responce']   =   false;
            $datas['msg']        =   "Somthig went wrong !!";
        }
         print_r(json_encode($datas));
    }
    
    // Payment Success
    public function payment_success1(){
        //print_r($_GET); exit;
        $pass               =   123456;
        $paymentid          =   urldecode($_GET['transaction_id']);
        $order_id           =   urldecode($_GET['order_id']);
        $user_id            =   urldecode($_GET['user_id']);
        $country            =   urldecode($_GET['country']);
        $address            =   urldecode($_GET['address']);
        $state              =   urldecode($_GET['state']);
        $city               =   urldecode($_GET['city']);
        $domain_url         =   urldecode($_GET['domain_url']);
        $account_password   =   urldecode($_GET['account_password']);
        $amount             =   urldecode($_GET['amount']);
        $password           =   !empty($account_password) ? md5($account_password) : md5($pass);
        
        if(!empty($paymentid)){
            $select_Sql  =  $this->db->query("SELECT * FROM payments_tabel WHERE id = '".$order_id."'");
            if($select_Sql->num_rows() > 0){
                $result     =   $this->db->query("UPDATE `users` SET pakg_amount='".$amount."', user_status='1', user_login_status='1', user_login='1', address = '".$address."', 
                country = '".$country."', state = '".$state."', city = '".$city."', domain_url = '".$domain_url."', user_password ='".$password."'  WHERE user_id = '".$user_id."'");
                
                $result     =   $this->db->query("UPDATE `payments_tabel` SET amount='".$amount."', status='1', transaction_id='".$paymentid."' WHERE id = '".$order_id."'");
            
                $select_sel     =   $select_Sql->result_array();
                
                //print_r($select_sel); exit;
                
                $message        =   '<b>Hello '.$select_sel[0]['client_name'].'! </b><br/>
                                    Welcome to the Kart Community. We are happy to have you here.  We have successfully received your payment.<br/>
                                    <b>Product Name � Kart </b><br/>
                                    <b>Transaction id � '.$paymentid.'</b><br/>
                                    <b>Name � '.$select_sel[0]['client_name'].'</b><br/>
                                    <b>Amount � '.$select_sel[0]['currency'].$select_sel[0]['amount'].'</b><br/>
                                    <b>Date � '.date("d M Y H:i:s").'</b><br/>
                                    Thank you for becoming the part of Kart family. Are you ready to start making your dreams come true? Click here to get started.<br/>';
            
            
                 /*Enquiry Mail Send Start*/
                $to_mail_arr = array();
                $to_mail_arr[0] = array('to_mail' => $select_sel[0]['client_email'], 'to_name' => $select_sel[0]['client_name']);
                $cc_mail_arr = array();
                $reply_to_mail_arr = array();
                $reply_to_mail_arr[0] = array('reply_mail'=>'sales@kriscent.in','reply_name'=>'noreply');
                $mail_subject = "Kart Supermarket Enquiry";
                $mail_attachment_arr = array();
                $from_mail_arr = array();
                $from_mail_arr[0] = array('from_mail' =>'sales@kriscent.in', 'from_name' =>'Kart Supermarket Enquiry');
                $result  =  $this->send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr);
                
                if($result){
                    echo json_encode(array('response' => 'success'));
                }
                else{
                    echo json_encode(array('response' => 'failure'));
                }   
            }
            else{
                if($select_Sql->num_rows() > 0){
                    $results    =   $this->db->query("DELETE FROM users WHERE  user_id = '".$user_id."'");
                    $result     =   $this->db->query("UPDATE `payments_tabel` SET status='2' WHERE id = '".$order_id."'");
                }
                
                if($result){
                    echo json_encode(array('response' => 'success'));
                }
                else{
                    echo json_encode(array('response' => 'failure'));
                } 
            }
        }
    }
    


    public function orders_old() {
        if (_is_user_login($this)) {
            $data = array();
            $this->load->model("product_model");
            /*
              $fromdate = date("Y-m-d");
              $todate = date("Y-m-d");
              $data['date_range_lable'] = $this->input->post('date_range_lable');

              $filter = "";
              if($this->input->post("date_range")!=""){
              $filter = $this->input->post("date_range");
              $dates = explode(",",$filter);
              $fromdate =  date("Y-m-d", strtotime($dates[0]));
              $todate =  date("Y-m-d", strtotime($dates[1]));
              $filter = " and sale.on_date >= '".$fromdate."' and sale.on_date <= '".$todate."' ";
              }
              $data["today_orders"] = $this->product_model->get_sale_orders($filter);
             */
            $data["today_orders"] = $this->product_model->get_sale_orders_list();
            $data["title"]        = $this->config->set_item('title', 'Orders');
            $this->load->view("admin/orders/orderslist2", $data);
        } else {
            redirect("admin");
        }
    }
    
	
	public function orders() {
        if (_is_user_login($this)) {
            $data = array();
            
            $this->load->model("product_model");
            
            if(!empty($_POST))
            {
                $datetype   = $this->input->post('datetype');
                $dateto   = $this->input->post('dateto');
                $fromdate   = $this->input->post('fromdate');
                $paymentmethod   = $this->input->post('paymentmethod');
                $customername   = $this->input->post('customername');
                $deliverboyname   = $this->input->post('deliverboyname');
                $orderstatus   = $this->input->post('orderstatus');
                
                $data["all_orders"] = $this->product_model->get_sale_orders_list_by_filter($datetype, $dateto, $fromdate, $paymentmethod, $customername, $deliverboyname, $orderstatus);
                $data["post"] = $_POST;
            }
            else
            {
                $data["all_orders"] = $this->product_model->get_sale_orders_list();
            }            
            
            $data["title"]        = $this->config->set_item('title', 'Orders');
            $this->load->view("admin/orders/orderslist2", $data);
        } else {
            redirect("admin");
        }
    }
    
    public function get_html_order_details(){
        $action_id      =  $_GET['order_id'];
		
        if (_is_user_login($this)) {
            $data = array();
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($action_id);
            $order_items = $this->product_model->get_sale_order_items($action_id);
            // print_r($order);
			// die;
            //$this->load->view("admin/orders/orderdetails", $data);
            if(!empty($order)) {
				$on_date = $deliverd_date = '';
                if(!empty($order->on_date)){
					$on_date = date('d-m-Y', strtotime($order->on_date));
				}
                
                if(!empty($order->order_deliverd_date)){
					$deliverd_date = date('d-m-Y', strtotime($order->order_deliverd_date));
				}
                
                
                
                
                $html = '<div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><b>Order Details</b><button type="button" style="" class="close" data-dismiss="modal">&times;</button></h4> 
                </div> 
                <div class="modal-body">
				<table class="table" cellspacing="0" style="width:100%">
                        <tbody>';
              
                    $html .= '
                            <tr>
                                <th style="width:150px">'.$this->lang->line("Order Number").':</th>
                                <td>'.$order->sale_id.'</td>
                                <th style="width:150px">'.$this->lang->line("Customer Name").':</th>
                                <td>'.$order->user_fullname.'</td>
                            </tr>
                            <tr>
                                <th style="width:150px">'.$this->lang->line("Delivery Date").':</th>
                                <td>'.$on_date.'</td>
                                <th style="width:150px">'.$this->lang->line("Mobile Number").':</th>
                                <td>'.$order->receiver_mobile.'</td>
                            </tr>
                            <tr>
                                <th style="width:150px">'.$this->lang->line("Delivery Time").':</th>
                                <td>'.$order->delivery_time_from.' - '.$order->delivery_time_to.'</td>
                                <th style="width:150px">'.$this->lang->line("Email").':</th>
                                <td>'.$order->user_email.'</td>
                            </tr>
                            <tr>
                                <th style="width:150px">'.$this->lang->line("Delivered Date").':</th>
                                <td>'.$deliverd_date.'</td>
                                <th style="width:150px">'.$this->lang->line("Shipping Address").':</th>
                                <td>'.$order->delivery_address.'</td>
                            </tr>
                            <tr>
                                <th style="width:150px">'.$this->lang->line("Total Price").':</th>
                                <td>'.$this->config->item('currency').' '.$order->total_amount.'</td>
                                <th style="width:150px">Customer signature</th>
                                <td>';
								if(!empty($order->signature))
								{
									$html .= '<img src="'.$this->config->item('base_url').'uploads/signature/'.$order->signature.'" alt="Customer Signature" style="width: 100px;">';
								}
								$html .= '</td>
                                
                            </tr>
                            <tr>
                                <th style="width:150px">'.$this->lang->line("Delivery Boy Description").':</th>
                                <td>'.$order->dboy_description.'</td>
                                
                            </tr>
							';
                        
                        
                        
                $html .= ' 
                        </tbody>

                    </table>
				
                        
                        <h5 style="text-align:center;font-size:15px;margin:5px 0px;"><b>Item Details</b></h5><hr/ style="margin:0px; padding-bottom:15px;">';
                        
                
                $html .= '
				<table class="table table-striped table-bordered table-hover"
                                           cellspacing="0" width="100%" style="width:100%">
                        
                        <tr>
                            <th class="text-left" style="">'.$this->lang->line("Product Image").'</th>
                            <th class="text-left" style="width: 450px;">'.$this->lang->line("Product Name").'</th>
                        </tr>
                        

                        <tbody>';
                foreach ($order_items as $items) {
                        
                    $p_name_array = explode(",",$items->product_image);
                    //print_r($p_name_array);
                    
                    $html .= '
                            <tr>
                                <td style="width:100px;text-align:center;"><img class="img-fluid" src="'.$this->config->item('base_url').'uploads/products/'.$p_name_array[0].'" style="width:60px;"></td>
                                <td>'.$this->lang->line("Product Name").': '.$items->product_name.'</br>'.$this->lang->line("Qty").': '.$items->qty.'</td>
                            </tr>';
                    
                        $html1 = '<div class="row">
                            <div class="col-md-3"> <img class="img-fluid" src="'.$this->config->item('base_url').'uploads/products/'.$p_name_array[0].'" style="width:60px;"> </div>
                            <div class="col-md-9" style="">
                                <ul type="none">
                                    <li>'.$this->lang->line("Product Name").': '.$items->product_name.'</li>
                                    <li>'.$this->lang->line("Qty").': '.$items->qty.'</li>
                                </ul>
                            </div>
                            
                        </div>';
                        
                        }
                $html .= ' 
                        </tbody>

                    </table>';
                      
                echo $html;
            }
            
        } else {
            redirect("admin");
        }
        
        //$this->load->view("admin/orders/orderdetails2", $data);
    }
	
    public function transaction(){
         if (_is_user_login($this)) {
            $data = array();
            $data["title"]        = $this->config->set_item('title', 'Transaction');
            $this->load->view("admin/orders/transaction", $data);
        } else {
            redirect("admin");
        }
    }
    
    public function schedule_orders() {
        if (_is_user_login($this)) {
            $data = array();
            $this->load->model("product_model");
            /*
              $fromdate = date("Y-m-d");
              $todate = date("Y-m-d");
              $data['date_range_lable'] = $this->input->post('date_range_lable');

              $filter = "";
              if($this->input->post("date_range")!=""){
              $filter = $this->input->post("date_range");
              $dates = explode(",",$filter);
              $fromdate =  date("Y-m-d", strtotime($dates[0]));
              $todate =  date("Y-m-d", strtotime($dates[1]));
              $filter = " and sale.on_date >= '".$fromdate."' and sale.on_date <= '".$todate."' ";
              }
              $data["today_orders"] = $this->product_model->get_sale_orders($filter);
             */
            $data["today_orders"] = $this->product_model->get_sale_orders_list2();
            $this->load->view("admin/orders/orderslist_schedule", $data);
        } else {
            redirect("admin");
        }
    }
	
    public function confirm_order($order_id) {
        if (_is_user_login($this)) {
            $this->load->model("product_model");
            $emailorder_confirmation     =   $this->config->item('emailorder_confirmation');
            $smsorder_confirmation       =   $this->config->item('smsorder_confirmation');
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if (!empty($order)) {
                //print_r($order); exit;
                $this->db->query("update sale set status = '1' where sale_id = '" . $order_id . "'");
                $q = $this->db->query("SELECT registers.user_email, registers.user_gcm_code, 
                                        registers.user_ios_token, user_location.receiver_name, user_location.receiver_mobile  
                                        FROM registers 
                                        LEFT JOIN sale on sale.user_id=registers.user_id 
                                        AND sale.sale_id='".$order_id."'
                                        LEFT JOIN user_location on user_location.location_id=sale.location_id
                                        where  registers.user_id='".$order->customerid."'");
                $user = $q->row();
                $token = array(
                    'Name'  => $user->receiver_name,
                    'orderid' => $order_id,
                    'website' => $this->config->item('name')
                );
                $pattern = '[%s]';
                foreach($token as $key=>$val){
                    $varMap[sprintf($pattern,$key)] = $val;
                }
                $msg               =  strtr($smsorder_confirmation,$varMap);
                $message1["title"] = "Confirmed  Order";
                $message1["message"] = strtr($smsorder_confirmation,$varMap);
                $message1["image"] = base_url()."uploads/company/".$this->config->item('logo');
                $message1["created_at"] = date("Y-m-d h:i:s");
                $message1["obj"] = "";

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
                $message = "<a href='".base_url()."' title='".$this->config->item('name')."'><img src='".base_url()."uploads/company/".$this->config->item('logo')."' style='float:right; width:30%;' alt='".$this->config->item('name')."' title='".$this->config->item('name')."'></a><br><br><br><br>";
               
                $message .= strtr($emailorder_confirmation,$varMap);
               // echo $message; print_r($message1); exit;
                
                $result  =  $this->send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr);

                /*Order Mail Send End*/
                if(!empty($this->config->item('firebase_key'))){
                    $this->load->helper('gcm_helper');
                    $gcm = new GCM();
                    if ($user->user_gcm_code != "") {
                        $result = $gcm->send_notification(array($user->user_gcm_code), $message1, "android",$this->config->item('firebase_key'));
                    }
                    if ($user->user_ios_token != "") {
                        $result = $gcm->send_notification(array($user->user_ios_token), $message1, "ios",$this->config->item('firebase_key'));
                    }
                }
                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order confirmed. </div>');
               $this->setting_model->sendsmsPOST($user->receiver_mobile, $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));
            }
            redirect("admin/orders");
        } else {
            redirect("admin");
        }
    }

    public function delivered_order($order_id) {
        if (_is_user_login($this)) {
            $this->load->model("product_model");
            $emailorder_dispatch     =   $this->config->item('emailorder_dispatch');
            $smsorder_dispatch       =   $this->config->item('smsorder_dispatch');
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if (!empty($order)) {
                $this->db->query("update sale set status = 2 where sale_id = '" . $order_id . "'");
                /* $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method)
                  SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method FROM sale
                  where sale_id = '".$order_id."'");

                 */

                $q = $this->db->query("SELECT registers.user_email, registers.user_gcm_code,
                                        registers.user_ios_token, user_location.receiver_name, user_location.receiver_mobile, sale.total_amount, sale.delivery_charge
                                        FROM registers 
                                        LEFT JOIN sale on sale.user_id=registers.user_id 
                                        AND sale.sale_id='".$order_id."'
                                        LEFT JOIN user_location on user_location.location_id=sale.location_id
                                        where  registers.user_id='".$order->customerid."'");
                $user = $q->row(); 
                
                $token = array(
                    'Name'  => $user->receiver_name,
                    'orderid' => $order_id,
                    'amount'    =>($user->total_amount+$user->delivery_charge),
                    'website' => $this->config->item('name')
                );
                $pattern = '[%s]';
                foreach($token as $key=>$val){
                    $varMap[sprintf($pattern,$key)] = $val;
                }
                
                $message1["title"] = "Delivered Order";
                $message1["message"] = strtr($smsorder_dispatch,$varMap);
                $message1["image"] = base_url()."uploads/company/".$this->config->item('logo');
                $message1["created_at"] = date("Y-m-d h:i:s");
                $message1["obj"] = "";
                
                $msg               =  strtr($smsorder_dispatch,$varMap);
               
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
                $message = "<a href='".base_url()."' title='".$this->config->item('name')."'><img src='".base_url()."uploads/company/".$this->config->item('logo')."' style='float:right; width:30%;' alt='".$this->config->item('name')."' title='".$this->config->item('name')."'></a><br><br><br><br>";
                $message .= strtr($emailorder_dispatch,$varMap);

                $result  =  $this->send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr);


                /*Order Mail Send End*/
                if(!empty($this->config->item('firebase_key'))){
                    $this->load->helper('gcm_helper');
                    $gcm = new GCM();
                    if ($user->user_gcm_code != "") {
                        $result = $gcm->send_notification(array($user->user_gcm_code), $message1, "android",$this->config->item('firebase_key'));
                    }
                    if ($user->user_ios_token != "") {
                        $result = $gcm->send_notification(array($user->user_ios_token), $message1, "ios",$this->config->item('firebase_key'));
                    }
                }

                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order delivered. </div>');
                                  
               $this->setting_model->sendsmsPOST($user->receiver_mobile, $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));
            }
            redirect("admin/orders");
        } else {
            redirect("admin");
        }
    }

    public function delivered_order_complete($order_id) {
        if (_is_user_login($this)) {
            $this->load->model("product_model");
            $emailorder_delivery     =   $this->config->item('emailorder_delivery');
            $smsorder_delivery       =   $this->config->item('smsorder_delivery');
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if (!empty($order)) {
                $date       =   date('Y-m-d H:i:s');
                $this->db->query("update sale set status = 4, order_deliverd_date='".$date."' where sale_id = '" . $order_id . "'");
                $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method)
                SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method FROM sale
                where sale_id = '" . $order_id . "'");

                 $q = $this->db->query("SELECT registers.user_email, registers.user_gcm_code,
                                        registers.user_ios_token, registers.rewards, user_location.receiver_name, user_location.receiver_mobile 
                                        FROM registers 
                                        LEFT JOIN sale on sale.user_id=registers.user_id 
                                        AND sale.sale_id='".$order_id."'
                                        LEFT JOIN user_location on user_location.location_id=sale.location_id
                                        where  registers.user_id='".$order->customerid."'");
                $user = $q->row();

                $token = array(
                    'Name'      => $user->receiver_name,
                    'orderid'   => $order_id,
                    'website'   => $this->config->item('name')
                );
                $pattern        = '[%s]';
                foreach($token as $key=>$val){
                    $varMap[sprintf($pattern,$key)] = $val;
                }
                
                $message1["title"]      = "Delivered  Order";
                $message1["message"]    = strtr($smsorder_delivery,$varMap);
                $message1["image"]      = base_url()."uploads/company/".$this->config->item('logo');
                $message1["created_at"] = date("Y-m-d h:i:s");
                $message1["obj"]        = "";
                
                $msg               =  strtr($smsorder_delivery,$varMap);
                
                // $q = $this->db->query("Select * from registers where user_id = '" . $order->user_id . "'");
                // $user = $q->row();

                $q2 = $this->db->query("Select total_rewards, user_id from sale where sale_id = '" . $order_id . "'");
                $user2 = $q2->row();

                $rewrd_by_profile = $user->rewards;
                $rewrd_by_order = $user2->total_rewards;

                $new_rewards = $rewrd_by_profile + $rewrd_by_order;
                $this->db->query("update registers set rewards = '" . $new_rewards . "' where user_id = '" . $user2->user_id . "'");


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
                $message = "<a href='".base_url()."' title='".$this->config->item('name')."'><img src='".base_url()."assets/images/header1/".$this->config->item('logo')."' style='float:right; width:30%;' alt='".$this->config->item('name')."' title='".$this->config->item('name')."'></a><br><br><br><br>";
                $message .= strtr($emailorder_delivery,$varMap);

                $result  =  $this->send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr);


                /*Order Mail Send End*/
                if(!empty($this->config->item('firebase_key'))){
                    $this->load->helper('gcm_helper');
                    $gcm = new GCM();
                    if ($user->user_gcm_code != "") {
                        $result = $gcm->send_notification(array($user->user_gcm_code), $message1, "android",$this->config->item('firebase_key'));
                    }
                    if ($user->user_ios_token != "") {
                        $result = $gcm->send_notification(array($user->user_ios_token), $message1, "ios",$this->config->item('firebase_key'));
                    }
                }

                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order delivered. </div>');
                                  
                //$msg = "Your order Number '" . $order->sale_id . "' Delivered successfully. Thank you for being with us";
                
              $this->setting_model->sendsmsPOST($user->receiver_mobile, $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));
            }
            redirect("admin/orders");
        } else {
            redirect("admin");
        }
    }

    public function cancle_order($order_id) {
        if (_is_user_login($this)) {
            $this->load->model("product_model");
            $emailorder_cancel     =   $this->config->item('emailorder_cancel');
            $smsorder_cancel       =   $this->config->item('smsorder_cancel');
            $order = $this->product_model->get_sale_order_by_id($order_id);
            //print_r($order);
            if (!empty($order)) {
                $this->db->query("update sale set status = 3, order_cancel_by='Admin' where sale_id = '" . $order_id . "'");
                //$this->db->delete('sale_items', array('sale_id' => $order_id));
                $q = $this->db->query("SELECT registers.user_email, registers.user_gcm_code,
                                        registers.user_ios_token, user_location.receiver_name, user_location.receiver_mobile 
                                        FROM registers 
                                        LEFT JOIN sale on sale.user_id=registers.user_id AND sale.sale_id='".$order_id."'
                                        LEFT JOIN user_location on user_location.location_id=sale.location_id
                                        where  registers.user_id='".$order->customerid."'");
                $user = $q->row();
                //print_r($user); exit;
                $token = array(
                    'Name'      => $user->receiver_name,
                    'orderid'   => $order_id,
                    'website'   => $this->config->item('name')
                );
                $pattern        = '[%s]';
                foreach($token as $key=>$val){
                    $varMap[sprintf($pattern,$key)] = $val;
                }
                
                $message1["title"]      = "Cancel  Order";
                $message1["message"]    = strtr($smsorder_cancel,$varMap);
                $message1["image"]      = base_url()."uploads/company/".$this->config->item('logo');
                $message1["created_at"] = date("Y-m-d h:i:s");
                $message1["obj"]        = "";
                
                $msg               =  strtr($smsorder_cancel,$varMap);
                
                
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
                $message = "<a href='".base_url()."' title='".$this->config->item('name')."'><img src='".base_url()."assets/images/header1/".$this->config->item('logo')."' style='float:right; width:30%;' alt='".$this->config->item('name')."' title='".$this->config->item('name')."'></a><br><br><br><br>";
                $message .= strtr($emailorder_cancel,$varMap);

                $result  =  $this->send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr);
                /*Order Mail Send End*/
                if(!empty($this->config->item('firebase_key'))){
                    $this->load->helper('gcm_helper');
                    $gcm = new GCM();
                    if ($user->user_gcm_code != "") {
                        $result = $gcm->send_notification(array($user->user_gcm_code), $message1, "android", $this->config->item('firebase_key'));
                    }
                    if ($user->user_ios_token != "") {
                        $result = $gcm->send_notification(array($user->user_ios_token), $message1, "ios", $this->config->item('firebase_key'));
                    }
                }

                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order Cancle. </div>');
                                  
               $this->setting_model->sendsmsPOST($user->receiver_mobile, $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));
            }
            redirect("admin/orders");
        } else {
            redirect("admin");
        }
    }

    public function delete_order($order_id) {
        if (_is_user_login($this)) {
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if (!empty($order)) {
                $this->db->query("delete from sale where sale_id = '" . $order_id . "'");
                $this->db->delete('sale_items', array('sale_id' => $order_id));
                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order deleted. </div>');
            }
            redirect("admin/orders");
        } else {
            redirect("admin");
        }
    }

    public function orderdetails($order_id) {
        if (_is_user_login($this)) {
            $data = array();
			$this->db->query("update sale set is_admin_saw = '1' where sale_id = '" . $order_id . "'");
            $this->load->model("product_model");
            $data["order"] = $this->product_model->get_sale_order_by_id($order_id);
            $data["order_items"] = $this->product_model->get_sale_order_items($order_id);
            //print_r( $data);exit();
            $this->load->view("admin/orders/orderdetails2", $data);
        } else {
            redirect("admin");
        }
    }

    public function change_status() {
        $table = $this->input->post("table");
        $id = $this->input->post("id");
        $on_off = $this->input->post("on_off");
        $id_field = $this->input->post("id_field");
        $status = $this->input->post("status");

        $this->db->update($table, array("$status" => $on_off), array("$id_field" => $id));
    }

    /* =========USER MANAGEMENT============== */

    public function user_types() {
        $data = array();
        if (isset($_POST)) {

            $this->load->library('form_validation');

            $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                if ($this->form_validation->error_string() != "") {
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                </div>';
                }
            } else {
                $user_type = $this->input->post("user_type");

                $this->load->model("common_model");
                $this->common_model->data_insert("user_types", array("user_type_title" => $user_type));
                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Type added Successfully
                                </div>');
                redirect("admin/user_types/");
            }
        }

        $this->load->model("users_model");
        $data["user_types"] = $this->users_model->get_user_type();
        $this->load->view("admin/user_types", $data);
    }

    function user_type_delete($type_id) {
        $data = array();
        $this->load->model("users_model");
        $usertype = $this->users_model->get_user_type_id($type_id);
        if ($usertype) {
            $this->db->query("Delete from user_types where user_type_id = '" . $usertype->user_type_id . "'");
            redirect("admin/user_types");
        }
    }
    function appuser_delete($userid) {
        $data = array();
        $this->load->model("users_model");
        $usertype = $this->users_model->get_allAppuser($userid);
        if ($usertype) {
            $this->db->query("Delete from registers where user_id = '" . $userid . "'");
            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User deleted. </div>');
            redirect("admin/registers");
        }
    }
    public function user_access($user_type_id) {
        if ($_POST) {
            //print_r($_POST);     
            $this->load->library('form_validation');

            $this->form_validation->set_rules('user_type_id', 'User Type', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                if ($this->form_validation->error_string() != "") {
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                </div>';
                }
            } else {
                //$user_type_id = $this->input->post("user_type_id");
                $this->load->model("common_model");
                $this->common_model->data_remove("user_type_access", array("user_type_id" => $user_type_id));

                $sql = "Insert into user_type_access(user_type_id,class,method,access) values";
                $sql_insert = array();
                foreach (array_keys($_POST["permission"]) as $controller) {
                    foreach ($_POST["permission"][$controller] as $key => $methods) {
                        if ($key == "all") {
                            $key = "*";
                        }
                        $sql_insert[] = "($user_type_id,'$controller','$key',1)";
                    }
                }
                $sql .= implode(',', $sql_insert) . " ON DUPLICATE KEY UPDATE access=1";
                $this->db->query($sql);
            }
        }
        $data['user_type_id'] = $user_type_id;
        $data["controllers"] = $this->config->item("controllers");
        $this->load->model("users_model");
        $data["user_access"] = $this->users_model->get_user_type_access($user_type_id);

        //$data["user_types"] = $this->users_model->get_user_type();
        $this->load->view("admin/user_access", $data);
    }

    /* ============USRE MANAGEMENT=============== */


    /* ========== Categories =========== */

    public function addcategories() {
        if (_is_user_login($this)) {

            $data["error"] = "";
            $data["active"] = "addcat";
            if (isset($_REQUEST["addcatg"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                $this->form_validation->set_rules('product_cat_type', 'Product Category Type',     'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                    }
                } else {
                    $this->load->model("category_model");
                    $this->category_model->add_category();
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/addcategories');
                }
            }
            $this->load->view('admin/categories/addcat2', $data);
        } else {
            redirect('admin');
        }
    }
    
    
    public function delete_attribute_values($attribute_value_id){
        if(_is_user_login($this)) {
            echo $attribute_value_id;
            //$attribute_value_id = $this->input->post("attribute_value_id");
            $array = array(
                "attribute_value_deleted" => 1                
            );

            $in_id = $this->common_model->data_update("attribute_values", $array, array("attribute_value_id" => $attribute_value_id));

            if($in_id)
            {
                $this->session->set_flashdata("response", '<div class="alert alert-success alert-dismissible" role="alert">
                                <i class="fa fa-check"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Your Request Deleted Successfully...
                            </div>');
                redirect('admin/attributes');
            }
        }
        else {
            redirect('admin');
        }
    }
    
    public function frontside(){
        if(_is_user_login($this)) {
            $data = array();
            
            if (isset($_REQUEST["update_menus"])) {
                                            
                $category = $this->input->post("category");
                $home = $this->input->post("home");
                $contact_us = $this->input->post("contact_us");
                $about_us = $this->input->post("about_us");
                // $boys = $this->input->post("boys");
                // $kids = $this->input->post("kids");
                $brand = $this->input->post("brand");
                $shop = $this->input->post("shop");
                
                if(empty($attribute_value_status))
                {
                    $attribute_value_status = 0;
                }
                $array = array(
                    "category" => $category,
                    "home" => $home,
                    "contact_us" => $contact_us,
                    "about_us" => $about_us,
                    // "boys" => $boys,
                    // "kids" => $kids,
                    "brand" => $brand,
                    "shop" => $shop
                );

                $in_id = $this->common_model->data_update("front_menu", $array, array("front_menu_id" => '1'));

                if($in_id)
                {
                    $this->session->set_flashdata("response", '<div class="alert alert-success alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Your Request Updated Successfully...
                                </div>');
                    redirect('admin/frontside');
                }
                    
               
            }
            elseif (isset($_REQUEST["update_filters"])) {
                $review = $this->input->post("review");
                $price = $this->input->post("price");
                $attributes = $this->input->post("attributes");
                $brand = $this->input->post("brand");
                $category = $this->input->post("category");
                
                
                
                if(empty($attribute_value_status))
                {
                    $attribute_value_status = 0;
                }
                $array = array(
                    "review" => $review,
                    "price" => $price,
                    "attributes" => $attributes,
                    "brand" => $brand,
                    "category" => $category
                );

                $in_id = $this->common_model->data_update("front_filter", $array, array("front_filter_id" => '1'));

                if($in_id)
                {
                    $this->session->set_flashdata("response", '<div class="alert alert-success alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Your Request Updated Successfully...
                                </div>');
                    redirect('admin/frontside');
                }
            }
            
            $this->load->view('admin/frontside/frontside_menu_filter', $data);
//            echo $attribute_value_id;
//            //$attribute_value_id = $this->input->post("attribute_value_id");
//            $array = array(
//                "attribute_value_deleted" => 1                
//            );
//
//            $in_id = $this->common_model->data_update("attribute_values", $array, array("attribute_value_id" => $attribute_value_id));
//
//            if($in_id)
//            {
//                $this->session->set_flashdata("response", '<div class="alert alert-success alert-dismissible" role="alert">
//                                <i class="fa fa-check"></i>
//                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
//                              <strong>Success!</strong> Your Request Deleted Successfully...
//                            </div>');
//                redirect('admin/attributes');
//            }
        }
        else {
            redirect('admin');
        }
    }

    public function attributes(){
        if(_is_user_login($this)) {
            
            if (isset($_REQUEST["addattribute"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('attribute', 'Select Attribute', 'trim|required');
                $this->form_validation->set_rules('product_cat_type', 'Select Product Category', 'trim|required');
                $this->form_validation->set_rules('attribute_value', 'Enter Attribute Value', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $data["response"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                    }
                }
                else
                {
                    $attribute_value_status = $this->input->post("attribute_value_status");
                    if(empty($attribute_value_status))
                    {
                        $attribute_value_status = 0;
                    }
                    
                    $array = array(
                        "attribute_id" => $this->input->post("attribute"),
                        "attribute_value" => ucfirst($this->input->post("attribute_value")),
                        "attribute_values_product_cat_type_id" => ucfirst($this->input->post("product_cat_type")),
                        "attribute_value_status" => $attribute_value_status,
                        "attribute_value_deleted" => 0,
                        "attribute_value_created" => date("Y-m-d h:i:s")
                    );
                    
                    $in_id = $this->common_model->data_insert("attribute_values", $array);
                   
                    if($in_id)
                    {
                        $this->session->set_flashdata("response", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                        redirect('admin/attributes');
                    }
                    
                }
            }            
            elseif (isset($_REQUEST["editattribute"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('attribute_value_id', 'Attribute Value Id', 'trim|required');
                $this->form_validation->set_rules('product_cat_type', 'Select Product Category', 'trim|required');
                $this->form_validation->set_rules('attribute', 'Select Attribute', 'trim|required');
                $this->form_validation->set_rules('attribute_value', 'Enter Attribute Value', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $data["response"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                    }
                }
                else
                {
                    $attribute_value_id = $this->input->post("attribute_value_id");
                    $attribute_value_status = $this->input->post("attribute_value_status");
                    if(empty($attribute_value_status))
                    {
                        $attribute_value_status = 0;
                    }
                    $array = array(
                        "attribute_id" => $this->input->post("attribute"),
                        "attribute_values_product_cat_type_id" => ucfirst($this->input->post("product_cat_type")),
                        "attribute_value" => $this->input->post("attribute_value"),
                        "attribute_value_status" => $attribute_value_status
                    );
                    
                    $in_id = $this->common_model->data_update("attribute_values", $array, array("attribute_value_id" => $attribute_value_id));
                   
                    if($in_id)
                    {
                        $this->session->set_flashdata("response", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Request Updated Successfully...
                                    </div>');
                        redirect('admin/attributes');
                    }
                    
                }
            }
            
            $data["attributes"] = $this->db
                    ->select('*')
                    ->where('attribute_deleted',0)
                    ->where('attribute_status',0)
                    ->get('attributes')
                    ->result_array();
            $data["attribute_values"] = $this->product_model->get_attribute_values();
            $this->load->view('admin/categories/attributes', $data);
        } else {
            redirect('admin');
        }
        //print_r(json_encode($tutorial));
    }

    public function add_header_categories() {
        if (_is_user_login($this)) {

            $data["error"] = "";
            $data["active"] = "addcat";
            if (isset($_REQUEST["addcatg"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                    }
                } else {
                    $this->load->model("category_model");
                    $this->category_model->add_header_category();
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/add_header_categories');
                }
            }
            $this->load->view('admin/icon_categories/addcat', $data);
        } else {
            redirect('admin');
        }
    }

    public function editcategory($id) {
        if (_is_user_login($this)) {
            $q = $this->db->query("select * from `categories` WHERE id=" . $id);
            $data["getcat"] = $q->row();

            $data["error"] = "";
            $data["active"] = "listcat";
            if (isset($_REQUEST["savecat"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('cat_id', 'Categories Id', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                $this->form_validation->set_rules('product_cat_type', 'Product Category Type',     'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                    }
                } else {
                    $this->load->model("category_model");
                    $this->category_model->edit_category();
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your category saved successfully...
                                    </div>');
                    redirect('admin/listcategories');
                }
            }
            $this->load->view('admin/categories/editcat2', $data);
        } else {
            redirect('admin');
        }
    }

    public function edit_header_category($id) {
        if (_is_user_login($this)) {
            $q = $this->db->query("select * from `header_categories` WHERE id=" . $id);
            $data["getcat"] = $q->row();

            $data["error"] = "";
            $data["active"] = "listcat";
            if (isset($_REQUEST["savecat"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('cat_id', 'Categories Id', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                    }
                } else {
                    $this->load->model("category_model");
                    $this->category_model->edit_header_category();
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your category saved successfully...
                                    </div>');
                    redirect('admin/header_categories');
                }
            }
            $this->load->view('admin/icon_categories/editcat', $data);
        } else {
            redirect('admin');
        }
    }

    public function listcategories() {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data["active"] = "listcat";
            $this->load->model("category_model");
            $data["allcat"] = $this->category_model->get_categories();
            $this->load->view('admin/categories/listcat2', $data);
        } else {
            redirect('admin');
        }
    }

    public function header_categories() {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data["active"] = "listcat";
            $this->load->model("category_model");
            $data["allcat"] = $this->category_model->get_header_categories();
            $this->load->view('admin/icon_categories/listcat', $data);
        } else {
            redirect('admin');
        }
    }

    public function deletecat($id) {
        if (_is_user_login($this)) {
            $query  =   $this->db->query("SELECT product_id FROM products WHERE category_id='".$id."'");
            if($query->num_rows() > 0){
                $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> This Category Add product. Firstly remove products.
                                        </div>');
                redirect('admin/listcategories');
            }
            else{
                $checkParent =  $this->db->query("SELECT id FROM categories WHERE parent='".$id."'");
                if($checkParent->num_rows() > 0){
                    $result_cat     =   $checkParent->result_array();
                    foreach($result_cat as $row){
                        $cat_id     =   $row['id'];
                        $querys  =   $this->db->query("SELECT product_id FROM products WHERE category_id='".$cat_id."'");
                        if($querys->num_rows() > 0){
                            $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                                        <i class="fa fa-check"></i>
                                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                      <strong>Warning!</strong> This Category Add product. Firstly remove products.
                                                    </div>');
                            redirect('admin/listcategories');
                        }
                        else{
                             $this->db->delete("categories", array("id" => $cat_id));
                        }
                    }
                }
                $this->db->delete("categories", array("id" => $id));
                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your item deleted successfully...
                                        </div>');
                redirect('admin/listcategories');

            }
        } else {
            redirect('admin');
        }
    }

    public function delete_header_categories($id) {
        if (_is_user_login($this)) {
            
            $query  =   $this->db->query("SELECT product_id FROM products WHERE category_id='".$id."'")->num_rows();
            
            if($query > 0){
                
            }
            else{
                    $this->db->delete("header_categories", array("id" => $id));
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your item deleted successfully...
                                        </div>');
                    redirect('admin/header_categories');
            }
        } else {
            redirect('admin');
        }
    }

    /* ========== End Categories ========== */
    /* ========== Brand =========== */

    public function addbrand() {
        if (_is_user_login($this)) {
           
            $data["error"] = "";
            $data["active"] = "addbrand";
            if (isset($_REQUEST["addbrand"])) {
                 //print_r($_POST); exit;
                $this->load->library('form_validation');
                $this->form_validation->set_rules('brand_title', 'Brand Title', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                    }
                } else {
                    $this->load->model("category_model");
                    $this->category_model->add_brand();
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/addbrand');
                }
            }
            $this->load->view('admin/brand/addbrand', $data);
        } else {
            redirect('admin');
        }
    }

    public function editbrand($id) {
        if (_is_user_login($this)) {
            $q = $this->db->query("select * from `tbl_brand` WHERE id=" . $id);
            $data["getcat"] = $q->row();

            $data["error"] = "";
            $data["active"] = "listbrand";
            if (isset($_REQUEST["savebrand"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('brand_title', 'Brand Title', 'trim|required');
                $this->form_validation->set_rules('brand_id', 'Brand Id', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                    }
                } else {
                    $this->load->model("category_model");
                    $this->category_model->edit_brand();
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Brand saved successfully...
                                    </div>');
                    redirect('admin/listbrand');
                }
            }
            $this->load->view('admin/brand/editbrand', $data);
        } else {
            redirect('admin');
        }
    }

    public function listbrand() {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data["active"] = "listbrand";
            $this->load->model("category_model");
            $data["allcat"] = $this->category_model->get_brand();
            $this->load->view('admin/brand/listbrand', $data);
        } else {
            redirect('admin');
        }
    }
    
    public function wish_list($user_id) {
        if (_is_user_login($this)) {
            //echo "wish_list";
            //$data["error"] = "";
            $data["active"] = "wishlist";
            $this->load->model("product_model");
            $data["allwishlist"] = $this->product_model->get_wish_list($user_id);
            $this->load->view('admin/wishlist', $data);
        } else {
            redirect('admin');
        }
    }


    public function deletebrand($id) {
        if (_is_user_login($this)) {
            $query  =   $this->db->query("SELECT product_id FROM products WHERE brand_id='".$id."'");
            if($query->num_rows() > 0){
                $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> This Brand Add product. Firstly remove products.
                                        </div>');
                redirect('admin/listbrand');
            }
            else{
                
                $querys  =   $this->db->query("SELECT product_id FROM products WHERE brand_id='".$id."'");
                if($querys->num_rows() > 0){
                    $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                                <i class="fa fa-check"></i>
                                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                              <strong>Warning!</strong> This Brand Add product. Firstly remove products.
                                            </div>');
                    redirect('admin/listbrand');
                }
                else{
                     $this->db->update("tbl_brand", array('trash'=>1), array("id" => $id));
                     //echo $this->db->last_query(); exit;
                     $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                                <i class="fa fa-check"></i>
                                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                              <strong>Success!</strong> Delete your brand...
                                            </div>');
                     redirect('admin/listbrand');
                }

            }
        } else {
            redirect('admin');
        }
    }

    public function category_type() {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data["active"] = "category_type";
            $q = $this->db->query("SELECT * FROM `product_cat_type`");

            $data["allcat"] = $q->result();
            $this->load->view('admin/category_type/list', $data);
        } else {
            redirect('admin');
        }
    }
    
    public function active_cat_type($id){
        if(_is_super_login($this)) {
            $this->db->where('product_cat_type_id',$id);
            $this->db->update('product_cat_type',array('status' => 1));
            
            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Successfully Active Category Type. </div>');
            redirect("admin/category_type");
        } else {
            redirect("admin");
        }
        
    }
    public function deactive_cat_type($id){
        if(_is_super_login($this)) {
            $this->db->where('product_cat_type_id',$id);
            $this->db->update('product_cat_type',array('status' => 0));
            
            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Successfully Deactive Category Type. </div>');
            redirect("admin/category_type");
        } else {
            redirect("admin");
        }
        
    }

    /* ========== End Brand ========== */
    
     /* ========== DeliverBoy ========== */
     
    function deliverBoy() {
        if (_is_user_login($this)) {
            $data['title'] = $this->config->set_item('title', ' Deliver Boy');
            $this->load->model("deliverboy_model");
            $data["deliverdata"] = $this->deliverboy_model->get_alldeliverboy();
            $this->load->view("admin/deliverboy/deliverBoyList", $data);
        } else {
            redirect('admin');
        }
    }
	
	public function disable_dboy($id) {
        if (_is_user_login($this)) {           
            
            $this->db->query('update delivery_boy set user_status = "0" WHERE id = "'.$id.'"');
            redirect('admin/deliverBoy');
        } else {
            redirect('admin');
        }
    }
    
    public function enable_dboy($id) {
        if (_is_user_login($this)) {           
            
            $this->db->query('update delivery_boy set user_status = "1" WHERE id = "'.$id.'"');
            redirect('admin/deliverBoy');
        } else {
            redirect('admin');
        }
    }
    
    public function enable_dboy_doc($id) {
        if (_is_user_login($this)) {           
            
            $this->db->query('update delivery_boy_doc set status = "1" WHERE id = "'.$id.'"');
            redirect('admin/deliverBoy');
        } else {
            redirect('admin');
        }
    }
    
     
    function add_deliverboy() {
        if (_is_user_login($this)) {
            $data['title'] = $this->config->set_item('title', 'Add Deliver Boy');

            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_name', 'Name', 'trim|required');
                $this->form_validation->set_rules('user_phone', 'Phone', 'trim|required');
                $this->form_validation->set_rules('user_email', 'Email', 'trim|required');
                $this->form_validation->set_rules('user_city', 'Password', 'trim|required');
                $this->form_validation->set_rules('user_state', 'Password', 'trim|required');
                $this->form_validation->set_rules('user_country', 'Password', 'trim|required');
                $this->form_validation->set_rules('user_pincode', 'Password', 'trim|required');
                $this->form_validation->set_rules('deliverboy_address', 'Address', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                                
                    }
                } else {
                    
                    $this->load->model("common_model");
                    $this->load->model("product_model");
                    $uni_id  = $this->product_model->new_sequence_code('DELIVER');
                    
                    $array = array(
                        "deliverBoy_id" => $uni_id,
                        "user_name" => $this->input->post("user_name"),
                        "user_phone" => $this->input->post("user_phone"),
                        "user_email" => $this->input->post("user_email"),
                        "user_city" => $this->input->post("user_city"),
                        "user_state" => $this->input->post("user_state"),
                        "user_country" => $this->input->post("user_country"),
                        "user_pincode" => $this->input->post("user_pincode"),
                        "user_password" => md5($this->input->post("user_password")),
                        "user_address" => $this->input->post("deliverboy_address"),
                        "deliverboy_description" => $this->input->post("deliverboy_description"),
                        "user_status" => $this->input->post("user_status"),
                        "created_at" => date('Y-m-d'),
                        "trash" => '0',
                        "present_status" => '1',
                    );
                    
                    if ($_FILES["deliverBoyImage"]["size"] > 0) {
                        $config['upload_path'] = './uploads/deliver/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('deliverBoyImage')) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $img_data = $this->upload->data();
                            $array["deliverBoyImage"] = $img_data['file_name'];
                        }
                    }
                    
                    $in_id = $this->common_model->data_insert("delivery_boy", $array);
                   
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully..."
                                    </div>');
                    redirect('admin/add_deliverboy');
                }
            }

            $this->load->view("admin/deliverboy/addDeliverBoy");
        } else {
            redirect('admin');
        }
    }
    
    function edit_deliverBoy($id) {
        if (_is_user_login($this)) {

            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_name', 'Name', 'trim|required');
                $this->form_validation->set_rules('user_phone', 'Mobile', 'trim|required');
                $this->form_validation->set_rules('user_email', 'Email', 'trim|required');
                 $this->form_validation->set_rules('user_city', 'City', 'trim|required');
                $this->form_validation->set_rules('user_state', 'State', 'trim|required');
                $this->form_validation->set_rules('user_country', 'Country', 'trim|required');
                $this->form_validation->set_rules('user_pincode', 'Pincode', 'trim|required');
                $this->form_validation->set_rules('deliverboy_address', 'Address', 'trim|required');
                // $this->form_validation->set_rules('user_password', 'Password', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                    }
                } else {
					
                    $this->load->model("common_model");
                    $array = array(                        
                        "user_name" => $this->input->post("user_name"),
                        "user_phone" => $this->input->post("user_phone"),
                        "user_email" => $this->input->post("user_email"),
                        "user_city" => $this->input->post("user_city"),
                        "user_state" => $this->input->post("user_state"),
                        "user_country" => $this->input->post("user_country"),
                        "user_pincode" => $this->input->post("user_pincode"),
                        "user_address" => $this->input->post("deliverboy_address"),
                        "deliverboy_description" => $this->input->post("deliverboy_description"),
                        "user_status" => $this->input->post("user_status")
                    );
					
					
					if(!empty($this->input->post("user_password"))){
						$array["user_password"] = md5($this->input->post("user_password"));
					}
                    
                     if ($_FILES["deliverBoyImage"]["size"] > 0) {
                        $config['upload_path']      = './uploads/deliver/';
                        $config['allowed_types']    = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('deliverBoyImage')) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $img_data                   = $this->upload->data();
                            $array["deliverBoyImage"]   = $img_data['file_name'];
                        }
                    }
                    $this->common_model->data_update("delivery_boy", $array, array("id" => $id));
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/deliverBoy');
                }
            }
            $this->load->model("deliverboy_model");
            $data["deliverdata"] = $this->deliverboy_model->get_deliverboy_by_id($id);
            $this->load->view("admin/deliverboy/editDeliverBoy", $data);
        } else {
            redirect('admin');
        }
    }
    
    function deliverBoy_orders($id) {
        if (_is_user_login($this)) {
            $data = array();
            $this->load->model("product_model");
            $delivery_boy_id = $id;
            $this->load->model("deliverboy_model");
            
            if(!empty($_POST))
            {
                $datetype   = $this->input->post('datetype');
                $dateto   = $this->input->post('dateto');
                $fromdate   = $this->input->post('fromdate');
                $paymentmethod   = $this->input->post('paymentmethod');
                $customername   = $this->input->post('customername');
//                $deliverboyname   = $this->input->post('deliverboyname');
                $orderstatus   = $this->input->post('orderstatus');
                
                $data["all_orders"] = $this->deliverboy_model->get_sale_orders_list_by_delivery_boy_id($datetype, $dateto, $fromdate, $paymentmethod, $customername, $orderstatus, $delivery_boy_id);
                $data["post"] = $_POST;
            }
            else
            {
                $data["all_orders"] = $this->deliverboy_model->get_sale_orders_list_by_delivery_boy_id("" , "", "", "", "", "", $delivery_boy_id);
                
                
            }
//            $this->load->model("deliverboy_model");
//            $data["deliverdata"] = $this->deliverboy_model->get_deliverboy_by_id($id);
            $this->load->view("admin/deliverboy/deliverBoyOrdersList", $data);
        } else {
            redirect('admin');
        }
    }
    
    function delete_deliverboy($id) {
        if (_is_user_login($this)) {
            $array = array(
                'trash' => '1',
                'user_status' => 0
                );
            $this->load->model("common_model");
            $this->common_model->data_update("delivery_boy", $array, array("id" => $id));
            redirect("admin/deliverBoy");
        }
    }
    
    public function check_phone_deliverBoy(){
        $getphone=  $this->input->get('phone');
        
        $result = $this->db
            ->where('user_phone', $getphone)
            ->where('user_status', 1)
            ->get('delivery_boy')
            ->row();
        if(!empty($result)){
            echo  "Phone Number Alreay Exist";
        }
        else{
            echo "No Exist";
        }
    }
    
    /* ========== End DeliverBoy ========== */
    
    
    /* ========== Products ========== */

    function products() {
        $data["title"]        = $this->config->set_item('title', 'Products');
        if (_is_user_login($this)) {
            $this->load->model("product_model");
            $data["products"] = $this->product_model->get_products();
            $this->load->view("admin/product/list2", $data);
        } else {
            redirect('admin');
        }
    }
    
    

    function header_products() {
        $this->load->model("product_model");
        $data["products"] = $this->product_model->get_header_products();
        $this->load->view("admin/icon_product/list", $data);
    }

    function edit_products($prod_id) {
         $data["title"]        = $this->config->set_item('title', 'Edit Products');
        if (_is_user_login($this)) {
			$this->load->model("product_model");
            if (isset($_POST)) {
                
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Product Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Parent Categories', 'trim|required');
                $this->form_validation->set_rules('product_cat_type', 'Product Category Type',     'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                    }
                } else {
                    
                    $tax     =  $this->input->post('tax');
                    
                    if ($this->input->post("rewards") == "") {
                        $rewards = 0;
                    } else {
                        $rewards = $this->input->post("rewards");
                    }
                    $this->load->model("common_model");
                    $array = array(
                        "product_name" => $this->input->post("prod_title"),
                        "product_arb_name" => $this->input->post("arb_prod_title"),
                        "product_arb_description" => $this->input->post("arb_product_description"),
                        "category_id" => $this->input->post("parent"),
                        "product_description" => $this->input->post("product_description"),
                        "in_stock" => $this->input->post("prod_status"),
                        "arb_unit" => $this->input->post("arb_unit"),
                        "rewards" => $rewards,
                        "product_type" => $this->input->post("prod_type"),
                        "product_call" => $this->input->post("prod_call"),
                        "product_cat_type_id"  => $this->input->post("product_cat_type")
                    );
					
					
					$pro_img = $this->input->post("pro_img");
                    if(empty($_FILES["prod_img"]['name'][0]) && empty($pro_img)){
                        $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Error!</strong> Product Image is required</div>');
                             redirect('admin/edit_products/'.$prod_id);
                    }
					
                    $filesCount = count($_FILES["prod_img"]['name']);
                    $file_name  = "prod_img";
                    $uploadData  = array();
                    if($filesCount > 0){
                        for($i = 0; $i < $filesCount; $i++){
                            if($_FILES[$file_name]['size'][$i] <= $this->config->item('file_size')){
                                $_FILES['files']['name']       = $_FILES[$file_name]['name'][$i];
                                $_FILES['files']['type']       = $_FILES[$file_name]['type'][$i];
                                $_FILES['files']['tmp_name']   = $_FILES[$file_name]['tmp_name'][$i];
                                $_FILES['files']['error']      = $_FILES[$file_name]['error'][$i];
                                $_FILES['files']['size']       = $_FILES[$file_name]['size'][$i];
                    
                                // File upload configuration
                                $config['upload_path']   = './uploads/products/';
                                $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
                    
                                // Load and initialize upload library
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                    
                                // Upload file to server
                                if($this->upload->do_upload('files')){
                                    // Uploaded file data
                                    $fileData = $this->upload->data();
                                    $uploadData[$i] = $fileData['file_name'];
                                }
                            }
                            else{
                                $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Error!</strong> Product File size is greater then '.($this->config->item('file_size')/1024).' KB...
                                        </div>');
                                     redirect('admin/edit_products/'.$prod_id);
                            }
                        }
                    }
					if(!empty($pro_img)){
						$uploadData = array_merge($uploadData,$pro_img);
					}
                    if(!empty($uploadData)){
						$image_string = '';
                        foreach ($uploadData as $key=>$file_name){
                            if($image_string == ''){
                                $image_string = $file_name;
                            }else{
                                $image_string .= ','.$file_name;
                            }
            
                        }
                         $array["product_image"] = $image_string;
                    }else{
                        $error = array('error' => $this->upload->display_errors());
                    }
                    
                    
                    $this->common_model->data_update("products", $array, array("product_id" => $prod_id));
                    $varient_id      = $_POST['varient_id'];
                    $quantity        = $_POST['quantity'];
                    $unit            = $_POST['unit'];
                    $stock           = $_POST['stock'];
                    $mrp             = $_POST['mrp'];
                    $margin          = $_POST['margin'];   
                    $price           = $_POST['price'];
                    $flavor          = !empty($_POST['flavor']) ? $_POST['flavor'] : '';
                    $var_use_for     = !empty($_POST['var_use_for']) ? $_POST['var_use_for'] : '';
                    $var_color       = !empty($_POST['var_color']) ? $_POST['var_color'] : '';
                    $var_size        = !empty($_POST['var_size']) ? $_POST['var_size'] : '';
                    $var_material    = !empty($_POST['var_material']) ? $_POST['var_material'] : '';
                    $tax           = $_POST['tax'];
                    $prod_var_img    = count($_FILES["prod_var_img"]['name']);
                    $file_name       = "prod_var_img";
                    if(!empty($quantity)){
                        $qn = count($quantity);
                        //$select_stock   =   $this->db->query("SELECT stock_inv FROM product_varient where product_id  = '" . $prod_id . "'")->row();;
                        //$stockInv       =   $select_stock->stock_inv;
                        //$this->db->query("delete from product_varient where product_id  = '" . $prod_id . "'");
                         for($i=0; $i<$qn; $i++){
                            if(!empty($price[$i])){
                                if(!empty($_FILES[$file_name]['name'][$i])){
                                    if($_FILES[$file_name]['size'][$i] <= $this->config->item('file_size')){
                                        $_FILES['files']['name']       = $_FILES[$file_name]['name'][$i];
                                        $_FILES['files']['type']       = $_FILES[$file_name]['type'][$i];
                                        $_FILES['files']['tmp_name']   = $_FILES[$file_name]['tmp_name'][$i];
                                        $_FILES['files']['error']      = $_FILES[$file_name]['error'][$i];
                                        $_FILES['files']['size']       = $_FILES[$file_name]['size'][$i];
                            
                                        // File upload configuration
                                        $config['upload_path']   = './uploads/products/';
                                        $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
                            
                                        // Load and initialize upload library
                                        $this->load->library('upload', $config);
                                        $this->upload->initialize($config);
                                        $uploadDatas    =   '';
                                        // Upload file to server
                                        if($this->upload->do_upload('files')){
                                            // Uploaded file data
                                            $fileData   = $this->upload->data();
                                            $uploadDatas = $fileData['file_name'];
                                        }
										
										if(!empty($varient_id[$i])){
											$purchaasr = $this->db->query("UPDATE product_varient SET pro_var_images = '" . $uploadDatas . "'  WHERE varient_id = '". $varient_id[$i]."' AND product_id = '".$prod_id."'");
                                        }
                                        
                                    }
                                    else{
                                        $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                                <i class="fa fa-check"></i>
                                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                              <strong>Error!</strong> Product Varient File size is greater then '.($this->config->item('file_size')/1024).' KB...
                                            </div>');
                                         redirect('admin/edit_products/'.$prod_id);
                                    }
                                }
                                
                                $flavors    =   !empty($flavor[$i]) ? $flavor[$i] : '';
                                $var_use_for1 =   !empty($var_use_for[$i]) ? $var_use_for[$i] : '';   
                                $var_size1     =   !empty($var_size[$i]) ? $var_size[$i] : '';   
                                $var_color1    =   !empty($var_color[$i]) ? $var_color[$i] : '';   
                                $var_material1 =   !empty($var_material[$i]) ? $var_material[$i] : ''; 
                                
                                $var_use_for1 =   ($var_use_for1>0) ? $var_use_for1 : '';   
                                $var_size1     =   ($var_size1>0) ? $var_size1 : '';   
                                $var_color1    =   ($var_color1>0) ? $var_color1 : ''; 
                                $var_material1 =   ($var_material1>0) ? $var_material1 : '';
                                
                                if(!empty($varient_id[$i])){
                                    $purchaasr = $this->db->query("UPDATE product_varient SET margin_value = '" . $margin[$i] . "',  price = '" . $price[$i] . "', qty = '" . $quantity[$i] . "', unit = '" . $unit[$i] . "', stock_inv = '" . $stock[$i] . "', 
                                                tax ='" . $tax . "', mrp ='" . $mrp[$i] . "', flavor = '" . $flavors . "', var_color = '" . $var_color1 . "', var_material = '" . $var_material1 . "', var_use_for = '" . $var_use_for1 . "', var_size = '" . $var_size1 . "' WHERE varient_id = '". $varient_id[$i]."' AND product_id = '".$prod_id."'");

                                }
                                else{
                                    $purchaasr = $this->db->query("INSERT into product_varient(product_id, price, margin_value ,qty, unit,stock_inv, tax, mrp, date, description, pro_var_images, flavor, var_use_for, var_size, var_color, var_material) 
                                        values(
                                            '" . $prod_id . "',
                                            '" . $price[$i] . "', 
                                            '" . $margin[$i] . "',
                                            '" . $quantity[$i] . "', 
                                            '" . $unit[$i] . "', 
                                            '" . $stock[$i] . "', 
                                            '" . $tax . "', 
                                            '" . $mrp[$i] . "',
                                            '" . date('d-m-y h:i:s ') . "',
                                            'Stock Update By Admin',
                                            '" . $uploadDatas . "', 
                                            '" . $flavors . "',
                                            '" . $var_use_for1 . "',
                                            '" . $var_size1 . "',
                                            '" . $var_color1 . "',
                                            '" . $var_material1 . "')
                                            ");
                                            
                                        $varition_id = $this->db->insert_id();
                                        $date=date('Y-m-d h:i:s');
                    					$data1 = array(
                    						'purchase_id'       => "" ,
                    						'product_id'        => $prod_id,
                    						'varition_id'       => $varition_id,
                    						'qty'               => $quantity[$i],
                    						'unit'              => $unit[$i],
                    						'date'              => $date,
                    						'stock_inv'         => $stock[$i],
                    						'price'             => $price[$i],
                                            'margin_value'      => $margin[$i],
                    						'mrp'               => $mrp[$i],
                    						'store_id_login'    => '1',
                                            'var_use_for'       => $var_use_for1,
                                            'var_size'          => $var_size1,
                                            'var_color'         => $var_color1,
                                            'var_material'               => $var_material1
                    					);
			                        $data = $this->db->insert('purchase', $data1); 
                                }
                            }
                        }
                    }
                    
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/products');
                }
            }
            
            $data["purchase"] = $this->db->query("select * from product_varient where product_id =  '".$prod_id."' ")->result();
            $data["product"] = $this->product_model->get_product_by_id($prod_id);
			
            $this->load->view("admin/product/edit2", $data);
        } else {
            redirect('admin');
        }
    }

    function edit_header_products($prod_id) {
        if (_is_user_login($this)) {

            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                    }
                } else {
                    $this->load->model("common_model");
                    $array = array(
                        "product_name" => $this->input->post("prod_title"),
                        "category_id" => $this->input->post("parent"),
                        "product_description" => $this->input->post("product_description"),
                        "in_stock" => $this->input->post("prod_status"),
                        "price" => $this->input->post("price"),
                        "unit_value" => $this->input->post("qty"),
                        "unit" => $this->input->post("unit"),
                        "rewards" => $this->input->post("rewards")
                    );
                    if ($_FILES["prod_img"]["size"] > 0) {
                        $config['upload_path'] = './uploads/products/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('prod_img')) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $img_data = $this->upload->data();
                            $array["product_image"] = $img_data['file_name'];
                        }
                    }

                    $this->common_model->data_update("header_products", $array, array("product_id" => $prod_id));
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/header_products');
                }
            }
            $this->load->model("product_model");
            $data["product"] = $this->product_model->get_header_product_by_id($prod_id);
            $this->load->view("admin/icon_product/edit", $data);
        } else {
            redirect('admin');
        }
    }

    function add_products() {
         $data["title"]        = $this->config->set_item('title', 'Add Products');
        if (_is_user_login($this)) {
            $data['title'] = $this->config->set_item('title', 'Add Product');

            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Product Title',     'trim|required');
                $this->form_validation->set_rules('product_cat_type', 'Product Category Type',     'trim|required');
                $this->form_validation->set_rules('parent',     'Parent Category',    'trim|required');
                $this->form_validation->set_rules('quantity[]', 'Quantity',             'trim|required');
                $this->form_validation->set_rules('unit[]',     'Unit',                 'trim|required');
                $this->form_validation->set_rules('stock[]',    'Stock',                'trim|required');
                $this->form_validation->set_rules('mrp[]',      'MRP',                  'trim|required');
                //$this->form_validation->set_rules('margin[]',      'Margin',                  'trim|required');
                $this->form_validation->set_rules('price[]',    'Price',                'trim|required');
                $this->form_validation->set_rules('brand',      'Brand',                'trim|required');
                $this->form_validation->set_rules('prod_sku_code', 'Product SKU Code',  'trim');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                    }
                } else {
                    if ($this->input->post("rewards") == "") {
                        $rewards = 0;
                    } else {
                        $rewards = $this->input->post("rewards");
                    }
                    $this->load->model("common_model");
                    $this->load->model("product_model");
                    $uni_id             =  $this->product_model->new_sequence_code('PRODUCT');
                    $tax                =  $this->input->post('tax');
                    $uploadData         =  '';
                    $product_slug       =  $this->slugify($this->input->post("prod_title"));
                    
                    $product_cat_type       =  $this->slugify($this->input->post("product_cat_type"));
                    
                    $array = array(
                        "static_product_id"         => $uni_id,
                        "product_name"              => $this->input->post("prod_title"),
                        "product_arb_name"          => $this->input->post("arb_prod_title"),
                        "product_slug"              => $product_slug,
                        "product_arb_description"   => $this->input->post("product_description"),
                        "category_id"               => $this->input->post("parent"),
                        "in_stock"                  => $this->input->post("prod_status"),
                        "product_description"       => $this->input->post("product_description"),
                        "prod_sku_code"             => $this->input->post("prod_sku_code"),
                        "prod_ware_location"        => $this->input->post("prod_ware_location"),
                        "rewards"                   => $rewards,
                        "product_type"              => $this->input->post("prod_type"),
                        "product_call"              => $this->input->post("prod_call"),
                        "brand_id"                  => $this->input->post("brand"),
                        "product_cat_type_id"                  => $this->input->post("product_cat_type")
                    );
					
					if(empty($_FILES["prod_img"]['name'][0])){
                        $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Error!</strong> Product Image is required</div>');
                             redirect('admin/add_products');
                    }
                    
                    $filesCount  = count($_FILES["prod_img"]['name']);
                    $file_name   = "prod_img";
                    $uploadData  = array();
                    for($i = 0; $i < $filesCount; $i++){
                        //print_r($_FILES[$file_name]['size'][$i]);
                        if($_FILES[$file_name]['size'][$i] <= $this->config->item('file_size')){
                            $_FILES['files']['name']       = $_FILES[$file_name]['name'][$i];
                            $_FILES['files']['type']       = $_FILES[$file_name]['type'][$i];
                            $_FILES['files']['tmp_name']   = $_FILES[$file_name]['tmp_name'][$i];
                            $_FILES['files']['error']      = $_FILES[$file_name]['error'][$i];
                            $_FILES['files']['size']       = $_FILES[$file_name]['size'][$i];
                
                            // File upload configuration
                            $config['upload_path']   = './uploads/products/';
                            $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
                
                            // Load and initialize upload library
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                
                            // Upload file to server
                            if($this->upload->do_upload('files')){
                                // Uploaded file data
                                $fileData = $this->upload->data();
                                $uploadData[$i] = $fileData['file_name'];
                            }
                        }
                        else{
                            $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Error!</strong> Product File size is greater then '.($this->config->item('file_size')/1024).' KB...
                                    </div>');
                                  redirect('admin/add_products');
                        }
                    }
                    //exit;
                    if(!empty($uploadData)){
                        $image_string = '';
                        foreach ($uploadData as $key=>$file_name){
                            if($image_string == ''){
                                $image_string = $file_name;
                            }else{
                                $image_string .= ','.$file_name;
                            }
            
                        }
                         $array["product_image"] = $image_string;
                    }else{
                        $error = array('error' => $this->upload->display_errors());
                    }
                   

                    $in_id = $this->common_model->data_insert("products", $array);
//                    print_r($_POST['var_use_for']);
                    $quantity           = $_POST['quantity'];
                    $var_use_for        = !empty($_POST['var_use_for']) ? $_POST['var_use_for'] : '';
                    $var_color          = !empty($_POST['var_color']) ? $_POST['var_color'] : '';
                    $var_size           = !empty($_POST['var_size']) ? $_POST['var_size'] : '';
                    $var_material       = !empty($_POST['var_material']) ? $_POST['var_material'] : '';
                    $unit               = $_POST['unit'];
                    $stock              = $_POST['stock'];
                    $mrp                = $_POST['mrp'];
                    $price              = $_POST['price'];
                    $marign             = $_POST['margin'];
                    $flavor             = !empty($_POST['flavor']) ? $_POST['flavor'] : '';
                    $prod_var_img       = count($_FILES["prod_var_img"]['name']);
                    $file_name          = "prod_var_img";
                    $uploadData         =   '';
                    if(!empty($quantity)){
                    $qn = count($quantity);
                    for($i=0;$i<$qn;$i++){
                        if(!empty($_FILES[$file_name]['name'][$i])){
                            if($_FILES['files']['size'] <= $this->config->item('file_size')){
                                $_FILES['files']['name']       = $_FILES[$file_name]['name'][$i];
                                $_FILES['files']['type']       = $_FILES[$file_name]['type'][$i];
                                $_FILES['files']['tmp_name']   = $_FILES[$file_name]['tmp_name'][$i];
                                $_FILES['files']['error']      = $_FILES[$file_name]['error'][$i];
                                $_FILES['files']['size']       = $_FILES[$file_name]['size'][$i];
                    
                                // File upload configuration
                                $config['upload_path']   = './uploads/products/';
                                $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
                    
                                // Load and initialize upload library
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                    
                                // Upload file to server
                                if($this->upload->do_upload('files')){
                                    // Uploaded file data
                                    $fileData   = $this->upload->data();
                                    $uploadData = $fileData['file_name'];
                                }
                            }
                            else{
                                 $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Error!</strong> Product Varient File size is greater then '.($this->config->item('file_size')/1024).' KB...
                                    </div>');
                                redirect('admin/add_products');
                                
                            }
                        }

                       
                    $flavors      =   !empty($flavor[$i]) ? $flavor[$i] : '';   
                    $var_use_for1 =   !empty($var_use_for[$i]) ? $var_use_for[$i] : '';   
                    $var_size1     =   !empty($var_size[$i]) ? $var_size[$i] : '';   
                    $var_color1    =   !empty($var_color[$i]) ? $var_color[$i] : '';   
                    $var_material1 =   !empty($var_material[$i]) ? $var_material[$i] : '';   
                        
                    $var_use_for1 =   ($var_use_for1>0) ? $var_use_for1 : '';   
                    $var_size1     =   ($var_size1>0) ? $var_size1 : '';   
                    $var_color1    =   ($var_color1>0) ? $var_color1 : ''; 
                    $var_material1 =   ($var_material1>0) ? $var_material1 : '';
                        
//                    $purchaasr = $this->db->query("Insert into product_varient(product_id, price, qty, unit,stock_inv, tax, mrp, date, description, pro_var_images,flavor) 
//                    values(
//                        '" . $in_id . "',
//                        '" . $price[$i] . "', 
//                        '" . $quantity[$i] . "', 
//                        '" . $unit[$i] . "', 
//                        '" . $stock[$i] . "', 
//                        '" . $tax . "', 
//                        '" . $mrp[$i] . "',
//                        '" . date('d-m-y h:i:s ') . "',
//                        'Stock Update By Admin',
//                        '" . $uploadData . "', '" . $flavors . "')
//                        ");
                        
                        
                    $data2 = array(						
						'product_id'      => $in_id,
						'price'           => $price[$i],
                        'margin_value'    => $marign[$i],
                        'qty'             => $quantity[$i],
                        'unit'            => $unit[$i],
                        'stock_inv'       => $stock[$i],
                        'tax'             => $tax,
                        'mrp'               => $mrp[$i],
						'date'              => date('d-m-y h:i:s '),
						'description'              => 'Stock Update By Admin',
						'pro_var_images'              => $uploadData,						
						'flavor'             => $flavors
					);
                        
                        
                    if($product_cat_type==126 || $product_cat_type==127 || $product_cat_type==128)
                    {
                        $data2["var_use_for"] = $var_use_for1;
                        $data2["var_size"] = $var_size1;
                        $data2["var_color"] = $var_color1;
                        $data2["var_material"] = $var_material1;
                    }
                        
//                    echo "<pre>";
//                        print_r($data2);
//                        echo "<br>";
                    $data = $this->db->insert('product_varient', $data2);
                        
                    $varition_id = $this->db->insert_id();
                    $date=date('Y-m-d h:i:s');
					$data1 = array(
						'purchase_id'       => "" ,
						'product_id'        => $in_id,
						'varition_id'       => $varition_id,
						'qty'               => $quantity[$i],
						'unit'              => $unit[$i],
						'date'              => $date,
						'stock_inv'         => $stock[$i],
						'price'             => $price[$i],
                        'margin_value'      => $marign[$i],
						'mrp'               => $mrp[$i],
						'store_id_login'    => '1'
					);
                        
                    if($product_cat_type==126 || $product_cat_type==127 || $product_cat_type==128)
                    {
                        $data1["var_use_for"] = $var_use_for1;
                        $data1["var_size"] = $var_size1;
                        $data1["var_color"] = $var_color1;
                        $data1["var_material"] = $var_material1;
                    }
                        
//                        echo "<pre>";
//                        print_r($data1);
//                        echo "<br>";
					$data = $this->db->insert('purchase', $data1);    
                        
                    }
                }
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>'); //$m
                    redirect('admin/products');
                }
            }

            $this->load->view("admin/product/add2");
        } else {
            redirect('admin');
        }
    }
    
    function product_image_upload(){
        if (_is_user_login($this)) {
            if (isset($_POST) && !empty($_POST)) {
                    $filesCount = count($_FILES["prod_img"]['name']);
                    if($filesCount < 50){
                        $file_name  = "prod_img";
                        for($i = 0; $i < $filesCount; $i++){
                            if($_FILES[$file_name]['size'][$i] <= $this->config->item('file_size')){
                                $_FILES['files']['name']       = $_FILES[$file_name]['name'][$i];
                                $_FILES['files']['type']       = $_FILES[$file_name]['type'][$i];
                                $_FILES['files']['tmp_name']   = $_FILES[$file_name]['tmp_name'][$i];
                                $_FILES['files']['error']      = $_FILES[$file_name]['error'][$i];
                                $_FILES['files']['size']       = $_FILES[$file_name]['size'][$i];
                    
                                // File upload configuration
                                $config['upload_path']   = './uploads/products/';
                                $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
                    
                                // Load and initialize upload library
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                    
                                // Upload file to server
                                if($this->upload->do_upload('files')){
                                    // Uploaded file data
                                    $fileData = $this->upload->data();
                                    $uploadData[$i] = $fileData['file_name'];
                                }
                            }
                            else{
                                 $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Error!</strong> Upload product File size is greater then '.($this->config->item('file_size')/1024).' KB...
                                    </div>');
                                  redirect('admin/product_image_upload');
                            }
                        }
                        if(!empty($uploadData)){
                            $this->session->set_flashdata('image_url',$uploadData);
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request added successfully...
                                        </div>');
                            
                            
                        }else{
                            $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Error!</strong>'.$this->upload->display_errors().'
                                        </div>');
                        }
                    }
                    else{
                        $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> Please Select maximum 50 Images...
                                        </div>');         
                    }
                    redirect('admin/product_image_upload');  
            }
            
            $this->load->view("admin/product/product_image_upload");
        }
        else{
            redirect('admin');
        }
    }
    
    function category_image_upload(){
        if (_is_user_login($this)) {
            if (isset($_POST) && !empty($_POST)) {
                    $filesCount = count($_FILES["cat_img"]['name']);
                    if($filesCount < 50){
                        $file_name  = "cat_img";
                        for($i = 0; $i < $filesCount; $i++){
                            if($_FILES[$file_name]['size'][$i] <= $this->config->item('file_size')){
                                $_FILES['files']['name']       = $_FILES[$file_name]['name'][$i];
                                $_FILES['files']['type']       = $_FILES[$file_name]['type'][$i];
                                $_FILES['files']['tmp_name']   = $_FILES[$file_name]['tmp_name'][$i];
                                $_FILES['files']['error']      = $_FILES[$file_name]['error'][$i];
                                $_FILES['files']['size']       = $_FILES[$file_name]['size'][$i];
                    
                                // File upload configuration
                                $config['upload_path']   = './uploads/category/';
                                $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
                    
                                // Load and initialize upload library
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                    
                                // Upload file to server
                                if($this->upload->do_upload('files')){
                                    // Uploaded file data
                                    $fileData = $this->upload->data();
                                    $uploadData[$i] = $fileData['file_name'];
                                }
                            }
                            else{
                                 $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Error!</strong> Upload product File size is greater then '.($this->config->item('file_size')/1024).' KB...
                                    </div>');
                                  redirect('admin/category_image_upload');
                            }
                        }
                        if(!empty($uploadData)){
                            $this->session->set_flashdata('image_url',$uploadData);
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request added successfully...
                                        </div>');
                            
                            
                        }else{
                            $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Error!</strong>'.$this->upload->display_errors().'
                                        </div>');
                        }
                    }
                    else{
                        $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> Please Select maximum 50 Images...
                                        </div>');         
                    }
                    redirect('admin/category_image_upload');  
            }
            
            $this->load->view("admin/product/category_image_upload");
        }
        else{
            redirect('admin');
        }
    }

    function add_header_products() {
        if (_is_user_login($this)) {

            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                $this->form_validation->set_rules('price', 'price', 'trim|required');
                $this->form_validation->set_rules('qty', 'qty', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                    }
                } else {
                    $this->load->model("common_model");
                    $array = array(
                        "product_name" => $this->input->post("prod_title"),
                        "category_id" => $this->input->post("parent"),
                        "in_stock" => $this->input->post("prod_status"),
                        "product_description" => $this->input->post("product_description"),
                        "price" => $this->input->post("price"),
                        "unit_value" => $this->input->post("qty"),
                        "unit" => $this->input->post("unit"),
                        "rewards" => $this->input->post("rewards")
                    );
                    if ($_FILES["prod_img"]["size"] > 0) {
                        $config['upload_path'] = './uploads/products/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('prod_img')) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $img_data = $this->upload->data();
                            $array["product_image"] = $img_data['file_name'];
                        }
                    }

                    $this->common_model->data_insert("header_products", $array);
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/header_products');
                }
            }

            $this->load->view("admin/icon_product/add");
        } else {
            redirect('admin');
        }
    }

    function delete_product($id) {
        //echo $id; exit;
        if (_is_user_login($this)) {
            //$this->db->query("Delete from products where product_id = '".$id."'");
            $product_ids = array('products.product_id' => $id);
            $data = array(
                'products.in_stock' => 0,
                'products.trash' => 1
            );
            $result   =  $this->db->update('products', $data, $product_ids);
            if($result == 1){
                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request Delete successfully...
                                        </div>');
                redirect('admin/products');
            }else{
                $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> Please Try Again..</div>');
                $this->errorMessage('error_msg',$msg);
                
                redirect('admin/products');
            }
        } else {
            redirect('admin');
        }
    }

    function delete_header_product($id) {
        if (_is_user_login($this)) {
            $this->db->query("Delete from header_products where product_id = '" . $id . "'");
            redirect("admin/header_products");
        }
    }

    /* ========== Products ========== */
    /* ========== Purchase ========== */

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
                        "unit" => $this->input->post("unit")
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
                $this->load->view("admin/product/purchase2", $data);
            }
        } else {
            redirect('admin');
        }
    }

    function edit_purchase($id) {
        if (_is_user_login($this)) {
            $data["title"]        = $this->config->set_item('title', 'Inventory');

            if (!empty($_POST)) {
                $this->load->library('form_validation');
                $this->load->model("common_model");
                //print_r($_POST);
                $varient         = $_POST['varient_id'];
                $quantity        = $_POST['quantity'];
                $unit            = $_POST['unit'];
                $stock           = $_POST['stock'];
                $mrp             = $_POST['mrp'];
                $price           = $_POST['price'];
                $newstock        = $_POST['newstock'];
                $var_use_for        = !empty($_POST['var_use_for']) ? $_POST['var_use_for'] : '';
                $var_color          = !empty($_POST['var_color']) ? $_POST['var_color'] : '';
                $var_size           = !empty($_POST['var_size']) ? $_POST['var_size'] : '';
                $var_material       = !empty($_POST['var_material']) ? $_POST['var_material'] : '';
                
                if(!empty($quantity)){
                    $qn = count($quantity);
                    
                    //$this->db->query("delete from product_varient where product_id  = '" . $id . "'");
                    for($i=0;$i<$qn;$i++){
                        $varient_id         =   $varient[$i];
                        $old_stock          =   $stock[$i];
                        $New_stock          =   $newstock[$i];
                        $stockComplete      =   ($old_stock + $New_stock);
                        $var_use_for1       =   !empty($var_use_for[$i]) ? $var_use_for[$i] : '';   
                        $var_size1          =   !empty($var_size[$i]) ? $var_size[$i] : '';   
                        $var_color1         =   !empty($var_color[$i]) ? $var_color[$i] : '';   
                        $var_material1      =   !empty($var_material[$i]) ? $var_material[$i] : ''; 
                       // echo $stockComplete;
                        if(!empty($price[$i])){
                        //Insert into product_varient(product_id, price, qty, unit,stock_inv, mrp, date, description)
                            $purchaasr = $this->db->query("UPDATE product_varient SET price ='" . $price[$i] . "',qty = '" . $quantity[$i] . "',unit = '" . $unit[$i] . "', mrp = '" . $mrp[$i] . "',
                            stock_inv =  '" . $stockComplete . "',description = 'Stock Update By Admin', var_use_for = '" . $var_use_for1 . "', var_size = '" . $var_size1 . "', var_color = '" . $var_color1 . "', var_material = '" . $var_material1 . "' WHERE varient_id = '" . $varient_id . "'");
                            
                        }
                    }
                    
                    if($newstock>0)
                    {
                        //echo "1";
                        
                        $product_id_row = $this->db->query("select * from product_varient where varient_id='".$varient_id."'")->row();
                        if($product_id_row)
                        {
                            $product_id = $product_id_row->product_id;
                        }
                        
                        $user_info = $this->db->query("select r.*  from product_notifyme pn left join registers r on r.user_id=pn.user_id where pn.product_id='".$product_id."'")->result_array();
                        if($user_info)
                        {
                            //echo "2";
                            $productDetails = $this->db->query("select * from products where product_id='".$product_id."'")->row();
                            
                         
                            $to_mail_arr = array();
                            $i=0;
                            $to ="";
                            foreach($user_info as $user)
                            {
                                $to .= $user['user_email'].", ";                                
                            }
                            $to = rtrim($to,", ");
                            
                        $to1 ="sales@kriscent.in";
                           
                            $mail_subject = "Product Email";                            
                            
                            $message = "<html>
                                        <head>
                                        <title>Product Email</title>
                                        </head>
                                        <body>
                                        <p>Hello Dear Customer</p>
                                        <p>Thank you to keep patience for ".$productDetails->product_name.".</p>
                                        <p>This is the product you wanted to buy. ".$productDetails->product_name." you can buy now; it is available with new stock.</p>
                                        <p><a href='".base_url()."../product/".$productDetails->product_slug."'>Please click here to buy</a></p>
                                        </body>
                                        </html>
                                       ";
                            
                            $headers = "From: " . "sales@kriscent.in". "\r\n";
                            $headers .= "To: norply <sales@kriscent.in>" . "\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                            $headers .= 'Bcc: '.$to . "\r\n";
                            
                            //$result = mail($to1, $mail_subject, $message, $headers);                            
                            //die();
                        }
                    }
                }
              //  exit;
                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Add your Stock...
                                </div>');
                redirect("admin/stock");
            }
            
            $this->load->model("product_model");
            $data["purchase"] = $this->db->query("select * from product_varient where product_id =  '".$id."' ")->result();
            $data["product"] = $this->product_model->get_product_by_id($id);
            $this->load->view("admin/product/edit_purchase2", $data);
        }
       
    }

    function delete_purchase($id) {
        if (_is_user_login($this)) {
            $this->db->query("Delete from purchase where purchase_id = '" . $id . "'");
            redirect("admin/add_purchase");
        } else {
            redirect('admin');
        }
    }

    /* ========== Purchase END ========== */

    public function socity() {
        if (_is_user_login($this)) {

            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
                $this->form_validation->set_rules('socity_name', 'Socity Name', 'trim|required');
                $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required');
                $this->form_validation->set_rules('free_delivery_amount', 'Free Delivery Charge Amount', 'trim');
                $this->form_validation->set_rules('days[]', 'Delivery Days', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "")
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                        </div>');
                }
                else {
                    $days_Arr   =   $this->input->post('days');
                    $days       =   '';
                    for($i=0; $i<count($days_Arr); $i++){
                        if(empty($days)){
                            $days   =   $days_Arr[$i];
                        }
                        else{
                            $days   =  $days.', '.$days_Arr[$i];
                        }
                    }
                    $this->load->model("common_model");
                    $array = array(
                        "socity_name" => $this->input->post("socity_name"),
                        "pincode" => $this->input->post("pincode"),
                        "delivery_charge" => $this->input->post("delivery"),
                        "free_delivery_amount" => $this->input->post("free_delivery_amount"),
                        'delivery_days'   => $days

                    );
                    $this->common_model->data_insert("socity", $array);

                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request added successfully...
                                        </div>');
                    redirect("admin/socity");
                }

                $this->load->model("product_model");
                $data["socities"] = $this->product_model->get_socities();
                $this->load->view("admin/socity/list2", $data);
            }
        } else {
            redirect('admin');
        }
    }
    
    public function pincode() {
        if (_is_user_login($this)) {

            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
                //$this->form_validation->set_rules('socity_name', 'Socity Name', 'trim|required');
                $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required');
                $this->form_validation->set_rules('free_delivery_amount', 'Free Delivery Charge Amount', 'trim');
                $this->form_validation->set_rules('days[]', 'Delivery Days', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "")
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                        </div>');
                }
                else {
                    $days_Arr   =   $this->input->post('days');
                    $days       =   '';
                    for($i=0; $i<count($days_Arr); $i++){
                        if(empty($days)){
                            $days   =   $days_Arr[$i];
                        }
                        else{
                            $days   =  $days.', '.$days_Arr[$i];
                        }
                    }
                    $this->load->model("common_model");
                    $array = array(
                       // "socity_name" => $this->input->post("socity_name"),
                        "pincode" => $this->input->post("pincode"),
                        "delivery_charge" => $this->input->post("delivery"),
                        "free_delivery_amount" => $this->input->post("free_delivery_amount"),
                        'delivery_days'   => $days

                    );
                    //$this->common_model->data_insert("socity", $array);
                    
                    $this->common_model->data_insert("pincode", $array);

                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request added successfully...
                                        </div>');
                    //redirect("admin/socity");
                    redirect("admin/pincode");
                }

                $this->load->model("product_model");
               //$data["socities"] = $this->product_model->get_socities();
                $data["pincodes"] = $this->product_model->get_pincodes();
               // $this->load->view("admin/socity/list2", $data);
                $this->load->view("admin/pincode/list2", $data);
                
                
            }
        } else {
            redirect('admin');
        }
    }
    
    public function edit_socity($id) {
        if (_is_user_login($this)) {

            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
                $this->form_validation->set_rules('socity_name', 'Socity Name', 'trim|required');
                $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required');
                 $this->form_validation->set_rules('days[]', 'Delivery Days', 'trim|required');
                $this->form_validation->set_rules('free_delivery_amount', 'Free Delivery Charge Amount', 'trim');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "")
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                }
                else {
                    $days_Arr   =   $this->input->post('days');
                    $days       =   '';
                    for($i=0; $i<count($days_Arr); $i++){
                        if(empty($days)){
                            $days   =   $days_Arr[$i];
                        }
                        else{
                            $days   =  $days.', '.$days_Arr[$i];
                        }
                    }
                    $this->load->model("common_model");
                    $array = array(
                        "socity_name" => $this->input->post("socity_name"),
                        "pincode" => $this->input->post("pincode"),
                        "delivery_charge" => $this->input->post("delivery"),
                        "free_delivery_amount" => $this->input->post("free_delivery_amount"),
                        'delivery_days'   => $days
                    );
                    $this->common_model->data_update("socity", $array, array("socity_id" => $id));

                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/socity");
                }

                $this->load->model("product_model");
                $data["socity"] = $this->product_model->get_socity_by_id($id);
                $this->load->view("admin/socity/edit2", $data);
            }
        } else {
            redirect('admin');
        }
    }
    
    public function edit_pincode($id) {
        if (_is_user_login($this)) {

            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
//                $this->form_validation->set_rules('socity_name', 'Socity Name', 'trim|required');
                $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required');
                 $this->form_validation->set_rules('days[]', 'Delivery Days', 'trim|required');
                $this->form_validation->set_rules('free_delivery_amount', 'Free Delivery Charge Amount', 'trim');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "")
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                }
                else {
                    $days_Arr   =   $this->input->post('days');
                    $days       =   '';
                    for($i=0; $i<count($days_Arr); $i++){
                        if(empty($days)){
                            $days   =   $days_Arr[$i];
                        }
                        else{
                            $days   =  $days.', '.$days_Arr[$i];
                        }
                    }
                    $this->load->model("common_model");
                    $array = array(
//                        "socity_name" => $this->input->post("socity_name"),
                        "pincode" => $this->input->post("pincode"),
                        "delivery_charge" => $this->input->post("delivery"),
                        "free_delivery_amount" => $this->input->post("free_delivery_amount"),
                        'delivery_days'   => $days
                    );
//                    $this->common_model->data_update("socity", $array, array("socity_id" => $id));
                    $this->common_model->data_update("pincode", $array, array("pincode_id" => $id));

                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    //redirect("admin/socity");
                    redirect("admin/pincode");
                }

                $this->load->model("product_model");
//                $data["socity"] = $this->product_model->get_socity_by_id($id);
                $data["pincode"] = $this->product_model->get_pincode_by_id($id);
                
                //$this->load->view("admin/socity/edit2", $data);
                $this->load->view("admin/pincode/edit2", $data);
            }
        } else {
            redirect('admin');
        }
    }

    public function delete_socity($id) {
        if (_is_user_login($this)) {
            $this->db->query("Delete from socity where socity_id = '" . $id . "'");
            redirect("admin/socity");
        } else {
            redirect('admin');
        }
    }
    
    public function delete_pincode($id) {
        if (_is_user_login($this)) {
            $this->db->query("Delete from pincode where pincode_id = '" . $id . "'");
            redirect("admin/pincode");
        } else {
            redirect('admin');
        }
    }
    ////////////Enquiry ////////////////
    public function enquiry() {
        if (_is_user_login($this)) {

            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
                $this->form_validation->set_rules('socity_name', 'Socity Name', 'trim|required');
                $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required');

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
                        "socity_name" => $this->input->post("socity_name"),
                        "pincode" => $this->input->post("pincode"),
                        "delivery_charge" => $this->input->post("delivery")
                    );
                    $this->common_model->data_insert("socity", $array);

                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request added successfully...
                                        </div>');
                    redirect("admin/socity");
                }

                $this->load->model("product_model");
                $data["enquiries"] = $this->product_model->get_enquiries();
                $this->load->view("admin/enquiry/list2", $data);
            }
        } else {
            redirect('admin');
        }
    }
    
    public function product_reviews() {
        if (_is_user_login($this)) {
            
//            if (isset($_POST)) {
//                echo "alert('post')";
//            }
            
            $this->load->model("product_model");
            $data["product_reviews"] = $this->product_model->get_product_reviews();
            $this->load->view("admin/product_reviews/product_reviews_list", $data);
        } else {
            redirect('admin');
        }
    }    
    
    
    public function disable_review($review_id) {
        if (_is_user_login($this)) {           
            
            $this->load->model("product_model");
            $this->product_model->update_disable_product_reviews($review_id);
            
            $data["product_reviews"] = $this->product_model->get_product_reviews();
            $this->load->view("admin/product_reviews/product_reviews_list", $data);
            redirect('admin/product_reviews');
        } else {
            redirect('admin');
        }
    }
    
    public function enable_review($review_id) {
        if (_is_user_login($this)) {           
            
            $this->load->model("product_model");
            $this->product_model->update_enable_product_reviews($review_id);
            
            $data["product_reviews"] = $this->product_model->get_product_reviews();
            $this->load->view("admin/product_reviews/product_reviews_list", $data);
            redirect('admin/product_reviews');
        } else {
            redirect('admin');
        }
    }
    
    public function delete_review($review_id) {
        if (_is_user_login($this)) {           
            
            $this->load->model("product_model");
            $this->product_model->update_delete_product_reviews($review_id);
            
            $data["product_reviews"] = $this->product_model->get_product_reviews();
            $this->load->view("admin/product_reviews/product_reviews_list", $data);
            redirect('admin/product_reviews');
        } else {
            redirect('admin');
        }
    }
    
    

    ///////////////Delete Enquiry////////////////
    public function delete_enquiry($id) {
        if (_is_user_login($this)) {
            $this->db->query("Delete from tbl_enquiry where id = '" . $id . "'");
            redirect("admin/enquiry");
        } else {
            redirect('admin');
        }
    }



    public function city() {
        if (_is_user_login($this)) {


            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('city_name', 'City Name', 'trim|required');

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
                        "city_name" => $this->input->post("city_name")
                    );
                    $this->common_model->data_insert("city", $array);

                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/city");
                }
            }

            $ct = $this->db->query("select * from `city`");
            $data["cities"] = $ct->result();
            $this->load->view("admin/socity/city_list", $data);
        } else {
            redirect("admin");
        }
    }

    public function delete_city($id) {
        if (_is_user_login($this)) {
            $this->db->query("Delete from city where city_id = '" . $id . "'");
            redirect("admin/city");
        } else {
            redirect('admin');
        }
    }

    public function declared_rewards() {
        if (_is_user_login($this)) {

            $this->load->library('form_validation');
            $this->load->model("product_model");



            $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required');

            if (!$this->form_validation->run() == FALSE) {

                $point = array(
                    'point' => $this->input->post('delivery')
                );

                $this->product_model->update_reward($point);


                if ($this->form_validation->error_string() != "")
                    $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                        </div>');
            }

            $data['rewards'] = $this->product_model->rewards_value();
            //print_r( $data['rewards']);
            $this->load->view("admin/declared_rewards/edit2", $data);
        }
        else {
            redirect('admin');
        }
    }

 

    function registers() {
        if (_is_user_login($this)) {
            $this->load->model("product_model");
            $users = $this->product_model->get_all_users();
            $data["users"]        = $users;
            $data["title"]        = $this->config->set_item('title', 'Register');
            $this->load->view("admin/allusers2", $data);
        } else {
            redirect('admin');
        }
    }

    /* ========== Page app setting ========= */

    public function addpage_app() {
        if (_is_user_login($this)) {

            $data["error"] = "";
            $data["active"] = "addpageapp";

            if (isset($_REQUEST["addpageapp"])) {
                //echo "dsfsdf"; die;
                $this->load->library('form_validation');
                $this->form_validation->set_rules('page_title', 'Page  Title', 'trim|required');
                $this->form_validation->set_rules('page_descri', 'Page Description', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "")
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                }
                else {
                    $this->load->model("page_app_model");
                    $this->page_app_model->add_page();
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Page added successfully...</div>');
                    redirect('admin/allpageapp');
                }
            }
            $this->load->view('admin/page_app/addpage_app', $data);
        } else {
            redirect('admin');
        }
    }

    public function allpageapp() {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data["active"] = "allpage";

            $this->load->model("page_app_model");
            $data["allpages"] = $this->page_app_model->get_pages();

            $this->load->view('admin/page_app/allpage_app2', $data);
        } else {
            redirect('admin');
        }
    }

    public function editpage_app($id) {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data["active"] = "allpage";

            $this->load->model("page_app_model");
            $data["onepage"] = $this->page_app_model->one_page($id);

            if (isset($_REQUEST["savepageapp"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('page_title', 'Page Title', 'trim|required');
                $this->form_validation->set_rules('page_id', 'Page Id', 'trim|required');
                $this->form_validation->set_rules('page_descri', 'Page Description', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "")
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                }
                else {
                    $this->load->model("page_app_model");
                    $this->page_app_model->set_page();
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your page saved successfully...</div>');
                    redirect('admin/allpageapp');
                }
            }
            $this->load->view('admin/page_app/editpage_app2', $data);
        } else {
            redirect('admin');
        }
    }

    public function deletepageapp($id) {
        if (_is_user_login($this)) {

            $this->db->delete("pageapp", array("id" => $id));
            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your page deleted successfully...
                                    </div>');
            redirect('admin/allpage_app');
        } else {
            redirect('admin');
        }
    }

    /* ========== End page page setting ======== */

    public function setting() {
        if (_is_user_login($this)) {
            $this->load->model("setting_model");
            $data["settings"] = $this->setting_model->get_settings();

            $this->load->view("admin/setting/settings2", $data);
        } else {
            redirect('admin');
        }
    }

    public function edit_settings($id) {
        if (_is_user_login($this)) {

            if (isset($_POST)) {
                $this->load->library('form_validation');

                $this->form_validation->set_rules('value', 'Amount', 'trim|required');
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
                        "title" => $this->input->post("title"),
                        "value" => $this->input->post("value")
                    );

                    $this->common_model->data_update("settings", $array, array("id" => $id));

                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/setting");
                }

                $this->load->model("setting_model");
                $data["editsetting"] = $this->setting_model->get_setting_by_id($id);
                $this->load->view("admin/setting/edit_settings2", $data);
            }
        } else {
            redirect('admin');
        }
    }
    
    public function theme_setting($id) {
       //print_r($_POST); exit;
       if($id == 1){
           $this->config->set_item('title', "App Setting");
           $theme   = "app";
       }
       elseif($id == 2){
           $this->config->set_item('title', "Website Setting");
           $theme   = "web";
       }
        elseif($id == 3){
            $this->config->set_item('title', "Backend Setting");
           $theme   = "back";
       }
       
        if (_is_user_login($this)) {
            $this->load->model("setting_model");
            if(!empty($_POST)){
                $setting    =   $this->input->post('setting');
                foreach($setting as $row => $value){
                    $data   =   array('meta_value' => $value);
                    $this->db->where('meta_key',$row);
                    $this->db->where('meta_type',$theme);
                    $this->db->update('theme_color_setting',$data);
                   // print_r($this->db->last_query()); exit;
                }
            }
            
            $data["settings"] = $this->setting_model->get_themesettings($theme);

            $this->load->view("admin/setting/theme_setting", $data);
        } else {
            redirect('admin');
        }
    }


    public function stock() {
        if (_is_user_login($this)) {
            $data['title'] = $this->config->set_item('title', 'Inventory');
            $this->load->model("product_model");
            $data["stock_list"] = $this->product_model->get_leftstock();
            $this->load->view("admin/product/stock2", $data);
        } else {
            redirect('admin');
        }
    }

    /* ========== End page page setting ======== */

    function testnoti() {
        $token = "dLmBHiGL_6g:APA91bGp5L_mZ0NwPZiihxIDVmo-d-UV05fvmcIDzDiyJ82ztCelmFl4oFRD2hEOPT2lE--ze-yH6Nac6KxbHspYWSQw4mmw8AZ-3HRrwD_crCO1o3p9mRu9WvOOsaw_vvScMnIIv2np";
    }

    function notification() {
        if (_is_user_login($this)) {

            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('title', 'Title', 'trim|required');
                $this->form_validation->set_rules('image_url', 'Image Url', 'trim|required');
                $this->form_validation->set_rules('descri', 'Description', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "")
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                }else {
                    if(!empty($this->config->item('firebase_key'))){
                         $title     = $this->input->post("title");
                         $messages   = $this->input->post("descri");
                         $image_url = $this->input->post("image_url");
                        ///$message["created_at"] = date("Y-m-d h:i:s");
                        //$msg = $this->input->post("descri");
    
                        $message = array('title' => $title, 'body' => $messages, 'sound' => 'Default', 'image' => $image_url);
                        $dataInsert = array('title' => $title, 'message' => $messages, 'sound' => 'Default', 'image' => $image_url,'create_date' => date('Y-m-d H:i:s'), 'create_by' => $this->session->userdata('user_id'), 'user_id' => '0');
                        $this->db->insert('notification', $dataInsert);
                        $this->load->helper('gcm_helper');
                        $gcm = new GCM();
    
                        $q = $this->db->query("Select user_gcm_code from registers");
                        $registers = $q->result();
                        foreach ($registers as $regs) {
                            if ($regs->user_gcm_code != "") {
                                $registatoin_ids[] = $regs->user_gcm_code;
                                
                            }
                        }
                        // Android Multi users Send Notification
                        
                        if(count($registatoin_ids) > 1000){
                            $chunk_array    = array_chunk($registatoin_ids,1000);
                            $notification_id    =   '';
                            foreach($chunk_array as $chunk){
                                if(empty($notification_id)){
                                        $notification_id    =   $chunk;
                                }    
                                else{
                                    $notification_id    =   $notification_id.','.$chunk;
                                }
                            }
                            $result = $gcm->send_notification($notification_id, $message, "android", $this->config->item('firebase_key'));
                        }
                        else{ // Android Single users Send Notification
                            if(!empty($registatoin_ids)){
                                $notification_id    =   '';
                                foreach($registatoin_ids as $chunk){
                                    if(empty($notification_id)){
                                        $notification_id    =   $chunk;
                                    }    
                                    else{
                                        $notification_id    =   $notification_id.','.$chunk;
                                    }
                                }
                                    $result = $gcm->send_notification($notification_id, $message, "android", $this->config->item('firebase_key'));
                                    
                            }
                        }
                    }
                    else{
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> Please Firstly firebase key fill in integration setting.
                                    </div>');
                    }
                    
            
                    redirect("admin/notification");
                }
               // exit;
                $this->load->view("admin/product/notification2");
            }
        } else {
            redirect('admin');
        }
    }

    function time_slot() {
        if (_is_user_login($this)) {
            $this->load->model("time_model");
            $timeslot = $this->time_model->get_time_slot();

            $this->load->library('form_validation');
            $this->form_validation->set_rules('opening_time', 'Opening Hour', 'trim|required');
            $this->form_validation->set_rules('closing_time', 'Closing Hour', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                if ($this->form_validation->error_string() != "")
                    $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
            }
            else {
                if (empty($timeslot)) {
                    $q = $this->db->query("Insert into time_slots(opening_time,closing_time,time_slot) values('" . date("H:i:s", strtotime($this->input->post('opening_time'))) . "','" . date("H:i:s", strtotime($this->input->post('closing_time'))) . "','" . $this->input->post('interval') . "')");
                } else {
                    $q = $this->db->query("Update time_slots set opening_time = '" . date("H:i:s", strtotime($this->input->post('opening_time'))) . "' ,closing_time = '" . date("H:i:s", strtotime($this->input->post('closing_time'))) . "',time_slot = '" . $this->input->post('interval') . "' ");
                }
            }

            $timeslot = $this->time_model->get_time_slot();
            $this->load->view("admin/timeslot/edit2", array("schedule" => $timeslot));
        } else {
            redirect('admin');
        }
    }
    
    function billing_setting() {
        if (_is_user_login($this)) {
            $this->load->model("time_model");
            $this->load->library('form_validation');
            if(!empty($_POST)){
                
                    $this->load->model("time_model");
                    $billingslot = $this->time_model->get_billing_details();
                    if ($_FILES["logo"]["size"] > 0) {
                        $config['upload_path'] = './uploads/company/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
    
                        if (!$this->upload->do_upload('logo')) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $img_data = $this->upload->data();
                            $logo = $img_data['file_name'];
                        }
                    }
                
                    if (empty($billingslot)) {
                        $q = $this->db->query("Insert into billing_details(name,logo,gstin,address,mobile,email,tax_slab,status) 
                        values('".$this->input->post('name')."',
                        '".$logo."',
                        '".$this->input->post('gstin')."',
                        '".$this->input->post('address')."',
                        '".$this->input->post('mobile')."',
                        '".$this->input->post('email')."',
                        '".$this->input->post('tax_slab')."',
                        '1') ");
                    } else {
                        $q = $this->db->query("Update billing_details 
                        set 
                        name = '" . $this->input->post('name') . "' ,
                        logo = '" . $logo . "',
                        gstin = '" . $this->input->post('gstin') . "' ,
                        address = '" . $this->input->post('address') . "' ,
                        mobile = '" . $this->input->post('mobile') . "',
                        email = '" . $this->input->post('email') . "' ,
                        tax_slab = '" . $this->input->post('tax_slab') . "',
                        status = '1'
                        ");
                    }
                }
            

            $billingslot = $this->time_model->get_billing_details();
            $this->load->view("admin/billing/biiling_details", array("details" => $billingslot));
        } else {
            redirect('admin');
        }
    }
    function mail_template_setting() {
        if (_is_user_login($this)) {
            $this->load->model("time_model");
            $this->load->library('form_validation');
            if(!empty($_POST)){
                
                    $this->load->model("time_model");
                    $template  = $this->time_model->get_mailtemplate_details();
                   
                    if (empty($template)) {
                        $type = $this->input->post('type');
                        $q = $this->db->query("Insert into mail_template(type,description,status) 
                        values('".$this->input->post('type')."',
                       
                        '".$this->input->post('description')."',
                        '1') ");
                    } else {
                        $type1 = $this->input->post('type1');
                        $type2 = $this->input->post('type2');
                        $type3 = $this->input->post('type3');
                        $type4 = $this->input->post('type4');
                        $type5 = $this->input->post('type5');
                        $type6 = $this->input->post('type6');
                        $type7 = $this->input->post('type7');
                        $type8 = $this->input->post('type8');
                        if($type1 == 1){
                            $q = $this->db->query("Update mail_template 
                            set 
                            description = '" . $this->input->post('description1') . "' 
                             where type = '1'
                            "); 
                        } if($type2 == 2){
                            $q = $this->db->query("Update mail_template 
                            set 
                            description = '" . $this->input->post('description2') . "' 
                             where type = '2'
                            "); 
                        } if($type3 == 3){
                            $q = $this->db->query("Update mail_template 
                            set 
                            description = '" . $this->input->post('description3') . "' 
                             where type = '3'
                            "); 
                        } if($type4 == 4){
                            $q = $this->db->query("Update mail_template 
                            set 
                            description = '" . $this->input->post('description4') . "' 
                             where type = '4'
                            "); 
                        } if($type5 == 5){
                            $q = $this->db->query("Update mail_template 
                            set 
                            description = '" . $this->input->post('description5') . "' 
                            where type = '5' 
                            "); 
                        } if($type6 == 6){
                            $q = $this->db->query("Update mail_template 
                            set 
                            description = '" . $this->input->post('description6') . "' 
                            
                            where type = '6' 
                            "); 
                        }
                        if($type7 == 7){
                            $q = $this->db->query("Update mail_template 
                            set 
                            description = '" . $this->input->post('description7') . "' 
                            
                            where type = '7' 
                            "); 
                        }
                        if($type8 == 8){
                            $q = $this->db->query("Update mail_template 
                            set 
                            description = '" . $this->input->post('description8') . "' 
                            
                            where type = '8' 
                            "); 
                        }
                       
                    }
                }
            
            $types = array(
                '1'=>'Order Confirmation',
                '2'=>'Order Dispatch',
                '3'=>'Order Delivery',
                '4'=>'Order Cancel',
                '5'=>'Order Refund',
                '6'=>'Sign Up',
                '7'=>'Send Order',
                '8'=>'Forgot Password',
                );
            //$data['mailslot'] = $this->time_model->get_mailtemplate_details();
            $data['type'] = $types;
            $this->load->view("admin/setting/mail_template_setting", $data);
        } else {
            redirect('admin');
        }
    }
    function sms_template_setting() {
        if (_is_user_login($this)) {
            $this->load->model("time_model");
            $this->load->library('form_validation');
            if(!empty($_POST)){
                    $this->load->model("time_model");
                    $type1 = $this->input->post('type1');
                    $type2 = $this->input->post('type2');
                    $type3 = $this->input->post('type3');
                    $type4 = $this->input->post('type4');
                    $type5 = $this->input->post('type5');
                    $type6 = $this->input->post('type6');
                    $type7 = $this->input->post('type7');
                    $type8 = $this->input->post('type8');
                    if($type1 == 1){
                        $q = $this->db->query("Update sms_template 
                        set 
                        description = '" . $this->input->post('description1') . "' 
                         where type = '1'
                        "); 
                    } if($type2 == 2){
                        $q = $this->db->query("Update sms_template 
                        set 
                        description = '" . $this->input->post('description2') . "' 
                         where type = '2'
                        "); 
                    } if($type3 == 3){
                        $q = $this->db->query("Update sms_template 
                        set 
                        description = '" . $this->input->post('description3') . "' 
                         where type = '3'
                        "); 
                    } if($type4 == 4){
                        $q = $this->db->query("Update sms_template 
                        set 
                        description = '" . $this->input->post('description4') . "' 
                         where type = '4'
                        "); 
                    } if($type5 == 5){
                        $q = $this->db->query("Update sms_template 
                        set 
                        description = '" . $this->input->post('description5') . "' 
                        where type = '5' 
                        "); 
                    } if($type6 == 6){
                        $q = $this->db->query("Update sms_template 
                        set 
                        description = '" . $this->input->post('description6') . "' 
                        
                        where type = '6' 
                        "); 
                    } if($type7 == 7){
                        $q = $this->db->query("Update sms_template 
                        set 
                        description = '" . $this->input->post('description7') . "' 
                        
                        where type = '7' 
                        "); 
                    } if($type8 == 8){
                        $q = $this->db->query("Update sms_template 
                        set 
                        description = '" . $this->input->post('description8') . "' 
                        
                        where type = '8' 
                        "); 
                    }
                       
                    
                }
            
            $types = array(
                '1'=>'Order Confirmation',
                '2'=>'Order Dispatch',
                '3'=>'Order Delivery',
                '4'=>'Order Cancel',
                '5'=>'Order Refund',
                '6'=>'Sign Up',
                '7'=>'Send Order',
                '8'=>'Forgot Password',
                );
            //$data['mailslot'] = $this->time_model->get_mailtemplate_details();
            $data['type'] = $types;
            $this->load->view("admin/setting/sms_template_setting", $data);
        } else {
            redirect('admin');
        }
    }
    function seo_setting() {
        if (_is_user_login($this)) {
            $this->load->model("time_model");
            $this->load->library('form_validation');
            if(!empty($_POST)){
                    $this->load->model("time_model");
                    $seo  = $this->db->query("Select * from seo_setting limit 1 ")->row();
                    if(empty($seo)){
                        $q = $this->db->query("Insert into seo_setting(title,description) 
                        values('".$this->input->post('title')."',
                        '".$this->input->post('description')."'
                        ) ");
                    }else{
                        $q              = $this->db->query("Update seo_setting 
                        set 
                        title           = '" . $this->input->post('title') . "' ,
                        description     = '" . $this->input->post('description') . "' ,
                        keywords        = '" . $this->input->post('keywords') . "' ,
                        amp             = '" . $this->input->post('amp') . "' ,
                        microformats    = '" . $this->input->post('microformats') . "' 
                        where id        = '1'
                        "); 
                    }
                }
            
            $types = array(
                '1'=>'Order Confirmation',
                '2'=>'Order Dispatch',
                '3'=>'Order Delivery',
                '4'=>'Order Cancel',
                '5'=>'Order Refund',
                '6'=>'Sign Up',
                );
            //$data['mailslot'] = $this->time_model->get_mailtemplate_details();
            $data['type'] = $types;
            $this->load->view("admin/setting/seo_setting", $data);
        } else {
            redirect('admin');
        }
    }
    function popup_setting() {
        if (_is_user_login($this)) {
            $this->load->library('form_validation');
            if(!empty($_POST)){
                $q = $this->db->query("UPDATE tbl_popup SET title ='".$this->input->post('title')."' , desc_type = '".$this->input->post('desc_type')."' , `desc` = '".base64_encode($this->input->post('description'))."' WHERE id='1'  ");
            }
            $data['data'] = $this->db->query("Select * from tbl_popup where id = 1 ")->row();
            $this->load->view("admin/setting/popup_setting", $data);
        } else {
            redirect('admin');
        }
    }
    
    function rewards_setting() {
        if (_is_user_login($this)) {
            $this->load->library('form_validation');
            if(!empty($_POST)){
				$is_reward = $this->input->post('is_reward');
				if(!empty($is_reward)){
					$is_reward = 1;	
				}
				else{
					$is_reward = 0;	
				}
				
                $q = $this->db->query("UPDATE tbl_reward_setting SET point_on_sale ='".$this->input->post('point_on_sale')."' , point_to_wallet = '".$this->input->post('point_to_wallet')."' , amount_on_sale ='".$this->input->post('amount_on_sale')."' , amount_to_wallet = '".$this->input->post('amount_to_wallet')."' , min_point_transfer = '".$this->input->post('min_point_transfer')."' , `is_reward` = '".$is_reward."' WHERE id='1'  ");
            }
            $data['data'] = $this->db->query("Select * from tbl_reward_setting where id = 1 ")->row();
            $this->load->view("admin/setting/rewards_setting", $data);
        } else {
            redirect('admin');
        }
    }
    
    public function rewards() {
        if (_is_user_login($this)) {
            $data = array();
            $this->load->model("product_model");
            
            $data["rewards"] = $this->product_model->get_rewards();
            $data["title"]        = $this->config->set_item('title', 'Rewards');
            $this->load->view("admin/rewards", $data);
        } else {
            redirect("admin");
        }
    }
    
    public function reward_history() {
        if (_is_user_login($this)) {
            $data = array();
            $this->load->model("product_model");
            
            $data["rewards"] = $this->product_model->get_reward_history();
            $data["title"]   = $this->config->set_item('title', 'Rewards');
            $this->load->view("admin/reward_history", $data);
        } else {
            redirect("admin");
		}
    }
    
    function closing_hours() {
        if (_is_user_login($this)) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
            $this->form_validation->set_rules('opening_time', 'Start Hour', 'trim|required');
            $this->form_validation->set_rules('closing_time', 'End Hour', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                if ($this->form_validation->error_string() != "")
                    $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                        </div>');
            }
            else {
                $array = array("date" => date("Y-m-d", strtotime($this->input->post("date"))),
                    "from_time" => date("H:i:s", strtotime($this->input->post("opening_time"))),
                    "to_time" => date("H:i:s", strtotime($this->input->post("closing_time")))
                );
                $this->db->insert("closing_hours", $array);
            }

            $this->load->model("time_model");
            $timeslot = $this->time_model->get_closing_date(date("Y-m-d"));
            $this->load->view("admin/timeslot/closing_hours2", array("schedule" => $timeslot));
        } else {
            redirect('admin');
        }
    }

    function delete_closing_date($id) {
        if (_is_user_login($this)) {
            $this->db->query("Delete from closing_hours where id = '" . $id . "'");
            redirect("admin/closing_hours");
        } else {
            redirect('admin');
        }
    }

    public function addslider() {
        if (_is_user_login($this)) {

            $data["error"] = "";
            $data["active"] = "addslider";

            if (isset($_REQUEST["addslider"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name'])) {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }

                if ($this->form_validation->run() == FALSE) {
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                } else {
                    $add = array(
                        "slider_title" => $this->input->post("slider_title"),
                        "slider_status" => $this->input->post("slider_status"),
                        "slider_url" => $this->input->post("slider_url"),
                        "sub_cat" => $this->input->post("sub_cat")
                    );
                    //echo $_FILES["slider_img"]["size"] .' >>> '.$this->config->item('file_size'); exit;
                    if ($_FILES["slider_img"]["size"] <= $this->config->item('slider_file_size') && $_FILES["slider_img"]["size"] > 0) {
                        $config['upload_path'] = './uploads/sliders/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('slider_img')) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $img_data = $this->upload->data();
                            $add["slider_image"] = $img_data['file_name'];
                        }
                    }
                    else{
                            $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Error!</strong> Slider File size is greater then '.($this->config->item('slider_file_size')/1024).' KB...
                                    </div>');
                            redirect('admin/addslider');
                    }

                    $this->db->insert("slider", $add);

                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    redirect('admin/addslider');
                }
            }
            $this->load->view('admin/slider/addslider2', $data);
        } else {
            redirect('admin');
        }
    }

    public function listslider() {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data["active"] = "listslider";
            $this->load->model("slider_model");
            $data["allslider"] = $this->slider_model->get_slider();
            $this->load->view('admin/slider/listslider2', $data);
        } else {
            redirect('admin');
        }
    }

    public function add_Banner() {
        if (_is_user_login($this)) {

            $data["error"] = "";
            $data["active"] = "addslider";

            if (isset($_REQUEST["addslider"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name'])) {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }

                if ($this->form_validation->run() == FALSE) {
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                } else {
                    $this->load->model("slider_model");
                    $add = array(
                        "slider_title" => $this->input->post("slider_title"),
                        "slider_status" => $this->input->post("slider_status"),
                        "slider_url" => $this->input->post("slider_url"),
                        "sub_cat" => $this->input->post("sub_cat")
                    );

                    if ($_FILES["slider_img"]["size"] <= $this->config->item('slider_file_size') && $_FILES["slider_img"]["size"] > 0) {
                        $config['upload_path'] = './uploads/sliders/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('slider_img')) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $img_data = $this->upload->data();
                            $add["slider_image"] = $img_data['file_name'];
                        }
                    }
                    else{
                        $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Error!</strong> Banner File size is greater then '.($this->config->item('slider_file_size')/1024).' KB...
                                    </div>');
                        redirect('admin/add_Banner');
                    }

                    $this->db->insert("banner", $add);

                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    redirect('admin/add_Banner');
                }
            }
            $this->load->view('admin/banner/addslider2', $data);
        } else {
            redirect('admin');
        }
    }

    public function banner() {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data["active"] = "listslider";
            $this->load->model("slider_model");
            $data["allslider"] = $this->slider_model->banner();
            $this->load->view('admin/banner/listslider2', $data);
        } else {
            redirect('admin');
        }
    }

    public function edit_banner($id) {
        if (_is_user_login($this)) {

            $this->load->model("slider_model");
            $data["slider"] = $this->slider_model->get_banner($id);

            $data["error"] = "";
            $data["active"] = "listslider";
            if (isset($_REQUEST["saveslider"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "")
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                }
                else {
                    $edit = array(
                        "slider_title" => $this->input->post("slider_title"),
                        "slider_status" => $this->input->post("slider_status"),
                        "slider_url" => $this->input->post("slider_url"),
                        "sub_cat" => $this->input->post("sub_cat")
                    );
                    if ($_FILES["slider_img"]["size"] <= $this->config->item('slider_file_size') && $_FILES["slider_img"]["size"] > 0) {
                        $config['upload_path'] = './uploads/sliders/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
            
                        if (!$this->upload->do_upload('slider_img')) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $img_data = $this->upload->data();
                            $edit["slider_image"] = $img_data['file_name'];
                        } 
                    }
                    else{
                        $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Error!</strong> Banner File size is greater then '.($this->config->item('slider_file_size')/1024).' KB...
                                    </div>');
                        redirect('admin/edit_banner/'.$id);
                    }
                    $this->slider_model->edit_banner($edit, $id);
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('admin/banner');
                }
            }
            $this->load->view('admin/banner/editslider2', $data);
        } else {
            redirect('admin');
        }
    }

    public function editslider($id) {
        if (_is_user_login($this)) {

            $this->load->model("slider_model");
            $data["slider"] = $this->slider_model->get_slider_by_id($id);

            $data["error"] = "";
            $data["active"] = "listslider";
            if (isset($_REQUEST["saveslider"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "")
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                }
                else {
                    $this->load->model("slider_model");
                    $edit = array(
                        "slider_title" => $this->input->post("slider_title"),
                        "slider_status" => $this->input->post("slider_status"),
                        "slider_url" => $this->input->post("slider_url"),
                        "sub_cat" => $this->input->post("sub_cat")
                    );
            
                    if ($_FILES["slider_img"]["size"] <= $this->config->item('slider_file_size') && $_FILES["slider_img"]["size"] > 0) {
                        $config['upload_path'] = './uploads/sliders/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
            
                        if (!$this->upload->do_upload('slider_img')) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $img_data = $this->upload->data();
                            $edit["slider_image"] = $img_data['file_name'];
                        }
                    }
                    else{
                            $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Error!</strong> Slider File size is greater then '.($this->config->item('slider_file_size')/1024).' KB...
                                    </div>');
                            redirect('admin/editslider/'.$id);
                    }
                    $this->slider_model->edit_slider($edit,$id);
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('admin/listslider');
                }
            }
            $this->load->view('admin/slider/editslider2', $data);
        } else {
            redirect('admin');
        }
    }

    public function deleteslider($id) {

        if (_is_user_login($this)) {
            $data = array();
            $this->load->model("slider_model");
            $slider = $this->slider_model->get_slider_by_id($id);
            if ($slider) {
                $this->db->query("UPDATE slider SET trash='1' where id = '" . $slider->id . "'");
               // unlink("uploads/sliders/" . $slider->slider_image);
                redirect("admin/listslider");
            }
        } else {
            redirect('admin');
        }
    }

    public function delete_banner($id) {
        if (_is_user_login($this)) {
            $data = array();
            $this->db->query("UPDATE banner SET trash='1' where id = '" . $id . "'");
            //unlink("uploads/sliders/" . $slider->slider_image);
            redirect("admin/banner");
        } else {
            redirect('admin');
        }
    }

    public function listimages() {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data["active"] = "listimages";
            $this->load->model("slider_model");
            $data["allimages"] = $this->slider_model->get_images();
            $this->load->view('admin/images/listimages', $data);
        } else {
            redirect('admin');
        }
    }

    public function addimage() {
        if (_is_user_login($this)) {

            $data["error"] = "";
            $data["active"] = "addimages";

            if (isset($_REQUEST["addimages"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('addimages', 'Image', 'trim|required');
                if (empty($_FILES['image']['name'])) {
                    $this->form_validation->set_rules('image', 'Image', 'required');
                }

                if ($this->form_validation->run() == FALSE) {
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                } else {
                    $add = array(
                        "status" => 1,
                    );
                    //echo $_FILES["slider_img"]["size"] .' >>> '.$this->config->item('file_size'); exit;
                    if ($_FILES["image"]["size"] <= $this->config->item('images_file_size') && $_FILES["image"]["size"] > 0) {
                        $path = './uploads/images/';
						if (!is_dir($path)){
							@mkdir($path, 0777, true);
						}
                        $config['upload_path'] = $path;
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('image')) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $img_data = $this->upload->data();
                            $add["image"] = $img_data['file_name'];
                        }
                    }
                    else{
                            $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Error!</strong> Image size is greater then '.($this->config->item('images_file_size')/1024).' KB...
                                    </div>');
                            redirect('admin/addimage');
                    }
					
					
					$this->db->set($add);
                    $this->db->insert("images", $add);

                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Image added successfully...
                                    </div>');
                    redirect('admin/addimage');
                }
            }
            $this->load->view('admin/images/addimage', $data);
        } else {
            redirect('admin');
        }
    }

    public function editimage($id) {
        if (_is_user_login($this)) {

            $this->load->model("slider_model");

            $data["error"] = "";
            $data["active"] = "editimages";
            if (isset($_REQUEST["saveimage"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('saveimage', 'Image', 'trim|required');
				if (empty($_FILES['image']['name'])) {
                    $this->form_validation->set_rules('image', 'Image', 'required');
                }
                if ($this->form_validation->run() == FALSE) {
					
                    if ($this->form_validation->error_string() != "")
                        $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Error!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                }
                else {
					
                    $this->load->model("slider_model");
                    $edit = array(
                        // "status" => 1,
                    );
            
                    if ($_FILES["image"]["size"] <= $this->config->item('images_file_size') && $_FILES["image"]["size"] > 0) {
						$path = './uploads/images/';
						if (!is_dir($path)){
							@mkdir($path, 0777, true);
						}
                        $config['upload_path'] = $path;
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
            
                        if (!$this->upload->do_upload('image')) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $img_data = $this->upload->data();
                            $edit["image"] = $img_data['file_name'];
                        }
                    }
                    else{
                            $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Error!</strong> Images size is greater then '.($this->config->item('images_file_size')/1024).' KB...
                                    </div>');
                            redirect('admin/editimage/'.$id);
                    }
					$this->db->set($edit);
                    $this->slider_model->edit_image($edit,$id);
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Images saved successfully...
                                    </div>');
                    redirect('admin/editimage/'.$id);
                }
            }
            $data["row"] = $this->slider_model->get_image_by_id($id);
            $this->load->view('admin/images/editimage', $data);
        } else {
            redirect('admin');
        }
    }

    public function deleteimage($id) {

        if (_is_user_login($this)) {
            $data = array();
            $this->load->model("slider_model");
            $row = $this->slider_model->get_image_by_id($id);
            if ($row) {
				$flpath = FCPATH.'/uploads/images/'.$row->image;
				if(!empty($row->image) && file_exists($flpath)){
					unlink($flpath);
				}
                $this->db->query("DELETE FROM images where id = '" . $row->id . "'");
                redirect("admin/listimages");
            }
        } else {
            redirect('admin');
        }
    }

    public function coupons() {
        if (_is_user_login($this)) {
            $this->load->helper('form');
            $this->load->model('product_model');
            $this->load->library('session');

            $this->load->library('form_validation');
            $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('from', 'From', 'required|callback_date_valid');
            $this->form_validation->set_rules('to', 'To', 'required|callback_date_valid');

            $this->form_validation->set_rules('value', 'Value', 'required|numeric');
            $this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');
            $this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');

            $data = array();
            $data['coupons'] = $this->product_model->coupon_list();
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters('<div class="text-danger">not wor', '</div>');

                $this->load->view("admin/coupons/coupon_list2", $data);
            } else {
                $data = array(
                    'coupon_name' => $this->input->post('coupon_title'),
                    'coupon_code' => $this->input->post('coupon_code'),
                    'valid_from' => $this->input->post('from'),
                    'valid_to' => $this->input->post('to'),
                    'validity_type' => $this->input->post('product_type'),
                    'product_name' => $this->input->post('printable_name'),
                    'discount_type' => $this->input->post('discount_type'),
                    'discount_value' => $this->input->post('value'),
                    'cart_value' => $this->input->post('cart_value'),
                    'uses_restriction' => $this->input->post('restriction')
                );
                //print_r($data);
                if ($this->product_model->coupon($data)) {
                    $this->session->set_flashdata('addmessage', 'Coupon added Successfully.');
                    $data['coupons'] = $this->product_model->coupon_list();
                    $this->load->view("admin/coupons/coupon_list2", $data);
                }
            }
        } else {
            redirect('admin');
        }
    }

    public function add_coupons() {
        //echo "595"; die;
        
            
        if (_is_user_login($this)) {
            $this->load->helper('form');
            $this->load->model('product_model');
            $this->load->library('session');

            $this->load->library('form_validation');
            $data["error"] = "";
            $data["active"] = "add_coupons";
            if (isset($_REQUEST["addcatg"])) {
            //echo "dfs"; die;
                $this->load->library('form_validation');
                $this->load->helper('form');
                $this->load->model('product_model');
                $this->load->library('session');

                $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required');
                $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
                $data['coupons'] = $this->product_model->coupon_list();
                if ($this->form_validation->run() == FALSE) {
                    // echo "in"; 
                    // die;
                        redirect('admin/add_coupons');
                } else {
                    
                    $from   =   str_replace('/','-',$this->input->post('from'));
                    
                    $to     =   str_replace('/','-',$this->input->post('to'));                    
                    $apply_type = $this->input->post('apply_type');
                    
                    $data = array(
                        'apply_type' => $apply_type,                        
                        'coupon_name' => $this->input->post('coupon_title'),
                        'coupon_code' => $this->input->post('coupon_code'),
                        'valid_from' => date('Y-m-d' , strtotime($from)),
                        'valid_to'  =>   date('Y-m-d' , strtotime($to)),
                        'discount_type' => $this->input->post('discount_type'),
                        'discount_value' => $this->input->post('discount_value'),
                        'minimum_cart_amt' => $this->input->post('minimum_cart_amt'),
                        'max_limit' => $this->input->post('max_limit'),
                        'coupon_description' => base64_encode($this->input->post('coupon_description')),
                        'coupon_status' => 1,
                        'uses_restriction' => $this->input->post('uses_restriction'),
                        'coupon_created_at'=> date("Y-m-d")
                    );
                    
                    
                    if($apply_type=="single_product")
                    {
                        $data["type_value"] = implode(", ", $this->input->post('products[]'));
                    }else if($apply_type=="category")
                    {
                        $data["type_value"] = implode(", ", $this->input->post('product_category[]'));
                    }else if($apply_type=="brand")
                    {
                        $data["type_value"] = implode(", ", $this->input->post('products[]'));
                    }else
                    {
                        $data["type_value"] = "";
                    }
                   
                    
                    if ($this->product_model->coupon($data)) {
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Coupon added Successfully.
                                        </div>');
                            redirect('admin/coupons');
                    }
                }
            
            }
            $this->load->model("category_model");
            $data["allcat"] = $this->category_model->get_categories();
            $data["allbrand"] = $this->category_model->get_brand();
            $this->load->model("product_model");
            $data["products"] = $this->product_model->get_products();
            //print_r($data["allcat"]);
            $this->load->view('admin/coupons/add_coupons2', $data);
        } else {
            redirect('admin');
        }
        
    }

    public function date_valid($date) {
        $parts = explode("/", $date);
        if (count($parts) == 3) {
            if (checkdate($parts[1], $parts[0], $parts[2])) {
                return TRUE;
            }
        }
        $this->form_validation->set_message('date_valid', 'The Date field must be dd/mm/yyyy');
        return false;
    }

    function lookup() {
        $this->load->model("product_model");
        $this->load->helper("url");
        $this->load->helper('form');
        // process posted form data  
        $keyword = $this->input->post('term');
        $type = $this->input->post('type');
        $data['response'] = 'false'; //Set default response  
        if ($type == 'Category') {
            
        } elseif ($type == 'Sub Category') {
            
        } else {
            $query = $this->product_model->lookup($keyword); //Search DB 
        }
        if (!empty($query)) {
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach ($query as $row) {
                if (empty($row->deal_product_name)) {
                    $data['message'][] = array(
                        'value'                 => $row->product_name,
                        'id'                    => $row->product_id,
                        'price'                 => $row->price,
                        'qty'                   => $row->qty, 
                        'unit'                  => $row->unit,
                        'product_varient_id'    => $row->varient_id,
                    );  //Add a row to array  
                }
            }
        }
        //print_r( $data['message']);
        if ('IS_AJAX') {
            echo json_encode($data); //echo json string if ajax request 
            //$this->load->view('admin/coupons/coupon_list',$data);
        } else {
            $this->load->view('admin/coupons/coupon_list', $data); //Load html view of search results  
        }
    }

    function looku() {

        $this->load->model("product_model");
        $this->load->helper("url");
        $this->load->helper('form');
        // process posted form data  
        $keyword = $this->input->post('term');
        $type = $this->input->post('type');
        $data['response'] = 'false'; //Set default response  

        $query = $this->product_model->looku($keyword); //Search DB 

        if (!empty($query)) {
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach ($query as $row) {
                $data['message'][] = array(
                    'value' => $row->title
                );  //Add a row to array  
            }
        }
        //print_r( $data['message']);
        if ('IS_AJAX') {
            echo json_encode($data); //echo json string if ajax request 
            //$this->load->view('admin/coupons/coupon_list',$data);
        } else {
            $this->load->view('admin/coupons/coupon_list', $data); //Load html view of search results  
        }
    }

    function look() {

        $this->load->model("product_model");
        $this->load->helper("url");
        $this->load->helper('form');
        // process posted form data  
        $keyword = $this->input->post('term');
        $type = $this->input->post('type');
        $data['response'] = 'false'; //Set default response  
        if ($type == 'Category') {
            
        } elseif ($type == 'Sub Category') {
            
        } else {
            $query = $this->product_model->look($keyword); //Search DB 
        }
        if (!empty($query)) {
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach ($query as $row) {
                $data['message'][] = array(
                    'value' => $row->title
                );  //Add a row to array  
            }
        }
        //print_r( $data['message']);
        if ('IS_AJAX') {
            echo json_encode($data); //echo json string if ajax request 
            //$this->load->view('admin/coupons/coupon_list',$data);
        } else {
            $this->load->view('admin/coupons/coupon_list', $data); //Load html view of search results  
        }
    }

    function editCoupon($id) {
        if (_is_user_login($this)) {
            
            $this->load->library('form_validation');
                $this->load->helper('form');
                $this->load->model('product_model');
                $this->load->library('session');

                $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required');
                $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
                $this->form_validation->set_rules('from', 'From', 'required');
                $this->form_validation->set_rules('to', 'To', 'required');

                $this->form_validation->set_rules('discount_type', 'Discount Type', 'required');
                $this->form_validation->set_rules('discount_value', 'Discount Value', 'required|numeric');
                $this->form_validation->set_rules('cart_value', 'Minimum Cart Amout', 'required|numeric');
                
                
               $this->form_validation->set_rules('uses_restriction', 'Value', 'required|numeric');
                $this->form_validation->set_rules('max_limit', 'Max limit', 'required|numeric');
                
                $this->form_validation->set_rules('coupon_description', 'Coupan Description', 'required');
                $this->form_validation->set_rules('coupon_status', 'Coupon Status', 'required|numeric');

            $data = array();
            if ($this->form_validation->run() == FALSE) {
                //echo "Test"; die();
                $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
                $this->load->model("category_model");
                $data["allcat"] = $this->category_model->get_categories();
                $data["allbrand"] = $this->category_model->get_brand();
                $this->load->model("product_model");
                $data["products"] = $this->product_model->get_products();
                $data['coupon'] = $this->product_model->getCoupon($id);
                $this->load->view("admin/coupons/edit_coupon", $data);
            } else {
                
                $apply_type = $this->input->post('apply_type');
                $data = array(
                        'apply_type' => $apply_type,                        
                        'coupon_name' => $this->input->post('coupon_title'),
                        'coupon_code' => $this->input->post('coupon_code'),
                        'valid_from' => $this->convertdmyToymd($this->input->post('from')),
                        'valid_to' => $this->convertdmyToymd($this->input->post('to')),
                        'discount_type' => $this->input->post('discount_type'),
                        'discount_value' => $this->input->post('discount_value'),
                        'minimum_cart_amt' => $this->input->post('cart_value'),
                        'max_limit' => $this->input->post('max_limit'),
                        'coupon_description' => base64_encode($this->input->post('coupon_description')),
                        'coupon_status' => $this->input->post('coupon_status'),
                        'uses_restriction' => $this->input->post('uses_restriction'),
                        'coupon_created_at'=> date("Y-m-d")
                );
                
                
                if($apply_type=="single_product")
                {
                    $data["type_value"] = implode(", ", $this->input->post('products[]'));
                }else if($apply_type=="category")
                {
                    $data["type_value"] = implode(", ", $this->input->post('product_category[]'));
                }else if($apply_type=="brand")
                {
                    $data["type_value"] = implode(", ", $this->input->post('products[]'));
                }
                else
                {
                    $data["type_value"] = "";
                }
                //echo $id;die();
                
                if ($this->product_model->editCoupon($id, $data)) {
                    $this->session->set_flashdata('addmessage', 'Coupon edited Successfully.');
                    redirect("admin/coupons");
                }
            }
        } else {
            redirect('admin');
        }
    }

    function deleteCoupon($id) {
        if (_is_user_login($this)) {
            $this->load->model('product_model');
            if ($this->product_model->deleteCoupon($id)) {
                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong>Successfully Deleted...
                                    </div>');
                redirect("admin/coupons");
            }
        } else {
            redirect('admin');
        }
    }

    function dealofday() {

        $this->load->model("product_model");
        $data["deal_products"] = $this->product_model->getdealproducts();

        $this->load->view('admin/deal/deal_list2', $data);
    }

    function add_dealproduct() {
        $this->load->helper('form');

        if (_is_user_login($this)) {



            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Product', 'trim|required');
                $this->form_validation->set_rules('deal_price', 'Price', 'trim|required');
                $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
                $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
                $this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
                $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                    }
                } else {
                    $this->load->model("product_model");
                    $array = array(
                        "product_id" => $this->input->post("pro_id"),
                        "pro_var_id" => $this->input->post("pro_var_id"),
                        "product_name" => $this->input->post("prod_title"),
                        "deal_price" => $this->input->post("deal_price"),
                        "start_date" => $this->input->post("start_date"),
                        "start_time" => $this->input->post("start_time"),
                        "end_date" => $this->input->post("end_date"),
                        "end_time" => $this->input->post("end_time")
                    );



                    $this->product_model->adddealproduct($array);
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/dealofday');
                }
            }

            $this->load->view("admin/deal/add2");
        } else {
            redirect('admin');
        }
    }

    function edit_deal_product($id) {
        if (_is_user_login($this)) {

            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Product', 'trim|required');
                $this->form_validation->set_rules('deal_price', 'Price', 'trim|required');
                $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
                $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
                $this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
                $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                    }
                } else {
                    $this->load->model("product_model");
                    $array = array(
                        "product_id" => $this->input->post("pro_id"),
                        "pro_var_id" => $this->input->post("pro_var_id"),
                        "product_name" => $this->input->post("prod_title"),
                        "deal_price" => $this->input->post("deal_price"),
                        "start_date" => $this->input->post("start_date"),
                        "start_time" => $this->input->post("start_time"),
                        "end_date" => $this->input->post("end_date"),
                        "end_time" => $this->input->post("end_time")
                    );

                    $this->product_model->edit_deal_product($id, $array);
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request edited successfully...
                                    </div>');
                    redirect('admin/dealofday');
                }
            }
            $this->load->model("product_model");
            $sql = $this->db->query("select * from deal_product where id = '".$id."' ")->row();
            $data["product"] = $sql;
            //$data["product_new"] = $sql;
            //print_r($data); exit;
            $this->load->view("admin/deal/edit2", $data);
        } else {
            redirect('admin');
        }
    }

    function delete_deal_product($id) {
        if (_is_user_login($this)) {
            $this->db->query("Delete from deal_product where id = '" . $id . "'");
            redirect("admin/dealofday");
        } else {
            redirect('admin');
        }
    }

    public function feature_banner() {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data["active"] = "listslider";
            $this->load->model("slider_model");
            $data["allslider"] = $this->slider_model->feature_banner();
            $this->load->view('admin/feature_banner/listslider2', $data);
        } else {
            redirect('admin');
        }
    }
    public function feature_banner_type() {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data["active"] = "listslider";
            $this->load->model("slider_model");
            $data["alltype"] = $this->slider_model->feature_banner_type();
            $this->load->view('admin/feature_banner/listfeaturetype', $data);
        } else {
            redirect('admin');
        }
    }

    public function add_feature_Banner() {
        if (_is_user_login($this)) {

            $data["error"] = "";
            $data["active"] = "addslider";

            if (isset($_REQUEST["addslider"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name'])) {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }

                if ($this->form_validation->run() == FALSE) {
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                } else {
                    $ids        =   '';
                    $type       =   '';
                    if(!empty($this->input->post("sub_cat"))){
                        $type   =   "category";
                        $ids    =   $this->input->post("sub_cat");
                    }
                    if(!empty($this->input->post("brand"))){
                        $type   =   "brand";
                        $ids    =   $this->input->post("brand");
                    }
                    if(!empty($this->input->post("product"))){
                        $type   =   "product";
                        $ids    =   $this->input->post("product");
                    }
                    
                    
                    $add = array(
                        "slider_title" => $this->input->post("slider_title"),
                        "slider_status" => $this->input->post("slider_status"),
                        "slider_url" => $this->input->post("slider_url"),
                        'image_type' => $this->input->post("banner_size"),
                        "sub_cat" => $ids,
                        "sub_type" => $type,
                        "banner_type" => $this->input->post("banner_type")
                    );

                    if ($_FILES["slider_img"]["size"] <= $this->config->item('slider_file_size') && $_FILES["slider_img"]["size"] > 0) {
                        $config['upload_path'] = './uploads/sliders/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        if($this->input->post("banner_size") == 1 && $this->input->post("banner_type") == 3){
                            $config['max_width'] = '750';
                            $config['min_width'] = '750';
                            $config['max_height'] = '250';
                            $config['min_height'] = '250';
                        }
                        elseif($this->input->post("banner_size") == 0 && $this->input->post("banner_type") == 3){
                            $config['max_width'] = '1395';
                            $config['min_width'] = '1395';
                            $config['max_height'] = '200';
                            $config['min_height'] = '200';
                        }
                        elseif($this->input->post("banner_size") == 0 && $this->input->post("banner_type") == 1){
                            $config['max_width'] = '560';
                            $config['min_width'] = '560';
                            $config['max_height'] = '378';
                            $config['min_height'] = '378';
                        }
                        elseif($this->input->post("banner_size") == 1 && $this->input->post("banner_type") == 1){
                            $config['max_width'] = '275';
                            $config['min_width'] = '275';
                            $config['max_height'] = '184';
                            $config['min_height'] = '184';
                        }
                        elseif(($this->input->post("banner_size") == 1 || $this->input->post("banner_size") == 0) && $this->input->post("banner_type") == 2){
                            $config['max_width'] = '480';
                            $config['min_width'] = '480';
                            $config['max_height'] = '360';
                            $config['min_height'] = '360';
                        }
                        elseif(($this->input->post("banner_size") == 1 || $this->input->post("banner_size") == 0) && $this->input->post("banner_type") == 4){
                            $config['max_width'] = '1130';
                            $config['min_width'] = '1130';
                            $config['max_height'] = '400';
                            $config['min_height'] = '400';
                        }
                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('slider_img')) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $img_data = $this->upload->data();
                            $add["slider_image"] = $img_data['file_name'];
                        }
                    }else{
                         $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> Slider File size is greater then '.($this->config->item('slider_file_size')/1024).' KB...
                                    </div>');
                        redirect('admin/add_feature_Banner');
                    }
                  
                    $this->db->insert("feature_slider", $add);

                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    redirect('admin/feature_banner');
                }
            }
            $this->load->view('admin/feature_banner/addslider2', $data);
        } else {
            redirect('admin');
        }
    }
    public function add_feature_Banner_type() {
        if (_is_user_login($this)) {

            $data["error"] = "";
            $data["active"] = "addslider";

            if (isset($_REQUEST["addslidertype"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('type_name', 'Name', 'trim|required');
               
                if ($this->form_validation->run() == FALSE) {
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                } else {
                    $add = array(
                        "type_name" => $this->input->post("type_name"),
                       
                    );

                    $this->db->insert("feature_slider_type", $add);

                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Type added successfully...
                                    </div>');
                    redirect('admin/feature_banner_type');
                }
            }
            $this->load->view('admin/feature_banner/addfeaturetype', $data);
        } else {
            redirect('admin');
        }
    }
    
    

    public function edit_feature_banner($id) {
        if (_is_user_login($this)) {

            $this->load->model("slider_model");
            $data["slider"] = $this->slider_model->get_feature_banner($id);

            $data["error"] = "";
            $data["active"] = "listslider";
            if (isset($_REQUEST["saveslider"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "")
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                }
                else {
                    
                    if ($_FILES["slider_img"]["size"] >= $this->config->item('slider_file_size')) {
                        //echo $_FILES["slider_img"]["size"] .' >>> '. $this->config->item('slider_file_size'); exit;
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> Slider File size is greater then '.($this->config->item('slider_file_size')/1024).' KB...
                                        </div>');
                        
                    }
                    else{
                        $this->load->model("slider_model");
                        $this->slider_model->edit_feature_banner($id);
                        $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your Slider saved successfully...
                                        </div>');
                        redirect('admin/feature_banner');
                    }
                }
            }
            $this->load->view('admin/feature_banner/editslider2', $data);
        } else {
            redirect('admin');
        }
    }
    public function edit_feature_banner_type($id) {
        if (_is_user_login($this)) {

            $this->load->model("slider_model");
            $data["slider"] = $this->slider_model->get_feature_banner_type($id);

            $data["error"] = "";
            $data["active"] = "listslider";
            if (isset($_REQUEST["saveslider"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('type_name', 'Name', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "")
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                }
                else {
                    $this->load->model("slider_model");
                     $edit = array(
                        "type_name" => $this->input->post("type_name"),
                        
                    );
                    
                    $this->db->update("feature_slider_type", $edit, array("type_id" => $id));
                    
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('admin/feature_banner_type');
                }
            }
            $this->load->view('admin/feature_banner/editfeaturetype', $data);
        } else {
            redirect('admin');
        }
    }

    public function delete_feature_banner($id) {
        if (_is_user_login($this)) {
            $data = array();
            $q  = $this->db->query("SELECT slider_image from feature_slider where id = '" . $id . "'")->row();
            unlink("uploads/sliders/" . $q->slider_image);
            $this->db->query("Delete from feature_slider where id = '" . $id . "'");
            redirect("admin/feature_banner");
        } else {
            redirect('admin');
        }
    }
    public function delete_feature_banner_type($id) {
        if (_is_user_login($this)) {
            $data = array();
            $q    = $this->db->query("SELECT * FROM feature_slider WHERE slider_title ='" . $id . "'");
            if($q->num_rows() > 0){
                $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> This Category Add banner. Firstly remove banners.
                                        </div>');
                redirect('admin/feature_banner_type');
            }
            else{
                $this->db->query("Delete from feature_slider_type where type_id = '" . $id . "'");
                redirect("admin/feature_banner_type");
            }
        } else {
            redirect('admin');
        }
    }
    
    
    public function help() {
        if (_is_user_login($this)) {
			$data = [];
            $domainName     =   base_url();
			$domainName = str_replace('/backend/', '', $domainName);
			$domainName = base64_encode($domainName);  
			// $url = $this->config->item('support_url');
			$url = rtrim($this->config->item('superadmin_url'), '/').'/index.php/superadmin/ticket_list/'.$domainName;
			
			// Setup request to send json via POST
			$rajkumar = curl_init(); 
			// Step 2
			curl_setopt($rajkumar,CURLOPT_URL,$url);
			curl_setopt($rajkumar,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($rajkumar,CURLOPT_HEADER, false); 
			// Step 3
			$result = curl_exec($rajkumar);
			// Step 4
			curl_close($rajkumar);
			// Step 5
			$pData     =   json_decode($result, true);
			if(!empty($pData['responce'])){
				$data["records"] = !empty($pData['data'])? $pData['data'] : '';
			}
			
			
            $this->load->view('admin/help/list', $data);
        } else {
            redirect('admin');
        }
    }

    public function help_details($tkt_id) {
        if (_is_user_login($this)) {
			$data = [];
            $domainName     =   base_url();
			$domainName = str_replace('/backend/', '', $domainName);
			$domainName = base64_encode($domainName);  
			if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('message', 'MKessage', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                    }
                } 
				else {
                    $domainName     =   urlencode($_SERVER['HTTP_HOST']);   
                    // $url = $this->config->item('support_url');
                    $url = rtrim($this->config->item('superadmin_url'), '/').'/index.php/superadmin/reply_ticket';
					
                    // Setup request to send json via POST
                    $data = array(
                        'tkt_id'       => urlencode($tkt_id),
                        'message'       => urlencode($this->input->post('message')),
                    );
                    $fields_string      =   '';
                    foreach($data as $key => $value) { 
                        $fields_string .= $key.'='.$value.'&';
                    }
                    $fields_string  =   rtrim($fields_string, '&');
                        
                    $tutorial_url   =    $url.'?'.$fields_string;
                        
                    $rajkumar = curl_init(); 
                    // Step 2
                    curl_setopt($rajkumar,CURLOPT_URL,$tutorial_url);
                    curl_setopt($rajkumar,CURLOPT_RETURNTRANSFER,true);
                    curl_setopt($rajkumar,CURLOPT_HEADER, false); 
                    // Step 3
                    $result = curl_exec($rajkumar);
                    // Step 4
                    curl_close($rajkumar);
                    // Step 5
					// echo '<pre>';
					// print_r($result );
					// die;
                    $result     =   json_decode($result, true);
                    if($result['responce'] == true){
                        
                        
                        $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                       
                        redirect('admin/help_details/'.$tkt_id);
                    }
                    else{
                         $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                                <i class="fa fa-check"></i>
                                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                              <strong>Error!</strong> Somethig went wrong !!</div>');
                    }
                }
            }
            
			
			
			
			// $url = $this->config->item('support_url');
			$url = rtrim($this->config->item('superadmin_url'), '/').'/index.php/superadmin/ticket_details/'.$domainName.'/'.$tkt_id;
			
			// Setup request to send json via POST
			$rajkumar = curl_init(); 
			// Step 2
			curl_setopt($rajkumar,CURLOPT_URL,$url);
			curl_setopt($rajkumar,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($rajkumar,CURLOPT_HEADER, false); 
			// Step 3
			$result = curl_exec($rajkumar);
			// Step 4
			curl_close($rajkumar);
			// Step 5
			// echo '<pre>';
			// print_r($result );
			// die;

			$pData     =   json_decode($result, true);
			if(!empty($pData['responce'])){
				$data["records"] = !empty($pData['data'])? $pData['data'] : '';
			}
			
			
            $this->load->view('admin/help/details', $data);
        } else {
            redirect('admin');
        }
    }

    public function help_form() {
        if (_is_user_login($this)) {

            $data["error"] = "";
			$domainName     =   base_url();
			$domainName = str_replace('/backend/', '', $domainName);
			$domainName = base64_encode($domainName);
            if (isset($_POST)) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('message', 'Message', 'trim|required');
                $this->form_validation->set_rules('subject', 'Subject', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                    }
                } 
				else {
					
                    // $domainName     =   urlencode($_SERVER['HTTP_HOST']);   
                    // $url = $this->config->item('support_url');
                    $url = rtrim($this->config->item('superadmin_url'), '/').'/index.php/superadmin/rise_ticket';
                    // Setup request to send json via POST
                    $data = array(
                        'subject'     => urlencode($this->input->post('subject')),
                        'message'       => urlencode($this->input->post('message')),
                        'domain'    => urlencode($domainName),
                    );
                    $fields_string      =   '';
                    foreach($data as $key => $value) { 
                        $fields_string .= $key.'='.$value.'&';
                    }
                    $fields_string  =   rtrim($fields_string, '&');
                        
                    $tutorial_url   =    $url.'?'.$fields_string;
                        
                    $rajkumar = curl_init(); 
                    // Step 2
                    curl_setopt($rajkumar,CURLOPT_URL,$tutorial_url);
                    curl_setopt($rajkumar,CURLOPT_RETURNTRANSFER,true);
                    curl_setopt($rajkumar,CURLOPT_HEADER, false); 
                    // Step 3
                    $result = curl_exec($rajkumar);
                    // Step 4
                    curl_close($rajkumar);
                    // Step 5
					// echo '<pre>';
					// print_r($result);
					// die;
                    $result     =   json_decode($result, true);
                    if($result['responce'] == true){
                        /*Order Mail Send Start*/
                        $to_mail_arr = array();
                        $to_mail_arr[0] = array('to_mail' => $this->input->post('email'), 'to_name' => $this->input->post('full_name'));
                        $cc_mail_arr = array();
                        $reply_to_mail_arr = array();
                        $reply_to_mail_arr[0] = array('reply_mail'=>$this->config->item('email'),'reply_name'=>'noreply');
                        $mail_subject = "Order Confirmation";
                        $mail_attachment_arr = array();
                        $from_mail_arr = array();
                        $from_mail_arr[0] = array('from_mail' => 'support@kriscent.in', 'from_name' => 'Kriscent');
                        $message    =  '<strong>Name</strong>'. $this->input->post('full_name').'<br/><strong>Mobile Number</strong>'.$this->input->post('mobile_no').'<br/><strong>Email</strong>'.$this->input->post('email').'<br/><strong>Message</strong>'.$this->input->post('message');
                       // echo $message; print_r($message1); exit;
                        
                        $result  =  $this->send_mail($to_mail_arr, $cc_mail_arr, $reply_to_mail_arr, $mail_subject, $message, $mail_attachment_arr, $from_mail_arr);
                        
                        $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                       
                        redirect('admin/help');
                    }
                    else{
                         $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                                <i class="fa fa-check"></i>
                                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                              <strong>Error!</strong> Somethig went wrong !!</div>');
                    }
                }
            }
            
			
			$this->load->view('admin/help/form');
        } else {
            redirect('admin');
        }
    }


    public function move() {
        $header = array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'X-Auth-Token : A878BFCAF5D52016244C671D94FCAF06DD0753CD5356987289EDC317144C82FFAECC66A99800DBAB'
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://384772.true-order.com/WebReporter/api/v1/items?limit=30249");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        $projects = curl_exec($curl);
        $p = json_decode($projects, true);

        //echo $projects (?limit=30249);

        $data = json_decode($projects);
        /* foreach ($data as $key => $item){
          if ($key=='items'){

          foreach ($key as $k => $itemName){
          echo '<br><br>Value found at array name=> '.$k."=>" . $itemName;
          }
          }
          echo '<br><br>Value found at array key=> '.$key."=>" . $item;
          } */
        foreach ($data->items as $items) {
            echo "<br><br>NAME =>" . $itemName = $items->itemName;
            echo "<br>description =>" . $description = $items->description;

            foreach ($items->stock as $stock) {
                //$stock = $items->stock;
                echo "<br>MRP =>" . $mrp = $stock->mrp;
                echo "<br>S.P =>" . $salePrice = $stock->salePrice;
                echo "<br>TAX(%) =>" . $taxPercentage = $stock->taxPercentage;
                echo "<br>MAIN_cat =>" . $cat = $stock->Cat2;
                echo "<br>SUB_cat =>" . $sub_cat = $stock->Cat1;
                echo "<br>UNIT_VALUE =>" . $unit_value = $stock->packing;
                echo "<br>TITLE =>" . $variantName = $stock->variantName;
            }
        }
    }

    public function payment() {

        if (_is_user_login($this)) {
             $this->config->set_item('title', "Payment Setting");
             $data['rozar'] = $this->db->query("SELECT * FROM razorpay ")->result();
             $this->load->view("admin/payment/list", $data);
        } else {
            redirect('admin');
        }
    }

    public function paypal_detail() {

        if (_is_user_login($this)) {

            $data["error"] = "";
            $data["active"] = "pp";
            if (isset($_POST["pp"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('client_id', 'Client ID', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                    }
                } else {
                    $client_id = $this->input->post("client_id");
                    //$emp_fullname = $this->input->post("emp_fullname");
                    $status = ($this->input->post("status") == "on") ? 1 : 0;
                    $array = array(
                        'client_id' => $client_id,
                        'status' => $status
                    );

                    $this->load->model("common_model");
                    $this->common_model->data_update("paypal", $array, array("id" => 1));
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('admin/payment');
                }
            }


            $data["paypal"] = $this->db->query("SELECT * FROM `paypal` where id = 1");
            print_r($data["paypal"]); exit;

            $this->load->view("admin/payment/edit_paypal", $data);
        } else {
            redirect('admin');
        }
    }

    public function razorpay_detail($id) {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data["active"] = "pp";
            if (isset($_POST["pp"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('api_key', 'Client ID', 'trim');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                    }
                } else {
                    $api_key        = $this->input->post("api_key");
                    $marchecnt_id   = $this->input->post("marchecnt_id");
                    $marchent_key   = $this->input->post("marchent_key");
                    $gateway_url    = $this->input->post("gateway_url");
                    $status         = ($this->input->post("status") == "on") ? 1 : 0;
                    $id             = $this->input->post('id');
                    $array = array(
                        'api_key'       => $api_key,
                        'marchecnt_id'  => $marchecnt_id,
                        'marchent_key'  => $marchent_key,
                        'gateway_url'   => $gateway_url,
                        'status'        => $status
                    );
                    $this->load->model("common_model");
                    $this->common_model->data_update("razorpay", $array, array("id" => $id));
                   // echo $this->db->last_query();  exit;
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('admin/payment');
                }
            }


            $data["razor"] = $this->db->query("SELECT * FROM `razorpay` where id ='".$id."'");
            $this->load->view("admin/payment/edit_razorpay", $data);
        } else {
            redirect('admin');
        }
    }

    public function ads() {
        if (_is_user_login($this)) {
            $data["ads"] = $this->db->query("SELECT * FROM `ads`");

            $this->load->view("admin/ads/list", $data);
        } else {
            redirect('admin');
        }
    }

    public function edit_ads($id) {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data["active"] = "pp";
            if (isset($_POST["pp"])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('name', 'Client ID', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>';
                    }
                } else {
                    $name = $this->input->post("name");
                    $ads_url = $this->input->post("ads_url");
                    $ads_content = $this->input->post("ads_content");
                    
                    $status = ($this->input->post("status") == "on") ? 1 : 0;
                    $array = array(
                        'name' => $name,
                        'ads_url' => $ads_url,
                        'ads_content' => $ads_content,
                        'status' => $status
                    );

                    $this->load->model("common_model");
                    $this->common_model->data_update("ads", $array, array("id" => $id));
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('admin/ads');
                }
            }


            $data["ads"] = $this->db->query("SELECT * FROM `ads` where id ='" . $id . "'");
            $this->load->view("admin/ads/edit_ads", $data);
        } else {
            redirect('admin');
        }
    }

    public function user_action($user_id) {
        if (_is_user_login($this)) {

            if (isset($_POST['profile'])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('name', 'Name', 'trim|required');
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'trim');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                    }
                } else {
                    extract($_POST);
                    $status = ($this->input->post("status") == "on") ? 1 : 0;
                    $this->db->select('user_password'); // Change it to what column name you have for id
                    $this->db->from('registers');
                    $this->db->where('user_id', $user_id); // 'Yes' or 'yes', depending on what you have in db
                    $query = $this->db->get();
                    $pass = $query->row();
                    /*
                      if($pass->user_password==$password)
                      {
                      $password_new=$password;
                      }
                      else
                      {
                      $password_new=md5($password);
                      }
                     */
                    if (empty($password)) {
                        $password_new = $pass->user_password;
                    } else {
                        $password_new = md5($password);
                    }
                    $update = $this->db->query("UPDATE `registers` SET `user_phone`='" . $phone . "',`user_fullname`='" . $name . "',`user_email`='" . $email . "',`user_password`='" . $password_new . "',`house_no`='" . $home . "',status='" . $status . "' WHERE `user_id`='" . $user_id . "'");
                    if (!$update) {
                        redirect('admin/registers');
                    }

                    //$this->product_model->edit_deal_product($id,$array); 
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request edited successfully...
                                    </div>');
                    redirect('admin/registers');
                }
            }

            if (isset($_POST['amount'])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('wallet', 'Name', 'trim|required');
                $this->form_validation->set_rules('type_wallet', 'TYpe', 'trim|required');
                
                //$this->form_validation->set_rules('rewards', 'Email', 'trim|required');
                $rewards = 0;

                if ($this->form_validation->run() == FALSE) {
                    if ($this->form_validation->error_string() != "") {
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                    </div>');
                    }
                } else {
                    $type =  $this->input->post('type_wallet');
                    $post_wallet = $this->input->post('wallet');
                    $qry_wallet = $this->db->query("SELECT * FROM `registers` where user_id = '" . $user_id . "'")->row();
                    $current_wallet  = $qry_wallet->wallet;
                    if($type  == 'add'){
                        $this->load->model("users_model");
                        $cr_wallet_amount = $post_wallet;
                        $msg = htmlspecialchars("Credit By Admin");
                        $this->users_model->crUserWalletHistory($user_id, $cr_wallet_amount, $msg);
                        $total = $current_wallet+$post_wallet;
                    }elseif($type  == 'remove'){
                        $this->load->model("users_model");
                        $cr_wallet_amount = $post_wallet;
                        $msg = htmlspecialchars("Debit By Admin");
                        $this->users_model->drUserWalletHistory($user_id, $cr_wallet_amount, $msg);
                        $total = $current_wallet-$post_wallet;  
                    }
                    $update = $this->db->query("UPDATE `registers` SET `wallet`='" . $total . "',`rewards`='" . $rewards . "' WHERE `user_id`='" . $user_id . "'");
                    
                    //$cr_wallet_amount = $payment;
                        //$msg = htmlspecialchars("Credit By Admin");
                        $msg1 = "Your wallet Credit ".$cr_wallet_amount." R. By Admin";
                        //$msg               =  strtr($smsorder_confirmation,$varMap);
                        
                        $this->setting_model->sendsmsPOST($qry_wallet->user_phone, $msg1, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));
                    
                    if (!$update) {
                        //header('location:w3school.com');
                        echo '<script language="javascript"> alert(Somthing Went Wrong. Uodate Not Successfull. ) </script>';
                        exit;
                    }

                    //$this->product_model->edit_deal_product($id,$array); 
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request edited successfully...
                                    </div>');
                    redirect('admin/registers');
                }
            }
            $this->load->model("product_model");
            $qry = $this->db->query("SELECT * FROM `registers` where user_id = '" . $user_id . "'");
            $data["user"] = $qry->result();
            $data["order"] = $this->product_model->get_sale_orders(" and sale.user_id = '" . $user_id . "' AND sale.status=4 ");
           
            $this->load->model("users_model");
            $data["wallet_history"] = $this->users_model->getUserWalletHistory($user_id);
            $this->load->view("admin/registers/useraction", $data);
        } else {
            redirect('admin');
        }
    }
    
    
    public function wallet_management() {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data = array();
            $qry=$this->db->query("SELECT wh.* , r.*, sum(wh.cr_id) as total_credit, sum(wh.dr_id) as total_debit  FROM `wallet_history` wh  LEFT JOIN registers r on  r.user_id = wh.user_id group by wh.user_id ");
            $data["wallet_history"] = $qry->result();
            $this->load->view("admin/registers/wallet_data", $data);
        } else {
            redirect("admin");
        }
    }
    public function refund_management() {
        if (_is_user_login($this)) {
            $data["error"] = "";
            $data = array();
            //$q = $this->db->query("select rr.* , r.user_fullname, r.user_email, r.user_phone, s.total_amount from `refund_request` rr  LEFT JOIN registers r on  r.user_id = rr.user_id LEFT JOIN sale as s on s.sale_id = rr.order_id order by rr.refund_id DESC");
            $q = $this->db->query("select rr.* , r.*,rr.status as refund_status, s.total_amount from `refund_request` rr  LEFT JOIN registers r on  r.user_id = rr.user_id LEFT JOIN sale as s on s.sale_id = rr.order_id order by rr.refund_id DESC");
            
            $data["refund_history"] = $q->result();
            $this->load->view("admin/registers/refund_management", $data);
        } else {
            redirect("admin");
        }
    }
    
    public function add_payment_in_wallet(){
        if (_is_user_login($this)) {
//            $data["error"] = "";
//            $data = array();
//            $qry=$this->db->query("SELECT wh.* , r.*, sum(wh.cr_id) as total_credit, sum(wh.dr_id) as total_debit  FROM `wallet_history` wh  LEFT JOIN registers r on  r.user_id = wh.user_id group by wh.user_id ");
//            $data["wallet_history"] = $qry->result();
            if(isset($_POST["checked_id"]))
            {
               // print_r($_POST);                
                $ids =  $this->input->post('checked_id');
                // print_r($ids);
                foreach($ids as $user_id)
                {
                    //echo $id."<br>";
                    $payment = $this->input->post('payment');
                    $description = $this->input->post('description');
                    $qry_wallet = $this->db->query("SELECT * FROM `registers` where user_id = '" . $user_id . "'")->row();
                    $current_wallet  = $qry_wallet->wallet;
                    //if($type  == 'add'){
                        $this->load->model("users_model");
                        $cr_wallet_amount = $payment;
                        $msg = htmlspecialchars("Credit By Admin");
                        $msg .= $msg.", ".$description;
                        $this->users_model->crUserWalletHistory($user_id, $cr_wallet_amount, $msg);
                        $total = $current_wallet+$payment;
                    //}
                    $update = $this->db->query("UPDATE `registers` SET `wallet`='" . $total . "' WHERE `user_id`='" . $user_id . "'");
                    
                    if (!$update) {
                        //header('location:w3school.com');
                        echo '<script language="javascript"> alert(Somthing Went Wrong. Uodate Not Successfull. ) </script>';
                        exit;
                    }
                    else
                    {
//                        $q = $this->db->query("SELECT registers.user_email, registers.user_gcm_code, 
//                                        registers.user_ios_token, user_location.receiver_name, user_location.receiver_mobile  
//                                        FROM registers 
//                                        LEFT JOIN sale on sale.user_id=registers.user_id 
//                                        AND sale.sale_id='".$order_id."'
//                                        LEFT JOIN user_location on user_location.location_id=sale.location_id
//                                        where  registers.user_id='".$order->customerid."'");
//                        $user = $q->row();
//                        $token = array(
//                            'Name'  => $user->receiver_name,
//                            'orderid' => $order_id,
//                            'website' => $this->config->item('name')
//                        );
//                        $pattern = '[%s]';
//                        foreach($token as $key=>$val){
//                            $varMap[sprintf($pattern,$key)] = $val;
//                        }
                        
                        $cr_wallet_amount = $payment;
                        //$msg = htmlspecialchars("Credit By Admin");
                        $msg = "Your wallet Credit ".$cr_wallet_amount." R. By Admin ".", ".@$description;
                        //$msg               =  strtr($smsorder_confirmation,$varMap);
                        
                        $this->setting_model->sendsmsPOST($qry_wallet->user_phone, $msg, $this->config->item('sms_url'), $this->config->item('sms_user'), $this->config->item('sms_pass'));

                        //$this->product_model->edit_deal_product($id,$array); 
                        $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Payment successfully Credited in Wallet...
                                    </div>');
                    }
                }
                //$type =  $this->input->post('type_wallet');

                    //redirect('admin/registers');
            }
            
            
            $q = $this->db->query("SELECT * FROM registers where  status='1'");
                $user = $q->result();
            //print_r($user);
            $data["userData"] = $user;
            $this->load->view("admin/wallet/add_payment_in_wallet", $data);
        } else {
            redirect("admin");
        }
        
    }
    
    public function change_status_refund($id) {
       
        $table = 'refund_request';
        $id = $id;
        $q_r = $this->db->query("select status from `refund_request` rr  where refund_id = '".$id."' ")->row();
        if($q_r->status == 0){
            $on_off = '1';
        }else if($q_r->status == 1){
            $on_off = '2';
        }

        $this->db->update($table, array("status" => $on_off), array("refund_id" => $id));
        redirect("admin/refund_management");
        
    }
    

    public function notification22() {
        if (_is_user_login($this)) {
            $serverObject = new SendNotification();
            $jsonString = $serverObject->sendPushNotificationToFCMSever($token, $message, $order_id);
            $jsonObject = json_decode($jsonString);
            return $jsonObject;
        } else {
            redirect('admin');
        }
    }

    public function language_status() {
        //print_r($_POST); exit;
        if (_is_user_login($this)) {
            $q = $this->db->query("select * from `language_setting` WHERE id=1");
            $data["status"] = $q->row();

            $data["error"] = "";
            $data["active"] = "listcat";
            if (isset($_POST["update"])) {
                $status      =   explode('@', $this->input->post('status'));
                $this->load->library('form_validation');
                $update = $this->db->query("UPDATE `language_setting` SET `status`='0' ");
                $update = $this->db->query("UPDATE `language_setting` SET `status`='" . $status[1] . "' WHERE `language_name`='".$status[0]."'");



                if (!$update) {

                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> Update Not Successfull. Something wents Wrong</div>';
                } else {
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Update Successfull </div>');
                    redirect('admin/language_status');
                }
            }
            $this->load->view('admin/setting/language', $data);
        } else {
            redirect('admin');
        }
    }
    
    
    public function company_setting(){
        if (_is_user_login($this)) {
            if(!empty($_POST)){
                $company    =   $this->input->post('company');
               // print_r($company); exit;
               // $currency   =   $this->input->post('currency');
                if ($_FILES["company_logo"]["size"] > 0) {
                    $config['upload_path'] = './uploads/company/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('company_logo')) {
                        $error = array('error' => $this->upload->display_errors());
                    } else {
                        $img_data = $this->upload->data();
                        $company["company_logo"] = $img_data['file_name'];
                    }
                }
                
                if ($_FILES["company_logo1"]["size"] > 0) {
                    $config['upload_path'] = './uploads/company/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('company_logo1')) {
                        $error = array('error' => $this->upload->display_errors());
                    } else {
                        $img_data1 = $this->upload->data();
                        //echo $img_data1['file_name'];
                        $company["company_logo1"] = $img_data1['file_name'];
                    }
                }
                
                
                
                if ($_FILES["company_favicon"]["size"] > 0) {
                    $config['upload_path'] = './uploads/company/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('company_favicon')) {
                        $error = array('error' => $this->upload->display_errors());
                    } else {
                        $img_datas = $this->upload->data();
                        $company["company_favicon"] = $img_datas['file_name'];
                    }
                }
                if ($_FILES["lite_app_icon"]["size"] > 0) {
                    $config['upload_path'] = './uploads/company/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('lite_app_icon')) {
                        $error = array('error' => $this->upload->display_errors());
                    } else {
                        $img_datas = $this->upload->data();
                        $company["lite_app_icon"] = $img_datas['file_name'];
                    }
                }
                
                
                
                // if ($_FILES["splash_screen"]["size"] > 0) {
                //     $config['upload_path'] = './uploads/company/';
                //     $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
                //     $this->load->library('upload', $config);

                //     if (!$this->upload->do_upload('splash_screen')) {
                //         $error = array('error' => $this->upload->display_errors());
                //     } else {
                //         $img_datas = $this->upload->data();
                //         $company["splash_screen"] = $img_datas['file_name'];
                //     }
                // }
                // if ($_FILES['intro_screen']['size'] > 0) {
                //     $file_name      =   "intro_screen";
                //     $company_intro  =   array();
                //     for($i=0; $i <= count($_FILES[$file_name]); $i++){
                //         if(!empty($_FILES[$file_name]['name'][$i])){
                //             $_FILES['files']['name']       = $_FILES[$file_name]['name'][$i];
                //             $_FILES['files']['type']       = $_FILES[$file_name]['type'][$i];
                //             $_FILES['files']['tmp_name']   = $_FILES[$file_name]['tmp_name'][$i];
                //             $_FILES['files']['error']      = $_FILES[$file_name]['error'][$i];
                //             $_FILES['files']['size']       = $_FILES[$file_name]['size'][$i];
                
                //             // File upload configuration
                //             $config['upload_path']   = './uploads/company/';
                //             $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
                
                //             // Load and initialize upload library
                //             $this->load->library('upload', $config);
                //             $this->upload->initialize($config);
                
                //             // Upload file to server
                //             if($this->upload->do_upload('files')){
                //                 // Uploaded file data
                //                 $fileData   = $this->upload->data();
                //                 $company_intro[] = $fileData['file_name'];
                //             }
                //         }
                //     }
                //     $company["intro_screen"]    = json_encode($company_intro);
                // }
                // if ($_FILES["app_icon"]["size"] > 0) {
                //     $config['upload_path'] = './uploads/company/';
                //     $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
                //     $this->load->library('upload', $config);

                //     if (!$this->upload->do_upload('app_icon')) {
                //         $error = array('error' => $this->upload->display_errors());
                //     } else {
                //         $img_datass = $this->upload->data();
                //         $company["app_icon"] = $img_datass['file_name'];
                //     }
                // }
                 foreach($company as $row => $value){
                    if(!empty($row) && is_string($row)){
                        $data   =   array('value' => $value);
                        $this->db->where('titles',$row);
                        $this->db->update('company_setting',$data);
                    }
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Update Successfull </div>');
                }
                // $data_arr  = array('value'=>$currency);
                // $this->db->where('titles','currency');
                // $this->db->update('company_setting',$data_arr);
                
                
            }
            $q = $this->db->query("select * from `company_setting` order by id ASC");
            $data["setting"] = $q->result();
        
            $this->load->view('admin/setting/company_setting', $data);
        } else {
            redirect('admin');
        }
    }
    
    
    public function firebase_setting(){
        if (_is_user_login($this)) {
            if(!empty($_POST)){
                $firebase    =   $this->input->post('firebase');
                
                 foreach($firebase as $row => $value){
                    $data   =   array('value' => $value);
                    $this->db->where('titles',$row);
                    $this->db->update('company_setting',$data);
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Update Successfull </div>');
                }
                
                
            }
            $q = $this->db->query("select * from `company_setting` order by id");
            $data["setting"] = $q->result();
        
            $this->load->view('admin/setting/firebase_setting', $data);
        } else {
            redirect('admin');
        }
    }
    public function currency_setting(){
        if (_is_user_login($this)) {
            if(!empty($_POST)){
                $firebase    =   $this->input->post('currency');
                
                 foreach($firebase as $row => $value){
                    $data   =   array('current_amount' => $value);
                    $this->db->where('id',$row);
                    $this->db->update('currencies',$data);
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Update Successfull </div>');
                }
                
                
            }
            $q = $this->db->query("select * from `currencies`");
            $data["setting"] = $q->result();
        
            $this->load->view('admin/setting/currency_setting', $data);
        } else {
            redirect('admin');
        }
    }
    
    public function custom_advertisement(){
        if (_is_user_login($this)) {
            if(!empty($_POST)){
                $firebase    =   $this->input->post('currency');
                
                 foreach($firebase as $row => $value){
                    $data   =   array('current_amount' => $value);
                    $this->db->where('id',$row);
                    $this->db->update('currencies',$data);
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Update Successfull </div>');
                }
                
                
            }
            $q = $this->db->query("select * from `custom_advertisement` where status =  1");
            $data["advertisement"] = $q->result();
        
            $this->load->view('admin/custom_advertisement', $data);
        } else {
            redirect('admin');
        }
    }
    
    
    
    public function exports_invoice(){
        // $fileName = 'data-'.time().'.xlsx'; 
		$this->load->helper('download');  		
        // load excel library
       // $this->load->library('excels');
        $this->load->model("product_model");
        
        $fromdate   =   $this->input->post('fromdate');
        $todate     =   $this->input->post('todate');
		
        $listInfo       = $this->product_model->exportList($fromdate, $todate);
        $spreadsheet    = new Spreadsheet();
        $spreadsheet->getActiveSheet(0);
		// echo 'mahendra';
        // die;
        // set Header
        $spreadsheet->getActiveSheet()->SetCellValue('A1', 'S.No');
        $spreadsheet->getActiveSheet()->SetCellValue('B1', 'Invoice No');
        $spreadsheet->getActiveSheet()->SetCellValue('C1', 'Customer');
        $spreadsheet->getActiveSheet()->SetCellValue('D1', 'Invoice Date');
        $spreadsheet->getActiveSheet()->SetCellValue('E1', 'Product/Service');       
        $spreadsheet->getActiveSheet()->SetCellValue('F1', 'Product/Service Description');       
        $spreadsheet->getActiveSheet()->SetCellValue('G1', 'Product/Service Quantity');       
        $spreadsheet->getActiveSheet()->SetCellValue('H1', 'Product/Service Rate');       
        $spreadsheet->getActiveSheet()->SetCellValue('I1', 'Product/Service  Amount'); 
        $spreadsheet->getActiveSheet()->SetCellValue('J1', 'Coupon Amount');       
        $spreadsheet->getActiveSheet()->SetCellValue('K1', 'Wallet Amount');       
        $spreadsheet->getActiveSheet()->SetCellValue('L1', 'Delivery Charge');
        $spreadsheet->getActiveSheet()->SetCellValue('M1', 'VAT');
        $spreadsheet->getActiveSheet()->SetCellValue('N1', 'Created Date');       
        $spreadsheet->getActiveSheet()->SetCellValue('O1', 'Modified Date');       
        $spreadsheet->getActiveSheet()->SetCellValue('P1', 'Total Tax');       
        $spreadsheet->getActiveSheet()->SetCellValue('Q1', 'Tax Persentage');       
        $spreadsheet->getActiveSheet()->SetCellValue('R1', 'Total Amount');
        $spreadsheet->getActiveSheet()->SetCellValue('S1', 'Billing Address Line1');       
        $spreadsheet->getActiveSheet()->SetCellValue('T1', 'Billing Address Line2');       
        $spreadsheet->getActiveSheet()->SetCellValue('U1', 'Billing Address Line3');       
        $spreadsheet->getActiveSheet()->SetCellValue('V1', 'Billing Address Line4');       
        $spreadsheet->getActiveSheet()->SetCellValue('W1', 'Billing Address Line5');       
        $spreadsheet->getActiveSheet()->SetCellValue('X1', 'Billing Address City');       
        $spreadsheet->getActiveSheet()->SetCellValue('Y1', 'Billing Address State');       
        $spreadsheet->getActiveSheet()->SetCellValue('Z1', 'Billing Address Postal Code');       
        $spreadsheet->getActiveSheet()->SetCellValue('AA1', 'Billing Address Country');       
        $spreadsheet->getActiveSheet()->SetCellValue('AB1', 'Billing Address Note'); 

        // $spreadsheet->getActiveSheet()->SetCellValue('AC1', 'Shipping Address Line1');       
        // $spreadsheet->getActiveSheet()->SetCellValue('AD1', 'Shipping Address Line2');       
        // $spreadsheet->getActiveSheet()->SetCellValue('AE1', 'Shipping Address Line3');       
        // $spreadsheet->getActiveSheet()->SetCellValue('AF1', 'Shipping Address Line4');       
        // $spreadsheet->getActiveSheet()->SetCellValue('AG1', 'Shipping Address Line5');       
        // $spreadsheet->getActiveSheet()->SetCellValue('AH1', 'Shipping Address City');       
        // $spreadsheet->getActiveSheet()->SetCellValue('AI1', 'Shipping Address State');       
        // $spreadsheet->getActiveSheet()->SetCellValue('AJ1', 'Shipping Address Postal Code');       
        // $spreadsheet->getActiveSheet()->SetCellValue('AK1', 'Shipping Address Country');       
        // $spreadsheet->getActiveSheet()->SetCellValue('AL1', 'Shipping Address Note');       
        // $spreadsheet->getActiveSheet()->SetCellValue('AM1', 'Shipping Method');       
        // $spreadsheet->getActiveSheet()->SetCellValue('AN1', 'Ship Date');       
            
        // // set Row
        $rowCount = 2;
        $sr       = 1;
        $orderid  = '';
        foreach ($listInfo as $list) {
            $single_item_price  =   $list->price; //($list->price *100)/(100+ $list->tax);
            $ItemQuantity       =   $list->qty;
            $total_item_price   =   number_format($single_item_price*$list->qty, 2);
            $tax                =   $list->tax; 
            $totalAmt           =   '';
            $totalTaxAmt        =   '';
            $diliverycharge     =   '';
            $avragePercent      =   '';
            if($list->sale_id  != $orderid){
                $total_amt      =   $this->product_model->getTotal_amt_Tax($list->sale_id);
                $orderid        =   $list->sale_id;
                $totalAmt       =   $total_amt['totalPrice'];
                $totalTaxAmt    =   $total_amt['totalTaxAmt'];
                $diliverycharge =   $total_amt['diliverycharge'];
                $avragePercent  =   $total_amt['avragePercent'];
            }
            $spreadsheet->getActiveSheet()->SetCellValue('A' . $rowCount, $sr);
            $spreadsheet->getActiveSheet()->SetCellValue('B' . $rowCount, '##00'.$list->sale_id);
            $spreadsheet->getActiveSheet()->SetCellValue('C' . $rowCount, $list->user_fullname);
            $spreadsheet->getActiveSheet()->SetCellValue('D' . $rowCount, date('d-m-Y', strtotime($list->on_date)));
            $spreadsheet->getActiveSheet()->SetCellValue('E' . $rowCount, $list->product_name);
            $spreadsheet->getActiveSheet()->SetCellValue('F' . $rowCount, $list->unit_value.' '.$list->unit);
            $spreadsheet->getActiveSheet()->SetCellValue('G' . $rowCount, $list->qty);
            $spreadsheet->getActiveSheet()->SetCellValue('H' . $rowCount, number_format($single_item_price,2));
            $spreadsheet->getActiveSheet()->SetCellValue('I' . $rowCount, $total_item_price);
            $spreadsheet->getActiveSheet()->SetCellValue('J' . $rowCount, ''); //Coupon
            $spreadsheet->getActiveSheet()->SetCellValue('K' . $rowCount, ''); //Wallest
            $spreadsheet->getActiveSheet()->SetCellValue('L' . $rowCount, $diliverycharge); //Delivery char
            $spreadsheet->getActiveSheet()->SetCellValue('M' . $rowCount, $tax);
            $spreadsheet->getActiveSheet()->SetCellValue('N' . $rowCount, date('d-m-Y', strtotime($list->created_at)));
            $spreadsheet->getActiveSheet()->SetCellValue('O' . $rowCount, date('d-m-Y', strtotime($list->created_at)));
            $spreadsheet->getActiveSheet()->SetCellValue('P' . $rowCount, $totalTaxAmt);
            $spreadsheet->getActiveSheet()->SetCellValue('Q' . $rowCount, $avragePercent);
            $spreadsheet->getActiveSheet()->SetCellValue('R' . $rowCount, $totalAmt);

            $spreadsheet->getActiveSheet()->SetCellValue('S' . $rowCount, $list->receiver_name);
            $spreadsheet->getActiveSheet()->SetCellValue('T' . $rowCount, $list->delivery_address);
            $spreadsheet->getActiveSheet()->SetCellValue('U' . $rowCount, $list->receiver_mobile);
            $spreadsheet->getActiveSheet()->SetCellValue('V' . $rowCount, '');
            $spreadsheet->getActiveSheet()->SetCellValue('W' . $rowCount, '');
            $spreadsheet->getActiveSheet()->SetCellValue('X' . $rowCount, $list->city);
            $spreadsheet->getActiveSheet()->SetCellValue('Y' . $rowCount, $list->state);
            $spreadsheet->getActiveSheet()->SetCellValue('Z' . $rowCount, $list->pincode);

            $spreadsheet->getActiveSheet()->SetCellValue('AA' . $rowCount, '');
            $spreadsheet->getActiveSheet()->SetCellValue('AB' . $rowCount, $list->note);
            // $spreadsheet->getActiveSheet()->SetCellValue('AA' . $rowCount, $list->receiver_name);
            // $spreadsheet->getActiveSheet()->SetCellValue('AB' . $rowCount, $list->delivery_address);
            // $spreadsheet->getActiveSheet()->SetCellValue('AC' . $rowCount, $list->receiver_mobile);
            // $spreadsheet->getActiveSheet()->SetCellValue('AD' . $rowCount, '');
            // $spreadsheet->getActiveSheet()->SetCellValue('AE' . $rowCount, '');
            // $spreadsheet->getActiveSheet()->SetCellValue('AF' . $rowCount, $list->city);
            // $spreadsheet->getActiveSheet()->SetCellValue('AG' . $rowCount, $list->state);
            // $spreadsheet->getActiveSheet()->SetCellValue('AH' . $rowCount, $list->pincode);
            // $spreadsheet->getActiveSheet()->SetCellValue('AI' . $rowCount, '');
            // $spreadsheet->getActiveSheet()->SetCellValue('AJ' . $rowCount, $list->note);
       
            $rowCount++;
            $sr++;
        }
		
		$path = FCPATH.'\\uploads\\';
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$fileName = $this->config->item('name').'-'.date("Y-m-d-H-i-s").".xlsx";
		
		$this->output->set_header('Content-Type: application/vnd.ms-excel');
		$this->output->set_header("Content-type: application/csv");
		$this->output->set_header('Cache-Control: max-age=0');
		$writer->save($path.$fileName); 
		
		$filepath = file_get_contents($path.$fileName);
		force_download($fileName, $filepath);
        
    } 
    
    
    public function get_html_assign_deliveryBoy(){
        $action_id      =  $_GET['action_id'];
       // echo $action_id; exit;
		$resultboy 		= $this->db
						->where('trash', 0)
						->where('user_status', 1)
						->order_by('present_status', 'DESC')
						->order_by('user_name', 'ASC')
						->get('delivery_boy')
						->result();
		if(!empty($resultboy)) {;
			$html = '<div class="row">	
						<div class="col-md-12">
							<h4> Assign Delivery Boy</h4>
							<div class="table-responsive">
								<form id="form" action="'.base_url().'admin/assign_deliverboy" method="post">
    								<table id="datatable" class="table table-striped custom-table mb-0 ">
    									<thead>
    									<tr>
    										<th class="text-center">DeliverBoy </th>
    									</tr>
    									<tr>
    										<td>
    										    <input type="hidden" name="order_id" value="'.$action_id.'" >
        										<select id="" name="deliveryboy" class="form-control" required>
        										    <option vlaue=""> --Choose-- </option>
        										    ';
        										   foreach($resultboy as $k=>$v){
													   if($v->present_status == 0){
															$html .= '<option style="background-color: #f44336; color:#fff" value="'.$v->id.'">  '.$v->user_name." - ".$v->user_phone.' </option>';
													   }
													   else{
														   $html .= '<option value="'.$v->id.'">  '.$v->user_name." - ".$v->user_phone.' </option>';
													   }
        										   }
        										
        										$html .= '</select>
    										</td>
    										
    									</tr>
    									<tr>
    									    <td>
    									        <div class="form-group form-button">
                                                    <input type="submit" name="addcatg" value="Assign Delivery Boy"  class="btn btn-fill btn-rose" />
                                                </div>
    									    </td>
    									</tr>
    									
    								
    									</thead>
    								
    								</table>
    							</form>
							</div>
						</div>
					</div>';
			echo $html;
		}
    }
    
    
    public function get_html_order_details12(){
        $action_id      =  $_GET['order_id'];
       // echo $action_id; exit;
//		$resultboy 		= $this->db
//						->where('trash', 0)
//						->get('delivery_boy')
//						->result();
//		if(!empty($resultboy)) {;
			
		//}
        if (_is_user_login($this)) {
            $data = array();
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($action_id);
            $order_items = $this->product_model->get_sale_order_items($action_id);
            //print_r($order_items);
            //$this->load->view("admin/orders/orderdetails", $data);
            if(!empty($order)) {
                
                if(!empty($orders->signature))
                {
                    $signature = @$orders->signature;
                }
                
                
                $html = '<div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><b>Order Details</b><button type="button" style="" class="close" data-dismiss="modal">&times;</button></h4> 
                </div> 
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><b>'.$this->lang->line("Order Number").':</b> #'.$order->sale_id.'</br><b>
                                    '.$this->lang->line("Delivered Date").':</b> '.date('d-m-Y', strtotime($order->order_deliverd_date)).'</br><b>                                    
                                    '.$this->lang->line("Total Price").':</b> '.$order->total_amount.' Rs. </br> 
                                </p>';
                    if(!empty($orders->signature))
                    {
                        $html .= '<img src="'.$this->config->item('base_url').'uploads/signature/'.@$signature.'" alt="Customer Signature" style="width: 100px; height: 40px;" height="15px;" width="30px;">';
                    }
                       $html .= '</div>
                            <div class="col-md-6">
                                <p><b>'.$this->lang->line("Customer Name").':</b> '.$order->user_fullname.'</br><b>
                                    '.$this->lang->line("Mobile Number").':</b> '.$order->receiver_mobile.'</br><b>
                                    '.$this->lang->line("Email").':</b> '.$order->user_email.'</br><b>
                                    '.$this->lang->line("Shipping Address").':</b> '.$order->delivery_address.'
                                </p>
                            </div>
                        </div>
                        <hr/ style="margin:0px;"><h5 style="text-align:center;font-size:15px;margin:5px 0px;"><b>Item Details</b></h5><hr/ style="margin:0px; padding-bottom:15px;">';
                        
                
                $html .= '<div class="row"><table class="table table-striped table-bordered table-hover"
                                           cellspacing="0" width="100%" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-left" style="padding:10px;">'.$this->lang->line("Product Image").'</th>
                            <th class="text-left" style="width: 450px;padding:10px;">'.$this->lang->line("Product Name").'</th>
                        </tr>
                        </thead>

                        <tbody>';
                foreach ($order_items as $items) {
                        
                    $p_name_array = explode(",",$items->product_image);
                    //print_r($p_name_array);
                    
                    $html .= '
                            <tr>
                                <td style="width:100px;text-align:center;"><img class="img-fluid" src="'.$this->config->item('base_url').'uploads/products/'.$p_name_array[0].'" style="width:60px;"></td>
                                <td>'.$this->lang->line("Product Name").': '.$items->product_name.'</br>'.$this->lang->line("Qty").': '.$items->qty.'</td>
                            </tr>';
                    
                        $html1 = '<div class="row">
                            <div class="col-md-3"> <img class="img-fluid" src="'.$this->config->item('base_url').'uploads/products/'.$p_name_array[0].'" style="width:60px;"> </div>
                            <div class="col-md-9" style="">
                                <ul type="none">
                                    <li>'.$this->lang->line("Product Name").': '.$items->product_name.'</li>
                                    <li>'.$this->lang->line("Qty").': '.$items->qty.'</li>
                                </ul>
                            </div>
                            
                        </div>';
                        
                        }
                $html .= ' 
                        </tbody>

                    </table></div>';
                      
                echo $html;
            }
            
        } else {
            redirect("admin");
        }
        
        //$this->load->view("admin/orders/orderdetails2", $data);
    }
    
   
    
    public function get_html_return_order_details(){
        $action_id      =  $_GET['order_id'];
		
        if (_is_user_login($this)) {
            $data = array();
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($action_id);
            $order_items = $this->product_model->get_sale_order_items($action_id);
            
            
            $q = $this->db->query("select rr.*, r.user_fullname, s.total_amount from `refund_request` rr LEFT JOIN registers r on r.user_id = rr.user_id LEFT JOIN sale as s on s.sale_id = rr.order_id where s.sale_id ='".$action_id."' order by rr.refund_id DESC");
            
            $refund_history = $q->row();
			// echo '<pre>';
            // print_r($refund_history);
            //$this->load->view("admin/orders/orderdetails", $data);
            if(!empty($order)) {
               $request_date = $refund_date = '';
                if(!empty($order->request_date)){
					$request_date = date('d-m-Y', strtotime($order->request_date));
				}
                
                if(!empty($order->refund_date)){
					$refund_date = date('d-m-Y', strtotime($order->refund_date));
				}
                
                $html = '<div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><b>Order Details</b><button type="button" style="" class="close" data-dismiss="modal">&times;</button></h4> 
                </div> 
                <div class="modal-body">
				<table class="table" cellspacing="0" style="width:100%">
                        <tbody>';
              
                    $html .= '
                            <tr>
                                <th style="width:150px">'.$this->lang->line("Order Number").':</th>
                                <td>'.$order->sale_id.'</td>
                                <th style="width:150px">'.$this->lang->line("Customer Name").':</th>
                                <td>'.$order->user_fullname.'</td>
                            </tr>
                            <tr>
                                <th style="width:150px">'.$this->lang->line("Request Date").':</th>
                                <td>'.$request_date.'</td>
                                <th style="width:150px">'.$this->lang->line("Mobile Number").':</th>
                                <td>'.$order->receiver_mobile.'</td>
                            </tr>
                            <tr>
                                <th style="width:150px">'.$this->lang->line("Refund Date").':</th>
                                <td>'.$refund_date.'</td>
                                <th style="width:150px">'.$this->lang->line("Email").':</th>
                                <td>'.$order->user_email.'</td>
                            </tr>
                            <tr>
                                <th style="width:150px">'.$this->lang->line("Description").':</th>
                                <td>'.$refund_history->description.'</td>
								<th style="width:150px">'.$this->lang->line("Reason").':</th>
                                <td>'.$refund_history->reason.'</td>
                                
                            </tr>
                            <tr>
                                <th style="width:150px">'.$this->lang->line("Delivery Boy Description").':</th>
                                <td>'.$refund_history->dboy_description.'</td>
								<th style="width:150px">'.$this->lang->line("Shipping Address").':</th>
                                <td>'.$order->delivery_address.'</td>
                            </tr>
                            <tr>
                                <th style="width:150px">'.$this->lang->line("Total Price").':</th>
                                <td>'.$this->config->item('currency').' '.$order->total_amount.'</td>
                                <th style="width:150px">Product Images</th>
                                <td>';
								if(!empty($order->dboy_images))
								{
									$html .= '<img src="'.$this->config->item('base_url').'uploads/product_images/'.$order->dboy_images.'" alt="Product Images" style="width: 100px;">';
								}
								$html .= '</td>
                                
                            </tr>
							';
                        
                        
                        
                $html .= ' 
                        </tbody>

                    </table>
				
                        
                        <h5 style="text-align:center;font-size:15px;margin:5px 0px;"><b>Item Details</b></h5><hr/ style="margin:0px; padding-bottom:15px;">';
                        
                
                $html .= '
				<table class="table table-striped table-bordered table-hover"
                                           cellspacing="0" width="100%" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-left" style="padding:10px;">'.$this->lang->line("Product Image").'</th>
                            <th class="text-left" style="width: 450px;padding:10px;">'.$this->lang->line("Product Name").'</th>
                        </tr>
                        </thead>

                        <tbody>';
                foreach ($order_items as $items) {
                        
                    $p_name_array = explode(",",$items->product_image);
                    //print_r($p_name_array);
                    
                        $html .= '
                            <tr>
                                <td style="width:100px;text-align:center;"><img class="img-fluid" src="'.$this->config->item('base_url').'uploads/products/'.$p_name_array[0].'" style="width:60px;"></td>
                                <td>'.$this->lang->line("Product Name").': '.$items->product_name.'</br>'.$this->lang->line("Qty").': '.$items->qty.'</td>
                            </tr>';
                        
                        }
                $html .= ' 
                        </tbody>

                    </table></div>';
                
                
                $html .= '</div>';
                      
                echo $html;
            }
            
        } else {
            redirect("admin");
        }
        
        //$this->load->view("admin/orders/orderdetails2", $data);
    }
    
     public function get_html_assign_deliveryBoy_refund_process(){
        $action_id      =  $_GET['action_id'];
       // echo $action_id; exit;
		$resultboy 		= $this->db
						->where('trash', 0)
						->where('user_status', 1)
						->order_by('present_status', 'DESC')
						->order_by('user_name', 'ASC')
						->get('delivery_boy')
						->result();
		if(!empty($resultboy)) {;
			$html = '<div class="row">	
						<div class="col-md-12">
							<h4> Assign Delivery Boy</h4>
							<div class="table-responsive">
								<form id="form" action="'.base_url().'admin/refund_assign_deliverboy" method="post">
    								<table id="datatable" class="table table-striped custom-table mb-0 ">
    									<thead>
    									
                                        
    									<tr>
                                            <td class="text-left col-md-4">
                                                Delivery Boy:
        										
    										</td>
    										<td class="col-md-8">    										    
                                                <input type="hidden" name="refund_id" value="'.$action_id.'" >
        										<select id="" name="deliveryboy" class="form-control" required>
        										    <option vlaue=""> --Choose-- </option>
        										    ';
        										   foreach($resultboy as $k=>$v){
        										      if($v->present_status == 0){
															$html .= '<option style="background-color: #f44336; color:#fff" value="'.$v->id.'">  '.$v->user_name." - ".$v->user_phone.' </option>';
													   }
													   else{
														   $html .= '<option value="'.$v->id.'">  '.$v->user_name." - ".$v->user_phone.' </option>';
													   }
        										   }
        										
        										$html .= '</select>
    										</td>
    										
    									</tr>
                                        
                                        <tr>
                                            <td class="text-left col-md-4" style="border:0;">
                                                Refund Description:
        										
    										</td>
    										<td class="col-md-8" style="border:0;">
                                                <textarea id="" name="refund_description" rows="4" class="form-control" required></textarea>
        										
    										</td>
    										
    									</tr>
    									<tr>
    									    <td colspan="2" style="border:0;" class="text-center">
    									        <div class="form-group form-button">
                                                    <input type="submit" name="addcatg" value="Assign Delivery Boy"  class="btn btn-fill btn-rose" />
                                                </div>
    									    </td>
    									</tr>
    									
    								
    									</thead>
    								
    								</table>
    							</form>
							</div>
						</div>
					</div>';
			echo $html;
		}
    }
    
    public function get_html_refund_request_reject(){
        $action_id      =  $_GET['action_id'];
       // echo $action_id; exit;
		$resultboy 		= $this->db
						->where('trash', 0)
						->get('delivery_boy')
						->result();
		if(!empty($resultboy)) {;
			$html = '<div class="row">	
						<div class="col-md-12">
							<h4> Refund Request Reject</h4>
							<div class="table-responsive">
								<form id="form" action="'.base_url().'admin/refund_rqst_reject" method="post">
    								<table id="datatable" class="table table-striped custom-table mb-0 ">
    									<thead>
                                        
                                        <tr>
                                            <td class="text-left col-md-4" style="border:0;">
                                                Description:
                                                
        										
    										</td>
    										<td class="col-md-8" style="border:0;">
                                            
                                                <input type="hidden" name="refund_id" value="'.$action_id.'" >
                                                <textarea id="" name="refund_description" rows="4" class="form-control" required></textarea>
        										
    										</td>
    										
    									</tr>
    									<tr>
    									    <td colspan="2" style="border:0;" class="text-center">
    									        <div class="form-group form-button">
                                                    <input type="submit" name="addcatg" value="Submit"  class="btn btn-fill btn-rose" />
                                                </div>
    									    </td>
    									</tr>
    									
    								
    									</thead>
    								
    								</table>
    							</form>
							</div>
						</div>
					</div>';
			echo $html;
		}
    }
    
    public function assign_deliverboy(){
        
        if(!empty($_POST)){
            $order_id = $this->input->post('order_id');
            $boy_id = $this->input->post('deliveryboy');
			
			$q = $this->db->query("SELECT * FROM delivery_boy where id = $boy_id and present_status = 1");
            $delivery_boy = $q->row();
            if(!empty($delivery_boy)){
                $dat = date("Y-m-d h:i:s");
                
            	$this->db->query("update sale set delivery_boy_id =  '" . $boy_id . "', assign_dboy_date = '".$dat."'  where sale_id = '" . $order_id . "'");
				// $this->db->query("update delivery_boy set order_id =  '" . $order_id . "'  where id = '" . $boy_id . "'");
				
				$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Your request Send successfully...
                            </div>');
							
			}
			else{
				$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Error!</strong> Delivery Boy does not present</div>
								  ');
			}
			
            redirect('admin/orders');
            
        }
    }
    
    public function refund_assign_deliverboy(){
        
        if(!empty($_POST)){
            //$order_id = $this->input->post('order_id');
            $delivery_boy_id = $this->input->post('deliveryboy');
            $status = 1;
            $description = $this->input->post('refund_description');
            $refund_id = $this->input->post('refund_id');
            $status_by = $this->session->userdata("user_id");
            $status_date = date("Y-m-d h:i:s");
            $dat = date("Y-m-d h:i:s");
            
            $q = $this->db->query("SELECT * FROM delivery_boy where id = $delivery_boy_id and present_status = 1");
            $delivery_boy = $q->row();
            if(!empty($delivery_boy)){
				$this->db->query("update refund_request set status =  '" . $status . "', delivery_boy_id='".$delivery_boy_id."', description='".$description."', status_by='".$status_by."', status_date='".$status_date."', assign_dboy_date = '".$dat."'  where refund_id = '" . $refund_id . "'");
            
				$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Your Refund Request Accepted...
                            </div>');
			}
			else{
				$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Error!</strong> Delivery Boy does not present</div>
								  ');
			}
            //die();
            redirect('admin/refund_management');
            
        }
    }
    
    public function refund_rqst_reject(){
        
        if(!empty($_POST)){
            //$order_id = $this->input->post('order_id');            
            $status = 2;
            $description = $this->input->post('refund_description');
            $refund_id = $this->input->post('refund_id');
            $status_by = $this->session->userdata("user_id");
            $status_date = date("Y-m-d h:i:s");
            
			$q = $this->db->query("SELECT * FROM refund_request where refund_id = $refund_id");
            $refund_request = $q->row();
            if(!empty($refund_request)){
				$this->db->query("update refund_request set status =  '" . $status . "', description='".$description."', status_by='".$status_by."', status_date='".$status_date."'  where refund_id = '" . $refund_id . "'");
				
				 $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
											<i class="fa fa-check"></i>
								  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								  <strong>Success!</strong> Return Request Canceled Successfully
								</div>');
            }
			else{
				$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Error!</strong> Invalid Return ID. </div>
								  ');
			}
            redirect('admin/refund_management');
            
        }
    }
    
    
    public function dboy_arriving($refund_id){
        $status_date = date("Y-m-d h:i:s");
            
		$q = $this->db->query("SELECT * FROM refund_request where refund_id = $refund_id");
		$refund_request = $q->row();
		if(!empty($refund_request)){
			$this->db->query("update refund_request set status = '3' where refund_id = '" . $refund_id . "'");
			
			$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
									<i class="fa fa-check"></i>
						  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						  <strong>Success!</strong> Delivery Boy Arriving successfully
						</div>');
		}
		else{
			$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
								<i class="fa fa-check"></i>
							  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							  <strong>Error!</strong> Invalid Return ID. </div>
							  ');
		}
        
		redirect('admin/refund_management');
		
    }
    
    public function dboy_received($refund_id){
		$status_date = date("Y-m-d h:i:s");
		
		$q = $this->db->query("SELECT * FROM refund_request where refund_id = $refund_id");
		$refund_request = $q->row_array();
		if(!empty($refund_request['order_id'])){
            $order_id      =  $refund_request['order_id'];
            $user_id      =  $refund_request['user_id'];
            $requestfor      =  $refund_request['requestfor'];
			
            $q = $this->db->query("SELECT sale.* FROM sale where sale.sale_id = $order_id");
			
            $refund_product_detail = $q->row();
            if(!empty($refund_product_detail)){
                
                if($requestfor=="refund")
                {
                    $refund_amount = $refund_product_detail->total_amount;
                    
                    $today_date = date("Y-m-d h:i:s");
    				
    				$q = $this->db->query("SELECT * FROM sale_items where sale_items.sale_id = $order_id");
    				$sale_items = $q->result();
    				foreach($sale_items as $sale_item){
    					$product_qty = $sale_item->qty;
    					$varient_id = $sale_item->pro_var_id;
    					$this->db->query("update product_varient set stock_inv=stock_inv+".$product_qty." where varient_id='".$varient_id."'");
    				}
    
                    $description_msg_transaction = "'refund amount ".$refund_amount.", order id-".$order_id.", add user wallet amount'";
    
                    $this->db->query("insert into transaction(user_id, order_id, transction_code, description, cr,  status, create_at) values($user_id, $order_id, 'Refund', $description_msg_transaction, $refund_amount, '1', '$today_date')");
    
                    $description_msg_wallet = "'Credit By Admin for refund order id ".$order_id."'";
    
                    $this->db->query("insert into wallet_history(user_id, transaction_by, description, cr_id, created_date) values($user_id, 'Refund', $description_msg_wallet, $refund_amount, '$today_date')");
    
                    $this->db->query("update registers set wallet=wallet+".$refund_amount." where user_id ='".$user_id."'");
                }
				
				
                $this->db->query("update refund_request set status='7' where refund_id ='".$refund_id."'"); //status 3 for completed refund process

                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Refund successfully.
                                </div>');
            }
            else
            {
                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Failed!</strong> Order not found...
                                </div>');
            }
            
           
            
        }
		else{
			$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
								<i class="fa fa-check"></i>
							  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							  <strong>Error!</strong> Invalid Return ID. </div>
							  ');
		}
		
        redirect('admin/refund_management');
            
        
    }
    
    
    
    function csv(){
        $this->load->view('admin/uploadCsvView');
    }
	
	function uploadData(){
        $this->load->model("product_model");
		// $file_data = $_FILES["userfile"]["tmp_name"];
		$extension = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);

		if($extension == 'csv'){
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		} elseif($extension == 'xlsx') {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		} else {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		}
		
		$spreadsheet = $reader->load($_FILES['userfile']['tmp_name']);
		// echo $extension;
		// echo '<pre>';
		// print_r($spreadsheet);
		// die;
		$allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();;
		$higestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();;
		// echo '<pre>';
		// print_r($allDataInSheet);
		foreach ($allDataInSheet as $row => $worksheet) {
			if($row>=2){
				$productNmae 		=  $worksheet['A'];
				$productDescription =  $worksheet['B'];
				$productImage 		=  $worksheet['C'];
				$categoryId 		=  $worksheet['D'];
				$inStock 			=  $worksheet['E'];
				$tax 				=  $worksheet['F'];
				$skucode 			=  $worksheet['G'];
				$varients		    =  $worksheet['H'];
				 // $varient       =  json_decode($varients, true);
				// print_r($varients);
				// die;
				$static_product_id  =  $this->product_model->new_sequence_code('PRODUCT');
				
				$product_slug  =  $this->slugify($productNmae);

				$data = array(
					'product_id'                =>  "" ,
                    'product_name'              =>  $productNmae,
                    'product_slug'              =>  $product_slug,
                    'product_description'       =>  $productDescription,
                    'product_image'             =>  $productImage,
                    'category_id'               =>  $categoryId,
                    'in_stock'                  =>  $inStock,
                    'tax'                       =>  $tax,
                    'prod_sku_code'             =>  $skucode,
                    'static_product_id'         =>  $static_product_id
				);
				// print_r($data); exit;
				$datas = $this->db->insert('products', $data);
				$in_id = $this->db->insert_id();
				if(!empty($varients)){
				    $varient       =  json_decode($varients, true);
					
                    foreach($varient as $vari_row){
						
						$date=date('Y-m-d h:i:s');
                        $data_varient   = array(
                                                'varient_id'    => '',
                                                'product_id'    => $in_id,
                                                'price'         => $vari_row['price'],
                                                'qty'           => $vari_row['qty'],
                                                'unit'          => $vari_row['unit'],
                                                'mrp'           => $vari_row['mrp'],
                                                'tax'           => $tax,
                                                'date'          => $date,
                                                'description'   => $productDescription,
                                                'trash'         => 0,
                                                'stock_inv'     => $vari_row['stock'],
                                                'pro_var_images'=> $vari_row['image'],
                                                );
                            $data  = $this->db->insert('product_varient', $data_varient);
							
                            $varition_id = $this->db->insert_id();
        					$data1 = array(
        						'purchase_id'       => "" ,
        						'product_id'        => $in_id,
        						'varition_id'       => $varition_id,
        						'qty'               => $vari_row['qty'],
        						'unit'              => $vari_row['unit'],
        						'date'              => $date,
        						'stock_inv'         => $vari_row['stock'],
        						'price'             => $vari_row['price'],
						        'mrp'               => $vari_row['mrp'],
        						'store_id_login'    => '1'
        					);
        					$data = $this->db->insert('purchase', $data1);
							
                    }
				}
				
			}
			
		}
		
       if($data == 1){
            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Your request Send successfully...
                            </div>');
       }
       else{
           $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> Something wents Wrong</div>';
       }
       redirect('admin/csv');
    }
    
	function categoryCsv(){
        $this->load->view('admin/categories/uploadCategory');
    }
    function uploadCategoryData(){
       $data  = $this->csv_model->uploadCategoryData();
       if($data == 1){
            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Your request Send successfully...
                            </div>');
       }
       else{
           $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> Something wents Wrong</div>';
       }
        redirect('admin/categoryCsv');
    }
    function subcategoryCsv(){
        $this->load->view('admin/categories/uploadSubCategory');
    }
    function uploadSubCategoryData(){
        $categoryId     =   $this->input->post('category_id');
       $data  = $this->csv_model->uploadSubCategoryData($categoryId);
       if($data == 1){
            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Your request Send successfully...
                            </div>');
       }
       else{
           $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> Something wents Wrong</div>';
       }
        redirect('admin/subcategoryCsv');
    }
    
    
    function homepage_list(){
        $response       =   array('status' => 0);
        $category_id    =   $this->input->post('homepage');
        
        $check_row      =   $this->db->query("SELECT homepage FROM categories WHERE id='".$category_id."'")->row();
        $homepage       =   1;
        if($check_row->homepage == 1){
            $homepage   =   0;
        }
        $change  = $this->db->query("UPDATE categories SET homepage = '".$homepage."' WHERE id='".$category_id."'");
        if($change){
            $response['status'] = 1;
            $response['data']   = $homepage;
        }
        
        echo json_encode($response);
    }
    
    function show_menu(){
        $response       =   array('status' => 0);
        $category_id    =   $this->input->post('homepage');
        
        $check_row      =   $this->db->query("SELECT homepage FROM product_cat_type WHERE product_cat_type_id='".$category_id."'")->row();
        $homepage       =   1;
        if($check_row->homepage == 1){
            $homepage   =   0;
        }
        $change  = $this->db->query("UPDATE product_cat_type SET homepage = '".$homepage."' WHERE product_cat_type_id='".$category_id."'");
        if($change){
            $response['status'] = 1;
            $response['data']   = $homepage;
        }
        
        echo json_encode($response);
    }
    
    function order_notification(){
        $response       =   array('status' => 0);
        $count_new_sale    =   $this->db->query("SELECT count(sale_id) as total FROM sale WHERE is_admin_saw = 0")->row();
		$total_new_sale    =   $count_new_sale->total;
        if($total_new_sale){
            $response['status'] = 1;
            $response['data']   = $total_new_sale;
        }
        
        
        echo json_encode($response);
    }
    private function printCategory($parent,$leval,$cat_type_id){
		$ret = '';  
		$q = $this->db->query("SELECT a.*, IFNULL(Deriv1.count, 0) AS count FROM `categories` a  LEFT JOIN (SELECT `parent`, COUNT(*) AS count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`parent`=" . $parent." AND a.`product_cat_type_id`=" . $cat_type_id);
		$rows = $q->result();

		foreach($rows as $row){
			if ($row->count > 0) {
				$ret .= $this->printRow($row);
				$ret .= $this->printCategory($row->id, $leval + 1, $cat_type_id);
					// print_r($row);
			}
			elseif ($row->count == 0) {
				$ret .= $this->printRow($row);
				// print_r($row);
			}
		}
		return $ret;
	}
	private function printRow($row){
        $ret = '';                                                
		$ret .= '<option value="'.$row->id.'" >';
		for($i=0; $i<$row->leval; $i++){ $ret .= "_"; }
		$ret .= $row->title;
		$ret .= '</option>';
		return $ret;
	}
	
    function get_category_by_type($cat_type){
        $response       =   array('status' => 0);
        $ret = '<option value="0"> '.$this->lang->line("Select Category").'</option>';
		
		$ret .= $this->printCategory(0, 0, $cat_type);
		
        if($ret){
            $response['status'] = 1;
            $response['data']   = $ret;
        }
        
        
        echo json_encode($response);
    }
    
    function get_pro_attr($cat_type){
        $response       =   array('status' => 0);
        $ret = '<option value="0"> '.$this->lang->line("Select Category").'</option>';
		$ret .= $this->printCategory(0, 0, $cat_type);
		
		
		$color_attr = '<option value="">'.$this->lang->line("Select Color").'</option>';
		$size_attr = '<option value="">'.$this->lang->line("Select Size").'</option>';
		$material_attr = '<option value="">'.$this->lang->line("Select Material").'</option>';
		$use_for_attr = '<option value="">'.$this->lang->line("Select Use For").'</option>';
		$q4 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=1 and attribute_values_product_cat_type_id=".$cat_type);
        $color = $q4->result();
		foreach($color as $row){
			$color_attr .= '<option value="'.$row->attribute_value_id.'" style="background-color:'.$row->attribute_value.'">'.$row->attribute_value.'</option>';
		}
		
		$q4 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=2 and attribute_values_product_cat_type_id=".$cat_type);
        $size = $q4->result();
		foreach($size as $row){
			$size_attr .= '<option value="'.$row->attribute_value_id.'">'.$row->attribute_value.'</option>';
		}
		
		$q4 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=3 and attribute_values_product_cat_type_id=".$cat_type);
        $material = $q4->result();
		foreach($material as $row){
			$material_attr .= '<option value="'.$row->attribute_value_id.'">'.$row->attribute_value.'</option>';
		}
		
		$q4 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=4 and attribute_values_product_cat_type_id=".$cat_type);
        $use_for = $q4->result();
		foreach($use_for as $row){
			$use_for_attr .= '<option value="'.$row->attribute_value_id.'">'.$row->attribute_value.'</option>';
		}
		
        if(!empty($ret) || !empty($color_attr) || !empty($size_attr) || !empty($material_attr) || !empty($use_for_attr)){
            $response['status'] = 1;
            $response['data']['category']   = $ret;
            $response['data']['color_attr']   	= $color_attr;
            $response['data']['size_attr']   	= $size_attr;
            $response['data']['material_attr']   = $material_attr;
            $response['data']['use_for_attr']   	= $use_for_attr;
        }
        
        
        echo json_encode($response);
    }
    
    public function tutorial(){
        if (_is_user_login($this)) {
            $data["active"] = "tutorial";
            // $tutorial_url   =   $this->config->item('tutorial_url');
            $tutorial_url = rtrim($this->config->item('superadmin_url'), '/').'/index.php/superadmin/get_tutorial';
			
			// die;
             // Step 1
            $rajkumar = curl_init(); 
            // Step 2
            curl_setopt($rajkumar,CURLOPT_URL,$tutorial_url);
            curl_setopt($rajkumar,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($rajkumar,CURLOPT_HEADER, false); 
            // Step 3
            $result = curl_exec($rajkumar);
            // Step 4
            curl_close($rajkumar);
            // Step 5
            $data["result"]   = $result;
            $this->load->view('admin/tutorial', $data);
        } else {
            redirect('admin');
        }
    }
    
    public function versions(){
        if (_is_user_login($this)) {
            $domainName     =   base_url();
			$domainName = str_replace('/backend/', '', $domainName);
			$domainName = base64_encode($domainName);
			
            $data["active"] = "versions";
            // $tutorial_url   =   $this->config->item('get_version_url').'/'.$domainName;
			$url = rtrim($this->config->item('superadmin_url'), '/').'/index.php/superadmin/get_version/'.$domainName;
            // echo $url; exit;
             // Step 1
            $rajkumar = curl_init(); 
            // Step 2
            curl_setopt($rajkumar,CURLOPT_URL,$url);
            curl_setopt($rajkumar,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($rajkumar,CURLOPT_HEADER, false); 
            // Step 3
            $result = curl_exec($rajkumar);
            // Step 4
            curl_close($rajkumar);
            // Step 5
            $data["userData"]   = $result;
            $this->load->view('admin/versions', $data);
        } else {
            redirect('admin');
        }
    }
    
    public function downloadVersionFile($version_file,$version_code){
        if (_is_user_login($this)) {
            $data["active"] = "versions";
            $superadmin_url   =   rtrim($this->config->item('superadmin_url'), '/');
            //echo $tutorial_url; exit;
             // Step 1
            $path = './uploads/version/';
			if (!is_dir($path)){
				@mkdir($path, 0777, true);
			}
			$source = $superadmin_url.'/uploads/version/'.$version_file;
			$destination = $path."version".$version_code.".zip";
			// $ch = curl_init();
			// $source = "http://someurl.com/afile.zip";
			// curl_setopt($ch, CURLOPT_URL, $source);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// $data = curl_exec ($ch);
			// curl_close ($ch);

			// $destination = "/asubfolder/afile.zip";
			// $file = fopen($destination, "w+");
			// fputs($file, $data);
			// fclose($file);
			
			
			if(file_put_contents($destination, fopen($source, 'r'))){
				$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Version File Download successfully
                            </div>');
			   }
			   else{
				   $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
												<i class="fa fa-warning"></i>
											  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											  <strong>Warning!</strong> Version File Download Failed</div>';
			   }
			   // die;
            redirect('admin/versions');
        } else {
            redirect('admin');
        }
    }
    
	public function downloadVersionExtract($version_code){
        //echo "ram";
		if (_is_user_login($this)) {
			$file_path = FCPATH."\\uploads\\version\\version".$version_code.".zip";
			if(file_exists($file_path)){
				$main_path = str_replace('\\backend', '', FCPATH);
				// $main_path .= 'test\\';
				
				
				$zip = new ZipArchive;
				if ($zip->open($file_path) === TRUE) {
					$zip->extractTo($main_path);
					$zip->close();
					$mysql_query = $main_path."Database\\mysql_query.sql";
					
					if(file_exists($mysql_query)){
						$sql = file_get_contents($mysql_query);
						$sqls = explode(';', $sql);
						array_pop($sqls);
						
						foreach($sqls as $statement){
							if(!empty($statement)){
								$this->db->db_debug = FALSE;
								$this->db->query($statement);
							}							
						}
					}
					
					$this->db->where('titles','web_version');
					$this->db->update('company_setting',array('value' => $version_code));
					unlink($file_path);
					
					$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
											<i class="fa fa-check"></i>
								  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								  <strong>Success!</strong> Version File Installed successfully
								</div>');
				} else {
					$data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
													<i class="fa fa-warning"></i>
												  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												  <strong>Warning!</strong> Version File Install Failed</div>';
				}
			}
        
			redirect('admin/versions');
        } else {
            redirect('admin');
        }
    }
	
    public function upgradeVersion($id){
        if (_is_user_login($this)) {
            // $domainName     =   urlencode($_SERVER['HTTP_HOST']);    
            $domainName     =   base_url();
			$domainName = str_replace('/backend/', '', $domainName);
			$domainName = base64_encode($domainName);
			
            $data["active"] = "versions";
            // $url = $this->config->item('upgrade_version_url').'/'.$domainName.'/'.$id;
			$url = rtrim($this->config->item('superadmin_url'), '/').'/index.php/superadmin/get_upgrade_request/'.$domainName.'/'.$id;
            // echo $tutorial_url; exit;
             // Step 1
            $rajkumar = curl_init(); 
            // Step 2
            curl_setopt($rajkumar,CURLOPT_URL,$url);
            curl_setopt($rajkumar,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($rajkumar,CURLOPT_HEADER, false); 
            // Step 3
            $result = curl_exec($rajkumar);
			// echo '<pre>';
			// print_r($result);
			// die;
            // Step 4
            curl_close($rajkumar);
            // Step 5
            $result     =   json_decode($result, true);
            if($result['responce'] == true){
                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
						<i class="fa fa-check"></i>
					  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					  <strong>Success!</strong> '.$result['msg'].'</div>');
					  
            }
            else{
                 $this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible" role="alert">
						<i class="fa fa-check"></i>
					  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					  <strong>Error!</strong> '.$result['msg'].'</div>');
            }
            
            redirect('admin/versions');
            
            
       }
       else{
            redirect('admin');
       }
        
    }
    
    public function renewal_payment_insert(){
        if (_is_user_login($this) && !empty($_POST)) {
			$textField      =   $_POST;
			$domainName     =   base_url();
			$domainName = str_replace('/backend/', '', $domainName);
			$domainName = base64_encode($domainName);
			$data = array(
				'client_name'       => urlencode($textField['client_name']),
				'client_email'      => urlencode($textField['client_email']),
				'client_mobile'     => urlencode($textField['mobile_no']),
				'currency'          => urlencode($textField['currency']),
				'amount'            => urlencode($textField['amount']),
				'language'          => urlencode($textField['language']),
				'plan_id'           => urlencode($textField['plan_id']),
				'subscrib'          => urlencode($textField['subscrib']),
				'product_name'      => urlencode($textField['product_name']),
				'domain'        => urlencode($domainName) 
			);
			$fields_string      =   '';
			foreach($data as $key => $value) { 
				$fields_string .= $key.'='.$value.'&';
			}
			$fields_string  =   rtrim($fields_string, '&');
            
            
            $url = rtrim($this->config->item('superadmin_url'), '/').'/index.php/superadmin/plan_renewal_payment_insert';
			$tutorial_url   =    $url.'?'.$fields_string;
            // echo $url; exit;
             // Step 1
            $rajkumar = curl_init($url); 
            // Step 2
            curl_setopt($rajkumar,CURLOPT_URL,$tutorial_url);
            curl_setopt($rajkumar,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($rajkumar,CURLOPT_HEADER, false); 
            // Step 3
            $result = curl_exec($rajkumar);
            // Step 4
            curl_close($rajkumar);
            // Step 5
            // echo '<pre>'; print_r($result); exit;
			
			$res = json_decode($result, true);
			if(!empty($res['responce']) && $res['responce'] == 'success'){
				echo $result;
			}
			else{
				echo json_encode(array('response' => 'failure'));
			}
        }
		else{
			echo json_encode(array('response' => 'failure'));
		}
		die;

    }
    
    public function renewal_payment_success(){
        if (_is_user_login($this) && !empty($_POST)){
			$textField      =   $_POST;
			$user_id = $this->session->userdata("user_id");
			$data = array(
				'paymentid' => urlencode($textField['paymentid']),
				'order_id'  => urlencode($textField['order_id']),
				'sub_id'    => !empty($textField['sub_id'])? urlencode($textField['sub_id']) : '',
			);

			$fields_string      =   '';
			foreach($data as $key => $value) { 
				$fields_string .= $key.'='.$value.'&';
			}
			$fields_string  =   rtrim($fields_string, '&');
				
            $url   =   rtrim($this->config->item('superadmin_url'), '/').'/index.php/superadmin/plan_renewal_payment_success';
			$tutorial_url   =    $url.'?'.$fields_string;
            //echo $tutorial_url; exit;
             // Step 1
            
            $rajkumar = curl_init($url); 
            // Step 2
            curl_setopt($rajkumar,CURLOPT_URL,$tutorial_url);
            curl_setopt($rajkumar,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($rajkumar,CURLOPT_HEADER, false); 
            // Step 3
            $result = curl_exec($rajkumar);
            // Step 4
            curl_close($rajkumar);
            // Step 5
            // print_r($result); exit;
			$res = json_decode($result, true);
			if(!empty($res['response']) && $res['response'] == 'success'){
				echo $result;
			}
			else{
				echo json_encode(array('response' => 'failure'));
			}
            
            
        } 
		else{
			echo json_encode(array('response' => 'failure'));
		}
    }
    
    public function payment_detail(){
         if (_is_user_login($this)) {
            $data["active"] = "get_payment_details";
            $user_id = $this->session->userdata("user_id");
            // $tutorial_url   =   $this->config->item('upgrade_version_url').'/'.$user_id;
            $url = rtrim($this->config->item('superadmin_url'), '/').'/index.php/superadmin/get_payment_details/'.$user_id;
            //echo $url; exit;
             // Step 1
            $rajkumar = curl_init(); 
            // Step 2
            curl_setopt($rajkumar,CURLOPT_URL,$url);
            curl_setopt($rajkumar,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($rajkumar,CURLOPT_HEADER, false); 
            // Step 3
            $result = curl_exec($rajkumar);
            // Step 4
            curl_close($rajkumar);
            // Step 5
             //print_r($result); exit;
            $pData = json_decode($result);
            $data["UserPaymentData"]   = !empty($pData->payment_list)? $pData->payment_list : '';
            $data["UserPlanData"]   = !empty($pData->plan_detail)? $pData->plan_detail : '';
             //print_r($data); exit;
            $this->load->view('admin/orders/payment_detail', $data);
        } else {
            redirect('admin');
        }

    }
    
    
   
}
