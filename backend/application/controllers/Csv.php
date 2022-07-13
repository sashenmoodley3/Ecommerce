<?php
class Csv extends CI_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('csv_model');
    }
    function index()
    {
        $this->load->view('admin/uploadCsvView');
    }
    function uploadData(){
	
		$file_data = $_FILES["userfile"]["tmp_name"];
		$object=PHPExcel_IOFactory::load($file_data);
		//print_r($object->getWorksheetIterator()); exit;
		foreach ($object->getWorksheetIterator() as $worksheet) {
			$highestRow = $worksheet->getHighestRow();
			$higestColumn=$worksheet->getHighestColumn();
			for($row=2; $row<=$highestRow; $row++){
				$productNmae 		=  $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				$productDescription =  $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$productImage 		=  $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$categoryId 		=  $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				$inStock 			=  $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				$price 				=  $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				$mrp 				=  $worksheet->getCellByColumnAndRow(6, $row)->getValue();
				$tax 				=  $worksheet->getCellByColumnAndRow(7, $row)->getValue();
				$unitValue 			=  $worksheet->getCellByColumnAndRow(8, $row)->getValue();
				$unit 				=  $worksheet->getCellByColumnAndRow(9, $row)->getValue();
				$increament 		=  $worksheet->getCellByColumnAndRow(10, $row)->getValue();
				$static_product_id 	=  $worksheet->getCellByColumnAndRow(11, $row)->getValue();
				$skucode 			=  $worksheet->getCellByColumnAndRow(12, $row)->getValue();
				$warehouse 			=  $worksheet->getCellByColumnAndRow(13, $row)->getValue();
				$qty 			    =  $worksheet->getCellByColumnAndRow(14, $row)->getValue();
				$varients		    =  $worksheet->getCellByColumnAndRow(15, $row)->getValue();

				$data = array(
					'product_id'                =>  "" ,
                    'product_name'              =>  $productNmae,
                    'product_description'       =>  $productDescription,
                    'product_image'             =>  $productImage,
                    'category_id'               =>  $categoryId,
                    'in_stock'                  =>  $inStock,
                    'price'                     =>  $price,
                    'mrp'                       =>  $mrp,
                    'unit_value'                =>  $unitValue,
                    'unit'                      =>  $unit,
                    'increament'                =>  $increament,
                    'rewards'                   =>  0,
                    'tax'                       =>  $tax,
                    'prod_sku_code'             =>  $skucode,
                    'prod_ware_location'        =>  $warehouse,
                    'static_product_id'         =>  $static_product_id
				);
				//print_r($data); exit;
				$datas = $this->db->insert('products', $data);
				$in_id = $this->db->insert_id();
				
				$varient       =  json_decode($varients, true);
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
                                            'description'   => $productDescription,
                                            'trash'         => 0
                                            );
                        $data  = $this->db->insert('product_varient', $data_varient);
                }
				
				if($datas){
					$datastatus 	=	1;
					$date=date('Y-m-d h:i:s');

					$data1 = array(
						'purchase_id' => "" ,
						'product_id' => $in_id,
						'qty' => 100,
						'unit' => $unit,
						'date' => $date,
						'store_id_login' => '1'
					);
					//$data = $this->db->insert('purchase', $data1);
					

				}
			}
		}
		if($data){
			$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
													<i class="fa fa-check"></i>
										  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										  <strong>Success!</strong> Your request Send successfully...
										</div>');
		}
		else{
			$data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
													<i class="fa fa-warning"></i>
												  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												  <strong>Warning!</strong> Something wents Wrong</div>';
			
		}
		redirect('csv');
	}
}
?>