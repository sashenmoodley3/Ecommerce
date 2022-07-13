<?php
/**
 * Created by PhpStorm.
 * User: Kriscent
 * Date: 28-08-2019
 * Time: 19:16
 */
class MY_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function data_insert($table,$insert_array){
		$this->db->insert($table,$insert_array);
		return $this->db->insert_id();
	}

	public function recursive_code(){
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$self_referal_code = substr(str_shuffle($str_result), 0, 6);
		$count_data_self_code = $this->my_model->dbRowCount('tbl_login','WHERE self_referal_code="'.$self_referal_code.'"');
		if($count_data_self_code != 0){
			//Call the function again. Increment number by one.
			return $this->recursive_code();

		}
		else{
			return $self_referal_code;
		}
	}
	
	public function check_recursive_increment($table_name,$where_clause){
		$i = 0;
		$count_data_self_code = $this->my_model->dbRowCount($table_name,'WHERE '.$where_clause['key'].' = "'.$where_clause['value'].'"');
		if($count_data_self_code != 0){
			$i++;
			$where_clause['value'] = $where_clause['value'].$i;
			//Call the function again. Increment number by one.
			return $this->check_recursive_increment($table_name,$where_clause);
		}
		else{
			return $where_clause['value'];
		}
	}
	public function chekOtp($Phone, $user_otp) {
		$result = $this->db
					->where('user_phone_number', $Phone)
					->where('user_otp', $user_otp)
					->get('tbl_user_otp')
					->result_array();
		if(count($result) > 0){
		    return true;
		}
		else{
		    return false;
		}
	}

	public function sequence_code($code){
		$rescode = $this->db->where('sequence_code', $code)->get('tbl_sequence')->row();
		$sequencecode = $rescode->sequence_number;
		$codeunique = $sequencecode+1;
		$unique_id =  $rescode->sequence_code.'000'.$codeunique;
		return $unique_id;
	}
	//////////////Get sequence No to Update sequence table////////////
	public function new_sequence_code($code){
		$rescode = $this->db->where('sequence_code', $code)->get('tbl_sequence')->row();
		$sequence_code = $rescode->sequence_number;
		$code_uni = $sequence_code + 1;
		$uni_idd =  $code.$this->pre_zero($code_uni, 4);
		$this->my_model->dbRowUpdate('tbl_sequence',array('sequence_number'=>$this->pre_zero($code_uni, 4)),'WHERE sequence_code = "'.$code.'"');
		return $uni_idd;
	}

////////// ADD PREPEND ZERO ////////////////////
	function pre_zero($num, $dig)
	{
		$num_padded = sprintf("%0" . $dig . "d", $num);
		return $num_padded;
	}


	///////////// Get Doctor Name By Doctor Uni Id /////////////////
	public function getDoctorNameById($doctor_uni_id) {
		$result = $this->db
			->select('doctor_full_name')
			->where('doctor_uni_id', $doctor_uni_id)
			->get('tbl_doctor')
			->row();
		return $result;
	}
///////////// Get All States By Ajax  /////////////////
	public function getCityByStateIdByAjax($state_id) {
		$city_id = array();
		$city_name = array();
		array_push($city_id, " ");
		array_push($city_name, "Please Select a City");

		$result = $this->db
			->where('state_id', $state_id)
			->get('tbl_city')
			->result_array();
		foreach ($result as $row){
			array_push($city_id, $row['city_id']);
			array_push($city_name, $row['city_name']);
		}
		if (count($city_id) > 1) {
			$revert = array(1, $city_id, $city_name);
		} else {
			$revert = array(0, $city_id , $city_name);
		}
		//		print_r($result);exit;
		return $revert;
	}
	///////////// Get City Data By State Id /////////////////
	public function getCityByStateId($state_id) {
		$result = $this->db
			->where('state_id', $state_id)
			->get('tbl_city')
			->result_array();
			return $result;
	}
	///////////// Get State Data By State Id /////////////////
	public function getStateDataByStateId($state_id) {
		$result = $this->db
			->where('state_id', $state_id)
			->get('tbl_states')
			->row();
			return $result;
	}
	///////////// Get City Data By City Id /////////////////
	public function getCityDataByCityId($city_id) {
		$result = $this->db
			->where('city_id', $city_id)
			->get('tbl_city')
			->row();
			return $result;
	}
	//////////////////Get CMS PAGE BY CMS Slug  ////////
	public function getCmsPageDetails($cms_slug) {
		$result = $this->db
					->where('page_slug', $cms_slug)
					->where('page_status',1)
					->where('trash',0)
					->get('tbl_cms')
					->row();
		return $result;
	}
	///////////// Get Review Data By Doctor Id /////////////////
	public function getDoctorTotalReviewById($doctor_uni_id) {
		$result = $this->db

			->select('COUNT(review_id) as total_review,SUM(review_rating) as total_rating')
			->where('review_for_id', $doctor_uni_id)
			->where('review_type', 'REV_DOC')
			->where('review_status', 1)
			->where('trash', 0)
			->get('tbl_review')
			->row();
			return $result;
	}
	///////////// Get All States /////////////////
	public function getAllStatesData() {
			$result = $this->db
				->where('state_status',1)
				->where('trash',0)
				->get('tbl_states')
				->result_array();
			return $result;
	}
///////////// Get Dates /////////////////
	public function getdays() {
		$days = array(
			'10' => 'Monday',
			'11' => 'Tuesday',
			'12' => 'Wednesday',
			'13' => 'Thursday',
			'14' => 'Friday',
			'15' => 'Saturday',
			'16' => 'Sunday',

		);
		return $days;
	}

	///////////// Get Dates /////////////////
	public function getAllBloodGroup() {
		$groups = array(
			'1' => 'O-',
			'2' => 'O+',
			'3' => 'A-',
			'4' => 'A+',
			'5' => 'B-',
			'6' => 'B+',
			'7' => 'AB-',
			'8' => 'AB+',

		);
		return $groups;
	}


	///////////// Get Banner /////////////////
	public function getbannermove() {
		$banner_position_result = $this->dbRowGetAllData('master_tbl', 'WHERE master_code = "position"');
		return $banner_position_result;
	}
///////////// Get Single Banner Category /////////////////
	public function getSingleBannerCat($id) {
		$result = $this->db
			->where('banner_category_id', $id)
			->get('tbl_banner_category')
			->row();
		return $result->banner_category_name;
	}
///////////// Get Kyc Verify /////////////////
	public function kyc_verify_documnents($uni_id) {
		$result = $this->db
			->where('login_uni_id', $uni_id)
			->get('tbl_kyc_document')
			->result();
		return $result;
	}

	public function scheduleDataListByweek($key_id,$unique_id)
	{
		$dataList =  $this->db->query("select * from tbl_schedule where schedule_days= '".$key_id."' and schedule_doctor_id = '".$unique_id."'")->row();
		return $dataList;
	}
	public function scheduleDataList($unique_id){
		$dataList =  $this->db->query("select * from tbl_schedule where schedule_doctor_id = '".$unique_id."'")->result();
		return $dataList;
	}
	public function scheduleDataPerPatientTime($unique_id)
	{

		$dataList =  $this->db->query("select * from tbl_schedule where  schedule_doctor_id = '".$unique_id."' limit 1")->row();
		return $dataList;
	}


	public function getAllBannerCategory() {
		$result = $this->db
			->where('banner_category_status',1)
			->get('tbl_banner_category')
			->result_array();
		return $result;
	}

	public function getAllTpaCard() {
		$result = $this->db
			->where('trash',0)
			->get('tbl_tpa_card')
			->result_array();
		//print_r($result); die;
		return $result;
	}

	public function getSpecialistByCategories($category) {
		$result = $this->db
			->where('master_category_id',$category)
			->get('tbl_specialist')
			->result_array();
		return $result;
	}
	///////////// Get All  Categories  /////////////////
	public function getAllCategories() {
			$result = $this->db
				->where('master_category_status',1)
				->where('trash',0)
				->get('tbl_master_category')
				->result_array();
			return $result;
	}
	///////////// Get All  Categories by id  /////////////////
	public function getAllCategoriesById($category) {
			$result = $this->db
				->where('master_category_status',1)
				->where('trash',0)
				->where('master_category_id IN('.$category.')')
				->get('tbl_master_category')
				->result_array();
			return $result;
	}
	
	///////////// Get All  Specilist by id  /////////////////
	public function getAllSpecialistById($specialist,$category ) {
			$result = $this->db
				->where('specialist_status',1)
				->where('trash',0)
				->where('specialist_id IN('.$specialist.')')
				->where('master_category_id',$category)
				->get('tbl_specialist')
				->result_array();
			//	print_r($this->db->last_query()); exit;
			return $result;
	}
		///////////// Get All Blog Categories  /////////////////
	public function getAllBlogCategories($parent='') {
		//		print_r("SELECT * FROM tbl_blog_category WHERE blog_parent_category_id IN (\"'.$parent.'\") AND blog_category_status = 1 AND trash = 0");exit;
		if($parent == ''){
			$sql = 'SELECT * FROM tbl_blog_category WHERE blog_category_status = 1 AND trash = 0';
		}else{
			$sql = 'SELECT * FROM tbl_blog_category WHERE blog_parent_category_id IN ("'.$parent.'") AND blog_category_status = 1 AND trash = 0';
		}
		$result = $this->db->query($sql);
		$row = $result->result_array();
		return $row;
	}

	///////////// Get All  Specialist  /////////////////
	public function getAllSpecialist() {
			$result = $this->db
				->where('specialist_status',1)
				->where('trash',0)
				->get('tbl_specialist')
				->result_array();
			return $result;
	}
///////////// Get All  Cities /////////////////
	public function getAllCityData() {
			$result = $this->db
				->get('tbl_city')
				->result_array();
			return $result;
	}
////Doctors Data By Ajax Query///////////////
	public function getDoctorsDataByAjax($start,$limit) {

		if(isset($limit,$start))
		{
			$result = $this->db->query("SELECT * FROM tbl_posts ORDER BY id DESC LIMIT ".$start.",".$limit);
//			print_r($result->result_array());exit;
			$posts = $result->result_array();
//			print_r($row);exit;
//			$var;
			return $posts;
		}

	}

	///////////// Get Master Category Data By Master Category Id /////////////////
	public function getMasterCategoryDataById($master_id) {
		$result = $this->db
			->where('master_category_id', $master_id)
			->get('tbl_master_category')
			->row();
//		print_r($result);exit;
		return $result;
	}


// MAIN COUNT QUERY
	function dbRowCount($table_name, $where_clause = '')
	{
		$whereSQL = '';
		if (!empty($where_clause)) {
			if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
				$whereSQL = " WHERE " . $where_clause;
			} else {
				$whereSQL = " " . trim($where_clause);
			}
		}
		$sql = "SELECT COUNT(*) AS count FROM " . $table_name;
		$sql .= $whereSQL;
//    echo $sql;
		$result = $this->db->query($sql);
//    echo $result;
		$row = $result->row();
//    print_r($row->count);exit();
		return $row->count;
	}

//Main get last inserted id

	function get_last_added_id(){
		$last_inserted_id = $this->db->lastInsertId();
		return $last_inserted_id;
	}

	// MAIN SELECT QUERY
	function dbRowSelect($table_name, $form_data, $where_clause = '')
	{
		$whereSQL = '';
		if (!empty($where_clause)) {
			if (substr(strtoupper(trim($where_clause)), 0, 5) != "WHERE") {
				$whereSQL = " WHERE " . $where_clause;
			} else {
				$whereSQL = " " . trim($where_clause);
			}
		}
		$fields = array($form_data);
		$sql = "SELECT " . implode(",", $form_data) . " FROM " . $table_name;
		$sql .= $whereSQL;
//		print_r($sql);exit;
		$result_data = "";
		if ($result = $this->db->query($sql)) {
			$row = $result->row();
//        print_r($row);die();

			foreach ($form_data as $value) {
				if ($result_data == "") {
					$result_data = $row->$value;
				} else {
					$result_data = $result_data . " ^@^ " . $row->$value;
				}
			}
//        print_r($result_data);die();
			return $result_data;
		} else {
			return $result_data;
		}
	}

	//Main Get All Data
	function dbRowGetAllData($table_name,$where_clause = '')

	{
		$sql = "SELECT * FROM " . $table_name;
		$sql .= ' '.$where_clause;
//    print_r($sql);die();
		$result_data = "";
		if ($result = $this->db->query($sql)) {
			$result_data = $result->result_array();
			return $result_data;
		} else {
			return $result_data;
		}
	}
		//Main Get All Data
	function dbRowGetSelectData($table_name, $selectdata, $where_clause = '')

	{
		$sql = "SELECT ".$selectdata." FROM " . $table_name;
		$sql .= ' '.$where_clause;
//    print_r($sql);die();
		$result_data = "";
		if ($result = $this->db->query($sql)) {
			$result_data = $result->result_array();
			return $result_data;
		} else {
			return $result_data;
		}
	}
	 function checkUserStatus($user_data){
		if (empty($user_data)) {
			$data['_error'] = "Email & Password Not Valid";
			return $data;
		} elseif ($user_data['trash'] == 1) {
			$data['_error'] = "Your A/C has been Deleted";
			return $data;
		} elseif ($user_data['login_status'] == 2) {
			$data['_error'] = "Your A/C has been blocked By Admin";
			return $data;
		}else{
			$data['_success'] = 'Correct Credentials';
			return $data;
		}
	}
	//Main Get All Data
	function dbRowGetAllSelectedData($table_name,$form_data,$where_clause = '')

	{
		$sql = "SELECT " . implode(",", $form_data) . " FROM " . $table_name;
		$sql .= ' '.$where_clause;
//    print_r($sql);die();
		$result_data = "";
		if ($result = $this->db->query($sql)) {
			$result_data = $result->result_array();
			return $result_data;
		} else {
			return $result_data;
		}
	}


// MAIN SELECT All QUERY
	function dbRowSelectAll($table_name, $form_data, $where_clause = '')
	{
		$whereSQL = '';
		if (!empty($where_clause)) {
			if (substr(strtoupper(trim($where_clause)), 0, 5) != "WHERE") {
				$whereSQL = " WHERE " . $where_clause;
			} else {
				$whereSQL = " " . trim($where_clause);
			}
		}
//    $fields = array($form_data);
		$sql = "SELECT * FROM " . $table_name;
		$sql .= $whereSQL;
//    print_r($sql);die();
		$result_data = "";
		if ($result = $this->db->query($sql)) {
			$row = $result->result_array();


			foreach ($row as $key => $value) {
//            print_r($value);die();
				if ($result_data == "") {
					$result_data = $row[$key];
				} else {
					$result_data = $result_data . " ^@^ " . $row[$key];
				}
			}
//        print_r($result_data);die();
			return $result_data;
		} else {
			return $result_data;
		}
	}

// MAIN INSERT QUERY
	function dbRowInsert($table_name, $table_data)
	{
		$fields = array_keys($table_data);
		$sql = "INSERT INTO " . $table_name . "(" . implode(',', $fields) . ") VALUES('" . implode("','", $table_data) . "')";
		if ($this->db->query($sql)) {
			return 1;
		} else {
			return 0;
		}
	}

// MAIN UPDATE QUERY
	function dbRowUpdate($table_name, $form_data, $where_clause = '')
	{
		$whereSQL = '';
		if (!empty($where_clause)) {
			if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
				$whereSQL = " WHERE " . $where_clause;
			} else {
				$whereSQL = " " . trim($where_clause);
			}
		}
		$sql = "UPDATE " . $table_name . " SET ";
		$sets = array();
		foreach ($form_data as $column => $value) {
			$sets[] = "" . $column . " = '" . $value . "'";
		}
		$sql .= implode(', ', $sets);
		$sql .= $whereSQL;
//    echo $sql;
		if ($this->db->query($sql)) {
			return 1;
		} else {
			return 0;
		}
	}

// MAIN DELETE QUERY
	function dbRowDelete($table_name, $where_clause = '')
	{
		$whereSQL = '';
		if (!empty($where_clause)) {
			if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
				$whereSQL = " WHERE " . $where_clause;
			} else {
				$whereSQL = " " . trim($where_clause);
			}
		}
		$sql = "DELETE FROM " . $table_name . $whereSQL;
		if ($this->db->query($sql)) {
			return 1;
		} else {
			return 0;
		}
	}


	// MASTER UPDATE QUERY
	function dbRowUpdateMasterTbl($table_name, $form_data)
	{
		$whereSQL = '';
		$result = 0;
		foreach ($form_data as $master_code => $master_title){
			$whereSQL = " WHERE master_code = '".$master_code."'";
			$sql = "UPDATE " . $table_name . " SET master_title = '".$master_title."'";
			$sql .= $whereSQL;
			$result = $this->db->query($sql);
		}
//		print_r($result);exit();
		if ($result == 1) {
			return 1;
		} else {
			return 0;
		}

	}



	/////////////////Getting data from the datatable /////////////////////
	public function get_datatables($table_name,$column_order,$column_search,$order,$where_clause='',$select_data ='',  $join_table='')
	{
		if ($select_data != ''){
			$this->db->select($select_data);
		}
		$this->_get_datatables_query($table_name,$column_order,$column_search,$order,$where_clause,  $join_table);
		if($_REQUEST['length'] != -1)
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		$query = $this->db->get();
		return $query->result();
	}


//////////////////////// Get DataTable Data ///////////////////////////
	private function _get_datatables_query($table_name,$column_order,$column_search,$order,$where_clause='',  $join_table='')
	{
		//add custom filter here

		$this->db->from($table_name);
		if(!empty($join_table)){
		    if(count($join_table) > 0){
    		    foreach($join_table as $join_key => $join_value){
                    $this->db->join($join_key, $join_value,'left');
                }
    		}
		}
//		print_r(key($where_clause).' '.$where_clause[key($where_clause)]);exit;
//		$this->db->where(key($where_clause), $where_clause[key($where_clause)]);
		$i = 0;
		if($where_clause != ''){

			foreach ($where_clause as $key => $value) // loop column
			{
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->where($key, $value);
//					$this->db->like($item, $_REQUEST['search']['value']);
				}
				else
				{
					$this->db->where($key, $value);
//					$this->db->or_like($item, $_REQUEST['search']['value']);
				}

				if(count($where_clause) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
				$i++;
			}
		}
		$i = 0;
		foreach ($column_search as $item) // loop column
		{
			if($_REQUEST['search']['value']) // if datatable send POST for search
			{

				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_REQUEST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_REQUEST['search']['value']);
				}

				if(count($column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
        //print_r($_REQUEST['order']); exit;
		if(isset($_REQUEST['order'])) // here order processing
		{
			$this->db->order_by($column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
		}
		else if(isset($order))
		{
//			$order = $order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		//print_r($this->db->last_query()); exit;
	}

	//////////////////// Count Number of Rows Filtered  /////////////////////////////
	public function count_filtered($table_name,$column_order,$column_search,$order,$where_clause='',  $join_table='')
	{
		$this->_get_datatables_query($table_name,$column_order,$column_search,$order,$where_clause,  $join_table);
		$query = $this->db->get();
		return $query->num_rows();
	}
	//////////////////// Total Number of Rows in Filtered Table /////////////////////////////
	public function count_all($table_name)
	{
		$this->db->from($table_name);
		return $this->db->count_all_results();
	}






}
