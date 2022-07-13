<?php
/*
    $this->load->model("users_model");
    $data["wallet_history"] = $this->users_model->getUserWalletHistory($user_id);
 */
class Users_model extends CI_Model{
    public function get_users($filter=array()){
        $filter = "";
        if(!empty($filter))
        {
            if(key_exists("user_type")){
                $filter .=" and users.user_type_id = '".$filter["user_type"]."'";
            }
            if(key_exists("status")){
                $filter .=" and users.user_status = '".$filter["status"]."'";
            }
        }
        $q = $this->db->query("select * from users where 1 ".$filter);
        return $q->result();
    }
        public function get_alluser(){
        $q = $this->db->query("select * from store_login ");
        return $q->result();
    }
    public function get_user_by_id($id){
        $q = $this->db->query("select * from store_login where  user_id = '".$id."' limit 1");
        return $q->row();
    }
     public function get_mainuser_by_id($id){
        $q = $this->db->query("select * from users where  user_id = '".$id."' limit 1");
        return $q->row();
    }
    public function get_user_type(){
        $q = $this->db->query("select * from user_types");
        return $q->result();
    }
    public function get_user_type_id($id){
        $q = $this->db->query("select * from user_types where user_type_id = '".$id."'");
        return $q->row();
    }
    public function get_user_type_access($type_id){
        $q = $this->db->query("select * from user_type_access where user_type_id = '".$type_id."'");
        return $q->result();
    }
    public function getUserWalletHistory($user_id, $start_date = '',$end_date=''){
        $filter         =   '';
        if(!empty($start_date)){
            $filter     .=   ' AND created_date >= "'.$start_date.' 00:00:01"';
        }
        if(!empty($end_date)){
            $filter     .=   ' AND created_date <= "'.$end_date.' 23:59:59"';
        }
        $qry=$this->db->query("SELECT * FROM `wallet_history` where user_id = '".$user_id."' ".$filter."");
        return $qry->result();
    }
    public function insetUserWalletHistory($user_id,$cr_wallet_amount,$dr_wallet_amount,$msg){
        //$qry=$this->db->query("SELECT * FROM `wallet_history` where user_id = '".$user_id."'");
        $this->db->query("INSERT INTO `wallet_history` ( 
                transaction_by, 
                description, 
                `user_id`, 
                `cr_id`, 
                `dr_id`, 
                `created_date`
                ) 
                VALUES (
                    'referral_code',
                    '$msg',
                    $user_id,
                    $cr_wallet_amount,
                    $dr_wallet_amount,
                    '".date("Y-m-d H:i:s")."'
                    );
                ");
        //var_dump($this->db->last_query());
        return $this->db->insert_id();
    }
    public function crUserWalletHistory($user_id,$cr_wallet_amount,$msg=null){
        $dr_wallet_amount=0;
        if(empty($msg)){
            $msg = htmlspecialchars("“by refer”");
        }
        $this->insetUserWalletHistory($user_id,$cr_wallet_amount,$dr_wallet_amount,$msg);
    }
    public function drUserWalletHistory($user_id,$dr_wallet_amount,$msg=null){
        $cr_wallet_amount=0;
        if(empty($msg)){
            $msg = htmlspecialchars("“For order”");
        }
        $this->insetUserWalletHistory($user_id,$cr_wallet_amount,$dr_wallet_amount,$msg);
    }
    public function get_allAppuser($userid){
        $q = $this->db->query("select * from registers WHERE  user_id='".$userid."'");
        return $q->row();
    }
    
    public function get_userList($id, $where){
        if(!empty($id)){
            $where  .=   " AND users.user_id='".$id."'";
        }
        
        $q = $this->db->query("SELECT users.*, country.name as country_name, tbl_states.state_name,tbl_city.city_name, tbl_plan.title, tbl_plan.plan_period, tbl_plancategory.title as package  FROM `users`
                                LEFT JOIN country On country.id = users.country
                                LEFT JOIN tbl_states On tbl_states.state_id = users.state
                                LEFT JOIN tbl_city ON tbl_city.city_id = users.city
                                LEFT JOIN tbl_plan ON tbl_plan.id = users.plan_id 
                                LEFT JOIN tbl_plancategory ON tbl_plancategory.id = users.pkg_id 
								".$where." GROUP BY user_id ORDER BY user_id");
        return $q->result_array();
        
    }
    
    public function get_versionList($id){
        $where  =   "WHERE tbl_version.trash=0";
        if(!empty($id)){
            $where  .=   " AND tbl_version.id='".$id."'";
        }
        $q = $this->db->query("SELECT tbl_version.* FROM `tbl_version` ".$where." ORDER BY tbl_version.id DESC");
        return $q->result_array();
    }
    public function get_versionListUser($domain, $id){
        $where  =   "WHERE tbl_version.trash=0";
        if(!empty($id)){
            $where  .=   " AND tbl_version.id='".$id."'";
        }
        
        $q = $this->db->query("SELECT tbl_version.*, tbl_upgrade.status as upgradeStatus
			FROM `tbl_version`
			LEFT JOIN tbl_upgrade On tbl_upgrade.version_id = tbl_version.id AND tbl_upgrade.trash=0 
			AND tbl_upgrade.domainid='".$domain."'
			".$where." ORDER BY tbl_version.id DESC");
        return $q->result_array();
    }
    public function get_tutorialList($id){
        $where  =   "WHERE trash=0";
        if(!empty($id)){
            $where  .=   " AND id='".$id."'";
        }
        $q = $this->db->query("SELECT tbl_videotutorial.*  FROM `tbl_videotutorial` ".$where." ORDER BY id");
        return $q->result_array();
    }
    
    public function get_upgradeList($id){
        $where  =   "WHERE tbl_upgrade.trash=0";
        if(!empty($id)){
            $where  .=   " AND tbl_upgrade.id='".$id."'";
        }
        $q = $this->db->query("SELECT tbl_upgrade.*, tbl_version.version_code, users.user_name, users.user_email, users.user_phone, users.user_fullname, users.pkg_id, users.version, users.pakg_amount, 
                               users.address, users.state, users.city , users.user_id 
                               FROM `tbl_upgrade`
                               LEFT JOIN tbl_version ON tbl_version.id = tbl_upgrade.version_id
                               LEFT JOIN users ON users.domain_url = tbl_upgrade.domainid 
                               ".$where." group by tbl_upgrade.id Order By tbl_upgrade.id DESC");
        return $q->result_array();
    }
    
    public function get_supportList($filter=[]){
        $where  =   "WHERE T.trash=0";
        if(!empty($filter['tkt_id'])){
            $where  .=   " AND T.tkt_id='".$filter['tkt_id']."'";
        }
        if(!empty($filter['user_id'])){
            $where  .=   " AND T.user_id='".$filter['user_id']."'";
        }
		if(isset($filter['status']) && $filter['status'] !='' ){
			$where  .=   " AND T.status='".$filter['status']."'";
		}
        $q = $this->db->query("SELECT T.*, US.user_name, US.user_email, US.user_phone FROM tbl_ticket T INNER JOIN users US ON US.user_id = T.user_id $where ORDER BY T.id DESC ");
        return $q->result_array();
    }
    
    public function get_supportDetailList($filter=[]){
        $q = $this->db->query("SELECT T.*, TM.*, US.user_name FROM tbl_ticket T INNER JOIN tbl_ticket_msg TM ON TM.tkt_id = T.tkt_id INNER JOIN users US ON US.user_id = T.user_id WHERE T.tkt_id='".$filter['tkt_id']."' ORDER BY TM.id ASC ");
        return $q->result_array();
    }
    
    public function get_enquiryList($id='',$status=''){
        $where  =   "WHERE tbl_kartenquiry.trash=0";
        if(!empty($id)){
            $where  .=   " AND tbl_kartenquiry.id='".$id."'";
        }
		if(isset($status) && $status !='' ){
			$where  .=   " AND tbl_kartenquiry.status='".$status."'";
		}
        $q = $this->db->query("SELECT tbl_kartenquiry.* 
                               FROM `tbl_kartenquiry`
                              ".$where."  
                               group by tbl_kartenquiry.id Order By tbl_kartenquiry.id DESC");
        return $q->result_array();
    }
    
    public function get_plancategory(){
        $where  =   "WHERE tbl_plancategory.trash=0";
        if(!empty($id)){
            $where  .=   " AND tbl_plancategory.id='".$id."'";
        }
        $q = $this->db->query("SELECT tbl_plancategory.* 
                               FROM `tbl_plancategory`
                              ".$where."  
                               group by tbl_plancategory.id Order By tbl_plancategory.id DESC");
        return $q->result_array();
    }
    
    public function get_plan($id='', $category_id='', $status=''){
        $where  =   "WHERE tbl_plan.trash=0";
        if(!empty($id)){
            $where  .=   " AND tbl_plan.id='".$id."'";
        }
        if(!empty($category_id)){
            $where  .=   " AND tbl_plan.category_id='".$category_id."'";
        }
		if(isset($status) && $status !='' ){
			$where  .=   " AND tbl_plan.status='".$status."'";
		}
        $q = $this->db->query("SELECT tbl_plan.* , tbl_plancategory.title as category FROM `tbl_plan`
                                LEFT JOIN tbl_plancategory ON tbl_plancategory.id =	tbl_plan.category_id
                              ".$where."  
                               group by tbl_plan.id Order By tbl_plan.id DESC");
        return $q->result_array();
        
    }
    
     public function get_transaction($id, $where){
        if(!empty($id)){
            $where  .=   " AND payments_tabel.id='".$id."'";
        }
        
        $q = $this->db->query("SELECT payments_tabel.* 
                               FROM `payments_tabel`
                              ".$where."  
                               group by payments_tabel.id Order By payments_tabel.id DESC");
        return $q->result_array();
    }
    
    
}
?>