<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function errorMsg($error_key, $error_msg) {
    if (empty($error_key)) {
        $error_key = 'error_msg'; //.'Account Member Not Be Found'
    }
    $messge = array('message' => $msg, 'class' => 'alert alert-danger fade in');
    $this->session->set_flashdata($error_key, $messge);
    $this->session->keep_flashdata($error_key, $messge);
}

class MbrAdminsTbl {

    const tbl_name = 'mbr_admins_tbl';
    const col_id = MbrAdminsTbl::tbl_name . '.id';
    const col_id_out = 'adminId';
    const col_mbr_account_id = MbrAdminsTbl::tbl_name . '.id';
    const col_mbr_account_id_out = MbrAccountsTbl::col_id_out; //'accountId';

}

class MbrOrganizationsTbl {

    const tbl_name = 'mbr_organizations_tbl';
    const col_id = MbrOrganizationsTbl::tbl_name . '.id';
    const col_id_out = 'organizationId';

}

class MbrAccountsTbl {

    const tbl_name = 'mbr_accounts_tbl';
    const col_id = MbrAccountsTbl::tbl_name . '.id';
    const col_id_out = 'accountId';
    const col_email = MbrAccountsTbl::tbl_name . '.email';

}

trait SystemModel {

    protected function lastAffectRowsIds($tbl_name) {
        $last_affect_rows = $this->db->affected_rows();
        $ids_array = $this->db
                ->select('id')
                ->limit($last_affect_rows, 0)
                ->get($tbl_name)
                ->result_array();
        $ids_array = array_column($ids_array, 'id');
        /*
          $sql = $this->db->last_query();
          $this->CI->preOutput($sql);
          $this->CI->preOutput($ids_array);
          die();
         * 
         */
        return $ids_array;
    }

    public function setSession() {
        
    }

}

Class MbrAccountsTbl_Model extends CI_Model {

    var $tbl_name = 'registers';

    public function __construct() {
        parent::__construct();
    }

    public function getMdbAccountWalletById($user_id){
        $user_wallet = $this->db
                ->where('user_id', $user_id)
                ->get($this->tbl_name)
                ->row()
                ->wallet;
        return $user_wallet;
        $wallet_amount = '';
        $total_amount = '';
        $data = array(
            "wallet" => "200.00",
            "total" => "730.00",
            "used_wallet" => "50.00"
        );
        $user_info = $this->getMdbAccountById($user_id);
        var_dump($user_info);
        $wallet_amount = $user_info->wallet;
        //$cart_amount =
        var_dump($wallet_amount);
    }
    public function getMdbMobileById($user_id){
        $user_phone = $this->db
                ->select('user_phone')
                ->where('user_id', $user_id)
                ->get($this->tbl_name)
                ->row()
                ->user_phone;
        return $user_phone;
    }
    public function getMdbAccountById($user_id){
        $user_info = $this->db
                ->where('user_id', $user_id)
                ->get($this->tbl_name)
                ->row();
        return $user_info;
    }
    public function getMdbAccountByFB($facebook_oauth){
        $user_info = $this->db
                ->where('facebook_oauth', $facebook_oauth)
                ->get($this->tbl_name)
                ->row();
        return $user_info;
    }
    public function getMdbAccountByGoogle($google_oauth){
        $user_info = $this->db
                ->where('google_oauth', $google_oauth)
                ->get($this->tbl_name)
                ->row();
        return $user_info;
    }
    public function getMdbAccountByEmail($user_email){
        $user_info = $this->db
                ->where('user_email', $user_email)
                ->get($this->tbl_name)
                ->row();
        return $user_info;
    }
    public function getMdbAddressesById($user_id){
        $q = $this->db->query("Select user_location.*,
                    pincode.* from user_location 
                    inner join pincode on pincode.pincode = user_location.pincode
                    where user_id = '" . $user_id . "' AND user_location.trash=0");
        return $q->result();
    }
    public function get_all_society(){
        $sql_society_data = $this->db->query("Select * from socity");
        return $sql_society_data->result();
    }

	
    public function updateMbrAccountDefault($id) {//Not Use
        $update = array(
            "slug" => $this->CI->random_code(6),
            "token_id" => $this->CI->random_code(6),
            "unique_id" => $this->CI->random_code(6),
            "referral_code" => $this->CI->random_code(6),
        );
        $id = $this->db
                ->where('id', $id)
                ->update($this->tbl_name, $update);
        return $id;
    }

    public function createMbrAccount($data_array) {
        $this->db->insert(MbrAccountsTbl::tbl_name, $data_array);
        $insert_account_id = $this->db->insert_id();
        if (!empty($insert_account_id)) {
            $mbr_account_id = $this->updateMbrAccountDefault($insert_account_id);
            var_dump($mbr_account_id);
            return $mbr_account_id;
        }
        return FALSE;
    }
    public function addAddress($array) {
        /*
         * address_user_name
         * address_mobile_no
         * address_pincode
         * address_address
         * address_address
         * 
         */
        $this->db->insert("user_location", $array);
        return $this->db->insert_id();
        
    }

}

Class MbrAdminsTbl_Model extends MbrAccountsTbl_Model {

    public function __construct() {
        parent::__construct();
    }

    public function createMbrAdmin($mbr_account_id) {
        $this->db->insert(MbrAdminsTbl::tbl_name, array('mbr_account_id' => $mbr_account_id));
        $insert_id = $this->db->insert_id();
    }

    public function getAdminByMobile($mobile) {
        $result = $this->db
                //'mbr_accounts_tbl.id = mbr_admin_tbl.mbr_account_id'
                ->where('user_phone', $mobile)
                ->get($this->tbl_name)
                ->row();
        //var_dump($rseult);
        return $result;
    }

    public function getAdminByEmail($email) {
        $this->getAdmin($email);
    }

    public function getAdmin($email) { // Not OK
        $result = $this->db
                ->join(MbrAccountsTbl::tbl_name, MbrAccountsTbl::col_id . ' = ' . MbrAdminsTbl::col_mbr_account_id)//'mbr_accounts_tbl.id = mbr_admin_tbl.mbr_account_id'
                ->where(MbrAccountsTbl::col_email, $email)
                ->get(MbrAdminsTbl::tbl_name)
                ->row();
        //var_dump($rseult);
        return $result;
    }

    /*
     * Add New Admistration Login 
     */

    public function setAdmin($data_array) {
        /*
          $this->db->insert(MbrAccountsTbl::tbl_name, $data_array);
          $insert_id = $this->db->insert_id();
         */
        $mbr_account_id = parent::createMbrAccount($data_array);
        if (!empty($mbr_account_id)) {
            return $this->createMbrAdmin($mbr_account_id);
        }
        return FALSE;
    }

}

Class MbrOrganizationsTbl_Model extends MbrAccountsTbl_Model {

    public function __construct() {
        parent::__construct();
    }

    public function createOrgAccount($data_array) {
        $this->db->insert(MbrOrganizationsTbl::tbl_name, $data_array);
        $insert_id = $this->db->insert_id();
    }

    public function setOrgAccount($data_array) {
        /*
          $data_array = array(
          'mbr_account_id'=>set_value('mbr_account_id'),
          'head_office_address' => set_value('head_office_address'),
          'org_full_name' => set_value('org_full_name'),
          'org_short_name' => set_value('org_short_name'),
          'logo_image' => set_value('logo_image'),
          'founder_name' => set_value('founder_name'),
          'ceo_name' => set_value('ceo_name'),
          'md_name' =>set_value('md_name')
          );
         * 
         */
        if (array_key_exists('mbr_account_id', $data_array) && !empty($data_array['mbr_account_id'])) {// && isset($data_array['mbr_account_id'])
            $org_account_id = $this->createOrgAccount($data_array);
        } else {
            $error_key = NULL;
            $error_msg = 'Account Member Not Be Found';
            errorMsg($error_key, $error_msg);
            $org_account_id = FALSE;
        }
        return $org_account_id;
    }

}

Class Oauth_model extends MbrAccountsTbl_Model {

    var $CI;

    use SystemModel;

    public function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
    }
    
    public function updateProfileByUserId($user_id,$update_data){
        $tbl_name = 'registers';
        return $this->db->update($tbl_name,$update_data,array('user_id' => $user_id));
    }

    public function checkRegistered($email) {
        
    }

    public function setMemberAccount($data_array) {
       
        $tbl_name = 'registers';
        $id = '';
        $salf_rafale_point=0;
        $salf_wallet=0;
        //$send_otp = $data_array['send_otp'];
        $mobile = $data_array['user_phone'];
        //$otp_select  = $this->db->query("select * from tbl_user_otp WHERE user_otp = '".$send_otp."' AND  user_phone_number = '".$mobile."' ")->row();
        //$userotp = $otp_select->user_otp;
        //if($send_otp  == $userotp ){
            
            //$user_rafale_code = set_value('user_rafale_code'); //$this->input->post("user_rafale_code");
//            if(!empty($data_array['user_rafale_code'])){
//                $user_rafale_code = $data_array['user_rafale_code'];
//                
//                $result_rew = $this->db
//                            ->select('user_id')
//                            ->select('salf_rafale_point')
//                            ->select('wallet')
//                            ->where('salf_rafale_code', $user_rafale_code)
//                            ->limit(1)
//                            ->get($tbl_name)
//                            ->row();
//                if(!empty($id)){
//                    $salf_rafale_point=10;
//                    $salf_wallet=10;
//                }
//            }
           
            $data = array_merge(array(
                'wallet' =>0,
                'salf_rafale_point' => 0,
                "salf_rafale_code" => $this->CI->random_code(6),
                //"user_rafale_code" => $user_rafale_code
                ), $data_array);
             $data_array["salf_rafale_code"] = $this->CI->random_code(6);
            //$this->CI->preOutput($data_array);
            $this->db->insert($tbl_name, $data_array);
            /*
              $sql = $this->db->last_query();
              $this->CI->preOutput($sql);
             * 
             */
            if ($this->db->affected_rows() > 0) {
                /*
                $arr_ids = $this->lastAffectRowsIds($tbl_name);
                foreach ($arr_ids as $value) {
                    $id = $value;
                    $update = array(
                        "slug" => $this->CI->random_code(6),
                        "token_id" => $this->CI->random_code(6),
                        "unique_id" => $this->CI->random_code(6),
                        "referral_code" => $this->CI->random_code(6),
                    );
                    $id = $this->db
                            ->where('id', $id)
                            ->update($tbl_name, $update);
                }*/
                return $this->db->insert_id();
            }
        //     return TRUE;
        // }
        return FALSE;
    }

    public function checkLoginByMobile($mobile, $password) {
        $obj = new MbrAdminsTbl_Model();
        $result = $obj->getAdminByMobile($mobile);
        //if($email==='robinsun31@gmail.com' && $password ==='testing@123'){
        if (!empty($result) && $result->user_password === md5($password) && $result->status == 1) {
            /*
            $data["data"] = array("user_id" => $row->user_id,
                "user_fullname" => $result->user_fullname,
                "user_email" => $result->user_email,
                "user_phone" => $result->user_phone,
                "user_image" => $result->user_image,
                "wallet" => $result->wallet,
                "rewards" => $result->rewards,
                "salf_rafale_code" => $row->salf_rafale_code

            );
             * 
             */
            /*
            $oauth_data_recorde = array(
                'ADMIN_LOGIN_TYPE' => 1,
                'logged_in' => TRUE,
                'ah_name' => 'Robin Kumar Sharma',
                'ah_type' => 'xyz...type',
                'ah_roles' => 'r01',
                'ah_email' => 'robinsun31@gmail.com',
            );*/
            
            return $result; //user login
        } 
        else if (!empty($result) && $result->user_password === md5($password) && $result->status == 0) {
            return 2; //user blocked
        }
        else if (!empty($result) && $result->user_password !== md5($password) && $result->status == 1) {
            return 3; //user password not matched
        }
        else {
            return FALSE; //user not exist
        }
        //die();
    }

    public function checkLogin($email, $password) {
        $obj = new MbrAdminsTbl_Model();
        $result = $obj->getAdmin($email);
        //if($email==='robinsun31@gmail.com' && $password ==='testing@123'){
        if (!empty($result) && $result->password === md5($password)) {
            /*
            $oauth_data_recorde = array(
                'ADMIN_LOGIN_TYPE' => 1,
                'logged_in' => TRUE,
                'ah_name' => 'Robin Kumar Sharma',
                'ah_type' => 'xyz...type',
                'ah_roles' => 'r01',
                'ah_email' => 'robinsun31@gmail.com',
            );
             * 
             */
            return $result;
        } else {
            return FALSE;
        }
    }

    public function checkDashboard() {
        
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
 */
?>
