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
		//echo $code_uni; exit;
		if($code == 'CALL'){
		    $uni_idd =  $this->pre_zero($code_uni, 4);
		}
		else{
		    $uni_idd =  $code.$this->pre_zero($code_uni, 4);
		}
		$this->my_model->dbRowUpdate('tbl_sequence',array('sequence_number'=>$this->pre_zero($code_uni, 4)),'WHERE sequence_code = "'.$code.'"');
		//echo $uni_idd; exit;
		return $uni_idd;
	}

    ////////// ADD PREPEND ZERO ////////////////////
	function pre_zero($num, $dig)
	{
		$num_padded = sprintf("%0" . $dig . "d", $num);
		return $num_padded;
	}

	///////////// Get Zodiac Sign  /////////////////
	public function getAllZodiacSign() {
		$result = $this->db
			->select('*')
			->where('trash', '0')
			->get('tbl_master_zodiacsign')
			->result_array();
		return $result;
	}
	
	public function getAllZodiacSignImg($id) {
		$result = $this->db
			->select('zodiac_title,zodiac_img')
			->where('zodiac_id', $id)
			->where('trash', '0')
			->get('tbl_master_zodiacsign')
			->result_array();
		return $result;
	}

	public function getNameZodiacSign($id) {
		$result = $this->db
			->select('*')
			->where('zodiac_id', $id)
			->where('trash', '0')
			->get('tbl_master_zodiacsign')
			->row();
		return $result->zodiac_title;
	}


	public function getAllLanguage() {
		$result = $this->db
			->where('trash',0)
			->get('tbl_master_language')
			->result_array();
		//print_r($result); die;
		return $result;
	}

	public function getAllLanguageName($language_id) {
		$result = $this->db
			->where('language_id',$language_id)
			->where('trash',0)
			->get('tbl_master_language')
			->row();
		return $result->language_name;
	}

	///////////// Get All  Categories  /////////////////
	public function getAllCategories() {
		$result = $this->db
			->where('master_category_status',1)
			->where('trash',0)
			->get('tbl_master_atrologer_category')
			->result_array();
		return $result;
	}

	public function getAllCategorieName($cat) {
		$result = $this->db
			->where('master_category_id',$cat)
			->where('master_category_status',1)
			->where('trash',0)
			->get('tbl_master_atrologer_category')
			->row();
		return $result->master_category_title;
	}
	public function getAllCategorieNameMulti($cat) {
		$result = $this->db
			->select('master_category_title')
			->where('master_category_id IN('.$cat.')')
			->where('master_category_status',1)
			->where('trash',0)
			->get('tbl_master_atrologer_category')
			->result_array();
		return $result;
	}

	public function getAstroCallChatCharges($astro_uni_id){
		$result = $this->db
			->select('astro_price_type,astro_price_inr,astro_price_dollar')
			->where('astro_uni_id',$astro_uni_id)
			->where('trash',0)
			->get('tbl_astrologer_price')
			->result_array();
		return $result;
	}

    public function getAllcountry() {
        $result = $this->db
            ->get('country')
            ->result_array();
        //print_r($result); die;
        return $result;
    }

    public function getAllcountryName($country_id) {
        $result = $this->db
            ->where('id',$country_id)
            ->get('country')
            ->row();
        return $result->name."-".$result->phonecode;
    }

    public function getCountryById($country_id) {
        $result = $this->db
            ->where('id',$country_id)
            ->get('country')
            ->row();
        return $result;
    }
    public function getCountryByState($state_id) {
        $result = $this->db
            ->select('country.name, country.phonecode')
            ->from('tbl_states')
            ->join('country', 'country.id = tbl_states.country_id')
            ->where('tbl_states.state_id',$state_id)
            ->get()
            ->row();
        return $result->name."-".$result->phonecode;
    }

	///////////// Get All  Categories by id  /////////////////
	public function getAllCategoriesById($category) {
		$result = $this->db
			->where('master_category_status',1)
			->where('trash',0)
			->where('master_category_id IN('.$category.')')
			->get('tbl_master_atrologer_category')
			->result_array();
		return $result;
	}

	///////////// Get Master Category Data By Master Category Id /////////////////
	public function getMasterCategoryDataById($master_id) {
		$result = $this->db
			->where('master_category_id', $master_id)
			->get('tbl_master_atrologer_category')
			->row();
        //print_r($result);exit;
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

	public function getAstroPriceData($astro_id, $type=''){
	    $where  =   array('astro_uni_id' => $astro_id,'trash'=>0);
	    if(!empty($type)){
			$where['astro_price_type'] = $type;
		}
			$result = $this->db
				->where($where)
				->get('tbl_astrologer_price')
				->result();
			return $result;
	}
	
	public function getAstroPriceDataType($astro_id, $type){
			$result = $this->db
				->where('astro_uni_id', $astro_id)
				->where('trash',0)
				->where('astro_price_type',$type)
				->get('tbl_astrologer_price')
				->row();
			return $result;
	}

	public function getProductCategoryById($cat_id){
		$result = $this->db
			->where('id', $cat_id)
			->where('trash',0)
			->get('product_categories')
			->row();
		return $result;
	}

	public function getProductCategoryNameById($cat_id){
	    //echo $cat_id; die;
		$result = $this->db
			->where('id', $cat_id)
			->where('trash',0)
			->get('product_categories')
			->row();
	    //echo $this->db->last_query(); 
		return $result->title;
	}
	
	
    public function getCategoryAll(){
		$result = $this->db
			->where('trash',0)
			->where('status',1)
			->get('product_categories')
			->result();
		return $result;

	}

	public function getSearchCategoryAll($search){
		$result = $this->db
            ->like('title',$search)
			->where('trash',0)
			->where('status',1)
			->get('product_categories')
			->result();
		return $result;

	}
	public function getProductNameById($pro_id){
	    echo $pro_id; die;
		$result = $this->db
			->where('product_id', $pro_id)
			->where('trash',0)
			->get('products')
			->row();
		return $result->product_name;
	}
	public function getProductById($pro_id){
		$result = $this->db
			->where('product_id', $pro_id)
			->where('trash',0)
			->get('products')
			->row();
		return $result;
	}
	public function getProductAll(){
		$result = $this->db
			->where('trash',0)

			->get('products')
			
			->result();
		return $result;
	}
	 public function getProductAllLimits($where_clause='',$sort_by ='',$start='', $limit =''){
        $filter ='';
        //print_r($where_clause);exit();
        if($where_clause != ''){
            $filter .= $where_clause;
        }
        
        if($sort_by != ''){
            $filter .= ' ORDER BY '.$sort_by;
        }
        if($limit != '' || $start != ''){
            $filter .= ' LIMIT '.$start.','.$limit;
        }
        $result = $this->db->query("SELECT 
                                    p.* , pc.* 
                                    FROM products p
                                    INNER JOIN product_categories pc ON pc.id = p.product_category_id
                                    WHERE p.trash = 0 ".$filter);
        $result = $result->result();
			//print_r($result);exit;
        return $result;
    }

    public function getAstroAllLimits($where_clause='',$sort_by ='',$start='', $limit =''){
        //echo "dsff"; die;
        $filter ='';
        
        if($where_clause != ''){
            $filter .= $where_clause;
        }
        
        if($sort_by != ''){
            $filter .= ' ORDER BY '.$sort_by;
        }
        else{
            $filter .= ' ORDER BY tbl_astrologers.dumi_rating DESC';
        }
        if($limit != '' || $start != ''){
            $filter .= ' LIMIT '.$start.','.$limit;
        }
        $result = $this->db->query("SELECT tbl_login.phone_number,tbl_login.email,tbl_astrologers.*, call_price.astro_price_inr AS call_price_Inr,
                                        call_price.astro_price_dollar AS call_price_dollar, chat_price.astro_price_inr AS chat_price_Inr,
                                        chat_price.astro_price_dollar AS chat_price_dollar, tbl_login.referal_code, tbl_city.city_name,tbl_states.state_name,
                                        tbl_master_language.language_name,  tbl_login.user_fcm_token,tbl_login.user_ios_token,tbl_login.fcm_key,
                                        tbl_login.self_referal_code
                                        FROM tbl_login
                                        INNER JOIN tbl_astrologers ON tbl_astrologers.astrologers_uni_id = tbl_login.uni_id AND tbl_astrologers.trash=0 AND tbl_astrologers.astrologers_status=1
                                        LEFT JOIN tbl_astrologer_price AS call_price ON call_price.astro_uni_id = tbl_login.uni_id AND call_price.astro_price_type='call'
                                        LEFT JOIN tbl_astrologer_price AS chat_price ON chat_price.astro_uni_id = tbl_login.uni_id AND chat_price.astro_price_type='chat'
                                        LEFT JOIN tbl_city ON tbl_city.city_id = tbl_astrologers.astrologers_city
                                        LEFT JOIN tbl_states ON tbl_states.state_id = tbl_astrologers.astrologers_state
                                        LEFT JOIN tbl_master_language ON tbl_master_language.language_id = tbl_astrologers.astrologers_language
                                        WHERE tbl_login.trash=0 AND tbl_login.login_status=1 ".$filter);
        $result = $result->result_array();
			//print_r($this->db->last_query());exit;
        return $result;
    }
   
                                        
	public function getAstrologerNameById($astro_id) {
        $result = $this->db
            ->join('tbl_login','tbl_login.uni_id = tbl_astrologers.astrologers_uni_id')
            ->where('tbl_astrologers.astrologers_uni_id',$astro_id)
            ->where('tbl_astrologers.trash',0)
            ->get('tbl_astrologers')
            ->row();
        if(!empty($result)){
            return $result->astrologers_name;
        }
        else{
            return '';
        }
    
    }
    
    
    public function getAstrologerById($astro_id) {
        $result = $this->db
            ->select('tbl_astrologers.*, tbl_login.phone_number,tbl_login.email,tbl_login.username,tbl_login.uni_id,tbl_login.user_fcm_token,tbl_login.user_ios_token')
            ->from('tbl_astrologers')
            ->join('tbl_login','tbl_login.uni_id = tbl_astrologers.astrologers_uni_id')
            ->where('astrologers_uni_id',$astro_id)
            ->where('tbl_astrologers.trash',0)
            ->get()
            ->row();
        return $result;
    }
    
    
    public function getAstrologerByPhone($phone) {
        $result = $this->db
            ->select('tbl_astrologers.*, tbl_login.phone_number,tbl_login.email')
            ->from('tbl_astrologers')
            ->join('tbl_login','tbl_login.uni_id = tbl_astrologers.astrologers_uni_id')
            ->where('tbl_login.phone_number',$phone)
            ->where('tbl_astrologers.trash',0)
            ->get()
            ->row();
        return $result;
    }
    public function getAstrologerAll() {
        $result = $this->db
            ->join('tbl_login','tbl_login.uni_id = tbl_astrologers.astrologers_uni_id')
            ->where('tbl_astrologers.trash',0)
            ->get('tbl_astrologers')
            ->result();
        return $result;
    }
    public function getAstrologerAllValue($limit = '') {
        $result = $this->db->query("SELECT tbl_login.phone_number,tbl_login.email,tbl_astrologers.*, call_price.astro_price_inr AS call_price_Inr,
                                        call_price.astro_price_dollar AS call_price_dollar, chat_price.astro_price_inr AS chat_price_Inr,
                                        chat_price.astro_price_dollar AS chat_price_dollar, tbl_login.referal_code, tbl_city.city_name,tbl_states.state_name,
                                        tbl_master_language.language_name,  tbl_login.user_fcm_token,tbl_login.user_ios_token,tbl_login.fcm_key,
                                        tbl_login.self_referal_code
                                        FROM tbl_login
                                        INNER JOIN tbl_astrologers ON tbl_astrologers.astrologers_uni_id = tbl_login.uni_id AND tbl_astrologers.trash=0 AND tbl_astrologers.astrologers_status=1
                                        LEFT JOIN tbl_astrologer_price AS call_price ON call_price.astro_uni_id = tbl_login.uni_id AND call_price.astro_price_type='call'
                                        LEFT JOIN tbl_astrologer_price AS chat_price ON chat_price.astro_uni_id = tbl_login.uni_id AND chat_price.astro_price_type='chat'
                                        LEFT JOIN tbl_city ON tbl_city.city_id = tbl_astrologers.astrologers_city
                                        LEFT JOIN tbl_states ON tbl_states.state_id = tbl_astrologers.astrologers_state
                                        LEFT JOIN tbl_master_language ON tbl_master_language.language_id = tbl_astrologers.astrologers_language
                                        WHERE tbl_login.trash=0 AND tbl_login.login_status=1 ORDER BY tbl_astrologers.dumi_rating DESC LIMIT $limit")->result();
        //  print_r($result); exit;    
            
        return $result;
    }

    public function getCustomerNameById($cus_id) {
        $result = $this->db
            ->where('customer_uni_id',$cus_id)
            //->where('trash',0)
            ->get('tbl_customer')
            ->row();
           // echo $result->customer_name; exit;
           if(!empty($result)){
               return $result->customer_name;
           }
        return false;
    }
    public function getCustomerById($cus_id) {
        $result = $this->db
            ->select('tbl_customer.*, tbl_login.phone_number,tbl_login.email,country.name as countryName,country.phonecode')
            ->from('tbl_customer')
            ->join('tbl_login','tbl_login.uni_id = tbl_customer.customer_uni_id')
            ->join('country','country.id = tbl_customer.customer_country_id')
            ->where('customer_uni_id',$cus_id)
            ->where('tbl_customer.trash',0)
            ->get()
            ->row();
        return $result;
    }
    public function getCustomerByPhone($phone) {
        $result = $this->db
            ->select('tbl_customer.*, tbl_login.phone_number,tbl_login.email,country.name as countryName,country.phonecode')
            ->from('tbl_customer')
            ->join('tbl_login','tbl_login.uni_id = tbl_customer.customer_uni_id')
            ->join('country','country.id = tbl_customer.customer_country_id')
            ->where('tbl_login.phone_number',$phone)
            ->where('tbl_customer.trash',0)
            ->get()
            ->row();
        return $result;
    }
    public function getCustomerAll() {
        $result = $this->db
            ->where('trash',0)
            ->get('tbl_customer')
            ->result();
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

    ///////////// Get All Report Name /////////////////
    public function getAllReportName() {
        $result = $this->db
            ->where('report_status',1)
            ->get('tbl_master_report')
            ->result();
        return $result;
    }

    ///////////// Get All Report Id By Name /////////////////
    public function getNameByReportName($report_id) {
        $result = $this->db
            ->where('report_id',$report_id)
            ->where('report_status',1)
            ->get('tbl_master_report')
            ->row();
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
			'1' => 'O−',
			'2' => 'O+',
			'3' => 'A−',
			'4' => 'A+',
			'5' => 'B−',
			'6' => 'B+',
			'7' => 'AB−',
			'8' => 'AB+',

		);
		return $groups;
	}



    ///////////// Get All  Cities /////////////////
	public function getAllCityData() {
			$result = $this->db
				->get('tbl_city')
				->result_array();
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

    ///////////// Get Offer Data By Offer Code /////////////////
    public function getOfferDataByCode($offer_code) {
        $result = $this->db
            ->where('coupon_code', $offer_code)
            ->get('tbl_coupons')
            ->row();
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
            //print_r($row);die();

			foreach ($form_data as $value) {
				if ($result_data == "") {
					$result_data = $row->$value;
				} else {
					$result_data = $result_data . " ^@^ " . $row->$value;
				}
			}
            //print_r($result_data);die();
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
        // print_r($sql);die();
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
		$this->_get_datatables_query($table_name,$column_order,$column_search,$order,$where_clause, $join_table);
		if($_REQUEST['length'] != -1)
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        
		$query = $this->db->get();

		return $query->result();
	}


    //////////////////////// Get DataTable Data ///////////////////////////
	private function _get_datatables_query($table_name,$column_order,$column_search,$order,$where_clause='', $join_table='')
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
                    //$this->db->like($item, $_REQUEST['search']['value']);
				}
				else
				{
					$this->db->where($key, $value);
                    //$this->db->or_like($item, $_REQUEST['search']['value']);
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

		if(isset($_REQUEST['order'])) // here order processing
		{
		    //print_r($_REQUEST['order']); exit;
			$this->db->order_by($column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
		}
		else if(isset($order))
		{
            //$order = $order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	//////////////////// Count Number of Rows Filtered  /////////////////////////////
	public function count_filtered($table_name,$column_order,$column_search,$order,$where_clause='', $join_table='')
	{
		$this->_get_datatables_query($table_name,$column_order,$column_search,$order,$where_clause, $join_table);
		$query = $this->db->get();
		return $query->num_rows();
	}
	//////////////////// Total Number of Rows in Filtered Table /////////////////////////////
	public function count_all($table_name)
	{
		$this->db->from($table_name);
		return $this->db->count_all_results();
	}
	
	
	//////////////////////Call History ///////////////
	public function callHistories($where){
	    
	    $result   = $this->db->query("SELECT call_history.*, astro.email AS astro_email, astro.phone_number AS astro_phone, tbl_astrologers.astrologers_name,
                                        tbl_astrologers.astrologers_address, call_price.astro_price_inr AS call_price_Inr,call_price.astro_price_dollar AS call_price_dollar, 
                                        chat_price.astro_price_inr AS chat_price_Inr,chat_price.astro_price_dollar AS chat_price_dollar, 
                                        users.email AS user_email, users.phone_number AS user_phone, tbl_customer.customer_name,tbl_customer.customer_address  
                                        FROM `call_history`
                                        LEFT JOIN tbl_login AS astro ON astro.uni_id =  call_history.astrologers_uni_id AND astro.login_status=1
                                        LEFT JOIN tbl_astrologers ON tbl_astrologers.astrologers_uni_id = call_history.astrologers_uni_id AND tbl_astrologers.astrologers_status=1 AND tbl_astrologers.trash=0
                                        LEFT JOIN tbl_astrologer_price AS call_price ON call_price.astro_uni_id = astro.uni_id AND call_price.astro_price_type='call'
                                        LEFT JOIN tbl_astrologer_price AS chat_price ON chat_price.astro_uni_id = astro.uni_id AND chat_price.astro_price_type='chat'
                                        LEFT JOIN tbl_login AS users ON users.uni_id =  call_history.user_uni_id AND users.login_status=1 
                                        LEFT JOIN tbl_customer ON tbl_customer.customer_uni_id = call_history.user_uni_id AND tbl_customer.customer_status=1  AND tbl_customer.trash=0
                                        ".$where." ORDER BY call_history.id DESC ");  
        if($result->num_rows() > 0){
            $data   = $result->result_array();
        }
        else{
            $data  = array();
        }
        return  $data;
	} 

    public function getAllAstrologers($search="", $sort_by = "", $limit=0){
        $where         =   '';
        if(!empty($search)){
            $where     =   " AND (tbl_login.phone_number ='".$search."' OR tbl_login.email='".$search."' OR call_price.astro_price_inr='".$search."' OR call_price.astro_price_dollar='".$search."' 
                            OR chat_price.astro_price_inr='".$search."' OR chat_price.astro_price_dollar='".$search."'
                            OR tbl_astrologers.astrologers_address LIKE '%$search%' OR  tbl_astrologers.astrologers_name LIKE '%$search%' OR   tbl_astrologers.astrologers_skills LIKE '%$search%' OR 
                            tbl_astrologers.astrologers_fees LIKE '%$search%' OR tbl_astrologers.astrologers_experience LIKE '%$search%' OR FIND_IN_SET(tbl_master_atrologer_category.master_category_title, '".$search."') > 0 
                            OR tbl_city.city_name LIKE '%$search%' OR tbl_states.state_name LIKE '%$search%') ";
        }
        $orderby        =   ' Order By  tbl_astrologers.busy_status DESC, tbl_astrologers.chat_busy_status DESC, tbl_astrologers.dumi_rating DESC';
        if(!empty($sort_by)){
            if($sort_by == "Call"){
                $orderby    =   'Order By tbl_astrologers.busy_status DESC';
            }
            elseif($sort_by == "Chat"){
                $orderby    =   'Order By tbl_astrologers.chat_busy_status DESC';
            }
            elseif($sort_by == "Call Price Low to High"){
                $orderby    =   'Order By call_price.astro_price_inr ASC';
            }
            elseif($sort_by == "Call Price High to Low"){
                $orderby    =   ' Order By call_price.astro_price_inr DESC';
            }   
            elseif($sort_by == "Chat Price Low to High"){
                $orderby    =   ' Order By chat_price.astro_price_inr ASC';
            }
            elseif($sort_by == "Chat Price High to Low"){
                $orderby    =   ' Order By chat_price.astro_price_inr DESC';
            }
            elseif($sort_by == "Name Wise A to Z"){
                $orderby    =   ' Order By tbl_astrologers.astrologers_name ASC';
            }
            elseif($sort_by == "Name Wise Z to A"){
                $orderby    =   ' Order By tbl_astrologers.astrologers_name DESC';
            }
            elseif($sort_by == "Rating High to Low"){
                $orderby    =   ' Order By rating DESC';
            }
            elseif($sort_by == "Rating Low to High"){
                $orderby    =   ' Order By rating ASC';
            }
            elseif($sort_by == "City A to Z"){
                $orderby    =   ' Order By tbl_city.city_name ASC';
            }
            elseif($sort_by == "City Z to A"){
                $orderby    =   ' Order By tbl_city.city_name DESC';
            }
            
        }
        $group_by  = " GROUP BY tbl_login.uni_id ";
        $result     =   $this->db->query("SELECT tbl_login.phone_number,tbl_login.email, tbl_login.mobile_verify, tbl_login.fcm_user_id, tbl_astrologers.*, call_price.astro_price_inr AS call_price_Inr,
                                        call_price.astro_price_dollar AS call_price_dollar, chat_price.astro_price_inr AS chat_price_Inr,
                                        chat_price.astro_price_dollar AS chat_price_dollar, tbl_login.referal_code, tbl_city.city_name,tbl_states.state_name,
                                        GROUP_CONCAT(tbl_master_atrologer_category.master_category_title ORDER BY tbl_master_atrologer_category.master_category_id) AS category_title,
                                        tbl_master_language.language_name, IFNULL(SUM(tbl_review.review_rating), 0) AS rating , tbl_login.user_fcm_token,tbl_login.user_ios_token,tbl_login.fcm_key,
                                        tbl_login.self_referal_code
                                        FROM tbl_login
                                        INNER JOIN tbl_astrologers ON tbl_astrologers.astrologers_uni_id = tbl_login.uni_id AND tbl_astrologers.trash=0 AND tbl_astrologers.astrologers_status=1
                                        LEFT JOIN tbl_astrologer_price AS call_price ON call_price.astro_uni_id = tbl_login.uni_id AND call_price.astro_price_type='call'
                                        LEFT JOIN tbl_astrologer_price AS chat_price ON chat_price.astro_uni_id = tbl_login.uni_id AND chat_price.astro_price_type='chat'
                                        LEFT JOIN tbl_city ON tbl_city.city_id = tbl_astrologers.astrologers_city
                                        LEFT JOIN tbl_states ON tbl_states.state_id = tbl_astrologers.astrologers_state
                                        LEFT JOIN tbl_master_atrologer_category ON FIND_IN_SET(tbl_master_atrologer_category.master_category_id, tbl_astrologers.astrologers_category_list) > 0 
                                        LEFT JOIN tbl_master_language ON tbl_master_language.language_id = tbl_astrologers.astrologers_language
                                        LEFT JOIN tbl_review ON tbl_review.review_for_id = tbl_login.uni_id AND tbl_review.trash=0
                                        WHERE tbl_login.trash=0 AND tbl_login.login_status=1".$where.$group_by.$orderby." ".$limit);
                                        //print_r($this->db->last_query()); exit;
        if($result->num_rows() > 0){
            $datas   = $result->result_array();
            $rating_dd = array();
            foreach($datas as $data){
                    
                    $Catresult     = $this->db->query("SELECT master_category_id, master_category_title FROM `tbl_master_atrologer_category` WHERE master_category_id IN (".$data['astrologers_category_list'].")  ");
                    $ratingdata    = $Catresult->result_array();
                    
                    $ratings       = $this->getReviewRating($data['astrologers_uni_id']);
                    $rating_dd     = array();
                    foreach($ratings as $value){
                        $rating_dd[] = array(
                            'review_id' => $value['review_id'] ,
                            'review_rating' => $value['review_rating'] ,
                            'review_comment' => $value['review_comment'] ,
                            'username' => substr($value['username'],0,2) ,
                            'email' => $value['email'] ,
                            'phone_number' => $value['phone_number'] ,
                            'created_at' => date('d-M-Y',$value['created_at']) ,
                            'customer_image_url' => $value['customer_image_url'] ,
                             'customer_image' => $value['customer_image'] 
                            
                            );
                    }
                    
                    // language
                    $language       =   '';
                    $langresult     = $this->db->query("SELECT language_id, language_name FROM `tbl_master_language` WHERE language_id IN (".$data['astrologers_language'].") ");
                    $langdata    = $langresult->result_array();
                    foreach($langdata as $langdatas){
                        if(empty($language)){
                            $language   = $langdatas['language_name'];
                        }
                        else{
                            $language   = $language.', '.$langdatas['language_name'];
                        }
                    }
                    //print_r($ratings); die;
                    $user          = 0;
                    $sumrating     = 0;
                    
                    foreach($ratings as $rows){
                        $user       +=1;
                        $sumrating  +=$rows['review_rating'];
                    }
                    $totalRating    =   0;
                    if(!empty($user)){
                        $totalRating  = $sumrating/$user;
                    }
                    
                    
                    $dumirating    = !empty($data['dumi_rating']) ? $data['dumi_rating'] : '0';
                    $rating        = !empty($data['rating']) ? $data['rating'] : '0';
                    $overallRatting = (int)$dumirating + (int)$rating;
                    
                    $results[] = array(
                                "phone_number"                  => !empty($data['phone_number']) ? $data['phone_number'] : '',
                                "email"                         => !empty($data['email']) ? $data['email'] : '',
                                "verify"                         => !empty($data['mobile_verify']) ? '1' : '0',
                                "astrologers_id"                => !empty($data['astrologers_id']) ? $data['astrologers_id'] : '',
                                "astrologers_uni_id"            => !empty($data['astrologers_uni_id']) ? $data['astrologers_uni_id'] : '',
                                "astrologers_slug"              => !empty($data['astrologers_slug']) ? $data['astrologers_slug'] : '',
                                "astrologers_online_portal"     => !empty($data['astrologers_online_portal']) ? $data['astrologers_online_portal'] : '',
                                "astrologers_name"              => !empty($data['astrologers_name']) ? $data['astrologers_name'] : '',
                                "astrologers_dob"               => !empty($data['astrologers_dob']) ? $data['astrologers_dob'] : '',
                                "astrologers_gender"            => !empty($data['astrologers_gender']) ? $data['astrologers_gender'] : '',
                                "astrologers_alternative_phone" => !empty($data['astrologers_alternative_phone']) ? $data['astrologers_alternative_phone'] : '',
                                "astrologers_address"           => !empty($data['astrologers_address']) ? $data['astrologers_address'] : '',
                                "astrologers_city"              => !empty($data['astrologers_city']) ? $data['astrologers_city'] : '',
                                "astrologers_state"             => !empty($data['astrologers_state']) ? $data['astrologers_state'] : '',
                                "astrologers_pincode"           => !empty($data['astrologers_pincode']) ? $data['astrologers_pincode'] : '',
                                "astrologers_image"             => !empty($data['astrologers_image']) ? $data['astrologers_image'] : '',
                                "astrologers_image_url"         => !empty($data['astrologers_image_url']) ? $data['astrologers_image_url'] : '',
                                "astrologers_id_proof"          => !empty($data['astrologers_id_proof']) ? $data['astrologers_id_proof'] : '',
                                "astrologers_long_biography"    => !empty($data['astrologers_long_biography']) ? base64_decode($data['astrologers_long_biography']) : '',
                                "astrologers_short_biography"   => !empty($data['astrologers_short_biography']) ? base64_decode($data['astrologers_short_biography']) : '',
                                "astrologers_experience"        => !empty($data['astrologers_experience']) ? $data['astrologers_experience'] : '',
                                "astrologers_pancard"           => !empty($data['astrologers_pancard']) ? $data['astrologers_pancard'] : '',
                                "astrologers_skills"            => !empty($data['astrologers_skills']) ? $data['astrologers_skills'] : '',
                                "astrologers_language"          => $language,
                                "astrologers_category_list"     => !empty($data['astrologers_category_list']) ? $data['astrologers_category_list'] : '',
                                "astrologers_status"            => !empty($data['astrologers_status']) ? $data['astrologers_status'] : '',
                                "astrologers_fees"              => !empty($data['astrologers_fees']) ? $data['astrologers_fees'] : '',
                                "astrologers_position"          => !empty($data['astrologers_position']) ? $data['astrologers_position'] : '',
                                "astrolozer_bank_name"          => !empty($data['astrolozer_bank_name']) ? $data['astrolozer_bank_name'] : '',
                                "astrolozer_acc_no"             => !empty($data['astrolozer_acc_no']) ? $data['astrolozer_acc_no'] : '',
                                "astrolozer_acc_type"           => !empty($data['astrolozer_acc_type']) ? $data['astrolozer_acc_type'] : '',
                                "astrolozer_ifsc_code"          => !empty($data['astrolozer_ifsc_code']) ? $data['astrolozer_ifsc_code'] : '',
                                "astrolozer_acc_name"           => !empty($data['astrolozer_acc_name']) ? $data['astrolozer_acc_name'] : '',
                                "astro_call_status"             => !empty($data['astro_call_status']) ? $data['astro_call_status'] : '0',
                                "astro_chat_status"             => !empty($data['astro_chat_status']) ? $data['astro_chat_status'] : '0',
                                "astro_call_online_time"        => !empty($data['astro_call_online_time']) ? $data['astro_call_online_time'] : '',
                                "astro_call_online_date"        => !empty($data['astro_call_online_date']) ? $data['astro_call_online_date'] : '',
                                "astro_online_chat_time"        => !empty($data['astro_online_chat_time']) ? $data['astro_online_chat_time'] : '',
                                "astro_online_chat_date"        => !empty($data['astro_online_chat_date']) ? $data['astro_online_chat_date'] : '',
                                "astro_query_status"            => !empty($data['astro_query_status']) ? $data['astro_query_status'] : 0,
                                "astro_query_status_time"       => !empty($data['astro_query_status_time']) ? $data['astro_query_status_time'] : '',
                                "astro_report_status"           => !empty($data['astro_report_status']) ? $data['astro_report_status'] : 0,
                                "astro_report_status_time"      => !empty($data['astro_report_status_time']) ? $data['astro_report_status_time'] : '',
                                "current_wallet_amt"            => !empty($data['current_wallet_amt']) ? $data['current_wallet_amt'] : 0,
                                "astrologer_online_portal"      => !empty($data['astrologer_online_portal']) ? $data['astrologer_online_portal'] : '',
                                "created_by"                    => !empty($data['created_by']) ? $data['created_by'] : '',
                                "created_at"                    => !empty($data['created_at']) ? $data['created_at'] : '',
                                "updated_by"                    => !empty($data['updated_by']) ? $data['updated_by'] : '',
                                "updated_at"                    => !empty($data['updated_at']) ? $data['updated_at'] : '',
                                "trash_by"                      => !empty($data['trash_by']) ? $data['trash_by'] : '',
                                "trash"                         => !empty($data['trash']) ? $data['trash'] : 0,
                                "call_price_Inr"                => !empty($data['call_price_Inr']) ? $data['call_price_Inr'] : '0',
                                "call_price_dollar"             => !empty($data['call_price_dollar']) ? $data['call_price_dollar'] : '0',
                                "chat_price_Inr"                => !empty($data['chat_price_Inr']) ? $data['chat_price_Inr'] : '0',
                                "chat_price_dollar"             => !empty($data['chat_price_dollar']) ? $data['chat_price_dollar'] : '0',
                                "city_name"                     => !empty($data['city_name']) ? $data['city_name'] : '',
                                "state_name"                    => !empty($data['state_name']) ? $data['state_name'] : '',
                                "category_title"                => !empty($data['category_title']) ? $data['category_title'] : '', 
                                "language_name"                 => !empty($data['language_name']) ? $data['language_name'] : '', 
                                "rating"                        => (string)$overallRatting,
                                "user_fcm_token"                => !empty($data['user_fcm_token']) ? $data['user_fcm_token'] : '',
                                "user_ios_token"                => !empty($data['user_ios_token']) ? $data['user_ios_token'] : '',
                                "fcm_user_id"                   => !empty($data['fcm_user_id']) ? $data['fcm_user_id'] : '',
                                "fcm_key"                       => !empty($data['fcm_key']) ? $data['fcm_key'] : '',
                                "self_referal_code"             => !empty($data['self_referal_code']) ? $data['self_referal_code'] : '',
                                'reviews'                       =>  $rating_dd,
                                'category_arr'                  =>  $ratingdata,
                                'avrageRating'                  =>  (string)$totalRating,
                                "call_busy_status"              => !empty($data['busy_status']) ? $data['busy_status'] : '0',
                                "chat_busy_status"              => !empty($data['chat_busy_status']) ? $data['chat_busy_status'] : '0',
                    );
                    unset($rating_dd);
            }
            
        }
        else{
            $results  = array();
        }
        return  $results;
    }
    
    public function getAstroService(){
        $datas      =   array();
        $result     =   $this->db->query("SELECT * FROM  tbl_master_atrologer_category WHERE trash=0 AND master_category_status=1");
        if($result->num_rows() > 0){
            $datas   = $result->result_array();
        }
        return  $datas;
    }
    public function getAllBannerCategory() {
		$result = $this->db
			->where('banner_category_status',1)
			->get('tbl_banner_category')
			->result_array();
		return $result;
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
	
	public function getReviewRating($astrologers_uni_id){
	    $datas      =   array();
        $result     =   $this->db->query("SELECT tbl_review.review_id, tbl_review.review_rating, tbl_review.review_comment,tbl_login.username,tbl_login.email, tbl_login.phone_number , tbl_review.created_at , tbl_customer.customer_image_url, tbl_customer.customer_image
                                            FROM  tbl_review
                                            LEFT JOIN tbl_login ON tbl_login.uni_id = tbl_review.review_by_id 
                                            LEFT JOIN tbl_customer ON tbl_customer.customer_uni_id = tbl_review.review_by_id 
                                            WHERE review_for_id='".$astrologers_uni_id."' AND review_status=1 AND tbl_review.trash=0");
        if($result->num_rows() > 0){
            $datas   = $result->result_array();
        }
        return  $datas;
	    
	}
	
	public function getUserNameById($id){
	    $result = $this->db
			->select('*')
			->where('uni_id', $id)
			->where('trash', '0')
			->get('tbl_login')
			->row();
		return $result->username;
	}



}
