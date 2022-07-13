<?php  $this->load->view("admin/common/head");
if($this->config->item('currency') == '₹'){
    $currency   =   'INR';
}
else{
    $currency   =   $this->config->item('currency');
}

?>
<link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/dataTables.bootstrap4.min.css"); ?>" rel="stylesheet" />
<style>
	
	
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
					<div class="msg"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Payment Detail");?></h4>
                                    <div class="toolbar">
									<?php 
										if(!empty($UserPlanData->plan) && $UserPlanData->plan == 'Expired'){
									?>
                                            <div class="row">
                                                <div class="col-md-5">
													<?php 
													
													// echo '<strong>Package:</strong> '.$UserPlanData->plan_name.'<br>';
													echo '<strong>'.$this->lang->line("Package").':</strong> '.$UserPlanData->plan_name.'<br>';
													echo '<strong>'.$this->lang->line("Amount").':</strong> '.$UserPlanData->plan_amount.'<br>';
													if(!empty($UserPlanData->plan_discount)){
														// echo '<strong>'.$this->lang->line("Discount").':</strong> '.$UserPlanData->plan_discount.'<br>';
													}
													echo '<strong>'.$this->lang->line("Period").':</strong> '.$UserPlanData->plan_period.' Days<br>';
													echo '<strong>'.$this->lang->line("Your Plan Expire On").':</strong> '.$UserPlanData->plan_expire.'<br>';
													if(!empty($UserPlanData->sub_id)){
														echo '<strong>'.$this->lang->line("Subscription Id").':</strong> '.$UserPlanData->sub_id.'<br>';
													}
													
													// echo '<pre>';
													// print_r($UserPlanData);
													// echo '</pre>';
													// rzp_test_3DN2lsUsAMZz1z	koSgCpjogUIldAsFF1bwzRqf
													
													// $UserPlanData->razorpay_plan_id;
													
													$this->session->set_flashdata('msb_customer_id', $UserPlanData->user_id);
													$this->session->set_flashdata('plan_id', $UserPlanData->razorpay_plan_id);
													$this->session->set_flashdata('plan_id', $UserPlanData->razorpay_plan_id);
													// $UserPlanData->razorpay_plan_id

													?>
												</div>
                                                <div class="col-md-5 pull-right">
												<?php if(empty($UserPlanData->sub_id)){ ?>
												
													<button class="pull-right btn btn-primary" id="pay_btn"><?php echo $this->lang->line("Plan Renewal");?></button>
													
													<?php } ?>
                                                </div>
                                               
                                            </div>
                                    <?php
										}
									?>
									</div>
                                      
                                    <div class="row">
                                        <h4 class="card-title"><?php echo $this->lang->line("Payment Detail List"); ?></h4>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="datatable" class="table table-border table-striped custom-table datatable mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo $this->lang->line("Sr. No."); ?></th>
                                                            <th><?php echo $this->lang->line("User Detail"); ?></th>
                                                            <th><?php echo $this->lang->line("Transaction Id"); ?> </th>
                                                            <th><?php echo $this->lang->line("Product Name"); ?></th>
                                                            <th><?php echo $this->lang->line("Order Amount"); ?></th>
                                                            <th><?php echo $this->lang->line("Order Date"); ?></th>
                                                            <th><?php echo $this->lang->line("Status"); ?></th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if(!empty($UserPaymentData))
                                                            {
                                                                //print_r($UserPaymentData);
                                                                $sr_no=1;
                                                                foreach($UserPaymentData as $payment_detail)
                                                                {
                                                                    //echo $payment_detail->id;
                                                                    if ($payment_detail->status == 1 && !empty(@$payment_detail->transaction_id)) {
                                                                        $status = "<span class='label label-success'>Paid</span>";
                                                                    } else{
                                                                        
                                                                        $status =  "<span class='label label-default'>Failed</span>";
                                                                    } 
                                                            ?>
                                                        <tr>
                                                        <td><?php echo $sr_no; ?></td>
                                                        <td>
														
														<b><?php echo $this->lang->line("Name"); ?></b>: <?php echo $payment_detail->client_name; ?><br>
														<b><?php echo $this->lang->line("Email"); ?></b>: <?php echo $payment_detail->client_email; ?><br>
														<b><?php echo $this->lang->line("Mobile"); ?></b>: <?php echo $payment_detail->client_mobile; ?><br>
														
														</td>
                                                        <td><?php echo @$payment_detail->transaction_id; ?></td>
                                                        <td><?php echo @$payment_detail->product_name; ?></td>
                                                        <td><?php echo @$payment_detail->amount; ?></td>
                                                        <td><?php echo date("d-m-Y", strtotime(@$payment_detail->created_at)); ?></td>
                                                            <td><?php echo @$status; ?></td>
                                                        </tr>
                                                        <?php
                                                              $sr_no++;      
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th><?php echo $this->lang->line("Sr. No."); ?></th>
                                                            <th><?php echo $this->lang->line("User Detail"); ?></th>
                                                            <th><?php echo $this->lang->line("Transaction Id"); ?> </th>
                                                            <th><?php echo $this->lang->line("Product Name"); ?></th>
                                                            <th><?php echo $this->lang->line("Order Amount"); ?></th>
                                                            <th><?php echo $this->lang->line("Order Date"); ?></th>
                                                            <th><?php echo $this->lang->line("Status"); ?></th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
    
                                                       
                                                    </tbody>
                                                </table>
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

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    
<script type="text/javascript">   
function payment_success(paymentid,order_id,sub_id=''){
	$.ajax({
		type: "post",
		url: "<?php echo site_url('index.php/admin/renewal_payment_success')?>",
		data: {paymentid:paymentid,order_id:order_id,sub_id:sub_id},
		dataType: "json",
		success: function (revert) {
			if (revert.response == "success") {
				var order_id  = revert.order_id;
				$('#pay_btn').removeAttr('disabled');
				$('.msg').html('<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> <strong>Success!</strong> '+revert.msg+'</div>');
				setTimeout(function(){
					window.location.reload();
				},2000)			
			}
			else {
				// $('#popupError').removeClass("hidden");
				
			}
		},
		error: function (revert) {
			$('.loading').hide();
		}
	});
}

function razorpay(amount,client_name,mobile_no,client_email,order_id,currency,sub_id){
    if(sub_id){
		var options = {
			// "key": "rzp_test_3DN2lsUsAMZz1z", // Enter the Key ID generated from the Dashboard
			"key": "rzp_test_MFIpVcNYxSzop9", // Enter the Key ID generated from the Dashboard
			"subscription_id": sub_id,
			"amount": amount*100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise or INR 500.
			// "currency": currency,
			"name": "Kart Supermarket",
			"description": "Kart Supermarket",
			"image": "https://www.kriscent.in/landing/free-ecommerce/images/logo.png",
			"receipt": order_id,//This is a sample Order ID. Create an Order using Orders API. 
			"handler": function (response){
				console.log(response);
				var paymentid = response.razorpay_payment_id;
				var sub_id = '';
				var sub_signature = '';
				if(response.razorpay_subscription_id){
					sub_id = response.razorpay_subscription_id;
				}
				payment_success(paymentid,order_id,sub_id);
			},
			"prefill": {
				"name": client_name,
				"email": client_email,
				"contact": mobile_no
			},
			"notes": {
				"address": "note value"
			},
			"theme": {
				"color": "#314e85"
			}
		};
	}   
	else{
		var options = {
			// "key": "rzp_test_3DN2lsUsAMZz1z", // Enter the Key ID generated from the Dashboard
			"key": "rzp_test_3DN2lsUsAMZz1z", // Enter the Key ID generated from the Dashboard
			"amount": amount*100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise or INR 500.
			"currency": currency,
			"name": "Kart Supermarket",
			"description": "Kart Supermarket",
			"image": "https://www.kriscent.in/landing/free-ecommerce/images/logo.png",
			"receipt": order_id,//This is a sample Order ID. Create an Order using Orders API. 
			"handler": function (response){
				console.log(response);
				var paymentid = response.razorpay_payment_id;
				payment_success(paymentid,order_id);
			},
			"prefill": {
				"name": client_name,
				"email": client_email,
				"contact": mobile_no
			},
			"notes": {
				"address": "note value"
			},
			"theme": {
				"color": "#314e85"
			}
		};
	}
	
	var rzp1 = new Razorpay(options);
	rzp1.open();
}  

function pay_btn(subscrib){
	var amount          =   '<?php echo $UserPlanData->plan_amount ?>';  
	var discount        =   '<?php echo $UserPlanData->plan_discount ?>';  
	var client_name     =   '<?php echo $UserPlanData->user_name ?>';   
	var mobile_no       =   '<?php echo $UserPlanData->user_phone ?>';   
	var client_email    =   '<?php echo $UserPlanData->user_email ?>';   
	var product_name    =   '<?php echo $UserPlanData->plan_name ?>';   
	var currency        =   '<?php echo $currency ?>';//;
	var plan_id         =   '<?php echo $UserPlanData->plan_id ?>';
	var language        =   '1';
	var phoneno         =   /^\d{10}$/;
	var reg             =   /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	
	if (client_name == "") {
		$(".msg").html('<div class="alert alert-danger alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"> &times; </span> <span class="sr-only">Close</span></button> <strong>Error!</strong> The name is required</div>');
	}
	else if (mobile_no == "" || mobile_no.length!=10) {
		$(".msg").html('<div class="alert alert-danger alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"> &times; </span> <span class="sr-only">Close</span></button> <strong>Error!</strong> The 10 digit mobile no is required</div>');
	}
	else if(client_email == ''){
		$(".msg").html('<div class="alert alert-danger alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"> &times; </span> <span class="sr-only">Close</span></button> <strong>Error!</strong> The email id is required</div>');
	}
	else if (reg.test(client_email) == false) {
		$(".msg").html('<div class="alert alert-danger alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"> &times; </span> <span class="sr-only">Close</span></button> <strong>Error!</strong> Email id is invalid</div>');
	}
	else if (amount == "") {
		$(".msg").html('<div class="alert alert-danger alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"> &times; </span> <span class="sr-only">Close</span></button> <strong>Error!</strong> The amount is required</div>');
	} 
	else if(plan_id !=0){
		$(this).attr('disabled','disabled'); 
		if(discount && discount>0){
			// amount = amount-discount
		}
		$.ajax({
			type: "post",
			url: "<?php echo site_url('index.php/admin/renewal_payment_insert')?>",
			data: {product_name:product_name,client_name:client_name,mobile_no:mobile_no,client_email:client_email,amount:amount,currency:currency,language:language,plan_id:plan_id,subscrib:subscrib},
			dataType: "json",
			success: function (revert) {
				//ajaxindicatorstop();
				
				if (revert.responce == 'success') {
					var order_id  		  = revert.order_id;
					var sub_id  		  = revert.sub_id;
					$('.msg').html('<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> <strong>Success!</strong> '+revert.msg+'</div>');
					razorpay(amount,client_name,mobile_no,client_email,order_id,currency,sub_id);
					
				}
				else {
					
					$('#pay_btn').removeAttr('disabled');
					
				}
			},
			error: function (revert) {
				//$('.loading').hide();
				$('#pay_btn').removeAttr('disabled');
			}
		});
	}
	else{
		alert("This Plan is not active only for enquiry");
	}
	
	// razorpay('<?php echo $UserPlanData->plan_amount ?>','<?php echo $UserPlanData->user_name ?>','<?php echo $UserPlanData->user_phone ?>','<?php echo $UserPlanData->user_email ?>','<?php echo $UserPlanData->plan_amount ?>','INR');
	
}

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
	
	$(document).on('click','#pay_btn', function(e){
		/*if(confirm('Do you want to subscrib')){
			pay_btn(1)
		}
		else{
			pay_btn(0)
		}*/
		pay_btn(0)
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