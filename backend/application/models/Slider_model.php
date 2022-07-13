<?php

class Slider_model extends CI_Model {

    public function get_slider_by_id($id) {
        $sql = "select * from slider where id ='" . $id . "' limit 0,1";
        $sql = "select 
	slider.id as id,
    slider.slider_title as slider_title,
    slider.slider_url as slider_url,
    slider.slider_image as slider_image,
    slider.sub_cat as sub_cat,
    slider.slider_status as slider_status,
    categories.title as cat_title,
    categories.slug as slug
	from slider 
    LEFT JOIN categories ON categories.id = slider.sub_cat AND categories.status = 1
	where slider.id = '" . $id . "' limit 0,1";
        $q = $this->db->query($sql);
        return $q->row();
    }

    public function get_banner($id) {
        $sql = "select * from banner where id ='" . $id . "' limit 0,1";
        $sql = "select 
                    banner.id as id,
                    banner.slider_title as slider_title,
                    banner.slider_url as slider_url,
                    banner.slider_image as slider_image,
                    banner.sub_cat as sub_cat,
                    banner.slider_status as slider_status,
                    categories.title as cat_title,
                    categories.slug as slug
                        from banner 
                    LEFT JOIN categories ON categories.id = banner.sub_cat AND categories.status = 1
                        where banner.id ='" . $id . "' limit 0,1";
        $q = $this->db->query($sql);
        return $q->row();
    }

    public function get_feature_banner($id) {
        $sql = "select * from feature_slider where id ='" . $id . "' limit 0,1";
        $sql = "select 
                    feature_slider.id as id,
                    feature_slider.image_type as image_type,
                    feature_slider.slider_title as slider_title,
                    feature_slider.slider_url as slider_url,
                    feature_slider.slider_image as slider_image,
                    feature_slider.sub_cat as sub_cat,
                    feature_slider.sub_type,
                    feature_slider.slider_status as slider_status,
                    feature_slider.banner_type,
                    categories.title as cat_title,
                    tbl_brand.title as brand_title,
                    products.product_name as product_name,
                    categories.slug as slug,
                    tbl_brand.slug as brand_slug,
                    products.product_slug as product_slug
                        from feature_slider 
                    LEFT JOIN categories ON categories.id = feature_slider.sub_cat AND categories.status = 1 AND feature_slider.sub_type='category'
                    LEFT JOIN tbl_brand  ON tbl_brand.id = feature_slider.sub_cat AND tbl_brand.status = 1 AND feature_slider.sub_type='brand'
                    LEFT JOIN products  ON products.product_id = feature_slider.sub_cat AND products.trash = 0 AND feature_slider.sub_type='product'
                        where feature_slider.id = '" . $id . "' limit 0,1";
        $q = $this->db->query($sql);
        return $q->row();
    }
    
    public function get_feature_banner_type($id) {
        $sql = "select * from feature_slider_type where type_id ='" . $id . "' ";
       
        $q = $this->db->query($sql);
        return $q->row();
    }
    
    
    
    public function get_slider() {
        $q = $this->db->query("Select * from slider WHERE trash=0");
        return $q->result();
    }

    public function banner() {
        $q = $this->db->query("Select * from banner WHERE trash=0");
        return $q->result();
    }

    public function feature_banner() {
        $q = $this->db->query("Select * from feature_slider WHERE trash=0");
        return $q->result();
    }
    public function feature_banner_type(){
        $q = $this->db->query("Select * from feature_slider_type");
        return $q->result();
    }
    public function get_active_slider() {
        $q = $this->db->query("select * from slider where slider_status = 1 ");
        return $q->result();
    }

    public function edit_slider($edit, $id) {
        $this->db->update("slider", $edit, array("id" => $id));
    }

    public function edit_feature_banner($id) {
        $ids        =   '';
        $type       =   '';
        if(!empty($this->input->post("sub_cat"))){
            $type   =   "category";
            $ids    =   $this->input->post("sub_cat");
        }
        if(!empty($this->input->post("brand"))){
            $type   =   "brand";
            $ids    =   $this->input->post("brand");
        }
        if(!empty($this->input->post("product"))){
            $type   =   "product";
            $ids    =   $this->input->post("product");
        }
        $edit = array(
            "slider_title" => $this->input->post("slider_title"),
            "slider_status" => $this->input->post("slider_status"),
            "slider_url" => $this->input->post("slider_url"),
            'image_type' => $this->input->post("banner_size"),
            "sub_cat" => $ids,
            "sub_type" => $type,
            "banner_type" => $this->input->post("banner_type")
        );
        
                
        if ($_FILES["slider_img"]["size"] <= $this->config->item('slider_file_size') && $_FILES["slider_img"]["size"] > 0) {
            
            $config['upload_path'] = './uploads/sliders/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            if($this->input->post("banner_size") == 1 && $this->input->post("banner_type") == 3){
                $config['max_width'] = '750';
                $config['min_width'] = '750';
                $config['max_height'] = '250';
                $config['min_height'] = '250';
            }
            elseif($this->input->post("banner_size") == 0 && $this->input->post("banner_type") == 3){
                $config['max_width'] = '1395';
                $config['min_width'] = '1395';
                $config['max_height'] = '200';
                $config['min_height'] = '200';
            }
            elseif($this->input->post("banner_size") == 0 && $this->input->post("banner_type") == 1){
                $config['max_width'] = '560';
                $config['min_width'] = '560';
                $config['max_height'] = '378';
                $config['min_height'] = '378';
            }
            elseif($this->input->post("banner_size") == 1 && $this->input->post("banner_type") == 1){
                $config['max_width'] = '275';
                $config['min_width'] = '275';
                $config['max_height'] = '184';
                $config['min_height'] = '184';
            }
            elseif(($this->input->post("banner_size") == 1 || $this->input->post("banner_size") == 0) && $this->input->post("banner_type") == 2){
                $config['max_width'] = '480';
                $config['min_width'] = '480';
                $config['max_height'] = '360';
                $config['min_height'] = '360';
            }
            elseif(($this->input->post("banner_size") == 1 || $this->input->post("banner_size") == 0) && $this->input->post("banner_type") == 4){
                $config['max_width'] = '1130';
                $config['min_width'] = '1130';
                $config['max_height'] = '400';
                $config['min_height'] = '400';
            }
            
            $this->load->library('upload', $config);
           // print_r($this->upload->display_errors());
            if (!$this->upload->do_upload('slider_img')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $img_data = $this->upload->data();
                $edit["slider_image"] = $img_data['file_name'];
            }
        }else{
             $error = array('error' => 'Slider File size is greater then '.$this->config->item('slider_file_size').' Bites...');
        }
        //print_r($edit);    exit;
        $this->db->update("feature_slider", $edit, array("id" => $id));
    }

    public function edit_banner($edit, $id) {
       
        $this->db->update("banner", $edit, array("id" => $id));
    }
	
	public function get_image_by_id($id) {
        $sql = "select * from images where id ='" . $id . "'";
        
        $q = $this->db->query($sql);
        return $q->row();
    }
	public function get_images() {
        $q = $this->db->query("select * from images where trash = 0 order by id desc");
        return $q->result();
    }

    public function edit_image($edit, $id) {
        $this->db->update("images", $edit, array("id" => $id));
    }

}

?>