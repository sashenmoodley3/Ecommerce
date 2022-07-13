<style type="text/css">

.alert-error {
  border-color: #d73925;
  background-color: #ed3237d1 !important;
  color: white;
}

.close{
  color: white;
}

:root {
  --green: #ed3237;
  --active: #3e4095;
}
section.checkout .tab-block .basket-header {
    text-transform: uppercase;
    font-weight: 700;
    color: #555;
    font-size: 0.85em;
    padding: 10px 0;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    font-family: "Poppins",sans-serif;
}
section.checkout .tab-block .item {
    padding: 20px 0;
    border-bottom: 1px solid #ddd;
}
section.checkout .tab-block img {
    max-width: 70px;
}
section.checkout .tab-block .title {
    margin-left: 15px;
}

section.checkout .nav-tabs>li.active>a, 
section.checkout .nav-tabs>li.active>a:hover, 
section.checkout .nav-tabs>li.active>a:focus {
    background: var(--active);
    border: 1px solid var(--active);
    color: #fff;
}
section.checkout .nav-tabs .nav-item.open .nav-link, 
section.checkout .nav-tabs .nav-item.open .nav-link:focus, 
section.checkout .nav-tabs .nav-item.open .nav-link:hover, 
section.checkout .nav-tabs .nav-link.active, 
section.checkout .nav-tabs .nav-link.active:focus, 
section.checkout .nav-tabs .nav-link.active:hover {
    color: #fff;
    background-color: var(--active);
    border-color: var(--active) var(--active) transparent;
}

section.checkout .img-fluid {
    max-width: 100%;
    height: auto;
}
section.checkout .nav-tabs.wizard {
  background-color: transparent;
  padding: 0;
  width: 100%;
  margin: 1em auto;
  border-radius: .25em;
  clear: both;
  border-bottom: none;
}


section.checkout .nav-tabs.wizard li>* {
  position: relative;
  padding: 1em .8em .8em 2.5em;
  color: #999999;
  background-color: #dedede;
  border-color: #dedede;
}

section.checkout .nav-tabs.wizard li.completed>* {
  color: #fff;
  background-color: var(--green);
  border-color: var(--green);
  // border-bottom: none;
}

section.checkout .nav-tabs.wizard li.active>* {
  color: #fff;
  background-color: var(--active);
  border-color: var(--active);
  // border-bottom: none;
}

section.checkout .nav-tabs.wizard li::after:last-child {
  border: none;
}

section.checkout .nav-tabs.wizard > li > a {
  opacity: 1;
  font-size: 14px;
}

section.checkout .nav-tabs.wizard a:hover {
  color: #fff;
  background-color: var(--active);
  border-color: var(--active)
}

section.checkout span.step {
  display: inline-block;
  padding: 10px 0 0 0;
  background: #ffffff;
  width: 35px;
  line-height: 100%;
  height: 35px;
  margin: auto;
  border-radius: 50%;
  font-weight: bold;
  font-size: 16px;
  color: #555;
  margin-bottom: 10px;
  text-align: center;
}
section.checkout .block-body {
    border: 1px solid #ddd;
    padding: 40px 30px;
}
section.checkout ul.order-menu {
    margin-bottom: 0;
}
section.checkout ul.order-menu li {
    padding: 20px 0;
    border-bottom: 1px solid #eee;
}
section.checkout ul.order-menu li {
    padding: 15px 0;
}
section.checkout .tab-block a {
    color: #333;
    text-decoration: none !important;
}

section.checkout .btn.wide, 
section.checkout .wide.btn-template-outlined {
    padding-left: 50px;
    padding-right: 50px;
}
section.checkout .nav-fill .nav-item {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    text-align: center;
}
section.checkout .align-items-center {
    -ms-flex-align: center!important;
    align-items: center!important;
}
section.checkout .d-flex {
    display: -ms-flexbox!important;
    display: flex!important;
}
section.checkout .tab-block a {
    color: #333;
    text-decoration: none !important;
}


section.checkout .CTAs a {
    margin-bottom: 10px;
}


section.checkout .tab-block a {
    color: #333;
    text-decoration: none !important;
}
section.checkout .btn-template-outlined.wide {
    padding-left: 50px;
    padding-right: 50px;
}
section.checkout .CTAs a {
    margin-bottom: 10px;
}
section.checkout .btn-template-outlined {
    border-radius: 50px !important;
    background: none;
    border: 1px solid var(--active) !important;
    color: #666;
}
section.checkout .CTAs {
    margin-top: 40px;
}
section.checkout .btn-template {
    border-radius: 50px !important;
    color: #fff !important;
}
section.checkout .btn-template {
    color: color-yiq(var(--active));
    background-color: var(--active);
    border-color: var(--active);
}
section.checkout ul.order-menu li {
    padding: 20px 0;
    border-bottom: 1px solid #eee;
}
section.checkout .justify-content-between {
    -ms-flex-pack: justify!important;
    justify-content: space-between!important;
}

section.checkout .d-flex {
    display: -ms-flexbox!important;
    display: flex!important;
}
.margin-top-10{
	margin-top:10px ;
}

@media(min-width:992px) {
  section.checkout .nav-tabs.wizard li {
    position: relative;
    padding: 0;
    margin: 4px 4px 4px 0;
    width: 30%;
    float: left;
  }
  section.checkout .nav-tabs.wizard li::after,
  section.checkout .nav-tabs.wizard li>*::after {
    content: '';
    position: absolute;
    top: 0;
    left: 100%;
    height: 0;
    width: 0;
    border: 45px solid transparent;
    border-right-width: 0;
    /*border-left-width: 20px*/
  }
  section.checkout .nav-tabs.wizard li::after {
    z-index: 1;
    -webkit-transform: translateX(4px);
    -moz-transform: translateX(4px);
    -ms-transform: translateX(4px);
    -o-transform: translateX(4px);
    transform: translateX(4px);
    border-left-color: #fff;
    margin: 0
  }
  section.checkout .nav-tabs.wizard li>*::after {
    z-index: 2;
    border-left-color: inherit;
  }
  section.checkout .nav-tabs.wizard > li:nth-of-type(1) > a {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
  }
  section.checkout .nav-tabs.wizard li:last-child a {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
  }
  section.checkout .nav-tabs.wizard li:last-child {
    margin-right: 0;
  }
  section.checkout .nav-tabs.wizard li:last-child a:after,
  section.checkout .nav-tabs.wizard li:last-child:after {
    content: "";
    border: none;
  }
  section.checkout span.step {
    display: block;
  }
  
  
}
#address .box .form-check-label {
	margin-left: 10px;
}
#address .box .form-check {
    height: 200px; 
    border: 1px solid #ddd;
	margin-bottom: 15px;
    margin-top: 0;
	padding: 10px;
}
.main-container {
    min-height: 350px;
}
   </style>
<!-- Main Container -->
<section class="main-container col2-right-layout checkout">
    <div class="main container">

        <?php //print_r($get_cart_product_arr); die;
        if (!empty($get_cart_product_arr)):
        //print_r($get_cart_product_arr[0]['product_id']);
        $pruduct_unit_qty = $get_cart_product_arr[0]['unit_value'];
        $current_qty = $get_cart_product_arr[0]['qty'];
        //$total = $pruduct_unit_qty-$current_qty;
        ?>
        <form id="frm_checkout" action="<?=base_url()?>place_order" method="post">
          <div class="row">
            <div class="col-main col-lg-8 col-md-8 col-sm-12 col-xs-12">
				    <div class="page-content checkout-page">
				  <ul class="nav nav-tabs nav-fill wizard" id="myTab" role="tablist">
					<li class="nav-item active">
					  <a style="padding:9px;" href="#home" class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" onclick="ResetWalletCouponValues()">1. Products</a>
					</li>
					<li class="nav-item">
					  <a style="padding:9px;" href="#profile" class="nav-link" id="profile-tab" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false" onclick="ResetWalletCouponValues()">2. Address</a>
					</li>
					<li class="nav-item">
					  <a style="padding:9px;" href="#contact" class="nav-link" id="contact-tab" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false">3. Payment</a>
					</li>
				  </ul>
				  <div class="tab-content" id="myTabContent">
					<div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab"><div class="tab-content">
					  <div id="order-review" class="tab-block">
                          <?php
                          if (!empty(form_error('minimum_order'))) { ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Wrong!</strong> 
                                    <?php
                                        echo form_error('minimum_order');
                                        //echo $this->session->flashdata('place_order_detalis');
                                    ?>
                            </div>
                        <?php
                        }
               ?>
						<div class="cart">
						  <div class="cart-holder">
							<div style="margin-top: 15px" class="basket-header">
              <p style="margin:0px; text-align: center;">Your Cart</p> 
							  <!-- <div class="row">
								<div class="col-md-6"><?=$this->lang->line("Product")?></div>
                                  <div class="col-md-2"><?=$this->lang->line("Unit Price")?></div>
								  <div class="col-md-2"><?=$this->lang->line("Quantity")?></div>
                                  <div class="col-md-2"><?=$this->lang->line("Price")?></div>
							  </div> -->
							</div>
							<div class="basket-body">
                            <?php
                                
              
            $total_order_price = 0;
            $total_tax_price = 0;
            foreach ($get_cart_product_arr as $key => $product) {
                $qty                    = $product['buy_qty'];
                $product_id             = $product['product_id'];
                $product_varient_id     = $product['varient_id'];
                $product_name           = $product['product_name'];
                $product_description    = $product['product_description'];
                 
                
                $pro1                   = explode(',', $product['product_image']);
                $product_image          = $product_img_url. $pro1[0];
                
                $category_id            = $product['category_id'];
                $in_stock               = $product['in_stock'];
                $mrp                    = $product['mrp'];
                $unit_value             = $product['unit'];
                $unit                   = $product['qty'];
                $increament             = $product['increament'];
                $rewards                = $product['rewards'];
                $tax                    = $product['tax'];
                $product_price          = $product['price'];
                $mrp                    = $product['mrp'];
                $q_variants             = $this->db->query("Select * from product_varient where product_id = '".$product_id."' AND varient_id='".$product_varient_id."'")->row();
                if (!empty($q_variants->pro_var_images)) {
                    $product_image  = base_url().'backend/uploads/products/'.$q_variants->pro_var_images;
                }
                //echo $this->session->userdata('price');
                
                // $unit                   = $this->session->userdata('unit');
                // $product_price          = $this->session->userdata('price');
                // $unit_value             = $this->session->userdata('unit_value');
                
                
                //$total_product_price = $product_price * $qty;
                // $total_order_price += $total_product_price;
                
                //$q = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id = '".$product_varient_id."'");
                
                $q = $this->db->query("SELECT deal_price FROM deal_product WHERE product_id = '".$product_id."' AND pro_var_id = '".$product_varient_id."' AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                                        AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
                $del_price = $q->row();
                
                if (!empty($del_price)) {
                    $product_price          = $del_price->deal_price;
                    $difference_price       = $mrp - $del_price->deal_price;
                    $total_product_price    = $product_price * $qty;
                    $total_order_price      += $total_product_price;
                    $single_price           =   $product_price;
                } else {
                    $product_price = $product_price;
                    $difference_price       = $mrp - $product_price;
                    $total_product_price = $product_price * $qty;
                    $total_order_price += $total_product_price;
                    $single_price           =   $product_price;
                    $total_tax_price += (($tax / 100) * $product_price) * $qty;//(($tax * $product_price) / 100) * $qty;
                }
                //echo $unit.' >> '.$unit_value;
                $qty_in_kg = $unit;
                $unit_in_kg = $unit_value;
                if (($unit_value == "gram") || ($unit_value == "gm") || ($unit_value == "GM")) {
                    $qty_in_kg = ($unit) / 1000;
                    $unit_in_kg = "Kg";
                }
                
                $product_price          =   number_format((float)$product_price, 2, '.', '');
                $mrp                    =   number_format((float)$mrp, 2, '.', '');
                $total_product_price    =   number_format((float)$total_product_price, 2, '.', '');
                $saveprice              +=   $difference_price*$qty;
                $q_slug                 =   $this->db->query("SELECT product_slug FROM products WHERE product_id = '".$product_id."'")->row();
                $product_slug           =   $q_slug->product_slug;
                $productUrl             =   $this->config->item('base_url')."product/". $product_slug; ?>
							  <!-- Product-->
							  <div class="item row d-flex align-items-center">
								<div class="col-md-6">
								  <div class="d-flex align-items-center">
									<img src="<?=$product_image; ?>" alt="..." class="img-fluid" >
									<div class="title"><a href="<?=$productUrl; ?>">
										<h6><?=ucfirst($product_name); ?></h6></a>
									</div>
								  </div>
								</div>
								<div class="col-md-2"><span><?=$this->config->item('currency')." ".$product_price; ?></span></div>
								<div class="col-md-2"><span><?=$qty; ?></span></div>
								<div class="col-md-2"><span><?=$this->config->item('currency')." ".$total_product_price; ?></span></div>
							  </div>
							  <?php
            }
              //$total_order_price = $total_order_price + $total_tax_price;
              $total_order_price    =   number_format((float)$total_order_price, 2, '.', '');
              $total_tax_price =   number_format((float)$total_tax_price, 2, '.', '');
              $total_order_price1 = $total_order_price;
              $get_cart_product_arr = $get_cart_product_arr;
                                ?>
							</div>
						  </div>
						  <div style="padding:10px; text-align: center;" class="total row">
                <span class="col-md-10 col-2"><?=$this->lang->line("Total")?></span>
                <span ><?=$this->config->item('currency')." ".$total_order_price;?></span>
               </div>
						</div>
					 
					  </div>
					</div>
						
						<div >
							<a href="<?php echo "{base_url}home" ?>" class="btn btn-template-outlined wide">
								<i class="fa fa-angle-left"></i> Back
							</a>
							<a style="float:right;" href="javascript:void(0);" data-href="#profile" class="btn btn-template wide next">
								Next <i class="fa fa-angle-right"></i>
							</a>
						</div>
						
					</div>
                      

					<div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						<div class="tab-content">
						  <div id="address" class="active tab-block">
							<div class="block-header mb-5">
								<h6>Shipping Address | Change </h6>
							</div>
						  <div class="box" style="border: 1px solid;padding: 20px;">
						  <div class="row">
                          <?php
                            if (is_array($getLoginUserAddresses)) {
                                //var_dump($getLoginUserAddresses);

                                $defaultAddressKey = "";
                                foreach ($getLoginUserAddresses as $key => $value) {
                                  if ($value->default_address==1){
                                    $defaultAddressKey = $key;
                                  }
                                } 

                                $v = $getLoginUserAddresses[$defaultAddressKey];
                                unset($getLoginUserAddresses[$defaultAddressKey]);
                                $getLoginUserAddresses[$defaultAddressKey] = $v;

                                foreach ($getLoginUserAddresses as $key => $value) {
                                  //  if($value->default_address==1)
                                 // {
                                    $location_id = $value->location_id;
                                    $house_no = $value->house_no;
                                    $receiver_name = $value->receiver_name;
                                    $receiver_mobile = $value->receiver_mobile;
                                    $delivery_charge = $value->delivery_charge;
                                    $free_delivery_amount = $value->free_delivery_amount;
                                    $pincode         = $value->pincode;
                                    $default_address         = $value->default_address;
                                    $delivery_days = $value->delivery_days;
                                 // }
                                  ?>
							<div class="col-md-4">
								<div class="form-check">
								  <input class="form-check-input shipping_address" type="radio" name="shipping_address" id="shipping_address<?=$location_id; ?>" value="<?=$location_id; ?>" <?php if ($value->default_address==1) {
    echo "checked";
} ?>  />
									<input type="hidden" name="free_delivery_amount" id="free_delivery_amount<?= $location_id ?>" value="<?=$free_delivery_amount; ?>">
								  <label class="form-check-label" for="shipping_address<?=$location_id; ?>" > <i class="primary"></i>
												   
										<?=$this->lang->line("Name")?> : <span><?=ucfirst($receiver_name); ?></span><br>
										<?=$this->lang->line("Address")?> : <span><?=ucfirst($house_no); ?></span><br>
										<?=$this->lang->line("Mobile No.")?> : <span><?=$receiver_mobile; ?></span><br>
										<?=$this->lang->line("Pincode")?> : <span><?=$pincode; ?></span><br>
										
										<?=$this->lang->line("Delivery Charges")?> : <?=$this->config->item('currency'); ?><span id="shipcharges_<?=$location_id; ?>"><?=$delivery_charge; ?></span> <br>

								   </label>
												   
								</div>
							</div>
                              <?php
                                }
                            }
                              ?>
						 </div>
                              
<!--
                            <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style="    margin-left: 20px;/* padding: 8px; */
						   margin-top: 66px;  background-color: #3e4095; color: white;">Add New Address</button>
-->
                              
						   <button id="address_form_btn" data-event="click" data-target="#address_form" type="button" class="btn" data-toggle="modal"  data-whatever="@mdo" style="    margin-left: 20px;/* padding: 8px; */
						   margin-top: 66px;  background-color: #3e4095; color: white;"><?=$this->lang->line("Add New Address")?></button>
                              
						  
						</div>
						</div>
					</div>
					<div style="margin-top: 15px;">
						<a href="javascript:void(0);" data-href="#home" class="btn btn-template-outlined wide prev" onclick="ResetWalletCouponValues()">
							<i class="fa fa-angle-left"></i> Back 
						</a>
						<a style="float:right;" href="javascript:void(0);" data-href="#contact" class="btn btn-template wide next">
							Next <i class="fa fa-angle-right"></i>
						</a>
					</div>
					
					</div>

					<div  class="tab-pane" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <?php
//                    echo $this->session->flashdata('place_order_detalis');
//                    echo $this->session->flashdata('minimum_order');
                    
                        echo form_error('_order_limitation_validation');
//                        echo form_error('minimum_order');
                        if (!empty(form_error('minimum_order'))) { ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Wrong!</strong> 
                                    <?php
                                        echo form_error('minimum_order');
                                        //echo $this->session->flashdata('place_order_detalis');
                                    ?>
                            </div>
                        <?php
                        }
                               
                    $delivery_date = '';
                    if (!empty($this->config->item("delivery_date_after_days"))) {
                        $delivery_date_after_days = $this->config->item("delivery_date_after_days");
                        $delivery_date = date('d-m-Y', strtotime('+'.$delivery_date_after_days.' days'));
                    }

                ?>
                        <?php if ($this->config->item('time_slot') == 1) { ?>
                <div style="margin-top:35px;" class="row">
                    <div class="col-md-6">
                        <label for="first_name" class="required" aria-required="true"><?=$this->lang->line("Select Delivery Date")?> *</label>
                        <input id="shipping_date" name="shipping_date" required="" class="input form-control valid"  aria-required="true" aria-invalid="false" readonly="" >
                        <?=form_error('shipping_date');?>
                        <!--onchange="document.getElementById('view_shipping_date').innerHTML = document.getElementById('shipping_date').value"-->
                        <input type="hidden" name="timefrom" id="timefrom" value="<?=$shopclosetime->from_time;?>">
                        <input type="hidden" name="timeto" id="timeto" value="<?=$shopclosetime->to_time;  ?>">
                        <input type="hidden" name="fdate" id="fdate" value="<?=$shopclosetime->date;?>">
                        <input type="hidden" name="cdate" id="cdate" value="<?=date('Y-m-d');?>">
                        <input type="hidden" name="dlch" id="dlch" value="">
                    </div>
                    <div class="col-sm-6" >
                      <label for="last_name" class="required" aria-required="true"><?=$this->lang->line("Select Delivery Time")?> *</label>
                      <select  id="shipping_time_from" name="shipping_time_from" class="form-control valid selecttime" style="height: auto;" aria-required="true" aria-invalid="false">
                        <option value="" selected=""><?=$this->lang->line("Select Delivery Time")?></option>
                      </select>
        			  <p id="show_closingerror" style="color: red; font-size: 13px; font-weight: 800;"> </p>
                      <?=form_error('shipping_time_from');?>
                    </div>
                                      
                </div>
                <?php } else { ?>
                    <input type="hidden" id="shipping_date" name="shipping_date" required="" class="input form-control valid"  aria-required="true" aria-invalid="false" readonly="" value="<?=date('d-m-Y')?>" >
                    <input type="hidden" id="shipping_time_from" name="shipping_time_from" required="" class="input form-control valid"  aria-required="true" aria-invalid="false" readonly=""  value="<?=date('H:i').'-'.date('H:i')?>">
                <?php }?>
						<div id="headingTwo">
						  <ul>
                                    <?php if ($this->config->item('cod_status')== 1) { ?>
                                    <li class="cc-selector col-sm-3">        
                                        <input checked="checked" type="radio" name="payment_type" value="Cash On Delivery" id="radio_button_5">
                                        <label class="drinkcard-cc" style="margin-bottom:0px; width:100%; overflow:hidden; " for="mastercard" onclick="radio_check('radio_button_5')">
                                            <img src="<?=base_url()?>assets/images/cash.jpg" width="100%" height="100%" style=" text-align-last:center;" alt="Cash On Delivery">
                    
                                        </label>
                                    </li>
                                    <?php } ?>
                                    <?php if (!empty($this->config->item('marchecnt_id')) && $this->config->item('razor_status')==1) { ?>
                                    <li class="cc-selector col-sm-3">        
                                        <input type="radio" required name="payment_type" value="Razorpay" id="radio_button_6">
                                        <label  class="drinkcard-cc" style="margin-bottom:0px; width:100%; overflow:hidden; " for="mastercard" onclick="radio_check('radio_button_6')">
                                            <img src="<?=base_url()?>assets/images/razorpay1.png" width="100%" height="100%" style=" text-align-last:center;" alt="Razorpay">
                    
                                        </label>
                                    </li>
                                    <?php } ?>
                                    <?php if (!empty($this->config->item('paypal_id')) && $this->config->item('paypal_status')==1) { ?>
                                    <li class="cc-selector col-sm-3">        
                                        <input type="radio" required name="payment_type" value="Paypal" id="radio_button_7">
                                        <label class="drinkcard-cc" style="margin-bottom:0px; width:100%; overflow:hidden; " for="mastercard" onclick="radio_check('radio_button_7')">
                                            <img src="<?=base_url()?>assets/images/paypal.jpg" width="100%" height="100%" style=" text-align-last:center;" alt="Razorpay">
                    
                                        </label>
                                    </li>
                                    <?php } ?>
                                 <?php if (!empty($this->config->item('paytm_id')) && $this->config->item('paytm_status')==1) { ?>
                                    <li class="cc-selector col-sm-3">        
                                        <input type="radio" required name="payment_type" value="Paytm" id="radio_button_8">
                                        <label class="drinkcard-cc" style="margin-bottom:0px; width:100%; overflow:hidden; " for="mastercard" onclick="radio_check('radio_button_8')">
                                            <img src="<?=base_url()?>assets/images/paytm.png" width="100%" height="100%" style=" text-align-last:center;" alt="Paytm">
                    
                                        </label>
                                    </li>
                                <?php } ?>
                                </ul>
						</div>
                        <div class="clearfix"></div>
                        
						
                      <?php
                        
    if (!empty($del_price)) {
        $product_price = $del_price->deal_price;
        $total_product_price = $del_price->deal_price * $qty;
        $existing_wallet_amount = $getWalletOnCheckout['existing_wallet_amount'];
        $remaing_wallet_amount = $getWalletOnCheckout['remaing_wallet_amount'];
        $used_wallet_amount = $getWalletOnCheckout['used_wallet_amount'];
        //$existing_cart_amount = $total_product_price;
        //$existing_cart_amount = $total_order_price;
        //echo "enter";
        if ($delivery_charge > 0 &&  $total_order_price<$free_delivery_amount) {
            $existing_cart_amount  = $total_order_price+$delivery_charge;
            $total_order_price  = $total_order_price+$delivery_charge;
            $shipping_charges = $delivery_charge;
        } else {
            $existing_cart_amount = $total_order_price;
            $shipping_charges = "0.00";
        }
         
        $remaing_cart_amount = $total_product_price-$used_wallet_amount;
    } else {
        $existing_wallet_amount = $getWalletOnCheckout['existing_wallet_amount'];

        $remaing_wallet_amount = ($getWalletOnCheckout['remaing_wallet_amount'] - $delivery_charge >= 0) 
        ? $getWalletOnCheckout['remaing_wallet_amount'] - $delivery_charge 
        : $getWalletOnCheckout['remaing_wallet_amount'];

        $used_wallet_amount = ($getWalletOnCheckout['used_wallet_amount'] + $delivery_charge <= $existing_wallet_amount) 
        ? $getWalletOnCheckout['used_wallet_amount'] + $delivery_charge 
        : $getWalletOnCheckout['used_wallet_amount'];
        //$existing_cart_amount = $getWalletOnCheckout['existing_cart_amount'];
        //$remaing_cart_amount = $getWalletOnCheckout['remaing_cart_amount'];
         
        // echo $delivery_charge."-".$total_order_price."-".$free_delivery_amount;
         
        if ($delivery_charge > 0 &&  $total_order_price<$free_delivery_amount) {
//            $existing_cart_amount  = $total_order_price+$delivery_charge;
            $existing_cart_amount  = $total_order_price + $total_tax_price + $delivery_charge;
            $total_order_price  = $total_order_price+$delivery_charge;
            //$remaing_cart_amount = $getWalletOnCheckout['remaing_cart_amount']+$delivery_charge;
            $remaing_cart_amount = $getWalletOnCheckout['remaing_cart_amount'] + $delivery_charge;
            $shipping_charges = $delivery_charge;
        } else {
            $existing_cart_amount = $total_order_price + $total_tax_price;
            $remaing_cart_amount = $getWalletOnCheckout['remaing_cart_amount'];
            $shipping_charges = 0;
        }
         
         
        //  echo "ddasd".$existing_wallet_amount."--111--".$remaing_wallet_amount."--222--".$used_wallet_amount."--333--".$existing_cart_amount."---444--".$remaing_cart_amount; die;
    }
      
             $final_order_price  = $total_order_price + $total_tax_price;
             $get_cart_product_arr = $get_cart_product_arr;
       
    ?>
                    <div class="well well-wallet" >
      <h4>Wallet </h4>
      <div>
          <table width="100%">
              <tr>
                <td class="wallet-check">
                    <input type="checkbox" id="shipping_wallet" class="form-control wallet" name="shipping_wallet_allow" data-existing-cart-amount ="<?= $existing_cart_amount ?>" data-remaing-cart-amount ="<?= $remaing_cart_amount ?>"
                               data-used-wallet-amount ="<?= $used_wallet_amount ?>" value="<?= $used_wallet_amount ?>" style="width: auto; float: left; margin: 5px 5px 5px 0px; height: 15px;" aria-required="true">
                    <span  style="font-size:11px;"><?=$this->lang->line("Wallet Amount")?>: <?=$this->config->item('currency') ?> <?= $existing_wallet_amount ?></span>
                    <!-- <span id="remaining_wallet" class="view_wallet_info" style="display:none;font-size:11px;"><br/><?=$this->lang->line("Remaing Wallet")?> : <?=$this->config->item('currency') ?> <?= $remaing_wallet_amount ?></span> -->
                    </br><span id='remain_wallet' class="view_wallet_info" style="display:none;font-size:11px;"></span>
                    <input type="hidden" id='existing_wallet_amount' name="existing_wallet_amount" value="<?= $existing_wallet_amount ?>"/>
                    <input type="hidden" id="final_shipping_charges" value="<?= $shipping_charges ?>"/>
                    <input type="hidden" id="remaining_wallet_amount" name="remaing_wallet_amount" value="<?= $remaing_wallet_amount ?>"/>
                    <input type="hidden" name="used_wallet_amount" id="used_wallet_amount" value="<?= $used_wallet_amount ?>"/>
                    <input type="hidden" id="existing_cart_amount" name="existing_cart_amount" value="<?= $existing_cart_amount ?>"/>
                    <input type="hidden" name="remaing_cart_amount" id="remaing_cart_amount" value="<?= $remaing_cart_amount ?>"/>
                    <input type="hidden" id="coupan_amount_use" name="coupan_amount_use" value="0"/>
                </td>
                <!-- <td class="price"><strong><?=$this->config->item('currency') ?> (<?= $final_order_price ?>) </strong></td> -->
                
            </tr>
            <tr>
                
                <td class="wallet-check"><strong><?=$this->lang->line("Total")?></strong></td>
                <td class="price"><strong><?=$this->config->item('currency') ?> <span id="total_amount" class="existing_cart_amount"><?= number_format((float)($final_order_price), 2, '.', '') ?></span></strong></td>
            </tr>
          </table>
      </div>
  </div>
                        <div style="margin-top:15px;">
                    <a href="javascript:void(0);" data-href="#profile" class="btn btn-template-outlined wide prev" onclick="ResetWalletCouponValues()">
                      <i class="fa fa-angle-left"></i> Back
                    </a>

                    <?php
                      $isQtyStockCorrect = 1;

                      foreach ($get_cart_product_arr as $key => $product) {
                        $qty                    = intval($product['buy_qty']);
                        $stockQty               = intval($product['stock_inv']);

                        if ($qty > $stockQty) {
                          $isQtyStockCorrect = 0;
                        }
                        
                      }
                      
                    ?>
                            <input style="float:right;" type="submit" name="" class="btn btn-template wide" onclick="validatePayDetails(<?php echo htmlspecialchars(json_encode($get_cart_product_arr));?>, <?=$this->config->item('minmum order amount');?>, <?=$isQtyStockCorrect?>)" value="Pay">
                            
						</div>
					</div>
                      <div class="clearfix"></div>
				</div>
        
				</div>
			</div>
              
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-bottom:40px">
            <div class="block-body order-summary">
              <h6 class="text-uppercase">Order Summary</h6>
                <div class="margin-bottom-5"><?=$this->lang->line("Have a voucher code")?></div>
                <div class="margin-bottom-5 text-primaries appled_coupan" style="display:none"></div>
                <div class="input-group">
                    <input type="hidden" id="coupanapplyedid" name="coupanapplyedid" value="">
                    <input type="text" style="height: 34px;text-transform: uppercase;" class="form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" qa="enterCodeCKO" ng-model="input.voucher_code" placeholder="Enter voucher code" ng-disabled="is_voucher_applied"  style="">
                    <span class="input-group-btn">
                        <a class="btn btn-default btn-voucher" qa="applyBtnCKO" type="submit">
                            <span style="letter-spacing: .5px; font-size: 11px;" id="applyCoupan" class="ng-binding"><?=$this->lang->line("APPLY")?></span>
                        </a>
                    </span>
                </div>
                <div class="margin-top-10">
					<!-- <div class="pull-left">
					<?=$this->lang->line("Voucher Discount")?>
					</div>
					<div class="pull-right">
					<span >
                        <a class="btn btn-default btn-voucher" onClick="showVoucherList()" qa="vouchDiscCKO" style="text-decoration: underline; cursor:pointer">
                            <span><?=$this->lang->line("Apply Voucher")?></span>
                        </a>
                    </span>
                    </div> -->
					<div class="clearfix1"></div>
				</div>
                 
            <!-- <hr/> -->
              <!--<p>Shipping and additional costs are calculated based on values you have entered</p>-->
              <ul class="order-menu list-unstyled">
                <li class="d-flex justify-content-between" id="subtotal"><span><?=$this->lang->line("Order Subtotal")?> </span><strong><?=$this->config->item('currency');?> <span id="final_total_order_price"><?=$total_order_price1;?></span></strong></li>
                  
                <li class="d-flex justify-content-between" id="subtotal"><span><?=$this->lang->line("Shipping and Handling")?></span><strong><span  id="chk_final_shipping_charges">
                           
                            <?php
                                if ($delivery_charge > 0 &&  $total_order_price<$free_delivery_amount) {
                                    echo $this->config->item('currency')." ".number_format((float)$delivery_charge, 2, '.', '');
                                } else {
                                    echo $this->lang->line("FREE");
                                }
//                            $final_order_price  = $total_order_price;
                            $final_order_price    =   number_format((float)$final_order_price, 2, '.', '');
                               
                            ?>
                        
                        
                        </span></strong></li>
                <li class="d-flex justify-content-between" id="vouchDiscCKO"><span><?=$this->lang->line("Voucher Discount")?></span><strong ><?=$this->config->item('currency');?> <span id="evoucher_credit_amount">0.00</span></strong></li>
               <li class="d-flex justify-content-between"><span>VAT</span><strong><?=$this->config->item('currency');?> <span id="evoucher_credit_amount"><?=$total_tax_price;?></span></strong></li>
                <li class="d-flex justify-content-between"><span><?=$this->lang->line("Total Amount Payable")?></span><strong class="text-primary price-total"><?=$this->config->item('currency');?><span id="final_total_price"><?=$final_order_price;?></span>
                            <span id="save_price"><script>document.getElementById("save_price").innerHTML = document.getElementById("saveprice").value</script></span></strong></li>
              </ul>
              <label style="text-align:center; margin-top:10px; margin-bottom:0px;">By Purchasing products i aggree to the 
                            		 <a style="color:#d9534f; font-style: italic;" href="<?=base_url()?>faq" target="_blank">Purchase Conditions</a></label>
            </div>
          </div>
          </div>
        </form>
        
        

        <?php
        else:
            $this->load->view('home/page/checkout.section/template.empty_cart.php');
        endif;
        ?>
        
    </div>
</section>

 <div class="modal fade" id="address_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="<?php if (!empty($this->session->flashdata('shipping_address'))) {
            echo 'false';
        } else {
            echo 'true';
        } ?>">
						 <div class="modal-dialog" role="document">
                             <form action="<?=base_url().'add_address'?>" id="addAddressFrm" method="post" accept-charset="utf-8" novalidate="novalidate">
							<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add  Address</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
                            <?php
                            if (!empty($this->session->flashdata('shipping_address'))) { ?>
                            
							<?php
                                echo $this->session->flashdata('shipping_address');
                            ?>
                               
                        <?php
                            unset($_SESSION['shipping_address']);}
                    ?>
                                 <?php echo form_error('process_login'); ?>
							  <div class="form-group">								
                                  <label for="address_user_name"><?=$this->lang->line("Name")?><span class="required">*</span></label>
                                  <?php echo form_error('address_user_name'); ?>
								<input id="address_user_name" required name="address_user_name"  value="{address_user_name}" type="text" class="form-control" >
							  </div>
							  <div class="form-group">
								<label for="address_mobile_no"><?=$this->lang->line("Mobile No.")?><span class="required">*</span></label>
                                  <?php echo form_error('address_mobile_no'); ?>
								<input id="address_mobile_no" required type="number" maxlength="10" pattern="\d{10}" class="form__input mobileNumberClass mobileNumber" autofocus="" name="address_mobile_no"  value="{address_mobile_no}"> 
							  </div>
							  <div class="form-group">
								<label for="address_pincode"><?=$this->lang->line("Pincode")?></label>
                                <?php echo form_error('address_pincode'); ?>
								 <input id="address_pincode" type="number" class="form-control" name="address_pincode"  value="{address_pincode}"  maxlength="6" pattern="\d{6}" class="form__input mobileNumberClass mobileNumber" autofocus="">
							  </div>
                 <!-- ----------------------------------------------------------------- -->
                 <div class="row">	
                  <div class="col-md-4">
                      <label>Map Value Latitude<span class="required">*</span></label>
                      <input id="address_lat" required class="form__input mobileNumberClass mobileNumber" autofocus="" class="form-control" name="address_lat" value="<?=$location->lat?>">
                  </div>
                  <div class="col-md-4">
                      <label>Map Value Longitude<span class="required">*</span></label>
                      <input id="address_lang" required class="form__input mobileNumberClass mobileNumber" autofocus="" class="form-control" name="address_lang" value="<?=$location->lang?>">
                  </div>
                  <div class="col-md-4">
                      <button style="margin-top:24px; background:#314E85;" name="getcord" class="button" onclick="locate()" ><span>Get Map Values</button>
                  </div>
                </div>
                <!-- ----------------------------------------------------------------- -->
							  <div class="form-group">
								<label for="address_address"><?=$this->lang->line("Address")?><span class="required">*</span></label>
                                <?php echo form_error('address_address'); ?>
								 <textarea  class="form-control" required name="address_address" rows="10">{address_address}</textarea>
							  </div>
                                
                                <div class="form-group">
								<label for="default_address"><?=$this->lang->line("Default Address")?></label>
                                <input type="checkbox" <?php echo !empty($location->default_address)? 'checked' : ''; ?> class="form-control default_address" name="default_address" value="1" style="width: auto; float: left; margin-right: 10px; margin: 0px 7px 0px 0px; background: transparent; display: inherit; box-shadow: none;">
							  </div>
							
						  </div>
						  <div class="modal-footer">
                              <button class="btn btn-primary" title="Add Address" type="submit"><span><?=$this->lang->line("Add Address")?></span></button>
<!--							<button type="button" class="btn btn-primary">Add Address</button>-->
						  </div>
						</div>
                                 </form>
							</div>
							</div>
<?php
//if (isset($add_address)) {
//    $this->load->view($add_address);
//}
?>

<script>
  var isCouponUsed = false; 
</script>

<script>

  function ResetWalletCouponValues (){
    debugger;
    if ($(".removecoupans").html() !== undefined) {
      $(".removecoupans").trigger('click')
    } else {
      if ($("#shipping_wallet").is(":checked")) {
                    $("#shipping_wallet").trigger('click')
                } 
    }
  }

     function locate(e){
        event.preventDefault();
        if ("geolocation" in navigator){
            navigator.geolocation.getCurrentPosition(function(position){ 
                var currentLatitude = position.coords.latitude;
                var currentLongitude = position.coords.longitude;

                $("#address_lat").val(currentLatitude);
                $("#address_lang").val(currentLongitude);
            });
        }
    }

    function validatePayDetails(stockRes, e, isQtyValid){
      debugger;

      if(isQtyValid === 0) {
        $.notify({
                    	message: 'You have selected more than the max stock for an item(s)'
                    },{
                    	type: 'error',
                    	placement: {
                    		from: "top",
                    		align: "right"
                    	},
                    });
           event.preventDefault();
      }


      if ($('#shipping_time_from').val() === "") {
        $('#show_closingerror').html('Please select delivery time');
        event.preventDefault();
      } else {
        $('#show_closingerror').html('');
      }

      if (parseInt($('#existing_cart_amount').val()) < e) {
         $.notify({
                    	message: 'Minimum value is R ' + e
                    },{
                    	type: 'error',
                    	placement: {
                    		from: "top",
                    		align: "right"
                    	},
                    });
           event.preventDefault();
      }  

    }
</script>

<script type="text/javascript">
	$(".wizard li").on('click', function () {
		$(this).prevAll().removeClass("active").addClass("completed");
		$(this).removeClass("completed").addClass("active");
		$(this).nextAll().removeClass("completed active");
		$('.tab-pane').removeClass("active");
		var tab_href = $(this).find('.nav-link').attr('href')
		// alert(tab_href)
		$(tab_href).addClass("active");
	});
	$(".next,.prev").on('click', function () {
		var tab_href1 = $(this).data('href')
		$('.nav-tabs a[href="'+tab_href1+'"]').parent().trigger('click')
	});

</script>
<script>
    $(document).on('change','.shipping_address', function(){
        debugger;
        var locationid = $(this).val();
        

        var preDeliveryValue = $('#chk_final_shipping_charges').html().replace(/\s/g,'').substring(1);

        if (preDeliveryValue.includes("FREE") || preDeliveryValue.includes("REE")) {
          var preDeliveryAmount = 0;
        } else {
          var preDeliveryAmount = preDeliveryValue
        }


        var used_wallet_amount = parseFloat($('#used_wallet_amount').val());
        var order_total = parseFloat($('#existing_cart_amount').val());
        var free_delivery_amount               =   parseFloat($('#free_delivery_amount'+locationid).val()); 
        var coupan_amount_use               =   parseFloat($('#coupan_amount_use').val());

        var shipping_charges    =  parseFloat($('#shipcharges_'+locationid).html());
                
        if(shipping_charges > 0 &&  order_total < free_delivery_amount){
            var total               =   parseFloat($('#existing_cart_amount').val());
            if ($("#shipping_wallet").is(":checked")) {
                 total               =  parseFloat($('#remaing_cart_amount').val());
                if(coupan_amount_use>0)
                {
                    total = total-coupan_amount_use;
                }
            }
            else{
                var total =   parseFloat($('#existing_cart_amount').val());
            }
            
            if(shipping_charges>0)
            {
                 var calShipCost = parseFloat($('#shipcharges_'+locationid).html() - preDeliveryAmount); 
                 total = parseFloat(total+(calShipCost)).toFixed(2);
            }
            
            total = parseFloat(total).toFixed(2);
            shipping_charges = parseFloat(shipping_charges).toFixed(2);
            document.getElementById('chk_final_shipping_charges').innerHTML = '<?=$this->config->item('currency');?>'+document.getElementById('shipcharges_'+locationid).innerHTML;
            
            $('#existing_cart_amount').val(total);
            $('#total_amount').html(total);
            $('#final_total_price').html(total);
            $('#final_shipping_charges').val(shipping_charges);
        }
        else{
            var applyshipping_charges = $('#final_shipping_charges').val();
            if ($("#shipping_wallet").is(":checked")) {
                var total = parseFloat($('#remaing_cart_amount').val());

                if(coupan_amount_use>0)
                {
                    total = total-coupan_amount_use;
                }
            }
            else{
                //var total = parseFloat($('#existing_cart_amount').val());
              if(!isCouponUsed && coupan_amount_use > 0) {
                var total = parseFloat($('#existing_cart_amount').val() - preDeliveryAmount - coupan_amount_use); 
                isCouponUsed = true;
              } else {
                var total = parseFloat($('#existing_cart_amount').val() - preDeliveryAmount); 
              }
            }
            
            total = parseFloat(total).toFixed(2);
            
            $('#existing_cart_amount').val(total);
            $('#total_amount').html(total);
            $('#final_total_price').html(total);
            $('#final_shipping_charges').val(0);
            document.getElementById('chk_final_shipping_charges').innerHTML ='<span class="text-primary">FREE</span>';
        }   
    })
</script>