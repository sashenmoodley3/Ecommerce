<?php  $this->load->view("admin/common/head"); ?>
<link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/dataTables.bootstrap4.min.css"); ?>" rel="stylesheet" />
    <style>
        .border-dark{
            padding: 10px 0px 0px 0px;
            border-top:1px #ccc solid;
            border-bottom:1px #ccc solid;
        }
        table.custom-table > thead > tr > th{
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
        }
        .mybtn{text-align:center;}
        .mybtn .dt-buttons>button{
        webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        position: relative;
        border: 0;
        border-radius: 3px;
        padding: 6px;
        font-weight: 400;
        color: #ffffff;
        font-style: inherit;
        font-variant: inherit;
        font-size: inherit;
        font-family: inherit;
        line-height: inherit;
        box-shadow: 0 2px 5px 0 rgba(0,0,0,.26);
        transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1),-webkit-transform .4s cubic-bezier(.25,.8,.25,1);
        transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1),transform .4s cubic-bezier(.25,.8,.25,1);
        }
        .mybtn .dt-buttons>button:nth-child(1){
        background-color: #e91e63;
        }
        .mybtn .dt-buttons>button:nth-child(2){
        background-color: #2196f3;
        margin-left: 3x;
        }
        .mybtn .dt-buttons>button:nth-child(3){
        background-color: #4caf50;
        margin-left: 3px;
        }
        .mybtn .dt-buttons>button:nth-child(4){
        background-color: #e91e63;
        margin-left: 3px;
        }
        
        .myselect label, .mysearch label{color: #292929;}
        .myselect select{height: 35px; width: 100%; padding: 0 5px;}
        
        .mysearch label{display:block;}
        .mysearch input{width:100% !important; border:1px solid #cccccc; height: 35px; padding: 0 12px;}
        a.action-btn-detail{
                padding: 10px;
                border-radius: 50%;
        }
        a.action-btn-edit{
                padding: 11px 5px;
                border-radius: 50%;
        }
        
/*        product detail popup css start*/
        
             

            .openmodal {
                background-color: white;
                color: black;
                width: 30vw
            }

            :-moz-any-link:focus {
                outline: none
            }

/*
            button:active {
                outline: none
            }

            button:focus {
                outline: none
            }

            .btn:focus {
                box-shadow: none
            }
*/
        
/*        product detail popup css end*/
        
        /* tooltip css start*/
        
/*
        .tooltip {
          position: relative;
          display: inline-block;
          border-bottom: 1px dotted black;
        }
*/

        .tooltip1 .tooltiptext {
          visibility: hidden;
          width: auto;
          background-color: #eeeeee;
          color: #000;
          text-align: center;
          border-radius: 6px;
          padding: 15px;

          /* Position the tooltip */
          position: absolute;
          z-index: 1;
        }

        .tooltip1:hover .tooltiptext {
          visibility: visible;
        }
        /* tooltip css end*/
        
    </style>


<body>
    <div class="wrapper">
        <!--sider -->
        <?php  $this->load->view("admin/common/sidebar"); ?>
        
        <div class="main-panel">
            <!--head -->
            <?php  $this->load->view("admin/common/header"); ?>
            <!--content -->
            <div class="content">
                <div class="container-fluid">
                    <?php  if(isset($error)){ echo $error; }
                        echo $this->session->flashdata('message'); 
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("All Orders");?></h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <form id="add2" form="" action="<?php echo site_url("admin/exports_invoice"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Orders List"); ?></h4>
                                        <div class="mybtn" style="display: inline-block; float:right;">
                                            <div class="dt-buttons">
                                                <button class="dt-button text-right" style="display: inline-block;" href="">Export Invoice</button>
                                            </div>
                                        </div>
                                        
                                        <div  class="toolbar">
                                            <div class="row">
                                                <div class="col-md-5 pull-right">
                                                    <div class="input-group input-daterange">
                                                        <input type="text" id="txtDate" name="fromdate" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">
                                                        <div class="input-group-addon">to</div>
                                                        <input type="text" id="txtDate2" name="todate" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        </div>
                                    </form>
                                    
                                    <h4 class="card-title"><?php echo $this->lang->line("Filters");?>: </h4>
                                    
                                    <form id="add2"  form="" action="<?php //echo site_url("admin/exports_invoice"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
                                    <div class="row"  style="margin-bottom:50px">
                                            <div class="col-md-3">
                                                <div >
                                                    <label class="label-on-left"><?php echo $this->lang->line("Date Type");?>: </label>
                                                    <select class="text-input form-control" id="datetype" name="datetype">
                                                        <option value="0">--Date Type--</option>
                                                        <option value="created_at" <?php if(@$post["datetype"]=="created_at"){ echo "selected";}?>>Order Date</option>
                                                        <option <?php if(@$post["datetype"]=="order_cancel_by"){ echo "selected";}?> value="order_cancel_by">Cancel Date</option>
                                                        <option <?php if(@$post["datetype"]=="on_date"){ echo "selected";}?> value="on_date">Delivery Date</option>
                                                        <option <?php if(@$post["datetype"]=="order_deliverd_date"){ echo "selected";}?> value="order_deliverd_date">Delivered Date</option>
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                            <div class="col-md-3">
                                                <div >
                                                    <label class="label-on-left"><?php echo $this->lang->line("To");?>:</label>
<!--                                                    <input type="text" name="dateto" id="dateto" class="form-control"  placeholder="Date To"/>-->
                                                    <input type="text" id="dateto" name="dateto" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:" value="<?php echo @$post["dateto"];?>">
                                                <span class="material-input"></span></div>
                                            </div>
                                        <div class="col-md-3">
                                                <div >
                                                    <label class="label-on-left"><?php echo $this->lang->line("From");?>: </label>
                                                    <input value="<?php echo @$post["fromdate"];?>" type="text" id="datefrom" name="fromdate" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">
<!--                                                    <input type="text" name="datefrom" id="datefrom" class="form-control"  placeholder="Date From"/>-->
                                                <span class="material-input"></span></div>
                                            </div>
                                            <div class="col-md-3">
                                                <div >
                                                    <label class="label-on-left"><?php echo $this->lang->line("Payment Method");?>: </label>
                                                   <select class="text-input form-control" id="paymentmethod" name="paymentmethod">
                                                        <option value="">--Payment Method--</option>
                                                        <option <?php if(@$post["paymentmethod"]=="Cash On Delivery"){ echo "selected";}?> value="Cash On Delivery">Cash On Delivery</option>
                                                        <option <?php if(@$post["paymentmethod"]=="Razorpay"){ echo "selected";}?> value="Razorpay">RazorPay</option>
                                                        <option <?php if(@$post["paymentmethod"]=="Paypal"){ echo "selected";}?> value="Paypal">PayPal</option>
                                                        <option <?php if(@$post["paymentmethod"]=="Paytm"){ echo "selected";}?> value="Paytm">Paytm</option>
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        <div class="col-md-3">
                                                <div >
                                                    <label class="label-on-left"><?php echo $this->lang->line("Customer Name");?>: </label>
                                                    <input type="text" value="<?php echo @$post["customername"];?>" required name="customername" id="customername" class="form-control"  placeholder="Customer Name"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                            <div class="col-md-3">
                                                <div >
                                                    <label class="label-on-left"><?php echo $this->lang->line("deliverBoyname");?>: </label>
                                                    <input value="<?php echo @$post["deliverboyname"];?>" type="text" required name="deliverboyname" id="deliverboyname" class="form-control"  placeholder="Deliver Boy Name"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                            <div class="col-md-3">
                                                <div >
                                                    <label class="label-on-left"><?php echo $this->lang->line("Order Status");?>: </label>
                                                    <select class="text-input form-control" id="orderstatus" name="orderstatus">
                                                        <option value="">--Order Type--</option>
                                                        <option <?php if(@$post["orderstatus"]=="0"){ echo "selected";}?> value="0">Pending Orders</option>
                                                        <option <?php if(@$post["orderstatus"]=="1"){ echo "selected";}?> value="1">Confirm Orders</option>
                                                        <option <?php if(@$post["orderstatus"]=="2"){ echo "selected";}?> value="2">Dispatch Orders</option>
                                                        <option <?php if(@$post["orderstatus"]=="4"){ echo "selected";}?> value="4">Delivered Orders</option>
                                                        <option <?php if(@$post["orderstatus"]=="-1"){ echo "selected";}?> value="-1">Returned Order Request</option>
                                                        <option <?php if(@$post["orderstatus"]=="returnedorder"){ echo "selected";}?> value="returnedorder">Returned Order</option>
                                                        <option <?php if(@$post["orderstatus"]=="3"){ echo "selected";}?> value="3">Cancel Orders</option>
<!--                                                       <option value="assigned orders">Assigned Orders</option>-->
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                            <div class="col-md-3">
                                                <div >
                                                    
                                                    <div class="mybtn" style="display: inline-block; float:right;    PADDING-TOP: 46px;PADDING-RIGHT: 120PX;">
                                                    <div class="dt-buttons">
                                                        <button id="btn_filter" class="dt-button text-center" style="display: inline-block; width:50px;width: 80px;">Filter</button>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="datatable" class="table table-border table-striped custom-table datatable mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left"><?php echo $this->lang->line("Order"); ?></th>
<!--                                                            <th class="text-center"><?php echo $this->lang->line("Date"); ?></th>-->
                                                            <th class="text-left"><?php echo $this->lang->line("Customer"); ?></th>
                                                            <!--<th class="text-center"><?php echo $this->lang->line("Order Amount"); ?></th>-->
                                                            <!--<th class="text-center"><?php echo $this->lang->line("Delivery Chaleftrge"); ?></th>-->
                                                            <th class="text-left"><?php echo $this->lang->line("Amount")." (in ".$this->config->item('currency').")"; ?></th>
<!--                                                            <th class="text-center"><?php echo $this->lang->line("User Signature"); ?></th>-->
                                                            <th class="text-left"><?php echo $this->lang->line("Payment Method"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Status"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Delivery Boy"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Action"); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th class="text-left"><?php echo $this->lang->line("Order"); ?></th>
<!--                                                            <th class="text-center"><?php echo $this->lang->line("Date"); ?></th>-->
                                                            <th class="text-left"><?php echo $this->lang->line("Customer"); ?></th>
                                                            <!--<th class="text-center"><?php echo $this->lang->line("Order Amount"); ?></th>-->
                                                            <!--<th class="text-center"><?php echo $this->lang->line("Delivery Charge"); ?></th>-->
                                                            <th class="text-left"><?php echo $this->lang->line("Amount"); ?></th>
<!--                                                            <th class="text-center"><?php echo $this->lang->line("User Signature"); ?></th>-->
                                                            <th class="text-left"><?php echo $this->lang->line("Payment Method"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Status"); ?></th>
                                                            <th class="text-left"><?php $this->lang->line("Delivery Boy"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Action"); ?></th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
                                                        //$no = $_REQUEST['start'];
          foreach($all_orders as $orders)
          {
              //$no++;
			$boyde = '';
			$action = '';
			$modal_name =   'myModal';
			$order_by   =   !empty($orders->order_by) ? '('.$orders->order_by.')' : '';
			$cancel_by  =   !empty($orders->order_cancel_by) ? 'Admin' : 'User';
			$folder = 'orders';
			if ($orders->orderStatus == 0) {
                $status =  "<span class='label label-default'>Pending ".$order_by."</span>";
            } else if ($orders->orderStatus == 1) {
                $status = "<span class='label label-info'>Confirmed ".$order_by."</span>";
            } else if ($orders->orderStatus == 2) {
                $status = "<span class='label label-warning'>Dispatch ".$order_by."</span>";
            } else if ($orders->orderStatus == 5) {
                $status = "<span class='label label-warning'>Hold ".$order_by."</span>";
            } else if ($orders->orderStatus == 3) {
                $status = "<span class='label label-danger'>Cancel (".$cancel_by.")</span>";
            } else if ($orders->orderStatus == 4) {
                $status = "<span class='label label-success'>Delivered ".$order_by."</span>";
            }
            else if ($orders->orderStatus == -1 && $orders->refund_status==0) {
                $status = "<span class='label label-info'>Return Request Pending</span>";
            }
            elseif($orders->orderStatus == -1 && $orders->refund_status == 1)
            {
                $status =  "<span class='label label-info'>Return Request Accepted</span>";
            }
            elseif($orders->orderStatus == -1 && $orders->refund_status == 2){
                $status =  "<span class='label label-danger'>Return Request cancelled</span>";
            }
            elseif($orders->orderStatus == -1 && $orders->refund_status == 3){
                $status =  "<span class='label label-success'>Return Request Comfirmed</span>";
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
            
            if(!empty($orders->signature))
            {
                $signature = $orders->signature;
            }
            else
            {
                $signature = "signature.png";
            }
           
            
            
            $orderw = $orders->sale_id;
			$delete_product = 'delete_product';
			$row = array();
			//print_r($orders); 
			$customer_name = !empty($orders->receiver_name) ? $orders->receiver_name : (!empty($orders->user_fullname)?$orders->user_fullname:'');
			// if($orders->free_delivery_amount > $orders->total_amount){
			// 	$order_amount = ($orders->total_amount+$orders->delivery_charge);
			// }
			// else{
			// 	$order_amount = $orders->total_amount;
			// }
            $order_amount = $orders->total_amount;
              
              $customer_tooltip_content = "<b>Name: </b>".ucfirst($customer_name)."<br><b>Email: </b>".$orders->user_email."<br><b>Mobile: </b>".$orders->receiver_mobile;
            ?>
                                                        
                                                        <?php //echo '<a href="#" data-toggle="modal" onclick="show_product_modal_view('."'ProductModal'".','."'".$orders->sale_id."'".')" class="" title="Order Invoice">'.$orders->sale_id.'</a>';?>
            
                <tr>
                    <td><?php echo $orders->sale_id;?></td>
                                                                 
<!--                    <td><?php echo "<b>Created Date:</b><br/> ".date("d-m-Y", strtotime($orders->order_create_date))."<br/><b>Delivery Date:</b><br/> ".date("d-m-Y", strtotime($orders->on_date))."<br/><b>Delivery Time:</b><br/>". date("H:i A", strtotime($orders->delivery_time_from)) . " - " . date("H:i A", strtotime($orders->delivery_time_to)); ?></td>-->
<!--                    <td><?php echo '<a href="#" data-toggle="modal" onclick="show_customer_info_modal_view('."'ProductModal'".','."'".$orders->sale_id."'".')" class="" title="'.$customer_tooltip_content.'">'.ucfirst($customer_name).'</a>'; ?></td>-->
                    <td><div class="tooltip1" style="opacity: 6;text-align:left;"><b><?php echo ucfirst($customer_name);?></b>
                              <span class="tooltiptext" style="text-align:left;"><?php echo $customer_tooltip_content;?></span>
                            </div>
                        </td>
                    <td><?php echo number_format($order_amount, 2, ".",""); ?></td>
<!--                    <td><img src="<?php echo site_url('uploads/signature/'.$signature); ?>" alt="Customer Signature" style="width: 100px; height: 40px;" height="15px;" width="30px;"></td>-->
                    <td><?php echo $orders->payment_method; ?></td>
                    <td><?php echo $status; ?></td>
                    <td><?php echo $boy; ?></td>
                    <td><?php 
              
            echo  '<a href="#" data-toggle="modal" onclick="show_product_modal_view('."'ProductModal'".','."'".$orders->sale_id."'".')" class="btn btn-success action-btn-detail" title="Order Details" ><i class="material-icons">list</i></a> ';
              
              echo '<a  href="'.site_url("admin/orderdetails/". $orders->sale_id).'" class="btn btn-success action-btn-detail" title="Order Invoice"> 
                                                                <i class="material-icons">info</i></a>
                                                                
                    <div class="dropdown" style="display:inline;">
                    <a class="btn btn-success action-btn-edit dropdown-toggle" data-toggle="dropdown" title="More Actions"> <i class="material-icons">edit</i>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">'.$action.$boyde.'
                           
                        
                       
                     <li>
                        <a href="'.site_url("admin/delete_order/" . $orders->sale_id).'"> '.$this->lang->line("Delete").'</a>
                    </li>
                    </ul>
                </div>';?></td>
                    
                </tr>
            <?php
          }
          ?>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->
                </div>
            </div>
            <!--footer -->
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <!--fixed -->
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>


<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    
<script type="text/javascript">
    function show_modal_view(modal_name,action_id) {
        var BASE_URL = '<?php echo site_url()?>';
        $.get(BASE_URL+"Admin/get_html_assign_deliveryBoy",{ action_id:action_id},function(data){
            $('.delivery_boy_details').html(data);

            $('#'+modal_name).modal('show');

        });

    }
    
    function show_product_modal_view(modal_name,action_id) {
        var BASE_URL = '<?php echo site_url()?>';
        $.get(BASE_URL+"Admin/get_html_order_details",{order_id:action_id},function(data){
            //alert(data);
            $('#order_details').html(data);

            $('#'+modal_name).modal('show');

        });

    }
    
    
    $(document).ready(function() {
        
        fetchOrder();
        
    });
    $(document).on('blur','#txtDate2', function(){
//        var table = $('#datatable').DataTable();
//        table.destroy();
        //fetchOrder();
    })
    function fetchOrder(){    
         table = $('#datatable').DataTable({
			"order": [0, 'desc'],
            "bFilter": true,//Initial no order.
			"dom": "<'row border-dark'<'col-sm-2 myselect'l><'col-sm-3 mybtn'B><'#cat.col-sm-2 myselect'><'col-sm-5 'f>>" 
                        + "<'row'<'col-sm-12'i>>" 
                        + "<'row'<'col-sm-12'tr>>" 
                        + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
			"pageLength": 100,
            "lengthMenu": [ [100, 500, 1000, -1], [100, 500, 1000, "All"] ],

		});
       
    }
    
    
     $(document).on('click','#btn_filter11', function(){
         //alert("ram");
                            
         var date_type = $('#datetype').val();
         var dateto = $('#dateto').val();
         var datefrom = $('#datefrom').val();
         var paymentmethod = $('#paymentmethod').val();
         var orderstatus = $('#orderstatus').val();
         var deliverboyname = $('#deliverboyname').val();
         var customername = $('#customername').val();
//         alert(date_type+'-'+dateto+'-'+datefrom+'-'+paymentmethod+'-'+orderstatus+'-'+customername+'-'+deliverboyname);
         
         table = $('#datatable').DataTable({

			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [],
            "bFilter": false,//Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('admin/fetchOrders_by_filter')?>",
				"type": "POST",
                
				"success": function ( data ) {
                    
                    var filter = {};
 
                        filter.date_type = $('#datetype').val();
                        filter.dateto = $('#dateto').val();
                        filter.datefrom = $('#datefrom').val();
                        filter.paymentmethod = $('#paymentmethod').val();
                        filter.orderstatus = $('#orderstatus').val();
                        filter.deliverboyname = $('#deliverboyname').val();
                        filter.customername = $('#customername').val();

                        d.value = filter;

                        //debugger;

                        return JSON.stringify(d);
//					 data.from = $('#txtDate').val();
//					 data.to = $('#txtDate2').val();
                    
                    //$('#datatable_filter').style("display","none");
					// data.LastName = $('#LastName').val();
					// data.address = $('#address').val();
				}
			},

			//Set column definition initialisation properties.
			"columnDefs": [
				{
					"targets": [ 7 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
			],
			
			"pageLength": 100,
              "lengthMenu": [ [100, 500, 1000, -1], [100, 500, 1000, "All"] ],

		});
         
//        var table = $('#datatable').DataTable();
//        table.destroy();
//        fetchOrder();
    })
    
    
$(document).ready(function() {

    $("#dateto").datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        dateFormat: 'dd/mm/yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});

    $(document).ready(function() {

    $("#datefrom").datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        dateFormat: 'dd/mm/yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});
    
    $(document).ready(function() {

    $("#txtDate").datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        dateFormat: 'dd/mm/yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});

    $(document).ready(function() {

    $("#txtDate2").datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        dateFormat: 'dd/mm/yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});
</script>
</html>


<div id="myModal" class="modal fade myModal" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body text-center delivery_boy_details">
			
			</div>
		</div>
	</div>
</div>

<div id="ProductModal1" class="modal fade myModal" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body text-center order_details">
			
			</div>
		</div>
	</div>
</div>


<div class="container d-flex justify-content-center mt-100">
    <!-- Button to Open the Modal --> 
<!--<button type="button" class="btn openmodal" data-toggle="modal" data-target="#modal1"> Click here </button> -->
<!-- The Modal -->
    <div class="modal fade" id="ProductModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ">
                <div id="order_details">
                
                
                </div>
                
            </div>
        </div>
    </div>
</div>



