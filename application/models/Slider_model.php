<?php 

class Slider_model extends CI_Model{

	function get_all_slide(){
		
	$query=$this->db->query("select * from slider");
	return $query->result();
	
	}
	
}

?>