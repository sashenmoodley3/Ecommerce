<?php
$marchent_id    =   $this->config->item('marchecnt_id');
$marchent_key   =   $this->config->item('marchent_key');

if($this->config->item('currency') == '₹'){
    $currency   =   'INR';
}
else{
    $currency   =   $this->config->item('currency');
}

?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<div class="col-xs-12 col-sm-9 ">
    <div class="my-account">
        <div class="page-title">
            <h2><?=$this->lang->line("My Wallet")?>
			<button style="display:none;" class="btn btn-primary pull-right" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Recharge Wallet</button>
			</h2>
            <div class="">
                <h5><?=$this->lang->line("Today available Wallet")?> :</h5>
                <p class="text-center"><span class="" style="font-size: 16px;color: #fe7e29;font-weight: 900;"><?=$wallet?>/-</span> </p>
				<div class="msg"></div>
				<?php
				
				// echo '<pre>';
				// print_r($getLoginUserInfo);
				// echo '</pre>';
				
				?>
				
				<div class="collapse" id="collapseExample">
				  <div class="card card-body" style="height: auto;overflow-y: auto;">
					<div class="col-md-6 payment_form">
						<div class="form-selector">
							<label for="update_profile_password_cur"><?=$this->lang->line("Amount")?> :</label>
							<input type="text" class="form-control" name="amount" value="" id="amount">
							
						</div>
						
						<div class="form-selector">
						<label><?=$this->lang->line("Payment Information")?></label>
						<br>
	 
						<?php if(!empty($this->config->item('marchecnt_id')) && $this->config->item('razor_status')==1){ ?>
							<span class="cc-selector">
								<input type="radio" required name="payment_type" value="Razorpay" id="radio_button_6" style="display:none;">
								<label class="drinkcard-cc" style="margin-bottom:0px; width:100px; overflow:hidden; " for="mastercard" onclick="radio_check('radio_button_6')">
									<img src="<?=base_url()?>assets/images/razorpay1.png" width="100%" height="100%" style=" text-align-last:center;" alt="Razorpay">

								</label>
							</span>
						
						<?php } ?>
						<?php /* if(!empty($this->config->item('paypal_id')) && $this->config->item('paypal_status')==1){ ?>
							<span class="cc-selector">
								<input type="radio" required name="payment_type" value="Paypal" id="radio_button_7" style="display:none;">
								<label class="drinkcard-cc" style="margin-bottom:0px; width:100px; overflow:hidden; " for="mastercard" onclick="radio_check('radio_button_7')">
									<img src="<?=base_url()?>assets/images/paypal.jpg" width="100%" height="100%" style=" text-align-last:center;" alt="Razorpay">

								</label>
							</span>
						<?php } */ ?>
						<?php if(!empty($this->config->item('paytm_id')) && $this->config->item('paytm_status')==1){ ?>
							<span class="cc-selector">
								<input type="radio" required name="payment_type" value="Paytm" id="radio_button_8" style="display:none;">
								<label class="drinkcard-cc" style="margin-bottom:0px; width:100px; overflow:hidden; " for="mastercard" onclick="radio_check('radio_button_8')">
									<img src="<?=base_url()?>assets/images/paytm.png" width="100%" height="100%" style=" text-align-last:center;" alt="Paytm">

								</label>
							</span>
						<?php } ?>
		
						</div>
						<div class="form-selector">
							<button class="button" id="pay_btn1"><?=$this->lang->line("Submit")?></button>
							
						</div>
						
					</div>
					<div class="col-md-6 paypay_button">
						<div class="svelte-1ap4ad2 clickforPayment" data-typeid="65" data-typeapp="card" data-payid="8" id="paypal-button-container">
							<div class="ref-text svelte-1ap4ad2"></div>
						</div>
					</div>
					
				  </div>
				</div>
				
            </div>
        </div>
        <div class="wishlist-item table-responsive">
            <h5><?=$this->lang->line("Available Wallet History")?> :</h5>
            <?php if(!empty($wallet_history)):?>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        
                        <th class="th-details"><?=$this->lang->line("Date")?></th>
                        <th class="th-price"><?=$this->lang->line("Cr.")?></th>
                        <th class="th-price"><?=$this->lang->line("Dr.")?></th>
                        <th class="th-details"><?=$this->lang->line("Description")?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //var_dump($user_order_list);
                    foreach ($wallet_history as $key => $value):
                        $transaction = $value->transaction_by;
                        $description = $value->description; //"descrption ....... Details.. Column Info",
                        $debit = $value->dr_id;
                        $credit = $value->cr_id;
                        $created_date = $value->created_date;
                    ?>
                    <tr>
                        <td class="th-product"><?=$created_date?></td>
                        <td class="th-product"><?=$credit?></td>
                        <td class="th-product"><?=$debit?></td>
                        <td class="th-product"><?=$description?></td>
                    </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
            <?php endif;?>
            <div class="cart_navigation">
                <a class="continue-btn" href="{base_url}/shop"><i class="fa fa-arrow-left"> </i>&nbsp; <?=$this->lang->line("Continue shopping")?></a> 
            </div>
			<div class="cart_navigation">
                <a class="checkout-btn" href="{base_url}/checkout"><i class="fa fa-check"></i> <?=$this->lang->line("Proceed to checkout")?></a> 
            </div>
            <!-- <div class="register-benefits">
                <h5><?=$this->lang->line("Mange Profile today and you will be able to")?> :</h5>
                <ul>
                    <li><?=$this->lang->line("Speed your way through checkout")?></li>
                    <li><?=$this->lang->line("Track your orders easily")?></li>
                    <li><?=$this->lang->line("Keep a record of all your purchases")?></li>
                </ul>
            </div> -->
        </div>
    </div>
</div>


<div class="space-50"></div>
<script src="https://www.paypal.com/sdk/js?client-id=<?=$this->config->item('paypal_id')?>&currency=<?=$currency?>" data-sdk-integration-source="button-factory"></script>

<!-- jquery js --> 
<script type="text/javascript" src="{base_url}assets/js/jquery.min.js"></script> 


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

	function paypalpay(amount,order_id){
		paypal.Buttons({
			env: 'sandbox', // sandbox | production
			style: {
			  shape: 'rect',
			  color: '',
			  layout: 'horizontal',
			  label: '',
			  tagline: false
			  
			},
			createOrder: function(data, actions) {
			  return actions.order.create({
				  purchase_units: [{
					  amount: {
						  value: amount
					  }
				  }]
			  });
			},
			onApprove: function(data, actions) {
			  return actions.order.capture().then(function(details) {
				  alert('Transaction completed by ' + details + '!');
				  // payment_success(paymentid,order_id);
			  });
			}
		}).render('#paypal-button-container');
	}

	function razorpay(amount,client_name,mobile_no,client_email,order_id,payment_type){
		var options = {
			"key": "<?=$marchent_key?>", // Enter the Key ID generated from the Dashboard
			"amount": amount*100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise or INR 500.
			"currency": '<?=$currency?>',
			"name": "<?=$this->config->item('name')?>",
			"description": "<?=$this->config->item('tagline')?>",
			"image": "<?=base_url()?>/uploads/company/<?=$this->config->item('logo')?>",
			"receipt": order_id,//This is a sample Order ID. Create an Order using Orders API. (https://razorpay.com/docs/payment-gateway/orders/integration/#step-1-create-an-order). Refer the Checkout form table given below
			"handler": function (response){
				console.log(response);
				 var paymentid   =   response.razorpay_payment_id;
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
				"color": "#ffc107"
			}

		};

		
		var rzp1 = new Razorpay(options);
		rzp1.open();
	}
	
	function payment_success(paymentid,order_id){
		$.ajax({
			type: "post",
			url: "{base_url}payment_success",
			data: {paymentid:paymentid,order_id:order_id},
			dataType: "json",
			success: function (revert) {
				if (revert.status) {
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
	


	$(document).on('click','#pay_btn1', function(e){
			
		e.preventDefault(); //7014282041
		var amount          =   $('#amount').val();  
		var payment_type    =   $('input[name="payment_type"]:checked').val();  
		var client_name     =   "<?php echo $getLoginUserInfo['user_fullname'] ?>";   
		var mobile_no     =   "<?php echo $getLoginUserInfo['user_phone'] ?>";   
		var client_email     =   "<?php echo $getLoginUserInfo['user_email'] ?>";   
		var client_email_encript     =   "<?php echo !empty($getLoginUserInfo['user_email'])? base64_encode($getLoginUserInfo['user_email']) : '' ?>";   
		var phoneno         =   /^\d{10}$/;
		var reg             =   /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		// alert(payment_type)
		
		if (amount == "") {
			$(".msg").html('<div class="alert alert-danger alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"> &times; </span> <span class="sr-only">Close</span></button> <strong>Error!</strong> The amount is required</div>');
		} 
		else if (payment_type == "" || payment_type == undefined) {
			$(".msg").html('<div class="alert alert-danger alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"> &times; </span> <span class="sr-only">Close</span></button> <strong>Error!</strong> Please select payment method</div>');
		}
		else {
			
			// $(this).attr('disabled','disabled'); 
			
			$.ajax({
				type: "post",
				url: "{base_url}recharge_wallet",
				data: {payment_type:payment_type,amount:amount},
				dataType: "json",
				success: function (revert) {
					//ajaxindicatorstop();
					
					if (revert.status) {
						var order_id = revert.order_id;
						$('.msg').html('<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> <strong>Success!</strong> '+revert.msg+'</div>');
						
						if(payment_type == 'Razorpay'){
							razorpay(amount,client_name,mobile_no,client_email,order_id,payment_type);
						}
						else if(payment_type == 'Paypal'){
							paypalpay(amount,order_id);
							$('.payment_form').hide()
							$('.paypay_button').show()
						}
						else if(payment_type == 'Paytm'){
							window.location.href = "{base_url}rechargewalletpaytm/"+encodeURI(order_id)+'/'+encodeURI(amount)
							// razorpay(amount,client_name,mobile_no,client_email,order_id,payment_type);
						}
						
					}
					else {
						
						$('.msg').html('<div class="alert alert-danger alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"> &times; </span> <span class="sr-only">Close</span></button> <strong>Error!</strong> '+revert.msg+'</div>');;
						
					}
					
					// $('.paypay_button').hide()
					// $('.payment_form').show()
				},
				error: function (revert) {
					//$('.loading').hide();
					$('#pay_btn').removeAttr('disabled');
				}
			});
			
		}
		
		// razorpay('<?php echo $UserPlanData->plan_amount ?>','<?php echo $UserPlanData->user_name ?>','<?php echo $UserPlanData->user_phone ?>','<?php echo $UserPlanData->user_email ?>','<?php echo $UserPlanData->plan_amount ?>','INR');
		
	
	})
	$(document).ready(function(){
		$('.paypay_button').hide()
	})
</script>




