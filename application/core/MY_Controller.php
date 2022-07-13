<?php
defined('BASEPATH') OR exit('No direct script access allowed');

trait CoreSystem {

    static private function setMenuLink($label, $title, $url, $html = '') {
        return array(
            'label' => $label,
            'title' => $title,
            'url' => $url, //base_url($url),
            'html' => $html
        );
    }

    public function output_parse($page_view_name, $send_data= NULL) {
        if (empty($send_data)) {
            $send_data = [];
        }
        $config_data = array(
            'base_url' => base_url()
        );
        $send_data = array_merge(self::menu(), $send_data, $config_data);
        $this->parser->parse($page_view_name, $send_data);
    }
    static public function jsonOutput($ResponseOutput) {
        self::setJSONHeaderResponse();
        echo json_encode($out_put);
    }
    static public function preOutput($out_put) {
        echo '<pre>';
        var_dump($out_put);
        echo '</pre>';
        echo '<br>';
    }

    static public function redirect_home() {
        redirect(base_url('home'), 'refresh');
    }

    static public function redirect_login() {
        redirect(base_url('login'), 'refresh');
    }

    static public function redirect_dashboard() {
        redirect(base_url('account'), 'refresh');
    }

    static public function setJSONHeaderResponse() {
        header("Content-Type: application/json");
    }

    static public function setHTMLHeaderResponse() {
        header('Content-Type: text/html; charset=utf-8');
    }

    static public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    static public function isJsonRequest() {
        return isset($_SERVER["CONTENT_TYPE"]) && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false;
    }

    static public function isHtmlRequest() {
        /*
         * Normal (GET) requests do not have a Content-Type header. 
         * For POST requests it would appear as $_SERVER["CONTENT_TYPE"], 
         * with a value like multipart/form-data or application/x-www-form-urlencoded.
         */
        //return ($_SERVER["CONTENT_TYPE"]);
        //return strpos($_SERVER["CONTENT_TYPE"], 'multipart/form-data') !== false;
        if (isset($_SERVER["CONTENT_TYPE"])) {
            return strpos($_SERVER["CONTENT_TYPE"], 'multipart/form-data') !== false || strpos($_SERVER["CONTENT_TYPE"], "application/x-www-form-urlencoded") !== false;
            ;
        } else {
            return FALSE;
        }
        /*
          return isset($_SERVER["CONTENT_TYPE"]) &&
          strpos($_SERVER["CONTENT_TYPE"], 'multipart/form-data')!== false || strpos($_SERVER["CONTENT_TYPE"], "application/x-www-form-urlencoded") !== false;
         * 
         */
    }

    static public function getJsonRequest() {
        return json_decode(file_get_contents('php://input'), true);
    }

}

trait MisUtil {

    private $session_data = array(
        'ADMIN_LOGIN_TYPE' => (-1),
        'logged_in' => false,
            /*
              'ah_name' => NULL,
              'ah_type' => NULL,
              'ah_roles' => NULL,
              'ah_email' => NULL,
             * 
             */
    );

    protected function menu() {
        $menu = array(
            'home' => self::setMenuLink('Home', 'Home', 'home'),
            'wishlist' => self::setMenuLink('Wishlist', 'Wishlist', 'wishlist', '<div class="wishlist"><a title="My Wishlist" href="{base_url}wishlist"><i class="fa fa-heart"></i><span class="hidden-xs">Wishlist</span></a></div>'),
            'resize_upload' => self::setMenuLink('ResizeUpload', 'Resize Upload', 'welcome/do_ResizeUpload'),
            'upload' => self::setMenuLink('Upload', 'Upload', 'welcome/do_upload'),
        );
        if (self::isLogin()) {
            $arr = array(
                'sag_panel' => self::setMenuLink('Sag Panel', 'Sag Panel', 'sag_panel'),
                'account' => self::setMenuLink('account', 'account', 'account', '<div class="myaccount"><a title="My Account" href="{base_url}my_account"><i class="fa fa-user"></i> <span class=" pl-5">My Account</span></a></div>'),
                'logout' => self::setMenuLink('logout', 'logout', 'logout', '<div class="logout"><a title="Logout" href="{base_url}logout"><i class="fa fa-lock"></i><span class=" pl-5">Logout</span></a></div>'),
            );
        } else {
            $arr = array(
                //'signin'=>self::setMenuLink('SignIn','Sign In','welcome/signin'),
                'login' => self::setMenuLink('Login', 'login', 'login', '<ul><li class="notLogged">
						         <img class="header-svg-icon img-responsive icon-delivery-location notLoggedPro" src="https://img.dmart.in/images/rwd/icons/profile.png" alt="signin"> 
						         <a class="dropdown-signin sticky-logo-menu opened" href="{base_url}registration" title="Sign-in">Sign-in</a> <a class="dropdown-register" href="{base_url}login?register" title="Register">Register</a></li></ul>
                '),
                'signup' => self::setMenuLink('SignUp', 'Sigin up', 'signup')
            );
        }
        return array('menu' => array_merge($menu, $arr));
    }

    public function isLogout() {
        if (!$this->isLogin())
            return FALSE;
        else
            return TRUE;
    }

    public function getWalletOnCheckout() {
        $checkout_wallet_info = FALSE;
        if ($this->isLogin()) {
            //echo $this->setting_model->getTotalCartAmount(); exit;
            $user_id                = $this->session->userdata('user_id');
            $user_cart_amount       = $this->setting_model->getTotalCartAmount();
            $user_wallet_amount     = $this->oauth_model->getMdbAccountWalletById($user_id);
            $checkout_wallet_info   = $this->setting_model->checkoutWallet($user_wallet_amount, $user_cart_amount);
        }
        return $checkout_wallet_info;
    }
	
	public function _order_limitation_validation(){
        if ($this->isLogin()) {
            $user_id                    = $this->session->userdata('user_id');
            $settings_arr               = $this->setting_model->get_settings();
            $settings_arr               = $settings_arr;
            $checkout_wallet_info       = $this->getWalletOnCheckout();
            $existing_wallet_amount     = $checkout_wallet_info['existing_wallet_amount'];
            $remaing_wallet_amount      = $checkout_wallet_info['remaing_wallet_amount'];
            $user_used_wallet_amount    = $checkout_wallet_info['used_wallet_amount'];
            $existing_cart_amount       = $checkout_wallet_info['existing_cart_amount'];
            $remaing_cart_amount        = $checkout_wallet_info['remaing_cart_amount'];
            $total_cart_amount          = $existing_cart_amount;
            //var_dump($settings_arr);
            if($total_cart_amount < $settings_arr[0]->value){
                $this->form_validation->set_message('_order_limitation_validation', 
                    'Order Not Allow Less Than : ' . $settings_arr[0]->value
                );
                return FALSE;
            }
            elseif($total_cart_amount>$settings_arr[1]->value){
                $this->form_validation->set_message('_order_limitation_validation', 
                    'Order Not Allow Greater Than : '  . $settings_arr[1]->value
                );
                return FALSE;
            }
            return TRUE;
        }
    }
    public function getWallet() {
        $user_wallet = FALSE;
        if ($this->isLogin()) {
            $user_id = $this->session->userdata('user_id');
            $user_wallet = $this->oauth_model->getMdbAccountWalletById($user_id);
            //var_dump($user_wallet);
        }
        return $user_wallet;
    }
    public function getUserWalletHistory() {
        $user_wallet_history = FALSE;
        if ($this->isLogin()) {
            $user_id = $this->session->userdata('user_id');
            $user_wallet_history = $this->users_model->getUserWalletHistory($user_id);
            //var_dump($user_wallet);
        }
        return $user_wallet_history;
    }

    public function place_order() {
       
        if ($this->isLogin()) {
            // echo '<pre>';
			// print_r($_POST);
			// die;
            $user_id = $this->session->userdata('user_id');
            $user_name = $this->session->userdata('user_name');
            $this->form_validation->set_rules('shipping_address',   'Shipping Address', 'trim|required|callback__order_limitation_validation');
            $this->form_validation->set_rules('shipping_date' ,     'Delivery Date', 'trim|required');
            $this->form_validation->set_rules('shipping_time_from', 'Delivery Time', 'trim|required');
            $this->form_validation->set_rules('coupan_amount_use', 'Coupan amount', 'trim');
    
            if ($this->form_validation->run() == FALSE) {
                //echo "123";
//           die();
//                $msg = array(
//                    'address_error' => "Plz.. Varified Shipping Address"
//                );
//                $msg = '"Plz.. Varified Shipping Address"';
                //print_r($this->form_validation->error_array());
                $this->session->set_flashdata('place_order_detalis', $this->form_validation->error_array());
                return FALSE;
            }
            $is_mange_wallet_history = false;
            // Delivery Date
            $delivery_date          = date('Y-m-d', strtotime(set_value('shipping_date')));
            // Delivery Time
            $delivery_time          = explode('-', (set_value('shipping_time_from')));
            $delivery_time_from     = date("h:i a", strtotime($delivery_time[0]));
            $delivery_time_to       = date("h:i a", strtotime($delivery_time[1]));
            
            $checkout_wallet_info   = $this->getWalletOnCheckout();
            //self::preOutput($checkout_wallet_info);
            $existing_wallet_amount = $checkout_wallet_info['existing_wallet_amount'];
            $remaing_wallet_amount  = $checkout_wallet_info['remaing_wallet_amount'];
            $user_used_wallet_amount = $checkout_wallet_info['used_wallet_amount'];
            $existing_cart_amount   = $checkout_wallet_info['existing_cart_amount'];
            $remaing_cart_amount    = $checkout_wallet_info['remaing_cart_amount'];
            $total_cart_amount      = $existing_cart_amount;
            $cart_amount_use        =   0;

            if (!empty(set_value('shipping_wallet_allow'))) {
                $total_cart_amount       = $remaing_cart_amount;
                $cart_amount_use         = $user_used_wallet_amount;
                $is_mange_wallet_history = TRUE;
            }
            $cart_product_arr            = $this->setting_model->getCartData();
            
            $total_items                = count($cart_product_arr);
            $total_kg = 0;
            $total_vat = 0;
            foreach ($cart_product_arr as $key => $product) {
                $product            = (object) $product;
                $row = $this->db->query('select stock_inv from product_varient WHERE varient_id ="'.$product->varient_id.'" AND  product_id ="'.$product->product_id.'" ')->row();
    			if(!empty($row)){
    				$quantity = $row->stock_inv;
    				$total_quantity = $quantity - $product->buy_qty;
    				$this->db->query('Update product_varient SET stock_inv = "'.$total_quantity.'" WHERE  varient_id ="'.$product->varient_id.'" AND product_id ="'.$product->product_id.'" '); 
    			}
    			
    			$q       = $this->db->query("Select deal_price from deal_product where product_id = '".$product->product_id."' AND pro_var_id='".$product->varient_id."' AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
				$del_price  =   0;
				if($q->num_rows() > 0){
				    $del_price          = $q->row();
				}
				if(!empty($del_price)){
					$product_price      = $del_price->deal_price;
				} else {
					$product_price      = $product->price;
				}
                
                $unit               = $product->unit;
                $unit_value         = $product->unit_value;
                
                
                $qty_in_kg = $product->qty;
                if ($unit == "gram") {
                    $qty_in_kg = ($product->qty * $unit_value) / 1000;
                }
                //$total_price = ($product->qty * $product->price);
                $total_kg += $qty_in_kg;

                $qty  = $product->buy_qty;
                $tax  = $product->tax;
                $total_vat += (($tax / 100) * $product_price) * $qty; //(($tax * $product_price) / 100) * $qty;
            }
            $coupanamount       =   0;
            $finalamount        =   $total_cart_amount;
            if(!empty($this->input->post('coupan_amount_use'))){
                $coupanamount   =   $this->input->post('coupan_amount_use');
                $total_cart_amount = $total_cart_amount - $this->input->post('coupan_amount_use');
                $finalamount = $total_cart_amount;
            }
            
            //$this->setting_model->insertUserOrderInCheckout($user_used_wallet_amount);
            $ld = $this->db->query("select user_location.*, pincode.*, 
				CONCAT_WS(' ', user_location.house_no, user_location.landmark, user_location.city, user_location.state, pincode.pincode) as address 
				from user_location
				inner join pincode on pincode.pincode = user_location.pincode
				where user_location.location_id = '" . set_value('shipping_address') . "'");
				
				
            $location = $ld->row();

            if ($finalamount >= $location->free_delivery_amount) {
                $location->delivery_charge = 0;
            }

            if (!empty(set_value('shipping_wallet_allow')) && $finalamount <= 0) {
                $cart_amount_use = $cart_amount_use + $location->delivery_charge;
            } else {
                $finalamount = $finalamount + $location->delivery_charge;
            }
            
            
            $payment_method = set_value('payment_type');
            
            if($payment_method == 'Cash On Delivery'){
                $paymentstatus = 0;
            }
            else
            {
                $paymentstatus = 3;
            }
            
            $plase_sale_order = array(
                'user_id'               => $user_id,
                'on_date'               => $delivery_date,
                "delivery_time_from"    => $delivery_time_from,
                "delivery_time_to"      => $delivery_time_to,
                'status'                => $paymentstatus,
                'note'                  => '',
                'is_paid'               => 0,
                'total_rewards'         => 0,
                'payment_method'        => set_value('payment_type'),
                'total_items'           => $total_items,
                'total_amount'          => $finalamount,
                'total_kg'              => $total_kg,
                'location_id'           => $location->location_id,
                'socity_id'             => 1,
                "created_at"            => date("Y-m-d H:i:s"),
                "signin_by"             => 'Web',
                'delivery_address'      => $location->address,
                'delivery_charge'       => $location->delivery_charge,
                'new_store_id'          => 1,
                'assign_to'             => 0,
                'coupan_amount_use'     => $coupanamount,
                'wallet_amount'         => $cart_amount_use,
                'vat_amount'            => number_format((float)$total_vat, 2, '.', ''),
                'order_by'              => $user_name
            );

            if (!empty(set_value('shipping_wallet_allow')) && $finalamount <= 0) {
                $totalAmount   =   $total_cart_amount;            
                //$cart_amount_use = $cart_amount_use 
            } else {
                $totalAmount   =   $total_cart_amount + $location->delivery_charge;
            }

			
			
           
            $this->db->insert('sale', $plase_sale_order);
            //echo $this->db->last_query(); exit;
            $sale_order_id = $this->db->insert_id();
            $transaction_Arr    =   array(
                                            'user_id'           =>  $user_id,
                                            'order_id'          =>  $sale_order_id,
                                            'transction_code'   =>  set_value('payment_type'),
                                            'description'       =>  "#".$order_id." purchase product amount is ".$this->config->item('currency')." ".$totalAmount."/ , coupan amount is ".$this->config->item('currency')." ".$coupanamount."/ and  AND delivery charges is ".$this->config->item('currency')." ".$location->delivery_charge."/",
                                            'cr'                =>   0,
                                            'dr'                =>   $totalAmount, 
                                            'status'            =>   0,
                                            'create_at'         =>   date("Y-m-d H:i:s"),
                                        );
             $this->db->insert('transaction', $transaction_Arr);
            //echo $sale_order_id; exit;
            if (!empty($sale_order_id)) {//Step - 2 -add Sele Item
                foreach ($cart_product_arr as $key => $product) {
                    $product = (object) $product;
                    
                    $unit               = $product->unit;
                    $unit_value         = $product->qty;
                    $q                  = $this->db->query("Select deal_price from deal_product where product_id = '".$product->product_id."' AND pro_var_id='".$product->varient_id."' AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
    				$del_price          = $q->row();
    				if(!empty($del_price)){
    					$product_price      = $del_price->deal_price;
    				} else {
    					$product_price      = $product->price;
    				}
                    
                    $qty_in_kg = $product->qty;
                    if ($unit == "gram") {
                        $qty_in_kg = ($product->qty * $unit_value) / 1000;
                    }
                    //$total_price = ($product->qty * $product->price);
                    $total_kg = $qty_in_kg;
                    $plase_sale_order_item = array(
                                                "product_id"    => $product->product_id,
                                                'pro_var_id'    => $product->varient_id,
                                                'product_name'  => $product->product_name,
                                                "qty"           => $product->buy_qty,
                                                "unit"          => $unit,
                                                "unit_value"    => $unit_value,
                                                "sale_id"       => $sale_order_id,
                                                "price"         => $product_price,
                                                "qty_in_kg"     => $qty_in_kg,
                                                "rewards"       => $product->rewards
                                            );
                    $this->db->insert('sale_items', $plase_sale_order_item);
                    $sale_item_id = $this->db->insert_id();
                    //$this->load->model("setting_model");
                    //$this->setting_model->deleteToCart($product->product_id);
                }
                if ($is_mange_wallet_history) {// Step - 3 & 4
                    /*                     * **********Step 3 - Update USer Wallet Account ************ */
                    $result_rew = $this->db
                            ->select('user_id')
                            ->select('salf_rafale_point')
                            ->select('wallet')
                            ->where('user_id', $user_id)
                            ->limit(1)
                            ->get('registers')
                            ->row();

                    if ($totalAmount < 0){
                        $dr_wallet_amount = ($user_used_wallet_amount + ($totalAmount)) + $location->delivery_charge;    
                    } else {
                        $dr_wallet_amount = $user_used_wallet_amount;
                    }
                            
                    $salf_rafale_point = $result_rew->salf_rafale_point - $dr_wallet_amount;
                    $salf_wallet = $result_rew->wallet - $dr_wallet_amount;
                                        
                    if ($totalAmount <= 0 ) {
                        $totalAmount = $totalAmount + $dr_wallet_amount;
                    } else {
                        $totalAmount = $totalAmount - $dr_wallet_amount;
                    }

                    $set_array = array(
                        "salf_rafale_point" => $salf_rafale_point,
                        "wallet" => $salf_wallet
                    );
                    $this->db->where('user_id', $user_id);
                    $this->db->update('registers', $set_array);
                    /*                     * **********Step 4 - Add User Wallet History ************ */
                    $msg = htmlspecialchars("“Debited For order Id : ”" . $sale_order_id);
                    $cr_wallet_amount = 0; //today
                    
                    $this->db->query("INSERT INTO `wallet_history` ( 
                        transaction_by, description,  `user_id`,  `cr_id`, `dr_id`, `created_date`) 
                        VALUES ('order_code','$msg',$user_id,$cr_wallet_amount,$dr_wallet_amount, '".date("Y-m-d H:i:s")."');
                    ");
                    
                    
                }
                //Delete Cart Data
                $this->load->model("setting_model");
                // $this->setting_model->deletesToCart();

            }
            //self::preOutput($_REQUEST);
            
            
            $place_order_detalis = array(
                'order_id'          => $sale_order_id,
                'order_price'       => $total_cart_amount,
                'delivery_date'     => $delivery_date,
                'fromtime'          => $delivery_time_from,
                'totime'            => $delivery_time_to,
                'delivery_charge'   => $location->delivery_charge
            );
           // print_r($place_order_detalis); exit;
            $this->session->set_flashdata('place_order_detalis', $place_order_detalis);
            //$this->session->keep_flashdata('place_order_detalis', $place_order_detalis);
            return $place_order_detalis;
        }
        return FALSE;
    }
	
	public function _check_pincode_service($pincode){
        if ($this->isLogin()) {
            $result_rew = $this->db
                            ->select('pincode')
                            ->where('pincode', $pincode)
                            ->get('pincode')
                            ->row();
							
            if(empty($result_rew)){
                $this->form_validation->set_message('_check_pincode_service', 
                    'We are not provide service For this Pincode '.$pincode.'.<br> Please Again Add Delivery Address with Other Pincode.'
                );
                return FALSE;
            }
            
            return TRUE;
        }
    }

    // isGuest | isClient | isAdmin | isManger | etc..
    public function insertLoginAddress() {
        $user_info = FALSE;
        if ($this->isLogin()) {
			$user_id = $this->session->userdata('user_id');
//            print_r($this->input->post());die();
            $this->form_validation->set_rules('address_pincode', 'Pincode', 'trim|required|callback__check_pincode_service');
            // $this->form_validation->set_rules('socity_id', 'Society', 'trim|required');
            $this->form_validation->set_rules('address_address', 'House', 'trim|required');
            $this->form_validation->set_rules('address_user_name', 'House', 'trim|required');
            $this->form_validation->set_rules('address_mobile_no', 'Mobile No.', 'trim|required'); //regex_match[/^[0-9]{10}$/]
           /* array(
                'pincode' => set_value('pincode'),
                'house_no' => set_value('house_no'),
                'socity_id' => set_value('socity_id'),
                'receiver_mobile' => set_value('receiver_mobile')
            );*/
            if ($this->form_validation->run() !== FALSE) {
				$default_address = $this->input->post('default_address');
				if(!empty($default_address)){
					$this->db->query('Update user_location SET default_address="0" WHERE user_id="'.$user_id.'"'); 
				}
				
	//            $socity_id = 1;
				$array = array(
					"user_id" => $user_id,
					"pincode" => set_value('address_pincode'),
					// "socity_id" => set_value('socity_id'),
					"house_no" => set_value('address_address'),
					"receiver_name" => set_value('address_user_name'),
					"receiver_mobile" => set_value('address_mobile_no'),
					"default_address" => set_value('default_address'),
                    "lat" => set_value('address_lat'),
                    "lang" => set_value('address_lang')
				);
	//            var_dump($array);die();
				$user_info = $this->oauth_model->addAddress($array);
				// echo "done quwery";
				// die();
                return $user_info;
            }
			else{
				$messge = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Wrong!</strong> '.implode(', ', $this->form_validation->error_array()).'
                                </div>';
                    
                    
                    
                $this->session->set_flashdata('shipping_address', $messge);
                return false;
				
			}
            
        }
        else
        {
            return false;
        }
       
        
    }

    public function getLoginUserInfo() {
        $user_info = FALSE;
        if ($this->isLogin()) {
            $user_id = $this->session->userdata('user_id');
            $user_info = $this->oauth_model->getMdbAccountById($user_id);
        }
        return $user_info;
    }

    public function getLoginUserAddresses() {
        $user_addresses = FALSE;
        if ($this->isLogin()) {
            $user_id = $this->session->userdata('user_id');
            $user_addresses = $this->oauth_model->getMdbAddressesById($user_id);
        }
        return $user_addresses;
    }

    public function isLogin() {
        if ($this->session->userdata('logged_in') == null || $this->session->userdata('logged_in') == false)
            return FALSE;
        else
            return TRUE;
    }

    protected function process_Logout() {
        $product =  $this->session->userdata('product');
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('ADMIN_LOGIN_TYPE');
        $this->session->unset_userdata('user_id');
        $message    =   "We hope you will back soon.";
        $this->session->set_flashdata('mess', $message);
        return TRUE;
    }
    protected function changePassword(){
        $this->form_validation->set_rules('update_profile_password_cur', 'Current Password', 'trim|required|xss_clean|min_length[6]');
        $this->form_validation->set_rules('update_profile_password', 'Password', 'trim|required|xss_clean|min_length[6]');
        $this->form_validation->set_rules('update_profile_passconf', 'Password Confirmation', 'trim|required|xss_clean|matches[update_profile_password]');
        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        }
        if ($this->isLogin()) {
            $user_id = $this->session->userdata('user_id');
            $userdata = $this->db->query("select * from  registers where user_id = $user_id ")->row();
            if($userdata->user_password == md5(set_value('update_profile_password_cur'))){
              
                $data = array(
                'user_password' => md5(set_value('update_profile_passconf')),
				
                );
                if (empty($data) || $this->oauth_model->updateProfileByUserId($user_id,$data) === FALSE) {
                   $messge = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Wrong!</strong> Not Match Email/Password. Please Re-Enter
                                </div>';
                    
                    
                    
                    $this->session->set_flashdata('error_msg', $messge);
                   // $this->session->keep_flashdata('error_msg', $messge['message']);
                    //$msg = "Invalid Email/Password  Error";
                    //$this->form_validation->set_message('changePassword', $messge);
                    return FALSE;
                } else {
                    //$message = 'Succcess Full Change Password..';
                    
                    $message = '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Succcess!</strong> Succcess Full Change Password..
                                </div>';
                    
                    //$messge = array('message' => 'Welcome To Eduncle Development Compamy', 'class' => 'alert alert-danger fade in');
                    $this->session->set_flashdata('changePassword', $message);
                    return TRUE;
                }  
            }else{
                    //$messge = array('message' => 'Old Password Not Matched', 'class' => 'alert alert-danger fade in');
                    
                    $messge = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Wrong!</strong> Old Password Not Matched. Please Re-Enter
                                </div>';
                
                    $this->session->set_flashdata('error_msg', $messge);
                    //$this->session->keep_flashdata('error_msg', $messge['message']);
                    //$msg = "Invalid Email/Password  Error";
                   // $this->form_validation->set_message('changePassword', $messge);
                    return FALSE;
            }
           
        }
    }
    protected function verifiy_ProfileUpdate(){
        $tbl_name = 'registers'; //$this->oauth->tablename;
        $this->form_validation->set_rules(
                'update_profile_useremail', 'Useremail', 'trim|xss_clean|valid_email', array()
        );
        $this->form_validation->set_rules(
                'update_profile_profilename', 'Username', 'trim|required|xss_clean', array(
                    'required' => 'You have not provided %s.',
                )
        );
        /*
        $this->form_validation->set_rules(
                'update_profile_mobile_no', 'Mobile No.', "trim|required|xss_clean|regex_match[/^[0-9]{10}$/]|is_unique[$tbl_name.user_phone]", //
                array(
                'required' => 'You have not provided %s.',
                'is_unique'     => 'This %s already exists.'
                )
        );
         * 
         */
        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        }
        $this->form_validation->set_rules('process_login', 'process_login', 'callback__processProfileUpdate');
        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function _processProfileUpdate(){
        if ($this->isLogin()) {
            $user_id = $this->session->userdata('user_id');
            $data = array(
                'user_email' => set_value('update_profile_useremail'),
                'user_fullname' => set_value('update_profile_profilename')
            );
            if (empty($data) || $this->oauth_model->updateProfileByUserId($user_id,$data) === FALSE) {
                $messge = array('message' => 'Wrong Not Match Email/Password Enter', 'class' => 'alert alert-danger fade in');
                $this->session->set_flashdata('error_msg', $messge);
                $this->session->keep_flashdata('error_msg', $messge);
                //$msg = "Invalid Email/Password  Error";
                $this->form_validation->set_message('_processProfileUpdate', $messge['message']);
                return FALSE;
            } else {
                //$messge = array('message' => 'Welcome To Eduncle Development Compamy', 'class' => 'alert alert-danger fade in');
                
                $messge = '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Updated Your Profile.
                                </div>';
                
                $this->session->set_flashdata('login_load_msg', $messge);
                $this->session->keep_flashdata('item', $messge);
                return TRUE;
            }
        }
        else{
//            $messge = array('message' => 'Wrong Not Match Login, Plz...', 'class' => 'alert alert-danger fade in');
//            $this->form_validation->set_message('_processProfileUpdate', $messge['message']);
            return FALSE;
        }
    }
    protected function verifiy_Login() {
        
        //$this->form_validation->set_rules('useremail', 'Email', 'trim|required|xss_clean|valid_email');
        //$this->form_validation->set_rules('mobile_no', 'Mobile No.', 'trim|required|xss_clean');
        $this->form_validation->set_rules(
                'mobile_no', 'Mobile No.', 'trim|required|xss_clean|regex_match[/^[0-9]{10}$/]', //|is_unique[registers.user_phone]
                array(
            'required' => 'You have not provided %s.',
                //'is_unique'     => 'This %s already exists.'
                )
        );
        $this->form_validation->set_rules(
                'password', 'Password', 'trim|required|xss_clean', array(
            'required' => 'You have not provided %s.',
                )
        );
        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        }
        $this->form_validation->set_rules('process_login', 'process_login', 'callback__process_login');
        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function _process_login() {
        $data = array(
            'eRemember' => $this->input->post('login_remember_me'),
            //'ah_email' => $this->input->post('useremail'),
            'ah_mobile' => $this->input->post('mobile_no'),
            'ah_password' => $this->input->post('password')
        );
        $this->set_Login_Remember_Me($data);
        $oauth_data_recorde = $this->oauth_model->checkLoginByMobile($data['ah_mobile'], $data['ah_password']);
	        if($oauth_data_recorde== FALSE){
            //$messge = array('message' => 'Your Password Not Matched', 'class' => 'alert alert-danger fade in');
            $messge = array('message' => 'User Not Exist. Please Register', 'class' => 'alert alert-danger fade in');
            $this->session->set_flashdata('error_msg', $messge);
            $this->session->keep_flashdata('error_msg', $messge);

            //$msg = "Invalid Mobile/Password  Error";
            $this->form_validation->set_message('_process_login', $messge['message']);
            return FALSE;
        }
        else if ($oauth_data_recorde == 2) {
            $messge = array('message' => 'Your Account is Blocked. Please Contact Admin.', 'class' => 'alert alert-danger fade in');
            $this->session->set_flashdata('error_msg', $messge);
            $this->session->keep_flashdata('error_msg', $messge);

            //$msg = "Invalid Mobile/Password  Error";
            $this->form_validation->set_message('_process_login', $messge['message']);
            return FALSE;
        }
        else if ($oauth_data_recorde == 3) {
            $messge = array('message' => 'Password Not Matched. Please Re-enter.', 'class' => 'alert alert-danger fade in');
            $this->session->set_flashdata('error_msg', $messge);
            $this->session->keep_flashdata('error_msg', $messge);

            //$msg = "Invalid Mobile/Password  Error";
            $this->form_validation->set_message('_process_login', $messge['message']);
            return FALSE;
        } else {
           //print_r($oauth_data_recorde); exit;
            $this->setAccountSessionInfo($oauth_data_recorde);
            $messge = array('message' => 'Welcome To Ecommerce', 'class' => 'alert alert-success fade in');
            $this->session->set_flashdata('login_load_msg', $messge);
             $messages    = "Hello ".$oauth_data_recorde->user_fullname.". Welcome to ".$this->config->item('name');
            $this->session->set_flashdata('mess', $messages);
            $this->session->keep_flashdata('item', $messge);
            return TRUE;
        }
    }

    public function setAccountSessionInfo($oauth_data_recorde) {
        $this->session_data = array(
            'ADMIN_LOGIN_TYPE' => 1,
            'logged_in' => TRUE,
            /*
              'ah_name' => $oauth_data_recorde['ah_name'],
              'ah_name' => $oauth_data_recorde['ah_name'],
              'ah_type' => $oauth_data_recorde['ah_type'],
              'ah_roles' => $oauth_data_recorde['ah_roles'],
              'ah_email' => $oauth_data_recorde['ah_email']
             * 
             */
            'user_id' => $oauth_data_recorde->user_id,
            'user_name' => $oauth_data_recorde->user_fullname
        );
        $this->session->set_userdata($this->session_data);
    }

    protected function verifiy_Registration() {
        $tbl_name = 'registers'; //$this->oauth->tablename;
        
        $this->form_validation->set_rules(
                'reg_profilename', 'profilename', "trim|required|xss_clean", array(
                        'required'  => 'You have not provided %s.'
                )
        );
        $this->form_validation->set_rules(
                'reg_useremail', 'Email', "trim|xss_clean",
                array(
                        'required'  => 'You have not provided %s.',
                        'is_unique' => 'This %s already exists.'
                )
        );
        $this->form_validation->set_rules(
                'reg_mobile_no', 'Mobile No.', "trim|required|xss_clean|regex_match[/^[0-9]{10}$/]|is_unique[$tbl_name.user_phone]", //
                array(
                        'required'  => 'You have not provided %s.',
                        'is_unique' => 'This %s already exists.'
                )
        );

        $this->form_validation->set_rules(
                'reg_private_policy', 'Private Policy', "trim|required", array(
                        'required'  => 'You have not provided %s.',
                )
        );

         $this->form_validation->set_rules('reg_referral_code', 'Referral Code', "trim");
        //$this->form_validation->set_rules('send_otp', 'send_otp', "trim|required");
        $this->form_validation->set_rules('reg_password', 'Password', 'trim|required|xss_clean|min_length[6]');
        // $this->form_validation->set_rules('reg_passconf', 'Password Confirmation', 'trim|required|xss_clean|matches[reg_password]');

        if ($this->form_validation->run() == FALSE) {
           /// print_r(); exit;
            $this->session->set_flashdata('login_load_msg', $this->form_validation->error_string());
            return FALSE;
        }
        //"send_otp"              =>  set_value('send_otp'),
        $parameter = array(
            "user_fullname"         =>  set_value('reg_profilename'),
            "user_phone"            =>  set_value('reg_mobile_no'),
            "user_email"            =>  set_value('reg_useremail'),
            "user_password"         =>  md5(set_value('reg_password')),
            'user_rafale_code'      =>  set_value('reg_referral_code')
        );
        
        $this->form_validation->set_rules(
                'process_registration', 'process_registration', 'callback__process_registration[' .
                json_encode($parameter)
                . ']'
        );
        
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('login_load_msg', $this->form_validation->error_string());
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function _process_registration($str, $data_json) {
        $data = json_decode($data_json, TRUE);
        
        if (empty($data) || $this->oauth_model->setMemberAccount($data) === FALSE) {
            $messge = array('message' => 'SomeThing Went Wrong !!', 'class' => 'alert alert-danger fade in');
            $this->session->set_flashdata('error_msg', $messge);
            $this->session->keep_flashdata('error_msg', $messge);
            //$msg = "Invalid Email/Password  Error";
            $this->form_validation->set_message('login_load_msg', "SomeThing Went Wrong");
            return FALSE;
        } else {
            //array('message' => '  ', 'class' => 'alert alert-danger fade in')
            $messge = "You have successfully registered.";
            //print_r($messge); exit;
            $this->session->set_flashdata('login_load_msg', $messge);
            $this->session->keep_flashdata('login_load_msg', $messge);
            return TRUE;
        }
    }

    public function trash_Account() {
        
    }

    public function activation_Account() {
        
    }

    public function verification_Account_By_Email() {
        
    }

    public function verification_Account_By_Mobile() {
        
    }

    public function block_Account() {
        
    }

    public function forget_Account_Password() {
        
    }

    public function createLog() {
        $browser = $this->CI->agent->browser();
        $version = $this->CI->agent->version();
        $platform = $this->CI->agent->platform();
        $mobile = $this->CI->agent->mobile();
        $operating_system = ($mobile != "") ? $platform . '-' . $mobile : $platform;
        $data = array(
            'user_id' => '1',
            'email' => $this->CI->input->post('email'),
            'login_date' => date("Y-m-d H:i:s"),
            'login_ip' => $_SERVER['REMOTE_ADDR'],
            'operating_system' => $operating_system,
            'browser' => $browser . "-Version-" . $version
        );
        $this->CI->db->insert($this->tablenameLog, $data);
        //echo $this->CI->db->last_query(); die;
        return TRUE;
    }

    public function set_Login_Remember_Me($data) {
        $this->load->helper('cookie');
        $postarr = $data;
        if ($postarr['eRemember'] == 'on') {
            $cookie = array(
                'name' => 'nspl_mobile_no',
                'value' => $postarr['ah_email'],
                'expire' => 86500,
                'secure' => false
            );

            $this->input->set_cookie($cookie);
            $cookie = array(
                'name' => 'nspl_password',
                'value' => $postarr['ah_password'],
                'expire' => 86500,
                'secure' => false
            );
            $this->input->set_cookie($cookie);
        } else {
            delete_cookie('nspl_username');
            delete_cookie('nspl_password');
        }
    }

    function doEntry() {
        $this->db->set('member_id', $this->session->userdata('SAG_mem_id'));
        $this->db->set('login_time', date('Y-m-d H:i:s'));
        $query = $this->db->insert($this->tablename);
    }

    public function setSession($data) {
        $data = array();
        $this->CI->session->set_userdata($data);
        /* $this->CI->session->set_userdata('SAG_mem_id', $adminRow->id);
          $this->CI->session->set_userdata('PRIVILEDGES', $adminRow->privileges);
          $this->CI->session->set_userdata('SAG_membername', $adminRow->name);
          $this->CI->session->set_userdata('profile_image', $adminRow->profile_image); */
    }

    public function getSession($key) {
        
    }

    public function get_Account_Information() {
        
    }

    public function set_Account_Session() {
        
    }

    public function get_Account_History() {
        
    }

    public function set_Account_History() {
        
    }

    public function get_Account_Roles() {
        
    }

    public function set_Account_Roles() {
        
    }

}

trait CoreUtil {
    /* This is a simple function that allows you to generate random strings containing 
     * Letters and Numbers (alphanumeric). 
     * You can also limit the string length. 
     * These random strings can be used for various purposes, 
     * including: Referral Code, Promotional Code, Coupon Code. Function relies on following 
     * PHP functions: base_convert, sha1, uniqid, mt_rand
     * Sample Output : a7d9e8
     */

    function random_code($length) {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
    }

//echo random_code(6);
    /*
     * purposes Of : Lisation Code, Vission Code, 
     * Output : b57d0c6b-e34c-438c-80c4-14d53e7e499a
     */
    function generate_uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0C2f) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0x2Aff), mt_rand(0, 0xffD3), mt_rand(0, 0xff4B)
        );
    }

    /*
     * purposes Of : Lisation Code, Vission Code, 
     * Sample Output : ro@123167pr1bmkHouK

      $tokenparta = generateRandomString(10);
      $timestampz=time();
      //$token = $timestampz*3 . $tokenparta;
      $pre_string = sprintf( '%s%s%03d',substr('robin', 0, 2),substr('online@123',-4),mt_rand( 0, 0777 ));
      $uniq_link = $pre_string . $tokenparta;
      echo "<br/>".$uniq_link;
     */

    function generateRandomString($length = 60) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $rand = $characters[rand(0, $charactersLength - 1)];
            //echo "$rand";
            $randomString .= $rand;
        }
        return $randomString;
    }

}

class My_Controller extends CI_Controller {

    use CoreSystem,
        MisUtil,
        CoreUtil;

    public function __construct() {
        parent::__construct();
        $this->load->model('Oauth_model', 'oauth_model');
        $this->load->model("Products_model", 'products_model');
        $this->load->model("Setting_model", "setting_model");
        $this->load->model("Users_model", "users_model");
        $this->load->helper('date');
        $this->load->helper('cookie');
        $this->load->library('parser'); //  Load form helper library
        $this->load->helper('url'); //  Load form helper library
        $this->load->helper("security"); //  xss_clean is part of security helper.//$data = $this->security->xss_clean($data);
        //  The User Agent Class provides functions that help identify information about the browser, mobile device, or robot visiting your site.
        $this->load->library('user_agent');
        $this->load->database(); //  Load database library
        $this->load->helper('form');
        $this->load->library('form_validation'); //  Load form validation library
        $this->load->library('session'); //  Load session library
        $this->form_validation->set_error_delimiters('<div class="error_msg text-warning">', '</div>');
    }

}

?>