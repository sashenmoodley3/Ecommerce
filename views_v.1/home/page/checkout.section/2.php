<div class="col-main col-sm-8 col-xs-12">
    <div class="checkout-page">
        <h4 class="checkout-sep"><?=$this->lang->line("Delivery Information")?></h4>
        <button id="address_form_btn" data-event="click" data-target="#address_form" class="button"> <i class="fa fa-plus"></i>&nbsp; <span><?=$this->lang->line("Delivery Address")?></span></button>
        <hr style="    margin: 14px 0px;">
        <div class="box-border">
                <div class="row">
                    <?php 
                        echo form_error('_order_limitation_validation'); 
                        if(!empty(form_error('shipping_address'))){ ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Wrong!</strong> 
                                    <?php 
                                        echo form_error('shipping_address'); 
                                        //echo $this->session->flashdata('place_order_detalis');
                                    ?>
                            </div>
                        <?php }
						
						if(!empty($this->session->flashdata('shipping_address'))){ ?>
                            
							<?php 
								echo $this->session->flashdata('shipping_address');
							?>
                               
                        <?php }
                    ?>
                    <div class="col-sm-12">
                        <label><?=$this->lang->line("Shipping Address")?> <span class="separator">|</span> <a href="#"><?=$this->lang->line("Change")?></a> </label>
                    </div>
                    <?php
                    if (is_array($getLoginUserAddresses)):
                        //var_dump($getLoginUserAddresses);
                        foreach ($getLoginUserAddresses as $key => $value) :
                            $location_id = $value->location_id;
                            $house_no = $value->house_no;
                            $receiver_name = $value->receiver_name;
                            $receiver_mobile = $value->receiver_mobile;
                            $delivery_charge = $value->delivery_charge;
                            $free_delivery_amount = $value->free_delivery_amount;
                            $pincode         = $value->pincode;
                            $default_address         = $value->default_address;
                            ?>
                            <div class="col-sm-6 delivery-address">
                                <div class="addresss">
                                    <dt class="complete"> </dt>
                                    <div class="complete col-sm-2" style="padding: 0px 5px;">
                                        <label for="reg_private_policy" style="font-weight: 500;">
                                            <input type="radio" <?php echo !empty($default_address)? 'checked' : ''; ?> class="form-control shipping_address" required name="shipping_address" value="<?= $location_id ?>" style="width: auto; float: left; margin-right: 10px; margin: 0px 7px 0px 0px; background: transparent; display: inherit; box-shadow: none;">
                                            <input type="hidden" name="free_delivery_amount" id="free_delivery_amount<?= $location_id ?>" value="<?=$free_delivery_amount;?>">
                                        </label>
                                    </div>
                                    <div class="col-sm-10" style="padding: 0px;">
                                        <i class="primary"></i>
                                        <address id="shipping_address_<?= $location_id ?>">
                                            <?=$this->lang->line("Name")?> : <span><?= $receiver_name ?></span><br>
                                            <?=$this->lang->line("Address")?> : <span><?= $house_no ?></span><br>
                                            <?=$this->lang->line("Mobile No.")?> : <span><?= $receiver_mobile ?></span><br/>
                                            <?=$this->lang->line("Pincode")?> : <span><?= $pincode ?></span><br/>
                                            
                                            <?=$this->lang->line("Delivery Charges")?> : <span><?=$this->config->item('currency') ?> <span id="shipcharges_<?= $location_id ?>"><?= $delivery_charge ?></span></span> <br>
        
                                        </address>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endforeach;
                    endif;
                    ?>
			<?php
				$delivery_date = '';
				if(!empty($this->config->item("delivery_date_after_days"))){
					$delivery_date_after_days = $this->config->item("delivery_date_after_days");
					$delivery_date = date('d-m-Y', strtotime('+'.$delivery_date_after_days.' days'));
				}
            
            ?>
                </div>
                <?php if($this->config->item('time_slot') == 1){ ?>
                <div class="row">
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
                <?php } 
                else{ ?>
                    <input type="hidden" id="shipping_date" name="shipping_date" required="" class="input form-control valid"  aria-required="true" aria-invalid="false" readonly="" value="<?=date('d-m-Y')?>" >
                    <input type="hidden" id="shipping_time_from" name="shipping_time_from" required="" class="input form-control valid"  aria-required="true" aria-invalid="false" readonly=""  value="<?=date('H:i').'-'.date('H:i')?>">
                <?php }?>
                
                <div class="row">
                    <div class="col-sm-12">
                        <dl>
                            <dt class="complete"><label><?=$this->lang->line("Payment Information")?></label></dt>
                            <dd>
                                <ul>
                                    <?php if($this->config->item('cod_status')== 1){ ?>
                                    <li class="cc-selector col-sm-3">        
                                        <input type="radio" required name="payment_type" value="Cash On Delivery" id="radio_button_5">
                                        <label class="drinkcard-cc" style="margin-bottom:0px; width:100%; overflow:hidden; " for="mastercard" onclick="radio_check('radio_button_5')">
                                            <img src="<?=base_url()?>assets/images/cash.jpg" width="100%" height="100%" style=" text-align-last:center;" alt="Cash On Delivery">
                    
                                        </label>
                                    </li>
                                    <?php } ?>
                                    <?php if(!empty($this->config->item('marchecnt_id')) && $this->config->item('razor_status')==1){ ?>
                                    <li class="cc-selector col-sm-3">        
                                        <input type="radio" required name="payment_type" value="Razorpay" id="radio_button_6">
                                        <label class="drinkcard-cc" style="margin-bottom:0px; width:100%; overflow:hidden; " for="mastercard" onclick="radio_check('radio_button_6')">
                                            <img src="<?=base_url()?>assets/images/razorpay1.png" width="100%" height="100%" style=" text-align-last:center;" alt="Razorpay">
                    
                                        </label>
                                    </li>
                                    <?php } ?>
                                    <?php if(!empty($this->config->item('paypal_id')) && $this->config->item('paypal_status')==1){ ?>
                                    <li class="cc-selector col-sm-3">        
                                        <input type="radio" required name="payment_type" value="Paypal" id="radio_button_7">
                                        <label class="drinkcard-cc" style="margin-bottom:0px; width:100%; overflow:hidden; " for="mastercard" onclick="radio_check('radio_button_7')">
                                            <img src="<?=base_url()?>assets/images/paypal.jpg" width="100%" height="100%" style=" text-align-last:center;" alt="Razorpay">
                    
                                        </label>
                                    </li>
                                    <?php } ?>
                                 <?php if(!empty($this->config->item('paytm_id')) && $this->config->item('paytm_status')==1){ ?>
                                    <li class="cc-selector col-sm-3">        
                                        <input type="radio" required name="payment_type" value="Paytm" id="radio_button_8">
                                        <label class="drinkcard-cc" style="margin-bottom:0px; width:100%; overflow:hidden; " for="mastercard" onclick="radio_check('radio_button_8')">
                                            <img src="<?=base_url()?>assets/images/paytm.png" width="100%" height="100%" style=" text-align-last:center;" alt="Paytm">
                    
                                        </label>
                                    </li>
                                <?php } ?>
                                </ul>
                            </dd>
                        </dl>
                    </div>
                </div>
        </div>
    </div>
</div>
<div class="col-md-4 cart-summeries">
  <div class="card">
     <h5 class="card-header"><?=$this->lang->line("Shopping Cart Summary")?> <span class="text-secondary float-right">(<?=count($get_cart_product_arr)?> item)</span></h5>
     <div class="card-body pt-0 pr-0 pl-0 pb-0">
         <?php
            if(is_array($getLoginUserAddresses)){
                        //var_dump($getLoginUserAddresses);
                foreach ($getLoginUserAddresses as $key => $value) {
                    if($value->default_address==1)
                    {
                        $location_id = $value->location_id;
                        $house_no = $value->house_no;
                        $receiver_name = $value->receiver_name;
                        $receiver_mobile = $value->receiver_mobile;
                        $delivery_charge = $value->delivery_charge;
                        $free_delivery_amount = $value->free_delivery_amount;
                        $pincode         = $value->pincode;
                        $default_address         = $value->default_address;
                    }
                }
            }
    
            $total_order_price = 0;
            foreach ($get_cart_product_arr as $key => $product){
                $qty                    = $product['buy_qty'];
                $product_id             = $product['product_id'];
                $product_varient_id     = $product['varient_id'];
                $product_name           = $product['product_name'];
                $product_description    = $product['product_description'];
                 
                
                $pro1                   = explode(',',$product['product_image']);
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
                if(!empty($q_variants->pro_var_images)){
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
        		
        		if(!empty($del_price)){
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
                $productUrl             =   $this->config->item('base_url')."product/". $product_slug;
        ?>
        <input type="hidden" name="product_qty" id="product_qty_<?=$product_varient_id?>" value="<?=$qty?>">
        <input type="hidden" name="product_id" id="product_id1_<?=$product_varient_id?>" value="<?=$product_id?>">
        <input type="hidden" name="product_varient_id" id="product_varient_id1_<?=$product_varient_id?>" value="<?=$varientid?>">
        <input type="hidden" name="price" id="price1_<?=$product_varient_id?>" value="<?=$single_price?>" class="priceee">
        <input type="hidden" name="unit" id="unit1_<?=$product_varient_id?>" value="<?=$unit?>" class="units">
        <input type="hidden" name="unit_value" id="unit_value1_<?=$product_varient_id?>" value="<?=$unit_value?>" class="unit_value">
        <input type="hidden" name="total_product_price" id="total_product_price_<?=$product_varient_id?>" value="<?=$total_product_price?>" class="total_product_price">
        <input type="hidden" name="difference_price" id="difference_price_<?=$product_varient_id?>" value="<?=$difference_price?>" class="difference_price">
        <div class="cart-list-product">
           <!--<a class="float-right remove-cart" data-id="<?=$product_id?>" data-varient="<?=$product_varient_id?>" title="Remove This Item"><i class="icon-close"></i></a>-->
           <img class="img-fluid" src="<?= $product_image ?>" alt="<?= $product_name ?>">
           <?=!empty($difference_price) ? '<span class="badges badges-success">'.$this->config->item('currency').$difference_price*$qty.'</span>' : ''?>
           <h5><a href="<?=$productUrl?>" title="<?= $product_name ?>"><?= $product_name ?></a></h5>
           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - <?= $qty_in_kg.' '.$unit_in_kg ?></h6>
           <p class="offer-price mb-0"><?=$this->config->item('currency') ?><?= $product_price ?> <?= $product_price < $mrp ? '<i class="mdi mdi-tag-outline"></i> <span class="regular-price">'.$this->config->item('currency').$mrp.'</span>' : ''?></p>
        </div>
        
        <?php } ?>
        <input type="hidden" name="total" id="total" value="<?=$total_order_price?>" class="total">
        <input type="hidden" name="saveprice" id="saveprice" value="<?=$saveprice?>" class="saveprice">
     </div>
  </div>
  <?php
        				
    if(!empty($del_price))
    {
        $product_price = $del_price->deal_price;
        $total_product_price = $del_price->deal_price * $qty;
        $existing_wallet_amount = $getWalletOnCheckout['existing_wallet_amount'];
        $remaing_wallet_amount = $getWalletOnCheckout['remaing_wallet_amount'];
        $used_wallet_amount = $getWalletOnCheckout['used_wallet_amount'];
       //$existing_cart_amount = $total_product_price;
         //$existing_cart_amount = $total_order_price;
         //echo "enter";
        if($delivery_charge > 0 &&  $total_order_price<$free_delivery_amount){
            $existing_cart_amount  = $total_order_price+$delivery_charge;
            $total_order_price  = $total_order_price+$delivery_charge;
            $shipping_charges = $delivery_charge;
        }
        else
        {
            $existing_cart_amount = $total_order_price;
            $shipping_charges = "0.00";
        }
         
        $remaing_cart_amount = $total_product_price-$used_wallet_amount;
    }else 
     {
         
         
         
         $existing_wallet_amount = $getWalletOnCheckout['existing_wallet_amount'];
         $remaing_wallet_amount = $getWalletOnCheckout['remaing_wallet_amount'];
         $used_wallet_amount = $getWalletOnCheckout['used_wallet_amount'];
         //$existing_cart_amount = $getWalletOnCheckout['existing_cart_amount'];
         //$remaing_cart_amount = $getWalletOnCheckout['remaing_cart_amount'];
         
        // echo $delivery_charge."-".$total_order_price."-".$free_delivery_amount;
         
        if($delivery_charge > 0 &&  $total_order_price<$free_delivery_amount){
//            $existing_cart_amount  = $total_order_price+$delivery_charge;
            $existing_cart_amount  = $total_order_price;
            $total_order_price  = $total_order_price+$delivery_charge;
            //$remaing_cart_amount = $getWalletOnCheckout['remaing_cart_amount']+$delivery_charge;
            $remaing_cart_amount = $getWalletOnCheckout['remaing_cart_amount'];
            $shipping_charges = $delivery_charge;
        }
        else
        {
            $existing_cart_amount = $total_order_price;
            $remaing_cart_amount = $getWalletOnCheckout['remaing_cart_amount'];
            $shipping_charges = 0;
        }
         
         
        //  echo "ddasd".$existing_wallet_amount."--111--".$remaing_wallet_amount."--222--".$used_wallet_amount."--333--".$existing_cart_amount."---444--".$remaing_cart_amount; die;
    }
    ?>
  
  
  <div class="well well-wallet" >
      <h4>Wallet Allow</h4>
      <div>
          <table width="100%">
              <tr>
                <td class="wallet-check">
                    <input type="checkbox" id="shipping_wallet" class="form-control wallet" name="shipping_wallet_allow" data-existing-cart-amount ="<?= $existing_cart_amount ?>" data-remaing-cart-amount ="<?= $remaing_cart_amount ?>"
                               data-used-wallet-amount ="<?= $used_wallet_amount ?>" value="<?= $used_wallet_amount ?>" style="width: auto; float: left; margin: 5px 5px 5px 0px; height: 15px;" aria-required="true">
                    <span style="font-size:11px;"><?=$this->lang->line("Wallet Amount")?>: <?=$this->config->item('currency') ?> <?= $existing_wallet_amount ?></span>
                    <span class="view_wallet_info" style="display:none;font-size:11px;"><br/><?=$this->lang->line("Remaing Wallet")?> : <?=$this->config->item('currency') ?> <?= $remaing_wallet_amount ?></span>
                    <input type="hidden" name="existing_wallet_amount" value="<?= $existing_wallet_amount ?>"/>
                    <input type="hidden" id="final_shipping_charges" value="<?= $shipping_charges ?>"/>
                    <input type="hidden" name="remaing_wallet_amount" value="<?= $remaing_wallet_amount ?>"/>
                    <input type="hidden" name="used_wallet_amount" id="used_wallet_amount" value="<?= $used_wallet_amount ?>"/>
                    <input type="hidden" id="existing_cart_amount" name="existing_cart_amount" value="<?= $existing_cart_amount ?>"/>
                    <input type="hidden" name="remaing_cart_amount" id="remaing_cart_amount" value="<?= $remaing_cart_amount ?>"/>
                    <input type="hidden" id="coupan_amount_use" name="coupan_amount_use" value="0"/>
                </td>
                <td class="price"><strong><?=$this->config->item('currency') ?> (<?= $used_wallet_amount ?>) </strong></td>
                
            </tr>
            <tr>
                
                <td class="wallet-check"><strong><?=$this->lang->line("Total")?></strong></td>
                <td class="price"><strong><?=$this->config->item('currency') ?> <span id="total_amount" class="existing_cart_amount"><?= number_format((float)($total_order_price), 2, '.', '') ?></span></strong></td>
            </tr>
          </table>
      </div>
  </div>
  
  
</div>
<script>
    $(document).on('change','.shipping_address', function(){
        
        var locationid          =   $(this).val();
        //var total               =   parseFloat($('#total').val());
        var used_wallet_amount               =   parseFloat($('#used_wallet_amount').val());
        var order_total               =   parseFloat($('#existing_cart_amount').val());
        
        var free_delivery_amount               =   parseFloat($('#free_delivery_amount'+locationid).val());
        
        var coupan_amount_use               =   parseFloat($('#coupan_amount_use').val());
//        if(used_wallet_amount>0)
//        {
//            order_total = order_total + used_wallet_amount;
//        }
        
        //total = total-coupan_amount_use;
        var shipping_charges    =   parseFloat($('#shipcharges_'+locationid).html());
        console.log(shipping_charges); 
        
        console.log("out-total-amount="+order_total+"-free_delivery_amount="+free_delivery_amount);
        
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
                var total               =   parseFloat($('#existing_cart_amount').val());
                //total               =   total + used_wallet_amount;
                
                
            }
            
            if(shipping_charges>0)
            {
                 total = parseFloat(total+shipping_charges).toFixed(2);
            }
            
            total = parseFloat(total).toFixed(2);
            document.getElementById('chk_final_shipping_charges').innerHTML = '<?=$this->config->item('currency');?>'+document.getElementById('shipcharges_'+locationid).innerHTML;
            
            
            
            
            //total               =   (parseFloat(total) + parseFloat(shipping_charges));
            
            //$('#existing_cart_amount').val(total);
            $('#total_amount').html(total);
            $('#final_total_price').html(total);
            $('#final_shipping_charges').val(shipping_charges);
            console.log("in-total-amount="+total+"-shipping_charges="+shipping_charges);
        }
        else{
            var applyshipping_charges = $('#final_shipping_charges').val();
            if ($("#shipping_wallet").is(":checked")) {
                var total               =   parseFloat($('#remaing_cart_amount').val());
//                if(applyshipping_charges>0)
//                {
//                    total = total-applyshipping_charges;
                
//                }
                if(coupan_amount_use>0)
                {
                    total = total-coupan_amount_use;
                }

//                if(applyshipping_charges>0)
//                {
//                    total = total-applyshipping_charges;
//                }
                
            }
            else{
                var total               =   parseFloat($('#existing_cart_amount').val());
                //total               =   total + used_wallet_amount;
            }
            console.log("entr="+shipping_charges);
            
            total = parseFloat(total).toFixed(2);
            
            $('#total_amount').html(total);
            $('#final_total_price').html(total);
            $('#final_shipping_charges').val(0);
            document.getElementById('chk_final_shipping_charges').innerHTML ='<span class="text-primary">FREE</span>';
        }
        
    })
</script>

