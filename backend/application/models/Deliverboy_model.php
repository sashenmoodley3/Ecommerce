<?php
class Deliverboy_model extends CI_Model{
    
    
    public function data_insert($table,$insert_array){
        $this->db->insert($table,$insert_array);
        return $this->db->insert_id();
    }
    public function data_update($table,$set_array,$condition){
        $this->db->update($table,$set_array,$condition);
        return $this->db->affected_rows();
    }
    public function data_remove($table,$condition){
        $this->db->delete($table,$condition);
    }
    
    
    public function get_alldeliverboy(){
        $q = $this->db->query("select delivery_boy.*, country.name as country_name, tbl_states.state_name,tbl_city.city_name  
		from delivery_boy 
		LEFT JOIN country On country.id = delivery_boy.user_country
		LEFT JOIN tbl_states On tbl_states.state_id = delivery_boy.user_state
		LEFT JOIN tbl_city ON tbl_city.city_id = delivery_boy.user_city
		where delivery_boy.trash = 0");
        return $q->result();
    }
    public function get_deliverboy_by_id($id){
        $q = $this->db->query("select delivery_boy.*, country.name as country_name, tbl_states.state_name,tbl_city.city_name 
		from delivery_boy 
		LEFT JOIN country On country.id = delivery_boy.user_country
		LEFT JOIN tbl_states On tbl_states.state_id = delivery_boy.user_state
		LEFT JOIN tbl_city ON tbl_city.city_id = delivery_boy.user_city
		where delivery_boy.id = '".$id."' AND  delivery_boy.trash = 0 ");
        return $q->row();
    }
    
    
    function get_sale_orders_list_by_delivery_boy_id($datetype="", $dateto="", $fromdate="", $paymentmethod="", $customername="", $orderstatus="", $delivery_boy_id){
        //echo "ram".$dateto;
            $filter = "";
            if(!empty($datetype) && (!empty($dateto) || !empty($fromdate))){
                if(empty($dateto))
                {
                    $dateto = date("Y-m-d");
                }
                
                if(empty($fromdate))
                {
                    $fromdate = date("Y-m-d");
                }
                
                $filter .=" and sale.$datetype BETWEEN '".$dateto."' AND '".$fromdate."'";
            }
            if($paymentmethod!=""){
                
                if($paymentmethod=="Cash On Delivery")
                {
                    $filter .=" and (sale.payment_method = '".$paymentmethod."' or sale.payment_method = 'cod' or sale.payment_method = 'COD')";
                }
                else
                {
                    $filter .=" and sale.payment_method = '".$paymentmethod."'";
                }                
                
            }
        
            if($customername!=""){
                $filter .=" and registers.user_fullname like '%".$customername."%'";
                //$join_type ="inner";
            }
//            else
//            {
//                $join_type ="left";
//            }
        
            if($orderstatus!=""){
                $filter .=" and sale.status = '".$orderstatus."'";
            }
        
         $sql = "Select distinct sale.*, registers.user_fullname, registers.user_phone,registers.pincode,
         registers.house_no,`sale`.`status` as `orderStatus`, `sale`.`created_at` as `order_create_date`, sale.new_store_id , pincode.free_delivery_amount, 
         user_location.pincode, user_location.house_no, user_location.receiver_name, user_location.receiver_mobile  from sale 
            inner join registers on registers.user_id = sale.user_id
            left join delivery_boy on delivery_boy.id = sale.delivery_boy_id
            left outer join user_location on user_location.location_id = sale.location_id
            left outer join pincode on pincode.pincode = user_location.pincode
            left outer join users on users.user_id = user_location.store_id
            where 1 ".$filter." and sale.delivery_boy_id ='".$delivery_boy_id."' ORDER BY sale_id DESC";
            //echo $sql;
            $q = $this->db->query($sql);
//			//print_r( $q->result()); die;
            return $q->result();
      } 
    
}
?>