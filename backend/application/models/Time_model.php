<?php
class Time_model extends CI_Model{
        function get_time_slot(){
           $q = $this->db->query("Select * from time_slots limit 1");
            return $q->row();
        }
        
        function get_billing_details(){
           $q = $this->db->query("Select * from billing_details limit 1");
            return $q->row();
        }
        function get_mailtemplate_details(){
           $q = $this->db->query("Select * from mail_template WHERE   status = 1 limit 1");
          return $q->row();
        }
         function get_smstemplate_details(){
           $q = $this->db->query("Select * from sms_template limit 1");
          return $q->row();
        }
        
        
        
        function get_closing_date($date){
           $q = $this->db->query("Select * from closing_hours where date >= '".date("Y-m-d",strtotime($date))."'");
            return $q->result(); 
        }
        function get_closing_hours($date){
           $q = $this->db->query("Select * from closing_hours where date = '".date("Y-m-d",strtotime($date))."'");
            return $q->result(); 
        }
}
?>