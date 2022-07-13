<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataTableController extends My_Controller {

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


	public function fetchproducts(){
	   
		///////// enquiry Table ////////////////
// 		$type    =    $_REQUEST['typeservice'];
		
// 		$from    =    $_REQUEST['from'];
// 		$to      =     $_REQUEST['to'];
		$_REQUEST   = $_GET;
		$table_name = 'products';
		$column_order = array('products.static_product_id','products.product_name','product_cat_type.title','tbl_brand.title','products.product_id','products.product_description','products.product_id');
		
		$column_search = array('products.static_product_id','products.product_name','products.product_id','products.product_description','products.product_id', 'categories.title','tbl_brand.title');
		$select_data  = "products.*, categories.title, tbl_brand.title as brand_name, product_cat_type.title as product_cat_name";
		$order = array('products.product_id' => 'desc'); // default order
		$where_clause = array('products.trash' => 0); // default order
		$join_table11   =  array('categories' => 'categories.id=products.category_id','tbl_brand' => 'tbl_brand.id = products.brand_id', 'product_cat_type' => 'product_cat_type.product_cat_type_id = products.product_cat_type_id' );
		///////////////////////////////////////////////////////////
		$product_list = $this->my_model->get_datatables($table_name,$column_order,$column_search,$order,$where_clause, $select_data, $join_table11);
	
		$data = array();
		$no = $_REQUEST['start'];
//		$i = 0
		foreach ($product_list as $pro) {
			$no++;
			$action = '';
			$modal_name = 'products_action';
			$folder = 'products';
			if($pro->in_stock == "1"){ 
			    $status = '<span class="label label-success">In Stock</span>';
			 } else { 
			     $status = ' <span class="label label-danger">Out of Stock</span>'; 
			     
			 }
		
			$description =  htmlspecialchars_decode($pro->product_description);
			$prod = $pro->product_id;
			$delete_product = 'delete_product';
		
			$row = array();
		
			$row[] = $pro->static_product_id;
			$row[] = '<a href="#" data-toggle="tooltip" title="'.$pro->product_name.'">'.mb_substr($pro->product_name,0,50).'</a>';
			$row[] = $pro->title;
            		$row[] = $pro->product_cat_name;
			$row[] = $pro->brand_name;
			$row[] =  mb_substr(strip_tags($description),0,200);
			$row[] = $status;
			$row[] = '<div class="dropdown" style="display:inline;">
                            <a class="btn btn-success action-btn-edit dropdown-toggle" data-toggle="dropdown" title="More Actions"> <i class="material-icons">edit</i>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                            <li>
                                <a  href="'.base_url().'admin/edit_products/'.$pro->product_id.'"  title="Edit"> Edit </a>
                             </li>
                             <li>
                                 <a class="delete-curd" data-toggle="modal"  onclick="show_modal('."'".$modal_name."'".','."''".','."'".$delete_product."'".','."'".$prod."'".')"> Delete </a>
                             </li>
                            </ul>
                        </div>';
		
			$data[] = $row;
		}
		$output = array(
			"draw" => $_REQUEST['draw'],
			"recordsTotal" => $this->my_model->count_all($table_name),
			"recordsFiltered" => $this->my_model->count_filtered($table_name,$column_order,$column_search,$order,$where_clause,$join_table11),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function fetchOrders(){
	   
		///////// enquiry Table ////////////////
        //$type    =    $_REQUEST['typeservice'];
        $_REQUEST   = $_GET;
        //print_r($_REQUEST); print_r($_GET); exit;
        $from        =    '';
        $to          =    '';
        if(!empty($_REQUEST['from'])){
            $from    =    $_REQUEST['from'];
        }
        if(!empty($_REQUEST['to'])){
            $to      =     $_REQUEST['to'];
        }
        
		
		$table_name     = 'sale';
		$column_order   = array('sale.sale_id','sale.on_date','user_location.receiver_name', 'user_location.delivery_time_from','user_location.receiver_mobile','sale.total_amount','sale.payment_method','sale.status','sale.delivery_boy_id');
		
		$column_search  = array('sale.on_date','user_location.receiver_name','user_location.receiver_mobile','sale.on_date');
		// $select_data    = "sale.*, registers.*, sale.status as orderStatus,user_location.* ";
		$select_data    = "sale.*, sale.created_at as order_create_date, registers.*, sale.status as orderStatus,user_location.*,pincode.* ";
		$where_clause   = array();
		if(!empty($from)){
		    $fromdate   =  date("Y-m-d", strtotime($from));
            $todate     =  date("Y-m-d", strtotime($to));
		    $where_clause = array('sale.on_date >=' => $fromdate , 'sale.on_date <=' =>$todate );
		}
		
		$order = array('sale.sale_id' => 'desc'); // default order
		$join_table11   =  array('registers' => 'registers.user_id=sale.user_id','user_location'=>'user_location.location_id = sale.location_id','pincode'=>'user_location.pincode = pincode.pincode');
		
		///////////////////////////////////////////////////////////
		$order_list = $this->my_model->get_datatables($table_name,$column_order,$column_search,$order,$where_clause, $select_data, $join_table11);
	    //echo $this->db->last_query(); exit;
		$data = array();
		$no = $_REQUEST['start'];
//		$i = 0
        // print_r($order_list); exit;
		foreach ($order_list as $orders) {
			$no++;
			$boyde = '';
			$action = '';
			$modal_name =   'myModal';
			$order_by   =   !empty($orders->order_by) ? '('.$orders->order_by.')' : '';
			$cancel_by  =   !empty($orders->order_cancel_by) ? 'Admin' : 'User';
			$folder = 'orders';
			if ($orders->orderStatus == 0) {
                $status =  "<span class='label label-default'>Pending ".$order_by."</span>";
            } else if ($orders->orderStatus == 1) {
                $status = "<span class='label label-success'>Confirmed ".$order_by."</span>";
            } else if ($orders->orderStatus == 2) {
                $status = "<span class='label label-info'>Dispatch ".$order_by."</span>";
            } else if ($orders->orderStatus == 3) {
                $status = "<span class='label label-danger'>Cancel (".$cancel_by.")</span>";
            } else if ($orders->orderStatus == 4) {
                $status = "<span class='label label-info'>Delivered ".$order_by."</span>";
            }
            else if ($orders->orderStatus == -1) {
                $status = "<span class='label label-info'>Return</span>";
            }
            
            if (!empty($orders->delivery_boy_id)) {
                $deliver_boy = $this->db->query("select * from delivery_boy where id = '".$orders->delivery_boy_id."' ")->row();
                $name  = $deliver_boy->user_name;
                $boy =  "<span class='label label-info'>".$name."</span>";
            }else{
                $boy = "<span class='label label-danger'>Not Assigned</span>";
            }
            
            
            if ($orders->orderStatus == 0) {
                    $action =  "<li><a href='" . site_url("admin/confirm_order/" . $orders->sale_id) . "'>Confirm</a></li>";
            } else if ($orders->orderStatus == 1) {
                    $action = "<li><a href='" . site_url("admin/delivered_order/" . $orders->sale_id) . "'>Dispatch</a></li>";
            } else if ($orders->orderStatus == 2) {
                    $action =  "<li><a href='" . site_url("admin/delivered_order_complete/" . $orders->sale_id) . "'>Delivered</a></li>";
            }
			
            if (empty($orders->delivery_boy_id) && $orders->orderStatus != -1) { 
                $boyde = '<li><a href="#" data-toggle="modal"  onclick="show_modal_view('."'".$modal_name."'".','."'".$orders->sale_id."'".')" > Assign Deliver Boy </a></li>';
            } 
            
            if ($orders->orderStatus < 3 && $orders->orderStatus != -1 ) { 
                $action .=    '<li><a href="'.site_url("admin/cancle_order/" . $orders->sale_id).'"> '.$this->lang->line("Cancel").'</a></li>';
            }
            
            
           
            
            
            $orderw = $orders->sale_id;
			$delete_product = 'delete_product';
			$row = array();
			//print_r($orders); exit;
			$customer_name = !empty($orders->receiver_name) ? $orders->receiver_name : (!empty($orders->user_fullname)?$orders->user_fullname:'');
			if($orders->free_delivery_amount > $orders->total_amount){
				$order_amount = ($orders->total_amount+$orders->delivery_charge);
			}
			else{
				$order_amount = $orders->total_amount;
			}
		
			$row[] = $orders->sale_id;
			// $row[] = $orders->created_at;
			$row[] = "<b>Created Date:</b><br/> ".date("d-m-Y", strtotime($orders->order_create_date))."<br/><b>Delivery Date:</b><br/> ".date("d-m-Y", strtotime($orders->on_date))."<br/><b>Delivery Time:</b><br/>". date("H:i A", strtotime($orders->delivery_time_from)) . " - " . date("H:i A", strtotime($orders->delivery_time_to));
			$row[] = "<b>".$this->lang->line("Name").":</b><br/> ".$customer_name."<br/><b>Mobile No:</b><br/>".$orders->user_phone;
// 			$row[] = $orders->total_amount;
// 			$row[] = $orders->delivery_charge;
			$row[] = ($order_amount);
			$row[] = $orders->payment_method;
			$row[] = $status;
			$row[] = $boy;
			$row[] = '<a  href="'.site_url("admin/orderdetails/". $orders->sale_id).'" class="btn btn-success action-btn-detail" title="Order Details"> 
                                                                <i class="material-icons">info</i></a>
                                                                
                    <div class="dropdown" style="display:inline;">
                    <a class="btn btn-success action-btn-edit dropdown-toggle" data-toggle="dropdown" title="More Actions"> <i class="material-icons">edit</i>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">'.$action.$boyde.'
                           
                        
                       
                     <li>
                        <a href="'.site_url("admin/delete_order/" . $orders->sale_id).'"> '.$this->lang->line("Delete").'</a>
                    </li>
                    </ul>
                </div>';
                                                                
                                                                
		
			$data[] = $row;
		}
		$output = array(
			"draw" => $_REQUEST['draw'],
			"recordsTotal" => $this->my_model->count_all($table_name),
			"recordsFiltered" => $this->my_model->count_filtered($table_name,$column_order,$column_search,$order,$where_clause,$join_table11),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
    
    public function fetchOrders_by_filter(){
	   
		///////// enquiry Table ////////////////
        //$type    =    $_REQUEST['typeservice'];
        $_REQUEST   = $_GET;
        //print_r($_REQUEST); print_r($_GET); exit;
        $from        =    '';
        $to          =    '';
        if(!empty($_REQUEST['from'])){
            $from    =    $_REQUEST['from'];
        }
        if(!empty($_REQUEST['to'])){
            $to      =     $_REQUEST['to'];
        }
        
		
		$table_name     = 'sale';
		$column_order   = array('sale.sale_id','sale.on_date','user_location.receiver_name', 'user_location.delivery_time_from','user_location.receiver_mobile','sale.total_amount','sale.payment_method','sale.status','sale.delivery_boy_id');
		
		$column_search  = array('sale.on_date','user_location.receiver_name','user_location.receiver_mobile','sale.on_date');
		// $select_data    = "sale.*, registers.*, sale.status as orderStatus,user_location.* ";
		$select_data    = "sale.*, sale.created_at as order_create_date, registers.*, sale.status as orderStatus,user_location.*,pincode.* ";
		$where_clause   = array();
		if(!empty($from)){
		    $fromdate   =  date("Y-m-d", strtotime($from));
            $todate     =  date("Y-m-d", strtotime($to));
		    $where_clause = array('sale.on_date >=' => $fromdate , 'sale.on_date <=' =>$todate );
		}
		
		$order = array('sale.sale_id' => 'desc'); // default order
		$join_table11   =  array('registers' => 'registers.user_id=sale.user_id','user_location'=>'user_location.location_id = sale.location_id','pincode'=>'user_location.pincode = pincode.pincode');
		
		///////////////////////////////////////////////////////////
		$order_list = $this->my_model->get_datatables($table_name,$column_order,$column_search,$order,$where_clause, $select_data, $join_table11);
	    //echo $this->db->last_query(); exit;
		$data = array();
		$no = $_REQUEST['start'];
//		$i = 0
        // print_r($order_list); exit;
		foreach ($order_list as $orders) {
			$no++;
			$boyde = '';
			$action = '';
			$modal_name =   'myModal';
			$order_by   =   !empty($orders->order_by) ? '('.$orders->order_by.')' : '';
			$cancel_by  =   !empty($orders->order_cancel_by) ? 'Admin' : 'User';
			$folder = 'orders';
			if ($orders->orderStatus == 0) {
                $status =  "<span class='label label-default'>Pending ".$order_by."</span>";
            } else if ($orders->orderStatus == 1) {
                $status = "<span class='label label-success'>Confirmed ".$order_by."</span>";
            } else if ($orders->orderStatus == 2) {
                $status = "<span class='label label-info'>Dispatch ".$order_by."</span>";
            } else if ($orders->orderStatus == 3) {
                $status = "<span class='label label-danger'>Cancel (".$cancel_by.")</span>";
            } else if ($orders->orderStatus == 4) {
                $status = "<span class='label label-info'>Delivered ".$order_by."</span>";
            }
            else if ($orders->orderStatus == -1) {
                $status = "<span class='label label-info'>Return</span>";
            }
            
            if (!empty($orders->delivery_boy_id)) {
                $deliver_boy = $this->db->query("select * from delivery_boy where id = '".$orders->delivery_boy_id."' ")->row();
                $name  = $deliver_boy->user_name;
                $boy =  "<span class='label label-info'>".$name."</span>";
            }else{
                $boy = "<span class='label label-danger'>Not Assigned</span>";
            }
            
            
            if ($orders->orderStatus == 0) {
                    $action =  "<li><a href='" . site_url("admin/confirm_order/" . $orders->sale_id) . "'>Confirm</a></li>";
            } else if ($orders->orderStatus == 1) {
                    $action = "<li><a href='" . site_url("admin/delivered_order/" . $orders->sale_id) . "'>Dispatch</a></li>";
            } else if ($orders->orderStatus == 2) {
                    $action =  "<li><a href='" . site_url("admin/delivered_order_complete/" . $orders->sale_id) . "'>Delivered</a></li>";
            }
			
            if (empty($orders->delivery_boy_id) && $orders->orderStatus != -1) { 
                $boyde = '<li><a href="#" data-toggle="modal"  onclick="show_modal_view('."'".$modal_name."'".','."'".$orders->sale_id."'".')" > Assign Deliver Boy </a></li>';
            } 
            
            if ($orders->orderStatus < 3 && $orders->orderStatus != -1 ) { 
                $action .=    '<li><a href="'.site_url("admin/cancle_order/" . $orders->sale_id).'"> '.$this->lang->line("Cancel").'</a></li>';
            }
            
            
           
            
            
            $orderw = $orders->sale_id;
			$delete_product = 'delete_product';
			$row = array();
			//print_r($orders); exit;
			$customer_name = !empty($orders->receiver_name) ? $orders->receiver_name : (!empty($orders->user_fullname)?$orders->user_fullname:'');
			if($orders->free_delivery_amount > $orders->total_amount){
				$order_amount = ($orders->total_amount+$orders->delivery_charge);
			}
			else{
				$order_amount = $orders->total_amount;
			}
		
			$row[] = $orders->sale_id;
			// $row[] = $orders->created_at;
			$row[] = "<b>Created Date:</b><br/> ".date("d-m-Y", strtotime($orders->order_create_date))."<br/><b>Delivery Date:</b><br/> ".date("d-m-Y", strtotime($orders->on_date))."<br/><b>Delivery Time:</b><br/>". date("H:i A", strtotime($orders->delivery_time_from)) . " - " . date("H:i A", strtotime($orders->delivery_time_to));
			$row[] = "<b>".$this->lang->line("Name").":</b><br/> ".$customer_name."<br/><b>Mobile No:</b><br/>".$orders->user_phone;
// 			$row[] = $orders->total_amount;
// 			$row[] = $orders->delivery_charge;
			$row[] = ($order_amount);
			$row[] = $orders->payment_method;
			$row[] = $status;
			$row[] = $boy;
			$row[] = '<a  href="'.site_url("admin/orderdetails/". $orders->sale_id).'" class="btn btn-success action-btn-detail" title="Order Details"> 
                                                                <i class="material-icons">info</i></a>
                                                                
                    <div class="dropdown" style="display:inline;">
                    <a class="btn btn-success action-btn-edit dropdown-toggle" data-toggle="dropdown" title="More Actions"> <i class="material-icons">edit</i>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">'.$action.$boyde.'
                           
                        
                       
                     <li>
                        <a href="'.site_url("admin/delete_order/" . $orders->sale_id).'"> '.$this->lang->line("Delete").'</a>
                    </li>
                    </ul>
                </div>';
                                                                
                                                                
		
			$data[] = $row;
		}
		$output = array(
			"draw" => $_REQUEST['draw'],
			"recordsTotal" => $this->my_model->count_all($table_name),
			"recordsFiltered" => $this->my_model->count_filtered($table_name,$column_order,$column_search,$order,$where_clause,$join_table11),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function fetchTransaction(){
	   
		///////// enquiry Table ////////////////
		$_REQUEST   = $_GET;
        $from    =    $_REQUEST['from'];
        $to      =     $_REQUEST['to'];

		
		$table_name = 'transaction';
		$column_order = array('transaction.create_at','transaction.order_id','registers.user_fullname','transaction.transaction_id','','','transaction.transction_code','transaction.status');
		
		$column_search = array('transaction.create_at','transaction.order_id','registers.user_fullname','registers.user_phone','transaction.create_at','transaction.transaction_id','transaction.transction_code','transaction.status');
		$select_data   = "transaction.*, registers.*, transaction.status as transaction_status, transaction.create_at as transaction_at";
		$where_clause = array();
		if(!empty($from)){
		    $fromdate   =  date("Y-m-d", strtotime($from));
            $todate     =  date("Y-m-d", strtotime($to));
		    $where_clause = array('transaction.create_at >=' => $fromdate , 'transaction.create_at <=' =>$todate );
		}
		
		$order = array('transaction.id' => 'desc'); // default order
		$join_table11   =  array('registers' => 'registers.user_id=transaction.user_id');
		
		///////////////////////////////////////////////////////////
		$order_list = $this->my_model->get_datatables($table_name,$column_order,$column_search,$order,$where_clause, $select_data, $join_table11);
	    //echo $this->db->last_query(); exit;
		$data = array();
		$no = $_REQUEST['start'];
        //		$i = 0
        $boyde = '';
        //print_r($order_list); exit;
		foreach ($order_list as $orders) {
			$no++;
			$action = '';
			$modal_name ='myModal';
			
			$folder = 'orders';
			if ($orders->transaction_status == 0) {
                $status =  "<span class='label label-default'>Pending</span>";
            } else if ($orders->transaction_status == 1) {
                //$status = "<span class='label label-success'>Pay</span>";
                $status = "<span class='label label-success'>Paid</span>";
            } 
            
            
            
            $orderw = $orders->id;
			$row = array();
		
			$row[] = $orders->transaction_at;
			$row[] = $orders->order_id;
			$row[] = $orders->user_fullname;
			$row[] = $orders->transaction_id;
			//$row[] = $orders->description;
            $row[] = $orders->description;
			$row[] = number_format($orders->dr,2,",",".");
			$row[] = $orders->transction_code;
			$row[] = $status;

			$data[] = $row;
		}
		$output = array(
			"draw" => $_REQUEST['draw'],
			"recordsTotal" => $this->my_model->count_all($table_name),
			"recordsFiltered" => $this->my_model->count_filtered($table_name,$column_order,$column_search,$order,$where_clause,$join_table11),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function fetchRegisters(){
	   
		///////// enquiry Table ////////////////
        //$type    =    $_REQUEST['typeservice'];
        		
        //$from    =    $_REQUEST['from'];
        //$to      =     $_REQUEST['to'];
		$_REQUEST   = $_GET;
		$table_name = 'registers';
		$column_order = array('registers.user_id','registers.created_at','registers.user_fullname','registers.user_phone','registers.salf_rafale_code','registers.user_rafale_code',
		'','','','registers.status','');
		
		$column_search = array('registers.user_fullname','registers.user_phone','registers.user_phone','registers.user_phone');
		$where_clause = '';
		$order = array('registers.user_id' => 'desc'); // default order
		///////////////////////////////////////////////////////////
		$register_list = $this->my_model->get_datatables($table_name,$column_order,$column_search,$order,$where_clause);
	
		$data = array();
		$no = $_REQUEST['start'];
        //		$i = 0
		foreach ($register_list as $user) {
			$no++;
			$action = '';
			$user_id = $user->user_id;
			if ($user->status == "1") {
                $status =  "<span class='label label-success'>Active </span>";
            } else {
                $status = "<span class='label label-danger'>Deactive</span>";
            } 
            
                
                
            $sale_amount  = $this->db->query("select sum(total_amount) AS total_amount, count(sale_id) AS total_orders, 
                sum(total_rewards) AS total_rewards, user_id FROM sale where user_id = '".$user_id."' ")->row();
            $wallet_amount_credit  = $this->db->query("select SUM(cr_id)  as credit FROM wallet_history where user_id = '".$user_id."' ")->row();
            $wallet_amount_debit   = $this->db->query("select SUM(dr_id) as debit  FROM wallet_history where user_id = '".$user_id."' ")->row();
            $total_wallets         = ($wallet_amount_credit->credit - $wallet_amount_debit->debit);
                
                
             
            $modal_name  = 'user_action';
            $folder   =   'user';
			$delete_usr = 'delete_user';
			$row = array();
		
			$row[] = $user->user_id;
			$row[] = $user->created_at;
			$row[] = $user->user_fullname;
			$row[] = $user->user_phone;
			$row[] = $user->salf_rafale_code;
			$row[] = $user->user_rafale_code;
			$row[] = $sale_amount->total_orders;
			$row[] = $total_wallets;
			$row[] = (($sale_amount->total_amount*100)/100);
			$row[] = $status;
			$row[] = '
			         <div class="dropdown" style="display:inline;">
                            <a class="btn btn-success action-btn-edit dropdown-toggle" data-toggle="dropdown" title="More Actions"> <i class="material-icons">edit</i>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                            <li>
                                <a  href="'.site_url("admin/wish_list/". $user->user_id).'"  title="View Wish List"> Wish List </a>
                             </li>
                            <li>
                                <a  href="'.site_url("admin/user_action/". $user->user_id).'"  title="Edit"> Edit </a>
                             </li>
                             <li>
                                 <a data-toggle="modal" onclick="show_modal('."'".$modal_name."'".','."'".$folder."'".','."'".$delete_usr."'".','."'".$user_id."'".')"> Delete </a>
                             </li>
                            </ul>
                        </div>
			            
			        ';                                     
		
			$data[] = $row;
		}
		$output = array(
			"draw" => $_REQUEST['draw'],
			"recordsTotal" => $this->my_model->count_all($table_name),
			"recordsFiltered" => $this->my_model->count_filtered($table_name,$column_order,$column_search,$order,$where_clause),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
}