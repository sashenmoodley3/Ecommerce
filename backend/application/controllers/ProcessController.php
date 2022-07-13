<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProcessController extends My_Controller {

	public function __construct() {
		parent::__construct();
		$this->groups = array(
			'1' => 'O−',
			'2' => 'O+',
			'3' => 'A−',
			'4' => 'A+',
			'5' => 'B−',
			'6' => 'B+',
			'7' => 'AB−',
			'8' => 'AB+',

		);
		$this->freeservice = array(
			'1' => 'Online Pooja',
			'2' => 'Birth',
			

		);
        $master_data_array = array('TDS','gateway_charge','admin_percentage');
        //$this->master_data = $this->auth_model->getMasterData($master_data_array);
	}

	////fetch enquiry///////////

    public function ActionProductDelete($action = '',$id = ''){
       
        $result =0;
        if ($action == 'delete_product'){
            $product_id      = $id;
            $data = array(
                'in_stock' => 0,
                'trash' => 1
            );
            $result = $this->my_model->dbRowUpdate('products',$data,'Where product_id = "'.$product_id.'"');
           //echo $this->db->last_query(); exit;
        }
        

        if($result == 1){
            
            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Delete successfully...
                                    </div>');
            redirect('admin/products');
        }else{
            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Delete successfully...
                                    </div>');
            $this->errorMessage('error_msg',$msg);
            
            redirect('admin/products');
        }

        

    }
    public function ActionUserDelete($action = '',$id = ''){
       
        $result =0;
        if ($action == 'delete_user'){
            $userid      = $id;
            $this->db->query("update registers set status='0' where user_id = '" . $userid . "'");
            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Update. </div>');
            redirect("admin/registers");
           
        }
        

    }

}