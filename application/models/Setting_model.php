<<<<<<< HEAD
<?php

//$this->load->model("product_model");
class Setting_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('cookie');
    }

    public function getPageDescri($pg_slug){
        $row = $this -> db
            -> select('pg_descri')
            -> where('pg_slug', $pg_slug)
            -> limit(1)
            -> get('pageapp')
            -> row_array();
        return $row;
        $q = $this->db->query("Select * from banner WHERE pg_slug = $pg_slug LIMIT 1");
        return $q->result_array();
    }

    // Array Search Function
    function searchArrayKeyVal($sKey, $id, $array) {
        //http://phpfiddle.org/lite/code/8id5-m032
        foreach ($array as $key => $val) {
            if ($val[$sKey] == $id) {
                return $key;
            }
        }
        return false;
    }

    function search_revisions($dataArray, $search_value, $key_to_search, $other_matching_value = null, $other_matching_key = null) {
        /*
          $findKey = $this->search_revisions($product_arr,$product_id, 'product_id');
          print_r($findKey);
         * 
          // This function will search the revisions for a certain value
          // related to the associative key you are looking for.
         * 
         */
        $keys = array();
        foreach ($dataArray as $key => $cur_value) {
            if ($cur_value[$key_to_search] == $search_value) {
                if (isset($other_matching_key) && isset($other_matching_value)) {
                    if ($cur_value[$other_matching_key] == $other_matching_value) {
                        $keys[] = $key;
                    }
                } else {
                    // I must keep in mind that some searches may have multiple
                    // matches and others would not, so leave it open with no continues.
                    $keys[] = $key;
                }
            }
        }
        return $keys;
    }

    private function setCartCookie($prod_arr) {
        $prod = json_encode($prod_arr);
        $cookie = array(
            'name' => 'product',
            'value' => $prod,
            'expire' => time() + 86500,
        );
        $data = array('product' => $prod);
        $this->session->set_userdata($data);
        //$this->input->set_cookie($cookie);
    }

    function countCartItem() {
        $prod = array();
        if ($this->session->userdata("product")) {
            $prod = json_decode($this->session->userdata("product"), TRUE);
        }
        return count($prod);
    }

    function checkoutWallet($user_wallet_amount, $user_cart_amount) {
        $exist_wallet = $user_wallet_amount;
        $existing_cart_amount = $user_cart_amount;
        if ($user_wallet_amount >= $user_cart_amount) {
            $final_amount = $exist_wallet;
            $walletdeductValue = $this->config->item('wallet_deduction');
            //$user_wallet_amount = $user_cart_amount * ($walletdeductValue/100);
            $remainingWalletAmount =  $user_wallet_amount - $user_cart_amount;
            $final_amount -= $user_wallet_amount;
            $balance = $user_cart_amount - $user_wallet_amount;
            $data = array(
                "existing_wallet_amount" => number_format($exist_wallet, 2, '.', ''),
                "remaing_wallet_amount" => number_format($remainingWalletAmount, 2, '.', ''),
                "used_wallet_amount" => number_format($user_cart_amount, 2, '.', ''),
                "existing_cart_amount" => number_format($existing_cart_amount, 2, '.', ''),
                "remaing_cart_amount" => number_format($final_amount, 2, '.', ''),
            );
        } elseif ($user_wallet_amount <= $user_cart_amount) {
            $final_amount = $exist_wallet;
            $walletdeductValue = $this->config->item('wallet_deduction');
            //$user_wallet_amount *= ($walletdeductValue/100);
            $final_amount -= $user_wallet_amount;
            $balance = $user_cart_amount - $user_wallet_amount;
            //number_format(, 2, '.', '')
            $data = array(
                "existing_wallet_amount" => number_format($exist_wallet, 2, '.', ''),
                "remaing_wallet_amount" => number_format($final_amount, 2, '.', ''),
                "used_wallet_amount" => number_format($user_wallet_amount, 2, '.', ''),
                "existing_cart_amount" => number_format($existing_cart_amount, 2, '.', ''),
                "remaing_cart_amount" => number_format($balance, 2, '.', ''),
            );
        }
        //print_r($data); exit;
        return $data;
    }

    function getTotalCartAmount() {
        $total_order_price = 0;
        $total_tax_price = 0;
        $get_cart_product_arr = $this->getCartData();
       // print_r($get_cart_product_arr); exit;
        foreach ($get_cart_product_arr as $key => $product) {
            
            $qty                    = $product['buy_qty'];
            $unit                   = $product['unit'];
            $product_price          = !empty($product['deal_price']) ? $product['deal_price'] : $product['price'];
            $unit_value             = $product['unit_value'];
            $tax                    = $product['tax'];
            $total_product_price    = $product_price * $qty;
            $total_order_price      += $total_product_price;
            $total_tax_price += (($tax / 100) * $product_price) * $qty; //(($tax * $product_price) / 100) * $qty;
        }
        return $total_order_price + $total_tax_price;
    }

    public function getCartData() {
        $getProductRow = array();
        $product_arr = $this->getToCart();
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
        $cart_product_arr = $getProductRow;
        return $cart_product_arr;
    }

    function getToCart() {
        $prod = array();
        if ($this->session->userdata("product")) {
            $prod = json_decode($this->session->userdata("product"), TRUE);
        }
        //print_r($prod); exit;
        return ($prod);
        // Using the $records array from Example #1
        /*
          $products = array_column($prod, 'qty', 'product_id');
          print_r($products);
          return $products;
         * 
         */
    }

    function addToCart($product_id, $product_varient_id, $qty, $stock) {
       
        //echo $product_varient_id."".$qty; die;
        $this->load->helper('cookie');
        $this->load->library('session');
        $product_arr = array();
        $isUpdate = $this->session->userdata("product"); 
        if ($this->session->userdata("product")) {
            $product_arr = json_decode($this->session->userdata("product"), TRUE);
        }
       
        if(!empty($product_arr)){
            $isProductFound = false;
            $arrayLength = count($product_arr);
            foreach ($product_arr as $key => $product) {
                if (empty($product['product_id']) || empty($product['buy_qty'])) {
                    unset($product_arr[$key]);
                }

                if (($product_id == $product['product_id']) && !$isProductFound) {
                    if($product_varient_id == $product['product_varient_id']){
                        
                        $arrayKey = $this->searchArrayKeyVal("product_varient_id", $product_varient_id, $product_arr);
                        $product_arr[$arrayKey]['buy_qty']  = $product_arr[$arrayKey]['buy_qty'] + $qty;
                        $isProductFound = true;
                    }
                    elseif ($arrayLength <= $key + 1 && !$isProductFound) {
                        $product_arr[] = array(
                            'product_id'            => $product_id,
                            'product_varient_id'    => $product_varient_id,
                            'buy_qty'               => $qty,
                            'stock'                 => $stock
                        );
                    }
                   
                    //unset($product_arr[$arrayKey]);
                }
                else{
                    if($this->searchArrayKeyVal("product_id", $product_id, $product_arr) === false){
                        $product_arr[] = array(
                            'product_id'            => $product_id,
                            'product_varient_id'    => $product_varient_id,
                            'buy_qty'               => $qty,
                            'stock'                 => $stock
                        );
                    }
                }
            }
        } else {
            $product_arr[] = array(
                        'product_id'            => $product_id,
                        'product_varient_id'    => $product_varient_id,
                        'buy_qty'               => $qty,
                        'stock'                 => $stock
                    );
        };
        
        
     
        
        $product_arr = json_encode($product_arr);
        $cookie = array(
            'name' => 'product',
            'value' => $product_arr,
            'expire' => time() + 86500,
        );
        $data  = array('product' => $product_arr);
        $this->session->set_userdata($data);
        ///print_r($this->session->userdata('product')); exit;
        //$this->input->set_cookie($cookie);
    }
    
     function addToCarts($product_id, $product_varient_id, $qty,$keys) {
       
        //echo $product_varient_id."".$qty; die;
        $this->load->helper('cookie');
        $this->load->library('session');
        $product_arr = array();
        if ($this->session->userdata("product")) {
            $product_arr = json_decode($this->session->userdata("product"), TRUE);
        }
        
        if(!empty($product_arr)){
            $isProductFound = false;
            foreach ($product_arr as $key => $product) {
                if (empty($product['product_id']) || empty($product['buy_qty'])) {
                    unset($product_arr[$key]);
                }
                if (($product_id == $product['product_id']) && !$isProductFound) {
                    if($product_varient_id == $product['product_varient_id']){
                        $isProductFound = true;
                        $arrayKey = $this->searchArrayKeyVal("product_varient_id", $product_varient_id, $product_arr);
                        if($keys == 'plus'){ 
                            $product_arr[$arrayKey]['buy_qty']  = $product_arr[$arrayKey]['buy_qty'] + 1;
                        }
                        elseif($keys == 'minus'){
                            $product_arr[$arrayKey]['buy_qty']  = $product_arr[$arrayKey]['buy_qty'] - 1;
                        }
                    }
                    // else{
                    //     $product_arr[] = array(
                    //         'product_id'            => $product_id,
                    //         'product_varient_id'    => $product_varient_id,
                    //         'buy_qty'               => $qty
                    //     );
                    // }
                }
                
            }
        }
        
        
        
      //print_r($product_arr); exit; 
        
        $product_arr = json_encode($product_arr);
        $cookie = array(
            'name' => 'product',
            'value' => $product_arr,
            'expire' => time() + 86500,
        );
        $data  = array('product' => $product_arr);
        $this->session->set_userdata($data);
       // print_r($this->session->userdata('product')); exit;
        //$this->input->set_cookie($cookie);
    }
    

    function deleteToCart($product_id, $product_varient_id) {
        /* $cookie = array(
          'name' => 'product',
          'value' => '',
          'expire' => '0',
          );
          delete_cookie($cookie);
         * 
         */
        //$product_arr = $this->setting_model->getToCart();
        $product_arr = $this->getToCart();
        foreach ($product_arr as $key => $product) {
           // print_r($product); exit;
            if (empty($product['product_id']) || empty($product['buy_qty'])) {
                unset($product_arr[$key]);
            }
        }
        $arrayKey = $this->searchArrayKeyVal("product_varient_id", $product_varient_id, $product_arr);
        unset($product_arr[$arrayKey]);
        $this->setCartCookie($product_arr);
    }

    function deletesToCart() {
        $this->session->unset_userdata("product");
    }

    function updateToCart($product_id, $qty) {
        
    }

    function getSliders() {
        $q = $this->db->query("Select * from slider where trash=0");
        return $q->result_array();
    }

    function getBanner() {
        $q = $this->db->query("Select * from banner where trash=0");
        return $q->result_array();
    }

    function getFeatureBanner() {
        $q = $this->db->query("Select * from feature_slider where trash=0");
        return $q->result_array();
        /*
         * $slider_status = $value['slider_status'];
          $slider_title = $value['slider_title'];
          $slider_image = $slider_img_url.$value['slider_image'];
         */
    }

    function get_settings() {
        $q = $this->db->query("Select * from settings");
        return $q->result();
    }

    function get_setting_by_id($id) {
        $q = $this->db->query("Select * from settings where id = '" . $id . "'");
        return $q->row();
    }

    /*     * *********Robin Sir********** */

    function insertReferralPoint($referral_point) { // Not OK
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
    function order_sms($user_id, $message) {//OK
        $user_phone = $this->db
                        ->select('user_phone')
                        ->where('user_id', $user_id)
                        ->limit(1)
                        ->get('registers')
                        ->row()
                ->user_phone;
        $this->sendsmsPOST($user_phone, $message);
    }

    // SEND SMS
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
    
    public function getCouponList($uni_id){
        $today_date = date('Y-m-d');
        $today_date = date('Y-m-d');
        $coupons    =   array();
        
        $coupons_list = $this->db->query('SELECT tbl_coupons.*,tbl_coupons.coupon_id as coupon_uni_id,tbl_coupon_apply.*,COUNT(tbl_coupon_apply.coupon_id) = tbl_coupons.uses_restriction as used_coupon FROM tbl_coupons 
											LEFT JOIN tbl_coupon_apply ON tbl_coupon_apply.coupon_id = tbl_coupons.coupon_id AND tbl_coupon_apply.user_id = "'.$uni_id.'" AND tbl_coupon_apply.coupon_apply_status = 1
											WHERE tbl_coupons.coupon_status=1 AND tbl_coupons.trash=0 AND tbl_coupons.valid_from <= "'.$today_date.'" AND tbl_coupons.valid_to >="'.$today_date.'" GROUP BY tbl_coupons.coupon_id
											ORDER BY  tbl_coupons.coupon_id DESC');
											
        if($coupons_list->num_rows() > 0){
          $coupons  =     $coupons_list->result_array();
        }
        return $coupons;
    }
    public function checkCouponCode($uni_id,$coupon_code)
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

=======
<?php

//$this->load->model("product_model");
class Setting_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('cookie');
    }

    public function getPageDescri($pg_slug){
        $row = $this -> db
            -> select('pg_descri')
            -> where('pg_slug', $pg_slug)
            -> limit(1)
            -> get('pageapp')
            -> row_array();
        return $row;
        $q = $this->db->query("Select * from banner WHERE pg_slug = $pg_slug LIMIT 1");
        return $q->result_array();
    }

    // Array Search Function
    function searchArrayKeyVal($sKey, $id, $array) {
        //http://phpfiddle.org/lite/code/8id5-m032
        foreach ($array as $key => $val) {
            if ($val[$sKey] == $id) {
                return $key;
            }
        }
        return false;
    }

    function search_revisions($dataArray, $search_value, $key_to_search, $other_matching_value = null, $other_matching_key = null) {
        /*
          $findKey = $this->search_revisions($product_arr,$product_id, 'product_id');
          print_r($findKey);
         * 
          // This function will search the revisions for a certain value
          // related to the associative key you are looking for.
         * 
         */
        $keys = array();
        foreach ($dataArray as $key => $cur_value) {
            if ($cur_value[$key_to_search] == $search_value) {
                if (isset($other_matching_key) && isset($other_matching_value)) {
                    if ($cur_value[$other_matching_key] == $other_matching_value) {
                        $keys[] = $key;
                    }
                } else {
                    // I must keep in mind that some searches may have multiple
                    // matches and others would not, so leave it open with no continues.
                    $keys[] = $key;
                }
            }
        }
        return $keys;
    }

    private function setCartCookie($prod_arr) {
        $prod = json_encode($prod_arr);
        $cookie = array(
            'name' => 'product',
            'value' => $prod,
            'expire' => time() + 86500,
        );
        $data = array('product' => $prod);
        $this->session->set_userdata($data);
        //$this->input->set_cookie($cookie);
    }

    function countCartItem() {
        $prod = array();
        if ($this->session->userdata("product")) {
            $prod = json_decode($this->session->userdata("product"), TRUE);
        }
        return count($prod);
    }

    function checkoutWallet($user_wallet_amount, $user_cart_amount) {
        $exist_wallet = $user_wallet_amount;
        $existing_cart_amount = $user_cart_amount;
        if ($user_wallet_amount >= $user_cart_amount) {
            $final_amount = $exist_wallet;
            $walletdeductValue = $this->config->item('wallet_deduction');
            //$user_wallet_amount = $user_cart_amount * ($walletdeductValue/100);
            $remainingWalletAmount =  $user_wallet_amount - $user_cart_amount;
            $final_amount -= $user_wallet_amount;
            $balance = $user_cart_amount - $user_wallet_amount;
            $data = array(
                "existing_wallet_amount" => number_format($exist_wallet, 2, '.', ''),
                "remaing_wallet_amount" => number_format($remainingWalletAmount, 2, '.', ''),
                "used_wallet_amount" => number_format($user_cart_amount, 2, '.', ''),
                "existing_cart_amount" => number_format($existing_cart_amount, 2, '.', ''),
                "remaing_cart_amount" => number_format($final_amount, 2, '.', ''),
            );
        } elseif ($user_wallet_amount <= $user_cart_amount) {
            $final_amount = $exist_wallet;
            $walletdeductValue = $this->config->item('wallet_deduction');
            //$user_wallet_amount *= ($walletdeductValue/100);
            $final_amount -= $user_wallet_amount;
            $balance = $user_cart_amount - $user_wallet_amount;
            //number_format(, 2, '.', '')
            $data = array(
                "existing_wallet_amount" => number_format($exist_wallet, 2, '.', ''),
                "remaing_wallet_amount" => number_format($final_amount, 2, '.', ''),
                "used_wallet_amount" => number_format($user_wallet_amount, 2, '.', ''),
                "existing_cart_amount" => number_format($existing_cart_amount, 2, '.', ''),
                "remaing_cart_amount" => number_format($balance, 2, '.', ''),
            );
        }
        //print_r($data); exit;
        return $data;
    }

    function getTotalCartAmount() {
        $total_order_price = 0;
        $total_tax_price = 0;
        $get_cart_product_arr = $this->getCartData();
       // print_r($get_cart_product_arr); exit;
        foreach ($get_cart_product_arr as $key => $product) {
            
            $qty                    = $product['buy_qty'];
            $unit                   = $product['unit'];
            $product_price          = !empty($product['deal_price']) ? $product['deal_price'] : $product['price'];
            $unit_value             = $product['unit_value'];
            $tax                    = $product['tax'];
            $total_product_price    = $product_price * $qty;
            $total_order_price      += $total_product_price;
            $total_tax_price += (($tax / 100) * $product_price) * $qty; //(($tax * $product_price) / 100) * $qty;
        }
        return $total_order_price + $total_tax_price;
    }

    public function getCartData() {
        $getProductRow = array();
        $product_arr = $this->getToCart();
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
        $cart_product_arr = $getProductRow;
        return $cart_product_arr;
    }

    function getToCart() {
        $prod = array();
        if ($this->session->userdata("product")) {
            $prod = json_decode($this->session->userdata("product"), TRUE);
        }
        //print_r($prod); exit;
        return ($prod);
        // Using the $records array from Example #1
        /*
          $products = array_column($prod, 'qty', 'product_id');
          print_r($products);
          return $products;
         * 
         */
    }

    function addToCart($product_id, $product_varient_id, $qty, $stock) {
       
        //echo $product_varient_id."".$qty; die;
        $this->load->helper('cookie');
        $this->load->library('session');
        $product_arr = array();
        $isUpdate = $this->session->userdata("product"); 
        if ($this->session->userdata("product")) {
            $product_arr = json_decode($this->session->userdata("product"), TRUE);
        }
       
        if(!empty($product_arr)){
            $isProductFound = false;
            $arrayLength = count($product_arr);
            foreach ($product_arr as $key => $product) {
                if (empty($product['product_id']) || empty($product['buy_qty'])) {
                    unset($product_arr[$key]);
                }

                if (($product_id == $product['product_id']) && !$isProductFound) {
                    if($product_varient_id == $product['product_varient_id']){
                        
                        $arrayKey = $this->searchArrayKeyVal("product_varient_id", $product_varient_id, $product_arr);
                        $product_arr[$arrayKey]['buy_qty']  = $product_arr[$arrayKey]['buy_qty'] + $qty;
                        $isProductFound = true;
                    }
                    elseif ($arrayLength <= $key + 1 && !$isProductFound) {
                        $product_arr[] = array(
                            'product_id'            => $product_id,
                            'product_varient_id'    => $product_varient_id,
                            'buy_qty'               => $qty,
                            'stock'                 => $stock
                        );
                    }
                   
                    //unset($product_arr[$arrayKey]);
                }
                else{
                    if($this->searchArrayKeyVal("product_id", $product_id, $product_arr) === false){
                        $product_arr[] = array(
                            'product_id'            => $product_id,
                            'product_varient_id'    => $product_varient_id,
                            'buy_qty'               => $qty,
                            'stock'                 => $stock
                        );
                    }
                }
            }
        } else {
            $product_arr[] = array(
                        'product_id'            => $product_id,
                        'product_varient_id'    => $product_varient_id,
                        'buy_qty'               => $qty,
                        'stock'                 => $stock
                    );
        };
        
        
     
        
        $product_arr = json_encode($product_arr);
        $cookie = array(
            'name' => 'product',
            'value' => $product_arr,
            'expire' => time() + 86500,
        );
        $data  = array('product' => $product_arr);
        $this->session->set_userdata($data);
        ///print_r($this->session->userdata('product')); exit;
        //$this->input->set_cookie($cookie);
    }
    
     function addToCarts($product_id, $product_varient_id, $qty,$keys) {
       
        //echo $product_varient_id."".$qty; die;
        $this->load->helper('cookie');
        $this->load->library('session');
        $product_arr = array();
        if ($this->session->userdata("product")) {
            $product_arr = json_decode($this->session->userdata("product"), TRUE);
        }
        
        if(!empty($product_arr)){
            $isProductFound = false;
            foreach ($product_arr as $key => $product) {
                if (empty($product['product_id']) || empty($product['buy_qty'])) {
                    unset($product_arr[$key]);
                }
                if (($product_id == $product['product_id']) && !$isProductFound) {
                    if($product_varient_id == $product['product_varient_id']){
                        $isProductFound = true;
                        $arrayKey = $this->searchArrayKeyVal("product_varient_id", $product_varient_id, $product_arr);
                        if($keys == 'plus'){ 
                            $product_arr[$arrayKey]['buy_qty']  = $product_arr[$arrayKey]['buy_qty'] + 1;
                        }
                        elseif($keys == 'minus'){
                            $product_arr[$arrayKey]['buy_qty']  = $product_arr[$arrayKey]['buy_qty'] - 1;
                        }
                    }
                    // else{
                    //     $product_arr[] = array(
                    //         'product_id'            => $product_id,
                    //         'product_varient_id'    => $product_varient_id,
                    //         'buy_qty'               => $qty
                    //     );
                    // }
                }
                
            }
        }
        
        
        
      //print_r($product_arr); exit; 
        
        $product_arr = json_encode($product_arr);
        $cookie = array(
            'name' => 'product',
            'value' => $product_arr,
            'expire' => time() + 86500,
        );
        $data  = array('product' => $product_arr);
        $this->session->set_userdata($data);
       // print_r($this->session->userdata('product')); exit;
        //$this->input->set_cookie($cookie);
    }
    

    function deleteToCart($product_id, $product_varient_id) {
        /* $cookie = array(
          'name' => 'product',
          'value' => '',
          'expire' => '0',
          );
          delete_cookie($cookie);
         * 
         */
        //$product_arr = $this->setting_model->getToCart();
        $product_arr = $this->getToCart();
        foreach ($product_arr as $key => $product) {
           // print_r($product); exit;
            if (empty($product['product_id']) || empty($product['buy_qty'])) {
                unset($product_arr[$key]);
            }
        }
        $arrayKey = $this->searchArrayKeyVal("product_varient_id", $product_varient_id, $product_arr);
        unset($product_arr[$arrayKey]);
        $this->setCartCookie($product_arr);
    }

    function deletesToCart() {
        $this->session->unset_userdata("product");
    }

    function updateToCart($product_id, $qty) {
        
    }

    function getSliders() {
        $q = $this->db->query("Select * from slider where trash=0");
        return $q->result_array();
    }

    function getBanner() {
        $q = $this->db->query("Select * from banner where trash=0");
        return $q->result_array();
    }

    function getFeatureBanner() {
        $q = $this->db->query("Select * from feature_slider where trash=0");
        return $q->result_array();
        /*
         * $slider_status = $value['slider_status'];
          $slider_title = $value['slider_title'];
          $slider_image = $slider_img_url.$value['slider_image'];
         */
    }

    function get_settings() {
        $q = $this->db->query("Select * from settings");
        return $q->result();
    }

    function get_setting_by_id($id) {
        $q = $this->db->query("Select * from settings where id = '" . $id . "'");
        return $q->row();
    }

    /*     * *********Robin Sir********** */

    function insertReferralPoint($referral_point) { // Not OK
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
    function order_sms($user_id, $message) {//OK
        $user_phone = $this->db
                        ->select('user_phone')
                        ->where('user_id', $user_id)
                        ->limit(1)
                        ->get('registers')
                        ->row()
                ->user_phone;
        $this->sendsmsPOST($user_phone, $message);
    }

    // SEND SMS
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
    
    public function getCouponList($uni_id){
        $today_date = date('Y-m-d');
        $today_date = date('Y-m-d');
        $coupons    =   array();
        
        $coupons_list = $this->db->query('SELECT tbl_coupons.*,tbl_coupons.coupon_id as coupon_uni_id,tbl_coupon_apply.*,COUNT(tbl_coupon_apply.coupon_id) = tbl_coupons.uses_restriction as used_coupon FROM tbl_coupons 
											LEFT JOIN tbl_coupon_apply ON tbl_coupon_apply.coupon_id = tbl_coupons.coupon_id AND tbl_coupon_apply.user_id = "'.$uni_id.'" AND tbl_coupon_apply.coupon_apply_status = 1
											WHERE tbl_coupons.coupon_status=1 AND tbl_coupons.trash=0 AND tbl_coupons.valid_from <= "'.$today_date.'" AND tbl_coupons.valid_to >="'.$today_date.'" GROUP BY tbl_coupons.coupon_id
											ORDER BY  tbl_coupons.coupon_id DESC');
											
        if($coupons_list->num_rows() > 0){
          $coupons  =     $coupons_list->result_array();
        }
        return $coupons;
    }
    public function checkCouponCode($uni_id,$coupon_code)
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

>>>>>>> main
?>