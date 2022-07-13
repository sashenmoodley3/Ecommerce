<<<<<<< HEAD
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
    public function getUserWalletHistory($user_id){
        $qry=$this->db->query("SELECT * FROM `wallet_history` where user_id = '".$user_id."' order by id DESC");
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
                    ".date("Y-m-d H:i:s")."
                    );
                ");
        //var_dump($this->db->last_query());
        return $this->db->insert_id();
    }
    /*
    public function crUserWalletHistory($user_id,$cr_wallet_amount){
        $dr_wallet_amount=0;
        $msg = htmlspecialchars("“by refer”");
        $this->insetUserWalletHistory($user_id,$cr_wallet_amount,$dr_wallet_amount,$msg);
    }
    public function drUserWalletHistory($user_id,$dr_wallet_amount,$msg=null){
        $cr_wallet_amount=0;
        if(empty($msg)){
            $msg = htmlspecialchars("“For order”");
        }
        $this->insetUserWalletHistory($user_id,$cr_wallet_amount,$dr_wallet_amount,$msg);
    }
     * 
     */
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
}
=======
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
    public function getUserWalletHistory($user_id){
        $qry=$this->db->query("SELECT * FROM `wallet_history` where user_id = '".$user_id."' order by id DESC");
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
                    ".date("Y-m-d H:i:s")."
                    );
                ");
        //var_dump($this->db->last_query());
        return $this->db->insert_id();
    }
    /*
    public function crUserWalletHistory($user_id,$cr_wallet_amount){
        $dr_wallet_amount=0;
        $msg = htmlspecialchars("“by refer”");
        $this->insetUserWalletHistory($user_id,$cr_wallet_amount,$dr_wallet_amount,$msg);
    }
    public function drUserWalletHistory($user_id,$dr_wallet_amount,$msg=null){
        $cr_wallet_amount=0;
        if(empty($msg)){
            $msg = htmlspecialchars("“For order”");
        }
        $this->insetUserWalletHistory($user_id,$cr_wallet_amount,$dr_wallet_amount,$msg);
    }
     * 
     */
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
}
>>>>>>> main
?>