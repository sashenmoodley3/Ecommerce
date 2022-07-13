<?php
class Category_model extends CI_Model{
        /* ========== Category========== */
        public function add_category()
        {
            $slug = url_title($this->input->post('cat_title'), 'dash', TRUE);
            $parentid = $this->input->post("parent");
            $product_cat_typeid = $this->input->post("product_cat_type");
           
                        
            $addcat = array(
                            "title"=>$this->input->post("cat_title"),
                            "product_cat_type_id"=>$product_cat_typeid,
                            "arb_title"=>$this->input->post("arb_cat_title"),
                            "slug"=>$slug,
                            "parent"=>$parentid, 
                            "status"=>$this->input->post("cat_status")
                            );
            
                if($_FILES["cat_img"]["size"] > 0){
                    $config['upload_path']          = './uploads/category/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $this->load->library('upload', $config);
    
                    if ( ! $this->upload->do_upload('cat_img'))
                    {
                            $error = array('error' => $this->upload->display_errors());
                    }
                    else
                    {
                        $img_data = $this->upload->data();
                        $addcat["image"]=$img_data['file_name'];
                    }
                    
               }
               
               
                if($parentid != "0"){
                    $q = $this->db->query("select * from `categories` where id=".$parentid);
                    $parent = $q->row();
                    $leval = $parent->leval + 1;
                    $addcat["leval"] = $leval;                       
                }
                
               
               $this->db->insert("categories",$addcat); 
        }
        
        

        
        public function edit_category()
        {
            $slug = url_title($this->input->post('cat_title'), 'dash', TRUE);
            $parentid = $this->input->post("parent");
            $product_cat_typeid = $this->input->post("product_cat_type");
            $checkParent =  $this->db->query("SELECT id FROM categories WHERE parent='".$this->input->post("cat_id")."'");
            
            if($checkParent->num_rows() > 0){
                $result_cat     =   $checkParent->result_array();
                foreach($result_cat as $row){
                    $cat_id     =   $row['id'];
                    $querys  =   $this->db->query("SELECT product_id FROM products WHERE category_id='".$cat_id."'");
                    if($querys->num_rows() > 0){
                       $result_pro  =   $querys->result_array();
                       foreach($result_pro as $product){
                            $product_id  =   $product['product_id'];
                            $update_array =  array(
                                                        'in_stock'   => $this->input->post("cat_status"),
                                                    );
                            $this->db->where('product_id', $product_id);
                            $this->db->update('products', $update_array);
                             //print_r($this->db->last_query());
                       }
                    }
                    $update_cat_array   =   array(
                                                    'status' => $this->input->post("cat_status")
                                                );
                    $this->db->where('id', $cat_id);
                    $this->db->update('categories', $update_cat_array);
                    //print_r($this->db->last_query()); exit;
                }
            }
            
            $editcat = array(
                            "title"=>$this->input->post("cat_title"),
                            "product_cat_type_id"=>$product_cat_typeid,
                            "arb_title"=>$this->input->post("arb_cat_title"),
                            "slug"=>$slug,
                            "parent"=>$parentid, 
                            "status"=>$this->input->post("cat_status")
                            );
            
                    if($_FILES["cat_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/category/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('cat_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $editcat["image"]=$img_data['file_name'];
                        }
                        
                   }
                   
                   
                   if($parentid != "0"){
						$q = $this->db->query("select * from `categories` where id=".$parentid);
						$parent = $q->row();
						$leval = $parent->leval + 1;
						$editcat["leval"] = $leval;                       
                    }
					else{
						$editcat["leval"] = 0;
					}
                  
                    $this->db->update("categories",$editcat,array("id"=>$this->input->post("cat_id"))); 
        }
        
        public function edit_header_category()
        {
            $slug = url_title($this->input->post('cat_title'), 'dash', TRUE);
            $parentid = $this->input->post("parent");
            $editcat = array(
                            "title"=>$this->input->post("cat_title"),
                            "slug"=>$slug,
                            "parent"=>$this->input->post("parent"), 
                            "status"=>$this->input->post("cat_status")
                            );
            
                    if($_FILES["cat_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/category/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('cat_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $editcat["image"]=$img_data['file_name'];
                        }
                        
                   }
                   if($parentid != "0"){
                    $q = $this->db->query("select * from `header_categories` where id=".$parentid);
                    $parent = $q->row();
                    $leval = $parent->leval + 1;
                    $editcat["leval"] = $leval;                       
                    }
                  
                    $this->db->update("header_categories",$editcat,array("id"=>$this->input->post("cat_id"))); 
        }
        
        public function get_categories()
        {
            $q = $this->db->query("SELECT a.*, Deriv1.prtitle, pc.title as pc_title FROM `categories` a  LEFT OUTER JOIN (SELECT `id`, `title` as `prtitle` FROM `categories`) as Deriv1 ON Deriv1.`id` = a.`parent` left join product_cat_type pc on pc.product_cat_type_id=a.product_cat_type_id" )  ;
           // $q = $this->db->query("select * from `categories` order by id DESC ");
            return $q->result();
        }
        public function get_header_categories()
        {
            $q = $this->db->query("SELECT a.*, Deriv1.prtitle FROM `header_categories` a  LEFT OUTER JOIN (SELECT `id`, `title` as `prtitle` FROM `categories`) as Deriv1 ON Deriv1.`id` = a.`parent` " );
           // $q = $this->db->query("select * from `categories` order by id DESC ");
            return $q->result();
        }
        
         public function sel_categories(){
            $q = $this->db->query("select * from `categories`  ");
            return $q->result();
        } 
             public function bus_category($id){
            $q = $this->db->query("select categories.title, business_category.bus_id as bcid, business_category.category_id from `business_category` INNER JOIN categories ON categories.id = business_category.category_id WHERE business_category.bus_id =".$id);
            return $q->result();
        } 
        
        public function get_categories_short($parent,$level,$th){
            $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                         LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                         WHERE a.`parent`=" . $parent);
                        
                        $return_array = array();
                        
                        foreach($q->result() as $row){
                                    if ($row->Count > 0) {
                                        $sub_cat =  $this->get_categories_short($row->id, $level + 1,$th);
                                        $row->sub_cat = $sub_cat;       
                                    } elseif ($row->Count==0) {
                                    
                                    }
                            $return_array[] = $row;
                        }
        return $return_array;
    }
    
    
    /* ========== Brand========== */
    public function add_brand(){
        $slug = url_title($this->input->post('brand_title'), 'dash', TRUE);
        $addcat = array(
                        "title"     =>  $this->input->post("brand_title"),
                        "slug"      =>  $slug,
                        "status"    =>  $this->input->post("brand_status")
                        );
        
        if($_FILES["brand_img"]["size"] > 0){
            $config['upload_path']          = './uploads/category/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('brand_img'))
            {
                    $error = array('error' => $this->upload->display_errors());
            }
            else
            {
                $img_data = $this->upload->data();
                $addcat["image"]=$img_data['file_name'];
            }
            
       }
        $this->db->insert("tbl_brand",$addcat); 
    }
        
        

        
    public function edit_brand(){
    $slug           =   url_title($this->input->post('brand_title'), 'dash', TRUE);
        $cat_id     =   $this->input->post("brand_id");
        $querys     =   $this->db->query("SELECT product_id FROM products WHERE brand_id='".$cat_id."'");
        if($querys->num_rows() > 0){
           $result_pro  =   $querys->result_array();
           foreach($result_pro as $product){
                $product_id  =   $product['product_id'];
                $update_array =  array(
                                            'in_stock'   => $this->input->post("brand_status"),
                                        );
                $this->db->where('product_id', $product_id);
                $this->db->update('products', $update_array);
           }
           $update_cat_array   =   array(
                                        'status' => $this->input->post("brand_status")
                                    );
            $this->db->where('id', $cat_id);
            $this->db->update('tbl_brand', $update_cat_array);
        }
        
        //print_r($this->db->last_query()); exit;

        $editcat = array(
                        "title"     =>  $this->input->post("brand_title"),
                        "slug"      =>  $slug,
                        "status"    =>  $this->input->post("brand_status")
                        );
        
        if($_FILES["brand_img"]["size"] > 0){
            $config['upload_path']          = './uploads/category/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('brand_img'))
            {
                    $error = array('error' => $this->upload->display_errors());
            }
            else
            {
                $img_data = $this->upload->data();
                $editcat["image"]=$img_data['file_name'];
            }
            
       }

        $this->db->update("tbl_brand",$editcat,array("id"=>$this->input->post("brand_id"))); 
    }
    public function get_brand(){
        $q = $this->db->query("SELECT tbl_brand.* FROM `tbl_brand` WHERE trash=0 ");
       // $q = $this->db->query("select * from `categories` order by id DESC ");
        return $q->result();
    }

}
?>