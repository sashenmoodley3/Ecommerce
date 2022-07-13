<?php
class Csv_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function uploadData(){
            $count=0;
            $fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
            while($csv_line = fgetcsv($fp,1024))
            {
                $count++;
                if($count == 1)
                {
                    continue;
                }//keep this if condition if you want to remove the first row
                for($i = 0, $j = count($csv_line); $i < $j; $i++)
                {
                    $insert_csv                         = array();
                    $insert_csv['product_name']         = $csv_line[0];
                    $insert_csv['product_description']  = $csv_line[1];
                    $insert_csv['product_image']        = $csv_line[2];
                    $insert_csv['category_id']          = $csv_line[3];
                    $insert_csv['in_stock']             = $csv_line[4];
                    $insert_csv['price']                = $csv_line[5];
                    $insert_csv['unit_value']           = $csv_line[6];
                    $insert_csv['unit']                 =  $csv_line[7];
                    $insert_csv['increament']           = $csv_line[8];
                    $insert_csv['rewards']              = $csv_line[9];
                    $insert_csv['tax']                  = $csv_line[10];
                    $insert_csv['skucode']              = $csv_line[11];
                    $insert_csv['warehouse']            = $csv_line[12];
                    $insert_csv['static_product_id']    = $csv_line[13];  
                    $insert_csv['qty']                  = $csv_line[14];   
                    $insert_csv['varient']              = $csv_line[15];
                }
                $i++;
                
                $mrp        =   $insert_csv['price'];
                if($insert_csv['tax'] == 'T'){
                    $tax    =   5;
                    $mrp    =   number_format(($insert_csv['price']*105)/100,2);
                }
                elseif($insert_csv['tax'] == 'P'){
                    $tax    =   19;
                    $mrp    =   number_format(($insert_csv['price']*119)/100,2);
                }
                //print_r($insert_csv); 
                $data = array(
                    'product_id'                => "" ,
                    'product_name'              => $insert_csv['product_name'],
                    'product_description'       => $insert_csv['product_description'],
                    'product_image'             => $insert_csv['product_image'],
                    'category_id'               => $insert_csv['category_id'],
                    'in_stock'                  => $insert_csv['in_stock'],
                    'price'                     => $insert_csv['price'],
                    'mrp'                       => $mrp,
                    'unit_value'                => $insert_csv['unit_value'],
                    'unit'                      => $insert_csv['unit'],
                    'increament'                => $insert_csv['increament'],
                    'rewards'                   => $insert_csv['rewards'],
                    'tax'                       => $tax,
                    'prod_sku_code'             =>$insert_csv['skucode'],
                    'prod_ware_location'        =>$insert_csv['warehouse'],
                    'static_product_id'         =>$insert_csv['static_product_id']
                    );
                    //print_r($data);
                $data['crane_features']=$this->db->insert('products', $data);
                $in_id=$this->db->insert_id();
                $date=date('Y-m-d h:i:s');
                
                $varient       =  json_decode($insert_csv['varient'], true);
                foreach($varient as $row){
                    $data_varient   = array(
                                            'varient_id'    => '',
                                            'product_id'    => $in_id,
                                            'price'         => $row['price'],
                                            'qty'           => $row['qty'],
                                            'unit'          => $row['unit'],
                                            'tax'           => $tax,
                                            'mrp'           => $row['mrp'],
                                            'date'          => $date,
                                            'description'   => $insert_csv['product_description'],
                                            'trash'         => 0
                                            );
                        $data  = $this->db->insert('product_varient', $data_varient);
                }
                
                $data1 = array(
                    'purchase_id' => "" ,
                    'product_id' => $in_id,
                    'qty' => $insert_csv['qty'],
                    'unit' => $insert_csv['unit'],
                    'date' => $date,
                    'store_id_login' => '1'
                    );
                $data  = $this->db->insert('purchase', $data1);
                if($data){
                    $datas  = 1;
                }
                else{
                    $datas  = 0;
                }
            }
            
           // exit;
            fclose($fp) or die("can't close file");
            $data['success']="Product upload success";
            return $datas;
    }
    
    function uploadCategoryData(){
            $count=0;
            $fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
            while($csv_line = fgetcsv($fp,1024))
            {
                $count++;
                if($count == 1)
                {
                    continue;
                }//keep this if condition if you want to remove the first row
                for($i = 0, $j = count($csv_line); $i < $j; $i++)
                {
                    $insert_csv                  = array();
                    $insert_csv['title']         = $csv_line[0];
                    $insert_csv['description']   = $csv_line[1];
                    $insert_csv['image']         = $csv_line[1];
                }
                $i++;
                
               
                //print_r($insert_csv); 
                $data = array(
                    'id'                    => "" ,
                    'title'                 => $insert_csv['title'],
                    'slug'                  => strtolower(str_replace(' ', '-', $insert_csv['title'])),
                    'description'           => $insert_csv['description'],
                    'image'                 => $insert_csv['image'],
                    'status'                => 1
                    );
                    //print_r($data);
                $data   =   $this->db->insert('categories', $data);
                if($data){
                    $datas  = 1;
                }
                else{
                    $datas  = 0;
                }
            }
            
           // exit;
            fclose($fp) or die("can't close file");
            $data['success']="Product upload success";
            return $datas;
    }
    function uploadSubCategoryData($categoryId){
            $count=0;
            $fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
            while($csv_line = fgetcsv($fp,1024))
            {
                $count++;
                if($count == 1)
                {
                    continue;
                }//keep this if condition if you want to remove the first row
                for($i = 0, $j = count($csv_line); $i < $j; $i++)
                {
                    $insert_csv                  = array();
                    $insert_csv['title']         = $csv_line[0];
                    $insert_csv['description']   = $csv_line[1];
                    $insert_csv['image']         = $csv_line[1];
                }
                $i++;
                
               
                //print_r($insert_csv); 
                $data = array(
                    'id'                    => "" ,
                    'title'                 => $insert_csv['title'],
                    'slug'                  => strtolower(str_replace(' ', '-', $insert_csv['title'])),
                    'description'           => $insert_csv['description'],
                    'parent'                =>  $categoryId,
                    'leval'                 =>  1,
                    'image'                 => $insert_csv['image'],
                    'status'                => 1
                    );
                    //print_r($data);
                $data   =   $this->db->insert('categories', $data);
                if($data){
                    $datas  = 1;
                }
                else{
                    $datas  = 0;
                }
            }
            
           // exit;
            fclose($fp) or die("can't close file");
            $data['success']="Product upload success";
            return $datas;
    }
}