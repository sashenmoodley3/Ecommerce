<?php
class Product_model extends CI_Model{
    
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

		$this->db->query('update  tbl_sequence  set sequence_number = "'.$this->pre_zero($code_uni, 4).'"  WHERE sequence_code = "'.$code.'" ');
		//echo $uni_idd; exit;
		return $uni_idd;
	}
	function pre_zero($num, $dig)
	{
		$num_padded = sprintf("%0" . $dig . "d", $num);
		return $num_padded;
	}
	function getProductVarient($product_id){
	    $sql        =   $this->db->query("SELECT product_varient.*, deal_product.deal_price, deal_product.start_date, deal_product.start_time, deal_product.end_date, deal_product.end_time FROM  product_varient 
	    LEFT JOIN deal_product ON deal_product.pro_var_id = product_varient.varient_id AND  deal_product.product_id = product_varient.product_id 
	    WHERE product_varient.product_id ='".$product_id."'");
	    $products   =   $sql->result();
	    return ($products);
	}
	
      function get_products($in_stock=false,$cat_id="",$search="", $page = ""){
            
            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($cat_id!=""){
                $filter .=" and products.category_id = '".$cat_id."' ";
            }
             if($search!=""){
                $filter .=" and products.product_name like '%".$search."%' ";
            }
            $sql = "Select dp.*,products.*,product_varient.varient_id, product_varient.price as var_price, product_varient.qty, product_varient.unit,
            product_varient.stock_inv, product_varient.tax, product_varient.mrp as var_mrp,product_varient.pro_var_images, (products.mrp - products.price) as difference_price, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
            inner join categories on categories.id = products.category_id 
            left  join(select SUM(qty) as c_qty,product_id from sale_items 
            INNER JOIN sale on sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id left join deal_product dp on dp.product_id=products.product_id 
            LEFT JOIN product_varient ON product_varient.varient_id =  dp.pro_var_id  AND product_varient.product_id = products.product_id
            where 1 AND products.trash = 0 ".$filter." ".$limit;
            //var_dump($sql);  AND products.trash = 0
            $q = $this->db
                    //->where('products.trash',0)
                    ->query($sql);
            $products =$q->result();
            //inner join product_price on product_price.product_id = products.product_id
            
            
            
            /*$prices = $this->get_product_price($in_stock);
            
            $products_output = array();
            foreach($products as $product){
                $price_array = array();
                foreach($prices as $price){
                    
                    if($price->product_id == $product->product_id){
                            $price_array[] = $price;        
                    }
                }
                $product->prices = $price_array;
                $products_output[] = $product;        
            }
            */
            return $products; 
      }
      
      function get_header_products($in_stock=false,$cat_id="",$search="", $page = ""){
            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
            if($in_stock){
                $filter .=" and header_products.in_stock = 1 ";
            }
            if($cat_id!=""){
                $filter .=" and header_products.category_id = '".$cat_id."' ";
            }
             if($search!=""){
                $filter .=" and header_products.product_name like '".$search."' ";
            }
            $q = $this->db->query("Select header_products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,header_categories.title from header_products 
            inner join header_categories on header_categories.id = header_products.category_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = header_products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = header_products.product_id
            where 1 ".$filter." ".$limit);
            $products = $q->result();
            //inner join product_price on product_price.product_id = products.product_id
            
            
            
            /*$prices = $this->get_product_price($in_stock);
            
            $products_output = array();
            foreach($products as $product){
                $price_array = array();
                foreach($prices as $price){
                    
                    if($price->product_id == $product->product_id){
                            $price_array[] = $price;        
                    }
                }
                $product->prices = $price_array;
                $products_output[] = $product;        
            }
            */
            return $products; 
      }
      
      function get_products_suggestion($in_stock=false,$cat_id="",$search="", $page = "", $barnd_id='', $product_id=''){
            //$name  = $_REQUEST['product_name'];
            $filter = "";
            $limit = "GROUP BY products.product_id";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($cat_id!=""){
                $filter .=" and products.category_id = '".$cat_id."' ";
            }
            if($barnd_id!=""){
                $filter .=" and products.barnd_id = '".$barnd_id."' ";
            }
            if($product_id!=""){
                $filter .=" and products.product_id = '".$product_id."' ";
            }
            if($search!=""){
                $filter .= " and ( products.product_name like '%". rtrim($search)."%' OR categories.title like '%". rtrim($search)."%' OR tbl_brand.title like '%". rtrim($search)."%')";
            }
            
           
$q = $this->db->query("Select dp.deal_price,dp.start_date,dp.start_time,dp.end_date,dp.end_time,products.*, product_varient.varient_id, product_varient.price as var_price, product_varient.qty, product_varient.unit,
            product_varient.stock_inv, product_varient.tax, product_varient.mrp as var_mrp,product_varient.pro_var_images,(products.mrp - products.price) as difference_price, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title , tbl_brand.title as brand_name,
            count(rating_table.product_id) as review_count, IFNULL(AVG(rating_table.rating),0) as ratings_average
            FROM products 
            INNER JOIN categories on categories.id = products.category_id 
            LEFT JOIN(select SUM(qty) as c_qty,product_id from sale_items 
            INNER JOIN sale on sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = products.product_id 
            LEFT JOIN(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id 
            LEFT JOIN deal_product dp on dp.product_id=products.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
            LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1 
            LEFT JOIN product_varient ON product_varient.product_id =  products.product_id  AND product_varient.product_id = products.product_id
			LEFT JOIN rating_table on rating_table.product_id = dp.product_id
            where 1 AND products.trash = 0 ".$filter.$limit );
          
          
          
          
          //"SELECT btl_wishlist.*, products.* FROM `btl_wishlist` LEFT JOIN  products ON products.product_id = btl_wishlist.product_id WHERE trash=0 and btl_wishlist.user_id='".$user_id."'"
            
            $products = $q->result();
            //inner join product_price on product_price.product_id = products.product_id
            
            
            
            /*$prices = $this->get_product_price($in_stock);
            
            $products_output = array();
            foreach($products as $product){
                $price_array = array();
                foreach($prices as $price){
                    
                    if($price->product_id == $product->product_id){
                            $price_array[] = $price;        
                    }
                }
                $product->prices = $price_array;
                $products_output[] = $product;        
            }
            */
            return $products; 
      }
    
        
       function get_wishlist_products($user_id){
            //$name  = $_REQUEST['product_name'];
            $filter = "";
           // $limit = "GROUP BY products.product_id";
            //$page_limit = " limit 100";
//            if($page != ""){
//                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
//            }
//            if($in_stock){
//                $filter .=" and products.in_stock = 1 ";
//            }
//            if($cat_id!=""){
//                $filter .=" and products.category_id = '".$cat_id."' ";
//            }
//            if($barnd_id!=""){
//                $filter .=" and products.barnd_id = '".$barnd_id."' ";
//            }
//            if($product_id!=""){
//                $filter .=" and products.product_id = '".$product_id."' ";
//            }
//            if($search!=""){
//                $filter .= " and ( products.product_name like '%". rtrim($search)."%' OR categories.title like '%". rtrim($search)."%' OR tbl_brand.title like '%". rtrim($search)."%')";
//            }
            
           
            $q = $this->db->query("Select dp.deal_price,dp.start_date,dp.start_time,dp.end_date,dp.end_time,products.*, product_varient.varient_id, product_varient.price as var_price, product_varient.qty, product_varient.unit,
            product_varient.stock_inv, product_varient.tax, product_varient.mrp as var_mrp,product_varient.pro_var_images,(products.mrp - products.price) as difference_price, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title , tbl_brand.title as brand_name
            FROM products 
            INNER JOIN categories on categories.id = products.category_id
            INNER JOIN btl_wishlist on btl_wishlist.product_id = products.product_id and btl_wishlist.user_id ='".$user_id."'
            LEFT JOIN(select SUM(qty) as c_qty,product_id from sale_items 
            INNER JOIN sale on sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = products.product_id 
            LEFT JOIN(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id 
            LEFT JOIN deal_product dp on dp.product_id=products.product_id AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.start_time)  <= NOW()
                AND CONCAT(DATE_FORMAT(STR_TO_DATE(dp.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',dp.end_time) >= NOW()
            LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1 
            LEFT JOIN product_varient ON product_varient.product_id =  products.product_id  AND product_varient.product_id = products.product_id
            where 1 AND products.trash = 0 group by products.product_id ");
           
           
            
          
         
            
            $products = $q->result();
            //inner join product_price on product_price.product_id = products.product_id
            
            
            
            /*$prices = $this->get_product_price($in_stock);
            
            $products_output = array();
            foreach($products as $product){
                $price_array = array();
                foreach($prices as $price){
                    
                    if($price->product_id == $product->product_id){
                            $price_array[] = $price;        
                    }
                }
                $product->prices = $price_array;
                $products_output[] = $product;        
            }
            */
            return $products; 
      }
    
    
      
      function get_product_by_id($prod_id){
            $q = $this->db->query("Select products.*, categories.title, tbl_brand.title as brand_name from products 
            LEFT join categories on categories.id = products.category_id
            LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1 
            where 1 and products.product_id = '".$prod_id."' limit 1");
            return $q->row();
            
      }
      
      function get_header_product_by_id($prod_id){
            $q = $this->db->query("Select header_products.*, header_categories.title from header_products 
            inner join header_categories on header_categories.id = header_products.category_id
            where 1 and header_products.product_id = '".$prod_id."' limit 1");
            return $q->row();
            
      }
      
      function get_attribute_values(){
        $q = $this->db->query("SELECT attribute_values.*, attributes.*, pc.* FROM  attribute_values
          LEFT JOIN attributes ON attributes.attribute_id = attribute_values.attribute_id LEFT JOIN product_cat_type pc ON pc.product_cat_type_id = attribute_values.attribute_values_product_cat_type_id where  attribute_values.attribute_value_deleted=0 order by attribute_values.attribute_value_id desc");
          return $q->result();
            
      }
    
    function get_purchase_list(){
        $q = $this->db->query("SELECT purchase. * , products.product_name, users.user_fullname, store_login.user_fullname FROM purchase
          LEFT JOIN products ON products.product_id = purchase.product_id
          LEFT JOIN users ON purchase.store_id_login = users.user_id
          LEFT JOIN store_login ON purchase.store_id_login = store_login.user_id");
          return $q->result();
            
      }
      function get_purchase_by_id($id){
        $q = $this->db->query("Select purchase.* from purchase 
            where 1 and purchase_id = '".$id."' limit 1");
            return $q->row();
      }
      function get_product_price($in_stock=false,$prod_id=""){
            $filter = "";
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($prod_id!=""){
                $filter .=" and products.product_id = '".$prod_id."' ";
            }
            $q = $this->db->query("Select product_price.* from product_price 
            inner join products on products.product_id = product_price.product_id 
            where 1 ".$filter);
            return $q->result();
      } 
      
     
      
      
      function get_prices_by_ids($ids){
            $q = $this->db->query("Select product_price.* from product_price 
            where 1 and price_id in (".$ids.")");
            return $q->result();
      }
      function get_price_by_id($price_id){
        $q = $this->db->query("Select * from product_price 
            where 1 and price_id = '".$price_id."'");
            return $q->row();
      }
      function get_socity_by_id($id){
        $q = $this->db->query("Select * from socity 
            where 1 and socity_id = '".$id."'");
            return $q->row();
      }
      function get_pincode_by_id($id){
        $q = $this->db->query("Select * from pincode 
            where 1 and pincode_id = '".$id."'");
            return $q->row();
      }
      function get_socities(){
        
        $q = $this->db->query("Select * from socity");
            return $q->result();
      }
      function get_pincodes(){
        
        $q = $this->db->query("Select * from pincode");
            return $q->result();
      }
      function get_enquiries(){

        $q = $this->db->query("Select * from tbl_enquiry");
            return $q->result();
      }
    
      function get_product_reviews(){

        $q = $this->db->query("Select rating_table.*, products.*, registers.* from rating_table
        left join registers ON rating_table.user_id=registers.user_id
        left join products ON rating_table.product_id=products.product_id where rating_table.review_trash='0'
        ");
        return $q->result();
          //die();
      }
        
      function rewards_value(){
        
        $q = $this->db->query("Select point from rewards where id=1");
            return $q->result();
      }
      
      function update_reward($data){
         
        $this->db->where('id', 1);
        $this->db->update('rewards', $data);
        
      }
      
      function coupon($data)
      {
          
          $this->db->insert('tbl_coupons',$data);
          return true;
      }
      
      function coupon_list()
      {
          $query = $this->db->get('tbl_coupons');
          return $query->result();
      }

      function editCoupon($id,$data)
      {
        $this->db->where('coupon_id', $id);
        $this->db->update('tbl_coupons', $data);
        return true;
      }

      function deleteCoupon($id)
      {
         $this->db->where('coupon_id', $id);
        $this->db->delete('tbl_coupons');
        return true;
      }

      function getCoupon($id)
      {
        $this->db->select('*');
        $this->db->from('tbl_coupons');
        $this->db->where('coupon_id',$id);
        $query = $this->db->get();
        return $query->row_array(); 

      }

      function lookup($keyword){ 
          $sql ="SELECT distinct(products.product_id),deal_product.product_name AS deal_product_name,products.*, product_varient.* , tbl_brand.title as brand_name
                FROM products
                left join deal_product ON deal_product.product_name = products.product_name
                LEFT JOIN product_varient ON product_varient.product_id = products.product_id
                INNER JOIN categories ON categories.id=products.category_id
                LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1 
                WHERE products.trash=0 AND products.in_stock=1 AND products.product_name like '%".$keyword."%'";
            
        $q = $this->db->query($sql);
        $products =$q->result();
        //print_r($products); exit;
        return $products;
          /*
            $this->db->select('*')->from('products'); 
            $this->db->like('product_name',$keyword,'after'); 

            //$this->db->or_like('iso',$keyword,'after'); 
            $query = $this->db->get();     
            return $query->result(); 
           * 
           */
      } 
      
       function looku($keyword){ 
        $this->db->select('*')->from('categories'); 

        $this->db->like('title',$keyword,'after');
        $this->db->where('parent',0) ;
        //$this->db->or_like('iso',$keyword,'after'); 
        $query = $this->db->get();     
        return $query->result(); 
      } 

       function look($keyword){ 
        $this->db->select('*')->from('categories'); 
        $this->db->like('title',$keyword,'after');
        $this->db->where('parent>',0) ; 
        //$this->db->or_like('iso',$keyword,'after'); 
        $query = $this->db->get();     
        return $query->result(); 
      } 

      function get_sale_by_user($user_id){
            $q = $this->db->query("Select * from sale where user_id = '".$user_id."'  ORDER BY sale_id DESC");
            return $q->result();
      }
      function get_sale_by_user2($user_id){
            $q = $this->db->query("Select * from sale where user_id = '".$user_id."' and status = 4 ORDER BY sale_id DESC");
            return $q->result();
      }
    
        function get_sale_by_user_id($user_id,$order_id){
            $q = $this->db->query("Select * from sale where user_id = '".$user_id."' and sale_id = '".$order_id."' ORDER BY sale_id DESC");
            return $q->row();
        }
    
      function get_sale_orders_list($filter=""){

          $sql = "SELECT `sale`.*, `sale`.`created_at` as `order_create_date`, `registers`.*, `sale`.`status` as `orderStatus`, refund_request.status as refund_status, `user_location`.*, `pincode`.*
            FROM `sale`
            left join refund_request on refund_request.order_id = sale.sale_id
            LEFT JOIN `registers` ON `registers`.`user_id`=`sale`.`user_id`
            LEFT JOIN `user_location` ON `user_location`.`location_id` = `sale`.`location_id`
            LEFT JOIN `pincode` ON `user_location`.`pincode` = `pincode`.`pincode`
            ORDER BY `sale`.`sale_id` DESC
             LIMIT 100";
          
//         echo $sql;die;
            $q = $this->db->query($sql);
            return $q->result();
      } 
	  
      function get_reward_history($filter=""){
         $sql = "Select distinct tbl_rewards_history.*,registers.user_fullname, registers.user_phone,registers.pincode,
         registers.socity_id,registers.house_no
           from tbl_rewards_history 
            inner join registers on registers.user_id = tbl_rewards_history.user_id
            where 1 ".$filter." ORDER BY tbl_rewards_history.id DESC";
//         echo $sql;die;
            $q = $this->db->query($sql);
            return $q->result();
      } 
	  
      function get_rewards($filter=""){
         $sql = "Select distinct tbl_user_rewards.*,registers.user_fullname, registers.user_phone,registers.pincode,
         registers.socity_id,registers.house_no
           from tbl_user_rewards 
            inner join registers on registers.user_id = tbl_user_rewards.user_id
            where 1 ".$filter." ORDER BY tbl_user_rewards.id DESC";
//         echo $sql;die;
            $q = $this->db->query($sql);
            return $q->result();
      } 
	  
	  
	  
	  function get_sale_orders_list2($filter=""){
         $sql = "Select r.user_fullname,pr.product_name, ps.* from tbl_product_schedule ps left join  registers r on r.user_id = ps.schedule_user_id
		 left join  products pr on pr.product_id = ps.schedule_product_id  ";
            //echo $sql;die;
            $q = $this->db->query($sql);
			//print_r( $q->result()); die;
            return $q->result();
      } 
    
    function get_sale_orders_list_by_filter($datetype, $dateto, $fromdate, $paymentmethod, $customername, $deliverboyname, $orderstatus){
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
            }
        
            if($deliverboyname!=""){
                $filter .=" and delivery_boy.user_name like '%".$deliverboyname."%'";
            }
        
            if($orderstatus!=""){
                
                if($orderstatus=="returnedorder"){
                    $filter .=" and refund_request.status = '3'";
                
                }
                elseif($orderstatus=="-1"){
                    $filter .=" and refund_request.status = '0'";
                
                }
                else{
                    $filter .=" and sale.status = '".$orderstatus."'";
                }
                
            }
        
         $sql = "Select distinct sale.*,registers.user_fullname, registers.user_phone, registers.user_email, registers.pincode, registers.house_no, `sale`.`status` as `orderStatus`, `sale`.`created_at` as `order_create_date`, sale.new_store_id , pincode.free_delivery_amount, refund_request.status as refund_status, 
         user_location.pincode, user_location.house_no, user_location.receiver_name, user_location.receiver_mobile  from sale 
            left join registers on registers.user_id = sale.user_id
            left join refund_request on refund_request.order_id = sale.sale_id
            left join delivery_boy on delivery_boy.id = sale.delivery_boy_id
            left outer join user_location on user_location.location_id = sale.location_id
            left outer join pincode on pincode.pincode = user_location.pincode
            left outer join users on users.user_id = user_location.store_id
            where 1 ".$filter." ORDER BY sale_id DESC";
            //echo $sql;die;
            $q = $this->db->query($sql);
//			//print_r( $q->result()); die;
            return $q->result();
      } 
	  
	  
      function get_sale_orders($filter=""){
         $sql = "Select distinct sale.*,registers.user_fullname, registers.user_phone,registers.pincode,
         registers.house_no, sale.new_store_id , pincode.free_delivery_amount, 
         user_location.pincode, user_location.house_no, user_location.receiver_name, user_location.receiver_mobile  from sale 
            inner join registers on registers.user_id = sale.user_id
            left outer join user_location on user_location.location_id = sale.location_id
            left outer join pincode on pincode.pincode = user_location.pincode
            left outer join users on users.user_id = user_location.store_id
            where 1 ".$filter." ORDER BY sale_id DESC";
            //         echo $sql;die;
            $q = $this->db->query($sql);
            return $q->result();
      } 
      
      function get_sale_order_by_id($order_id){
          $sql = "Select distinct sale.*, sale.user_id as customerid, wallet_history.*,registers.user_fullname,registers.user_phone,registers.user_email,registers.pincode,registers.house_no, pincode.free_delivery_amount, user_location.pincode, user_location.house_no, user_location.receiver_name, user_location.receiver_mobile 
		  from sale 
            inner join registers on registers.user_id = sale.user_id
            left outer join user_location on user_location.location_id = sale.location_id
            left outer join pincode on pincode.pincode = user_location.pincode
            LEFT JOIN wallet_history ON wallet_history.user_id = sale.user_id AND  DATE_FORMAT(wallet_history.created_date, '%d-%m-%Y %H:%i') =  DATE_FORMAT(sale.created_at, '%d-%m-%Y %H:%i')
            where sale_id = ".$order_id." limit 1";
            $q = $this->db->query($sql);
            return $q->row();
      } 
      function get_sale_order_items($sale_id){
        $q = $this->db->query("Select si.*,p.*, pv.*, si.price as item_price, si.price as price, s.total_amount, si.qty*si.price as sub_total, categories.title  AS category_name, si.qty as qtys 
		from sale_items si 
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
            return $q->result();
      }
      
    //   function get_leftstock(){
          
    //     $q = $this->db->query("Select products.*,categories.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock from products 
    //       inner join categories on categories.id=products.category_id
    //         left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
    //         left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id 
    //         WHERE products.trash = 0 
    //         ");
    //     return $q->result();
    //   }
      
       function get_leftstock(){
          
        $q = $this->db->query("Select products.*,categories.* from products 
                            inner join categories on categories.id=products.category_id
                            WHERE products.trash = 0 
            ");
        return $q->result();
      }
      function get_all_users(){
        $sql = "SELECT registers.*, IFNULL(sale_order.total_amount, 0) AS total_amount, 
                IFNULL(total_orders, 0) AS total_orders, 
                IFNULL(sale_order.total_rewards, 0) AS total_rewards, IFNULL(wallets_history.wallet,0) AS wallets   
                FROM registers 
                LEFT OUTER JOIN (SELECT sum(total_amount) AS total_amount, count(sale_id) AS total_orders, 
                sum(total_rewards) AS total_rewards, user_id FROM sale GROUP BY user_id) AS sale_order 
                ON sale_order.user_id = registers.user_id
                LEFT JOIN (SELECT SUM(wallet_history.cr_id)- SUM(wallet_history.dr_id) AS wallet, user_id 
                FROM wallet_history GROUP BY user_id) AS wallets_history ON wallets_history.user_id=registers.user_id
                WHERE 1 ORDER BY user_id DESC";
            $q = $this->db->query($sql);
            
            return $q->result();
      }

      function adddealproduct($data)
      {
        $this->db->insert('deal_product',$data);
        return true;
      }
    
      function update_disable_product_reviews($review_id)
      {
        $sql ='update rating_table  set review_status = "1"  WHERE review_id = "'.$review_id.'"';
          $this->db->query($sql);
        return true;
          //die();
      }
    
      function update_enable_product_reviews($review_id)
      {
          echo $sql = 'update rating_table  set review_status = "0"  WHERE review_id = "'.$review_id.'"';
        $this->db->query($sql);
        return true;
          //die();
      }
    
    function update_delete_product_reviews($review_id)
      {
          echo $sql = 'update rating_table  set review_trash = "1"  WHERE review_id = "'.$review_id.'"';
        $this->db->query($sql);
        return true;
          //die();
      }

       function getdealproducts()
      {

        $query = $this->db->get('deal_product');
        return $query->result();
      }
      
      function getdealproduct($id)
      {
          /*
          $this->db->where('id',$id);
          $query=$this->db->get('deal_product');
           * return $query->row();
           * 
           */
          $sql = "SELECT 
                    ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock,
                        deal_product.*,
                        products.*, categories.title, tbl_brand.title as brand_name
                    FROM
                        deal_product
                            INNER JOIN
                        products ON deal_product.product_name = products.product_name
                            INNER JOIN
                        categories ON categories.id = products.category_id
                        left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                            LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1 
                            WHERE 
                        deal_product.id = $id
                    LIMIT 1";
        $q = $this->db->query($sql);
          return $q->row();
      }
      
      function edit_deal_product($id,$data)
      {
          $this->db->where('id',$id);
          $this->db->update('deal_product',$data);
          return true;
      }

      
      function get_order_list()
      {
          
      }
      function delivery_boy_order($delivery_boy_id){
            $q = $this->db->query("Select sale.*,user_location.*,pincode.* from sale
            left join user_location on user_location.location_id = sale.location_id
			LEFT JOIN pincode ON pincode.pincode =  user_location.pincode
             where assign_to = '".$delivery_boy_id."' ORDER BY sale_id DESC");
            return $q->result();
      }
      
      function exportList($fromdate, $todate){
          $where    =   "WHERE 1=1";
          if(!empty($fromdate)){
             $where .= " AND sale.on_date BETWEEN '".$fromdate."' AND   '".$todate."'"; 
          }
          $q = $this->db->query("SELECT sale_items.*, sale.*, products.*, registers.*, user_location.*,pincode.*, categories.title  AS categoryName, product_varient.*
                                FROM sale_items
                                LEFT JOIN sale ON sale.sale_id = sale_items.sale_id
                                LEFT JOIN  products ON products.product_id = sale_items.product_id
                                LEFT JOIN  product_varient ON product_varient.varient_id = sale_items.pro_var_id
                                LEFT JOIN registers ON registers.user_id = sale.user_id
                                LEFT JOIN user_location ON user_location.location_id = sale.location_id
                                LEFT JOIN pincode ON pincode.pincode =  user_location.pincode
                                LEFT JOIN categories ON categories.id = products.category_id ".$where." ORDER BY sale.sale_id ASC");
            return $q->result();
      }
      
      function getTotal_amt_Tax($sale_id){
            $q          =   $this->db->query("SELECT sale_items.product_id, sale_items.qty, sale_items.price, product_varient.tax, sale.delivery_charge  FROM sale_items 
                                    LEFT JOIN products ON products.product_id = sale_items.product_id
                                    LEFT JOIN sale ON sale.sale_id = sale_items.sale_id
                                    LEFT JOIN  product_varient ON product_varient.varient_id = sale_items.pro_var_id
                                    WHERE sale_items.sale_id = '".$sale_id."'");
            $result             =   $q->result();
            $totalPrice         =   0; 
            $totalTax           =   0; 
            $totalQty           =   0;
            $totalTaxAmt        =   0;
            $diliverycharge     =   0;
            //print_r($result); exit;
            foreach($result as $data){
                //echo $data->price.' >>>>> '.$data->tax.' >>>>> '.$data->qty.' ';
                // $totalPrice     +=   (floatval($data->price)*100)/(100+floatval($data->tax))*floatval($data->qty);
                // $totalTaxAmt    +=   (floatval($data->price)*floatval($data->qty)) - (floatval($data->price)*100)/(100+floatval($data->tax))*floatval($data->qty);
                // $totalTax       +=   floatval($data->tax);
                // $totalQty       +=   floatval($data->qty);
                // $diliverycharge  =   floatval($data->delivery_charge);
                $totalPrice     +=   floatval($data->price) * floatval($data->qty);
                $totalTaxAmt    +=   ((floatval($data->tax)/100)*floatval($data->price)) * floatval($data->qty);
                $totalTax       +=   floatval($data->tax);
                $totalQty       +=   floatval($data->qty);
                $diliverycharge  =   floatval($data->delivery_charge);
                
            }
            $avragePercent      =   number_format((floatval($totalTaxAmt)*100)/floatval($totalPrice), 2);
            return  array('totalPrice' => number_format($totalPrice,2), 'totalTax' => number_format($totalTax,2), 'totalQty' => $totalQty,'totalTaxAmt' => number_format($totalTaxAmt,2),'diliverycharge' =>$diliverycharge,'avragePercent' => $avragePercent);
      }
      function get_productstock($id){
        $q = $this->db->query("Select products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock, tbl_brand.title as brand_name from products 
        inner join categories on categories.id=products.category_id
        left outer join(select SUM(qty) as c_qty,product_id from sale_items  INNER JOIN sale on sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1 
             WHERE products.trash = 0 AND products.in_stock = 1 AND products.product_id IN (".$id.") 
            ");
        return $q->result_array();
      }
      
    //   function get_leftstock(){
    //     $q = $this->db->query("Select products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock from products 
    //     inner join categories on categories.id=products.category_id
    //     left outer join(select SUM(qty) as c_qty,product_id from sale_items  INNER JOIN sale on sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = products.product_id 
    //         left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
    //          WHERE products.trash = 0 
    //         ");
    //     return $q->result();
    //   }
     function getUserCurrentOrder($userid, $date){
        $result    =   $this->db
                        ->select('*')
                        ->where('sale.user_id', $userid)
                        ->where('sale.on_date', $date)
                        ->order_by('sale_id', "desc")
                        ->limit(1)
                        ->get('sale')
                        ->row();
                        
        return $result;
     }
      
    
    public function get_wish_list($user_id){
        $q = $this->db->query("SELECT btl_wishlist.*, products.* FROM `btl_wishlist` LEFT JOIN  products ON products.product_id = btl_wishlist.product_id WHERE trash=0 and btl_wishlist.user_id='".$user_id."'");
       // $q = $this->db->query("select * from `categories` order by id DESC ");
        //print_r($q->result()); die();
        return $q->result();
    }
}
?>