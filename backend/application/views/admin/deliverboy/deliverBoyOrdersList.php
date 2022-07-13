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
                                                        <input type="text" id="txtDate" name="fromdate" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:" autocomplete="off">
                                                        <div class="input-group-addon">to</div>
                                                        <input type="text" id="txtDate2" name="todate" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:" autocomplete="off">
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
                                                    <input type="text" id="dateto" name="dateto" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:" value="<?php echo @$post["dateto"];?>" autocomplete="off">
                                                <span class="material-input"></span></div>
                                            </div>
                                        <div class="col-md-3">
                                                <div >
                                                    <label class="label-on-left"><?php echo $this->lang->line("From");?>: </label>
                                                    <input value="<?php echo @$post["fromdate"];?>" type="text" id="datefrom" name="fromdate" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:" autocomplete="off">
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
<!--
                                            <div class="col-md-3">
                                                <div >
                                                    <label class="label-on-left"><?php echo $this->lang->line("deliverBoyname");?>: </label>
                                                    <input value="<?php echo @$post["deliverboyname"];?>" type="text" required name="deliverboyname" id="deliverboyname" class="form-control"  placeholder="Deliver Boy Name"/>
                                                <span class="material-input"></span></div>
                                            </div>
-->
                                            <div class="col-md-3">
                                                <div >
                                                    <label class="label-on-left"><?php echo $this->lang->line("Order Status");?>: </label>
                                                    <select class="text-input form-control" id="orderstatus" name="orderstatus">
                                                        <option value="">--Order Type--</option>
                                                        <option <?php if(@$post["orderstatus"]=="0"){ echo "selected";}?> value="0">Pending Orders</option>
                                                        <option <?php if(@$post["orderstatus"]=="1"){ echo "selected";}?> value="1">Confirm Orders</option>
                                                        <option <?php if(@$post["orderstatus"]=="2"){ echo "selected";}?> value="2">Dispatch Orders</option>
                                                        <option <?php if(@$post["orderstatus"]=="4"){ echo "selected";}?> value="4">Delivered Orders</option>
                                                        <option <?php if(@$post["orderstatus"]=="-1"){ echo "selected";}?> value="-1">Returned Order</option>
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
                                                            <th class="text-left"><?php echo $this->lang->line("Delivery Date"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Customer"); ?></th>
                                                            <!--<th class="text-left"><?php echo $this->lang->line("Order Amount"); ?></th>-->
                                                            <!--<th class="text-left"><?php echo $this->lang->line("Delivery Charge"); ?></th>-->
                                                            <th class="text-left"><?php echo $this->lang->line("Amount"); ?></th>
<!--                                                            <th class="text-left"><?php echo $this->lang->line("User Signature"); ?></th>-->
                                                            <th class="text-left"><?php echo $this->lang->line("Payment Method"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Status"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Delivery Boy"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Action"); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th class="text-left"><?php echo $this->lang->line("Delivery Order"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Date"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Customer"); ?></th>
                                                            <!--<th class="text-left"><?php echo $this->lang->line("Order Amount"); ?></th>-->
                                                            <!--<th class="text-left"><?php echo $this->lang->line("Delivery Charge"); ?></th>-->
                                                            <th class="text-left"><?php echo $this->lang->line("Amount"); ?></th>
<!--                                                            <th class="text-left"><?php echo $this->lang->line("User Signature"); ?></th>-->
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
			//print_r($orders); exit;
			$customer_name = !empty($orders->receiver_name) ? $orders->receiver_name : (!empty($orders->user_fullname)?$orders->user_fullname:'');
			if($orders->free_delivery_amount > $orders->total_amount){
				$order_amount = ($orders->total_amount+$orders->delivery_charge);
			}
			else{
				$order_amount = $orders->total_amount;
			}
            ?>
            
                <tr>
                    <td><?php echo $orders->sale_id; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($orders->order_create_date)); ?></td>
                    <td><?php echo $customer_name; ?></td>
                    <td><?php echo $order_amount; ?></td>
<!--                    $orders->signature-->
<!--                    <td><img src="<?php echo site_url('uploads/signature/'.$signature); ?>" alt="Customer Signature" style="width: 100px; height: 40px;" height="15px;" width="30px;"></td>-->
                    <td><?php echo $orders->payment_method; ?></td>
                    <td><?php echo $status; ?></td>
                    <td><?php echo $boy; ?></td>
                    <td><?php echo '<a  href="'.site_url("admin/orderdetails/". $orders->sale_id).'" class="btn btn-success action-btn-detail" title="Order Details"> 
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


    
<script type="text/javascript">
    function show_modal_view(modal_name,action_id) {
        var BASE_URL = '<?php echo site_url()?>';
        $.get(BASE_URL+"Admin/get_html_assign_deliveryBoy",{ action_id:action_id},function(data){
            $('.user_details').html(data);

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

//			"processing": true, //Feature control the processing indicator.
//			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [],
//             "bFilter": false,//Initial no order.

			// Load data for the table's content from an Ajax source
//			"ajax": {
//				"url": "<?php echo site_url('admin/fetchOrders')?>",
//				"type": "GET",
//                
//				"data": function ( data ) {
//					 data.from = $('#txtDate').val();
//					 data.to = $('#txtDate2').val();
//                    
//                    //$('#datatable_filter').style("display","none");
//					// data.LastName = $('#LastName').val();
//					// data.address = $('#address').val();
//				}
//			},

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
       
    }
    
    
     $(document).on('click','#btn_filter11', function(){
         alert("ram");
                            
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
			<div class="modal-body text-center user_details">
			
			</div>
		</div>
	</div>
</div>
</div>