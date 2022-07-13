<<<<<<< HEAD
<?php

Class ProductTbl_Model extends CI_Model {

    var $tbl_name = 'products';

    public function __construct() {
        parent::__construct();
    }

}

class Products_model extends ProductTbl_Model {

    public function __construct() {
        parent::__construct();
    }
    
    function getProduct($product_id){
        $row = $this -> db
            //-> select('id')
            -> where('product_id', $product_id)
            ->where('trash',0)
            -> limit(1)
            -> get('products')
            -> row_array();
        return $row;
    }
    
     function getProductByVarient($product_id, $product_varient_id){
        
        $row = $this->db->query("SELECT products.*, product_varient.*,deal_product.deal_price  FROM `products` 
                                INNER JOIN product_varient On product_varient.product_id = products.product_id
                                LEFT JOIN deal_product ON deal_product.product_id = products.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()
                                WHERE product_varient.product_id = '".$product_id."' AND 
                                product_varient.varient_id='".$product_varient_id."' AND products.trash=0 ")->row_array();
        return $row;
    }

    function get_products($in_stock = false, $cat_id = "", $search = "", $page = "", $slug='', $brand="", $type='') {
		
        $filter = "";
        $limit = "";
        $page_limit = 10;
        if ($page != "") {
            $limit .= " limit " . (($page - 1) * $page_limit) . "," . $page_limit . " ";
        }
        if ($in_stock) {
            $filter .= " and products.in_stock = 1 ";
        }
        if ($cat_id != "") {
            $filter .= " and products.category_id IN (" . $cat_id . ") ";
        }
        if ($search != "") {
            $filter .= " and (products.product_name like '%". rtrim($search)."%' OR categories.title like '%". rtrim($search)."%' OR tbl_brand.title like '%". rtrim($search)."%'  )";
        }
        if(!empty($brand)){
            if($type == 'category'){
                $filter .= " and categories.slug = '".$brand."'";
            }
            elseif($type == 'brand'){
                $filter .= " and tbl_brand.slug = '".$brand."'";
            }elseif($type == 'product'){
                $filter .= " and products.product_slug = '".$brand."'";
            }
            else{
                $filter .= " and tbl_brand.slug = '".$brand."'";
            }
            
        }
        if ($slug != "") {
            $filter .= " and ( products.product_slug LIKE '%".$slug."%' OR products.product_name LIKE '%".$slug."%')";
        }
        $sql = "Select dp.*,products.*, products.mrp - products.price as difference_price, 
                ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title, categories.slug, tbl_brand.title as brand_name from products 
                inner join categories on categories.id = products.category_id
                left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                left join deal_product dp on dp.product_id=products.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
                LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                where 1 AND products.trash = 0 " . $filter . " ORDER BY products.product_id DESC " . $limit;
           //echo $sql; exit;     
        $q = $this->db->query($sql);
        $products = $q->result_array();
        
        return $products;
    }
    
    
    function get_products_by_filter($in_stock = false, $cat_id = "", $search = "", $page = "", $brand_ids1="", $review="", $filter_price="", $min="", $max="", $filter_order_by="", $category_ids1="", $cat_type_ids1="") {
		//echo $page;
           //echo $category_ids1;   
        
        //die();
        $filter = "";
        $limit = "";
        $filter_order ="";
        $page_limit = 9;
        if ($page != "") {
            $limit .= " limit " . (($page - 1) * $page_limit) . "," . $page_limit . " ";
        }
        if ($in_stock) {
            $filter .= " and products.in_stock = 1 ";
        }

        
        if ($brand_ids1 != "") {
            $filter .= " and products.brand_id IN (" . $brand_ids1 . ") ";
        }
        
        if ($category_ids1 != "") {
            $filter .= " and products.category_id IN (" . $category_ids1 . ") ";
        }
        
        if ($cat_type_ids1 != "") {
            $filter .= " and products.product_cat_type_id IN (" . $cat_type_ids1 . ") ";
        }
        
        if ($review != "") {
            $filter .= " and rtt.rate IN (" . $review . ") ";
        }
        
        if ($filter_price != "") {
            $filter .= " and pv.price>='".$min."' and pv.price<='".$max."'";
        }
        
        if ($filter_order_by != "") {
            if($filter_order_by=="name1")
            {
                $filter_order .= " ORDER BY products.product_name asc";
            }
            elseif($filter_order_by=="name2")
            {
                $filter_order .= " ORDER BY products.product_name desc";
            }
            elseif($filter_order_by=="price1")
            {
                $filter_order .= " ORDER BY pv.price asc";
            }
            elseif($filter_order_by=="price2")
            {
                $filter_order .= " ORDER BY pv.price desc";
            }
            
        }
        
        
       $sql = "Select dp.*, rtt.rate as avg_rating, pv.*, products.*, products.mrp - products.price as difference_price, 
                ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title, categories.slug, tbl_brand.title as brand_name from products 
                left join categories on categories.id = products.category_id
                left join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                left join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                left join deal_product dp on dp.product_id=products.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
                LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                LEFT JOIN (select avg(rt.rating) as rate, rt.product_id from rating_table rt where rt.review_trash=0 and rt.review_status=0 group by rt.product_id) rtt on rtt.product_id = products.product_id 
                LEFT JOIN product_varient pv on pv.product_id = products.product_id AND pv.trash=0
                where 1 AND products.trash = 0 " . $filter . " group by products.product_id  ".$filter_order. " ". $limit;
           //echo $sql; exit;     
        $q = $this->db->query($sql);
        $products = $q->result_array();
        //$total = count($products);
        //print_r($products);
        
        return $products;
    }
    
    function get_products_details_by_filter($in_stock = false, $cat_id = "", $search = "", $page = "", $brand_ids1="", $review="", $filter_price="", $min="", $max="", $filter_order_by="", $category_ids1="", $cat_type_ids1="") {
		//echo $page;
        
        //die();
        $filter = "";
        $limit = "";
        $filter_order ="";
        $page_limit = 9;
        if ($page != "") {
            $limit .= " limit " . (($page - 1) * $page_limit) . "," . $page_limit . " ";
        }
        if ($in_stock) {
            $filter .= " and products.in_stock = 1 ";
        }

        
        if ($brand_ids1 != "") {
            $filter .= " and products.brand_id IN (" . $brand_ids1 . ") ";
        }
        
        if ($category_ids1 != "") {
            $filter .= " and products.category_id IN (" . $category_ids1 . ") ";
        }
        
        if ($cat_type_ids1 != "") {
            $filter .= " and products.product_cat_type_id IN (" . $cat_type_ids1 . ") ";
        }
        
        if ($review != "") {
            $filter .= " and rtt.rate IN (" . $review . ") ";
        }
        
        if ($filter_price != "") {
            $filter .= " and pv.price>='".$min."' and pv.price<='".$max."'";
        }
        
        if ($filter_order_by != "") {
            if($filter_order_by=="name1")
            {
                $filter_order .= " ORDER BY products.product_name asc";
            }
            elseif($filter_order_by=="name2")
            {
                $filter_order .= " ORDER BY products.product_name desc";
            }
            elseif($filter_order_by=="price1")
            {
                $filter_order .= " ORDER BY pv.price asc";
            }
            elseif($filter_order_by=="price2")
            {
                $filter_order .= " ORDER BY pv.price desc";
            }
            
        }
        
        
        $sql = "Select dp.*, rtt.rate as avg_rating, pv.*, products.*, products.mrp - products.price as difference_price, 
                ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title, categories.slug, tbl_brand.title as brand_name from products 
                inner join categories on categories.id = products.category_id
                left join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                left join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                left join deal_product dp on dp.product_id=products.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
                LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                LEFT JOIN (select avg(rt.rating) as rate, rt.product_id from rating_table rt where rt.review_trash=0 and rt.review_status=0 group by rt.product_id) rtt on rtt.product_id = products.product_id 
                LEFT JOIN product_varient pv on pv.product_id = products.product_id AND pv.trash=0
                where 1 AND products.trash = 0 " . $filter . " group by products.product_id  ".$filter_order. " ". $limit;
           //echo $sql; exit;     
        $q = $this->db->query($sql);
        $products = $q->result_array();
        //$total = count($products);
        //print_r($products);
        
        return $products;
    }
    
    function getRecentAddProduct(){
        if (empty($limit)) {
            $limit = 15;
        }
        $sql = "SELECT  
                    p.*, dp.start_date, dp.start_time, dp.end_time, dp.deal_price, c.title,
                    p.mrp - p.price AS difference_price, tbl_brand.title as brand_name
                FROM
                    products p
                        INNER JOIN categories c ON c.id = p.category_id
                        LEFT JOIN deal_product dp ON dp.product_id = p.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
                        LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                    WHERE p.trash = 0
                    GROUP BY p.product_id
                    ORDER BY product_id DESC
                    LIMIT $limit";

                    //echo $sql;die;
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getTopSellingProducts($limit = NULL) {
        if (empty($limit)) {
            $limit = 16;
        }
        $sql = "SELECT  
                    p.*, dp.start_date, dp.start_time, dp.end_time, dp.deal_price, c.title,
                    p.mrp - p.price AS difference_price,
                    COUNT(si.product_id) AS top,
                    si.product_id ,tbl_brand.title as brand_name
                FROM
                    products p
                        INNER JOIN sale_items si ON p.product_id = si.product_id
                        LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                        INNER JOIN categories c ON c.id = p.category_id
                        LEFT JOIN deal_product dp ON dp.product_id = si.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
                    WHERE p.trash = 0
                    GROUP BY si.product_id
                    ORDER BY top DESC
                    LIMIT $limit";

                    //echo $sql;die;
        $query = $this->db->query($sql)->result_array();

        return $query;
        
    }

    public function getDealProducts($limit = NULL) {
        if (empty($limit)) {
            $limit = 16;
        }
	
        $sql = "SELECT 
                    deal_product.*, products.*, categories.title, tbl_brand.title as brand_name
                FROM
                    deal_product
                        INNER JOIN products ON deal_product.product_id = products.product_id
                        LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                        INNER JOIN product_varient ON product_varient.varient_id = deal_product.pro_var_id
                        INNER JOIN categories ON categories.id = products.category_id
                    WHERE CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()
                    LIMIT $limit";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getFeatureBanner($limit = 5) {
        $sql = "Select * from feature_slider LIMIT $limit";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getBanner($limit = 10) {
        $sql = "Select * from banner LIMIT $limit";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getCategorys($parent) {
        $where = "WHERE 1";
        if (!empty($parent)) {
            $where .= " AND a.`parent`=" . $parent;
        }
        $sql = "SELECT 
                    a.*, IFNULL(Deriv1.Count, 0) AS Count, IFNULL(Total1.PCount, 0) AS PCount
                FROM
                `categories` a
                    LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent`
                    LEFT OUTER JOIN (SELECT `category_id`, COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id`
                    $where ";

        $query = $this->db->query($sql);
        return $query->result_array();
//        $categories = $this->getCategoriesShort(0, 0);
//        return $categories;
    }

    /*
      public function getCategoriesShort($parent, $level) {
      if (empty($level)) {
      $level = 0;
      }
      $result_array = $this->getCategorys($parent);
      $return_array = array();

      foreach ( $result_array as $row) {
      if ($row['Count']>0) {
      $sub_cat = $this->getCategoriesShort($row['id'], $level + 1);
      if(!empty($sub_cat)){
      $row['sub_cat'] = $sub_cat;
      }
      }
      $return_array[] = $row;
      }
      return $return_array;
      }
     */
     
     public function get_brand($start='', $limit= '') {
        return $this -> db
                ->where('trash',0)
                ->where('status',1)
                ->limit($limit, $start)
                -> order_by('title')
                -> get('tbl_brand')
                -> result();
    }
    
    public function get_menu($limit='', $start='') {
        return $this -> db
                ->where('trash',0)
                ->where('status',1)
                ->limit($limit, $start)
                -> get('tbl_brand')
                -> result();
    }

    public function get_categories() {
        $parent = 0;
        if ($this->input->post("parent")) {
            $parent = $this->input->post("parent");
        }
        $categories = $this->get_categories_short($parent, 0, $this);
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
    }

    public function getCategoriesShort($parent, $level, $th, $cat_type_id='') {
		$filter = "";
        if(!empty($cat_type_id)){
			$filter = "and a.`product_cat_type_id`=$cat_type_id";
		}
		
        $sql = "SELECT 
                    a.*,
                    IFNULL(Deriv1.Count, 0) AS Count,
                    IFNULL(Total1.PCount, 0) AS PCount
                FROM
                    `categories` a
                        LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent`
                        LEFT OUTER JOIN (SELECT  `category_id`, COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id`
                WHERE
                   a.status = 1 and a.`parent`=$parent $filter";
        $q = $th->db->query($sql);
        $return_array = array();
        foreach ($q->result() as $row) {
            if ($row->Count > 0) {
                $sub_cat = $this->getCategoriesShort($row->id, $level + 1, $th, $cat_type_id);
                $row->sub_cat = $sub_cat;
            } elseif ($row->Count == 0) {
                
            }
            $return_array[] = $row;
        }
        return $return_array;
    }
    
    public function getCategoryChild($ids) {
		// $sql = "select id from categories where parent in('".$ids."')";
                // $query = $this->db->query($sql);
        $sql = "SELECT 
                    a.id,
                    IFNULL(Deriv1.Count, 0) AS Count
                FROM
                    `categories` a
					LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent`
                WHERE
					a.status = 1 and a.`parent` in('".$ids."')";
					
        $q = $this->db->query($sql);
        $return_array = array();
        foreach ($q->result() as $row) {
            if ($row->Count > 0) {
                $sub_cat = $this->getCategoryChild($row->id);
                $row->sub_cat = $sub_cat;
            } elseif ($row->Count == 0) {
                
            }
            $return_array[] = $row;
        }
        return $return_array;
    }
    
	public function getMyOrders(){
        $user_id = $this->session->userdata('user_id');
        $q = $this->db->query("Select sale.*,user_location.*,pincode.* 
			from sale 
			left join user_location on user_location.location_id = sale.location_id
            left join pincode on pincode.pincode = user_location.pincode
			where sale.user_id = '".$user_id."'  ORDER BY sale_id DESC");
        return $q->result();
    }
    public function getMyRewards(){
        $user_id = $this->session->userdata('user_id');
        $q = $this->db->query("Select SUM(point) as total from tbl_user_rewards where user_id = '".$user_id."' and status = 1 ORDER BY id DESC");
		$res = $q->row_array();
		if(!empty($res['total'])){
			return $res['total'];
		}
        return false;
    }
    public function getUserRewardHistory(){
        $user_id = $this->session->userdata('user_id');
        $q = $this->db->query("Select * from tbl_rewards_history where user_id = '".$user_id."' ORDER BY id DESC");
		return $q->result();
    }
    public function getMyOrder($order_id){
        $user_id = $this->session->userdata('user_id');
        $q = $this->db->query("Select * from sale where user_id = '".$user_id."' "
                . "and status != 3 and sale_id = $order_id ORDER BY sale_id DESC");
        return $q->result_array();
    }

   function get_sale_order_by_id($order_id){
          $sql = "Select distinct sale.*, sale.user_id as customerid, wallet_history.*,registers.user_fullname,registers.user_phone,registers.user_email,registers.pincode,registers.socity_id,registers.house_no, pincode.free_delivery_amount, user_location.socity_id, user_location.pincode, user_location.house_no, user_location.receiver_name, user_location.receiver_mobile from sale 
            inner join registers on registers.user_id = sale.user_id
            left outer join user_location on user_location.location_id = sale.location_id
            left outer join pincode on pincode.pincode = user_location.pincode
            LEFT JOIN wallet_history ON wallet_history.user_id = sale.user_id AND  DATE_FORMAT(wallet_history.created_date, '%d-%m-%Y %H:%i') =  DATE_FORMAT(sale.created_at, '%d-%m-%Y %H:%i')
            where sale_id = ".$order_id." limit 1";
            $q = $this->db->query($sql);
            return $q->result_array();
      } 
      function get_sale_order_items($sale_id){
          //old query
//        $q = $this->db->query("Select si.*,p.*,si.price as item_price, si.price as price, s.total_amount, categories.title  AS category_name, tbl_brand.title AS brand_name from sale_items si 
//        inner join products p on p.product_id = si.product_id 
//        LEFT JOIN categories ON categories.id=p.category_id AND categories.status = 1
//        LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
//        
//        inner join sale s on s.sale_id = si.sale_id where si.sale_id = '".$sale_id."'");
          
          $q = $this->db->query("Select si.*,p.*, pv.*, si.price as item_price, si.price as price, s.total_amount, categories.title  AS category_name, si.qty as qtys from sale_items si 
        inner join products p on p.product_id = si.product_id 
        inner join product_varient pv on pv.varient_id = si.pro_var_id 
        LEFT JOIN categories ON categories.id=p.category_id AND categories.status = 1
        LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1 
        inner join sale s on s.sale_id = si.sale_id where si.sale_id = '".$sale_id."'");
       
          
          /* $data['data'][]= $q->result();
        $q = $this->db->query("Select si.*,hp.* from sale_items si 
        inner join header_products hp on hp.product_id = si.product_id 
        where sale_id = '".$sale_id."'");
        $data['data'][] = $q->result();
        /*if(empty($data)){
         $q = $this->db->query("Select si.*,hp.* from sale_items si 
        inner join header_products hp on hp.product_id = si.product_id 
        where sale_id = '".$sale_id."'");
        }*/

    //int_r($data);exit();*/
            return $q->result_array();
      }
      
      
    function getCategoryWiseProduct(){
        
        $category_list      =   $this->db->query("SELECT id, title,parent FROM categories WHERE homepage ='1'")->result();
        $productArr         =   array();
        foreach($category_list as $row){
           
            $category_id        =   $row->id;
            $category_title     =   $row->title;
            $category_parent    =   $row->parent;
            // Where condition for product
            $where              =   '';
            $limit              =   10;
            if(!empty($category_parent)){
                $where          =   " AND products.category_id ='".$category_id."'";
            }
            else{
                $categoryStr          =   $category_id;
                $categories_list      =   $this->db->query("SELECT id, title,parent FROM categories WHERE parent ='".$category_id."'")->result();
                foreach($categories_list as $rows){
                    if(empty($categoryStr)){
                        $categoryStr     =   $rows->id;
                    }
                    else{
                        $categoryStr     =   $categoryStr.','.$rows->id;
                    }
                }
                $where          =   " AND products.category_id IN (".$categoryStr.")";
            }
            
            
            $product_List       =   $this->db->query("SELECT dp.*,products.*, products.mrp - products.price AS difference_price, 
                                                            ( IFNULL (producation.p_qty,0) - IFNULL(consuption.c_qty,0)) AS stock , categories.title, tbl_brand.title  AS brand_name
                                                            FROM products 
                                                            INNER JOIN categories ON categories.id = products.category_id 
                                                            LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                                                            LEFT JOIN (SELECT SUM(qty) AS c_qty,product_id FROM sale_items GROUP BY product_id) AS consuption ON consuption.product_id = products.product_id 
                                                            LEFT OUTER JOIN(SELECT SUM(qty) AS p_qty,product_id FROM purchase GROUP BY product_id) AS producation ON producation.product_id = products.product_id 
                                                            LEFT JOIN deal_product dp ON dp.product_id=products.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                                                            AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
                                                            WHERE 1 AND  products.trash = 0 ".$where.' LIMIT 10')->result_array();
                
           // print_r($this->db->last_query()); exit;    
            $productArr[]   = array(
                                        'category_id'       =>  $category_id,
                                        'category_title'    =>  $category_title,
                                        'product'           =>  $product_List
                                    );    
        }
        
        return $productArr;
    }  
      
}
=======
<?php

Class ProductTbl_Model extends CI_Model {

    var $tbl_name = 'products';

    public function __construct() {
        parent::__construct();
    }

}

class Products_model extends ProductTbl_Model {

    public function __construct() {
        parent::__construct();
    }
    
    function getProduct($product_id){
        $row = $this -> db
            //-> select('id')
            -> where('product_id', $product_id)
            ->where('trash',0)
            -> limit(1)
            -> get('products')
            -> row_array();
        return $row;
    }
    
     function getProductByVarient($product_id, $product_varient_id){
        
        $row = $this->db->query("SELECT products.*, product_varient.*,deal_product.deal_price  FROM `products` 
                                INNER JOIN product_varient On product_varient.product_id = products.product_id
                                LEFT JOIN deal_product ON deal_product.product_id = products.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()
                                WHERE product_varient.product_id = '".$product_id."' AND 
                                product_varient.varient_id='".$product_varient_id."' AND products.trash=0 ")->row_array();
        return $row;
    }

    function get_products($in_stock = false, $cat_id = "", $search = "", $page = "", $slug='', $brand="", $type='') {
		
        $filter = "";
        $limit = "";
        $page_limit = 10;
        if ($page != "") {
            $limit .= " limit " . (($page - 1) * $page_limit) . "," . $page_limit . " ";
        }
        if ($in_stock) {
            $filter .= " and products.in_stock = 1 ";
        }
        if ($cat_id != "") {
            $filter .= " and products.category_id IN (" . $cat_id . ") ";
        }
        if ($search != "") {
            $filter .= " and (products.product_name like '%". rtrim($search)."%' OR categories.title like '%". rtrim($search)."%' OR tbl_brand.title like '%". rtrim($search)."%'  )";
        }
        if(!empty($brand)){
            if($type == 'category'){
                $filter .= " and categories.slug = '".$brand."'";
            }
            elseif($type == 'brand'){
                $filter .= " and tbl_brand.slug = '".$brand."'";
            }elseif($type == 'product'){
                $filter .= " and products.product_slug = '".$brand."'";
            }
            else{
                $filter .= " and tbl_brand.slug = '".$brand."'";
            }
            
        }
        if ($slug != "") {
            $filter .= " and ( products.product_slug LIKE '%".$slug."%' OR products.product_name LIKE '%".$slug."%')";
        }
        $sql = "Select dp.*,products.*, products.mrp - products.price as difference_price, 
                ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title, categories.slug, tbl_brand.title as brand_name from products 
                inner join categories on categories.id = products.category_id
                left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                left join deal_product dp on dp.product_id=products.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
                LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                where 1 AND products.trash = 0 " . $filter . " ORDER BY products.product_id DESC " . $limit;
           //echo $sql; exit;     
        $q = $this->db->query($sql);
        $products = $q->result_array();
        
        return $products;
    }
    
    
    function get_products_by_filter($in_stock = false, $cat_id = "", $search = "", $page = "", $brand_ids1="", $review="", $filter_price="", $min="", $max="", $filter_order_by="", $category_ids1="", $cat_type_ids1="") {
		//echo $page;
           //echo $category_ids1;   
        
        //die();
        $filter = "";
        $limit = "";
        $filter_order ="";
        $page_limit = 9;
        if ($page != "") {
            $limit .= " limit " . (($page - 1) * $page_limit) . "," . $page_limit . " ";
        }
        if ($in_stock) {
            $filter .= " and products.in_stock = 1 ";
        }

        
        if ($brand_ids1 != "") {
            $filter .= " and products.brand_id IN (" . $brand_ids1 . ") ";
        }
        
        if ($category_ids1 != "") {
            $filter .= " and products.category_id IN (" . $category_ids1 . ") ";
        }
        
        if ($cat_type_ids1 != "") {
            $filter .= " and products.product_cat_type_id IN (" . $cat_type_ids1 . ") ";
        }
        
        if ($review != "") {
            $filter .= " and rtt.rate IN (" . $review . ") ";
        }
        
        if ($filter_price != "") {
            $filter .= " and pv.price>='".$min."' and pv.price<='".$max."'";
        }
        
        if ($filter_order_by != "") {
            if($filter_order_by=="name1")
            {
                $filter_order .= " ORDER BY products.product_name asc";
            }
            elseif($filter_order_by=="name2")
            {
                $filter_order .= " ORDER BY products.product_name desc";
            }
            elseif($filter_order_by=="price1")
            {
                $filter_order .= " ORDER BY pv.price asc";
            }
            elseif($filter_order_by=="price2")
            {
                $filter_order .= " ORDER BY pv.price desc";
            }
            
        }
        
        
       $sql = "Select dp.*, rtt.rate as avg_rating, pv.*, products.*, products.mrp - products.price as difference_price, 
                ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title, categories.slug, tbl_brand.title as brand_name from products 
                left join categories on categories.id = products.category_id
                left join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                left join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                left join deal_product dp on dp.product_id=products.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
                LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                LEFT JOIN (select avg(rt.rating) as rate, rt.product_id from rating_table rt where rt.review_trash=0 and rt.review_status=0 group by rt.product_id) rtt on rtt.product_id = products.product_id 
                LEFT JOIN product_varient pv on pv.product_id = products.product_id AND pv.trash=0
                where 1 AND products.trash = 0 " . $filter . " group by products.product_id  ".$filter_order. " ". $limit;
           //echo $sql; exit;     
        $q = $this->db->query($sql);
        $products = $q->result_array();
        //$total = count($products);
        //print_r($products);
        
        return $products;
    }
    
    function get_products_details_by_filter($in_stock = false, $cat_id = "", $search = "", $page = "", $brand_ids1="", $review="", $filter_price="", $min="", $max="", $filter_order_by="", $category_ids1="", $cat_type_ids1="") {
		//echo $page;
        
        //die();
        $filter = "";
        $limit = "";
        $filter_order ="";
        $page_limit = 9;
        if ($page != "") {
            $limit .= " limit " . (($page - 1) * $page_limit) . "," . $page_limit . " ";
        }
        if ($in_stock) {
            $filter .= " and products.in_stock = 1 ";
        }

        
        if ($brand_ids1 != "") {
            $filter .= " and products.brand_id IN (" . $brand_ids1 . ") ";
        }
        
        if ($category_ids1 != "") {
            $filter .= " and products.category_id IN (" . $category_ids1 . ") ";
        }
        
        if ($cat_type_ids1 != "") {
            $filter .= " and products.product_cat_type_id IN (" . $cat_type_ids1 . ") ";
        }
        
        if ($review != "") {
            $filter .= " and rtt.rate IN (" . $review . ") ";
        }
        
        if ($filter_price != "") {
            $filter .= " and pv.price>='".$min."' and pv.price<='".$max."'";
        }
        
        if ($filter_order_by != "") {
            if($filter_order_by=="name1")
            {
                $filter_order .= " ORDER BY products.product_name asc";
            }
            elseif($filter_order_by=="name2")
            {
                $filter_order .= " ORDER BY products.product_name desc";
            }
            elseif($filter_order_by=="price1")
            {
                $filter_order .= " ORDER BY pv.price asc";
            }
            elseif($filter_order_by=="price2")
            {
                $filter_order .= " ORDER BY pv.price desc";
            }
            
        }
        
        
        $sql = "Select dp.*, rtt.rate as avg_rating, pv.*, products.*, products.mrp - products.price as difference_price, 
                ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title, categories.slug, tbl_brand.title as brand_name from products 
                inner join categories on categories.id = products.category_id
                left join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                left join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                left join deal_product dp on dp.product_id=products.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
                LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                LEFT JOIN (select avg(rt.rating) as rate, rt.product_id from rating_table rt where rt.review_trash=0 and rt.review_status=0 group by rt.product_id) rtt on rtt.product_id = products.product_id 
                LEFT JOIN product_varient pv on pv.product_id = products.product_id AND pv.trash=0
                where 1 AND products.trash = 0 " . $filter . " group by products.product_id  ".$filter_order. " ". $limit;
           //echo $sql; exit;     
        $q = $this->db->query($sql);
        $products = $q->result_array();
        //$total = count($products);
        //print_r($products);
        
        return $products;
    }
    
    function getRecentAddProduct(){
        if (empty($limit)) {
            $limit = 15;
        }
        $sql = "SELECT  
                    p.*, dp.start_date, dp.start_time, dp.end_time, dp.deal_price, c.title,
                    p.mrp - p.price AS difference_price, tbl_brand.title as brand_name
                FROM
                    products p
                        INNER JOIN categories c ON c.id = p.category_id
                        LEFT JOIN deal_product dp ON dp.product_id = p.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
                        LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                    WHERE p.trash = 0
                    GROUP BY p.product_id
                    ORDER BY product_id DESC
                    LIMIT $limit";

                    //echo $sql;die;
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getTopSellingProducts($limit = NULL) {
        if (empty($limit)) {
            $limit = 16;
        }
        $sql = "SELECT  
                    p.*, dp.start_date, dp.start_time, dp.end_time, dp.deal_price, c.title,
                    p.mrp - p.price AS difference_price,
                    COUNT(si.product_id) AS top,
                    si.product_id ,tbl_brand.title as brand_name
                FROM
                    products p
                        INNER JOIN sale_items si ON p.product_id = si.product_id
                        LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                        INNER JOIN categories c ON c.id = p.category_id
                        LEFT JOIN deal_product dp ON dp.product_id = si.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
                    WHERE p.trash = 0
                    GROUP BY si.product_id
                    ORDER BY top DESC
                    LIMIT $limit";

                    //echo $sql;die;
        $query = $this->db->query($sql)->result_array();

        return $query;
        
    }

    public function getDealProducts($limit = NULL) {
        if (empty($limit)) {
            $limit = 16;
        }
	
        $sql = "SELECT 
                    deal_product.*, products.*, categories.title, tbl_brand.title as brand_name
                FROM
                    deal_product
                        INNER JOIN products ON deal_product.product_id = products.product_id
                        LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                        INNER JOIN product_varient ON product_varient.varient_id = deal_product.pro_var_id
                        INNER JOIN categories ON categories.id = products.category_id
                    WHERE CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()
                    LIMIT $limit";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getFeatureBanner($limit = 5) {
        $sql = "Select * from feature_slider LIMIT $limit";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getBanner($limit = 10) {
        $sql = "Select * from banner LIMIT $limit";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getCategorys($parent) {
        $where = "WHERE 1";
        if (!empty($parent)) {
            $where .= " AND a.`parent`=" . $parent;
        }
        $sql = "SELECT 
                    a.*, IFNULL(Deriv1.Count, 0) AS Count, IFNULL(Total1.PCount, 0) AS PCount
                FROM
                `categories` a
                    LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent`
                    LEFT OUTER JOIN (SELECT `category_id`, COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id`
                    $where ";

        $query = $this->db->query($sql);
        return $query->result_array();
//        $categories = $this->getCategoriesShort(0, 0);
//        return $categories;
    }

    /*
      public function getCategoriesShort($parent, $level) {
      if (empty($level)) {
      $level = 0;
      }
      $result_array = $this->getCategorys($parent);
      $return_array = array();

      foreach ( $result_array as $row) {
      if ($row['Count']>0) {
      $sub_cat = $this->getCategoriesShort($row['id'], $level + 1);
      if(!empty($sub_cat)){
      $row['sub_cat'] = $sub_cat;
      }
      }
      $return_array[] = $row;
      }
      return $return_array;
      }
     */
     
     public function get_brand($start='', $limit= '') {
        return $this -> db
                ->where('trash',0)
                ->where('status',1)
                ->limit($limit, $start)
                -> order_by('title')
                -> get('tbl_brand')
                -> result();
    }
    
    public function get_menu($limit='', $start='') {
        return $this -> db
                ->where('trash',0)
                ->where('status',1)
                ->limit($limit, $start)
                -> get('tbl_brand')
                -> result();
    }

    public function get_categories() {
        $parent = 0;
        if ($this->input->post("parent")) {
            $parent = $this->input->post("parent");
        }
        $categories = $this->get_categories_short($parent, 0, $this);
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
    }

    public function getCategoriesShort($parent, $level, $th, $cat_type_id='') {
		$filter = "";
        if(!empty($cat_type_id)){
			$filter = "and a.`product_cat_type_id`=$cat_type_id";
		}
		
        $sql = "SELECT 
                    a.*,
                    IFNULL(Deriv1.Count, 0) AS Count,
                    IFNULL(Total1.PCount, 0) AS PCount
                FROM
                    `categories` a
                        LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent`
                        LEFT OUTER JOIN (SELECT  `category_id`, COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id`
                WHERE
                   a.status = 1 and a.`parent`=$parent $filter";
        $q = $th->db->query($sql);
        $return_array = array();
        foreach ($q->result() as $row) {
            if ($row->Count > 0) {
                $sub_cat = $this->getCategoriesShort($row->id, $level + 1, $th, $cat_type_id);
                $row->sub_cat = $sub_cat;
            } elseif ($row->Count == 0) {
                
            }
            $return_array[] = $row;
        }
        return $return_array;
    }
    
    public function getCategoryChild($ids) {
		// $sql = "select id from categories where parent in('".$ids."')";
                // $query = $this->db->query($sql);
        $sql = "SELECT 
                    a.id,
                    IFNULL(Deriv1.Count, 0) AS Count
                FROM
                    `categories` a
					LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent`
                WHERE
					a.status = 1 and a.`parent` in('".$ids."')";
					
        $q = $this->db->query($sql);
        $return_array = array();
        foreach ($q->result() as $row) {
            if ($row->Count > 0) {
                $sub_cat = $this->getCategoryChild($row->id);
                $row->sub_cat = $sub_cat;
            } elseif ($row->Count == 0) {
                
            }
            $return_array[] = $row;
        }
        return $return_array;
    }
    
	public function getMyOrders(){
        $user_id = $this->session->userdata('user_id');
        $q = $this->db->query("Select sale.*,user_location.*,pincode.* 
			from sale 
			left join user_location on user_location.location_id = sale.location_id
            left join pincode on pincode.pincode = user_location.pincode
			where sale.user_id = '".$user_id."'  ORDER BY sale_id DESC");
        return $q->result();
    }
    public function getMyRewards(){
        $user_id = $this->session->userdata('user_id');
        $q = $this->db->query("Select SUM(point) as total from tbl_user_rewards where user_id = '".$user_id."' and status = 1 ORDER BY id DESC");
		$res = $q->row_array();
		if(!empty($res['total'])){
			return $res['total'];
		}
        return false;
    }
    public function getUserRewardHistory(){
        $user_id = $this->session->userdata('user_id');
        $q = $this->db->query("Select * from tbl_rewards_history where user_id = '".$user_id."' ORDER BY id DESC");
		return $q->result();
    }
    public function getMyOrder($order_id){
        $user_id = $this->session->userdata('user_id');
        $q = $this->db->query("Select * from sale where user_id = '".$user_id."' "
                . "and status != 3 and sale_id = $order_id ORDER BY sale_id DESC");
        return $q->result_array();
    }

   function get_sale_order_by_id($order_id){
          $sql = "Select distinct sale.*, sale.user_id as customerid, wallet_history.*,registers.user_fullname,registers.user_phone,registers.user_email,registers.pincode,registers.socity_id,registers.house_no, pincode.free_delivery_amount, user_location.socity_id, user_location.pincode, user_location.house_no, user_location.receiver_name, user_location.receiver_mobile from sale 
            inner join registers on registers.user_id = sale.user_id
            left outer join user_location on user_location.location_id = sale.location_id
            left outer join pincode on pincode.pincode = user_location.pincode
            LEFT JOIN wallet_history ON wallet_history.user_id = sale.user_id AND  DATE_FORMAT(wallet_history.created_date, '%d-%m-%Y %H:%i') =  DATE_FORMAT(sale.created_at, '%d-%m-%Y %H:%i')
            where sale_id = ".$order_id." limit 1";
            $q = $this->db->query($sql);
            return $q->result_array();
      } 
      function get_sale_order_items($sale_id){
          //old query
//        $q = $this->db->query("Select si.*,p.*,si.price as item_price, si.price as price, s.total_amount, categories.title  AS category_name, tbl_brand.title AS brand_name from sale_items si 
//        inner join products p on p.product_id = si.product_id 
//        LEFT JOIN categories ON categories.id=p.category_id AND categories.status = 1
//        LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
//        
//        inner join sale s on s.sale_id = si.sale_id where si.sale_id = '".$sale_id."'");
          
          $q = $this->db->query("Select si.*,p.*, pv.*, si.price as item_price, si.price as price, s.total_amount, categories.title  AS category_name, si.qty as qtys from sale_items si 
        inner join products p on p.product_id = si.product_id 
        inner join product_varient pv on pv.varient_id = si.pro_var_id 
        LEFT JOIN categories ON categories.id=p.category_id AND categories.status = 1
        LEFT JOIN tbl_brand on tbl_brand.id = p.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1 
        inner join sale s on s.sale_id = si.sale_id where si.sale_id = '".$sale_id."'");
       
          
          /* $data['data'][]= $q->result();
        $q = $this->db->query("Select si.*,hp.* from sale_items si 
        inner join header_products hp on hp.product_id = si.product_id 
        where sale_id = '".$sale_id."'");
        $data['data'][] = $q->result();
        /*if(empty($data)){
         $q = $this->db->query("Select si.*,hp.* from sale_items si 
        inner join header_products hp on hp.product_id = si.product_id 
        where sale_id = '".$sale_id."'");
        }*/

    //int_r($data);exit();*/
            return $q->result_array();
      }
      
      
    function getCategoryWiseProduct(){
        
        $category_list      =   $this->db->query("SELECT id, title,parent FROM categories WHERE homepage ='1'")->result();
        $productArr         =   array();
        foreach($category_list as $row){
           
            $category_id        =   $row->id;
            $category_title     =   $row->title;
            $category_parent    =   $row->parent;
            // Where condition for product
            $where              =   '';
            $limit              =   10;
            if(!empty($category_parent)){
                $where          =   " AND products.category_id ='".$category_id."'";
            }
            else{
                $categoryStr          =   $category_id;
                $categories_list      =   $this->db->query("SELECT id, title,parent FROM categories WHERE parent ='".$category_id."'")->result();
                foreach($categories_list as $rows){
                    if(empty($categoryStr)){
                        $categoryStr     =   $rows->id;
                    }
                    else{
                        $categoryStr     =   $categoryStr.','.$rows->id;
                    }
                }
                $where          =   " AND products.category_id IN (".$categoryStr.")";
            }
            
            
            $product_List       =   $this->db->query("SELECT dp.*,products.*, products.mrp - products.price AS difference_price, 
                                                            ( IFNULL (producation.p_qty,0) - IFNULL(consuption.c_qty,0)) AS stock , categories.title, tbl_brand.title  AS brand_name
                                                            FROM products 
                                                            INNER JOIN categories ON categories.id = products.category_id 
                                                            LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1
                                                            LEFT JOIN (SELECT SUM(qty) AS c_qty,product_id FROM sale_items GROUP BY product_id) AS consuption ON consuption.product_id = products.product_id 
                                                            LEFT OUTER JOIN(SELECT SUM(qty) AS p_qty,product_id FROM purchase GROUP BY product_id) AS producation ON producation.product_id = products.product_id 
                                                            LEFT JOIN deal_product dp ON dp.product_id=products.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                                                            AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
                                                            WHERE 1 AND  products.trash = 0 ".$where.' LIMIT 10')->result_array();
                
           // print_r($this->db->last_query()); exit;    
            $productArr[]   = array(
                                        'category_id'       =>  $category_id,
                                        'category_title'    =>  $category_title,
                                        'product'           =>  $product_List
                                    );    
        }
        
        return $productArr;
    }  
      
}
>>>>>>> main
